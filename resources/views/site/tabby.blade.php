@extends('site.master.master')
@section('page_title')
    {{ __('lang.tabby')}}
@endsection
@section('content')


    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>

    <div class="container">

        <div class="view-title text-center">
            <div class="main-title text-center">
                <h1 class="page-title text-center">
                    <img width="150px" src="{{ asset('/images/tabby.png') }}">
                    {{ __('lang.tabby')}}
                </h1>
            </div>
        </div>


        <div class="page-content">

            @if(LaravelLocalization::getCurrentLocale()  == 'en')
                <h3 class="page-title mb-5" style="text-align: left !important; direction: ltr !important;">
                    {!! nl2br($tabby->text_en) !!}
                </h3>
            @else
                <h3 class="page-title mb-5" style="text-align: right !important; direction: rtl !important;">
                    {!! nl2br($tabby->text) !!}
                </h3>
            @endif

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.tabby_min_limit')." : ". $tabby->min ." ريال سعودي" }}--}}
            {{--            </h4>--}}
            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.tabby_max_limit')." : ". $tabby->max ." ريال سعودي" }}--}}
            {{--            </h4>--}}

            {{--            <h3 class="page-title mt-5 mb-2">--}}
            {{--                {{ __('lang.supported_instalments')}}--}}
            {{--            </h3>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments')." : ". $tabby->instalments }}--}}
            {{--            </h4>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments_min_limit')." : ". $tabby->min }}--}}
            {{--            </h4>--}}

            {{--            <h4 class="page-title">--}}
            {{--                {{ __('lang.instalments_max_limit')." : ". $tabby->max }}--}}
            {{--            </h4>--}}

        </div>
         @if(LaravelLocalization::getCurrentLocale()  == 'en')
                <h3 class="page-title mb-5" style="text-align: left !important; direction: ltr !important;">
                    {{ __('lang.TabbyPromo')}}
                </h3>
            @else
                <h3 class="page-title mb-5" style="text-align: right !important; direction: rtl !important;">
                    {{ __('lang.TabbyPromo')}}
                </h3>
            @endif

    </div>

@endsection
