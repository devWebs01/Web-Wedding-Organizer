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
        <div class="bg-white">
            <div class="px-4 mx-auto max-w-7xl">
                <div class="text-center pt-5">
                    <h1
                        class="text-4xl font-extrabold tracking-tight text-gray-900 font-display sm:text-5xl md:text-6xl xl:text-7xl">
                        <span class="block xl:inline">Discover the best</span>
                        <span class="block text-cool-indigo-600">Tailwind templates &amp; UI kits</span>
                    </h1>
                    <p class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Tailwind Awesome is a curated list of the best Tailwind templates &amp;
                        UI kits in the internet. We are actively searching, and curating the
                        coolest resources out there.
                    </p>
                    <div class="relative max-w-3xl px-4 mx-auto mt-10 sm:px-6">
                        <input wire:model.live="search" type="search" placeholder="Type here"
                            class="input input-bordered w-full max-w-xs" />

                        <select class="select select-bordered w-full max-w-xs" wire:model.live="category_id">
                            <option value="">Kategori Produk</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ Str::limit($category->name, 35, '...') }}
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <h3 class="text-center fw-bold mt-5">
                <span wire:loading class="text-primary">loading...</span>
                {{ $search }}
                </h5>

                <div class="max-w-lg px-4 pt-12 mx-auto md:max-w-screen-2xl md:px-6 xl:px-8 2xl:px-12">
                    <div data-controller="pagination lazy-loader">
                        <div id="resources"
                            class="grid mx-auto gap-x-6 gap-y-12 md:grid-cols-2 lg:grid-cols-3 xl:gap-x-8 2xl:gap-x-12 2xl:gap-y-16 xl:gap-y-14">

                            @foreach ($this->products as $product)
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
                                                        href="/resources/cruip-bundle">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex flex-col justify-between flex-1 px-6 pt-6 pb-0">
                                            <div class="flex-1">
                                                <a class="block group" href="/resources/cruip-bundle">
                                                    <div class="badge badge-outline">
                                                        {{ Str::limit($product->category->name, 30, '...') }}</div>

                                                    <h5
                                                        class="flex items-center font-bold leading-7 text-gray-900 group-hover:text-cool-indigo-600">
                                                        {{ $product->title }}
                                                    </h5>

                                                    <h3
                                                        class="flex items-center text-xl font-bold leading-7 text-gray-900 group-hover:text-red">
                                                        Rp. {{ $product->price }}
                                                    </h3>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <div data-controller="banner" data-banner-id-value="bundle_177"
                                class="relative flex flex-col items-center w-full overflow-hidden isolate md:flex-row bg-slate-50 rounded-3xl md:col-span-2 lg:col-span-3">
                                <svg viewBox="0 0 1024 1024"
                                    class="absolute left-1/2 top-1/2 lg:top-[20%] -z-10 h-[80rem] w-[80rem] -translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] sm:left-full sm:-ml-80 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0"
                                    aria-hidden="true">
                                    <circle cx="512" cy="512" r="512"
                                        fill="url(#759c1415-0410-454c-8f7c-9a820de03641)" fill-opacity="0.7"></circle>
                                    <defs>
                                        <radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
                                            <stop stop-color="#8191d9"></stop>
                                            <stop offset="1" stop-color="#f2f3fc"></stop>
                                        </radialGradient>
                                    </defs>
                                </svg>
                                <div
                                    class="order-2 w-full px-6 py-8 lg:py-16 lg:pl-12 md:w-2/3 lg:order-1 lg:w-5/12 xl:py-20 xl:pl-16 xl:pr-0">
                                    <div
                                        class="py-1 pl-1 pr-2.5 rounded-2xl border border-cool-indigo-100 bg-cool-indigo-50 inline-flex text-cool-indigo-700 font-medium text-xs items-center">
                                        <span
                                            class="flex justify-center items-center bg-white rounded-2xl border border-cool-indigo-100 px-2 py-0.5 mr-2">
                                            Featured
                                        </span>
                                        Limited time offer
                                    </div>
                                    <div class="mt-3.5 space-y-1 lg:mt-6 lg:space-y-5">
                                        <h4
                                            class="text-xl font-semibold text-gray-900 lg:text-4xl lg:leading-tight lg:tracking-tight ">
                                            Get Unlimited Access to Cruip's 18+ Templates for <span
                                                class="inline-flex items-center"><span
                                                    class="text-cool-indigo-600">$89</span> </span>
                                        </h4>
                                        <p class="text-base leading-normal text-gray-600 lg:text-xl">
                                            Unlock a $40 discount on Cruip's All-Access Bundle and get a beautiful
                                            collection of Tailwind CSS templates, fully coded in HTML, React, Next.js, and
                                            Vue.
                                        </p>
                                    </div>
                                    <div class="items-center mt-6 space-x-4 lg:mt-10 md:flex md:flex-1 lg:w-0">
                                        <a class="btn btn-primary btn-small lg:btn-md" target="_blank"
                                            data-action="banner#handleClick" href="https://cruip.com/?ref=tailwindawesome">
                                            Get Bundle
                                            <svg class="w-4.5 h-4.5 ml-2 text-white lg:w-5 lg:h-5"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M21 9L21 3M21 3H15M21 3L13 11M10 5H7.8C6.11984 5 5.27976 5 4.63803 5.32698C4.07354 5.6146 3.6146 6.07354 3.32698 6.63803C3 7.27976 3 8.11984 3 9.8V16.2C3 17.8802 3 18.7202 3.32698 19.362C3.6146 19.9265 4.07354 20.3854 4.63803 20.673C5.27976 21 6.11984 21 7.8 21H14.2C15.8802 21 16.7202 21 17.362 20.673C17.9265 20.3854 18.3854 19.9265 18.673 19.362C19 18.7202 19 17.8802 19 16.2V14"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </svg>

                                        </a>
                                    </div>
                                </div>
                                <div
                                    class="relative order-1 w-full h-full md:w-1/3 lg:order-2 lg:w-7/12 aspect-[2/1] md:aspect-auto">
                                    <picture>
                                        <source
                                            srcset="https://d1w019qw3bn26k.cloudfront.net/assets/cruip-bundle-mockup-103706f36871290292dfe8d2500e2e43caa7dc94327f805996b6d7dc85e8dc97.png"
                                            media="(min-width: 1024px)">
                                        <source srcset="https://d1etqblq65l80m.cloudfront.net/nufte8zsbpjhezaihy9tons5ziq5"
                                            media="(min-width: 768px)">
                                        <img src="https://d1etqblq65l80m.cloudfront.net/nufte8zsbpjhezaihy9tons5ziq5"
                                            alt="{{ $product->title }}" loading="lazy"
                                            class="absolute inset-0 object-cover object-left w-full h-full">
                                    </picture>
                                </div>
                            </div>

                        </div>
                    </div>


                    {{-- <div class="untree_co-section product-section before-footer-section">
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
                </div> --}}
                </div>
            @endvolt
</x-costumer-layout>
