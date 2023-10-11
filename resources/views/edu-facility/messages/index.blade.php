@extends('edu-facility.master.master')
@section('title')
    @lang('lang.Support_Center')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title">@lang('lang.Support_Center')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.Support_Center')</li>
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
                        <h4 class="card-title mb-2">@lang('lang.Support_Center')</h4>

                        <hr>
                        <h6>@lang('lang.filter_results')</h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="">
                                    <div class="col-2 float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.status') </label>
                                            <select class="form-control" name="status" id="">
                                                <option value="all">@lang('lang.all')</option>
                                                <option @if ($_status != null && $_status == "new") selected
                                                        @endif   value="new">@lang('lang.new')
                                                </option>
                                                <option @if ($_status != null && $_status == "read") selected
                                                        @endif   value="read">@lang('lang.seen')
                                                </option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-3  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.Starting_from')</label>
                                            <input type="date" name="from" value="{{ $_from }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-3  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.To')</label>
                                            <input type="date" name="to" value="{{ $_to }}" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.filter_results')</label>
                                            <button
                                                title="@lang('lang.filter_text')"
                                                type="submit"
                                                class="btn btn-success btn-block"><i class="fa fa-filter" aria-hidden="true"></i>
                                                @lang('lang.filter_results')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.reset')</label>
                                            <button title="@lang('lang.reset_text')" type="reset"
                                                    class="btn btn-success btn-block"><i class="fas fa-undo"></i>
                                                @lang('lang.reset')
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                <tr class="footable-header">
                                    <th class="text-center">@lang('lang.reference_number')</th>
                                    <th class="text-center">@lang('lang.status')</th>
                                    <th class="text-center">@lang('lang.name')</th>
                                    <th class="text-center">@lang('lang.email')</th>
                                    <th class="text-center">@lang('lang.time')</th>
                                    <th class="text-center">@lang('lang.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $dt)
                                    <tr>
                                        <td>{{$dt->id}}</td>
                                        <td>
                                            @if ($dt->status == 'new')
                                                <span class="badge badge-success">@lang('lang.new')</span>
                                            @else
                                                <span class="badge badge-warning">@lang('lang.seen')</span>
                                            @endif

                                        </td>
                                        <td>{{$dt->name}}</td>
                                        <td>{{$dt->email}}</td>
                                        <td>{{$dt->created_at}}</td>
                                        <td class="text-center">
                                            <a href="{{url('edu-facility/messages/'.$dt->id)}}"
                                               title="@lang('lang.view')" class="btn btn-sm btn-info"> <i
                                                    class="fa fa-eye"></i> @lang('lang.view')  </a>
                                            <a href="mailto:{{ $dt->email }}" title="@lang('lang.reply')"
                                               class="btn btn-sm btn-success mt-1"> <i class="fa fa-envelope"></i>
                                                @lang('lang.reply')
                                            </a>
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
