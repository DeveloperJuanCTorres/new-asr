<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <?php
        $version = '1993.0.2';
    ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v=<?php echo $version ?>">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}?v=<?php echo $version ?>">
    <link href="{{asset('css/phone.css')}}?v=<?php echo $version ?>" rel="stylesheet">

    <!-- Scripts -->
    <!-- vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>
<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
     <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{asset('js/phone.js')}}?v=<?php echo $version ?>"></script>
    <script src="{{asset('js/ubigeo.js')}}?v=<?php echo $version ?>"></script>
    <script>
        document.getElementById("cart-toggle").addEventListener("click", function(){
            document.getElementById("mini-cart").classList.add("open");
            loadMiniCart();
        });

        document.getElementById("close-mini-cart").addEventListener("click", function(){
            document.getElementById("mini-cart").classList.remove("open");
        });

        function loadMiniCart(){
            fetch("{{ route('cart.mini') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById("mini-cart-body").innerHTML = html;
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
