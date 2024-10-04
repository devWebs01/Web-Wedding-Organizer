<?php

use Dipantry\Rajaongkir\Models\ROProvince;
use Dipantry\Rajaongkir\Models\ROCity;
use App\Models\Address;
use function Livewire\Volt\{state, computed, rules, uses};
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

state(['province_id'])->url();

rules([
    'province_id' => 'required|exists:rajaongkir_provinces,id',
    'city_id' => 'required|exists:rajaongkir_cities,id',
    'details' => 'required|min:20',
]);

$getAddress = computed(function () {
    return Address::where('user_id', auth()->id())->first();
});

state([
    'province_id' => fn() => $this->getAddress->province_id ?? 8 ,
    'city_id' => fn() => $this->getAddress->city_id ?? '',
    'details' => fn() => $this->getAddress->details ?? '',
    'provinces' => fn() => ROProvince::all(),
]);

$cities = computed(function () {
    return ROCity::where('province_id', $this->province_id)->get();
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

    $this->dispatch('address-update');

    $this->alert('success', 'Alamat telah diperbaharui.', [
        'position' => 'top',
        'timer' => '2000',
        'toast' => true,
        'timerProgressBar' => true,
        'text' => '',
    ]);
};

?>
@volt
    <div>
        <div class="alert alert-dark alert-dismissible fade show" role="alert">
            <strong>
                Kamu dapat melihat dan memperbarui detail alamat kamu, seperti nama provinsi, kota dan detail lengkap
                yang sesuai lokasimu.
            </strong>
        </div>
        <form wire:submit.prevent="submit">
            @csrf
            <div class="row mb-3">
                <label for="province_id" class="col-sm-2 col-form-label">Pilih Provinsi</label>

                <div class="col-sm-10">
                    <select wire:model.live="province_id" wire:loading.attr="disabled" class="form-select" name="province_id"
                        id="province_id">
                        <option>Pick one</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <small class="fw-bold text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="city_id" class="col-sm-2 col-form-label">Pilih Kota</label>

                <div class="col-sm-10">
                    <select wire:model="city_id" wire:loading.attr="disabled" class="form-select" name="city_id" id="city_id">
                        <option selected>Pick one</option>
                        @foreach ($this->cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <small class="fw-bold text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="details" class="col-sm-2 col-form-label">
                    Detail Lengkap
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control" wire:model='details' name="details" id="details" rows="3"></textarea>
                    @error('details')
                    <small class="fw-bold text-danger">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
            </div>


            <div class="text-end">
                <button type="submit" class="btn btn-dark">
                    <div wire:loading class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span wire:loading.class='d-none'>
                        {{ !$this->getAddress ? 'SUBMIT' : 'EDIT' }}
                    </span>
                </button>

            </div>
        </form>
    </div>
@endvolt
