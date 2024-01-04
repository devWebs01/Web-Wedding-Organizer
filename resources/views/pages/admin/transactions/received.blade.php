<?php

use function Livewire\Volt\{state, usesPagination, with};
use App\Models\Order;

usesPagination();

state([
    // 'orders' => fn() => Order::where('user_id', auth()->id())->get(),
]);

with(
    fn() => [
        'receives' => fn() => Order::where('user_id', auth()->id())
            ->where('status', 'unpaid')
            ->orWhere('status', 'progress')
            ->latest()
            ->paginate(5),
    ],
);
?>


<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Pesanan Masuk') }}
                </h2>
            </x-slot>

            <div class="py-5 p-4">
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
                            @foreach ($receives as $no => $order)
                                <tr>
                                    <th>{{ ++$no }}</th>
                                    <th>{{ $order->invoice }}</th>
                                    <th>
                                        <div class="badge badge-warning p-3">
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
                            {{ $receives->links() }}
                        </div>
                    </table>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
