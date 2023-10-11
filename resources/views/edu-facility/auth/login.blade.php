@extends('edu-facility.layouts.auth')
@section('title')
    @lang('lang.login')
@endsection
@section('form')
    <div id="loginform">
        <div class="logo">
            <img src="{{asset(setting()->dark_logo)}}" alt="{{setting()->app_name}}">
            <h5 class="font-medium mb-3 mt-3">@lang('lang.Sign_In_to_edu')</h5>
        </div>
        <!-- Form -->
        <div class="row">
            <div class="col-12">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('edu-facility.login') }}" aria-label="@lang('lang.Login')">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-12 col-form-label text-md-right">@lang('lang.email')</label>

                        <div class="col-md-12">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-12 col-form-label text-md-right">@lang('lang.password')</label>

                        <div class="col-md-12">
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                   required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-check float-right" style="width: 100%; text-align: right !important;">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label mr-4" for="remember"> @lang('lang.remember_me') </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                @lang('lang.login')
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                        @if (Route::has('edu-facility.password.request'))
                            <a class="btn btn-link text-right float-right"  style="width: 100%; text-align: right !important;" href="{{ route('edu-facility.password.request') }}">
                                @lang('lang.forgot_your_password')
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

