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
    'cart' => fn() => Cart::where('user_id', auth()->user()->id ?? null)->get(),
    'subTotal' => fn() => Cart::where('user_id', auth()->user()->id ?? null)
        ->get()
        ->sum(function ($item) {
            return $item->product->price * $item->qty;
        }),
]);
on([
    'cart-updated' => function () {
        $this->cart = Cart::where('user_id', auth()->user()->id ?? null)->get();
        $this->subTotal = Cart::where('user_id', auth()->user()->id ?? null)
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
        <button class="btn btn-ghost text-xl">
            <a wire:navigate href="/"
                class="flex justify-start block text-left sm:text-center lg:text-left sm:justify-center lg:justify-start">
                <span class="flex items-start sm:items-center">
                    <svg class="w-auto h-6 text-gray-800 fill-current" viewBox="0 0 194 116"
                        xmlns="http://www.w3.org/2000/svg">
                        <g fill-rule="evenodd">
                            <path
                                d="M96.869 0L30 116h104l-9.88-17.134H59.64l47.109-81.736zM0 116h19.831L77 17.135 67.088 0z">
                            </path>
                            <path d="M87 68.732l9.926 17.143 29.893-51.59L174.15 116H194L126.817 0z"></path>
                        </g>
                    </svg>
                </span>
            </a>
        </button>
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
            <div class="flex items-center gap-3">
                <a class="btn btn-ghost btn-circle" wire:navigate href="/orders" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" id="cube">
                        <path
                            d="M20.49,7.52a.19.19,0,0,1,0-.08.17.17,0,0,1,0-.07l0-.09-.06-.15,0,0h0l0,0,0,0a.48.48,0,0,0-.09-.11l-.09-.08h0l-.05,0,0,0L16.26,4.45h0l-3.72-2.3A.85.85,0,0,0,12.25,2h-.08a.82.82,0,0,0-.27,0h-.1a1.13,1.13,0,0,0-.33.13L4,6.78l-.09.07-.09.08L3.72,7l-.05.06,0,0-.06.15,0,.09v.06a.69.69,0,0,0,0,.2v8.73a1,1,0,0,0,.47.85l7.5,4.64h0l0,0,.15.06.08,0a.86.86,0,0,0,.52,0l.08,0,.15-.06,0,0h0L20,17.21a1,1,0,0,0,.47-.85V7.63S20.49,7.56,20.49,7.52ZM12,4.17l1.78,1.1L8.19,8.73,6.4,7.63Zm-1,15L5.5,15.81V9.42l5.5,3.4Zm1-8.11L10.09,9.91l5.59-3.47L17.6,7.63Zm6.5,4.72L13,19.2V12.82l5.5-3.4Z">
                        </path>
                    </svg>

                </a>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
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
                                <a href="/catalog/cart" wire:navigate class="btn btn-neutral btn-block">Lihat Keranjang</a>
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
