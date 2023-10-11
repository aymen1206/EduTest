@extends('edu-facility.master.master')
@section('title')
   @lang('lang.Subscription_prices') @lang('lang.add_new')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.Subscription_prices')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility/prices')}}"> @lang('lang.Subscription_prices') </a></li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('edu-facility/prices/')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label class="col-md-12"> @lang('lang.name') </label>
                                <div class="col-md-12">
                                    <input name="name" required class="form-control" placeholder="@lang('lang.write_a_title_like_sixth_grade_subscription')" value="{{old('name')}}">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">  @lang('lang.english_name') </label>
                                <div class="col-md-12">
                                    <input name="name_en" required placeholder="@lang('lang.write_a_title_like_sixth_grade_subscription')" class="form-control" value="{{old('name_en')}}">
                                    <span class="text-danger">{{ $errors->first('name_en') }}</span>
                                </div>
                            </div>


                                <div class="form-group">
                                    <label class="col-md-12">  @lang('lang.stage') </label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="type" required>
                                            <option value="" disabled selected> @lang('lang.stage') </option>
                                            @foreach($data['types'] as $dt)
                                                <option @if($data['facility']->type_id == $dt->id) selected @endif value="{{$dt->id}}"> {{lng($dt,'name')}} </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{ $errors->first('type') }}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"> @lang('lang.class') </label>
                                    <div class="col-md-12">
                                        <select name="stage" class="form-control">

                                        </select>

                                        <span class="text-danger">{{ $errors->first('stage') }}</span>
                                    </div>
                                </div>
                                @if(auth()->guard('edu_facility')->user()->facility_type == 2)
                                <div class="form-group">
                                    <label class="col-md-12"> @lang('lang.subject') </label>
                                    <div class="col-md-12">
                                            <select class="form-control" name="subject" required aria-label="Default select example">
                                                @foreach($data['subjects'] as $subject)
                                                    <option value="{{$subject->id}}"> {{$subject->name}} </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('subscription_period') }}</span>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label class="col-md-12">@lang('lang.payment_method') </label>
                                    <div class="col-md-12">
                                            <select class="form-control" name="subscription_period" required aria-label="Default select example">

                                            </select>
                                            <span class="text-danger">{{ $errors->first('subscription_period') }}</span>
                                    </div>
                                </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.before_discount') </label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="price_discount" class="form-control" placeholder="@lang('lang.before_discount')"  value="{{old('price_discount')}}">
                                    <span class="text-danger">{{ $errors->first('price_discount') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.after_discount')</label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="price" class="form-control" placeholder="@lang('lang.after_discount')" required value="{{old('price')}}">
                                    <span class="text-danger">{{ $errors->first('price') }}</span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.The_total_number_of_students')</label>
                                <div class="col-md-12">
                                    <input type="number" min="0" name="allowed_number" placeholder="@lang('lang.The_total_number_of_students')" class="form-control" required value="{{old('allowed_number')}}">
                                    <span class="text-danger">{{ $errors->first('allowed_number') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> @lang('lang.note') </label>
                                <div class="col-md-12">
                                    <textarea name="note" rows="10" class="form-control" placeholder="@lang('lang.note')"></textarea>
                                    <span class="text-danger">{{ $errors->first('note') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.note_en') </label>
                                <div class="col-md-12">
                                    <textarea name="note_en" rows="10" placeholder="@lang('lang.note_en')" class="form-control"></textarea>
                                    <span class="text-danger">{{ $errors->first('note_en') }}</span>
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
     jQuery(document).ready(function ()
        {
            jQuery('select[name="type"]').on('change',function(){
                var type_id = jQuery(this).val();
                if(type_id)
                {
                    jQuery.ajax({
                        url : '../../../edu-facility/get_stages/' +type_id,
                        type : "GET",
                        dataType : "json",
                        success:function(data)
                        {
                            jQuery('select[name="stage"]').empty();
                            jQuery.each(data, function(key,value){
                                $('select[name="stage"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });

                    jQuery.ajax({
                        url : '../../../edu-facility/get_payment_methods/' +type_id,
                        type : "GET",
                        dataType : "json",
                        success:function(data)
                        {
                            jQuery('select[name="subscription_period"]').empty();
                            jQuery.each(data, function(key,value){
                                $('select[name="subscription_period"]').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });

                }
                else
                {
                    $('select[name="state"]').empty();
                    $('select[name="subscription_period"]').empty();
                }
            });
        });

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
