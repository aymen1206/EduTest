@extends('site.master.master')
@section('page_title')
    {{ __('lang.tamara')}}
@endsection
@section('content')


    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>

    <div class="container">

        <div class="view-title text-center">
            <div class="main-title text-center">
                <h1 class="page-title text-center">
                    <img width="150px" src="{{ asset('/images/tamara.png') }}">
                    {{ __('lang.tamara')}}
                </h1>
            </div>
        </div>


        <div class="page-content">

            @if(LaravelLocalization::getCurrentLocale()  == 'en')
                <h3 class="page-title mb-5" style="text-align: left !important; direction: ltr !important;">
                    {!! nl2br($tamara->text_en) !!}
                </h3>
            @else
                <h3 class="page-title mb-5" style="text-align: right !important; direction: rtl !important;">
                    {!! nl2br($tamara->text) !!}
                </h3>
            @endif

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.tamara_min_limit')." : ". $data[0]->min_limit->amount ." ريال سعودي" }}--}}
            {{--            </h4>--}}
            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.tamara_max_limit')." : ". $data[0]->max_limit->amount ." ريال سعودي" }}--}}
            {{--            </h4>--}}

            {{--            <h3 class="page-title mt-5 mb-2">--}}
            {{--                {{ __('lang.supported_instalments')}}--}}
            {{--            </h3>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments')." : ". $data[0]->supported_instalments[0]->instalments }}--}}
            {{--            </h4>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments_min_limit')." : ". $data[0]->supported_instalments[0]->min_limit->amount }}--}}
            {{--            </h4>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments_max_limit')." : ". $data[0]->supported_instalments[0]->max_limit->amount }}--}}
            {{--            </h4>--}}

        </div>

    </div>

@endsection
