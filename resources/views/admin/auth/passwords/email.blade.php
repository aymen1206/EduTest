@extends('admin.layouts.auth')
@section('title')
    @lang('lang.lang.reset_password')
@endsection
@section('form')
    <div id="loginform">
        <div class="logo">
            <h5 class="font-medium mb-3 mt-3">@lang('lang.reset_password')</h5>
        </div>
        <!-- Form -->
        <div class="row">
            <div class="col-12">
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                    <form method="POST" action="{{ route('admin.password.email') }}" aria-label="@lang('lang.reset_password')">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-right mb-3 text-orange">@lang('lang.reset_email_message')</label>

                            <label for="email" class="col-md-12 col-form-label text-md-right">@lang('lang.email')</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                     @lang('lang.Send_password_reset_link')
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

