<div class="price-left">
    @if($total_discount_amount<$total_amount)
    <span class="pl1">${{ number_format($total_discount_amount/$qty,2)}}/Can</span>
    <span class="pl2">MSRP ${{$variant_price}}</span>
    @else
    <span class="pl1">${{$variant_price}}/Can</span>
    @endif
</div>
<div class="price-left">
    @if($total_discount_amount<$total_amount)
    <span class="pr3">${{$total_discount_amount}}</span>
    <span class="pr4">Save ${{number_format($total_amount-$total_discount_amount, 2)}}</span>
    @else
    <span class="pr3">${{$total_amount}}</span>
    @endif
</div>