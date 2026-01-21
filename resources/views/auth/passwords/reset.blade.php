@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'home'])

    <div style="background-color:#dee8f1; padding-bottom:40px;"> 
    <div class="registercontainer">
        <div class="cart-container">
            <p class="loginlogo"><a href="{{ route('home') }}"><img src="{{ asset('images/clew-logo.png') }}"/></a></p>
            <div class="signhd">{{ __('Reset Password') }}</div>
            <div class="loginform white">
                <form method="POST" action="{{ route('resetPassword') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="frows">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email:*" value="{{ old('email') }}" autocomplete="email" autofocus />
                        <span>@error('email'){{ $message }}@enderror</span>
                    </div>
                    <div class="frows">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password:*" autocomplete="current-password">
                        <span>@error('password'){{ $message }}@enderror</span>
                    </div>

                    <div class="frows mt10px">
                        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
                    </div>
                    <div class="button mt10px"><button type="submit" class="bluebtn btnCenter">{{ __('Reset Password') }}</button></div>  
                </form>
            </div>
        </div>
     </div>    
    </div>

    @include('layouts.parts.footer')
@endsection
