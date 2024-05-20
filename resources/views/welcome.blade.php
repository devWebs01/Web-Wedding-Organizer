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

            <section class="my-lg-9 py-5">
                <div class="container">
                    <div class="row flex-row-reverse align-items-center ">
                        <div class="col-lg-8">
                            <div class="image-holder text-end">
                                <img src="https://demo.templatesjungle.com/serene/images/banner-image1.png" alt="banner"
                                    class="img-fluid ">
                            </div>
                        </div>
                        <div class="col-lg-4 mt-5 mt-lg-0">
                            <div class="banner-content ">
                                <h6 class="sub-heading">Beauty products</h6>
                                <h2 id="font-custom" class="display-3 fw-semibold my-2 my-lg-3">Perawatan kulit mudah &
                                    terjangkau.
                                </h2>
                                <p class="fs-5">Feugiat tellus metus lacus vulputate sed nec, feugiat at. Ac ultrices
                                    facilisis suspendisse
                                    nec sagittis, mauris quisque pellentesque tincidunt. </p>
                                <a href="shop.html" class="btn btn-outline-dark text-uppercase mt-4 mt-lg-5">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="my-5">
                <div class="container-lg">
                    <div class="row align-items-center ">
                        <div class="col-lg-6">
                            <div class="image-holder">
                                <img src="https://demo.templatesjungle.com/serene/images/banner-image2.png" alt="banner"
                                    class="img-fluid ">
                            </div>
                        </div>
                        <div class="col-lg-6 mt-5 mt-lg-0">
                            <div class="banner-content ">
                                <ul class="nav nav-tabs d-block border-0" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border-0 text-start p-0" id="safe-tab" data-bs-toggle="tab"
                                            data-bs-target="#safe-tab-pane" type="button" role="tab"
                                            aria-controls="safe-tab-pane" aria-selected="true">
                                            <h6 class="sub-heading m-0">01</h6>
                                            <h2 id="font-custom" class="display-3 hover fw-semibold mb-5 ">100% Aman</h2>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border-0 text-start p-0" id="natural-tab"
                                            data-bs-toggle="tab" data-bs-target="#natural-tab-pane" type="button"
                                            role="tab" aria-controls="natural-tab-pane" aria-selected="false"
                                            tabindex="-1">
                                            <h6 class="sub-heading m-0">02</h6>
                                            <h2 id="font-custom" class="display-3 hover fw-semibold mb-5">Natural</h2>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border-0 text-start p-0 rounded" id="organic-tab"
                                            data-bs-toggle="tab" data-bs-target="#organic-tab-pane" type="button"
                                            role="tab" aria-controls="organic-tab-pane" aria-selected="false"
                                            tabindex="-1">
                                            <h6 class="sub-heading m-0">03</h6>
                                            <h2 id="font-custom" class="hover display-3 fw-semibold mb-5">Organik</h2>
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="safe-tab-pane" role="tabpanel"
                                        aria-labelledby="safe-tab" tabindex="0">
                                        <p class="fs-5">Dolor sit amet consectetur adipisicing elit. Accusamus, deserunt
                                            officiis? Adipisci
                                            blanditiis pariatur necessitatibus cumque voluptas vitae non aspernatur,
                                            delectus odio in illum
                                            tenetur ut maxime et itaque dolore.</p>
                                    </div>
                                    <div class="tab-pane fade" id="natural-tab-pane" role="tabpanel"
                                        aria-labelledby="natural-tab" tabindex="0">
                                        <p class="fs-3">Ipsum, dolor sit amet consectetur adipisicing elit. Velit repellat
                                            nulla corrupti
                                            asperiores earum, ipsum at maxime esse? In fugit, quis est at repudiandae
                                            obcaecati eius magni
                                            doloribus a aliquid?</p>
                                    </div>
                                    <div class="tab-pane fade" id="organic-tab-pane" role="tabpanel"
                                        aria-labelledby="organic-tab" tabindex="0">
                                        <p class="fs-3">Sit amet consectetur, adipisicing elit. Praesentium ipsum sint
                                            necessitatibus odit
                                            consequatur sunt deleniti asperiores? Beatae dolorem, aut doloribus magni autem
                                            fugiat labore,
                                            doloremque, facere consequuntur vitae ut?</p>
                                    </div>

                                </div>

                                <a href="about.html" class="btn btn-outline-dark text-uppercase mt-5">Learn More</a>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="container pt-5">
                <div class="row align-items-center my-lg-9">
                    <div class="col-lg-6">
                        <div class="banner-content ">
                            <h6>Populer Sekarang</h6>
                            <h2 id="font-custom" class="display-3 fw-semibold my-2 my-lg-3">Produk Perawatan Kulit
                                Terpopuler
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <p class="fs-5">Feugiat tellus metus lacus vulputate sed nec, feugiat at. Ac ultrices facilisis
                            suspendisse
                            nec sagittis, mauris quisque pellentesque tincidunt. </p>
                        <a href="shop.html" class="btn btn-outline-dark text-uppercase mt-4 mt-lg-5">View all Products</a>
                    </div>
                </div>
                <hr>
            </div>

            <div class="properties section mt-5">
                <div class="container">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6">
                                <div class="item bg-body border rounded-top-circle">
                                    <a href="{{ route('product-detail', ['product' => $product->id]) }}"><img
                                            src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                            class="object-fit-cover rounded-top-circle"
                                            style="width: 100%; height: 300px;"></a>
                                    <span class="category">
                                        {{ Str::limit($product->category->name, 13, '...') }}
                                    </span>
                                    <h6>
                                        {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                                    </h6>
                                    <h4>
                                        <a href="{{ route('product-detail', ['product' => $product->id]) }}">
                                            {{ Str::limit($product->title, 50, '...') }}
                                        </a>
                                    </h4>
                                    <div class="main-button">
                                        <a href="{{ route('product-detail', ['product' => $product->id]) }}">Beli
                                            Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="section best-deal">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="section-heading">
                                <h6>| Best Deal</h6>
                                <h2>Find Your Best Deal Right Now!</h2>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="tabs-content">
                                <div class="row">
                                    <div class="nav-wrapper ">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="appartment-tab" data-bs-toggle="tab"
                                                    data-bs-target="#appartment" type="button" role="tab"
                                                    aria-controls="appartment" aria-selected="true">Appartment</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="villa-tab" data-bs-toggle="tab"
                                                    data-bs-target="#villa" type="button" role="tab"
                                                    aria-controls="villa" aria-selected="false" tabindex="-1">Villa
                                                    House</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="penthouse-tab" data-bs-toggle="tab"
                                                    data-bs-target="#penthouse" type="button" role="tab"
                                                    aria-controls="penthouse" aria-selected="false"
                                                    tabindex="-1">Penthouse</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="appartment" role="tabpanel"
                                            aria-labelledby="appartment-tab">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="info-table">
                                                        <ul>
                                                            <li>Total Flat Space <span>185 m2</span></li>
                                                            <li>Floor number <span>26th</span></li>
                                                            <li>Number of rooms <span>4</span></li>
                                                            <li>Parking Available <span>Yes</span></li>
                                                            <li>Payment Process <span>Bank</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <img src="/guest/images/deal-01.jpg" alt="">
                                                </div>
                                                <div class="col-lg-3">
                                                    <h4>Extra Info About Property</h4>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod
                                                        tempor pack incididunt ut labore et dolore magna aliqua quised ipsum
                                                        suspendisse.
                                                        <br><br>When you need free CSS templates, you can simply type
                                                        TemplateMo in any search engine website. In addition, you can type
                                                        TemplateMo Portfolio, TemplateMo One Page Layouts, etc.
                                                    </p>
                                                    <div class="icon-button">
                                                        <a href="property-details.html"><i class="fa fa-calendar"></i>
                                                            Schedule a visit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="villa" role="tabpanel"
                                            aria-labelledby="villa-tab">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="info-table">
                                                        <ul>
                                                            <li>Total Flat Space <span>250 m2</span></li>
                                                            <li>Floor number <span>26th</span></li>
                                                            <li>Number of rooms <span>5</span></li>
                                                            <li>Parking Available <span>Yes</span></li>
                                                            <li>Payment Process <span>Bank</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <img src="/guest/images/deal-02.jpg" alt="">
                                                </div>
                                                <div class="col-lg-3">
                                                    <h4>Detail Info About Villa</h4>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod
                                                        tempor pack incididunt ut labore et dolore magna aliqua quised ipsum
                                                        suspendisse. <br><br>Swag fanny pack lyft blog twee. JOMO ethical
                                                        copper mug, succulents typewriter shaman DIY kitsch twee taiyaki
                                                        fixie hella venmo after messenger poutine next level humblebrag swag
                                                        franzen.</p>
                                                    <div class="icon-button">
                                                        <a href="property-details.html"><i class="fa fa-calendar"></i>
                                                            Schedule a visit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="penthouse" role="tabpanel"
                                            aria-labelledby="penthouse-tab">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="info-table">
                                                        <ul>
                                                            <li>Total Flat Space <span>320 m2</span></li>
                                                            <li>Floor number <span>34th</span></li>
                                                            <li>Number of rooms <span>6</span></li>
                                                            <li>Parking Available <span>Yes</span></li>
                                                            <li>Payment Process <span>Bank</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <img src="/guest/images/deal-03.jpg" alt="">
                                                </div>
                                                <div class="col-lg-3">
                                                    <h4>Extra Info About Penthouse</h4>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, do eiusmod
                                                        tempor pack incididunt ut labore et dolore magna aliqua quised ipsum
                                                        suspendisse. <br><br>Swag fanny pack lyft blog twee. JOMO ethical
                                                        copper mug, succulents typewriter shaman DIY kitsch twee taiyaki
                                                        fixie hella venmo after messenger poutine next level humblebrag swag
                                                        franzen.</p>
                                                    <div class="icon-button">
                                                        <a href="property-details.html"><i class="fa fa-calendar"></i>
                                                            Schedule a visit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <section class="py-5 my-md-5 border rounded-5">
                    <div class="container">
                        <div class="row justify-content-center text-center text-white py-4">
                            <div class="col-lg-8">
                                <span>Sign Up</span>
                                <h2 class="display-5 fw-bold">Get Started Today</h2>
                                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam feugiat erat
                                    quis pulvinar semper. Cras commodo vitae libero ut consequat</p>
                                <div class="d-grid col-3 mx-auto">
                                    <a class="btn bg-white text-primary" type="submit">Sign up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    @endvolt
</x-guest-layout>
