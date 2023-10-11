@extends('admin.master.master')
@section('title')
    المشتركين
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title">سلة المهملات</h4>
                    <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">المشتركين</li>
                            <li class="breadcrumb-item active" aria-current="page">سلة المهملات</li>
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
                        
                        <table  class="table table-striped table-bordered display">
                            <thead>
                            <tr class="footable-header">
                                <th class="text-center">@lang('lang.logo')</th>
                                <th class="text-center">@lang('lang.name')</th>
                                <th class="text-center"> النوع</th>
                                <th class="text-center"> الحالة</th>
                                <th class="text-center"> تاريخ الاشتراك</th>
                                <th class="text-center">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                @if($dt->trashed())
                                <tr>
                                    @if($dt->facility_type === 1 || $dt->facility_type === 3)
                                        <td><img width="50" src="{{asset($dt->logo)}}"
                                                 onerror="this.src='{{ asset('images/facility_default_logo.png')  }}'">
                                        </td>
                                    @elseif($dt->facility_type === 2)
                                        <td><img width="50" src="{{asset($dt->profile_image)}}"></td>
                                    @endif
                                    <td style="width:150px !important;">{{$dt->name}}</td>
                                    <td>{{$dt->type->name}}</td>
                                    <td>
                                        @if ($dt->status == 1)
                                            <a class="badge badge-success inactive-confirm" title="اضغط للتعطيل"
                                               href="{{url('admin/edu-facilities/inactive/'.$dt->id)}}"> مفعل </a>
                                        @else
                                            <a class="badge badge-warning active-confirm" title=" اضغط للتفعيل"
                                               href="{{url('admin/edu-facilities/active/'.$dt->id)}}"> معطل </a>
                                        @endif
                                    </td>
                                    <td>{{$dt->created_at}}</td>
                                    <td style="width: 190px !important;" class="text-center">
                                        <a href="{{url('admin/edu-facilities/'.$dt->id.'/restore')}}"
                                           title="@lang('lang.delete')" class="btn btn-sm btn-success restore-confirm"> <i
                                                    class="fa fa-repeat"></i> @lang('lang.restore') </a>
                                        <a href="{{url('admin/edu-facilities/'.$dt->id.'/delete')}}"
                                           title="@lang('lang.delete')" class="btn btn-sm btn-danger delete-confirm"> <i
                                                    class="fa fa-trash"></i> @lang('lang.deleteforever') </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>

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
                    buttons: ["@lang('lang.cancel')", "@lang('lang.delete')"],
                }).then(function (value) {
                    if (value) {
                        window.location.href = url;
                    }
                });
            });

            $('.restore-confirm').on('click', function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                swal({
                    title: "@lang('lang.are_you_sure')",
                    text: "هل تريد  استعادة هذا العنصر",
                    icon: 'warning',
                    buttons: ["@lang('lang.cancel')", "إستعادة"],
                }).then(function (value) {
                    if (value) {
                        window.location.href = url;
                    }
                });
            });


            $('.inactive-confirm').on('click', function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                swal({
                    title: "@lang('lang.are_you_sure')",
                    text: "هل تريد تعطيل هذا الحساب",
                    icon: 'warning',
                    buttons: ["@lang('lang.cancel')", "تعطيل"],
                }).then(function (value) {
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
