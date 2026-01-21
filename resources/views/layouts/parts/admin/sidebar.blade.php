<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard*')?'active':'' }}"><i class="fa fa-th-large"></i> <span>Dashboard</span></a></li>
                <li>
                    <a href="#home" data-toggle="collapse" class="{{ request()->is(['admin/ticker*','admin/banner*','admin/promise*','admin/process*','admin/award*','admin/country*','admin/state*'])?'active':'collapsed' }}"><i class="fa fa-dashboard"></i> <span>Home Management</span> <i class="icon-submenu fa fa-arrow-left"></i></a>
                    <div id="home" class="collapse {{ request()->is(['admin/ticker*','admin/banner*','admin/promise*','admin/process*','admin/award*','admin/country*','admin/state*'])?'in':'' }}">
                        <ul class="nav">
                            <li><a href="{{ route('admin.ticker.index') }}" class="{{ request()->is('admin/ticker*')?'active':'' }}">Ticker</a></li>
                            <li><a href="{{ route('admin.banner.index') }}" class="{{ request()->is('admin/banner*')?'active':'' }}">Banner</a></li>
                            <li><a href="{{ route('admin.promise.index') }}" class="{{ request()->is('admin/promise*')?'active':'' }}">Promise</a></li>
                            <li><a href="{{ route('admin.process.index') }}" class="{{ request()->is('admin/process*')?'active':'' }}">Process</a></li>
                            <li><a href="{{ route('admin.award.index') }}" class="{{ request()->is('admin/award*')?'active':'' }}">Award</a></li>
                            <li><a href="{{ route('admin.country.index') }}" class="{{ request()->is('admin/country*')?'active':'' }}">Country</a></li>
                            <li><a href="{{ route('admin.state.index') }}" class="{{ request()->is('admin/state*')?'active':'' }}">State</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#product" data-toggle="collapse" class="{{ request()->is(['admin/category*','admin/flavour*','admin/strength*','admin/label*','admin/product*'])?'active':'collapsed' }}"><i class="fa fa-briefcase"></i> <span>Product Management</span> <i class="icon-submenu fa fa-arrow-left"></i></a>
                    <div id="product" class="collapse {{ request()->is(['admin/category*','admin/flavour*','admin/strength*','admin/label*','admin/product*'])?'in':'' }}">
                        <ul class="nav">
                            {{--<li><a href="{{ route('admin.category.index') }}" class="{{ request()->is('admin/category*')?'active':'' }}">Category</a></li>--}}
                            <li><a href="{{ route('admin.flavour.index') }}" class="{{ request()->is('admin/flavour*')?'active':'' }}">Flavor</a></li>
                            <li><a href="{{ route('admin.strength.index') }}" class="{{ request()->is('admin/strength*')?'active':'' }}">Strength</a></li>
                            <li><a href="{{ route('admin.label.index') }}" class="{{ request()->is('admin/label*')?'active':'' }}">Label</a></li>
                            <li><a href="{{ route('admin.product.index') }}" class="{{ request()->is('admin/product*')?'active':'' }}">Product</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="{{ route('admin.coupon.index') }}" class="{{ request()->is('admin/coupon*')?'active':'' }}"><i class="fa fa-tag"></i> <span>Coupon Management</span></a></li>
                <li><a href="{{ route('admin.discount.index') }}" class="{{ request()->is('admin/discount*')?'active':'' }}"><i class="fa fa-tag"></i> <span>Discount Management</span></a></li>
                <li><a href="{{ route('admin.user.index') }}" class="{{ request()->is('admin/user*')?'active':'' }}"><i class="fa fa-users"></i> <span>Customer Management</span></a></li>
                <li><a href="{{ route('admin.order.index') }}" class="{{ request()->is('admin/order*')?'active':'' }}"><i class="fa fa-shopping-cart"></i> <span>Order Management</span></a></li>
                <li><a href="{{ route('admin.about.index') }}" class="{{ request()->is('admin/about*')?'active':'' }}"><i class="fa fa-file"></i> <span>About Management</span></a></li>
                <li><a href="{{ route('admin.page.index') }}" class="{{ request()->is('admin/page*')?'active':'' }}"><i class="fa fa-files-o"></i> <span>Page Management</span></a></li>
                <li><a href="{{ route('admin.press-release.index') }}" class="{{ request()->is('admin/press-release*')?'active':'' }}"><i class="fa fa-newspaper-o"></i> <span>Press Release Management</span></a></li>
                <li><a href="{{ route('admin.faq.index') }}" class="{{ request()->is('admin/faq*')?'active':'' }}"><i class="fa fa-question-circle"></i> <span>FAQ Management</span></a></li>
                <li><a href="{{ route('admin.store.index') }}" class="{{ request()->is('admin/store*')?'active':'' }}"><i class="fa fa-building"></i> <span>Store Management</span></a></li>
                <li>
                    <a href="#enquiry" data-toggle="collapse" class="{{ request()->is(['admin/contact*', 'admin/newsletter-subscription*'])?'active':'collapsed' }}"><i class="fa fa-sticky-note"></i> <span>Enquiries</span> <i class="icon-submenu fa fa-arrow-left"></i></a>
                    <div id="enquiry" class="collapse {{ request()->is(['admin/contact*', 'admin/newsletter-subscription*'])?'in':'' }}">
                        <ul class="nav">
                            <li><a href="{{ route('admin.contact') }}" class="{{ request()->is('admin/contact*')?'active':'' }}">Contact</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#setup" data-toggle="collapse" class="{{ request()->is(['admin/subadmin*', 'admin/website*', 'admin/change-password*'])?'active':'collapsed' }}"><i class="fa fa-cog"></i> <span>Set Up</span> <i class="icon-submenu fa fa-arrow-left"></i></a>
                    <div id="setup" class="collapse {{ request()->is(['admin/subadmin*', 'admin/website*', 'admin/change-password*'])?'in':'' }}">
                        <ul class="nav">
                            @if(auth()->user()->role_id==1)
                            <li><a href="{{ route('admin.subadmin.index') }}" class="{{ request()->is('admin/subadmin*')?'active':'' }}">Additional Admin</a></li>
                            <li><a href="{{ route('admin.website.index') }}" class="{{ request()->is('admin/website*')?'active':'' }}">Website</a></li>
                            @endif
                            <li><a href="{{ route('admin.changePassword') }}" class="{{ request()->is('admin/change-password*')?'active':'' }}">Change Password</a></li>
                            <li>
                                <a class="logoutNow" href="javascript:void(0)">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>