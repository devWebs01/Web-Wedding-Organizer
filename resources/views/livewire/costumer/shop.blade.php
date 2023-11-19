<div>
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between gap-3">
            <div class="mb-0 me-1">
                <h1 class="fs-2 mb-1 fw-bolder">Produk Toko</h1>
                <p class="mb-0">Total {{ $products->count() }} produk toko</p>
            </div>
            <div class="d-flex justify-content-md-end align-items-center gap-3 flex-wrap">
                <div class="position-relative">
                    <select class="form-select form-select-lg rounded" wire:model.live="category_id">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ Str::limit($category->name, 35, '...') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <label class="switch">
                    <input wire:model.live="search" type="text" class="form-control" aria-describedby="helpId"
                        placeholder="Masukkan judul buku ...">
                </label>
            </div>
        </div>
    </div>

    <h5 class="text-center fw-bold">ketikan{{ $search }}</h5>

    <div class="untree_co-section product-section before-footer-section">
        <div class="container-fluid">
            <div class="row">

                <!-- Start Column -->
                @foreach ($products as $product)
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item" href="#">
                            <div class="lc-block border-0 card card-cover overflow-hidden bg-dark rounded-5 shadow-xl"
                                lc-helper="background"
                                style="background-image: url({{ Storage::url($product->image) }}); background-size:cover; height:300px;">
                            </div>
                            <span
                                class="text-wrap text-primary fw-bold badge shadow-lg py-4 my-3">{{ $product->category->name }}</span>
                            <h2 class="fs-5 lh-1 fw-bolder text-truncate mb-3">{{ $product->title }}</h2>
                            <h2 class="fs-6 lh-1 fw-bold">Rp. {{ $product->price }}</h2>
                            <span class="icon-cross">
                                <img src="/assets/images/cross.svg" class="img-fluid">
                            </span>
                        </a>
                    </div>
                @endforeach
                <!-- End Column -->

            </div>
        </div>
    </div>
</div>
