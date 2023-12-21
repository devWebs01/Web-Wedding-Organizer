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
            <div class="px-4 mx-auto max-w-7xl">
                <div class="text-center pt-5">
                    <h1
                        class="text-4xl font-extrabold tracking-tight text-gray-900 font-display sm:text-5xl md:text-6xl xl:text-7xl">
                        <span class="block xl:inline">Telusuri Kebutuhan</span>
                        <span class="block text-cool-indigo-600">Produk ATK Anda di Toko Kami</span>
                    </h1>
                    <p class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Telusuri kategori produk kami yang luas, termasuk pensil, pulpen, kertas, dan peralatan kantor
                        lainnya. Temukan produk unggulan kami yang akan memenuhi kebutuhan kantor Anda.
                    </p>
                    <div class="relative max-w-3xl px-4 mx-auto mt-10 sm:px-6">
                        <input wire:model.live="search" type="search" placeholder="Type here"
                            class="input input-bordered w-full max-w-xs mb-3" />

                        <select class="select select-bordered w-full max-w-xs" wire:model.live="category_id">
                            <option value="">Kategori Produk</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ Str::limit($category->name, 35, '...') }}
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <h5 class="text-center font-bold mt-5">
                <span wire:loading class="loading loading-spinner mr-4"></span>
                {{ $search }}
            </h5>

            <div class="max-w-lg px-4 pt-12 mx-auto md:max-w-screen-2xl md:px-6 xl:px-8 2xl:px-12">
                <div data-controller="pagination lazy-loader">
                    <div id="resources"
                        class="grid mx-auto gap-x-6 gap-y-12 md:grid-cols-2 lg:grid-cols-3 xl:gap-x-8 2xl:gap-x-12 2xl:gap-y-16 xl:gap-y-14">
                        @if ($this->products->isNotEmpty())
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
                                                    <a wire:navigate
                                                        class="w-full justify-center inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-2xl shadow-sm text-white transition duration-150 bg-cool-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cool-indigo-500"
                                                        href="/catalog/{{ $product->id }}">View details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex flex-col justify-between flex-1 px-6 pt-6 pb-0">
                                            <div class="flex-1">
                                                <a wire:navigate class="block group" href="/catalog/{{ $product->id }}">
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
            </div>
            <section class="bg-white dark:bg-gray-900">
                <div
                    class="items-center max-w-screen-xl px-4 py-8 mx-auto lg:grid lg:grid-cols-4 lg:gap-16 xl:gap-24 lg:py-24 lg:px-6">
                    <div class="col-span-2 mb-8">
                        <p class="text-lg font-medium text-purple-600 dark:text-purple-500">Trusted Worldwide</p>
                        <h2
                            class="mt-3 mb-4 text-3xl font-extrabold tracking-tight text-gray-900 md:text-3xl dark:text-white">
                            Trusted by over 600 million users and 10,000 teams</h2>
                        <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">Our rigorous security and
                            compliance standards are at the heart of all we do. We work tirelessly to protect you and your
                            customers.</p>
                        <div class="pt-6 mt-6 space-y-4 border-t border-gray-200 dark:border-gray-700">
                            <div>
                                <a href="#"
                                    class="inline-flex items-center text-base font-medium text-purple-600 hover:text-purple-800 dark:text-purple-500 dark:hover:text-purple-700">
                                    Explore Legality Guide
                                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                            <div>
                                <a href="#"
                                    class="inline-flex items-center text-base font-medium text-purple-600 hover:text-purple-800 dark:text-purple-500 dark:hover:text-purple-700">
                                    Visit the Trust Center
                                    <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 space-y-8 md:grid md:grid-cols-2 md:gap-12 md:space-y-0">
                        <div>
                            <svg class="w-10 h-10 mb-2 text-purple-600 md:w-12 md:h-12 dark:text-purple-500"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="mb-2 text-2xl font-bold dark:text-white">99.99% uptime</h3>
                            <p class="font-light text-gray-500 dark:text-gray-400">For Landwind, with zero maintenance
                                downtime</p>
                        </div>
                        <div>
                            <svg class="w-10 h-10 mb-2 text-purple-600 md:w-12 md:h-12 dark:text-purple-500"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                </path>
                            </svg>
                            <h3 class="mb-2 text-2xl font-bold dark:text-white">600M+ Users</h3>
                            <p class="font-light text-gray-500 dark:text-gray-400">Trusted by over 600 milion users around
                                the world</p>
                        </div>
                        <div>
                            <svg class="w-10 h-10 mb-2 text-purple-600 md:w-12 md:h-12 dark:text-purple-500"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="mb-2 text-2xl font-bold dark:text-white">100+ countries</h3>
                            <p class="font-light text-gray-500 dark:text-gray-400">Have used Landwind to create functional
                                websites</p>
                        </div>
                        <div>
                            <svg class="w-10 h-10 mb-2 text-purple-600 md:w-12 md:h-12 dark:text-purple-500"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                </path>
                            </svg>
                            <h3 class="mb-2 text-2xl font-bold dark:text-white">5+ Million</h3>
                            <p class="font-light text-gray-500 dark:text-gray-400">Transactions per day</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endvolt
</x-costumer-layout>
