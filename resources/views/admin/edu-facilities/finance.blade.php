@extends('admin.master.master')
@section('title')
    @lang('lang.Profile_finance_settings')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">
    @php
        $dt = json_decode($data->json , true);
    @endphp

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.Profile_finance_settings')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/edu-facilities')}}">المشتركين</a></li>
                            <li class="breadcrumb-item active">@lang('lang.Profile_finance_settings')</li>
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
                              action="{{url('admin/finance-profile/update/'.$data->facility_id)}}">
                            @csrf

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.iban')</label>
                                <div class="col-md-12">
                                    <input type="text" name="iban" placeholder="@lang('lang.iban')" required
                                           class="form-control form-control-line" value="{{$data->iban}}">
                                    <span class="text-danger">{{ $errors->first('iban') }}</span>
                                </div>
                            </div>

                            <h6>  @lang('lang.contact_info') </h6>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.first_name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="first" placeholder="@lang('lang.first_name')" required
                                           class="form-control form-control-line" value="{{$data->first}}">
                                    <span class="text-danger">{{ $errors->first('first') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.middle_name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="middle" placeholder="@lang('lang.middle_name')" required
                                           class="form-control form-control-line" value="{{$data->middle}}">
                                    <span class="text-danger">{{ $errors->first('middle') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.last_name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="last" placeholder="@lang('lang.last_name')" required
                                           class="form-control form-control-line" value="{{$data->last}}">
                                    <span class="text-danger">{{ $errors->first('last') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.email')</label>
                                <div class="col-md-12">
                                    <input type="email" name="email" placeholder="@lang('lang.email')" required
                                           class="form-control form-control-line" value="{{$data->email}}">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.phone')</label>
                                <div class="col-md-12">
                                    <input type="text" name="phone" placeholder="@lang('lang.phone')" required
                                           class="form-control form-control-line" value="{{$data->phone}}">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>
                            @if($dt == null)
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info btn-sm">@lang('lang.update') </button>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>

                    @if($dt != null)
                        <div class="card-body">
                            <h6> @lang('lang.status') </h6>
                            @if(isset($dt['id']))
                                <div class="alert alert-success">

                                    <ul>
                                        <li> معرف المدرسة {{  ' : '.$dt['id']  }}</li>
                                        <li>  @lang('lang.status') {{  ' : '.$dt['status']  }}</li>
                                        <li> معرف عملية الدفع {{  ' : '.$dt['destination_id']  }}</li>
                                    </ul>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    <h6> حدث خطأ اثناء انشاء بيانات الدفع والتحويل من فضلك تأكد من البيانات الاتية
                                        : </h6>
                                    <ul>
                                        <li> يجب التأكد من ان كل الحقول في صفحة البروفايل تم ادخالها بشكل صحيح <a
                                                    target="_blank" href="{{ url
                                    ('edu-facility/profile')
                                    }}">اضغط هنا </a></li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection

@section('custom-javascript')
    <script src="{{asset('dashboard/assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/extra-libs/jquery.repeater/repeater-init.js')}}"></script>
    <script src="{{asset('dashboard/assets/extra-libs/jquery.repeater/dff.js')}}"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{asset('/dashboard')}}/dist/js/pages/forms/select2/select2.init.js"></script>
@endsection

