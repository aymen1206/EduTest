@extends('admin.master.master')
@section('title')
  انواع المنشئات التعليمية
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title"> انواع المنشئات التعليمية</h4>
            <a href="{{url('admin/types/create')}}" class="btn btn-primary float-right text-white"> <span class="fa fa-plus-square"></span> @lang('lang.add_new') </a>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">انواع المنشئات التعليمية</li>
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
                    <h4 class="card-title mb-2">انواع المنشئات التعليمية</h4>
                    تصدير نتائج الصفحة لملفات خارجية بالصيغ الاتية :
                    <br>
                    <div class="table-responsive">
                      <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr class="footable-header">
                                    <th class="text-center">@lang('lang.name')</th>
                                    <th class="text-center">الاسم بالانجليزية</th>
                                    <th class="text-center">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{$dt->name}}</td>
                                    <td>{{$dt->name_en}}</td>
                                    <td class="text-center">
                                      <a href="{{url('admin/facilities-types?type='.$dt->id)}}" title="@lang('lang.edit')" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> المرحلة التعليمية </a>
                                      <a href="{{url('admin/types/'.$dt->id.'/edit')}}" title="@lang('lang.edit')" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i> @lang('lang.edit')</a>
                                      <a href="{{url('admin/types/'.$dt->id.'/delete')}}" title="@lang('lang.delete')" class="btn btn-sm btn-danger delete-confirm"> <i class="fa fa-trash"></i> @lang('lang.delete') </a>
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
    <script type="text/javascript">
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: "@lang('lang.are_you_sure')",
                text: "@lang('lang.permanently_deleted')",
                icon: 'warning',
                buttons: ["@lang('lang.cancel')","@lang('lang.delete')"],
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });
    </script>

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
