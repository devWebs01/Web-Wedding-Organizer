<?php

use function Livewire\Volt\{state, rules, computed, usesPagination};
use App\Models\Category;
use function Laravel\Folio\name;

name('categories-product');

state(['name', 'categoryId']);
rules(['name' => 'required|min:6|string']);

usesPagination();

$categories = computed(fn() => Category::latest()->paginate(10));

$save = function (Category $category) {
    $validate = $this->validate();

    if ($this->categoryId == null) {
        $category->create($validate);
    } else {
        $categoryUpdate = Category::find($this->categoryId);
        $categoryUpdate->update($validate);
    }
    $this->reset('name');

    // $this->dispatch('category-stored');
};

$edit = function (Category $category) {
    $category = Category::find($category->id);
    $this->categoryId = $category->id;
    $this->name = $category->name;
};

$destroy = function (Category $category) {
    $category->delete();
    $this->reset('name');
};
?>

<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Kategori Produk') }}
                </h2>
            </x-slot>

            <div>
                <div class="max-w-7xl mx-auto py-5 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-lg shadow-md">
                        <form wire:submit="save"
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-md border-l-4 border-black rounded-lg p-4">
                            <x-input-label for="name" :value="__('Tambah Kategori Produk')" />
                            <x-text-input wire:loading.attr="disabled" wire:model="name" id="name"
                                class="block mt-1 w-full" type="name" name="name" required autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />

                            <div class="flex items-center mt-5 gap-4">
                                <x-primary-button>{{ __('Submit') }}</x-primary-button>

                                <x-action-message wire:loading class="me-3" on="category-stored">
                                    {{ __('loading...') }}
                                </x-action-message>

                                <x-action-message class="me-3" on="category-stored">
                                    {{ __('Saved!') }}
                                </x-action-message>
                        </form>
                    </div>
                </div>
                <div>
                    <div
                        class="overflow-x-auto mt-6 border-l-4 border-black bg-white dark:bg-gray-800 overflow-hidden shadow-md  rounded-lg p-4">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->categories as $no => $category)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>{{ $category->name }}</th>
                                        <th class="join">
                                            <button wire:loading.attr='disabled' wire:click='edit({{ $category->id }})'
                                                class="btn btn-outline btn-sm join-item">
                                                {{ __('Edit') }}
                                            </button>

                                            <button
                                                wire:confirm.prompt="Yakin Ingin Menghapus?\n\nTulis 'Hapus' untuk konfirmasi!|Hapus"
                                                wire:loading.attr='disabled' wire:click='destroy({{ $category->id }})'
                                                class="btn btn-outline btn-sm join-item">
                                                {{ __('Hapus') }}
                                            </button>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $this->categories->links() }}
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
