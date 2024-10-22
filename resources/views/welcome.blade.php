<?php

use function Livewire\Volt\{state, computed};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;

name('welcome');

state([
    'products' => fn() => Product::latest()->limit(6)->get(),
]);

?>

<x-guest-layout>
    <x-slot name="title">Selamat Datang</x-slot>
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

            <div class="container my-5">
                <img src="./hero/modal-image.png" class="img-fluid rounded" alt="hero page" />
            </div>

            <section class="py-5">
                <div class="container">
                    <div class="row">
                        <span class="text-muted">Cerita Kami</span>
                        <h2 class="display-5 fw-bold">Tentang Kita</h2>
                        <div class="col-md-5">
                            <p class="lead">
                                Kami adalah tim wedding organizer yang berkomitmen untuk membuat hari istimewa kamu menjadi
                                tak terlupakan. 
                            </p>
                        </div>
                        <div class="col-md-6 offset-md-1">

                            <p class="lead mb-0">
                                Dengan pengalaman bertahun-tahun, kami mewujudkan visi unik setiap pasangan sambil mengurangi stres dan memberikan pengalaman menyenangkan.
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
                                        <a class="btn btn-dark"
                                            href="{{ route('product-detail', ['product' => $product->id]) }}">Lihat</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <section class="container py-5 my-md-5 bg-custom-secondary rounded">
                <div class="row justify-content-center text-center text-white py-4">
                    <div class="col-lg-8">
                        <span>Daftar Sekarang</span>
                        <h2 id="font-custom" class="display-5 fw-bold my-2">Mulai Hari Ini Juga!</h2>
                        <p class="lead text-white">Ceritakan sedikit tentang kamu dan rencana pernikahan kamu agar
                            kami dapat memberikan rekomendasi vendor dan konten yang lebih baik.</p>
                        <div class=" mt-5 d-grid col-3 mx-auto">
                            <a class="btn btn-dark text-uppercase " href="{{ route('login') }}" type="submit">Daftar</a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    @endvolt
</x-guest-layout>
