@extends('site.master.master')
@section('page_title')
  @lang('lang.home') | {{ auth()->guard('student')->user()->name }}
@endsection
@section('content')
  <style>
  .services-data {
    padding: 7px;
    text-align: center;
}
  </style>
  <section class="section-box view-banner" style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed"></section>
<div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        @if($errors->any())
          @foreach($errors->all() as $error)
               <div class="alert alert-danger mb-2"> {{ $error }} </div>
          @endforeach
        @endif

      </div>
        <div class="col-md-12 mb-5">
              <h3 class="text-center">@lang('lang.welcome') {{ auth()->guard('student')->user()->name }} </h3>
        </div>

        <div class="col-6 col-md-2">
          <div class="item">
              <a class="services-link" href="{{ url('student/notifications')}}">
                  <div class="srvices-box">
                      <div class="services-img" style="background: url('{{ asset('site/images/notifications.svg') }}');background-position: center;"></div>
                      <div class="services-data">
                          <h3 class="services-title text-center"> @lang('lang.notifications') <span class="badge text-danger">(  {{ DB::table('notifications')->where('target','student')->where('target_id',auth()->guard('student')->user()->id)->count() }} ) </span></h3>
                      </div>
                  </div>
              </a>
          </div>
        </div>

        <div class="col-6 col-md-2">
          <div class="item">
              <a class="services-link" href="{{ url('student/profile') }}">
                  <div class="srvices-box">
                      <div class="services-img" style="background: url('{{ asset('site/images/profile.jpg') }}');background-position: center;"></div>
                      <div class="services-data">
                          <h3 class="services-title text-center">@lang('lang.profile')</h3>
                      </div>
                  </div>
              </a>
          </div>
        </div>

        <div class="col-6 col-md-2">
          <div class="item">
              <a class="services-link" href="{{ url('/student/favorites') }}">
                  <div class="srvices-box">
                      <div class="services-img" style="background: url('{{ asset('site/images/favorites.png') }}');background-position: center;"></div>
                      <div class="services-data">
                          <h3 class="services-title text-center"> @lang('lang.Favorite')  <span class="badge text-danger">(  {{ auth()->guard('student')->user()->facilities()->count() }} ) </span></h3>

                      </div>
                  </div>
              </a>
          </div>
        </div>

        <div class="col-6 col-md-2">
          <div class="item">
              <a class="services-link" href="{{ url('student/orders') }}">
                  <div class="srvices-box">
                      <div class="services-img" style="background: url('{{ asset('site/images/orders.png') }}');background-position: center;"></div>
                      <div class="services-data">
                          <h3 class="services-title text-center"> @lang('lang.orders')  <span class="badge text-danger">(  {{ auth()->guard('student')->user()->orders()->count() }} ) </span></h3>
                      </div>
                  </div>
              </a>
          </div>
        </div>
        <div class="col-6 col-md-2">
          <div class="item">
              <a class="services-link" href="{{ url('student/childrens') }}">
                  <div class="srvices-box">
                      <div class="services-img" style="background: url('{{ asset('site/images/opn-saudi-school.jpg') }}');background-position: center;"></div>
                      <div class="services-data">
                          <h3 class="services-title text-center"> @lang('lang.children')  <span class="badge text-danger">(  {{ auth()->guard('student')->user()->childrens()->count() }} ) </span></h3>
                      </div>
                  </div>
              </a>
          </div>
        </div>
    </div>
</div>
@endsection
