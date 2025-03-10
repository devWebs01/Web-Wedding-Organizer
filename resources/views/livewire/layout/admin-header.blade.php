<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();
    $this->redirect('/');
};
?>

<div>
    <header class="app-header d-print-none">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                    <li class="nav-item dropdown">
                        <div class="d-flex">
                            <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="https://api.dicebear.com/7.x/notionists/svg?seed={{ auth()->user()->name }}"
                                    alt="" width="50" height="50" class="rounded-circle border">
                            </a>
                            <button type="button" class="nav-link" wire:click="logout">
                               <i class='bx bx-log-in display-6'></i>
                            </button>
                        </div>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                            <div class="message-body">
                                <a href="{{ route('account.auth') }}"
                                    class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-user fs-6"></i>
                                    <p class="mb-0 fs-3">Akun Profile</p>
                                </a>
                                <button wire:click="logout" class="d-flex align-items-center gap-2 dropdown-item">
                                    <i class="ti ti-logout fs-6"></i>
                                    <p class="mb-0 fs-3">Keluar</p>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

</div>
