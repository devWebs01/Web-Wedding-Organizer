<?php

use App\Models\User;
use Carbon\Carbon;
use function Livewire\Volt\{computed};
use function Laravel\Folio\name;

name('customers');


$users = computed(function () {
    return User::query()->where('role', 'customer')->latest()->get();
});

?>

<x-admin-layout>
    <x-slot name="title">Pelanggan</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('customers') }}">Pelanggan</a></li>
    </x-slot>
    @include('layouts.datatables')
        @volt
            <div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive rounded">
                            <table class="table text-center text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telp</th>
                                        <th>Provinsi</th>
                                        <th>Kota</th>
                                        <th>Alamat</th>
                                        <th>Terdaftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($this->users as $no => $user)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->telp }}</td>
                                            <td>{{ $user->address->province->name ?? '-' }}</td>
                                            <td>
                                                {{ $user->address->city->name ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $user->address->details ?? '-' }}
                                            </td>
                                            <td>{{ Carbon::parse($user->created_at)->format('d m Y') }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        @endvolt
</x-admin-layout>
