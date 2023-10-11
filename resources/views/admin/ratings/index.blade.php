@extends('admin.master.master')
@section('title')
    @lang('lang.Reviews')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 align-self-center">
                <h4 class="page-title">@lang('lang.Reviews')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.Reviews')</li>
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
                        <h4 class="card-title mb-2">@lang('lang.Reviews')</h4>

                        <hr>
                        <h6>@lang('lang.filter_results')  </h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <form action="">
                                    <div class="col-sm-3  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.Starting_from')  </label>
                                            <input type="date" name="from" value="{{ $_from }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-3  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.To')  </label>
                                            <input type="date" name="to" value="{{ $_to }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.filter')  </label>
                                            <button title="@lang('lang.filter_text')" type="submit"
                                                    class="btn btn-success btn-block"><i class="fa fa-filter"
                                                                                         aria-hidden="true"></i>@lang('lang.filter_results')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-2  float-left">
                                        <div class="form-group">
                                            <label for="">@lang('lang.reset') </label>
                                            <button title="@lang('lang.reset_text')" type="reset"
                                                    class="btn btn-success btn-block"><i
                                                    class="fas fa-undo"></i>@lang('lang.reset')</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-6">
                                <h6>@lang('lang.Number_of_reviews') : {{ $data->count() }} </h6>
                            </div>
                            <div class="col-sm-6">
                                <h6>@lang('lang.Rating_percentage') : {{ $data->avg('rate') }} </h6>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="file_export" class="table table-striped table-bordered display">
                                <thead>
                                <tr class="footable-header">
                                    <th class="text-center">@lang('lang.name')   </th>
                                    <th class="text-center">@lang('lang.edu_facilities')   </th>
                                    <th class="text-center">@lang('lang.comment')  </th>
                                    <th class="text-center">@lang('lang.rate')  </th>
                                    <th class="text-center">@lang('lang.status')  </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $dt)
                                    <tr>
                                        <td><a title="@lang('lang.view')">{{ $dt->name }}</a></td>
                                        <td><a href="{{ url('admin/edu-facilities/'.$dt->facility_id) }}" title="@lang('lang.view')">{{ $dt->facility_name }}</a></td>
                                        <td>{{ \Str::words($dt->comment, 10, '...')  }}</td>
                                        </td>
                                        <td>{{$dt->rate}} </td>
                                        <td>
                                            <a class="btn btn-sm btn-info"
                                               href="{{ url('admin/ratings/'.$dt->id) }}">
                                                <span class="fa fa-cog"></span>
                                                @lang('lang.view')
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
