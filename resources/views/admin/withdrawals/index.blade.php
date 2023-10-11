@extends('admin.master.master')
@section('title')
  طلبات سحب الرصيد
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title"> طلبات سحب الرصيد</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">طلبات سحب الرصيد</li>
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
                    <h4 class="card-title mb-2">طلبات سحب الرصيد</h4>
                    <div class="table-responsive">
                      <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr class="footable-header">
                                    <th class="text-center">  رقم الطلب </th>
                                    <th class="text-center"> صاحب الطلب </th>
                                    <th class="text-center"> النوع  </th>
                                    <th class="text-center"> اسم البنك </th>
                                    <th class="text-center"> اسم صاحب الحساب </th>
                                    <th class="text-center">رقم الحساب </th>
                                    <th class="text-center"> المبلغ </th>
                                    <th class="text-center"> حالة الطلب </th>
                                     <th class="text-center"> تاريخ الطلب  </th>
                                     <th class="text-center"> تاريخ الرد علي الطلب  </th>
                                    <th class="text-center">  الاجراءات </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{$dt->id}}</td>
                                  <td> <a href="{{url('admin/edu-facilities/'.App\Models\EduFacility::find($dt->facility_id)->id)}}"> {{ App\Models\EduFacility::find($dt->facility_id)->name }}</a></td>
                                    <td>{{ App\Models\EduFacility::find($dt->facility_id)->type->name }}</td>
                                    <td>{{$dt->bank}}</td>
                                    <td>{{$dt->account_name}}</td>
                                    <td>{{$dt->account_number}}</td>
                                    <td>{{$dt->total}}</td>
                                    <td>
                                        @if($dt->status == 'under_revision')
                                        <span class="badge badge-orange"> قيد المراجعة </span>
                                        @elseif($dt->status == 'accepted')
                                            <span class="badge badge-success"> مقبول </span>
                                        @elseif($dt->status == 'rejected')
                                            <span class="badge badge-danger"> مرفوض </span>
                                        @else
                                            <span class="badge badge-light"> حدث خطأ </span>
                                        @endif
                                    </td>
                                    <td>{{$dt->created_at}}</td>
                                    <td>{{$dt->updated_at}}</td>
                                    <td class="text-center">
                                        <a href="{{url('admin/withdrawal/'.$dt->id.'/edit')}}" title="@lang('lang.edit')" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i>  الرد علي الطلب </a>
                                    </td>

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
