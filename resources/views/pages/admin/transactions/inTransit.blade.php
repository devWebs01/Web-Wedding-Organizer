<?php

use function Livewire\Volt\{state, usesPagination, with};
use App\Models\Order;

usesPagination();

state([
    // 'orders' => fn() => Order::where('user_id', auth()->id())->get(),
]);

with(
    fn() => [
        'unpaid_orders' => fn() => Order::where('user_id', auth()->id())
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
                    {{ __('Pesanan Dikirim') }}
                </h2>
            </x-slot>

            <div class="py-5">
                <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                    <table class="table text-center my-5">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Atas Nama</th>
                                <th>Jenis order</th>
                                <th>Nomor order</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unpaid_orders as $no => $order)
                                <tr>
                                    <th>{{ ++$no }}</th>
                                    <th>{{ $order }}</th>
                                    <th class="join">

                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
