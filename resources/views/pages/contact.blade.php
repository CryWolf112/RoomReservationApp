@extends('layouts.layout')

@section('content')

@include('layouts.info')

<h1 class="text-start gradient-title">Contact Us</h1>
<div class="card my-3">
  <div class="row p-3">
    <div class="col-md-6 mx-auto">
        <div style="width: 100%"><iframe width="100%" height="570" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.maps.ie/distance-area-calculator.html">measure distance on map</a></iframe></div>
    </div>

    <div class="col-md-6">
      <div class="card-body text-start">
        <h5 class="card-title text-start">Send us a message</h5>

        <form action="sendQuery" method="POST" enctype="multipart/form-data">

        @csrf

        @if (!Auth::check())
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
        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" id="country" name="country_id" aria-describedby="country">
                <option disabled selected hidden>Select country</option>
                @php
                    foreach ($countries as $country) {
                        echo '<option value="'.$country->id.'">'.$country->name.'</option>';
                    }
                @endphp
            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        @endif

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>

        <div class="mb-3">
            <label for="msg" class="form-label">Message</label>
            <textarea class="form-control" id="msg" name="message" required></textarea>
        </div>

        <button type="submit" class="btn btn-outline-primary" style="min-width: 124px">Send</button>

        </form>
      </div>
    </div>
  </div>
</div>

@stop