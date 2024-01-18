<?php

use App\Models\User;
use function Livewire\Volt\{state, rules};
use Illuminate\Validation\Rule;

state(['user', 'name' => fn() => $this->user->name, 'email' => fn() => $this->user->email, 'password', 'telp' => fn() => $this->user->telp]);

$update = function () {
    $user = $this->user;

    $validateData = $this->validate([
        'name' => 'required|min:5',
        'email' => 'required|min:5|' . Rule::unique(User::class)->ignore($user->id),
        'password' => 'min:5|nullable',
        'telp' => 'required|digits_between:11,12|' . Rule::unique(User::class)->ignore($user->id),
    ]);
    $user = $this->user;

    // Jika wire:model password terisi, lakukan update password
    if (!empty($this->password)) {
        $validateData['password'] = bcrypt($this->password);
    } else {
        // Jika wire:model password tidak terisi, gunakan password yang lama
        $validateData['password'] = $user->password;
    }
    $user->update($validateData);

    $this->reset('name', 'email', 'password', 'telp');

    $this->redirect('/admin/users', navigate: true);
};

?>
<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Edit Admin
                </h2>
            </x-slot>
            <div class="card">
                <div class="card-body">
                    <div role="alert" class="alert shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="stroke-warning shrink-0 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold">Peringatan!</h3>
                            <div class="text-xs">Kosongkan
                                <span class="font-bold text-warning">Password</span>
                                jika tidak mengganti password!
                            </div>
                        </div>
                    </div>
                    <form wire:submit="update">
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
                    </form>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
