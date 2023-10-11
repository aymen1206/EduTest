@extends('edu-facility.master.master')
@section('title')
    @lang('lang.balance_withdrawal_records')
@endsection
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('/dashboard/assets/libs/select2/dist/css/select2.min.css')}}">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.balance_withdrawal_records')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility/withdrawal-logs')}}">  @lang('lang.balance_withdrawal_records') </a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.add_new')</li>
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
                        <form class="form-horizontal form-material" method="post" action="{{url('edu-facility/withdrawal-logs/')}}" enctype="multipart/form-data">
                            @csrf

                          <!--  <div class="form-group">
                                <label class="col-md-12">   @lang('lang.bank') </label>
                                <div class="col-md-12">
                                    <input type="text" name="bank" placeholder="@lang('lang.bank')" required class="form-control form-control-line" value="{{old('bank')}}">
                                    <span class="text-danger">{{ $errors->first('bank') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.account_holders_name')</label>
                                <div class="col-md-12">
                                    <input type="text" name="account_name" placeholder="@lang('lang.account_holders_name')" required class="form-control form-control-line" value="{{old('account_name')}}">
                                    <span class="text-danger">{{ $errors->first('account_name') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> @lang('lang.account_number') </label>
                                <div class="col-md-12">
                                    <input type="text" name="account_number" placeholder=" @lang('lang.account_number')" required class="form-control form-control-line" value="{{old('account_number')}}">
                                    <span class="text-danger">{{ $errors->first('account_number') }}</span>
                                </div>
                            </div>
-->
                            <div class="form-group">
                                <label class="col-md-12">@lang('lang.Balance_available_to_withdraw') </label>
                                <div class="col-md-12">
                                    <input type="number" disabled min="{{ $dt->total }}" max="{{ $dt->total }}" name="total" placeholder="المبلغ" required class="form-control form-control-line" value="{{ $dt->total }}">
                                    <span class="text-danger">{{ $errors->first('total') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">@lang('lang.add_new')</button>
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

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        today = yyyy+'-'+mm+'-'+dd;
        let towmorow = yyyy+'-'+mm+'-'+(dd+1);
        document.getElementById("start_date").setAttribute("min", today);
        document.getElementById("end_date").setAttribute("min", towmorow);

    </script>


    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="{{asset('/dashboard')}}/assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="{{asset('/dashboard')}}/dist/js/pages/forms/select2/select2.init.js"></script>
@endsection
