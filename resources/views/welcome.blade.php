<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <x-slot name="title">Accueil AutoDrive</x-slot>

    <!-- On charge Tailwind via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

   @extends('layouts.front')

{{-- SEO SPÉCIFIQUE À L'ACCUEIL --}}
@section('title', 'AutoDrive - Location de voiture pas chère à Lomé')
@section('meta_description', 'Besoin d\'une location de voiture à Lomé ? AutoDrive vous propose des véhicules de tourisme et utilitaires au meilleur prix. Réservez en ligne.')

@section('content')



<!-- STYLE POUR LES ANIMATIONS -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .animate-fade-up { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .animate-float { animation: float 4s ease-in-out infinite; }
</style>

<!-- 1. HERO SECTION IMMERSIF -->
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-slate-900">

    <!-- Image de fond avec effet Parallax léger -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=2000&auto=format&fit=crop"
             class="w-full h-full object-cover opacity-40 scale-105 hover:scale-100 transition-transform duration-[20s] ease-linear">
        <!-- Dégradé sombre pour la lisibilité -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-transparent to-slate-900"></div>
    </div>

    <div class="relative z-10 container mx-auto px-4 text-center mt-[-50px]">

        <!-- Badge Nouveau -->
        <div class="inline-block bg-blue-600/20 border border-blue-500/50 backdrop-blur-md rounded-full px-4 py-1.5 mb-6 animate-fade-up">
            <span class="text-blue-400 text-xs font-bold tracking-[0.2em] uppercase">Nouvelle Flotte 2025 Disponible</span>
        </div>

        <!-- Titre Géant -->
        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight animate-fade-up delay-100">
            Prenez le contrôle <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">de votre voyage</span>
        </h1>

        <p class="text-lg md:text-xl text-slate-300 mb-10 max-w-2xl mx-auto leading-relaxed animate-fade-up delay-200">
            Une expérience de location fluide, sécurisée et sans surprise.
            Véhicules premium, tarifs transparents et assistance 24/7.
        </p>

        <!-- Boutons d'action -->
        <div class="flex flex-col md:flex-row justify-center gap-4 animate-fade-up delay-300">
            <a href="{{ route('vehicles.index') }}" class="group relative px-8 py-4 bg-blue-600 rounded-full text-white font-bold overflow-hidden shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 transition-all">
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                <span class="relative flex items-center gap-2">
                    Réserver un véhicule
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </span>
            </a>
            <a href="{{ route('promotions') }}" class="px-8 py-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-full text-white font-bold hover:bg-white/10 transition flex items-center justify-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Voir les promotions
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 text-white/50 animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
    </div>
</div>

<!-- 2. SECTION FEATURES (Cartes Flottantes) -->
<div class="py-24 bg-gray-50 relative">
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 -mt-32">

            <!-- Carte 1 -->
            <div class="bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition duration-300 animate-float" style="animation-delay: 0s;">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Zéro Papier</h3>
                <p class="text-gray-500 leading-relaxed">Fini la paperasse. Réservez, signez et payez en ligne. Votre contrat est généré instantanément.</p>
            </div>

            <!-- Carte 2 -->
            <div class="bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition duration-300 animate-float" style="animation-delay: 1s;">
                <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Sécurité Certifiée</h3>
                <p class="text-gray-500 leading-relaxed">Données chiffrées, paiements sécurisés. Une infrastructure gérée par des experts certifiés Google.</p>
            </div>

            <!-- Carte 3 -->
            <div class="bg-white p-8 rounded-3xl shadow-xl hover:-translate-y-2 transition duration-300 animate-float" style="animation-delay: 2s;">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Flexibilité Totale</h3>
                <p class="text-gray-500 leading-relaxed">Modifiez ou annulez sans frais jusqu'à 48h avant. Nous nous adaptons à votre rythme.</p>
            </div>

        </div>
    </div>
</div>

<!-- 3. FLOTTE VEDETTE -->
<div class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-end mb-12">
            <div>
                <span class="text-blue-600 font-bold uppercase tracking-widest text-xs">Notre Collection</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-2">Derniers Arrivages</h2>
            </div>
            <a href="{{ route('vehicles.index') }}" class="hidden md:flex items-center gap-2 text-gray-900 font-bold hover:text-blue-600 transition">
                Tout voir <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        @php $featuredVehicles = \App\Models\Vehicle::where('is_available', true)->latest()->take(3)->get(); @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredVehicles as $vehicle)
                <div class="group bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 hover:shadow-2xl transition duration-500">
                    <div class="h-56 overflow-hidden relative">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">Image non disponible</div>
                        @endif
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-xs text-blue-600 font-bold uppercase">{{ $vehicle->brand }}</p>
                                <h3 class="text-xl font-bold text-gray-900">{{ $vehicle->name }}</h3>
                            </div>
                            <div class="bg-white px-2 py-1 rounded-md shadow-sm border border-gray-100">
                                <p class="text-xs font-bold text-gray-900">{{ $vehicle->type }}</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 my-4 pt-4 flex justify-between items-center">
                            <p class="text-2xl font-black text-gray-900">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-500">FCFA</span></p>
                            <a href="{{ route('vehicle.show', $vehicle->id) }}" class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center text-white group-hover:bg-blue-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

</body>

</html>
