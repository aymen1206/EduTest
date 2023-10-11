@extends('site.master.master')
@section('page_title')
    {{ __('lang.jeel')}}
@endsection
@section('content')


    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>

    <div class="container">

        <div class="view-title text-center">
            <div class="main-title text-center">
                <h1 class="page-title text-center">
                    <img width="100px" src="{{ asset('/images/jeel-pay.jpeg') }}">
                    {{ __('lang.jeel')}}
                </h1>
            </div>
        </div>


        <div class="page-content">

            @if(LaravelLocalization::getCurrentLocale()  == 'en')
                <h3 class="page-title mb-5" style="text-align: left !important; direction: ltr !important;">
                    {!! nl2br($jeel->text_en) !!}
                </h3>
            @else
                <h3 class="page-title mb-5" style="text-align: right !important; direction: rtl !important;">
                    {!! nl2br($jeel->text) !!}
                </h3>
            @endif

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.jeel_min_limit')." : ". $jeel->min ." ريال سعودي" }}--}}
            {{--            </h4>--}}
            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.jeel_max_limit')." : ". $jeel->max ." ريال سعودي" }}--}}
            {{--            </h4>--}}

            {{--            <h3 class="page-title mt-5 mb-2">--}}
            {{--                {{ __('lang.supported_instalments')}}--}}
            {{--            </h3>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments')." : ". $jeel->instalments }}--}}
            {{--            </h4>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments_min_limit')." : ". $jeel->min }}--}}
            {{--            </h4>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments_max_limit')." : ". $jeel->max }}--}}
            {{--            </h4>--}}

        </div>
     

    </div>

@endsection
