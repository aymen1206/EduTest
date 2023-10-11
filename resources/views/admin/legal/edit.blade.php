@extends('admin.master.master')
@section('title')
تعديل الشروط والاحكام
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">تعديل الشروط والاحكام</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/legal')}}">الشروط والاحكام</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> تعديل الشروط والاحكام </li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/legal/update')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12"> الشروط والاحكام </label>
                                <div class="col-md-12">
                                    <textarea name="text" class="form-control" required rows="10">{!! $data->text !!}</textarea>
                                    <span class="text-danger">{{ $errors->first('text') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> الشروط والاحكام بالانجليزية </label>
                                <div class="col-md-12">
                                    <textarea name="text_en" class="form-control" required rows="10">{!! $data->text_en !!}</textarea>
                                    <span class="text-danger">{{ $errors->first('text_en') }}</span>
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
