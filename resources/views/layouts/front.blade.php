<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoDrive</title>
    <!-- On charge le CSS et le JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased min-h-screen flex flex-col">

    <!-- 1. LE MENU DU HAUT (Navbar) -->
    <!-- C'est ici qu'on inclut ton menu "AutoDrive" avec les liens Accueil, Contact... -->
    @include('partials.navbar')

    <!-- 2. LE CONTENU VARIABLE -->
    <!-- C'est ici que s'affichera ta page "Mes Réservations" -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- 3. PIED DE PAGE (Optionnel, pour faire joli) -->
    <footer class="bg-gray-900 text-white mt-12 py-8">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
        <div>
            <h3 class="text-xl font-bold mb-4">AutoDrive</h3>
            <p class="text-gray-400 text-sm">Votre partenaire de confiance pour la location de véhicules. Fiabilité et confort garantis.</p>
        </div>
        <div>
            <h3 class="text-xl font-bold mb-4">Liens rapides</h3>
            <ul class="text-gray-400 text-sm space-y-2">
                <li><a href="{{ route('vehicles.index') }}" class="hover:text-white">Nos Véhicules</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-white">À propos</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-xl font-bold mb-4">Nous trouver</h3>
            <p class="text-gray-400 text-sm">123 Avenue de la Libération<br>Lomé, Togo</p>
        </div>
    </div>
    <div class="text-center text-gray-600 text-xs mt-8 pt-4 border-t border-gray-800">
        &copy; {{ date('Y') }} AutoDrive. Projet Licence Génie Logiciel.
    </div>
</footer>
</body>
</html>