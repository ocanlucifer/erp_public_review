<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @guest
        {{ config('app.name', 'Laravel') }}
        @else
        {{ config('app.name', 'Laravel') }} [ {{Auth::user()->user_perusahaan['nama_perusahaan']}} ]
        @endguest
    </title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" ></script> -->
    <script src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--
    <link href="{{ asset('css/bc/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bc/form.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bc/customize.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('assets/css/minified/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/core.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
    <link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">


    <link href="{{ asset('assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/minified/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/minified/components.min.css') }}" rel="stylesheet" type="text/css">

    <style>
        .cont {
            position: relative;
        }

        .cont .btnn {
            position: absolute;
            top: 8%;
            right: 0%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            font-size: 5px;
            padding: 0px 0px;
            border: none;
            cursor: pointer;
            border-radius: 0px;
            text-align: center;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 3;
            /* <-- Apparently some margin are still there even though it's hidden */
        }

        input[type=number] {
            -moz-appearance: textfield;
            /* Firefox */
        }

        td {
            padding: 5 !important;
            vertical-align: middle !important;
            font-size: 12px !important;
        }

        th {
            padding: 5 !important;
            vertical-align: middle !important;
            font-size: 14px !important;
        }

        .input-intable {
            /*height:57 !important; */
            position: relative !important;
            min-width: 70 !important;
            box-sizing: border-box !important;
            -webkit-box-sizing: border-box !important;
            -moz-box-sizing: border-box !important;
        }

        .select2-selection--single {
            height: 100% !important;
        }

        .select2-selection__rendered {
            padding: 4px !important;
            word-wrap: break-word !important;
            white-space: normal !important;
            vertical-align: middle !important;
        }

        .td-input {
            padding: 5 !important;
            vertical-align: middle !important;
        }

        .xx {
            display: block;
            height: 570;
            overflow-y: auto;
        }

        .navbar {
            padding: 0pt 10pt 0pt 0pt !important;
        }

        .conten {
            padding: 0pt 10pt 2pt 10pt !important;
        }

        .breadcrumb {
            padding: 0pt 0pt 0pt 0pt !important;
            margin: 0pt 0pt 10pt !important;
        }
    </style>
</head>

<body>
    <!-- <div id="app"> -->
    <div class="">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm ">

            <a class="navbar-brand" href="{{ url('/home') }}">
                @guest
                {{ config('app.name', 'Laravel') }}
                @else
                <img src="{{ url(Auth::user()->user_perusahaan['logo']) }}" align="middle">
                <!-- {{ config('app.name', 'Laravel') }} <b>[ {{Auth::user()->user_perusahaan['nama_perusahaan']}} ]</b> -->
                @endguest
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse nav navbar-nav " id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto ">
                    @guest

                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Master
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            @if (Auth::user()->hak_akses =='IT')
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/perusahaan') }}"><i class="icon-office"></i>
                                    Perusahaan</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/divisi') }}"><i class="icon-city"></i>
                                    Divisi</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/manage_user') }}"><i class="icon-users"></i>
                                    User</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/brand') }}"><i class="icon-droplet"></i>
                                    Brands</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/countries') }}"><i class="icon-flag3"></i>
                                    Countries</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/currencies') }}"><i
                                        class="icon-coin-dollar"></i> Currencies</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/customer') }}"><i
                                        class="icon-collaboration"></i> Customer</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/supplier') }}"><i class="icon-store2"></i>
                                    Suppliers</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/unit') }}"><i class="icon-puzzle3"></i>
                                    Units</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/size') }}"><i
                                        class="icon-font-size"></i>Sizes</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/material') }}"><i class="icon-package"></i>
                                    Material</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/style') }}"><i
                                        class="icon-file-presentation"></i>Style</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/style_sample') }}"><i
                                        class="icon-file-presentation2"></i>Style Sample</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/fabric_const') }}"><i
                                        class="icon-file-presentation2"></i>Fabric Construct</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/fabric_comp') }}"><i
                                        class="icon-file-presentation2"></i>Fabric Composts</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/color') }}"><i
                                        class="icon-color-sampler"></i>Color</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/tipe_bc') }}"><i
                                        class="icon-typewriter"></i>Tipe BC</a>
                            </li>
                            <li class="">
                                <a class="dropdown-item" href="{{ url('/ppn') }}"><i class="icon-coin-dollar"></i>
                                    PPN</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    &nbsp &nbsp
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Sales
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <li class="">
                                <a href="{{ url('/quotation') }}">Quotations</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/salesorders') }}">Orders</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/salessamples') }}">Samples</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}">Order Groups</a>
                            </li>
                        </ul>
                    </li>
                    &nbsp &nbsp
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Purchasing
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <li class="">
                                <a href="{{ url('/consumption') }}"><i class="icon-pie-chart3"></i>Consumptions</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-file-text2"></i>PO Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-file-text2"></i>PO Akasesoris</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-file-text3"></i>Rekap PO Kain</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-box"></i>BPB Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-box"></i>BPB Kain Rekap</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-box"></i>BPB Aksesoris</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Retur Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Retur Kain Rekap</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Retur Aksesoris</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-dots"></i>SPM Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-dots"></i>SPM Kain Rekap</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-dots"></i>SPM Aksesoris</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-dots"></i>SPM Per Minggu</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-dots"></i>SPM Per Minggu Rekap</a>
                            </li>
                        </ul>
                    </li>
                    &nbsp &nbsp
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Warehouse
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter"></i>Surat Jalan Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter"></i>Surat Jalan Aksesoris</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-checkmark"></i>Pemakaian Kain</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Aksesoris</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Produksi Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Produksi
                                    Aksesoris</a>
                            </li>
                        </ul>
                    </li>
                    &nbsp &nbsp
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Manufacturing
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-calculator3"></i>Marker Calculations</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/mcp') }}"><i class="icon-stack-check"></i>Marker Check Productions</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/marker') }}"><i class="icon-stack-empty"></i>Markers</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/promark') }}"><i class="icon-stack-empty"></i>Production Markers</a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-file-check"></i>Quality Test</a>
                            </li>
                        </ul>
                    </li>
                    &nbsp &nbsp
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Report
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter"></i> Jalan Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter"></i> Jalan Aksesoris</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-pie-chart3"></i>Pemakaian Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Aksesoris</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Produksi Kain</a>
                            </li>
                            <li class="">
                                <a href="{{ url('/') }}"><i class="icon-enter5"></i>Surat Jalan Retur Produksi
                                    Aksesoris</a>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto navbar-right">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="icon-user"></i> {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('/') }}"><i class="icon-key"></i> Change Password</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="icon-lock"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </nav>
        <main class="content">
            @yield('content')
        </main>
        <div class="py-3"></div>
        <footer>
            <center>
                &copy; 2020 <a href="http://www.teodore.com/" target="blank">PT. Teodore Pan Garmindo</a>
                <div class="py-4"></div>
            </center>
        </footer>
    </div>
</body>


</html>
