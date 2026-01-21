<div class="price-left">
    @if($total_discount_amount<$total_amount)
    <span>${{$total_discount_amount}}</span>
    <span>Save ${{number_format($total_amount-$total_discount_amount, 2)}}</span>
    @else
    <span>${{$total_amount}}</span>
    <span></span>
    @endif
</div>