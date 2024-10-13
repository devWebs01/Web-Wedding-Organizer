<?php

use function Livewire\Volt\{state, usesPagination, with};
use App\Models\Order;

usesPagination(theme: 'bootstrap');

state(['count' => 0]);

$increment = fn() => $this->count++;

// 'UNPAID', 'PROGRESS', 'COMPLETED', 'PENDING', 'CANCELED', 'CONFIRMED'

with(
    fn() => [
        'progress_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'UNPAID')->orWhere('status', 'PROGRESS')->orWhere('status', 'PENDING')->latest()->paginate(5),

        'confirmed_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'CONFIRMED')->latest()->paginate(5),

        'completed_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'COMPLETED')->latest()->paginate(5),

        'canceled_orders' => fn() => Order::where('user_id', auth()->id())->where('status', 'CANCELED')->latest()->paginate(5),
    ],
);

?>
<x-guest-layout>
    <x-slot name="title">Daftar Pesanan</x-slot>
    @volt
        <div>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            Daftar Pesanan
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center">
                        <p>
                            Di sini kamu dapat melihat daftar pesanan, status pengiriman, dan rincian transaksi kamu. Ini
                            akan memudahkan kamu melacak pembelian kamu sebelumnya.
                        </p>
                    </div>
                </div>

                <div class="card rounded-top-5 px-3 mb-3">
                    <ul class="nav nav-pills m-3 align-self-center gap-4" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active position-relative" id="pills-progress_orders-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-progress_orders" type="button" role="tab"
                                aria-controls="pills-progress_orders" aria-selected="true">Masih Proses

                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($progress_orders) }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="pills-confirmed_orders-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-confirmed_orders" type="button" role="tab"
                                aria-controls="pills-confirmed_orders" aria-selected="false">
                                Pengerjaan
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($confirmed_orders) }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="pills-completed_orders-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-completed_orders" type="button" role="tab"
                                aria-controls="pills-completed_orders" aria-selected="false">
                                Pesanan Selesai
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($completed_orders) }}
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link position-relative" id="pills-canceled_orders-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-canceled_orders" type="button" role="tab"
                                aria-controls="pills-canceled_orders" aria-selected="false">
                                Pembatalan
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ count($canceled_orders) }}
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-progress_orders" role="tabpanel"
                        aria-labelledby="pills-progress_orders-tab" tabindex="0">
                        <div class="card rounded-bottom-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
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
                                            @foreach ($progress_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #f35525">
                                                            {{ __('status.' . $item->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ formatRupiah($item->total_amount) }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $progress_orders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-confirmed_orders" role="tabpanel"
                        aria-labelledby="pills-confirmed_orders-tab" tabindex="0">
                        <div class="card rounded-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Invoice</th>
                                                <th>Resi</th>
                                                <th>Status</th>
                                                <th>Total Pesanan</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($confirmed_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>{{ $item->tracking_number }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #f35525">
                                                            {{ __('status.' . $item->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ formatRupiah($item->total_amount) }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $progress_orders->links() }}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-completed_orders" role="tabpanel"
                        aria-labelledby="pills-completed_orders-tab" tabindex="0">
                        <div class="card rounded-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
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
                                            @foreach ($completed_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #f35525">
                                                            {{ __('status.' . $item->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ formatRupiah($item->total_amount) }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $progress_orders->links() }}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-canceled_orders" role="tabpanel"
                        aria-labelledby="pills-canceled_orders-tab" tabindex="0">
                        <div class="card rounded-5">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-center">
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
                                            @foreach ($canceled_orders as $no => $item)
                                                <tr>
                                                    <th>{{ ++$no }}</th>
                                                    <td>{{ $item->invoice }}</td>
                                                    <td>
                                                        <span class="badge rounded-pill p-2"
                                                            style="background-color: #f35525">
                                                            {{ __('status.' . $item->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ formatRupiah($item->total_amount) }}
                                                    </td>
                                                    <td>
                                                        <a wire:navigate href="/orders/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-dark">Lihat</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{ $progress_orders->links() }}
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-guest-layout>
