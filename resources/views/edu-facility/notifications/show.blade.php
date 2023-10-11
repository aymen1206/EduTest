@extends('edu-facility.master.master')
@section('title')
    @lang('lang.notifications')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">   @lang('lang.notifications')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/edu-facility/notification')}}">   @lang('lang.notifications')</a></li>
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
                        <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>   @lang('lang.title') </td>
                                        <td>{{ $data->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>  @lang('lang.notifications')</td>
                                        <td>{!! $data->text !!}</td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection

