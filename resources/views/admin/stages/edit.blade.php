@extends('admin.master.master')
@section('title')
    الصفوف الدراسية @lang('lang.update')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">الصفوف الدراسية @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/stages')}}">الصفوف الدراسية</a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/stages/'.$data->id)}}" enctype="multipart/form-data">
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
                                <label class="col-md-12">الصف بالانجليزية</label>
                                <div class="col-md-12">
                                    <input type="text" name="name_en" placeholder="الصف بالانجليزية" required class="form-control form-control-line" value="{{$data->name_en}}">
                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-md-12"> المرحلة التعليمية </label>
                                <div class="col-md-12">
                                    <select class="form-control" name="type">
                                        @foreach($data_2 as $dt)
                                            <option @if($data->type_id == $dt->id) selected @endif value="{{$dt->id}}">{{$dt->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
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
