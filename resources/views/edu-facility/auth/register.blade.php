@extends('site.master.master')
@section('page_title')
تسجيل حساب مستخدم جديد
@endsection
@section('content')
<section class="section-box view-banner"
    style="background: url('https://media-exp1.licdn.com/dms/image/C4E1BAQH-9J2-__M3NA/company-background_10000/0/1549552528714?e=2159024400&v=beta&t=26cx4LCxHdtbgXtomZyaPFCV5xgxsDEKTaGtEHbZChQ');">
</section>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if($errors->any())
            @foreach($errors->all() as $error)
            <div class="alert alert-danger mb-2"> {{ $error }} </div>
            @endforeach
            @endif

        </div>
        <div class="col-md-8">
            <h3 class="text-center"> @lang('lang.service_recipient_account') </h3>

            <form class="popup-form" method="post" action="{{ url('edu-facility\register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="col-md-12">@lang('lang.name')</label>
                        <div class="col-md-12">
                            <input type="text" name="name" required class="form-control form-control-line">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                    </div>


                    <!--<div class="form-group">-->
                    <!--    <label class="col-md-12">@lang('lang.facility_type')</label>-->
                    <!--    <div class="col-md-12">-->
                    <!--        <select class="form-control form-control-line" name="type_id" required aria-label="Default select example">-->
                    <!--            <option value="" selected disabled>@lang('lang.facility_type') </option>-->
                    <!--            @foreach(DB::table('types')->get() as $dt)-->
                    <!--                <option value="{{$dt->id}}"> {{$dt->name}} </option>-->
                    <!--            @endforeach-->
                    <!--        </select>-->
                    <!--        <span class="text-danger">{{ $errors->first('type_id') }}</span>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <div class="row">
                        <div class="formRow mb-3 col">
                            <label class="col-md-12">@lang('lang.phone')</label>
                            <div class="col-md-12">
                                <input type="tel" name="phone" class="form-control form-control-line" required>
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>

                        <div class="formRow mb-3 col">
                            <label class="col-md-12">@lang('lang.mobile')</label>
                            <div class="col-md-12">
                                <input type="text" name="mobile" class="form-control form-control-line" required>
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput1" class="col-md-12">@lang('lang.email')</label>
                            <div class="col-md-12">
                                <input type="email" name="email" required class="form-control form-control-line" id="exampleFormControlInput1" placeholder="name@example.com">
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                        </div>

                        <div class="formRow mb-3 col">
                            <label class="col-md-12">@lang('lang.city')</label>
                            <div class="col-md-12">
                                <select name="city" required class="form-control p-2">
                                    @foreach(DB::table('cities')->get() as $city)
                                        <option value="{{ $city->id }}">@if(LaravelLocalization::getCurrentLocaleNative() == 'العربية') {{ $city->nameAr }} @else {{ $city->nameEn }} @endif</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput2" class="form-label">@lang('lang.password')</label>
                            <input type="password" name="password" required minlength="8" class="form-control"
                                id="exampleFormControlInput2" placeholder="***************">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="formRow mb-3 col">
                            <label for="exampleFormControlInput2" class="form-label">@lang('lang.confirm_password')</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="exampleFormControlInput2" placeholder="***************">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">

                            <label class="check-container"> @lang('lang.accept_terms')
                                <input type="checkbox" name="legal_agreement" required checked="">
                                <span class="checkmark"></span>
                            </label>
                            @error('legal_agreement')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary sumbit-form">@lang('lang.register')</button>
                        </div>
                    </div>

                </form>

        </div>
    </div>
</div>
@endsection
