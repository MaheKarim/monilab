<header class="d-sidebar">
    <div class="header-navbar">
        <div class="navbar-toggle">
            <div class="nav-header">
                <ul class="list-group menu text-center" id="menu">
                    <li class="list-group-item {{menuActive('user.home')}}"><a href="{{ route('user.home') }}"><span><i class="fas fa-tachometer-alt"></i>@lang('Dashboard')</span></a></li>
                    <li class="list-group-item menu_has_children"><a href="#0"><span><i class="fas fa-credit-card"></i>@lang('Deposit')</span></a>
                        <ul class="sub-menu {{menuActive('user.deposit*',2)}}">
                            <li class="{{menuActive('user.deposit.index')}}"><a href="{{ route('user.deposit.index') }}"><i class="far fa-stop-circle"></i>@lang('Deposit Now')</a></li>
                            <li class="{{menuActive('user.deposit.history')}}"><a href="{{route('user.deposit.history')}}"><i class="far fa-stop-circle"></i>@lang('Deposit History')</a></li>
                        </ul>
                    </li>
                    <li class="list-group-item {{menuActive('user.advertise*')}}"><a href="{{ route('user.advertise.index') }}"><span><i class="las la-ad"></i>@lang('Advertise')</span></a></li>
                    <li class="list-group-item menu_has_children"><a href="#0"><span><i class="fab fa-bitcoin"></i>@lang('Hyip')</span></a>
                        <ul class="sub-menu {{menuActive('user.hyip*',2)}}">
                            <li class="{{menuActive('user.hyip.new')}}"><a href="{{route('user.hyip.new')}}"><i class="far fa-stop-circle"></i>@lang('New Hyip')</a></li>
                            <li class="{{menuActive('user.hyip.index')}}"><a href="{{ route('user.hyip.index') }}"><i class="far fa-stop-circle"></i>@lang('My Hyips')</a></li>
                            <li class="{{menuActive('user.hyip.update.pending')}}"><a href="{{route('user.hyip.update.pending')}}"><i class="far fa-stop-circle"></i>@lang('Pending Update')</a></li>
                        </ul>
                    </li>
                    <li class="list-group-item {{menuActive('user.profile.setting')}}"><a href="{{ route('user.profile.setting') }}"><span><i class="fas fa-user-alt"></i>@lang('Profile')</span></a></li>
                    <li class="list-group-item {{menuActive('user.twofactor*')}}"><a href="{{ route('user.twofactor') }}"><span><i class="fas fa-shield-alt"></i>@lang('2FA Security')</span></a></li>
                    <li class="list-group-item menu_has_children"><a href="#"><span><i class="fas fa-ticket-alt"></i>@lang('Ticket')</span></a>
                        <ul class="sub-menu {{menuActive('ticket*',2)}}">
                            <li class="{{menuActive('ticket.open')}}"><a href="{{ route('ticket.open') }}"><i class="far fa-stop-circle"></i>@lang('New Ticket')</a></li>
                            <li class="{{menuActive('ticket.index')}}"><a href="{{ route('ticket.index') }}"><i class="far fa-stop-circle"></i>@lang('My Ticket')</a></li>
                        </ul>
                    </li>
                    <li class="list-group-item"><a href="{{ route('user.logout') }}"><span><i class="fas fa-power-off"></i>@lang('Logout')</span></a></li>
                </ul>
            </div>
        </div>
        <div class="mobile-nav-toggle">
            <span></span>
        </div>
    </div>
</header>
