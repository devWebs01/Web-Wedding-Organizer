<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;
use function Laravel\Folio\name;

name('login');

layout('layouts.auth-layout');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    if (auth()->user()->role == 'admin') {
        $this->redirect(session('url.intended', RouteServiceProvider::HOME), navigate: true);
    } elseif (auth()->user()->role == 'superadmin') {
        $this->redirect(session('url.intended', RouteServiceProvider::HOME), navigate: true);
    } else {
        $this->redirect('/');
    }
};

?>

<x-slot name="title">
    Login Page
</x-slot>

<div class="row justify-content-center w-100">
    <div class="col-md-8 col-lg-6 col-xxl-3">
        <div class="card mb-0">
            <div class="card-body">
                <p class="text-center">
                    Selamat datang kembali! Masuk ke akun Anda untuk memulai berbelanja.
                </p>
                <form wire:submit="login">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" wire:model="form.email" class="form-control" id="email"
                            aria-describedby="emailHelp">
                        @error('email')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" wire:model="form.password" class="form-control" id="password">
                        @error('password')
                            <small id="password" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input class="form-check-input dark" type="checkbox" wire:model="form.remember"
                                value="" id="flexCheckChecked" checked="">
                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                Ingat saya
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-8 fs-4 mb-4 rounded-2">
                        Masuk
                    </button>
                    <div class="d-flex align-items-center justify-content-center">
                        <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
                        <a class="text-dark fw-bold ms-2" href="{{ route('register') }}">Buat akun</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
