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
                    <nav aria-label="Breadcrumb">
                        <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                            <li>
                                <div class="flex items-center">
                                    <a href="/catalog/list" wire:navigate
                                        class="mr-2 text-sm font-medium text-gray-900">Katalog Produk</a>
                                    <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                        aria-hidden="true" class="h-5 w-4 text-gray-300">
                                        <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                    </svg>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <a href="#"
                                        class="mr-2 text-sm font-medium text-gray-900">{{ $product->category->name }}</a>
                                </div>
                            </li>
                        </ol>
                    </nav>

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
                                Rp. {{ $product->price }}
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
                                    <button class="btn btn-outline">
                                        <span wire:loading class="loading loading-spinner"></span>

                                        Masukkan Keranjang</button>
                                    <x-action-message class="me-3" on="cart-updated">
                                        {{ __('success!') }}
                                    </x-action-message>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-costumer-layout>
