@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page' => 'checkout'])
    <!--
        <div class="homeSlider">
            <div><img src="{{ asset('images/login-banner.jpg') }}" class="w100"/></div>
        </div>
         -->

    <div id="checkoutSection" style="background-color:#dee8f1; padding:40px 0px;">
        <div class="headingRow">Checkout</div>
        <div class="checkout-container mt30px">
            <!--left container open-->
            <div class="checkoutContainer-left">
                <form id="checkoutForm" name="checkoutForm">
                    <div class="col-f">
                        <p class="hdcheck">Customer Name</p>
                        <div class="loginform">
                            <div class="frows checkrow">
                                <div class="frows-in">
                                    <input type="text" id="first_name" name="first_name" placeholder="First Name *" value="{{ $checkout ? $checkout->first_name : auth()->user()->first_name }}" />
                                    <span></span>
                                </div>
                                <div class="frows-in">
                                    <input type="text" id="last_name" name="last_name" placeholder="Last Name *" value="{{ $checkout ? $checkout->last_name : auth()->user()->last_name }}" />
                                    <span class="error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-f mt30px">
                        <p id="checkoutAddressBtn" class="hdcheck">Shipping Details <span>*Indicates mandatory fields</span>
                        </p>
                        <div id="checkoutAddressSection">
                            <div class="loginform">
                                <div class="frows"><input type="text" id="address" name="address" placeholder="Address *" value="{{ $checkout ? $checkout->address : '' }}" /><span></span></div>
                                <div class="frows"><input type="text" id="apartment" name="apartment" placeholder="Apartment *" value="{{ $checkout ? $checkout->apartment : '' }}" /><span></span></div>
                                <div class="frows checkrow">
                                    <div class="frows-in">
                                        <select name="country" id="country" required>
                                            <option value="">Country *</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" {{ $checkout ? ($checkout->country_id == $country->id ? 'selected' : '') : '' }}>{{ $country->title }}</option>
                                            @endforeach
                                        </select>
                                        <span></span>
                                    </div>
                                    <div class="frows-in">
                                        <select name="state" id="state" required>
                                            <option value="">State *</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}" {{ $checkout ? ($checkout->state_id == $state->id ? 'selected' : '') : '' }}>{{ $state->title }}</option>
                                            @endforeach
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                                <div class="frows checkrow">
                                    <div class="frows-in">
                                        <input type="text" id="city" name="city" placeholder="City *" value="{{ $checkout ? $checkout->city : '' }}" />
                                        <span></span>
                                    </div>
                                    <div class="frows-in">
                                        <input type="text" id="pincode" name="pincode" placeholder="Pincode *" onkeypress="return numbersonly(event)" maxlength="6" value="{{ $checkout ? $checkout->pincode : '' }}" />
                                        <span></span>
                                    </div>
                                </div>
                                <div class="frows checkrow">
                                    <div class="frows-in">
                                        <input type="text" id="mobile" name="mobile" placeholder="Mobile No. *" onkeypress="return numbersonly(event)" maxlength="10" value="{{ $checkout ? $checkout->mobile : '' }}" />
                                        <span></span>
                                    </div>
                                    <div class="frows-in">
                                        <input type="text" id="dob" name="dob" placeholder="DOB *" value="{{ $checkout ? $checkout->dob : '' }}" readonly />
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="makedef"><input type="checkbox" id="defaddress"/> <label for="defaddress">Make this my default address</label></div> --}}

                            <div class="billadd">
                                <strong>Billing address</strong>
                                <small><input type="checkbox" id="samebilling" name="samebilling" value="1"
                                        {{ $checkout_id ? ($checkout->samebilling ? 'checked' : '') : 'checked' }} /> <label
                                        for="samebilling">Same as Shipping Address</label></small>
                            </div>

                            <div id="billingDetailsSection"
                                style="display:{{ $checkout_id ? ($checkout->samebilling ? 'none' : 'block') : 'none' }};">
                                <p class="hdcheck mt30px">Billing Details</p>
                                <div class="loginform">
                                    <div class="frows checkrow">
                                        <div class="frows-in">
                                            <input type="text" id="billing_first_name" name="billing_first_name"
                                                placeholder="First Name *"
                                                value="{{ $checkout ? $checkout->billing_first_name : '' }}" /><span></span>
                                        </div>
                                        <div class="frows-in">
                                            <input type="text" id="billing_last_name" name="billing_last_name"
                                                placeholder="Last Name *"
                                                value="{{ $checkout ? $checkout->billing_last_name : '' }}" /><span
                                                class="error"></span>
                                        </div>
                                    </div>
                                    <div class="frows"><input type="text" id="billing_address"
                                            name="billing_address" placeholder="Address *"
                                            value="{{ $checkout ? $checkout->billing_address : '' }}" /><span></span></div>
                                    <div class="frows"><input type="text" id="billing_apartment"
                                            name="billing_apartment" placeholder="Apartment *"
                                            value="{{ $checkout ? $checkout->billing_apartment : '' }}" /><span></span>
                                    </div>
                                    <div class="frows checkrow">
                                        <div class="frows-in">
                                            <select name="billing_country" id="billing_country" required>
                                                <option value="">Country *</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $checkout ? ($checkout->billing_country_id == $country->id ? 'selected' : '') : '' }}>
                                                        {{ $country->title }}</option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                        <div class="frows-in">
                                            <select name="billing_state" id="billing_state" required>
                                                <option value="">State *</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ $checkout ? ($checkout->billing_state_id == $state->id ? 'selected' : '') : '' }}>
                                                        {{ $state->title }}</option>
                                                @endforeach
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="frows checkrow">
                                        <div class="frows-in">
                                            <input type="text" id="billing_city" name="billing_city"
                                                placeholder="City *"
                                                value="{{ $checkout ? $checkout->billing_city : '' }}" /><span></span>
                                        </div>
                                        <div class="frows-in">
                                            <input type="text" id="billing_pincode" name="billing_pincode"
                                                placeholder="Pincode *" onkeypress="return numbersonly(event)"
                                                maxlength="6"
                                                value="{{ $checkout ? $checkout->billing_pincode : '' }}" /><span></span>
                                        </div>
                                    </div>
                                    <div class="frows"><input type="text" id="billing_mobile" name="billing_mobile"
                                            placeholder="Mobile No. *" onkeypress="return numbersonly(event)"
                                            maxlength="10"
                                            value="{{ $checkout ? $checkout->billing_mobile : '' }}" /><span></span></div>
                                </div>
                            </div>

                            <div class="mt30px">
                                <input type="hidden" id="id" name="id"
                                    value="{{ $checkout_id ? $checkout_id : '' }}" />
                                <div class="button"><button type="button" id="checkoutSubmit" class="bluebtn btnCenter"
                                        style="height:50px; width:100%;">Deliver Here</button></div>
                            </div>
                        </div>
                    </div>
                </form>

                <div id="deliveryMethod" class="col-f mt30px">
                    <p id="deliveryMethodBtn" class="hdcheck">Shipping Methods</p>
                    <div id="deliveryMethodSection" style="display:none;">
                        <div class="dM-rows mt30px">
                            <div class="rowsleft" style="padding-bottom:15px;">
                                <input type="radio" id="standard" name="shipping_method" class="shippingMethod"
                                    value="standard"
                                    {{ $checkout_id ? ($checkout->shipping_method == 'standard' ? 'checked' : '') : 'checked' }} />
                                <p>Standard Delivery</p>
                                <span>Get it by {{ now()->addDays(7)->format('d M') }} -
                                    {{ now()->addDays(10)->format('d M') }}</span>
                            </div>
                            <div class="pric">Free</div>
                        </div>
                        <div class="dM-rows">
                            <div class="rowsleft">
                                <input type="radio" id="usps_mail" name="shipping_method" class="shippingMethod"
                                    value="usps_mail"
                                    {{ $checkout_id ? ($checkout->shipping_method == 'usps_mail' ? 'checked' : '') : '' }} />
                                <p>USPS Priority Mail <img src="{{ asset('images/usps.jpg') }}" alt="" /></p>
                            </div>
                            <div class="pric">$13.05</div>
                        </div>
                        <div class="dM-rows">
                            <div class="rowsleft">
                                <input type="radio" id="ups_ground" name="shipping_method" class="shippingMethod"
                                    value="ups_ground"
                                    {{ $checkout_id ? ($checkout->shipping_method == 'ups_ground' ? 'checked' : '') : '' }} />
                                <p>UPS Ground <img src="{{ asset('images/ups.jpg') }}" alt="" /></p>
                            </div>
                            <div class="pric">$15.09</div>
                        </div>
                        <div class="dM-rows" style="border-bottom:none;">
                            <div class="rowsleft">
                                <input type="radio" id="ups_air" name="shipping_method" class="shippingMethod"
                                    value="ups_air"
                                    {{ $checkout_id ? ($checkout->shipping_method == 'ups_air' ? 'checked' : '') : '' }} />
                                <p>UPS Next Day Air <img src="{{ asset('images/ups.jpg') }}" alt="" /></p>
                            </div>
                            <div class="pric">$14.95</div>
                        </div>
                    </div>
                </div>

                @php
                    $shipping_price = $checkout_id ? $checkout->shipping_price : 0;
                    $grand_total = number_format(
                        $carts->sum('total_discount_amount') + $shipping_price - $couponDiscount,
                        2,
                    );
                @endphp

                <!---payment option open--->
                <div id="paymentMethod" class="col-f mt30px">
                    <p id="paymentMethodBtn" class="hdcheck">Payment Method</p>
                    <div id="paymentMethodSection" class="payment-option-cnt" style="display:none;">
                        <ul class="payacord">
                            <li><!--<h3 class="payac1">Credit card</h3>
                                <div class="answer an1" style="display:none;"> -->
                                {{-- <div class="answer an1"> --}}
                                <div id="autherizePayment">
                                    <form id="payment-form">
                                        {{-- @csrf --}}
                                        {{-- <div id="payment-element">
                                        @include('public.parts.paymentSection', ['carts'=>$carts, 'shipping_price'=>$shipping_price, 'couponDiscount'=>$couponDiscount])
                                    </div> --}}
                                        <div id="payment-element" >
                                            @include('public.parts.authorizePaymentSection', [
                                                'carts' => $carts,
                                                'shipping_price' => $shipping_price,
                                                'couponDiscount' => $couponDiscount,
                                            ])
                                        </div>
                                        <div class="text-center">
                                            <div class="button"><button id="submit" type="submit" class="bluebtn btnCenter" style="height:50px; width:100%; margin-top:20px;">Place Order</button>
                                            </div>
                                        </div>
                                        <div id="error-message" style="color:#e74c3c;"></div>
                                        <p class="error" style="text-align: left; color:#df1b41" id="tncerror"></p>
                                    </form>
                                    {{-- <div class="card-wrapper"></div> --}}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!---payment option close--->
            </div>
            <!--left container close-->

            <!--right container open-->
            <div class="checkoutContainer-right">
                <div class="orderSummary-bx">
                    <p class="hdcheck" style="border-bottom:1px solid #000; padding-bottom:10px;">Order Summary</p>
                    @foreach ($carts as $cart)
                        <div class="cartproductRow mt10px">
                            <div class="pImg"><img src="{{ asset('storage/product/thumb/' . $cart->product_image) }}">
                            </div>
                            <div class="cp-des">
                                <div class="proname">{{ $cart->product->title }}
                                    ({{ $cart->productVariant->strength->title }})</div>
                                <div class="proDis">
                                    <div class="pri">${{ $cart->total_discount_amount }}
                                        <small>Unit(s):{{ $cart->qty }}</small></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="priceSection" class="check-price-row">
                    @include('public.parts.priceSection', [
                        'carts' => $carts,
                        'shipping_price' => $shipping_price,
                        'couponDiscount' => $couponDiscount,
                    ])
                </div>
                <div class="check-eb">
                    <a href="{{ route('cart') }}" title="Edit Order">Edit Order</a>
                    <a href="{{ route('cart') }}" title="Back to Cart">Back to Cart</a>
                </div>
                <div class="cdtl">
                    <p>Estimated delivery between <strong>{{ now()->addDays(7)->format('d M') }} -
                            {{ now()->addDays(10)->format('d M') }}</strong></p>
                    <p><i class="fa fa-map-marker"></i> Deliver to
                        {{ $checkout ? $checkout->first_name : auth()->user()->first_name }}</p>
                </div>
                <!-- <div class="button"><button type="button" class="bluebtn btnCenter" style="height:50px; width:100%;">Place Order</button></div> -->
                <!--  <p class="tc mt20px" style="font-size:14px;">You'll be securely redirected to Visa to enter your password and complete your purchase.</p> -->
            </div>
            <!--right container close-->
        </div>
    </div>
    <div class="invalidAge" style="display: none;">
        <div class="invalidAgeWrap">
            <span class="close">x</span>
            <div class="content">Sorry, Your age does not permit you to enter this website.</div>
        </div>
    </div>
    @include('layouts.parts.footer')
