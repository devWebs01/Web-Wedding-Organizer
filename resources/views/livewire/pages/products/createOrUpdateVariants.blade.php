<?php

use function Livewire\Volt\{state, computed};
use App\Models\Product;
use App\Models\Variant;

state([
    'productId' => '',
    'title' => '',
    'variantId' => '',
    'size',
    'qty',
]);

$createOrUpdateVariant = function (Variant $variant) {
    $validateData = $this->validate([
        'productId' => 'required|exists:products,id',
        'size' => 'required',
        'qty' => 'required|numeric',
    ]);

    if ($this->variantId == null) {
        $variant->create([
            'product_id' => $this->productId,
            'size' => $this->size,
            'qty' => $this->qty,
        ]);
    } else {
        $variantUpdate = Variant::find($this->variantId);
        $variantUpdate->update($validateData);
    }

    $this->reset('size', 'qty', 'variantId');
};

$editVariant = function (Variant $variant) {
    $variant = Variant::find($variant->id);
    $this->variantId = $variant->id;
    $this->size = $variant->size;
    $this->qty = $variant->qty;
};

$destroyVariant = function (Variant $variant) {
    $variant->delete();
    $this->reset('size', 'qty', 'variantId');
};

$resetVariant = function () {
    $this->reset('size', 'qty', 'variantId');
};

$variants = computed(function () {
    return Variant::where('product_id', $this->productId)->get();
});

?>

<div>
    <p class="fw-bold mb-3">Tambahkan Varian Product {{ $title }}</p>
    @if ($this->variants !== null)
        <div class="table-responsive border rounded mb-3">
            <table class="table text-center text-nowrap">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Varian</th>
                        <th>Qty</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->variants as $no => $item)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $item->size }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>
                                <div class="btn-group">
                                    <a type="button" wire:click='editVariant({{ $item->id }})'
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <button
                                        wire:confirm.prompt="Yakin Ingin Menghapus?\n\nTulis 'hapus' untuk konfirmasi!|hapus"
                                        wire:loading.attr='disabled' wire:click='destroyVariant({{ $item->id }})'
                                        class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <form wire:submit.prevent="createOrUpdateVariant">
        @csrf
        @error('productId')
            <p class="text-danger fw-bold">Tetapkan data produk dahulu!</p>
        @enderror

        <div class="input-group mb-3">

            <input type="text" class="form-control
                            @error('size') is-invalid @enderror"
                wire:model="size" id="size" aria-describedby="sizeId" placeholder="Enter size product" />


            <input type="number" class="form-control
                            @error('qty') is-invalid @enderror"
                wire:model="qty" id="qty" aria-describedby="qtyId" placeholder="Enter qty product" />
            <button type="submit" class="btn btn-primary">
                Submit
            </button>

            <button type="reset" wire:click='resetVariant' class="btn btn-danger">
                Reset
            </button>

        </div>

        <p>
            @error('size')
                <small id="sizeId" class="form-text text-danger">{{ $message }}</small>,
            @enderror
            @error('qty')
                <small id="qtyId" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </p>
    </form>
</div>
