@php $website = \App\Models\Website::find(1); @endphp
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="brand">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{asset('storage/website')}}/{{$website->logo}}" alt="" class="img-responsive logo">
        </a>
    </div>
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="fa fa-bars" aria-hidden="true"></i></button>
        </div>
        <div id="navbar-menu">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    @guest
                    <a href="{{ route('admin.login') }}"><i class="lnr lnr-user"></i> <span>{{ __('Login') }}</span></a>
                    @else
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    <span>{{ Auth::user()->name }}</span> <i class="icon-submenu fa fa-arrow-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.changePassword') }}"><i class="fa fa-cog"></i> <span>{{ __('Change Password') }}</span></a></li>
                        <li><a class="logoutNow" href="javascript:void(0)"><i class="fa fa-sign-out"></i> <span>{{ __('Logout') }}</span></a></li>
                    </ul>
                    @endguest
                </li>
            </ul>
        </div>
    </div>
</nav>
<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">@csrf</form>