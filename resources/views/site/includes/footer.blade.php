<div class="clearfix"></div>
<footer>
    <div class="container">
        <div class="top">
            <div class="text-center">
                <p>{{ __('lang.Download_app')}}</p>
                <div class="d-flex justify-content-center">
                     <a href="https://play.google.com/store/apps/details?id=com.theedukey.theedukeysc"><img src="{{asset('/site/images/google-play.png')}}" /></a> 
                    <a href="https://apps.apple.com/sa/app/the-edukey/id6445922337"><img src="{{asset('/site/images/app-store.png')}}" /></a>
                </div>
            </div>
            <div class="row align-items-center justify-content-between">
                <div class="col-md-6">
                    <figure><img src="{{ asset('images/Logo_Footer.png')  }}" class="logo" /></figure>
                </div>
                <div class="col-md-6">
                    <ul>

                    
                    <li><a href="{{ url('/faq/') }}"> {{ __('lang.faq')}}</a></li>
                        <li><a href="{{ url('/facilities/1') }}"> {{ __('lang.edu_facilities')}}</a></li>
                        <li><a href="{{ url('/terms') }}">{{ __('lang.Terms_Conditions')}}</a></li>
                        <li>
                            <a href="{{ url('/tamara') }}">
                                <img width="70px" src="{{ asset('/images/tamara.png') }}">
                            </a>
                        </li>
                        <li>
                             <a href="{{ url('/tabby') }}">
                                <img width="70px" src="{{ asset('/images/tabby.png') }}">
                            </a>
                        </li>
                        <li>
                             <a href="{{ url('/jeel') }}">
                                <img width="70px" height="30px" src="{{ asset('/images/jeel-pay.jpeg') }}">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row align-items-center ">
                <div class="col-md-4">
                    <p class="m-0">{{ __('lang.rights')}} </p>
                </div>
                <div class="col-md-4">
                    <ul class="footer-socail fo">
                        <li><a target="_blank" href="{{ contact()->youtube }}"><i class="fab fa-youtube"></i></a></li>
                        <li><a target="_blank" href="{{ contact()->twitter }}"><i class="fab fa-twitter"></i></a></li>
                        <li><a target="_blank" href="{{ contact()->insta }}"><i class="fab fa-instagram"></i></a></li>
                        <li><a target="_blank" href="{{ contact()->facebook }}"><i class="fab fa-facebook"></i></a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="float-end">
                        <a target="_blank" href="https://www.topline.com.sa" title="تطوير توب لاين"><img
                                src="https://www.topline.com.sa/logo/topline-logo-dark.png"
                                alt="استضافة - تصميم مواقع - برمجة تطبيقات | توب لاين"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
