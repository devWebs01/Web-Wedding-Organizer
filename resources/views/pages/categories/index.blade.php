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
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="card mt-5">
                            <div class="card-body">
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
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="overflow-x-auto border pt-2 rounded">
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
                                                    <th>
                                                        <a href="categories/{{ $category->id }}" wire:navigate.hover
                                                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                            {{ __('edit') }}
                                                        </a>
                                                        <x-danger-button
                                                            wire:confirm.prompt="Are you sure?\n\nType delete to confirm|delete"
                                                            wire:loading.attr='disabled'
                                                            wire:click='destroy({{ $category->id }})' class="mt-5">
                                                            {{ __('Hapus') }}
                                                        </x-danger-button>
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
            </div>
        </div>
    @endvolt
</x-app-layout>
