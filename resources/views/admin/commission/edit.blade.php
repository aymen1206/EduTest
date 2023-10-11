@extends('admin.master.master')
@section('title')
    نسبة العمولة
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> تعديل نسبة العمولة </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/commission')}}">نسبة العمولة</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> تعديل نسبة العمولة </li>
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
                        <form id="form" class="form-horizontal form-material" method="post" action="{{url('admin/commission/'.$data->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="col-md-12"> النسبة المئوية للعمولة </label>
                                <div class="col-md-12">
                                    <input type="number" step="0.25"  min="0.0" name="commission" placeholder="نسبة العمولة" required class="form-control form-control-line" value="{{$data->commission}}">
                                    <span class="text-danger">{{ $errors->first('commission') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success update-confirm">@lang('lang.update')</button>
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
        $('.update-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: "@lang('lang.are_you_sure')",
                text: "سيتم تطبيق النسبة الجديدة علي الاشتراكات المستقبلية",
                icon: 'warning',
                buttons: ["@lang('lang.cancel')","حسنا .. متابعة"],
            }).then(function(value) {
                if (value) {
                    $('#form').submit();
                }
            });
        });
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
