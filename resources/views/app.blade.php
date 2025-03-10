<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        @php
            use Illuminate\Support\Facades\Session;
            $nonce = Session::get('csp_nonce'); // Récupération du nonce stocké en session
        @endphp
        <!-- Injection du nonce dans les balises meta -->
        <meta name="csp-nonce" content="{{ $nonce }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" nonce="{{ $nonce }}">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" nonce="{{ $nonce }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" nonce="{{ $nonce }}">

        <!-- Scripts -->
        <script nonce="{{ $nonce }}">
            window.cspNonce = "{{ $nonce }}"; // Permet de récupérer le nonce côté Vue.js
        </script>

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        <!-- Test pour voir le nonce injecté -->
        <p style="display: none;">CSP Nonce: {{ $nonce }}</p>

        @inertia
    </body>
</html>
