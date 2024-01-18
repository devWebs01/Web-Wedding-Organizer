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
        'status' => 'PENDING',
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
                <section class="bg-gray-100 rounded-xl">
                    <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 gap-x-16 gap-y-8 lg:grid-cols-5">
                            <div class="lg:col-span-2 lg:py-12">
                                <p class="max-w-xl text-lg">
                                    Silakan unggah bukti pembayaran Anda di sini untuk memproses pesanan Anda lebih lanjut.
                                    Terima kasih atas kerjasama Anda.
                                </p>

                                <div class="mt-8">
                                    @foreach ($banks as $item)
                                        <div>
                                            <p class="text-2xl font-bold text-primary"> {{ $item->account_number }} </p>

                                            <p class="mb-2 not-italic">{{ $item->account_owner }} (<span
                                                    class="text-primary">{{ $item->bank_name }}</span>)
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="rounded-lg bg-white p-8 shadow-lg lg:col-span-3 lg:p-12">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <div class="p-4">
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                </section>
            </div>
        </div>
    @endvolt
</x-costumer-layout>
