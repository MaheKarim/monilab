<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ gs()->sitename($page_title ?? '') }}</title>

    @include('partials.seo')

    <link
        href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
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
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/color.php') }}?color={{ gs('base_color') }}">

    @stack('style-lib')

    @stack('style')
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
<div class="fixed-area fixed-area-two d-flex flex-wrap justify-content-center">
    @yield('content')
</div>
@include($activeTemplate.'partials.footer')


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->

<!-- jquery -->
<script src="{{asset($activeTemplateTrue.'js/jquery-3.7.1.min.js')}}"></script>
<!-- migarate-jquery -->
<script src="{{asset($activeTemplateTrue.'js/jquery-migrate-3.4.1.js')}}"></script>
<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/bootstrap.bundle.min.js')}}"></script>
<!-- magnific-popup js -->
<script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.js')}}"></script>
<!-- isotope -->
<script src="{{asset($activeTemplateTrue.'js/isotope.pkgd.min.js')}}"></script>
<!-- nice-select js-->
<script src="{{asset($activeTemplateTrue.'js/jquery.nice-select.js')}}"></script>
<!-- swipper js -->
<script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
<!-- viewport js -->
<script src="{{asset($activeTemplateTrue.'js/viewport.jquery.js')}}"></script>
<!-- odometer js -->
<script src="{{asset($activeTemplateTrue.'js/odometer.min.js')}}"></script>
<!-- syotimer js -->
<script src="{{asset($activeTemplateTrue.'js/jquery.syotimer.js')}}"></script>
<script src="{{asset($activeTemplateTrue.'js/popper.min.js')}}"></script>

<script src="{{asset($activeTemplateTrue.'js/syotimer.lang.js')}}"></script>
<!-- wow js file -->
<script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>
<!-- main -->
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>
<!-- file-input-js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap-fileinput.js')}}"></script>

@stack('script-lib')



{{--@include(activeTemplate().'partials.notify')--}}

{{--@include('partials.plugins')--}}


@stack('script')


<script>
    (function ($) {
        "use strict";
        $(".langSel").on("change", function () {
            window.location.href = "{{ route('home') }}/change/" + $(this).val();
        });


        function formatState(state) {
            if (!state.id) return state.text;
            let gatewayData = $(state.element).data();
            return $(`<div class="d-flex gap-2">${gatewayData.imageSrc ? `<div class="select2-image-wrapper"><img class="select2-image" src="${gatewayData.imageSrc}"></div>` : ''}<div class="select2-content"> <p class="select2-title">${gatewayData.title}</p><p class="select2-subtitle">${gatewayData.subtitle}</p></div></div>`);
        }

        $('.select2').each(function (index, element) {
            $(element).select2({
                templateResult: formatState,
                minimumResultsForSearch: "-1"
            });
        });

        $('.select2-searchable').each(function (index, element) {
            $(element).select2({
                templateResult: formatState,
                minimumResultsForSearch: "1"
            });
        });


        $('.select2-basic').each(function (index, element) {
            $(element).select2({
                dropdownParent: $(element).closest('.select2-parent')
            });
        });

    })(jQuery);

</script>


<script>
    (function ($) {
        "use strict";

        var inputElements = $('[type=text],[type=password],select,textarea');
        $.each(inputElements, function (index, element) {
            element = $(element);
            element.closest('.form-group').find('label').attr('for', element.attr('name'));
            element.attr('id', element.attr('name'))
        });

        $.each($('input:not([type=checkbox]):not([type=hidden]), select, textarea'), function (i, element) {

            if (element.hasAttribute('required')) {
                $(element).closest('.form-group').find('label').addClass('required');
            }

        });


        $('.showFilterBtn').on('click', function () {
            $('.responsive-filter-card').slideToggle();
        });


        Array.from(document.querySelectorAll('table')).forEach(table => {
            let heading = table.querySelectorAll('thead tr th');
            Array.from(table.querySelectorAll('tbody tr')).forEach((row) => {
                Array.from(row.querySelectorAll('td')).forEach((colum, i) => {
                    colum.setAttribute('data-label', heading[i].innerText)
                });
            });
        });


        let disableSubmission = false;
        $('.disableSubmission').on('submit', function (e) {
            if (disableSubmission) {
                e.preventDefault()
            } else {
                disableSubmission = true;
            }
        });

    })(jQuery);

</script>

</body>
</html>
