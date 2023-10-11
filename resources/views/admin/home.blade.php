@extends('admin.master.master')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-sm-5 col-xs-12 align-self-center">
                <h4 class="page-title">احصائيات عامة </h4>

            </div>
        </div>
    </div>
   <div class="container-fluid">
        <div class="row">
            <h3 class="mb-3"> احصائيات الطلبات </h3>  
            <hr>      
        </div>
        <div class="row">
                 <div class="col-sm-3 col-xs-12">
                    <div class="card card-hover">
                        <div class="card-body"style="background:url({{asset('assets/')}}/images/background/active-bg.png) no-repeat top center;">
                            <h4> كل الطلبات </h4>
                            <hr>
                            <span>    الطلبات : {{ $orders['total']->count() }} </span>  
                            <span style="float: left">   الاسعار : {{ $orders['total']->sum_of_prices }}  </span>                                   
                        </div>
                    </div>
                 </div>            

            @foreach ($orders['types'] as $key => $dt)

            <div class="col-sm-3 col-xs-12" >
                <div class="card card-hover">
                    <div class="card-body"style="background:url({{asset('assets/')}}/images/background/active-bg.png) no-repeat top center;">
                        <h4> {{ $dt->type_name }} </h4>
                        <hr>
                        <span>    الطلبات : {{ $dt->sum_of_orders }} </span>
                        <span style="float: left">    الاسعار : {{ $dt->sum_of_prices }} </span>                    
                    </div>
                </div>
            </div>                   
            @endforeach     
        </div>




        <div class="row">
            <h3 class="mb-3"> احصائيات المقاعد والاسعار  </h3>        
        </div>
        <div class="row">
            <div class="col-sm-12" >
                <div class="card card-hover">
                    <div class="card-body"style="background:url({{asset('assets/')}}/images/background/active-bg.png) no-repeat top center;">
                        <div class="pt-3 text-center">
                            <table class="table table-striped table-responsive">
                                <thead class="thead-inverse">
                                    <tr>     
                                        <th> المرحلة   </th>           
                                        <th> الصف   </th>           
                                        <th> سعر الاشتراك  </th>
                                        <th> العدد الكلي للطلاب </th>
                                        <th> الاماكن المحجوزة </th>
                                        <th> الاماكن الشاغرة </th>
                                   
                                    </tr>
                                    </thead>
                                    <tbody>                            
                                        @foreach ($prices as $price)
                                        <tr>
                                            <td>{{ $price->type_name }}</td>                                            
                                            <td>{{ $price->stage_name }}</td>                                            
                                            <td>{{ $price->normalprice }} </td>
                                            <td>{{ $price->allowed_number }} مقعد</td>
                                            <td>{{ $price->booked }} مقعد</td>
                                            <td>{{ $price->free }} مقعد</td>                                            
                                                                                     
                                        </tr>                                  
                                        @endforeach                                                      
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>                             
        </div>




        <div class="row">
            <h3 class="mb-3"> احصائيات الارصدة وعمليات السحب  </h3>        
        </div>
        <div class="row">
            <div class="col-12" >
                <div class="card card-hover">
                    <div class="card-body"style="background:url({{asset('assets/')}}/images/background/active-bg.png) no-repeat top center;">
                        <div class="pt-3 text-center">
                            <table class="table table-striped table-responsive">
                                <thead class="thead-inverse">
                                    <tr>     
                                        <th> عدد المشتركين </th>                                          
                                        <th> نسبة العمولة </th>
                                        <th> اجمالي مستحقات المدارس (قابل للسحب)</th>
                                        <td> اجمالي مستحقات المنصة (العمولات)</td>
                                        <td> عمليات سحب سابقة</td>
                                        <td>اجمالي المسحوبات</td>
                                        <td> الرصيد الكلي</td>
                                    </tr>
                                    </thead>
                                    <tbody>                            
                                        <tr>
                                            <td>{{ $total_sucscription }}</td>                                            
                                            <td>  {{ $commission_rate }} %   </td>
                                             <td> @if ($financialLogs != null) {{ $financialLogs->total }} @endif ريال</td>
                                            <td> @if ($financialLogs != null) {{ $financialLogs->total_commission }} @endif ريال</td>
                                            <td>{{ $withdrawas->count() }} عملية سحب </td>
                                            <td>{{ $withdrawas->sum('total') }} ريال </td>
                                            <td> @if ($financialLogs != null) {{ $financialLogs->final_total }} @endif ريال</td>
                                        </tr>                                  
                                    </tbody>
                            </table>
                        </div>
                        <a href="{{url('admin/withdrawal')}}" class="btn btn-outline-primary brn-sm"> عرض عمليات السحب </a>
                    </div>
                </div>
            </div>                             
        </div>
            
            
            <div class="col-sm-6 col-xs-12" >
                <h3 class="mb-3"> احصائيات الدعم الفني   </h3>        
                <div class="card card-hover">
                    <div class="card-body"style="background:url({{asset('assets/')}}/images/background/active-bg.png) no-repeat top center;">
                        <div class="pt-3 text-center">
                            <table class="table table-striped table-responsive">
                                <thead class="thead-inverse">
                                    <tr>     
                                        <th> عدد الرسائل </th>   
                                        <th> رسائل جديدة </th>                                        
                                        <th> رسائل تم عرضها </th>                                                                                                                   
                                    </tr>
                                    </thead>
                                    <tbody>                            
                                       
                                        <tr>
                                            <td>{{ $messages->count() }}</td>                                            
                                            <td>{{ $messages->where('status','new')->count() }} </td>
                                            <td>{{ $messages->where('status','read')->count() }} </td>                                                                                  
                                        </tr>                                  
                                                                                       
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 

        </div>

    </div>
@endsection
