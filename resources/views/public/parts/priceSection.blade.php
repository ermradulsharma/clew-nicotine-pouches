<p><span>Price:</span> <span>${{ number_format($carts->sum('total_price'), 2) }}</span></p>
<p><span>Discount:</span> <span>-${{ number_format(($carts->sum('total_price')-$carts->sum('total_discount_amount')), 2) }}</span></p>
<p><span>Coupon Discount:</span> <span>-${{$couponDiscount}}</span></p>
<p><span>Tax:</span> <span>$0.00</span></p>
<p><span>Shipping:</span> <span>${{ number_format($shipping_price, 2)}}</span></p>
<p><span>Grand total:</span> <span>${{ number_format($carts->sum('total_discount_amount')+$shipping_price-$couponDiscount, 2)}}</span></p>