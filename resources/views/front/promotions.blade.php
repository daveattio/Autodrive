@extends('layouts.front')

@section('title', 'Offres Spéciales & Promotions - AutoDrive')

@section('content')
<div class="bg-gray-50 min-h-screen pb-20">

    <!-- 1. EN-TÊTE HERO (Design Sombre & Premium) -->
    <div class="relative bg-slate-900 py-20 overflow-hidden">
        <!-- Effets de fond -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-blue-600 rounded-full blur-[120px] opacity-20"></div>
            <div class="absolute bottom-0 left-10 w-72 h-72 bg-purple-600 rounded-full blur-[100px] opacity-20"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-900/50 border border-blue-500/30 text-blue-300 text-xs font-bold uppercase tracking-widest mb-4">
                Bons Plans
            </span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-4 tracking-tight">
                Nos Offres <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Exclusives</span>
            </h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto">
                Profitez de réductions exceptionnelles sur une sélection de véhicules. <br>Premier arrivé, premier servi !
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 max-w-7xl -mt-10 relative z-20">

        @if($promotions->isEmpty())
            <!-- ÉTAT VIDE (Joli Design) -->
            <div class="bg-white rounded-3xl shadow-xl p-12 text-center border border-gray-100">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 rounded-full mb-6 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" /></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Pas de promo en ce moment</h3>
                <p class="text-gray-500 mt-2">Nos prix sont déjà très bas, mais revenez vite pour les soldes !</p>
                <a href="{{ route('vehicles.index') }}" class="inline-block mt-6 px-6 py-3 bg-slate-900 text-white font-bold rounded-lg hover:bg-blue-600 transition">
                    Voir tous les véhicules
                </a>
            </div>
        @else
            <!-- GRILLE DES PROMOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($promotions as $promo)
                <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500 transform hover:-translate-y-2 flex flex-col h-full">

                    <!-- IMAGE (Avec Zoom au survol) -->
                    <div class="h-60 bg-gray-200 relative overflow-hidden">
                        @if($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-800">
                                <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                            </div>
                        @endif

                        <!-- Badge Réduction (Pulsant) -->
                        <div class="absolute top-4 right-4 z-10">
                            <div class="relative">
                                <div class="absolute inset-0 bg-red-500 rounded-lg blur opacity-50 animate-pulse"></div>
                                <div class="relative bg-red-600 text-white px-3 py-1.5 rounded-lg shadow-lg flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <span class="font-black text-lg">-{{ $promo->discount_percent }}%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Badge Véhicule (Si lié) -->
                        @if($promo->vehicle)
                            <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-md text-xs font-bold text-slate-800 uppercase tracking-wide shadow-sm">
                                {{ $promo->vehicle->brand }} {{ $promo->vehicle->name }}
                            </div>
                        @endif
                    </div>

                    <!-- CONTENU -->
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-slate-900 group-hover:text-blue-600 transition duration-300 line-clamp-1">
                                {{ $promo->title }}
                            </h3>
                            <p class="text-slate-500 text-sm mt-2 line-clamp-2 leading-relaxed">
                                {{ $promo->description }}
                            </p>
                        </div>

                        <!-- INFO DATES (Design Calendrier) -->
                        <div class="mt-auto">
                            <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100 mb-5 group-hover:border-blue-100 transition duration-300">
                                <div class="bg-white p-2 rounded-lg text-blue-600 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Validité</span>
                                    <span class="text-sm font-bold text-slate-700">
                                        Du {{ \Carbon\Carbon::parse($promo->start_date)->format('d/m') }}
                                        au <span class="text-blue-600">{{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- BOUTON D'ACTION (Large et Animé) -->
                            @if($promo->vehicle_id)
                                <a href="{{ route('vehicle.show', $promo->vehicle_id) }}" class="group/btn relative w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-slate-900 overflow-hidden shadow-lg transition-all hover:shadow-blue-500/30">
                                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-600 to-indigo-600 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                    <span class="relative flex items-center gap-2">
                                        Réserver ce véhicule
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                </a>
                            @else
                                <a href="{{ route('vehicles.index') }}" class="group/btn block w-full text-center py-3.5 px-4 rounded-xl text-sm font-bold text-slate-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                                    Voir tout le catalogue
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="mt-12">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
