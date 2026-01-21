<div class="frows checkrow">
    <div class="frows-in" style="width:100%;">
        <select id="country" name="country" required>
            <option value="">Country*</option>
            @php $countries = \App\Models\Country::where('status', 1)->get(); @endphp
            @foreach($countries as $country)
            <option value="{{ $country->id }}" {{($userAddress)?(($userAddress->country_id==$country->id)?'selected':''):''}}>{{ $country->title }}</option>
            @endforeach
        </select>
        <span></span>
    </div>
</div>
<div class="frows checkrow">
    <div class="frows-in">
    <input type="text" id="first_name" name="first_name" value="{{($userAddress)?$userAddress->first_name:''}}" placeholder="First Name*"><span></span>
    </div>
    <div class="frows-in">
    <input type="text" id="last_name" name="last_name" value="{{($userAddress)?$userAddress->last_name:''}}" placeholder="Last Name*"><span></span>
    </div>
</div>
<div class="frows">
    <input type="text" id="address" name="address" value="{{($userAddress)?$userAddress->address:''}}" placeholder="Street Address*"><span></span>
</div>
<div class="frows">
    <input type="text" id="apartment" name="apartment" value="{{($userAddress)?$userAddress->apartment:''}}" placeholder="Apartment/Unit*"><span></span>
</div>
<div class="myloc">Use My Location <i class="fa fa-map-marker"></i></div>
<div class="frows"><input type="text" id="pincode" name="pincode" value="{{($userAddress)?$userAddress->pincode:''}}" placeholder="Pincode*" onkeypress="return numbersonly(event)" maxlength="6"><span></span></div>
<div class="frows checkrow">
    <div class="frows-in">
        <select id="state" name="state" required>
            <option value="">State*</option>
            @if($userAddress)
            @php $states = \App\Models\State::where('country_id', $userAddress->country_id)->where('status', 1)->get(); @endphp
            @foreach($states as $state)
            <option value="{{ $state->id }}" {{($userAddress)?(($userAddress->state_id==$state->id)?'selected':''):''}}>{{ $state->title }}</option>
            @endforeach
            @endif
        </select>
        <span></span>
    </div>
    <div class="frows-in">
    <input type="text" id="city" name="city" placeholder="City*" value="{{($userAddress)?$userAddress->city:''}}" /><span></span>
    </div>
</div>
<div class="frows"><input type="text" id="mobile" name="mobile" value="{{($userAddress)?$userAddress->mobile:''}}" placeholder="Mobile number*" onkeypress="return numbersonly(event)" maxlength="10"><span></span></div>
<div class="button mt20px">
    <input type="hidden" id="id" name="id" value="{{($userAddress)?$userAddress->id:''}}"/>
    <button id="addressSave" type="button" class="bluebtn btnCenter" style="height:50px; width:100%;">Save</button>
</div>