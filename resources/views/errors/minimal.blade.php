<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.theme.default.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}" />
</head>
<body>
<section class="body-error error-outside">
    <div class="center-error">

        <div class="row">
            <div class="col-md-8">
                <div class="main-error mb-3">
                    <h2 class="error-code text-dark text-center font-weight-semibold m-0">@yield('code') <i class="fas fa-file"></i></h2>
                    <p class="error-explanation text-center">@yield('message')</p>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="text">Here are some useful links</h4>
                <ul class="nav nav-list flex-column primary">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-caret-right text-dark"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-caret-right text-dark"></i> FAQ's</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>
<script src="{{ asset('vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('vendor/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('vendor/common/common.js') }}"></script>
<script src="{{ asset('vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<!-- Specific Page Vendor -->
<script src="{{ asset('vendor/jquery-appear/jquery.appear.js') }}"></script>
<script src="{{ asset('vendor/owl.carousel/owl.carousel.js') }}"></script>
<script src="{{ asset('vendor/isotope/isotope.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/admin/theme.js') }}"></script>
<script src="{{ asset('js/admin/theme.init.js') }}"></script>
</body>
</html>
