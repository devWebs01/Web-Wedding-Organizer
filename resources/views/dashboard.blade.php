<?php

use App\Models\Product;
use App\Models\Order;
use App\Models\User;

use function Livewire\Volt\{state};

state([
    'products' => fn() => Product::count(),
    'customers' => fn() => User::whereRole('customer')->count(),
    'orders' => fn() => Order::count(),
]);

?>
<x-app-layout>
    <div>
        @volt
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </x-slot>
            {{-- <div class="card py-3 justify-center">
                <div class="card-body">
                    <div class="items-center flex-col justify-center flex gap-4  lg:flex-row">
                        <div class="w-full max-w-2xl rounded-lg lg:w-1/3">
                            <div class="bg-neutral rounded-md p-8">
                                <div class="inline-block text-sm text-white font-medium"><span
                                        class="bg-indigo-700 items-center py-1 px-3 inline-flex rounded-full">
                                        Pelanggan</span></div>
                                <div class="mt-4">
                                    <p class="ml-6 text-gray-100 text-xl font-semibold">{{ $users }} Terdaftar
                                        disistem saat ini</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full max-w-2xl rounded-lg lg:w-1/3">
                            <div class="bg-neutral rounded-md p-8">
                                <div class="inline-block text-sm text-white font-medium"><span
                                        class="bg-indigo-500 items-center py-1 px-3 inline-flex rounded-full">Produk
                                        Toko</span>
                                </div>
                                <div class="mt-4">
                                    <p class="ml-6 text-gray-100 text-xl font-semibold">{{ $products }} Terdaftar
                                        disistem saat ini
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full max-w-2xl rounded-lg lg:w-1/3">
                            <div class="bg-neutral rounded-md p-8">
                                <div class="inline-block text-sm text-white font-medium"><span
                                        class="bg-pink-700 items-center py-1 px-3 inline-flex rounded-full">Transaksi</span>
                                </div>
                                <div class="mt-4">
                                    <p class="ml-6 text-gray-100 text-xl font-semibold">{{ $orders }} Terdaftar
                                        disistem saat ini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="px-10 mt-12">
                <div class="mb-12 grid gap-y-10 gap-x-6 md:grid-cols-2 xl:grid-cols-4">
                    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                        <div
                            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-pink-600 to-pink-400 text-white shadow-pink-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                class="w-6 h-6 text-white">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="p-4 text-right">
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                                Pelanggan Hari ini</p>
                            <h4
                                class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                                {{ $customers }}</h4>
                        </div>
                    </div>
                    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                        <div
                            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-green-600 to-green-400 text-white shadow-green-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 512 512" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"
                                stroke="#000000">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <title>product</title>
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="icon" fill="#ffffff" transform="translate(64.000000, 34.346667)">
                                            <path
                                                d="M192,7.10542736e-15 L384,110.851252 L384,332.553755 L192,443.405007 L1.42108547e-14,332.553755 L1.42108547e-14,110.851252 L192,7.10542736e-15 Z M127.999,206.918 L128,357.189 L170.666667,381.824 L170.666667,231.552 L127.999,206.918 Z M42.6666667,157.653333 L42.6666667,307.920144 L85.333,332.555 L85.333,182.286 L42.6666667,157.653333 Z M275.991,97.759 L150.413,170.595 L192,194.605531 L317.866667,121.936377 L275.991,97.759 Z M192,49.267223 L66.1333333,121.936377 L107.795,145.989 L233.374,73.154 L192,49.267223 Z"
                                                id="Combined-Shape"> </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="p-4 text-right">
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                                Produk Toko</p>
                            <h4
                                class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                                {{ $products }}</h4>
                        </div>

                    </div>
                    <div class="relative flex flex-col bg-clip-border rounded-xl bg-white text-gray-700 shadow-md">
                        <div
                            class="bg-clip-border mx-4 rounded-xl overflow-hidden bg-gradient-to-tr from-orange-600 to-orange-400 text-white shadow-orange-500/40 shadow-lg absolute -mt-4 grid h-16 w-16 place-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" class="w-6 h-6 text-white">
                                <path
                                    d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                                </path>
                            </svg>
                        </div>
                        <div class="p-4 text-right">
                            <p class="block antialiased font-sans text-sm leading-normal font-normal text-blue-gray-600">
                                Sales</p>
                            <h4
                                class="block antialiased tracking-normal font-sans text-2xl font-semibold leading-snug text-blue-gray-900">
                                {{ $orders }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endvolt
    </div>
</x-app-layout>
