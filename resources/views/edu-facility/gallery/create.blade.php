@extends('edu-facility.master.master')
@section('title')
    @lang('lang.gallery') @lang('lang.add_new')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.gallery')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility/gallery')}}">@lang('lang.gallery')</a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('edu-facility/gallery/')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-md-12"> @lang('lang.image') </label>
                                    <div class="col-md-10">
                                        <input type="file" name="image" required class="form-control" onchange="loadPreview(this);">
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    </div>
                                    <div class="col-md-2">
                                        <img id="preview_img" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="img-fluid img-thumbnail" />
                                    </div>
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
@section('custom-javascript')
    <script>
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(200)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
