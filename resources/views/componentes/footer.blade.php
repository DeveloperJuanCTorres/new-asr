<footer class="main-footer text-white pt-5">

    <div class="container">

        <div class="row">

            <!-- Logo + Descripción -->
            <div class="col-lg-4 col-md-6 mb-4">
                <img src="/images/logo-asr.png" height="45" class="mb-3" alt="Logo">

                <p class="footer-description">
                    {{$company->description}}
                </p>

                <!-- Redes -->
                <div class="social-icons mt-3">
                    <a href="{{$company->link_facebook}}"><i class="bi bi-facebook"></i></a>
                    <a href="{{$company->link_instagram}}"><i class="bi bi-instagram"></i></a>
                    <a href="{{$company->link_youtube}}"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <!-- Enlaces rápidos -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="footer-title">Enlaces</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('shop.index') }}">Tienda</a></li>
                    <li><a href="{{ route('about') }}">Nosotros</a></li>
                    <li><a href="{{ route('contact') }}">Contáctanos</a></li>
                    <li><a href="{{ route('cart.index') }}">Carrito</a></li>
                </ul>
            </div>

            <!-- Categorías dinámicas -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="footer-title">Categorías</h6>
                <ul class="footer-links">
                    @foreach($global_categories ?? [] as $cat)
                        <li>
                            <a href="{{ route('shop.category', $cat->slug) }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="footer-title">Contacto</h6>

                <p class="mb-1">
                    📍 {{$company->address}}
                </p>

                <p class="mb-1">
                    📞 {{$company->phone}}
                </p>

                <p class="mb-1">
                    ✉ {{$company->email}}
                </p>

                <!-- Libro de reclamaciones -->
                <div class="libro-reclamaciones mt-3">
                    <a href="{{ route('libro.reclamaciones') }}" class="btn btn-outline-warning btn-sm w-100">
                        📘 Libro de Reclamaciones
                    </a>
                </div>

            </div>

        </div>

        <!-- Línea separadora -->
        <hr class="footer-divider">

        <!-- Bottom -->
        <div class="row align-items-center pb-3">

            <div class="col-md-6 text-center text-md-start small">
                © {{ date('Y') }} ASR Repuestos. Todos los derechos reservados.
            </div>

            <div class="col-md-6 text-center text-md-end">
                <img src="/images/metodos-pago.png" height="28" alt="Métodos de pago">
            </div>

        </div>

    </div>

</footer>