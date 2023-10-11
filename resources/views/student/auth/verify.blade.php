@extends('edu-facility.layouts.auth')
@section('title')
    @lang('lang.reset_password')
@endsection
@section('form')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="text-center"> @lang('lang.welcome') {{ auth()->guard('student')->user()->name }} </h5>
                <div class="card-header text-center">@lang('lang.Verify_Your_Email_Address')</div>

                <div class="card-body text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('lang.fresh_verification_sent')
                        </div>
                    @endif

                    @lang('lang.Before_proceeding')
                    <hr>
                    @lang('lang.If_not_receive_email')
                     <br>
                    <form class="d-inline" method="POST" action="{{ route('student.verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-info align-baseline mt-3">@lang('lang.click_here_to_request_another') </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
