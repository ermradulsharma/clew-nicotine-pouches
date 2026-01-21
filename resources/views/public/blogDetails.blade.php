@extends('layouts.app')
@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page' => 'blogs'])
    <style>
        .post-content p {
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .post-content img {
            max-width: 100%;
            height: auto;
        }

        .post-content h1,
        .post-content h2,
        .post-content h3 {
            font-weight: 700;
            font-size: 23px;
            letter-spacing: 0.1em;
            text-transform: capitalize;
            line-height: 27px;
            margin-bottom: 10px;
        }

        @media (min-width: 768px) {

            .post-content h1,
            .post-content h2,
            .post-content h3 {
                font-size: 28px;
            }
        }

        .post-content ul,
        .post-content ol {
            margin-left: 2rem;
        }
    </style>

    <div class="homeSlider">
        <div>
            <img src="{{ \Helper::getMobileBanner($post->ID) }}" class="w100 shwoMobile" />
            <img src="{{ \Helper::getDesktopBanner($post->ID) }}" class="w100 show-desktop" />
        </div>
    </div>
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div class="recommendation-container">
        <div class="blogD-cnt">
            <p class="blog-hding">{{ $post->post_title }}</p>
            <div class="post-content"> {!! $post->post_content !!}</div>
        </div>

    </div>


    @include('layouts.parts.footer')
@endsection
