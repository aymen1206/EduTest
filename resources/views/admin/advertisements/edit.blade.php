@extends('admin.master.master')
@section('title')
    الاعلانات التجارية @lang('lang.update')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> الاعلانات التجارية @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/advertisements')}}"> الاعلانات التجارية </a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/advertisements/'.$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12">عنوان الاعلان</label>
                                <div class="col-md-12">
                                    <input type="text" name="link" placeholder="رابط الاعلان" required class="form-control form-control-line" value="{{$data->link}}">
                                    <span class="text-danger">{{ $errors->first('link') }}</span>
                                </div>
                            </div>

                            <div class="form-group new-label-title">

                                <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                    صورة الاعلان
                                </label>
                                <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->image)}}">
                                <div class="col-md-12">
                                    <input class="form-control" name="image" id="file-upload" type="file"/>
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
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
