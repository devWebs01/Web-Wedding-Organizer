<?php

use function Livewire\Volt\{state, rules, usesFileUploads};
use App\Models\Product;

state(['product' => fn() => Product::find($id)]);

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
                        <a href="#" class="btn outline-primary mt-4">Keranjang</a>
                        <a href="#" class="btn outline-primary mt-4">Langsung Beli</a>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
