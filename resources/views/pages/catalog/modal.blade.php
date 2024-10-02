<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <i class="fa-solid fa-circle-exclamation fs-1 my-4"></i>
                <h6>
                    Apakah Anda yakin ingin melanjutkan dengan checkout? Pastikan semua item dalam wedding checklist Anda sudah sesuai dan lengkap
                </h6>
            </div>
            <div class="modal-footer d-flex justify-content-around">
                <button class="btn btn-danger btn-sm" class="btn btn-secondary"
                    data-bs-dismiss="modal"
                    role="button">
                    Kembali
                </button>

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
