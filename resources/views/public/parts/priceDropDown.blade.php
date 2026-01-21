@php
    $qtyOptions = [1, 5, 10, 15];
@endphp
@foreach($qtyOptions as $qty)
    @php
        $discounts = \Helper::discount($product_id, $variant_id, $qty);
        $price = $discounts["total_discount_amount"] ?: $discounts["total_amount"];
        $savings = $discounts["total_amount"] - $discounts["total_discount_amount"];
    @endphp
    <li class="chooseQty {{ ($qtySel == $qty) ? 'qtySelected' : '' }}" product-id="{{ $product_id }}" variant-id="{{ $variant_id }}" qty="{{ $qty }}">
        <label class="s1">{{ $qty }} {{ $qty == 1 ? 'can' : 'cans' }}</label>
        <label class="s2">${{ number_format($price, 2) }}</label>
        @if($savings > 0)
            <label class="s3">Save ${{ number_format($savings, 2) }}</label>
        @else
            <label></label>
        @endif
    </li>
@endforeach
