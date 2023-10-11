@extends('site.master.master')
@section('page_title')
    {{ __('lang.about_us')}}
@endsection
@section('content')
<link rel="stylesheet" href="{{asset('dashboard/dist/')}}/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@if(LaravelLocalization::getCurrentLocale()  == 'en')
<style>
  /* Icon when the collapsible content is shown */

  .btn:after {
    
    content: "\e114";
    font-family: "Glyphicons Halflings";
    float: right;
    margin-left: 15px;
  }
  /* Icon when the collapsible content is hidden */
  .btn.collapsed:after {
 content: "\e080";
    content: "\e114";
    font-family: "Glyphicons Halflings";
  }
</style>
@else
<style>
  /* Icon when the collapsible content is shown */

  .btn:after {
    
    content: "\e114";
    font-family: "Glyphicons Halflings";
    float: left;
    margin-left: 15px;
  }
  /* Icon when the collapsible content is hidden */
  .btn.collapsed:after {
    content: "\e114";
    font-family: "Glyphicons Halflings";
  }
</style>
@endif




    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>

    <div class="content">

        
    <h1 style="text-align: center; font-size: xx-large">
                {{ __('lang.faq')}}
                </h1>
                
</html>
@if(LaravelLocalization::getCurrentLocale()  == 'en')

<button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo" style=" width: 100%;  text-align:left; ">{{ __('lang.first_question')}}</button>
  <div id="demo" class="collapse" style=" text-align:left;">
  {{ __('lang.first_answer')}}
  </div>
@else

<button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo" style=" width: 100%;  text-align:right; ">{{ __('lang.first_question')}}</button>
  <div id="demo" class="collapse">
  {{ __('lang.first_answer')}}
  </div>
@endif

@if(LaravelLocalization::getCurrentLocale()  == 'en')


<button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo1"
style=" width: 100%; text-align:left; ">{{ __('lang.second_question')}}</button>
  <div id="demo1" class="collapse" style=" text-align:left;">
  {{ __('lang.second_answer')}}
  </div>
@else


<button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo1"
style=" width: 100%; text-align:right ">{{ __('lang.second_question')}}</button>
  <div id="demo1" class="collapse">
  {{ __('lang.second_answer')}}
  </div>
@endif
@if(LaravelLocalization::getCurrentLocale()  == 'en')
  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo2"
style=" width: 100%; text-align:left ">{{ __('lang.third_question')}}</button>
  <div id="demo2" class="collapse"  style=" text-align:left;">
  {{ __('lang.third_answer')}}
  </div>
@else
  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo2"
style=" width: 100%; text-align:right ">{{ __('lang.third_question')}}</button>
  <div id="demo2" class="collapse" >
  {{ __('lang.third_answer')}}
  </div>
@endif

@if(LaravelLocalization::getCurrentLocale()  == 'en')
  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo3"
style=" width: 100%; text-align:left ">{{ __('lang.fourth_question')}}</button>
  <div id="demo3" class="collapse" style=" text-align:left;">
  {{ __('lang.fourth_answer')}}
  </div>
@else
   <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo3"
style=" width: 100%; text-align:right ">{{ __('lang.fourth_question')}}</button>
  <div id="demo3" class="collapse">
  {{ __('lang.fourth_answer')}}
  </div>
@endif



@if(LaravelLocalization::getCurrentLocale()  == 'en')
 <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo4"
style=" width: 100%; text-align:left ">{{ __('lang.fifth_question')}}</button>
  <div id="demo4" class="collapse" style=" text-align:left;">
  {{ __('lang.fifth_answer')}}
  </div>
@else
   <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo4"
style=" width: 100%; text-align:right ">{{ __('lang.fifth_question')}}</button>
  <div id="demo4" class="collapse" >
  {{ __('lang.fifth_answer')}}
  </div>
@endif

 

@if(LaravelLocalization::getCurrentLocale()  == 'en')

  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo5"
style=" width: 100%; text-align:left ">{{ __('lang.sixth_question')}}</button>
  <div id="demo5" class="collapse" style=" text-align:left;">
  {{ __('lang.sixth_answer')}}
  </div>
@else

  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo5"
style=" width: 100%; text-align:right ">{{ __('lang.sixth_question')}}</button>
  <div id="demo5" class="collapse">
  {{ __('lang.sixth_answer')}}
  </div>
@endif

@if(LaravelLocalization::getCurrentLocale()  == 'en')

   <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo6"
style=" width: 100%; text-align:left ">{{ __('lang.seventh_question')}}</button>
  <div id="demo6" class="collapse" style=" text-align:left;">
  {{ __('lang.seventh_answer')}}
  </div>
@else
  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo6"
style=" width: 100%; text-align:right ">{{ __('lang.seventh_question')}}</button>
  <div id="demo6" class="collapse" >
  {{ __('lang.seventh_answer')}}
  </div>
@endif




@if(LaravelLocalization::getCurrentLocale()  == 'en')
  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo7"
style=" width: 100%; text-align:left; ">{{ __('lang.eighth_question')}}</button>
  <div id="demo7" class="collapse" style=" text-align:left;">
  {{ __('lang.eighth_answer')}}
  </div>
@else
  <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo7"
style=" width: 100%; text-align:right ">{{ __('lang.eighth_question')}}</button>
  <div id="demo7" class="collapse">
  {{ __('lang.eighth_answer')}}
  </div>
@endif




@if(LaravelLocalization::getCurrentLocale()  == 'en')
 <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo8"
style=" width: 100%; text-align:left ">{{ __('lang.ninth_question')}}</button>
  <div id="demo8" class="collapse" style=" text-align:left;">
  {{ __('lang.ninth_answer')}}
  </div>
@else
 <button type="button" class="btn btn-lg btn-default collapsed" data-toggle="collapse" data-target="#demo8"
style=" width: 100%; text-align:right; ">{{ __('lang.ninth_question')}}</button>
  <div id="demo8" class="collapse">
  {{ __('lang.ninth_answer')}}
  </div>
@endif





 

  
















</div>




        

    </div>
    







   <h1></h1>

@endsection