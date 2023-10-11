@extends('admin.master.master')
@section('title')
    اللغات @lang('lang.update')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">اللغات @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/languages')}}">اللغات</a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/languages/'.$data->id)}}" enctype="multipart/form-data">
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
                                    <input type="text" name="iso" required class="form-control form-control-line" value="{{$data->iso}}">
                                    <span class="text-danger">{{ $errors->first('iso') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> الحالة </label>
                                <div class="col-md-12">
                                    <select name="status" class="form-control">
                                        <option @if($data->status == 'active') selected @endif value="active"> مفعل </option>
                                        <option @if($data->status == 'inactive') selected @endif value="inactive"> غير مفعل </option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
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
