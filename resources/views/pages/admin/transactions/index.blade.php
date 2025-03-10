<?php

use function Livewire\Volt\{computed};
use App\Models\Order;
use function Laravel\Folio\name;
use Carbon\Carbon;

name('transactions.index');

$orders = computed(function () {
    return Order::query()->latest()->get();
   
});

?>


<x-admin-layout>
    <x-slot name="title">Transaksi</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
    </x-slot>
    @include('layouts.datatables')

    @volt
        <div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive rounded">
                        <table class="table text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Invoice</th>
                                    <th>Status</th>
                                    <th>Total Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->orders as $no => $order)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>{{ $order->invoice }}</th>
                                        <th>
                                            <span class="badge bg-primary uppercase">
                                                {{ __('status.' . $order->status) }}
                                            </span>
                                        </th>
                                        <th>
                                            {{ formatRupiah($order->total_amount) }}
                                        </th>
                                        <th>{{ Carbon::parse($order->created_at)->format('d m Y') }}</th>
                                        <th>
                                            <a href="/admin/transactions/{{ $order->id }}"
                                                class="btn btn-primary btn-sm">
                                                Detail
                                            </a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
