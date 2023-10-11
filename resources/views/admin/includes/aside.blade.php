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
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('admin')}}" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">@lang('lang.home')</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">  ادارة المنشئات التعليمية </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/edu-facilities?status=1')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">  المنشئات التعليمية </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/edu-facilities?status=2')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">  طلبات الاشتراك الجديدة </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/edu-facilities?status=0')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> حسابات معطلة </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/types')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">انواع  المنشئات التعليمية </span></a></li>
                        <li class="sidebar-item"><a href="{{url('admin/paymentmethods')}}" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu">    طرق الدفع  </span></a></li>
                        <li class="sidebar-item"><a href="{{url('admin/subjects')}}" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu"> المواد الدراسية </span></a></li>
                        <li class="sidebar-item"><a href="{{url('admin/trashed/edu-facilities/')}}" class="sidebar-link"><i class="mdi mdi-adjust"></i><span class="hide-menu">سلة  المهملات</span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">إدارة اولياء الامور</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/students')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">اولياء الامور</span></a></li>
                    </ul>
                </li>


                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">الادارة المالية</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/financial')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">  الرصيد </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/commission')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> نسبة العمولة </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/financial-logs')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> السجلات المالية </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/withdrawal')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> طلبات السحب </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-list"></i><span class="hide-menu"> ادارة الاشتراكات </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/orders?status=new')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu">  طلبات جديدة </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/orders?status=is_paid')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> الاشتراكات </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fa fa-image"></i><span class="hide-menu"> ادارة الاعلانات </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/ads')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> الاعلانات الترويجية </span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/advertisements')}}"><i class="mdi mdi-adjust"></i><span class="hide-menu"> الاعلانات التجارية </span></a></li>
                    </ul>
                </li>

                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/ratings')}}" aria-expanded="false"><i class="fa fa-star"></i><span class="hide-menu"> تقييمات المنشئات </span></a></li>

                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/messages')}}" aria-expanded="false"><i class="fa fa-inbox"></i><span class="hide-menu"> صندوق الوارد </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/languages')}}" aria-expanded="false"><i class="fa fa-language"></i><span class="hide-menu"> ادارة اللغات  </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/currencies')}}" aria-expanded="false"><i class="fa fa-money-bill"></i><span class="hide-menu"> ادارة العملات  </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url
                ('admin/tamara')}}" aria-expanded="false"><i class="fa fa-cog"></i><span
                                class="hide-menu"> ادارة منصة تمارا  </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url
                ('admin/tabby')}}" aria-expanded="false"><i class="fa fa-cog"></i><span
                                class="hide-menu"> ادارة منصة تابي  </span></a></li>                 
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url
                ('admin/jeel')}}" aria-expanded="false"><i class="fa fa-cog"></i><span
                                class="hide-menu"> ادارة منصة جييل   </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/about')}}" aria-expanded="false"><i class="fa fa-question"></i><span class="hide-menu"> من نحن </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/legal')}}" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu"> الشروط والاحكام  </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/contact')}}" aria-expanded="false"><i class="fa fa-phone"></i><span class="hide-menu"> بيانات الاتصال </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/setting')}}" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu"> @lang('lang.setting') </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/seo')}}" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu"> اعدادات ال SEO </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/notifications')}}" aria-expanded="false"><i class="fa fa-bell"></i><span class="hide-menu"> @lang('lang.notifications') </span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('admin/logout')}}" aria-expanded="false"><i class="fa fa-sign-out"></i><span class="hide-menu"> @lang('lang.logout') </span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
