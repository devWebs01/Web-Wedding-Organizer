<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
    <li class="nav-item">
        <a class="nav-link" href="/" role="button">
            Beranda
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('catalog-products') }}" role="button">
            Katalog
        </a>
    </li>
    <li class="nav-item">
        <span class="nav-link search-trigger cursor-pointer">Pencarian</span>

        <!-- Search navbar overlay-->
        <div class="navbar-search d-none">
            <div class="input-group mb-3 h-100">
                <span class="input-group-text px-4 bg-transparent border-0"><i class="ri-search-line ri-lg"></i></span>
                <input type="text" class="form-control text-body bg-transparent border-0"
                    placeholder="Enter your search terms...">
                <span
                    class="input-group-text px-4 cursor-pointer disable-child-pointer close-search bg-transparent border-0"><i
                        class="ri-close-circle-line ri-lg"></i></span>
            </div>
        </div>
        <div class="search-overlay"></div>
        <!-- / Search navbar overlay-->
    </li>

</ul>
