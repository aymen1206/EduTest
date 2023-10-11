@extends('edu-facility.master.master')
@section('title')
    الاعلانات @lang('lang.update')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> الاعلانات @lang('lang.update')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility/ads')}}"> الاعلانات </a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('edu-facility/ads/'.$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12">عنوان الاعلان</label>
                                <div class="col-md-12">
                                    <input type="text" name="title" placeholder="عنوان الاعلان" required class="form-control form-control-line" value="{{$data->title}}">
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                </div>
                            </div>

                            <div class="form-group new-label-title">

                                <label class="col-md-12" for="file-upload" class="custom-file-upload">
                                    صورة الاعلان
                                </label>
                                <img width="250" class="img-thumbnail rounded mb-2" src="{{asset($data->image)}}">
                                <div class="col-md-12">
                                    <input class="form-control" name="image" id="file-upload" type="file"/>
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> تفاصيل الاعلان </label>
                                <div class="col-md-12">
                                    <textarea class="form-control" name="text" required rows="3" placeholder=" تفاصيل الاعلان">{!! $data->text !!}</textarea>
                                    <span class="text-danger">{{ $errors->first('text') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.stages')</label>
                                <div class="col-md-12">


                                    @if(auth()->guard('edu_facility')->user()->facility_type == 1)
                                        <select name="stage" class="form-control">
                                            @foreach($stages as $key=>$stage)
                                                <option @if($data->stage == $stage->id) selected @endif value="{{$stage->id}}">{{$stage->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('stage') }}</span>
                                    @elseif(auth()->guard('edu_facility')->user()->facility_type == 3)
                                        <select name="center_type" class="form-control">
                                            @foreach($center_types as $ctype)
                                                <option  @if($data->center_type == $ctype->id) selected @endif value="{{$ctype->id}}"> {{$ctype->name}} </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('center_type') }}</span>

                                    @elseif(auth()->guard('edu_facility')->user()->facility_type == 2)
                                        <select name="facility_type" class="form-control">
                                            @foreach($teacher_types as $teacher_type)
                                                <option  @if($data->facility_type == $teacher_type->id) selected @endif value="{{$teacher_type->id}}"> {{$teacher_type->name}} </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('facility_type') }}</span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">سعر الاشتراك قبل الخصم</label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="price" class="form-control" required value="{{$data->price}}">
                                    <span class="text-danger">{{ $errors->first('price') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> سعر الاشتراك بعد الخصم </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="price_after_discount" class="form-control" required value="{{$data->price_after_discount}}">
                                    <span class="text-danger">{{ $errors->first('price_after_discount') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12"> تاريخ بداية الاعلان </label>
                                <div class="col-md-12">
                                    <input type="date" id="start_date" name="start_date" required class="form-control" value="{{$data->start_date}}">
                                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="col-md-12"> تاريخ نهاية الاعلان </label>
                                <div class="col-md-12">
                                    <input type="date" id="end_date" name="end_date" required class="form-control" value="{{$data->end_date}}">
                                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> عدد المشتركين المسموح لهم بالاشتراك </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="subscribers_allowed_number" class="form-control" required value="{{$data->subscribers_allowed_number}}">
                                    <span class="text-danger">{{ $errors->first('subscribers_allowed_number') }}</span>
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

    <script type="text/javascript">

        jQuery(document).ready(function ()
        {
            jQuery('select[name="type_id"]').on('change',function(){
                var type_id = jQuery(this).val();
                if(type_id)
                {
                    jQuery.ajax({
                        url : '../../../edu-facility/get_stages/' +type_id,
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
@endsection

