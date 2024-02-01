<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Toko Toko Mawar Super Laundry, Terbaik dan Terpecaya</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white">
    <div class="min-h-screen  dark:bg-gray-900 bg-white">
        <livewire:layout.navigation-costumer />


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>


    <footer class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Grid -->
        <div class="text-center">
            <div>
                <a class="flex-none text-xl font-semibold text-black dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    href="#" aria-label="Brand">Toko Mawar Super Laundry</a>
            </div>
            <!-- End Col -->

            <div class="mt-3">
                <p class="text-gray-500">Harumkan Setiap Momen Anda!</p>
            </div>
        </div>
        <!-- End Grid -->
    </footer>
</body>

</html>
