{{-- <div class="productMultiSlider slider_{{$product_id}}_{{$variant_id}} {{ $variantSel?'':'hide' }}" product_id="{{$product_id}}" variant_id="{{$variant_id}}" style="position:relative;">
    @foreach($productImages as $productImage)
    <div><img src="{{asset('storage/product/multishots/'.$productImage->image)}}" class="w100"/></div>
    @endforeach
</div> --}}
<div class="productMultiSlider slider_{{$product_id}}_{{$variant_id}} {{ $variantSel ? '' : 'hide' }}" product_id="{{$product_id}}" variant_id="{{$variant_id}}">
    <div class="slider-container">
        {{-- Thumbnail Slider (vertical) --}}
        <div class="thumbnail-slider slider_{{$product_id}}_{{$variant_id}}_nav" style="width: 20%;">
            @foreach($productImages as $productImage)
                <div>
                    <img src="{{ asset('storage/product/multishots/' . $productImage->image) }}" class="thumb-img w25" />
                </div>
            @endforeach
        </div>
        {{-- Main Slider --}}
        <div class="main-slider slider_{{$product_id}}_{{$variant_id}}" style="width: 80%">
            @foreach($productImages as $productImage)
                <div>
                    <img src="{{ asset('storage/product/multishots/' . $productImage->image) }}" class="w25" />
                </div>
            @endforeach
        </div>
        
        
    </div>
</div>
