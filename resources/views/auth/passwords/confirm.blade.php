@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'user'])

    <div style="background-color:#dee8f1; padding-bottom:40px;"> 
    <div class="registercontainer">   
        <div class="cart-container">
            <p class="loginlogo"><a href="{{ route('home') }}"><img src="{{ asset('images/clew-logo.png') }}"/></a></p>
            <div class="signhd">{{ __('Confirm Password') }}</div>
            <div class="loginform white">
            
                <form method="POST" action="{{ route('password.confirm') }}">
                    <p class="tc hsi">{{ __('Please confirm your password before continuing.') }}</p>
                    @csrf
                    <div class="frows">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password:*" autocomplete="current-password">
                        <span>@error('password'){{ $message }}@enderror</span>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="fyp tc">
                            <a title="Forgot your password?" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                    
                    <div class="button mt20px">
                        <button type="submit" class="bluebtn btnCenter">
                            {{ __('Confirm Password') }}
                        </button>
                    </div>     
                </form>
            </div>
        </div>
        <div class="tc ncl">New to <b>CLEW?</b> <a href="{{ route('register')}}">signup</a></div>
    </div>
    </div>
    @include('layouts.parts.footer')
@endsection
