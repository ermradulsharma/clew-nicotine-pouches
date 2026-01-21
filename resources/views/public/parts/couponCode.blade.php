<form id="couponCodeForm" name="couponCodeForm">
    <div class="copuoncode">
        <input type="text" id="couponCode" name="couponCode" value="{{($couponData)?$couponData->coupon_code:''}}" placeholder="Enter Coupon code" {{($couponData)?'disabled':''}}>
        <button type="button" id="couponCodeBtn" class="couponCheck {{($couponData)?'':'btnBlue'}}">{{($couponData)?'Remove':'Apply'}}</button>
    </div>
</form>