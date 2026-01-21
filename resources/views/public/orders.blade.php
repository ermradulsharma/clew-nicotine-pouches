@extends('layouts.app')
@section('content')
  @include('layouts.parts.warning')
  @include('layouts.parts.header', ['page'=>'orders'])
@include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
  <div style="background-color:#dee8f1;">
    <div class="orderDetail-container">
        <div class="headingRow">Orders</div>
        @include('public.parts.orderSection', ['orders'=>$orders])
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
					  <h1 class="mb-3">My Orders</h1>
            <div id="orderSection">
              @include('public.user.parts.orderSection', ['orders'=>$orders])
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="returnOrderModal" class="add_new_address">
      <div class="new_address_fom"><span class="close_address_box"></span>
        <div id="returnOrderFormSection"></div>
      </div>
    </div>
  </div>
  --}}
  
  @include('layouts.parts.footer')
@endsection