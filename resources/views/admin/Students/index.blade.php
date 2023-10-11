@extends('admin.master.master')
@section('title')
 أولياء الامور
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title">أولياء الامور</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">أولياء الامور</li>
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
                        <h4 class="card-title mb-2">أولياء الامور</h4>
                        <hr>
                        <h6> فلترة النتائج </h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="">
                                    

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">بداية من تاريخ </label>
                                            <input type="date" name="from" value="{{ $_from }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for=""> الي تاريخ </label>
                                            <input type="date" name="to" value="{{ $_to }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for=""> فلترة </label>
                                            <button title="فلترة نتائج البحث بناء علي المدخلات" type="submit"
                                                    class="btn btn-success btn-block"><i class="fa fa-filter"
                                                                                         aria-hidden="true"></i> فلترة
                                                النتائج
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for=""> اعادة ضبط </label>
                                            <button title="حذف جميع قيم الفلاتر" type="reset"
                                                    class="btn btn-success btn-block"><i class="fas fa-undo"></i> اعادة
                                                ضبط
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <hr>
                        <h6>
                            تصدير النتائج بملف خارجي بالصيغ الاتية :
                        </h6>
                        <br>
                        <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                            <tr class="footable-header">
                                <th class="text-center">الصورة</th>
                                <th class="text-center">@lang('lang.name')</th>
                                <th class="text-center"> رقم الجوال</th>
                                <th class="text-center">البريد الالكتروني</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center"> تاريخ  التسجيل</th>
                                <th class="text-center">@lang('lang.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                        <td><img width="50" src="{{asset($dt->id_image)}}"
                                                 onerror="this.src='{{ asset('images/Students.png')  }}'">
                                        </td>

                                    <td style="width:150px !important;">{{$dt->name}}</td>
                                    <td>{{$dt->phone}}</td>
                                    <td>{{$dt->email}}</td>
                                    <td>{{$dt->citys->nameAr}}</td>
                                   



                                    <td>{{$dt->created_at}}</td>
                                    <td style="width: 190px !important;" class="text-center">                                        
                                        <a href="{{url('admin/student/'.$dt->id)}}" title="عرض البيانات"
                                           class="btn btn-sm btn-info"> <i class="fa fa-edit"></i> عرض </a>
                                        <a href="{{url('admin/student/'.$dt->id.'/edit')}}"
                                           title="@lang('lang.edit')" class="btn btn-sm btn-warning"> <i
                                                    class="fa fa-edit"></i> @lang('lang.edit')</a>
                                        <a href="{{url('admin/student/'.$dt->id.'/delete')}}"
                                           title="@lang('lang.delete')" class="btn btn-sm btn-danger delete-confirm"> <i
                                                    class="fa fa-trash"></i> @lang('lang.delete') </a>
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

            $('.active-confirm').on('click', function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                swal({
                    title: "@lang('lang.are_you_sure')",
                    text: "هل تريد تفعيل هذا الطلب",
                    icon: 'warning',
                    buttons: ["@lang('lang.cancel')", "تفعيل"],
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
