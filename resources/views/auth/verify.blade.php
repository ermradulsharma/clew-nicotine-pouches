@extends('layouts.app')

@section('content')

<div style="background-color:#dee8f1;"> 
    <div class="cart-container">
        <p class="loginlogo"><a href="{{ route('home') }}"><img src="{{ asset('images/clew-logo.png') }}"/></a></p>
        <div class="loghead"><span>login</span><p>{{ __('Verify Your Email Address') }}</p></div>
        <div class="loginform">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p class="tc">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p class="tc">{{ __('If you did not receive the email') }}</p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="bluebtn btnCenter">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
</div>

{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
--}}
@endsection
