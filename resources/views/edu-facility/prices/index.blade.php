@extends('edu-facility.master.master')
@section('title')
    @lang('lang.Subscription_prices')
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title">   @lang('lang.Subscription_prices')</h4>
            <a href="{{url('edu-facility/prices/create')}}" class="btn btn-primary float-right text-white"> <span class="fa fa-plus-square"></span> @lang('lang.add_new') </a>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">  @lang('lang.Subscription_prices')</li>
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
                    <h4 class="card-title mb-2">  @lang('lang.Subscription_prices')</h4>
                    <div class="table-responsive">
                      <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr class="footable-header">
                                    <th class="text-center">@lang('lang.title')</th>
                                    <th class="text-center">@lang('lang.stage')</th>
                                    <th class="text-center">@lang('lang.class')</th>
                                    <th class="text-center">@lang('lang.payment_method')</th>
                                    <!--<th class="text-center"> السعر  </th>-->
                                    <!--<th class="text-center"> العدد  </th>-->
                                    <th class="text-center">@lang('lang.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{lng($dt,'name')}}</td>
                                    <td>{{lng($dt->_type,'name')}}</td>
                                    <td>{{lng($dt->_stage,'name')}}</td>
                                    <td>{{lng($dt->subscriptionperiod,'name')}}</td>
                                    <!--<td>{{$dt->price}}</td>-->
                                    <!--<td>{{$dt->allowed_number}}</td>-->
                                    <td class="text-center">
                                      <a href="{{url('edu-facility/prices/'.$dt->id)}}" title="@lang('lang.view')" class="btn btn-sm btn-success"> <i class="fa fa-eye"></i> @lang('lang.view') </a>
                                      <a href="{{url('edu-facility/prices/'.$dt->id.'/edit')}}" title="@lang('lang.edit')" class="btn btn-sm btn-warning"> <i class="fa fa-edit"></i> @lang('lang.edit')</a>
                                      <a href="{{url('edu-facility/prices/'.$dt->id.'/delete')}}" title="@lang('lang.delete')" class="btn btn-sm btn-danger delete-confirm"> <i class="fa fa-trash"></i> @lang('lang.delete') </a>
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
