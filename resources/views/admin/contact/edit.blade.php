@extends('admin.master.master')
@section('title')
    بيانات الاتصال
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">تعديل بيانات الاتصال  </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/contact')}}">بيانات الاتصال  </a></li>
                            <li class="breadcrumb-item active" aria-current="page">تعديل بيانات الاتصال  </li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/contact/'.$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12">الهاتف</label>
                                <div class="col-md-12">
                                    <input type="text" name="phone"  required class="form-control form-control-line" value="{{$data->phone}}">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">الجوال</label>
                                <div class="col-md-12">
                                    <input type="text" name="mobile"  required class="form-control form-control-line" value="{{$data->mobile}}">
                                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">رقم الدعم الفني</label>
                                <div class="col-md-12">
                                    <input type="text" name="support"  required class="form-control form-control-line" value="{{$data->support}}">
                                    <span class="text-danger">{{ $errors->first('support') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12">البريد الالكتروني</label>
                                <div class="col-md-12">
                                    <input type="email" name="email"  required class="form-control form-control-line" value="{{$data->email}}">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">العنوان</label>
                                <div class="col-md-12">
                                    <input type="text" name="address"  required class="form-control form-control-line" value="{{$data->address}}">
                                    <span class="text-danger">{{ $errors->first('address') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> العنوان بالانجليزية </label>
                                <div class="col-md-12">
                                    <input type="text" name="address_en"  required class="form-control form-control-line" value="{{$data->address_en}}">
                                    <span class="text-danger">{{ $errors->first('address_en') }}</span>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="col-md-12">مواعيد العمل</label>
                                <div class="col-md-12">
                                    <input type="text" name="working_hours"  required class="form-control form-control-line" value="{{$data->working_hours}}">
                                    <span class="text-danger">{{ $errors->first('working_hours') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">مواعيد العمل بالانجليزية </label>
                                <div class="col-md-12">
                                    <input type="text" name="working_hours_en"  required class="form-control form-control-line" value="{{$data->working_hours_en}}">
                                    <span class="text-danger">{{ $errors->first('working_hours_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> الفيسبوك</label>
                                <div class="col-md-12">
                                    <input type="url" name="facebook"  required class="form-control form-control-line" value="{{$data->facebook}}">
                                    <span class="text-danger">{{ $errors->first('facebook') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> تويتر</label>
                                <div class="col-md-12">
                                    <input type="url" name="twitter"  required class="form-control form-control-line" value="{{$data->twitter}}">
                                    <span class="text-danger">{{ $errors->first('twitter') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> انستجرام</label>
                                <div class="col-md-12">
                                    <input type="url" name="insta"  required class="form-control form-control-line" value="{{$data->insta}}">
                                    <span class="text-danger">{{ $errors->first('insta') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> يوتيوب</label>
                                <div class="col-md-12">
                                    <input type="url" name="youtube"  required class="form-control form-control-line" value="{{$data->youtube}}">
                                    <span class="text-danger">{{ $errors->first('youtube') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> تيليجرام</label>
                                <div class="col-md-12">
                                    <input type="url" name="telegram"  required class="form-control form-control-line" value="{{$data->telegram}}">
                                    <span class="text-danger">{{ $errors->first('telegram') }}</span>
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
