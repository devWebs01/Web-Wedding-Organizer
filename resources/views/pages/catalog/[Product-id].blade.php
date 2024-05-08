<?php

use function Livewire\Volt\{state, rules};
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use function Laravel\Folio\name;

name('product-detail');

state([
    'user_id' => fn() => Auth()->user()->id ?? '',
    'product_id' => fn() => $this->product->id,
    'randomProduct' => fn() => Product::inRandomOrder()->limit(6)->get(),
    'product' => fn() => Product::find($id),
    'qty' => 1,
]);

rules([
    'user_id' => 'required|exists:users,id',
    'product_id' => 'required|exists:products,id',
    'qty' => 'required|numeric',
]);

$addToCart = function () {
    if (Auth::check() && auth()->user()->role == 'customer') {
        $existingCart = Cart::where('user_id', $this->user_id)
            ->where('product_id', $this->product_id)
            ->first();

        if ($existingCart) {
            $existingCart->update(['qty' => $existingCart->qty + $this->qty]);
        } else {
            Cart::create($this->validate());
        }

        $this->dispatch('cart-updated');
    } else {
        $this->redirectRoute('login');
    }
};
?>
<x-guest-layout>
    @volt
        <div>
            {{-- <div class="text-justify bg-white">
                <div class="pt-6">
                    <div class="text-sm breadcrumbs">
                        <ul class="px-4 sm:px-6 lg:px-8">
                            <li><a href="/catalog/list">Katalog Produk</a></li>
                            <li><a href="#">Produk</a></li>
                        </ul>
                    </div>

                    <!-- Image gallery -->

                    <div
                        class="grid mx-auto mt-4 px-3 sm:px-6 lg:px-8 grid-cols-1 items-start gap-x-6 gap-y-8 sm:grid-cols-12 lg:gap-x-8">
                        <div class="overflow-hidden rounded-lg sm:col-span-4 lg:col-span-5">
                            <img src="{{ Storage::url($product->image) }}"
                                alt="Two each of gray, white, and black shirts arranged on table."
                                class="w-full h-full object-cover object-center">
                        </div>
                        <div class="sm:col-span-8 lg:col-span-7">
                            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl mb-3">
                                {{ $product->title }}
                            </h1>
                            <h1 class="text-xl tracking-tight text-gray-900 mb-3 font-semibold">
                                {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                            </h1>
                            <h3 class="text-sm font-medium text-gray-900">Deskripsi</h3>

                            <div class="space-y-6">
                                <p class="text-base text-gray-900">{{ $product->description }}</p>
                            </div>

                            <div class="my-4">
                                <h3 class="text-sm font-medium text-gray-900">Detail Produk</h3>

                                <div class="mb-4">
                                    <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                        <li class="text-gray-400"><span
                                                class="text-gray-600">{{ $product->category->name }}y</span></li>
                                        <li class="text-gray-400"><span class="text-gray-600">{{ $product->quantity }}
                                                Stok</span></li>
                                        <li class="text-gray-400"><span class="text-gray-600">{{ $product->weight }}
                                                Gram</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <form wire:submit='addToCart'>
                                <div class="flex items-center gap-4">
                                    <button {{ $product->quantity == 0 ? 'disabled' : '' }} class="btn btn-outline">
                                        <span wire:loading class="loading loading-spinner"></span>

                                        {{ $product->quantity == 0 ? 'Tidak Tersedia' : 'Masukkan Keranjang' }}</button>
                                    <x-action-message class="me-3" on="cart-updated">
                                        {{ __('success!') }}
                                    </x-action-message>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="max-w-lg px-4 pt-12 mx-auto md:max-w-screen-2xl md:px-6 xl:px-8 2xl:px-12">
                <div class="flex flex-col w-full">
                    <div class="divider">Mungkin kamu suka!!!</div>
                </div>
                <div data-controller="pagination lazy-loader">
                    <div id="resources"
                        class="grid mx-auto gap-x-6 gap-y-12 md:grid-cols-2 lg:grid-cols-3 xl:gap-x-8 2xl:gap-x-12 2xl:gap-y-16 xl:gap-y-14">
                        @if ($randomProduct->isNotEmpty())
                            @foreach ($randomProduct as $product)
                                <div>
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
                                                    <a class="w-full justify-center inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-2xl shadow-sm text-white transition duration-150 bg-cool-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500"
                                                        href="/catalog/{{ $product->id }}">Lihat Produk</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex flex-col justify-between flex-1 px-6 pt-6 pb-0">
                                            <div class="flex-1">
                                                <a class="block group" href="/catalog/{{ $product->id }}">
                                                    <div class="badge badge-outline">
                                                        {{ Str::limit($product->category->name, 30, '...') }}</div>

                                                    <h5
                                                        class="flex items-center font-bold leading-7 text-gray-900 group-hover:text-cool-indigo-600">
                                                        {{ $product->title }}
                                                    </h5>

                                                    <h5
                                                        class="flex items-center text-xl font-bold leading-7 text-gray-900 group-hover:text-red">
                                                        Rp. {{ Number::format($product->price, locale: 'id') }}
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
            </div> --}}

            <!-- Product Top Section-->
            <div class="row g-9" data-sticky-container>

                <!-- Product Images-->
                <div class="col-12 col-md-6 col-xl-7">
                    <div class="row g-3" data-aos="fade-right">
                        <div class="col-12">
                            <picture>
                                <img class="img-fluid" data-zoomable src="{{ Storage::url($product->image) }}"
                                    alt="HTML Bootstrap Template by Pixel Rocket">
                            </picture>
                        </div>
                        {{-- <div class="col-12">
                            <picture>
                                <img class="img-fluid" data-zoomable src="./assets/images/products/product-page-2.jpeg"
                                    alt="HTML Bootstrap Template by Pixel Rocket">
                            </picture>
                        </div>
                        <div class="col-12">
                            <picture>
                                <img class="img-fluid" data-zoomable src="./assets/images/products/product-page-3.jpeg"
                                    alt="HTML Bootstrap Template by Pixel Rocket">
                            </picture>
                        </div>
                        <div class="col-12">
                            <picture>
                                <img class="img-fluid" data-zoomable src="./assets/images/products/product-page-4.jpeg"
                                    alt="HTML Bootstrap Template by Pixel Rocket">
                            </picture>
                        </div> --}}
                    </div>
                </div>
                <!-- /Product Images-->

                <!-- Product Information-->
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="sticky-top top-5">
                        <div class="pb-3" data-aos="fade-in">

                            <h1 class="mb-1 fs-2 fw-bold">
                                {{ $product->title }}
                            </h1>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="fs-4 m-0">
                                    {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                                </p>
                            </div>

                            <!-- size product -->
                            {{-- <div class="border-top mt-4 mb-3 product-option">
                                <small class="text-uppercase pt-4 d-block fw-bolder">
                                    <span class="text-muted">Available Sizes (Mens)</span> : <span
                                        class="selected-option fw-bold" data-pixr-product-option="size">M</span>
                                </small>
                                <div class="mt-4 d-flex justify-content-start flex-wrap align-items-start">
                                    <div class="form-check-option form-check-rounded">
                                        <input type="radio" name="product-option-sizes" value="S"
                                            id="option-sizes-0">
                                        <label for="option-sizes-0">

                                            <small>S</small>
                                        </label>
                                    </div>
                                    <div class="form-check-option form-check-rounded">
                                        <input type="radio" name="product-option-sizes" value="SM"
                                            id="option-sizes-1">
                                        <label for="option-sizes-1">

                                            <small>SM</small>
                                        </label>
                                    </div>
                                    <div class="form-check-option form-check-rounded">
                                        <input type="radio" name="product-option-sizes" value="M" checked
                                            id="option-sizes-2">
                                        <label for="option-sizes-2">

                                            <small>M</small>
                                        </label>
                                    </div>
                                    <div class="form-check-option form-check-rounded">
                                        <input type="radio" name="product-option-sizes" value="L"
                                            id="option-sizes-3">
                                        <label for="option-sizes-3">

                                            <small>L</small>
                                        </label>
                                    </div>
                                    <div class="form-check-option form-check-rounded">
                                        <input type="radio" name="product-option-sizes" value="Xl"
                                            id="option-sizes-4">
                                        <label for="option-sizes-4">

                                            <small>XL</small>
                                        </label>
                                    </div>
                                    <div class="form-check-option form-check-rounded">
                                        <input type="radio" name="product-option-sizes" value="XXL"
                                            id="option-sizes-5">
                                        <label for="option-sizes-5">

                                            <small>XXL</small>
                                        </label>
                                    </div>
                                </div>
                            </div> --}}
                            <!-- size product -->

                            <!-- variant product -->
                            {{-- <div class="mb-3">
                                <small class="text-uppercase pt-4 d-block fw-bolder text-muted">
                                    Available Designs :
                                </small>
                                <div class="mt-4 d-flex justify-content-start flex-wrap align-items-start">
                                    <picture class="me-2">
                                        <img class="f-w-24 p-2 bg-light border-bottom border-dark border-2 cursor-pointer"
                                            src="./assets/images/products/product-page-thumb-1.jpeg"
                                            alt="HTML Bootstrap Template by Pixel Rocket">
                                    </picture>
                                    <picture>
                                        <img class="f-w-24 p-2 bg-light cursor-pointer"
                                            src="./assets/images/products/product-page-thumb-2.jpeg"
                                            alt="HTML Bootstrap Template by Pixel Rocket">
                                    </picture>
                                </div>
                            </div> --}}
                            <!-- variant product -->
                            <form wire:submit='addToCart'>
                                @csrf
                                <button class="btn btn-dark w-100 mt-4 mb-0 hover-lift-sm hover-boxshadow"
                                    {{ $product->quantity == 0 ? 'disabled' : '' }}>
                                    {{ $product->quantity == 0 ? 'Tidak Tersedia' : 'Masukkan Keranjang' }}
                                </button>
                            </form>


                            <!-- Product Highlights-->
                            <div class="my-5">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="text-center px-2">
                                            <i class="ri-24-hours-line ri-2x"></i>
                                            <small class="d-block mt-1">Next-day Delivery</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="text-center px-2">
                                            <i class="ri-secure-payment-line ri-2x"></i>
                                            <small class="d-block mt-1">Secure Checkout</small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="text-center px-2">
                                            <i class="ri-service-line ri-2x"></i>
                                            <small class="d-block mt-1">Free Returns</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Product Highlights-->

                            <!-- Product Accordion -->
                            <div class="accordion" id="accordionProduct">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Deksripsi
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionProduct">
                                        <div class="accordion-body">
                                            <p class="m-0">
                                                {{ $product->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Detail Produk
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordionProduct">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex border-0 row g-0 px-0">
                                                    <span class="col-4 fw-bolder">
                                                        Kategori
                                                    </span>
                                                    <span class="col-7 offset-1">
                                                        {{ $product->category->name }}
                                                    </span>
                                                </li>
                                                <li class="list-group-item d-flex border-0 row g-0 px-0">
                                                    <span class="col-4 fw-bolder">
                                                        Stok
                                                    </span>
                                                    <span class="col-7 offset-1">
                                                        {{ $product->quantity }}
                                                    </span>
                                                </li>
                                                <li class="list-group-item d-flex border-0 row g-0 px-0">
                                                    <span class="col-4 fw-bolder">
                                                        Berat
                                                    </span>
                                                    <span class="col-7 offset-1">
                                                        {{ $product->weight }}
                                                        Gram
                                                    </span>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Product Accordion-->
                        </div>
                    </div>
                </div>
                <!-- / Product Information-->
            </div>
            <!-- / Product Top Section-->

            <div class="row g-0">

                <!-- Related Products-->
                <div class="col-12" data-aos="fade-up">
                    <h3 class="fs-4 fw-bolder mt-7 mb-4">You May Also Like</h3>
                    <!-- Swiper Latest -->
                    <div class="swiper-container" data-swiper
                        data-options='{
                        "spaceBetween": 10,
                        "loop": true,
                        "autoplay": {
                          "delay": 5000,
                          "disableOnInteraction": false
                        },
                        "navigation": {
                          "nextEl": ".swiper-next",
                          "prevEl": ".swiper-prev"
                        },
                        "breakpoints": {
                          "600": {
                            "slidesPerView": 2
                          },
                          "1024": {
                            "slidesPerView": 3
                          },
                          "1400": {
                            "slidesPerView": 4
                          }
                        }
                      }'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-danger rounded-circle d-block me-1"></span>
                                                Sale</span>
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-1.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Air VaporMax
                                            2021</a>
                                        <small class="text-muted d-block">4 colours, 10 sizes</small>
                                        <p class="mt-2 mb-0 small"><s class="text-muted">$329.99</s> <span
                                                class="text-danger">$198.66</span></p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-success rounded-circle d-block me-1"></span> New
                                                In</span>
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-2.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike ZoomX
                                            Vaporfly</a>
                                        <small class="text-muted d-block">2 colours, 4 sizes</small>
                                        <p class="mt-2 mb-0 small">$275.45</p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-secondary rounded-circle d-block me-1"></span>
                                                Sold Out</span>
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-3.jpg" alt="">
                                        </picture>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Blazer Mid
                                            &#x27;77</a>
                                        <small class="text-muted d-block">5 colours, 6 sizes</small>
                                        <p class="mt-2 mb-0 small text-muted">Sold Out</p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-4.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Air Force
                                            1</a>
                                        <small class="text-muted d-block">6 colours, 9 sizes</small>
                                        <p class="mt-2 mb-0 small">$425.85</p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-danger rounded-circle d-block me-1"></span>
                                                Sale</span>
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-5.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Air Max
                                            90</a>
                                        <small class="text-muted d-block">4 colours, 10 sizes</small>
                                        <p class="mt-2 mb-0 small"><s class="text-muted">$196.99</s> <span
                                                class="text-danger">$98.66</span></p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-danger rounded-circle d-block me-1"></span>
                                                Sale</span>
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-success rounded-circle d-block me-1"></span> New
                                                In</span>
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-6.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Glide
                                            FlyEase</a>
                                        <small class="text-muted d-block">1 colour</small>
                                        <p class="mt-2 mb-0 small"><s class="text-muted">$329.99</s> <span
                                                class="text-danger">$198.66</span></p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-7.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Zoom
                                            Freak</a>
                                        <small class="text-muted d-block">2 colours, 2 sizes</small>
                                        <p class="mt-2 mb-0 small">$444.99</p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-success rounded-circle d-block me-1"></span> New
                                                In</span>
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-8.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Air
                                            Pegasus</a>
                                        <small class="text-muted d-block">3 colours, 10 sizes</small>
                                        <p class="mt-2 mb-0 small">$178.99</p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                            <div class="swiper-slide">
                                <!-- Card Product-->
                                <div
                                    class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                                    <div class="card-img position-relative">
                                        <div class="card-badges">
                                            <span class="badge badge-card"><span
                                                    class="f-w-2 f-h-2 bg-success rounded-circle d-block me-1"></span> New
                                                In</span>
                                        </div>
                                        <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                                class="ri-heart-line"></i></span>
                                        <picture class="position-relative overflow-hidden d-block bg-light">
                                            <img class="w-100 img-fluid position-relative z-index-10" title=""
                                                src="./assets/images/products/product-1.jpg" alt="">
                                        </picture>
                                        <div class="position-absolute start-0 bottom-0 end-0 z-index-20 p-2">
                                            <button class="btn btn-quick-add"><i class="ri-add-line me-2"></i> Quick
                                                Add</button>
                                        </div>
                                    </div>
                                    <div class="card-body px-0">
                                        <a class="text-decoration-none link-cover" href="./product.html">Nike Air
                                            Jordans</a>
                                        <small class="text-muted d-block">3 colours, 10 sizes</small>
                                        <p class="mt-2 mb-0 small">$154.99</p>
                                    </div>
                                </div>
                                <!--/ Card Product-->
                            </div>
                        </div>

                        <!-- Add Arrows -->
                        <div
                            class="swiper-prev top-50  start-0 z-index-30 cursor-pointer transition-all bg-white px-3 py-4 position-absolute z-index-30 top-50 start-0 mt-n8 d-flex justify-content-center align-items-center opacity-50-hover">
                            <i class="ri-arrow-left-s-line ri-lg"></i>
                        </div>
                        <div
                            class="swiper-next top-50 end-0 z-index-30 cursor-pointer transition-all bg-white px-3 py-4 position-absolute z-index-30 top-50 end-0 mt-n8 d-flex justify-content-center align-items-center opacity-50-hover">
                            <i class="ri-arrow-right-s-line ri-lg"></i>
                        </div>


                    </div>
                    <!-- / Swiper Latest-->
                </div>
                <!-- / Related Products-->


            </div>
        </div>
    @endvolt
    </x-costumer-layout>
