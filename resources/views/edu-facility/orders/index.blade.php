@extends('edu-facility.master.master')
@section('title')
    @lang('lang.orders')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title"> @lang('lang.orders')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.orders')</li>
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
                        <h4 class="card-title mb-2">@lang('lang.orders')</h4>
                        <hr>
                        <h6>@lang('lang.filter') </h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="">
                                    <div class="col-2  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.stage')</label>
                                            <select class="form-control" name="type" id="">
                                              <option value=""> @lang('lang.all') </option>
                                              @foreach ($facility['types'] as $type)
                                                  <option @if ($_type != null && $_type == $type->id ) selected @endif value="{{ $type->id }}">{{ lng($type,'name') }}</option>
                                              @endforeach
                                            </select>

                                          </div>
                                    </div>
                                    <div class="col-2 float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.status')</label>
                                            <select class="form-control" name="status" id="">
                                                <option value=""> @lang('lang.all') </option>
                                                <option @if ($_status != null && $_status == "new") selected @endif   value="new"> @lang('lang.new') </option>
                                                <option @if ($_status != null && $_status == "accepted") selected @endif  value="accepted">@lang('lang.accepted')</option>
                                                <option @if ($_status != null && $_status == "under_revision" ) selected @endif  value="under_revision">@lang('lang.processing')</option>
                                                <option @if ($_status != null && $_status == "rejected") selected @endif  value="rejected">@lang('lang.rejected')</option>
                                                <option @if ($_status != null && $_status == "is_paid") selected @endif  value="is_paid">@lang('lang.complete')</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.Starting_from')</label>
                                            <input type="date" name="from" value="{{ $_from }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">  @lang('lang.To') </label>
                                            <input type="date" name="to" value="{{ $_to }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for=""> @lang('lang.filter') </label>
                                            <button title="@lang('lang.filter_text')" type="submit" class="btn btn-success btn-block"> <i class="fa fa-filter" aria-hidden="true"></i> @lang('lang.filter') </button>
                                        </div>
                                    </div>
                                     <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.reset') </label>
                                            <button title="@lang('lang.reset_text')" type="reset" class="btn btn-success btn-block"> <i class="fas fa-undo"></i> @lang('lang.reset')  </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <hr>
                        <h6> @lang('lang.create_a_file_containing_the_data_in_the_table_in_the_following_formats')  </h6>
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                <tr class="footable-header">
                                    <th class="text-center">@lang('lang.order_num')</th>
                                    <th class="text-center">@lang('lang.applicant')</th>
                                    <th class="text-center">@lang('lang.the_date_of_application')</th>
                                    <th class="text-center">@lang('lang.phone')</th>
                                    <th class="text-center">@lang('lang.payment_method')</th>
                                    <th class="text-center">@lang('lang.stage') & @lang('lang.class')</th>
                                    <th class="text-center">@lang('lang.status')</th>
                                    <th class="text-center">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($data))
                                    @foreach($data as $dt)
                                        <tr>
                                            <td>{{$dt->id}}</td>
                                            <td>{{$dt->studentdata->name}}</td>
                                            <td>{{$dt->created_at}}</td>
                                            <td>{{$dt->studentdata->phone}}</td>
                                            <td>{{lng($dt->pricelist->subscriptionperiod,'name')}}</td>
                                            <td>{{ lng($dt->pricelist->_type,'name') }} / {{ lng($dt->pricelist->_stage,'name') }}</td>
                                            <td>
                                                @if($dt->status == 'new')
                                                    @lang('lang.new')
                                                @elseif($dt->status == 'under_revision')
                                                    @lang('lang.processing')
                                                @elseif($dt->status == 'rejected')
                                                    @lang('lang.rejected')
                                                @elseif($dt->status == 'accepted')
                                                    @lang('lang.accepted')
                                                @elseif($dt->status == 'is_paid')
                                                    @lang('lang.complete')
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{url('edu-facility/orders/'.$dt->id)}}"
                                                   title="@lang('lang.view')" class="btn btn-sm btn-success"> <i
                                                        class="fa fa-eye"></i> @lang('lang.view') </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
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
