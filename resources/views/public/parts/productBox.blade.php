@foreach($products as $product)
<div id="productBox-{{$product->id}}" class="boxes" style="position:relative;">
    @php
        $productImage = $product->variants()->where('status', 1)->orderBy('position', 'asc')->first();            
    @endphp
    @if($productImage)
    @php $thumb =  asset('storage/product/'.$productImage->thumb); @endphp
    @else
    @php $thumb = asset('images/product-thumb.png'); @endphp
    @endif

    <a href="{{ route('productDetail', $product->slug) }}"><img id="productImage-{{$product->id}}" src="{{$thumb}}"/></a>
    {!! \Helper::wishlistIcon($product->id) !!}
    <span class="shareProductCard">
        <a href="javascript:void(0)" product-title="{{$product->title}}" product-url="{{ route('productDetail', $product->slug) }}" class='product-share-button' >
            <i class="fa fa-share-alt"></i>
        </a>
    </span>
    {!! \Helper::label($product->id) !!}

    @if($product->rating)
    <p class="star">
        @for($rating = 1; $rating<=5; $rating++)
        <i class="fa {{ ($product->rating<=$rating)?'fa-star-o':'fa-star' }}" aria-hidden="true"></i>
        @endfor
    </p>
    @endif

    <p class="line1"><a href="{{ route('productDetail', $product->slug) }}">{{ $product->title }}</a></p>
    @php
        $defaultQty = 5;
        $variants = \App\Models\ProductVariant::where('product_id', $product->id)->where('status',1)->orderBy('position','asc')->get();
        $variant_id = $variants->first()?->id;
        $discounts = \Helper::discount($product->id, $variant_id, $defaultQty);
        $price = $discounts["total_discount_amount"] ?: $discounts["total_amount"];
        $savings = $discounts["total_amount"] - $discounts["total_discount_amount"];
    @endphp
    <p id="price-{{ $product->id }}" class="productPrice line2">
        <span>${{ number_format($price, 2) }}</span>
        @if($savings > 0)
            <span>Save ${{ number_format($savings, 2) }}</span>
        @else
            <span></span>
        @endif
    </p>
    {{-- <p id="price-{{ $product->id }}" class="productPrice line2">
        @if($product->mrp>$product->price)
        <span>${{$product->price}}</span>
        <span>${{$product->mrp}}</span>
        @else
        <span>${{$product->price}}</span>
        <span></span>
        @endif
    </p> --}}

    @php $variants = \App\Models\ProductVariant::where('product_id', $product->id)->where('status',1)->orderBy('position','asc')->get(); @endphp
    {{--
    <p id="variant-{{ $product->id }}" class="variantList" style="margin:15px 0px; display:none;">Strength :
        @foreach($variants as $variant)
        @if($loop->first) @php $variant_id = $variant->id; @endphp @endif
        <span class="variant {{ ($loop->first)?'selected':'' }}" id="product-variant-{{$variant->id}}" product-id="{{$product->id}}" variant-id="{{$variant->id}}" variant-price="{{$variant->price}}" variant-image="{{ asset('storage/product/'.$variant->thumb) }}">{{$variant->strength->title}}</span>
        @endforeach
    </p>
    --}}

    <div class="vlist">
        <span>Strength</span>
        <select id="strength-{{ $product->id }}" name="strength" class="strength">
            @foreach($variants as $variant)
            @if($loop->first) @php $variant_id = $variant->id; @endphp @endif
            <option value="{{$variant->id}}" product-id="{{$product->id}}" variant-id="{{$variant->id}}" variant-price="{{$variant->price}}" variant-image="{{ asset('storage/product/'.$variant->thumb) }}">{{$variant->strength->title}}</option>
            @endforeach
        </select>
    </div>
    {{-- {{ $product }} --}}
    <div id="productQtySection-{{ $product->id }}" class="productQtySection">
        <div class="addrow">
            <div id="productQtySel-{{ $product->id }}" class="val-d displayPrice productQtySel" product-id="{{ $product->id }}">{{ $defaultQty }} {{ $defaultQty == 1 ? 'can' : 'cans' }}</div>
            <div id="productQtyBox-{{ $product->id }}" class="all-vall productQtyBox" style="display:none;">
                <ul class="productQtyPrice" id="qtyList-{{ $product->id }}">
                    @include('public.parts.priceDropDown', ['product_id'=>$product->id, 'product'=>$product,'variant_id'=>$variant_id, 'qtySel'=>$defaultQty])
                </ul>
            </div>
            <a href="javascript:void(0)" id="product-{{$product->id}}" product-id="{{$product->id}}" class="bluebtn btn-inline add_to_cart">add</a>
        </div>
        <div class="viewCart"></div>
    </div>
</div>
@endforeach


