@extends('admin.master.master')
@section('title')
    الطلبات
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title"> الطلبات</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/orders')}}"> الطلبات </a></li>
                        <li class="breadcrumb-item active" aria-current="page"> عرض بيانات طلب </li>
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
                    <h4 class="card-title mb-3">الطلبات</h4>
                    <form class="form-horizontal form-material" id="confirm-form" method="post"
                        action="{{url('edu-facility/orders/'.$data->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="col-md-12"> تغيير حالة الطلب </label>
                            <div class="col-md-12">
                                <select name="status" class="form-control" @if($data->status == 'is_paid') disabled @endif >
                                    <option value="new" @if($data->status == 'new') selected @endif>طلب جديد</option>
                                    <option value="under_revision" @if($data->status == 'under_revision') selected @endif>قيد المراجعة</option>
                                    <option value="rejected" @if($data->status == 'rejected') selected @endif>مرفوض</option>
                                    <option value="accepted" @if($data->status == 'accepted') selected @endif>مقبول</option>
                                    <option value="is_paid" @if($data->status == 'is_paid') selected @endif>مكتمل</option>
                                </select>

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
                            <h4 class="text-center"> بيانات الطلب </h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-bordered display">
                                    <tbody>

                                        <tr>
                                            <th> رقم الطلب : {{$data->id}}</th>

                                            <th> وقت ارسال الطلب : {{$data->created_at}}</th>
                                            <th> اخر تحديث لحالة الطلب : {{$data->updated_at}}</th>
                                            <th>حالة الطلب :
                                                @if($data->status == 'new')
                                                جديد
                                                @elseif($data->status == 'under_revision')
                                                قيد المراجعة
                                                @elseif($data->status == 'rejected')
                                                مرفوض
                                                @elseif($data->status == 'accepted')
                                                مقبول
                                                @elseif($data->status == 'is_paid')
                                                    مكتمل
                                                @endif
                                            </th>

                                            @if($data->invoice)
                                            <th> الفاتورة :
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
                        <div class="col">
                            <h4 class="text-center"> بيانات الحساب </h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-striped table-bordered display">
                                    <tbody>
                                    <tr>
                                        <th>الاسم</th>
                                        <td>{{$data->studentdata->name}}</td>
                                    </tr>

                                    <tr>
                                        <th>رقم الهوية</th>
                                        <td>
                                            @if($data->studentdata->id_number)
                                                {{$data->studentdata->id_number}}</td>
                                        @else
                                            غير متوفر
                                        @endif

                                    </tr>

                                    <tr>
                                        <th>رقم الجوال</th>
                                        <td>{{$data->studentdata->phone}}</td>
                                    </tr>

                                    <tr>
                                        <th> البريد الالكتروني</th>
                                            <td>{{$data->studentdata->email}}</td>
                                        </tr>

                                        <tr>
                                            <th> المدينة </th>
                                            <td>  {{ DB::table('cities')->where('id',$data->studentdata->city)->first()->nameAr }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <h4 class="text-center"> بيانات المشترك </h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-striped table-bordered display">
                                    <tbody>

                                        @if($data->childrendata)
                                        <tr>
                                            <th> نوع الاشتراك </th>
                                            <td>
                                                اشتراك لاحد الابناء
                                            </td>

                                        <tr>
                                            <th> اسم الطالب </th>
                                            <td>
                                                {{ $data->childrendata->name }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> النوع </th>
                                            <td>
                                                @if ($data->childrendata->gender == 'male')
                                                ذكر
                                                @else
                                                انثي
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> تاريخ الميلاد </th>
                                            <td>
                                                {{ $data->childrendata->birth_date }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> الصورة الشخصية </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->childrendata->image) }}" class="fancybox">
                                                    عرض الصورة </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> صورة بطاقة العائلة</th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->family_id_image) }}"
                                                   class="fancybox"> عرض صورة بطاقة العائلة </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>رقم الهوية للطالب</th>
                                            <td>{{ trim($data->childrendata->id_number) }}</td>
                                        </tr>


                                        <tr>
                                            <th> صورة الهوية للطالب</th>
                                            <td>
                                                <a href="{{ asset('/'.$data->childrendata->id_image) }}"
                                                   class="fancybox">عرض صورة هوية الطالب </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> صورة اخر شهادة علمية </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->childrendata->certificate_image) }}"
                                                    class="fancybox"> عرض صورة اخر شهادة علمية </a>
                                            </td>
                                        </tr>

                                        </tr>
                                        @else
                                        <tr>
                                            <th> نوع الاشتراك </th>
                                            <td>
                                                اشتراك بالحساب الشخصي
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> الصورة الشخصية </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->image) }}" class="fancybox">
                                                    عرض الصورة </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> صورة الهوية </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->id_image) }}"
                                                    class="fancybox">عرض الصورة </a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th> صورة اخر شهادة علمية </th>
                                            <td>
                                                <a href="{{ asset('/'.$data->studentdata->certificate_image) }}"
                                                    class="fancybox"> عرض الصورة </a>
                                            </td>
                                        </tr>
                                        @endif


                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="col">
                            <h4 class="text-center"> بيانات باقة الاشتراك </h4>
                            <div class="table-responsive">
                                <table id="file_export" class="table table-striped table-bordered display">
                                    <tbody>

                                        <tr>
                                            <th style="width:30%"> باقة الاشتراك </th>
                                            <td>{{$data->pricelist->name}}</td>
                                        </tr>

                                        <tr>
                                            <th style="width:30%">المرحلة التعليمية</th>
                                            <td>{{$data->pricelist->_type->name}}</td>
                                        </tr>

                                        <tr>
                                            <th> الصف الدراسي </th>
                                            <td>{{$data->pricelist->_stage->name}}</td>
                                        </tr>

                                        <tr>
                                            <th> نوع الاشتراك </th>
                                            <td>{{$data->pricelist->subscriptionperiod->name}}</td>
                                        </tr>

                                        <tr>
                                            <th> التكلفة </th>
                                            <td>{{$data->pricelist->normalprice}}</td>
                                        </tr>

                                        <tr>
                                            <th> الاماكن المسموح بها </th>
                                            <td>{{$data->pricelist->allowed_number}}</td>
                                        </tr>

                                        <tr>
                                            <th>عدد الطلاب المسجلين</th>
                                            <td>{{ $data->pricelist->booked }}</td>
                                        </tr>

                                        <tr>
                                            <th>الاماكن الشاغرة</th>
                                            <td>{{ $data->pricelist->free }}</td>
                                        </tr>

                                        <tr>
                                            <th> ملاحظات الاشتراك </th>
                                            <td>{{ $data->pricelist->note }}</td>
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
            text: "يترتب علي تغيير حالة الطلب بعض الامور المالية وعمليات الدفع",
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
