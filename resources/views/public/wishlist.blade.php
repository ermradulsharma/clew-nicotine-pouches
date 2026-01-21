@extends('layouts.app')
@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'wishlist'])
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div style="background-color:#dee8f1;">
         <div class="wishlistContainer">
            <div class="headingRow">Clew Wish List</div>
            <div class="emptyWishlist" style="text-align:left; margin-top:30px;">
            <div id="wishlistProducts">
              @include('public.parts.wishlistSection', ['wishlists'=>$wishlists])
            </div>
            </div>
         </div>
    </div>
  @include('layouts.parts.footer')
@endsection