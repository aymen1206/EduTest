@extends('edu-facility.master.master')
@section('title')
    تذاكر العملاء 
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> تذاكر العملاء </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility/messages')}}"> تذاكر العملاء </a></li>
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
                                        <td>الرقم المرجعي</td>
                                        <td>{{ $data->id }}</td>
                                    </tr>
                                    <tr>                                        
                                        <td> الاسم </td>
                                        <td>{{ $data->name }}</td>
                                    </tr>
                                    <tr>                                       
                                        <td>الهاتف</td>
                                        <td>{{ $data->phone }}</td>
                                    </tr>
                                    <tr>                                       
                                        <td>البريد الالكتروني</td>
                                        <td>{{ $data->email }}</td>
                                    </tr>
                                    <tr>                                       
                                        <td>موضوع الرسالة</td>
                                        <td>{{ $data->subject }}</td>
                                    </tr>
                                    <tr>                                       
                                        <td>نص الرسالة</td>
                                        <td>{!! nl2br($data->text) !!}</td>
                                    </tr> 
                                    <tr>
                                        <td colspan="2">
                                            <a href="mailto:{{ $data->email }}" title="الرد بواسطة البريد الالكتروني" class="btn btn-sm btn-success"> <i class="fa fa-envelope"></i> الرد علي التذكرة </a>
                                        </td>                                        
                                    </tr>                                   
                                </tbody>
                        </table>
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

