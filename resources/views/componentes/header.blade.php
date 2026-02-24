<header class="main-header sticky-top">

    <!-- Top Bar -->
    <div class="top-bar py-2">
        <div class="container d-flex justify-content-between small">
            <div>
                🚚 Envíos a todo el Perú
            </div>
            <div>
                @auth
                    Bienvenido, {{ auth()->user()->name }}
                @else
                    <a href="{{ route('login') }}" class="text-white me-3">Login</a>
                    <a href="{{ route('register') }}" class="text-white">Registro</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark main-navbar">
        <div class="container">

            <!-- Logo -->
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <img src="/images/logo-asr.png" height="40" alt="Logo">
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler border-0" type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Desktop Menu -->
            <div class="collapse navbar-collapse d-none d-lg-flex">

                <!-- Links -->
                <ul class="navbar-nav me-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.index') }}">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contáctanos</a>
                    </li>
                </ul>

                <!-- Buscador -->
                <form action="{{ route('shop.index') }}"
                    method="GET"
                    class="mx-auto w-50 position-relative">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control rounded-pill ps-4"
                        placeholder="Buscar repuestos, modelo, marca...">

                    <button type="submit"
                            class="btn btn-warning position-absolute end-0 top-0 rounded-pill px-4">
                        🔍
                    </button>
                </form>

                <!-- Icons -->
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a href="javascript:void(0)" 
                        class="nav-link position-relative"
                        id="cart-toggle">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span class="cart-badge" id="cart-count">
                                {{ count(session('cart', [])) }}
                            </span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <div class="mini-cart" id="mini-cart">
        <div class="mini-cart-header">
            <strong>Tu carrito</strong>
            <button id="close-mini-cart" class="btn-close"></button>
        </div>

        <div class="mini-cart-body" id="mini-cart-body">
            <!-- Productos cargados por AJAX -->
        </div>

        <div class="mini-cart-footer">
            <a href="{{ route('cart.index') }}" class="btn btn-dark w-100">
                Ver carrito
            </a>
        </div>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menú</h5>
            <button type="button" class="btn-close bg-white"
                    data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">

            <!-- Buscador mobile -->
            <form action="{{ route('shop.search') }}"
                method="GET"
                class="mb-4">
                <input type="text"
                    name="search"
                    class="form-control"
                    placeholder="Buscar repuestos...">
            </form>

            <ul class="navbar-nav">
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="{{ route('shop.index') }}">Tienda</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#">Nosotros</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link" href="#">Contáctanos</a>
                </li>
            </ul>

            <hr>

            <a href="{{ route('cart.index') }}" class="btn btn-warning w-100">
                Ver Carrito (<span id="cart-count-mobile">{{ count(session('cart', [])) }}</span>)
            </a>

        </div>
    </div>

    <!-- Categorías -->
    <div class="categories-bar">
        <div class="container">
            <ul class="nav">
                @foreach($global_categories ?? [] as $cat)
                    <li class="nav-item">
                        <a href="{{ route('shop.category', $cat->slug) }}"
                           class="nav-link">
                            {{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

</header>