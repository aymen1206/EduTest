@extends('site.master.master')
@section('page_title')
    @lang('lang.Terms_Conditions')
@endsection
@section('content')

    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>

    <div class="container">

        <div class="view-title">
            <div class="main-title">
                <h1 class="page-title">
                    @lang('lang.Terms_Conditions')
                </h1>
            </div>
        </div>


        <div class="page-content">
            {!! nl2br(lng($data,'text')) !!}
        </div>

    </div>




@endsection
