<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Gibran">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet"> 

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/css/plugins.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

	<!-- Cusom css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

    @yield('style')

	<!-- Modernizer js -->
	<script src="{{ asset('frontend/js/vendor/modernizr-3.5.0.min.js') }}"></script>

</head>
<body>
    <!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->

	<!-- Main wrapper -->
	<div class="wrapper" id="wrapper">
        <div id="app">

            @include('frontend.partial.header')

            <main class="">
                <!-- لإظهار رسائل النجاح أو الفشل -->
                @include('flash.flash')

                @yield('content')
            </main>

            @include('frontend.partial.footer')

        </div>
    </div>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>

    <!-- JS Files -->
	<script src="{{ asset('frontend/js/vendor/jquery-3.2.1.min.js') }}"></script>
	{{-- <script src="js/popper.min.js"></script> --}}
	{{-- <script src="js/bootstrap.min.js"></script> --}}
	<script src="{{ asset('frontend/js/plugins.js') }}"></script>
	<script src="{{ asset('frontend/js/active.js') }}"></script>
	<script src="{{ asset('frontend/js/custom.js') }}"></script>

    @yield('script')

</body>
</html>
