@extends('admin.master.master')
@section('title')
    @lang('lang.seo')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.edit_seo')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/seo')}}">@lang('lang.seo')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.edit_seo')</li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/seo/'.$seo->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.title')</label>
                                <div class="col-md-12">
                                    <input type="text" name="title" placeholder="@lang('lang.title')" required class="form-control form-control-line" value="{{$seo->title}}">
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.description')</label>
                                <div class="col-md-12">
                                    <textarea name="description" required class="form-control form-control-line">{!! $seo->description !!}</textarea>
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.keywords')</label>
                                <div class="col-md-12">
                                    <textarea name="keywords" required class="form-control form-control-line">{!! $seo->keywords !!}</textarea>
                                    <span class="text-danger">{{ $errors->first('keywords') }}</span>
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
