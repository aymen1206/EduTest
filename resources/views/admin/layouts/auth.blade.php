<!DOCTYPE html>
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"><meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('dashboard/assets/')}}/images/favicon.png">
    <title> {{ config('app.name', 'Laravel') }} | Admin </title>

    <!-- Custom CSS -->
    <link href="{{asset('dashboard/assets/')}}/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="{{asset('dashboard/assets/')}}/extra-libs/c3/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('dashboard/dist/')}}/css/style.min.css" rel="stylesheet">
    <link href="{{asset('dashboard/dist/css/custom.css')}}" rel="stylesheet">

</head>

<body>
<div class="main-wrapper">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Login box.scss -->
    <!-- ============================================================== -->
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center"
         style="background:url({{asset('site/images/Slider.webp')}}) no-repeat center center;">
        <div class="auth-box">
            @yield('form')
        </div>
    </div>
</div>

<script src="{{asset('dashboard/assets/')}}/libs/jquery/dist/jquery.min.js"></script>
<script src="{{asset('dashboard/assets/')}}/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="{{asset('dashboard/assets/')}}/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function () {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
</script>
</body>
</html>
