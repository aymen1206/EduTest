@extends('edu-facility.master.master')
@section('title')
  @lang('lang.balance_withdrawal_records')
@endsection
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title"> @lang('lang.balance_withdrawal_records')</h4>
            <a href="{{url('edu-facility/withdrawal-logs/create')}}" class="btn btn-primary float-right text-white"> <span class="fa fa-plus-square"></span> @lang('lang.new_withdrawal_request')  </a>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('lang.balance_withdrawal_records')</li>
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
                    <h4 class="card-title mb-2">@lang('lang.balance_withdrawal_records')</h4>
                    <hr>
                        <h6> @lang('lang.filter') </h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="">
                                    <div class="col-2 float-left">
                                        <div class="form-group">
                                            <label for=""> @lang('lang.status') </label>
                                            <select class="form-control" name="status" id="">
                                                <option value="all"> @lang('lang.all') </option>
                                                <option @if ($_status != null && $_status == "under_revision") selected @endif   value="under_revision">@lang('lang.processing') </option>
                                                <option @if ($_status != null && $_status == "accepted") selected @endif   value="accepted"> @lang('lang.accepted') </option>
                                                <option @if ($_status != null && $_status == "rejected") selected @endif   value="rejected"> @lang('lang.rejected') </option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-3  float-left">
                                        <div class="form-group">
                                            <label for=""> @lang('lang.Starting_from') </label>
                                            <input type="date" name="from" value="{{ $_from }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-3  float-left">
                                        <div class="form-group">
                                            <label for=""> @lang('lang.To')  </label>
                                            <input type="date" name="to" value="{{ $_to }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for=""> @lang('lang.filter')  </label>
                                            <button title="@lang('lang.filter_text')" type="submit" class="btn btn-success btn-block"> <i class="fa fa-filter" aria-hidden="true"></i> @lang('lang.filter')</button>
                                        </div>
                                    </div>
                                     <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">  @lang('lang.reset')  </label>
                                            <button title=" " type="reset" class="btn btn-success btn-block"> <i class="fas fa-undo"></i> @lang('lang.reset')   </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    <div class="table-responsive">
                        <h6>@lang('lang.export_results')</h6>
                      <table id="file_export" class="table table-striped table-bordered display">
                            <thead>
                                <tr class="footable-header">
                                    <th class="text-center">@lang('lang.order_num')</th>
                                    <th class="text-center">@lang('lang.bank')</th>
                                    <th class="text-center">@lang('lang.account_holders_name')</th>
                                    <th class="text-center">@lang('lang.account_number')</th>
                                    <th class="text-center">@lang('lang.Total')</th>
                                    <th class="text-center">@lang('lang.time')</th>
                                    <th class="text-center">@lang('lang.status')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{$dt->id}}</td>
                                    <td>{{$dt->bank}}</td>
                                    <td>{{$dt->account_name}}</td>
                                    <td>{{$dt->account_number}}</td>
                                    <td>{{$dt->total}}</td>
                                    <td>{{$dt->created_at}}</td>
                                    <td>
                                        @if($dt->status == 'under_revision')
                                        <span class="badge badge-orange">@lang('lang.processing') </span>
                                        @elseif($dt->status == 'accepted')
                                            <span class="badge badge-success"> @lang('lang.accepted') </span>
                                        @elseif($dt->status == 'rejected')
                                            <span class="badge badge-danger"> @lang('lang.rejected') </span>
                                        @else
                                            <span class="badge badge-light"> @lang('lang.an_error_occurred')  </span>
                                        @endif
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
