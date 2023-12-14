<?php

use function Livewire\Volt\{computed, usesPagination};
use App\Models\Product;

usesPagination();

$products = computed(fn() => Product::latest()->paginate(10));

$destroy = function (product $product) {
    Storage::delete($product->image);
    $product->delete();
};
?>

<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Produk Toko') }}
                </h2>
            </x-slot>
            <div class="max-w-7xl mx-auto pt-5 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div>
                        <a class="btn btn-neutral" href="/admin/products/store" wire:navigate>
                            Tambah Produk
                        </a>
                    </div>
                    <div class="overflow-x-auto border mt-4 rounded">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah / Stok</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->products as $no => $product)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>
                                            <div class="avatar">
                                                <div class="w-16 rounded-full">
                                                    <img src="{{ Storage::url($product->image) }}" />
                                                </div>
                                            </div>
                                        </th>
                                        <th>{{ $product->title }}</th>
                                        <th>{{ $product->price }}</th>
                                        <th>{{ $product->quantity }}</th>
                                        <th>
                                            <div class="join">
                                                <a href="products/{{ $product->id }}" wire:navigate.hover
                                                    class="btn join-item btn-outline btn-sm">
                                                    {{ __('Edit') }}
                                                </a>

                                                <button wire:confirm.prompt="Are you sure?\n\nType delete to confirm|delete"
                                                    wire:loading.attr='disabled' wire:click='destroy({{ $product->id }})'
                                                    class="btn join-item btn-outline btn-sm">
                                                    {{ __('Hapus') }}
                                                </button>
                                            </div>

                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $this->products->links() }}
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
