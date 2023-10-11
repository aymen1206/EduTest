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

        .card figure {
            margin: 0;
            height: 250px;
            overflow: hidden;
        }

        .card figure img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-link + .card-link {
            margin-right: .1rem;
        }

        li.list-group-item.d-flex > a {
            padding: .4rem .4rem;
        }

        @media (max-width: 992px) {
            li.list-group-item.d-flex {
                justify-content: center;
            }
        }
    </style>
    <section class="section-box view-banner"
             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed"></section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger mb-2"> {{ $error }} </div>
                    @endforeach
                @endif

            </div>

            <div class="col-md-12 mb-5 text-center">
                <h3 class="text-center"> @lang('lang.Children_management') </h3>
                <h6 class="text-center">@lang('lang.child_text')</h6>

                @if ($data['student']->guardian_id_number == null || $data['student']->family_id_image == null)
                    <div class="alert alert-warning mt-5" role="alert">
                        <h4 class="alert-heading">@lang('lang.complete_profile_title')</h4>
                        <p>@lang('lang.complete_profile_text')</p>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#dataModal">
                            @lang('lang.Complete')
                        </button>
                    </div>
                @else
                    <a href="{{ url('student/childrens/create') }}" class="btn btn-sm btn-success"> <i
                            class="fa fa-plus-circle" aria-hidden="true"></i> @lang('lang.add_new')  </a>
                @endif
            </div>

            @if (count($data['childrens']))
                @foreach ($data['childrens'] as $child)
                    <div class="col-md-3 mb-5">
                        <div class="card">
                            <figure>
                                <img class="card-img-top" src="{{ asset('/'.$child->image) }}" alt="Card image cap">
                            </figure>
                            <div class="card-body">
                                <h5 class="card-title">{{ $child->name }}</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">@lang('lang.id_number') : {{ $child->id_number }}</li>
                                <li class="list-group-item">@lang('lang.gender') : {{ $child->gender }}</li>
                                <li class="list-group-item">@lang('lang.st_birth_date')  : {{ $child->birth_date }}</li>
                                <li class="list-group-item d-flex">
                                    <a href="{{ asset('/'.$child->id_image) }}" rel="group"
                                       class="fancybox card-link btn btn-outline-success btn-sm">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        @lang('lang.id_number_photo')
                                    </a>
                                    <a href="{{ asset('/'.$child->certificate_image) }}" rel="group"
                                       class="fancybox card-link btn btn-outline-success btn-sm"> <i
                                            class="fa fa-graduation-cap" aria-hidden="true"></i> @lang('lang.scientific_certificate_photo')</a>
                                </li>
                            </ul>
                            <div class="card-body">
                                <div class="row">
                                    <a style="background: #19bab2; border:none; color:white;margin-left: 10px;"
                                       href="{{ url('/student/childrens/'.$child->id.'/edit') }}"
                                       class="col btn btn-info btn-block"> @lang('lang.edit') </a>
                                    <a style="background: #19bab2; border:none; color:white"
                                       href="{{ url('/student/childrens/'.$child->id.'/delete') }}"
                                       class="col btn btn-warning btn-block delete-confirm"> @lang('lang.delete') </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3 class="text-center">@lang('lang.No_results')</h3>
            @endif


        </div>
    </div>
@endsection
@section('custom-javascript')
    <script type="text/javascript">
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: "@lang('lang.are_you_sure')",
                text: "@lang('lang.permanently_deleted')",
                icon: 'warning',
                buttons: ["@lang('lang.cancel')", "@lang('lang.delete')"],
            }).then(function (value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });

        $(document).ready(function () {
            $(".fancybox").fancybox();
        });

    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"
            integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"
          integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection
