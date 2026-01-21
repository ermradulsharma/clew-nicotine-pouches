@php $productVariant = $product->variants()->where('status',1)->orderBy('position','asc')->first(); @endphp
<div class="buydeal-container">
    <div class="amountRow">
        @for($qty = 1; $qty<=3; $qty++)
        @php $discounts = \Helper::discount($product->id, $productVariant->id, $qty*5); @endphp
        <div class="col">
            <p>buy {{$qty*5}}</p>
            <span>${{ $discounts["total_discount_amount"]?$discounts["total_discount_amount"]:$discounts["total_amount"]}}</span>
            <span>Save ${{ number_format($discounts["total_amount"]-$discounts["total_discount_amount"], 2) }}</span>
        </div>
        @endfor
    </div>

    <div class="w100 mt20px">
        <a href="{{ route('productDetail', $product->slug) }}">
            @if($product->banner)
            <img src="{{asset('storage/product/banner/'.$product->banner)}}" class="w100"/>
            @else
            <img src="{{asset('images/buy3img.png')}}" class="w100"/>
            @endif
        </a>
    </div>
</div>