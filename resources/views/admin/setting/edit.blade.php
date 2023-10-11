@extends('admin.master.master')
@section('title')
    @lang('lang.setting')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.edit_setting')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/setting')}}">@lang('lang.setting')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.edit_setting')</li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/setting/'.$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.app_name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="app_name" placeholder="@lang('lang.app_name')" required class="form-control form-control-line" value="{{$data->app_name}}">
                                    <span class="text-danger">{{ $errors->first('app_name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.app_name') بالانجليزية</label>
                                <div class="col-md-12">
                                    <input type="text" name="app_name_en" placeholder="@lang('lang.app_name') بالانجليزية" required class="form-control form-control-line" value="{{$data->app_name_en}}">
                                    <span class="text-danger">{{ $errors->first('app_name_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.dark_logo')</label>
                                <div class="col-sm-1">
                                    <img class="img-fluid" src="{{asset('/'.$data->dark_logo)}}">
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="dark_logo" class="form-control form-control-line">
                                    <span class="text-danger">{{ $errors->first('dark_logo') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.light_logo')</label>
                                <div class="col-sm-1">
                                    <img class="img-fluid" src="{{asset('/'.$data->light_logo)}}">
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="light_logo" class="form-control form-control-line">
                                    <span class="text-danger">{{ $errors->first('light_logo') }}</span>
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
