@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    
    @include('layouts.parts.header', ['page'=>'search'])

    <div class="product-list-container">
        <div id="productListing" class="product-listing-container" style="width:100%;">
            <div class="totalitem">Search Keyword: {{ $searchKey }}</div>
            <div id="productListBox" class="product-showlist">
                @include('public.parts.productBox', ['products'=>$products])
            </div>
        </div>  
    </div>

    @include('layouts.parts.footer')
@endsection
