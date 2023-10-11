@extends('edu-facility.master.master')
@section('title')
    @lang('lang.Profile_settings')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.Profile_settings')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active"><a href="{{url('/edu-facility/profile')}}">@lang('lang.Profile_settings')</a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('edu-facility/profile/')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="@lang('lang.name')" required class="form-control form-control-line" value="{{$data->name}}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.english_name') </label>
                                <div class="col-md-12">
                                    <input type="text" name="name_en" placeholder="@lang('lang.name') بالانجليزية" required class="form-control form-control-line" value="{{$data->name_en}}">
                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.about')</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="about" required rows="5" placeholder="@lang('lang.about')">{{$data->about}}</textarea>
                                    <span class="text-danger">{{ $errors->first('about') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.text_en')</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="about_en" required rows="5">{{$data->about_en}}</textarea>
                                    <span class="text-danger">{{ $errors->first('about_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                    <label class="col-md-12">@lang('lang.type')</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="type_id" required aria-label="Default select example">
                                            <option value="" selected disabled> @lang('lang.please_select_the_type_of_educational_facility') </option>
                                            @foreach($data2 as $dt)
                                                <option @if($data->facility_type == $dt->id) selected @endif value="{{$dt->id}}"> {{lng($dt,'name')}} </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('type_id') }}</span>
                                    </div>
                                </div>


                                <div class="form-group">

                                    <label class="col-md-12">@lang('lang.stage')</label>

                                    <div class="col-md-12">
                                        <select name="facility_types[]" id="select_2" class="select2 form-control select2-hidden-accessible" multiple="" style="height: 36px;width: 100%;" data-select2-id="13" tabindex="-1" aria-hidden="true">
                                            @foreach($current_types as $ct)
                                                <option value="{{$ct->id}}" selected>{{ lng($ct,'name') }}</option>
                                            @endforeach
                                             @foreach($data3 as $dt3)
                                                <option value="{{$dt3->id}}">{{ lng($dt3,'name') }}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger">{{ $errors->first('stages') }}</span>
                                    </div>
                                </div>




                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.phone')</label>
                                <div class="col-md-12">
                                    <input type="tel" name="phone" class="form-control" required placeholder="05XXXXXXXXX" value="{{$data->phone}}">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.mobile')</label>
                                <div class="col-md-12">
                                    <input type="text" name="mobile" class="form-control" required placeholder="05XXXXXXXXX" value="{{$data->mobile}}">
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12">@lang('lang.email')</label>
                                <div class="col-md-12">
                                    <input type="email" name="email" required class="form-control" id="exampleFormControlInput1"
                                           placeholder="name@example.com" value="{{$data->email}}">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.city')</label>
                                <div class="col-md-12">
                                   <select name="city" required class="form-control p-2">
                                    @foreach(DB::table('cities')->get() as $city)
                                        <option @if($data->city == $city->id) selected @endif value="{{ $city->id }}">
                                            @if(LaravelLocalization::getCurrentLocaleNative() == 'العربية')
                                                {{ $city->nameAr }}
                                            @else
                                                {{ $city->nameEn }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12"> @lang('lang.address') </label>
                                <div class="col-md-12">
                                    <input type="text" name="address" required class="form-control" id="exampleFormControlInput1"  value="{{$data->address}}">
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12"> @lang('lang.address_en')</label>
                                <div class="col-md-12">
                                    <input type="text" name="address_en" required class="form-control" id="exampleFormControlInput1"  value="{{$data->address_en}}">
                                    <span class="text-danger">{{ $errors->first('address_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.map_location')</label>
                                <div class="col-md-12">
                                     <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBYk-bPGA2YW221CLysrZW7_4od9x5G90Y&sensor=false"></script>
                                    <div style="height:200px;" id="map"></div>
                                    <input type="hidden" name="map_location" id="map_location" value="{{$data->map_location}}">
                                </div>

                            </div>

                           <div class="is_facility_1_3_5">

                                <div class="form-group new-label-title">

                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.commercial_attach')
                                    </label>
                                    <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->commercial_record)}}">
                                    <div class="col-md-12">
                                        <input class="form-control" name="commercial_record" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('commercial_record') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.owner_id_attach')
                                    </label>
                                    <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->owner_id)}}">
                                    <div class="col-md-12">
                                        <input class="form-control" name="owner_id" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('owner_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">

                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.logo_attach')
                                    </label>
                                    <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->logo)}}">
                                    <div class="col-md-12">
                                        <input class="form-control" name="logo" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    </div>
                                </div>
                             </div>


                                <div class="is_teatcher_2">

                                    <div class="email-repeater form-group col-md-12 teacher">
                                        <label for=""> التخصصات </label>

                                        <div class="row ">
                                            @foreach( \DB::table('specialties')->where('facility_id',$data->id)->get() as $kky => $sp )
                                                <div class="col-3">
                                                    <div style="padding: 10px; border: 1px solid grey; border-radius: 5px">
                                                        <img src="{{asset($sp->image)}}" style="width: 100%; height: 150px;">
                                                        <h6 class="mt-2"> {{$sp->title}} </h6>
                                                        <hr>
                                                        <a class="btn btn-sm btn-danger" href="{{url('edu-facility/sp/delete/'.$sp->id)}}"> <span class="fa fa-trash"></span> حذف </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div data-repeater-list="specialties_group">
                                            <div data-repeater-item class="row m-b-15">
                                                <div class="col-md-5">
                                                    <label> اسم التخصص </label>
                                                    <input type="text"  name="title" class="form-control" placeholder="التخصص">
                                                </div>
                                                <div class="col-md-5">
                                                    <label> شهادة التخصص </label>
                                                    <input type="file"  name="file" class="form-control">
                                                </div>
                                                <div class="col-md-1">
                                                    <label> حذف </label>
                                                    <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light" type="button"><i class="ti-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-repeater-create="" class="btn btn-outline-dark waves-effect waves-light"> اضافة تخصص </button>
                                    </div>

                                    <div class="form-group new-label-title">
                                        <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                            هوية المعلم
                                        </label>
                                        <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->teacher_id)}}">
                                        <div class="col-md-12">
                                            <input class="form-control" name="teacher_id" id="file-upload" type="file"/>
                                            <span class="text-danger">{{ $errors->first('teacher_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group new-label-title">
                                        <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                            شهادة التخصص
                                        </label>
                                        <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->sp_image)}}">
                                        <div class="col-md-12">
                                            <input class="form-control" name="sp_image" id="file-upload" type="file"/>
                                            <span class="text-danger">{{ $errors->first('sp_image') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group new-label-title">
                                        <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                            الصورة الشخصية
                                        </label>
                                        <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->profile_image)}}">
                                        <div class="col-md-12">
                                            <input class="form-control" name="profile_image" id="file-upload" type="file"/>
                                            <span class="text-danger">{{ $errors->first('profile_image') }}</span>
                                        </div>
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

            let dt_flage = {{ $data->facility_type }}

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
                        url : '../../../edu-facility/get_facility_types/' +type_id,
                        type : "GET",
                        dataType : "json",
                        success:function(data)
                        {
                            console.log(data);
                            jQuery('select[name="facility_types[]"]').empty();
                            jQuery.each(data, function(key,value){
                                $('select[name="facility_types[]"]').append('<option value="'+ key +'">'+ value +'</option>');
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

