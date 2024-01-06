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
    'couriers' => fn() => Courier::where('order_id', $this->order->id)->get(),
    'shipping_cost' => fn() => $this->selectCourier()->value ?? $this->order->shipping_cost,
    'payment_method' => fn() => $this->order->payment_method ?? null,
    'note' => fn() => $this->order->note ?? null,
    'protect_cost' => 0,
]);

state(['courier'])->url();

$protect_cost_opsional = computed(function () {
    return $this->protect_cost ? 3000 : 0;
});

$selectCourier = computed(function () {
    $confirmCourier = Courier::find($this->courier);

    if (!$confirmCourier) {
        return 0;
    } else {
        $this->dispatch('update-selectCourier');
        return $confirmCourier;
    }
});

on([
    'update-selectCourier' => function () {
        $this->shipping_cost = $this->selectCourier()->value ?? 0;
    },
]);

rules(['courier' => 'required', 'payment_method' => 'required']);

$confirmOrder = function () {
    $this->validate();
    $bubble_wrap = $this->protect_cost == 0 ? '' : ' + Bubble Wrap';
    $status_payment = $this->payment_method == 'Transfer Bank' ? 'Unpaid' : 'Pending';
    $order = $this->order;
    $order->update([
        'total_amount' => $order->total_amount + $this->shipping_cost + $this->protect_cost_opsional,
        'shipping_cost' => $this->shipping_cost,
        'payment_method' => $this->payment_method,
        'status' => $status_payment,
        'note' => $this->note,
        'estimated_delivery_time' => $this->selectCourier()->etd,
        'courier' => $this->selectCourier()->description,
        'protect_cost' => $this->protect_cost,
    ]);

    $this->dispatch('delete-couriers', 'courier');

    if ($this->payment_method == 'Transfer Bank') {
        $this->redirect('/payments/' . $order->id, navigate: true);
    } else {
        $this->redirect('/orders', navigate: true);
    }
};

$cancelOrder = function ($orderId) {
    $order = Order::findOrFail($orderId);

    // Mengambil semua item yang terkait dengan pesanan yang dibatalkan
    $orderItems = Item::where('order_id', $order->id)->get();

    // Mengembalikan quantity pada tabel produk
    foreach ($orderItems as $orderItem) {
        $product = Product::findOrFail($orderItem->product_id);
        $newQuantity = $product->quantity + $orderItem->qty;

        // Memperbarui quantity pada tabel produk
        $product->update(['quantity' => $newQuantity]);
    }

    // Memperbarui status pesanan menjadi 'Cancelled'
    $order->update(['status' => 'Cancelled']);

    // Menghapus data kurir terkait
    $this->dispatch('delete-couriers');

    // Redirect ke halaman pesanan setelah pembatalan
    $this->redirect('/orders', navigate: true);
};

on([
    'delete-couriers' => function () {
        Courier::where('order_id', $this->order->id)->delete();
    },
]);

