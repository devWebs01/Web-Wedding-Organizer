<?php

use function Livewire\Volt\{state, computed, uses};
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\Variant;
use Jantinnerezo\LivewireAlert\LivewireAlert;

uses([LivewireAlert::class]);

// product :  'category_id', 'vendor', 'title', 'image'
// variant :  'product_id', 'name', 'description', 'price'

state([
    'productId' => '',
    'variantId' => '',
    'title' => '',
    'name',
    'description',
    'price',
]);

$savedVariant = function (Variant $variant) {
    $validateData = $this->validate([
        'productId' => 'required|exists:products,id',
        'name' => [
            'required',
            Rule::unique('variants')
                ->where(function ($query) {
                    return $query->where('product_id', $this->productId);
                })
                ->ignore($this->variantId),
        ],
        'description' => 'required|min:10',
        'price' => 'required|numeric',
    ]);

    if ($this->variantId == null) {
        $variant->create([
            'product_id' => $this->productId,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);
    } else {
        $variantUpdate = Variant::find($this->variantId);
        $variantUpdate->update($validateData);
    }

    $this->reset('name', 'description', 'price', 'variantId');

    $this->alert('success', 'Penginputan varian telah berhasil', [
        'position' => 'center',
        // 'width' => '500',
        'timer' => 2000,
        'toast' => true,
        'timerProgressBar' => true,
    ]);
};

$editVariant = function (Variant $variant) {
    $variant = Variant::find($variant->id);
    $this->variantId = $variant->id;
    $this->name = $variant->name;
    $this->description = $variant->description;
    $this->price = $variant->price;
};

$destroyVariant = function (Variant $variant) {
    $variant->delete();
    $this->reset('name', 'description', 'price', 'variantId');
};

$resetVariant = function () {
    $this->reset('name', 'description', 'price', 'variantId');
};

$variants = computed(function () {
    return Variant::where('product_id', $this->productId)->get();
});

?>

<div>
    <p class="fw-bold mb-3">Tambahkan Varian Product {{ $title }}</p>
    <form wire:submit.prevent="savedVariant">
        @csrf
        @error('productId')
        <p class="text-danger fw-bold">Tetapkan data produk dahulu!</p>
        @enderror

        <div class="row">
            <div class="mb-3 col-12 col-md-6">
                <label for="name" class="form-label">Nama Varian</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" id="name"
                    aria-describedby="nameId" placeholder="Enter variant name" />
                @error('name')
                <small id="nameId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 col-12 col-md-6">
                <label for="price" class="form-label">Harga Varian</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" wire:model="price"
                    id="price" aria-describedby="priceId" placeholder="Enter variant price" />
                @error('price')
                <small id="priceId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 col-12">
                <label for="description" class="form-label">Deksripsi
                    Varian</label>
                <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description"
                    id="description" placeholder="Leave a comment here" id="floatingTextarea2"
                    style="height: 100px"></textarea>
                @error('description')
                <small id="descriptionId" class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>

        </div>

        <div class="mb-3 d-flex justify-content-md-between gap-2">
            <button name="reset" wire:click='resetVariant' class="btn btn-danger">
                Reset
            </button>

            <button name="submit" class="btn btn-primary">
                Submit
            </button>

        </div>

        <p>
            @error('name')
            <small id="nameId" class="form-text text-danger">{{ $message }}</small>,
            @enderror
            @error('stock')
            <small id="stockId" class="form-text text-danger">{{ $message }}</small>
            @enderror
        </p>
    </form>

    @if ($this->variants !== null)
    <div class="table-responsive border rounded mb-3">
        <table class="table text-center text-nowrap">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Varian</th>
                    <th>Harga</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->variants as $no => $item)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->formatRupiah($item->price) }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-3">
                            <!-- Button edit -->
                            <a name="button" wire:click='editVariant({{ $item->id }})'
                                class="btn btn-sm btn-warning">Edit</a>

                            <!-- Button remove -->
                            <button wire:loading.attr='disabled' wire:click='destroyVariant({{ $item->id }})'
                                class="btn btn-sm btn-danger" wire:confirm.prompt="Yakin ingin menghapus {{ $item->name }}?\n\nKetik 'hapus' untuk mengkonfirmasi!|hapus">
                                Hapus
                            </button>

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modal{{ $item->id }}">
                                Detail
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <br>

    @foreach ($this->variants as $no => $item)
    <!-- Modal -->
    <div class="modal fade" id="modal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Varian</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p class="fw-bold mb-0">Nama Varian:</p>
                        <p class="text-dark">{{ $item->name }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold mb-0">Harga Varian:</p>
                        <p class="text-dark">{{ $item->formatRupiah($item->price) }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold mb-0">Deksripsi Varian:</p>
                        <p class="text-dark">{{ $item->description }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
