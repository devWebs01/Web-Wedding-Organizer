<?php

use function Livewire\Volt\{state, rules, uses};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Payment;
use App\Models\Item;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

name('transactions.show');

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
    'notes' => [],
    'paymentId',
]);

// Status Order : 'UNPAID', 'PROGRESS', 'COMPLETED', 'PENDING', 'CANCELED', 'CONFIRMED'

// Function order
$confirmOrder = function () {
    $this->order->update(['status' => 'CONFIRMED']);
    $this->dispatch('orders-alert');
};

$cancelOrder = function () {
    $order = $this->order;

    $order->update(['status' => 'CANCELED']);

    $this->dispatch('orders-alert');

    $this->alert('success', 'Pesanan telah di batalkan!', [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);
};

$completeOrder = fn() => $this->order->update(['status' => 'COMPLETED']);

// Status Payment : 'UNPAID', 'PENDING', 'CONFIRMED', 'REJECTED'

// Function payment
$confirmPayment = function (Payment $payment) {
    $payment->update(['payment_status' => 'COMPLETED']);
};

$rejectPayment = function (Payment $payment) {
    $payment->update(['payment_status' => 'REJECTED']);
};

$saveNote = function ($paymentId) {
    // Validasi input
    $this->validate([
        'notes.' . $paymentId => 'required|string|max:255',
    ]);

    // Temukan pembayaran berdasarkan ID
    $payment = Payment::findOrFail($paymentId);

    // Simpan catatan
    $payment->update([
        'note' => $this->notes[$paymentId],
    ]);

    $this->alert('success', 'Note telah di inputkan!', [
        'position' => 'top',
        'timer' => 3000,
        'toast' => true,
    ]);
};

?>
<x-admin-layout>
    <x-slot name="title">Transaksi {{ $order->invoice }}</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('transactions.show', ['order' => $order->id]) }}">{{ $order->invoice }}</a></li>
    </x-slot>
    @volt
        <div>
            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">Halo! 😊</h4>
                <p> Kami ingin mengingatkan Anda untuk memeriksa status pembayaran pesanan yang belum diselesaikan.
                    Segera menyelesaikan pembayaran akan membantu kami memproses pesanan dengan lebih cepat.
                </p>
            </div>

            <div class="card d-print-none">
                <div class="card-header">
                    <button type="button" class="btn btn-primary position-relative">
                        {{ __('status.' . $order->status) }}
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                        </span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between">

                        @if ($order->status == 'PENDING')
                            <div class="col-auto">
                                <button wire:click='confirmOrder' class="btn btn-primary" type="submit">
                                    <i class="ti ti-circle-check fs-3"></i>
                                    Konfirmasi Pesanan
                                </button>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-danger" wire:click="cancelOrder('{{ $order->id }}')"
                                    role="button">
                                    <i class="ti ti-x fs-3"></i>
                                    Batalkan Pesanan
                                </button>
                            </div>
                        @endif

                        <div class="col-auto">
                            <button class="btn btn-dark print-page" onclick="window.print()" type="button">
                                <i class="ti ti-printer fs-3"></i>
                                Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @if ($order->status == 'CANCELED')
                <div class="alert alert-danger" role="alert">
                    <strong>Pengingat!</strong>
                    <span>
                        Mohon hubungi mengkonfirmasi pembatalkan pesanan melalui no. telpon yang tertera...

                        @if ($order->payment_method != 'COD (Cash On Delivery)' && $order->status === 'PICKUP')
                            Dan lakukan pengembalian dana kepada customer
                        @endif

                    </span>
                </div>
            @endif

            <div class="card d-print-block">
                <div class="card-header py-4 row">
                    <div class="col-md">
                        <h4 class="fw-bolder">Pesanan</h4>
                        <p>Waktu Acara : <strong>{{ \carbon\Carbon::parse($order->wedding_date)->format('d M Y') }}</strong>
                        </p>
                        <p>Metode Pembayaran : <strong>{{ $order->payment_method }}</strong></p>
                    </div>
                    <div class="col-md text-lg-end">
                        <h4 class="fw-bolder">Pelanggan</h4>
                        <p>{{ $order->user->name }}</p>
                        <p>{{ $order->user->email }}</p>
                        <p>{{ $order->user->telp }}</p>
                        <p>{{ $order->user->address->province->name }}, {{ $order->user->address->city->name }}</p>
                        <p>{{ $order->user->address->details }}</p>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="border">
                                <th class="text-center">#</th>
                                <th>Produk</th>
                                <th class="text-center">Variant</th>
                                <th class="text-end">Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $no => $item)
                                <tr class="border">
                                    <td class="text-center">{{ ++$no }}</td>
                                    <td>{{ Str::limit($item->product->title, 30, '...') }}</td>
                                    <td class="text-center">{{ $item->variant->name }}</td>
                                    <td class="text-end">{{ formatRupiah($item->variant->price) }}</td>
                                </tr>
                            @endforeach

                            <tr class="text-end">
                                <td colspan="2"></td>
                                <td class="text-center fw-bolder"> Sub Total:</td>
                                <td class="fw-bolder text-dark">
                                    {{ 'Rp.' . Number::format($order->items->sum(fn($item) => $item->variant->price), locale: 'id') }}
                                </td>
                            </tr>
                            <tr class="text-end">
                                <td colspan="2"></td>
                                <td class="text-center fw-bolder"> Total:</td>
                                <td class="fw-bolder text-dark">{{ formatRupiah($order->total_amount) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer row">
                    <div class="col-12">
                        <span class="fw-medium text-heading">Note:</span>
                        <span>{{ $order->note }}</span>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row gap-4">
                        @foreach ($order->payments as $item)
                            <div class="col-md border p-3 rounded">
                                <h4 class="text-center fw-bold">{{ $item->payment_type }}</h4>

                                <div class="d-flex justify-content-around gap-3">
                                    <h6 class="text-center my-2">{{ formatRupiah($item->amount) }}</h6>

                                    <h6 class="text-center my-2">{{ __('status.' . $item->payment_status) }}</h6>
                                </div>

                                @if ($item->proof_of_payment)
                                    <div class="text-center">
                                        <a data-fslightbox="mygalley" class="rounded" target="_blank" data-type="image"
                                            href="{{ Storage::url($item->proof_of_payment) }}">
                                            <img src="{{ Storage::url($item->proof_of_payment) }}"
                                                class="img object-fit-cover rounded" style="height: 550px; width: 100%"
                                                alt="proof_of_payment1" />
                                        </a>
                                    </div>


                                    {{-- // Status Payment : 'UNPAID', 'PENDING', 'CONFIRMED', 'REJECTED' --}}

                                    @if ($item->payment_status === 'PENDING' || $item->payment_status === 'UNPAID')
                                        <div class="d-flex justify-content-between gap-3">
                                            <button wire:click="confirmPayment('{{ $item->id }}')"
                                                class="btn btn-success mt-3">
                                                Konfirmasi {{ $item->payment_type }}
                                            </button>
                                            <button wire:click="rejectPayment('{{ $item->id }}')"
                                                class="btn btn-danger mt-3">
                                                Tolak {{ $item->payment_type }}
                                            </button>
                                        </div>
                                    @elseif ($item->note)
                                        <p class="my-3 text-dark">Note :
                                            <strong>{{ $item->note }}</strong>
                                        </p>
                                    @else
                                        <form wire:submit.prevent="saveNote('{{ $item->id }}')">
                                            <div class="my-3">
                                                <label for="note-{{ $item->id }}" class="form-label">
                                                    Note {{ __('status.' . $item->payment_status) }}
                                                </label>
                                                <textarea class="form-control mb-3" wire:model.defer="notes.{{ $item->id }}" name="note-{{ $item->id }}"
                                                    rows="3"></textarea>
                                                @error('notes.' . $item->id)
                                                    <small class="fw-bold text-danger mb-3">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <div class="card placeholder" style="height: 550px; width: 100%"></div>
                                @endif


                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    @endvolt
    </x-app-layout>
