<div class="card d-print-block border-0">
    <div class="card-header py-4 row">
        <div class="col-md">
            <h4>Pesanan</h4>
            <p>Waktu Acara : <strong>{{ \carbon\Carbon::parse($order->wedding_date)->format('d M Y') }}</strong></p>
            <p>Metode Pembayaran : <strong>{{ $order->payment_method }}</strong></p>

        </div>
        <div class="col-md text-lg-end">
            <h4>Pelanggan</h4>
            <p>{{ $order->user->name }}</p>
            <p>{{ $order->user->email }}</p>
            <p>{{ $order->user->telp }}</p>
            <p>{{ $order->user->address->province->name }}, {{ $order->user->address->city->name }}</p>
            <p>{{ $order->user->address->details }}</p>
        </div>
    </div>

    <div class="card-body table-responsive row px-0">
        <table class="table table-borderless">
            <thead>
                <tr class="border">
                    <th class="text-center">#</th>
                    <th>Produk</th>
                    <th class="text-center">Variant</th>
                    <th class="text-end">Harga Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $no => $item)
                    <tr class="border">
                        <td class="text-center">{{ ++$no }}</td>
                        <td>{{ Str::limit($item->product->title, 30, '...') }}</td>
                        <td class="text-center">{{ $item->variant->name }}</td>
                        <td class="text-end">{{ formatRupiah($item->variant->price) }}</td>
                    </tr>
                @endforeach

                <tr class="text-end">
                    <td colspan="2"></td>
                    <td class="text-center fw-bolder"> Sub Total:</td>
                    <td class="fw-bolder text-dark">
                        {{ 'Rp.' . Number::format($order->items->sum(fn($item) => $item->variant->price), locale: 'id') }}
                    </td>
                </tr>
                <tr class="text-end">
                    <td colspan="2"></td>
                    <td class="text-center fw-bolder"> Total:</td>
                    <td class="fw-bolder text-dark">{{ formatRupiah($order->total_amount) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card-footer row">
        <div class="col-12">
            <span class="fw-medium text-heading">Note:</span>
            <span>{{ $order->note ?? '-' }}</span>
        </div>
    </div>

    <div class="card-body row px-0 gap-4">
        @foreach ($order->payments as $item)
            <div class="col-md border p-3 rounded">
                <h4 class="text-center fw-bold">{{ $item->payment_type }} -
                    {{ Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}</h4>

                <div class="d-flex justify-content-around gap-3">
                    <h6 class="text-center my-2">{{ formatRupiah($item->amount) }}</h6>

                    <h6 class="text-center my-2">{{ __('status.' . $item->payment_status) }}</h6>
                </div>

                @if ($item->proof_of_payment)
                    <div class="text-center">
                        <a data-fslightbox="mygalley" class="rounded" target="_blank" data-type="image"
                            href="{{ Storage::url($item->proof_of_payment) }}">
                            <img src="{{ Storage::url($item->proof_of_payment) }}" class="img object-fit-cover rounded"
                                style="height: 550px; width: 100%" alt="proof_of_payment1" />
                        </a>
                    </div>

                    {{-- 'UNPAID', 'PENDING', 'CONFIRMED', 'REJECTED' --}}

                    @if ($item->payment_status == 'REJECTED')
                        <a href="{{ route('order.payment', ['payment' => $item->id]) }}"
                            class="btn btn-dark mt-3 d-grid">
                            Lakukan Pembayaran {{ $item->payment_type }}
                        </a>
                    @endif
                    @if ($item->note)
                        <p class="my-3 text-dark">Note :
                            <strong>{{ $item->note }}</strong>
                        </p>
                    @endif
                @else
                    <div class="card placeholder" style="height: 550px; width: 100%"></div>

                    <a href="{{ route('order.payment', ['payment' => $item->id]) }}"
                        class="btn btn-dark mt-3 d-grid
                        {{ ($item->payment_type === 'Tunai' && $item->payment_status === 'UNPAID') ||
                        ($item->payment_type === 'DP' && $item->payment_status === 'UNPAID') ||
                        ($item->payment_type === 'Pelunasan' && $dp_confirmed)
                            ? ''
                            : 'disabled' }}">
                        Lakukan Pembayaran {{ $item->payment_type }}
                    </a>
                @endif


            </div>
        @endforeach
    </div>

</div>
