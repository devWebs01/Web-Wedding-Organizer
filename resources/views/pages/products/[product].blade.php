<?php

use function Livewire\Volt\{state, rules, usesFileUploads};
use App\Models\Category;
use App\Models\Product;

usesFileUploads();

state(['product']);

state(['categories' => fn() => Category::get()]);

state(['category_id' => fn() => $this->product->category_id, 'title' => fn() => $this->product->title, 'price' => fn() => $this->product->price, 'quantity' => fn() => $this->product->quantity, 'weight' => fn() => $this->product->weight, 'description' => fn() => $this->product->description]);

state(['image']);

rules(['category_id' => 'required|exists:categories,id', 'title' => 'required|min:5', 'price' => 'required|numeric', 'quantity' => 'required|numeric', 'image' => 'nullable', 'weight' => 'required|numeric', 'description' => 'required|min:10']);

$save = function () {
    $validate = $this->validate();
    if ($this->image) {
        $validate['image'] = $this->image->store('public/images');
        Storage::delete($this->product->image);
    } else {
        $validate['image'] = $this->product->image;
    }
    product::whereId($this->product->id)->update($validate);

    $this->redirect('/products', navigate: true);
};
?>
<x-app-layout>
    <div>
        @volt
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Produk "{{ $product->title }}"
                </h2>
            </x-slot>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form wire:submit="save" class="p-6" enctype="multipart/form-data">

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Kosongkan gambar') }}
                            </h2>

                            <div class="mt-6">
                                <x-input-label for="title" :value="__('Nama Produk')" />
                                <x-text-input wire:loading.attr="disabled" wire:model="title" id="title"
                                    class="block mt-1 w-full" type="text" name="title" autofocus
                                    autocomplete="title" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div class="mt-6">
                                <x-input-label for="price" :value="__('Harga')" />
                                <x-text-input wire:loading.attr="disabled" wire:model="price" id="price"
                                    class="block mt-1 w-full" type="number" name="price" autofocus
                                    autocomplete="price" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div class="mt-6">
                                <x-input-label for="image" :value="__('Gambar')" />
                                <x-file-input wire:loading.attr="disabled" wire:model="image" id="image"
                                    class="block mt-1 w-full" type="file" name="image" autofocus
                                    autocomplete="image" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                            <div class="mt-6">
                                <x-input-label for="quantity" :value="__('Jumlah / Stok')" />
                                <x-text-input wire:loading.attr="disabled" wire:model="quantity" id="quantity"
                                    class="block mt-1 w-full" type="number" name="quantity" autofocus
                                    autocomplete="quantity" />
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
                                <x-text-input wire:loading.attr="disabled" wire:model="weight" id="weight"
                                    class="block mt-1 w-full" type="number" name="weight" autofocus
                                    autocomplete="weight" />
                                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                            </div>
                            <div class="mt-6">
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <x-textarea wire:loading.attr="disabled" wire:model="description" id="description"
                                    class="block mt-1 w-full" type="number" name="description" autofocus
                                    autocomplete="description" />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>


                            <div class="mt-6 flex justify-end">
                                <a class="btn btn-outline hover:btn-ghost" href="/products" wire:navigate>Batal</a>

                                <x-primary-button class="ms-3">
                                    <span wire:loading class="loading loading-spinner"></span>
                                    {{ __('Submit') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            @endvolt
        </div>
</x-app-layout>
