@extends('layouts.layout')

@section('content')

<form action="validateMailChange" method="POST">
    @csrf

    @include('layouts.info')

    <div class="card mx-auto" style="width: 24rem">
        <div class="card-header mt-2 mb-2 text-center">
            <h3>Change email address</h3>
        </div>
        <div class="card-body">
            <div class="d-flex flex-column justify-content-end text-start">
                <div class="mb-3">
                    <label for="email" class="form-label">New email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <button type="submit" id="btnConfirm" class="btn btn-outline-primary">Confirm</button>
            </div>
        </div>
    </div>
</form>

@stop