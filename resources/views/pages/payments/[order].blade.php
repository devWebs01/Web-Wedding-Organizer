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
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
                        <div class="mx-auto sm:text-center lg:max-w-2xl">
                            <div class="max-w-xl mb-10 md:mx-auto sm:text-center lg:max-w-2xl md:mb-12">
                                <div>
                                    <p class="inline-block px-3 py-px mb-4 text-lg font-semibold">
                                        Total Pembayaran
                                    </p>
                                </div>
                                <h2 class="max-w-lg mb-6 text-6xl font-extrabold md:mx-auto">
                                    {{ 'Rp. ' . Number::format($order->total_amount) }}
                                </h2>
                                <p class="max-w-xl mb-4 text-base text-gray-700 sm:mx-auto">
                                    Masukkan bukti pembayaran Anda dan selesaikan transaksi Anda dengan cepat dan aman.
                                </p>
                                <div>
                                    @foreach ($banks as $bank)
                                        <div role="alert" class="alert shadow-lg mb-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                class="stroke-info shrink-0 w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div>
                                                <h3 class="font-bold">{{ $bank->account_number }}
                                                </h3>
                                                <div class="text-xs">{{ $bank->account_owner }} - {{ $bank->bank_name }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <form wire:submit="submit">
                                <div class="mb-4 transition-shadow duration-300 hover:shadow-xl lg:mb-6">
                                    <!-- component -->
                                    <div class="border border-dashed border-gray-500 relative rounded-lg">
                                        <input type="file" wire:model='proof_of_payment'
                                            class="cursor-pointer relative block opacity-0 w-full h-full p-20 z-50">
                                        <div class="text-center p-10 absolute top-0 right-0 left-0 m-auto">
                                            <h4>
                                                Drop files anywhere to upload
                                                <br />or
                                            </h4>
                                            <p class="">Select Files</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <x-input-error :messages="$errors->get('proof_of_payment')" class="my-2" />
                                    <button class="my-5 btn btn-wide btn-primary">SUBMIT</button>
                                </div>
                            </form>
                            <p class="max-w-xl mb-4 text-base text-gray-700 sm:mx-auto">
                                Kepuasan Anda adalah prioritas kami, dan kami siap memastikan pengalaman pembayaran yang
                                lancar untuk Anda. Terima kasih telah memilih kami untuk pembelian Anda!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
