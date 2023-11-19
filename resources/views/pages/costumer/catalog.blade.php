<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;

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
<x-costumer-layout>
    @volt
        <div>
            <div style="background:url(https://cdn.livecanvas.com/media/backgrounds/bgjar/WorldMap.svg); background-size: auto; background-position: center center; background-repeat: no-repeat;"
                class="py-6 py-lg-8 container-fluid px-0">
                <div class="container text-center py-6">
                    <div class="row">
                        <div class="col-lg-6 col-xl-5 mx-auto">
                            <div class="mb-3">
                                <div editable="rich">
                                    <h1 class="fw-bold">Join Our Awesome Team</h1>
                                </div>
                            </div>
                            <div class="mb-5">
                                <div editable="rich">
                                    <p class="fw-bold">We are trusted by over 10.000+ clients. Join them by using our
                                        product
                                        and
                                        boost your sales.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between gap-3">
                    <div class="mb-0 me-1">
                        <h1 class="fs-2 mb-1 fw-bolder">Produk Toko</h1>
                        <p class="mb-0">Total {{ $this->products->count() }} produk toko</p>
                    </div>
                    <div class="d-flex justify-content-md-end align-items-center gap-3 flex-wrap">
                        <div class="position-relative row gap-3">
                            <div class="col-md">
                                <select class="form-select form-select-lg rounded-box" wire:model.live="category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ Str::limit($category->name, 35, '...') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md">
                                <input wire:model.live="search" type="search" class="form-control w-100 rounded-box"
                                    aria-describedby="helpId" placeholder="Masukkan judul buku ...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-center fw-bold mt-5">
                <span wire:loading class="text-primary">loading...</span>
                {{ $search }}
                </h5>

                <div class="untree_co-section product-section before-footer-section">
                    <div class="container-fluid">
                        <div class="row">

                            <!-- Start Column -->
                            @foreach ($this->products as $product)
                                <div class="col-12 col-md-4 col-lg-3 mb-5">
                                    <a class="product-item" href="#">
                                        <div class="lc-block border-0 card card-cover overflow-hidden bg-dark rounded-5 shadow-xl"
                                            lc-helper="background"
                                            style="background-image: url({{ Storage::url($product->image) }}); background-size:cover; height:300px;">
                                        </div>
                                        <span
                                            class="text-wrap text-primary fw-bold badge shadow-lg py-4 my-3">{{ $product->category->name }}</span>
                                        <h2 class="fs-5 lh-1 fw-bolder text-truncate mb-3">{{ $product->title }}</h2>
                                        <h2 class="fs-6 lh-1 fw-bold">Rp. {{ $product->price }}</h2>
                                        <span class="icon-cross">
                                            <img src="/assets/images/cross.svg" class="img-fluid">
                                        </span>
                                    </a>
                                </div>
                            @endforeach
                            <!-- End Column -->
                        </div>
                    </div>
                </div>
        </div>
    @endvolt
</x-costumer-layout>
