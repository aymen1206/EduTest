@extends('site.master.master')
@section('page_title')
    {{ __('lang.about_us')}}
@endsection
@section('content')

    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>

    <div class="container">

        <div class="view-title">
            <div class="main-title">
                <h1 class="page-title">
                    {{ lng($about,'title') }}
                </h1>
            </div>
        </div>


        <div class="page-content">
            {!! nl2br(lng($about,'text')) !!}
        </div>

    </div>


    <div id="googleMap"></div>

    <script>
        function myMap() {
            var mapProp = {
                center: new google.maps.LatLng({{ $about->map }}),
                zoom: 15,
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            new google.maps.Marker({
                position: new google.maps.LatLng({{ $about->map }}),
                map
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBYk-bPGA2YW221CLysrZW7_4od9x5G90Y&callback=myMap"></script>


    <section class="section-box testimonial-block design2">
        <div class="container">
            <h2 class="section-title text-center">{{ __('lang.Partners')}}</h2>
            <div class="row partner-section">
                    <div class="col item text-center partner-item">
                        <img  class="partner-logo" src="{{ asset('/images/alrajhi-partnet.jpeg') }}" />
                    </div>
                    <div class="col item text-center partner-item">
                        <img class="partner-logo" src="{{ asset('/images/tamara-partner.jpeg') }}"/>
                    </div>
                    <div class="col item text-center partner-item">
                        <img class="partner-logo" src="{{ asset('/images/jeel-pay-partner.jpeg') }}"/>
                    </div>
            </div>
        </div>
    </section>

@endsection
