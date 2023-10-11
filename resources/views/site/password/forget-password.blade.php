@extends('admin.layouts.auth')
@section('title')
    @lang('lang.reset_password')
@endsection
@section('form')
<style>
    .card{
        border: 1px solid gainsboro;
        padding: 15px;
        box-shadow: 1px 1px 1px 0px;
        margin-bottom: 20px;
    }
    .auth-wrapper .auth-box {
        background: rgb(255 255 255 / 61%);
        padding: 30px;
        box-shadow: 1px 0 20px rgb(0 0 0 / 8%);
        max-width: 400px;
        width: 90%;
        margin: 10% 0;
    }
    .auth-wrapper .auth-box{
        max-width:500px !important;
    }
    
    a{
        font-size:16px;
    }
</style>
    <div id="loginform">
        <div class="logo">
            <h5 class="font-medium mb-3 mt-3">@lang('lang.reset_password')</h5>
        </div>
        <!-- Form -->
        <div class="row">
            
            <div class="col-12 text-center card" >
               <a href="{{url('student/password/reset')}}"> <i class="fa fa-user ml-3"></i>  @lang('lang.reset_client_account') </a>
            </div>
            
            <div class="col-12 text-center card">
               <a href="{{url('edu-facility/password/reset')}}"> <i class="fa fa-university ml-3"></i> @lang('lang.reset_service_recipient_account') </a>
            </div>
        </div>
    </div>
@endsection
