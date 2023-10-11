@extends('admin.master.master')
@section('title')
    أولياء الامور@lang('lang.update')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">أولياء الأمور @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/students')}}">أولياء الأمور</a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/student/'.$data->id)}}" enctype="multipart/form-data">
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
                                <label class="col-md-12">@lang('lang.name') بالانجليزية </label>
                                <div class="col-md-12">
                                    <input type="text" name="name_en" placeholder="@lang('lang.name') بالانجليزية" required class="form-control form-control-line" value="{{$data->name_en}}">
                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.email')</label>
                                <div class="col-md-12">
                                    <input type="email" name="email" placeholder="@lang('lang.email')" required class="form-control form-control-line" value="{{$data->email}}">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.phone')</label>
                                <div class="col-md-12">
                                    <input type="text" name="phone" placeholder="@lang('lang.phone')" required class="form-control form-control-line" value="{{$data->phone}}">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.gradian')</label>
                                <div class="col-md-12">
                                    <input type="text" name="gradian" placeholder="@lang('lang.gradian')" required class="form-control form-control-line" value="{{$data->guardian_name}}">
                                    <span class="text-danger">{{ $errors->first('guardian_name') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.id_number')</label>
                                <div class="col-md-12">
                                    <input type="text" name="id_number" placeholder="@lang('lang.id_number') " required class="form-control form-control-line" value="{{$data->id_number}}">
                                    <span class="text-danger">{{ $errors->first('id_number') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.guardian_id_number')</label>
                                <div class="col-md-12">
                                   <input type="text" name="guardian_id_number" placeholder="@lang('lang.guardian_id_number') " required class="form-control form-control-line" value="{{$data->guardian_id_number}}">
                                    <span class="text-danger">{{ $errors->first('guardian_id_number') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                    <label class="col-md-12">المدينة</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="city_id" required aria-label="Default select example">
                                            <option value="" selected disabled> من فضلك اختر نوع المنشأة التعليمية </option>
                                            @foreach($data2 as $dt)
                                                <option @if($data->city == $dt->id) selected @endif value="{{$dt->id}}"> {{$dt->nameAr}} </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    </div>
                                </div>


                           <div class="is_facility_1_3_5">

                                <div class="form-group new-label-title">

                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.id_number_photo')
                                    </label>
                                    <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->id_number_photo)}}">
                                    <div class="col-md-12">
                                        <input class="form-control" name="id_photo" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('id_number') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.family_id_image')
                                    </label>
                                    <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->family_id_image)}}">
                                    <div class="col-md-12">
                                        <input class="form-control" name="Family_id" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('family_id_image') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">

                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.certificate_image')
                                    </label>
                                    <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->certificate_image)}}">
                                    <div class="col-md-12">
                                        <input class="form-control" name="certificate_image" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('certificate_image') }}</span>
                                    </div>
                                </div>
                             </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput2" class="col-md-12">@lang('lang.password') <span class="text-orange">( @lang('lang.password_update_text') )</span> </label>
                                <div class="col-md-12">
                                    <input type="password" name="password" class="form-control" id="exampleFormControlInput2"
                                           placeholder="***************">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
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
    <script src="{{asset('dashboard/assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/extra-libs/jquery.repeater/repeater-init.js')}}"></script>
    <script src="{{asset('dashboard/assets/extra-libs/jquery.repeater/dff.js')}}"></script>
    <script type="text/javascript">

        jQuery(document).ready(function ()
        {
            $('.is_teatcher_2').hide();
            $('.is_facility_1_3_5').hide();

            let dt_flage = {{ $data->facility_type }};

            if(dt_flage == '1' || dt_flage == '3' || dt_flage == '5'){
                 $('.is_facility_1_3_5').show();
            }else{
                $('.is_teatcher_2').show();
            }

            jQuery('select[name="type_id"]').on('change',function(){
                var type_id = jQuery(this).val();

                if(type_id == '1' || type_id == '3' || type_id == '5'){
                 $('.is_facility_1_3_5').show();
                 $('.is_teatcher_2').hide();
                }else{
                    $('.is_teatcher_2').show();
                    $('.is_facility_1_3_5').hide();
                }


                if(type_id)
                {
                    jQuery.ajax({
                        url : '../../../admin/get_stages/' +type_id,
                        type : "GET",
                        dataType : "json",
                        success:function(data)
                        {
                            console.log(data);
                            jQuery('select[name="stages[]"]').empty();
                            jQuery.each(data, function(key,value){
                                $('select[name="stages[]"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                }
                else
                {
                    $('select[name="state"]').empty();
                }
            });
        });
    </script>


    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{asset('/dashboard')}}/dist/js/pages/forms/select2/select2.init.js"></script>
    <script>
        window.onload = function() {

             var latlng = new google.maps.LatLng({{ $data->map_location }});

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

