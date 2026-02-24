@extends('layouts.app')

@section('content')

@include('componentes.header')

<!-- HERO -->
<section class="about-hero text-white d-flex align-items-center">
    <div class="container text-center">
        <h1 class="fw-bold">Especialistas en Repuestos para Motos y Mototaxis</h1>
        <p class="lead mt-3">
            Calidad, confianza y soporte técnico en todo el Perú
        </p>
    </div>
</section>

<!-- QUIENES SOMOS -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">¿Quiénes Somos?</h2>
                <p>
                    Somos una empresa especializada en la comercialización de repuestos
                    para motos lineales y mototaxis. Atendemos técnicos, talleres y
                    clientes finales en todo el Perú.
                </p>

                <p>
                    Nuestro enfoque está en ofrecer productos confiables, precios
                    competitivos y una atención profesional que respalde cada compra.
                </p>
            </div>

            <div class="col-lg-6">
                <img src="/images/logo-asr.png" width="500"
                     class="img-fluid rounded shadow">
            </div>

        </div>
    </div>
</section>

<!-- MISION Y VISION -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <div class="card p-4 h-100 shadow-sm">
                    <h4 class="fw-bold">Nuestra Misión</h4>
                    <p class="mt-3">
                        Proveer repuestos de calidad garantizada,
                        asegurando rapidez en la entrega y soporte técnico especializado.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-4 h-100 shadow-sm">
                    <h4 class="fw-bold">Nuestra Visión</h4>
                    <p class="mt-3">
                        Convertirnos en la tienda online líder en repuestos
                        para motos y mototaxis en el mercado peruano.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- DIFERENCIALES -->
<section class="py-5">
    <div class="container text-center">

        <h2 class="fw-bold mb-5">¿Por qué elegirnos?</h2>

        <div class="row">

            <div class="col-md-3">
                <i class="bi bi-shield-check fs-1 text-warning"></i>
                <h6 class="mt-3 fw-bold">Productos Garantizados</h6>
                <p>Trabajamos con marcas reconocidas y calidad comprobada.</p>
            </div>

            <div class="col-md-3">
                <i class="bi bi-truck fs-1 text-warning"></i>
                <h6 class="mt-3 fw-bold">Envíos a Todo el Perú</h6>
                <p>Despachamos rápido y seguro a nivel nacional.</p>
            </div>

            <div class="col-md-3">
                <i class="bi bi-people fs-1 text-warning"></i>
                <h6 class="mt-3 fw-bold">Precios para Técnicos</h6>
                <p>Sistema especial para talleres y profesionales.</p>
            </div>

            <div class="col-md-3">
                <i class="bi bi-headset fs-1 text-warning"></i>
                <h6 class="mt-3 fw-bold">Soporte Especializado</h6>
                <p>Asesoría técnica antes y después de tu compra.</p>
            </div>

        </div>
    </div>
</section>

<!-- ESTADISTICAS -->
<section class="about-stats text-white py-5">
    <div class="container">
        <div class="row text-center">

            <div class="col-md-4">
                <h2 class="fw-bold">+5,000</h2>
                <p>Clientes Atendidos</p>
            </div>

            <div class="col-md-4">
                <h2 class="fw-bold">+2,000</h2>
                <p>Repuestos Disponibles</p>
            </div>

            <div class="col-md-4">
                <h2 class="fw-bold">100%</h2>
                <p>Compromiso y Confianza</p>
            </div>

        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 text-center">
    <div class="container">
        <h3 class="fw-bold mb-3">¿Listo para encontrar el repuesto que necesitas?</h3>
        <a href="{{ route('shop.index') }}" class="btn btn-warning px-5 py-3">
            Ir a la Tienda
        </a>
    </div>
</section>

@include('componentes.footer')

@endsection