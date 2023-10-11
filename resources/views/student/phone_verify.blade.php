@extends('edu-facility.layouts.auth')
@section('title')
    @lang('lang.phone_verify')
@endsection
@section('form')
    <style>
        #recaptcha-container {
            margin-top: 20px !important;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="text-center"> @lang('lang.welcome') {{ auth()->guard('student')->user()->name }} </h5>
                    <div class="card-header text-center">@lang('lang.Verify_Your_Phone')</div>

                    <div class="card-body text-center">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                @lang('lang.fresh_verification_sent')
                            </div>
                        @endif
                        @lang('lang.Before_proceeding_phone_otp')
                        <div class="alert alert-success" id="successAuth" style="display: none;">
                            @lang('lang.otp_sent')
                        </div>
                        <form style="margin-top: 10px;">
                            @csrf
                            <input dir="ltr" disabled="disabled" type="text" id="number" class="form-control"
                                   value="{{ $student->phone }}">
                            <div id="recaptcha-container"></div>
                            <button type="button" class="btn btn-primary mt-3"
                                    onclick="sendOTP();">@lang('lang.send_otp')</button>
                        </form>

                        <div class="mb-5 mt-5">
                            <h3>@lang('lang.verify_code')</h3>
                            <div class="alert alert-success" id="successOtpAuth" style="display: none;">
                                @lang('lang.auth_is_successful')
                            </div>
                            <div class="alert alert-danger" id="error" style="display: none;">
                                @lang('lang.error_sms')
                            </div>
                            <form>
                                <input type="text" id="verification" class="form-control mb-1"
                                       placeholder="@lang('lang.verify_code')">
                                <button type="button" class="btn btn-danger mt-3" onclick="verify()">
                                    @lang('lang.check_verify_code')
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyB_MN_toLOHIJ_xPgl3HDPpdf1LZoAIPPo",
            authDomain: "theedukeydev.firebaseapp.com",
            projectId: "theedukeydev",
            storageBucket: "theedukeydev.appspot.com",
            messagingSenderId: "509476633729",
            appId: "1:509476633729:web:db0a18dc580d056ce8a180"
        };
        firebase.initializeApp(firebaseConfig);
    </script>
    <script type="text/javascript">
        window.onload = function () {
            render();
        };

        function render() {
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
            recaptchaVerifier.render();
        }

        function sendOTP() {
            var number = "+" + "<?php echo $student->phone ?>";
            firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                console.log(coderesult);
                $("#successAuth").show();
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }

        function verify() {
            var code = $("#verification").val();
            coderesult.confirm(code).then(function (result) {
                var user = result.user;
                console.log(user);
                $("#successOtpAuth").show();
                window.location.href = "{{url('/student/otp-success')}}";
            }).catch(function (error) {
                $("#error").text(error.message);
                $("#error").show();
            });
        }
    </script>

@endsection
