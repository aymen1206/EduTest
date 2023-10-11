@extends('edu-facility.master.master')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.Control_Panel') </h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">@lang('lang.home')</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <h3 class="mb-3">@lang('lang.Order_stats') </h3>
            <hr>
        </div>
        <div class="row">
                 <div class="col-sm-3 col-xs-12">
                    <div class="card card-hover">
                        <div class="card-body">
                            <h4>@lang('lang.All_orders')</h4>
                            <hr>
                            <span>@lang('lang.the_orders') : {{ $orders['total']->total }} </span>
                            <span style="float: left; margin:0 10px"> @lang('lang.prices') : {{ $orders['total']->sum_of_prices }}  </span>
                            <hr>
                            <span class="clairfix"></span>
                            <span style="float: left">@lang('lang.new')  : {{ $orders['total']->new_orders }}  </span>
                            <span style="float: right">@lang('lang.accepted')  : {{ $orders['total']->accepted_orders }}  </span>
                            <div style="clear:both"></div>
                            <span style="float: left">@lang('lang.rejected')   : {{ $orders['total']->rejected_orders }}  </span>
                            <span style="float: right">@lang('lang.processing')  : {{ $orders['total']->under_revision_orders }}  </span>
                            <div style="clear:both"></div>
                            <span style="float: right">@lang('lang.complete')   : {{ $orders['total']->is_paid_orders }}  </span>

                        </div>
                    </div>
                 </div>

            @foreach ($orders['types'] as $key => $dt)

            <div class="col-sm-3 col-xs-12" >
                <div class="card card-hover">
                    <div class="card-body">
                        <h4> {{lng($dt->pricelist->_type,'name') }} </h4>
                        <hr>
                        <span>@lang('lang.the_orders')  : {{ $dt->sum_of_orders }} </span>
                        <span style="float: left; margin:0 10px"> @lang('lang.prices')  : {{ $dt->sum_of_prices }} </span>
                         <hr>
                            <span class="clairfix"></span>
                            <span style="float: left"> @lang('lang.new')   : {{$dt->new_orders }}  </span>
                            <span style="float: right">@lang('lang.accepted')  : {{ $dt->accepted_orders }}  </span>
                            <div style="clear:both"></div>
                            <span style="float: left">@lang('lang.rejected')   : {{ $dt->rejected_orders }}  </span>
                            <span style="float: right">@lang('lang.processing')  : {{ $dt->under_revision_orders }}  </span>
                            <div style="clear:both"></div>
                            <span style="float: right">@lang('lang.complete')   : {{ $dt->is_paid_orders }}  </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>




        <div class="row">
            <h3 class="mb-3">@lang('lang.Seating_stats_and_prices') </h3>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12" >
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="pt-3 text-center">
                            <table class="table table-striped table-responsive">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>@lang('lang.stage') </th>
                                        <th>@lang('lang.class') </th>
                                        <th>@lang('lang.Subscription_prices')</th>
                                        <th>@lang('lang.The_total_number_of_students') </th>
                                        <th>@lang('lang.Reserved_places')</th>
                                        <th>@lang('lang.vacancies')</th>
                                        <th>@lang('lang.view')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prices as $price)
                                        <tr>
                                            <td>{{ lng($price->_type,'name') }}</td>
                                            <td>{{ lng($price->_stage,'name') }}</td>
                                            <td>{{ $price->price }} @lang('lang.sar')</td>
                                            <td>{{ $price->allowed_number }} @lang('lang.seat') </td>
                                            <td>{{ $price->booked }} @lang('lang.seat')  </td>
                                            <td>{{ $price->free }} @lang('lang.seat')  </td>
                                            <td> <a class="btn btn-outline-info btn-sm" href="{{url('edu-facility/prices/'.$price->id)}}"> @lang('lang.view') </a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <h3 class="mb-3">@lang('lang.Balance_and_withdrawal_stats') </h3>
        </div>
        <div class="row">
            <div class="col-12 table-responsive" >
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="pt-3 text-center table-responsive">
                            <table class="table table-striped table-responsive">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>@lang('lang.number_of_subscribers')</th>
                                        <th>@lang('lang.Total_Subscriptions')</th>
                                        <th>@lang('lang.commission_rate')</th>
                                        <th>@lang('lang.Total_commissions')</th>
                                        <th>@lang('lang.Total')</th>
                                        <th>@lang('lang.Balance_available_to_withdraw')</th>
                                        <th>@lang('lang.Previous_withdrawals')</th>
                                        <th>@lang('lang.Total_withdrawals')</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ $total_sucscription }}</td>
                                            <td> @if ($financialRecord != null) {{ $financialRecord->subscriptions }} @else 0 @endif  </td>
                                            <td> @if ($financialRecord != null) {{ $financialRecord->commissions_rate }} %   @else 0 @endif  </td>
                                            <td> @if ($financialRecord != null) {{ $financialRecord->commissions }}  @else 0 @endif  </td>
                                            <td> @if ($financialRecord != null) {{ $financialRecord->total }}  @else 0 @endif  </td>
                                            <td> @if ($financialRecord != null) {{ $financialRecord->total }}  @else 0 @endif  </td>
                                            <td>{{ $withdrawas->count() }}</td>
                                            <td>{{ $withdrawas->sum('total') }}</td>
                                        </tr>

                                    </tbody>
                            </table>
                        </div>
                        <a href="{{url('edu-facility/withdrawal-logs')}}" class="btn btn-outline-primary brn-sm">@lang('lang.View_withdrawals')</a>
                        <a href="{{url('edu-facility/financial')}}" class="btn btn-outline-primary brn-sm">@lang('lang.View_balance_details')</a>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6 col-xs-12 table-responsive" >
                <h3 class="mb-3">@lang('lang.Visits_and_ratings_stats')</h3>
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="pt-3 text-center">
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>@lang('lang.visits')</th>
                                        <th>@lang('lang.Number_of_reviews')</th>
                                        <th>@lang('lang.Rating_percentage')</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ auth()->guard('edu_facility')->user()->visits }}</td>
                                            <td>{{ auth()->guard('edu_facility')->user()->totalCommentsCount() }} </td>
                                            <td>({{ auth()->guard('edu_facility')->user()->averageRate()  }})  / 5 </td>
                                        </tr>

                                    </tbody>
                            </table>
                        </div>
                        <a href="{{url('edu-facility/ratings')}}" class="btn btn-outline-primary brn-sm">@lang('lang.view') </a>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-xs-12 table-responsive">
                <h3 class="mb-3">@lang('lang.Support_center_stats')</h3>
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="pt-3 text-center">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('lang.number_of_messages')</th>
                                        <th>@lang('lang.new_messages')</th>
                                        <th>@lang('lang.Viewed_messages')</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ $messages->count() }}</td>
                                            <td>{{ $messages->where('status','new')->count() }} </td>
                                            <td>{{ $messages->where('status','read')->count() }} </td>
                                        </tr>

                                    </tbody>
                            </table>
                        </div>
                        <a href="{{url('edu-facility/messages')}}" class="btn btn-outline-primary brn-sm">@lang('lang.view')</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

