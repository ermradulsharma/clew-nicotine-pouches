@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'user'])

    <div style="background-color:#dee8f1; padding-bottom:40px;"> 
    <div class="registercontainer">     
        <div class="cart-container">
            <p class="loginlogo"><a href="{{ route('home') }}"><img src="{{ asset('images/clew-logo.png') }}"/></a></p>
            <div class="signhd">{{ __('Reset Password') }}</div>
            <div class="loginform white">
                <form method="POST" action="{{ route('forgotPassword') }}">
                    @csrf

                    @if(session('status'))
                        <p class="tc hsi">
                            {{ session('status') }}
                        </p>
                    @endif
                    <div class="frows">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email:*" value="{{ old('email') }}" autocomplete="email" autofocus />
                        <span>@error('email'){{ $message }}@enderror</span>
                    </div>
                    
                    <div class="button mt20px">
                        <button type="submit" class="bluebtn btnCenter">
                            {{ __('Send Password Reset Link') }}
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
