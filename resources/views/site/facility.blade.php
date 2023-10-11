@extends('site.master.master')
@section('page_title')
    {{ lng($data,'name') }}
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <style>
        .ratings {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center
        }

        .ratings > input {
            display: none
        }

        .ratings > label {
            position: relative;
            width: 1em;
            font-size: 3vw;
            color: #FFD600;
            cursor: pointer;
        }

        .ratings > label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .ratings > label:hover:before,
        .ratings > label:hover ~ label:before {
            opacity: 1 !important
        }

        .ratings > input:checked ~ label:before {
            opacity: 1
        }

        .ratings:hover > input:checked ~ label:before {
            opacity: 0.4
        }

        .one-price {
            box-shadow: 0px 0px 24px -14px #0000004d !important;
            border: 1px solid #ddd;
        }

        .one-price ul {
            padding: 0;
            list-style-type: none;
            line-height: 2;
            font-size: 1rem;
        }

        .one-price ul > li:before {
            content: '\f058';
            display: inline-flex;
            align-items: center;
            margin-left: 1px;
            font-family: 'Font Awesome 5 Free';
            color: goldenrod;
        }
    </style>
    <section class="section-box view-banner" style="background: url('../../images/1549552528714.jfif');"></section>

    <div class="container">

        <div class="view-title">
            <div class="row">
                <div class="col-1">
                    <img class="img-fluid" src="{{asset(''.$data->logo)}}" alt="{{lng($data,'name')}}" title="{{lng($data,'name')}}"
                         onerror="this.src='{{asset('/images/facility_default_logo.png')}}'">
                </div>
                <div class="col-11">
                    <div class="main-title">
                        <h1 class="page-title">
                            {{ lng($data,'name') }}
                        </h1>
                        <p class="small-title"><span class="fa fa-map-marker-alt"></span> {{ lng($data,'address') }} </p>
                        <p class="small-title"> @lang('lang.Get_rating') : ({{ $data->averageRate()}} <i
                                class="fa fa-star text-warning" aria-hidden="true"></i> )</p>
                    </div>
                    <div class="view-rate">
                        <div class="rating-bar">
                        <span>
                            @for($i=(int)$data->averageRating; $i>0 ; $i--)
                                <i class="fas fa-star"></i>
                            @endfor
                        </span>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="page-content">
            {!! nl2br(lng($data,'about')) !!}
        </div>

        @auth('student')
            <div class="action-btns">
                @if(is_favorite($data->id) == true)
                    <a class="fav-btn" title="@lang('lang.remove_from_favorites')"
                       href="{{url('/student/remove-from-favorite/'.$data->id)}}"><i class="fas fa-heart"></i>@lang('lang.remove_from_favorites')</a>
                @else
                    <a class="fav-btn" title="@lang('lang.add_to_favorites')" href="{{url('/student/add-to-favorite/'.$data->id)}}">
                        @lang('lang.add_to_favorites')
                        <i class="fas fa-heart"></i>
                    </a>
                @endif
                @if(count($prices))
                    <a href="#prices" title="@lang('lang.register_on')">
                        @lang('lang.register_on')
                    <i class="fas fa-check"></i>
                    </a>
                @endif
            </div>
        @endauth

    </div>




    @if(count($gallery))

        <div class="toprated-divider-top">
            <svg preserveAspectRatio="none" viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 0v46.29c47.79 22.2 103.59 32.17 158 28 70.36-5.37 136.33-33.31 206.8-37.5 73.84-4.36 147.54 16.88 218.2 35.26 69.27 18 138.3 24.88 209.4 13.08 36.15-6 69.85-17.84 104.45-29.34C989.49 25 1113-14.29 1200 52.47V0z"
                    opacity=".50"/>
                <path
                    d="M0 0v5.63C149.93 59 314.09 71.32 475.83 42.57c43-7.64 84.23-20.12 127.61-26.46 59-8.63 112.48 12.24 165.56 35.4C827.93 77.22 886 95.24 951.2 90c86.53-7 172.46-45.71 248.8-84.81V0z"/>
            </svg>
        </div>

        <section class="section-box toprated-block">
            <div class="container">
                <h2 class="section-title text-center">@lang('lang.gallery')</h2>
                <div class="owl-services owl-carousel owl-theme">
                    @foreach($gallery as $gl)
                        <div class="item">
                            <a data-fancybox="gallery" href="{{asset($gl->image)}}">
                                <img src="{{asset($gl->image)}}" height="200"/>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    @endif


    <section class="section-box">
        <div class="container">
            <h2 class="section-title text-center">@lang('lang.map_location')</h2>
            <button id="showpath" class="btn btn-outline-info btn-sm"> <i class="fa fa-map-marker"></i> @lang('lang.drive_to_us') </button>
            <div class="row">
                <div class="col" id="googleMap"></div>
                <div style="max-height:450px; overflow:auto" class="col d-none" id="sidebar"></div>
            </div>

        </div>
    </section>



    <script>


        function myMap() {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();
            const image = "{{asset('/images/school.png')}}";
            const schoolloc =  new google.maps.LatLng({{$data->map_location}})
            const mapDiv = document.getElementById("showpath");


            var mapProp = {
                center: schoolloc,
                zoom: 15,
            };

            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

            directionsRenderer.setMap(map);
            directionsRenderer.setPanel(document.getElementById("sidebar"));



            new google.maps.Marker({
                position: new google.maps.LatLng({{$data->map_location}}),
                map,
                icon: image,
            });


            google.maps.event.addDomListener(mapDiv, "click", () => {

           if (navigator.geolocation) {

              navigator.geolocation.getCurrentPosition(

                (position) => {
                  const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                  };

                  let  originPoints = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

                directionsService
                .route({
                 origin: originPoints,
                 destination: schoolloc,
                  travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {
                    document.getElementById("sidebar").classList.remove("d-none");
                  directionsRenderer.setDirections(response);
                })
                .catch((e) => window.alert("Directions request failed due to " + status));
                },
                () => {
                  handleLocationError(true, infoWindow, map.getCenter());
                }
              );
            }
            });
        }



    </script>





    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRYgXbnwFrKQnKcggeZvkoKxuOWtvGYOU&callback=myMap&language={{LaravelLocalization::getCurrentLocale()}}"></script>

    @if(count($prices))
        <section class="section-box prices">
            <div class="container">
                <h2" class="section-title text-center">@lang('lang.Subscription_prices')</h2>
                <div class="row" id="prices">
                    @foreach($prices as $pr)
                        <div class="col-lg-6 col-md-6 text-center">
                            <div class="one-price"
                                 style="background-color:rgba(0, 0, 0, 0.01); padding: 20px 20px; box-shadow: 2px 2px 2px grey">
                                <span>
                                    @if($tamara_config->status == 1 && $pr->price >= $tamara_config->min && $pr->price <= $tamara_config->max && in_array($data->id,explode(',',$tamara_config->locked_facilities)))
                                        <img style="float: left" width="70px" src="{{ asset('/images/tamara.png') }}">
                                    @endif
                                     @if($tabby_config->status == 1 && $pr->price >= $tabby_config->min && $pr->price <= $tabby_config->max && in_array($data->id,explode(',',$tabby_config->locked_facilities)))
                                        <img style="float: left" width="70px" src="{{ asset('/images/tabby.png') }}">
                                    @endif

                                    {{ lng($pr,'name') }}
                                </span>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul>
                                            <li style="text-align:right;">@lang('lang.stage') : {{lng($pr->_type,'name')}}</li>
                                            <li style="text-align:right;">@lang('lang.payment_method')
                                                : {{ lng($pr->subscriptionperiod,'name')}}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul>
                                            <li style="text-align:right;">@lang('lang.class')  : {{lng($pr->_stage,'name')}}</li>
                                            @if($pr->price_discount > $pr->price)
                                                <li style="text-align:right;"> @lang('lang.before_discount')
                                                    : {{ $pr->price_discount  }} @lang('lang.sar')
                                                </li>
                                            @endif
                                            <li style="text-align:right;"> @lang('lang.current_price') : {{ $pr->price  }} @lang('lang.sar')</li>
                                            @if($pr->price_discount > $pr->price)
                                                <li style="text-align:right;">  @lang('lang.saving')
                                                    : {{ $pr->price_discount - $pr->price  }} @lang('lang.sar')
                                                </li>
                                            @endif
                                        </ul>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                        <ul>
                                            <li style="text-align:right;">@lang('lang.note') : {!! lng($pr,'note') !!}</li>
                                        </ul>
                                    </div>
                                </div>

                                <a class="btn btn-outline-success btn-sm mt-2"
                                   href="{{ url('student/make-order/'.$data->id.'/'.$pr->id) }}"> @lang('lang.subscribe') </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($alts))

        <div class="toprated-divider-top">
            <svg preserveAspectRatio="none" viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0 0v46.29c47.79 22.2 103.59 32.17 158 28 70.36-5.37 136.33-33.31 206.8-37.5 73.84-4.36 147.54 16.88 218.2 35.26 69.27 18 138.3 24.88 209.4 13.08 36.15-6 69.85-17.84 104.45-29.34C989.49 25 1113-14.29 1200 52.47V0z"
                    opacity=".50"/>
                <path
                    d="M0 0v5.63C149.93 59 314.09 71.32 475.83 42.57c43-7.64 84.23-20.12 127.61-26.46 59-8.63 112.48 12.24 165.56 35.4C827.93 77.22 886 95.24 951.2 90c86.53-7 172.46-45.71 248.8-84.81V0z"/>
            </svg>
        </div>



        <section class="section-box toprated-block">

            <div class="container">
                <h2 class="section-title text-center">@lang('lang.Related_facilities')</h2>

                <div class="owl-services owl-carousel owl-theme">
                    @foreach($alts as $lt)
                        <div class="item">
                            <a class="services-link" href="{{ url('/facility/'.$lt->id ) }}">
                                <div class="srvices-box">
                                    <div class="services-img" style="background: url('{{ asset($lt->logo) }}');"></div>
                                    <div class="services-data">
                                        <h3 class="services-title  text-center mb-2">{{ lng($lt,'name') }}</h3>
                                        <p class="map-marker text-center"> {{ lng($lt,'address') }}</p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i> {{ $lt->averageRate()}}
                                            @auth('student')
                                                @if(is_favorite($lt->id) == true)
                                                    <a title="@lang('lang.remove_from_favorites')"
                                                       href="{{url('/student/remove-from-favorite/'.$lt->id)}}"><i
                                                            class="fas fa-heart text-danger" style="float:left"></i></a>
                                                @else
                                                    <a title="@lang('lang.add_to_favorites')"
                                                       href="{{url('/student/add-to-favorite/'.$lt->id)}}"><i
                                                            class="far fa-heart text-danger" style="float:left"></i></a>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>


            </div>

        </section>
    @endif

    <section class="section-box testimonial-block design2">
        <div class="container">
            @if (count($data->comments()->where('approved',1)->get()))
                <h2 class="section-title text-center">@lang('lang.Customer_Reviews')</h2>
                <div class="owl-testimonial owl-carousel owl-theme">
                    @foreach($data->comments()->where('approved',1)->orderBy('id','desc')->take(10)->get() as $comment)
                        <div class="item text-center">
                            <img class="testimonial-avatar" src="{{ asset('/'.$comment->student->image) }}"/>
                            <h4 class="testimonial-user">{{ $comment->student->name }}</h4>
                            <span class="testimonial-pos">
                        @for ($i = 0 ; $i < $comment->rate; $i++)
                                    <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                @endfor
                    </span>
                            <p class="testimonial-text">{{$comment->comment}}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @auth('student')
                @php
                    $flag = DB::table('orders')->where('facility_id',$data->id)->where('student',auth()->guard('student')->user()->id)->first();
                @endphp
                @if($flag != null)
                    <h2 class="section-title text-center mt-5">@lang('lang.rate_us')</h2>
                    <form class="contact-us-form" method="post" action="{{ route('student.rate') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="ratings">
                                    <input type="radio" name="rating" value="5" id="5">
                                    <label for="5">☆</label>
                                    <input type="radio" name="rating" value="4" id="4">
                                    <label for="4">☆</label>
                                    <input type="radio" name="rating" value="3" id="3">
                                    <label for="3">☆</label>
                                    <input type="radio" name="rating" value="2" id="2">
                                    <label for="2">☆</label>
                                    <input type="radio" name="rating" value="1" id="1">
                                    <label for="1">☆</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" name="comment" required rows="3"
                                          placeholder="@lang('lang.type_review')"></textarea>
                                <input type="hidden" name="facility" value="{{ $data->id }}">
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">@lang('lang.send')</button>
                            </div>
                        </div>
                    </form>
                @endif 
            @endauth

        </div>
    </section>
    @auth('student')

        <!-- start contact us -->
        <section class="section-box contactus-block" id="contact">
            <div class="container">
                <h2 class="section-title text-center">@lang('lang.contact_us')</h2>
                <form class="contact-us-form" method="post" action="{{ url('send-message') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" required name="name" class="form-control" placeholder="@lang('lang.name')">
                            <input type="hidden" name="facility_id" value="{{ $data->id }}">
                        </div>
                        <div class="col-lg-6">
                            <input type="email" name="email" required class="form-control"
                                   placeholder="@lang('lang.email')">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="phone" required class="form-control" placeholder="@lang('lang.phone')">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="subject" required class="form-control" placeholder="@lang('lang.subject')">
                        </div>
                        <div class="col-12">
                            <textarea class="form-control" name="message" required rows="3"
                                      placeholder="@lang('lang.message')"></textarea>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">@lang('lang.send')</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- end contact us -->
    @endauth
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
@endsection
