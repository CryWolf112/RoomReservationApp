<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Query;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }


    public function news()
    {
        $news = News::all()->sortByDesc('updated_at');
        return view('pages.news')->with('news', $news);
    }

    public function newsUpdate(Request $request)
    {
        try {
            $rules = [
                'news_item.*.title' => 'string|max:255|required',
                'news_item.*.image' => 'max:1024000|mimes:jpg,jpeg,png,svg|nullable',
                'news_item.*.content' => 'string|max:65535|required'
            ];

            $message = 'News update failed. Please, try again.';
            $validator = Validator::make($request->all(), $rules, [
                'news_item.*.title' => $message,
                'news_item.*.image' => $message,
                'news_item.*.content' => $message
            ]);

            if (!$validator->fails()) {
                $all_ids = News::all('id');
                $removed_ids = $all_ids->pluck('id')->toArray();
                $news_data = head($request->all('news_item'));
                $is_updated = false;

                DB::beginTransaction();

                //update existing news and create new
                foreach ($news_data as $id => $news_item) {
                    if ($all_ids->contains($id)) {
                        $news = News::where('id', $id)->first();
                        $news->title = $news_item['title'];
                        $news->content = $news_item['content'];

                        if (array_key_exists('image', $news_item)) {
                            $filename = Str::random(60) . '.' . $news_item['image']->getClientOriginalExtension();

                            Storage::putFileAs(
                                'public/img/news/',
                                $news_item['image'],
                                $filename
                            );

                            Storage::delete('public/img/news/' . $news->news_image);

                            $news->news_image = $filename;
                        }

                        if ($news->isDirty()) {
                            $news->updated_at = Carbon::now('UTC');
                            $news->save();

                            $is_updated = true;
                        }

                        $removed_ids = array_diff($removed_ids, [$id]);
                    } else {
                        $news = new News();
                        $news->title = $news_item['title'];
                        $news->content = $news_item['content'];
                        $news->updated_at = Carbon::now('UTC');

                        if (array_key_exists('image', $news_item)) {
                            $filename = Str::random(60) . '.' . $news_item['image']->getClientOriginalExtension();

                            Storage::putFileAs(
                                'public/img/news/',
                                $news_item['image'],
                                $filename
                            );

                            $news->news_image = $filename;
                            $news->save();

                            $is_updated = true;
                        }
                    }
                }

                //remove deleted news
                if (count($removed_ids) > 0) {
                    News::whereIn('id', $removed_ids)->delete();

                    $is_updated = true;
                }

                DB::commit();

                if ($is_updated) {
                    return redirect('news')->with('info', 'News are updated succesfully.');
                } else {
                    return redirect('news');
                }
            } else {
                return back()->withErrors($validator);
            }
        } 
        catch (Exception $exception)
        {
            Log::critical('An error occured while sending query', [
                'exception_code' => $exception->getCode(),
                'exception_message' => $exception->getMessage()
            ]);

            DB::rollBack();
            abort($exception->getCode());
        }
    }

    public function contact()
    {
        $countries = DB::table('countries')->select(['id', 'name'])->get();
        return view('pages.contact')->with('countries', $countries);
    }

    public function sendQuery(Request $request)
    {
        try {
            if (Auth::check()) {
                $rules = [
                    'subject' => 'string|max:255|required',
                    'message' => 'string|max:65535|required'
                ];

                $data = array_merge($request->all(), [
                    'email' => Auth::user()->email,
                    'country_id' => Auth::user()->country_id,
                ]);
            } else {
                $rules = [
                    'first_name' => 'string|max:32|regex:/^[A-Za-z]*$/|nullable',
                    'last_name' => 'string|max:32|regex:/^[A-Za-z]*$/|nullable',
                    'country_id' => 'integer|exists:countries,id|nullable',
                    'email' => 'email|unique:users,email|required',
                    'subject' => 'string|max:255|required',
                    'message' => 'string|max:65535|required'
                ];

                $data = $request->all();
            }

            $validator = Validator::make($data, $rules);

            if (!$validator->fails()) {
                $query = new Query($data);
                $query->updated_at = Carbon::now('UTC');

                DB::beginTransaction();
                $query->save();

                DB::commit();

                return redirect('contact')->with('info', 'Message is sent successfully. We will contact you as soon as possible.');
            }

            return back()->withErrors($validator);
        } catch (Exception $exception) {
            Log::critical('An error occured while sending query', [
                'exception_code' => $exception->getCode(),
                'exception_message' => $exception->getMessage()
            ]);

            DB::rollBack();
            abort($exception->getCode());
        }
    }

    public function about()
    {
        return view('pages.about');
    }
}
