<?php

use function Livewire\Volt\{state, computed, usesPagination, on, rules};
use App\Models\Bank;

usesPagination();

state(['swap' => false, 'account_owner', 'account_number', 'bank_name', 'bankId']);

$banks = computed(fn() => Bank::latest()->paginate(5));

$destroy = function (Bank $bank) {
    $bank->delete();
    $this->reset('account_owner', 'bank_name', 'account_number');
};

rules([
    'account_owner' => 'required|string|min:5',
    'bank_name' => 'required|string|min:3',
    'account_number' => 'required|min:10',
]);

$save = function (Bank $bank) {
    $validate = $this->validate();

    if ($this->bankId == null) {
        $bank->create($validate);
    } else {
        $bankUpdate = Bank::find($this->bankId);
        $bankUpdate->update($validate);
    }

    $this->reset('account_owner', 'bank_name', 'account_number');
};

$edit = function (Bank $bank) {
    $banks = Bank::find($bank->id);
    $this->bankId = $bank->id;
    $this->account_owner = $bank->account_owner;
    $this->account_owner = $bank->account_owner;
    $this->bank_name = $bank->bank_name;
    $this->account_number = $bank->account_number;
};

?>
@volt
    <div>
        <div>
            <form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="account_owner" :value="__('Atas Nama')" />
                        <x-text-input wire:loading.attr="disabled" wire:model.blur="account_owner" id="account_owner"
                            class="block mt-1 w-full" type="text" name="account_owner" autofocus
                            autocomplete="account_owner" />
                        <x-input-error :messages="$errors->get('account_owner')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="bank_name" :value="__('Nama Bank')" />
                        <x-text-input wire:loading.attr="disabled" wire:model.blur="bank_name" id="bank_name"
                            class="block mt-1 w-full" type="text" name="bank_name" autofocus autocomplete="bank_name" />
                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                    </div>
                </div>
                <div class="mt-3">
                    <x-input-label for="account_number" :value="__('Nomor Rekening')" />
                    <x-text-input wire:loading.attr="disabled" wire:model.blur="account_number" id="account_number"
                        class="block mt-1 w-full" type="number" name="account_number" autofocus
                        autocomplete="account_number" />
                    <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                </div>
                <div class="mt-3 flex justify-end">
                    <x-primary-button class="ms-3">
                        <span wire:target='save' wire:loading class="loading loading-spinner"></span>
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <table class="table text-center my-5">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Atas Nama</th>
                    <th>Jenis Bank</th>
                    <th>Nomor Bank</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->banks as $no => $bank)
                    <tr>
                        <th>{{ ++$no }}</th>
                        <th>{{ $bank->account_owner }}</th>
                        <th>{{ $bank->bank_name }}</th>
                        <th>{{ $bank->account_number }}</th>
                        <th class="join">
                            <button wire:loading.attr='disabled' wire:click='edit({{ $bank->id }})'
                                class="btn btn-outline btn-sm join-item">
                                {{ __('Edit') }}
                            </button>
                            <button wire:confirm.prompt="Yakin Ingin Menghapus?\n\nTulis 'Hapus' untuk konfirmasi!|Hapus"
                                wire:loading.attr='disabled' wire:click='destroy({{ $bank->id }})'
                                class="btn btn-outline btn-sm join-item">
                                {{ __('Hapus') }}
                            </button>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $this->banks->links() }}
    </div>
@endvolt
