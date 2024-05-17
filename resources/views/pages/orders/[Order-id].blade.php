<?php

use function Livewire\Volt\{state, rules, computed, on};
use Dipantry\Rajaongkir\Constants\RajaongkirCourier;
use App\Models\Order;
use App\Models\Item;
use App\Models\Courier;
use App\Models\Product;

state(['order', 'orderItems' => fn() => Item::where('order_id', $this->order->id)->get(), 'couriers' => fn() => Courier::where('order_id', $this->order->id)->get(), 'shipping_cost' => fn() => $this->selectCourier()->value ?? $this->order->shipping_cost, 'payment_method' => fn() => $this->order->payment_method ?? null, 'note' => fn() => $this->order->note ?? null, 'protect_cost' => 0]);

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
    $status_payment = $this->payment_method == 'Transfer Bank' ? 'UNPAID' : 'PENDING';
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

    // Memperbarui status pesanan menjadi 'CANCELLED'
    $order->update(['status' => 'CANCELLED']);

    // Menghapus data kurir terkait
    $this->dispatch('delete-couriers');

    // Redirect ke halaman pesanan setelah pembatalan
    $this->redirect('/orders', navigate: true);
};

$complatedOrder = fn() => $this->order->update(['status' => 'COMPLETED']);

on([
    'delete-couriers' => function () {
        Courier::where('order_id', $this->order->id)->delete();
    },
]);

?>
<x-guest-layout>
    <x-slot name="title">Pesanan </x-slot>
    @volt
        <div>
            <p class="d-none">@json($this->selectCourier())</p>

            <div class="container">
                <div class="row my-4">
                    <div class="col-lg-6">
                        <h2 id="font-custom" class="display-4 fw-bold">
                            {{ $order->invoice }}
                        </h2>
                    </div>
                    <div class="col-lg-6 mt-4 mt-lg-0 align-content-center fun-facts">
                        <div class="counter float-start float-lg-end">
                            <span id="font-custom" class="fs-4 fw-bold">{{ $order->status }}</span>
                        </div>
                    </div>

                    <div class="alert alert-white border mt-3 d-flex align-items-center rounded-5" role="alert">
                        <span class="fs-1 me-4">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <strong class="fs-5">
                            {{ $order->user->name . ', ' . $order->user->email . ', ' . $order->user->telp }}
                            <br>

                            <span style="color: #f35525">
                                {{ $order->user->address->province->name . ', ' . $order->user->address->city->name . ', ' . $order->user->address->details }}
                            </span>
                        </strong>
                    </div>

                </div>
            </div>

        </div>
    @endvolt
</x-guest-layout>
