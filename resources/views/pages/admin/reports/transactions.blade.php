<?php

use App\Models\Order;
use function Livewire\Volt\{computed};

$orders = computed(fn() => Order::query()->get());

?>
<x-app-layout>
    @volt
        @include('layouts.print')
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Laporan Data Penjualan
                </h2>
            </x-slot>

            <div class="print:block">
                <div class="sm:px-6 lg:px-8">
                    <div class="py-5">
                        <div class="mx-auto">
                            <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <div class="overflow-x-auto">
                                    <table id="example" class="display" style="width:100%">
                                        <!-- head -->
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>Pembeli</th>
                                                <th>Status</th>
                                                <th>Total Belanja</th>
                                                <th>Metode Pembayaran</th>
                                                <th>Tambahan</th>
                                                <th>Jumlah </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->orders as $no => $order)
                                                <tr>
                                                    <td>{{ ++$no }}.</td>
                                                    <td>{{ $order->invoice }}</td>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>{{ $order->payment_method }}</td>
                                                    <td>{{ $order->protect_cost == 1 ? 'Bubble Wrap' : '-' }}</td>
                                                    <td>{{ $order->items->count() }} Barang</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-app-layout>
