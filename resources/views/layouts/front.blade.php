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

    <footer class="bg-slate-950 text-slate-400 py-16 border-t border-slate-900 text-sm relative z-30">
    <div class="container mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

            <!-- 1. Marque (Avec Logo SVG) -->
            <div class="col-span-1 md:col-span-1">
                <a href="/" class="flex items-center gap-2 mb-6 group">
                    <div class="bg-blue-600 text-white p-2 rounded-lg shadow-lg shadow-blue-900/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <span class="text-2xl font-black text-white tracking-tighter uppercase">
                        Auto<span class="text-blue-600">Drive</span>
                    </span>
                </a>
                <p class="text-xs leading-relaxed mb-6 text-slate-500">
                    La référence de la location de véhicules premium au Togo. Technologie, Sécurité et Transparence pour vos déplacements.
                </p>

                <!-- 5 Réseaux Sociaux -->
                <div class="flex gap-3">
                    <!-- Facebook -->
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition transform hover:-translate-y-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <!-- Twitter / X -->
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center hover:bg-black hover:text-white transition transform hover:-translate-y-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    <!-- Instagram -->
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-red-500 hover:to-purple-500 hover:text-white transition transform hover:-translate-y-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <!-- LinkedIn -->
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center hover:bg-[#0077b5] hover:text-white transition transform hover:-translate-y-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                    <!-- TikTok -->
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center hover:bg-black hover:text-white transition transform hover:-translate-y-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.35-1.17 1.09-1.07 1.93.03.58.42 1.06 1 1.24.64.22 1.34.15 1.98-.05.81-.25 1.53-.78 1.95-1.45.24-.37.45-.77.58-1.2.02-3.66.01-7.31.02-10.97.02-.13-.02-.27 0-.4 1.27-.01 2.54-.01 3.82-.02z"/></svg></a>
                </div>
            </div>

            <!-- 2. Navigation -->
            <div>
                <h4 class="text-white font-bold uppercase text-xs tracking-widest mb-4">Explorer</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="{{ route('vehicles.index') }}" class="hover:text-blue-500 transition">Notre Flotte</a></li>
                    <li><a href="{{ route('promotions') }}" class="hover:text-blue-500 transition">Offres Flash</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-500 transition">À propos</a></li>
                    <li><a href="{{ route('blog') }}" class="hover:text-blue-500 transition">Blog & Conseils</a></li>
                </ul>
            </div>

            <!-- 3. Légal -->
            <div>
                <h4 class="text-white font-bold uppercase text-xs tracking-widest mb-4">Informations</h4>
                <ul class="space-y-3 text-xs">
                    <li><a href="#" class="hover:text-white transition">Conditions Générales</a></li>
                    <li><a href="#" class="hover:text-white transition">Politique de Confidentialité</a></li>
                    <li><a href="#" class="hover:text-white transition">Mentions Légales</a></li>
                    <li><a href="{{ route('login') }}" class="text-slate-600 hover:text-white transition flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg> Accès Staff</a></li>
                </ul>
            </div>

            <!-- 4. Contact -->
            <div>
                <h4 class="text-white font-bold uppercase text-xs tracking-widest mb-4">Nous trouver</h4>
                <ul class="space-y-4 text-xs">
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>123 Avenue de la Libération,<br>Lomé, Togo</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>+228 90 00 00 00</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>contact@autodrive.tg</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="border-t border-slate-900 pt-8 text-center flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] text-slate-600">
                &copy; {{ date('Y') }} AutoDrive Togo SARL. Tous droits réservés.
            </p>
            <p class="text-[10px] text-slate-600">
                Développé avec <span class="text-red-500 animate-pulse">♥</span> par l'équipe technique.
            </p>
        </div>
    </div>
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
