@extends('site.master.master')

@section('page_title')
    @lang('lang.orders')
@endsection

@section('content')
    <style>
        @media (max-width: 992px) {
            .subpage table td:before {
                content: attr(data-caption);
                display: inline-block;
                vertical-align: middle;
                margin-left: 20px;
            }

            .subpage table thead {
                display: none;
            }

            .subpage table td {
                display: flex;
                border: 0;
            }

            .table-bordered > :not(caption) > * {
                border: 0;
            }

        }
    </style>
    <section class="section-box view-banner"
             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed"></section>

    <section class="section-box edit-profile">

        <div class="container">

            <h2 class="section-title text-center">
                <img width="150px" src="{{ asset('/images/tamara.png') }}">
                @lang('lang.installment_with_tamara')
            </h2>


            <div class="subpage">

                <div class="row">
                    @if($error != null)
                        <div class="alert alert-danger">
                            <h6> @lang("lang.$error") </h6>
                        </div>
                    @else
                        @if($data == false)
                            <div class="alert alert-danger">
                                <h6> @lang("lang.can_not_installment_with_tamara") </h6>
                            </div>
                        @else
                            <div class="alert alert-success">
                                <h6> @lang("lang.can_installment_with_tamara") </h6>
                                <a href="{{ url('student/tamara/'.$order_id) }}" class="btn btn-success btn-sm">
                                    @lang("lang.pay_with_tamara")
                                </a>
                            </div>
                        @endif
                    @endif

                </div>

            </div>

        </div>

        </div>

    </section>

@endsection

