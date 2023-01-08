@extends("layouts.layout")

@section("content")

<div class="card mx-auto mt-3" style="width: 36rem;">
    <div class="card-body text-center text-light">
        <h4>We sent you email to {{ $email }}</h4>
        <h6>Please, check your email inbox</h6>
    </div>
</div>
@stop