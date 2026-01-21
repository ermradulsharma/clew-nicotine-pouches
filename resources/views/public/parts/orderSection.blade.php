@if(count($orders))
    @foreach($orders as $order)
    <div class="o-adr mt20px">
        <div class="d-odrhd">
            <span>Order ID: #{{$order->id}}</span> 
            <span><a href="{{route('orderDetails', [$order->id])}}">View Details</a></span>
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
        <div class="addrow">
            <p class="totalord">
                <span>Ordered On</span>
                <span>{{date("d M Y", strtotime($order->created_at))}}</span>
            </p> 
        </div>
    </div>
    @endforeach
@else
<div class="addrow text-center">
    <h3>Your Order history is empty.</h3>
</div>
@endif