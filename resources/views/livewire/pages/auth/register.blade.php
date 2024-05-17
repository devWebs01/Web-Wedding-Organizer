<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Laravel\Folio\name;

name('register');

layout('layouts.auth-layout');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
    'role' => 'customer',
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);
    $validated['role'] = $this->role;

    event(new Registered(($user = User::create($validated))));

    Auth::login($user);

    $this->redirect(RouteServiceProvider::HOME);
};

?>

<x-slot name="title">
    Register Page
</x-slot>

<div class="row justify-content-center w-100">
    <div class="col-md-8 col-lg-6 col-xxl-3">
        <div class="card mb-0">
            <div class="card-body">

                <p class="text-center">
                    Daftarkan diri Anda untuk memulai belanja di toko kami.
                </p>
                <form wire:submit="register">
                    <input type="hidden" wire:model="role" value="customer">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="form-control" id="name"
                            aria-describedby="nameHelp">
                        @error('name')
                            <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" wire:model="email" class="form-control" id="email"
                            aria-describedby="emailHelp">
                        @error('email')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" wire:model="password" class="form-control" id="password">
                        @error('password')
                            <small id="password" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Ulangi Kata sandi</label>
                        <input type="password" wire:model="password_confirmation" class="form-control"
                            id="password_confirmation">
                        @error('password_confirmation')
                            <small id="password_confirmation" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-2">
                        Daftar
                    </button>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
                        <a class="text-dark fw-bold ms-2" href="{{ route('login') }}">Masuk Sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
