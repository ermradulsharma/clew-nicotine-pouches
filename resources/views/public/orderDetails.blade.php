@extends('layouts.app')
@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'orders'])
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
  <div style="background-color:#dee8f1;">
    <div class="orderDetail-container">
        <div class="headingRow">Order Details</div>
    
        <div class="o-adr mt20px">
            <div class="d-odrhd">
                <span>Order ID: #{{$order->id}}</span> 
                <span><a href="#"><img src="{{asset('images/invoice-icon.png')}}"/> invoice</a><a href="#">track order</a></span>
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
        </div>

        <div class="o-adr mt20px">
        <div class="addrow">
            <p class="hdel">Delivery Address</p> 
            <p class="hde2">Address</p>
            <p>
                {{$order->name}},<br/>
                {{$order->address}}, {{$order->apartment}}<br/>
                {{$order->city}} - {{$order->pincode}},<br/>
                {{$order->state}}, {{$order->country}}
            </p>
            <p class="hde3">{{$order->mobile}}</p>
            <p class="hde4">Estimated delivery: {{date("d M Y", strtotime('+7 days', strtotime($order->created_at)))}}</p>
        </div>
        </div>


        <div class="o-adr mt20px">
        <div class="addrow">
            <p class="hdel">Order total</p>
            <p class="totalord">
              <span>Total</span>
              <span>$ {{$order->total}}</span>
            </p>
            <p class="totalord">
              <span>Coupon Discount</span>
              <span>$ {{$order->coupon_amount}}</span>
            </p> 
            <p class="totalord">
              <span>Grand Total</span>
              <span>$ {{$order->grand_total}}</span>
            </p> 
        </div>
        </div>


    </div>
  </div>
  
  {{--
    <div class="page-content">
        <div class="holder breadcrumbs-wrap mt-0">
        <div class="container">
            <ul class="breadcrumbs">
            <li><a href="{{route('home')}}">Home</a></li>
            <li><span>My Orders</span></li>
            </ul>
        </div>
        </div>
        <div class="holder">
        <div class="container">
            <div class="row">
            @include('layouts.parts.accountNavigation', ['page' => "orders"])
            <div class="col-md-14 aside">
                <div class="account_right_block">
                    <div class="Order_detail_top">
                        <div class="order_id">
                            <strong>Order ID: #{{$order->id}}</strong>
                        </div>
                        <div class="orderDate">
                            <strong>Order Date: </strong> {{date("d M Y", strtotime($order->created_at))}}
                        </div>
                    </div>
                    <div class="delivery_full_info">
                        <div class="billing">
                            <p>
                                <h3>Billing Address</h3>
                                <strong>{{$order->name}}</strong><br>
                                {{$order->address}}, {{$order->city}}, {{$order->state}} {{$order->pincode}}<br>
                                <strong>Mobile No.: </strong>{{$order->mobile}}
                            </p>
                        </div>
                        <div class="track_order_box">
                            <div class="Ship_method">
                                <p>
                                    <strong>Order Status</strong><br>
                                    {{$order->order_status}}
                                </p>
                            </div>
                            <div class="pay_method">
                                <p>
                                    <strong>Payment Method</strong><br>
                                    {{strtoupper($order->payment_mode)}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="order_grid order_details">
                        <table border="1" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>SKU Code</th>
                                    <th>Unit Price</th>
                                    <th>Units</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                <tr>
                                    <td>
                                        <a href="{{ route('productDetails', [$cart->product->category->slug, $cart->product->subcategory->slug, $cart->product->slug]) }}">
                                            <img class="prod_img" src="{{asset('public/storage/product')}}/{{$cart->product_image}}" alt="{{$cart->product_name}}" />
                                        </a>
                                    </td>
                                    <td>{{$cart->product_name}} ({{$cart->size_name}})</td>
                                    <td>{{$cart->sku_code}}</td>
                                    <td>Rs. {{$cart->unit_price}}</td>
                                    <td>{{$cart->qty}}</td>
                                    <td>Rs. {{$cart->total_price}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text_right_td">Order Total</td>
                                    <td class="text_right_td">Rs. {{$order->total}}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text_right_td">Shipping Fee</td>
                                    <td class="text_right_td">Rs. {{$order->delivery_charge}}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text_right_td">Coupon Discount</td>
                                    <td class="text_right_td">Rs. {{$order->discount}}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text_right_td">Grand Total</td>
                                    <td class="text_right_td">Rs. {{$order->grand_total}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    --}}
    
    @include('layouts.parts.footer')
@endsection