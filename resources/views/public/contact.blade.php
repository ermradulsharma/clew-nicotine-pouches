@extends('layouts.app')

@section('content')
    @include('layouts.parts.warning')
    @include('layouts.parts.header', ['page' => 'contact'])
    @include('public.parts.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div style="background-color:#dee8f1; padding: 2.5rem;">
        <div class="headingRow">Contact Us</div>
        <div class="contact-container">
            <div class="contactLeft">
                {{-- <div class="contact-adress">
                    <span><i class="fa fa-map-marker"></i></span>
                    <p><span> NEVCORE INNOVATIONS</span>
                        Corporation Trust Center,<br />1209 Orange
                        Street, in the City of Wilmington,<br />Country
                        of New Castle, Delaware, USA 19801</p>
                </div> --}}
                <div class="glob mt10px">
                    <span><a href="https://www.clewpouches.com" target="_blank" rel="noopener noreferrer"><img src="{{ asset('images/internet.png') }}"> www.clewpouches.com</a></span>
                    <span><a href="mailto:enquiry@clewpouches.com"><img src="{{ asset('images/glob.png') }}"/> enquiry@clewpouches.com</a></span>
                    <span><a href="mailto:customercare@clewpouches.com"><img src="{{ asset('images/msg.png') }}" style="width:36px;"/> customercare@clewpouches.com</a></span>
                </div>
                <div class="glob mt10px" style="display: none;">
                    <span><i class="fa fa-phone" style="font-size:25px;"></i></span>
                    <span class="sbb"><a href="tel:0(1234) 123456">0(1234) 123456</a></span>
                </div>

                <div class="contact-social">
                    <p>Follow Us</p>
                    <div class="fbox-4">
                        {{-- <a href="https://www.facebook.com/Official.Clew" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a> 
                    <a href="https://www.instagram.com/official.clew" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/clewpouches" target="_blank" title="Instagram"><i class="fa fa-linkedin"></i></a>
                    <a href="https://www.youtube.com/channel/UC_QnIRpoQGygQ0ihQ7HgCeQ" target="_blank" title="Youtube"><i class="fa fa-youtube-play"></i></a>
                    <a href="https://x.com/OfficialClew" target="_blank" title="X"><i class="fa fa-x">X</i></a> --}}
                        {{-- <a href="https://www.facebook.com/Official.Clew" target="_blank" title="Facebook" aria-label="Facebook" style="height: 35px;"><img src="{{ asset('images/facebook.png') }}" alt="Facebook" width="35" height="35" srcset="{{ asset('images/facebook.png') }}"></a> --}}
                        <a href="https://www.instagram.com/clewpouches.us" target="_blank" title="Instagram"
                            aria-label="Instagram" style="height: 35px;"><img src="{{ asset('images/instagram.png') }}"
                                alt="Instagram" width="35" height="35"
                                srcset="{{ asset('images/instagram.png') }}"></a>
                        <a href="https://www.linkedin.com/company/clewpouches" target="_blank" title="LinkedIn"
                            aria-label="LinkedIn" style="height: 35px;"><img src="{{ asset('images/linkedin.png') }}"
                                alt="LinkedIn" width="35" height="35"
                                srcset="{{ asset('images/linkedin.png') }}"></a>
                        {{-- <a href="https://www.youtube.com/channel/UC_QnIRpoQGygQ0ihQ7HgCeQ" target="_blank" title="YouTube" aria-label="YouTube" style="height: 35px;"><img src="{{ asset('images/youtube.png') }}" alt="Youtube" width="35" height="35" srcset="{{ asset('images/youtube.png') }}"></a>
                    <a href="https://x.com/OfficialClew" target="_blank" title="X (Twitter)" aria-label="X (Twitter)" style="height: 35px;"><img src="{{ asset('images/twitter.png') }}" alt="Twitter" width="35" height="35" srcset="{{ asset('images/twitter.png') }}"></a> --}}
                    </div>
                </div>
            </div>

            <div class="contactRight">
                <div class="contact-form">
                    <p class="imf">*Indicates mandatory fields</p>
                    <form id="contactUsForm" name="contactUsForm">
                        <div class="colR">
                            <p>Name*</p>
                            <div class="colf">
                                <input type="text" id="first_name" name="first_name" placeholder="First Name" />
                                <input type="text" id="last_name" name="last_name" placeholder="Last Name" />
                            </div>
                            <span></span>
                        </div>
                        <div class="colR">
                            <p>enquiry Type*</p>
                            <select id="enquiry_type" name="enquiry_type" required>
                                <option value="">Enquiry Type*</option>
                                <option value="Business">Business</option>
                                <option value="Individual">Individual</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="colR">
                            <p>Email*</p>
                            <input type="text" id="email" name="email" placeholder="Email" />
                            <span></span>
                        </div>
                        <div class="colR">
                            <p>Phone no.*</p>
                            <div class="colS">
                                <input type="text" id="country_code" name="country_code" placeholder="Country Code" />
                                <input type="text" id="phone_no" name="phone_no" placeholder="Phone no."
                                    onkeypress="return numbersonly(event);" maxlength="10" />
                            </div>
                            <span></span>
                        </div>
                        <div class="colR">
                            <p>message*</p>
                            <textarea id="message" name="message" placeholder="Message"></textarea>
                            <span></span>
                        </div>
                        <div class="colR mt10px"><button type="submit" id="contactUsSubmit" class="bluebtn">Submit</button>
                        </div>
                        <div id="responseMsg" style="color:#FF0000;">&nbsp;</div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    @include('layouts.parts.footer')
@endsection
