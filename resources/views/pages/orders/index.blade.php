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
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li>
                            <div class="flex items-center">
                                <a href="/orders" class="mr-2 text-sm font-medium text-gray-900">Pesanan Saya</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="px-4 sm:px-6 lg:px-8 pt-6">
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
                                    <td>{{ 'Rp. ' . Number::format($unpaid->total_amount, locale: 'id') }}</td>
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
                                    <td>{{ 'Rp. ' . Number::format($packed->total_amount, locale: 'id') }}</td>
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
                                    <td>{{ 'Rp. ' . Number::format($shipped->total_amount, locale: 'id') }}</td>
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
                                    <td>{{ 'Rp. ' . Number::format($completed->total_amount, locale: 'id') }}</td>
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
                                    <td>{{ 'Rp. ' . Number::format($cancelled->total_amount, locale: 'id') }}</td>
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
