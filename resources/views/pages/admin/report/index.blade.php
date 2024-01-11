<?php

use App\Models\Order;
use function Livewire\Volt\{computed, state, usesPagination};

state(['search'])->url();
usesPagination();

$orders = computed(function () {
    if ($this->search == null) {
        return Order::query()
            //    ->where('role', 'admin')
            ->paginate(10);
    } else {
        return Order::query()
            //    ->where('role', 'admin')
            // ->where('name', 'LIKE', "%{$this->search}%")
            // ->orWhere('email', 'LIKE', "%{$this->search}%")
            // ->orWhere('telp', 'LIKE', "%{$this->search}%")
            ->paginate(10);
    }
});

?>
<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Laporan Transaksi
                </h2>
            </x-slot>

            <div>
                <div class="sm:px-6 lg:px-8">
                    <div class="py-5">
                        <div class="mx-auto">
                            <div class="mb-4 flex space-x-4 p-2 bg-white rounded-lg shadow-md justify-between">
                                <span class="text-xl font-bold">Cari Data Transaksi</span>
                                <label class="form-control w-full max-w-xs">
                                    <input wire:model.live="search" type="search" placeholder="Input Pencarian"
                                        class="input input-bordered input-sm w-full max-w-xs" />
                                </label>
                            </div>

                            <div class=" bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <div class="overflow-x-auto">
                                    <table class="table text-center">
                                        <!-- head -->
                                        <thead>
                                            <tr>
                                                <th>Pembeli</th>
                                                <th>Invoice</th>
                                                <th>Status</th>
                                                <th>Total_amount</th>
                                                <th>Resi</th>
                                                <th>Metode Pembayaran</th>
                                                <th>Kurir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->orders as $no => $order)
                                                <tr>
                                                    <td>{{ $order->user->name }}.</td>
                                                    <td>{{ $order->invoice }}.</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>{{ $order->tracking_number }}</td>
                                                    <td>{{ $order->payment_method }}</td>
                                                    <td>{{ $order->courier }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="py-5">
                                        {{ $this->orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-app-layout>
