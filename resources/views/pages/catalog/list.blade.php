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
                        <span class="block xl:inline">Dengan berbagai varian aroma</span>
                        <span class="block text-cool-indigo-600">yang menarik</span>
                    </h1>
                    <p class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Produk kami terbuat dari bahan-bahan alami yang aman untuk kulit dan ramah lingkungan. Dapatkan
                        pakaian bersih dan harum dengan pewangi laundry kami.
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
                                                        {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
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

        </div>
    @endvolt
</x-costumer-layout>
