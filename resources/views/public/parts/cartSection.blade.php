@if($carts->count())
    <div class="cartLeft">
        @php $grand_total = 0; @endphp
        @foreach($carts as $cart)
            <div class="cartproductRow" id="cart-item-{{$cart->id}}" cart-id="{{$cart->id}}" style="background-color:#f5f9fc;">
                <span class="cross remove_from_cart" cart-id="{{$cart->id}}">&#10006;</span>
                <div class="pImg">
                    <a href="{{ route('productDetail', [$cart->product->slug]) }}"><img src="{{asset('storage/product/'.$cart->product_image)}}"/></a>
                </div>
                <div class="cp-des">
                    <div class="proname">{{$cart->product->title}} ({{$cart->productVariant->strength->title}})</div>
                    <div class="proDis">
                        <div class="as">
                            <button class="decrease_qty" cart-id="{{$cart->id}}" {{($cart->qty==1)?'disabled':''}}>-</button>
                                <input type="text" id="item-qty-{{$cart->id}}" class="qty-input" value="{{$cart->qty}}" data-min="1" data-max="100" disabled />
                            <button class="increase_qty" cart-id="{{$cart->id}}" {{($cart->qty>=100)?'disabled':''}}>+</button>
                        </div>
                        <div class="pri">
                            ${{$cart->total_discount_amount}}
                            @if($cart->total_discount_amount<$cart->total_price)
                            <small>Save ${{ number_format($cart->total_price-$cart->total_discount_amount, 2) }}</small>
                            @endif
                        </div>
                    </div>

                    {!! \Helper::buyMoreQty($cart->product_id, $cart->variant_id, $cart->qty) !!}
                </div>
            </div>
            @php $grand_total += $cart->total_discount_amount;  @endphp
        @endforeach
    </div>

    <div class="cartRight">
        <div class="ctn-row">
            <span><a href="{{ route('home') }}">&#8592; continue shopping</a></span>
            <span><a id="emptyCart">clear all items</a></span>
        </div>

        <div class="cartnewadd">
            {!! \Helper::couponCode() !!}
            <div class="cfee"><span>Price</span><span>${{ number_format($carts->sum('total_price'), 2) }}</span></div>
            <div class="cfee"><span>Discount</span><span>-${{ number_format(($carts->sum('total_price')-$carts->sum('total_discount_amount')), 2) }}</span></div>
            @php $couponDiscount = \Helper::couponDiscount() @endphp
            <div class="cfee"><span>Coupon Discount</span><span>-${{ $couponDiscount }}</span></div>
            <div class="cfee"><span>Total Savings</span><span>${{ number_format(($carts->sum('total_price')-$carts->sum('total_discount_amount'))+$couponDiscount, 2) }}</span></div>  
        </div>

        <div class="carttotal-row">
            <span>Grand Total</span>
            <span>${{ number_format($grand_total-$couponDiscount, 2)}}</span>
        </div>
        <p class="mt10px"><a href="{{ route('checkout') }}" id="checkout_btn" class="bluebtn btnCenter" tabindex="0" style="width:100%; height:50px;">proceed to checkout</a></p>
    </div>
    <div class="agechecker">
        <input type="hidden" id="first_name" value="{{ auth()->check() ? auth()->user()->first_name : '' }}">
        <input type="hidden" id="last_name" value="{{ auth()->check() ? auth()->user()->last_name : '' }}">
    </div>
@else
    <div class="cartempty-B"> 
    <div class="sumhd" style="text-align:center;">Your shopping cart is empty!</div>
    <p class="mt30px"><a href="{{ route('products') }}" class="bluebtn btnCenter" tabindex="0">continue shopping</a></p>
    </div>
@endif



