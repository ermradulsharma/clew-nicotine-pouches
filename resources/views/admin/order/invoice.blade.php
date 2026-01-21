@extends('layouts.admin')

@section('content')
<div class="container invoice">
  <div class="invoice-header">
    <div class="row">
      <div class="col-xs-8">
        <h1>Order Receipt</h1>
        <h4 class="text-muted"><strong> Order ID:</strong> {{ $order->id }} | Date: {{ date('d M Y', strtotime($order->created_at)) }}</h4>
      </div>
      <div class="col-xs-4">
        <div class="media">
          <ul class="media-body list-unstyled">
            <li><strong>NEVCORE INNOVATIONS</strong></li>
            <li>Corporation Trust Center</li>
            <li>1209 Orange Street, in the City of Wilmington,</li>
            <li>Country of New Castle, Delaware, USA 19801</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="invoice-body">
    <div class="row">
      <div class="col-xs-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <p><strong>Billing Details:</strong></p>
            <dl class="dl-horizontal">
              <dt>Name</dt>
              <dd>{{ $order->billing_name }}</dd>
              <dt>Address</dt>
              <dd>{{ $order->billing_address }}, {{ $order->billing_apartment }},<br />
              {{ $order->billing_city }}-{{ $order->billing_pincode }}, {{ $order->billing_state }}</dd>
          </div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <p><strong>Shipping Details:</strong></p>
            <dl class="dl-horizontal">
              <dt>Name</dt>
              <dd>{{ $order->name }}</dd>
              <dt>Address</dt>
              <dd>{{ $order->address }}, {{ $order->apartment }}<br />
              {{ $order->city }}-{{ $order->pincode }}, {{ $order->state }}</dd>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th class="text-center">Product Name</th>
            <th class="text-center">SKU Code</th>
            <th class="text-center colfix">Unit Cost</th>
            <th class="text-center colfix">Units</th>
            <th class="text-center colfix">Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->cart as $cart)
          <tr>
            <td>{{ $cart->product_name }} ({{$cart->variant_name}})</td>
            <td>{{ $cart->sku_code . '-' . strtoupper($cart->variant_name) }}</td>
            <td class="text-right">
              <span class="mono">${{ $cart->unit_price }}</span>
            </td>
            <td class="text-right">
              <span class="mono">{{ $cart->qty }} Unit(s)</span>
            </td>
            <td class="text-right">
              <span class="mono">${{ $cart->total_price }}</span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="panel panel-default">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <td class="text-center col-xs-1">Sub Total</td>
            <td class="text-center col-xs-1">Shipping Charge</td>
            <td class="text-center col-xs-1">Coupon Discount</td>
            <td class="text-center col-xs-1">Total Amount</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="text-center rowtotal mono">${{ $order->total }}</th>
            <th class="text-center rowtotal mono">${{ $order->shipping_total }}</th>
            <th class="text-center rowtotal mono">${{ $order->coupon_amount }}</th>
            <th class="text-center rowtotal mono">${{ $order->grand_total }}</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="invoice-footer">
    Thank you for choosing our services.
    <br/> We hope to see you again soon
    <br/>
    <strong>Clew</strong>
  </div>
</div>
@endsection
