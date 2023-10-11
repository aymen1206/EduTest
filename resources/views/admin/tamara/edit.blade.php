@extends('admin.master.master')
@section('title')
    @lang('lang.tamara')
@endsection
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <style type="text/css">
        .select2-container--default .select2-selection--multiple {
            height: auto !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #414755;
        }
    </style>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">@lang('lang.edit_tamara')</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/admin')}}">@lang('lang.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{url('/admin/tamara')}}">@lang('lang.tamara')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('lang.edit_tamara')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <form class="form-horizontal form-material" method="post" action="{{url('admin/tamara')}}">
                            @csrf
                            <div class="form-group">
                                <label class="col-md-12">URL</label>
                                <div class="col-md-12">
                                    <input type="url" name="url" required
                                           class="form-control form-control-line" value="{{$data->url}}">
                                    <span class="text-danger">{{ $errors->first('url') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Token</label>
                                <div class="col-md-12">
                                    <textarea name="token" required
                                              class="form-control form-control-line">{{$data->token }}</textarea>
                                    <span class="text-danger">{{ $errors->first('token') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">Notification Token</label>
                                <div class="col-md-12">
                                    <textarea name="notification" required
                                              class="form-control form-control-line">{{$data->notification }}</textarea>
                                    <span class="text-danger">{{ $errors->first('notification') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> عدد الاقساط </label>
                                <div class="col-md-12">
                                    <input type="number" min="3" name="instalments" disabled
                                           class="form-control form-control-line" value="{{$data->instalments}}">
                                    <span class="text-danger">{{ $errors->first('instalments') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> الحد الادني للتقسيط </label>
                                <div class="col-md-12">
                                    <input type="number" min="1" name="min" required
                                           class="form-control form-control-line" value="{{$data->min}}">
                                    <span class="text-danger">{{ $errors->first('min') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12">الحد الاقصي للتقسيط </label>
                                <div class="col-md-12">
                                    <input type="number" min="1" name="max" required
                                           class="form-control form-control-line" value="{{$data->max}}">
                                    <span class="text-danger">{{ $errors->first('max') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="select2-with-tokenizer" class="col-md-12"> المدارس المسموح لها بالتقسيط مع تمارا </label>
                                <div class="col-md-12">
                                    <select class="form-control js-example-basic-multiple select2-hidden-accessible"
                                            multiple=""
                                            name="facilities[]"
                                            id="select2-with-tokenizer" style="width: 100%;"
                                            data-select2-id="select2-with-tokenizer" tabindex="-1" aria-hidden="true">
                                        @foreach($facilities as $facility)
                                        <option value="{{$facility->id}}" @if(in_array($facility->id, explode(',',$data->locked_facilities)))
                                            selected @endif>
                                            {{ $facility->name
                                        }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12"> التقسيط عن طريق تمارا </label>
                                <div class="col-md-12">
                                    <select name="status" class="form-control">
                                        <option value="1" @if($data->status == 1) selected @endif> تفعيل</option>
                                        <option value="0" @if($data->status == 0) selected @endif> تعطيل</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12" for="text"> النص بالعربية </label>
                                <div class="col-md-12">
                                    <textarea rows="7" class="form-control" name="text" id="text">{!! $data->text
                                    !!}</textarea>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-12" for="text_en"> النص بالانجليزية </label>
                                <div class="col-md-12">
                                    <textarea rows="7" class="form-control" name="text_en" id="text_en">{!!
                                    $data->text_en
                                    !!}</textarea>
                                    <span class="text-danger">{{ $errors->first('text_en') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">@lang('lang.update')</button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>

    </div>
@endsection
@section('custom-javascript')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

</script>

@endsection
