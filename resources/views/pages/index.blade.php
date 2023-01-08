@extends('layouts.layout')

@section('content')
    <h1 class="text-center gradient-title">Welcome to Room Reservation Application</h1>

    <div class="row">
        <div class="card mt-3 mx-auto pt-3 col-4" style="width: 32rem;">
            <img src="{{ asset('storage/img/other/welcome-image.jpg') }}" draggable="false" class="card-img-top rounded-3" alt="...">
            <div class="card-body">
              <h5 class="card-title text-start">Choose form many institutions around world</h5>
              <p class="card-text text-start">Our application contains thousands of institutions form which you can pick suitable location</p>
            </div>
        </div>

          <div class="card mt-3 mx-auto col-8" style="width: 46rem;">
            <div class="card-body">
                <p class="card-text text-start">
                    Purpose of this aplication is to offer our users best possible service when it comes to finding best places for holding a meeting. You can choose form thousands of institutions including education buildings, offices, private buildings, and much more. As our client, you will get best possible insights about institution, rooms and equipment.
                </p>
                <p class="card-text text-start">
                    Our application offers you choice, wheather you want to be lesser or to rent rooms. As a renter you can add unlimited number of institutions form which other users will chose. To increase satisfactio of our users, every room has its own small gallery as well as specifications and description.
                </p>
                <p class="card-text text-start">
                    As a lessee you have wide choice of choosing betwen thousands of institutions and tens of thousands of rooms. Our advanced search methods and filters, as well as location binder helps you with searching process. However, if you ever run into problem or just want more information, feel free to contact us. Our support team is available 24 hours a day, 7 days in the week.
                </p>
            </div>
            <div class="card-footer d-flex">
                <a href="https://www.facebook.com/" class="px-3 py-2">
                    <img src="{{ asset('storage/img/other/facebook-icon.svg') }}" width="32" height="32" class="card-img-top rounded-3">
                </a>
                <a href="https://www.twitter.com/" class="px-3 py-2">
                    <img src="{{ asset('storage/img/other/twitter-icon.svg') }}" width="32" height="32" class="card-img-top rounded-3">
                </a>
                <a href="https://www.linkedin.com/" class="px-3 py-2">
                    <img src="{{ asset('storage/img/other/linkedin-icon.svg') }}" width="32" height="32" class="card-img-top rounded-3">
                </a>
            </div>
          </div>

    </div>
@stop