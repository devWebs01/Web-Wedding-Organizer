<?php

use function Livewire\Volt\{state, rules, on, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Item;
use App\Models\Courier;
use App\Models\Product;
use Carbon\Carbon;


uses([LivewireAlert::class]);

state([
    'orderId' => fn() => $this->order->id,
    'orderItems' => fn() => $this->order->items,
    'note' => fn() => $this->order->note ?? null,
    'min_down_payment' => fn() => $this->order->total_amount / 2,
    'max_down_payment' => fn() => $this->order->total_amount,
    'total_down_payment' => fn() => $this->order->total_amount / 2,
    'full_payment' => fn () => Carbon::parse($this->wedding_date)->addMonth()->format('d/m/Y') ?? '',
    'payment_method',
    'wedding_date',
    'order',
]);

$gap_down_payment = function () {
    return $this->order->total_amount - $this->total_down_payment;
};

$confirm_order = function () {
    // return dd($this->total_down_payment);
    // $this->validate();

    // $order = $this->order;

    // $order->update([
    //     'total_amount' => $order->total_amount,
    //     'payment_method' => $this->payment_method,
    //     'status' => 'UNPAID',
    //     'note' => $this->note,
    // ]);

    // // Redirect ke halaman pembayaran atau daftar pesanan
    // if ($this->payment_method == 'Transfer Bank') {
    //     $this->alert('success', 'kamu telah memilih opsi pengiriman. Lanjut melakukan pembayaran.', [
    //         'position' => 'top',
    //         'timer' => 3000,
    //         'toast' => true,
    //     ]);
    //     $this->redirectRoute('customer.payment', ['order' => $order->id]);
    // } else {
    //     $this->redirect('/orders');
    // }
};

$cancel_order = function ($orderId) {
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
            @include('layouts.datepicker')

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
                    <h5>{{ $min_down_payment }}</h5>
                    <h5>{{ $this->gap_down_payment() }}</h5>

                    @if ($order->status === 'PROGRESS' || $order->status === 'UNPAID')
                        @if ($order->status == 'CANCELLED')
                            <div class="alert alert-danger rounded-5" role="alert">
                                <strong>Pemberitahuan!</strong>
                                <span>
                                    Pesanan dibatalkan. Silahkan tunggu konfirmasi tentang pengambalian dana!
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
                                            <h6 class="fw-bold" style="color: #f35525">
                                                {{ formatRupiah($item->variant->price) }} </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-5">

                                <div class="mb-3">
                                    <label for="wedding_date" class="form-label">Tanggal Acara</label>
                                    <input type="text" wire:model.live='wedding_date' class="form-control" name="datepicker"
                                        id="wedding_date" aria-describedby="wedding_date" placeholder="wedding_date" />
                                    @error('wedding_date')
                                        <small class="fw-bold text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Opsi Pembayaran</label>
                                    <select wire:model.live='payment_method' class="form-select" name="payment_method"
                                        id="payment_method">
                                        <option>Pilih satu</option>
                                        <option value="Lunas">Lunas</option>
                                        <option value="Cicilan">Cicilan</option>
                                    </select>
                                    @error('payment_method')
                                        <small class="fw-bold text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="mb-3 {{ $payment_method == 'Cicilan' ?: 'd-none' }}">
                                    <label for="total_down_payment" class="form-label">Down Payment (DP)</label>
                                    <input type="number" wire:model.live='total_down_payment' class="form-control"
                                        name="total_down_payment" id="total_down_payment" min="{{ $min_down_payment }}"
                                        max="{{ $order->total_amount }}" value="{{ $min_down_payment }}" />
                                    @error('total_down_payment')
                                        <small class="fw-bold text-danger">{{ $message }}</small> <br>
                                    @enderror
                                    <small
                                        class="fw-bold text-danger {{ $total_down_payment == $order->total_amount ?: 'd-none' }}">DP
                                        yang kamu masukkan sama dengan total harga yang harus di bayar, pembayaran akan di
                                        anggap sebagai Lunas</small>
                                </div>

                                <div class="mb-3 {{ $payment_method == 'Cicilan' ?: 'd-none' }}">
                                    <label for="full_payment" class="form-label">Tanggal Pelunasan</label>
                                    <input type="text" wire:model='full_payment' class="form-control"
                                         id="full_payment"
                                        aria-describedby="full_payment"
                                        placeholder="full_payment" disabled />
                                    <small class="fw-bold text-danger">Tanggal pelunasan paling lambat adalah 1 bulan dari tanggal acara</small>
                                </div>

                                <div class="mb-3">
                                    <label for="note" class="form-label">Pesan Tambahan</label>
                                    <textarea wire:model='note' class="form-control" name="note" id="note" rows="3"
                                        {{ $order->status !== 'PROGRESS' ? 'disabled' : '' }}>
                                    </textarea>
                                    @error('note')
                                        <small class="fw-bold text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="row">
                                    <div class="col">
                                        Total Harga
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ formatRupiah($order->total_amount) }}
                                    </div>
                                </div>

                                <div class="row {{ $payment_method == 'Cicilan' ?: 'd-none' }}">
                                    <div class="col">
                                        Down Payment (DP)
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ formatRupiah($total_down_payment) }}
                                    </div>
                                </div>
                                <div class="row {{ $payment_method == 'Cicilan' ?: 'd-none' }}">
                                    <div class="col">
                                        Sisa Pembayaran
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ formatRupiah($this->gap_down_payment()) }}
                                    </div>
                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-md">
                                        @if ($order->status === 'PROGRESS' || $order->status === 'UNPAID')
                                            <button class="btn btn-danger" wire:click="cancel_order('{{ $order->id }}')"
                                                role="button">
                                                Batalkan
                                            </button>
                                        @endif
                                    </div>

                                    <div class="col-md text-end">
                                        @if ($order->status === 'PROGRESS')
                                            <button wire:click="confirm_order('{{ $order->id }}')" class="btn btn-dark">
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
