@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'orders'])

    <div style="background-color:#dee8f1;">
        <div class="orderDetail-container">
            <div class="headingRow">Thank You!</div>
            <div class="o-adr mt20px">
                <div class="d-odrhd">
                    <span>Order ID: #{{$order->id}}</span>
                </div>
                @foreach($order->cart as $cart)
                <div class="ad-row">
                    <div class="op-pImg">
                        <img src="{{asset('storage/product/'.$cart->product_image)}}" alt="{{$cart->product_name}}" />
                        <span class="mt10px">{{$cart->product_name}} ({{$cart->variant_name}})</span>
                    </div>
                    <div class="op-pri">$ {{$cart->total_discount_amount}}</div>
                </div>
                @endforeach
                <div class="addrow"><p class="hdel">Your order has been placed successfully.</p></div>
            </div>
        </div>
    </div>

    @include('layouts.parts.footer')
@endsection
