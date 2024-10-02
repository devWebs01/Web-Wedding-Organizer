<?php

use function Livewire\Volt\{state, rules, computed, on, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Item;
use App\Models\Courier;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

state(['courier'])->url();

state([
    'orderId' => fn() => $this->order->id,
    'orderItems' => fn() => $this->order->items,
    'note' => fn() => $this->order->note ?? null,
    'payment_method',
    'order',
    // 'payment_method' => fn() => $this->order->payment_method ?? null,
]);

$confirmOrder = function () {
    $this->validate();

    $status_payment = $this->payment_method == 'Transfer Bank' ? 'UNPAID' : 'PENDING';
    $order = $this->order;

    $order->update([
            'total_amount' => $order->total_amount + $this->shipping_cost + $this->protect_cost_opsional,
            'shipping_cost' => $this->shipping_cost,
            'payment_method' => $this->payment_method,
            'status' => $status_payment,
            'note' => $this->note,
            'estimated_delivery_time' => $this->selectCourier()->etd,
            'courier' => $this->selectCourier()->description,
            'protect_cost' => $this->protect_cost,
        ]);

    // Redirect ke halaman pembayaran atau daftar pesanan
    if ($this->payment_method == 'Transfer Bank') {
        $this->alert('success', 'kamu telah memilih opsi pengiriman. Lanjut melakukan pembayaran.', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
        $this->redirectRoute('customer.payment', ['order' => $order->id]);
    } else {
        $this->redirect('/orders');
    }
};

$cancelOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);

    // Memperbarui status pesanan menjadi 'CANCELLED'
    $order->update(['status' => 'CANCELLED']);

    // Redirect ke halaman pesanan setelah pembatalan
    $this->redirect('/orders');
};

$complatedOrder = fn() => $this->order->update(['status' => 'COMPLETED']);

?>
<x-guest-layout>
    <x-slot name="title">Pesanan {{ $order->invoice }}</x-slot>

    @volt
        <div>
            <div class="container">
                <div class="row my-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            {{ $order->invoice }}
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center fun-facts mb-3">
                        <div class="counter float-start float-lg-end">
                            <span id="font-custom" class="fs-4 fw-bold">{{ $order->status }}</span>
                        </div>
                    </div>

                    @if ($order->status === 'PROGRESS' || $order->status === 'UNPAID')
                        @if ($order->status == 'CANCELLED')
                            <div class="alert alert-danger rounded-5" role="alert">
                                <strong>Pemberitahuan!</strong>
                                <span>
                                    Pesanan dibatalkan.
                                    @if ($order->payment_method != 'COD (Cash On Delivery)')
                                        Silahkan tunggu konfirmasi tentang pengambalian dana!
                                    @endif
                                </span>
                            </div>
                        @endif
                        <div class="row my-5">
                            <div class="col-lg-7">
                                @foreach ($orderItems as $item)
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <img src="{{ Storage::url($item->product->image) }}"
                                                class="img rounded object-fit-cover border rounded" height="100px"
                                                width="200px" alt="{{ $item->product->title }}" />
                                        </div>
                                        <div class="col">
                                            <h5 id="font-custom">
                                                {{ $item->product->title }}
                                                -
                                                {{ $item->variant->name }}
                                            </h5>
                                            <p>
                                                X {{ $item->qty }} item ({{ $item->product->weight }} gram)
                                            </p>
                                            <h6 class="fw-bold" style="color: #f35525">
                                                Rp.
                                                {{ Number::format ($item->variant->price, locale: 'id') }}
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-5">

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                    <select wire:model.live='payment_method' class="form-select" name="payment_method"
                                        id="payment_method">
                                        <option>Pilih satu</option>
                                        <option value="Lunas">Lunas</option>
                                        <option value="Cicilan">Cicilan</option>
                                    </select>
                                    @error('courier')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="note" class="form-label">Pesan Tambahan</label>
                                    <textarea wire:model='note' class="form-control" name="note" id="note" rows="3"
                                        {{ $order->status !== 'PROGRESS' ? 'disabled' : '' }}>
                            </textarea>
                                    @error('note')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="row">
                                    <div class="col">
                                        Total Produk
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ 'Rp. ' . Number::format($this->order->total_amount) }}
                                    </div>
                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-md">
                                        @if ($order->status === 'PROGRESS' || $order->status === 'UNPAID')
                                            <button class="btn btn-danger" wire:click="cancelOrder('{{ $order->id }}')"
                                                role="button">
                                                Batalkan
                                            </button>
                                        @endif
                                    </div>

                                    <div class="col-md text-end">
                                        @if ($order->status === 'PROGRESS')
                                            <button wire:click="confirmOrder('{{ $order->id }}')" class="btn btn-dark">
                                                Lanjut
                                            </button>
                                        @elseif ($order->status === 'UNPAID')
                                            <a href="{{ route('customer.payment', ['order' => $order->id]) }}"
                                                class="btn btn-dark">
                                                Bayar
                                            </a>
                                        @elseif ($order->status === 'SHIPPED')
                                            <button wire:click="complatedOrder" class="btn btn-dark" role="button">
                                                Pesanan diterima
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                    @else
                        @include('pages.transactions.invoice')
                        @if ($order->status === 'SHIPPED')
                            <button wire:click="complatedOrder" class="btn btn-dark" role="button">
                                Pesanan diterima
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endvolt
</x-guest-layout>
