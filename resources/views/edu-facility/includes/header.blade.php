<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" style="background: #2e3442 !important">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>

            <a class="navbar-brand" href="{{url('/edu-facility')}}">
                <!-- Logo icon -->
                <b class="logo-icon text-center">
                    <img style="width:80%; max-height: 50px;" src="{{ asset(setting()->light_logo) }}" class="dark-logo" />
                </b>
                <!--End Logo icon -->

            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" style="background-color: #2f949c !important">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(auth()->guard('edu_facility')->user()->facility_type == 1 || auth()->guard('edu_facility')->user()->facility_type == 3)
                        <img src="{{ asset(auth()->guard('edu_facility')->user()->logo)}}" alt="user" onerror="this.src='{{url('images/facility_default_logo.png')}}';" class="rounded-circle" width="40">
                        @elseif(auth()->guard('edu_facility')->user()->facility_type == 2)
                            <img src="{{ asset(auth()->guard('edu_facility')->user()->profile_image)}}" alt="user" onerror="this.src='{{url('images/teacher.png')}}';" class="rounded-circle" width="31">
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                        <span class="with-arrow"><span class="bg-primary"></span></span>
                        <div class="d-flex no-block align-items-center p-15 bg-primary text-white mb-2">
                            <div class="ml-1">
                                @if(auth()->guard('edu_facility')->user()->facility_type == 1 || auth()->guard('edu_facility')->user()->facility_type == 3)
                                <img src="{{ asset(auth()->guard('edu_facility')->user()->logo)}}" alt="user" onerror="this.src='{{url('images/facility_default_logo.png')}}';" class="img-circle" width="60">
                                @elseif(auth()->guard('edu_facility')->user()->facility_type == 2)
                                    <img src="{{ asset(auth()->guard('edu_facility')->user()->profile_image)}}" alt="user" onerror="this.src='{{url('images/teacher.png')}}';" class="img-circle" width="60">
                                @endif
                            </div>
                            <div class="ml-2">
                            <h4 class="mb-0">{{auth()->guard('edu_facility')->user()->name}}</h4>
                            <p class=" mb-0">{{auth()->guard('edu_facility')->user()->email}}</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{url('edu-facility/profile')}}"><i class="ti-user mr-1 ml-1"></i> @lang('lang.my_profile')</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{url('edu-facility/logout')}}"><i class="fa fa-power-off mr-1 ml-1"></i> @lang('lang.logout')</a>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
