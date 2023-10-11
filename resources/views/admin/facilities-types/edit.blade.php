@extends('admin.master.master')
@section('title')
    المراحل التعليمية @lang('lang.update')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">المراحل التعليمية  - @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/facilities-types')}}">المراحل التعليمية</a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/facilities-types/'.$data->id)}}" enctype="multipart/form-data">
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
                                <label class="col-md-12"> الاسم بالانجليزية</label>
                                <div class="col-md-12">
                                    <input type="text" name="name_en" placeholder="الاسم بالانجليزية" required class="form-control form-control-line" value="{{$data->name_en}}">
                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> نوع المنشأة </label>
                                <div class="col-md-12">
                                    <select  class="form-control form-control-line" name="type">
                                        @foreach(DB::table('types')->get() as $key => $val)
                                            <option @if($data->type == $val->id) selected @endif value="{{ $val->id }}"> {{ $val->name }} </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
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
