@extends('admin.master.master')
@section('title')
    ملخض الرصيد
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title">ملخص الرصيد</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ملخص الرصيد</li>
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
                        <h4 class="card-title mb-2">ملخص الرصيد</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td> عدد المشتركين</td>
                                    <td>{{ $total_sucscription }} مشترك </td>
                                </tr>
                                <tr>
                                    <td> نسبة العمولة الحالية</td>
                                    <td>{{ $commission_rate }} %</td>
                                </tr>

                                <tr>
                                    <td> اجمالي مستحقات المدارس (قابل للسحب)</td>
                                    <td> @if ($financialLogs != null) {{ $financialLogs->total }} @endif ريال</td>
                                </tr>
                                <tr>
                                    <td> اجمالي مستحقات المنصة (العمولات)</td>
                                    <td> @if ($financialLogs != null) {{ $financialLogs->total_commission }} @endif
                                        ريال
                                    </td>
                                </tr>

                                <tr>
                                    <td> عمليات سحب سابقة</td>
                                    <td>{{ $withdrawas->count() }} عملية سحب </td>
                                </tr>
                                <tr>
                                    <td>اجمالي المسحوبات</td>
                                    <td>{{ $withdrawas->sum('total') }} ريال </td>

                                </tr>
                                <tr>
                                    <td> الرصيد الكلي</td>
                                    <td> @if ($financialLogs != null) {{ $financialLogs->final_total }} @endif ريال</td>
                                </tr>

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
