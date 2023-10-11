@extends('admin.master.master')
@section('title')
    @lang('lang.notifications')
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title"> @lang('lang.notifications')</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.notifications')</li>
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
                    <h4 class="card-title mb-2">@lang('lang.notifications')</h4>
                    <div class="table-responsive">
                      <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr class="footable-header">
                                    <th class="text-center"> @lang('lang.title')  </th>
                                    <th class="text-center"> @lang('lang.notifications')  </th>
                                    <th class="text-center"> @lang('lang.status') </th>
                                    <th class="text-center"> @lang('lang.time') </th>
                                    <th class="text-center">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{$dt->title}}</td>
                                    <td>{{$dt->text}}</td>
                                    <td>
                                        @if ($dt->status == '0')
                                            <span class="badge badge-success"> @lang('lang.new')</span>
                                        @else
                                            <span class="badge badge-warning">@lang('lang.seen') </span>
                                        @endif

                                    </td>
                                    <td>{{$dt->created_at}}</td>
                                    <td class="text-center">
                                      <a href="{{url('admin/notification/'.$dt->id)}}" title="@lang('lang.view_data')" class="btn btn-sm btn-info"> <i class="fa fa-eye"></i> @lang('lang.view')  </a>
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
    <!--This page plugins -->
    <script src="{{ asset('dashboard/')}}/assets/extra-libs/datatables.net/js/jquery.dataTables.js"></script>
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
