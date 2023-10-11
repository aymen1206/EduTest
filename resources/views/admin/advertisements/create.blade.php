@extends('admin.master.master')
@section('title')
   الاعلانات @lang('lang.add_new')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">الاعلانات @lang('lang.add_new')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/ads')}}"> الاعلانات </a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/ads/')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="col-md-12">عنوان الاعلان</label>
                                <div class="col-md-12">
                                    <input type="text" name="title" placeholder="عنوان الاعلان" required class="form-control form-control-line" value="{{old('title')}}">
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            </div>

                            <div class="form-group new-label-title">

                                <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                    صورة الاعلان
                                </label>
                                <div class="col-md-12">
                                    <input class="form-control" name="image" id="file-upload" type="file"/>
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> تفاصيل الاعلان </label>
                                <div class="col-md-12">
                                <textarea class="form-control" name="text" required rows="3" placeholder=" تفاصيل الاعلان">{{old('text')}}</textarea>
                                    <span class="text-danger">{{ $errors->first('text') }}</span>
                                </div>
                            </div>          

                            <div class="form-group">
                                <label class="col-md-12">سعر الاشتراك قبل الخصم</label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="price" class="form-control" required value="{{old('price')}}">
                                    <span class="text-danger">{{ $errors->first('price') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> سعر الاشتراك بعد الخصم </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="price_after_discount" class="form-control" required value="{{old('price_after_discount')}}">
                                    <span class="text-danger">{{ $errors->first('price_after_discount') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12"> تاريخ بداية الاعلان </label>
                                <div class="col-md-12">
                                    <input type="date" id="start_date" name="start_date" required class="form-control" value="{{old('start_date')}}">
                                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12"> تاريخ نهاية الاعلان </label>
                                <div class="col-md-12">
                                    <input type="date" id="end_date" name="end_date" required class="form-control" value="{{old('end_date')}}">
                                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> عدد المشتركين المسموح لهم بالاشتراك </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="subscribers_allowed_number" class="form-control" required value="{{old('subscribers_allowed_number')}}">
                                    <span class="text-danger">{{ $errors->first('subscribers_allowed_number') }}</span>
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

    <script type="text/javascript">

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        today = yyyy+'-'+mm+'-'+dd;
        let towmorow = yyyy+'-'+mm+'-'+(dd+1);
        document.getElementById("start_date").setAttribute("min", today);
        document.getElementById("end_date").setAttribute("min", towmorow);

    </script>


    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{asset('/dashboard')}}/dist/js/pages/forms/select2/select2.init.js"></script>
@endsection
