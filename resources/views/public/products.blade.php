@extends('layouts.app')
@push('after-style')
    <style>
        @media (max-width: 425px) and (min-width: 376px) {
            .product-list-container .val-d {
                background-position: calc(100% - 90px) calc(1em + 2px), calc(100% - 85px) calc(1em + 2px), calc(100% - 2.5em) 0.5em;
            }
            .val-d {
            width: 100% !important;
        }
        @media (max-width: 375px) {
            .val-d {
            width: 78% !important;
        }
        }
        }
    </style>
@endpush
@section('content')
    @include('layouts.parts.warning')

    @include('layouts.parts.header', ['page' => 'products'])

    @php $page = \Helper::page('product'); @endphp
@section('title', $page->pageTitle)
@section('pageDescription', $page->pageDescription)
@section('pageKeywords', $page->pageKeywords)
@include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
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
            <img src="{{ asset('images/listing-banner-mobile.jpg') }}" class="w100 shwoMobile" />
            <img src="{{ asset('images/listing-banner-desktop.jpg') }}" class="w100 show-desktop" />
        </div>
    </div>
@endif

<div class="product-list-container">
    <div class="listing-container">
        <div class="filter-container">
            <div id="productSortBy" class="filterRight">
                <div class="fb-one" id="sortFilter"><img src="images/sort-icon.png" /> Sort & Filter</div>
                <div class="desktop-fb-one"><img src="images/sort-icon.png" /> Sort & Filter</div>
                <div class="sortlistshow" style="display:none;">
                    <div class="filter-listing-box">
                        <div class="hding"><span>SORT BY</span><span class="cls"
                                id="sortclosecfilter">&#10006;</span></div>
                        <div class="shorradio">
                            <ul>
                                <li><label for="most_popular">Most Popular</label> <input type="radio"
                                        id="most_popular" name="sortby" class="sortBy" value="most_popular" checked />
                                </li>
                                <li><label for="newest">Newest</label> <input type="radio" id="newest"
                                        name="sortby" class="sortBy" value="newest" /> </li>
                                <li><label for="discounted">Discounted: Most-least</label> <input type="radio"
                                        id="discounted" name="sortby" class="sortBy" value="discounted" /> </li>
                                <li><label for="price_low_high">Price: Low-High</label> <input type="radio"
                                        id="price_low_high" name="sortby" class="sortBy" value="price_low_high" />
                                </li>
                                <li><label for="price_high_low">Price: High-Low</label> <input type="radio"
                                        id="price_high_low" name="sortby" class="sortBy" value="price_high_low" />
                                </li>
                            </ul>
                        </div>
                        <div class="filterRowbtn">
                            <a href="#" id="applyProductSorting" class="bluebtn btnCenter mt10px"
                                tabindex="0">apply</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="productFilter" class="filterLeft">
                <div class="fb-two" id="categoriesFilter"><img src="images/categories-icon.png" /> Categories</div>
                <div class="desktop-fb-two"><img src="images/categories-icon.png" /> Categories</div>
                <div class="sfdetailC" style="display:none;">
                    <div class="filter-listing-box">
                        <div class="hding"><span>CATEGORIES</span><span class="cls"
                                id="closecfilter">&#10006;</span></div>
                        <div class="accordion-filter">
                            <div class="tab-filter">
                                <input type="checkbox" name="accordion-1" id="cb1" checked>
                                <label for="cb1" class="tab__label">flavor</label>
                                <div class="tab__content">
                                    <ul>
                                        @foreach ($flavours as $flavour)
                                            <li><input type="checkbox" id="flavour-{{ $flavour->id }}" name="flavour[]"
                                                    value="{{ $flavour->id }}" class="flavours" /> <label
                                                    for="flavour-{{ $flavour->id }}">{{ $flavour->title }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-filter">
                                <input type="checkbox" name="accordion-1" id="cb2">
                                <label for="cb2" class="tab__label">strength</label>
                                <div class="tab__content">
                                    <ul>
                                        @foreach ($strengths as $strength)
                                            <li><input type="checkbox" id="strength-{{ $strength->id }}"
                                                    name="strength[]" value="{{ $strength->id }}" class="strengths" />
                                                <label
                                                    for="strength-{{ $strength->id }}">{{ $strength->title }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="filterRowbtn">
                            <a href="#" id="clearProductFilter" class="whitebtn btnCenter mt10px"
                                tabindex="0">clear categories</a>
                            <a href="#" id="applyProductFilter" class="bluebtn btnCenter mt10px"
                                tabindex="0">apply and close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="productListing" class="product-listing-container">
        <div class="totalitem">{{ $products->count() }} Items</div>
        <div id="productListBox" class="product-showlist">
            @include('public.parts.productBox', ['products' => $products])
        </div>
    </div>
</div>


@include('layouts.parts.footer')
@endsection
