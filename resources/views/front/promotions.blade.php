@extends('layouts.front')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 max-w-7xl">

        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Offres & Promotions</h1>
            <p class="text-gray-500 text-lg">Profitez de nos réductions exclusives sur une sélection de véhicules.</p>
        </div>

        @if($promotions->isEmpty())
            <div class="text-center py-20">
                <div class="inline-block p-6 rounded-full bg-blue-50 mb-4">
                    <svg class="h-16 w-16 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Aucune promotion en cours</h3>
                <p class="text-gray-500 mt-2">Revenez plus tard !</p>
            </div>
        @else
            <!-- Grille identique au Catalogue -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($promotions as $promo)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full group">

                    <!-- Image (Même dimension h-52 que les véhicules) -->
                    <div class="h-52 bg-gray-100 w-full relative overflow-hidden">
                        @if($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white">
                                <svg class="w-16 h-16 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                            </div>
                        @endif

                        <!-- Badge Réduction -->
                        <div class="absolute top-3 right-3 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-black shadow-md">
                            -{{ $promo->discount_percent }}%
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Offre Spéciale</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $promo->title }}</h3>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 flex-grow">
                            {{ $promo->description }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <!-- Affichage de la plage de dates -->
                            <div class="flex items-center gap-2 mb-4 text-xs text-gray-500 bg-gray-50 p-2 rounded">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Du <strong>{{ \Carbon\Carbon::parse($promo->start_date)->format('d/m') }}</strong> au <strong>{{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}</strong></span>
                            </div>

                            <a href="{{ route('vehicles.index') }}" class="block text-center w-full bg-gray-900 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-blue-600 transition shadow-md">
                                Voir les véhicules
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
