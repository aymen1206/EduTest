<aside class="left-sidebar" style="background-color: #414755 !important">
    <style type="text/css">
        .sidebar-link i{
            color: white !important;
        }
        .sidebar-link {
            color: white !important;
        }
        .sidebar-nav ul{
            background:  #414755 !important;
        }
        .has-arrow::after{
            color: white !important;
            border-color: white !important;
        }
        .sidebar-item .sidebar-link i {
            color: white !important;
        }
    </style>
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" style="background-color: #414755 !important" >
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('edu-facility')}}" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">@lang('lang.home')</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu"> @lang('lang.subscriptions') </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/prices')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> @lang('lang.Subscription_prices') </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/orders?status=new')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">  @lang('lang.New_Subscription') </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/orders?status=is_paid')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">   @lang('lang.Current_Subscriptions') </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu"> @lang('lang.financial_management') </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/finance')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">  @lang('lang.Profile_finance_settings') </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/financial')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">  @lang('lang.Balance') </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/financial-logs')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> @lang('lang.financial_records') </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/withdrawal-logs')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> @lang('lang.Balance_withdrawal') </span></a></li>
                    </ul>
                </li>


                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-folder"></i><span class="hide-menu"> @lang('lang.account_settings') </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/profile/show')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> @lang('lang.Account_details') </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/gallery')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> @lang('lang.gallery') </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/reset-password')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> @lang('lang.reset_password') </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/messages')}}" aria-expanded="false"><i class="fas fa-hands-helping"></i><span class="hide-menu"> @lang('lang.Support_Center') </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/ratings')}}" aria-expanded="false"><i class="fa fa-star"></i><span class="hide-menu"> @lang('lang.Reviews') </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/notification')}}" aria-expanded="false"><i class="mdi mdi-bell-ring"></i><span class="hide-menu"> @lang('lang.notifications') </span></a></li>


                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-translate"></i><span class="hide-menu"> @lang('lang.language') </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li class="sidebar-item">
                                <a  class="sidebar-link waves-effect waves-dark sidebar-link" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" aria-expanded="false">
                                    <i class="mdi mdi-adjust"></i><span class="hide-menu"> <img src="{{asset('site/images/'.$properties['native'].'.png')}}" /> {{ $properties['native'] }} </span>
                                </a>
                            </li>
                    @endforeach
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('edu-facility/logout')}}" aria-expanded="false"><i class="fa fa-sign-out"></i><span class="hide-menu"> @lang('lang.logout') </span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
