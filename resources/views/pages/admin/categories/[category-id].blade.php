<?php

use function Livewire\Volt\{state, rules};
use App\Models\Category;

// Dari link category/{id}, dengan membuat variabel (state) dapat menerima parameter category/{id}
state(['category']);
state(['name' => fn() => $this->category->name]);

rules(['name' => 'required|min:6|string']);

$save = function () {
    Category::whereId($this->category->id)->update($this->validate());

    $this->redirect('/admin/categories', navigate: true);
};
?>
<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Kategori Produk
                </h2>
            </x-slot>
            <div class="max-w-7xl mx-auto pt-6 sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                    <div>
                        <form wire:submit='save'>
                            <x-input-label for="name" :value="__('Nama Kategori Produk')" />
                            <x-text-input wire:model="name" id="name" name="name" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />

                            <div class="flex items-center mt-5 gap-4">
                                <x-primary-button>{{ __('Submit') }}</x-primary-button>

                                <x-action-message wire:loading class="me-3" on="category-save">
                                    {{ __('loading...') }}
                                </x-action-message>

                                <x-action-message class="me-3" on="category-save">
                                    {{ __('Saved!') }}
                                </x-action-message>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endvolt
</x-app-layout>
