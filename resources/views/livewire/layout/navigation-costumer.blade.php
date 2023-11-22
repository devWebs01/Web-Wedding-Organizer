<?php

// Mengimpor kelas Logout dari namespace App\Livewire\Actions
use App\Livewire\Actions\Logout;
use App\Models\Cart;
use function Livewire\Volt\{state, computed, on};

// Di sini kita membuat sebuah fungsi yang disebut $logout
// Fungsi ini akan melakukan logout saat dipanggil
$logout = function (Logout $logout) {
    // Panggil fungsi khusus dalam objek Logout untuk mengeksekusi logout
    $logout();

    // Setelah logout, arahkan pengguna kembali ke halaman utama dengan memberi tahu program untuk melakukan navigasi (bukan hanya memperbarui halaman)
    $this->redirect('/', navigate: true);
};

state([
    'cart' => fn() => Cart::where('user_id', auth()->user()->id)->get(),
    'subTotal' => fn() => Cart::where('user_id', auth()->user()->id)
        ->get()
        ->sum(function ($item) {
            return $item->product->price * $item->qty;
        }),
]);
on([
    'count-updated' => function () {
        $this->cart = Cart::where('user_id', auth()->user()->id)->get();
        $this->subTotal = Cart::where('user_id', auth()->user()->id)
            ->get()
            ->sum(function ($item) {
                return $item->product->price * $item->qty;
            });
    },
]);
?>

<div class="navbar bg-base-100">
    <div class="navbar-start">
        <div class="dropdown">
            <label tabindex="0" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </label>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <a href="/" wire:navigate>Home</a>
                </li>
                <li>
                    <a href="/catalog/list" wire:navigate>Katalog Produk</a>
                </li>
            </ul>
        </div>
        <a class="btn btn-ghost text-xl">daisyUI</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li>
                <a href="/" wire:navigate>Home</a>
            </li>
            <li>
                <a href="/catalog/list" wire:navigate>Katalog Produk</a>
            </li>
        </ul>
    </div>
    <div class="navbar-end">
        @auth
            <div class="flex-none">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="badge badge-sm indicator-item">{{ $this->cart->count() }}</span>
                        </div>
                    </label>
                    <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
                        <div class="card-body">
                            <span class="font-bold text-lg">{{ $this->cart->count() }} Items</span>
                            <span class="text-neutral">Subtotal: Rp. {{ $this->subTotal }}</span>
                            <div class="card-actions">
                                <button class="btn btn-neutral btn-block">View cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img alt="Tailwind CSS Navbar component"
                                src="https://api.dicebear.com/7.x/notionists/svg?seed={{ auth()->user()->name }}" />
                        </div>
                    </label>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li>
                            <a class="justify-between">
                                Profile
                                <span class="badge">New</span>
                            </a>
                        </li>
                        <li><a>Settings</a></li>
                        <li wire:click="logout"><a>Logout</a></li>
                    </ul>
                </div>
            </div>
        @else
            <a href="/login" wire:navigate class="btn mx-2">Login</a>
            <a href="/register" wire:navigate class="btn mx-2">Register</a>
        @endauth
    </div>
</div>
