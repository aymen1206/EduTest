<header id="mobile-header" class="nav-top">
    <div class="container">
        <div class="mob-logo">
            <a href="#">
                <img src="{{ asset(setting()->dark_logo)  }}" class="logo" />
            </a>
        </div>
        <div class="toggle-menu">
            <span class="hamburger" id="ham"><i class="fas fa-bars"></i></span>
        </div>
    </div>
</header>

<header id="theme-header">
    <div class="container">

        <div class="d-flex align-items-center">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset(setting()->dark_logo)  }}" class="logo" />
            </a>
            <ul class="header-links">
                <li class="{{ (request()->is('/')) ? 'select-menu' : '' }}"><a href="{{ url('/') }}">{{ __('lang.home')}}</a></li>
                <li class="{{ (request()->is('about')) ? 'select-menu' : '' }}"><a href="{{ url('/about') }}">{{ __('lang.about_us')}}</a></li>
                <li class="{{ (request()->is('contact')) ? 'select-menu' : '' }}"><a href="{{ url('/contact') }}">{{ __('lang.contact_us')}}</a></li>
                <li class="{{ (request()->is('offers')) ? 'select-menu' : '' }}"><a href="{{ url('/offers') }}">{{ __('lang.offers')}}</a></li>
            </ul>
            <div class="user-area  d-flex align-items-center">
                @if(auth()->guard('student')->user() != null)
                <div class="login-area topbar-icon">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (auth()->guard('student')->user()->image != null)
                            <img src="{{asset('/'.auth()->guard('student')->user()->image)}}" width="40" height="40" />
                            {{ auth()->guard('student')->user()->name }}
                            @else
                            <img src="{{asset('/site/images/user.png')}}" width="40" height="40" />
                            {{ auth()->guard('student')->user()->name }}
                            @endif
                        </button>
                        <ul class="dropdown-menu hover-effect" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ url('student') }}"><i class="fas fa-home"></i>{{ __('lang.home')}}</a></li>
                            <li><a class="dropdown-item" href="{{ url('student/notifications') }}"><i class="fas fa-bell"></i>{{ __('lang.notifications')}}</a></li>
                            <li><a class="dropdown-item" href="{{ url('student/profile') }}"><i class="fas fa-user"></i>{{ __('lang.Edit_profile')}}</a></li>
                            <li><a class="dropdown-item" href="{{ url('student/favorites') }}"><i class="fas fa-heart"></i>{{ __('lang.Favorite')}}</a></li>
                            <li><a class="dropdown-item" href="{{ url('student/orders') }}"><i class="fas fa-shopping-basket"></i>{{ __('lang.orders')}}</a> </li>
                            <li><a class="dropdown-item" href="{{ url('student/childrens') }}"><i class="fa fa-users"aria-hidden="true"></i>{{ __('lang.children')}}</a> </li>
                            <li><a class="dropdown-item" href="{{ url('student/change-password') }}"><i class="fa fa-lock"aria-hidden="true"></i>{{ __('lang.reset_password')}}</a> </li>
                            <li><a class="dropdown-item" href="{{ url('student/logout') }}"><i class="fas fa-sign-out-alt"></i>{{ __('lang.logout')}}</a></li>
                        </ul>
                    </div>
                </div>
                @else
                <div class="login-area topbar-icon">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="currency-icon"><i class="fas fa-user-plus"></i></span>
                            {{ __('lang.join_us')}}
                        </button>
                        <ul class="dropdown-menu hover-effect" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#studentModal">{{ __('lang.client_account')}}</a></li>
                            <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#facilityModal">{{ __('lang.service_recipient_account')}} </a></li>
                        </ul>
                    </div>
                </div>

                <div>
				    <a href="" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-lock"></i> {{ __('lang.login')}}</a>
				</div>

                @endif

                <div class="lang-area topbar-icon">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                            $lang_icon = LaravelLocalization::getCurrentLocaleNative().'.png';
                            @endphp
                            <img src="{{asset('site/images/'.$lang_icon)}}" /> {{LaravelLocalization::getCurrentLocaleNative()}}
                        </button>
                        <ul class="dropdown-menu hover-effect" aria-labelledby="dropdownMenuButton">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a  class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        <img src="{{asset('site/images/'.$properties['native'].'.png')}}" /> {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
