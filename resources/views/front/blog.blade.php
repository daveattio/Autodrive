@extends('layouts.front')

@section('title', 'Conseils & Actualités Auto - AutoDrive Togo')
@section('meta_description', 'Découvrez nos guides sur la location de voiture à Lomé, les meilleures routes du Togo et nos astuces pour économiser sur votre location.')

@section('content')
<div class="bg-gray-50 pb-20">

    <!-- EN-TÊTE BLOG -->
    <div class="bg-slate-900 text-white py-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-[150px] opacity-20 translate-x-1/2 -translate-y-1/2"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <span class="text-blue-400 font-bold tracking-widest uppercase text-xs mb-3 block">Le Magazine AutoDrive</span>
            <h1 class="text-4xl md:text-6xl font-black mb-6">Conseils & <span class="text-blue-500">Actu</span></h1>
            <p class="text-slate-400 max-w-2xl mx-auto text-lg">Tout ce que vous devez savoir pour conduire au Togo en toute sérénité. Guides, astuces et découvertes.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-10 relative z-20">

        <!-- ARTICLE À LA UNE (Featured) -->
        <a href="{{ route('vehicles.index') }}" class="group block mb-12">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row h-auto md:h-[400px] border border-gray-100">
                <div class="md:w-3/5 relative overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1200&auto=format&fit=crop"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-in-out" alt="Roadtrip Togo">
                    <div class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">À la une</div>
                </div>
                <div class="md:w-2/5 p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center gap-2 text-xs text-gray-400 mb-4 font-bold uppercase tracking-wider">
                        <span>Guide Voyage</span>
                        <span>•</span>
                        <span>5 min de lecture</span>
                    </div>
                    <h2 class="text-3xl font-black text-gray-900 mb-4 group-hover:text-blue-600 transition">Les 5 plus belles routes à découvrir au Togo en 4x4</h2>
                    <p class="text-gray-600 mb-6 line-clamp-3">De Kpalimé à Kara, le Togo regorge de paysages époustouflants. Découvrez notre itinéraire conseillé pour un road-trip inoubliable avec nos SUV tout-terrain.</p>
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Auto+Drive&background=0D8ABC&color=fff" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Équipe AutoDrive</p>
                            <p class="text-xs text-gray-500">{{ now()->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- GRILLE D'ARTICLES -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Article 1 : SEO "Location Lomé" -->
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:-translate-y-2 transition duration-300 group">
                <div class="h-56 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-6">
                    <span class="text-blue-600 text-xs font-bold uppercase tracking-wider">Pratique</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-blue-600 transition">Location de voiture à Lomé : Les pièges à éviter</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-3">Assurances, état des lieux, caution... Voici notre checklist ultime pour louer un véhicule dans la capitale sans stress.</p>
                    <a href="{{ route('contact') }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 flex items-center gap-1">
                        Lire l'article <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </article>

            <!-- Article 2 : SEO "Voiture pas chère" -->
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:-translate-y-2 transition duration-300 group">
                <div class="h-56 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <span class="text-green-600 text-xs font-bold uppercase tracking-wider">Budget</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-blue-600 transition">Trouver une voiture pas chère : Nos conseils</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-3">Vous avez un budget serré ? Découvrez comment profiter de nos offres économiques et économiser sur le carburant.</p>
                    <a href="{{ route('promotions') }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 flex items-center gap-1">
                        Voir les promos <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </article>

            <!-- Article 3 : SEO "Utilitaire" -->
            <article class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:-translate-y-2 transition duration-300 group">
                <div class="h-56 overflow-hidden relative">
                    <img src="https://images.pexels.com/photos/33767582/pexels-photo-33767582.jpeg" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                <div class="p-6">
                    <span class="text-orange-600 text-xs font-bold uppercase tracking-wider">Entreprise</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-blue-600 transition">Location Utilitaire : La solution pour vos chantiers</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-3">Pour les professionnels et les déménagements, découvrez notre flotte de véhicules robustes et spacieux.</p>
                    <a href="{{ route('vehicles.index') }}" class="text-sm font-bold text-gray-900 hover:text-blue-600 flex items-center gap-1">
                        Voir la flotte <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </article>

        </div>
    </div>
</div>
@endsection
