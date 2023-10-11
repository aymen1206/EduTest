@extends('edu-facility.master.master')
@section('title')
      @lang('lang.Subscription_prices')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.Subscription_prices') </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility/prices')}}">@lang('lang.Subscription_prices') </a></li>
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
                                        <td>@lang('lang.name')</td>
                                        <td>{{ $data->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.english_name')</td>
                                        <td>{{ $data->name_en }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.stage')</td>
                                        <td>{{ lng($data->_type,'name') }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.class')</td>
                                        <td>{{ lng($data->_stage,'name') }}</td>
                                    </tr>
                                    @if($data->subject != null)
                                    <tr>
                                        <td>@lang('lang.subject')</td>
                                        <td>{{ DB::table('subjects')->where('id',$data->subject)->first()->name }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>@lang('lang.payment_method')</td>
                                        <td>{{ lng($data->subscriptionperiod,'name') }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.before_discount')</td>
                                        <td>{{ $data->price_discount }} @lang('lang.sar') </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.saving')</td>
                                        <td>
                                            @if(isset($data->price_discount) == true)
                                                {{ $data->price_discount - $data->price }}  @lang('lang.sar')
                                                <br>
                                               ( {{ floor((($data->price_discount - $data->price) / $data->price_discount ) * 100)}} % )
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.after_discount')</td>
                                        <td>{{ $data->price }}@lang('lang.sar') </td>
                                    </tr>
                            
                                    <tr>
                                        <td>@lang('lang.The_total_number_of_students') </td>
                                        <td>{{ $data->allowed_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.note')</td>
                                        <td>{!! nl2br($data->note) !!}</td>
                                    </tr>
                                    <tr>
                                        <td>@lang('lang.note_en')</td>
                                        <td>{!! nl2br($data->note_en) !!}</td>
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

