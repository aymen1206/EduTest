@extends('site.master.master')
@section('page_title')
    @lang('lang.offers')
@endsection
@section('content')
<section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>
    <section class="section-box edit-profile">
        <div class="container">
            <h2 class="section-title text-center">@lang('lang.offers')</h2>
            <div class="subpage">
                <div class="row">
                    @if(count($data) == 0)
                        <h3 class="section-title text-center">@lang('lang.No_results')</h3>
                    @endif

                    @foreach($data as $offer)
                        <div class="col-lg-3 col-md-6">
                            <a class="services-link" href="{{ url('/offer/'.$offer->id ) }}">
                                <div class="srvices-box">
                                    <div class="services-img"
                                         style="background: url('{{ asset($offer->image) }}');"></div>
                                    <div class="services-data">
                                        <h3 class="services-title mb-3">{{ lng($offer,'title') }}</h3>
                                        <p class="map-marker">
                                            <span>
                                            <i class="fas fa-calendar-alt"></i>@lang('lang.from') :
                                            {{ $offer->start_date }}
                                            </span>
                                            <span style="float: left">
                                            <i class="fas fa-calendar-alt"></i> @lang('lang.to') :
                                            {{ $offer->end_date }}
                                            </span>
                                        </p>
                                        <div class="clearfix"></div>
                                        <p class="map-marker">
                                            <span style="text-decoration: line-through; background: gainsboro;text-decoration: line-through;padding: 5px;border-radius: 30px;">
                                           @lang('lang.before_discount')
                                            {{ $offer->price }}
                                            </span>
                                            <span style="float: left; background: gainsboro; padding: 5px;border-radius: 30px; margin-top: -4px; ">
                                                @lang('lang.after_discount')
                                            {{ $offer->price_after_discount }}
                                            </span>
                                        </p>

                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
        </div>
    </section>
@endsection
