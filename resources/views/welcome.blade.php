<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;

name('welcome');

state([
    'products' => fn() => Product::latest()->limit(3)->get(),
]);

?>

<x-guest-layout>
    <x-slot name="title">Selamat Datang</x-slot>
    <style>
        .hover {
            --c: #9c9259;
            /* the color */

            color: #0000;
            background:
                linear-gradient(90deg, #fff 50%, var(--c) 0) calc(100% - var(--_p, 0%))/200% 100%,
                linear-gradient(var(--c) 0 0) 0% 100%/var(--_p, 0%) 100% no-repeat;
            -webkit-background-clip: text, padding-box;
            background-clip: text, padding-box;
            transition: 0.5s;
            border-radius: 10px;
        }

        .hover:hover {
            --_p: 100%
        }
    </style>
    @volt
        <div>

            <div class="container pt-5">
                <div class="row align-items-center my-lg-9">
                    <div class="col-lg-6">
                        <div class="banner-content ">
                            <h6>Momen sekali seumur hidup</h6>
                            <h2 id="font-custom" class="display-4 fw-semibold my-2 my-lg-3">
                                Mulailah perjalanan menuju pernikahan yang sempurna
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <p class="fs-5">Pencarian mudah untuk vendor dengan portofolio, harga, dan ulasan dikumpulkan di
                            satu tempat.</p>
                        <a href="{{ route('catalog-products') }}"
                            class="btn btn-outline-dark text-uppercase mt-4 mt-lg-5">Lihat Produk</a>
                    </div>
                </div>
            </div>

            <div class="container my-5 ratio ratio-16x9 border rounded">

                <a data-bs-toggle="modal" data-bs-target="#modalId">
                    <img src="./hero/modal-image.png" alt="">
                </a>

                <!-- Modal -->
                <div class="modal fade" id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content" style="
                        background: transparent;">
                            <div class="modal-body p-0">
                                <i id="close" class="fa-solid fa-x text-white fs-5" data-bs-dismiss="modal"
                                aria-label="Close"></i>
                                <video class="w-100 rounded" muted loop autoplay>
                                    <source src="{{ asset('./hero/modal-video.mp4') }}" type="video/mp4">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    #close {
                        position: absolute;
                        right: -30px;
                        top: 0;
                        z-index: 999;
                        --bs-btn-close-color: white;
                    }
                </style>
            </div>

            <section class="py-5">
                <div class="container">
                    <div class="row">
                        <span class="text-muted">Cerita Kami</span>
                        <h2 class="display-5 fw-bold">Tentang Kita</h2>
                        <div class="col-md-5">
                            <p class="lead">
                                Kami adalah tim wedding organizer yang berkomitmen untuk membuat hari istimewa Anda menjadi
                                tak terlupakan. Dengan pengalaman bertahun-tahun, kami memahami setiap detail yang
                                diperlukan untuk pernikahan yang sempurna.
                            </p>
                        </div>
                        <div class="col-md-6 offset-md-1">

                            <p class="lead mb-0">
                                Kami percaya bahwa setiap pasangan memiliki cerita unik. Tugas kami adalah
                                mewujudkan visi Anda menjadi kenyataan, sambil mengurangi stres dan memberikan pengalaman
                                yang menyenangkan.
                            </p>
                        </div>
                    </div>
                </div>
            </section>


            <div class="properties section mt-5">
                <div class="container">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="card item text-center border-0 p-4" style="height: 610px">

                                    <div class="card-header border-0 m-0 p-0">
                                        <a href="{{ route('product-detail', ['product' => $product->id]) }}">
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                                class="object-fit-cover" style="width: 100%; height: 300px;">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <span class="category">
                                            {{ Str::limit($product->category->name, 25, '...') }}
                                        </span>

                                        <p class="mt-3 mb-0 text-custom fw-bolder">
                                            {{ Str::limit($product->vendor, 30, '...') }}
                                        </p>

                                        <h4 class="my-0">
                                            <a href="{{ route('product-detail', ['product' => $product->id]) }}">
                                                {{ Str::limit($product->title, 30, '...') }}
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="d-grid bg-none border-0">
                                        <a class="btn btn-dark rounded-5"
                                            href="{{ route('product-detail', ['product' => $product->id]) }}">Lihat</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="container">
                <section class="py-5 my-md-5 border rounded-5" style="background-color: #9c9259;">
                    <div class="container">
                        <div class="row justify-content-center text-center text-white py-4">
                            <div class="col-lg-8">
                                <span>Daftar Sekarang</span>
                                <h2 id="font-custom" class="display-5 fw-bold my-2">Mulai Hari Ini Juga!</h2>
                                <p class="lead text-white">Ceritakan sedikit tentang Anda dan rencana pernikahan Anda agar
                                    kami dapat memberikan rekomendasi vendor dan konten yang lebih baik.</p>
                                <div class=" mt-5 d-grid col-3 mx-auto">
                                    <a class="btn btn-dark text-uppercase " href="{{ route('login') }}"
                                        type="submit">Daftar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    @endvolt
</x-guest-layout>
