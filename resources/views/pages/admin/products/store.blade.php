<?php

use function Livewire\Volt\{state, rules, usesFileUploads};

use App\Models\Product;
use App\Models\Category;

usesFileUploads();

state(['categories' => fn() => Category::get()]);

state(['category_id', 'title', 'price', 'quantity', 'image', 'weight', 'description']);

rules(['category_id' => 'required|exists:categories,id', 'title' => 'required|min:5', 'price' => 'required|numeric', 'quantity' => 'required|numeric', 'image' => 'required', 'weight' => 'required|numeric', 'description' => 'required|min:10']);

$save = function () {
    $validate = $this->validate();
    $validate['image'] = $this->image->store('public/images');

    Product::create($validate);
    $this->reset('category_id', 'title', 'price', 'quantity', 'weight', 'description');

    $this->redirect('/admin/products', navigate: true);
};
?>
<x-app-layout>
    @volt
        <div>
            {{-- <x-modal name="add-new-products" :show="$errors->isNotEmpty()" focusable> --}}
            <form wire:submit="save" class="p-6" enctype="multipart/form-data">

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Tambah produk baru !') }}
                </h2>

                <div class="mt-6">
                    <x-input-label for="title" :value="__('Nama Produk')" />
                    <x-text-input wire:loading.attr="disabled" wire:model="title" id="title" class="block mt-1 w-full"
                        type="text" name="title" autofocus autocomplete="title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <x-input-label for="price" :value="__('Harga')" />
                    <x-text-input wire:loading.attr="disabled" wire:model="price" id="price" class="block mt-1 w-full"
                        type="number" name="price" autofocus autocomplete="price" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <x-input-label for="image" :value="__('Gambar')" />
                    <x-file-input wire:loading.attr="disabled" wire:model="image" id="image" class="block mt-1 w-full"
                        type="file" name="image" autofocus autocomplete="image" />
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <x-input-label for="quantity" :value="__('Jumlah / Stok')" />
                    <x-text-input wire:loading.attr="disabled" wire:model="quantity" id="quantity"
                        class="block mt-1 w-full" type="number" name="quantity" autofocus autocomplete="quantity" />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <x-input-label for="quantity" :value="__('Kategori Produk')" />
                    <select wire:model='category_id' class="select select-bordered w-full">
                        <option disabled selected>Who shot first?</option>
                        @foreach ($this->categories as $category)
                            <option value="{{ $category->id }}">- {{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <x-input-label for="weight" :value="__('Berat Produk')" />
                    <x-text-input wire:loading.attr="disabled" wire:model="weight" id="weight" class="block mt-1 w-full"
                        type="number" name="weight" autofocus autocomplete="weight" />
                    <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                </div>
                <div class="mt-6">
                    <x-input-label for="description" :value="__('Deskripsi')" />
                    <x-textarea wire:loading.attr="disabled" wire:model="description" id="description"
                        class="block mt-1 w-full" type="number" name="description" autofocus autocomplete="description" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>


                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3">
                        <span wire:loading class="loading loading-spinner"></span>
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>
            </form>
            {{-- </x-modal> --}}
            <div>
            @endvolt
</x-app-layout>
