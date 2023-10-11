@extends('site.master.master')
@section('page_title')
    {{ __('lang.about_us')}}
@endsection
@section('content')
    <section class="section-box view-banner" style="background: url('{{ asset('images/1549552528714.jpeg') }}');"></section>
         <div class="alert alert-warning" style="text-align:center;">
                <h3 class="page-title mb-5">
                    {{ __('lang.'.$status)}}
                </h3>
            </div>

    </div>

@endsection
