@extends('admin.master.master')
@section('title')
  @lang('lang.seo')
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title"> @lang('lang.seo')</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.seo')</li>
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
                    <h4 class="card-title mb-2">@lang('lang.seo')</h4>
                    <div class="table-responsive">
                      <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr class="footable-header">
                                    <th class="text-center">@lang('lang.title')</th>
                                    <th class="text-center">@lang('lang.description')</th>
                                    <th class="text-center">@lang('lang.keywords')</th>
                                    <th class="text-center">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>{{$seo->title}}</td>
                                    <td>{{$seo->description}}</td>
                                    <td>{{$seo->keywords}}</td>
                                    <td class="text-center">
                                      <a href="{{url('admin/seo/'.$seo->id.'/edit')}}" title="@lang('lang.edit')" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
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
