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
    <x-slot name="title">Katalog Produk</x-slot>
    @volt
        <div>
            <!-- Category Top Banner -->
            <section class="pt-5">
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 id="font-custom" class="display-2 fw-bold">
                                Katalog Produk
                            </h2>
                        </div>
                        <div class="col-lg-6 mt-4 mt-lg-0 align-content-center">
                            <p>
                                Jelajahi katalog kami dan temukan produk yang tepat untuk pernikahan kamu. Jika kamu memiliki pertanyaan, jangan ragu untuk menghubungi tim kami.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="mb-4 row">
                            <label for="inputsearch" class="col-sm-2 col-form-label">Kata Kunci</label>
                            <div class="col-sm-10">
                                <input wire:model.live="search" type="search" class="form-control" id="inputsearch">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <select wire:model.live="category_id" class="form-select" name="category_id"
                                    id="">
                                    <option selected value="">Kategori Produk</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ Str::limit($category->name, 35, '...') }}
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Category Top Banner -->
            <div class="properties section mt-0">
                <div class="container">
                    <div class="row">
                        @foreach ($this->products as $product)
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
        </div>
    @endvolt
    </x-costumer-layout>
