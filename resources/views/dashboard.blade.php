<?php

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use function Livewire\Volt\{state};

state([
    'products' => fn() => Product::count(),
    'customers' => fn() => User::whereRole('customer')->count(),
    'orders' => fn() => Order::count(),
]);

?>
<x-admin-layout>
    @volt
        <div>

        </div>
    @endvolt
</x-admin-layout>
