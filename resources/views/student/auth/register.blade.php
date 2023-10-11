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
            <h3 class="text-center">تسجيل حساب مستخدم جديد</h3>

            <form class="popup-form" method="post" action="{{ route('student.st_register') }}" enctype="multipart/form-data">
                @csrf
                <div class="formRow mb-3">
                    <label class="form-label">اسم الطالب</label>
                    <input type="text" name="name" required class="form-control"
                        placeholder="عبد الله محمد عبد الله القحطاني" value="{{old('name')}}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">رقم الجوال</label>
                    <input type="tel" name="phone" required class="form-control" placeholder="9665XXXXXXXXX"
                        value="{{old('phone')}}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                    <input type="email" name="email" required class="form-control" id="exampleFormControlInput1"
                        placeholder="name@example.com" value="{{old('email')}}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">الدولة</label>
                    <input type="text" name="country" required class="form-control"
                        placeholder="المملكة العربية السعودية" value="{{old('country')}}">
                    @error('country')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">المدينة</label>
                    <input type="text" name="city" required class="form-control" placeholder="الرياض"
                        value="{{old('city')}}">
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label for="exampleFormControlInput2" class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" id="exampleFormControlInput2"
                        placeholder="***************">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label for="exampleFormControlInput2" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        id="exampleFormControlInput2" placeholder="***************">

                </div>

                <div class="row">
                    <div class="col-12">

                        <label class="check-container">الموافقة على الشروط و األحكام
                            <input type="checkbox" name="legal_agreement" required >
                            <span class="checkmark"></span>
                        </label>
                        @error('legal_agreement')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary sumbit-form">تسجيل</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
