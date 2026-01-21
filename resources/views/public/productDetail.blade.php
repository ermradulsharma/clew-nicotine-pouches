@extends('layouts.app')

@section('title', $product->pageTitle)
@section('pageDescription', $product->pageDescription)
@section('pageKeywords', $product->pageKeywords)

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'products'])

    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    <div id="productDetail" class="product-detail-container">
        <div class="pd-left" style="position:relative;">
            <div id="overlay" style="position:absolute;"><div class="cv-spinner"><span class="spinner"></span></div></div>
            <p class="pro-heading">{{ $product->title }}</p>
            
            {!! \Helper::wishlistIcon($product->id) !!}
            <span class="shareproduct">
            <a href="javascript:void(0)" product-title="{{$product->title}}" product-url="{{ route('productDetail', $product->slug) }}" class='product-share-button' >
                <i class="fa fa-share-alt"></i>
            </a>
            </span>
            <div id="productMultiSlider">
                @php $variantSel = $productVariants->first()->id ?? 0; @endphp
                @foreach($productVariants as $variant)
                    {!! \Helper::productMultiSlider($product->id, $variant->id, $loop->first ? $variant->id : 0) !!}
                @endforeach
                {{--
                <div class="homeSlider" style="position:relative;">
                    @forelse($productVariants as $productImage)
                    <div><img src="{{asset('storage/product/'.$productImage->image)}}" class="w100"/></div>
                    @empty
                    <div><img src="{{asset('images/product-thumb.png')}}" class="w100"/></div>
                    @endforelse
                </div>
                --}}
            </div>
        </div>
        <div class="pd-right">
            <div class="pd-rating">
                @if($product->rating)
                    <span class="star">
                        @for($rating = 1; $rating <= 5; $rating++)
                            <i class="fa {{ ($product->rating <= $rating) ? 'fa-star-o' : 'fa-star' }}" aria-hidden="true"></i>
                        @endfor
                    </span>
                @endif
            </div>
            <div class="vlist">
                <span>Strength</span>
                <select id="strength-{{ $product->id }}" name="strength" class="strength">
                    @foreach($productVariants as $variant)
                        <option value="{{$variant->id}}" product-id="{{$product->id}}" variant-id="{{$variant->id}}" variant-price="{{$variant->price}}">{{$variant->strength->title}}</option>
                    @endforeach
                </select>
            </div>
            <div id="productQtySection">
                <div class="addrow">
                    <div id="productQtySel" class="val-d displayPrice" product-id="{{ $product->id }}">5 can </div>
                    <div id="productQtyBox" class="all-vall productQtyBox" style="display:none;">
                        <ul id="qtyList">
                            @include('public.parts.priceDropDown', ['product_id'=>$product->id, 'product'=>$product,'variant_id'=>$variantSel, 'qtySel'=>5])
                        </ul>
                    </div>
                </div>
            </div>
            @php
                $defaultQty = 5;
                $discounts = \Helper::discount($product->id, $variantSel, $defaultQty);
                $finalPrice = $discounts["total_discount_amount"] ?: $discounts["total_amount"];
                $savings = $discounts["total_amount"] - $discounts["total_discount_amount"];
            @endphp
            <div id="discount" class="pricesection-r mt20px">
                <div class="price-left">
                    <span class="pl1">${{ number_format($finalPrice / $defaultQty, 2) }}/Can</span>
                    @if($savings > 0)
                        <span class="pl2">MSRP ${{ number_format($discounts["total_amount"] / $defaultQty, 2) }}</span>
                    @endif
                </div>
                <div class="price-left">
                    <span class="pr3">${{ number_format($finalPrice, 2) }}</span>
                    @if($savings > 0)
                        <span class="pr4">Save ${{ number_format($savings, 2) }}</span>
                    @endif
                </div>
            </div>
            <p><a href="javascript:void(0)" id="product-{{$product->id}}" product-id="{{$product->id}}" class="bluebtn btnCenter add_to_cart" tabindex="0" style="width:100%;">add to cart</a></p>
            <p class="productdiscreption">{!!$product->description!!}</p>
            <p class="pq">Quantity: 20 pouches/can</p>
        </div>
    </div>
    <div class="prodehig">
        {{-- <img src="{{asset('images/product-detail-high.jpg')}}" class="w100"/> --}}
        <img src="{{ asset('images/banners-below-product-details-1920x880.jpg') }}" class="w100"/> 
    </div>

    <div class="pickup-Cnt">
        <div class="pickL"><img src="{{asset('images/product-detail-pick-up.jpg')}}" class="w100"/></div>
        <div class="pickR">it's the perfect pick-me-up for when you need a quick reset.</div>
    </div>

    <div class="buydeal-container">
        <div class="amountRow">
            @for($qty = 1; $qty<=3; $qty++)
                @php $discounts = \Helper::discount($product->id, $variantSel, $qty * 5); @endphp
                <div class="col">
                    <p>Buy {{ $qty * 5 }}</p>
                    <span>${{ $discounts['total_discount_amount'] ?: $discounts['total_amount'] }}</span>
                    <span>Save ${{ number_format($discounts['total_amount'] - $discounts['total_discount_amount'], 2) }}</span>
                </div>
            @endfor
        </div>
        @if($product->banner)
            <div class="w100 mt20px"><img src="{{asset('storage/product/banner/'.$product->banner)}}" class="w100"/></div>
        @else
            <div class="w100 mt20px"><img src="{{asset('images/buy3img.png')}}" class="w100"/></div>
        @endif
    </div>
    <div class="ymaylike-container" style="background-color:#dee8f1;">
        <div class="headingRow">You May Also Like</div>
        <div id="youMayLikeProducts" class="collection-slider-container">
            <div class="collection-productSlid">
                @include('public.parts.productBox', ['products' => $similar_products->count() ? $similar_products : $products])
            </div>
        </div>
    </div>
    @if($recently_viewed_products->count())
        <div class="ymaylike-container">
            <div class="headingRow">Recently Viewed</div>
            <div id="recentlyViewedProducts" class="collection-slider-container">
                <div class="collection-productSlid">
                    @include('public.parts.productBox', ['products' => $recently_viewed_products])
                </div>
            </div>
        </div>
    @endif
    @include('layouts.parts.footer')
@endsection
