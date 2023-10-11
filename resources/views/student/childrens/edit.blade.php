@extends('site.master.master')
@section('page_title')
    @lang('edit_children')  | {{ auth()->guard('student')->user()->name }}
@endsection
@section('content')
    <style>
        .services-data {
            padding: 7px;
            text-align: center;
        }

    </style>
    <section class="section-box view-banner"
             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed">
    </section>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-8">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger mb-2"> {{ $error }} </div>
                    @endforeach
                @endif
            </div>

            <div class="col-md-12 mb-5 text-center">
                <h3 class="text-center"> @lang('lang.edit_children')</h3>
            </div>


            <div class="col-8">
                <form method="post" action="{{route('student.childrens.update',$data->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="formRow mb-3">
                        <label class="form-label">@lang('lang.st_name') <span class="text-danger font-bold"> * @lang('lang.required')</span></label>
                        <input type="text" name="name" required class="form-control" placeholder="@lang('lang.st_name')"
                               value="{{ $data->name }}">
                        @error('name')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="formRow mb-3">
                        <label class="form-label">@lang('lang.st_birth_date') <span class="text-danger font-bold"> * @lang('lang.required')</span></label>
                        <input type="date" name="birth_date" required class="form-control"
                               value="{{ $data->birth_date }}">
                        @error('birth_date')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="formRow mb-3">
                        <label class="form-label">@lang('lang.st_ID') <span class="text-danger font-bold"> * @lang('lang.required')</span> </label>
                        <input type="text" required name="id_number" class="form-control" id="idn2"
                               value="{{ $data->id_number }}">
                        @error('id_number')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="formRow mb-3">
                        <label class="form-label" style="margin-left: 20px !important"> @lang('lang.gender') </label>
                        <input type="radio" name="gender" value="male" @if($data->gender == 'male') checked @endif id="male"> <label for="male" style="font-size: 18px !important">@lang('lang.male')</label>
                        <input type="radio" name="gender" value="female" id="female" @if($data->gender == 'female') checked @endif><label for="female" style="font-size: 18px !important">@lang('lang.female')</label>
                    </div>

                    <img id="image" src="{{ asset('/'.$data->image) }}" width="100" height="100" alt="">

                    <div class="formRow mb-3 new-label-title">
                        @lang('lang.st_profile_photo') <span class="text-danger font-bold"> * @lang('lang.required')</span>
                        <label for="file-upload1" class="custom-file-upload">
                            <i class="far fa-image"></i> @lang('lang.attach_photo')
                        </label>
                        <input id="file-upload1" name="image" type="file" onchange="loadPreview(this,'#image')" ;/>
                        @error('image')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <img id="id_image" src="{{ asset('/'.$data->id_image) }}" width="100" height="100" alt="">
                    <div class="formRow mb-3 new-label-title">
                        @lang('lang.st_ID')  (  @lang('lang.under_18') )
                        <label for="file-upload3" class="custom-file-upload">
                            <i class="far fa-image"></i> @lang('lang.attach_photo')
                        </label>
                        <input id="file-upload3" name="id_image" type="file" onchange="loadPreview(this,'#id_image')" ;/>
                        @error('id_image')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <img id="certificate_image" src="{{ asset('/'.$data->certificate_image) }}" width="100" height="100" alt="">
                    <div class="formRow mb-3 new-label-title">
                        @lang('lang.last_sin_attach')  ( @lang('lang.if_found') )
                        <label for="file-upload2" class="custom-file-upload">
                            <i class="far fa-image"></i>  @lang('lang.attach_photo')
                        </label>
                        <input id="file-upload2" name="certificate_image" type="file" onchange="loadPreview(this,'#certificate_image')" ;/>
                        @error('certificate_image')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary sumbit-form"> تعديل</button>
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
