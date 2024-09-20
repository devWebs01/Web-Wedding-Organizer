<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>{{ $title ?? '' }} | {{ $setting->name }}</title>

    @livewireStyles

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/guest/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('/guest/css/fontawesome.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('/guest/css/templatemo-villa-agency.css') }}">
    <link rel="stylesheet" href="{{ asset('/guest/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('/guest/css/animate.css') }}">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    @stack('css')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Reddit+Sans:ital,wght@0,200..900;1,200..900&display=swap');

        * {
            font-family: "Reddit Sans", sans-serif;
            font-optical-sizing: auto;
            /* font-weight: <weight>;
            font-style: normal; */
        }

        .pagination {
            justify-content: center;
            --bs-pagination-active-bg: #000000;
            --bs-pagination-color: black;
        }

        .active>.page-link,
        .page-link.active {
            border-color: #000000;
        }

        .nav-pills .nav-link {
            color: black;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: white;
            background-color: black;
        }

        #font-custom {
            font-family: "DM Serif Display", serif;
            font-weight: 400;
            font-style: normal;
        }

        .font-stroke {
            text-shadow: 2px 2px #646262;
        }

        .btn-custom {
            padding: 12px 24px;
            background-color: white;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }

        .btn-custom span {
            color: black;
            position: relative;
            z-index: 1;
            transition: color 0.6s cubic-bezier(0.53, 0.21, 0, 1);
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            border-radius: 6px;
            transform: translate(-100%, -50%);
            width: 100%;
            height: 100%;
            background-color: hsl(244, 63%, 69%);
            transition: transform 0.6s cubic-bezier(0.53, 0.21, 0, 1);
        }

        .btn-custom:hover span {
            color: white;
        }

        .btn-custom:hover::before {
            transform: translate(0, -50%);
        }



    </style>

    @vite([])
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-body mb-3">
            <div class="container border rounded-5 p-3">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <span id="font-custom" class=" fw-bold fs-2">{{ $setting->name }}</span>
                </a>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">
                                </i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('catalog-products') }}">
                                Katalog
                            </a>
                        </li>
                    </ul>
                    <div class="gap-5">
                        @livewire('layout.guest-nav')
                    </div>
                </div>

            </div>
        </nav>
    </header>
    <!-- ***** Header Area End ***** -->
    @include('layouts.payment')
    {{ $slot }}

    <footer class="py-0 sticky-md-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-3 text-center text-lg-start">
                    <span id="font-custom" class="text-white fw-bold fs-2">{{ $setting->name }}</span>
                </div>
                <div class="col-12 col-lg-6 navbar-expand text-center">
                    <p class="fw-bold">
                        {{ $setting->province->name }},
                        {{ $setting->city->name }},
                        {{ $setting->city->postal_code }},
                        Indonesia
                    </p>
                </div>
                <div class="col-12 col-lg-3 text-center text-lg-end text-white">
                    <a class="me-2 text-white" href="">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a class="me-2 text-white" href="">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a class="me-2 text-white" href="">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('/guest/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/guest/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/guest/js/isotope.min.js') }}"></script>
    <script src="{{ asset('/guest/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('/guest/js/counter.js') }}"></script>
    <script src="{{ asset('/guest/js/custom.js') }}"></script>

    @stack('scripts')

    @livewireScripts

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-livewire-alert::scripts />
</body>

</html>
