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
                    Laporan Data Pengiriman
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
                                                <th>Pembeli</th>
                                                <th>Status</th>
                                                <th>Total Belanja</th>
                                                <th>Nomor Resi</th>
                                                <th>Metode Pembayaran</th>
                                                <th>Berat Barang</th>
                                                <th>Tambahan</th>
                                                <th>Kurir</th>
                                                <th>Ongkir</th>
                                                <th>Estimasi Pengiriman</th>
                                                <th>Tujuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->orders as $no => $order)
                                                <tr>
                                                    <td>{{ ++$no }}.</td>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>{{ $order->tracking_number }}</td>
                                                    <td>{{ $order->payment_method }}</td>
                                                    <td>{{ $order->total_weight }} gram</td>
                                                    <td>{{ $order->protect_cost == 1 ? 'Bubble Wrap' : '-' }}</td>
                                                    <td>{{ $order->courier }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($order->shipping_cost, locale:'id') }}</td>
                                                    <td>{{ $order->estimated_delivery_time }} Hari</td>
                                                    <td>
                                                        {{ $order->user->address->province->name ?? '-' }},
                                                        {{ $order->user->address->city->name ?? '-' }}
                                                    </td>
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
