<?php

// Mengimpor kelas User dari namespace App\Models
use App\Models\User;
// Mengimpor kelas RouteServiceProvider dari namespace App\Providers
use App\Providers\RouteServiceProvider;
// Mengimpor kelas MustVerifyEmail dari namespace Illuminate\Contracts\Auth
use Illuminate\Contracts\Auth\MustVerifyEmail;
// Mengimpor kelas Auth dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Auth;
// Mengimpor kelas Session dari namespace Illuminate\Support\Facades
use Illuminate\Support\Facades\Session;
// Mengimpor kelas Rule dari namespace Illuminate\Validation
use Illuminate\Validation\Rule;

// Menggunakan fungsi-fungsi dari Livewire\Volt
use function Livewire\Volt\state;

// Mendefinisikan state (keadaan) dengan variabel 'name' dan 'email' dan memberikan nilai awal berdasarkan pengguna yang sedang login
state([
    'name' => fn() => auth()->user()->name,
    'email' => fn() => auth()->user()->email,
]);

// Membuat fungsi bernama $updateProfileInformation
$updateProfileInformation = function () {
    // Mendapatkan objek pengguna yang sedang login
    $user = Auth::user();

    // Memvalidasi input nama dan email dengan aturan yang telah ditentukan
    $validated = $this->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
    ]);

    // Mengisi model User dengan data yang telah divalidasi
    $user->fill($validated);

    // Jika email berubah, atur ulang waktu verifikasi email
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Menyimpan perubahan pada model User ke dalam database
    $user->save();

    // Memanggil event 'profile-updated' dengan parameter nama pengguna
    $this->dispatch('profile-updated', name: $user->name);
};

// Membuat fungsi bernama $sendVerification
$sendVerification = function () {
    // Mendapatkan objek pengguna yang sedang login
    $user = Auth::user();

    // Jika email pengguna sudah terverifikasi, arahkan pengguna ke halaman yang diinginkan atau halaman utama jika tidak ada yang diinginkan
    if ($user->hasVerifiedEmail()) {
        $path = session('url.intended', RouteServiceProvider::HOME);

        $this->redirect($path);

        return;
    }

    // Jika email belum terverifikasi, kirim ulang email verifikasi
    $user->sendEmailVerificationNotification();

    // Tampilkan pesan sukses dalam sesi
    Session::flash('status', 'verification-link-sent');
};

?>


<section>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required
                autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof MustVerifyEmail &&
                    !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
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
</section>
