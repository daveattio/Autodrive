<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- 1. TITRE DYNAMIQUE (SEO) -->
    <title>@yield('title', 'AutoDrive - Location de voitures à Lomé et au Togo')</title>

    <!-- 2. META DESCRIPTION DYNAMIQUE (SEO) -->
    <meta name="description" content="@yield('meta_description', 'Louez des véhicules pas chers, SUV, Berlines et Utilitaires au Togo. Service fiable, rapide et sécurisé. Réservation en ligne 24/7.')">

    <!-- 3. MOTS-CLÉS (Keywords) -->
    <meta name="keywords" content="location voiture Lomé, voiture pas chère Togo, location utilitaire, AutoDrive, location 4x4">

    <!-- OPEN GRAPH (Pour que le lien soit joli sur WhatsApp/Facebook) -->
    <meta property="og:title" content="@yield('title', 'AutoDrive Togo')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}"> <!-- Mets une belle image de voiture ici plus tard -->
    <meta property="og:type" content="website">

    <!-- PRELOAD (Optimisation vitesse) -->
    <link rel="preconnect" href="https://fonts.bunny.net">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Flatpickr (Calendrier) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col">

    @include('partials.navbar')

    <main class="flex-grow">
        <!-- MAGIE ICI : On affiche soit le slot (Livewire), soit le content (Blade classique) -->
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-12 py-8 text-center">
        <p>&copy; {{ date('Y') }} AutoDrive. Tous droits réservés.</p>
    </footer>

</body>

</html>
