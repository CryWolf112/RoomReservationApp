@extends('layouts.layout')

@section('content')

<div class="card mx-auto mt-3" style="width: 36rem;">
    <div class="card-body text-center text-light">
        <h4>{{ $msg }}</h4>
        @if (!Auth::check())
            <h6>Please, click <a href="/">here</a> to log in</h6>
         @endif
    </div>
</div>

@stop