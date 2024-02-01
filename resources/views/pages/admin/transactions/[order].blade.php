<?php

use function Livewire\Volt\{state, rules};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Item;

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
    'tracking_number',
]);

rules([
    'tracking_number' => 'required|min:10',
]);

$confirm = function () {
    $this->order->update(['status' => 'PACKED']);
    $this->dispatch('order-update');
};

$submitTrackingNumber = function () {
    $validate = $this->validate();
    $validate['status'] = 'SHIPPED';

    $this->order->update($validate);
    $this->dispatch('order-update');
};

?>
<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl dark:text-gray-200 leading-tight">
                    Pesanan #{{ $order->invoice }}
                </h2>
            </x-slot>
            <!-- Invoice -->

            <div class="bg-white sm:mx-6 lg:mx-8 rounded-lg shadow-md border-l-4 border-black">
                <div class="max-w-[85rem] py-5 pb-10 px-4 mx-auto my-4 sm:my-10">
                    <!-- Grid -->
                    <div class="mb-5 pb-5 grid justify-between items-center border-b md:grid-cols-2 grid-rows-1 gap-4">
                        <div>
                            <h2 class="text-2xl font-semibold dark:text-gray-200">Faktur Pesanan</h2>
                        </div>
                        <!-- Col -->

                        <div class="text-right">
                            @if ($order->status == 'PENDING')
                                <button wire:click='confirm' class="btn ">
                                    <span class="loading loading-spinner loading-md" wire:loading
                                        wire:target='confirm'></span>
                                    Konfirmasi Pesanan</button>
                            @elseif ($order->status == 'PACKED')
                                <form wire:submit="submitTrackingNumber">

                                    <div class="join gap-3">
                                        <div class="join-item">
                                            <input wire:model='tracking_number' type="text"
                                                placeholder="Masukkan Resi Pesanan"
                                                class="input input-bordered @error('tracking_number')
                                                input-error
                                                @enderror w-full max-w-md" />
                                        </div>
                                        <div class="join-item">
                                            <button type="submit" class="btn btn-neutral">
                                                <span class="loading loading-spinner loading-md" wire:loading
                                                    wire:target='submitTrackingNumber'></span>
                                                Submit</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <!-- Col -->
                    </div>
                    <!-- End Grid -->
                    <!-- Grid -->
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <div class="grid space-y-3">
                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Pesanan Dari:
                                    </dt>
                                    <dd class="dark:text-gray-200 font-bold">
                                        {{ $order->user->name }}
                                    </dd>
                                </dl>
                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Status Pesanan:
                                    </dt>
                                    <dd class="dark:text-gray-200 font-bold uppercase">
                                        {{ $order->status }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Rincian Pembeli:
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        <div>
                                            <span class="block font-semibold">{{ $order->user->name }}</span>
                                            {{ $order->user->email }}<br>
                                            {{ $order->user->telp }}<br>
                                        </div>
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Rincian Pengiriman:
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        <div class="text-ballence">
                                            <span class="text-wrap" style="overflow-wrap: anywhere;">
                                                {{ $order->user->name }}
                                                <br>
                                                {{ $order->user->address->province->name }},
                                                {{ $order->user->address->city->name }} <br>
                                                {{ $order->user->address->details }}
                                            </span>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <!-- Col -->

                        <div>
                            <div class="grid space-y-3">
                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Nomor Faktur:
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        {{ $order->invoice }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Nomor Resi Pesanan:
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        {{ $order->tracking_number ?? '-' }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Total Pembayaran:
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        {{ 'Rp. ' . Number::format($order->total_amount, locale: 'id') }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Kurir:
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        {{ $order->courier }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Tambahan :
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        {{ $order->protect_cost == true ? 'Bubble Wrap' : '-' }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Metode Pembayaran:
                                    </dt>
                                    <dd class="font-medium dark:text-gray-200">
                                        {{ $order->payment_method }}
                                    </dd>
                                </dl>
                                @if ($order->payment_method == 'Transfer Bank')
                                    <dl class="grid sm:flex gap-x-3 text-sm">
                                        <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                            Bukti Pembayaran:
                                        </dt>
                                        <dd class="font-medium dark:text-gray-200">
                                            <img src="{{ Storage::url($order->proof_of_payment) }}" alt=""
                                                width="120" class="rounded">
                                        </dd>
                                    </dl>
                                @endif
                            </div>
                        </div>
                        <!-- Col -->
                    </div>
                    <!-- End Grid -->

                    <!-- Table -->
                    <div class="mt-6 border border-gray-200 p-4 rounded-lg space-y-4 dark:border-gray-700">
                        <div class="hidden sm:grid sm:grid-cols-5">
                            <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase">Produk</div>
                            <div class="text-start text-xs font-medium text-gray-500 uppercase">Jumlah</div>
                            <div class="text-start text-xs font-medium text-gray-500 uppercase">Harga Produk</div>
                            <div class="text-end text-xs font-medium text-gray-500 uppercase">Total Harga</div>
                        </div>

                        @foreach ($orderItems as $item)
                            <div class="hidden sm:block border-b border-gray-200 dark:border-gray-700"></div>

                            <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                                <div class="col-span-full sm:col-span-2">
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Produk</h5>
                                    <p class="font-medium dark:text-gray-200">
                                        {{ Str::limit($item->product->title, 30, '...') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Jumlah</h5>
                                    <p class="dark:text-gray-200 ml-4">{{ $item->qty }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Harga Produk</h5>
                                    <p class="dark:text-gray-200 ml-2">
                                        {{ 'Rp.' . Number::format($item->product->price, locale: 'id') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Total Harga</h5>
                                    <p class="sm:text-end dark:text-gray-200">
                                        {{ 'Rp.' . Number::format($item->product->price * $item->qty, locale: 'id') }}</p>
                                </div>
                            </div>

                            <div class="sm:hidden border-b border-gray-200 dark:border-gray-700"></div>
                        @endforeach

                    </div>
                    <!-- End Table -->

                    <!-- Flex -->
                    <div class="mt-8 flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-end space-y-2">
                            <!-- Grid -->
                            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500">Subtotal:</dt>
                                    <dd class="col-span-2 font-medium dark:text-gray-200">
                                        {{ 'Rp.' .
                                            Number::format(
                                                $order->items->sum(function ($item) {
                                                    return $item->qty * $item->product->price;
                                                }),
                                                locale: 'id',
                                            ) }}
                                        </td>
                                    </dd>
                                </dl>

                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500">Biaya Pengiriman:</dt>
                                    <dd class="col-span-2 font-medium dark:text-gray-200">
                                        {{ 'Rp.' . Number::format($order->shipping_cost, locale: 'id') }}</dd>
                                </dl>
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500">Berat Barang:</dt>
                                    <dd class="col-span-2 font-medium dark:text-gray-200">
                                        {{ $order->total_weight }} gram</dd>
                                </dl>
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500">Biaya Tambahan:</dt>
                                    <dd class="col-span-2 font-medium dark:text-gray-200">
                                        Rp. 3000</dd>
                                </dl>

                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500 font-extrabold text-xl">Total:</dt>
                                    <dd class="col-span-2 dark:text-gray-200 font-extrabold text-xl">
                                        {{ 'Rp.' . Number::format($order->total_amount, locale: 'id') }}</dd>
                                </dl>
                            </div>
                            <!-- End Grid -->
                        </div>
                    </div>
                    <!-- End Flex -->
                </div>
            </div>
            <!-- End Invoice -->
        </div>
    @endvolt
</x-app-layout>
