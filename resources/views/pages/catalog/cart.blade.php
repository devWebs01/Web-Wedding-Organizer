<?php

use function Livewire\Volt\{state, rules, on, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Item;
use App\Models\Address;
use App\Models\Shop;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use function Laravel\Folio\{middleware};
use Illuminate\Support\Facades\DB;

middleware(['auth', 'verified']);
uses([LivewireAlert::class]);

name('catalog-cart');

state([
    'carts' => fn() => Cart::where('user_id', auth()->id())->get(),
    'destination' => fn() => Address::where('user_id', auth()->id())->first(),
    'origin' => fn() => Shop::first(),
    'wedding_date',
    'order',
]);

on([
    'cart-updated' => function () {
        $this->cart = $this->carts;
        $this->subTotal = $this->carts->sum(function ($item) {
            return $item->variant->price;
        });
    },
]);

$calculateTotal = function () {
    $total = 0;
    foreach ($this->carts as $cart) {
        $total += $cart->variant->price;
    }
    return $total;
};

$deleteProduct = function ($cartId) {
    $cart = Cart::find($cartId);
    $cart->delete();
    $this->dispatch('cart-updated');
};

$confirmCheckout = function () {
    try {
        // Gunakan transaksi dengan retry sebanyak 5 kali
        DB::transaction(function () {
            $userId = auth()->id();

            // Ambil item keranjang pengguna
            $cartItems = Cart::with('variant')->where('user_id', $userId)->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Keranjang kosong. Tidak ada item untuk diproses.');
            }

            // Buat pesanan baru
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'PROGRESS',
                'invoice' => 'INV-' . time(),
                'total_amount' => 0,
            ]);

            // Hitung total harga pesanan
            $totalPrice = $cartItems->sum(function ($cartItem) {
                return $cartItem->variant->price;
            });

            // Siapkan item pesanan untuk batch insert
            $orderItems = $cartItems
                ->map(function ($cartItem) {
                    return [
                        'product_id' => $cartItem->product_id,
                        'variant_id' => $cartItem->variant_id,
                    ];
                })
                ->toArray();

            // Simpan semua item pesanan sekaligus
            $order->items()->createMany($orderItems);

            // Perbarui total harga pesanan
            $order->update(['total_amount' => $totalPrice]);

            // Dispatch event untuk memperbarui keranjang
            $this->dispatch('cart-updated');

            // Tampilkan notifikasi sukses
            $this->alert('success', 'Pesanan telah berhasil diproses. Menuju detail pesanan.', [
                'position' => 'top',
                'timer' => 1500,
                'toast' => true,
            ]);

            // Redirect ke halaman detail pesanan
            $this->redirect('/orders/' . $order->id);

             // Hapus keranjang pengguna setelah berhasil menambahkan pesanan
             Cart::where('user_id', $userId)->delete();

        }, 5); // Retry 5 kali jika terjadi deadlock atau kegagalan transaksi
    } catch (\Throwable $e) {
        // Tampilkan notifikasi error jika transaksi gagal setelah retry 5 kali
        $this->alert('error', 'Maaf, terjadi kesalahan sistem. Silakan coba lagi nanti.', [
            'position' => 'top',
            'timer' => 2000,
            'toast' => true,
            'timerProgressBar' => true,
        ]);

        // Log error untuk debugging jika diperlukan
        \Log::error('Checkout gagal: ' . $e->getMessage());
    }
};

?>

<x-guest-layout>
    <x-slot name="title">Wedding Checklist</x-slot>

    @volt
        <div>
            @include('pages.catalog.modal')
            {{-- @include('layouts.datepicker') --}}

            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            Wedding Checklist
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center">
                        <p>
                            Kami bekerja sama dengan berbagai vendor terkemuka, termasuk katering, dekorator, fotografer,
                            dan penyedia hiburan, untuk memastikan kamu mendapatkan layanan terbaik di hari bahagia kamu.
                        </p>
                    </div>
                </div>

                <div class="card rounded-5">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table rounded table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Produk</th>
                                        <th>Varian</th>
                                        <th>Total Harga</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $no => $cart)
                                        <tr class="align-items-center">
                                            <td>{{ ++$no }}.</td>
                                            <td>{{ Str::limit($cart->product->title, 20, '...') }}</td>
                                            <td>
                                                {{ $cart->variant->name }}
                                            </td>
                                            <td class="w-1/6">
                                                {{ formatRupiah($cart->variant->price) }}
                                            </td>
                                            <td>
                                                <button wire:click="deleteProduct('{{ $cart->id }}')" type="button"
                                                    class="btn btn-body btn-sm">
                                                    <i class="fa-solid fa-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Total:</td>
                                        <td>
                                            {{ formatRupiah($this->calculateTotal()) }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a class="btn btn-outline-dark btn-sm" href="{{ route('catalog-products') }}"
                                                role="button">
                                                Lihat Produk Lain
                                            </a>
                                        </td>
                                        <td colspan="2"></td>
                                        <td>
                                            @if ($carts->count() > 0)
                                                @if (!$this->destination)
                                                    <a class="btn btn-outline-dark btn-sm"
                                                        href="{{ route('customer.account', ['user' => auth()->id()]) }}"
                                                        role="button">
                                                        Lengkapi Data Diri
                                                    </a>
                                                @else
                                                    <button type="button" class="btn btn-outline-dark btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Checkout
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div wire:loading class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>


    @endvolt
</x-guest-layout>
