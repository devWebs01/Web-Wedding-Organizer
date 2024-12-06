<?php

use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use function Laravel\Folio\name;
use function Livewire\Volt\{state, rules, uses};
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name('product-detail');

state([
    'randomProduct' => fn() => Product::inRandomOrder()->limit(6)->get(),
    'user_id' => fn() => Auth()->user()->id ?? '',
    'product_id' => fn() => $this->product->id,
    'product',
]);

rules([
    'user_id' => 'required|exists:users,id',
    'product_id' => 'required|exists:products,id',
]);

$addToCart = function (Product $product) {
    if (Auth::check() && auth()->user()->role == 'customer') {
        $existingCart = Cart::where('user_id', $this->user_id)
            ->where('product_id', $this->product_id)
            ->first();

        if ($existingCart) {
            $this->alert('warning', 'Layanan sudah ada di daftar.', [
                'position' => 'top',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'text' => '',
            ]);
        } else {
            Cart::create($this->validate());

            $this->alert('success', 'Layanan berhasil ditambahkan ke dalam daftar.', [
                'position' => 'top',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'text' => '',
            ]);
        }

        $this->dispatch('cart-updated');
    } else {
        $this->redirect('/login');
    }
};

?>
<x-guest-layout>
    <x-slot name="title">Product {{ $product->title }}</x-slot>

    @volt
        <div>
            <section class="pt-5">
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2 id="font-custom" class="display-2 fw-bold">
                                Detail Layanan
                            </h2>
                        </div>
                        <div class="col-lg-6 mt-lg-0 align-content-center">
                            <p>
                                Rayakan hari istimewa kamu dengan Paket <strong>{{ $product->title }}</strong> dari
                                <strong>{{ $product->vendor }}</strong>. Dirancang untuk memenuhi semua kebutuhan pernikahan
                                kamu.
                            </p>
                        </div>
                    </div>

                </div>
            </section>

            <section class="pb-5">
                <div class="container">
                    <div class="row gx-2">
                        <aside class="col-lg-6">
                            <div class="card rounded-4 mb-3" style="width: 100%; height: 550px">
                                <a href="{{ Storage::url($product->image) }}" data-fancybox
                                    data-src="{{ Storage::url($product->image) }}">
                                    <img class="card-img-top" src="{{ Storage::url($product->image) }}" width=100%;
                                        height=550px; style="object-fit: cover;" alt="card-img-top">
                                </a>
                            </div>

                            <div class="d-flex flex-row gap-1 overflow-auto">
                                @foreach ($product->images as $imageItem)
                                    <div class="col">
                                        <div class="card rounded-4 mb-3" style="width: 100px; height: 100px">
                                            <a href="{{ Storage::url($imageItem->image_path) }}" data-fancybox="gallery"
                                                data-caption="Caption #1">
                                                <img class="card-img-top" src="{{ Storage::url($imageItem->image_path) }}"
                                                    width=100px; height=100px; style="object-fit: cover;"
                                                    alt="other images">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </aside>
                        <main class="col-lg-6">
                            <div class="ps-lg-3">
                                <small class="fw-bold" style="color: #9c9259;">{{ $product->category->name }}</small>
                                <h2 id="font-custom" class="title text-dark fw-bold">
                                    {{ $product->title }}
                                </h2>

                                <div class="my-3">
                                    <span class="fs-4 fw-bold">
                                        {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                                    </span>
                                </div>

                                <p class="mb-3 fs-5">
                                    {{ $product->description }}
                                </p>
                                <div class="d-grid my-4">
                                    @auth
                                        <form wire:submit='addToCart'>
                                            <button wire:key="{{ $product->id }}" type="submit" class="btn btn-dark w-100">

                                                <span wire:loading.remove>Masukkan List
                                                </span>

                                                <div wire:loading class="spinner-border spinner-border-sm" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </button>
                                        </form>
                                        @error('variant_id')
                                            <small class="my-3 text-center text-danger">
                                                Plih paket/variant yang diinginkan
                                            </small>
                                        @enderror
                                    @else
                                        <a class="btn btn-dark w-100" href="{{ route('login') }}" role="button">Pesan
                                            Sekarang</a>
                                    @endauth
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </section>
            <!-- content -->
        </div>
    @endvolt
</x-guest-layout>
