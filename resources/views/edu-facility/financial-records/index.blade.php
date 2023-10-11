@extends('edu-facility.master.master')
@section('title')
    @lang('lang.Balance')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title"> @lang('lang.Balance')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.Balance')</li>
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
                        <h4 class="card-title mb-2">@lang('lang.Balance')</h4>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <td>@lang('lang.number_of_subscribers')</td>
                                    <td>{{ $total_sucscription }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('lang.Total_Subscriptions')</td>
                                    <td>{{ $total_orders }}</td>
                                </tr>

                                <tr>
                                    <td>@lang('lang.commission_rate')</td>
                                    <td>{{ $commission_rate }} %</td>
                                </tr>
                                <tr>
                                    <td>@lang('lang.Total_commissions')</td>
                                    <td> @if ($financialLogs != null) {{ $financialLogs->total_commission }} @endif  </td>
                                </tr>
                                <tr>
                                    <td>@lang('lang.Balance_available_to_withdraw')</td>
                                    <td> @if ($financialLogs != null) {{ $financialLogs->total }} @endif  </td>
                                </tr>
                                <tr>
                                    <td>@lang('lang.Previous_withdrawals')</td>
                                    <td>{{ $withdrawas->count() }}</td>
                                </tr>
                                <tr>
                                    <td>@lang('lang.Total_withdrawals')</td>
                                    <td>{{ $withdrawas->sum('total') }}</td>

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
