@extends('site.master.master')
@section('page_title')
    الاشعارات
@endsection
@section('content')
    <section class="section-box view-banner"
             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed"></section>
    <section class="section-box edit-profile">
        <div class="container">
            <h2 class="section-title text-center"> @lang('lang.notifications') </h2>

            <div class="subpage">
                <div class="row">
                    @if(count($data) == 0)
                        <h3 class="section-title text-center">@lang('lang.No_results')</h3>
                    @endif
                    @foreach($data as $notification)
                        <div class="col-12 mb-5">
                            <div class="srvices-box">
                                <div class="services-data">
                                    <h3 class="services-title">{{ $notification->title }}</h3>
                                    <span> {{ $notification->created_at }} </span>
                                    <p class="map-marker">{{ $notification->text }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
