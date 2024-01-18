<?php

use App\Models\User;
use function Livewire\Volt\{computed, state, usesPagination};

state(['search'])->url();
usesPagination();

$users = computed(function () {
    if ($this->search == null) {
        return User::query()
            ->where('role', 'admin')
            ->latest()
            ->paginate(10);
    } else {
        return User::query()
            ->where('role', 'admin')
            ->where(function ($query) {
                $query
                    ->where('name', 'LIKE', "%{$this->search}%")
                    ->orWhere('email', 'LIKE', "%{$this->search}%")
                    ->orWhere('telp', 'LIKE', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);
    }
});

$destroy = function (User $user) {
    $user->delete();
};

?>
<x-app-layout>
    @volt
        <div>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Data Admin
                </h2>
            </x-slot>

            <div>
                <div class="sm:px-6 lg:px-8">
                    <div class="py-5">
                        <div class="mx-auto">
                            <div class="mb-4 flex space-x-4 p-2 bg-white rounded-lg shadow-md justify-between">
                                <a href="/admin/users/store" class="btn btn-neutral ">Tambah Admin</a>
                                <label class="form-control w-full max-w-xs">
                                    <input wire:model.live="search" type="search" placeholder="Input Pencarian"
                                        class="input input-bordered w-full max-w-xs" />
                                </label>
                            </div>

                            <div class=" bg-white p-4 rounded-lg shadow-md border-l-4 border-black">
                                <div class="overflow-x-auto">
                                    <table class="table text-center">
                                        <!-- head -->
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Telp</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($this->users as $no => $user)
                                                <tr>
                                                    <td>{{ ++$no }}</td>
                                                    <td>{{ $user->name }}.</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->telp }}</td>
                                                    <td class="join">
                                                        <a href="/admin/users/{{ $user->id }}" wire:navigate
                                                            class="btn btn-sm btn-outline join-item">Edit</a>
                                                        <button
                                                            wire:confirm.prompt="Yakin Ingin Menghapus?\n\nTulis 'Hapus' untuk konfirmasi!|Hapus"
                                                            wire:loading.attr='disabled'
                                                            wire:click='destroy({{ $user->id }})'
                                                            class="btn join-item btn-outline btn-sm">
                                                            {{ __('Hapus') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="py-5">
                                        {{ $this->users->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-app-layout>
