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

            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Tambah Produk Toko') }}
                </h2>
            </x-slot>

            <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                <form wire:submit="save"
                    class="space-y-6 bg-white dark:bg-gray-800 overflow-hidden shadow-md border-l-4 border-black rounded-lg p-4"
                    enctype="multipart/form-data">

                    <div>
                        <x-input-label for="title" :value="__('Nama Produk')" />
                        <x-text-input wire:loading.attr="disabled" wire:model.blur="title" id="title"
                            class="block mt-1 w-full" type="text" name="title" autofocus autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="price" :value="__('Harga')" />
                        <x-text-input wire:loading.attr="disabled" wire:model.blur="price" id="price"
                            class="block mt-1 w-full" type="number" name="price" autofocus autocomplete="price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="image" :value="__('Gambar')" />
                        <x-file-input wire:loading.attr="disabled" wire:model.blur="image" id="image"
                            class="block mt-1 w-full" type="file" name="image" autofocus autocomplete="image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="quantity" :value="__('Jumlah / Stok')" />
                        <x-text-input wire:loading.attr="disabled" wire:model.blur="quantity" id="quantity"
                            class="block mt-1 w-full" type="number" name="quantity" autofocus autocomplete="quantity" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="quantity" :value="__('Kategori Produk')" />
                        <select wire:model.blur='category_id' class="select select-bordered w-full">
                            <option disabled selected>Who shot first?</option>
                            @foreach ($this->categories as $category)
                                <option value="{{ $category->id }}">- {{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="weight" :value="__('Berat Produk')" />
                        <x-text-input wire:loading.attr="disabled" wire:model.blur="weight" id="weight"
                            class="block mt-1 w-full" type="number" name="weight" autofocus autocomplete="weight" />
                        <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <x-textarea wire:loading.attr="disabled" wire:model.blur="description" id="description"
                            class="block mt-1 w-full" type="number" name="description" autofocus
                            autocomplete="description" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a class="btn btn-outline" href="/admin/products">
                            {{ __('Batal') }}
                        </a>

                        <x-primary-button class="ms-3">
                            <span wire:target='save' wire:loading class="loading loading-spinner"></span>
                            {{ __('Submit') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    @endvolt
</x-app-layout>
