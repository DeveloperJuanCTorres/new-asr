@extends('layouts.app')

@section('content')

@include('componentes.header')

<div class="container py-5">

    <div class="row">
        {{-- GALERÍA --}}
        @php
            $videoUrl = trim($product->video ?? '');
            $videoEmbed = null;
            $videoId = null;

            if (!empty($videoUrl)) {

                // Parsear URL correctamente
                $parsedUrl = parse_url($videoUrl);

                if (isset($parsedUrl['host'])) {

                    // Caso youtu.be
                    if (str_contains($parsedUrl['host'], 'youtu.be')) {
                        $videoId = ltrim($parsedUrl['path'], '/');
                    }

                    // Caso youtube.com
                    if (str_contains($parsedUrl['host'], 'youtube.com')) {

                        // Shorts
                        if (str_contains($parsedUrl['path'], '/shorts/')) {
                            $parts = explode('/shorts/', $parsedUrl['path']);
                            $videoId = $parts[1] ?? null;
                        }

                        // Watch?v=
                        if (isset($parsedUrl['query'])) {
                            parse_str($parsedUrl['query'], $queryParams);
                            if (isset($queryParams['v'])) {
                                $videoId = $queryParams['v'];
                            }
                        }
                    }
                }

                if (!empty($videoId)) {
                    $videoEmbed = "https://www.youtube.com/embed/" . $videoId;
                }
            }

            $showVideoFirst = !empty($videoEmbed);
            $autoPlayVideo = request()->has('video');

            // IMÁGENES
            $images = [];

            if (!empty($product->images)) {

                // Si viene como JSON string
                if (is_string($product->images)) {
                    $decoded = json_decode($product->images, true);
                    if (is_array($decoded)) {
                        $images = $decoded;
                    }
                }

                // Si ya viene como array
                if (is_array($product->images)) {
                    $images = $product->images;
                }
            }

            // Si no hay imágenes múltiples, usar imagen principal
            if (empty($images) && !empty($product->image)) {
                $images[] = $product->image;
            }
        @endphp
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    {{-- ELEMENTO PRINCIPAL --}}
                    <div id="mainMediaContainer" class="text-center mb-3">

                        @if($showVideoFirst)
                            @if($autoPlayVideo)
                                {{-- VIDEO MODO GRANDE --}}
                                <div class="ratio ratio-16x9 mx-auto" style="max-width:100%;">
                                    <iframe
                                        src="{{ $videoEmbed }}?autoplay=1&rel=0&modestbranding=1"
                                        frameborder="0"
                                        allow="autoplay; encrypted-media"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @else
                                {{-- VIDEO NORMAL --}}
                                <div class="ratio ratio-16x9 mx-auto" style="max-width:600px;">
                                    <iframe
                                        src="{{ $videoEmbed }}?rel=0&modestbranding=1"
                                        frameborder="0"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @endif
                        @elseif(!empty($images))
                            <img src="{{ asset('storage/'.str_replace('\\','/',$images[0])) }}"
                                class="img-fluid rounded"
                                style="max-height:450px; object-fit:contain;">
                        @endif

                    </div>

                    {{-- MINIATURAS --}}
                    <div class="d-flex justify-content-center gap-2 flex-wrap">

                        {{-- Miniatura de video --}}
                        @if($showVideoFirst)
                            <div class="video-thumb position-relative"
                                style="width:80px; height:80px; cursor:pointer;"
                                data-video="{{ $videoEmbed }}">

                                <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                                    class="img-thumbnail"
                                    style="width:100%; height:100%; object-fit:cover;">

                                <span class="position-absolute top-50 start-50 translate-middle text-white fs-4">
                                    ▶
                                </span>
                            </div>
                        @endif

                        {{-- Miniaturas imágenes --}}
                        @foreach($images as $image)
                            <img src="{{ asset('storage/'.str_replace('\\','/',$image)) }}"
                                class="img-thumbnail thumb-image"
                                style="width:80px; height:80px; object-fit:contain; cursor:pointer;">
                        @endforeach

                    </div>

                </div>
            </div>
        </div>

        {{-- INFORMACIÓN --}}
        <div class="col-md-6">

            <h2 class="fw-bold">{{ $product->name }}</h2>

            <p class="text-muted mb-1">
                Marca: <strong>{{ $product->brand->name ?? 'Genérico' }}</strong>
            </p>

            <hr>

            <h3 class="text-danger fw-bold mb-3">
                S/. {{ number_format($product->price, 2) }}
            </h3>

            {{-- STOCK --}}
            @if($product->stock > 0)
                <span class="badge bg-success mb-3">
                    En stock ({{ $product->stock }} disponibles)
                </span>
            @else
                <span class="badge bg-danger mb-3">
                    Agotado
                </span>
            @endif

            {{-- FORMULARIO AGREGAR AL CARRITO --}}
            
            <div class="d-flex align-items-center mb-3">
                <label class="me-2 fw-bold">Cantidad:</label>
                <input type="number"
                        name="quantity"
                        value="1"
                        min="1"
                        max="{{ $product->stock }}"
                        class="form-control"
                        style="width:100px;">
            </div>

            <button type="button"
                    class="btn btn-warning btn-lg w-100 fw-bold shadow add-to-cart-btn"
                    data-id="{{ $product->id }}">
                Agregar al carrito
            </button>

            <!-- <button class="btn btn-dark btn-lg w-100 mt-3">
                Comprar ahora
            </button> -->

            <hr>

            {{-- BENEFICIOS --}}
            <ul class="list-unstyled small">
                <li>✔ Envíos rápidos a todo el Perú</li>
                <li>✔ Garantía de calidad</li>
                <li>✔ Soporte especializado en repuestos</li>
            </ul>

        </div>
    </div>

    {{-- TABS DE INFORMACIÓN --}}
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description">
                        Descripción
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#specs">
                        Especificaciones
                    </button>
                </li>
            </ul>

            <div class="tab-content p-4 border border-top-0 bg-white shadow-sm">
                <div class="tab-pane fade show active" id="description">
                    {!! $product->description !!}
                </div>

                <div class="tab-pane fade" id="specs">
                    <table class="table">
                        <tr>
                            <th>Modelo compatible</th>
                            <td>{{ $product->model ?? 'No especificado' }}</td>
                        </tr>
                        <tr>
                            <th>Categoría</th>
                            <td>{{ $product->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Código</th>
                            <td>{{ $product->sku }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- PRODUCTOS RELACIONADOS --}}
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="fw-bold mb-4">Productos relacionados</h4>
        </div>

        @foreach($relatedProducts as $related)
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <img src="{{ asset('storage/'.$related->image) }}"
                         class="card-img-top p-3"
                         style="height:200px; object-fit:contain;">

                    <div class="card-body text-center">
                        <h6 class="fw-bold">{{ $related->name }}</h6>
                        <p class="text-danger fw-bold">
                            ${{ number_format($related->price, 2) }}
                        </p>

                        <a href="{{ route('shop.show', $related->slug) }}"
                           class="btn btn-outline-dark btn-sm">
                           Ver detalle
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>

@include('componentes.footer')

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const mainContainer = document.getElementById("mainMediaContainer");

    // Click en miniaturas de imagen
    document.querySelectorAll('.thumb-image').forEach(img => {
        img.addEventListener('click', function() {

            mainContainer.innerHTML =
                `<img src="${this.src}"
                      class="img-fluid rounded"
                      style="max-height:450px; object-fit:contain;">`;
        });
    });

    // Click en miniatura de video
    document.querySelectorAll('.video-thumb').forEach(video => {
        video.addEventListener('click', function() {

            let videoUrl = this.dataset.video;

            mainContainer.innerHTML =
                `<div class="ratio ratio-16x9 mx-auto" style="max-width:600px;">
                    <iframe src="${videoUrl}?autoplay=1"
                            frameborder="0"
                            allow="autoplay; encrypted-media"
                            allowfullscreen>
                    </iframe>
                 </div>`;
        });
    });

});

document.addEventListener("DOMContentLoaded", function () {

    const urlParams = new URLSearchParams(window.location.search);

    if(urlParams.has('video')){

        const iframe = document.querySelector("#mainMediaContainer iframe");

        if(iframe){
            iframe.scrollIntoView({ behavior: "smooth" });

            setTimeout(() => {
                if (iframe.requestFullscreen) {
                    iframe.requestFullscreen();
                }
            }, 800);
        }
    }

});
</script>

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