@extends('layouts.app')
@push('after-style')
<style>
    @media (max-width: 375px;) {
        .val-d {
            width: calc(100% - 13%) !important;
        }
    }
</style>
@endpush
@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'home'])
    <div class="homeSlider">
        @foreach($banners as $banner)
            @if($banner->bannerType=='image')
                <div>
                    <img src="{{asset('storage/banner/'.$banner->thumb) }}" class="w100 shwoMobile"/>
                    <img src="{{asset('storage/banner/'.$banner->image) }}" class="w100 show-desktop"/>
                </div>
            @else
                <div>
                    <video width="100%" height="100%" preload="auto" poster="{{asset('storage/banner/'.$banner->poster) }}" autoplay="" playsinline="" muted="" loop="">
                        <source src="{{asset('storage/banner/'.$banner->video) }}" type="video/mp4">
                    </video>
                </div>
            @endif
        @endforeach
    </div>
    <div class="clewhighlight">
        <img src="{{ asset('images/highlight-section-image-1920x490.jpg') }}" class="w100"/>
        {{-- <div class="chiglight-box">
            <img src="{{asset('images/usp-s-min.png')}}" alt=""/>
            @foreach($promises as $promise)
            <div class="higIconbox"><img src="{{asset('storage/promise/'.$promise->image) }}"/></div>
            @endforeach
        </div> --}}
    </div>
    <div class="clew-collection-container">
        <div class="headingRow">The<img src="{{asset('images/clew-icon.jpg')}}"/>Collection</div>
        <div id="youMayLikeProducts" class="collection-slider-container">
            <div class="collection-productSlid">
                @include('public.parts.productBox', ['products'=>$products])
            </div>
        </div>
        <p><a href="{{ route('products') }}" class="viewallbtn btnCenter">view all flavors</a></p>
    </div>
    {{-- <div class="offers-container">
        <div class="homeSlider offerslid">
            <div>
                <a href="{{ route('products') }}">
                    <img src="{{asset('images/offers-banner.jpg')}}" class="w100"/>
                    <img src="{{asset('images/offer-slider-1920x850.jpg')}}" class="w100"/>
                </a>
            </div>
        </div>
        <div class="buygetbanner">
            <a href="{{ route('products') }}"><img src="{{asset('images/buy-4-getfree-banner.png')}}"/></a>
            <a href="{{ route('products') }}" class="darkblue-btn">Buy Now</a>
        </div>
    </div> --}}
    <div class="how-to-clew-container">
        <div id="how-to-clew" class="ma-vdo">
            <a href="javascript:void(0)" class="videoLoader" data-video-src="videos/how-to-clew.mp4">
                <img src="images/how-to-clew.png" class="w100"/>
            </a>
        </div>
    </div>
    <div id="how-to-clew-video" style="display:none;">
        <div class="how-to-clewBox">
            <div id="videoModalContainer">
                <video id="localVideo" width="750" height="425" controls autoplay>
                    <source src="" type="video/mp4" />
                    Your browser does not support the video tag.
                </video>
            </div>
            <span id="videoClose">&#x2715;</span>
        </div>
    </div>
    <div class="step-for-use">
        @foreach($processes as $process)
        <div class="bx">
            <img src="{{asset('storage/process/'.$process->image) }}">
            <span>{{$process->title}}</span>
            <p>{{$process->tagline}}</p>
        </div>
        @endforeach
    </div>
    <div class="stay-clew-ed-in">
        <div class="headingRow">Stay CLEW-ed In!</div>
        <div class="stayClewslider">
            <div><img src="{{asset('images/clew-insta1.jpg') }}"/></div>
            <div><img src="{{asset('images/clew-insta3.jpg') }}"/></div>
            <div><img src="{{asset('images/clew-insta2.jpg') }}"/></div>
        </div>
        <div class="headingRow">Join the Clew Community</div>
        <div class="social-icon">
            {{-- <a href="https://www.facebook.com/Official.Clew" target="_blank" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="https://www.instagram.com/clewpouches.us" target="_blank" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            <a href="https://www.linkedin.com/company/clewpouches" target="_blank" title="Instagram"><i class="fa fa-linkedin" aria-hidden="true"></i></a> --}}
            {{-- <a href="https://www.facebook.com/Official.Clew" target="_blank" title="Facebook" aria-label="Facebook" style="height: 35px;"><img src="{{ asset('images/facebook.png') }}" alt="Facebook" width="35" height="35" srcset="{{ asset('images/facebook.png') }}"></a> --}}
            <a href="https://www.instagram.com/clewpouches.us" target="_blank" title="Instagram" aria-label="Instagram" style="height: 35px;"><img src="{{ asset('images/instagram.png') }}" alt="Instagram" width="35" height="35" srcset="{{ asset('images/instagram.png')}}"></a>
            <a href="https://www.linkedin.com/company/clewpouches" target="_blank" title="LinkedIn" aria-label="LinkedIn" style="height: 35px;"><img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" width="35" height="35" srcset="{{ asset('images/linkedin.png') }}"></a>
            {{-- <a href="https://www.youtube.com/channel/UC_QnIRpoQGygQ0ihQ7HgCeQ" target="_blank" title="YouTube" aria-label="YouTube" style="height: 35px;"><img src="{{ asset('images/youtube.png') }}" alt="Youtube" width="35" height="35" srcset="{{ asset('images/youtube.png') }}"></a>
            <a href="https://x.com/OfficialClew" target="_blank" title="X (Twitter)" aria-label="X (Twitter)" style="height: 35px;"><img src="{{ asset('images/twitter.png') }}" alt="Twitter" width="35" height="35" srcset="{{ asset('images/twitter.png') }}"></a> --}}
        </div>
    </div>
    @include('layouts.parts.footer')
@endsection
