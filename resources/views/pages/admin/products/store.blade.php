<?php

use function Livewire\Volt\{state, rules, usesFileUploads, computed, uses};
use App\Models\Product;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Image;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);
name('products.create');
usesFileUploads();


state([
    'categories' => fn() => Category::get(),
    'productId' => '',
    'image_other' => [],
    'category_id',
    'vendor',
    'title',
    'image',
]);

rules([
    'category_id' => 'required|exists:categories,id',
    'vendor' => 'required|min:5',
    'title' => 'required|min:5',
    'image' => 'required|image',
    'image_other' => 'nullable',
    'image_other.*' => 'image',
]);

$redirectProductsPage = function () {
    $this->redirectRoute('products.index');
};

$create = function () {
    $validate = $this->validate();
    $validate['image'] = $this->image->store('public/images');

    $image_other = $this->image_other;

    if ($this->productId == null) {
        $product = Product::create($validate);
        $this->productId = $product->id;
    } else {
        $product = Product::find($this->productId);
        $product->update($validate);
    }

    foreach ($image_other as $item) {
        $imagePath = $item->store('public/image_other');

        Image::create([
            'product_id' => $product->id,
            'image_path' => $imagePath, // Memperbaiki untuk menyimpan path gambar
        ]);
    }

    $this->alert('success', 'Penginputan layanan gallery telah selesai dan lengkapi dengan menambahkan varian layanan!', [
        'position' => 'center',
        'width' => '500',
        'timer' => 2000,
        'toast' => true,
        'timerProgressBar' => true,
    ]);
};

?>


<x-admin-layout>
    <x-slot name="title">Layanan</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Layanan</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.create') }}">Layanan Baru</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <form wire:submit="create" enctype="multipart/form-data">
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
                                    <label for="title" class="form-label">Nama Layanan</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        wire:model="title" id="title" aria-describedby="titleId"
                                        placeholder="Enter product title" />
                                    @error('title')
                                        <small id="titleId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="vendor" class="form-label">Vendor Layanan</label>
                                    <input type="text" class="form-control @error('vendor') is-invalid @enderror"
                                        wire:model="vendor" id="vendor" aria-describedby="vendorId"
                                        placeholder="Enter product vendor" />
                                    @error('vendor')
                                        <small id="vendorId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Layanan</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        wire:model="image" id="image" aria-describedby="imageId"
                                        placeholder="Enter product image" accept="image/*" />
                                    @error('image')
                                        <small id="imageId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori Layanan</label>
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
                                    <label for="image_other" class="form-label">Gambar Lainnya</label>
                                    <input type="file" class="form-control @error('image_other.*') is-invalid @enderror"
                                        wire:model="image_other" id="image_other" aria-describedby="image_otherId"
                                        placeholder="Enter product image_other" accept="image/*" multiple />
                                    @error('image_other.*')
                                        <small id="image_otherId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $productId == null ? 'Submit' : 'Edit' }}
                                    </button>
                                    <x-action-message wire:loading on="create">
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
