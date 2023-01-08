@extends('layouts.layout')

@section('content')

            <form action="validate" method="POST" class="my-5" onsubmit="validateRegistration(event)">
                @csrf

                @include('layouts.info')

                <div class="card mx-auto" style="width: 36rem;">
                    <div class="card-header">
                      <h3>Register</h3>
                    </div>
                    <div class="card-body col mx-auto text-start">

                    <div class="d-flex gap-5">
                        <div class="mb-3 col">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" maxlength="32" aria-describedby="firstName" pattern="^[A-Za-z]*$" title="First name must contains letter only">
                        </div>
                        <div class="mb-3 col">
                            <label for="lastName" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" maxlength="32" aria-describedby="lastName" pattern="^[A-Za-z]*$" title="Last name must contains letter only">
                        </div>
                    </div>

                    <div class="d-flex gap-5 justify-content-between">
                        <div class="mb-3 col">
                            <label for="birthDate" class="form-label">Date of birth</label>
                            <input type="date" class="form-control" id="birthDate" name="birth_date" min='1899-01-01' max='2000-13-13' aria-describedby="birthDate">
                        </div>
                        <div class="mb-3 col">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" aria-describedby="gender">
                                <option disabled selected hidden>Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select" id="country" name="country" aria-describedby="country">
                            <option disabled selected hidden>Select country</option>
                            @php
                                foreach ($countries as $country) {
                                    echo '<option value="'.$country->id.'">'.$country->name.'</option>';
                                }
                            @endphp
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="username" minlength="6" maxlength="16" pattern="^[A-Za-z0-9]*$" title="Username must contain letters and/or digits only" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8" maxlength="16" aria-describedby="password" onchange="validatePassword()" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).*$" title="Password must contain at least one uppercase, at least one sign and at least one number" required>
                    </div>

                    <div class="mb-3">
                        <label for="repeat" class="form-label">Repeat password</label>
                        <input type="password" class="form-control" id="repeat" name="password_confirmation" aria-describedby="repeat" onkeyup="validatePassword()" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role_id" aria-describedby="role" required>
                            <option value="" disabled selected hidden>Select role</option>
                            <option value="1">I want to rent rooms</option>
                            <option value="2">I want to be renter</option>
                        </select>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="policy" name="policy" required>
                        <label class="form-check-label" for="policy">
                            I accept application policy
                        </label>
                    </div>
                    
                    <div class="mb-1 mt-3 g-recaptcha" id="captcha" name="captcha" data-callback="validateRecaptcha" data-sitekey="6Le14SYgAAAAAMLIxIQp2K_YEWReLVRfMvRHvS_i"></div>
                    <div class="mb-3" id="captchaError" style="color:red"></div>

                    <button type="submit" id="btnRegister" class="btn btn-outline-primary w-100">Register</button>
                    </div>
                </div>
            </form>
    @stop