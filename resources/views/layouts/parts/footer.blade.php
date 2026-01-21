<div class="footer">
    <div class="footerOne">  
        <div class="footer-row1">
            <div class="subscribeRow">
                <p class="hd">subscribe</p> 
                <p class="mt10px" style="font-size:18px;">Be the first to get the latest news about trends, promotions, and much more!</p>
                <div class="subform">
                    <form id="newsletterForm" name="newsletterForm">
                    <input type="text" id="email_address" name="email_address" placeholder="Your email address" />
                    <button type="button" id="newsletterSubmit" class="viewallbtn btnCenter subbtn">Join Us</button>
                    </form>
                </div>
            </div>
            <div class="m-awardfooter">
                <div class="hdawd">awarded best nicotine pouch globally</div>
                <div class="awdllgo">
                    @php $awards = \App\Models\Award::where('status', 1)->orderBy('position','asc')->get(); @endphp
                    @foreach($awards as $award)
                    <img src="{{asset('storage/award/'.$award->image) }}" alt="{{$award->title}}"/>
                    @endforeach
                </div>
            </div>
            <div class="ftr-about shwoMobile mt30px">
                <p class="hd">About</p>
                <p><img src="{{ asset('images/Clew_logo_dark.svg') }}"/></p>
                <p>Welcome to CLEW, the ultimate nicotine experience designed for the modern consumer. Our nicotine pouches are crafted to deliver
                    enduring satisfaction with an ultra-smooth mouthfeel that sets a new standard in the industry.</p>
            </div>
        </div>
        <div class="footer-row2 mt20px shwoMobile">
            <ul class="accordion-list shwoMobile">
                <li class="foot1">
                    <h3 >Information</h3>
                    <div class="answer awer1" style="display:none;">
                        <ul class="footerSub">
                        {{-- <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('products') }}">The Clew Collection</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('blogs') }}">Blog</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li> --}}
                        <li><a href="{{ route('products') }}">The CLEW Collection</a></li> 
                        <li><a href="{{ route('blogs') }}">Blog</a></li>
                        <li><a href="{{ route('faq') }}">FAQs</a></li>
                        <li><a href="#">Shipping & Delivery</a></li>
                        <li><a href="#">Return</a></li> 
                        <li><a href="#">Privacy Policy</a></li> 
                        <li><a href="#">Terms & Conditions</a></li> 
                        </ul>
                    </div>
                </li>
                <li class="foot2">
                    <h3>Products</h3>
                    <div class="answer awer2" style="display:none;">
                    <ul class="footerSub">
                        <li><a href="{{ route('products') }}">The CLEW collection</a></li>
                        <li><a href="{{ route('cart') }}">cart</a></li>
                    </ul>
                    </div> 
                </li>
                @php $faqs = \App\Models\Faq::where('status', 1)->orderBy('position','asc')->get(); @endphp
                @if($faqs->count())
                <li class="foot3">
                    <h3>FAQ</h3>
                    <div class="answer awer3" style="display:none;">
                        @foreach($faqs as $faq)
                        <div class="footerQns">
                            <span>Q. {{ $faq->title }}</span>
                            <p>A. {{ $faq->description }}</p>
                        </div>
                        @endforeach
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="footertwo shwoMobile">
        <p><a href="{{ route('contact') }}" class="viewallbtn btnCenter" style="margin-top:20px;">contact us</a></p>
        <div class="glob mt20px">
            <i class="fa fa-map-marker"></i>
            <span>    
            <strong>NEVCORE INNOVATIONS</strong><br/>
            Corporation Trust Center, 1209<br>
            Orange Street, in the City of Wilmington,<br>
            Country of New Castle, Delaware,USA 19801
            </span>    
        </div>
        <div class="glob mt20px">
            <span><a href="mailto:enquiry@clewpouches.com"><img src="{{ asset('images/glob.png') }}" width="25"/> enquiry@clewpouches.com</a></span>
            <span class="sbb"><a href="mailto:customercare@clewpouches.com"><img src="{{ asset('images/msg.png') }}"/> customercare@clewpouches.com</a></span>
            <span class="sbb" style="display: none;"><a href="#"><img src="{{ asset('images/whatup.png') }}"/> 0(1234) 123456</a></span>
        </div>
        <div class="glob mt30px">
            <span>Secure payment</span>
            <span class="visa"><img src="{{ asset('images/visa-pay-icon.png') }}"/></span>
        </div>
    </div>

    <!--desktop version-->
    <div class="d-awardfooter">
        <div class="hdawd">awarded best nicotine pouch globally</div>
        <div class="awdllgo">
        @php $awards = \App\Models\Award::where('status', 1)->orderBy('position','asc')->get(); @endphp
            @foreach($awards as $award)
            <img src="{{asset('storage/award/'.$award->image) }}" alt="{{$award->title}}"/>
            @endforeach
            {{-- <img src="{{ asset('images/europe-awards.jpg') }}"/>
            <img src="{{ asset('images/africa-awards.jpg') }}"/>
            <img src="{{ asset('images/mena-awards.jpg') }}"/>
            <img src="{{ asset('images/sa-awards.jpg') }}"/>
            <img src="{{ asset('images/uk-awards.jpg') }}"/> --}}
        </div>
    </div>
    <div class="desktopFooter">
        <div class="deskBox">
            <p class="hd">About <img src="{{ asset('images/Clew_logo_dark.svg') }}" height="19" style="width: 65px !important;" width="65"/></p>
            <p>Welcome to CLEW, the ultimate nicotine experience designed for the modern consumer. Our nicotine pouches are crafted to deliver
            enduring satisfaction with an ultra-smooth mouthfeel that sets a new standard in the industry.</p>
        </div>
        <div class="deskBox">
            <p class="hd">Information</p>
            <ul>
                <li><a href="{{ route('products') }}">The CLEW Collection</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('blogs') }}">Blog</a></li>
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                <li><a href="{{ route('faq') }}">FAQs</a></li>
            </ul>
        </div>
        <div class="deskBox">
            <p class="hd">CUSTOMER SERVICES</p>
            <ul>
            @if(!Auth()->check())
                <li><a href="{{ route('login') }}">Login</a></li>
            @endif
                <li><a href="{{ route('shippingDelivery') }}">shipping &amp; delivery</a></li>
                <li><a href="{{ route('returns') }}">returns</a></li>
                <!-- <li><a href="#">loyalty points</a></li> -->
                <li><a href="#">age verification</a></li>
                <li><a href="{{ route('privacyPolicy') }}">privacy policy</a></li>
                <li><a href="{{ route('termsCondition') }}">terms & condition</a></li>
            </ul>
        </div>
        <div class="deskBox">
            <p class="hd">Contact us</p>
            <div>
                <span class="bdfr">
                    <i class="fa fa-map-marker"></i>
                    <div class="nevBx">
                    <strong>NEVCORE INNOVATIONS</strong><br/>
                    Corporation Trust Center, 1209<br>
                    Orange Street, in the City of Wilmington,<br>
                    Country of New Castle, Delaware,<br/> USA 19801
                    </div>
                </span>  
                <span><a href="mailto:enquiry@clewpouches.com"><img src="{{ asset('images/glob.png') }}"/> enquiry@clewpouches.com</a></span>
                <span><a href="mailto:customercare@clewpouches.com"><img src="{{ asset('images/msg.png') }}" style="width:36px;"/> customercare@clewpouches.com</a></span>
                <span style="display: none;"><a href="#"><img src="{{ asset('images/whatup.png') }}" style="width:36px;"/> 0(1234) 123456</a></span>
            </div>
        </div>
        <div class="deskBox">
            <p class="hd">Follow Us</p>
            <div class="fbox-4">
                {{-- <a href="https://www.facebook.com/Official.Clew" target="_blank" title="Facebook" aria-label="Facebook" style="height: 35px;"><img src="{{ asset('images/facebook.png') }}" alt="Facebook" width="35" height="35" srcset="{{ asset('images/facebook.png') }}"></a> --}}
                <a href="https://www.instagram.com/clewpouches.us" target="_blank" title="Instagram" aria-label="Instagram" style="height: 35px;"><img src="{{ asset('images/instagram.png') }}" alt="Instagram" width="35" height="35" srcset="{{ asset('images/instagram.png')}}"></a>
                <a href="https://www.linkedin.com/company/clewpouches" target="_blank" title="LinkedIn" aria-label="LinkedIn" style="height: 35px;"><img src="{{ asset('images/linkedin.png') }}" alt="LinkedIn" width="35" height="35" srcset="{{ asset('images/linkedin.png') }}"></a>
                {{-- <a href="https://www.youtube.com/channel/UC_QnIRpoQGygQ0ihQ7HgCeQ" target="_blank" title="YouTube" aria-label="YouTube" style="height: 35px;"><img src="{{ asset('images/youtube.png') }}" alt="Youtube" width="35" height="35" srcset="{{ asset('images/youtube.png') }}"></a>
                <a href="https://x.com/OfficialClew" target="_blank" title="X (Twitter)" aria-label="X (Twitter)" style="height: 35px;"><img src="{{ asset('images/twitter.png') }}" alt="Twitter" width="35" height="35" srcset="{{ asset('images/twitter.png') }}"></a> --}}
            </div>
        </div>

        <div class="deskBox">
            <p class="hd">secure payments</p>
            <p><img src="{{ asset('images/visa-pay-icon.png') }}" style="width:240px;"/></p>
        </div>
    </div>
    <!--desktop version-->
</div>

<div class="lowerFooter">Copyright © <?= date('Y') ?> CLEW Pouches | All rights reserved</div>