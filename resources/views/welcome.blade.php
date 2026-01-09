@extends('layouts.front')

@section('title', 'AutoDrive - La Location Premium au Togo')

@section('content')

<!-- 1. HERO SECTION (IMMERSIVE) -->
<div class="relative h-[85vh] flex items-center justify-center overflow-hidden bg-slate-900">

    <!-- Image de fond avec effet de zoom lent -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.pexels.com/photos/164634/pexels-photo-164634.jpeg"
             class="w-full h-full object-cover opacity-50 animate-slow-zoom"
             alt="Luxury Car">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-slate-900/60"></div>
    </div>

    <!-- Contenu Central -->
    <div class="relative z-10 container mx-auto px-4 text-center text-white mt-10">
        <span class="inline-block py-1 px-3 rounded-full bg-blue-600/20 border border-blue-500/50 text-blue-300 text-xs font-bold uppercase tracking-widest mb-6 animate-fade-in-down">
            Nouvelle Flotte 2026 Disponible
        </span>

        <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight animate-fade-in-up">
            Conduisez <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">l'exceptionnel</span>.
        </h1>

        <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto animate-fade-in-up delay-100">
            La première plateforme de location 100% digitale au Togo. Réservez en 2 minutes, roulez en toute liberté.
        </p>

        <!-- Barre de Recherche "Glassmorphism" -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl max-w-4xl mx-auto shadow-2xl animate-fade-in-up delay-200 transform hover:scale-[1.01] transition duration-500">
            <form action="{{ route('vehicles.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 text-left">
                    <label class="block text-xs text-gray-400 uppercase font-bold ml-2 mb-1">Je cherche</label>
                    <input type="text" name="search" placeholder="Marque, Modèle..." class="w-full bg-slate-800/50 border border-slate-600 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="flex-1 text-left">
                    <label class="block text-xs text-gray-400 uppercase font-bold ml-2 mb-1">Catégorie</label>
                    <select class="w-full bg-slate-800/50 border border-slate-600 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les types</option>
                        <option>Berline</option>
                        <option>SUV / 4x4</option>
                        <option>Luxe</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg shadow-blue-600/30 transition transform hover:-translate-y-1">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Indicateur de Scroll -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce text-gray-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
    </div>
</div>

<!-- 2. SECTION STATS (Compteur) -->
<div class="bg-white py-10 border-b border-gray-100">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-gray-100">
            <div class="reveal">
                <span class="block text-4xl font-black text-slate-900 mb-1">50+</span>
                <span class="text-sm text-gray-500 uppercase tracking-wider font-bold">Véhicules</span>
            </div>
            <div class="reveal delay-100">
                <span class="block text-4xl font-black text-blue-600 mb-1">24/7</span>
                <span class="text-sm text-gray-500 uppercase tracking-wider font-bold">Support</span>
            </div>
            <div class="reveal delay-200">
                <span class="block text-4xl font-black text-slate-900 mb-1">100%</span>
                <span class="text-sm text-gray-500 uppercase tracking-wider font-bold">Satisfait</span>
            </div>
            <div class="reveal delay-300">
                <span class="block text-4xl font-black text-green-500 mb-1">0F</span>
                <span class="text-sm text-gray-500 uppercase tracking-wider font-bold">Frais cachés</span>
            </div>
        </div>
    </div>
</div>

<!-- 3. COMMENT ÇA MARCHE (Steps) -->
<div class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto mb-16 reveal">
            <span class="text-blue-600 font-bold uppercase tracking-widest text-xs">Simplicité</span>
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 mt-2 mb-4">Louez votre voiture en 3 étapes.</h2>
            <p class="text-gray-500">Fini la paperasse interminable. Avec AutoDrive, tout se passe en ligne, de la sélection à la remise des clés.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
            <!-- Ligne de connexion (Desktop) -->
            <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-0.5 bg-gray-200 -z-10"></div>

            <!-- Étape 1 -->
            <div class="text-center group reveal hover:-translate-y-2 transition duration-300">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-xl mx-auto mb-6 border-4 border-white group-hover:border-blue-500 transition duration-300 relative z-10">
                    <svg class="w-10 h-10 text-slate-700 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">1. Choisissez</h3>
                <p class="text-gray-500 text-sm px-6">Parcourez notre catalogue et filtrez selon vos besoins : Berline, SUV ou Utilitaire.</p>
            </div>

            <!-- Étape 2 -->
            <div class="text-center group reveal delay-100 hover:-translate-y-2 transition duration-300">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-xl mx-auto mb-6 border-4 border-white group-hover:border-blue-500 transition duration-300 relative z-10">
                    <svg class="w-10 h-10 text-slate-700 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">2. Réservez</h3>
                <p class="text-gray-500 text-sm px-6">Sélectionnez vos dates. Créez votre profil (Particulier ou Entreprise) en quelques secondes.</p>
            </div>

            <!-- Étape 3 -->
            <div class="text-center group reveal delay-200 hover:-translate-y-2 transition duration-300">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-xl mx-auto mb-6 border-4 border-white group-hover:border-blue-500 transition duration-300 relative z-10">
                    <svg class="w-10 h-10 text-slate-700 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">3. Roulez</h3>
                <p class="text-gray-500 text-sm px-6">Validez le paiement sécurisé. Récupérez vos clés à l'agence et profitez de la route.</p>
            </div>
        </div>
    </div>
