@if(count($userAddresses))
    <p class="shd mt20px">Delivery addressess ({{count($userAddresses)}})</p>
    @foreach($userAddresses as $userAddress)
    <div class="deliverySelectBox">
        <div id="address-bar-{{$userAddress->id}}" address-id="{{$userAddress->id}}" class="add-dtl radio">
            <input type="radio" id="address-{{$userAddress->id}}" address-id="{{$userAddress->id}}" {{($userAddress->preferred)?'checked':''}}/>
            <label for="address-{{$userAddress->id}}" class="nms">
            <span>{{$userAddress->name}}</span>
            {{$userAddress->address}}, 
            {{$userAddress->city}}, {{$userAddress->state}} - {{$userAddress->pincode}}, {{$userAddress->country}}
            <br>Email ID : {{$userAddress->email}}&nbsp;|&nbsp;
            Mobile No : {{$userAddress->mobile}}
            </label>
        </div>
        @if($page=="addresses")
        <p><a href="#" class="whitebtn btnCenter mt10px edit_address" tabindex="0" address-id="{{$userAddress->id}}">Edit address</a></p>
        <p><a href="#" class="bluebtn btnCenter mt10px delete_address" tabindex="0" address-id="{{$userAddress->id}}">Delete address</a></p>
        @else
        <p><a href="#" class="bluebtn btnCenter mt10px" tabindex="0" address-id="{{$userAddress->id}}">Deliver to this address</a></p>
        <p><a href="#" class="whitebtn btnCenter mt10px edit_address" tabindex="0" address-id="{{$userAddress->id}}">Edit address</a></p>
        @endif
    </div>
    @endforeach
@else
<div class="empty-addressbook">
    <img src="{{ asset('images/address-add.jpg') }}" />
    <h3>You haven't added any address.</h3>
    <p>Please add a new address.</p>
</div>
@endif