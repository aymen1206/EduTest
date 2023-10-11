@extends('admin.master.master')
@section('title')
    العملات @lang('lang.update')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">العملات @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/currencies')}}">العملات</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.update')</li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/currencies/'.$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="@lang('lang.name')" required class="form-control form-control-line" value="{{$data->name}}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">الشعار</label>
                                <div class="col-md-12">
                                    <input type="text" name="code" required class="form-control form-control-line" value="{{$data->code}}">
                                    <span class="text-danger">{{ $errors->first('code') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">الرمز</label>
                                <div class="col-md-12">
                                    <input type="text" name="symbol" required class="form-control form-control-line" value="{{$data->symbol}}">
                                    <span class="text-danger">{{ $errors->first('symbol') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> طريقةالكتابة </label>
                                <div class="col-md-12">
                                    <input type="text" name="format" required class="form-control form-control-line" value="{{$data->format}}">
                                    <span class="text-danger">{{ $errors->first('format') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12"> الحالة </label>
                                <div class="col-md-12">
                                    <select name="active" class="form-control">
                                        <option @if($data->active == 1) selected @endif value="1"> مفعل </option>
                                        <option @if($data->active == 0) selected @endif value="0"> غير مفعل </option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> القيمة مقابل الريال السعودي </label>
                                <div class="col-md-12">
                                    <input type="number" step="0.01" min="0" name="exchange_rate" required class="form-control form-control-line" value="{{$data->exchange_rate}}">
                                    <span class="text-danger">{{ $errors->first('exchange_rate') }}</span>
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
