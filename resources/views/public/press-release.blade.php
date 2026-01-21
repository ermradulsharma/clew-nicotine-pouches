@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page' => 'press-release'])
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @php $page = \Helper::page('press-release'); @endphp
    @section('title', $page->pageTitle)
    @section('pageDescription', $page->pageDescription)
    @section('pageKeywords', $page->pageKeywords)

@php $banners = $page->banners()->orderBy('position','asc')->get(); @endphp
@if (count($banners))
    <div class="homeSlider">
        @foreach ($banners as $banner)
            <div>
                <img src="{{ asset('storage/page/banner/' . $banner->mobile) }}" class="w100 shwoMobile" />
                <img src="{{ asset('storage/page/banner/' . $banner->desktop) }}" class="w100 show-desktop" />
            </div>
        @endforeach
    </div>
@else
    <div class="homeSlider">
        <div>
            <img src="{{ asset('images/press-release-banner-mobile.jpg') }}" class="w100 shwoMobile" />
            <img src="{{ asset('images/press-release-banner-desktop.jpg') }}" class="w100 show-desktop" />
        </div>
    </div>
@endif

<div class="blog-container">
    <div class="headingRow">Clew Press Release</div>
    <div style="width:90%; margin-left:auto; margin-right:auto;">
        <p class="hdcheck mt30px">Featured</p>
    </div>
    <div class="blog-press-slid mt20px">
        @foreach ($pressReleases as $pressRelease)
            <div>
                <div class="blogBox">
                    <a href="{{ $pressRelease->url }}" target="_blank">
                        <img src="{{ asset('storage/press-release/' . $pressRelease->image) }}" />
                        <p class="date">{{ date('d M, Y', strtotime($pressRelease->date)) }}</p>
                        <p class="sbhd" style="padding-top:0px">{{ $pressRelease->title }}</p>
                        <p class="blgcnt">
                            {{ $pressRelease->description }}
                            <a href="{{ $pressRelease->url }}" target="_blank">Read More</a>
                        </p>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>



<div class="recommendation-container">
    <p class="hdcheck mt30px">Recommended</p>
    <div class="recom-row">
        @foreach ($pressReleases as $pressRelease)
            <div class="recommend-box">
                <a href="{{ $pressRelease->url }}" target="_blank">
                    <img src="{{ asset('storage/press-release/' . $pressRelease->image) }}" />
                </a>
                <div class="remLeft">
                    <p class="hdrem">{{ $pressRelease->title }}</p>
                    <p class="hdCn">{{ $pressRelease->description }}
                        <a href="{{ $pressRelease->url }}" target="_blank">Read More</a>
                    </p>
                    <div class="auname"><span>{{ date('d M, Y', strtotime($pressRelease->date)) }}</span></div>
                </div>
            </div>
        @endforeach
    </div>
</div>


@include('layouts.parts.footer')
@endsection
