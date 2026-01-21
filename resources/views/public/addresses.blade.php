@extends('layouts.app')
@section('content')
  @include('layouts.parts.warning')
  @include('layouts.parts.header', ['page'=>'user'])
@include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
  <div class="customer-address-container">
    <div class="customer-add-left">
      <div class="wishlistContainer">
        <div class="headingRow">Address</div>
        <div class="deliverySelect">
          <div id="addressSection">
            @include('public.parts.addressSection', ['page'=>'addresses','userAddresses'=>$userAddresses])
          </div>
        </div>
      </div>
    </div>
    <div class="cart-container customer-add-right">
      <p class="bhd">Add address</p>
      <div class="loginform">
        <form id="addressForm" name="addressForm">
          @include('public.parts.addressForm', ['page'=>'addresses','userAddress'=>''])
        </form>
      </div>
    </div>
  </div>

  @include('layouts.parts.footer')
@endsection