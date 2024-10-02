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
    // Buat record pesanan
    $cartItems = Cart::where('user_id', auth()->id())->get();

    $order = Order::create([
        'user_id' => auth()->id(),
        'status' => 'PROGRESS',
        'invoice' => 'INV-' . time(),
        'total_amount' => 0,
        // 'shipping_cost' => 0,
        // 'province_id' => $this->destination->province_id,
        // 'city_id' => $this->destination->city_id,
        // 'details' => $this->destination->details,
    ]);

    // Inisialisasi total harga pesanan
    $totalPrice = 0;
    // $totalWeight = 0;

    // Salin item dari keranjang ke tabel order_items
    foreach ($cartItems as $cartItem) {
        $orderItem = new Item([
            'product_id' => $cartItem->product_id,
            'variant_id' => $cartItem->variant_id,
            // 'qty' => $cartItem->qty,
        ]);

        // Tambahkan item ke pesanan
        $order->items()->save($orderItem);

        // Hitung total harga pesanan
        $totalPrice += $cartItem->variant->price;

        // Hitung total berat pesanan
        // $totalWeight += $cartItem->product->weight;

        // Kurangkan kuantitas produk dari stok
        // $cartItem->variant->decrement('stock', $cartItem->qty);
    }

    // Update total harga pesanan
    $order->update([
        'total_amount' => $totalPrice, // Total harga pesanan ditambah ongkir
        // 'total_weight' => $totalWeight, // Total berat pesanan
    ]);

    try {
        // $jneShippingData = [
        //     'origin' => $this->origin->city_id,
        //     'destination' => $this->destination->city_id,
        //     'weight' => 123,
        //     'courier' => RajaongkirCourier::JNE,
        // ];
        // $tikiShippingData = [
        //     'origin' => $this->origin->city_id,
        //     'destination' => $this->destination->city_id,
        //     'weight' => 123,
        //     'courier' => RajaongkirCourier::TIKI,
        // ];

        // $jneOngkirCost = \Rajaongkir::getOngkirCost($jneShippingData['origin'], $jneShippingData['destination'], $jneShippingData['weight'], $jneShippingData['courier']);

        // $tikiOngkirCost = \Rajaongkir::getOngkirCost($tikiShippingData['origin'], $tikiShippingData['destination'], $tikiShippingData['weight'], $tikiShippingData['courier']);

        // $jneShippingCost = $jneOngkirCost[0]['costs'];
        // $tikiShippingCost = $tikiOngkirCost[0]['costs'];

        // foreach ($jneShippingCost as $shippingCost) {
        //     \App\Models\Courier::create([
        //         'order_id' => $order->id,
        //         'description' => $shippingCost['description'] . ' (JNE)',
        //         'value' => $shippingCost['cost'][0]['value'],
        //         'etd' => $shippingCost['cost'][0]['etd'],
        //     ]);
        // }

        // foreach ($tikiShippingCost as $shippingCost) {
        //     \App\Models\Courier::create([
        //         'order_id' => $order->id,
        //         'description' => $shippingCost['description'] . ' (TIKI)',
        //         'value' => $shippingCost['cost'][0]['value'],
        //         'etd' => $shippingCost['cost'][0]['etd'],
        //     ]);
        // }

        Cart::where('user_id', auth()->id())->delete();

        $this->dispatch('cart-updated');

        $this->alert('success', 'Pesanan telah berhasil diproses. Menuju detail pesanan.', [
            'position' => 'top',
            'timer' => '2000',
            'toast' => true,
            'text' => '',
        ]);

        $this->redirect('/orders/' . $order->id);
    } catch (\Throwable $th) {
        Order::find($order->id)->delete();

        $this->alert('error', 'Maaf, terjadi kesalahan saat checkout. Silakan coba lagi!', [
            'position' => 'top',
            'timer' => '2000',
            'toast' => true,
            'timerProgressBar' => true,
            'text' => '',
        ]);
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
                            Kami bekerja sama dengan berbagai vendor terkemuka, termasuk katering, dekorator, fotografer, dan penyedia hiburan, untuk memastikan kamu mendapatkan layanan terbaik di hari bahagia kamu.
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
                                                {{ $cart->variant->formatRupiah($cart->variant->price) }}
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
                                            {{ $cart->variant->formatRupiah($this->calculateTotal()) }}
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
