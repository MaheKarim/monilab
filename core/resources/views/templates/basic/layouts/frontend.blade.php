<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->sitename($page_title ?? '') }}</title>

    @include('partials.seo')

    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/fontawesome-all.min.css')}}">
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/line-awesome.min.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <!-- nice-select css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/nice-select.css')}}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <!-- odometer css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/odometer.css')}}">
    <!-- icon css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/themify.css')}}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <!--headline.css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/jquery.animatedheadline.css')}}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    <!-- custom style css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">
    <!-- file input css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap-fileinput.css')}}">
    <!-- site color -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/color.php') }}?color={{ gs('base_color') }}">

    @stack('style-lib')

    @stack('style')


    <style>

    </style>

</head>

<body>

<div class="preloader">
    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>


@include($activeTemplate.'partials.header')

<div class="fixed-area d-flex flex-wrap">
    @include($activeTemplate.'partials.left-sidenav')
    @yield('content')
    @include($activeTemplate.'partials.right-sidenav')
</div>

@include($activeTemplate.'partials.footer')


@php
    $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
@endphp
@if(($cookie->data_values->status == Status::ENABLE) && !\Cookie::get('gdpr_cookie'))
    <!-- cookies dark version start -->
    <div class="cookies-card text-center hide">
        <div class="cookies-card__icon bg--base">
            <i class="las la-cookie-bite"></i>
        </div>
        <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}" target="_blank">@lang('learn more')</a></p>
        <div class="cookies-card__btn mt-4">
            <a href="javascript:void(0)" class="btn btn--base w-100 policy">@lang('Allow')</a>
        </div>
    </div>
    <!-- cookies dark version end -->
@endif

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<!-- jquery -->
<script src="{{asset($activeTemplateTrue.'js/jquery-3.7.1.min.js')}}"></script>
<!-- migarate-jquery -->
<script src="{{asset($activeTemplateTrue.'js/jquery-migrate-3.4.1.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
<!-- magnific-popup js -->
<script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.js')}}"></script>
<!-- isotope -->
<script src="{{asset($activeTemplateTrue.'js/isotope.pkgd.min.js')}}"></script>
<!-- nice-select js-->
<script src="{{asset($activeTemplateTrue.'js/jquery.nice-select.js')}}"></script>
<!-- swipper js -->
<script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
<!--chart js-->
<script src="{{asset($activeTemplateTrue.'js/chart.js')}}"></script>
<!-- viewport js -->
<script src="{{asset($activeTemplateTrue.'js/viewport.jquery.js')}}"></script>
<!-- odometer js -->
<script src="{{asset($activeTemplateTrue.'js/odometer.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/proper.min.js')}}"></script>
<!-- syotimer js -->
<script src="{{asset($activeTemplateTrue.'js/jquery.syotimer.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/syotimer.lang.js')}}"></script>
<!-- wow js file -->
<script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
<!-- main -->
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>
<!-- file-input-js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap-fileinput.js')}}"></script>

@stack('script-lib')

@stack('script')

{{--@include('partials.plugins')--}}

{{--@include(activeTemplate().'partials.notify')--}}


<script>
    (function ($) {
        "use strict";
        $(document).on("change", ".langSel", function() {
            window.location.href = "{{url('/')}}/change/"+$(this).val() ;
        });

        $('.policy').on('click',function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.get('{{route('cookie.accept')}}', function(response){
                iziToast.success({message: response, position: "topRight"});
                $('.cookie__wrapper').addClass('d-none');
            });
        });

        setTimeout(function(){
            $('.cookies-card').removeClass('hide')
        },2000);

        var inputElements = $('[type=text],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for',element.attr('name'));
            element.attr('id',element.attr('name'))
        });

        $.each($('input, select, textarea'), function (i, element) {
            var elementType = $(element);
            if(elementType.attr('type') != 'checkbox'){
                if (element.hasAttribute('required')) {
                    $(element).closest('.form-group').find('label').addClass('required');
                }
            }

        });


        let disableSubmission = false;
        $('.disableSubmission').on('submit',function(e){
            if (disableSubmission) {
            e.preventDefault()
            }else{
            disableSubmission = true;
            }
        });

    })(jQuery);
</script>

</body>
</html>
