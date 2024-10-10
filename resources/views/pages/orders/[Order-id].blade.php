<?php

use function Livewire\Volt\{state, rules, on, uses, mount};
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Payment;
use App\Models\Variant;
use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use Carbon\Carbon;

uses([LivewireAlert::class]);

name('order.customer');

state([
    'orderId' => fn() => $this->order->id,
    'orderItems' => fn() => $this->order->items,
    'note' => fn() => $this->order->note ?? null,
    'order',

    // Inisialisasi
    'min_dp' => fn() => $this->order->total_amount / 2,
    'max_dp' => fn() => $this->order->total_amount,
    'total_dp' => fn() => $this->min_dp,
    'full_payment',

    // Payment Model
    'payment_method' => fn() => $this->order->payment_method ?? '',
    'wedding_date' => fn() => Carbon::parse($this->wedding_date)
        ->addMonth()
        ->format('Y-m-d') ?? '',
    'payment_date',
    'payment_status',
    'amount',

    // Status Pembayaran
    'is_dp' => fn() => $this->order->payments->contains('payment_type', 'DP'), // Mengecek apakah ada DP
    'is_installment' => fn() => $this->order->payment_method === 'Cicilan', // Cek apakah metode cicilan
    'dp_confirmed' => fn() => $this->order->payments->where('payment_type', 'DP')->first()?->payment_status === 'CONFIRMED', // Cek apakah DP sudah dikonfirmasi
    'payment_type' => fn() => $this->is_dp ? 'Pelunasan' : 'DP', // Tentukan jenis pembayaran berikutnya (DP atau Pelunasan)
]);

mount(function () {
    $this->full_payment = $this->calculateFullPayment();
});

$updatedWeddingDate = function ($value) {
    // Panggil metode untuk menghitung full_payment
    $this->full_payment = $this->calculateFullPayment();
};

$calculateFullPayment = function () {
    // Logika untuk menghitung full_payment berdasarkan wedding_date
    return Carbon::parse($this->wedding_date)
        ->addWeek()
        ->format('Y-m-d');
};

$gap_dp = fn() => $this->order->total_amount - $this->total_dp;

$start_date = fn() => Carbon::parse(now())->format('Y-m-d');

$end_date = fn() => Carbon::parse($this->wedding_date)
    ->addMonth()
    ->format('Y-m-d');

rules([
    'payment_method' => 'required|string|max:255',
    'wedding_date' => 'required|date|after:today',
    'note' => 'nullable|string|max:500',
]);

