<?php

use function Livewire\Volt\{computed};
use App\Models\Category;


$categories = computed(fn() => Category::latest()->get());


?>

<x-app-layout>
    @volt
    @include('layouts.print')
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Laporan Data Kategori Produk') }}
                </h2>
            </x-slot>

            <div class="sm:px-6 lg:px-8">
                <div class="py-5">
                    <div class="mx-auto">
                        <div
                            class="overflow-x-auto mt-6 border-l-4 border-black bg-white dark:bg-gray-800 overflow-hidden shadow-md  rounded-lg p-4">
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Jumlah Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->categories as $no => $category)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->products->count() }} Produk Toko</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-app-layout>
