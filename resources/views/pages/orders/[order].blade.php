<?php

use function Livewire\Volt\{state, rules, computed};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Item;
use App\Models\Shop;
use App\Models\Address;
use App\Models\Courier;

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
    'origin' => fn() => Shop::first(),
    'destination' => fn() => Address::where('user_id', auth()->id())->first(),
    'payment_method',
    'note',
]);

$deleteOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);
    $order->delete();
    $this->redirect('/orders', navigate: true);
};

// $selectOptions = computed(function () {
//     $jneShippingData = [
//         'origin' => $this->origin->city_id,
//         'destination' => $this->destination->city_id,
//         'weight' => $this->order->total_weight,
//         'courier' => RajaongkirCourier::JNE,
//     ];
//     $tikiShippingData = [
//         'origin' => $this->origin->city_id,
//         'destination' => $this->destination->city_id,
//         'weight' => $this->order->total_weight,
//         'courier' => RajaongkirCourier::TIKI,
//     ];

//     $jneOngkirCost = \Rajaongkir::getOngkirCost($jneShippingData['origin'], $jneShippingData['destination'], $jneShippingData['weight'], $jneShippingData['courier']);

//     $tikiOngkirCost = \Rajaongkir::getOngkirCost($tikiShippingData['origin'], $tikiShippingData['destination'], $tikiShippingData['weight'], $tikiShippingData['courier']);

//     $jneShippingCost = $jneOngkirCost[0]['costs']; // Asumsikan hanya terdapat satu hasil kurir
//     $tikiShippingCost = $tikiOngkirCost[0]['costs']; // Asumsikan hanya terdapat satu hasil kurir

//     $combinedShippingCosts = array_merge($jneShippingCost, $tikiShippingCost);

