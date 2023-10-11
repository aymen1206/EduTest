@extends('site.master.master')
@section('page_title')
تسجيل ولي أمر طالب تحت سن 18
@endsection
@section('content')
  <section class="section-box view-banner" style="background: url('https://media-exp1.licdn.com/dms/image/C4E1BAQH-9J2-__M3NA/company-background_10000/0/1549552528714?e=2159024400&v=beta&t=26cx4LCxHdtbgXtomZyaPFCV5xgxsDEKTaGtEHbZChQ');"></section>

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
              <h3 class="text-center">تسجيل طالب فوق سن 18</h3>

              <form class="popup-form" method="post" action="{{ url('student\register') }}" enctype="multipart/form-data">

                <div class="formRow mb-3">
                    <label class="form-label">اسم ولي الامر</label>
                    <input type="text" name="guardian_name" required class="form-control" placeholder="محمد عبد الله القحطاني">
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">اسم الطالب</label>
                    <input type="text" name="name" required class="form-control" placeholder="عبد الله محمد عبد الله القحطاني">
                </div>

                  <div class="formRow mb-3 new-label-title">
                      الصورة الشخصية للطالب
                      <label for="file-upload" class="custom-file-upload">
                          <i class="far fa-image"></i>ارفاق صورة
                      </label>
                      <input id="file-upload" name="image" required type="file"/>
                  </div>

                  <div class="formRow mb-3">
                      <label class="form-label">رقم هوية ولي الأمر</label>
                      <input type="text" name="guardian_id_number	" required class="form-control">
                  </div>


                  <div class="formRow mb-3">
                      <label class="form-label">رقم هوية الطالب</label>
                      <input type="text" name="id_number" required class="form-control">
                  </div>

                  <div class="formRow mb-3 new-label-title">
                      صورة بطاقة العائلة
                      <label for="file-upload2" class="custom-file-upload">
                          <i class="far fa-image"></i>ارفاق صورة
                      </label>
                      <input id="file-upload2" name="family_id_image" required type="file"/>
                  </div>


                  <div class="formRow mb-3 new-label-title">
                    ارفاق آخر شهادة علمية
                    <label for="file-upload3" class="custom-file-upload">
                        <i class="far fa-image"></i>ارفاق صورة
                    </label>
                    <input id="file-upload3" name="certificate_image" required type="file"/>
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">رقم الجوال</label>
                    <input type="text" name="phone" required class="form-control" placeholder="9665XXXXXXXXX">
                </div>

                <div class="formRow mb-3">
                    <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                    <input type="email" name="email" required class="form-control" id="exampleFormControlInput1"
                           placeholder="name@example.com">
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">الدولة</label>
                    <input type="text" name="country" required class="form-control" placeholder="المملكة العربية السعودية">
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">المدينة</label>
                    <input type="text" name="city" required class="form-control" placeholder="الرياض">
                </div>

                {{-- <div class="formRow mb-3">
                    <label class="form-label">الموقع علي الخريطة</label>
                    <input type="text" class="form-control" placeholder="الرياض">
                    <div class="select-location-map"><i class="fas fa-street-view"></i></div>
                </div> --}}

                <div class="formRow mb-3">
                    <label for="exampleFormControlInput2" class="form-label">كلمة المرور</label>
                    <input type="password" name="password" required minlength="8" class="form-control" id="exampleFormControlInput2"
                           placeholder="***************">
                </div>

                <div class="formRow mb-3">
                    <label for="exampleFormControlInput2" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" required minlength="8" class="form-control" id="exampleFormControlInput2"
                           placeholder="***************">
                </div>

                <div class="row">
                    <div class="col-12">

                        <label class="check-container">الموافقة على الشروط و األحكام
                            <input type="checkbox" name="legal_agreement" required checked="">
                            <span class="checkmark"></span>
                        </label>

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
