<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Aggone</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light%7CPlayfair+Display:400" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.theme.default.css') }}" />

    <!-- Current Page CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/rs-plugin/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/rs-plugin/css/layers.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/rs-plugin/css/navigation.css') }}">

    <script src="{{ asset('vendor/modernizr/modernizr.min.js') }}"></script>

</head>
<body class="loading-overlay-showing" data-plugin-page-transition data-loading-overlay data-plugin-options="{'hideDelay': 500}">
<div class="loading-overlay">
    <div class="bounce-loader">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
</body>
<body class="one-page" data-target="#header" data-spy="scroll" data-offset="100">

<div class="body">

    <header id="header" class="header-transparent header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyChangeLogo': true, 'stickyStartAt': 30, 'stickyHeaderContainerHeight': 70}">
        <div class="header-body border-top-0 bg-dark box-shadow-none">
            <div class="header-container container">
                <div class="header-row">
                    <div class="header-column">
                        <div class="header-row">
                            <div class="header-logo">
                                <a href="{{ url('/') }}">
                                    AGGONE
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="header-column justify-content-end">
                        <div class="header-row">
                            <div class="header-nav header-nav-links header-nav-dropdowns-dark header-nav-light-text order-2 order-lg-1">
                                <div class="header-nav-main header-nav-main-mobile-dark header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-effect-2 header-nav-main-sub-effect-1">
                                    <nav class="collapse">
                                        <ul class="nav nav-pills" id="mainNav">
                                            <li>
                                                <a data-hash class="dropdown-item active" href="#home">
                                                    Home
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-hash data-hash-offset="68" href="#services">Services</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-hash data-hash-offset="68" href="#projects">Projects</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-hash data-hash-offset="68" href="#clients">Clients</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-hash data-hash-offset="68" href="#team">Meet the Team</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" data-hash data-hash-offset="68" href="#contact">Contact Us</a>
                                            </li>
                                            @guest
                                            <li>
                                                <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                                            </li>
                                            @endguest
                                        </ul>
                                    </nav>
                                </div>
                                <button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div role="main" class="main" id="home">
        <div class="slider-container rev_slider_wrapper" style="height: 100vh;">
            <div id="revolutionSlider" class="slider rev_slider" data-version="5.4.8" data-plugin-revolution-slider data-plugin-options="{'sliderLayout': 'fullscreen', 'delay': 9000, 'gridwidth': 1140, 'gridheight': 800, 'responsiveLevels': [4096,1200,992,500]}">
                <ul>
                    <li class="slide-overlay" data-transition="fade">
                        <img src="{{ asset('images/slides/slide-one-page-1-1.jpg') }}"
                             alt=""
                             data-bgposition="center center"
                             data-bgfit="cover"
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                        <div class="tp-caption tp-resizeme"
                             data-frames='[{"delay":1500,"speed":2000,"frame":"0","from":"opacity:0;x:-100%;y:-100%;","to":"o:1;x:0;y:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-type="image"
                             data-x="left" data-hoffset="['0','-150','-200','-200']"
                             data-y="top" data-voffset="['-100','-150','-200','-200']"
                             data-width="['auto']"
                             data-height="['auto']"
                             data-basealign="slide"><img src="{{ asset('images/slides/slide-one-page-1-2.jpg') }}" alt=""></div>

                        <div class="tp-caption tp-resizeme"
                             data-frames='[{"delay":1500,"speed":2000,"frame":"0","from":"opacity:0;x:100%;y:-100%;","to":"o:1;x:0;y:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-type="image"
                             data-x="right" data-hoffset="['0','-150','-200','-200']"
                             data-y="top" data-voffset="['-100','-150','-200','-200']"
                             data-width="['auto']"
                             data-height="['auto']"
                             data-basealign="slide"><img src="{{ asset('images/slides/slide-one-page-1-3.jpg') }}" alt=""></div>

                        <div class="tp-caption tp-resizeme"
                             data-frames='[{"delay":1500,"speed":2000,"frame":"0","from":"opacity:0;x:-100%;y:100%;","to":"o:1;x:0;y:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-type="image"
                             data-x="left" data-hoffset="['0','-150','-200','-200']"
                             data-y="bottom" data-voffset="['-100','-150','-200','-200']"
                             data-width="['auto']"
                             data-height="['auto']"
                             data-basealign="slide"><img src="{{ asset('images/slides/slide-one-page-1-4.jpg') }}" alt=""></div>

                        <div class="tp-caption tp-resizeme"
                             data-frames='[{"delay":1500,"speed":2000,"frame":"0","from":"opacity:0;x:100%;y:100%;","to":"o:1;x:0;y:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-type="image"
                             data-x="right" data-hoffset="['0','-150','-200','-200']"
                             data-y="bottom" data-voffset="['-100','-150','-200','-200']"
                             data-width="['auto']"
                             data-height="['auto']"
                             data-basealign="slide"><img src="{{ asset('images/slides/slide-one-page-1-5.jpg') }}" alt=""></div>

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['-170','-170','-170','-365']"
                             data-y="center" data-voffset="['-80','-80','-80','-105']"
                             data-start="1000"
                             data-transform_in="x:[-300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;"><img src="{{ asset('images/slides/slide-title-border.png') }}" alt=""></div>

                        <div class="tp-caption text-color-light font-weight-normal"
                             data-x="center"
                             data-y="center" data-voffset="['-80','-80','-80','-105']"
                             data-start="700"
                             data-fontsize="['16','16','16','40']"
                             data-lineheight="['25','25','25','45']"
                             data-transform_in="y:[-50%];opacity:0;s:500;">WE WORK HARD AND AGGONE HAS</div>

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['170','170','170','365']"
                             data-y="center" data-voffset="['-80','-80','-80','-105']"
                             data-start="1000"
                             data-transform_in="x:[300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;"><img src="{{ asset('images/slides/slide-title-border.png') }}" alt=""></div>

                        <h1 class="tp-caption font-weight-extra-bold text-color-light negative-ls-1"
                            data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:1.5;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                            data-x="center"
                            data-y="center" data-voffset="['-30','-30','-30','-30']"
                            data-fontsize="['50','50','50','90']"
                            data-lineheight="['55','55','55','95']">THE BEST DESIGN</h1>

                        <div class="tp-caption"
                             data-frames='[{"delay":2000,"speed":500,"frame":"0","from":"opacity:0;x:10%;","to":"opacity:1;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center" data-hoffset="['-40','-40','-40','-40']"
                             data-y="center" data-voffset="['2','2','2','15']"><img src="{{ asset('images/slides/slide-blue-line-big.png') }}" alt=""></div>

                        <div class="tp-caption font-weight-light ws-normal text-center"
                             data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"split":"chars","splitdelay":0.03,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                             data-x="center"
                             data-y="center" data-voffset="['53','53','53','105']"
                             data-width="['530','530','530','1100']"
                             data-fontsize="['18','18','18','40']"
                             data-lineheight="['26','26','26','45']"
                             style="color: #b5b5b5;">Trusted by over <strong class="text-color-light">30,000</strong> satisfied users, Aggone is a huge success in the one of largest world's MarketPlace.</div>

                        <a class="tp-caption btn btn-primary btn-rounded font-weight-semibold"
                           data-frames='[{"delay":2500,"speed":2000,"frame":"0","from":"opacity:0;y:50%;","to":"o:1;y:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                           data-hash
                           data-hash-offset="85"
                           href="#projects"
                           data-x="center" data-hoffset="0"
                           data-y="center" data-voffset="['133','133','133','255']"
                           data-whitespace="nowrap"
                           data-fontsize="['14','14','14','33']"
                           data-paddingtop="['15','15','15','40']"
                           data-paddingright="['45','45','45','110']"
                           data-paddingbottom="['15','15','15','40']"
                           data-paddingleft="['45','45','45','110']">GET STARTED NOW!</a>

                    </li>
                    <li class="slide-overlay" data-transition="fade">
                        <img src="{{ asset('images/slides/slide-bg-2.jpg') }}"
                             alt=""
                             data-bgposition="center center"
                             data-bgfit="cover"
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['-170','-170','-170','-350']"
                             data-y="center" data-voffset="['-50','-50','-50','-75']"
                             data-start="1000"
                             data-transform_in="x:[-300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;"><img src="{{ asset('images/slides/slide-title-border.png') }}" alt=""></div>

                        <div class="tp-caption text-color-light font-weight-normal"
                             data-x="center"
                             data-y="center" data-voffset="['-50','-50','-50','-75']"
                             data-start="700"
                             data-fontsize="['16','16','16','40']"
                             data-lineheight="['25','25','25','45']"
                             data-transform_in="y:[-50%];opacity:0;s:500;">WE WORK HARD AND PORTO HAS</div>

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['170','170','170','350']"
                             data-y="center" data-voffset="['-50','-50','-50','-75']"
                             data-start="1000"
                             data-transform_in="x:[300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;"><img src="{{ asset('images/slides/slide-title-border.png') }}" alt=""></div>

                        <div class="tp-caption font-weight-extra-bold text-color-light negative-ls-1"
                             data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:1.5;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center"
                             data-y="center"
                             data-fontsize="['50','50','50','90']"
                             data-lineheight="['55','55','55','95']">THE BEST DESIGN</div>

                        <div class="tp-caption font-weight-light ws-normal text-center"
                             data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"split":"chars","splitdelay":0.05,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                             data-x="center"
                             data-y="center" data-voffset="['60','60','60','105']"
                             data-width="['530','530','530','1100']"
                             data-fontsize="['18','18','18','40']"
                             data-lineheight="['26','26','26','45']"
                             style="color: #b5b5b5;">Trusted by over <strong class="text-color-light">30,000</strong> satisfied users, Aggone is a huge success in the one of largest world's MarketPlace.</div>

                    </li>
                    <li class="slide-overlay slide-overlay-dark" data-transition="fade">
                        <img src="{{ asset('images/slides/slide-bg-6.jpg') }}"
                             alt=""
                             data-bgposition="center center"
                             data-bgfit="cover"
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['-145','-145','-145','-320']"
                             data-y="center" data-voffset="['-80','-80','-80','-130']"
                             data-start="1000"
                             data-transform_in="x:[-300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;"><img src="{{ asset('images/slides/slide-bg-6.jpg') }}" alt=""></div>

                        <div class="tp-caption text-color-light font-weight-normal"
                             data-x="center"
                             data-y="center" data-voffset="['-80','-80','-80','-130']"
                             data-start="700"
                             data-fontsize="['16','16','16','40']"
                             data-lineheight="['25','25','25','45']"
                             data-transform_in="y:[-50%];opacity:0;s:500;">WE CREATE DESIGNS, WE ARE</div>

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['145','145','145','320']"
                             data-y="center" data-voffset="['-80','-80','-80','-130']"
                             data-start="1000"
                             data-transform_in="x:[300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;"><img src="{{ asset('images/slides/slide-title-border.png') }}" alt=""></div>

                        <div class="tp-caption font-weight-extra-bold text-color-light"
                             data-frames='[{"delay":1300,"speed":1000,"frame":"0","from":"opacity:0;x:-50%;","to":"opacity:0.7;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center" data-hoffset="['-155','-155','-155','-255']"
                             data-y="center"
                             data-fontsize="['145','145','145','250']"
                             data-lineheight="['150','150','150','260']">A</div>

                        <div class="tp-caption font-weight-extra-bold text-color-light"
                             data-frames='[{"delay":1500,"speed":1000,"frame":"0","from":"opacity:0;x:-50%;","to":"opacity:0.7;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center" data-hoffset="['-80','-80','-80','-130']"
                             data-y="center"
                             data-fontsize="['145','145','145','250']"
                             data-lineheight="['150','150','150','260']">G</div>

                        <div class="tp-caption font-weight-extra-bold text-color-light"
                             data-frames='[{"delay":1700,"speed":1000,"frame":"0","from":"opacity:0;x:-50%;","to":"opacity:0.7;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center"
                             data-y="center"
                             data-fontsize="['145','145','145','250']"
                             data-lineheight="['150','150','150','260']">O</div>

                        <div class="tp-caption font-weight-extra-bold text-color-light"
                             data-frames='[{"delay":1900,"speed":1000,"frame":"0","from":"opacity:0;x:-50%;","to":"opacity:0.7;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center" data-hoffset="['65','65','65','115']"
                             data-y="center"
                             data-fontsize="['145','145','145','250']"
                             data-lineheight="['150','150','150','260']">N</div>

                        <div class="tp-caption font-weight-extra-bold text-color-light"
                             data-frames='[{"delay":2100,"speed":1000,"frame":"0","from":"opacity:0;x:-50%;","to":"opacity:0.7;x:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center" data-hoffset="['139','139','139','240']"
                             data-y="center"
                             data-fontsize="['145','145','145','250']"
                             data-lineheight="['150','150','150','260']">E</div>

                        <div class="tp-caption font-weight-light text-color-light"
                             data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2300,"split":"chars","splitdelay":0.05,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                             data-x="center"
                             data-y="center" data-voffset="['85','85','85','140']"
                             data-fontsize="['18','18','18','40']"
                             data-lineheight="['26','26','26','45']">The best choice for your new website</div>

                    </li>
                    <li class="slide-overlay" data-transition="fade">
                        <img src="{{ asset('images/blank.gif') }}"
                             alt=""
                             data-bgposition="center center"
                             data-bgfit="cover"
                             data-bgrepeat="no-repeat"
                             class="rev-slidebg">

                        <div class="rs-background-video-layer"
                             data-forcerewind="on"
                             data-volume="mute"
                             data-videowidth="100%"
                             data-videoheight="100%"
                             data-videomp4="{{ asset('video/memory-of-a-woman.mp4') }}"
                             data-videopreload="preload"
                             data-videoloop="loop"
                             data-forceCover="1"
                             data-aspectratio="16:9"
                             data-autoplay="true"
                             data-autoplayonlyfirsttime="false"
                             data-nextslideatend="false">
                        </div>

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['-170','-170','-170','-350']"
                             data-y="center" data-voffset="['-50','-50','-50','-75']"
                             data-start="1000"
                             data-transform_in="x:[-300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;" style="z-index: 5;"><img src="{{ asset('images/slides/slide-title-border.png') }}" alt=""></div>

                        <div class="tp-caption text-color-light font-weight-normal"
                             data-x="center"
                             data-y="center" data-voffset="['-50','-50','-50','-75']"
                             data-start="700"
                             data-fontsize="['16','16','16','40']"
                             data-lineheight="['25','25','25','45']"
                             data-transform_in="y:[-50%];opacity:0;s:500;" style="z-index: 5;">WE WORK HARD AND PORTO HAS</div>

                        <div class="tp-caption"
                             data-x="center" data-hoffset="['170','170','170','350']"
                             data-y="center" data-voffset="['-50','-50','-50','-75']"
                             data-start="1000"
                             data-transform_in="x:[300%];opacity:0;s:500;"
                             data-transform_idle="opacity:0.2;s:500;" style="z-index: 5;"><img src="{{ asset('images/slides/slide-title-border.png') }}" alt=""></div>

                        <div class="tp-caption font-weight-extra-bold text-color-light negative-ls-1"
                             data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"sX:1.5;opacity:0;fb:20px;","to":"o:1;fb:0;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
                             data-x="center"
                             data-y="center"
                             data-fontsize="['50','50','50','90']"
                             data-lineheight="['55','55','55','95']" style="z-index: 5;">PERFECT VIDEOS</div>

                        <div class="tp-caption font-weight-light ws-normal text-center"
                             data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"split":"chars","splitdelay":0.05,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                             data-x="center"
                             data-y="center" data-voffset="['60','60','60','105']"
                             data-width="['530','530','530','1100']"
                             data-fontsize="['18','18','18','40']"
                             data-lineheight="['26','26','26','45']"
                             style="color: #b5b5b5; z-index: 5;">Trusted by over <strong class="text-color-light">30,000</strong> satisfied users, Aggone is a huge success in the one of largest world's MarketPlace.</div>

                        <div class="tp-dottedoverlay tp-opacity-overlay"></div>
                    </li>
                </ul>
            </div>
        </div>
        <section id="services" class="section section-height-3 bg-primary border-0 m-0 appear-animation" data-appear-animation="fadeIn">
            <div class="container my-3">
                <div class="row mb-5">
                    <div class="col text-center appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                        <h2 class="font-weight-bold text-color-light mb-2">Services</h2>
                        <p class="text-color-light opacity-7">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT</p>
                    </div>
                </div>
                <div class="row mb-lg-4">
                    <div class="col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300">
                        <div class="feature-box feature-box-style-2">
                            <div class="feature-box-icon">
                                <i class="icons icon-support text-color-light"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="font-weight-bold text-color-light text-4 mb-2">CUSTOMER SUPPORT</h4>
                                <p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing <span class="alternative-font text-color-light">metus.</span> elit. Quisque rutrum pellentesque imperdiet.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 appear-animation" data-appear-animation="fadeInUpShorter">
                        <div class="feature-box feature-box-style-2">
                            <div class="feature-box-icon">
                                <i class="icons icon-layers text-color-light"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="font-weight-bold text-color-light text-4 mb-2">SLIDERS</h4>
                                <p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque imperdiet. Nulla lacinia iaculis nulla.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="300">
                        <div class="feature-box feature-box-style-2">
                            <div class="feature-box-icon">
                                <i class="icons icon-menu text-color-light"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="font-weight-bold text-color-light text-4 mb-2">BUTTONS</h4>
                                <p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque imperdiet. Nulla lacinia iaculis nulla.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="300">
                        <div class="feature-box feature-box-style-2">
                            <div class="feature-box-icon">
                                <i class="icons icon-doc text-color-light"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="font-weight-bold text-color-light text-4 mb-2">HTML5 / CSS3 / JS</h4>
                                <p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque imperdiet. Nulla lacinia iaculis nulla.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 appear-animation" data-appear-animation="fadeInUpShorter">
                        <div class="feature-box feature-box-style-2">
                            <div class="feature-box-icon">
                                <i class="icons icon-user text-color-light"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="font-weight-bold text-color-light text-4 mb-2">ICONS</h4>
                                <p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing <span class="alternative-font text-color-light">metus.</span> elit. Quisque rutrum pellentesque imperdiet.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="300">
                        <div class="feature-box feature-box-style-2">
                            <div class="feature-box-icon">
                                <i class="icons icon-screen-desktop text-color-light"></i>
                            </div>
                            <div class="feature-box-info">
                                <h4 class="font-weight-bold text-color-light text-4 mb-2">LIGHTBOX</h4>
                                <p class="text-color-light opacity-7">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque imperdiet. Nulla lacinia iaculis nulla.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="projects" class="container">
            <div class="row justify-content-center pt-5 mt-5">
                <div class="col-lg-9 text-center">
                    <div class="appear-animation" data-appear-animation="fadeInUpShorter">
                        <h2 class="font-weight-bold mb-2">Projects</h2>
                        <p class="mb-4">LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT</p>
                    </div>
                    <p class="pb-3 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque consequat, ante nulla hendrerit arcu, ac tincidunt mauris lacus sed leo. vamus suscipit molestie vestibulum.</p>
                </div>
            </div>
            <div class="row pb-5 mb-5">
                <div class="col">

                    <div class="appear-animation popup-gallery-ajax" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                        <div class="owl-carousel owl-theme mb-0" data-plugin-options="{'items': 4, 'margin': 35, 'loop': false}">


                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Presentation</span>
														<span class="thumb-info-type">Brand</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
                                    <span class="thumb-info thumb-info-lighten">
                                        <span class="thumb-info-wrapper">
                                            <span class="owl-carousel owl-theme dots-inside m-0" data-plugin-options="{'items': 1, 'margin': 20, 'animateOut': 'fadeOut', 'autoplay': true, 'autoplayTimeout': 3000}">
                                                <span>
                                                    <img src="{{ asset('images/projects/project-1.jpg') }}" class="img-fluid border-radius-0" alt="">
                                                </span>
                                                <span>
                                                    <img src="{{ asset('images/projects/project-1-2.jpg') }}" class="img-fluid border-radius-0" alt="">
                                                </span>
                                            </span>
                                            <span class="thumb-info-title">
                                                <span class="thumb-info-inner">Aggone Watch</span>
                                                <span class="thumb-info-type">Media</span>
                                            </span>
                                            <span class="thumb-info-action">
                                                <span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-2.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Identity</span>
														<span class="thumb-info-type">Logo</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-27.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Aggone Screens</span>
														<span class="thumb-info-type">Website</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-4.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Three Bottles</span>
														<span class="thumb-info-type">Logo</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
                                    <span class="thumb-info thumb-info-lighten">
                                        <span class="thumb-info-wrapper">
                                            <img src="{{ asset('images/projects/project-5.jpg') }}" class="img-fluid border-radius-0" alt="">
                                            <span class="thumb-info-title">
                                                <span class="thumb-info-inner">Company T-Shirt</span>
                                                <span class="thumb-info-type">Brand</span>
                                            </span>
                                            <span class="thumb-info-action">
                                                <span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-6.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Mobile Mockup</span>
														<span class="thumb-info-type">Website</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-7.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Aggone Label</span>
														<span class="thumb-info-type">Media</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-23.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Business Folders</span>
														<span class="thumb-info-type">Logo</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-24.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Tablet Screen</span>
														<span class="thumb-info-type">Website</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-25.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Black Watch</span>
														<span class="thumb-info-type">Media</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                            <div class="portfolio-item">
                                <a href="#" data-ajax-on-modal>
											<span class="thumb-info thumb-info-lighten">
												<span class="thumb-info-wrapper">
													<img src="{{ asset('images/projects/project-26.jpg') }}" class="img-fluid border-radius-0" alt="">
													<span class="thumb-info-title">
														<span class="thumb-info-inner">Monitor Mockup</span>
														<span class="thumb-info-type">Website</span>
													</span>
													<span class="thumb-info-action">
														<span class="thumb-info-action-icon bg-dark opacity-8"><i class="fas fa-plus"></i></span>
													</span>
												</span>
											</span>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <section id="clients" class="section section-background section-height-4 overlay overlay-show overlay-op-9 border-0 m-0" style="background-image: url('{{ asset('images/bg-one-page-1-1.jpg') }}'); background-size: cover; background-position: center;">
            <div class="container">
                <div class="row">
                    <div class="col text-center">
                        <h2 class="font-weight-bold text-color-light mb-2">We’re excited about Aggone Template</h2>
                        <p class="text-color-light opacity-7">30,000 CUSTOMERS IN 100 COUNTRIES USE AGGONE TEMPLATE. MEET OUR CUSTOMERS.</p>
                    </div>
                </div>
                <div class="row text-center py-3 my-4">
                    <div class="owl-carousel owl-theme carousel-center-active-item carousel-center-active-item-style-2 mb-0" data-plugin-options="{'responsive': {'0': {'items': 1}, '476': {'items': 1}, '768': {'items': 5}, '992': {'items': 7}, '1200': {'items': 7}}, 'autoplay': true, 'autoplayTimeout': 3000, 'dots': false}">
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-1.png') }}" alt="">
                        </div>
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-2.png') }}" alt="">
                        </div>
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-3.png') }}" alt="">
                        </div>
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-4.png') }}" alt="">
                        </div>
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-5.png') }}" alt="">
                        </div>
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-6.png') }}" alt="">
                        </div>
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-4.png') }}" alt="">
                        </div>
                        <div>
                            <img class="img-fluid" src="{{ asset('images/logos/logo-light-2.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">

                        <div class="owl-carousel owl-theme nav-bottom rounded-nav mb-0" data-plugin-options="{'items': 1, 'loop': true, 'autoHeight': true}">
                            <div>
                                <div class="testimonial testimonial-style-2 testimonial-light testimonial-with-quotes testimonial-quotes-primary mb-0">
                                    <blockquote>
                                        <p class="text-5 line-height-5 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget risus porta, tincidunt turpis at, interdum tortor. Suspendisse potenti.</p>
                                    </blockquote>
                                    <div class="testimonial-author">
                                        <p><strong class="font-weight-extra-bold text-2">- John Smith. Okler</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="testimonial testimonial-style-2 testimonial-light testimonial-with-quotes testimonial-quotes-primary mb-0">
                                    <blockquote>
                                        <p class="text-5 line-height-5 mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget risus porta, tincidunt turpis at, interdum tortor. Suspendisse potenti.</p>
                                    </blockquote>
                                    <div class="testimonial-author">
                                        <p><strong class="font-weight-extra-bold text-2">- John Smith. Okler</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <div id="team" class="container pb-4">
            <div class="row pt-5 mt-5 mb-4">
                <div class="col text-center appear-animation" data-appear-animation="fadeInUpShorter">
                    <h2 class="font-weight-bold mb-1">Team</h2>
                    <p>LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT</p>
                </div>
            </div>
            <div class="row pb-5 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="200">
                <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
							<div class="thumb-info thumb-info-hide-wrapper-bg thumb-info-no-zoom">
								<span class="thumb-info-wrapper">
									<a href="#">
										<img src="{{ asset('images/team/team-1.jpg') }}" class="img-fluid" alt="">
									</a>
								</span>
								<div class="thumb-info-caption">
									<h3 class="font-weight-extra-bold text-color-dark text-4 line-height-1 mt-3 mb-0">John Doe</h3>
									<span class="text-2 mb-0">CEO</span>
									<span class="thumb-info-caption-text pt-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac ligula mi, non suscipitaccumsan</span>
									<span class="thumb-info-social-icons">
										<a target="_blank" href="http://www.facebook.com/"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
										<a href="http://www.twitter.com/"><i class="fab fa-twitter"></i><span>Twitter</span></a>
										<a href="http://www.linkedin.com/"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
									</span>
								</div>
							</div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
							<div class="thumb-info thumb-info-hide-wrapper-bg thumb-info-no-zoom">
								<span class="thumb-info-wrapper">
									<a href="#">
										<img src="{{ asset('images/team/team-2.jpg') }}" class="img-fluid" alt="">
									</a>
								</span>
								<div class="thumb-info-caption">
									<h3 class="font-weight-extra-bold text-color-dark text-4 line-height-1 mt-3 mb-0">Jessica Doe</h3>
									<span class="text-2 mb-0">DESIGNER</span>
									<span class="thumb-info-caption-text pt-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac ligula mi, non suscipitaccumsan</span>
									<span class="thumb-info-social-icons">
										<a target="_blank" href="http://www.facebook.com/"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
										<a href="http://www.twitter.com/"><i class="fab fa-twitter"></i><span>Twitter</span></a>
										<a href="http://www.linkedin.com/"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
									</span>
								</div>
							</div>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4 mb-sm-0">
							<div class="thumb-info thumb-info-hide-wrapper-bg thumb-info-no-zoom">
								<span class="thumb-info-wrapper">
									<a href="#">
										<img src="{{ asset('images/team/team-3.jpg') }}" class="img-fluid" alt="">
									</a>
								</span>
								<div class="thumb-info-caption">
									<h3 class="font-weight-extra-bold text-color-dark text-4 line-height-1 mt-3 mb-0">Ricki Doe</h3>
									<span class="text-2 mb-0">DEVELOPER</span>
									<span class="thumb-info-caption-text pt-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac ligula mi, non suscipitaccumsan</span>
									<span class="thumb-info-social-icons">
										<a target="_blank" href="http://www.facebook.com/"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
										<a href="http://www.twitter.com/"><i class="fab fa-twitter"></i><span>Twitter</span></a>
										<a href="http://www.linkedin.com/"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
									</span>
								</div>
							</div>
                </div>
                <div class="col-sm-6 col-lg-3">
							<div class="thumb-info thumb-info-hide-wrapper-bg thumb-info-no-zoom">
								<span class="thumb-info-wrapper">
									<a href="#">
										<img src="{{ asset('images/team/team-4.jpg') }}" class="img-fluid" alt="">
									</a>
								</span>
								<div class="thumb-info-caption">
									<h3 class="font-weight-extra-bold text-color-dark text-4 line-height-1 mt-3 mb-0">Melinda Doe</h3>
									<span class="text-2 mb-0">SEO ANALYST</span>
									<span class="thumb-info-caption-text pt-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac ligula mi, non suscipitaccumsan</span>
									<span class="thumb-info-social-icons">
										<a target="_blank" href="http://www.facebook.com/"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
										<a href="http://www.twitter.com/"><i class="fab fa-twitter"></i><span>Twitter</span></a>
										<a href="http://www.linkedin.com/"><i class="fab fa-linkedin-in"></i><span>Linkedin</span></a>
									</span>
								</div>
							</div>
                </div>
            </div>
        </div>

        <section id="contact" class="section bg-color-grey-scale-1 border-0 py-0 m-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">

                        <!-- Google Maps - Settings on footer -->
                        <div id="googlemaps" class="google-ma h-100 mb-0" style="min-height: 400px;"></div>

                    </div>
                    <div class="col-md-6 p-5 my-5">

                        <div class="px-4">
                            <h2 class="font-weight-bold line-height-1 mb-2">Contact Us</h2>
                            <p class="text-3 mb-4">LOREM IPSUM DOLOR SIT A MET</p>
                            <form id="contactForm" class="contact-form form-style-2 pr-xl-5" action="https://portotheme.com/html/porto/7.5.0/php/contact-form.php" method="POST">
                                <div class="contact-form-success alert alert-success d-none mt-4" id="contactSuccess">
                                    <strong>Success!</strong> Your message has been sent to us.
                                </div>

                                <div class="contact-form-error alert alert-danger d-none mt-4" id="contactError">
                                    <strong>Error!</strong> There was an error sending your message.
                                    <span class="mail-error-message text-1 d-block" id="mailErrorMessage"></span>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-xl-4">
                                        <input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" placeholder="Name" required>
                                    </div>
                                    <div class="form-group col-xl-8">
                                        <input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <textarea maxlength="5000" data-msg-required="Please enter your message." rows="4" class="form-control" name="message" id="message" placeholder="Message" required></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <input type="submit" value="SUBMIT" class="btn btn-primary btn-rounded font-weight-semibold px-5 btn-py-2 text-2" data-loading-text="Loading...">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="section bg-primary border-0 m-0">
            <div class="container">
                <div class="row justify-content-center text-center text-lg-left py-4">
                    <div class="col-lg-auto appear-animation" data-appear-animation="fadeInRightShorter">
                        <div class="feature-box feature-box-style-2 d-block d-lg-flex mb-4 mb-lg-0">
                            <div class="feature-box-icon">
                                <i class="icon-location-pin icons text-color-light"></i>
                            </div>
                            <div class="feature-box-info pl-1">
                                <h5 class="font-weight-light text-color-light opacity-7 mb-0">ADDRESS</h5>
                                <p class="text-color-light font-weight-semibold mb-0">MON - FRI: 10:00am - 6:00pm</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-auto appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                        <div class="feature-box feature-box-style-2 d-block d-lg-flex mb-4 mb-lg-0 px-xl-4 mx-lg-5">
                            <div class="feature-box-icon">
                                <i class="icon-call-out icons text-color-light"></i>
                            </div>
                            <div class="feature-box-info pl-1">
                                <h5 class="font-weight-light text-color-light opacity-7 mb-0">CALL US NOW</h5>
                                <a href="tel:+8001234567" class="text-color-light font-weight-semibold text-decoration-none">800-123-4567</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-auto appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="400">
                        <div class="feature-box feature-box-style-2 d-block d-lg-flex">
                            <div class="feature-box-icon">
                                <i class="icon-share icons text-color-light"></i>
                            </div>
                            <div class="feature-box-info pl-1">
                                <h5 class="font-weight-light text-color-light opacity-7 mb-0">FOLLOW US</h5>
                                <p class="mb-0">
                                    <span class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" class="text-color-light font-weight-semibold" title="Facebook"><i class="mr-1 fab fa-facebook-f"></i> FACEBOOK</a></span>
                                    <span class="social-icons-twitter pl-3"><a href="http://www.twitter.com/" target="_blank" class="text-color-light font-weight-semibold" title="Twitter"><i class="mr-1 fab fa-twitter"></i> TWITTER</a></span>
                                    <span class="social-icons-instagram pl-3"><a href="http://www.linkedin.com/" target="_blank" class="text-color-light font-weight-semibold" title="Linkedin"><i class="mr-1 fab fa-instagram"></i> INSTAGRAM</a></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer id="footer" class="mt-0">
        <div class="footer-copyright">
            <div class="container py-2">
                <div class="row py-4">
                    <div class="col d-flex align-items-center justify-content-center">
                        <p><strong>AGGONE TEMPLATE</strong> - © Copyright 2019. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>

