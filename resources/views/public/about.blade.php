@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'about'])

    @php $page = \Helper::page('about-us'); @endphp
    @section('title', $page->pageTitle)
    @section('pageDescription', $page->pageDescription)
    @section('pageKeywords', $page->pageKeywords)
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
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
            <img src="{{ asset('images/aboutUs-banner.png') }}" class="w100 shwoMobile"/>
            <img src="{{ asset('images/aboutUs-banner-m.png') }}" class="w100 show-desktop"/>
        </div>
    </div>
    @endif

    

    <div class="aboutClew-container">
        <div class="aboutclew-cnt">
            <div class="headingRow">{{$about->title}}</div>
            <p class="mt10px">{{$about->description}}</p>
        </div>
        <img src="{{ asset('storage/about/'.$about->image) }}" class="w100"/>
    </div>

    <div class="mis-vis-container">
        <div class="ourmission">
            <img src="{{ asset('storage/about/'.$about->om_image) }}"/>
            <div class="headingRow">{{$about->om_title}}</div>
            <p class="mt10px">{{$about->om_description}}</p>
            <!-- <p class="mt10px">We refused to settle for the ordinary in nicotine products. CLEW is redefining nicotine<a href="javascript:void(0);" class="mission-l">...Read More</a>
            <span style="display:none;" class="mission-c">science by creating advanced solutions that prioritize harm reduction for adult smokers. Our goal is to offer safer, more satisfying alternatives, helping accelerate the global shift away from cigarettes and paving the way for a smoke-free future.</span></p> -->
        </div>
        <div class="ourmission">
            <img src="{{ asset('storage/about/'.$about->ov_image) }}"/>
            <div class="headingRow">{{$about->ov_title}}</div>
            <p class="mt10px">{{$about->ov_description}}</p>
            <!-- <p class="mt10px">Driven by an uncompromising commitment to quality, we ensure our products are 
                crafted to your satisfaction.<a href="javascript:void(0);" class="vission-l">...Read More</a><span style="display:none;" class="vission-c"> Upholding the highest global standards in regulations and compliance, we implement rigorous age-gating measures to prevent access to those under the legal age. Our partnerships foster mutual growth, supporting success for suppliers, distributors, retailers, and employees. Sustainability remains central to our mission, as we continuously strive to minimize our environmental footprint and maintain full transparency in our practices.</span></p> -->
        </div>
    </div>

    <div class="quality-assurance-container">
        <img src="{{ asset('storage/about/'.$about->qa_image) }}"/>
        <div class="qualityCnt">
            <div class="headingRow">{{$about->qa_title}}</div>
          <!--  <p class="mt5px">Quality is at the heart of everything we do.<a href="javascript:void(0);" class="qa-l">...Read More</a><span style="display:none;" class="qa-c"> We are unwavering in our commitment to excellence, ensuring that every product we offer is best-in-class. From meticulous attention to device functionality and flavor profiling to the selection of premium ingredients, we leave no stone unturned in our pursuit of perfection. Your satisfaction drives us, and we strive to deliver an extraordinary experience with each and every product.
            </span>
            </p> -->
            <p class="mt10px">{{$about->qa_description}}</p>
        </div>
    </div>

    <div class="about-nev">
        <div class="headingRow">{{$about->ni_title}}</div>
        <img src="{{ asset('storage/about/'.$about->ni_image) }}"/>
        <!-- <p class="mt20px">NEVCORE Innovations stands at the
        forefront of nicotine harm reduction,
        championing a future where<a href="javascript:void(0);" class="nev-l">...Read More</a>
        <span style="display:none;" class="nev-c">indulgence meets responsibility. As a global.</span>
        </p> -->
        <p>{{$about->ni_description}}</p>
    </div>

    <div class="manufacturing-container">
        <div id="mediaCorner" class="ma-vdo">
            <a href="javascript:void(0)" id="{{$about->m_video}}" class="videoLoader"><img src="{{ asset('storage/about/'.$about->m_image) }}"/></a>
        </div>
        <div class="ma-cnt">
            <div class="headingRow" style="color:#fff;">{{$about->m_title}}</div>
           <!-- <p class="mt20px">Clew is a global leader in next-generation product manufacturing, partnering with NEVCORE Innovation to deliver
                <a href="javascript:void(0);" class="man-l">...Read More</a>
                <span style="display:none;" class="man-c"> best-in-class oral nicotine pouches and disposables. Our cutting-edge</span>
            </p> --> 
            <p>{{$about->m_description}}</p>
        </div>
    </div>


<div id="manufacture-video" style="display:none;">
     <div class="manufactureBox">
     <div  id="videoModalContainer"></div>
        <span id="videoClose">&#x2715;<span>
     </div>
</div>


    @include('layouts.parts.footer')
@endsection