<?php

use function Livewire\Volt\{state, rules, computed, on};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Item;
use App\Models\Courier;
use App\Models\Product;

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
]);

?>
<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Pesanan #{{ $order->invoice }}
                </h2>
            </x-slot>
            <!-- Invoice -->

            <div class="bg-white sm:mx-6 lg:mx-8 rounded-lg shadow-md border-l-4 border-black">
                <div class="max-w-[85rem] pt-5 pb-10 px-4 mx-auto my-4 sm:my-10">
                    <!-- Grid -->
                    <div class="mb-5 flex justify-between items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Faktur Pesanan</h2>
                        </div>
                        <!-- Col -->

                        {{-- <div class="inline-flex gap-x-2">
                            <a class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-gray-800 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                                href="#">
                                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" x2="12" y1="15" y2="3" />
                                </svg>
                                Invoice PDF
                            </a>
                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                href="#">
                                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9" />
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                                    <rect width="12" height="8" x="6" y="14" />
                                </svg>
                                Print
                            </a>
                        </div> --}}
                        <!-- Col -->
                    </div>
                    <!-- End Grid -->
                    <!-- Grid -->
                    <div class="grid md:grid-cols-2 gap-3">
                        <div>
                            <div class="grid space-y-3">
                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Pesanan dari:
                                    </dt>
                                    <dd class="text-gray-800 dark:text-gray-200">
                                        <a class="inline-flex items-center gap-x-1.5 text-blue-600 decoration-2 hover:underline font-medium"
                                            href="#">
                                            {{ $order->user->name }}
                                        </a>
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Rincian Pembeli:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-gray-200">
                                        <span class="block font-semibold">{{ $order->user->name }}</span>
                                        <address class="not-italic font-normal">
                                            {{ $order->user->email }},<br>
                                            {{ $order->user->telp }},<br>
                                        </address>
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Rincian Pengiriman:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-gray-200">
                                        <span class="block font-semibold">{{ $order->user->name }}</span>
                                        <address class="not-italic font-normal">
                                            {{ $order->user->address->province->name }},
                                            {{ $order->user->address->city->name }}<br>
                                            {{ $order->user->address->details }}<br>
                                        </address>
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
                                    <dd class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ $order->invoice }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Total Pembayaran:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ $order->total_amount }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Kurir:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ $order->courier }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Tambahan :
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ $order->protect_cost == true ? 'Bubble Wrap' : '-' }}
                                    </dd>
                                </dl>

                                <dl class="grid sm:flex gap-x-3 text-sm">
                                    <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                        Metode Pembayaran:
                                    </dt>
                                    <dd class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ $order->payment_method }}
                                    </dd>
                                </dl>
                                @if ($order->payment_method == 'Transfer Bank')
                                    <dl class="grid sm:flex gap-x-3 text-sm">
                                        <dt class="min-w-[150px] max-w-[200px] text-gray-500">
                                            Bukti Pembayaran:
                                        </dt>
                                        <dd class="font-medium text-gray-800 dark:text-gray-200">
                                            <img src="{{ Storage::url($order->image) }}" alt="" class="max-w-md">
                                        </dd>
                                    </dl>
                                @else
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
                                    <p class="font-medium text-gray-800 dark:text-gray-200">
                                        {{ Str::limit($item->product->title, 30, '...') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Jumlah</h5>
                                    <p class="text-gray-800 dark:text-gray-200">{{ $item->qty }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Harga Produk</h5>
                                    <p class="text-gray-800 dark:text-gray-200">
                                        {{ 'Rp.' . Number::format($item->product->price, locale: 'id') }}</p>
                                </div>
                                <div>
                                    <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase">Total Harga</h5>
                                    <p class="sm:text-end text-gray-800 dark:text-gray-200">
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
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">
                                        {{ 'Rp.' . Number::format($item->qty * $item->product->price, locale: 'id') }}</td>
                                    </dd>
                                </dl>

                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500">Biaya Pengiriman:</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">
                                        {{ 'Rp.' . Number::format($order->shipping_cost, locale: 'id') }}</dd>
                                </dl>
                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500">Biaya Tambahan:</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">
                                        Rp. 3000</dd>
                                </dl>

                                <dl class="grid sm:grid-cols-5 gap-x-3 text-sm">
                                    <dt class="col-span-3 text-gray-500">Total:</dt>
                                    <dd class="col-span-2 font-medium text-gray-800 dark:text-gray-200">
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
