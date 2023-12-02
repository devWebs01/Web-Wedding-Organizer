<?php

use function Livewire\Volt\{state, rules, on};
use App\Models\Cart;

state(['carts' => fn() => Cart::where('user_id', auth()->id())->get()]);

on([
    'count-updated' => function () {
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
    // Cek apakah qty pada keranjang belum mencapai jumlah stok produk
    if ($cart->qty < $cart->product->quantity) {
        $cart->update(['qty' => $cart->qty + 1]);
        $this->dispatch('count-updated');
    }
};

$decreaseQty = function ($cartId) {
    $cart = Cart::find($cartId);
    if ($cart->qty > 1) {
        $cart->update(['qty' => $cart->qty - 1]);
        $this->dispatch('count-updated');
    }
};
?>

<x-costumer-layout>
    @volt
        <div>
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li>
                            <div class="flex items-center">
                                <a href="/catalog/list" wire:navigate class="mr-2 text-sm font-medium text-gray-900">Katalog
                                    Produk</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                    class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium text-gray-900">Keranjang Belanja</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="rounded overflow-x-auto">
                        <table class="table text-center border border-2">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $no => $cart)
                                    <tr>
                                        <td>{{ ++$no }}.</td>
                                        <td>{{ Str::limit($cart->product->title, 50, '...') }}</td>
                                        <td>
                                            <div class="join gap-4 flex justify-center items-center">
                                                <button wire:loading.attr='disabled'
                                                    wire:click="increaseQty('{{ $cart->id }}')"
                                                    class="btn btn-xs join-item font-bold">+</button>
                                                <span class="join-item">{{ $cart->qty }}</span>
                                                <button wire:loading.attr='disabled'
                                                    wire:click="decreaseQty('{{ $cart->id }}')"
                                                    class="btn btn-xs join-item font-bold">-</button>
                                            </div>

                                        </td>
                                        <td class="w-1/6">Rp. {{ $cart->qty * $cart->product->price }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-end space-y-2">
                            <!-- Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm mx-5">
                                    <dt class="col-span-3 text-gray-500">Total:</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">
                                        Rp. {{ $this->calculateTotal() }}
                                    </dd>
                                </dl>

                            </div>
                            <!-- End Grid -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
