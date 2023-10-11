@extends('admin.master.master')
@section('title')
    السجلات المالية | {{ $facility->name }}
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title"> السجلات المالية | {{ $facility->name }}</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">السجلات المالية | {{ $facility->name }}</li>
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
                    <h4 class="card-title mb-2"> الرصيد </h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered display">

                            <tr>
                                <td> عدد المشتركين</td>
                                <td>{{ $total_sucscription }} مشترك</td>
                            </tr>
                            <tr>
                                <td>اجمالي الاشتراكات</td>
                                <td>{{ $total_orders }}</td>
                            </tr>

                            <tr>
                                <td> نسبة العمولة الحالية</td>
                                <td>{{ $commission_rate }} %</td>
                            </tr>
                            <tr>
                                <td> اجمالي العمولات</td>
                                <td> @if ($financialLogs != null) {{ $financialLogs->total_commission }} @endif  </td>
                            </tr>
                            <tr>
                                <td> اجمالي الرصيد المتاح سحبه</td>
                                <td> @if ($financialLogs != null) {{ $financialLogs->total }} @endif  </td>
                            </tr>
                            <tr>
                                <td> عمليات سحب سابقة</td>
                                <td>{{ $withdrawas->count() }}</td>
                            </tr>
                            <tr>
                                <td>اجمالي المسحوبات</td>
                                <td>{{ $withdrawas->sum('total') }}</td>

                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-2"> السجلات المالية </h4>
                    <div class="table-responsive">
                        <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                            <th>#</th>
                            <th>رقم الفاتورة</th>
                            <th>تاريخ العملية</th>
                            <th>العملية</th>
                            <th> اجمالي الفاتورة</th>
                            <th>نسبة العمولة</th>
                            <th>العمولة</th>
                            <th>خصم</th>
                            <th>اضافة</th>
                            <th>اجمالي العمولات</th>
                            <th>اجمالي الرصيد</th>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $log)
                                <tr>
                                    <td>{{ $key+1  }}</td>
                                    <td>{{$log->InvoiceId}}</td>
                                    <td>{{$log->created_at}}</td>
                                    <td>{{$log->text}}</td>
                                    <td>{{$log->Invoice_value}} ريال </td>
                                    <td>{{$log->commission_rate}}%</td>
                                    <td>{{$log->commission}} ريال </td>
                                    <td>{{$log->withdraw}} ريال </td>
                                    <td>{{$log->addition}} ريال </td>
                                    <td>{{$log->total_commission}} ريال </td>
                                    <td>{{$log->total}} ريال </td>
                                </tr>
                            @endforeach
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
