<?php

use function Livewire\Volt\{computed};
use App\Models\Category;
use App\Models\Product;

$randomProducts = computed(function () {
    return Product::inRandomOrder()->limit(6)->get();
});

?>

@volt
    <div>
        <div class="row">
            @foreach ($this->randomProducts as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="item bg-body border rounded-top-circle">
                        <a href="{{ route('product-detail', ['product' => $product->id]) }}"><img
                                src="{{ Storage::url($product->image) }}" alt="{{ $product->title }}"
                                class="object-fit-cover rounded-top-circle" style="width: 100%; height: 300px;"></a>
                        <span class="category">
                            {{ Str::limit($product->category->name, 13, '...') }}
                        </span>
                        <h6>
                            {{ 'Rp. ' . Number::format($product->price, locale: 'id') }}
                        </h6>
                        <h4>
                            <a href="{{ route('product-detail', ['product' => $product->id]) }}">
                                {{ Str::limit($product->title, 50, '...') }}
                            </a>
                        </h4>
                        <div class="main-button">
                            <a href="{{ route('product-detail', ['product' => $product->id]) }}">Beli</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endvolt
