@php $website = \App\Models\Website::find(1); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="fullscreen-bg">
<head>
    <title>Admin</title>
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" app-url="{{ url('/') }}">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">
	<script src="{{ asset('assets/vendor/ckeditor4/ckeditor.js') }}"></script>
	<!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main.css') }}">
	<!-- ICONS -->
    <link rel="shortcut icon" href="{{asset('storage/website')}}/{{$website->favicon}}" />
	@stack('after-style')
</head>
<body>
	<!-- WRAPPER -->
	<div id="wrapper">
        @yield('content')
    </div>
    <!-- Javascript -->
	<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/datepicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootbox/bootbox.js') }}"></script>
	<script src="{{ asset('assets/admin/scripts/layout-common.js') }}"></script>
	@if(session('error'))<script>notify('error', '{{ session('error') }}');</script>@endif
	@if(session('success'))<script>notify('success', '{{ session('success') }}');</script>@endif
	<script src="{{ asset('assets/admin/scripts/back-custom.js') }}"></script>
	@stack('after-scripts')
</body>
</html>
