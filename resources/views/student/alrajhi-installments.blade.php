@extends('site.master.master')
@section('page_title')
    @lang('lang.Terms_Conditions_alrajhi_installments')
@endsection
@section('content')

    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}'); height: 250px;"></section>

    <div class="container" style="padding-bottom: 10px;">

    @if(isset($data['status']) && $data['status'] == 'success')
    <div class="view-title">
                <div class="main-title">
                        <h1 class="page-title">
                            @lang('lang.Terms_Conditions_alrajhi_installments')
                        </h1>
                </div>
                <div class="page-content alert alert-success">
                    @lang('lang.alrajhi_success')
                </div>
            </div>

    @else
    <form method="post" action="{{ url('student/alrajhi-installments/'.$data['order_id']) }}">
                @csrf
            <div class="view-title">
                <div class="main-title">
                        @if($errors->any())
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger mb-2"> {{ $error }} </div>
                        @endforeach
                        @endif
                        <h1 class="page-title">
                            @lang('lang.Terms_Conditions_alrajhi_installments')
                        </h1>
                </div>
            </div>
                <div class="page-content" style="font-size: 15px; line-height:20px; padding-bottom: 20px">
                    {!! nl2br(lng($data['text'],'text')) !!}
                </div>
        <div class="row">
                    <div class="col-12">

                        <label class="check-container">الموافقة على الشروط و األحكام
                            <input type="checkbox" name="legal_agreement" required>
                            <span class="checkmark"></span>
                        </label>
                        @error('legal_agreement')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary sumbit-form">@lang('lang.i_agree_to_alrajhi')</button>
                    </div>
                </div>
</form>
@endif
    </div>


@endsection
