
<div class="header-top-section">
    <div class="custom-container">
        <div class="header-top-area d-flex flex-wrap align-items-center justify-content-between">
            <nav class="navbar navbar-expand-lg p-0">
                <a class="site-logo site-title" href="{{route('home')}}">
                    <img src="{{getImage(getFilePath('logo_icon') .'/logo.png')}}" alt="site-logo"></a>
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fas fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ml-auto mr-auto">
                        <li><a href="{{route('home')}}"><i class="fas fa-home"></i> @lang('Home')</a></li>
                        <li><a href="{{ route('contact') }}"><i class="fas fa-blender-phone"></i> @lang('Contact')</a></li>
                        <li><a href="{{ route('user.hyip.index') }}"><i class="fas fa-book-reader"></i> @lang('Your Hyip')</a></li>
                        <li><a href="{{ route('user.advertise.index') }}"><i class="las la-ad"></i>@lang('Advertising')</a></li>
                    </ul>
                </div>
                <div class="header-left-link">

                </div>
                <div class="language-select-list d-flex flex-wrap align-items-center">
                    <div class="language-select">
                        <select class="select-bar langSel language-select">
{{--                            @foreach($language as $item)--}}
{{--                                <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->code) }}</option>--}}
{{--                            @endforeach--}}
                        </select>
                    </div>
                </div>
                <div class="header-search">
                    <form action="{{ route('search') }}" method="GET">
                        @csrf
                        <input type="search" name="search" placeholder="@lang('I’m searching for') _">
                        <button class="header-search-btn" type="submit"><i class="icon-search"></i></button>
                    </form>
                </div>
                <div class="mobile-header-search">
                    <div class="search-bar">
                        <a href="#0"><i class="fas fa-search"></i></a>
                        <div class="header-top-search-area">
                            <form class="header-search-form" action="{{ route('search') }}" method="GET">
                                @csrf
                                <input type="search" name="search" id="header_search" placeholder="@lang('I’m searching for') _">
                                <button class="header-search-btn" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="header-btn">
                @auth
                    <div class="register-btn">
                        <a href="{{ route('user.home') }}" class="cmn-btn">@lang('Dashboard')</a>
                    </div>
                @else
                    <div class="register-btn">
                        <a href="{{ route('user.register') }}" class="cmn-btn">@lang('Register')</a>
                    </div>
                    <div class="logout-btn">
                        <a href="{{ route('user.login') }}" class="cmn-btn">@lang('Login')</a>
                    </div>
                @endauth
            </div>
            <div class="mobile-header-btn">
                <div class="account-bar">
                    <a href="#"><i class="fas fa-user"></i></a>
                </div>
                <div class="account-btn-group">
                    <div class="account-btn">
                        @auth
                            <a href="{{ route('user.home') }}" class="cmn-btn">@lang('Dashboard')</a>
                        @else
                            <a href="{{ route('user.register') }}" class="cmn-btn">@lang('Register')</a>
                            <a href="{{ route('user.login') }}" class="cmn-btn">@lang('Login')</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
