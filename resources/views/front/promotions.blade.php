@extends('layouts.front')

@section('title', 'Offres Flash & Promotions - AutoDrive')

@section('content')
<div class="bg-gray-50 min-h-screen py-16">
    <div class="container mx-auto px-4 max-w-7xl">

        <!-- En-tête -->
        <div class="text-center mb-16 relative">
            <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-2 block">Opportunités à saisir</span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4">Nos Offres <span class="text-red-600">Flash</span></h1>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto">Profitez de tarifs exceptionnels sur une sélection de véhicules. Attention, ces offres sont limitées dans le temps !</p>
        </div>

        @if($promotions->isEmpty())
        <!-- État vide -->
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Aucune offre flash en ce moment</h3>
            <p class="text-gray-500 mt-2">Nos meilleures offres reviendront très vite.</p>
            <a href="{{ route('vehicles.index') }}" class="mt-6 px-6 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition">Voir le catalogue standard</a>
        </div>
        @else
        <!-- GRILLE DES CARTES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($promotions as $promo)
            <div class="group bg-white rounded-[2rem] border border-gray-100 overflow-hidden shadow-lg hover:shadow-2xl hover:shadow-red-900/10 transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full relative">

                <!-- IMAGE + LE BADGE MARQUE -->
                <div class="h-64 relative overflow-hidden bg-gray-200">
                    @if($promo->image)
                    <img src="{{ asset('storage/' . $promo->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                    @else
                    <div class="flex items-center justify-center h-full bg-slate-800 text-slate-600">
                        <svg class="w-20 h-20 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif

                    <!-- LE fameux LOGO FLASH (Ta référence) -->
                    <div class="absolute top-4 left-4 bg-[#DC2626] text-white px-5 py-3 rounded-2xl shadow-[0_10px_20px_rgba(220,38,38,0.4)] flex items-center gap-2 z-10 transform -rotate-2 group-hover:rotate-0 transition duration-300">
                        <!-- Icône Éclair -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <!-- Pourcentage -->
                        <span class="text-3xl font-black italic tracking-tighter leading-none">-{{ $promo->discount_percent }}%</span>
                    </div>

                    <!-- Overlay dégradé en bas -->
                    <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>

                <!-- CONTENU -->
                <div class="p-6 flex flex-col flex-grow relative">

                    <!-- Si lié à un véhicule : Tags comme sur le catalogue -->
                    @if($promo->vehicle)
                    <div class="flex flex-wrap gap-2 mb-3">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ $promo->vehicle->type }}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">
                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                            {{ $promo->vehicle->transmission }}
                        </span>
                    </div>
                    @else
                    <div class="mb-3">
                        <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-100">
                            Offre Globale
                        </span>
                    </div>
                    @endif

                    <!-- Titre Promo -->
                    <h3 class="text-2xl font-black text-slate-900 mb-3 leading-tight group-hover:text-blue-600 transition">{{ $promo->title }}</h3>

                    <!-- Description -->
                    <p class="text-gray-500 text-sm mb-6 line-clamp-2 flex-grow">
                        {{ $promo->description }}
                    </p>

                    <div class="mt-auto pt-5 border-t border-gray-100">

                        <!-- Date de validité (Icône Date) -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2 text-xs font-bold text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg w-full">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-400">Du</span>
                                <span class="text-slate-700">{{ \Carbon\Carbon::parse($promo->start_date)->format('d/m') }}</span>
                                <span class="text-gray-400">au</span>
                                <span class="text-slate-700">{{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <!-- Bouton d'action -->
                        <!-- Bouton d'action (Style Catalogue Flash) -->
                        <div class="mt-4">
                            @if($promo->vehicle_id)
                            <!-- CAS 1 : Promo liée à un véhicule -->
                            <a href="{{ route('vehicle.show', $promo->vehicle_id) }}"
                                class="group bg-slate-900 text-white px-5 py-3 rounded-xl font-bold text-sm hover:bg-blue-900 transition shadow-lg flex items-center justify-center gap-3 overflow-hidden relative">

                                <!-- Logo (Gauche, Effet Flash Jaune) -->
                                <svg class="w-4 h-4 text-blue-400 group-hover:text-yellow-400 group-hover:scale-125 transition duration-300 ease-out transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>

                                <!-- Texte -->
                                <span class="relative z-10">Réserver ce véhicule</span>

                                <!-- Effet Lumière au survol -->
                                <div class="absolute inset-0 h-full w-full bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition duration-700 ease-in-out"></div>
                            </a>
                            @else
                            <!-- CAS 2 : Promo générale (Catalogue) -->
                            <a href="{{ route('vehicles.index') }}"
                                class="group bg-white border-2 border-slate-200 text-slate-700 px-5 py-3 rounded-xl font-bold text-sm hover:border-slate-900 hover:text-slate-900 transition flex items-center justify-center gap-3 overflow-hidden relative">

                                <!-- Logo (Gauche) -->
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-900 transition duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>

                                <span class="relative z-10">Voir le catalogue</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16">
            {{ $promotions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
