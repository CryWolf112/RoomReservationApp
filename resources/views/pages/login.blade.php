@extends('layouts.layout')

@section('content')

            <form action ="authenticate" class="mt-5" method="POST">
              @csrf

              @include('layouts.info')

              <div class="card mx-auto" style="width: 18rem;">
                <div class="card-header">
                  <h3>Log In</h3>
                </div>
                <div class="card-body">
              <div class="d-flex flex-column justify-content-end text-start">
              <div class="mb-3">
                <label for="input" class="form-label">Username or email</label>
                <input type="text" name="input" class="form-control" id="input" required>
              </div>
              <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword" required>
              </div>
              
              <a href="/forgotPassword" class="mb-3 mt-1">Forgot password?</a>

              <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="checkboxRemember">
                <label class="form-check-label" for="checkboxRemember">Remember me</label>
              </div>
              <button type="submit" class="btn btn-outline-primary">Login</button>
            </div>
                </div>
                </div>
            </form>
        
    @stop