<?php

use function Livewire\Volt\{state, rules, usesFileUploads, computed, uses};
use App\Models\Product;
use App\Models\Category;
use App\Models\Variant;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);
name('products.create');
usesFileUploads();

// product :  'category_id', 'vendor', 'title', 'image'
// variant :  'type', 'product_id', 'description', 'price'

state([
    'categories' => fn() => Category::get(),
    'productId' => '',
    'category_id',
    'vendor',
    'title',
    'image',
]);

rules([
    'category_id' => 'required|exists:categories,id',
    'vendor' => 'required|min:5',
    'title' => 'required|min:5',
    'image' => 'required',
]);

$redirectProductsPage = function () {
    $this->redirectRoute('products.index');
};

$createdProduct = function () {
    $validate = $this->validate();
    $validate['image'] = $this->image->store('public/images');

    if ($this->productId == null) {
        $product = Product::create($validate);
        $this->productId = $product->id;
    } else {
        $product = Product::find($this->productId);
        $product->update($validate);
    }

    $this->alert('success', 'Penginputan produk toko telah selesai dan lengkapi dengan menambahkan varian produk!', [
        'position' => 'center',
        'width' => '500',
        'timer' => 2000,
        'toast' => true,
        'timerProgressBar' => true,
    ]);
};

?>


<x-admin-layout>
    <x-slot name="title">Produk</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.create') }}">Produk Baru</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <form wire:submit="createdProduct" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md mb-3">
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img rounded object-fit-cover"
                                        alt="image" loading="lazy" height="625px" width="100%" />
                                @else
                                    <img src="" class="img rounded object-fit-cover placeholder " alt="image"
                                        loading="lazy" height="625px" width="100%" />
                                @endif
                            </div>
                            <div class="col-md">

                                <div class="mb-3">
                                    <label for="title" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        wire:model="title" id="title" aria-describedby="titleId"
                                        placeholder="Enter product title" />
                                    @error('title')
                                        <small id="titleId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="vendor" class="form-label">Vendor Produk</label>
                                    <input type="text" class="form-control @error('vendor') is-invalid @enderror"
                                        wire:model="vendor" id="vendor" aria-describedby="vendorId"
                                        placeholder="Enter product vendor" />
                                    @error('vendor')
                                        <small id="vendorId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        wire:model="image" id="image" aria-describedby="imageId"
                                        placeholder="Enter product image" accept="image/*" />
                                    @error('image')
                                        <small id="imageId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori Produk</label>
                                    <select class="form-select" wire:model="category_id" id="category_id">
                                        <option>Pilih salah satu</option>
                                        @foreach ($this->categories as $category)
                                            <option value="{{ $category->id }}">- {{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('category_id')
                                        <small id="category_id" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $productId == null ? 'Submit' : 'Edit' }}
                                    </button>
                                    <x-action-message wire:loading on="save">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </x-action-message>
                                </div>

                            </div>
                    </form>
                </div>

                <hr>

                @if ($productId)
                    @livewire('pages.createOrUpdateVariants', ['productId' => $productId, 'title' => $title])

                    <button type="button" wire:click='redirectProductsPage' class="btn btn-primary">Selesai</button>
                @endif



            </div>
        </div>
    @endvolt


</x-admin-layout>
