@extends('layouts.app')
@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'stores'])

    <div id="clewstore"></div>
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div class="location-container">
        <div class="find-location-box">
            <div class="hdd">find clew near you</div>
            <div class="lo-form-box">
                <form id="storeSearchForm" name="storeSearchForm">
                    <div class="frm-one">
                        <select id="state" name="state" required>
                            <option value="">State</option> 
                            @foreach($states as $state)
                            <option value="{{$state->state}}">{{$state->state}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="frm-one">
                        <select id="city" name="city" required>
                            <option value="">City</option>
                        </select>
                    </div>
                    <div class="frm-one"><input type="text" id="pincode" name="pincode" placeholder="Pincode" onkeypress="return numbersonly(event);" maxlength="6"></div>
                    <div class="frm-one"><button type="button" id="storeSearch" class="searchBtn">Submit</button></div>
                    <div id="responseMsg">&nbsp;</div>
                </form>
            </div>
            <div class="showStore">
                <div class="showHd">store near you</div>
                <div id="storeList" class="storelist-box">
                    @foreach($stores as $store) 
                    @php $gmapAddress=urlencode($store->name."+".$store->address."+".$store->city."+".$store->state."+".$store->zip); @endphp
                    <div class="storelist">
                        <p class="s-h-d">
                        <a href="https://www.google.com/maps/dir/?api=1&origin=&destination={{$gmapAddress}}&travelmode=" target="_blank">
                        {{utf8_decode($store->name)}}
                        </a>
                        </p>
                        <p>{{utf8_decode($store->address)}}, {{utf8_decode($store->city)}}, {{utf8_decode($store->state)}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="map" class="mapBox"></div>
    </div>
    @push('google-maps-scripts')
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyBkh0MJV_FAoKEmmC5mKOwqb9sqoG-Fk8A&loading=async&callback=initMap"></script>
    @endpush
    @include('layouts.parts.footer')
@endsection
