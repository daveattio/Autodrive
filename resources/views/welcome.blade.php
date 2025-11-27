<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <x-slot name="title">Accueil AutoDrive</x-slot>

    <!-- On charge Tailwind via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 antialiased">

    @include('partials.navbar')

    <!-- Bannière Hero -->
    <div class="bg-blue-600 text-white py-20 text-center">
        <h1 class="text-5xl font-bold mb-4">Louez la voiture de vos rêves</h1>
        <p class="text-xl mb-8">Simple, Rapide et Sécurisé.</p>
        <a href="{{ route('vehicles.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100">
            Voir tous les véhicules
        </a>
    </div>

    <!-- (Tu pourras ajouter une section "Derniers ajouts" ici plus tard si on a le temps) -->

</body>

</html>
