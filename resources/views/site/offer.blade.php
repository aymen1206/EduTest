@extends('site.master.master')
@section('page_title')
    العروض الترويجية | {{ $data->title }}
@endsection
@section('content')

    <section class="section-box view-banner"
             style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>
    <div class="container">

        <div class="row">
            <div class="col-12 mb-5">
                <div class="main-title">
                    <h1 class="page-title">{{ lng($data,'title') }}</h1>
                </div>
            </div>
            <div class="col-3">
                <img class="img-fluid" src="{{ asset('/'.$data->image) }}">
            </div>

            <div class="col-9">
                <div class="col-6">
                    <div class="main-title">
                        <p class="small-title"><span class="fa fa-calendar-alt"></span> @lang('lang.from')
                            : {{ $data->start_date }} </p>
                        <p class="small-title"><span class="fa fa-money-bill-alt"></span> @lang('lang.before_discount')
                            : <span style="text-decoration: line-through">{{ $data->price }}</span></p>
                    </div>
                </div>
                <div class="col-6 float-left" style="float:left ">
                    <div class="main-title">
                        <p class="small-title"><span class="fa fa-calendar-alt"></span> @lang('lang.to')
                            : {{ $data->end_date }} </p>
                        <p class="small-title"><span class="fa fa-money-bill-alt"></span> @lang('lang.after_discount')
                            : {{ $data->price_after_discount }} </p>
                    </div>
                </div>
                <div class="col-12 page-content mt-5 mb-5">
                    {!! nl2br(lng($data,'text')) !!}
                </div>
            </div>
        </div>


    </div>
@endsection
