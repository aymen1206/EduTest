@extends('site.master.master')
@php
use App\Models\EduFacility;
@endphp
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
    <style>
        .ratings {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            margin-bottom: 10px;
        }

        .ratings > input {
            display: none
        }

        .ratings > label {
            position: relative;
            width: 1em;
            font-size: 3vw;
            color: #FFD600;
            cursor: pointer;
        }

        .ratings > label::before {
            content: "\2605";
            position: absolute;
            opacity: 0
        }

        .ratings > label:hover:before,
        .ratings > label:hover ~ label:before {
            opacity: 1 !important
        }

        .ratings > input:checked ~ label:before {
            opacity: 1
        }

        .ratings:hover > input:checked ~ label:before {
            opacity: 0.4
        }

        .one-price {
            box-shadow: 0px 0px 24px -14px #0000004d !important;
            border: 1px solid #ddd;
        }

        .one-price ul {
            padding: 0;
            list-style-type: none;
            line-height: 2;
            font-size: 1rem;
        }

        .one-price ul > li:before {
            content: '\f058';
            display: inline-flex;
            align-items: center;
            margin-left: 1px;
            font-family: 'Font Awesome 5 Free';
            color: goldenrod;
        }
    </style>
    <section class="section-box view-banner"

             style="height: 200px;background: url('{{ asset('images/1549552528714.jpeg') }}');background-attachment:fixed">

    </section>
    <section class="section-box edit-profile">

        <div class="container">

            <h2 class="section-title text-center"> @lang('lang.orders') </h2>


            <div class="subpage">

                <div class="row">

                    @if(count($data) == 0)

                        <h3 class="section-title text-center"> @lang('lang.No_results') </h3>
                    @else
                        <table class="table table-bordered table-hover">

                            <thead>

                            <th>@lang('lang.order_num')</th>

                            <th>@lang('lang.service_provider')</th>

                            <th>@lang('lang.status')</th>

                            <th>@lang('lang.name')</th>

                            <th>@lang('lang.stage')</th>

                            <th>@lang('lang.class') </th>

                            <th>@lang('lang.order_type')</th>

                            <th>@lang('lang.payment_method')</th>

                            <th>@lang('lang.price')</th>

                            <th>@lang('lang.from') - @lang('lang.to')</th>

                            <th>@lang('lang.actions')</th>

                            </thead>

                            <tbody>

                            @foreach($data as $order)

                                <tr>

                                    <td data-caption="@lang('lang.order_num')"> {{ $order->id }}</td>

                                    <td data-caption="@lang('lang.service_provider')"> {{ lng($order->facility,'name') }}</td>

                                    <td class="text-center" data-caption="@lang('lang.status')">
                                        @if($order->status == 'is_paid')
                                          <span class="btn btn-sm btn-outline-success"> @lang('lang.complete') </span>
                                        @elseif($order->status == 'accepted')
                                            <span class="btn  btn-outline-success btn-sm">@lang('lang.order_accepted') </span>
                                        @elseif($order->status == 'new')
                                            <span class="btn  btn-outline-info btn-sm"> @lang('lang.new')</span>
                                        @elseif($order->status == 'under_revision')
                                            <span class="btn  btn-outline-warning btn-sm">@lang('lang.processing')</span>
                                        @elseif($order->status == 'rejected')
                                            <span class="btn  btn-outline-danger btn-sm">@lang('lang.rejected')</span>
                                        @endif
                                    </td>

                                    <td data-caption="@lang('lang.name')"> {{  lng($order->pricelist,'name')  }}</td>

                                    <td data-caption="@lang('lang.stage')"> {{ lng($order->pricelist->_type,'name') }}</td>

                                    <td data-caption="@lang('lang.class')"> {{ lng($order->pricelist->_stage,'name') }}</td>

                                    <td data-caption="@lang('lang.order_type')">

                                        @if($order->children == null || $order->children == 0)

                                            @lang('lang.main_account')

                                        @else

                                            <a href="{{ url('student/childrens/'.$order->children.'/edit') }}">
                                                @lang('lang.children'):
                                                @if(DB::table('childrens')->where('id',$order->children)->first() != null)
                                                    {{ DB::table('childrens')->where('id',$order->children)->first()->name}}
                                                @endif
                                            </a>

                                    @endif

                                    <td data-caption="@lang('lang.payment_method')"> {{ lng($order->pricelist->subscriptionperiod,'name')  }}</td>

                                    <td data-caption="@lang('lang.price')"> {{ $order->pricelist->price }} @lang('lang.sar')</td>

                                    <td class="text-center" data-caption="@lang('lang.actions')">

                                        @if ($order->status == 'is_paid')
                                            @if($order->tamara == 1)
                                             <a
                                                   href="{{ url('/student/tamara/invoice/'.Hashids::encode($order->id)) }}"
                                                   target="_blank">
                                                    <img width="70px" src="{{ asset('/images/tamara.png') }}">
                                                </a>
                                            @elseif($order->tabby == 1)
                                                <a
                                                   href="{{ url('/student/tabby/invoice/'.Hashids::encode($order->id)) }}"
                                                   target="_blank">
                                                    <img width="70px" src="{{ asset('/images/tabby.png') }}">
                                                </a>  
                                            @elseif($order->jeel == 1)
                                                <a
                                                   href="{{ url('/student/jeel/invoice/'.Hashids::encode($order->id)) }}"
                                                   target="_blank">
                                                    <img width="70px" src="{{ asset('/images/jeel-pay.jpeg') }}">
                                                </a>
                                            @else
                                               
                                                <a class="btn btn-success btn-sm"
                                                   href="{{ url('/student/invoice/'.$order->InvoiceId.'/'.$order->id) }}"
                                                   target="_blank">
                                                    <span class="fa fa-file"></span> @lang('lang.invoice')
                                                </a>
                                            @endif

                                        @else

                                            @if($order->status == 'accepted')

                                                <a class="btn btn-block btn-sm btn-outline-success"
                                                style="width: 90%"
                                                   href="{{ url('student/get-payment-methods/'.Hashids::encode($order->id)) }}">
                                                    @lang('lang.online_payment')
                                                </a>

                                                @if(
                                                    $tamara_config->status == 1
                                                    && $order->pricelist->price >= $tamara_config->min
                                                    && $order->pricelist->price <= $tamara_config->max
                                                    && in_array($order->facility_id,explode(',',
                                                    $tamara_config->locked_facilities))
                                                )
                                                <div class="mt-2"> 

                                                    <a class="btn btn-block btn-sm btn-outline-success" style="width: 90%" href="{{ url('student/tamara-payment/'.Hashids::encode($order->id))}}">
                                                        <img width="70px" src="{{ asset('/images/tamara.png') }}">@lang('lang.installment_with_tamara')
                                                    </a>
                                                </div>
                                                 @endif
                                            
                                                @if(
                                                    $tabby_config->status == 1
                                                    && $order->pricelist->price >= $tabby_config->min
                                                    && $order->pricelist->price <= $tabby_config->max
                                                    && in_array($order->facility_id,explode(',',
                                                    $tabby_config->locked_facilities))
                                                )
                                                 <div class="mt-2"> 

                                                    <a class="btn btn-block btn-sm btn-outline-success" style="width: 90%" href="{{ url('student/tabby-payment/'.Hashids::encode($order->id))}}">
                                                        <img width="70px" src="{{ asset('/images/tabby.png') }}">@lang('lang.installment_with_tabby')
                                                    </a>
                                                </div>
                                                 @endif

                                                   @if(
                                                    $jeel_config->status == 1
                                                    && $order->pricelist->price >= $jeel_config->min
                                                    && $order->pricelist->price <= $jeel_config->max
                                                    && in_array($order->facility_id,explode(',',
                                                    $jeel_config->locked_facilities))
                                                )

                                             <div class="mt-2"> 

                                                    <a class="btn btn-block btn-sm btn-outline-success" style="width: 90%" href="{{ url('student/jeel-installments/'.Hashids::encode($order->id))}}">
                                                        <img width="70px" src="{{ asset('/images/jeel-pay.jpeg') }}">@lang('lang.installment_with_jeel')
                                                    </a>
                                                </div>
                                                 @endif
                                                 
                                                <div class="mt-2">
                                                    <a class="btn btn-block btn-sm"
                                                    href="{{ url('student/alrajhi-installments/'.Hashids::encode($order->id))}}"
                                                    style="background-color: #221BFF; color: white; width: 90%" >
                                                    <img width="30px" height="30px" src="{{ asset('/images/alrajhi.png') }}">  @lang('lang.installment_with_rajhi')
                                                </a>
                                                </div>
                                         



                                            @elseif($order->status == 'rejected')

                                                <a class="btn btn-block btn-sm btn-outline-danger">@lang('lang.No_results')</a>

                                            @else

                                                <a class="btn btn-block btn-sm btn-warning">@lang('lang.processing')</a>

                                            @endif

                                        @endif

                                    </td>
                                    <td>
                                    </td>

                                </tr>
                            @php
                                $Facility = EduFacility::find($order->facility_id);
                            @endphp                                        

                            @if($order->rate == null && $order->status == 'is_paid' )
                                         <section>
                                                <div class="container">
                                                    @if (count($Facility->comments()->where('approved',1)->get()))
                                                        <h2 class="section-title text-center">@lang('lang.Customer_Reviews')</h2>
                                                        <div class="owl-testimonial owl-carousel owl-theme">
                                                            @foreach($Facility->comments()->where('approved',1)->orderBy('id','desc')->take(10)->get() as $comment)
                                                                <div class="item text-center">
                                                                    <img class="testimonial-avatar" src="{{ asset('/'.$comment->student->image) }}"/>
                                                                    <h4 class="testimonial-user">{{ $comment->student->name }}</h4>
                                                                    <span class="testimonial-pos">
                                                                @for ($i = 0 ; $i < $comment->rate; $i++)
                                                                            <i class="fa fa-star text-warning" aria-hidden="true"></i>
                                                                        @endfor
                                                            </span>
                                                                    <p class="testimonial-text">{{$comment->comment}}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                  <div class="modal " style="display: block!important;" id="myModal" role="dialog">
                                                    <div class="modal-dialog">
                                                    
                                                      <!-- Modal content-->
                                                      <div class="modal-content">
                                                           <h2 class="section-title text-center mt-5">@lang('lang.rate_us') </h2>
                                                           <h4 class=" text-center mt-5">{{ lng($order->facility,'name') }}</h4>
                                                                    <form class="contact-us-form" method="post" action="{{ route('student.rate') }}">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="ratings">
                                                                                    <input type="radio" name="rating" value="5" id="5">
                                                                                    <label for="5">☆</label>
                                                                                    <input type="radio" name="rating" value="4" id="4">
                                                                                    <label for="4">☆</label>
                                                                                    <input type="radio" name="rating" value="3" id="3">
                                                                                    <label for="3">☆</label>
                                                                                    <input type="radio" name="rating" value="2" id="2">
                                                                                    <label for="2">☆</label>
                                                                                    <input type="radio" name="rating" value="1" id="1">
                                                                                    <label for="1">☆</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <textarea class="form-control" name="comment" required rows="3"
                                                                                          placeholder="@lang('lang.type_review')"></textarea>
                                                                                <input type="hidden" name="facility" value="{{ $order->facility_id }}">
                                                                            </div>
                                                                            <div class="col-6 text-right">
                                                                                <button type="submit" class="btn btn-primary" style="margin-top: 15px">@lang('lang.send')</button>
                                                                            </div>
                                                                            </form>
                                                                            <div class="col-6 text-left" style="width:50%; text-align:left;">
                                                                            <a  class="btn btn-dark" style="margin-top: 15px" href="{{ url("/student/Skip-rate/$order->facility_id/skip") }}" >@lang('lang.skip')</a>
                                                                            </div>
                                                                        </div>
                                                                    
                                                      </div>
                                                      
                                                    </div>
                                                  </div>
                                                 
                                    </div>
                                </section>
                                @endif
                            @endforeach

                            </tbody>

                        </table>
                    @endif
                </div>

            </div>

        </div>

        </div>

    </section>

@endsection

