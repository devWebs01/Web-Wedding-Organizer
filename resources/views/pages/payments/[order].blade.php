<?php

use function Livewire\Volt\{state, usesFileUploads};
use App\Models\Order;
use App\Models\Bank;

usesFileUploads();

state([
    'order' => fn() => Order::find($id),
    'proof_of_payment',
    'banks' => fn() => Bank::get(),
]);

$submit = function () {
    $this->validate([
        'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg',
    ]);

    $order = $this->order;
    $order->update([
        'proof_of_payment' => $this->proof_of_payment->store('public/proof_of_payment'),
        'status' => 'packed',
    ]);

    $this->redirect('/orders', navigate: true);
};

?>
<x-costumer-layout>
    @volt
        <div>
            <div class="pt-6">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="mx-auto flex items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <li>
                            <div class="flex items-center">
                                <a href="/orders" class="mr-2 text-sm font-medium">Pesanan Saya</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor" aria-hidden="true"
                                    class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium">Rincian Pesanan</a>
                                <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                    aria-hidden="true" class="h-5 w-4 text-gray-300">
                                    <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <a href="#" class="mr-2 text-sm font-medium">Rincian Pembayaran</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="py-4 sm:px-6 lg:px-8">
                <div role="alert" class="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-info shrink-0 w-6 h-6 mb-auto">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-normal">Rekening Pembayaran :</h3>
                        <h4
                            class="mt-2 text-xl font-extrabold leading-8 text-gray-900 dark:text-white sm:text-3xl sm:leading-9">
                            Selesaikan transaksi Anda dengan cepat dan aman.
                        </h4>
                    </div>

                </div>
                <div class="grid md:grid-cols-2 grid-rows-1 gap-4">
                    <div class="p-4">
                        <div class="lg:ml-4 lg:col-start-2 ">
                            <ul class="mt-8 space-y-3 font-medium">
                                @foreach ($banks as $bank)
                                    <li class="flex items-start lg:col-span-1">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 leading-5 text-gray-600">
                                            {{ $bank->bank_name }}, {{ $bank->account_owner }}
                                            <br>
                                            <span class="text-primary">
                                                {{ $bank->account_number }}
                                            </span>
                                        </p>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="p-4 mt-8">
                        <p class="mb-2 font-bold"> Total Pembayaran
                        </p>
                        <h2 class="text-4xl font-extrabold">
                            {{ 'Rp. ' . Number::format($order->total_amount) }}
                        </h2>
                        <p class="mb-5"> Masukkan bukti pembayaran Anda pada form input:
                        </p>
                        <form wire:submit="submit">
                            <input type="file" wire:model='proof_of_payment'
                                class="file-input file-input-bordered file-input-primary w-full " />
                            <x-input-error :messages="$errors->get('proof_of_payment')" class="my-2" />
                            <button class="my-5 btn btn-wide btn-primary">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @endvolt
</x-costumer-layout>
