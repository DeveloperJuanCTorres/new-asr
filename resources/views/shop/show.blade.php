@extends('layouts.app')

@section('content')

@include('componentes.header')

<div class="container py-5">

    <div class="row">
        {{-- GALERÍA --}}
        @php
            // Decodificar JSON manualmente
            $imagesRaw = $product->images;

            if (!empty($imagesRaw)) {
                $decoded = json_decode($imagesRaw, true);
                $images = is_array($decoded) ? $decoded : [];
            } else {
                $images = [];
            }

            $hasImages = count($images) > 0;

            // Imagen principal
            $mainImage = $hasImages ? $images[0] : null;
        @endphp
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    {{-- IMAGEN PRINCIPAL --}}
                    <div class="text-center mb-3">
                        @if($hasImages)
                            <img id="mainImage"
                                src="{{ asset('storage/'.str_replace('\\','/',$mainImage)) }}"
                                class="img-fluid rounded"
                                style="max-height:450px; object-fit:contain;">
                        @else
                            <img id="mainImage"
                                src="{{ asset('images/placeholder.png') }}"
                                class="img-fluid rounded"
                                style="max-height:450px; object-fit:contain;">
                        @endif
                    </div>

                    {{-- MINIATURAS --}}
                    @if($hasImages && count($images) > 1)
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            @foreach($images as $image)
                                <img src="{{ asset('storage/'.str_replace('\\','/',$image)) }}"
                                    class="img-thumbnail thumb-image"
                                    style="width:80px; height:80px; object-fit:contain; cursor:pointer;">
                            @endforeach
                        </div>
                    @endif

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
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf

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

                <button type="submit"
                        class="btn btn-warning btn-lg w-100 fw-bold shadow">
                    Agregar al carrito
                </button>
            </form>

            <button class="btn btn-dark btn-lg w-100 mt-3">
                Comprar ahora
            </button>

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
    document.querySelectorAll('.thumb-image').forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('mainImage').src = this.src;
        });
    });
</script>
@endpush

@endsection