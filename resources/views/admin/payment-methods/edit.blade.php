@extends('admin.master.master')
@section('title')
    طرق الدفع @lang('lang.update')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">طرق الدفع @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/paymentmethods')}}">طرق الدفع</a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/paymentmethods/'.$data->id)}}" enctype="multipart/form-data">
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
                                <label class="col-md-12">@lang('lang.eng')</label>
                                <div class="col-md-12">
                                    <input type="text" name="name_en" placeholder="@lang('lang.eng')" required class="form-control form-control-line" value="{{$data->name_en}}">
                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> المرحلة التعليمية </label>
                                <div class="col-md-12">
                                    <select name="type[]" id="select_2" class="select2 form-control select2-hidden-accessible" multiple="" style="height: 36px;width: 100%;" data-select2-id="13" tabindex="-1" aria-hidden="true">
                                            @foreach($types as $type)
                                                <option @if(in_array($type->id,explode(',',$data->type))) selected @endif value="{{ $type->id }}"> {{ $type->name }} </option>
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
@section('custom-javascript')
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{asset('/dashboard')}}/dist/js/pages/forms/select2/select2.init.js"></script>
@endsection
