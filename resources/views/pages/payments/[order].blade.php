<?php

use function Livewire\Volt\{state, with};
use App\Models\Order;

state([
    'order' => fn() => Order::find($id),
]);

?>
<x-costumer-layout>
    @volt
        <div>
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li>
                            <div class="flex items-center">
                                <a href="/orders" class="mr-2 text-sm font-medium">Pesanan Saya</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                    class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="/orders/{{ $order->id }}" class="mr-2 text-sm font-medium">Rincian Pesanan</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                    aria-hidden="true" class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="/payments/{{ $order->id }}" class="mr-2 text-sm font-medium">Rincian
                                    Pembayaran</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="grid sm:px-8 lg:grid-cols-2 mx-auto gap-4">
                <div>
                    kk

                </div>
            </div>

        </div>
    @endvolt
</x-costumer-layout>
