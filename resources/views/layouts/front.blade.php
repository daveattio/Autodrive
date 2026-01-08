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
    <!-- BOUTON WHATSAPP FLOTTANT -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-2 group">

        <!-- Bulle d'aide (Apparaît au survol) -->
        <div class="bg-white px-4 py-2 rounded-lg shadow-lg border border-gray-100 text-slate-800 text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-2 group-hover:translate-y-0 pointer-events-none mb-1">
            Besoin d'aide ? Discutez avec nous !
        </div>

        <!-- Le Bouton -->
        <a href="https://wa.me/22870932343?text=Bonjour,%20je%20suis%20intéressé%20par%20une%20location%20de%20voiture."
            target="_blank"
            class="bg-[#25D366] hover:bg-[#20bd5a] text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg shadow-green-500/30 transition-all transform hover:scale-110 hover:-translate-y-1 animate-bounce-slow">

            <!-- Icône WhatsApp SVG -->
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
            </svg>
        </a>
    </div>

    <style>
        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s infinite;
        }
    </style>
</body>

</html>
