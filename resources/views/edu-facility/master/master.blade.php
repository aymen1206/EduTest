<!DOCTYPE html>
@php
    $lang = LaravelLocalization::getCurrentLocaleNative();
@endphp
<html @if($lang == 'العربية') dir="rtl" lang="ar"  @else dir="ltr" lang="en" @endif >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <title>  {{ setting()->app_name }} | @yield('title') </title>
    <!-- Custom CSS -->
    <link href="{{ asset('dashboard/')}}/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="{{ asset('dashboard/')}}/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dashboard/')}}/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.2/css/all.css" />
    <link href="{{asset('dashboard/dist/css/custom.css')}}" rel="stylesheet">

    <style>
        .dt-buttons{
            margin-bottom: 20px !important;
        }
    </style>
</head>

<body>

<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>

<div id="main-wrapper">

    @include('edu-facility.includes.header')

    @include('edu-facility.includes.aside')

    <div class="page-wrapper">
        @yield('content')
        @include('edu-facility.includes.footer')
    </div>

</div>

<div class="chat-windows"></div>
<script src="{{ asset('dashboard/')}}/assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('dashboard/')}}/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- apps -->
<script src="{{ asset('dashboard/')}}/dist/js/app.min.js"></script>
<script src="{{ asset('dashboard/')}}/dist/js/app.init.js"></script>
<!-- Theme settings -->
<script src="{{ asset('dashboard/')}}/dist/js/app-style-switcher.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ asset('dashboard/')}}/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="{{ asset('dashboard/')}}/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="{{ asset('dashboard/')}}/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="{{ asset('dashboard/')}}/dist/js/feather.min.js"></script>
<script src="{{ asset('dashboard/')}}/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<script src="{{ asset('dashboard/')}}/assets/extra-libs/c3/d3.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/extra-libs/c3/c3.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/libs/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/libs/gaugeJS/dist/gauge.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/libs/flot/excanvas.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/libs/flot/jquery.flot.js"></script>
<script src="{{ asset('dashboard/')}}/assets/libs/jquery.flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.time.min.js" integrity="sha512-lcRowrkiQvFli9HkuJ2Yr58iEwAtzhFNJ1Galsko4SJDhcZfUub8UxGlMQIsMvARiTqx2pm7g6COxJozihOixA==" crossorigin="anonymous"></script>
<script src="{{ asset('dashboard/')}}/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
<script src="{{ asset('dashboard/')}}/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
<script src="{{ asset('dashboard/')}}/dist/js/pages/dashboards/dashboard2.js"></script>
<script src="{{ asset('dashboard/')}}/assets/libs/summernote/dist/summernote-bs4.min.js"></script>


<script>
    $('#summernote').summernote({
        placeholder: 'Type your email Here',
        tabsize: 2,
        height: 250
    });
</script>
@include('sweetalert::alert')
@yield('custom-javascript')
</body>

</html>
