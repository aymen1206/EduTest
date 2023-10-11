@extends('admin.master.master')
@section('title')
    من نحن
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">تعديل من نحن</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/about')}}">من نحن</a></li>
                            <li class="breadcrumb-item active" aria-current="page">تعديل من نحن</li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/about/'.$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12">العنوان</label>
                                <div class="col-md-12">
                                    <input type="text" name="title"  required class="form-control form-control-line" value="{{$data->title}}">
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">العنوان بالانجليزية</label>
                                <div class="col-md-12">
                                    <input type="text" name="title_en"  required class="form-control form-control-line" value="{{$data->title_en}}">
                                    <span class="text-danger">{{ $errors->first('title_en') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12"> الصورة </label>
                                <div class="col-sm-1">
                                    <img class="img-fluid" src="{{asset('/'.$data->image)}}">
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="image" class="form-control form-control-line">
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">النص</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="text" required rows="7">{{ $data->text }}</textarea>
                                    <span class="text-danger">{{ $errors->first('text') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> النص بالانجليزية</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="text_en" required rows="7">{{ $data->text_en }}</textarea>
                                    <span class="text-danger">{{ $errors->first('text_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.map_location')</label>
                                <div class="col-md-12">
                                    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBYk-bPGA2YW221CLysrZW7_4od9x5G90Y&sensor=false"></script>
                                    <div style="height:200px;" id="map"></div>
                                    <input type="hidden" name="map_location" id="map_location" value="{{$data->map}}">
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
    <script>
        window.onload = function() {

            var latlng = new google.maps.LatLng({{ $data->map }});

            var map = new google.maps.Map(document.getElementById('map'), {
                center: latlng,
                zoom: 7,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: 'Set lat/lon values for this property',
                draggable: true
            });
            google.maps.event.addListener(marker, 'dragend', function(a) {
                var cord = a.latLng.lat().toFixed(4) + ',' + a.latLng.lng().toFixed(4);
                document.getElementById('map_location').value = cord;
            });
        };
    </script>
@endsection
