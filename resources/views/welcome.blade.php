<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;
use function Laravel\Folio\name;

name('welcome');

state([
    'products' => fn() => Product::latest()->limit(8)->get(),
    'randomProduct' => fn() => Product::inRandomOrder()->limit(6)->get(),
]);

?>

<x-guest-layout>
    @volt
        <div>
            <!-- / Top banner -->
            <section class="vh-75 vh-lg-60 container-fluid rounded overflow-hidden" data-aos="fade-in">
                <!-- Swiper Info -->
                <div class="swiper-container overflow-hidden rounded h-100 bg-light" data-swiper
                    data-options='{
              "spaceBetween": 0,
              "slidesPerView": 1,
              "effect": "fade",
              "speed": 1000,
              "loop": true,
              "parallax": true,
              "observer": true,
              "observeParents": true,
              "lazy": {
                "loadPrevNext": true
                },
                "autoplay": {
                  "delay": 5000,
                  "disableOnInteraction": false
              },
              "pagination": {
                "el": ".swiper-pagination",
                "clickable": true
                }
              }'>
                    <div class="swiper-wrapper">

                        <!-- Slide-->
                        <div class="swiper-slide position-relative h-100 w-100">
                            <div
                                class="w-100 h-100 overflow-hidden position-absolute z-index-1 top-0 start-0 end-0 bottom-0">
                                <div class="w-100 h-100 bg-img-cover bg-pos-center-center overflow-hidden rounded"
                                    data-swiper-parallax="-100"
                                    style=" will-change: transform; background-image: url(/guest/images/banners/banner-1.jpg)">
                                </div>
                            </div>
                            <div
                                class="container position-relative z-index-10 d-flex h-100 align-items-start flex-column justify-content-center">
                                <p class="title-small text-white opacity-75 mb-0" data-swiper-parallax="-100">Everything
                                    You Need</p>
                                <h2 class="display-3 tracking-wide fw-bold text-uppercase tracking-wide text-white"
                                    data-swiper-parallax="100">
                                    <span class="text-outline-light">Summer</span> Essentials
                                </h2>
                                <div data-swiper-parallax-y="-25">
                                    <a href="./category.html" class="btn btn-psuedo text-white" role="button">Shop New
                                        Arrivals</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Slide-->

                        <!-- Slide-->
                        <div class="swiper-slide position-relative h-100 w-100">
                            <div
                                class="w-100 h-100 overflow-hidden position-absolute z-index-1 top-0 start-0 end-0 bottom-0">
                                <div class="w-100 h-100 bg-img-cover bg-pos-center-center overflow-hidden rounded"
                                    data-swiper-parallax="-100"
                                    style=" will-change: transform; background-image: url(/guest/apola_image/banner2.jpg)">
                                </div>
                            </div>
                            <div
                                class="container position-relative z-index-10 d-flex h-100 align-items-start flex-column justify-content-center">
                                <p class="title-small text-white opacity-75 mb-0" data-swiper-parallax="-100">Spring
                                    Collection</p>
                                <h2 class="display-3 tracking-wide fw-bold text-uppercase tracking-wide text-white"
                                    data-swiper-parallax="100">
                                    Adidas <span class="text-outline-light">SS21</span></h2>
                                <div data-swiper-parallax-y="-25">
                                    <a href="./category.html" class="btn btn-psuedo text-white" role="button">Shop
                                        Latest Adidas</a>
                                </div>
                            </div>
                        </div>
                        <!--/Slide-->

                        <!-- Slide-->
                        <div class="swiper-slide position-relative h-100 w-100">
                            <div
                                class="w-100 h-100 overflow-hidden position-absolute z-index-1 top-0 start-0 end-0 bottom-0">
                                <div class="w-100 h-100 bg-img-cover bg-pos-center-center overflow-hidden rounded"
                                    data-swiper-parallax="-100"
                                    style=" will-change: transform; background-image: url(/guest/apola_image/banner1.jpg)">
                                </div>
                            </div>
                            <div
                                class="container position-relative z-index-10 d-flex h-100 align-items-start flex-column justify-content-center">
                                <p class="title-small text-white opacity-75 mb-0" data-swiper-parallax="-100">Just Do it
                                </p>
                                <h2 class="display-3 tracking-wide fw-bold text-uppercase tracking-wide text-white"
                                    data-swiper-parallax="100">
                                    Nike <span class="text-outline-light">SS21</span></h2>
                                <div data-swiper-parallax-y="-25">
                                    <a href="./category.html" class="btn btn-psuedo text-white" role="button">Shop
                                        Latest Nike</a>
                                </div>
                            </div>
                        </div>
                        <!-- /Slide-->

                        <!--Slide-->
                        <div class="swiper-slide position-relative h-100 w-100">
                            <div
                                class="w-100 h-100 overflow-hidden position-absolute z-index-1 top-0 start-0 end-0 bottom-0">
                                <div class="w-100 h-100 bg-img-cover bg-pos-center-center overflow-hidden rounded"
                                    data-swiper-parallax="-100"
                                    style=" will-change: transform; background-image: url(/guest/apola_image/banner3.jpg)">
                                </div>
                            </div>
                            <div
                                class="container position-relative z-index-10 d-flex h-100 align-items-start flex-column justify-content-center">
                                <p class="title-small text-white opacity-75 mb-0" data-swiper-parallax="-100">Look Good
                                    Feel Good</p>
                                <h2 class="display-3 tracking-wide fw-bold text-uppercase tracking-wide text-white"
                                    data-swiper-parallax="100">
                                    <span class="text-outline-light">Sustainable</span> Fashion
                                </h2>
                                <div data-swiper-parallax-y="-25">
                                    <a href="./category.html" class="btn btn-psuedo text-white" role="button">Why We Are
                                        Different</a>
                                </div>
                            </div>
                        </div>
                        <!--/Slide-->

                    </div>

                    <div class="swiper-pagination swiper-pagination-bullet-light"></div>

                </div>
                <!-- / Swiper Info-->
            </section>
            <!--/ Top Banner-->

            <!-- Featured Brands-->
            <div class="brand-section container-fluid" data-aos="fade-in">
                <div class="bg-overlay-sides-white-to-transparent bg-white py-5 py-md-7">
                    <section class="marquee marquee-hover-pause">
                        <div class="marquee-body">
                            <div class="marquee-section animation-marquee-50">
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-1.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-2.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-3.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-4.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-5.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-6.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-7.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-8.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-3 mx-lg-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-9.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                            </div>
                            <div class="marquee-section animation-marquee-50">
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-1.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-2.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-3.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-4.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-5.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-6.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-7.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-8.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                                <div class="mx-5 f-w-24">
                                    <a class="d-block" href="./category.html">
                                        <picture>
                                            <img class="img-fluid d-table mx-auto" src="/guest/images/logos/logo-9.svg"
                                                alt="">
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!--/ Featured Brands-->

            <div class="container-fluid">

                <!-- Featured Categories-->
                <div class="m-0">
                    <!-- Swiper Latest -->
                    @livewire('welcome.featured-products')
                    <!-- / Swiper Latest--> <!-- SVG Used for Clipath on featured images above-->
                    <svg width="0" height="0">
                        <defs>
                            <clipPath id="svg-slanted-one" clipPathUnits="objectBoundingBox">
                                <path
                                    d="M0.822,1 H0.016 a0.015,0.015,0,0,1,-0.016,-0.015 L0.158,0.015 A0.016,0.015,0,0,1,0.173,0 L0.984,0 a0.016,0.015,0,0,1,0.016,0.015 L0.837,0.985 A0.016,0.015,0,0,1,0.822,1">
                                </path>
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <!-- /Featured Categories-->

                <!-- Homepage Intro-->
                <div class="position-relative row my-lg-7 pt-5 pt-lg-0 g-8">
                    <div class="bg-text bottom-0 start-0 end-0" data-aos="fade-up">
                        <h2 class="bg-text-title opacity-10"><span class="text-outline-dark">Old</span>Skool</h2>
                    </div>
                    <div class="col-12 col-md-6 position-relative z-index-20 mb-7 mb-lg-0" data-aos="fade-right">
                        <p class="text-muted title-small">Welcome</p>
                        <h3 class="display-3 fw-bold mb-5"><span class="text-outline-dark">APOLA.CO.ID</span> - streetwear
                            &
                            footwear specialists</h3>
                        <p class="lead">We are APOLA.CO.ID, a leading supplier of global streetwear brands, including
                            names
                            such as <a href="./category.html">Stussy</a>, <a href="./category.html">Carhartt</a>, <a
                                href="./category.html">Gramicci</a>, <a href="./category.html">Afends</a> and many more.
                        </p>
                        <p class="lead">With worldwide shipping and unbeatable prices - now's a great time to pick out
                            something from our range.</p>
                        <a href="./category.html" class="btn btn-psuedo" role="button">Shop New Arrivals</a>
                    </div>
                    <div class="col-12 col-md-6 position-relative z-index-20 pe-0" data-aos="fade-left">
                        <picture class="w-50 d-block position-relative z-index-10 border border-white border-4 shadow-lg">
                            <img class="img-fluid" src="/guest/apola_image/thumbnail1.jpg"
                                alt="HTML Bootstrap Template by Pixel Rocket">
                        </picture>
                        <picture
                            class="w-60 d-block me-8 mt-n10 shadow-lg border border-white border-4 position-relative z-index-20 ms-auto">
                            <img class="img-fluid" src="/guest/apola_image/thumbnail2.jpg"
                                alt="HTML Bootstrap Template by Pixel Rocket">
                        </picture>
                        <picture
                            class="w-50 d-block me-8 mt-n7 shadow-lg border border-white border-4 position-absolute top-0 end-0 z-index-0 ">
                            <img class="img-fluid" src="/guest/apola_image/thumbnail3.jpg"
                                alt="HTML Bootstrap Template by Pixel Rocket">
                        </picture>
                    </div>
                </div>
                <!-- / Homepage Intro-->

                <!-- Instagram-->
                <!-- Swiper Instagram -->
                <div data-aos="fade-in">
                    <h3 class="title-small text-muted text-center mb-3 mt-5"><i
                            class="ri-instagram-line align-bottom"></i>
                        #APOLA.CO.ID
                    </h3>
                    <div class="overflow-hidden">
                        <div class="swiper-container swiper-overflow-visible" data-swiper
                            data-options='{
                    "spaceBetween": 20,
                    "loop": true,
                    "autoplay": {
                      "delay": 5000,
                      "disableOnInteraction": false
                    },
                    "breakpoints": {
                      "400": {
                        "slidesPerView": 2
                      },
                      "600": {
                        "slidesPerView": 3
                      },
                      "999": {
                        "slidesPerView": 5
                      },
                      "1024": {
                        "slidesPerView": 6
                      }
                    }
                  }'>
                            <div class="swiper-wrapper mb-5">

                                <!-- Start of instagram slideshow loop for items-->
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model1/image1.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model2/image2.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model3/image3.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model1/image4.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model2/image1.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model3/image3.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model2/image2.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <div class="swiper-slide flex-column">
                                    <picture>
                                        <img class="rounded shadow-sm img-fluid" data-zoomable
                                            src="/guest/apola_image/model3/image2.jpg" title="image" alt="images">
                                    </picture>
                                </div>
                                <!-- / end of items loop-->

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Swiper Instagram-->
                <!-- / Instagram-->

            </div>
        </div>
    @endvolt
</x-guest-layout>
