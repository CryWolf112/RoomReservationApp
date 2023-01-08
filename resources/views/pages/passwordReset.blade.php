@extends('layouts.layout')

@section('content')

        <form action="validateNewPassword" method="POST">
    @csrf

    @include('layouts.info')

    <div class="card mx-auto" style="width: 24rem">
        <div class="card-header mt-2 mb-2 text-center">
                <h3>New password</h3>
        </div>
            <div class="card-body">
                <div class="d-flex flex-column justify-content-end text-start">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" aria-describedby="password" onchange="validatePassword()" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).*$" title="- min. 8 characters - at least one uppercase&#010- at least one sign&#013- at least one number&#013- max. 16 characters" required>
                </div>

                <div class="mb-3">
                    <label for="repeat" class="form-label">Repeat password</label>
                    <input type="password" class="form-control" id="repeat" name="password_confirmation" aria-describedby="repeat" onkeyup="validatePassword()" required>
                </div>

                <button type="submit" id="btnSave" class="btn btn-outline-primary">Save</button>

            </div>
            </div>
        </div>
        </form>

@stop