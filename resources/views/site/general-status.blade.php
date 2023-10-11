@extends('site.master.master')
@section('page_title')
    {{ __('lang.contact_us')}}
@endsection
@section('content')

    <section class="section-box view-banner" style="background: url('../images/1549552528714.jfif');"></section>


    <!-- start contact us -->
    <section class="section-box contactus-block" id="contact">
        <div class="container">
            @if($dt == 'true')
                <h3 class="text-center"> تمت عملية الدفع بنجاح </h3>
                <h3 class="text-center"> سوف يتم توجيهك الي صفحة الطلبات </h3>
            @else
                <h3 class="text-center"> عفوا .. لم تتم عملية الدفع بشكل صحيح  </h3>
                <h3 class="text-center"> سوف يتم توجيهك الي صفحة الطلبات </h3>
            @endif
        </div>
    </section>
    <!-- end contact us -->

@endsection
@section('custom-javascript')
<script>
    setTimeout(function(){
        window.location.href = '{{url("student/orders")}}';
    }, 3000);
</script>
@endsection
