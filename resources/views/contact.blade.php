@extends('layouts.app')

@section('content')

@include('componentes.header')

<!-- HERO -->
<section class="contact-hero d-flex align-items-center">
    <div class="container text-white text-center">
        <h1 class="fw-bold display-5">Contáctanos</h1>
        <p class="lead mt-3">
            Estamos listos para ayudarte con repuestos, cotizaciones y asesoría técnica especializada.
        </p>
    </div>
</section>


<!-- INFO CONTACTO -->
<section class="py-5 bg-light">
    <div class="container">

        <div class="row g-4">

            <div class="col-md-4">
                <div class="contact-card text-center p-4">
                    <i class="bi bi-telephone fs-2 text-warning"></i>
                    <h5 class="mt-3">Teléfono</h5>
                    <p class="text-muted mb-0">+51 999 999 999</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-card text-center p-4">
                    <i class="bi bi-envelope fs-2 text-warning"></i>
                    <h5 class="mt-3">Correo</h5>
                    <p class="text-muted mb-0">ventas@turepuestos.com</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="contact-card text-center p-4">
                    <i class="bi bi-geo-alt fs-2 text-warning"></i>
                    <h5 class="mt-3">Ubicación</h5>
                    <p class="text-muted mb-0">Lima, Perú</p>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- FORMULARIO -->
<section class="py-5">
    <div class="container">

        <div class="row g-5">

            <div class="col-lg-7">

                <h3 class="mb-4 fw-bold">Envíanos un mensaje</h3>

                <form method="POST" action="#">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-lg" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control form-control-lg">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control form-control-lg" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Mensaje</label>
                            <textarea rows="5" class="form-control form-control-lg" required></textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">
                                Enviar mensaje
                            </button>
                        </div>

                    </div>

                </form>

            </div>


            <!-- MAPA -->
            <div class="col-lg-5">
                <h3 class="mb-4 fw-bold">Nuestra ubicación</h3>

                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.62841496596369!2d-79.83619252288946!3d-6.763192601461019!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x904cef92e3804373%3A0x30adef4a7bfeb2d0!2sCasa!5e0!3m2!1ses!2spe!4v1762135763036!5m2!1ses!2spe"
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- CTA FINAL -->
<section class="cta-section text-center text-white py-5">
    <div class="container">
        <h3 class="fw-bold">¿Necesitas asesoría inmediata?</h3>
        <p class="mt-3">Nuestros expertos están disponibles para ayudarte.</p>
        <a href="https://wa.me/51999999999" target="_blank" 
           class="btn btn-success btn-lg fw-bold mt-3">
            Escríbenos por WhatsApp
        </a>
    </div>
</section>

@include('componentes.footer')

@endsection