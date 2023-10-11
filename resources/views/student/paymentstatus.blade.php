@extends('site.master.master')
@section('page_title')
    @lang('lang.Payment_Result')
@endsection
@section('content')
  <section class="section-box view-banner" style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed"></section>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if ($dt == true)
            <div class="alert alert-success" role="alert">
              <h4 class="alert-heading">@lang('lang.payment_success')</h4>
              <p> @lang('lang.payment_success_text') </p>
            </div>
            @else
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">@lang('lang.payment_failed')</h4>
                <p>@lang('lang.payment_failed_text')</p>
              </div>
            @endif
        </div>

    </div>
</div>
@endsection
