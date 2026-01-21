@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'user'])
    <!-- <div class="homeSlider">
        <div><img src="{{ asset('images/login-banner.jpg') }}" class="w100"/></div>
    </div> -->

    @php $page = \Helper::page('register'); @endphp
    @section('title', $page->pageTitle)
    @section('pageDescription', $page->pageDescription)
    @section('pageKeywords', $page->pageKeywords)

    @php $banners = $page->banners()->orderBy('position','asc')->get(); @endphp
    @if(count($banners))
    <div class="homeSlider">
        @foreach($banners as $banner)
        <div>
            <img src="{{ asset('storage/page/banner/'.$banner->mobile) }}" class="w100 shwoMobile"/>
            <img src="{{ asset('storage/page/banner/'.$banner->desktop) }}" class="w100 show-desktop"/>
        </div>
        @endforeach
    </div>
    @else
    <div class="homeSlider">
        <div>
            <img src="{{ asset('images/register-desktop.jpg') }}" class="w100 show-desktop"/>
            <img src="{{ asset('images/register-mobile.jpg') }}" class="w100 shwoMobile"/>
        </div>
    </div>
    @endif

    

    <div style="background-color:#dee8f1;"> 
        <div class="registercontainer">
            <div class="cart-container">
                <div class="signhd" style="text-transform:none; flex-direction:row;">New to <img src="{{ asset('images/clew-icon.jpg') }}" alt=""/>?</div>
                <div class="loginform white">
                    <form id="signupForm" name="signupForm" method="POST" action="{{ route('register') }}">
                        @csrf
                        <p class="tc">Enter your details below</p>
                        <p class="imf">*Indicates mandatory fields</p> 
                        <div class="frows checkrow mt10px">
                            <div class="frows-in">
                            <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name*" autocomplete="first_name" autofocus>
                            <span>@error('first_name'){{ $message }}@enderror</span>
                            </div>
                            <div class="frows-in">
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name*" autocomplete="last_name" autofocus>
                            <span>@error('last_name'){{ $message }}@enderror</span>
                            </div>
                        </div>
                        <!--
                        <p class="tc hsi">Sign-in Information</p>
                        -->
                        <div class="frows mt10px">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email*" autocomplete="email">
                            <span>@error('email'){{ $message }}@enderror</span>
                        </div>
                        <div class="frows mt10px">
                            <input id="password" type="password" name="password"  placeholder="Password*" autocomplete="new-password">
                            <div class="show-password" id="togglePassword">
                                <img src="{{asset('images/password-eye-icn.svg')}}" />
                            </div>
                            <span>@error('password'){{ $message }}@enderror</span>
                        </div>
                        <p class="tc">Password requirements: minimum of 12 characters and must contain the following: uppercase, lowercase, special character, number</p>
                        <div class="frows mt10px">
                            <input id="password-confirm" type="password" name="password_confirmation"  placeholder="Confirm Password" autocomplete="new-password">
                            <div class="show-password" id="confirmTogglePassword">
                                <img src="{{asset('images/password-eye-icn.svg')}}" />
                            </div>
                            <span>@error('password_confirmation'){{ $message }}@enderror</span>
                        </div>
                        <div class="rem-row">
                            <div class="rem-row-left">
                                <input type="checkbox" id="tnc" name="tnc" value="1">
                                <label for="tnc">I agree with the Terms & Conditions and Privacy Policy</label>
                            </div>
                        </div>
                        <div class="rem-row mt10px">
                            <div class="rem-row-left">
                                <input type="checkbox" id="newsletter" name="newsletter" value="1">
                                <label for="newsletter">I wish to receive exclusive offers and discounts by email</label>
                            </div>
                        </div>    
                        <div class="frows mt10px">
                            <div class="g-recaptcha mt10px" data-sitekey="{{ config('services.recaptcha.sitekey') }}"></div>
                            <span>@error('g-recaptcha-response') {{ $message }} @enderror</span>
                        </div>
                        <div class="button mt20px"><button type="submit" class="bluebtn btnCenter">{{ __('Create an Account') }}</button></div>
                        <div id="responseMsg" class="mt10px"><span style="font-size: 11px; color: #e56161;">@error('tnc'){{ $message }}@enderror</span></div>      
                    </form>
                </div>
                <div class="tc ncl">Already have an account? <a href="{{ route('login') }}">Login</a></div>
            </div>
        </div>    
    </div>


    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    @include('layouts.parts.footer')
@endsection
