<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | Sign In</title>

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
<section class="body-sign">
    <div class="center-sign">
        <a href="{{ url('/') }}" class="logo float-left">
            <img src="{{ asset('images/logo.jpg') }}" height="54" alt="Aggone Admin" />
        </a>

        <div class="panel card-sign">
            <div class="card-title-sign mt-3 text-right">
                <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i> Recover Password</h2>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="m-0">Enter your e-mail below and we will send you reset instructions!</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group mb-0">
                        <div class="input-group">
                            <input name="email" type="email" placeholder="E-mail" class="form-control form-control-lg @error('email') is-invalid @enderror" />
                            <span class="input-group-append">
                                <button class="btn btn-primary btn-lg" type="submit">Reset!</button>
                            </span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <p class="text-center mt-3">Remembered? <a href="{{ route('login') }}">Sign In!</a></p>
                </form>
            </div>
        </div>

        <p class="text-center text-muted mt-3 mb-3">&copy; Copyright 2019. All Rights Reserved.</p>
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
@yield('template_scripts')
</body>
</html>
