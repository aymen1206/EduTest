<!doctype html>
<html lang="ar" dir="rtl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://code.jquery.com/ui/jquery-ui-git.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
          integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
          crossorigin="anonymous"/>
    <meta name="google-site-verification" content="UamxthO2hqJfnyXD61wI6ofKEeMBdFIfzwz8f7OShHk"/>
    <link rel="stylesheet" href="{{asset('/site/css/bootstrap.rtl.min.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
          rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
          rel="stylesheet"/>
    <link href="{{asset('/site/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('site/css/responsiv.css')}}" rel="stylesheet">
    <title> {{ seo()->title }} | @yield('page_title')</title>

    <meta name="description" content="{{ seo()->description }}">
    <meta name="keywords" content="{{ seo()->keywords }}">
    <meta property="og:description" content="{{ seo()->description }}"/>
    <meta property="og:title" content="{{ seo()->title }}"/>
    <meta property="og:type" content="site"/>
    <meta property="og:locale" content="ar-ar"/>
    <meta property=":locale:alternate" content="en-us"/>
    <meta property="og:url" content="https://theedukey.com"/>
    <meta property="og:image" content="https://theedukey.com/uploads/settings/1643894636.png"/>
    <meta property="og:image" content="https://theedukey.com/uploads/settings/1643894636.png"/>
    <meta property="og:image:url" content="https://theedukey.com/uploads/settings/1643894636.png"/>
    <meta property="og:image" content="https://theedukey.com/uploads/settings/1643894636.png"/>

</head>

<body>

<div class="mob-menu-over"></div>
@include('site.includes.nav')

<div class="site-container">
    <div id="site-wrapper">

        @include('site.includes.header')

        @yield('content')

        @include('site.includes.footer')

    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="{{asset('/site/js/functions.js')}}"></script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
