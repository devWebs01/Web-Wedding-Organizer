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

        'packed_orders' => fn() => Order::where('user_id', auth()->id())
            ->where('status', 'packed')
            ->latest()
            ->paginate(5),

        'shipped_orders' => fn() => Order::where('user_id', auth()->id())
            ->where('status', 'shipped')
            ->latest()
            ->paginate(5),

        'completed_orders' => fn() => Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->paginate(5),

        'cancelled_orders' => fn() => Order::where('user_id', auth()->id())
            ->where('status', 'cancelled')
            ->latest()
            ->paginate(5),
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
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Belum
                                    Dibayar</button>

                                <button x-on:click="openTab = 2" :class="{ 'bg-black text-white': openTab === 2 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Pesanan
                                    Dikemas</button>

                                <button x-on:click="openTab = 3" :class="{ 'bg-black text-white': openTab === 3 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Pesanan
                                    Dikirim</button>

                                <button x-on:click="openTab = 4" :class="{ 'bg-black text-white': openTab === 4 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Pesanan
                                    Selesai</button>

                                <button x-on:click="openTab = 5" :class="{ 'bg-black text-white': openTab === 5 }"
                                    class="flex-1 py-2 px-4 rounded-md focus:outline-none focus:shadow-outline-blue transition-all duration-300">Pesanan
                                    Dibatalkan</button>
                            </div>

                            <div x-show="openTab === 1"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2">Belum Dibayar</p>
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
                                            @foreach ($unpaid_orders as $no => $unpaid)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $unpaid->invoice }}</td>
                                                    <td>{{ $unpaid->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($unpaid->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $unpaid->id }}"
                                                            class="btn btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="px-4 mt-4">
                                        {{ $unpaid_orders->links() }}
                                    </div>
                                </div>
                            </div>

                            <div x-show="openTab === 2"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2">Pesanan Dikemas</p>
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
                                            @foreach ($packed_orders as $no => $packed)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $packed->invoice }}</td>
                                                    <td>{{ $packed->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($packed->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $packed->id }}"
                                                            class="btn btn-sm">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="px-4 mt-4">
                                        {{ $packed_orders->links() }}
                                    </div>
                                </div>
                            </div>

                            <div x-show="openTab === 3"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2">Pesanan Dikirm</p>
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
                                            @foreach ($shipped_orders as $no => $shipped)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $shipped->invoice }}</td>
                                                    <td>{{ $shipped->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($shipped->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $shipped->id }}"
                                                            class="btn btn-sm">Lihat</a>
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

                            <div x-show="openTab === 4"
                                class="transition-all duration-500 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2">Pesanan Selesai</p>
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
                                            @foreach ($completed_orders as $no => $completed)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $completed->invoice }}</td>
                                                    <td>{{ $completed->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($completed->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $completed->id }}"
                                                            class="btn btn-sm">Lihat</a>
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

                            <div x-show="openTab === 5"
                                class="transition-all duration-300 bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <p class="text-md font-semibold mb-2">Pesanan Dibatalkan</p>
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
                                            @foreach ($cancelled_orders as $no => $cancelled)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $cancelled->invoice }}</td>
                                                    <td>{{ $cancelled->status }}</td>
                                                    <td>{{ 'Rp. ' . Number::format($cancelled->total_amount, locale: 'id') }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $cancelled->id }}"
                                                            class="btn btn-sm">Lihat</a>
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
