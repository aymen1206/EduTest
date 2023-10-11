@extends('admin.master.master')
@section('title')
    المشتركين @lang('lang.add_new')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">المشتركين @lang('lang.add_new')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/edu-facilities')}}">المشتركين</a></li>
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
                        <form class="form-horizontal form-material" method="post"
                              action="{{url('admin/edu-facilities/')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="col-md-12"> نوع المشترك </label>
                                <div class="col-md-12">
                                    <select name="facility_type" id="facility_type" class="form-control">
                                        @foreach(App\Models\Type::all() as $ty)
                                            <option value="{{$ty->id}}"> {{$ty->name}} </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('type') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="@lang('lang.name')" required
                                           class="form-control form-control-line" value="{{old('name')}}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.name') بالانجليزية </label>
                                <div class="col-md-12">
                                    <input type="text" name="name_en" placeholder="@lang('lang.name') بالانجليزية" required
                                           class="form-control form-control-line" value="{{old('name_en')}}">
                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.about')</label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="about" required rows="3"
                                              placeholder="@lang('lang.about')">{{old('about')}}</textarea>
                                    <span class="text-danger">{{ $errors->first('about') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.about') بالانجليزية </label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="about_en" required rows="3"
                                              placeholder="@lang('lang.about') بالانجليزية">{{old('about_en')}}</textarea>
                                    <span class="text-danger">{{ $errors->first('about_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group facility">
                                <label class="col-md-12">@lang('lang.facilities_type')</label>
                                <div class="col-md-12">
                                    <select class="form-control" name="type_id" required
                                            aria-label="Default select example">
                                        @foreach($data as $dt)
                                            <option value="{{$dt->id}}"> {{$dt->name}} </option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('type_id') }}</span>
                                </div>
                            </div>


                            <div class="form-group facility">
                                <label class="col-md-12">@lang('lang.stages')</label>
                                <div class="col-md-12">
                                    <select name="stages[]" id="select_2"
                                            class="select2 form-control select2-hidden-accessible" multiple=""
                                            style="height: 36px;width: 100%;" data-select2-id="13" tabindex="-1"
                                            aria-hidden="true">

                                    </select>

                                    <span class="text-danger">{{ $errors->first('stages') }}</span>
                                </div>
                            </div>

                            <div class="form-group" id="center_types">
                                <label class="col-md-12"> نوع المركز التدريبي </label>
                                <div class="col-md-12">
                                    <select name="center_types[]" id="select_22"
                                            class="select2 form-control select2-hidden-accessible" multiple=""
                                            style="height: 36px;width: 100%;" data-select2-id="132" tabindex="-1"
                                            aria-hidden="true">
                                        @foreach(\App\Models\CenterTypes::all() as $ctype)
                                            <option value="{{$ctype->id}}"> {{$ctype->name}} </option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger">{{ $errors->first('center_types') }}</span>
                                </div>
                            </div>


                            <div class="form-group teacher">
                                <label class="col-md-12"> المرحلة التعليمية </label>
                                <div class="col-md-12">
                                    <select name="facility_types[]" id="select_2d"
                                            class="select2 form-control select2-hidden-accessible" multiple=""
                                            style="height: 36px;width: 100%;" data-select2-id="142" tabindex="-1"
                                            aria-hidden="true">
                                        @foreach(\App\Models\EduFacilitiesType::all() as $typ)
                                            <option value="{{$typ->id}}"> {{$typ->name}} </option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger">{{ $errors->first('facility_types') }}</span>
                                </div>
                            </div>

                            <div class="email-repeater form-group col-md-12 m-b-20 teacher">
                                <label for=""> التخصصات </label>
                                <div data-repeater-list="specialties_group">
                                    <div data-repeater-item class="row m-b-15">
                                        <div class="col-md-5">
                                            <label> اسم التخصص </label>
                                            <input type="text" required name="title" class="form-control"
                                                   placeholder="التخصص">
                                        </div>
                                        <div class="col-md-5">
                                            <label> شهادة التخصص </label>
                                            <input type="file" required name="file" class="form-control">
                                        </div>
                                        <div class="col-md-1">
                                            <label> حذف </label>
                                            <button data-repeater-delete=""
                                                    class="btn btn-danger waves-effect waves-light" type="button"><i
                                                    class="ti-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" data-repeater-create=""
                                        class="btn btn-outline-dark waves-effect waves-light"> اضافة تخصص
                                </button>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.phone')</label>
                                <div class="col-md-12">
                                    <input type="tel" name="phone" class="form-control" required
                                           placeholder="05XXXXXXXXX" value="{{old('phone')}}">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.mobile')</label>
                                <div class="col-md-12">
                                    <input type="text" name="mobile" class="form-control" required
                                           placeholder="05XXXXXXXXX" value="{{old('mobile')}}">
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12">@lang('lang.email')</label>
                                <div class="col-md-12">
                                    <input type="email" name="email" required class="form-control"
                                           id="exampleFormControlInput1"
                                           placeholder="name@example.com" value="{{old('email')}}">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.country')</label>
                                <div class="col-md-12">
                                    <input type="text" name="country" class="form-control" required
                                           value="{{old('country')}}" placeholder="@lang('lang.country_example')">
                                    <span class="text-danger">{{ $errors->first('country') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.city')</label>
                                <div class="col-md-12">
                                    <input type="text" name="city" class="form-control" required value="{{old('city')}}"
                                           placeholder="@lang('lang.city_example')">
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">العنوان</label>
                                <div class="col-md-12">
                                    <input type="text" name="address" class="form-control" required value="{{old('address')}}"
                                           placeholder="العنوان">
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">العنوان بالانجليزية </label>
                                <div class="col-md-12">
                                    <input type="text" name="address_en" class="form-control" required value="{{old('address_en')}}"
                                           placeholder="العنوان">
                                    <span class="text-danger">{{ $errors->first('address_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.map_location')</label>
                                <div class="col-md-12">
                                    <input type="text" name="map_location" class="form-control" required
                                           value="{{old('map_location')}}" placeholder="@lang('lang.city_example')">
                                    <span class="text-danger">{{ $errors->first('map_location') }}</span>
                                </div>
                                {{--                                <div class="select-location-map col-md-12"><i class="fas fa-street-view"></i></div>--}}
                            </div>

                            <div id="edu">
                                <div class="form-group new-label-title">

                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.commercial_attach')
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="commercial_record" id="file-upload"
                                               type="file"/>
                                        <span class="text-danger">{{ $errors->first('commercial_record') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.owner_id_attach')
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="owner_id" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('owner_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        @lang('lang.logo_attach')
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="logo" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('logo') }}</span>
                                    </div>
                                </div>

                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        الصورة الاساسية
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="image" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    </div>
                                </div>

                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        البانر
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="banner" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('banner') }}</span>
                                    </div>
                                </div>

                            </div>

                            <div class="teacher">
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        هوية المعلم
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="teacher_id" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('teacher_id') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        شهادة التخصص
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="sp_image" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('sp_image') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        الصورة الشخصية
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="profile_image" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('profile_image') }}</span>
                                    </div>
                                </div>
                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        الصورة الاساسية
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="image" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    </div>
                                </div>

                                <div class="form-group new-label-title">
                                    <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                        البانر
                                    </label>
                                    <div class="col-md-12">
                                        <input class="form-control" name="banner" id="file-upload" type="file"/>
                                        <span class="text-danger">{{ $errors->first('banner') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput2" class="col-md-12">@lang('lang.password')</label>
                                <div class="col-md-12">
                                    <input type="password" name="password" required class="form-control"
                                           id="exampleFormControlInput2"
                                           placeholder="***************">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput2"
                                       class="col-md-12">@lang('lang.confirm_password')</label>
                                <div class="col-md-12">
                                    <input type="password" name="password_confirmation" class="form-control" required
                                           id="exampleFormControlInput2"
                                           placeholder="***************">
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>

                            <div class="row">

                                <label dir="ltr" class="col-12 check-container"> @lang('lang.legal_confirm')
                                    <input type="checkbox" name="legal_agreement" checked="">
                                    <span class="checkmark"></span>
                                </label>
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

    <script src="{{asset('dashboard/assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/extra-libs/jquery.repeater/repeater-init.js')}}"></script>
    <script src="{{asset('dashboard/assets/extra-libs/jquery.repeater/dff.js')}}"></script>


    <script type="text/javascript">

        jQuery(document).ready(function () {
            $('#center_types').hide();
            $('.teacher').hide();

            $('#facility_type').on('change', function () {
                if ($(this).val() == 3) {
                    $('#center_types').show();
                    $('#edu').show();
                    $('.teacher').hide();
                    $('.facility').hide();
                }

                if ($(this).val() == 1) {
                    $('#center_types').hide();
                    $('.teacher').hide();
                    $('.facility').show();
                    $('#edu').show();
                }

                if ($(this).val() == 2) {
                    $('#center_types').hide();
                    $('.facility').hide();
                    $('#edu').hide();
                    $('.teacher').show();
                }

            });

            jQuery('select[name="type_id"]').on('change', function () {
                var type_id = jQuery(this).val();
                if (type_id) {
                    jQuery.ajax({
                        url: '../../admin/get_stages/' + type_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            jQuery('select[name="stages[]"]').empty();
                            jQuery.each(data, function (key, value) {
                                $('select[name="stages[]"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="state"]').empty();
                }
            });
        });
    </script>


    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{asset('/dashboard')}}/dist/js/pages/forms/select2/select2.init.js"></script>
@endsection
