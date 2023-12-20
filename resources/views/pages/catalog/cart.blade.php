<?php

use function Livewire\Volt\{state, rules, on};
use App\Models\Cart;
use App\Models\Order;
use App\Models\Item;
use App\Models\Address;

state([
    'carts' => fn() => Cart::where('user_id', auth()->id())->get(),
    'getAddress' => fn() => Address::where('user_id', auth()->id())->first(),
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
    // Ambil item keranjang pengguna
    $cartItems = Cart::where('user_id', auth()->id())->get();

    // Buat record pesanan
    $order = Order::create([
        'user_id' => auth()->id(),
        'status' => 'unpaid', // Atur status pesanan sesuai kebutuhan
        'invoice' => 'INV-' . time(), // Atur nomor invoice, bisa disesuaikan sesuai kebutuhan
        'total_amount' => 0, // Nantinya akan dihitung berdasarkan order_items
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

    // Hapus item keranjang setelah checkout
    Cart::where('user_id', auth()->id())->delete();

    // ... lainnya sesuai kebutuhan ...
    $this->dispatch('cart-updated');

    $this->redirect('/orders/' . $order->id, navigate: true);
    // Ganti dengan route yang sesuai, dan kirimkan ID pesanan ke halaman konfirmasi
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
                                <a href="/catalog/list" class="mr-2 text-sm font-medium text-gray-900">Katalog Produk</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                    class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="/catalog/cart" class="mr-2 text-sm font-medium text-gray-900">Keranjang Barang</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="px-4 sm:px-6 lg:px-8 pt-6">
                <div class="rounded overflow-x-auto">
                    <table class="table text-center border">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Total Harga</th>
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
                                                class="btn btn-xs join-item font-bold btn-outline">+</button>
                                            <span class="join-item">{{ $cart->qty }}</span>
                                            <button wire:loading.attr='disabled'
                                                wire:click="decreaseQty('{{ $cart->id }}')"
                                                class="btn btn-xs join-item font-bold btn-outline">-</button>
                                        </div>
                                    </td>
                                    <td class="w-1/6">Rp. {{ $cart->qty * $cart->product->price }}</td>
                                    <td>
                                        <button wire:click="deleteProduct('{{ $cart->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <span class="font-extrabold text-lg text-black">Total: </span>
                                </td>
                                <td>
                                    <span class="font-extrabold text-lg text-black">Rp. {{ $this->calculateTotal() }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="/catalog/list" wire:navigate class="join-item btn btn-outline">
                                        Lanjut Belanja
                                    </a>
                                </td>
                                <td>
                                    @if ($carts->count() > 0)
                                        @if (!$this->getAddress)
                                            <a href="/user/{{ auth()->id() }}" wire:loading.attr='disable'
                                                class="join-item btn btn-neutral">
                                                <span wire:loading.delay wire:loading wire:target="confirmCheckout"
                                                    class="loading loading-spinner loading-xs"></span>
                                                Atur Alamat</a>
                                        @else
                                            <form wire:submit="confirmCheckout">
                                                <button wire:loading.attr='disable' type="submit"
                                                    class="join-item btn btn-neutral">
                                                    <span wire:loading.delay wire:loading wire:target="confirmCheckout"
                                                        class="loading loading-spinner loading-xs"></span>
                                                    Checkout</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <x-action-message on="cart-updated">
                                        <button style="text-align: -webkit-center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </x-action-message>
                                </td>
                            </tr>
                        </tfoot>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
