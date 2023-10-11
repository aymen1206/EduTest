@extends('admin.master.master')
@section('title')
    الطلبات
@endsection
@section('content')

    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title"> الطلبات</h4>

                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">الطلبات</li>
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
                        <h4 class="card-title mb-2">الطلبات</h4>
                        <hr>
                        <h6> فلترة النتائج </h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="">
                                    <div class="col-2  float-left">
                                        <div class="form-group">
                                            <label for="">المرحلة التعليمية</label>
                                            <select class="form-control" name="type" id="">
                                              <option value=""> كل المراحل </option>
                                              @foreach ($facility['types'] as $type)
                                                  <option @if ($_type != null && $_type == $type->id ) selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                              @endforeach
                                            </select>

                                          </div>
                                    </div>
                                    <div class="col-2 float-left">
                                        <div class="form-group">
                                            <label for="">حالة الطلب</label>
                                            <select class="form-control" name="status" id="">
                                                <option value=""> كل الحالات </option>
                                                <option @if ($_status != null && $_status == "new") selected @endif   value="new"> جديد </option>
                                                <option @if ($_status != null && $_status == "accepted") selected @endif  value="accepted">مقبول</option>
                                                <option @if ($_status != null && $_status == "under_revision" ) selected @endif  value="under_revision">قيد المراجعة</option>
                                                <option @if ($_status != null && $_status == "rejected") selected @endif  value="rejected">مرفوض</option>
                                                <option @if ($_status != null && $_status == "is_paid") selected @endif  value="is_paid">مكتمل</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">بداية من تاريخ </label>
                                            <input type="date" name="from" value="{{ $_from }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">  الي تاريخ  </label>
                                            <input type="date" name="to" value="{{ $_to }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for=""> فلترة </label>
                                            <button title="فلترة نتائج البحث بناء علي المدخلات" type="submit" class="btn btn-success btn-block"> <i class="fa fa-filter" aria-hidden="true"></i> فلترة النتائج </button>
                                        </div>
                                    </div>
                                     <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for=""> اعادة ضبط </label>
                                            <button title="حذف جميع قيم الفلاتر" type="reset" class="btn btn-success btn-block"> <i class="fas fa-undo"></i> اعادة ضبط  </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <hr>
                        <h6> انشاء ملف يحتوي علي البيانات الواردة بالجدول بالصيغ التالية  :  </h6>
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                <tr class="footable-header">
                                    <th class="text-center">مقدم الطلب</th>
                                    <th class="text-center">تاريخ تقديم الطلب</th>
                                    <th class="text-center">رقم الجوال</th>
                                    <th class="text-center">نوع الاشتراك</th>
                                    <th class="text-center">المرحلة والصف</th>
                                    <th class="text-center">حالة الطلب</th>
                                    <th class="text-center"> الجههة المقدم لها </th>
                                    <th class="text-center"> عملية الدفع </th>
                                    <th class="text-center">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($data))
                                    @foreach($data as $dt)
                                        <tr>
                                            <td>{{$dt->studentdata->name}}</td>
                                            <td>{{$dt->created_at}}</td>
                                            <td>{{$dt->studentdata->phone}}</td>
                                            <td>{{$dt->pricelist->subscriptionperiod->name}}</td>
                                            <td>{{ $dt->pricelist->_type->name }} / {{ $dt->pricelist->_stage->name }}</td>
                                            <td>
                                                @if($dt->status == 'new')
                                                    جديد
                                                @elseif($dt->status == 'under_revision')
                                                    قيد المراجعة
                                                @elseif($dt->status == 'rejected')
                                                    مرفوض
                                                @elseif($dt->status == 'accepted')
                                                    مقبول
                                                @elseif($dt->status == 'is_paid')
                                                    مكتمل
                                                @endif
                                            </td>
                                            <td>{{$dt->facility->name}}</td>
                                            <td>{{$dt->payment_type()}}</td>
                                            <td class="text-center">
                                                <a href="{{url('admin/orders/'.$dt->id)}}"
                                                   title="عرض البيانات" class="btn btn-sm btn-success"> <i
                                                        class="fa fa-eye"></i> عرض البيانات </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('custom-javascript')
@section('custom-javascript')
    <!--This page plugins -->
    <script src="{{ asset('dashboard/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script src="{{ asset('dashboard/')}}/dist/js/pages/datatable/datatable-advanced.init.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
