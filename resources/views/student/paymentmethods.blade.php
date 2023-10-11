@extends('site.master.master')
@section('page_title')
    @lang('lang.Choose_payment_method')
@endsection
@section('content')
  <section class="section-box view-banner" style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed"></section>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
              <h3 class="text-center"> @lang('lang.Choose_payment_method') </h3>
        </div>
        @foreach ($paymentMethods as $item)

        <div class="col-lg-3 col-md-6 mb-5 p-3">
            <a class="services-link" href="{{ url('student/pay/'.$order_id.'/'.$item['PaymentMethodId']) }}">
                <div class="srvices-box">
                    <div class="services-img" style="background: url('{{ $item['ImageUrl'] }}'); background-size:100% 100% !important"></div>
                    <div class="services-data">
                        <h5 class="services-title text-center">{{ $item['PaymentMethodAr'] }}</h5>
                        <p class="map-marker"> <i class="fas fa-usd-circle"></i> تكاليف الخدمة : {{  $item['ServiceCharge']}} ريال سعودي </p>
                        <p class="map-marker"> <i class="fas fa-usd-circle"></i>  اجمالي المبلغ : {{  $item['TotalAmount']}} ريال سعودي </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
