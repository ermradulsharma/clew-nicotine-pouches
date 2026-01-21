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