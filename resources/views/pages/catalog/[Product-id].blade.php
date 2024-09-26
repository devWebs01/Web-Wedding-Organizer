<?php

use function Livewire\Volt\{state, rules, computed, uses};
use App\Models\Product;
use App\Models\Variant;
use App\Models\Cart;
use App\Models\User;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name('product-detail');

state([
    'user_id' => fn() => Auth()->user()->id ?? '',
    'product_id' => fn() => $this->product->id,
    'variant_id' => '',
    'randomProduct' => fn() => Product::inRandomOrder()->limit(6)->get(),
    'qty' => 1,
    'variant' => '',
    'product',
]);

rules([
    'user_id' => 'required|exists:users,id',
    'product_id' => 'required|exists:products,id',
    'variant_id' => 'required|exists:variants,id',
    'qty' => 'required|numeric',
]);

$selectVariant = function (Variant $variant) {
    $this->variant = $variant;
    $this->variant_id = $variant->id;
};

$addToCart = function (Product $product) {
    if (Auth::check() && auth()->user()->role == 'customer') {
        $existingCart = Cart::where('user_id', $this->user_id)
            ->where('variant_id', $this->variant_id)
            ->first();

        if ($existingCart) {
        $this->alert('warning', 'Item sudah ada di keranjang belanja.', [
            'position' => 'top',
            'timer' => '2000',
            'toast' => true,
            'timerProgressBar' => true,
            'text' => '',
        ]);

        } else {
            Cart::create($this->validate());
            $this->dispatch('cart-updated');

            $this->alert('success', 'Item berhasil ditambahkan ke dalam keranjang belanja.', [
                'position' => 'top',
                'timer' => '2000',
                'toast' => true,
                'timerProgressBar' => true,
                'text' => '',
            ]);
        }

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
                                Detail Produk
                            </h2>
                        </div>
                        <div class="col-lg-6 mt-lg-0 align-content-center">
                            <p>
                                Rayakan hari istimewa Anda dengan Paket <strong>{{ $product->title }}</strong> dari <strong>{{ $product->vendor }}</strong>. Dirancang untuk memenuhi semua kebutuhan pernikahan Anda.
                            </p>
                        </div>
                    </div>

                </div>
            </section>

            <section class="pb-5">
                <div class="container">
                    <div class="row gx-2">
                        <aside class="col-lg-6">
                            <div class="border rounded-4 mb-3 d-flex justify-content-center">
                                <img class="p-4 object-fit-cover rounded-5" style="width: 100%;"
                                src="{{ Storage::url($product->image) }}" />
                            </div>
                        </aside>
                        <main class="col-lg-6">
                            <div class="ps-lg-3">
                                <small class="fw-bold" style="color: #f35525;">{{ $product->category->name }}</small>
                                <h2 id="font-custom" class="title text-dark fw-bold">
                                    {{ $product->title }}
                                </h2>

                                <div class="my-3">
                                    <span class="h5 fw-bold" style="color: #f35525;">
                                        {{ $variant->name ?? '' }}
                                    </span>
                                </div>

                                <p class="mb-3">
                                    {{ $product->description }}
                                </p>

                                <div class="row">

                                    <dt class="col-3 mb-2 text-capitalize">Nama</dt>
                                    <dd class="col-9 mb-2">
                                        {{ $variant->name ?? ''  }}</dd>

                                    <dt class="col-3 mb-2 text-capitalize">Harga</dt>
                                    <dd class="col-9 mb-2">
                                        {{ $variant ? 'Rp. ' . Number::format($variant->price, locale: 'id') : '' }}

                                    <dt class="col-3 mb-2 text-capitalize">Deksripsi</dt>
                                    <dd class="col-9 mb-2">
                                        {{ $variant->description ?? ''  }}</dd>


                                    <dt class="col-3 mb-2">Pilihan</dt>
                                    <dd class="col-9 mb-2">
                                        <div class="row gap-3">

                                            @foreach ($product->variants as $variant)
                                                <div class="col-auto">
                                                    <button wire:key='{{ $variant->id }}'
                                                        wire:click='selectVariant({{ $variant->id }})' type="button"
                                                        class="badge rounded-pill" style="color: #f35525;">
                                                        {{ $variant->name }}
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </dd>
                                </div>

                                <div class="d-grid my-4">
                                    @auth
                                        <form wire:submit='addToCart'>
                                            @if ($variant)
                                                <button wire:key="{{ $product->id }}" type="submit"
                                                    class="btn btn-dark w-100 rounded-5">

                                                    <span
                                                        wire:loading.remove>Masukkan Keranjang
                                                    </span>

                                                    <div wire:loading class="spinner-border spinner-border-sm" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                </button>
                                            @endif
                                        </form>
                                        @error('variant_id')
                                            <small class="my-3 text-center text-danger">
                                                Plih ukuran/variant yang diinginkan
                                            </small>
                                        @enderror
                                    @else
                                        <a class="btn btn-dark w-100 rounded-5" href="{{ route('login') }}" role="button">Pesan Sekarang</a>
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
