@extends('admin.master.master')
@section('title')
    طلب سحب رصيد
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">طلب سحب رصيد</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/witddrawal')}}"> سجلات سحب الرصيد </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"> الرد علي طلب</li>
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

                        <h4 class="card-title mb-2">السجلات المالية لمقدم الطلب </h4>
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <tbody>
                                <tr>
                                    <td> صاحب الطلب</td>
                                    <td>{{ App\Models\EduFacility::find($data->facility_id)->name }}</td>
                                </tr>
                                <tr>
                                    <td> اجمالي الرصيد المتاح سحبه </td>
                                    <td>{{$dt->total}} ريال </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                        <h4 class="card-title mb-2"> بيانات الطلب </h4>
                        <table id="file_export" class="table table-striped table-bordered display">
                            <tbody>

                            <tr>
                                <td > اسم البنك</td>
                                <td>{{$data->bank}}</td>
                            </tr>
                            <tr>
                                <td > اسم صاحب الحساب</td>
                                <td>{{$data->account_name}}</td>
                            </tr>
                            <tr>
                                <td >رقم الحساب</td>
                                <td>{{$data->account_number}}</td>
                            </tr>
                            <tr>
                                <td > المبلغ</td>
                                <td>{{$data->total}}</td>
                            </tr>
                            <tr>
                                <td > حالة الطلب</td>
                                <td>
                                    @if($data->status == 'under_revision')
                                        <span class="badge badge-orange"> قيد المراجعة </span>
                                    @elseif($data->status == 'accepted')
                                        <span class="badge badge-success"> مقبول </span>
                                    @elseif($data->status == 'rejected')
                                        <span class="badge badge-danger"> مرفوض </span>
                                    @else
                                        <span class="badge badge-light"> حدث خطأ </span>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <form class="form-horizontal form-material" method="post" action="{{url('admin/withdrawal/'.$data->id)}}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12"> الرد علي الطلب </label>
                                <div class="col-md-12">
                                    <select name="status" class="form-control">
                                        <option value="accepted"> قبول الطلب </option>
                                        <option value="rejected">  رفض الطلب </option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
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
        var mm = today.getMontd() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }

        today = yyyy + '-' + mm + '-' + dd;
        let towmorow = yyyy + '-' + mm + '-' + (dd + 1);
        document.getElementById("start_date").setAttribute("min", today);
        document.getElementById("end_date").setAttribute("min", towmorow);

    </script>


    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{asset('/dashboard')}}/dist/js/pages/forms/select2/select2.init.js"></script>
@endsection
