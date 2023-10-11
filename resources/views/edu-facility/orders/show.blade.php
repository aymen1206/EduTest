@extends('edu-facility.master.master')
@section('title')
@lang('lang.orders')
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title"> @lang('lang.orders')</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/edu-facility/orders')}}"> @lang('lang.orders') </a></li>
                        <li class="breadcrumb-item active" aria-current="page"> @lang('lang.view_order_data') </li>
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
                    <h4 class="card-title mb-3">@lang('lang.orders')</h4>
                    <form class="form-horizontal form-material" id="confirm-form" method="post"
                        action="{{route('edu-facility.order')}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-md-12">@lang('lang.change_order_status')  </label>
                            <div class="col-md-12">
                                <select name="status" class="form-control" @if($data->status == 'is_paid') disabled @endif>
                                    <option value="new" @if($data->status == 'new') selected @endif> @lang('lang.new')</option>
                                    <option value="under_revision" @if($data->status == 'under_revision') selected @endif> @lang('lang.processing')</option>
                                    <option value="rejected" @if($data->status == 'rejected') selected @endif>@lang('lang.rejected') </option>
                                    <option value="accepted" @if($data->status == 'accepted') selected @endif>@lang('lang.accepted') </option>
                                    <option value="is_paid" @if($data->status == 'is_paid') selected @endif> @lang('lang.complete') </option>
                                </select>
                                <input type="" name="id" value="{{$data->id}}" hidden readonly>
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success change-confirm" @if($data->status == 'is_paid') disabled @endif>@lang('lang.update')</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-12">
                            <h4 class="text-center"> @lang('lang.order_data') </h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-bordered display">
                                    <tbody>

                                        <tr>
                                            <th>  @lang('lang.order_num')  : {{$data->id}}</th>

                                            <th> @lang('lang.the_date_of_application') : {{$data->created_at}}</th>
                                            <th> @lang('lang.latest_order_status_update') : {{$data->updated_at}}</th>
                                            <th>@lang('lang.status')  :
                                                @if($data->status == 'new')
                                                    @lang('lang.new')
                                                @elseif($data->status == 'under_revision')
                                                    @lang('lang.processing')
                                                @elseif($data->status == 'rejected')
                                                    @lang('lang.rejected')
                                                @elseif($data->status == 'accepted')
                                                    @lang('lang.accepted')
                                                @elseif($data->status == 'is_paid')
                                                    @lang('lang.complete')
                                                @endif

                                            </th>
                                            @if(isset($data->invoice))
                                            <th> @lang('lang.bill_num') :
                                                <a href="{{ $data->invoice->payment_url }}" target="_blank">
                                                    {{$data->InvoiceId}}
                                                </a>
                                            </th>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($invoice != null)
                            <div class="col-12">
                                <h4 class="text-center"> تم تقسيط هذا الطلب من تمارا <img width="70px" src="{{ asset
                                ('/images/tamara.png') }}">  </h4>
                                <div class="table-responsive">
                                    <table id="file_export" class="table table-bordered display">
                                        <tbody>

                                        <tr>
                                            <th>  رقم طلب التقسيط  : {{$invoice->order_id}}</th>

                                            <th> حالة الطلب : {{$invoice->status}}</th>
                                            <th> عدد الاقساط : {{$invoice->instalments}}</th>
                                            <th> اول قسط مدفوع : {{$invoice->paid_amount->amount}} ريال</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{--                                    @if($invoice->status != 'fully_captured')--}}

                                {{--                                        <a class="btn btn-success btn-sm" href="{{ url('edu-facility/orders/accept-tamara/'.$invoice->order_id)--}}
                                {{--                                        }}"> تفعيل الطلب مع تمارا </a>--}}

                                {{--                                    @endif--}}

                            </div>
                        @endif
                        <div class="col">
                            <h4 class="text-center">@lang('lang.Account_details')</h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-striped table-bordered display">
                                    <tbody>
                                        <tr>
                                            <th>@lang('lang.name') </th>
                                            <td>{{$data->studentdata->name}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.id_number')</th>
                                            <td>{{$data->studentdata->id_number}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.phone')</th>
                                            <td>{{$data->studentdata->phone}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.email') </th>
                                            <td>{{$data->studentdata->email}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.city') </th>
                                            <td>
                                                @if(LaravelLocalization::getCurrentLocaleNative() == 'العربية')
                                                    {{ DB::table('cities')->where('id',$data->studentdata->city)->first()->nameAr }}
                                                @else
                                                    {{ DB::table('cities')->where('id',$data->studentdata->city)->first()->nameEn }}
                                                @endif
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <h4 class="text-center">@lang('lang.Subscriber_data') </h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-striped table-bordered display">
                                    <tbody>
                                        @if ($data->children == 0 || $data->children == null )
                                        <tr>
                                            <th> @lang('lang.Subtype') </th>
                                            <td>
                                                @lang('lang.by_personal_account')
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> @lang('lang.profile_image')</th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->image) }}" class="fancybox">
                                                    @lang('lang.view') </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.id_number_photo') </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->id_image) }}"
                                                    class="fancybox">@lang('lang.view') </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.scientific_certificate_photo') </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->certificate_image) }}"
                                                    class="fancybox"> @lang('lang.view') </a>
                                            </td>
                                        </tr>

                                        @else
                                        <tr>
                                            <th>@lang('lang.Subtype') </th>
                                            <td>
                                                @lang('lang.subscribe_to_one_of_the_dependents')
                                            </td>

                                        <tr>
                                            <th> @lang('lang.st_name')</th>
                                            <td>
                                                {{ $data->childrendata->name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.gender') </th>
                                            <td>
                                                @if ($data->childrendata->gender == 'male')
                                                    @lang('lang.male')
                                                @else
                                                    @lang('lang.female')
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.st_birth_date') </th>
                                            <td>
                                                {{ $data->childrendata->birth_date }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.st_profile_photo') </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->childrendata->image) }}" class="fancybox">
                                                    @lang('lang.view') </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.family_id') </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->family_id_image) }}"
                                                    class="fancybox">@lang('lang.view') </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.st_ID_num')</th>
                                            <td>{{$data->childrendata->id_number}}</td>
                                        </tr>


                                        <tr>
                                            <th>@lang('lang.st_ID') </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->childrendata->id_image) }}"
                                                    class="fancybox">@lang('lang.view') </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.scientific_certificate_photo') </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->childrendata->certificate_image) }}"
                                                    class="fancybox"> @lang('lang.view') </a>
                                            </td>
                                        </tr>

                                        </tr>

                                        @endif

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="col">
                            <h4 class="text-center"> @lang('lang.subscription_package_data')  </h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-striped table-bordered display">
                                    <tbody>

                                        <tr>
                                            <th style="width:30%"> @lang('lang.package')</th>
                                            <td>{{lng($data->pricelist,'name')}}</td>
                                        </tr>

                                        <tr>
                                            <th style="width:30%">@lang('lang.stage')</th>
                                            <td>{{lng($data->pricelist->_type,'name')}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.class') </th>
                                            <td>{{lng($data->pricelist->_stage,'name')}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.payment_method') </th>
                                            <td>{{lng($data->pricelist->subscriptionperiod,'name')}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.price') </th>
                                            <td>{{$data->pricelist->price}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.The_total_number_of_students') </th>
                                            <td>{{$data->pricelist->allowed_number}}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.Reserved_places')</th>
                                            <td>{{ $data->pricelist->booked }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('lang.vacancies')</th>
                                            <td>{{ $data->pricelist->free }}</td>
                                        </tr>
                                        
                                        <tr>
                                            <th>@lang('lang.note') </th>
                                            <td>{{lng($data->pricelist,'note') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('custom-javascript')
<script type="text/javascript">
    $('.change-confirm').on('click', function (event) {
        event.preventDefault();
        swal({
            title: "@lang('lang.are_you_sure')",
            text: "@lang('lang.changing_the_status_of_the_order_entails_some_financial_matters_and_payment_processes')",
            icon: 'warning',
            buttons: ["@lang('lang.cancel')", "@lang('lang.update')"],
        }).then(function (value) {
            if (value) {
                $('#confirm-form').submit();
            }
        });
    });
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
