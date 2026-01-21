@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'payment'])

    <div class="homeSlider">
        <div><img src="images/cart-banner.jpg" class="w100"/></div>
    </div>

    <div style="background-color:#dee8f1; border:1px solid #fff;"> 
        <div class="cart-container">
            <div class="headingRow">Checkout</div>
            
            <p class="tc ohd mt30px">shipping address</p>
            <div class="o-adr mt20px">
                <p><i class="fa fa-phone"></i> {{ $checkout->mobile }}</p>
                <p class="mt20px"><i class="fa fa-map-marker"></i>  {{ $checkout->apartment }}, {{ $checkout->address }}, {{ $checkout->city }} - {{ $checkout->pincode }}</p> 
            </div>

            <p class="tc ohd mt30px">Payment method</p>
            <div class="o-adr mt20px">
            <p class="visar"><img src="images/visa-icon.jpg"/> ******************3737</p>
            </div>

            <p class="tc ohd mt30px">Cart</p>
            <div class="o-adr mt20px">
                @php $grand_total = 0; @endphp
                @foreach($carts as $cart)
                <div class="ad-row">
                    <div class="op-pImg"><img src="{{asset('storage/product/'.$cart->product_image)}}"> <span class="mt10px">{{$cart->product->title}} ({{$cart->productVariant->strength->title}})</span></div>
                    <div class="op-pri">
                        @if($cart->total_discount_amount==$cart->total_price)
                        $ {{$cart->total_price}}/-
                        @else
                        <small class="deleted">$ {{$cart->total_price}}/-</small>
                        $ {{$cart->total_discount_amount}}/-
                        @endif
                    </div>
                </div>
                @php $grand_total += $cart->total_discount_amount;  @endphp
                @endforeach
                <div class="carttotal-row"><span>cart toal</span><span>$ {{$grand_total}}</span></div>
            </div>

            <div class="ctn-row mt20px">
                <span><a href="{{ route('checkout') }}">&#8592; Back</a></span>
                <span></span>
            </div>

            <p class="mt30px"><a href="#" class="bluebtn btnCenter" tabindex="0" style="width:100%;">submit order</a></p>

        </div>
    </div>

    {{--
    <div class="product-main-container">
        <div class="headingRow">
            <span style="color:#1d5697;">Payment</span>
            <img src="images/heading-btm-blue.png"/>
        </div>

        <div class="bcrum">
            <a href="{{ route('home') }}"><img src="images/homeIcon.png"/></a> / shopping cart / payment
        </div>
        
        <div id="paymentSection" class="checkout-container">
            <form id="paymentForm" name="paymentForm">
                <div class="trms">
                    <ul>
                        <li><input type="radio" name="payment" value="online" checked /> Online (Prepaid)</li>
                        <li><input type="radio" name="payment" value="cod" /> Cash on Delivery</li>
                    </ul>
                </div>
                <div class="btnrow">
                    <button type="submit" id="placeOrder" class="buttoncss">Place Order</button>
                </div>
            </form>
        </div>
    </div>
    --}}


    @include('layouts.parts.footer')
@endsection
