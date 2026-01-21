@extends('layouts.app')
@section('title', $page->pageTitle)
@section('pageDescription', $page->pageDescription)
@section('pageKeywords', $page->pageKeywords)

@section('content')
    <style>
        .pageclew-cnt {
            width: 80%;
            margin: auto;
            padding: 2.5rem;
        }
        @media (max-width: 768px) {
            .pageclew-cnt {
            width: 100%;
            padding: 2rem 1rem;
            text-align: justify;
        }
        }
    </style>
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page' => 'about'])
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @if (count($page->banners))
        <div class="homeSlider">
            @foreach ($page->banners as $banner)
                <div>
                    <img src="{{ asset('storage/page/banner/' . $banner->mobile) }}" class="w100 shwoMobile" />
                    <img src="{{ asset('storage/page/banner/' . $banner->desktop) }}" class="w100 show-desktop" />
                </div>
            @endforeach
        </div>
    @endif

    <section class="accordion">
        <div class="pageClew-container">
            <div class="pageclew-cnt">
                <div class="headingRow">{{ $page->title }}</div>
                <p class="mt30px">{!! $page->content !!}</p>
            </div>
        </div>
    </section>
    @include('layouts.parts.footer')
@endsection
