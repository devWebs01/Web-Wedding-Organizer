<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Tentukan Tanggal Acaramu
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="daterange" class="form-label">Pilih Tanggal</label>
                    <input type="text" class="form-control" name="daterange" id="daterange" aria-describedby="helpId"
                        placeholder="XX/XX/XXX" />
                    @error('daterange')
                        <small class="text-danger-fw-bold">{{ $message }}</small>
                    @enderror
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-around">
                <a class="btn btn-dark btn-sm" href="{{ route('customer.account', ['user' => auth()->id()]) }}"
                    role="button">
                    Tidak, Atur Alamat
                </a>

                <form wire:submit="confirmCheckout">
                    <button wire:loading.attr='disable' type="submit" class="btn btn-sm btn-dark">
                        <span wire:loading.delay wire:target="confirmCheckout"
                            class="loading loading-spinner loading-xs"></span>
                        Ya, Lanjut
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
