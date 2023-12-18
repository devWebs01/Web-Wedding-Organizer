<?php

use function Livewire\Volt\{state, rules, computed, usesPagination};
use App\Models\Category;

state(['name']);
rules(['name' => 'required|min:6|string']);

usesPagination();

$categories = computed(fn() => Category::latest()->paginate(10));

$save = function () {
    Category::create($this->validate());
    $this->name = '';

    $this->dispatch('category-stored');
};

$destroy = function (Category $category) {
    $category->delete();
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
            
            <div class="max-w-7xl mx-auto pt-5 sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                    <div>
                        <form wire:submit="save">
                            <x-input-label for="name" :value="__('Tambah Kategori Produk')" />
                            <x-text-input wire:loading.attr="disabled" wire:model="name" id="name"
                                class="block mt-1 w-full" type="name" name="name" required autofocus
                                autocomplete="name" />
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
                    <div>
                        <div class="overflow-x-auto border rounded mt-6">
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
                                                <a href="categories/{{ $category->id }}" wire:navigate.hover
                                                    class="btn btn-outline btn-sm join-item">
                                                    {{ __('edit') }}
                                                </a>
                                                <button wire:confirm.prompt="Are you sure?\n\nType delete to confirm|delete"
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

        </div>
    @endvolt
</x-app-layout>
