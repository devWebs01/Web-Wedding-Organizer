<?php

use function Livewire\Volt\{state, rules, computed, usesPagination};
use App\Models\Category;
use function Laravel\Folio\name;

name('categories-product');

state(['name', 'categoryId']);
rules(['name' => 'required|min:6|string']);

usesPagination(theme: 'bootstrap');

$categories = computed(fn() => Category::latest()->paginate(10));

$save = function (Category $category) {
    $validate = $this->validate();

    if ($this->categoryId == null) {
        $category->create($validate);
    } else {
        $categoryUpdate = Category::find($this->categoryId);
        $categoryUpdate->update($validate);
    }
    $this->reset('name');
};

$edit = function (Category $category) {
    $category = Category::find($category->id);
    $this->categoryId = $category->id;
    $this->name = $category->name;
};

$destroy = function (Category $category) {
    $category->delete();
    $this->reset('name');
};
?>


<x-admin-layout>
    <div>
        <x-slot name="title">Kategori Produk</x-slot>
        <x-slot name="header">
            <li class="breadcrumb-item"><a wire:navigate href="{{ route('dashboard') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a wire:navigate href="{{ route('categories-product') }}">Kategori Produk</a></li>
        </x-slot>

        @volt
            <div>
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <form wire:submit="save">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Kategori Baru</label>
                                    <input type="text" class="form-control" wire:model="name" id="name"
                                        aria-describedby="helpId" placeholder="Masukkan kategori baru" />

                                    @error('name')
                                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="reset" class="btn btn-danger">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>

                            </form>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped text-center rounded">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->categories as $no => $category)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a wire:click='edit({{ $category->id }})'
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <button
                                                        wire:confirm.prompt="Yakin Ingin Menghapus?\n\nTulis 'hapus' untuk konfirmasi!|hapus"
                                                        wire:loading.attr='disabled'
                                                        wire:click='destroy({{ $category->id }})'
                                                        class="btn btn-sm btn-danger">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                            {{ $this->categories->links() }}
                        </div>

                    </div>
                </div>
            </div>
        @endvolt

    </div>
</x-admin-layout>
