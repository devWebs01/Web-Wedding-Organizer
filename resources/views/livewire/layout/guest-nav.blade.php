<?php

use App\Livewire\Actions\Logout;
use App\Models\Cart;
use function Livewire\Volt\{state, computed, on};

$logout = function (Logout $logout) {
    $logout();

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

<div>
    @auth
        <div class="d-lg-flex gap-3">
            <a href="{{ route('catalog-cart') }}" class="text-dark btn border">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            <a href="/orders" class="text-dark btn border">
                <i class="fa-solid fa-truck"></i>
            </a>
            <a href="/user/{{ auth()->id() }}" class="text-dark btn border">
                <i class="fa-solid fa-user"></i>
            </a>
            <a wire:click="logout" href="#" class="text-dark btn border">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    @else
        <a class="btn btn-outline-dark btn-sm rounded" href="{{ route('login') }}" role="button">Masuk</a>
        <a class="btn btn-outline-dark btn-sm rounded" href="{{ route('register') }}" role="button">Daftar</a>
    @endauth
</div>
