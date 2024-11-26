<?php

use function Livewire\Volt\{state, rules, usesFileUploads, uses, computed};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Storage; // Untuk menghapus file lama
use function Laravel\Folio\name;
use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Image;

uses([LivewireAlert::class]);

name('products.edit');
usesFileUploads();

// product :  'category_id', 'vendor', 'title', 'image'
// variant :  'product_id', 'name', 'description', 'price'

state([
    'categories' => fn() => Category::get(),
    'productId' => fn() => $this->product->id,
    'category_id' => fn() => $this->product->category_id,
    'vendor' => fn() => $this->product->vendor,
    'title' => fn() => $this->product->title,
    'image_other' => [],
    'image',
    'product',
]);

rules([
    'category_id' => 'required|exists:categories,id',
    'title' => 'required|min:5',
    'vendor' => 'required|min:5',
    'image' => 'nullable',
]);

$edit = function () {
    $validate = $this->validate();
    $image_other = $this->image_other;
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

    // Tangani gambar tambahan (image_other) jika ada
    if (!empty($image_other)) {
        $this->validate([
            'image_other' => 'nullable', // Gambar tambahan bersifat opsional
            'image_other.*' => 'image|max:2048', // Validasi setiap elemen gambar
        ]);

        $findImages = Image::where('product_id', $product->id)->get();

        if ($findImages->isNotEmpty()) {
            foreach ($findImages as $image) {
                Storage::delete($image->image_path);
                $image->delete();
            }
        }

        foreach ($image_other as $item) {
            $imagePath = $item->store('public/image_other');
            Image::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
            ]);
        }
    }

    $this->alert('success', 'Penginputan layanan gallery telah selesai dan lengkapi dengan menambahkan varian layanan!', [
        'position' => 'center',
        'width' => '500',
        'timer' => 2000,
        'toast' => true,
        'timerProgressBar' => true,
    ]);
};

$redirectProductsPage = function () {
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


    @volt
        <div>
            <div class="card">
                <div class="card-body">
                    <form wire:submit="edit" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md mb-3">
                                @if ($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img rounded object-fit-cover"
                                        alt="image" loading="lazy" height="625px" width="100%" />
                                @elseif ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" class="img rounded object-fit-cover"
                                        alt="image" loading="lazy" height="625px" width="100%" />
                                @endif
                            </div>
                            <div class="col-md">
                                <h2 class="fw-bolder mb-3">Detail Layanan</h2>

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
                                        placeholder="Enter product image" />
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
                                    <label for="image_other" class="form-label">
                                        Gambar Lainnya
                                        <br>
                                        <small class="text-danger fw-bold">
                                            (Tidak perlu menginputkan gambar lagi jika tidak ingin mengubah gambar lainnya)
                                        </small>
                                    </label>
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
                                    <x-action-message wire:loading on="edit">
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
