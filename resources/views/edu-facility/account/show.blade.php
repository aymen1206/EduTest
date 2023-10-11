@extends('edu-facility.master.master')
@section('title')
    {{ lng($data,'name') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> {{ lng($data,'name') }} </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ lng($data,'name') }}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{url('edu-facility/profile')}}" title="@lang('lang.edit')" class="btn btn-sm btn-warning float-left"> <i class="fa fa-edit"></i> @lang('lang.edit') </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>@lang('lang.name')</td>
                                <td>{{$data->name}}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.english_name') </td>
                                <td>{{$data->name_en}}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.logo')</td>
                                <td><img width="50" src="{{asset($data->logo)}}" onerror="this.src='{{ asset('images/facility_default_logo.png')  }}'" > </td>
                            </tr>
                            <tr>
                                <td>@lang('lang.type') </td>
                                <td>{{ lng($data->type,'name') }}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.services')</td>
                                <td>
                                    @foreach($current_types as $ct)
                                        <span class="badge badge-cyan">{{lng($ct,'name') }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('lang.status')</td>
                                <td>
                                    @if ($data->status == 1)
                                        <a class="badge badge-success inactive-confirm" title="@lang('lang.Click_to_disable')" href="{{url('admin/edu-facilities/inactive/'.$data->id)}}">@lang('lang.active') </a>
                                    @else
                                        <a class="badge badge-warning active-confirm" title="@lang('lang.Click_to_activate')"  href="{{url('admin/edu-facilities/active/'.$data->id)}}">@lang('lang.inactive')  </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('lang.Subscription_date')</td>
                                <td>{{$data->created_at}}</td>
                            </tr>

                            <tr>
                                <td>@lang('lang.phone')</td>
                                <td>{{$data->phone}}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.mobile')</td>
                                <td>{{$data->mobile}}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.email')</td>
                                <td>{{$data->email}}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.city')</td>
                                <td>
                                    @if(LaravelLocalization::getCurrentLocaleNative() == 'العربية')
                                        {{DB::table('cities')->where('id',$data->city)->first()->nameAr}}
                                    @else
                                        {{DB::table('cities')->where('id',$data->city)->first()->nameEn}}
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td>@lang('lang.address')</td>
                                <td>{{$data->address}}</td>
                            </tr>
                            <tr>
                                <td> @lang('lang.address_en')</td>
                                <td>{{$data->address_en}}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.map_location')</td>
                                <td>
                                    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBYk-bPGA2YW221CLysrZW7_4od9x5G90Y&sensor=false"></script>
                                    <div style="height:200px;" id="map"></div>
                                </td>
                            </tr>

                            <div class="is_facility_1_3_5">
                                <tr>
                                    <td> @lang('lang.commercial_attach')</td>
                                    <td><img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->commercial_record)}}"></td>
                                </tr>
                                <tr>
                                    <td> @lang('lang.owner_id_attach')</td>
                                    <td><img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->owner_id)}}"></td>
                                </tr>
                                <tr>
                                    <td> @lang('lang.logo_attach')</td>
                                    <td><img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->logo)}}"></td>
                                </tr>
                            </div>

                            <div class="is_teatcher_2" style="display: none !important;">
                                <tr style="display: none !important;">
                                    <td> هوية المعلم</td>
                                    <td><img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->teacher_id)}}"></td>
                                </tr >
                                <tr style="display: none !important;">
                                    <td> شهادة التخصص </td>
                                    <td><img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->sp_image)}}"></td>
                                </tr>
                                <tr style="display: none !important;">
                                    <td>الصورة الشخصية</td>
                                    <td><img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->profile_image)}}"></td>
                                </tr>
                            </div>


                            <tr>
                                <td colspan="2">@lang('lang.text')</td>
                            </tr>
                            <tr>
                                <td colspan="2">{!! $data->about !!}</td>
                            </tr>

                            <tr>
                                <td colspan="2">@lang('lang.text_en')</td>
                            </tr>
                            <tr>
                                <td colspan="2">{!! $data->about_en !!}</td>
                            </tr>

                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection

@section('custom-javascript')
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

