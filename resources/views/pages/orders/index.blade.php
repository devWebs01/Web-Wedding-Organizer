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

// Unpaid, packed, shipped, completed, cancelled.

?>
<x-costumer-layout>
    @volt
        <div>
            <div class="text-sm breadcrumbs">
                <ul class="px-4 sm:px-6 lg:px-8">
                    <li><a wire:navigate href="/catalog/list">Katalog Produk</a></li>
                    <li><a wire:navigate href="/catalog/cart">Keranjang</a></li>
                    <li><a wire:navigate href="/orders">Pesanan Saya</a></li>
                </ul>
            </div>

            <div class="px-4 sm:px-6 lg:px-8">

                <div class="overflow-x-auto border rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-xl">Belum dibayar
                        <span wire:loading class="loading loading-spinner loading-xs text-error"></span>
                    </h3>
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
                                    <td>Rp. {{ $unpaid->total }}</td>
                                    <td>
                                        <a wire:navigate href="/orders/{{ $unpaid->id }}" class="btn btn-sm">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 mt-4">
                        {{ $unpaid_orders->links() }}
                    </div>
                </div>

                <div class="overflow-x-auto border rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-xl">Pesanan Dikemas
                        <span wire:loading class="loading loading-spinner loading-xs text-error"></span>
                    </h3>
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
                                    <td>Rp. {{ $packed->total }}</td>
                                    <td>
                                        <a wire:navigate href="/orders/{{ $packed->id }}" class="btn btn-sm">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 mt-4">
                        {{ $packed_orders->links() }}
                    </div>
                </div>

                <div class="overflow-x-auto border rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-xl">Pesanan Dikirim
                        <span wire:loading class="loading loading-spinner loading-xs text-error"></span>
                    </h3>
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
                                    <td>Rp. {{ $shipped->total }}</td>
                                    <td>
                                        <a wire:navigate href="/orders/{{ $shipped->id }}" class="btn btn-sm">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 mt-4">
                        {{ $shipped_orders->links() }}
                    </div>
                </div>

                <div class="overflow-x-auto border rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-xl">Pesanan Selesai
                        <span wire:loading class="loading loading-spinner loading-xs text-error"></span>
                    </h3>
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
                                    <td>Rp. {{ $completed->total }}</td>
                                    <td>
                                        <a wire:navigate href="/orders/{{ $completed->id }}" class="btn btn-sm">Lihat</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-4 mt-4">
                        {{ $completed_orders->links() }}
                    </div>
                </div>

                <div class="overflow-x-auto border rounded-xl p-6 mb-8">
                    <h3 class="font-semibold text-xl">Pesanan Dibatalkan
                        <span wire:loading class="loading loading-spinner loading-xs text-error"></span>
                    </h3>
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
                                    <td>Rp. {{ $cancelled->total }}</td>
                                    <td>
                                        <a wire:navigate href="/orders/{{ $cancelled->id }}" class="btn btn-sm">Lihat</a>
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
    @endvolt
</x-costumer-layout>