<!-- Vendor -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery.appear/jquery.appear.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.cookie/jquery.cookie.min.js') }}"></script>
<script src="{{ asset('vendor/modernizr/modernizr.js') }}"></script>
<script src="{{ asset('vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
<script src="{{ asset('vendor/jquery-cookie/jquery.cookie.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('vendor/common/common.min.js') }}"></script>
<script src="{{ asset('vendor/nanoscroller/nanoscroller.js') }}"></script>
<script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<script src="{{ asset('vendor/jquery-appear/jquery.appear.js') }}"></script>
<script src="{{ asset('vendor/owl.carousel/owl.carousel.js') }}"></script>
<script src="{{ asset('vendor/isotope/isotope.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.gmap/jquery.gmap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery.lazyload/jquery.lazyload.min.js') }}"></script>
<script src="{{ asset('vendor/vide/jquery.vide.min.js') }}"></script>
<script src="{{ asset('vendor/vivus/vivus.min.js') }}"></script>

<script src="{{ asset('js/app/theme.js') }}"></script>

<script src="{{ asset('vendor/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('vendor/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="{{ asset('js/views/view.contact.js') }}"></script>


<!-- Theme Initialization Files -->
<script src="{{ asset('js/app/theme.init.js') }}"></script>

<!-- Examples -->
<script src="{{ asset('js/examples/examples.portfolio.js') }}"></script>

