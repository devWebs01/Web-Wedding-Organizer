<?php

// Mengimpor kelas LoginForm dari namespace App\Livewire\Forms
use App\Livewire\Forms\LoginForm;
// Mengimpor kelas RouteServiceProvider dari namespace App\Providers
use App\Providers\RouteServiceProvider;
// Mengimpor kelas Session dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Session;

// Menggunakan fungsi-fungsi dari Livewire\Volt
use function Livewire\Volt\form;
use function Livewire\Volt\layout;

// Mengatur layout untuk halaman guest menggunakan 'layouts.guest'
layout('layouts.guest');

// Menampilkan formulir login menggunakan kelas LoginForm
form(LoginForm::class);

// Membuat fungsi bernama $login
$login = function () {
    // Memvalidasi input dengan aturan yang telah ditentukan sebelumnya
    $this->validate();

    // Menggunakan metode authenticate dari objek form untuk melakukan proses login
    $this->form->authenticate();

    // Me-generate session yang baru setelah login berhasil
    Session::regenerate();

    // Arahkan pengguna ke halaman yang diinginkan atau halaman utama jika tidak ada yang diinginkan
    $this->redirect(session('url.intended', RouteServiceProvider::HOME), navigate: true);
};

?>


<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('register') }}" wire:navigate>
                {{ __('Yo have not account?') }}
            </a>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
