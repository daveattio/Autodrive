<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO DYNAMIQUE (Gestion des titres) -->
    <title>
        @hasSection('title')
            @yield('title') - AutoDrive
        @else
            {{ $title ?? 'AutoDrive - Location de voitures' }}
        @endif
    </title>

    <meta name="description" content="@yield('meta_description', 'La meilleure agence de location au Togo.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
