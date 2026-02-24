@extends('layouts.app')

@section('content')

@include('componentes.header')

<section class="hero-carousel">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">

            @foreach($banners as $key => $banner)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="hero-slide d-flex align-items-center"
                     style="background-image: url('{{ asset('storage/' . str_replace('\\', '/', $banner->image)) }}');">
                    <div class="container text-white">
                        <div class="col-lg-6">
                            <h1 class="fw-bold display-5">
                                Repuestos Originales para<br>
                                Mototaxis y Motos Lineales
                            </h1>

                            <p class="mt-3">
                                Encuentra el repuesto exacto con stock real y precios especiales.
                            </p>

                            <div class="mt-4">
                                <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg me-3">
                                    Comprar Ahora
                                </a>
                                <a href="#" class="btn btn-outline-light btn-lg">
                                    Ver por Modelo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Slide 2 -->
            <!-- <div class="carousel-item">
                <div class="hero-slide d-flex align-items-center"
                     style="background-image: url('/images/hero2.jpg');">
                    <div class="container text-white">
                        <div class="col-lg-6">
                            <h1 class="fw-bold display-5">
                                Precios Especiales para Técnicos
                            </h1>

                            <p class="mt-3">
                                Regístrate como distribuidor y accede a precios exclusivos.
                            </p>

                            <div class="mt-4">
                                <a href="#" class="btn btn-warning btn-lg">
                                    Solicitar Registro
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Slide 3 -->
            <!-- <div class="carousel-item">
                <div class="hero-slide d-flex align-items-center"
                     style="background-image: url('/images/hero3.jpg');">
                    <div class="container text-white">
                        <div class="col-lg-6">
                            <h1 class="fw-bold display-5">
                                Envíos a Todo el Perú
                            </h1>

                            <p class="mt-3">
                                Entregas rápidas y stock en tiempo real.
                            </p>

                            <div class="mt-4">
                                <a href="{{ route('shop.index') }}" class="btn btn-warning btn-lg">
                                    Ver Productos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button"
                data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button"
                data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</section>

<section class="py-4 bg-light">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-3">
                🚚 <strong>Envíos a todo el Perú</strong>
            </div>

            <div class="col-md-3">
                💳 <strong>Pago Seguro</strong>
            </div>

            <div class="col-md-3">
                🔧 <strong>Soporte Técnico</strong>
            </div>

            <div class="col-md-3">
                📦 <strong>Productos Garantizados</strong>
            </div>

        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">Categorías Principales</h2>

        <div class="swiper categoriasSwiper">
            <div class="swiper-wrapper">

                @foreach($categories as $category)
                    <div class="swiper-slide">
                        <a href="{{ route('shop.category', $category->slug) }}" 
                           class="category-card">

                            <img src="{{ asset('storage/'.$category->image) }}" 
                                 alt="{{ $category->name }}">

                            <div class="category-overlay">
                                <h6>{{ $category->name }}</h6>
                            </div>

                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">Productos Destacados</h2>

        <div class="row g-4">
            @foreach($featured_products as $product)
                <div class="col-md-3">
                    <div class="card product-card h-100">

                        <div class="product-image-wrapper">
                            @php
                                $images = json_decode($product->images, true);
                            @endphp
                            <img src="{{ asset('storage/' . ($images[0] ?? 'no-image.png')) }}"
                                alt="{{ $product->name }}">
                        </div>

                        <div class="card-body d-flex flex-column">

                            <h6 class="fw-bold">
                                {{ $product->name }}
                            </h6>

                            <div class="mt-auto">
                                @auth
                                    <span class="text-success fw-bold">
                                        S/. {{ $product->price }}
                                    </span>
                                @else
                                    <span class="text-dark fw-bold">
                                        S/. {{ $product->price }}
                                    </span>
                                @endauth

                                <button class="btn btn-warning w-100 mt-2 add-to-cart"
                                        data-id="{{ $product->id }}">
                                    Agregar al carrito
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('componentes.footer')

<script>
document.addEventListener("DOMContentLoaded", function () {

    new Swiper('.categoriasSwiper', {
        slidesPerView: "auto",
        spaceBetween: 20,
        grabCursor: true,
        freeMode: true,
        loop: false,
    });

});
</script>
@endsection
