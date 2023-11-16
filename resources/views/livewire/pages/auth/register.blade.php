<?php

// Mengimpor kelas User dari namespace App\Models
use App\Models\User;
// Mengimpor kelas RouteServiceProvider dari namespace App\Providers
use App\Providers\RouteServiceProvider;
// Mengimpor kelas Registered dari namespace Illuminate\Auth\Events
use Illuminate\Auth\Events\Registered;
// Mengimpor kelas Auth dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Auth;
// Mengimpor kelas Hash dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Hash;
// Mengimpor kelas Password dari namespace Illuminate\Validation\Rules
use Illuminate\Validation\Rules;

// Menggunakan fungsi-fungsi dari Livewire\Volt
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

// Mengatur layout untuk halaman guest menggunakan 'layouts.guest'
layout('layouts.guest');

// Mendefinisikan state (keadaan) dengan beberapa variabel dan memberikan nilai awal kosong
state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => ''
]);

// Mendefinisikan aturan validasi untuk beberapa variabel, termasuk aturan unik untuk email pada model User
rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

// Membuat fungsi bernama $register
$register = function () {
    // Memvalidasi input dengan aturan yang telah ditentukan sebelumnya
    $validated = $this->validate();

    // Mengenkripsi password sebelum menyimpannya ke dalam database
    $validated['password'] = Hash::make($validated['password']);

    // Membuat event Registered dengan user yang baru dibuat
    event(new Registered($user = User::create($validated)));

    // Melakukan login otomatis setelah registrasi
    Auth::login($user);

    // Arahkan pengguna ke halaman utama setelah registrasi
    $this->redirect(RouteServiceProvider::HOME, navigate: true);
};

?>


<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