</div>

<!-- 4. LA FLOTTE EN VEDETTE (Grid Premium) -->
<div class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 reveal">
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900">Nos Stars du moment</h2>
                <p class="text-gray-500 mt-2">Les modèles les plus demandés cette semaine.</p>
            </div>
            <a href="{{ route('vehicles.index') }}" class="hidden md:inline-flex items-center gap-2 text-blue-600 font-bold hover:gap-3 transition-all">
                Voir tout le catalogue <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        @php
            $featuredVehicles = \App\Models\Vehicle::where('is_available', true)->inRandomOrder()->take(3)->get();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredVehicles as $vehicle)
                <div class="group bg-gray-50 rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl transition duration-500 reveal">
                    <div class="h-64 overflow-hidden relative">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-60"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="bg-blue-600 text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-1 inline-block">{{ $vehicle->type }}</span>
                            <h3 class="text-xl font-bold">{{ $vehicle->brand }} {{ $vehicle->name }}</h3>
                        </div>
                    </div>
                    <div class="p-6 flex justify-between items-center">
                        <div>
                            <p class="text-gray-400 text-xs uppercase font-bold">À partir de</p>
                            <p class="text-slate-900 text-2xl font-black">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-500">FCFA</span></p>
                        </div>
                        <a href="{{ route('vehicle.show', $vehicle->id) }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 shadow-md group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center md:hidden">
             <a href="{{ route('vehicles.index') }}" class="inline-flex items-center gap-2 text-blue-600 font-bold">
                Voir tout le catalogue <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</div>

<!-- 5. SECTION PARALLAX / PROMO (Coupure visuelle) -->
<div class="relative py-32 bg-fixed bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1542362567-b07e54358753?q=80&w=2000&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-slate-900/70"></div>
    <div class="container mx-auto px-4 relative z-10 text-center text-white reveal">
        <h2 class="text-4xl md:text-6xl font-black mb-6">Besoin d'une location longue durée ?</h2>
        <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
            Profitez de tarifs dégressifs pour les entreprises et les séjours de plus de 30 jours. Devis personnalisé en 24h.
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-slate-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-blue-50 transition transform hover:scale-105 shadow-xl">
            Contacter le service Pro
        </a>
    </div>
</div>

<!-- 6. FAQ (Accordéon) -->
<div class="py-24 bg-white" x-data="{ active: null }">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="text-center mb-16 reveal">
            <h2 class="text-3xl font-bold text-slate-900">Questions Fréquentes</h2>
        </div>

        <div class="space-y-4">
            <!-- Question 1 -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden reveal">
                <button @click="active = (active === 1 ? null : 1)" class="w-full text-left p-6 flex justify-between items-center bg-white hover:bg-gray-50 transition">
                    <span class="font-bold text-lg text-slate-800">Quels documents pour louer une voiture ?</span>
                    <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="active === 1" x-collapse class="p-6 pt-0 text-gray-600 bg-gray-50 border-t border-gray-100">
                    Il vous faut un permis de conduire valide de plus de 2 ans, une pièce d'identité (CNI ou Passeport) et une caution (CB ou espèces).
                </div>
            </div>

            <!-- Question 2 -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden reveal">
                <button @click="active = (active === 2 ? null : 2)" class="w-full text-left p-6 flex justify-between items-center bg-white hover:bg-gray-50 transition">
                    <span class="font-bold text-lg text-slate-800">L'assurance est-elle incluse ?</span>
                    <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="active === 2" x-collapse class="p-6 pt-0 text-gray-600 bg-gray-50 border-t border-gray-100">
                    Oui, tous nos véhicules incluent une assurance responsabilité civile. Une assurance tous risques est disponible en option lors de la réservation.
                </div>
            </div>

            <!-- Question 3 -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden reveal">
                <button @click="active = (active === 3 ? null : 3)" class="w-full text-left p-6 flex justify-between items-center bg-white hover:bg-gray-50 transition">
                    <span class="font-bold text-lg text-slate-800">Puis-je annuler ma réservation ?</span>
                    <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="active === 3" x-collapse class="p-6 pt-0 text-gray-600 bg-gray-50 border-t border-gray-100">
                    L'annulation est gratuite jusqu'à 48h avant le début de la location. Passé ce délai, des frais peuvent s'appliquer.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT D'ANIMATION AU SCROLL (Simple et Léger) -->
<style>
    /* Classes pour l'animation */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }
    /* Animation lente du zoom sur le Hero */
    @keyframes slow-zoom {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    .animate-slow-zoom {
        animation: slow-zoom 20s infinite alternate;
    }
    /* Fade In basique */
    .animate-fade-in-up { animation: fadeInUp 1s ease-out forwards; opacity: 0; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
</style>

<script>
    // Petit script pour déclencher les animations quand on scrolle
    function reveal() {
        var reveals = document.querySelectorAll(".reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 150;
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }
    }
    window.addEventListener("scroll", reveal);
    // Déclencher une fois au chargement pour les éléments déjà visibles
    reveal();
</script>

@endsection
