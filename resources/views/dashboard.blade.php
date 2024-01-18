<?php

use App\Models\Product;
use App\Models\Order;
use App\Models\User;

use function Livewire\Volt\{state};

state([
    'products' => fn() => Product::count(),
    'users' => fn() => User::whereRole('customer')->count(),
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
            <div class="card py-3 justify-center">
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
            </div>
        @endvolt
    </div>
</x-app-layout>
