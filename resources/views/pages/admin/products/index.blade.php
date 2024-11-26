<?php

use function Livewire\Volt\{computed, usesPagination, state, uses};
use App\Models\Product;
use function Laravel\Folio\name;
use Jantinnerezo\LivewireAlert\LivewireAlert;

name('products.index');
usesPagination(theme: 'bootstrap');

uses([LivewireAlert::class]);
state(['search'])->url();

$products = computed(function () {
    if ($this->search == null) {
        return Product::query()->latest()->paginate(10);
    } else {
        return Product::query()
            ->where('title', 'LIKE', "%{$this->search}%")
            ->orWhere('price', 'LIKE', "%{$this->search}%")
            ->orWhere('quantity', 'LIKE', "%{$this->search}%")
            ->latest()
            ->paginate(10);
    }
});

$destroy = function (product $product) {
    try {
        Storage::delete($product->image);
        $product->delete();
        $this->alert('success', 'Data layanan berhasil di hapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    } catch (\Throwable $th) {
        $this->alert('error', 'Data layanan gagal di hapus!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
};
?>


<x-admin-layout>
    <x-slot name="title">Layanan Gallery</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Layanan Gallery</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah
                                Layanan Gallery</a>
                        </div>
                        <div class="col">
                            <input wire:model.live="search" type="search" class="form-control" name="search"
                                id="search" aria-describedby="helpId" placeholder="Masukkan nama layanan gallery" />
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive border rounded px-3">
                        <table class="table text-center text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Thumbnail</th>
                                    <th>Kategori Layanan</th>
                                    <th>Nama Layanan</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->products as $no => $product)
                                    <tr>
                                        <th>{{ ++$no }}</th>
                                        <th>
                                            <img src="{{ Storage::url($product->image) }}" alt="" width="50"
                                                height="50" class="rounded-circle border">
                                        </th>
                                        <th>{{ $product->category->name }}</th>
                                        <th>{{ $product->title }}</th>
                                        <th>
                                            <a href="{{ route('products.edit', ['product' => $product->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <button wire:loading.attr='disabled' wire:click='destroy({{ $product->id }})'
                                                class="btn btn-sm btn-danger ">
                                                Hapus
                                            </button>
                                        </th>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{ $this->products->links() }}
                    </div>

                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
