@extends('admin.master.master')
@section('title')
    العملات @lang('lang.add_new')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.add_new')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/currencies')}}">العملات</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_new')</li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/currencies/')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="@lang('lang.name')" required class="form-control form-control-line" value="{{old('name')}}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">الشعار</label>
                                <div class="col-md-12">
                                    <input type="text" name="iso" required class="form-control form-control-line" placeholder=" مثال : sar , egp , usd">
                                    <span class="text-danger">{{ $errors->first('iso') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> الحالة </label>
                                <div class="col-md-12">
                                    <select name="status" class="form-control">
                                        <option value="active"> مفعل </option>
                                        <option value="inactive"> غير مفعل </option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> القيمة مقابل الريال السعودي </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" step="0.01"  name="value_to_sar" required class="form-control form-control-line" placeholder="مثال : الدولار يساوي 4.5 ريال سعودي">
                                    <span class="text-danger">{{ $errors->first('value_to_sar') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">@lang('lang.add_new')</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection
