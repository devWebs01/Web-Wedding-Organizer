<?php

use App\Models\User;
use function Livewire\Volt\{state, rules};

state(['name', 'email', 'password', 'telp']);

rules([
    'name' => 'required|min:5',
    'email' => 'required|min:5|unique:users,email',
    'password' => 'required|min:5',
    'telp' => 'required|unique:users,telp,id|digits_between:11,12',
]);

$save = function () {
    $validateData = $this->validate();
    $validateData['role'] = 'admin';
    User::create($validateData);

    $this->reset('name', 'email', 'password', 'telp');

    $this->redirect('/admin/users', navigate: true);
};

?>
<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Tambah Admin
                </h2>
            </x-slot>
            <form wire:submit="save">
                <div class="card">
                    <div class="card-body">

                        <div class="mt-6">
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input wire:loading.attr="disabled" wire:model="name" id="name"
                                class="block mt-1 w-full" type="text" name="name" autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input wire:loading.attr="disabled" wire:model="email" id="email"
                                class="block mt-1 w-full" type="email" name="email" autofocus autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input wire:loading.attr="disabled" wire:model="password" id="password"
                                class="block mt-1 w-full" type="password" name="password" autofocus
                                autocomplete="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="telp" :value="__('Telp')" />
                            <x-text-input wire:loading.attr="disabled" wire:model="telp" id="telp"
                                class="block mt-1 w-full" type="number" name="telp" autofocus autocomplete="telp" />
                            <x-input-error :messages="$errors->get('telp')" class="mt-2" />
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="btn btn-neutral">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endvolt
</x-app-layout>
