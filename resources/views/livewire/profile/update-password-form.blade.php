<?php

// Mengimpor kelas Auth dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Auth;
// Mengimpor kelas Hash dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Hash;
// Mengimpor kelas Password dari namespace Illuminate\Validation\Rules
use Illuminate\Validation\Rules\Password;
// Mengimpor kelas ValidationException dari namespace Illuminate\Validation
use Illuminate\Validation\ValidationException;

// Menggunakan fungsi-fungsi dari Livewire\Volt
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

// Mendefinisikan state (keadaan) dengan beberapa variabel dan memberikan nilai awal kosong
state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => '',
]);

// Mendefinisikan aturan validasi untuk beberapa variabel, termasuk aturan 'current_password' yang disertakan oleh pengguna
rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

// Membuat fungsi bernama $updatePassword
$updatePassword = function () {
    try {
        // Memvalidasi input dengan aturan yang telah ditentukan sebelumnya
        $validated = $this->validate();
    } catch (ValidationException $e) {
        // Jika validasi gagal, reset nilai variabel terkait dan lemparkan kembali exception
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    // Memperbarui password pengguna dengan password yang baru di-hash
    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    // Setelah berhasil, reset nilai variabel terkait
    $this->reset('current_password', 'password', 'password_confirmation');

    // Memanggil event 'password-updated'
    $this->dispatch('password-updated');
};

?>


<section>
    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <x-input-label for="current_password" :value="__('Kata Sandi Saat Ini')" />
            <x-text-input wire:model="current_password" id="current_password" name="current_password" type="password"
                class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Kata Sandi Baru')" />
            <x-text-input wire:model="password" id="password" name="password" type="password" class="mt-1 block w-full"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Ulangi Kata Sandi Baru')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" name="password_confirmation"
                type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            <x-action-message wire:loading class="me-3" on="password-updated">
                {{ __('loading...') }}
            </x-action-message>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Tersimpan!') }}
            </x-action-message>
        </div>
    </form>
</section>
