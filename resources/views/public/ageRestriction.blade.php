@extends('layouts.app')

@section('content')
    <div class="age-main-container">
        <div class="age-restricted-box">
            <div class="logo"><img src="{{asset('images/clew-logo.png')}}"/></div>
            <div class="restrictedBox">
                <p>Age Verification<br/></p>
                <span> Minimum age to access this webpage is 21 years.<br/>Are you 21 years or older?</span>
                <div class="buttonrow">
                    <button id="legalAge">Yes</button>
                    <button id="invalidAge">No</button>
                </div>
            </div>
            <div class="invalidAge" style="display: none;">
                <div class="invalidAgeWrap">
                <span class="close">x</span>
                <div class="content">Sorry, Your age does not permit you to enter this website.</div>
                </div>
            </div>
        </div>
    </div>
@endsection
