@extends('layouts.front')

@section('title', 'AutoDrive - La référence de la location au Togo')

@section('content')

<!-- --- STYLE SPÉCIFIQUE POUR LES ANIMATIONS --- -->
<style>
    /* Effet d'apparition au scroll */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* Animation lente du fond Hero */
    @keyframes kenburns {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    .animate-kenburns {
        animation: kenburns 20s infinite alternate;
    }
</style>

<!-- 1. HERO SECTION IMMERSIF (Plein Écran) -->
<div class="relative h-screen flex items-center justify-center overflow-hidden">
    <!-- Image de fond animée -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1493238792000-8113da705763?q=80&w=2000&auto=format&fit=crop"
             class="w-full h-full object-cover animate-kenburns"
             alt="Roadtrip Togo">
        <!-- Filtre sombre dégradé -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/50 to-slate-900"></div>
    </div>

    <div class="relative z-10 container mx-auto px-4 text-center">
        <div class="inline-block mb-4 px-4 py-1 rounded-full border border-blue-400/30 bg-blue-500/10 backdrop-blur-md">
            <span class="text-blue-400 font-bold tracking-widest uppercase text-xs">Bienvenue chez AutoDrive</span>
        </div>

        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight drop-shadow-lg">
            La route est à <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">vous</span>.
        </h1>

        <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
            Louez des véhicules d'exception à Lomé. Simplicité, sécurité et transparence.
            Votre voyage commence ici.
        </p>

        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="{{ route('vehicles.index') }}" class="group relative px-8 py-4 bg-blue-600 rounded-full font-bold text-white shadow-lg shadow-blue-600/30 overflow-hidden">
                <span class="relative z-10 group-hover:text-white transition">Voir les véhicules</span>
                <div class="absolute inset-0 h-full w-full bg-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
            </a>
            <a href="#how-it-works" class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-full font-bold text-white hover:bg-white/20 transition">
                Comment ça marche ?
            </a>
        </div>
    </div>

    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
    </div>
</div>

<!-- 2. BARRE DE RECHERCHE FLOTTANTE (Glassmorphism) -->
<div class="relative -mt-24 z-20 container mx-auto px-4">
    <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl p-4 md:p-8 border border-white/50 max-w-4xl mx-auto reveal">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Je cherche un véhicule</label>
                <div class="relative">
                    <select class="w-full bg-gray-50 border border-gray-200 text-gray-900 font-bold rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500">
                        <option>Tous les modèles</option>
                        <option>SUV / 4x4</option>
                        <option>Berlines</option>
                        <option>Utilitaires</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Budget journalier</label>
                <select class="w-full bg-gray-50 border border-gray-200 text-gray-900 font-bold rounded-xl py-3 px-4 focus:ring-blue-500 focus:border-blue-500">
                    <option>Peu importe</option>
                    <option>Moins de 20 000 FCFA</option>
                    <option>20 000 - 50 000 FCFA</option>
                    <option>Plus de 50 000 FCFA</option>
                </select>
            </div>
            <a href="{{ route('vehicles.index') }}" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl shadow-lg flex items-center justify-center gap-2 transition transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Rechercher
            </a>
        </div>
    </div>
</div>

<!-- 3. CARROUSEL DE VÉHICULES (Dynamique) -->
<div class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-12 reveal">
            <div>
                <h2 class="text-4xl font-black text-slate-900">Nos Stars de la route</h2>
                <p class="text-gray-500 mt-2 text-lg">Sélectionnés pour leur confort et leur fiabilité.</p>
            </div>
            <a href="{{ route('vehicles.index') }}" class="hidden md:flex items-center gap-2 text-blue-600 font-bold hover:gap-4 transition-all">
                Voir tout le catalogue <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        @php
            $featuredVehicles = \App\Models\Vehicle::where('is_available', true)->inRandomOrder()->take(3)->get();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredVehicles as $index => $vehicle)
                <!-- Carte Véhicule (Avec délai d'apparition) -->
                <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden group hover:-translate-y-3 transition duration-500 reveal" style="transition-delay: {{ $index * 100 }}ms">
                    <div class="h-64 overflow-hidden relative">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">No Image</div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-slate-900 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">
                            {{ $vehicle->type }}
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-blue-600 font-bold text-xs uppercase">{{ $vehicle->brand }}</p>
                                <h3 class="text-2xl font-black text-slate-900">{{ $vehicle->name }}</h3>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 text-gray-500 text-sm mb-6 border-y border-gray-100 py-4">
                            <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg> {{ $vehicle->transmission }}</span>
                            <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Top État</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-3xl font-black text-slate-900">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} <span class="text-sm text-gray-400 font-normal">FCFA</span></p>
                            <a href="{{ route('vehicle.show', $vehicle->id) }}" class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center text-white hover:bg-blue-600 transition shadow-lg group-hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- 4. SECTION STATS (Compteurs animés) -->
<div class="bg-blue-900 py-20 relative overflow-hidden">
    <!-- Déco de fond -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10">
        <svg class="absolute top-0 left-0 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] text-white" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
        <svg class="absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2 w-[600px] h-[600px] text-white" fill="currentColor" viewBox="0 0 100 100"><circle cx="50" cy="50" r="50"/></svg>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
            <div class="reveal">
                <p class="text-5xl font-black mb-2 count-up" data-target="50">0</p>
                <p class="text-blue-300 uppercase tracking-widest text-xs font-bold">Véhicules</p>
            </div>
            <div class="reveal" style="transition-delay: 100ms">
                <p class="text-5xl font-black mb-2 count-up" data-target="1200">0</p>
                <p class="text-blue-300 uppercase tracking-widest text-xs font-bold">Clients</p>
            </div>
            <div class="reveal" style="transition-delay: 200ms">
                <p class="text-5xl font-black mb-2 count-up" data-target="24">0</p>
                <p class="text-blue-300 uppercase tracking-widest text-xs font-bold">Heures / 24 Support</p>
            </div>
            <div class="reveal" style="transition-delay: 300ms">
                <p class="text-5xl font-black mb-2 count-up" data-target="100">0</p>
                <p class="text-blue-300 uppercase tracking-widest text-xs font-bold">% Fiabilité</p>
            </div>
        </div>
    </div>
</div>

<!-- 5. COMMENT ÇA MARCHE (Étapes) -->
<div id="how-it-works" class="py-24 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 reveal">
            <h2 class="text-4xl font-black text-slate-900 mb-4">Louer n'a jamais été aussi simple</h2>
            <p class="text-gray-500 text-lg">3 étapes, 5 minutes, et vous êtes sur la route.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
            <!-- Ligne de connexion (Desktop) -->
            <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-0.5 bg-gray-200 z-0"></div>

            <!-- Étape 1 -->
            <div class="relative z-10 text-center reveal">
                <div class="w-24 h-24 bg-white border-4 border-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg text-3xl font-black">1</div>
                <h3 class="text-xl font-bold mb-3">Choisissez</h3>
                <p class="text-gray-500 leading-relaxed px-4">Parcourez notre catalogue et filtrez selon vos besoins : SUV, Berline, Eco...</p>
            </div>
            <!-- Étape 2 -->
            <div class="relative z-10 text-center reveal" style="transition-delay: 200ms">
                <div class="w-24 h-24 bg-white border-4 border-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg text-3xl font-black">2</div>
                <h3 class="text-xl font-bold mb-3">Réservez</h3>
                <p class="text-gray-500 leading-relaxed px-4">Créez votre profil (Particulier ou Pro), choisissez vos dates et validez.</p>
            </div>
            <!-- Étape 3 -->
            <div class="relative z-10 text-center reveal" style="transition-delay: 400ms">
                <div class="w-24 h-24 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg text-3xl font-black">3</div>
                <h3 class="text-xl font-bold mb-3">Roulez</h3>
                <p class="text-gray-500 leading-relaxed px-4">Récupérez vos clés en agence. Le véhicule est prêt, propre et le plein est fait.</p>
            </div>
        </div>
    </div>
</div>

<!-- 6. PROMO BANNIÈRE (Urgence) -->
<div class="container mx-auto px-4 mb-20 reveal">
    <div class="bg-slate-900 rounded-[3rem] p-10 md:p-20 text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        <div class="relative z-10">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Prêt à prendre la route ?</h2>
            <p class="text-blue-200 text-xl mb-10 max-w-2xl mx-auto">Profitez de nos offres de lancement et partez à l'aventure dès aujourd'hui.</p>
            <a href="{{ route('promotions') }}" class="inline-block bg-white text-slate-900 px-10 py-4 rounded-full font-black text-lg hover:bg-blue-50 transition transform hover:scale-105 shadow-xl">
                Voir les promotions
            </a>
        </div>
    </div>
</div>

<!-- SCRIPT JS POUR LES ANIMATIONS -->
<script>
    // 1. SCROLL REVEAL (Apparition au défilement)
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
    reveal(); // Au chargement

    // 2. COMPTEUR ANIMÉ (Pour les stats)
    const counters = document.querySelectorAll('.count-up');
    const speed = 200;

    const animateCounters = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target + (target > 1000 ? '+' : ''); // Ajoute un + si grand nombre
                }
            };
            updateCount();
        });
    }

    // Lance l'animation des compteurs quand on arrive dessus
    let hasAnimated = false;
    window.addEventListener('scroll', () => {
        const statsSection = document.querySelector('.bg-blue-900');
        if (statsSection && !hasAnimated && statsSection.getBoundingClientRect().top < window.innerHeight) {
            animateCounters();
            hasAnimated = true;
        }
    });
</script>

@endsection
