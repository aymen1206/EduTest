@extends('site.master.master')
@section('page_title')
    @lang('lang.Edit_profile')
@endsection
@section('content')
<section class="section-box view-banner"
    style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed">
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
        <div class="col-md-8 mb-5">
            <h3 class="text-center">@lang('lang.reset_password')</h3>

            <form class="popup-form" method="post" action="{{ route('student.st_reset_password') }}">
                @csrf
                <div class="form-group">
                    <label for="exampleFormControlInput2" class="col-md-12">@lang('lang.old_password')</label>
                    <div class="col-md-12">
                        <input type="password" name="old_password" required minlength="8" class="form-control" id="exampleFormControlInput2" placeholder="***************">
                        <span class="text-danger">{{ $errors->first('old_password') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput2" class="col-md-12"> @lang('lang.new_password') </label>
                    <div class="col-md-12">
                        <input type="password" name="password" required minlength="8" class="form-control" id="exampleFormControlInput2" placeholder="***************">
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlInput2" class="col-md-12">@lang('lang.confirm_new_password')</label>
                    <div class="col-md-12">
                        <input type="password" name="password_confirmation" required minlength="8" class="form-control" id="exampleFormControlInput2" placeholder="***************">
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary sumbit-form">@lang('lang.reset_password')</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
