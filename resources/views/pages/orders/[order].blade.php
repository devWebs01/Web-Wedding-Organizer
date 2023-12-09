<?php

use function Livewire\Volt\{state, rules};
use App\Models\Order;
use App\Models\Item;
use App\Models\User;

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
]);

$calculateTotal = function () {
    $total = 0;
    foreach ($this->orderItems as $orderItem) {
        // $total += $orderItem->item->product->price * $orderItem->qty;
        $total += $orderItem->product->price * $orderItem->qty;
    }
    return $total;
};

$deleteOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);
    $order->delete();
    $this->redirect('/orders', navigate: true);
};

?>
<x-costumer-layout>
    @volt
        <div>
            <div class="min-w-screen min-h-screen">
                <div class="pt-6">
                    <nav aria-label="Breadcrumb">
                        <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                            <li>
                                <div class="flex items-center">
                                    <a href="/catalog/cart" wire:navigate
                                        class="mr-2 text-sm font-medium text-gray-900">Keranjang</a>
                                    <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                        aria-hidden="true" class="h-5 w-4 text-gray-300">
                                        <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                    </svg>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <a href="#" class="mr-2 text-sm font-medium text-gray-900">Checkout Belanja</a>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="w-full bg-white px-4 sm:px-6 lg:px-8 py-10">
                    <div class="w-full">
                        <div class="-mx-3 md:flex items-start">
                            <div class="px-3 md:w-7/12 lg:pr-10">
                                @foreach ($orderItems as $orderItem)
                                    <div class="w-full mx-auto font-light mb-6 border-b border-gray-200 pb-6">
                                        <div class="w-full flex items-center">
                                            <div
                                                class="overflow-hidden rounded-lg w-16 h-16 bg-gray-50 border border-gray-200">
                                                <img src="{{ Storage::url($orderItem->product->image) }}" alt="">
                                            </div>
                                            <div class="flex-grow pl-3">
                                                <h6 class="font-semibold uppercase">
                                                    {{ $orderItem->product->title }}
                                                </h6>
                                                <p class="text-gray-400">x {{ $orderItem->qty }}</p>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-sm">Rp.
                                                    {{ $orderItem->qty * $orderItem->product->price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="mb-6 pb-6 border-b border-gray-200 md:border-none text-xl">
                                    <div class="w-full flex items-center">
                                        <div class="flex-grow">
                                            <span class="text-sm">Subtotal untuk produk</span>
                                        </div>
                                        <div class="pl-3">
                                            <span class="font-semibold text-sm">Rp.
                                                {{ $orderItem->qty * $orderItem->product->price }}</span>
                                        </div>
                                    </div>
                                    <div class="w-full flex items-center">
                                        <div class="flex-grow">
                                            <span class="text-sm">Subtotal pengiriman</span>
                                        </div>
                                        <div class="pl-3">
                                            <span class="font-semibold text-sm">---------</span>
                                        </div>
                                    </div>
                                    <div class="w-full flex items-center">
                                        <div class="flex-grow">
                                            <span class="text-primary font-bold">Total Pembayaran</span>
                                        </div>
                                        <div class="pl-3">
                                            <span class="font-bold text-primary">Rp. {{ $this->calculateTotal() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 md:w-5/12">
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 font-light mb-6">
                                    <h4 class="font-bold text-lg">Alamat Pengiriman</h4>
                                    <div class="w-full flex items-baseline">
                                        <div class="join gap-x-2">
                                            <div class="join-item">
                                                {{ $order->user->name }}
                                            </div>
                                            <div class="join-item">|</div>
                                            <div class="join-item">
                                                {{ $order->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <p>Lorem, ipsum.</p>
                                    <p>Lorem, ipsum.</p>
                                </div>
                                <div class="w-full mx-auto rounded-lg bg-white border border-gray-200 font-light mb-6 p-3">
                                    <h4 class="font-bold text-lg">Metode Pembayaran</h4>

                                    <div class="w-full pl-3">
                                        <label for="cod" class="flex items-center cursor-pointer">
                                            <input type="radio" class="form-radio h-5 w-5" name="type" id="cod">
                                            <img src="https://d3sxshmncs10te.cloudfront.net/icon/free/svg/32259.svg?token=eyJhbGciOiJoczI1NiIsImtpZCI6ImRlZmF1bHQifQ__.eyJpc3MiOiJkM3N4c2htbmNzMTB0ZS5jbG91ZGZyb250Lm5ldCIsImV4cCI6MTcwMjE2NjQwMCwicSI6bnVsbCwiaWF0IjoxNzAxOTM2OTI5fQ__.f27ce53403c5aaf79cad0ecf9a464e9aa4b6ce6e5ef860f0938abe54468c704c"
                                                width="80" class="ml-3" />
                                        </label>
                                    </div>
                                    <div class="w-full p-3">
                                        <label for="transfer" class="flex items-center cursor-pointer">

                                            <input type="radio" class="form-radio h-5 w-5 text-indigo-500" name="type"
                                                id="transfer">

                                            <img src="https://d3sxshmncs10te.cloudfront.net/icon/free/svg/2208355.svg?token=eyJhbGciOiJoczI1NiIsImtpZCI6ImRlZmF1bHQifQ__.eyJpc3MiOiJkM3N4c2htbmNzMTB0ZS5jbG91ZGZyb250Lm5ldCIsImV4cCI6MTcwMjE2NjQwMCwicSI6bnVsbCwiaWF0IjoxNzAxOTM3MjIzfQ__.cf6f92d5a3867fbc299f5cb84c6b0c86c2260794192b07eb3269cd66382d6e66"
                                                width="40" class="ml-4" />
                                            <p class="font-semibold">Transfer</p>
                                        </label>
                                    </div>
                                </div>
                                <label class="form-control w-full max-w-xs">
                                    <input type="file" class="file-input file-input-bordered w-full max-w-xs" />
                                    <div class="label">
                                        <span class="label-text-alt">Kosongkan</span>
                                    </div>
                                </label>
                                <div class="join gap-3 flex mx-auto">
                                    <button wire:click="deleteOrder('{{ $order->id }}')" class="btn btn-neutral">
                                        <span wire:loading class="loading loading-spinner text-neutral"></span>

                                        Batalkan Pesanan</button>
                                    <button class="btn btn-outline">
                                        <span wire:loading class="loading loading-spinner text-neutral"></span>

                                        Bayar Sekarang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
