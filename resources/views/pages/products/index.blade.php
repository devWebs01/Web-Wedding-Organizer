<?php

use function Livewire\Volt\{state, rules, computed, usesPagination, usesFileUploads};
use App\Models\Product;
use App\Models\Category;

usesFileUploads();
usesPagination();

state(['categories' => fn() => Category::get()]);
state(['category_id', 'title', 'price', 'quantity', 'image', 'weight', 'description']);

rules(['category_id' => 'required|exists:categories,id', 'title' => 'required|min:5', 'price' => 'required|numeric', 'quantity' => 'required|numeric', 'image' => 'required', 'weight' => 'required|numeric', 'description' => 'required|min:10']);

$products = computed(fn() => product::latest()->paginate(10));

$save = function () {
    $validate = $this->validate();
    $validate['image'] = $this->image->store('public/images');

    product::create($validate);
    $this->reset('category_id', 'title', 'price', 'quantity', 'weight', 'description');

    $this->dispatch('add-new-products');
};

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
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="card mt-5">
                            <div class="card-body">
                                <x-primary-button class="max-w-xs"
                                    x-on:click.prevent="$dispatch('open-modal', 'add-new-products')">
                                    {{ __('Tambah Produk') }}</x-primary-button>
                                @include('pages.products.store')
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="overflow-x-auto border pt-2 rounded">
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
                                                        <a href="products/{{ $product->id }}" wire:navigate.hover
                                                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                            {{ __('edit') }}
                                                        </a>
                                                        <x-danger-button
                                                            wire:confirm.prompt="Are you sure?\n\nType delete to confirm|delete"
                                                            wire:loading.attr='disabled'
                                                            wire:click='destroy({{ $product->id }})' class="mt-5">
                                                            {{ __('Hapus') }}
                                                        </x-danger-button>
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
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
