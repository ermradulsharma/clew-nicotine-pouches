@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'user'])
    <!-- <div class="homeSlider">
        <div><img src="{{ asset('images/login-banner.jpg') }}" class="w100"/></div>
    </div> -->

    @php $page = \Helper::page('login'); @endphp
    @section('title', $page->pageTitle)
    @section('pageDescription', $page->pageDescription)
    @section('pageKeywords', $page->pageKeywords)
    <div class="login-c-container" style="background-color:#dee8f1;">
        @if($page)
        <div class="login-slider">
            <img src="{{ asset('storage/page/'.$page->image) }}" class="w100 show-desktop"/>
        </div>
        @else
        <div class="login-slider">
           <!-- <img src="{{ asset('images/login-banner.jpg') }}" class="w100 shwoMobile"/> -->
            <img src="{{ asset('images/login-banner-mobile.jpg') }}" class="w100 show-desktop"/>
        </div>
        @endif

        <div class="cart-container">
            <div class="headingRow">Login</div>
         
            <div class="loginform white">
                <form id="loginForm" name="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="frows">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email:" value="{{ old('email') }}" autocomplete="email" autofocus />
                        <span>@error('email'){{ $message }}@enderror</span>
                    </div>
                    <div class="frows">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password:" autocomplete="current-password">
                        <div class="show-password" id="togglePassword">
                            <img src="{{asset('images/password-eye-icn.svg')}}" />
                        </div>
                        <span>@error('password'){{ $message }}@enderror</span>
                    </div>
                    <div class="rem-row">
                        <div class="rem-row-left"><input type="checkbox" id="rememberme"/> <label for="rememberme">Remember me</label></div>
                        @if (Route::has('password.request'))
                        <div class="fyp tc">
                            <a title="Forgot your password?" href="{{ route('forgotPassword') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    <div class="button mt20px">
                        <button type="submit" class="bluebtn btnCenter">
                            {{ __('Login') }}
                        </button>
                    </div>     
                </form>
            </div>
            <div class="tc ncl">New to <b>CLEW?</b><br/><a href="{{ route('register')}}">Sign up</a></div>    
        </div>
    </div>
    @include('layouts.parts.footer')
@endsection
