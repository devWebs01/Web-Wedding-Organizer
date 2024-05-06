<?php

use function Livewire\Volt\{state, rules, computed};
use App\Models\Category;
use App\Models\Product;

state([
    'randomProducts' => fn() => Product::inRandomOrder()->limit(8)->get(),
]);

?>

@volt
    <div>
        <div class="swiper-container overflow-hidden overflow-lg-visible" data-swiper
            data-options='{
    "spaceBetween": 25,
    "slidesPerView": 1,
    "observer": true,
    "observeParents": true,
    "breakpoints": {
      "540": {
        "slidesPerView": 1,
        "spaceBetween": 0
      },
      "770": {
        "slidesPerView": 2
      },
      "1024": {
        "slidesPerView": 3
      },
      "1200": {
        "slidesPerView": 4
      },
      "1500": {
        "slidesPerView": 5
      }
    },
    "navigation": {
      "nextEl": ".swiper-next",
      "prevEl": ".swiper-prev"
    }
  }'>
            <div class="swiper-wrapper">
                @foreach ($randomProducts as $product)
                    <div class="swiper-slide align-self-stretch bg-transparent h-auto">
                        <div class="me-xl-n4 me-xxl-n5" data-aos="fade-up" data-aos-delay="000">
                            <picture class="d-block mb-4 img-clip-shape-one ">
                                <img class="object-fit-cover rounded" width="450" height="450" title=""
                                    src="{{ Storage::url($product->image) }}" alt="HTML Bootstrap Template by Pixel Rocket">
                            </picture>
                            <p class="title-small mb-2 text-muted">{{ $product->category->name }}</p>
                            <h4 class="lead fw-bold">{{ $product->title }}</h4>
                            <a href="{{ route('product-detail', ['product' => $product->id]) }}"
                                class="btn btn-psuedo align-self-start">
                                Beli Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div
                class="swiper-btn swiper-prev swiper-disabled-hide swiper-btn-side btn-icon bg-white text-dark ms-3 shadow mt-n5">
                <i class="ri-arrow-left-s-line "></i>
            </div>
            <div
                class="swiper-btn swiper-next swiper-disabled-hide swiper-btn-side swiper-btn-side-right btn-icon bg-white text-dark me-3 shadow mt-n5">
                <i class="ri-arrow-right-s-line ri-lg"></i>
            </div>

        </div>
    </div>
@endvolt
