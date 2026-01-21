@extends('layouts.app')

@section('content')

    <div class="topslider-box">
        @include('layouts.parts.header', ['page'=>'checkout'])
        <img src="images/product-details_top.jpg" style="width:100%;"/>
    </div>

    <div class="product-main-container">
        <div class="headingRow">
            <span style="color:#1d5697;">Sorry.</span>
            <img src="images/heading-btm-blue.png"/>
        </div>
        <div class="ingCnt">Your order has been cancelled.</div>
    </div>

    @include('layouts.parts.footer')
@endsection
