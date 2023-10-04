<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Admin Login Page">
        <meta name="author" content="Gibran">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> Admin Dashboard </title>

        <!-- Custom fonts for this template-->
  
        <link href="https://fonts.googleapis.com/css?family=Encode+Sans+Semi+Condensed:100,200,300,400" rel="stylesheet">

        
        <!-- Cusom css -->
        <link rel="stylesheet" href="{{ asset('backend/css/login-error.css') }}">

    </head>
    <body class="loading">
        <h1>Hello {{ auth()->guard('admin')->check()? auth()->guard('admin')->user()->name : auth()->user()->name}} ,</h1>
        <h2>You must <a href="{{ auth()->guard('admin')->check()? route('admin.logout') : route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a> First </h2>
        <form id="logout-form" action="{{ auth()->guard('admin')->check()? route('admin.logout') : route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <h2>Our go back to <a href="{{ route('home') }}"> Home Page</a> </h2>
        <div class="gears">
          <div class="gear one">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
          </div>
          <div class="gear two">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
          </div>
          <div class="gear three">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
          </div>
        </div>
        <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{ asset('backend/js/login-error.js') }}"></script>
      </body>
</html>
