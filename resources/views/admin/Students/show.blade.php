@extends('admin.master.master')
@section('title')
    {{ $data->name }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> {{$data->name}} </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/edu-facilities')}}">أولياء الامور</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$data->name}}</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{url('admin/student/'.$data->id.'/edit')}}" title=" تعديل البيانات" class="btn btn-sm btn-warning float-left"> <i class="fa fa-edit"></i> تعديل البيانات</a>
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
                                <td>الاسم</td>
                                <td>{{$data->name}}</td>
                            </tr>
                            <tr>
                                <td>  الاسم بالانجليزية </td>
                                <td>{{$data->name_en}}</td>
                            </tr>
                            <tr>
                                <td>صورة شخصية</td>
                                    <td><img width="50" src="{{asset($data->image)}}"
                                                 onerror="this.src='{{ asset('images/Students.png')  }}'">
                                    </td>
                            </tr>
                            <tr>
                                <td>تاريخ الاشتراك</td>
                                <td>{{$data->created_at}}</td>
                            </tr>
                            <tr>
                                <td> اسم ولي الأمر </td>
                                @if(!is_null($data->guardian_name))
                                <td>{{$data->guardian_name}}</td>
                                @else
                                <td>لم يحدد بعد</td>
                                @endif
                            </tr>
                            <tr>
                                <td>هوية الطالب</td>
                                @if(!empty($data->id_number))
                                <td>{{$data->id_number}}</td>
                                @else
                                <td>لم يحدد بعد</td>
                                @endif
                            </tr>
                            <tr>
                                <td>هوية ولي الامر</td>
                                @if(!is_null($data->guardian_id_number))
                                <td>{{$data->guardian_id_number}}</td>
                                @else
                                <td>لم يحدد بعد</td>
                                @endif
                            </tr>

                            <tr>
                                <td>صورة الهوية</td>
                                <td><img width="100" src="{{asset($data->id_image)}}"
                                                 onerror="this.src='{{ asset('images/id-card.png')  }}'"></td>
                            </tr>


                            <tr>
                                <td>صورة هوية ولي الامر</td>
                                <td><img width="100" src="{{asset($data->family_id_image)}}"
                                                 onerror="this.src='{{ asset('images/id-card.png')  }}'"></td>
                            </tr>
                            <tr>
                                <td>الجوال</td>
                                <td>{{$data->phone}}</td>
                            </tr>
                            <tr>
                                <td>البريد الالكتروني</td>
                                <td>{{$data->email}}</td>
                            </tr>
                            <tr>
                                <td>المدينة</td>
                                <td>{{$data->citys->nameAr}}</td>
                            </tr>
                            <tr>
                                <td>صورة الشهادة</td>
                                <td><img width="100" src="{{asset($data->certificate_image)}}"
                                                 onerror="this.src='{{ asset('images/certificate.png')  }}'"></td>
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

