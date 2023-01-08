<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\sendMail;
use App\Models\EmailVerification;
use App\Models\PasswordReset;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Console\AboutCommand;

class UserController extends Controller
{
    public function login(){
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        if (filter_var($request->input, FILTER_VALIDATE_EMAIL)) {
            $pattern = 'email';
        } else {
            $pattern = 'username';
        }

        $remember = $request->remember == 'on' ? true : false;

        if (Auth::attempt([$pattern => $request->input, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            return redirect(RouteServiceProvider::HOME);
        }
        
        return back()->withErrors('Login failed');
    }

    public function register()
    {
        $countries = DB::table('countries')->select(['id', 'name'])->get();
        return view('pages.register')->with('countries', $countries);
    }

    public function validateRegistration(Request $request)
    {
        $rules = [
            'first_name' => 'string|max:32|regex:/^[A-Za-z]*$/|nullable',
            'last_name' => 'string|max:32|regex:/^[A-Za-z]*$/|nullable',
            'birth_date' => 'date|date-format:Y-m-d|before:' . Carbon::now()->toDateString() . '|after:1900-01-01|nullable',
            'gender' => 'string|in:male,female|nullable',
            'country_id' => 'integer|exists:countries,id|nullable',
            'username' => 'string|min:6|max:16|regex:/^[A-Za-z0-9]*$/|unique:users,username|required',
            'email' => 'email|unique:users,email|required',
            'password' => 'string|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).*$/|confirmed|required',
            'role_id' => 'integer|in:1,2|required',
            'policy' => 'accepted',
            'g-recaptcha-response' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, [
            'country.between' => 'The selected country is invalid',
            'g-recaptcha-response.required' => 'The google captcha validation is required'
        ]);

        if (!$validator->fails()) {

            $user_id = hash('sha256', $request->username);

            $user = new User($request->all());
            $user->id = $user_id;
            $user->password = Hash::make($request->password);
            $user->save();

            $user_role = new UserRole();
            $user_role->user_id = $user_id;
            $user_role->role_id = $request->role_id;
            $user_role->save();

            $subject = "Please, confirm your email";
            $token = hash('sha256', Str::random(60));
            $url = $_SERVER['SERVER_NAME'] . '/verifyEmail?email=' . $request->email . '&token=' . $token;
            $msg = "<p>Please confirm your account by <a href='" . $url . "'>clicking here</a></p>";

            self::sendMail($request->email, $subject, $msg);

            $email_verification = new EmailVerification();
            $email_verification->user_id = $user_id;
            $email_verification->email = $request->email;
            $email_verification->token = $token;
            $email_verification->created_at = Carbon::now('UTC');
            $email_verification->expires_at = Carbon::now('UTC')->addDay();
            $email_verification->save();

            return view('pages.mailSent', ['email' => $request->email]);
        } else {
            return redirect('register')->withErrors($validator);
        }
    }

    public function verifyEmail(Request $request)
    {
        $email_verification = EmailVerification::where('email', $request->email)->where('token', $request->token)->first();

        if (!empty($email_verification)) {
            if (Carbon::now('UTC')->lt($email_verification->expires_at)) {

                User::where('id', $email_verification->user_id)->update([
                    'email' => $email_verification->email,
                    'account_confirmed' => true
                ]);

                EmailVerification::where('user_id', $email_verification->user_id)
                    ->where('token', $email_verification->token)
                    ->update([
                        'email_verified' => true,
                        'expires_at' => Carbon::now('UTC')
                    ]);

                return view('pages.verify', ['msg' => 'Email verified succesfully!']);
            } else {
                return abort('419');
            }
        } else {
            return abort('404');
        }
    }

    public function forgotPassword()
    {
        return view("pages.forgotPassword");
    }

    public function validatePasswordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['email', 'required', Rule::exists('users', 'email')->where('account_confirmed', true)]
        ]);

        if (!$validator->fails()) {
            $token = hash('sha256', Str::random(60));

            $password_reset = new PasswordReset($request->all());
            $password_reset->token = $token;
            $password_reset->created_at = Carbon::now('UTC');
            $password_reset->expires_at = Carbon::now('UTC')->addDay();
            $password_reset->save();

            $url = $_SERVER['SERVER_NAME'] . '/resetPassword?email=' . $request->email . '&token=' . $token;
            $msg = "<p>Please confirm password reset by <a href='" . $url . "'>clicking here</a></p>";
            self::sendMail($request->email, "Password reset", $msg);

            return view("pages.mailSent", ['email' => $request->email]);
        }

