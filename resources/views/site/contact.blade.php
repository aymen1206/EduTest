@extends('site.master.master')
@section('page_title')
    {{ __('lang.contact_us')}}
@endsection
@section('content')

    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>


       <!-- start contact us -->
    <section class="section-box contactus-block" id="contact">
        <div class="container">
            <h2 class="section-title text-center">{{ __('lang.contact_platform')}}</h2>
            <form class="contact-us-form" method="post" action="{{ url('send-message') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <input type="text" required name="name" class="form-control" placeholder="{{ __('lang.name')}}">
                        <input type="hidden" name="facility_id" value="0">
                    </div>
                    <div class="col-lg-6">
                        <input type="email" name="email" required class="form-control" placeholder="{{ __('lang.email')}}">
                    </div>
                    <div class="col-lg-6">
                        <input type="text" name="phone" required class="form-control" placeholder="{{ __('lang.phone')}}">
                    </div>
                    <div class="col-6">
                        <input type="text" name="subject" required class="form-control" placeholder="{{ __('lang.subject')}}">
                    </div>
                    <div class="col-12">
                        <textarea class="form-control" name="message" required rows="3" placeholder="{{ __('lang.message')}}"></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">{{ __('lang.send')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- end contact us -->

@endsection
