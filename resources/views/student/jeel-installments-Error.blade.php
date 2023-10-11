@extends('site.master.master')
@section('page_title')
    {{ __('lang.about_us')}}
@endsection
@section('content')

    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}'); "></section>
         <div class="alert alert-danger" style="text-align:center;">
        @if($error=="must be in 5xxxxxxxx format")
                <h3 class="page-title mb-5" >
                    {{ __('lang.wrong_phone_number')}}
                </h3>       
        @elseif($error=="must be in 1xxxxxxxxx or 2xxxxxxxxx formats")
                <h3 class="page-title mb-5" >
                    {{ __('lang.wrong_id')}}
                </h3>
   
          @elseif($error=="noChiled")
                <h3 class="page-title mb-5" >
                    {{ __('lang.noChiled')}}
                </h3>

          @else
                <h3 class="page-title mb-5" >
              
                    {{ __('lang.jeelpriceIssue')}}
                  
                </h3>

        @endif


        
            </div>

    </div>

@endsection
