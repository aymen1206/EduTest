@extends('site.master.master')
@section('page_title')
@lang('lang.Create_new_order')
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
        <div class="col-12">
            <h3 class="mb-5 text-center"> @lang('lang.Create_new_order')</h3>
        </div>

        <div class="col">
            <div class="one-price" style="padding: 20px; line-height: 30px; font-size: 16px">
                <span>@lang('lang.package')  : {{ lng($price_list,'name') }}</span>
                <hr>
                <table class="table table-striped table-inverse">
                    <tbody>
                        <tr>
                            <td >@lang('lang.stage')</td>
                            <td>{{lng($price_list->_type,'name')}}</td>
                        </tr>
                        <tr>
                            <td >@lang('lang.class')</td>
                            <td>{{lng($price_list->_stage,'name')}}</td>
                        </tr>
                        <tr>
                            <td > @lang('lang.payment_method') </td>
                            <td>{{lng($price_list->subscriptionperiod,'name')}}</td>
                        </tr>
                        @if($price_list->price_discount != null )
                            <tr>
                                <td >@lang('lang.before_discount')</td>
                                <td>{{$price_list->price_discount}} @lang('lang.sar') </td>
                            </tr>

                            <tr>
                                <td > @lang('lang.saving') </td>
                                <td>{{$price_list->price_discount  - $price_list->price}}   @lang('lang.sar') </td>
                            </tr>

                        @endif
                        <tr>
                            @if($price_list->price_discount != null )
                            <td>@lang('lang.current_price')</td>
                            @else
                                <td>@lang('lang.price')  </td>
                            @endif
                            <td>{{$price_list->price}}  @lang('lang.sar')</td>
                        </tr>
           
                        <tr>
                            <td >@lang('lang.service_provider')</td>
                            <td>{{lng($facility,'name')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">@lang('lang.note')</td>
                        </tr>
                    <tr>
                        <td colspan="2">{!! lng($price_list,'note') !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col">
            <div class="one-price" style="padding: 20px; line-height: 30px; font-size: 16px">
                <span> @lang('lang.client_data') </span>
                <hr>
                <table class="table table-striped table-inverse">
                    <tbody>
                        <tr>
                            <td >@lang('lang.name')</td>
                            <td>{{$student->name}}</td>
                        </tr>
                        <tr>
                            <td >@lang('lang.id_number')</td>
                            <td>{{$student->id_number}}</td>
                        </tr>
                        <tr>
                            <td > @lang('lang.phone') </td>
                            <td>{{$student->phone}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form id="manform" action="{{route('student.makeorder')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="facility_id" value="{{$facility->id}}">
                <input type="hidden" name="price_id" value="{{$price_list->id}}">

                @if($student->id_number == '' || $student->id_number == null || $student->id_image == '' || $student->id_image == null || $student->certificate_image == '' || $student->certificate_image == null)
                <button type="button" class="btn btn-outline-secondary btn-block" style="width: 100%" data-bs-toggle="modal" data-bs-target="#completeModal"> @lang('lang.order_text_1') </button>
                <br>
                @else
                <!--<button id="submit-main-account" class="btn btn-outline-secondary btn-block" style="width: 100%">@lang('lang.complete_with_main')</button>-->
                @endif

                @if($student->childrens()->get()->count() > 0 )
                <!--<h5 class="mt-3 mb-3 text-center"> او يمكنك ايضا </h5>-->
                <div class="input-group">
                    <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary" id="child_submit" type="submit">@lang('lang.complete_with_child') </button>
                    </div>
                    <select class="custom-select form-control" required id="children_select" name="children" id="inputGroupSelect03">
                    @foreach ($student->childrens as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                    </select>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
@section('custom-javascript')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(function () {

        $('#submit-main-account').on('click', function (event) {
            event.preventDefault();

            swal({
                title: "@lang('lang.are_you_sure')",
                text: "@lang('lang.confirm_order_with_main_account')",
                icon: 'warning',
                buttons: ["@lang('lang.cancel')","@lang('lang.Complete')"],
            }).then(function(value) {
                 if (value) {
                    $('#children_select').val('0');
                    $( "#manform" ).submit();
                 }
            });
        });


        $('#child_submit').on('click', function (event) {
            event.preventDefault();

            swal({
                title: "@lang('lang.are_you_sure')",
                text: "@lang('lang.confirm_order_with_child_account')",
                icon: 'warning',
                buttons: ["@lang('lang.cancel')","@lang('lang.Complete')"],
            }).then(function(value) {
                 if (value) {
                    $( "#manform" ).submit();
                 }
            });
        });



    });
</script>
@endsection
