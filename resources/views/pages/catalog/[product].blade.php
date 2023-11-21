<?php

use function Livewire\Volt\{state};
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Str;

state(['product' => fn() => Product::find($id)]);

$addToCart = function () {
    \Cart::add([
        'id' => Str::random(),
        'name' => $this->product->title,
        'price' => $this->product->price,
        'quantity' => 1,
        'attributes' => [
            'image' => $this->product->image,
        ],
    ]);

    $this->dispatch('count-updated');
};
?>
<x-costumer-layout>
    @volt
        <div>
            <div class="mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="md:flex p-10">
                    <div class="md:shrink-0">
                        <img class="h-48 w-full object-cover md:h-full md:w-48" src="{{ Storage::url($product->image) }}"
                            alt="{{ $product->title }}">
                    </div>
                    <div class="p-8">
                        <div class="badge badge-outline">{{ $product->category->name }}</div>
                        <a href="#"
                            class="block mt-1 text-4xl leading-tight font-medium text-black hover:underline">{{ $product->title }}</a>
                        <p class="mt-2 text-slate-500">{{ $product->description }}</p>
                        <div class="flex gap-4 mt-4">
                            <form wire:submit='addToCart'>
                                <button type="submit" class="btn btn-active btn-neutral hover:btn-outline">
                                    <span wire:loading class="loading loading-spinner"></span>

                                    Keranjang</button>
                            </form>
                            <form action="">
                                <button type="submit" class="btn btn-outline btn-neutral">Langsung Beli</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
