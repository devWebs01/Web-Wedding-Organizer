<?php

use Dipantry\Rajaongkir\Models\ROProvince;
use Dipantry\Rajaongkir\Models\ROCity;
use App\Models\Address;
use function Livewire\Volt\{state, computed, rules};

state([
    'getAddress' => fn() => Address::where('user_id', auth()->id())->first(),

    'rajaongkir_province_id' => fn() => $this->getAddress->rajaongkir_province_id ?? '',

    'rajaongkir_city_id' => fn() => $this->getAddress->rajaongkir_city_id ?? '',

    'details' => fn() => $this->getAddress->details ?? '',
]);
state(['rajaongkir_province_id'])->url();

state(['provinces' => fn() => ROProvince::all()]);

rules([
    'rajaongkir_province_id' => 'required|exists:rajaongkir_provinces,id',
    'rajaongkir_city_id' => 'required|exists:rajaongkir_cities,id',
    'details' => 'required|min:20',
]);

$cities = computed(function () {
    return ROCity::where('province_id', $this->rajaongkir_province_id)->get();
});

$submit = function () {
    $validate = $this->validate();

    if ($this->getAddress) {
        $updateAddress = Address::where('user_id', auth()->id())->first();
        $updateAddress->update($validate);
    } elseif (!$this->getAddress) {
        $validate['user_id'] = auth()->id();
        Address::create($validate);
    }
};

?>
@volt
    <div>
        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Pilih Provinsi</span>
                    </div>
                    <select wire:model.live="rajaongkir_province_id" wire:loading.attr="disabled"
                        class="select select-bordered">
                        <option selected>Pick one</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('rajaongkir_province_id')" />
                </label>
            </div>
            <div class="mb-3">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Pilih Kota</span>
                    </div>
                    <select wire:model='rajaongkir_city_id' class="select select-bordered" wire:loading.attr="disabled">
                        <option selected>Pick one</option>
                        @foreach ($this->cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('rajaongkir_city_id')" />
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
                    <span class="label-text">Detail alamat</span>
                </div>
                <textarea wire:model='details' placeholder="..." class="textarea textarea-bordered w-full" wire:loading.attr="disabled"></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('details')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>

                <x-action-message wire:loading class="me-3" on="profile-updated">
                    {{ __('loading...') }}
                </x-action-message>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved!') }}
                </x-action-message>
            </div>
        </form>
    </div>
@endvolt
