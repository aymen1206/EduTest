@extends('admin.master.master')
@section('title')
    تقييمات المنشئات
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> تقييمات المنشئات  </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/ratings')}}"> تقييمات المنشئات </a></li>
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
                        <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td> الطالب </td>
                                        <td>{{ $data->name }}</td>
                                    </tr>
                                    <tr>
                                        <td> المدرسة </td>
                                        <td><a href="{{ url('admin/edu-facilities/'.$data->facility_id) }}" title="@lang('lang.view')">{{ $data->facility_name }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>التقييم</td>
                                        <td>{{ $data->rate }}</td>
                                    </tr>
                                    <tr>
                                        <td> تاريخ التقييم </td>
                                        <td>{{ $data->created_at->locale('ar')->toDayDateTimeString() }}</td>
                                    </tr>
                                    <tr>
                                        <td> التعليق </td>
                                        <td>{{ $data->comment }}</td>
                                    </tr>
                                </tbody>
                        </table>
                        <div class="alert alert-info">
                            <span class="fas fa-exclamation-triangle"></span>
                             في حالة الموافقة علي التعليق يتم عرضه في الموقع ويمكن للمدرسة التحكم في عرضه او اخفائه من خلال لوحة التحكم الخاصة بها
                        </div>
                        @if($data->admin_approved == 0)
                            <a href="{{ url('/admin/ratings/'.$data->id.'/status') }}" class="btn btn-success"> الموافقة علي عرض التعليق </a>
                        @else
                            <a href="{{ url('/admin/ratings/'.$data->id.'/status') }}" class="btn btn-warning"> اخفاء التعليق </a>
                        @endif
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
@endsection

