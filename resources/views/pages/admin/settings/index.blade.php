<?php

use function Laravel\Folio\name;

name('setting-store');

?>
<x-admin-layout>
    <x-slot name="title">Pengaturan Gallery</x-slot>
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('setting-store') }}">Pengaturan Gallery</a></li>
    </x-slot>

    @volt
        <div>
            <div class="card overflow-hidden">
                <div class="card-header p-0">
                    <img src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/images/backgrounds/profilebg.jpg"
                        alt="matdash-img" class="img-fluid">
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">

                            <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-profile" type="button" role="tab"
                                aria-controls="v-pills-profile" aria-selected="true">Profile</button>

                            <button class="nav-link" id="v-pills-payment-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-payment" type="button" role="tab"
                                aria-controls="v-pills-payment" aria-selected="true">Rekening</button>


                        </div>
                        <div class="tab-content" id="v-pills-tabContent">

                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab" tabindex="0">
                                @include('pages.admin.settings.profile')

                            </div>

                            <div class="tab-pane fade" id="v-pills-payment" role="tabpanel"
                                aria-labelledby="v-pills-payment-tab" tabindex="0">
                                @include('pages.admin.settings.bank')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endvolt
</x-admin-layout>
