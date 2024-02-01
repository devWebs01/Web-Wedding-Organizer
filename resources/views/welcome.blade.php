<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;

state([
    'products' => fn() => Product::latest()
        ->limit(2)
        ->get(),
    'randomProduct' => fn() => Product::inRandomOrder()
        ->limit(6)
        ->get(),
]);

?>

<x-costumer-layout>
    @volt
        <div>
            <!-- BEGIN HERO SECTION -->
            <div class="relative items-center justify-center w-full overflow-x-hidden lg:pt-40 lg:pb-40 xl:pt-40 xl:pb-64">
                <div
                    class="container flex flex-col items-center justify-between h-full max-w-6xl px-8 mx-auto -mt-32 lg:flex-row xl:px-0">
                    <div
                        class="flex flex-col items-center w-full max-w-xl pt-48 text-center lg:items-start lg:w-1/2 lg:pt-20 xl:pt-40 lg:text-left">
                        <h1 class="relative mb-4 text-3xl font-black leading-tight text-gray-900 sm:text-6xl xl:mb-8">Selamat
                            datang di Toko Kami!</h1>
                        <p class="pr-0 mb-8 text-base text-gray-600 sm:text-lg xl:text-xl lg:pr-20"> Temukan beragam pilihan
                            pewangi yang segar dan tahan lama untuk menjaga pakaian Anda tetap harum dan bersih. Dapatkan
                            pengalaman mencuci yang menyenangkan dengan produk berkualitas terbaik. Kunjungi toko kami
                            sekarang dan temukan pewangi laundry favorit Anda!
                        </p>
                        <a wire:navigate href="/catalog/list"
                            class="relative self-start inline-block w-auto px-8 py-4 mx-auto mt-0 text-base font-bold text-white bg-indigo-600 border-t border-gray-200 rounded-md shadow-xl sm:mt-1 fold-bold lg:mx-0">Belanja
                            Sekarang</a>
                        <!-- Integrates with section -->
                    </div>
                    <div class="relative z-50 flex flex-col items-end justify-center w-full h-full lg:w-1/2 ms:pl-10">
                        <div class="container relative lg:left-60 w-full max-w-4xl lg:absolute xl:max-w-6xl lg:w-screen">
                            <img src="/img/hero.png"
                                class="w-full h-auto mt-20 mb-20 ml-0 lg:mt-24 xl:mt-40 lg:mb-0 lg:w-96 lg:-ml-12">
                        </div>
                    </div>
                </div>
            </div>
            <!-- HERO SECTION END -->

            <!-- Icon Blocks -->
            <div class="px-10">
                <div class="max-w-[85rem] px-4 sm:px-6 mx-auto">
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 items-center gap-12">
                        <!-- Icon Block -->
                        <div>
                            <div
                                class="relative flex justify-center items-center w-12 h-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-blue-600 before:via-transparent before:to-violet-600 before:rounded-xl dark:bg-slate-900">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-600 dark:text-blue-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect width="10" height="14" x="3" y="8" rx="2" />
                                    <path d="M5 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2h-2.4" />
                                    <path d="M8 18h.01" />
                                </svg>
                            </div>
                            <div class="mt-5">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Temukan Aroma Ilahi</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Benamkan pakaian Anda dalam wewangian
                                    laundry bunga dan jeruk yang mempesona untuk sentuhan kemewahan pada setiap pencucian.
                                </p>
                            </div>
                        </div>
                        <!-- End Icon Block -->

                        <!-- Icon Block -->
                        <div>
                            <div
                                class="relative flex justify-center items-center w-12 h-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-blue-600 before:via-transparent before:to-violet-600 before:rounded-xl dark:bg-slate-900">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-600 dark:text-blue-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 7h-9" />
                                    <path d="M14 17H5" />
                                    <circle cx="17" cy="17" r="3" />
                                    <circle cx="7" cy="7" r="3" />
                                </svg>
                            </div>
                            <div class="mt-5">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Dengan Kesegaran Tahan Lama
                                </h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400"> Nikmati keharuman yang tahan lama pada
                                    pakaian Anda. Formula canggih kami membuat cucian Anda tetap harum sepanjang hari.
                                </p>
                            </div>
                        </div>
                        <!-- End Icon Block -->

                        <!-- Icon Block -->
                        <div>
                            <div
                                class="relative flex justify-center items-center w-12 h-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-blue-600 before:via-transparent before:to-violet-600 before:rounded-xl dark:bg-slate-900">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-600 dark:text-blue-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                                </svg>
                            </div>
                            <div class="mt-5">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Penawaran Peluncuran
                                    Eksklusif</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Jadilah orang pertama yang merasakan
                                    keajaiban! Nikmati penawaran peluncuran spesial untuk wewangian laundry terbaru kami.
                                </p>
                            </div>
                        </div>
                        <!-- End Icon Block -->

                        <!-- Icon Block -->
                        <div>
                            <div
                                class="relative flex justify-center items-center w-12 h-12 bg-white rounded-xl before:absolute before:-inset-px before:-z-[1] before:bg-gradient-to-br before:from-blue-600 before:via-transparent before:to-violet-600 before:rounded-xl dark:bg-slate-900">
                                <svg class="flex-shrink-0 w-6 h-6 text-blue-600 dark:text-blue-500"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z" />
                                    <path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1" />
                                </svg>
                            </div>
                            <div class="mt-5">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Lembut pada Kain</h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-400">Jangan berkompromi dalam perawatan.
                                    Wewangian terbaru kami lembut pada kain dan memberikan kesegaran yang kuat.
                                </p>
                            </div>
                        </div>
                        <!-- End Icon Block -->
                    </div>
                </div>
            </div>
            <!-- End Icon Blocks -->

            <!-- PRODUCT NEW START -->
            <section>
                <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:items-stretch">
                        <div class="grid place-content-center rounded bg-gray-100 p-6 sm:p-8">
                            <div class="mx-auto max-w-md text-center lg:text-left">
                                <header>
                                    <h2 class="text-xl font-bold text-gray-900 sm:text-3xl">Pilihan Terbaik</h2>

                                    <p class="mt-4 text-gray-500">
                                        Pewangi Laundry Terbaik untuk Hasil yang Harum dan Tahan Lama. Temukan Pilihan
                                        Pewangi Laundry Berkualitas Tinggi di Toko Kami!
                                    </p>
                                </header>

                                <a wire:navigate href="/catalog/list"
                                    class="mt-8 inline-block rounded border border-gray-900 bg-gray-900 px-12 py-3 text-sm font-medium text-white transition hover:shadow focus:outline-none focus:ring">
                                    Lihat Lebih
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-2 lg:py-8">
                            <ul class="grid grid-cols-2 gap-4">
                                @foreach ($products as $item)
                                    <li>
                                        <a wire:navigate href="/catalog/{{ $item->id }}" class="group block">
                                            <img src="{{ Storage::url($item->image) }}" alt=""
                                                class="aspect-square w-full rounded object-cover" />

                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!-- PRODUCT NEW END -->

            <!-- PRODUCT POPULER sTART-->
            <div class="max-w-lg pt-12 mx-auto md:max-w-screen-2xl">
                <div data-controller="pagination lazy-loader">
                    <div class="text-center">
                        <h1 class="text-4xl px-10 font-bold mb-0">Produk Terbaru</h1>
                        <p class="text-lg px-10 mb-0">Belanja sekarang dan ubah setiap pencucian menjadi pengalaman
                            menyenangkan. <br>
                            Rangkullah kesegaran yang
                            belum pernah ada sebelumnya!
                        </p>
                    </div>
                    <div id="resources"
                        class="grid mx-auto gap-x-6 gap-y-12 md:grid-cols-2 lg:grid-cols-3 xl:gap-x-8 2xl:gap-x-12 2xl:gap-y-16 xl:gap-y-14 p-10">
                        @if ($randomProduct->isNotEmpty())
                            @foreach ($randomProduct as $product)
                                <div class="border rounded-xl">
                                    <div
                                        class="flex flex-col w-full overflow-hidden bg-gray-100 rounded-2xl h-72 sm:h-80 md:h-72 lg:h-64 xl:h-80">
                                        <div class="relative flex items-center justify-center flex-shrink-0 h-full group">
                                            <img class="rounded-lg shadow-md mx-auto object-cover object-left-top transition ease-in-out duration-300"
                                                alt="{{ $product->title }}" data-lazy-loader-target="entry"
                                                src="{{ Storage::url($product->image) }}">
                                            <div
                                                class="absolute inset-0 transition duration-200 bg-gray-900 opacity-0 rounded-2xl group-hover:opacity-60">
                                            </div>
                                            <div
                                                class="absolute inset-0 flex flex-col items-center justify-center transition duration-200 opacity-0 group-hover:opacity-100">
                                                <div class="shadow-sm w-33 rounded-2xl">
                                                    <a wire:navigate
                                                        class="w-full justify-center inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-2xl shadow-sm text-white transition duration-150 bg-cool-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500"
                                                        href="/catalog/{{ $product->id }}">Lihat Produk</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex flex-col justify-between flex-1 px-6 pt-6 pb-0">
                                            <div class="flex-1">
                                                <a wire:navigate class="block group" href="/catalog/{{ $product->id }}">
                                                    <div class="badge badge-outline">
                                                        {{ Str::limit($product->category->name, 30, '...') }}</div>

                                                    <h5
                                                        class="flex items-center font-bold leading-7 text-gray-900 group-hover:text-cool-indigo-600">
                                                        {{ $product->title }}
                                                    </h5>

                                                    <h5
                                                        class="flex items-center text-xl font-bold leading-7 text-gray-900 group-hover:text-red">
                                                        {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                                                    </h5>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
            <!-- PRODUCT POPULER END -->

            <!-- INTEGRETED -->
            <div class="flex flex-col mx-3 bg-white rounded-lg">
                <div class="w-full draggable">
                    <div class="container flex flex-col items-center gap-8 mx-auto my-11">
                        <h1 class="text-xl text-center text-dark-grey-600">Terintegrasi Dengan Jasa
                            Pengiriman Terpecaya</h1>
                        <div class="flex flex-wrap items-center justify-center w-full gap-6 lg:flex-nowrap">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="75.0209mm"
                                    height="20.32mm"
                                    style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                    viewBox="0 0 9902 2032" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <symbol id="format_x0020_logo_x0020_utk_x0020_jpg" viewBox="-4385 -8732 18672 19496">
                                        <rect class="fil0 str0" x="-4381" y="-8728" width="18665" height="19488" />
                                    </symbol>
                                    <g id="Layer_x0020_1">
                                        <metadata id="CorelCorpID_0Corel-Layer" />
                                        <path class="fil1"
                                            d="M612 1702c159,152 373,244 607,244 234,0 448,-92 608,-244l118 0c-180,204 -439,330 -726,330 -287,0 -546,-126 -726,-330l119 0zm165 0c30,21 62,40 95,57 22,-21 48,-40 73,-57l100 0c-4,2 -9,4 -12,6 -16,7 -31,16 -46,25 -22,13 -43,30 -64,48 91,39 192,60 296,60 104,0 205,-21 296,-60 -21,-18 -42,-34 -64,-48 -15,-9 -30,-18 -46,-25 -3,-1 -7,-4 -12,-6l100 0c0,0 0,0 0,0 25,16 51,36 73,57 33,-18 65,-36 95,-57l80 0c-43,34 -89,65 -138,91 -16,9 -33,18 -49,25 -103,45 -216,70 -335,70 -119,0 -232,-25 -335,-70 -16,-7 -33,-16 -49,-25 -49,-25 -95,-57 -138,-91l80 0z" />
                                        <path class="fil1"
                                            d="M388 1372c51,126 128,240 225,330l-119 0c-85,-95 -152,-207 -196,-330l91 0zm112 0c40,88 95,167 162,234 36,-40 76,-77 118,-109 -21,-39 -39,-80 -55,-125l48 0c13,34 28,68 45,98 16,-9 31,-19 48,-28l-62 -70 104 0 24 37c12,-4 24,-9 37,-15 -3,-7 -4,-15 -6,-22l39 0c1,3 1,7 3,10 12,-3 25,-7 37,-10l360 0c12,3 25,7 37,10 1,-3 1,-7 3,-10l39 0c-1,7 -3,15 -6,22 54,21 103,46 150,76 16,-30 31,-64 45,-98l48 0c-16,45 -34,86 -55,125 42,31 82,68 118,109 67,-67 122,-146 162,-234l52 0c-45,101 -107,193 -183,271 -10,10 -22,21 -34,31 -10,9 -21,19 -33,28l-80 0c28,-19 57,-42 82,-64 -33,-37 -70,-70 -109,-98 -40,64 -88,119 -141,162l-100 0c-15,-6 -30,-12 -45,-18 -13,-3 -25,-7 -39,-10 -28,-6 -60,-9 -91,-9 -31,0 -62,3 -91,9 -13,3 -25,7 -39,10 -15,6 -30,12 -45,18l-100 0c-54,-43 -101,-98 -141,-162 -39,28 -76,61 -109,98 25,22 54,45 82,64l-80 0c-12,-9 -22,-19 -33,-28 -12,-10 -24,-21 -34,-31 -76,-77 -138,-170 -183,-271l52 0zm1642 0c-45,123 -112,235 -196,330l-118 0c95,-91 173,-204 223,-330l91 0zm-1300 143c42,67 91,122 146,164 24,-13 49,-24 74,-33 -33,-52 -61,-120 -83,-199 -7,3 -15,4 -22,9l10 15 -46 0c-27,13 -54,28 -79,45zm610 164c55,-42 104,-97 146,-164 -43,-28 -89,-51 -137,-68 -22,79 -51,147 -83,199 25,9 51,19 74,33zm-437 -244c22,82 51,150 83,201 39,-10 80,-16 122,-16 42,0 83,6 122,16 33,-51 61,-119 83,-201 -65,-21 -134,-31 -205,-31 -71,0 -140,10 -205,31z" />
                                        <path class="fil1"
                                            d="M774 876l-31 49 183 9c1,-19 3,-39 4,-58l39 0c-1,19 -1,39 -3,59l254 12 70 -71 86 0 -83 126 77 126 -74 0 -82 -74 -250 10c3,112 15,216 34,306l-39 0c-19,-92 -31,-195 -34,-305l-202 9 181 296 -104 0 -33 -36 -9 0c4,12 7,24 12,36l-48 0c-4,-12 -7,-24 -12,-36l-12 0 -42 -55 37 -3c-1,-10 -4,-19 -6,-30l-15 -15 -65 0 -48 -61 55 -4 -79 -86c-40,0 -77,1 -113,1l-48 3 -55 2 -85 6c-61,3 -116,6 -170,7 -25,0 -86,4 -62,-46 19,-40 65,-95 109,-116 48,-22 80,-37 128,-39 104,-3 320,22 320,22l42 -46 171 0zm733 0c3,25 4,52 4,79l-40 0c0,-27 -1,-54 -3,-79l39 0zm257 0c3,25 6,52 7,79l-46 0c-2,-27 -4,-54 -7,-79l46 0zm289 0c3,25 6,52 9,79l-48 0c-3,-27 -6,-54 -10,-79l49 0zm140 0c3,25 6,52 7,79l-83 0c-2,-27 -4,-54 -9,-79l85 0zm-1897 495c-22,-64 -40,-129 -51,-199l85 0c12,70 31,137 57,199l-91 0zm150 0c-27,-62 -48,-129 -60,-199l48 0c13,70 36,137 64,199l-52 0zm592 0c58,-15 118,-22 180,-22 62,0 122,7 180,22l-360 0zm400 0c18,-88 30,-187 33,-293l40 0c-3,106 -15,204 -34,293l-39 0zm228 0c33,-88 54,-187 60,-293l46 0c-6,104 -27,204 -58,293l-48 0zm272 0c42,-89 68,-189 76,-293l48 0c-7,104 -33,202 -71,293l-52 0zm112 0c37,-91 60,-190 67,-293l83 0c-6,103 -27,201 -59,293l-91 0zm-543 -378l998 0 0 46 -998 0 0 -46z" />
                                        <path class="fil1"
                                            d="M603 876l30 -34 -57 -4 48 -61 67 0c3,-15 7,-30 10,-45l-27 -1 42 -55 3 0c16,-51 37,-97 59,-138 -42,-33 -82,-68 -118,-109 -106,106 -183,242 -217,396l-49 0c85,-390 421,-680 824,-680 419,0 769,317 835,732l-49 0c-28,-174 -110,-330 -228,-448 -36,40 -76,76 -118,109 52,97 89,213 106,339l-46 0c-15,-118 -49,-223 -97,-314 -48,31 -97,57 -150,76 18,73 30,152 36,238l-39 0c-6,-82 -18,-158 -33,-226 -68,22 -141,34 -217,34 -76,0 -149,-12 -217,-34 -15,68 -27,144 -33,226l-39 0c6,-86 18,-165 36,-238 -12,-4 -24,-9 -34,-13l-158 251 -171 0zm687 0l3 -4 85 0 -1 4 -86 0zm818 0c-65,-446 -439,-788 -890,-788 -433,0 -794,315 -881,736l-85 0c86,-470 486,-824 965,-824 497,0 907,381 974,876l-85 0zm-1305 -384c40,-64 88,-119 141,-161 -25,-18 -51,-36 -73,-57 -64,31 -123,73 -177,120 33,36 70,68 109,97zm183 -192c15,9 30,18 46,25 18,9 37,16 58,22 12,4 24,7 37,10 30,6 60,10 91,10 31,0 61,-4 91,-10 13,-3 25,-6 37,-10 21,-6 40,-13 58,-22 16,-7 31,-16 46,-25 22,-15 43,-31 64,-49 -91,-37 -192,-58 -296,-58 -104,0 -205,21 -296,58 21,18 42,34 64,49zm0 55c-55,42 -104,97 -146,164 19,12 37,22 58,33l9 -10 76 0 -24 39 18 7c22,-80 52,-147 85,-199 -27,-9 -52,-19 -76,-33zm-171 207c-18,36 -34,73 -49,113l19 0 77 -85c-16,-9 -31,-18 -48,-28zm781 -43c-42,-67 -91,-122 -146,-164 -24,13 -49,24 -76,33 33,52 62,119 85,199 48,-18 94,-42 137,-68zm-104 -187c54,42 101,97 141,161 39,-28 76,-61 109,-97 -54,-48 -113,-89 -177,-120 -22,21 -48,39 -73,57zm-396 67c-33,49 -61,118 -83,201 65,21 134,31 205,31 71,0 140,-10 205,-31 -22,-83 -51,-152 -83,-201 -39,10 -80,15 -122,15 -42,0 -83,-4 -122,-15z" />
                                        <path class="fil2"
                                            d="M8275 1843l204 -1242 231 0c-140,-40 -235,-119 -235,-211 0,-131 195,-238 437,-238 241,0 436,107 436,238 0,92 -95,171 -235,211l183 0 -205 1242 -815 0zm-2484 0l295 -1691 817 0 -296 1691 -815 0zm-1049 0l204 -1242 232 0c-140,-40 -237,-119 -237,-211 0,-131 196,-238 437,-238 241,0 437,107 437,238 0,92 -97,171 -237,211l183 0 -205 1242 -815 0zm-1538 0l219 -1227 -524 0 83 -478 1827 0 -88 478 -482 0 -220 1227 -815 0z" />
                                        <path class="fil1"
                                            d="M9649 272l0 70 28 0c18,0 31,-1 39,-7 7,-6 12,-15 12,-27 0,-12 -4,-21 -13,-27 -7,-6 -21,-9 -40,-9l-25 0zm-59 -39l95 0c34,0 61,6 79,18 18,12 25,30 25,54 0,16 -4,30 -13,42 -10,10 -22,19 -40,22l55 110 -65 0 -48 -100 -28 0 0 100 -59 0 0 -245zm91 -57c-25,0 -48,4 -70,13 -21,9 -40,21 -58,39 -18,18 -31,39 -42,61 -9,22 -15,46 -15,70 0,25 6,48 15,70 9,22 22,42 39,59 18,18 37,31 61,40 22,10 46,15 70,15 24,0 46,-4 68,-13 24,-10 43,-22 62,-40 16,-16 30,-36 39,-58 10,-22 15,-45 15,-68 0,-27 -4,-51 -13,-73 -9,-22 -22,-42 -39,-59 -18,-18 -39,-33 -61,-42 -22,-9 -46,-13 -71,-13zm0 -37c30,0 60,6 86,16 27,12 51,28 71,51 21,19 37,43 48,70 10,27 16,55 16,85 0,30 -6,58 -18,85 -10,27 -27,51 -48,71 -21,21 -46,36 -73,48 -27,10 -55,16 -83,16 -30,0 -58,-6 -85,-18 -27,-10 -51,-27 -73,-49 -19,-21 -36,-45 -46,-70 -10,-27 -16,-55 -16,-83 0,-21 3,-40 7,-60 6,-19 13,-37 25,-55 19,-34 46,-61 79,-79 33,-19 68,-28 109,-28z" />
                                        <polygon class="fil1"
                                            points="7418,176 8364,176 7559,995 8083,1843 7100,1843 6601,1026 " />
                                    </g>
                                </svg>
                            </span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="48.6449mm"
                                    height="20.32mm"
                                    style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                                    viewBox="0 0 4865 2032" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                        <style type="text/css">
                                            <![CDATA[
                                            .fil0 {
                                                fill: #25387B
                                            }

                                            .fil1 {
                                                fill: #DF2128
                                            }

                                            .fil3 {
                                                fill: #25387B;
                                                fill-rule: nonzero
                                            }

                                            .fil2 {
                                                fill: #25387C;
                                                fill-rule: nonzero
                                            }
                                            ]]>
                                        </style>
                                    </defs>
                                    <g id="__x0023_Layer_x0020_1">
                                        <metadata id="CorelCorpID_0Corel-Layer" />
                                        <polygon class="fil0"
                                            points="3203,1459 3509,0 4652,0 4576,365 4004,365 3966,547 4452,547 4375,912 3889,912 3851,1095 4423,1095 4346,1459 " />
                                        <path class="fil1"
                                            d="M0 1459c1017,-486 2393,-797 3649,-912 339,-31 675,-49 1143,-49 18,0 49,-6 73,-12l-94 450c-5,24 -46,36 -76,36 -2868,0 -4585,486 -4585,486l-109 0z" />
                                        <polygon class="fil0"
                                            points="1540,1459 1846,0 2393,0 2719,663 2858,0 3405,0 3099,1459 2552,1459 2231,772 2087,1459 " />
                                        <path class="fil0"
                                            d="M1017 851l178 -851 547 0 -214 1022c-66,316 -312,438 -639,438l-403 0 92 -438 182 0c134,0 231,-49 256,-170z" />
                                        <polygon class="fil2"
                                            points="2772,1944 2783,1866 2905,1866 2916,1784 2794,1784 2803,1723 2928,1723 2939,1641 2744,1641 2692,2026 2897,2026 2908,1944 " />
                                        <path class="fil2"
                                            d="M3202 1641l-85 0 -40 70c-6,11 -13,23 -21,38 -6,-20 -10,-31 -10,-33l-25 -75 -73 0 61 189 -110 196 87 0 35 -62c8,-14 15,-26 20,-36 3,10 7,22 11,36l20 62 77 0 -61 -182 114 -203z" />
                                        <path class="fil2"
                                            d="M3397 1743c0,-21 -3,-40 -9,-55 -7,-16 -16,-28 -28,-36 -12,-7 -27,-11 -46,-11l-105 0 -52 385 70 0 19 -139 22 0c22,0 36,-1 45,-3 14,-3 26,-8 35,-14 9,-6 17,-15 24,-27 7,-11 13,-26 18,-45 5,-18 7,-37 7,-56zm-129 -21l0 0 25 0c20,0 25,2 25,2 3,1 5,4 6,7 2,4 3,10 3,17 0,11 -2,22 -6,32 -4,9 -9,15 -16,19 -4,2 -15,6 -46,6l-3 0 11 -84z" />
                                        <path class="fil2"
                                            d="M3582 1891c-3,-9 -7,-17 -11,-24 20,-7 36,-20 47,-38 13,-22 19,-49 19,-82 0,-23 -3,-43 -10,-59 -7,-17 -17,-30 -29,-37 -12,-7 -27,-10 -47,-10l-113 0 -52 385 70 0 20 -151 10 0c11,0 15,3 16,4 4,5 11,16 19,43 12,43 20,75 24,95l2 8 74 0 -3 -13c-13,-52 -26,-93 -36,-122zm-85 -168l0 0 44 0c17,0 20,3 20,3 5,5 7,12 7,22 0,10 -2,19 -6,28 -4,8 -9,14 -16,18 -4,2 -15,6 -46,6l-14 0 10 -77z" />
                                        <polygon class="fil3"
                                            points="3847,1866 3858,1784 3737,1784 3745,1723 3871,1723 3882,1641 3686,1641 3635,2026 3839,2026 3850,1944 3714,1944 3726,1866 " />
                                        <path class="fil2"
                                            d="M3993 1715c10,0 17,3 22,10 6,8 9,19 10,34l1 11 67 -5 0 -10c-2,-35 -11,-64 -27,-86 -17,-23 -42,-34 -72,-34 -31,0 -54,12 -71,35 -16,22 -23,50 -23,82 0,19 3,35 8,50 5,15 13,27 22,36 9,9 22,19 41,32 22,15 29,22 31,24 4,6 6,12 6,21 0,10 -3,18 -8,25 -5,6 -14,9 -26,9 -20,0 -27,-8 -30,-14 -2,-4 -5,-14 -6,-41l0 -11 -67 5 0 10c0,25 3,48 9,68 7,21 19,37 35,49 17,12 36,18 59,18 33,0 59,-13 77,-39 18,-24 27,-54 27,-88 0,-28 -6,-51 -18,-70 -8,-13 -26,-28 -55,-47 -21,-14 -29,-22 -32,-26 -4,-5 -6,-11 -6,-19 0,-9 2,-16 6,-21 4,-5 10,-7 20,-7z" />
                                        <path class="fil2"
                                            d="M4230 1789c-21,-14 -29,-22 -32,-26 -4,-5 -6,-11 -6,-19 0,-9 2,-16 6,-21 4,-5 10,-7 20,-7 10,0 17,3 22,10 6,8 9,19 10,34l1 11 67 -5 0 -10c-2,-35 -11,-64 -27,-86 -17,-23 -42,-34 -72,-34 -31,0 -54,12 -71,35 -16,22 -23,50 -23,82 0,19 3,35 8,50 5,15 13,27 22,36 9,9 22,19 41,32 22,15 29,22 31,24 4,6 6,12 6,21 0,10 -3,18 -8,25 -5,6 -13,9 -26,9 -20,0 -27,-8 -30,-14 -2,-4 -5,-14 -6,-41l0 -11 -67 5 0 10c0,25 3,48 9,68 7,21 19,37 35,49 17,12 36,18 59,18 33,0 59,-13 77,-39 18,-24 27,-54 27,-88 0,-28 -6,-51 -18,-70 -8,-13 -26,-28 -54,-47z" />
                                    </g>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <link href="https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/keen-slider.min.css" rel="stylesheet" />

            <script type="module">
                import KeenSlider from 'https://cdn.jsdelivr.net/npm/keen-slider@6.8.6/+esm'

                const keenSlider = new KeenSlider(
                    '#keen-slider', {
                        loop: true,
                        slides: {
                            origin: 'center',
                            perView: 1.25,
                            spacing: 16,
                        },
                        breakpoints: {
                            '(min-width: 1024px)': {
                                slides: {
                                    origin: 'auto',
                                    perView: 1.5,
                                    spacing: 32,
                                },
                            },
                        },
                    },
                    []
                )

                const keenSliderPrevious = document.getElementById('keen-slider-previous')
                const keenSliderNext = document.getElementById('keen-slider-next')

                const keenSliderPreviousDesktop = document.getElementById('keen-slider-previous-desktop')
                const keenSliderNextDesktop = document.getElementById('keen-slider-next-desktop')

                keenSliderPrevious.addEventListener('click', () => keenSlider.prev())
                keenSliderNext.addEventListener('click', () => keenSlider.next())

                keenSliderPreviousDesktop.addEventListener('click', () => keenSlider.prev())
                keenSliderNextDesktop.addEventListener('click', () => keenSlider.next())
            </script>

            <section class="bg-gray-50">
                <div class="mx-auto max-w-[1340px] px-4 py-12 sm:px-6 lg:me-0 lg:py-16 lg:pe-0 lg:ps-8 xl:py-24">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:items-center lg:gap-16">
                        <div class="max-w-xl text-center ltr:sm:text-left rtl:sm:text-right">
                            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                Coba dengarkan apa kata pembeli kami...
                            </h2>

                            <p class="mt-4 text-gray-700">
                                Testimoni pembeli dengan kepuasan terbaik!
                            </p>

                            <div class="hidden lg:mt-8 lg:flex lg:gap-4 sm:ml-32">
                                <button aria-label="Previous slide" id="keen-slider-previous-desktop"
                                    class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5 rtl:rotate-180">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 19.5L8.25 12l7.5-7.5" />
                                    </svg>
                                </button>

                                <button aria-label="Next slide" id="keen-slider-next-desktop"
                                    class="rounded-full border border-rose-600 p-3 text-rose-600 transition hover:bg-rose-600 hover:text-white">
                                    <svg class="h-5 w-5 rtl:rotate-180" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="-mx-6 lg:col-span-2 lg:mx-0">
                            <div id="keen-slider" class="keen-slider">
                                <div class="keen-slider__slide">
                                    <blockquote
                                        class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12">
                                        <div>
                                            <div class="flex gap-0.5 text-green-500">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </div>

                                            <div class="mt-4">
                                                <p class="mt-4 leading-relaxed text-gray-700">
                                                    Saya kagum dengan wangi wewangian laundry yang saya beli tahan lama!
                                                    Benar-benar tahan 24 jam, sesuai janji. Sangat merekomendasikan produk
                                                    ini karena aromanya segar dan bertahan lama
                                                </p>
                                            </div>
                                        </div>

                                        <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
                                            &mdash; Budi Santoso
                                        </footer>
                                    </blockquote>
                                </div>

                                <div class="keen-slider__slide">
                                    <blockquote
                                        class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12">
                                        <div>
                                            <div class="flex gap-0.5 text-green-500">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </div>

                                            <div class="mt-4">
                                                <p class="mt-4 leading-relaxed text-gray-700">
                                                    Baru-baru ini membeli wewangian cucian, dan saya jatuh cinta dengan
                                                    aroma Signature! Pakaiannya terasa sangat lembut dan bersih tanpa bau
                                                    buatan.
                                                </p>
                                            </div>
                                        </div>

                                        <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
                                            &mdash; Ratna Dewi

                                        </footer>
                                    </blockquote>
                                </div>

                                <div class="keen-slider__slide">
                                    <blockquote
                                        class="flex h-full flex-col justify-between bg-white p-6 shadow-sm sm:p-8 lg:p-12">
                                        <div>
                                            <div class="flex gap-0.5 text-green-500">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>

                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            </div>

                                            <div class="mt-4">

                                                <p class="mt-4 leading-relaxed text-gray-700">
                                                    Sangat puas dengan pewangi laundry ini! Aromanya tahan lama dan membuat
                                                    pakaian terasa segar. Setelah mencuci, wanginya masih terasa hingga
                                                    beberapa hari ke depan. Sangat direkomendasikan
                                                </p>
                                            </div>
                                        </div>

                                        <footer class="mt-4 text-sm font-medium text-gray-700 sm:mt-6">
                                            &mdash; Irfan Setiawan

                                        </footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-center gap-4 lg:hidden">
                        <button aria-label="Previous slide" id="keen-slider-previous"
                            class="rounded-full border border-rose-600 p-4 text-rose-600 transition hover:bg-rose-600 hover:text-white">
                            <svg class="h-5 w-5 -rotate-180 transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </button>

                        <button aria-label="Next slide" id="keen-slider-next"
                            class="rounded-full border border-rose-600 p-4 text-rose-600 transition hover:bg-rose-600 hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    @endvolt
</x-costumer-layout>
