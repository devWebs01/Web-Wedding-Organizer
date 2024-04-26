<?php

use function Livewire\Volt\{state, usesPagination, computed};
use App\Models\Order;
use function Laravel\Folio\name;

name('transactions.index');

state(['search'])->url();
usesPagination();

$orders = computed(function () {
    if ($this->search == null) {
        return Order::query()->paginate(10);
    } else {
        return Order::query()
            ->where('invoice', 'LIKE', "%{$this->search}%")
            ->orWhere('status', 'LIKE', "%{$this->search}%")
            ->orWhere('total_amount', 'LIKE', "%{$this->search}%")
            ->paginate(10);
    }
});

?>


<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Transaksi Toko') }}
                </h2>
            </x-slot>

            <div class="py-5 p-4">
                <div class="mb-4 flex space-x-4 p-2 bg-white rounded-lg shadow-md justify-end">
                    <label class="form-control w-full max-w-xs">
                        <input wire:model.live="search" type="search" placeholder="Input Pencarian"
                            class="input input-bordered w-full max-w-xs" />
                    </label>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                    <table class="table text-center my-5">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Invoice</th>
                                <th>Status</th>
                                <th>Total Pesanan</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($this->orders as $no => $order)
                                <tr>
                                    <th>{{ ++$no }}</th>
                                    <th>{{ $order->invoice }}</th>
                                    <th>
                                        <div class="badge badge-warning p-3 uppercase">
                                            {{ $order->status }}
                                        </div>
                                    </th>
                                    <th>
                                        {{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                    </th>
                                    <th>
                                        <a href="/admin/transactions/{{ $order->id }}" wire:navigate
                                            class="btn btn-neutral btn-sm">
                                            Detail Order
                                        </a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                        <div>
                            {{ $this->orders->links() }}
                        </div>
                    </table>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