?>
<x-costumer-layout>
    @volt
        <div>
            <p class="hidden">@json($this->selectCourier())</p>
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
            <div class="sm:px-8 mt-4 mx-auto">
                <div role="alert" class="alert shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-black shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>
                        {{ $order->user->name }} <br>
                        {{ $order->user->email }}, {{ $order->user->telp }} <br>
                        {{ $order->user->address->province->name }}, {{ $order->user->address->city->name }} <br>
                        {{ $order->user->address->details }} <br>
                    </span>
                    <div>
                        <button class="btn btn-sm uppercase btn-primary">{{ $order->status }}</button>
                    </div>
                </div>
            </div>

            <div class="grid sm:px-8 lg:grid-cols-2 mx-auto gap-4">
                <div>
                    <div class="mt-4 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                        <p class="font-bold text-xl border-b">Produk Pesanan</p>
                        <div>
                            @foreach ($orderItems as $orderItem)
                                <div class="flex flex-col rounded-lg sm:flex-row">
                                    <img lazy class="m-2 h-24 w-28 rounded-md border object-cover object-center"
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
                        <div class="mt-4 py-2 px-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Total Pesanan ({{ $orderItems->count() }} Produk)</p>
                                <p class="font-semibold">
                                    {{ 'Rp. ' . Number::format($this->order->total_amount, locale: 'id') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-3 rounded-lg border px-2 py-4 sm:px-6">
                    <p class="font-bold text-xl border-b mb-4">Opsi Pengiriman</p>
                    <div>
                        <div role="alert" class="alert bg-neutral text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Estimasi tanggal diterima tergantung pada waktu pengemasan Penjual dan waktu pengiriman ke
                                lokasi
                                Anda.</span>
                        </div>
                    </div>
                    <div>
                        <!-- courier -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="courier" :value="__('Pilih Jasa Pengiriman')" class="mb-2" />
                            @if ($order->status == 'Progress')
                                <select wire:model.live='courier' class="select select-bordered">
                                    <option disabled>Pilih salah satu</option>
                                    @foreach ($couriers as $courier)
                                        <option value="{{ $courier->id }}">
                                            {{ $courier->description }} -
                                            {{ $courier->etd . ' Hari' }} -
                                            {{ 'Rp. ' . Number::format($courier->value, locale: 'id') }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('courier')" class="mt-2" />
                            @else
                                <x-text-input
                                    value="{{ $order->courier . ' - ' . $order->estimated_delivery_time . ' Hari - ' . 'Rp. ' . Number::format($order->shipping_cost, locale: 'id') }}"
                                    disabled></x-text-input>
                            @endif
                        </label>

                        <!-- payment_method -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="payment_method" :value="__('Pilih Metode Pembayaran')" class="mb-2" />
                            <select {{ $order->status == 'Progress' ?: 'disabled' }} wire:model='payment_method'
                                class="select select-bordered">
                                <option>Pilih salah satu</option>
                                <option value="COD (Cash On Delivery)">COD (Cash On Delivery)</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                            </select>

                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </label>

                        <!-- note -->
                        <label class="form-control w-full mb-3">
                            <x-input-label for="note" :value="__('Catatan Tambahan')" class="mb-2" />
                            <textarea wire:target='submit' wire:model.blur="note" class="mt-1 w-full textarea textarea-bordered h-36"
                                {{ $order->status == 'Progress' ?: 'disabled' }} />
                            </textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </label>
                    </div>
                    <div>
                        <div class="form-control">
                            <label class="gap-3 flex">
                                <input wire:model.live='protect_cost' type="checkbox" class="checkbox"
                                    {{ $order->protect_cost == 0 ?: 'checked' }}
                                    {{ $order->protect_cost == null ?: 'disabled' }} />
                                <div>
                                    <h3 class="font-bold">Proteksi Pesanan</h3>
                                    <div class="text-xs">
                                        Melindungi pesanan Anda dari kerusakan yang tidak diinginkan.
                                    </div>
                                    <div class="text-xs">
                                        Rp. 3.000
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <!-- Total -->
                        <div class="mt-6 border-t py-2">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Subtotal untuk Produk</p>
                                <p class="font-semibold"> {{ 'Rp. ' . Number::format($this->order->total_amount) }}</p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Subtotal Pengiriman</p>
                                <p lazy class="font-semibold">
                                    <span wire:loading wire:target='courier'
                                        class="loading loading-xs loading-dots  text-neutral">
                                    </span>
                                    {{ 'Rp. ' . Number::format($shipping_cost, locale: 'id') }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium">Total Pembayaran</p>
                                <p lazy class="font-semibold">
                                    <span wire:loading wire:target='courier'
                                        class="loading loading-xs loading-dots  text-neutral">
                                    </span>
                                    {{ 'Rp. ' . Number::format($order->total_amount + $shipping_cost + $this->protect_cost_opsional(), locale: 'id') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        @if ($order->status == 'Unpaid')
                            <a href="/payments/{{ $order->id }}" wire:navigate
                                class="btn btn-primary btn-wide my-4 mx-3">
                                <span wire:loading wire:target='confirmOrder'
                                    class="loading loading-spinner text-neutral">
                                </span>
                                Lakukan Pembayaran
                            </a>
                            <button wire:click="cancelOrder('{{ $order->id }}')"
                                class="btn btn-error btn-wide text-white my-4 mx-3">
                                <span wire:loading wire:target='cancelOrder' class="loading loading-spinner text-white">
                                </span>
                                Batalkan Pesanan
                            </button>
                        @elseif ($order->status == 'Progress')
                            <button wire:click="confirmOrder('{{ $order->id }}')"
                                class="btn btn-neutral btn-wide my-4 mx-3">
                                <span wire:loading wire:target='confirmOrder'
                                    class="loading loading-spinner text-neutral">
                                </span>
                                Lanjutkan Pembelian
                            </button>
                        @elseif ($order->proof_of_payment != null)
                            <div class="collapse bg-base-200">
                                <input type="checkbox" />
                                <div class="collapse-title text-xl font-medium">
                                    Lihat Bukti Pembayaran {{ $order->status }}
                                </div>
                                <div class="collapse-content">
                                    <img src="{{ Storage::url($order->proof_of_payment) }}" class="w-full rounded-lg"
                                        alt="proof of payment">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-costumer-layout>