</script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->
@include('sweetalert::alert')
@yield('custom-javascript')
</body>
<div class="modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalTitle">{{__('lang.login')}}</h5>
            </div>
            <div class="modal-body">
                <form class="popup-form" method="post" action="{{url('login')}}">
                    @csrf

                    <div class="formRow mb-3">
                        <label for="exampleFormControlInput1" class="form-label">{{__('lang.email')}}</label>
                        <input type="email" name="email" required class="form-control" id="exampleFormControlInput1"
                               placeholder="name@example.com">
                        <div class="login-mail-action done"><i class="fas fa-check"></i></div>
                    </div>


                    <div class="formRow mb-3">
                        <label for="exampleFormControlInput2" class="form-label">{{__('lang.password')}}</label>
                        <input type="password" name="password" required minlength="8" class="form-control"
                               id="exampleFormControlInput2" placeholder="***************">
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col-lg-6">

                            <label class="check-container">{{__('lang.remember_me')}}
                                <input type="checkbox" name="remember" checked="">
                                <span class="checkmark"></span>
                            </label>

                        </div>
                        <div class="col-lg-6">
                            <a class="reset-link"
                               href="{{ url('forget-password') }}">{{__('lang.forgot_your_password')}}</a>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary sumbit-form">{{__('lang.login')}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="studentModal" tabindex="-1" aria-labelledby="studentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalTitle"> {{__('lang.client_account')}} </h5>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger st_r_print_error_msg" style="display:none">
                    <ul></ul>
                </div>

                <form class="popup-form" method="post" action="{{ route('student.st_register') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="formRow mb-3">
                        <label class="form-label">{{__('lang.name')}}</label>
                        <input type="text" name="name" id="st_r_name" class="form-control">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="formRow mb-3">
                        <label class="form-label">{{__('lang.mobile')}}</label>
                        <input type="text" name="phone" id="st_r_mobile" class="form-control"
                               placeholder="9665XXXXXXXXX">
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="formRow mb-3">
                        <label for="exampleFormControlInput1" class="form-label">{{__('lang.email')}}</label>
                        <input type="email" name="email" id="st_r_email" class="form-control"
                               id="exampleFormControlInput1"
                               placeholder="name@example.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="formRow mb-3">
                        <label class="form-label">{{__('lang.city')}}</label>
                        <select name="city" id="st_r_city" class="form-control p-2">
                            @foreach(DB::table('cities')->get() as $city)
                                <option
                                    value="{{ $city->id }}"> @if(LaravelLocalization::getCurrentLocaleNative() == 'العربية') {{ $city->nameAr }} @else {{ $city->nameEn }} @endif</option>
                            @endforeach
                        </select>
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <div class="row" style="width: 100%;">
                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput2" class="form-label">{{__('lang.password')}}</label>
                            <input type="password" name="password" id="st_r_password" minlength="8" class="form-control"
                                   id="exampleFormControlInput2" placeholder="***************">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput2"
                                   class="form-label">{{__('lang.confirm_password')}}</label>
                            <input type="password" name="password_confirmation" id="st_r_password_confirmation"
                                   class="form-control"
                                   id="exampleFormControlInput2" placeholder="***************">

                        </div>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col-12">

                            <label class="check-container"> {{__('lang.accept_terms')}}
                                <input type="checkbox" name="legal_agreement" id="st_r_legal_agreement" checked>
                                <span class="checkmark"></span>
                            </label>
                            @error('legal_agreement')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <span class="text-danger">
                                {{__('lang.agree_click') }}
                            </span>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="st_register_submit"
                                    class="btn btn-primary sumbit-form"> {{__('lang.register')}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="dataModal" tabindex="-1" aria-labelledby="dataModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalTitle"> {{__('lang.complete_account')}} </h5>
            </div>
            <div class="modal-body">
                <form class="popup-form" method="post" action="{{ route('student.childrens_complete_account') }}"
                      enctype="multipart/form-data">
                    @csrf


                    <div class="formRow mb-3">
                        <label class="form-label">{{__('lang.parent_id')}}</label>
                        <input type="text" name="guardian_id_number" class="form-control" required>
                    </div>
                    <img id="preview_img11" src="https://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png"
                         class="img-fluid img-thumbnail" width="150" height="150"/>
                    <div class="formRow mb-3 new-label-title">
                        {{__('lang.family_id')}}
                        <label for="file-upload" class="custom-file-upload">
                            <i class="far fa-image"></i>{{__('lang.attach_photo')}}
                        </label>
                        <input id="file-upload" name="family_id_image" required type="file"
                               onchange="loadPreview(this,'#preview_img11')" ;/>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary sumbit-form">{{__('lang.Complete')}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="completeModal" tabindex="-1" aria-labelledby="completeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalTitle"> {{__('lang.complete_account')}} </h5>
            </div>
            <div class="modal-body">
                <form class="popup-form" method="post" action="{{route('student.make_order_complete_account') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="formRow mb-3">
                        <label class="form-label">{{__('lang.id_number')}}</label>
                        <input type="text" name="id_number" class="form-control" required>
                    </div>

                    <div class="formRow mb-3 new-label-title">
                        {{__('lang.id_number_photo')}}
                        <label for="file-upload00" class="custom-file-upload">
                            <i class="far fa-image"></i> {{__('lang.attach_photo')}}
                        </label>
                        <input id="file-upload00" required name="id_image" type="file"/>
                    </div>

                    <div class="formRow mb-3 new-label-title">
                        {{__('lang.scientific_certificate_photo')}}
                        <label for="file-upload11" class="custom-file-upload">
                            <i class="far fa-image"></i> {{__('lang.attach_photo')}}
                        </label>
                        <input id="file-upload11" required name="certificate_image" type="file"/>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary sumbit-form">{{__('lang.Complete')}}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="facilityModal" tabindex="-1" aria-labelledby="facilityModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facilityModalTitle">{{__('lang.service_recipient_account')}}</h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger fa_r_print_error_msg" style="display:none">
                    <ul></ul>
                </div>

                <form class="popup-form" method="post" action="{{ route('edu-facility.fa_register') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="col-md-12">@lang('lang.name')</label>
                        <div class="col-md-12">
                            <input type="text" name="name" id="fa_r_name" class="form-control form-control-line">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>


                    <!--<div class="form-group">-->
                <!--    <label class="col-md-12">@lang('lang.facility_type')</label>-->
                    <!--    <div class="col-md-12">-->
                    <!--        <select class="form-control form-control-line" name="type_id" required aria-label="Default select example">-->
                <!--            <option value="" selected disabled>@lang('lang.facility_type') </option>-->
                <!--            @foreach(DB::table('types')->get() as $dt)-->
                <!--                <option value="{{$dt->id}}"> {{$dt->name}} </option>-->
                    <!--            @endforeach-->
                    <!--        </select>-->
                <!--        <span class="text-danger">{{ $errors->first('type_id') }}</span>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="row" style="width: 100%;">
                        <div class="formRow mb-3 col">
                            <label class="col-md-12">@lang('lang.phone')</label>
                            <div class="col-md-12">
                                <input type="tel" name="phone" id="fa_r_phone" class="form-control form-control-line">
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>

                        <div class="formRow mb-3 col">
                            <label class="col-md-12">@lang('lang.mobile')</label>
                            <div class="col-md-12">
                                <input type="text" name="mobile" id="fa_r_mobile"
                                       class="form-control form-control-line">
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput1" class="col-md-12">@lang('lang.email')</label>
                            <div class="col-md-12">
                                <input type="email" name="email" id="fa_r_email" class="form-control form-control-line"
                                       id="exampleFormControlInput1" placeholder="name@example.com">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                        </div>

                        <div class="formRow mb-3 col">
                            <label class="col-md-12">@lang('lang.city')</label>
                            <div class="col-md-12">
                                <select name="city" id="fa_r_city" class="form-control p-2">
                                    @foreach(DB::table('cities')->get() as $city)
                                        <option
                                            value="{{ $city->id }}">@if(LaravelLocalization::getCurrentLocaleNative() == 'العربية') {{ $city->nameAr }} @else {{ $city->nameEn }} @endif</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput2" class="form-label">@lang('lang.password')</label>
                            <input type="password" name="password" id="fa_r_password" minlength="8" class="form-control"
                                   id="exampleFormControlInput2" placeholder="***************">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput2"
                                   class="form-label">@lang('lang.confirm_password')</label>
                            <input type="password" name="password_confirmation" id="fa_r_password_confirmation"
                                   class="form-control"
                                   id="exampleFormControlInput2" placeholder="***************">

                        </div>
                    </div>

                    <div class="row" style="width: 100%;">
                        <div class="col-12">

                            <label class="check-container"> @lang('lang.accept_terms')
                                <input type="checkbox" name="legal_agreement" id="fa_r_legal_agreement" checked>
                                <span class="checkmark"></span>
                            </label>
                            @error('legal_agreement')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <span class="text-danger">
                                {{__('lang.agree_click') }}
                            </span>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="fa_register_submit"
                                    class="btn btn-primary sumbit-form">@lang('lang.register')</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        // student regiser validation
        $("#st_register_submit").click(function (e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var name = $("#st_r_name").val();
            var phone = $("#st_r_mobile").val();
            var email = $("#st_r_email").val();
            var city = $("#st_r_city").val();
            var legal_agreement = $("#st_r_legal_agreement").val();
            var password = $("#st_r_password").val();
            var password_confirmation = $("#st_r_password_confirmation").val();


            $.ajax({
                url: "{{ route('student.st_register') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    name: name,
                    phone: phone,
                    email: email,
                    legal_agreement: legal_agreement,
                    city: city,
                    password: password,
                    password_confirmation: password_confirmation
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        document.location.href = '/student';
                    } else {
                        ST_printErrorMsg(data.error);
                    }
                }
            });

        });

        function ST_printErrorMsg(msg) {
            $(".st_r_print_error_msg").find("ul").html('');
            $(".st_r_print_error_msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".st_r_print_error_msg").find("ul").append('<li>' + value + '</li>');
            });
        }


        // facility register validation

        $("#fa_register_submit").click(function (e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var name = $("#fa_r_name").val();
            var phone = $("#fa_r_phone").val();
            var mobile = $("#fa_r_mobile").val();
            var email = $("#fa_r_email").val();
            var city = $("#fa_r_city").val();
            var legal_agreement = $("#fa_r_legal_agreement").val();
            var password = $("#fa_r_password").val();
            var password_confirmation = $("#fa_r_password_confirmation").val();


            $.ajax({
                url: "{{ route('edu-facility.fa_register') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    name: name,
                    phone: phone,
                    mobile: mobile,
                    email: email,
                    legal_agreement: legal_agreement,
                    city: city,
                    password: password,
                    password_confirmation: password_confirmation
                },
                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        document.location.href = '/edu-facility';
                    } else {
                        Fa_printErrorMsg(data.error);
                    }
                }
            });

        });

        function Fa_printErrorMsg(msg) {
            $(".fa_r_print_error_msg").find("ul").html('');
            $(".fa_r_print_error_msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".fa_r_print_error_msg").find("ul").append('<li>' + value + '</li>');
            });
        }


    });


</script>

<script>
    function loadPreview(input, id) {

        id = id || '#preview_img';
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(id)
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</html>