<script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?key={{ config("settings.googleMapsAPIKey") }}&libraries=places&dummy=.js'></script>
<script>
    // Map Markers
    var mapMarkers = [{
        address: "New York, NY 10017",
        html: "<strong>New York Office</strong><br>New York, NY 10017<br><br><a href='#' onclick='mapCenterAt({latitude: 40.75198, longitude: -73.96978, zoom: 16}, event)'>[+] zoom here</a>",
    }];

    // Map Initial Location
    var initLatitude = 40.75198;
    var initLongitude = -73.96978;

    // Map Extended Settings
    var mapSettings = {
        controls: {
            draggable: (($.browser.mobile) ? false : true),
            panControl: true,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            overviewMapControl: true
        },
        scrollwheel: false,
        markers: mapMarkers,
        latitude: initLatitude,
        longitude: initLongitude,
        zoom: 5
    };

    var map = $('#googlemaps').gMap(mapSettings),
        mapRef = $('#googlemaps').data('gMap.reference');

    // Map text-center At
    var mapCenterAt = function(options, e) {
        e.preventDefault();
        $('#googlemaps').gMap("centerAt", options);
    }

    // Styles from https://snazzymaps.com/
    var styles = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}];

    var styledMap = new google.maps.StyledMapType(styles, {
        name: 'Styled Map'
    });

    mapRef.mapTypes.set('map_style', styledMap);
    mapRef.setMapTypeId('map_style');

</script>

</body>
</html>
