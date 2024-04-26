<?php

use App\Models\User;
use function Livewire\Volt\{computed};
use function Laravel\Folio\name;

name('report.customers');

$users = computed(
    fn() => User::where('role', 'customer')
        ->latest()
        ->get(),
);

?>
<x-app-layout>
    @volt
        @include('layouts.print')
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Laporan Data Pelanggan
                </h2>
            </x-slot>

            <div>
                <div class="sm:px-6 lg:px-8">
                    <div class="py-5">
                        <div class="mx-auto">
                            <div class=" bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <div class="overflow-x-auto">
                                    <table id="example" class="display" style="width:100%">
                                        <!-- head -->
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Telp</th>
                                                <th>Alamat</th>
                                                <th>Total Transaksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->users as $no => $user)
                                                <tr>
                                                    <td>{{ ++$no }}</td>
                                                    <td>{{ $user->name }}.</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->telp }}</td>
                                                    <td>
                                                        {{ $user->address->province->name ?? '-' }},
                                                        {{ $user->address->city->name ?? '-' }}
                                                    </td>
                                                    <td>{{ $user->orders->count() }} Transaksi</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-app-layout>