@endsection

@push('after-scripts')
<script>
    var form = document.getElementById('payment-form');
    var submitBtn = document.getElementById('submit');
    var handleError = (error) => {
        const messageContainer = document.querySelector('#error-message');
        messageContainer.textContent = error.message;
        submitBtn.disabled = false;
    }
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        var first_name = document.getElementById("first_name").value;
        var address = document.getElementById("address").value;
        var city = document.getElementById("city").value;
        var stateEl = document.getElementById("state");
        var state = stateEl.selectedIndex !== -1 ? stateEl.options[stateEl.selectedIndex].text : '';
        var countryEl = document.getElementById("country");
        var country = countryEl.options[countryEl.selectedIndex].text;
        var postal_code = document.getElementById("pincode").value;
        var cardNumber = document.getElementById("cardNumber").value;
        var expiry = document.getElementById("expiry").value;
        var cvc = document.getElementById("cvc").value;
        var first_name = document.getElementById("first_name").value;
        var last_name = document.getElementById("last_name").value;

        const formData = {
            first_name,
            address,
            city,
            state,
            country,
            postal_code,
            cardNumber,
            expiry,
            cvc,
            first_name,
            last_name,
        };

        try {
            const response = await fetch('{{ route('paymentStore') }}', {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const result = await response.json();
            console.log(result.status);
            
            if (result.status === 200) {
                window.location.href = "{{ route('orderPlaced') }}";
                return false;
            } else {
                window.location.href = "{{ route('orderCancelled') }}";
            }
            // window.location.href = "{{ route('orderCancelled') }}";
        } catch (error) {
            console.error('Error submitting form:', error);
        }
    });
</script>
@endpush
