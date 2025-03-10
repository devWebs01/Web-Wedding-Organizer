<?php

use function Livewire\Volt\{state, rules, usesFileUploads, uses, computed};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Storage; // Untuk menghapus file lama
use function Laravel\Folio\name;
use App\Models\Category;
use App\Models\Product;
use App\Models\Image;

uses([LivewireAlert::class]);

name('products.edit');
usesFileUploads();

state([
    'categories' => fn() => Category::get(),
    'productId' => fn() => $this->product->id,
    'category_id' => fn() => $this->product->category_id,
    'price' => fn() => $this->product->price,
    'title' => fn() => $this->product->title,
    'description' => fn() => $this->product->description,
    'imageother' => [],
    'previmageother',
    'image',
    'product',
]);

rules([
    'category_id' => 'required|exists:categories,id',
    'title' => 'required|min:5',
    'price' => 'required|numeric',
    'description' => 'required|min:5',
    'image' => 'nullable',
]);

$updatingimageother = function ($value) {
    $this->previmageother = $this->imageother;
};

$updatedimageother = function ($value) {
    $this->imageother = array_merge($this->previmageother, $value);
};

$removeItem = function ($key) {
    if (isset($this->imageother[$key])) {
        $file = $this->imageother[$key];
        $file->delete();
        unset($this->imageother[$key]);
    }

    $this->imageother = array_values($this->imageother);
};

$edit = function () {
    $validate = $this->validate();
    $product = $this->product;

    if ($this->image) {
        $validate['image'] = $this->image->store('public/images');
        Storage::delete($this->product->image);
    } else {
        $validate['image'] = $this->product->image;
    }

    Product::whereId($this->product->id)->update($validate);

    // Perbarui atau buat produk baru
    if ($this->productId) {
        $product = Product::find($this->productId);
        $product->update($validate);
    } else {
        $product = Product::create($validate);
        $this->productId = $product->id;
    }

    if (count($this->imageother) > 0) {
        $imageother = Image::where('product_id', $product->id)->get();

        if ($imageother->isNotEmpty()) {
            foreach ($imageother as $image) {
                Storage::delete($image->image_path);

                $image->delete();
            }
        }

        foreach ($this->imageother as $image) {
            $path = $image->store('public/images');
            Image::create([
                'product_id' => $product->id,
                'image_path' => $path,
            ]);

            $image->delete();
        }
    }

    $this->alert('success', 'Penginputan layanan gallery telah selesai', [
        'position' => 'center',
        'width' => '500',
        'timer' => 2000,
        'toast' => true,
        'timerProgressBar' => true,
    ]);
    $this->redirectRoute('products.index');
};

?>
<x-admin-layout>
    <x-slot name="title">Layanan</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Layanan Gallery</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('products.edit', ['product' => $product->id]) }}">{{ $product->title }}</a></li>
    </x-slot>

    @include('layouts.fancybox')
    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <form wire:submit="edit" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md mb-3">
                                @if ($image)
                                    <a data-fancybox data-src="{{ $image->temporaryUrl() }}">
                                        <img src="{{ $image->temporaryUrl() }}" class="img rounded object-fit-cover"
                                            alt="image" loading="lazy" height="625px" width="100%" />
                                    </a>
                                @elseif ($product->image)
                                    <a data-fancybox data-src="{{ Storage::url($product->image) }}">
                                        <img src="{{ Storage::url($product->image) }}" class="img rounded object-fit-cover"
                                            alt="image" loading="lazy" height="625px" width="100%" />
                                    </a>
                                @endif
                            </div>
                            <div class="col-md">

                                <div class="mb-3">
                                    <label for="title" class="form-label">Nama </label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        wire:model="title" id="title" aria-describedby="titleId"
                                        placeholder="Enter..." />
                                    @error('title')
                                        <small id="titleId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        wire:model="price" id="price" aria-describedby="priceId"
                                        placeholder="Enter..." />
                                    @error('price')
                                        <small id="priceId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Thumbnail</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        wire:model="image" id="image" aria-describedby="imageId" placeholder="Enter..."
                                        accept="image/*" />
                                    @error('image')
                                        <small id="imageId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Kategori </label>
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
                                    <label for="imageother" class="form-label">Gambar Lainnya</label>
                                    <input type="file" class="form-control @error('imageother.*') is-invalid @enderror"
                                        wire:model="imageother" id="imageother" aria-describedby="imageotherId"
                                        placeholder="Enter imageother" accept="image/*" multiple />
                                    @error('imageother.*')
                                        <small id="imageotherId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea wire:model='description' class="form-control @error('description') is-invalid @enderror" name="description"
                                        id="description" rows="3"></textarea>
                                    @error('description')
                                        <small id="descriptionId" class="form-text text-danger">{{ $message }}</small>
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
                @if ($imageother)
                    <div class="mb-5">
                        <div class="d-flex flex-nowrap gap-3 overflow-auto" style="white-space: nowrap;">
                            @foreach ($imageother as $key => $image)
                                <div class="position-relative" style="width: 200px; flex: 0 0 auto;">
                                    <div class="card mt-3">
                                        <a data-fancybox data-src="{{ $image->temporaryUrl() }}">
                                        <img src="{{ $image->temporaryUrl() }}" class="card-img-top"
                                        style="object-fit: cover; width: 200px; height: 200px;" alt="preview">
                                    </a>
                                        <a type="button" class="position-absolute top-0 start-100 translate-middle p-2"
                                            wire:click.prevent='removeItem({{ json_encode($key) }})'>
                                            <i class='bx bx-x p-2 rounded-circle ri-20px text-white bg-danger'></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($product->images->isNotEmpty())
                    <div class="mb-5">
                        <div class="alert alert-warning mb-0 d-flex align-items-center justify-content-center fw-bolder"
                            role="alert">
                            <span class="display-6 mx-3">
                                <iconify-icon icon="solar:shield-warning-linear"></iconify-icon>
                            </span>
                            <small class="fs-3">(Tidak perlu menginputkan gambar lagi jika tidak ingin
                                mengubah gambar lainnya)</small>
                        </div>
                        <div class="d-flex flex-nowrap gap-3 overflow-auto" style="white-space: nowrap;">
                            @foreach ($product->images as $key => $image)
                                <div class="position-relative" style="width: 200px; flex: 0 0 auto;">
                                    <div class="card mt-3">
                                        <a data-fancybox="gallery" data-src="{{ Storage::url($image->image_path) }}">
                                        <img src="{{ Storage::url($image->image_path) }}" class="card-img-top"
                                        style="object-fit: cover; width: 200px; height: 200px;" alt="preview">
                                    </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    @endvolt
</x-admin-layout>
