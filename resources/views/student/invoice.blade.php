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

        @media print {
            .receipt-content .logo a:hover {
                text-decoration: none;
                color: #7793C4;
            }

            .receipt-content .invoice-wrapper {
                background: #FFF;
                border: 1px solid #CDD3E2;
                box-shadow: 0px 0px 1px #CCC;
                padding: 40px 40px 60px;
                margin-top: 40px;
                border-radius: 4px;
            }

            .receipt-content .invoice-wrapper .payment-details span {
                color: #A9B0BB;
                display: block;
            }
            .receipt-content .invoice-wrapper .payment-details a {
                display: inline-block;
                margin-top: 5px;
            }

            .receipt-content .invoice-wrapper .line-items .print a {
                display: inline-block;
                border: 1px solid #9CB5D6;
                padding: 13px 13px;
                border-radius: 5px;
                color: #708DC0;
                font-size: 13px;
                -webkit-transition: all 0.2s linear;
                -moz-transition: all 0.2s linear;
                -ms-transition: all 0.2s linear;
                -o-transition: all 0.2s linear;
                transition: all 0.2s linear;
            }

            .receipt-content .invoice-wrapper .line-items .print a:hover {
                text-decoration: none;
                border-color: #333;
                color: #333;
            }

            .receipt-content {
                background: #ECEEF4;
            }
            @media (min-width: 1200px) {
                .receipt-content .container {width: 900px; }
            }

            .receipt-content .logo {
                text-align: center;
                margin-top: 50px;
            }

            .receipt-content .logo a {
                font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
                font-size: 36px;
                letter-spacing: .1px;
                color: #555;
                font-weight: 300;
                -webkit-transition: all 0.2s linear;
                -moz-transition: all 0.2s linear;
                -ms-transition: all 0.2s linear;
                -o-transition: all 0.2s linear;
                transition: all 0.2s linear;
            }

            .receipt-content .invoice-wrapper .intro {
                line-height: 25px;
                color: #444;
            }

            .receipt-content .invoice-wrapper .payment-info {
                margin-top: 25px;
                padding-top: 15px;
            }

            .receipt-content .invoice-wrapper .payment-info span {
                color: #A9B0BB;
            }

            .receipt-content .invoice-wrapper .payment-info strong {
                display: block;
                color: #444;
                margin-top: 3px;
            }

            @media (max-width: 767px) {
                .receipt-content .invoice-wrapper .payment-info .text-right {
                    text-align: left;
                    margin-top: 20px; }
            }
            .receipt-content .invoice-wrapper .payment-details {
                border-top: 2px solid #EBECEE;
                margin-top: 30px;
                padding-top: 20px;
                line-height: 22px;
            }


            @media (max-width: 767px) {
                .receipt-content .invoice-wrapper .payment-details .text-right {
                    text-align: left;
                    margin-top: 20px; }
            }
            .receipt-content .invoice-wrapper .line-items {
                margin-top: 40px;
            }
            .receipt-content .invoice-wrapper .line-items .headers {
                color: #A9B0BB;
                font-size: 13px;
                letter-spacing: .3px;
                border-bottom: 2px solid #EBECEE;
                padding-bottom: 4px;
            }
            .receipt-content .invoice-wrapper .line-items .items {
                margin-top: 8px;
                border-bottom: 2px solid #EBECEE;
                padding-bottom: 8px;
            }
            .receipt-content .invoice-wrapper .line-items .items .item {
                padding: 10px 0;
                color: #696969;
                font-size: 15px;
            }
            @media (max-width: 767px) {
                .receipt-content .invoice-wrapper .line-items .items .item {
                    font-size: 13px; }
            }
            .receipt-content .invoice-wrapper .line-items .items .item .amount {
                letter-spacing: 0.1px;
                color: #84868A;
                font-size: 16px;
            }
            @media (max-width: 767px) {
                .receipt-content .invoice-wrapper .line-items .items .item .amount {
                    font-size: 13px; }
            }

            .receipt-content .invoice-wrapper .line-items .total {
                margin-top: 30px;
            }

            .receipt-content .invoice-wrapper .line-items .total .extra-notes {
                float: left;
                width: 40%;
                text-align: left;
                font-size: 13px;
                color: #7A7A7A;
                line-height: 20px;
            }

            @media (max-width: 767px) {
                .receipt-content .invoice-wrapper .line-items .total .extra-notes {
                    width: 100%;
                    margin-bottom: 30px;
                    float: none; }
            }

            .receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
                display: block;
                margin-bottom: 5px;
                color: #454545;
            }

            .receipt-content .invoice-wrapper .line-items .total .field {
                margin-bottom: 7px;
                font-size: 14px;
                color: #555;
            }

            .receipt-content .invoice-wrapper .line-items .total .field.grand-total {
                margin-top: 10px;
                font-size: 16px;
                font-weight: 500;
            }

            .receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
                color: #20A720;
                font-size: 16px;
            }

            .receipt-content .invoice-wrapper .line-items .total .field span {
                display: inline-block;
                margin-left: 20px;
                min-width: 85px;
                color: #84868A;
                font-size: 15px;
            }

            .receipt-content .invoice-wrapper .line-items .print {
                margin-top: 50px;
                text-align: center;
            }



            .receipt-content .invoice-wrapper .line-items .print a i {
                margin-right: 3px;
                font-size: 14px;
            }

            .receipt-content .footer {
                margin-top: 40px;
                margin-bottom: 110px;
                text-align: center;
                font-size: 12px;
                color: #969CAD;
            }
        }


        .receipt-content .logo a:hover {
            text-decoration: none;
            color: #7793C4;
        }

        .receipt-content .invoice-wrapper {
            background: #FFF;
            border: 1px solid #CDD3E2;
            box-shadow: 0px 0px 1px #CCC;
            padding: 40px 40px 60px;
            margin-top: 40px;
            border-radius: 4px;
        }

        .receipt-content .invoice-wrapper .payment-details span {
            color: #A9B0BB;
            display: block;
        }

        .receipt-content .invoice-wrapper .payment-details a {
            display: inline-block;
            margin-top: 5px;
        }

        .receipt-content .invoice-wrapper .line-items .print a {
            display: inline-block;
            border: 1px solid #9CB5D6;
            padding: 13px 13px;
            border-radius: 5px;
            color: #708DC0;
            font-size: 13px;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .line-items .print a:hover {
            text-decoration: none;
            border-color: #333;
            color: #333;
        }

        .receipt-content {
            background: #ECEEF4;
        }

        @media (min-width: 1200px) {
            .receipt-content .container {
                width: 900px;
            }
        }

        .receipt-content .logo {
            text-align: center;
            margin-top: 50px;
        }

        .receipt-content .logo a {
            font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
            font-size: 36px;
            letter-spacing: .1px;
            color: #555;
            font-weight: 300;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }

        .receipt-content .invoice-wrapper .intro {
            line-height: 25px;
            color: #444;
        }

        .receipt-content .invoice-wrapper .payment-info {
            margin-top: 25px;
            padding-top: 15px;
        }

        .receipt-content .invoice-wrapper .payment-info span {
            color: #A9B0BB;
        }

        .receipt-content .invoice-wrapper .payment-info strong {
            display: block;
            color: #444;
            margin-top: 3px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-info .text-right {
                text-align: left;
                margin-top: 20px;
            }
        }

        .receipt-content .invoice-wrapper .payment-details {
            border-top: 2px solid #EBECEE;
            margin-top: 30px;
            padding-top: 20px;
            line-height: 22px;
        }


        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-details .text-right {
                text-align: left;
                margin-top: 20px;
            }
        }

        .receipt-content .invoice-wrapper .line-items {
            margin-top: 40px;
        }

        .receipt-content .invoice-wrapper .line-items .headers {
            color: #A9B0BB;
            font-size: 13px;
            letter-spacing: .3px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 4px;
        }

        .receipt-content .invoice-wrapper .line-items .items {
            margin-top: 8px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 8px;
        }

        .receipt-content .invoice-wrapper .line-items .items .item {
            padding: 10px 0;
            color: #696969;
            font-size: 15px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item {
                font-size: 13px;
            }
        }

        .receipt-content .invoice-wrapper .line-items .items .item .amount {
            letter-spacing: 0.1px;
            color: #84868A;
            font-size: 16px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item .amount {
                font-size: 13px;
            }
        }

        .receipt-content .invoice-wrapper .line-items .total {
            margin-top: 30px;
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes {
            float: left;
            width: 40%;
            text-align: left;
            font-size: 13px;
            color: #7A7A7A;
            line-height: 20px;
        }

        @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .total .extra-notes {
                width: 100%;
                margin-bottom: 30px;
                float: none;
            }
        }

        .receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
            display: block;
            margin-bottom: 5px;
            color: #454545;
        }

        .receipt-content .invoice-wrapper .line-items .total .field {
            margin-bottom: 7px;
            font-size: 14px;
            color: #555;
        }

        .receipt-content .invoice-wrapper .line-items .total .field.grand-total {
            margin-top: 10px;
            font-size: 16px;
            font-weight: 500;
        }

        .receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
            color: #20A720;
            font-size: 16px;
        }

        .receipt-content .invoice-wrapper .line-items .total .field span {
            display: inline-block;
            margin-left: 20px;
            min-width: 85px;
            color: #84868A;
            font-size: 15px;
        }

        .receipt-content .invoice-wrapper .line-items .print {
            margin-top: 50px;
            text-align: center;
        }


        .receipt-content .invoice-wrapper .line-items .print a i {
            margin-right: 3px;
            font-size: 14px;
        }

        .receipt-content .footer {
            margin-top: 40px;
            margin-bottom: 110px;
            text-align: center;
            font-size: 12px;
            color: #969CAD;
        }

    </style>
    <section class="section-box view-banner"

             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed">

    </section>

    <section class="section-box edit-profile">

        <div class="container">

            <h2 class="section-title text-center"> @lang('lang.invoice') </h2>


            <div class="subpage">

                <div class="row">


                    <div class="receipt-content">
                        <div class="container bootstrap snippets bootdey">
                            <div class="row">
                                <div id="printdiv" class="col-md-12">
                                    <div class="invoice-wrapper mb-5" style="position: relative">
                                        <div class="col-12" style="padding: 14px;background: #707070;">
                                            <div class="row">
                                                <div class="col-6">
                                                <img src="{{ asset('uploads/settings/1643894636.png') }}">
                                            </div>
                                                <div style="color: white" class="col-6 pt-3">
                                                    <span class="fa fa-map-marker"></span> {{$contact->address}}
                                                    <br>
                                                    <span class="fa fa-phone"></span> {{$contact->phone}}
                                                    <br>
                                                    <span class="fa fa-envelope"></span> {{$contact->email}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="intro mt-3">
                                            @lang('lang.hi')
                                            <strong>{{ auth()->guard('student')->user()->name }}</strong>,
                                            <br>
                                            @lang('lang.receipt_title') <strong> {{ $invoice->invoice_value }} </strong>
                                            (@lang('lang.sar'))
                                        </div>

                                        <div class="payment-info">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <span>@lang('lang.Payment_No')</span>
                                                    <strong>{{ $invoice->receipt }}</strong>
                                                    <span>@lang('lang.Payment_Date')</span>
                                                    <strong>{{ $invoice->updated_at }}</strong>
                                                </div>
                                                <div class="col-sm-6 text-right">

                                                    <span>@lang('lang.Card_Number')</span>
                                                    <strong> {{ $invoice->card_first_six.'******'.$invoice->card_last_four }} </strong>
                                                    <strong> {{ $invoice->card_brand }} </strong>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="payment-details">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <span>@lang('lang.Client')</span>
                                                    <strong>
                                                        {{ $invoice->customer_name }}
                                                    </strong>
                                                    <p>
                                                        {{ $invoice->customer_phone }}
                                                        <br>
                                                        <a href="#">
                                                            {{ $client->email }}
                                                        </a>
                                                    </p>
                                                </div>
                                                <div class="col-sm-6 text-right">
                                                    <span>@lang('lang.Payment_To')</span>
                                                    <strong>
                                                        ذا ايديوكي theedukey
                                                    </strong>
                                                    <p>
                                                        {{$contact->address}}
                                                        <br>
                                                        {{$contact->phone}}
                                                        <br>
                                                        <a href="#">
                                                            {{$contact->email}}
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="payment-details">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <th>@lang('lang.service_provider')</th>
                                                        <th>@lang('lang.service')</th>
                                                        <th>@lang('lang.class')</th>
                                                        <th>@lang('lang.payment_method')</th>
                                                        <th>@lang('lang.price')</th>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td data-caption="@lang('lang.service_provider')"> {{ lng($order->facility,'name') }}</td>
                                                            <td data-caption="@lang('lang.name')"> {{  lng($order->pricelist,'name')  }}</td>
                                                            <td data-caption="@lang('lang.stage')"> {{ lng($order->pricelist->_type,'name') }}, {{ lng($order->pricelist->_stage,'name') }}</td>
                                                            <td data-caption="@lang('lang.payment_method')"> {{ lng($order->pricelist->subscriptionperiod,'name')  }}</td>
                                                            <td data-caption="@lang('lang.price')"> {{ $invoice->invoice_value }} @lang('lang.sar')</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="line-items">

                                            <div class="total text-right">
                                                <!--<p class="extra-notes">-->
                                                <!--    <strong>@lang('lang.Extra_Notes')</strong>-->
                                                <!--    {{ $invoice->status }} : {{ $invoice->message }}-->
                                                <!--</p>-->
                                                <div class="field">
                                                    @lang('lang.price') :  <span>{{ $invoice->invoice_value }} @lang('lang.sar')</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        </div>

    </section>

@endsection
@section('custom-javascript')
    <script>
        $(function () {

            $('#print').one('click',function (event){
                alert(1);
                event.preventDefault();
                PrintElem('printdiv');
            });

            function PrintElem(elem)
            {
                var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                mywindow.document.write('<html><head><title>' + document.title  + '</title>');
                mywindow.document.write('<style rel="stylesheet" href="{{asset('/print.css')}}" type="text/css" />');
                mywindow.document.write('</head><body >');
                mywindow.document.write('<h1>' + document.title  + '</h1>');
                mywindow.document.write(document.getElementById(elem).innerHTML);
                mywindow.document.write('</body></html>');

                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/

                mywindow.print();
                mywindow.close();

                return true;
            }

        });
    </script>
@endsection

