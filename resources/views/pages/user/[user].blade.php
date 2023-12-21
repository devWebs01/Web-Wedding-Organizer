<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use function Livewire\Volt\state;

state([
    'name' => fn() => auth()->user()->name,
    'email' => fn() => auth()->user()->email,
    'telp' => fn() => auth()->user()->telp,
]);

$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        'telp' => ['required', 'digits_between:11,12', 'numeric', Rule::unique(User::class)->ignore($user->id)],
    ]);

    $user->fill($validated);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    $this->dispatch('profile-updated', name: $user->name);
};

$sendVerification = function () {
    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        $path = session('url.intended', RouteServiceProvider::HOME);

        $this->redirect($path);

        return;
    }

    $user->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};

?>

<x-costumer-layout>
    @volt
        <div>
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium text-gray-900">Pengguna</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                    class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium text-gray-900">Profile Information</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="sm:px-6 lg:px-8">

                <div x-data="{ openTab: 1 }" class="py-8">
                    <div class="mx-auto">
                        <div class="mb-4 flex space-x-4 p-2 bg-white rounded-lg shadow-md">
                            <button x-on:click="openTab = 1" :class="{ 'bg-black text-white': openTab === 1 }"
                                class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Profile
                                Pengguna</button>
                            <button x-on:click="openTab = 2" :class="{ 'bg-black text-white': openTab === 2 }"
                                class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Alamat
                                Pengguna</button>
                        </div>

                        <div x-show="openTab === 1"
                            class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                            <h2 class="text-2xl font-semibold mb-2">Profil Pengguna</h2>
                            <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input wire:model="name" id="name" name="name" type="text"
                                        class="mt-1 block w-full" required autofocus autocomplete="name" />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input wire:model="email" id="email" name="email" type="email"
                                        class="mt-1 block w-full" required autocomplete="username" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                                    @if (auth()->user() instanceof MustVerifyEmail &&
                                            !auth()->user()->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                                {{ __('Your email address is unverified.') }}

                                                <button wire:click.prevent="sendVerification"
                                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <x-input-label for="telp" :value="__('telp')" />
                                    <x-text-input wire:model="telp" id="telp" name="number" type="number"
                                        class="mt-1 block w-full" required autofocus autocomplete="telp" />
                                    <x-input-error class="mt-2" :messages="$errors->get('telp')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                                    <x-action-message wire:loading class="me-3" on="profile-updated">
                                        {{ __('loading...') }}
                                    </x-action-message>

                                    <x-action-message class="me-3" on="profile-updated">
                                        {{ __('Tersimpan!') }}
                                    </x-action-message>
                                </div>
                            </form>
                        </div>

                        <div x-show="openTab === 2"
                            class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                            <h2 class="text-2xl font-semibold mb-2">Alamat
                                Pengguna</h2>
                            @include('pages.user.address')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
