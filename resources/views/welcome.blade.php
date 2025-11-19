<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AutoDrive - Location de voitures</title>
        
        <!-- On charge Tailwind via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 antialiased">
        
        <!-- Barre de navigation simplifiée -->
        <nav class="bg-white shadow p-4 mb-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold text-blue-600">AutoDrive</h1>
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600">Mon Compte</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 mr-4">Connexion</a>
                            <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Inscription</a>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- NOTRE CATALOGUE LIVEWIRE EST ICI -->
        <livewire:front.vehicle-catalog />

    </body>
</html>