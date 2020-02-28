<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('template_title')</title>

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
    @yield('custom_stylesheet')
</head>
<body>
    <section id="app" class="body">
        <header class="header">
            <div class="logo-container">
                <a href="{{ url('') }}" class="logo">
                    <img src="{{ asset('images/logo.jpg') }}" width="35" height="35" alt="Aggone Admin" />
                </a>
                <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
                    <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </div>

            <!-- start: search & user box -->
            <div class="header-right">

                <form action="" class="search nav-form">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                        <span class="input-group-append">
                            <button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
                        </span>
                    </div>
                </form>

                <span class="separator"></span>

                <div id="userbox" class="userbox">
                    <a href="#" data-toggle="dropdown">
                        <figure class="profile-picture">
                            <img src="@if ($user->photo_url) {{ $user->photo_url }} @else {{ Gravatar::get($user->email) }} @endif" alt="Joseph Doe" class="rounded-circle" data-lock-picture="img/%21logged-user.jpg" />
                        </figure>
                        <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                            <span class="name">{{ $user->name }}</span>
                            <span class="role">
                                @foreach($user->roles as $user_role)
                                    {{ $user_role->name }}
                                @endforeach
                            </span>
                        </div>

                        <i class="fa custom-caret"></i>
                    </a>

                    <div class="dropdown-menu">
                        <ul class="list-unstyled mb-2">
                            <li class="divider"></li>
{{--                            <li>--}}
{{--                                <a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fas fa-user"></i> My Profile</a>--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fas fa-lock"></i> Lock Screen</a>--}}
{{--                            </li>--}}
                            <li>
                                <a role="menuitem" tabindex="-1" href="javascript:;"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-power-off"></i> Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end: search & user box -->
        </header>
        <div class="inner-wrapper">
            <aside id="sidebar-left" class="sidebar-left">

                <div class="sidebar-header">
                    <div class="sidebar-title">
                        Aggone Admin
                    </div>
                    <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                        <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>

                <div class="nano">
                    <div class="nano-content">
                        <nav id="menu" class="nav-main" role="navigation">

                            <ul class="nav nav-main">
                                <li @if(Request::routeIs('dashboard')) class="nav-active" @endif>
                                    <a class="nav-link" href="{{ route('dashboard') }}">
                                        <i class="fas fa-home" aria-hidden="true"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>

{{--                                <li @if(Request::routeIs('users.*')) class="nav-active" @endif>--}}
{{--                                    <a class="nav-link" href="{{ route('users.index') }}">--}}
{{--                                        <i class="fas fa-users" aria-hidden="true"></i>--}}
{{--                                        <span>User Management</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li @if(Request::routeIs('groups.*')) class="nav-active" @endif>--}}
{{--                                    <a class="nav-link" href="{{ route('groups.index') }}">--}}
{{--                                        <i class="fas fa-user-friends" aria-hidden="true"></i>--}}
{{--                                        <span>User Group</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <hr class="separator" />--}}

                                <li @if(Request::routeIs('users.*')) class="nav-main" @endif>
                                    <a href="#">
{{--                                        <i class="fa fa-users"></i>--}}
                                        <span>User Management</span>
{{--                                        <i class="fa fa-angle-left pull-right"></i>--}}
                                    </a>

{{--                                    <ul @if(Request::routeIs('users.*')) class="nav-children" @endif>--}}
                                    <ul class="nav nav-main">
                                        <li @if(Request::routeIs('players.*')) class="nav-active" @endif>
                                            <a href="{{ route('players.index') }}">
                                                <i class="fas fa-user-friends" aria-hidden="true"></i>
                                                <span>Players</span>
                                            </a>
                                        </li>

                                        <li @if(Request::routeIs('coaches.*')) class="nav-active" @endif>
                                            <a href="{{ route('coaches.index') }}">
                                                <i class="fas fa-user-friends" aria-hidden="true"></i>
                                                <span>Coaches</span>
                                            </a>
                                        </li>
{{--                                        <li @if(Request::routeIs('users.*')) class="nav-active" @endif>--}}
{{--                                            <a href="{{ route('users.index') }}">--}}
{{--                                                <i class="fas fa-user-friends" aria-hidden="true"></i>--}}
{{--                                                <span>Agents</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <script>
                        // Maintain Scroll Position
                        if (typeof localStorage !== 'undefined') {
                            if (localStorage.getItem('sidebar-left-position') !== null) {
                                var initialPosition = localStorage.getItem('sidebar-left-position'),
                                    sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                                sidebarLeft.scrollTop = initialPosition;
                            }
                        }
                    </script>


                </div>

            </aside>
            <section role="main" class="content-body pb-0">
                <header class="page-header">
{{--                    <h2>Layouts</h2>--}}

                    <div class="right-wrapper text-right">
{{--                        <ol class="breadcrumbs">--}}
{{--                            <li>--}}
{{--                                <a href="{{ route('dashboard') }}">--}}
{{--                                    <i class="fas fa-home"></i>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li><span>Layouts</span></li>--}}
{{--                        </ol>--}}

                        <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
                    </div>
                </header>
                @yield('content')
            </section>
        </div>
        <aside id="sidebar-right" class="sidebar-right">
            <div class="nano">
                <div class="nano-content">
                    <a href="#" class="mobile-close d-md-none">
                        Collapse <i class="fas fa-chevron-right"></i>
                    </a>

                    <div class="sidebar-right-wrapper">

                        <div class="sidebar-widget widget-calendar">
{{--                            <h6>Upcoming Tasks</h6>--}}
                            <div data-plugin-datepicker data-plugin-skin="dark"></div>

                        </div>


                    </div>
                </div>
            </div>
        </aside>
    </section>
    @yield('custom_modal')
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
