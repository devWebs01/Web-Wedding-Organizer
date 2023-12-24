<?php

use function Livewire\Volt\{state, rules, computed, on};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Item;
use App\Models\Courier;

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
    'couriers' => fn() => Courier::where('order_id', $this->order->id)->get(),
    'shipping_cost' => fn() => $this->selectCourier()->value ?? $this->order->shipping_cost,
    'payment_method' => fn() => $this->order->payment_method ?? null,
    'note' => fn() => $this->order->note ?? null,
]);

state(['courier'])->url();

$selectCourier = computed(function () {
    $confirmCourier = Courier::find($this->courier);

    if (!$confirmCourier) {
        return 0;
    } else {
        $this->dispatch('update-selectCourier');
        return $confirmCourier;
    }
});

on([
    'update-selectCourier' => function () {
        $this->shipping_cost = $this->selectCourier()->value;
    },
]);

rules(['courier' => 'required', 'payment_method' => 'required']);

$confirmOrder = function () {
    $this->validate();
    $order = $this->order;
    $order->update([
        'total_amount' => $order->total_amount + $this->shipping_cost,
        'shipping_cost' => $this->shipping_cost,
        'payment_method' => $this->payment_method,
        'status' => 'Unpaid',
        'note' => $this->note,
        'estimated_delivery_time' => $this->selectCourier()->etd,
        'courier' => $this->selectCourier()->description,
    ]);
    $this->dispatch('delete-couriers');
    $this->redirect('/payments/' . $order->id, navigate: true);
};

$deleteOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);
    $order->update([
        'status' => 'Cancelled',
    ]);
    $this->dispatch('delete-couriers');
    $this->redirect('/orders', navigate: true);
};

on([
    'delete-couriers' => function () {
        Courier::where('order_id', $this->order->id)->delete();
    },
]);

?>
<x-costumer-layout>
    @volt
        <div>
            <p class="hidden">@json($this->selectCourier())</p>
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li>
                            <div class="flex items-center">
                                <a href="/orders" class="mr-2 text-sm font-medium">Pesanan Saya</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                    class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium">Rincian Pesanan</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>


            <div class="grid sm:px-8 lg:grid-cols-2 mx-auto gap-4">
                <div>
                    <div class="mt-8 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                        <p class="font-bold text-xl border-b">Produk Pesanan</p>
                        <div>
                            @foreach ($orderItems as $orderItem)
                                <div class="flex flex-col rounded-lg sm:flex-row">
                                    <img lazy class="m-2 h-24 w-28 rounded-md border object-cover object-center"
                                        src="{{ Storage::url($orderItem->product->image) }}" alt="" />
                                    <div class="flex w-full flex-col px-4 py-4">
                                        <span class="font-semibold">{{ $orderItem->product->title }}</span>
                                        <span class="float-right ">X {{ $orderItem->qty }} item</span>
                                        <p class="text-lg font-bold">Rp.
                                            {{ Number::format($orderItem->qty * $orderItem->product->price, locale: 'id') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 py-2 px-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Total Pesanan ({{ $orderItems->count() }} Produk)</p>
                                <p class="font-semibold">
                                    {{ 'Rp. ' . Number::format($this->order->total_amount, locale: 'id') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                        <p class="font-bold text-xl border-b mb-4">Informasi Penerima</p>
                        <div>
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <span class="label-text">Nama Lengkap</span>
                                </div>
                                <input type="text" value="{{ $order->user->name }}" placeholder="Type here"
                                    class="input input-bordered w-full" disabled />
                            </label>
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <span class="label-text">Email</span>
                                </div>
                                <input type="email" value="{{ $order->user->email }}" placeholder="Type here"
                                    class="input input-bordered w-full" disabled />
                            </label>
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <span class="label-text">Telepon</span>
                                </div>
                                <input type="text" value="{{ $order->user->telp }}" placeholder="Type here"
                                    class="input input-bordered w-full" disabled />
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                    <p class="font-bold text-xl border-b mb-4">Opsi Pengiriman</p>
                    <div>
                        <!-- courier -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="courier" :value="__('Pilih Jasa Pengiriman')" class="mb-2" />
                            @if ($order->status == 'Progress')
                                <select wire:model.live='courier' class="select select-bordered">
                                    <option disabled value="">Pilih salah satu</option>
                                    @foreach ($couriers as $courier)
                                        <option value="{{ $courier->id }}">
                                            {{ $courier->description }} -
                                            {{ $courier->etd . ' Hari' }} -
                                            {{ 'Rp. ' . Number::format($courier->value, locale: 'id') }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('courier')" class="mt-2" />
                            @else
                                <x-text-input value="{{ $order->courier }}" disabled></x-text-input>
                            @endif
                        </label>

                        <!-- payment_method -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="payment_method" :value="__('Pilih Metode Pembayaran')" class="mb-2" />
                            <select {{ $order->status == 'Progress' ?: 'disabled' }} wire:model='payment_method'
                                class="select select-bordered">
                                <option>Pilih salah satu</option>
                                <option value="COD (Cash On Delivery)">COD (Cash On Delivery)</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                            </select>

                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </label>

                        <!-- note -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="note" :value="__('Catatan Tambahan')" class="mb-2" />
                            <textarea wire:target='submit' wire:model.blur="note" class="mt-1 w-full textarea textarea-bordered h-36"
                                {{ $order->status == 'Progress' ?: 'disabled' }} />
                            </textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </label>

                        <!-- Total -->
                        <div class="mt-6 border-t border-b py-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Subtotal untuk Produk</p>
                                <p class="font-semibold"> {{ 'Rp. ' . Number::format($this->order->total_amount) }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Subtotal Pengiriman</p>
                                <p lazy class="font-semibold">
                                    <span wire:loading wire:target='courier'
                                        class="loading loading-xs loading-dots  text-neutral">
                                    </span>
                                    {{ 'Rp. ' . Number::format($shipping_cost, locale: 'id') }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Total Pembayaran</p>
                                <p lazy class="font-semibold">
                                    <span wire:loading wire:target='courier'
                                        class="loading loading-xs loading-dots  text-neutral">
                                    </span>
                                    {{ 'Rp. ' . Number::format($order->total_amount + $shipping_cost, locale: 'id') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @if ($order->status == 'progress')
                        <div class="text-center mt-5">
                            <button wire:click="deleteOrder('{{ $order->id }}')"
                                class="btn btn-neutral btn-wide my-4 mx-3">
                                <span wire:loading wire:target='deleteOrder' class="loading loading-spinner text-neutral">
                                </span>
                                Batalkan Pesanan
                            </button>
                            <button wire:click='confirmOrder' class="btn btn-primary btn-wide my-4 mx-3">
                                Lanjutkan Pesanan
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    @endvolt
</x-costumer-layout>
