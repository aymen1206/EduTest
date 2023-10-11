@extends('edu-facility.master.master')
@section('title')
    @lang('lang.reset_password')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.reset_password')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active"><a href="{{url('/edu-facility/reset-password')}}">@lang('lang.reset_password')</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <form class="form-horizontal form-material" method="post" action="{{url('edu-facility/reset-password')}}">
                            @csrf

                            <div class="form-group">
                                <label for="exampleFormControlInput2" class="col-md-12">@lang('lang.old_password')</label>
                                <div class="col-md-12">
                                    <input type="password" name="old_password" required minlength="8" class="form-control"
                                           id="exampleFormControlInput2"
                                           placeholder="***************">
                                    <span class="text-danger">{{ $errors->first('old_password') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput2" class="col-md-12"> @lang('lang.new_password') </label>
                                <div class="col-md-12">
                                    <input type="password" name="password" required minlength="8" class="form-control"
                                           id="exampleFormControlInput2"
                                           placeholder="***************">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput2" class="col-md-12"> @lang('lang.confirm_new_password') </label>
                                <div class="col-md-12">
                                    <input type="password" name="password_confirmation" required minlength="8" class="form-control"
                                           id="exampleFormControlInput2"
                                           placeholder="***************">
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">@lang('lang.update')</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection

