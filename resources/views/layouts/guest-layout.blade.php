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

    @include('layouts.styles')

    
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

    <footer>
        <div class="container">
            <div class="d-lg-flex justify-content-center text-center align-items-center">
                <span id="font-custom" class="text-white fw-bold pt-5 pb-0">{{ $setting->details }}</span>
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
