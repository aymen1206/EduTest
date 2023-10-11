@extends('site.master.master')
@section('page_title')
    {{ __('lang.about_us')}}
@endsection
@section('content')
@if($status=='CUSTOMER_CANCELLED')
   <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>
         <div class="alert alert-danger" style="text-align:center;">
                <h3 class="page-title mb-5" >
                  تم الغاء عملية الدفع  عن طريق جيل
                </h3>
            </div>

    </div>
@elseif($status=='success')
   <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>
         <div class="alert alert-success" style="text-align:center;">
                <h3 class="page-title mb-5" >
                  تمت عملية الدفع بنجاح عن طريق جيل
                </h3>
            </div>

    </div>
@endif

@endsection
