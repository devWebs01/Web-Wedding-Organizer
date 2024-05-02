<?php

use function Livewire\Volt\{state, usesPagination, with};
use App\Models\Order;

usesPagination();

state([
    // 'orders' => fn() => Order::where('user_id', auth()->id())->get(),
]);

with(
    fn() => [
        'process_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'UNPAID')->orWhere('status', 'PROGRESS')->orWhere('status', 'PENDING')->latest()->paginate(5),

        'shipped_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'SHIPPED')->orWhere('status', 'PACKED')->latest()->paginate(5),

        'completed_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'COMPLETED')->latest()->paginate(5),

        'cancelled_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'CANCELLED')->latest()->paginate(5),
    ],
);

?>
<x-costumer-layout>
    @volt
        <div>

            <div>
                <div class="sm:px-6 lg:px-8">
                    <div x-data="{ openTab: 1 }" class="py-5">
                        <div class="mx-auto">
                            <div class="mb-4 flex space-x-4 p-2 bg-white rounded-lg shadow-md overflow-auto">
                                <button x-on:click="openTab = 1" :class="{ 'bg-black text-white': openTab === 1 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Proses
                                </button>

                                <button x-on:click="openTab = 2" :class="{ 'bg-black text-white': openTab === 2 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">
                                    Dikirim</button>

                                <button x-on:click="openTab = 3" :class="{ 'bg-black text-white': openTab === 3 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">
                                    Selesai</button>

                                <button x-on:click="openTab = 4" :class="{ 'bg-black text-white': openTab === 4 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">
                                    Dibatalkan</button>
                            </div>

                            <div x-show="openTab === 1"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2 text-center border-b">Proses</p>
                                <div>
                                    <table class="table text-center">
                                        <!-- head -->
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
                                            @foreach ($process_orders as $no => $order)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $order->invoice }}</td>
                                                    <td>
                                                        <div class="badge badge-neutral p-3 uppercase">
                                                            {{ $order->status }}
                                                        </div>
                                                    </td>
                                                    <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a href="/orders/{{ $order->id }}" class="btn btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="px-4 mt-4">
                                        {{ $process_orders->links() }}
                                    </div>
                                </div>
                            </div>

                            <div x-show="openTab === 2"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2 text-center border-b">Dikirm</p>
                                <div>
                                    <table class="table text-center">
                                        <!-- head -->
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
                                            @foreach ($shipped_orders as $no => $order)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $order->invoice }}</td>
                                                    <td>
                                                        <div class="badge badge-neutral p-3 uppercase">
                                                            {{ $order->status }}
                                                        </div>
                                                    </td>
                                                    <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a href="/orders/{{ $order->id }}" class="btn btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="px-4 mt-4">
                                        {{ $shipped_orders->links() }}
                                    </div>
                                </div>
                            </div>

                            <div x-show="openTab === 3"
                                class="transition-all duration-500 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2 text-center border-b">Selesai</p>
                                <div>
                                    <table class="table text-center">
                                        <!-- head -->
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
                                            @foreach ($completed_orders as $no => $order)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $order->invoice }}</td>
                                                    <td>
                                                        <div class="badge badge-neutral p-3 uppercase">
                                                            {{ $order->status }}
                                                        </div>
                                                    </td>
                                                    <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a href="/orders/{{ $order->id }}" class="btn btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="px-4 mt-4">
                                        {{ $completed_orders->links() }}
                                    </div>
                                </div>
                            </div>

                            <div x-show="openTab === 4"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2 text-center border-b">Dibatalkan</p>
                                <div>
                                    <table class="table text-center">
                                        <!-- head -->
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
                                            @foreach ($cancelled_orders as $no => $order)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $order->invoice }}</td>
                                                    <td>
                                                        <div class="badge badge-neutral p-3 uppercase">
                                                            {{ $order->status }}
                                                        </div>
                                                    </td>
                                                    <td>{{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a href="/orders/{{ $order->id }}" class="btn btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="px-4 mt-4">
                                        {{ $cancelled_orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
