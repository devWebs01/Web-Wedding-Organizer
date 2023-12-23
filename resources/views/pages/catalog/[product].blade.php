<?php

use function Livewire\Volt\{state, rules};
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;

state(['product' => fn() => Product::find($id)]);
state([
    'user_id' => fn() => Auth()->user()->id,
    'product_id' => fn() => $this->product->id,
    'qty' => 1,
    'randomProduct' => fn() => Product::inRandomOrder()
        ->limit(6)
        ->get(),
]);

rules([
    'user_id' => 'required|exists:users,id',
    'product_id' => 'required|exists:products,id',
    'qty' => 'required|numeric',
]);

$addToCart = function () {
    $existingCart = Cart::where('user_id', $this->user_id)
        ->where('product_id', $this->product_id)
        ->first();

    if ($existingCart) {
        // If the product is already in the cart, update the quantity
        $existingCart->update(['qty' => $existingCart->qty + $this->qty]);
    } else {
        // If the product is not in the cart, add it as a new item
        Cart::create($this->validate());
    }

    $this->dispatch('cart-updated');
};
?>
<x-costumer-layout>
    @volt
        <div>
            <div class="text-justify bg-white">
                <div class="pt-6">
                    <div class="text-sm breadcrumbs">
                        <ul class="px-4 sm:px-6 lg:px-8">
                            <li><a wire:navigate href="/catalog/list">Katalog Produk</a></li>
                            <li><a wire:navigate href="#">Produk</a></li>
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
                                                        Rp. {{ $product->price }}
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
