<?php

use App\Livewire\Actions\Logout;
use App\Models\Order;
use function Livewire\Volt\{computed, state, on};

$logout = function (Logout $logout) {
    $logout();
    $this->redirect('/', navigate: true);
};
?>

<div>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
        <div class="message-body">
            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">My Profile</p>
            </a>
            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-mail fs-6"></i>
                <p class="mb-0 fs-3">My Account</p>
            </a>
            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-list-check fs-6"></i>
                <p class="mb-0 fs-3">My Task</p>
            </a>
            <button wire:click="logout" class="btn btn-outline-primary w-100">Logout</button>
        </div>
    </div>
</div>
