@extends('site.master.master')
@section('page_title')
    @lang('lang.Favorite')
@endsection
@section('content')
    <style>
        .gm-style {
            font: unset !important;
            font-weight: bold;
            color: black;
        }

        .gm-style-iw-d,
        .gm-style-iw-c,
        .gm-style-iw-d > div {
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        .gm-style-iw {
            padding-right: 13px !important;
        }
    </style>
    <section class="section-box view-banner"
             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed">
    </section>
    <section class="section-box edit-profile">
        <div class="container">
            <h2 class="section-title text-center"> @lang('lang.Favorite') </h2>


            <div class="subpage">
                <div class="row">
                    @if(count($data) == 0)
                        <h3 class="section-title text-center"> @lang('lang.No_results') </h3>
                    @endif

                    @foreach($data as $edu)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a class="services-link" href="{{ url('/facility/'.$edu->id ) }}">
                                <div class="srvices-box">
                                    <div class="services-img" style="background: url('{{ asset($edu->logo) }}');"></div>
                                    <div class="services-data">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>{{ number_format((float)$edu->averageRating, 2, '.', '')  }}
                                            @if(is_favorite($edu->id) == true)
                                                <a href="{{url('/student/remove-from-favorite/'.$edu->id)}}"><i
                                                        class="fas fa-heart text-danger" style="float:left"></i></a>
                                            @else
                                                <a href="{{url('/student/add-to-favorite/'.$edu->id)}}"><i
                                                        class="far fa-heart text-danger" style="float:left"></i></a>
                                            @endif
                                        </div>
                                        <h3 class="services-title">{{ $edu->name }}</h3>
                                        <p class="map-marker"><i class="fas fa-map-marker-alt"></i>{{ $edu->address }}
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
