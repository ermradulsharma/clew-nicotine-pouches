<div class="headerCnt">
    <div class="logo"><a href="{{ route('home') }}"><img src="{{asset('images/Clew_logo_white.svg')}}"/></a></div>
    <div id="searchBox-d" class="desktopsearch">
        <input id="searchDKey" type="text" value="" placeholder="Search product.." autocomplete="off">
        <button id="searchDSubmit"><img src="{{asset('images/search-icon.png')}}"/></button>
        <div id="search-results"></div>
    </div>
    <div class="hRight">
        <div class="tleft">
            <div class="searchbx"><img src="{{asset('images/search-icon.png')}}" id="search-b-c"/></div>
            @php $cartItems = \App\Models\CartTemp::where('session_id', session()->getId())->count(); @endphp
            <div id="cartIcon" class="cartRow">
              <a href="{{route('cart')}}">
                <img src="{{asset('images/cart-icon.png')}}"/>
                <strong>@if($cartItems)<span>{{ $cartItems }}</span>@endif</strong>
              </a>
            </div>
            @if(Auth()->check())
            <div class="userbx"><a><img src="{{asset('images/user-icon.png')}}"/></a>
                <div class="userop" style="display:none;">
                  <ul>
                    <li><a href="{{ route('profile') }}"><i class="fa fa-user-circle-o"></i>Profile</a></li>
                    <li><a href="{{ route('addresses') }}"><i class="fa fa-address-book"></i>Addresses</a></li>
                    <li><a href="{{ route('orders') }}"><i class="fa fa-shopping-bag"></i>Orders</a></li>
                    <li><a href="{{ route('wishlist') }}"><i class="fa fa-heart"></i>Wishlist</a></li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </li>
                  </ul>
                </div>
            </div>
            @else
            <div class="userbx"><a href="{{route('login')}}"><img src="{{asset('images/user-icon.png')}}"/></a></div>
            @endif
        </div>
        <div class="tright">
            <div class="burger" id="burger">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </div>
            <div class="navbar-block" id="menu">
                <ul class="menu">
                    <li class="menu-item"><a class="menu-link {{ ($page=='home')?'active':'' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="menu-item"><a class="menu-link {{ ($page=='about')?'active':'' }} " href="{{ route('about') }}">About Us</a></li>
                    <li class="menu-item"><a class="menu-link {{ ($page=='products')?'active':'' }} " href="{{ route('products') }}">Products</a></li>
                    <li class="menu-item"><a class="menu-link {{ ($page=='contact')?'active':'' }}" href="{{ route('contact') }}">Contact Us</a></li>
                    <li class="menu-item"><a class="menu-link {{ ($page=='blogs')?'active':'' }}" href="{{ route('blogs') }}">Blogs</a></li>
                    <li class="menu-item"><a class="menu-link {{ ($page=='press-release')?'active':'' }}" href="{{ route('pressRelease') }}">Press Release</a></li>
                    <li class="menu-item"><a class="menu-link {{ ($page=='stores')?'active':'' }}" href="{{ route('stores') }}">Store Locator</a></li>
                    @if(!Auth()->check())
                    <div class="menuLogrow">
                        <a href="{{route('login')}}" title="Login">Login</a>
                        <a href="{{route('register')}}">Sign Up</a>
                    </div>
                    @endif
                </ul>
            </div>
        </div>
    </div>
<!--searchbox open--->
<div id="searchBox-r" class="searchRow" style="display:none;">
    <div id="form-search">
        <input id="searchKey" type="text" value="" placeholder="Search.." autocomplete="off">
        <button id="searchSubmit">Search</button>
        <span id="searchboxHide">&#10005;</span>
    </div>
    <div id="search-results"></div>
</div>
<!--searchbox close--->
</div>