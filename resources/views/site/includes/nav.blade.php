<nav class="nav-drill">
    <ul class="nav-items nav-level-1">

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">
               {{ __('lang.home')}}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/about') }}">
               {{ __('lang.about_us')}}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/contact') }}">
              {{ __('lang.contact_us')}}
            </a>
        </li>
        <li class="nav-item nav-expand">
            <a class="nav-link nav-expand-link" href="#">
               {{ __('lang.join_us')}}
            </a>
            <ul class="nav-items nav-expand-content">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" href="#loginModal">{{ __('lang.login')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" href="#studentModal">
                       {{ __('lang.client_account')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" href="#facilityModal">
                       {{ __('lang.service_recipient_account')}}
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item nav-expand">
            <a class="nav-link nav-expand-link" href="#">
              @php
                $lang_icon = LaravelLocalization::getCurrentLocaleNative().'.png';
              @endphp
              <img src="{{asset('site/images/'.$lang_icon)}}" /> {{LaravelLocalization::getCurrentLocaleNative()}}
            </a>
            <ul class="nav-items nav-expand-content">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li class="nav-item">
                        <a  class="nav-link" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            <img src="{{asset('site/images/'.$properties['native'].'.png')}}" /> {{ $properties['native'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        @if(auth()->guard('student')->user() != null)
        <li class="nav-item nav-expand">
            <a class="nav-link nav-expand-link" href="#">
              @if (auth()->guard('student')->user()->image != null)
              <img src="{{asset('/'.auth()->guard('student')->user()->image)}}" width="40" height="40" />
              {{ auth()->guard('student')->user()->name }}
              @else
              <img src="{{asset('/site/images/user.png')}}" width="40" height="40" />
              {{ auth()->guard('student')->user()->name }}
              @endif
            </a>
            <ul class="nav-items nav-expand-content">

                <li class="nav-item"><a class="nav-link" href="{{ url('student') }}"><i class="fas fa-home"></i>{{ __('lang.home')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('student/notifications') }}"><i class="fas fa-bell"></i>{{ __('lang.notifications')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('student/profile') }}"><i class="fas fa-user"></i> {{ __('lang.Edit_profile')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('student/favorites') }}"><i class="fas fa-heart"></i>{{ __('lang.Favorite')}}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('student/orders') }}"><i class="fas fa-shopping-basket"></i>{{ __('lang.orders')}}</a> </li>
                <li class="nav-item"><a class="nav-link" href="{{ url('student/childrens') }}"><i class="fa fa-users" aria-hidden="true"></i> {{ __('lang.children')}} </a> </li>
                <li class="nav-item"><a class="nav-link" href="{{ url('student/logout') }}"><i class="fas fa-sign-out-alt"></i>{{ __('lang.logout')}}</a></li>
            </ul>
        </li>

        @endif
    </ul>
</nav>