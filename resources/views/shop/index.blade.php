@extends('layouts.app')

@section('content')

@include('componentes.header')

<section class="shop-section py-5">
    <div class="container">

        <div class="row">

            <!-- SIDEBAR FILTROS -->
            <div class="col-lg-3 mb-4">

                <div class="filter-box">

                    <h5 class="filter-title">Categorías</h5>
                    <ul class="filter-list">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('shop.category', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <hr>

                    <h5 class="filter-title">Rango de Precio</h5>

                    <form method="GET">
                        <input type="number" name="min_price" class="form-control mb-2" placeholder="Min">
                        <input type="number" name="max_price" class="form-control mb-2" placeholder="Max">

                        <button class="btn btn-warning w-100">
                            Filtrar
                        </button>
                    </form>

                </div>

            </div>

            <!-- PRODUCTOS -->
            <div class="col-lg-9">

                <!-- Barra superior -->
                <div class="shop-top d-flex justify-content-between align-items-center mb-4">

                    <h4 class="mb-0">
                        Mostrando {{ $products->count() }} productos
                    </h4>

                    <form method="GET">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Ordenar por</option>
                            <option value="price_asc">Precio menor</option>
                            <option value="price_desc">Precio mayor</option>
                            <option value="latest">Más recientes</option>
                        </select>
                    </form>

                </div>

                <!-- GRID -->
                <div class="row g-4">

                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6 col-12">

                            <div class="card product-card h-100">

                                <div class="product-image-wrapper" style="height: 300px !important;">
                                    @php
                                        $images = json_decode($product->images, true);
                                    @endphp
                                    <img src="{{ asset('storage/' . str_replace('\\','/',$images[0])) }}"
                                         alt="{{ $product->name }}">
                                </div>

                                <div class="card-body d-flex flex-column">

                                    <h6 class="product-title">
                                        {{ $product->name }}
                                    </h6>

                                    <div class="product-price">

                                        @auth
                                            <span class="price">
                                                S/ {{ number_format($product->price_tecnico ?? $product->price, 2) }}
                                            </span>
                                        @else
                                            <span class="price">
                                                S/ {{ number_format($product->price, 2) }}
                                            </span>
                                        @endauth

                                    </div>

                                    <div class="mt-3 d-grid gap-2">
                                        <a href="{{ route('shop.show', $product->slug) }}"
                                        class="btn btn-outline-dark">
                                            Ver Producto
                                        </a>

                                        <button class="btn btn-warning add-to-cart-btn"
                                                data-id="{{ $product->id }}">
                                            <i class="bi bi-cart"></i> Agregar al carrito
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                <!-- PAGINACIÓN -->
                <div class="mt-5">
                    {{ $products->links() }}
                </div>

            </div>

        </div>

    </div>
</section>

@include('componentes.footer')

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".add-to-cart-btn").forEach(button => {

        button.addEventListener("click", function () {

            let productId = this.dataset.id;

            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){

                    // Actualizar contador desktop
                    let cartCount = document.getElementById("cart-count");
                    if(cartCount){
                        cartCount.innerText = data.cart_count;
                        cartCount.classList.add("bump");

                        setTimeout(() => {
                            cartCount.classList.remove("bump");
                        }, 300);
                    }

                    // Actualizar contador mobile
                    let cartCountMobile = document.getElementById("cart-count-mobile");
                    if(cartCountMobile){
                        cartCountMobile.innerText = data.cart_count;
                    }

                    // Notificación elegante
                    showToast("Producto agregado al carrito 🛒");

                }

            });

        });

    });

});

function showToast(message) {

    let toast = document.createElement("div");
    toast.innerText = message;
    toast.style.position = "fixed";
    toast.style.bottom = "20px";
    toast.style.right = "20px";
    toast.style.background = "#000";
    toast.style.color = "#fff";
    toast.style.padding = "12px 20px";
    toast.style.borderRadius = "10px";
    toast.style.zIndex = "9999";

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2500);
}
</script>
@endpush

@endsection