$confirm_order = function () {
    try {
        DB::beginTransaction(); // Mulai transaksi

        // Validasi input
        $this->validate();

        $payment_date = $this->full_payment;
        $order = $this->order;

        // Pastikan order ada sebelum melanjutkan
        if (!$order) {
            throw new \Exception('Order tidak ditemukan.');
        }

        // Update Order
        $order->update([
            'payment_method' => $this->payment_method,
            'wedding_date' => $this->wedding_date,
            'status' => 'UNPAID',
            'note' => $this->note,
        ]);

        // Logika Pembayaran
        if (($this->total_dp == $order->total_amount && $this->payment_method === 'Cicilan') || $this->payment_method === 'Tunai') {
            // Jika DP sama dengan total_amount, anggap Tunai
            Payment::create([
                'order_id' => $order->id,
                'payment_type' => 'Tunai',
                'amount' => $this->order->total_amount,
                'payment_date' => now(),
                'payment_status' => 'UNPAID',
            ]);
        } else {
            // Jika ada selisih, simpan sebagai dua pembayaran
            Payment::create([
                'order_id' => $order->id,
                'payment_type' => 'DP',
                'amount' => $this->total_dp,
                'payment_date' => now(),
                'payment_status' => 'UNPAID',
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_type' => 'Pelunasan',
                'amount' => $order->total_amount - $this->total_dp,
                'payment_date' => $payment_date,
                'payment_status' => 'UNPAID',
            ]);
        }

        DB::commit(); // Jika tidak ada error, commit transaksi

        // Redirect ke halaman pembayaran atau daftar pesanan
        $this->alert('success', 'Kamu telah memilih opsi pengiriman. Lanjut melakukan pembayaran.', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);

        $this->redirectRoute('order.payment', ['payment' => $order->payments->first->id]);
    } catch (\Throwable $th) {
        DB::rollBack(); // Batalkan transaksi jika terjadi kesalahan

        // Tampilkan notifikasi error
        $this->alert('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);

        // Redirect ke halaman sebelumnya atau tampilkan error lainnya
        $this->redirect('/orders/' . $order->id);
    }
};

$cancel_order = function ($orderId) {
    $order = Order::findOrFail($orderId);

    // Memperbarui status pesanan menjadi 'CANCELED'
    $order->update(['status' => 'CANCELED']);

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
                            <span id="font-custom" class="fs-4 fw-bold">
                                {{ __('status.' . $order->status) }}
                            </span>
                        </div>
                    </div>

                    @if ($order->status === 'PROGRESS')
                        @if ($order->status == 'CANCELED')
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
                                                {{ formatRupiah($item->variant->price ?? 0) }} </h6>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-lg-5">
                                <div class="mb-3">
                                    <label for="wedding_date" class="form-label">Tanggal Acara</label>
                                    <input type="date" wire:model.live='wedding_date' class="form-control"
                                        name="wedding_date" min="{{ $this->start_date() }}" />
                                    @error('wedding_date')
                                        <small class="fw-bold text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Opsi Pembayaran</label>
                                    <select wire:model.change='payment_method' class="form-select" name="payment_method">
                                        <option>Pilih satu</option>
                                        <option value="Tunai">Tunai</option>
                                        <option value="Cicilan">Cicilan</option>
                                    </select>
                                    @error('payment_method')
                                        <small class="fw-bold text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div
                                    class="mb-3
                                    {{ $payment_method == 'Cicilan' ?: 'd-none' }}
                                    {{ $order->status == 'PROGRESS' ?: 'd-none' }}
                                    ">
                                    <label for="total_dp" class="form-label">Down Payment (DP)</label>
                                    <input type="number" wire:model.lazy.number='total_dp' class="form-control"
                                        name="total_dp" id="total_dp" min="{{ $min_dp }}"
                                        max="{{ $order->total_amount }}" />
                                    @error('total_dp')
                                        <small class="fw-bold text-danger">{{ $message }}</small> <br>
                                    @enderror
                                    <small
                                        class="fw-bold text-danger {{ $total_dp == $order->total_amount ?: 'd-none' }}">DP
                                        yang kamu masukkan sama dengan total harga yang harus di bayar, pembayaran akan di
                                        anggap sebagai Tunai</small>
                                    <small class="fw-bold text-danger {{ $total_dp > $order->total_amount ?: 'd-none' }}">
                                        DP melebihi total harga, mohon masukkan angka yang benar.
                                    </small>
                                </div>

                                <div
                                    class="mb-3
                                {{ $payment_method == 'Cicilan' ?: 'd-none' }}
                                {{ $order->status == 'PROGRESS' ?: 'd-none' }}
                                ">
                                    <label for="full_payment" class="form-label">Tanggal Pelunasan</label>
                                    <input type="date" wire:model.live='full_payment' class="form-control"
                                        min="{{ $this->start_date() }}" max="{{ $this->end_date() }}" />
                                    @error('full_payment')
                                        <small class="fw-bold text-danger">{{ $message }}</small> <br>
                                    @enderror
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
                                        {{ formatRupiah($order->total_amount ?? 0) }}
                                    </div>
                                </div>

                                <div
                                    class="row
                                {{ $payment_method == 'Cicilan' ?: 'd-none' }}
                                {{ $order->status == 'PROGRESS' ?: 'd-none' }}
                                ">
                                    <div class="col">
                                        Down Payment (DP)
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ formatRupiah($total_dp ?? 0) }}
                                    </div>
                                </div>
                                <div
                                    class="row
                                {{ $payment_method == 'Cicilan' ?: 'd-none' }}
                                {{ $order->status == 'PROGRESS' ?: 'd-none' }}
                                 ">
                                    <div class="col">
                                        Sisa Pembayaran
                                    </div>
                                    <div class="col text-end fw-bold" style="color: #f35525">
                                        {{ formatRupiah($this->gap_dp() ?? 0) }}
                                    </div>
                                </div>

                                <hr>
                                <div class="row">

                                    <div class="col-md">
                                        @if ($order->status === 'PROGRESS')
                                            <button class="btn btn-danger" wire:click="cancel_order('{{ $order->id }}')"
                                                role="button">
                                                Batalkan
                                            </button>
                                        @endif
                                    </div>

                                    <div class="col-md text-end">
                                        @if ($order->status === 'PROGRESS')
                                            <button wire:click="confirm_order('{{ $order->id }}')"
                                                class="btn btn-dark
                                                {{ ($payment_method == 'Cicilan' && $total_dp < $min_dp) || $total_dp > $order->total_amount ? 'disabled' : '' }}">
                                                Lanjut
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
