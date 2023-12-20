<?php

use function Livewire\Volt\{state, rules, computed};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Item;
use App\Models\Shop;
use App\Models\Address;

state([
    'order' => fn() => Order::find($id),
    'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(),
    'user' => fn() => Address::where('user_id', auth()->id())->first(),
    'shop' => fn() => Shop::first(),
    'calculateProduct' => fn() => $this->order->total,
    'estimated',
]);

$deleteOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);
    $order->delete();
    $this->redirect('/orders', navigate: true);
};

$courierTIKI = computed(function () {
    $ongkir = \Rajaongkir::getOngkirCost(
        $origin = 1,
        $destination = 200,
        $weight = 300,
        $courier = RajaongkirCourier::TIKI,
    );
    $data = [];
    foreach ($ongkir as $item) {
        foreach ($item['costs'] as $key) {
            foreach ($key['cost'] as $value) {
                $data = [
                    'name' => $item['name'],
                    'price' => $value['value'],
                    'etd' => $value['etd'],
                ];
            }
        }
    }

    return $data;
})->persist();

$courierJNE = computed(function () {
    $ongkir = \Rajaongkir::getOngkirCost($origin = 1, $destination = 200, $weight = 300, $courier = RajaongkirCourier::JNE);
    $data = [];
    foreach ($ongkir as $item) {
        foreach ($item['costs'] as $key) {
            foreach ($key['cost'] as $value) {
                $data = [
                    'name' => $item['name'],
                    'price' => $value['value'],
                    'etd' => $value['etd'],
                ];
            }
        }
    }
    return $data;
})->persist();

?>
<x-costumer-layout>
    @volt
        <div>
            <p lazy>@json($this->courierTIKI())</p>
            <p lazy>@json($this->courierJNE()['price'])</p>
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
                                            {{ $orderItem->qty * $orderItem->product->price }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-8 py-2 px-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Total Pesanan ({{ $orderItems->count() }} Produk)</p>
                                <p class="font-semibold">
                                    Rp. {{ Number::format($this->calculateProduct, locale: 'id') }}
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
                        <!-- Total -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="name" :value="__('Pilih Jasa Pengiriman')" class="mb-2" />
                            <select class="select select-bordered">
                                <option>Pilih salah satu</option>
                                <option>Jalur Nugraha Ekakurir (JNE)</option>
                                <option>Citra Van Titipan Kilat (TIKI)</option>
                            </select>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </label>

                        <!-- Total -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="name" :value="__('Pilih Metode Pembayaran')" class="mb-2" />
                            <select class="select select-bordered">
                                <option>Pilih salah satu</option>
                                <option>COD (Cash On Delivery)</option>
                                <option>Transfer Bank</option>
                            </select>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </label>

                        <!-- Total -->
                        <div class="mt-6 border-t border-b py-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Subtotal untuk Produk</p>
                                <p class="font-semibold"> Rp. {{ Number::format($this->calculateProduct) }}</p>
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