//     foreach ($combinedShippingCosts as $shippingCost) {
//         $courier = new Courier();
//         $courier->description = $shippingCost['description'];
//         $courier->value = $shippingCost['cost'][0]['value'];
//         $courier->etd = $shippingCost['cost'][0]['etd'];
//         $courier->save();
//     }
// });

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
                                <a href="#" class="mr-2 text-sm font-medium">Rincian Pesanan</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>


            <div class="grid sm:px-8 lg:grid-cols-2 mx-auto gap-4">
                <div>
                    <div class="mt-8 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                        <p class="font-bold text-xl border-b">Produk Pesanan</p>
                        <div>
                            @foreach ($orderItems as $orderItem)
                                <div class="flex flex-col rounded-lg sm:flex-row">
                                    <img class="m-2 h-24 w-28 rounded-md border object-cover object-center"
                                        src="{{ Storage::url($orderItem->product->image) }}" alt="" />
                                    <div class="flex w-full flex-col px-4 py-4">
                                        <span class="font-semibold">{{ $orderItem->product->title }}</span>
                                        <span class="float-right ">X {{ $orderItem->qty }} item</span>
                                        <p class="text-lg font-bold">Rp.
                                            {{ Number::format($orderItem->qty * $orderItem->product->price, locale: 'id') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 py-2 px-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Total Pesanan ({{ $orderItems->count() }} Produk)</p>
                                <p class="font-semibold">
                                    Rp. {{ Number::format($this->order->total_amount, locale: 'id') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                        <p class="font-bold text-xl border-b mb-4">Informasi Penerima</p>
                        <div>
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <span class="label-text">Nama Lengkap</span>
                                </div>
                                <input type="text" value="{{ $order->user->name }}" placeholder="Type here"
                                    class="input input-bordered w-full" disabled />
                            </label>
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <span class="label-text">Email</span>
                                </div>
                                <input type="email" value="{{ $order->user->email }}" placeholder="Type here"
                                    class="input input-bordered w-full" disabled />
                            </label>
                            <label class="form-control w-full mb-3">
                                <div class="label">
                                    <span class="label-text">Telepon</span>
                                </div>
                                <input type="text" value="{{ $order->user->telp }}" placeholder="Type here"
                                    class="input input-bordered w-full" disabled />
                            </label>
                        </div>
                    </div>
                </div>


                <div class="mt-8 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                    <p class="font-bold text-xl border-b mb-4">Opsi Pengiriman</p>
                    <div>
                        <!-- origin $ destination -->
                        <div class="join flex justify-between mb-3 align-middle">
                            <div class="join-item">
                                <input type="text" value="{{ $this->origin->province->name }}"
                                    class="input input-bordered text-center" disabled />
                            </div>
                            <div class="join-item lg:hidden">
                                <svg height="40px" width="40px" version="1.1" id="_x32_"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                        stroke="#CCCCCC" stroke-width="1.024"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <style type="text/css">
                                            .st0 {
                                                fill: #000000;
                                            }
                                        </style>
                                        <g>
                                            <path class="st0"
                                                d="M311.069,130.515c-0.963-5.641-5.851-9.768-11.578-9.768H35.43c-7.61,0-13.772,6.169-13.772,13.765 c0,7.61,6.162,13.772,13.772,13.772h64.263c7.61,0,13.772,6.17,13.772,13.773c0,7.603-6.162,13.772-13.772,13.772H13.772 C6.169,175.829,0,181.998,0,189.601c0,7.603,6.169,13.764,13.772,13.764h117.114c6.72,0,12.172,5.46,12.172,12.18 c0,6.72-5.452,12.172-12.172,12.172H68.665c-7.61,0-13.772,6.17-13.772,13.773c0,7.602,6.162,13.772,13.772,13.772h45.857 c6.726,0,12.179,5.452,12.179,12.172c0,6.719-5.453,12.172-12.179,12.172H51.215c-7.61,0-13.772,6.169-13.772,13.772 c0,7.603,6.162,13.772,13.772,13.772h87.014l5.488,31.042h31.52c-1.854,4.504-2.911,9.421-2.911,14.598 c0,21.245,17.218,38.464,38.464,38.464c21.237,0,38.456-17.219,38.456-38.464c0-5.177-1.057-10.094-2.911-14.598h100.04 L311.069,130.515z M227.342,352.789c0,9.146-7.407,16.553-16.553,16.553c-9.152,0-16.56-7.407-16.56-16.553 c0-6.364,3.627-11.824,8.892-14.598h15.329C223.714,340.965,227.342,346.424,227.342,352.789z">
                                            </path>
                                            <path class="st0"
                                                d="M511.598,314.072l-15.799-77.941l-57.689-88.759H333.074l32.534,190.819h38.42 c-1.846,4.504-2.904,9.421-2.904,14.598c0,21.245,17.219,38.464,38.456,38.464c21.246,0,38.464-17.219,38.464-38.464 c0-5.177-1.057-10.094-2.91-14.598h16.741c6.039,0,11.759-2.708,15.582-7.386C511.273,326.136,512.8,319.988,511.598,314.072z M392.529,182.882h26.314l34.162,52.547h-51.512L392.529,182.882z M456.14,352.789c0,9.146-7.407,16.553-16.56,16.553 c-9.138,0-16.552-7.407-16.552-16.553c0-6.364,3.635-11.824,8.892-14.598h15.329C452.513,340.965,456.14,346.424,456.14,352.789z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="join-item">
                                <input type="text" value="{{ $this->destination->province->name }}"
                                    class="input input-bordered text-center" disabled />
                            </div>
                        </div>

                        <!-- courier -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="courier" :value="__('Pilih Jasa Pengiriman')" class="mb-2" />
                            <select wire:model.live='courier' class="select select-bordered">
                                <option value="">Pilih salah satu</option>

                            </select>
                            <x-input-error :messages="$errors->get('courier')" class="mt-2" />
                        </label>

                        <!-- method_payment -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="method_payment" :value="__('Pilih Metode Pembayaran')" class="mb-2" />
                            <select class="select select-bordered">
                                <option>Pilih salah satu</option>
                                <option>COD (Cash On Delivery)</option>
                                <option>Transfer Bank</option>
                            </select>
                            <x-input-error :messages="$errors->get('method_payment')" class="mt-2" />
                        </label>

                        <!-- Total -->
                        <div class="mt-6 border-t border-b py-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Subtotal untuk Produk</p>
                                <p class="font-semibold"> Rp. {{ Number::format($this->order->total_amount) }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Subtotal Pengiriman</p>
                                <p class="font-semibold">$399.00</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Estimasi Pengiriman</p>
                                <p class="font-semibold">$399.00</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Total Pembayaran</p>
                                <p class="font-semibold">$399.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <button wire:click="deleteOrder('{{ $order->id }}')" class="btn btn-neutral btn-wide m-4">
                            <span wire:loading class="loading loading-spinner text-neutral">
                            </span>
                            Batalkan Pesanan
                        </button>
                        <button class="btn btn-primary btn-wide m-4">
                            Lanjutkan Pesanan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-costumer-layout>