        return back()->withErrors($validator);
    }

    public function resetPassword(Request $request)
    {
        $password_reset = PasswordReset::where('email', $request->email)->where('token', $request->token)->first();

        if (!empty($password_reset)) {
            if (Carbon::now()->lt($password_reset->expires_at)) {
                Session::put('reset_password_data', array(
                    [
                        'email' => $password_reset->email,
                        'token' => $password_reset->token
                    ]
                ));

                return view('pages.passwordReset');
            } else {
                return abort('419');
            }
        } else {
            return abort('404');
        }
    }

    public function validateNewPassword(Request $request)
    {
        $reset_password_data = Session::get('reset_password_data');

        if (empty($reset_password_data)) {
            return abort(419);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'string|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).*$/|confirmed|required'
        ]);

        if (!$validator->fails()) {
            User::where('email', $reset_password_data[0]['email'])->update(
                [
                    'password' => Hash::make($request->password)
                ]
            );

            PasswordReset::where('email', $reset_password_data[0]['email'])
                ->where('token', $reset_password_data[0]['token'])
                ->update(
                    [
                        'expires_at' => Carbon::now('UTC')
                    ]
                );
        } else {
            return back()->withErrors($validator);
        }

        return view('pages.verify', ['msg' => 'Password changed succesfully!']);
    }

    public function home()
    {
        return view('pages.home');
    }

    public function profile()
    {
        $countries = DB::table('countries')->select(['id', 'name'])->get();
        return view('pages.profile')->with('countries', $countries);
    }

    public function profileHandler(Request $request)
    {
        if ($request->profile_action == 'save') {
            $user = User::find(Auth::user()->id);

            $rules = [
                'first_name' => 'string|max:32|regex:/^[A-Za-z]*$/|nullable',
                'last_name' => 'string|max:32|regex:/^[A-Za-z]*$/|nullable',
                'birth_date' => 'date|date-format:Y-m-d|before:' . Carbon::now()->toDateString() . '|after:1900-01-01|nullable',
                'gender' => 'string|in:male,female|nullable',
                'country_id' => 'integer|exists:countries,id|nullable',
                'profile_image' => 'max:1024000|mimes:jpg,jpeg,png,svg|nullable'
            ];

            $validator = Validator::make($request->all(), $rules, [
                'profile_image.mimes' => 'Uploaded file type is not supported.',
                'profile_image.max' => 'Uploaded profile image must not be greater than 1 MB.'
            ]);

            if (!$validator->fails()) {

                if (!empty($request->profile_image)) {

                    $filename = Str::random(60) . '.' . $request->profile_image->getClientOriginalExtension();

                    Storage::putFileAs(
                        'public/img/profile/',
                        $request->profile_image,
                        $filename
                    );

                    if (!empty($user->profile_image)) {
                        Storage::delete('public/img/profile/' . $user->profile_image);
                    }

                    $user->profile_image = $filename;
                }

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->birth_date = $request->birth_date;
                $user->gender = $request->gender;
                $user->country_id = $request->country_id;

                if ($user->isDirty()) {
                    $user->save();

                    return redirect('home/profile')->with('info', 'Profile changes saved succesfully');
                } else {
                    return redirect('home/profile');
                }
            }

            return back()->withErrors($validator);
        } else if ($request->profile_action == 'delete'){
            $user = User::find(Auth::id());
            //$user->delete();

            Auth::logout();
            Session::flush();

            return redirect('')->with('info', 'Account deleted successfully!');
        }
    }

    public function changeEmail()
    {
        return view('pages.changeEmail');
    }

    public function validateMailChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:users|required'
        ]);

        if (!$validator->fails()) {
            $subject = "Please, confirm your email";
            $token = hash('sha256', Str::random(60));
            $url = $_SERVER['SERVER_NAME'] . '/verifyEmailChange?email=' . $request->email . '&token=' . $token;
            $msg = "<p>Please confirm your email change by <a href='" . $url . "'>clicking here</a></p>";

            self::sendMail($request->email, $subject, $msg);

            $email_verification = new EmailVerification();
            $email_verification->user_id = Auth::id();
            $email_verification->email = $request->email;
            $email_verification->token = $token;
            $email_verification->created_at = Carbon::now('UTC');
            $email_verification->expires_at = Carbon::now('UTC')->addDay();
            $email_verification->save();

            return view('pages.mailSent', ['email' => $request->email]);
        }

        return back()->withErrors($validator);
    }

    public function verifyEmailChange(Request $request)
    {
        $email_verification = EmailVerification::where('email', $request->email)->where('token', $request->token)->first();

        if (!empty($email_verification)) {
            if (Carbon::now('UTC')->lt($email_verification->expires_at)) {

                User::where('id', $email_verification->user_id)->update([
                    'email' => $email_verification->email,
                ]);

                EmailVerification::where('user_id', $email_verification->user_id)
                    ->where('token', $email_verification->token)
                    ->update([
                        'email_verified' => true,
                        'expires_at' => Carbon::now('UTC')
                    ]);

                return view('pages.verify', ['msg' => 'Email changed succesfully!']);
            } else {
                return abort('419');
            }
        } else {
            return abort('404');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect('');
    }

    private function sendMail($mail_to, $subject, $msg)
    {
        require '../vendor/autoload.php';

        $mail_from = env("SMTP_MAIL");

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = env("SMTP_MAIL_HOST");
        $mail->SMTPAuth = true;
        $mail->Username = $mail_from;
        $mail->Password = env("SMTP_MAIL_PASSWORD");
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($mail_from, 'RoomReservationApp');
        $mail->addAddress($mail_to);
        $mail->addReplyTo($mail_from, 'Information');

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send() ? true : false;

        $mail->clearAddresses();
        $mail->smtpClose();
    }
}
