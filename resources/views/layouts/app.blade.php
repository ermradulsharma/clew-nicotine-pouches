<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" app-url="{{ url('/') }}" current-url="{{ url()->current() }}">
        @php $website = \App\Models\Website::find(1); @endphp
        <title>@yield('title', $website->pageTitle)</title>
        <meta name="description" content="@yield('pageDescription',$website->pageDescription)">
        <meta name="keywords" content="@yield('pageKeywords',$website->pageKeywords)">
        <link rel="shortcut icon" href="{{ asset('images/clew-favicon.ico') }}" type="image/x-icon">
        <!-- [Style] -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="stylesheet" href="{{ asset('css/hdp-styles.css') }}">
        <link rel="stylesheet" href="{{ asset('css/slick.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="{{ asset('authorize/card-js.min.css') }}" rel="stylesheet" type="text/css" />
        @stack('after-style')
    </head>
    <body>
        @yield('content')
    </body>
    <!-- [Scripts] -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    @stack('google-maps-scripts')
	<script src="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/video.js') }}"></script>
    <script src="{{ asset('authorize/card-js.min.js') }}"></script>
    <!-- [/Scripts] -->
    @stack('after-scripts')
</html>
