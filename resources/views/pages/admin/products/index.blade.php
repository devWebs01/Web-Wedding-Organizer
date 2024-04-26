<?php

use function Livewire\Volt\{computed, usesPagination, state};
use App\Models\Product;
use function Laravel\Folio\name;

name('products.index');

state(['search'])->url();
usesPagination();

$products = computed(function () {
    if ($this->search == null) {
        return Product::query()->paginate(10);
    } else {
        return Product::query()
            ->where('title', 'LIKE', "%{$this->search}%")
            ->orWhere('price', 'LIKE', "%{$this->search}%")
            ->orWhere('quantity', 'LIKE', "%{$this->search}%")
            ->paginate(10);
    }
});

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
            <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                <div class="mb-4 flex space-x-4 p-2 bg-white rounded-lg shadow-md justify-between">
                    <a class="btn btn-neutral shadow-lg" href="/admin/products/store" wire:navigate>
                        Tambah Produk
                    </a>
                    <label class="form-control w-full max-w-xs">
                        <input wire:model.live="search" type="search" placeholder="Input Pencarian"
                            class="input input-bordered w-full max-w-xs" />
                    </label>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden  shadow-md border-l-4 border-black rounded-lg p-4">
                    <div class="overflow-x-auto">
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
                                        <th>{{ 'Rp.' . Number::format($product->price, locale: 'id') }}</th>
                                        <th>{{ $product->quantity }}</th>
                                        <th>
                                            <div class="join">
                                                <a href="products/{{ $product->id }}" wire:navigate.hover
                                                    class="btn join-item btn-outline btn-sm">
                                                    {{ __('Edit') }}
                                                </a>

                                                <button
                                                    wire:confirm.prompt="Yakin Ingin Menghapus?\n\nTulis 'Hapus' untuk konfirmasi!|Hapus"
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
