@extends('layouts.app')
@section('title', $page->pageTitle)
@section('pageDescription', $page->pageDescription)
@section('pageKeywords', $page->pageKeywords)

@section('content')
    <style>
        .tab__content {
            margin: auto !important;
        }

        .faqClew-container {
            text-align: center;
            padding: 1.5rem 0;
        }

        .faqclew-cnt {
            margin-bottom: 2rem;
        }

        /*  */
        .tab {
            position: relative;
            width: 75%;
            margin: auto;
            margin-bottom: 0.5rem;
            background: #dee8f1;
            border-radius: 10px;
        }

        .tab input {
            position: absolute;
            opacity: 0;
            z-index: -1;
        }

        .tab input:checked~.tab__content {
            max-height: 100vh;
        }

        .accordion {
            padding: 2.5rem;
        }

        .tab__label,
        .tab__close {
            display: flex;
            background: #15a5c7;
            cursor: pointer;
            border-radius: 10px;
        }

        .tab__label {
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            font-weight: 700;
            color: #ffffff;
        }

        .tab__label::after {
            content: "\276F";
            width: 1em;
            height: 1em;
            text-align: center;
            transform: rotate(90deg);
            transition: all 0.35s;
        }

        .tab input:checked+.tab__label::after {
            transform: rotate(270deg);
        }

        .tab__content p {
            margin: 0;
            padding: 1rem;
        }

        .tab__close {
            justify-content: flex-end;
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }

        .accordion--radio {
            --theme: var(--secondary);
        }

        .tab input:not(:checked)+.tab__label:hover::after {
            animation: bounce .5s infinite;
        }

        .tab input:checked+label {
            border-radius: 10px 10px 0 0;
        }

        @keyframes bounce {
            25% {
                transform: rotate(90deg) translate(.25rem);
            }

            75% {
                transform: rotate(90deg) translate(-.25rem);
            }
        }

        @media (max-width: 768px) {
            .accordion {
                padding: 1rem 1.5rem;
            }

            .faqclew-cnt p {
                text-align: justify;
            }

            .tab {
                width: 100% !important;
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
        <div class="faqClew-container">
            <div class="faqclew-cnt">
                <div class="headingRow">{{ $page->title }}</div>
                <p class="mt10px">{{ $page->pageDescription }}</p>
            </div>
        </div>
        @foreach ($faqs as $key => $faq)
            <div class="tab">
                <input type="radio" name="accordion-1" id="cb{{ $key + 1 }}"
                    {{ $key == 0 ? 'checked' : '' }}>
                <label for="cb{{ $key + 1 }}" class="tab__label">{{ $faq->title }}</label>
                <div class="tab__content">
                    <p>{{ $faq->description }}</p>
                </div>
            </div>
        @endforeach
    </section>
    @include('layouts.parts.footer')
@endsection
