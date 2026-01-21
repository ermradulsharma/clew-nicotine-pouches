@if($productImages->count())
<div class="homeSlider" style="position:relative;">
    @forelse($productImages as $productImage)
    <div><img src="{{asset('storage/product/multishots/'.$productImage->image)}}" class="w100"/></div>
    @empty
    <div><img src="{{asset('images/product-thumb.png')}}" class="w100"/></div>
    @endforelse
</div>
@else
<div class="homeSlider" style="position:relative;">
    @forelse($productVariants as $productImage)
    <div><img src="{{asset('storage/product/'.$productImage->image)}}" class="w100"/></div>
    @empty
    <div><img src="{{asset('images/product-thumb.png')}}" class="w100"/></div>
    @endforelse
</div>
@endif