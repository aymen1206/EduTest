@extends('site.master.master')
@section('page_title')
    {{ __('lang.home')}}
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
    .gm-style-iw-d>div {
        padding-left: 0 !important;
        margin-left: 0 !important;
    }

    .gm-style-iw {
        padding-right: 13px !important;
    }




    .green-label {
        background-color: #defadb;
        color: #19bab2;
        border-radius: 5px;
        font-size: 0.8rem;
        margin: 0 3px
    }

    .radio,
    .checkbox {
        padding: 6px 10px
    }

    .border {
        border-radius: 12px
    }

    .options {
        position: relative;
        padding-left: 25px
    }

    .radio label,
    .checkbox label {
        display: block;
        font-size: 14px;
        cursor: pointer;
        margin: 0
    }

    .options input {
        opacity: 0
    }

    .checkmark {
        position: absolute;
        top: 0px;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 50%
    }

    .options input:checked~.checkmark:after {
        display: block
    }

    .options .checkmark:after {
        content: "";
        width: 9px;
        height: 9px;
        display: block;
        background: white;
        position: absolute;
        top: 52%;
        left: 51%;
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        transition: 300ms ease-in-out 0s
    }

    .options input[type="radio"]:checked~.checkmark {
        background: #19bab2;
        transition: 300ms ease-in-out 0s
    }

    .options input[type="radio"]:checked~.checkmark:after {
        transform: translate(-50%, -50%) scale(1)
    }

    .count {
        font-size: 0.8rem
    }

    label {
        cursor: pointer
    }


    .check {
        position: absolute;
        top: 1px;
        right: 0;
        height: 18px;
        width: 18px;
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        border-radius: 3px
    }

    .tick:hover input~.check {
        background-color: #f3f3f3
    }

    .tick input:checked~.check {
        background-color: #19bab2
    }

    .check:after {
        content: "";
        position: absolute;
        display: none
    }

    .tick input:checked~.check:after {
        display: block;
        transform: rotate(45deg) scale(1)
    }

    .tick .check:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg) scale(2)
    }

    #country {
        font-size: 0.8rem;
        border: none;
        border-left: 1px solid #ccc;
        padding: 0px 10px;
        outline: none;
        font-weight: 900
    }

    .close {
        font-size: 1.2rem
    }

    div.text-muted {
        font-size: 0.85rem
    }

    #sidebar {
        width: 25%;
        float: left
    }

    .category {
        font-size: 0.9rem;
        cursor: pointer
    }

    .list-group-item {
        border: none;
        padding: 0.3rem 0.4rem 0.3rem 0rem
    }

    .badge-primary {
        background-color: #defadb;
        color: #19bab2
    }

    .brand .check {
        background-color: #fff;
        top: 3px;
        border: 1px solid #666
    }

    .brand .tick {
        font-size: 1rem;
        padding-left: 25px
    }

    .rating .check {
        background-color: #fff;
        border: 1px solid #666;
        top: 0
    }

    .rating .tick {
        font-size: 0.9rem;
        padding-left: 25px
    }

    .rating .fas.fa-star {
        color: #ffbb00;
        padding: 0px !important;
    }

    .brand .tick:hover input~.check,
    .rating .tick:hover input~.check {
        background-color: #f9f9f9
    }

    .brand .tick input:checked~.check,
    .rating .tick input:checked~.check {
        background-color: #19bab2
    }
    .options-search > a:not(:last-child) {
    margin-left: 5px;
}
.options-search > a{
    transition: 300ms;

}
.options-search > a:hover{
    opacity: .8;
}
@media (max-width:992px) {
    .search1,.search1{ width:100%; margin-bottom:20px}
    h2.section-title {
    padding: 0;
    font-size: 1.5rem;
    margin: 0 0 20px;
}

.view-banner {
    margin: 0 0 10px;
}
}
  
  .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
    float: right;
    padding: 11px 16px 5px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #f6f6f6;
    margin: 0 7px;
    color: #999;
    border-radius: 8px;
    font-size: 16px;
}
</style>
<style>.footer-divider svg {background: #e8f7f7;}</style>
<section class="section-box search-block">
    <div class="search-box">
        <form action="{{url('/')}}" method="get">
        <h3>{{ __('lang.search_for')}}</h3>
        <div class="search-text-warp">
            <div class="searcl-label">
                <i class="fas fa-chevron-down down-arrow"></i>
                <span class="search-placeholder">{{ __('lang.select_stage')}}</span>
                <ul class="search-items">
                    <li data-value="18"><i class="fas fa-angle-left"></i>{{ __('lang.baby_daycare')}}</li>
                    <li data-value="2"><i class="fas fa-angle-left"></i>{{ __('lang.Kindergarten')}}</li>
                    <li data-value="1"><i class="fas fa-angle-left"></i>{{ __('lang.preparatory')}}</li>
                    <li data-value="3"><i class="fas fa-angle-left"></i>{{ __('lang.primary')}}</li>
                    <li data-value="4"><i class="fas fa-angle-left"></i>{{ __('lang.middle')}}</li>
                    <li data-value="5"><i class="fas fa-angle-left"></i>{{ __('lang.secondary')}}</li>
                </ul>
                <input type="hidden" class="search-value" name="type" value="2" />
                <input type="hidden" class="search-value" name="facility_type"/>
            </div>
            <input type="text" name="keyword" class="form-control" placeholder="{{__('lang.Type_name_school')}}">
        </div>

        <div class="d-grid gap-2 col-12 mx-auto search-btn">
            <button type="submit" class="btn btn-primary btn-block search1"><i class="fas fa-search"></i></button>
        </div>
        </form>
    </div>
</section>
@php
$url=$_SERVER['REQUEST_URI']."?";
@endphp
<section class="section-box edit-profile">
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <a class="btn btn-primary btn-sm search1" style="background:#19bab2; border: none; float:left" href="{{$url.'&map=false&rate='}}"> <i class="fa fa-list" aria-hidden="true"></i> @lang('lang.display_lists') </a>
            </div>
            <div class="col-sm-6 col-xs-12">
                <a class="btn btn-primary btn-sm search1" style="background:#19bab2; border: none" href="{{$url.'facility_type=&keyword=&type=2&map=true&rate='}}"> <i class="fa fa-map-marker" aria-hidden="true"></i> @lang('lang.display_map') </a>
            </div>
        </div>


        <div class="subpage">
            <div class="row">
                @if(count($data) == 0)
                <h3 class="section-title text-center">@lang('lang.No_results')</h3>
                @endif

                <div class="col-md-2 ml-4">

                    <div class="card p-3 " id="mobile-filter">
                        <h6 class="mb-0 text-center">@lang('lang.filter')</h6>
                        <hr>
                        <div class="py-3">
                            <h5 class="font-weight-bold">@lang('lang.stages')</h5>
                            <ul class="list-group">
                                <li
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                    <a style="width: 100%" style="z-index: 1000"
                                        href="{{$url.'&facility_type=&rate='}}">
                                        <input type="checkbox" @if(!isset($filter['facility_type'])) checked @else disabled @endif >
                                        @lang('lang.all') @lang('lang.stages')
                                    </a>
                                </li>
                                <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                        <a style="width: 100%" href="{{$url.'&facility_type=18&rate='}}">
                                            <input type="checkbox" @if(isset($filter['facility_type']) && $filter['facility_type']->id == 18) checked @else disabled @endif > @lang('lang.baby_daycare')
                                        </a>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                        <a style="width: 100%" href="{{$url.'&facility_type=2&rate='}}">
                                            <input type="checkbox" @if(isset($filter['facility_type']) && $filter['facility_type']->id == 2) checked @else disabled @endif >@lang('lang.Kindergarten')
                                        </a>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                        <a style="width: 100%" href="{{$url.'&facility_type=1&rate='}}">
                                            <input type="checkbox" @if(isset($filter['facility_type']) && $filter['facility_type']->id == 1) checked @else disabled @endif >@lang('lang.preparatory')
                                        </a>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                        <a style="width: 100%" href="{{$url.'&facility_type=3&rate='}}">
                                            <input type="checkbox" @if(isset($filter['facility_type']) && $filter['facility_type']->id == 3) checked @else disabled @endif >@lang('lang.primary')
                                        </a>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                        <a style="width: 100%" href="{{$url.'&facility_type=4&rate='}}">
                                            <input type="checkbox" @if(isset($filter['facility_type']) && $filter['facility_type']->id == 4) checked @else disabled @endif >@lang('lang.middle')
                                        </a>
                                    </li>
                                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                        <a style="width: 100%" href="{{$url.'&facility_type=5&rate='}}">
                                            <input type="checkbox" @if(isset($filter['facility_type']) && $filter['facility_type']->id == 5) checked @else disabled @endif >@lang('lang.secondary')
                                        </a>
                                    </li>
                            </ul>
                        </div>

                        <div class="py-3">
                            <h5 class="font-weight-bold"> @lang('lang.payment_methods') </h5>
                            <ul class="list-group">
                                <li
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                    <a style="width: 100%" style="z-index: 1000"
                                        href="{{$url.'&subscription=&rate='}}">
                                        <input type="checkbox" @if(!isset($filter['subscription'])) checked @else disabled @endif >
                                        @lang('lang.all') @lang('lang.payment_methods')
                                    </a>
                                </li>
                                @foreach ($filter['subscription_periods'] as $subscription)
                                <li
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                    <a style="width: 100%" style="z-index: 1000"
                                        href="{{$url.'&subscription='.$subscription->id.'&rate='}}">
                                        <input type="checkbox" @if(isset($filter['subscription']) &&
                                            $filter['subscription']==$subscription->id) checked @else disabled @endif >
                                        {{ lng($subscription,'name') }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>


                        <div class="py-3">
                            <h5 class="font-weight-bold">@lang('lang.ratings')</h5>
                            <form class="rating">
                                <div class="form-inline d-flex align-items-center py-2">
                                    <label class="tick">
                                        <a style="width: 100%" style="z-index: 1000"
                                            href="{{$url.'&rate='}}">
                                            <input type="checkbox" @if(!isset($filter['rate']))
                                                checked @else disabled @endif>
                                            @lang('lang.all') @lang('lang.ratings')
                                        </a>
                                    </label>
                                </div>
                                <div class="form-inline d-flex align-items-center py-2">
                                    <label class="tick">
                                        <a style="width: 100%" style="z-index: 1000"
                                            href="{{$url.'&rate=5'}}">
                                            <input type="checkbox" @if(isset($filter['rate']) && $filter['rate']==5)
                                                checked @else disabled @endif>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                        </a>
                                    </label>
                                </div>
                                <div class="form-inline d-flex align-items-center py-2">
                                    <label class="tick">
                                        <a style="width: 100%" style="z-index: 1000"
                                            href="{{$url.'&rate=4'}}">
                                            <input type="checkbox" @if(isset($filter['rate']) && $filter['rate']==4)
                                                checked @else disabled @endif>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="far fa-star  text-muted"></span>
                                        </a>
                                    </label>
                                </div>
                                <div class="form-inline d-flex align-items-center py-2">
                                    <label class="tick">
                                        <a style="width: 100%" style="z-index: 1000"
                                            href="{{$url.'&rate=3'}}">
                                            <input type="checkbox" @if(isset($filter['rate']) && $filter['rate']==3)
                                                checked @else disabled @endif>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="far fa-star  text-muted"></span>
                                            <span class="far fa-star  text-muted"></span>
                                        </a>
                                    </label>
                                </div>
                                <div class="form-inline d-flex align-items-center py-2">
                                    <label class="tick">
                                        <a style="width: 100%" style="z-index: 1000"
                                            href="{{$url.'&rate=2'}}">
                                            <input type="checkbox" @if(isset($filter['rate']) && $filter['rate']==2)
                                                checked @else disabled @endif>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="far fa-star  text-muted"></span>
                                            <span class="far fa-star  text-muted"></span>
                                            <span class="far fa-star  text-muted"></span>
                                        </a>
                                    </label>
                                </div>
                                <div class="form-inline d-flex align-items-center py-2">
                                    <label class="tick">
                                        <a style="width: 100%" style="z-index: 1000"
                                            href="{{$url.'&rate=1'}}">
                                            <input type="checkbox" @if(isset($filter['rate']) && $filter['rate']==1)
                                                checked @else disabled @endif>
                                            <span class="fas fa-star"></span>
                                            <span class="far fa-star  text-muted"></span>
                                            <span class="far fa-star  text-muted"></span>
                                            <span class="far fa-star  text-muted"></span>
                                            <span class="far fa-star  text-muted"></span>
                                        </a>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">

                    @if($map != null)
                    <div class="row">
                        <div class="col-12" style="height: 600px">
                            {!! $map->render() !!}
                        </div>
                    </div>
                    @else
                    <div class="row">
                        @foreach($data as $edu)
                        <div class="col-lg-4 col-md-6 mb-5">
                            <a class="services-link" href="{{ url('/facility/'.$edu->id ) }}">
                                <div class="srvices-box">
                                    <div class="services-img" style="background: url('{{ asset($edu->logo) }}');">
                                    </div>
                                    <div class="services-data">
                                        <h3 class="services-title text-center">{{ lng($edu,'name') }}</h3>
                                        <p class="map-marker text-center">{{ lng($edu,'address') }}</p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i> {{ $edu->averageRate()}}
                                            @if(is_favorite($edu->id) == true)
                                            <a title="@lang('lang.remove_from_favorites')"
                                                href="{{url('/student/remove-from-favorite/'.$edu->id)}}"><i
                                                    class="fas fa-heart text-danger" style="float:left"></i></a>
                                            @else
                                            <a title="@lang('lang.add_to_favorites')"
                                                href="{{url('/student/add-to-favorite/'.$edu->id)}}"><i
                                                    class="far fa-heart text-danger" style="float:left"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="col-md-2">
                    @foreach (DB::table('advertisements')->get() as $item)
                    <a href="{{ $item->link }}" target="_blank">
                        <img class="img-fluid mb-5" src="{{ asset('/'.$item->image) }}" alt="">
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="center">
           {{ $data->links() }}
            </div>

        </div>
    </div>
</section>

@endsection
