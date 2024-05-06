<?php

use App\Livewire\Actions\Logout;
use App\Models\Cart;
use function Livewire\Volt\{state, computed, on};

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

state([
    'cart' => fn() => Cart::where('user_id', auth()->user()->id ?? null)->get(),
    'subTotal' => fn() => Cart::where('user_id', auth()->user()->id ?? null)
        ->get()
        ->sum(function ($item) {
            return $item->product->price * $item->qty;
        }),
]);
on([
    'cart-updated' => function () {
        $this->cart = Cart::where('user_id', auth()->user()->id ?? null)->get();
        $this->subTotal = Cart::where('user_id', auth()->user()->id ?? null)
            ->get()
            ->sum(function ($item) {
                return $item->product->price * $item->qty;
            });
    },
]);
?>

<ul class="list-unstyled mb-0 d-flex align-items-center order-1 order-lg-2 nav-sidelinks">

    <!-- Mobile Nav Toggler-->
    <li class="d-lg-none">
        <span class="nav-link text-body d-flex align-items-center cursor-pointer" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation"><i class="ri-menu-line ri-lg me-1"></i> Menu</span>
    </li>
    <!-- /Mobile Nav Toggler-->

    @auth
        <!-- Navbar Login-->
        <li class="ms-1 d-none d-lg-inline-block">
            <a class="nav-link text-body" href="./login.html">
                Profile
            </a>
        </li>
        <!-- /Navbar Login-->
        <!-- Navbar Cart Icon-->
        <li class="ms-1 d-inline-block position-relative dropdown-cart">
            <button class="nav-link me-0 disable-child-pointer border-0 p-0 bg-transparent text-body" type="button">
                Keranjang (2)
            </button>
            <div class="cart-dropdown dropdown-menu">

                <!-- Cart Header-->
                <div class="d-flex justify-content-between align-items-center border-bottom pt-3 pb-4">
                    <h6 class="fw-bolder m-0">Cart Summary (2 items)</h6>
                    <i class="ri-close-circle-line text-muted ri-lg cursor-pointer btn-close-cart"></i>
                </div>
                <!-- / Cart Header-->

                <!-- Cart Items-->
                <div>

                    <!-- Cart Product-->
                    <div class="row mx-0 py-4 g-0 border-bottom">
                        <div class="col-2 position-relative">
                            <picture class="d-block ">
                                <img class="img-fluid" src="/guest/images/products/product-cart-1.jpg"
                                    alt="HTML Bootstrap Template by Pixel Rocket">
                            </picture>
                        </div>
                        <div class="col-9 offset-1">
                            <div>
                                <h6 class="justify-content-between d-flex align-items-start mb-2">
                                    Nike Air VaporMax 2021
                                    <i class="ri-close-line ms-3"></i>
                                </h6>
                                <span class="d-block text-muted fw-bolder text-uppercase fs-9">Size: 9 /
                                    Qty: 1</span>
                            </div>
                            <p class="fw-bolder text-end text-muted m-0">$85.00</p>
                        </div>
                    </div>
                    <!-- Cart Product-->
                    <div class="row mx-0 py-4 g-0 border-bottom">
                        <div class="col-2 position-relative">
                            <picture class="d-block ">
                                <img class="img-fluid" src="/guest/images/products/product-cart-2.jpg"
                                    alt="HTML Bootstrap Template by Pixel Rocket">
                            </picture>
                        </div>
                        <div class="col-9 offset-1">
                            <div>
                                <h6 class="justify-content-between d-flex align-items-start mb-2">
                                    Nike ZoomX Vaporfly
                                    <i class="ri-close-line ms-3"></i>
                                </h6>
                                <span class="d-block text-muted fw-bolder text-uppercase fs-9">Size: 11
                                    / Qty: 1</span>
                            </div>
                            <p class="fw-bolder text-end text-muted m-0">$125.00</p>
                        </div>
                    </div>
                </div>
                <!-- /Cart Items-->

                <!-- Cart Summary-->
                <div>
                    <div class="pt-3">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-start mb-4 mb-md-2">
                            <div>
                                <p class="m-0 fw-bold fs-5">Grand Total</p>
                                <span class="text-muted small">Inc $45.89 sales tax</span>
                            </div>
                            <p class="m-0 fs-5 fw-bold">$422.99</p>
                        </div>
                    </div>
                    <a href="./cart.html" class="btn btn-outline-dark w-100 text-center mt-4" role="button">View Cart</a>
                    <a href="./checkout.html" class="btn btn-dark w-100 text-center mt-2" role="button">Proceed To
                        Checkout</a>
                </div>
                <!-- / Cart Summary-->
            </div>


        </li>
    @else
        <li class="ms-1 d-none d-lg-inline-block">
            <a class="nav-link text-body" href="{{ route('login') }}">
                Masuk
            </a>
        </li>
        <li class="ms-1 d-none d-lg-inline-block">
            <a class="nav-link text-body" href="{{ route('register') }}">
                Daftar
            </a>
        </li>
    @endauth
    <!-- /Navbar Cart Icon-->

</ul>
