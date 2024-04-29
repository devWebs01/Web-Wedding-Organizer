<div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="./index.html" class="text-nowrap logo-img">
            <img src="/admin/images/logos/logo.svg" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
        </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false"
                    {{ request()->routeIs('dashboard') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Beranda</span>
                </a>
            </li>
            <li>
                <span class="sidebar-divider lg"></span>
            </li>

            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Pengguna</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('users.index') }}" aria-expanded="false"
                    {{ request()->routeIs('users.index') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Admin</span>
                </a>
                <a class="sidebar-link" href="{{ route('customers') }}" aria-expanded="false"
                    {{ request()->routeIs('customers') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Pelanggan</span>
                </a>
            </li>
            <li>
                <span class="sidebar-divider lg"></span>
            </li>

            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Toko</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('categories-product') }}" aria-expanded="false"
                    {{ request()->routeIs('categories-product') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Kategori Produk</span>
                </a>
                <a class="sidebar-link" href="{{ route('products.index') }}" aria-expanded="false"
                    {{ request()->routeIs('products.index') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Produk Toko</span>
                </a>
                <a class="sidebar-link" href="{{ route('setting-store') }}" aria-expanded="false"
                    {{ request()->routeIs('setting-store') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Pengaturan</span>
                </a>
            </li>
            <li>
                <span class="sidebar-divider lg"></span>
            </li>

            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Kelola Transaksi</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('transactions.index') }}" aria-expanded="false"
                    {{ request()->routeIs('transactions.index') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Transaksi</span>
                </a>
            </li>
            <li>
                <span class="sidebar-divider lg"></span>
            </li>

            <li class="nav-small-cap">
                <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                <span class="hide-menu">Kelola Laporan</span>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('report.categories-product') }}" aria-expanded="false"
                    {{ request()->routeIs('report.categories-product') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Data Kategori</span>
                </a>
                <a class="sidebar-link" href="{{ route('report.products') }}" aria-expanded="false"
                    {{ request()->routeIs('report.products') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Data Produk</span>
                </a>
                <a class="sidebar-link" href="{{ route('report.customers') }}" aria-expanded="false"
                    {{ request()->routeIs('report.customers') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Data Pelanggan</span>
                </a>
                <a class="sidebar-link" href="{{ route('report.transactions') }}" aria-expanded="false"
                    {{ request()->routeIs('report.transactions') }}>
                    <iconify-icon icon="solar:widget-add-line-duotone"></iconify-icon>
                    <span class="hide-menu">Data Pelanggan</span>
                </a>
            </li>
            <li>
                <span class="sidebar-divider lg"></span>
            </li>



    </nav>
    <!-- End Sidebar navigation -->
</div>
