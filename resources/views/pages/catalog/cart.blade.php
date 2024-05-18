<?php

use function Livewire\Volt\{state, rules, on, mount};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Item;
use App\Models\Address;
use App\Models\Shop;
use function Laravel\Folio\name;

name('catalog-cart');

state([
    'carts' => fn() => Cart::where('user_id', auth()->id())->get(),
    'destination' => fn() => Address::where('user_id', auth()->id())->first(),
    'origin' => fn() => Shop::first(),
    'order',
]);

on([
    'cart-updated' => function () {
        $this->cart = $this->carts;
        $this->subTotal = $this->carts->sum(function ($item) {
            return $item->product->price * $item->qty;
        });
    },
]);

$calculateTotal = function () {
    $total = 0;
    foreach ($this->carts as $cart) {
        $total += $cart->product->price * $cart->qty;
    }
    return $total;
};

$increaseQty = function ($cartId) {
    $cart = Cart::find($cartId);
    if ($cart->qty < $cart->product->quantity) {
        $cart->update(['qty' => $cart->qty + 1]);
        $this->dispatch('cart-updated');
    }
};

$decreaseQty = function ($cartId) {
    $cart = Cart::find($cartId);
    if ($cart->qty > 1) {
        $cart->update(['qty' => $cart->qty - 1]);
        $this->dispatch('cart-updated');
    }
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
        'shipping_cost' => 0,
    ]);

    // Inisialisasi total harga pesanan
    $totalPrice = 0;
    $totalWeight = 0;

    // Salin item dari keranjang ke tabel order_items
    foreach ($cartItems as $cartItem) {
        $orderItem = new Item([
            'product_id' => $cartItem->product_id,
            'qty' => $cartItem->qty,
        ]);

        // Tambahkan item ke pesanan
        $order->items()->save($orderItem);

        // Hitung total harga pesanan
        $totalPrice += $cartItem->product->price * $cartItem->qty;

        // Hitung total berat pesanan
        $totalWeight += $cartItem->product->weight * $cartItem->qty;

        // Kurangkan kuantitas produk dari stok
        $cartItem->product->decrement('quantity', $cartItem->qty);
    }

    // Update total harga pesanan
    $order->update([
        'total_amount' => $totalPrice, // Total harga pesanan ditambah ongkir
        'total_weight' => $totalWeight, // Total berat pesanan
    ]);

    try {
        $jneShippingData = [
            'origin' => $this->origin->city_id,
            'destination' => $this->destination->city_id,
            'weight' => 123,
            'courier' => RajaongkirCourier::JNE,
        ];
        $tikiShippingData = [
            'origin' => $this->origin->city_id,
            'destination' => $this->destination->city_id,
            'weight' => 123,
            'courier' => RajaongkirCourier::TIKI,
        ];

        $jneOngkirCost = \Rajaongkir::getOngkirCost($jneShippingData['origin'], $jneShippingData['destination'], $jneShippingData['weight'], $jneShippingData['courier']);

        $tikiOngkirCost = \Rajaongkir::getOngkirCost($tikiShippingData['origin'], $tikiShippingData['destination'], $tikiShippingData['weight'], $tikiShippingData['courier']);

        $jneShippingCost = $jneOngkirCost[0]['costs'];
        $tikiShippingCost = $tikiOngkirCost[0]['costs'];

        foreach ($jneShippingCost as $shippingCost) {
            \App\Models\Courier::create([
                'order_id' => $order->id,
                'description' => $shippingCost['description'] . ' (JNE)',
                'value' => $shippingCost['cost'][0]['value'],
                'etd' => $shippingCost['cost'][0]['etd'],
            ]);
        }

        foreach ($tikiShippingCost as $shippingCost) {
            \App\Models\Courier::create([
                'order_id' => $order->id,
                'description' => $shippingCost['description'] . ' (TIKI)',
                'value' => $shippingCost['cost'][0]['value'],
                'etd' => $shippingCost['cost'][0]['etd'],
            ]);
        }

        Cart::where('user_id', auth()->id())->delete();

        $this->dispatch('cart-updated');

        $this->redirect('/orders/' . $order->id);
    } catch (\Throwable $th) {
        Order::find($order->id)->delete();
    }
};

?>

<x-guest-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>
    @volt
        <div>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            Keranjang Belanja
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center">
                        <p>
                            Terima kasih telah memilih produk-produk kami. Sekarang saatnya untuk menyelesaikan pembelianmu.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table rounded table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Item</th>
                                        <th>Jumlah</th>
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
                                                <div class="input-group input-group-sm justify-content-center">
                                                    <button class="btn btn-body btn-sm border rounded-start-pill"
                                                        wire:loading.attr='disabled'
                                                        wire:click="decreaseQty('{{ $cart->id }}')">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <span class="input-group-text bg-body border">
                                                        {{ $cart->qty }}
                                                    </span>
                                                    <button class="btn btn-body btn-sm border rounded-end-circle"
                                                        wire:loading.attr='disabled'
                                                        wire:click="increaseQty('{{ $cart->id }}')">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>

                                                </div>
                                            </td>
                                            <td class="w-1/6">
                                                {{ 'Rp.' . Number::format($cart->qty * $cart->product->price, locale: 'id') }}
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
                                            {{ 'Rp.' . Number::format($this->calculateTotal(), locale: 'id') }}
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                            <a class="btn btn-outline-dark btn-sm" href="{{ route('catalog-products') }}"
                                                role="button">
                                                Lanjut Belanja
                                            </a>
                                        </td>
                                        <td>
                                            @if ($carts->count() > 0)
                                                @if (!$this->destination)
                                                    <a class="btn btn-outline-dark btn-sm" href="/user/{{ auth()->id() }}"
                                                        role="button">
                                                        Atur Alamat
                                                    </a>
                                                @else
                                                    <form wire:submit="confirmCheckout">
                                                        <button wire:loading.attr='disable' type="submit"
                                                            class="btn btn-sm btn-outline-dark">
                                                            <span wire:loading.delay wire:target="confirmCheckout"
                                                                class="loading loading-spinner loading-xs"></span>
                                                            Checkout</button>
                                                    </form>
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
