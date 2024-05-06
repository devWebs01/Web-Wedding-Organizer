<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;

name('catalog-products');

state(['search'])->url();
state(['categories' => fn() => Category::get()]);
state(['category_id' => '']);

$products = computed(function () {
    // Dapatkan semua buku jika tidak ada search dan category
    if (!$this->search && !$this->category_id) {
        return Product::latest()->get();
    }

    // Dapatkan buku berdasarkan search
    elseif ($this->search && !$this->category_id) {
        return Product::where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->get();
    }

    // Dapatkan buku berdasarkan category
    elseif (!$this->search && $this->category_id) {
        return Product::where('category_id', $this->category_id)
            ->latest()
            ->get();
    }

    // Dapatkan buku berdasarkan search dan category
    else {
        return Product::where('title', 'like', '%' . $this->search . '%')
            ->where('category_id', $this->category_id)
            ->latest()
            ->get();
    }
});

?>
<x-guest-layout>
    @volt
        <div>
            <!-- Category Top Banner -->
            <div class="py-10 bg-img-cover bg-overlay-dark position-relative overflow-hidden bg-pos-center-center rounded-0"
                style="background-image: url(/guest/apola_image/thumbnail1.jpg);">
                <div class="container-fluid position-relative z-index-20">
                    <h1 class="fw-bold display-6 mb-4 text-white">APOLA.CO.ID</h1>
                    <div class="col-12 col-md-6">
                        <p class="text-white mb-0 fs-5">
                            Jelajahi beragam pilihan gaya dan tren terbaru dalam mode pakaian kami. Dari koleksi santai yang
                            nyaman hingga pakaian kasual yang stylish, kami memiliki segala yang Anda butuhkan untuk tampil
                            percaya diri dan menarik setiap hari.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Category Top Banner -->

            <div class="container-fluid mb-5">
                <!-- Category Toolbar-->
                <div class="d-flex justify-content-between items-center pt-5 flex-column flex-lg-row">
                    <div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('catalog-products') }}">Katalog</a>
                                </li>
                            </ol>
                        </nav>
                        <h1 class="fw-bold fs-3 mb-2">Menampilkan ({{ $this->products->count() }})</h1>
                    </div>
                    <div class="d-flex justify-content-end align-items-center mt-4 mt-lg-0 flex-column flex-md-row">
                        <x-action-message wire:loading on="search">
                            <span class="spinner-border spinner-border-sm"></span>
                        </x-action-message>
                        <div class="rounded me-md-3 d-flex align-items-center fs-7 lh-1 w-100 mb-2 mb-md-0 w-md-auto">
                            <input wire:model.live="search" type="search" class="form-control rounded rounded-5"
                                name="search" id="search" placeholder="Input pencarian..." />
                        </div>

                        <div class="me-md-3 d-flex align-items-center fs-7 lh-1 w-100 mb-2 mb-md-0 w-md-auto">
                            <select class="form-select rounded rounded-5" name="" id=""
                                wire:model.live="category_id">
                                <option selected value="">Kategori Produk</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ Str::limit($category->name, 35, '...') }}
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div> <!-- /Category Toolbar-->

                <!-- Products-->
                <div class="row g-4">
                    @if ($this->products->isNotEmpty())
                        @foreach ($this->products as $product)
                            <div class="col-12 col-sm-6 col-lg-4">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 rounded z-index-10" style="object-fit: cover" width="300"
                                                height="350" title="{{ $product->title }}"
                                                src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <a href="{{ route('product-detail', ['product' => $product->id]) }}"
                                                class="btn btn-quick-add rounded fw-bold fs-4 rouned">
                                                {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <p class="title-small mb-2 text-muted">{{ $product->category->name }}</p>
                                        <h4 class="lead fw-bold">{{ $product->title }}</h4>
                                        <a href="{{ route('product-detail', ['product' => $product->id]) }}"
                                            class="btn btn-psuedo align-self-start">
                                            Beli Sekarang
                                        </a>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                        @endforeach
                    @endif
                </div>
                <!-- / Products-->
            </div>

        </div>
    @endvolt
    </x-costumer-layout>
