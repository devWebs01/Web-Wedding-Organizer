<?php

use Dipantry\Rajaongkir\Models\ROProvince;
use Dipantry\Rajaongkir\Models\ROCity;
use App\Models\Shop;
use function Livewire\Volt\{state, computed, rules};

state(['province_id'])->url();

$getShop = computed(function () {
    return Shop::first();
});

state([
    'name' => fn() => $this->getShop->name ?? '',
    'province_id' => fn() => $this->getShop->province_id ?? '',
    'city_id' => fn() => $this->getShop->city_id ?? '',
    'details' => fn() => $this->getShop->details ?? '',
    'provinces' => fn() => ROProvince::all(),
]);

$cities = computed(function () {
    return ROCity::where('province_id', $this->province_id)->get();
});

rules([
    'name' => 'required|min:5',
    'province_id' => 'required|exists:rajaongkir_provinces,id',
    'city_id' => 'required|exists:rajaongkir_cities,id',
    'details' => 'required|min:20',
]);

$submit = function () {
    $validate = $this->validate();
    if ($this->getShop) {
        $updateShop = Shop::first();
        $updateShop->update($validate);
    } elseif (!$this->getShop) {
        Shop::create($validate);
    }
    $this->dispatch('address-update');
};

?>
@volt
    <div>
        <form wire:submit.prevent="submit">
            <label class="form-control w-full mb-3">
                <div class="label">
                    <span class="label-text">Nama Toko </span>
                </div>
                <input type="text" placeholder="Type here" class="input input-bordered w-full" wire:model="name"
                    wire:loading.attr="disabled" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </label>
            <div class="mb-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Pilih Lokasi Provinsi </span>
                    </div>
                    <select wire:model.live="province_id" wire:loading.attr="disabled" class="select select-bordered">
                        <option selected>Pick one</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('province_id')" />
                </label>
            </div>
            <div class="mb-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Pilih Lokasi Kota </span>
                    </div>
                    <select wire:model='city_id' class="select select-bordered" wire:loading.attr="disabled">
                        <option selected>Pick one</option>
                        @foreach ($this->cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('city_id')" />
                    <div class="label" wire:loading>
                        <span class="label-text-alt">loadng...</span>
                        <span class="label-text-alt">
                            <span class="loading loading-spinner loading-xs"></span>
                        </span>
                    </div>
                </label>
            </div>
            <div class="mb-3">
                <div class="label">
                    <span class="label-text">Detail Alamat Toko </span>
                </div>
                <textarea wire:model='details' placeholder="..." class="textarea textarea-bordered w-full h-52"
                    wire:loading.attr="disabled"></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('details')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                <x-action-message wire:loading class="me-3" on="address-update">
                    {{ __('loading...') }}
                </x-action-message>

                <x-action-message class="me-3" on="address-update">
                    {{ __('Tersimpan!') }}
                </x-action-message>
            </div>
        </form>
    </div>
@endvolt
