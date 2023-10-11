@extends('site.master.master')
@section('page_title')
    @lang('lang.Children_management') | {{ auth()->guard('student')->user()->name }}
@endsection
@section('content')
    <style>
        .services-data {
            padding: 7px;
            text-align: center;
        }

        @media (max-width: 992px) {
            span.desc {
                font-size: .898rem;
            }

            .sumbit-form {
                display: block;
                border-radius: 5px;
                line-height: initial;
                height: auto;
                margin: auto;
                margin-bottom: 1rem;
            }

            figure {
                text-align: center;
            }
        }
    </style>
    <section class="section-box view-banner"
             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed">
    </section>
    <div class="container-fluid">

        <div class=" mb-5 text-center">
            <h3 class="text-center">     @lang('lang.add_new_child') | {{ auth()->guard('student')->user()->name }}</h3>
            <h6 class="text-center">@lang('lang.add_child_text')</h6>
        </div>

        <div>
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger mb-2"> {{ $error }} </div>
                @endforeach
            @endif
        </div>
        <div class="row justify-content-center">


            <div class="col-md-8">
                @if ($data['student']->guardian_id_number == null || $data['student']->family_id_image == null)
                    <div class="alert alert-warning mt-5" role="alert">
                        <h4 class="alert-heading">@lang('lang.complete_profile_title')@lang('lang.complete_profile_title')</h4>
                        <p>@lang('lang.complete_profile_text')</p>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#dataModal">
                            @lang('lang.Complete')
                        </button>
                    </div>
                @else
                    <form method="post" action="{{route('student.childrens.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="formRow mb-3">
                            <label class="form-label"> @lang('lang.st_name') <span
                                    class="text-danger font-bold"> *  @lang('lang.required')</span></label>
                            <input type="text" name="name" required class="form-control" placeholder="@lang('lang.st_name')"
                                   value="{{ old('name') }}">
                            @error('name')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="formRow mb-3">
                            <label class="form-label"> @lang('lang.st_birth_date')<span class="text-danger font-bold"> * @lang('lang.required')</span>
                            </label>
                            <input type="date" name="birth_date" required class="form-control"
                                   value="{{ old('birth_date') }}">
                            @error('birth_date')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="formRow mb-3">
                            <label class="form-label"> @lang('lang.st_ID_num')<span
                                        class="text-danger font-bold"> * @lang('lang.required')</span> </label>
                            <input type="text" required name="id_number" class="form-control"
                                   value="{{ old('id_number') }}">
                            @error('id_number')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>

                        <div class="formRow mb-3">
                            <label class="form-label"
                                   style="margin-left: 20px !important"> @lang('lang.gender') </label>
                            <input type="radio" name="gender" value="male" checked id="male"> <label for="male"
                                                                                                     style="font-size: 18px !important">@lang('lang.male')</label>
                            &nbsp;&nbsp;&nbsp;
                            <input type="radio" name="gender" value="female" id="female"> <label for="female"
                                                                                                 style="font-size: 18px !important">
                                @lang('lang.female')</label>
                        </div>


                        <figure>
                            <img id="preview_img1" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png"
                                 class="img-fluid img-thumbnail"/>
                        </figure>

                        <div class="formRow mb-3 new-label-title">
                            <span class="desc">@lang('lang.st_profile_photo')
                                <span class="text-danger font-bold"> * @lang('lang.required')</span>
                            </span>
                            <label for="file-upload1" class="custom-file-upload">
                                <i class="far fa-image"></i> @lang('lang.attach_photo')
                            </label>
                            <input id="file-upload1" required name="image" type="file"
                                   onchange="loadPreview(this,'#preview_img1')" ;/>
                            @error('iamge')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>


                        <figure>
                            <img id="preview_img2" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png"
                                 class="img-fluid img-thumbnail"/>
                        </figure>

                        <div class="formRow mb-3 new-label-title">
                            <span class="desc">@lang('lang.st_ID') ( @lang('lang.st_ID') @lang('lang.under_18' )</span>
                            <label for="file-upload3" class="custom-file-upload">
                                <i class="far fa-image"></i>@lang('lang.attach_photo')
                            </label>
                            <input id="file-upload3" name="id_image" type="file"
                                   onchange="loadPreview(this,'#preview_img2')" ;/>
                            @error('id_image')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>


                        <figure>
                            <img id="preview_img3" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png"
                                 class="img-fluid img-thumbnail"/>
                        </figure>

                        <div class="formRow mb-3 new-label-title">
                            <span class="desc">@lang('lang.last_sin_attach')  (@lang('lang.if_found')) </span>
                            <label for="file-upload2" class="custom-file-upload">
                                <i class="far fa-image"></i>@lang('lang.attach_photo')
                            </label>
                            <input id="file-upload2" name="certificate_image" type="file"
                                   onchange="loadPreview(this,'#preview_img3')" ;/>
                            @error('certificate_image')<span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                            @enderror
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary sumbit-form">@lang('lang.register')</button>
                            </div>
                        </div>

                    </form>
                @endif
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
