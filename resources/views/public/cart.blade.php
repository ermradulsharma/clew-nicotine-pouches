@extends('layouts.app')

@section('content')
@include('layouts.parts.warning')
    @include('layouts.parts.header', ['page'=>'cart'])
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    {{-- <div class="homeSlider">
        <div><img src="images/cart-banner.jpg" class="w100"/></div>
    </div> --}}
    <div style="background-color:#dee8f1;"> 
        <div class="cart-container">
            <div class="headingRow">Your Cart</div>
            <div id="cartSection" class="cartCR">
                @include('public.parts.cartSection', ['carts'=>$carts])
            </div>
        </div>
    </div>
    {{-- {!! \Helper::buyPackDeal() !!} --}}
    {{-- <div class="buydeal-container">
        <div class="amountRow">
            @for($qty = 1; $qty<=3; $qty++)
            @php $discounts = \Helper::discount(1, 1, $qty*5); @endphp
            <div class="col">
                <p>buy {{$qty*5}}</p>
                <span>${{ $discounts["total_discount_amount"]?$discounts["total_discount_amount"]:$discounts["total_amount"]}}</span>
                <span>Save ${{ number_format($discounts["total_amount"]-$discounts["total_discount_amount"], 2) }}</span>
            </div>
            @endfor
        </div>
        <div class="w100 mt20px"><img src="{{asset('images/buy3img.png')}}" class="w100"/></div>
    </div> --}}
    <div style="padding:40px 0px 80px;">
        <div class="headingRow">You May Also Like</div>
        @php $products = \App\Models\Product::where('status', 1)->orderBy('position','asc')->get(); @endphp
        <div id="youMayLikeProducts" class="collection-slider-container">
            <div class="collection-productSlid">
                @include('public.parts.productBox', ['products' => $products])  
            </div>
        </div>
    </div>
    @include('layouts.parts.footer')
@endsection
{{-- @push('after-scripts')
<noscript><meta http-equiv="refresh" content="0; url=https://agechecker.net/noscript"></noscript>
<script>
    (function(w,d) {
        var config = {
            // key: "0ZvqAWM0Tg9doHLaQ5gowhPk0CZG9Mpc",
            key: "x5tJwxBjIM9J9ZdGOZKLkbeWyLHi7N1H",
            element: "#checkout_btn",
            fields: {
                first_name: ".agechecker #first_name",
                last_name: ".agechecker #last_name",
            },
            onpresubmit: function(data, done, cancel) {
                var webhookUrl = "/age-verification-webhook";
                var payload = {
                    customer: data.customer,
                    order: data.order
                };
                fetch(webhookUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                }).then(response => {
                    if (!response.ok) throw new Error("Webhook failed with status: " + response.status);
                    return response.json();
                }).then(result => {
                    if (result.allowVerification) {
                        done();
                    } else {
                        cancel();
                        const errorBox = document.querySelector('.invalidAge');
                        if (errorBox) {
                            errorBox.style.display = 'block';
                        }
                    }
                }).catch(error => {
                    cancel();
                });
            }
        };
        w.AgeCheckerConfig=config;
        if(config.path&&(w.location.pathname+w.location.search).indexOf(config.path)) return;
        var h=d.getElementsByTagName("head")[0];
        var a=d.createElement("script");
        a.src="https://cdn.agechecker.net/static/popup/v1/popup.js";
        a.crossOrigin="anonymous";
        a.onerror=function(a){
            w.location.href="https://agechecker.net/loaderror";
        };
        h.insertBefore(a,h.firstChild);
    })(window, document);
</script>
@endpush --}}