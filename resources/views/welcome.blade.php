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

<!-- 1. HERO SECTION (Image de fond) -->
<div class="relative bg-gray-900 h-[600px] flex items-center">
    <!-- Image de fond sombre -->
    <div class="absolute inset-0 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1485291571150-772bcfc10da5?q=80&w=2000&auto=format&fit=crop"
             class="w-full h-full object-cover opacity-40"
             alt="Location voiture Lomé">
    </div>

    <div class="relative container mx-auto px-4 text-center">
        <span class="text-blue-400 font-bold tracking-widest uppercase text-sm mb-2 block animate-fade-in-up">Bienvenue chez AutoDrive</span>
        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight">
            Explorez le Togo <br> en toute <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">liberté</span>
        </h1>
        <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
            La référence de la location de voiture à Lomé. Des véhicules récents, assurés et disponibles 24/7 pour vos séjours professionnels ou touristiques.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('vehicles.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full font-bold text-lg transition transform hover:scale-105 shadow-lg shadow-blue-500/30">
                Choisir un véhicule
            </a>
            <a href="{{ route('contact') }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/30 px-8 py-4 rounded-full font-bold text-lg transition">
                Nous contacter
            </a>
        </div>
    </div>
</div>

<!-- 2. POURQUOI NOUS CHOISIR (Réassurance) -->
<div class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
            <div class="p-6">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Prix Transparents</h3>
                <p class="text-gray-500">Pas de frais cachés. Le prix affiché est le prix payé. Une location de voiture pas chère et honnête.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Réservation Facile</h3>
                <p class="text-gray-500">Réservez en 3 clics. Notre système de location en ligne est optimisé pour vous faire gagner du temps.</p>
            </div>
            <div class="p-6">
                <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Véhicules Premium</h3>
                <p class="text-gray-500">Une flotte entretenue régulièrement. De la citadine économique au SUV de luxe pour vos voyages.</p>
            </div>
        </div>
    </div>
</div>

<!-- 3. VÉHICULES EN VEDETTE (Dynamique) -->
<div class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-gray-900">Nos Derniers Véhicules</h2>
            <p class="text-gray-500 mt-2">Découvrez les nouveautés de notre flotte.</p>
        </div>

        <!-- On utilise PHP directement ici pour récupérer 3 voitures -->
        @php
            $featuredVehicles = \App\Models\Vehicle::where('is_available', true)->latest()->take(3)->get();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredVehicles as $vehicle)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:-translate-y-2 transition duration-300">
                    <div class="h-48 overflow-hidden relative">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">Photo non disponible</div>
                        @endif
                        <div class="absolute top-3 right-3 bg-white px-3 py-1 rounded-full text-xs font-bold shadow">{{ $vehicle->type }}</div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-xl mb-1">{{ $vehicle->brand }} {{ $vehicle->name }}</h3>
                        <p class="text-blue-600 font-black text-lg mb-4">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} FCFA <span class="text-sm text-gray-400 font-normal">/jour</span></p>
                        <a href="{{ route('vehicle.show', $vehicle->id) }}" class="block w-full py-3 bg-gray-900 text-white text-center rounded-lg font-bold hover:bg-blue-600 transition">
                            Voir détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('vehicles.index') }}" class="text-blue-600 font-bold hover:underline">Voir toute la flotte →</a>
        </div>
    </div>
</div>

@endsection

</body>

</html>
