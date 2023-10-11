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
                <img width="150px" src="{{ asset('/images/tabby.png') }}">
                @lang('lang.installment_in_tabby')
            </h2>


            <div class="subpage">

                <div class="row">
                            <div class="alert alert-danger">
                                <h6> @lang("lang.can_not_installment_with_tabby") </h6>
                            </div>
                       
                </div>

            </div>

        </div>

        </div>

    </section>

@endsection

