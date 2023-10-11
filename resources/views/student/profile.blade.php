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
        <div class="col-md-8">
            <h3 class="text-center">@lang('lang.Edit_profile')</h3>

            <form class="popup-form mb-5" method="post" action="{{ route('student.st_profile') }}" enctype="multipart/form-data">
                @csrf

                @if ($student->guardian_name != '')
                <div class="formRow mb-3">
                    <label class="form-label">@lang('lang.Parent_name')</label>
                    <input type="text" name="guardian_name" required class="form-control" value="{{$student->guardian_name}}">
                    @error('guardian_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endif

                <div class="formRow mb-3">
                    <label class="form-label">@lang('lang.username')</label>
                    <input type="text" name="name" required class="form-control" value="{{$student->name}}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

               <div class="formRow mb-3">
                    <label class="form-label">@lang('lang.username_en')</label>
                    <input type="text" name="name_en" required class="form-control" value="{{$student->name_en}}">
                    @error('name_en')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


                <div class="formRow mb-3 new-label-title">
                    @if ($student->image)
                        <img id="preview_img1" src="{{ asset('/'.$student->image) }}" width="150" height="150">
                    @else
                        <img id="preview_img1" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="img-fluid img-thumbnail" width="150" height="150" />
                    @endif
                    <br>
                     @lang('lang.profile_image')
                    <label for="file-upload" class="custom-file-upload">
                        <i class="far fa-image"></i> @lang('lang.attach_photo')
                    </label>
                    <input id="file-upload" name="image" type="file" onchange="loadPreview(this,'#preview_img1')";/>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


                @if ($student->certificate_image)
                <div class="formRow mb-3 new-label-title">
                    <img id="preview_img2" src="{{ asset('/'.$student->certificate_image) }}" width="150" height="150">
                    <br>
                   @lang('lang.scientific_certificate_photo')
                    <label for="file-upload2" class="custom-file-upload">
                        <i class="far fa-image"></i>@lang('lang.attach_photo')
                    </label>
                    <input id="file-upload2" name="certificate_image" type="file" onchange="loadPreview(this,'#preview_img2')";/>
                    @error('certificate_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endif


                @if ($student->id_image)
                <div class="formRow mb-3 new-label-title">
                    @if ($student->id_image)
                        <img id="preview_img3" src="{{ asset('/'.$student->id_image) }}" width="150" height="150">
                    @endif

                    <br>
                      @lang('lang.id_number_photo')
                    <label for="file-upload3" class="custom-file-upload">
                        <i class="far fa-image"></i>@lang('lang.attach_photo')
                    </label>
                    <input id="file-upload3" name="id_image" type="file" onchange="loadPreview(this,'#preview_img3')";/>
                    @error('id_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endif

                @if($student->family_id_image)
                <div class="formRow mb-3 new-label-title">
                    <img id="preview_img4" src="{{ asset('/'.$student->family_id_image) }}" width="150" height="150">
                    <br>
                    @lang('lang.family_id')
                    <label for="file-upload4" class="custom-file-upload">
                        <i class="far fa-image"></i>@lang('lang.attach_photo')
                    </label>
                    <input id="file-upload4" name="family_id_image" type="file" onchange="loadPreview(this,'#preview_img4')"; />
                    @error('family_id_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endif



                    <div class="formRow mb-3">
                        <label class="form-label">@lang('lang.id_number')</label>
                        <input type="text" name="id_number" required class="form-control"
                               value="{{$student->id_number}}">
                        @error('id_number')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
              


                <div class="formRow mb-3">
                    <label class="form-label">@lang('lang.mobile')</label>
                    <input type="tel" name="phone" required class="form-control" placeholder="9665XXXXXXXXX"
                        value="{{$student->phone}}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label for="exampleFormControlInput1" class="form-label">@lang('lang.email')</label>
                    <input type="email" name="email" required class="form-control" id="exampleFormControlInput1"
                        placeholder="name@example.com" value="{{$student->email}}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="formRow mb-3">
                    <label class="form-label">@lang('lang.city')</label>
                    <select name="city" required class="form-control p-2">
                        @foreach(DB::table('cities')->get() as $city)
                            <option @if($student->city == $city->id) selected @endif value="{{ $city->id }}">@if(LaravelLocalization::getCurrentLocaleNative() == 'العربية') {{ $city->nameAr }} @else {{ $city->nameEn }} @endif</option>
                        @endforeach
                    </select>
                    @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>


                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary sumbit-form">@lang('lang.Edit_profile')</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
<script>
    function loadPreview(input, id) {

        id = id || '#preview_img';
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(id)
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
