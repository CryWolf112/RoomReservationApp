<?php
  $current_page = basename($_SERVER['REQUEST_URI']);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
    <header>
        @if (Auth::check())
        <nav class="navbar navbar-expand-lg navbar-dark p-3">
          <div class="container-fluid">
            <a class="navbar-brand">RoomReservationApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav d-flex">
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == 'home') echo 'active'?>" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == 'news') echo 'active'?>" aria-current="page" href="/news">News</a>
                </li>
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == 'contact') echo 'active'?>" aria-current="page" href="/contact">Contact</a>
                </li>
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == 'about') echo 'active'?>" aria-current="page" href="/about">About Us</a>
                </li>
              </ul>
              <ul class="navbar-nav d-flex ms-auto">
                <li class="nav-item text-light my-auto me-1">
                  Hello, {{ Auth::user()->username }}!
                </li>
                <li class="nav-item dropdown">
                  <a class="dropdown-toggle nav-link" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ !empty(Auth::user()->profile_image) ? asset('storage/img/profile/'.Auth::user()->profile_image): asset('storage/img/other/person-circle.svg') }}"
                    width="32" height="32" draggable="false" class="rounded-circle" alt="Responsive image">
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="/home/profile">My Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        @else
        <nav class="navbar navbar-expand-lg navbar-dark p-3">
          <div class="container-fluid">
            <a class="navbar-brand">RoomReservationApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == '') echo 'active'?>" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == 'news') echo 'active'?>" aria-current="page" href="/news">News</a>
                </li>
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == 'contact') echo 'active'?>" aria-current="page" href="/contact">Contact</a>
                </li>
                <li class="nav-item px-3">
                  <a class="nav-link button p-2 <?php if($current_page == 'about') echo 'active'?>" aria-current="page" href="/about">About Us</a>
                </li>
              </ul>
              <ul class="navbar-nav d-flex ms-auto">
                <li class="nav-item">
                  <a class="nav-link button p-2 <?php if($current_page == 'login') echo 'active'?>" aria-current="page" href="/login">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link button p-2 <?php if($current_page == 'register') echo 'active'?>" aria-current="page" href="/register">Register</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        @endif
      </header>
      <main>
        <div class="container pt-3 text-center">
          @yield('content')
        </div>
      </main>
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-4">
        <div class="col-md-4 d-flex align-items-center">
          <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
            <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
          </a>
          <span class="mb-3 mb-md-0 text-muted">© 2022 Company, Inc</span>
        </div>
      </footer>

      <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>