<?php

use function Livewire\Volt\{computed};
use App\Models\Product;

$products = computed(fn() => Product::latest()
        ->get(),
);

?>

<x-app-layout>
    @volt
    @include('layouts.print')
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Laporan Data Produk Toko') }}
                </h2>
            </x-slot>
            <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden  shadow-md border-l-4 border-black rounded-lg p-4">
                    <div class="overflow-x-auto">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah / Stok</th>
                                    <th>Berat Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->products as $no => $product)
                                    <tr>
                                        <td>{{ ++$no }}</td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ 'Rp. ' . Number::format($product->price, locale: 'id') }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->weight }} gram</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
