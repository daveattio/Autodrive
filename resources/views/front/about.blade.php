@extends('layouts.front')

@section('title', 'Qui sommes-nous ? - AutoDrive Togo')

@section('content')
<div class="bg-white">

    <!-- HERO SIMPLE -->
    <div class="bg-slate-50 py-20 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6">Plus qu'une location,<br>une <span class="text-blue-600">liberté</span> de mouvement.</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
                Depuis 2025, AutoDrive redéfinit les standards de la mobilité au Togo en alliant technologie, transparence et service client d'exception.
            </p>
        </div>
    </div>

    <!-- SECTION HISTOIRE (Image Droite) -->
    <div class="py-20 container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <span class="text-blue-600 font-bold uppercase tracking-widest text-xs mb-2 block">Notre Histoire</span>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Nés d'une volonté de simplifier.</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Tout a commencé par un constat simple : louer une voiture à Lomé était compliqué. Papiers administratifs lourds, tarifs flous, véhicules incertains...
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Nous avons créé <strong>AutoDrive</strong> pour changer la donne. Une plateforme numérique fluide, une flotte renouvelée tous les 24 mois et une transparence totale sur les prix. Aujourd'hui, nous accompagnons aussi bien les particuliers en vacances que les grandes entreprises.
                </p>
            </div>
            <div class="md:w-1/2">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?q=80&w=1000&auto=format&fit=crop" class="w-full object-cover h-[400px]">
                    <!-- Petit badge flottant -->
                    <div class="absolute bottom-6 left-6 bg-white p-4 rounded-xl shadow-lg">
                        <p class="text-4xl font-black text-blue-600">100%</p>
                        <p class="text-xs font-bold text-gray-500 uppercase">Togolais</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- NOS VALEURS (Icônes) -->
    <div class="bg-slate-900 py-20 text-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="text-center p-6 border border-slate-700 rounded-2xl hover:bg-slate-800 transition">
                    <div class="w-14 h-14 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Transparence Totale</h3>
                    <p class="text-slate-400">Ce que vous voyez est ce que vous payez. Pas de frais cachés au comptoir.</p>
                </div>
                <div class="text-center p-6 border border-slate-700 rounded-2xl hover:bg-slate-800 transition">
                    <div class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Sécurité Maximale</h3>
                    <p class="text-slate-400">Véhicules révisés avant chaque départ. Assistance 24/7 incluse dans tous les contrats.</p>
                </div>
                <div class="text-center p-6 border border-slate-700 rounded-2xl hover:bg-slate-800 transition">
                    <div class="w-14 h-14 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Service Humain</h3>
                    <p class="text-slate-400">Une équipe locale disponible pour vous conseiller les meilleurs itinéraires.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- L'ÉQUIPE (Humanisation) -->
    <div class="py-20 container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">L'équipe dirigeante</h2>
            <p class="text-gray-500 mt-2">Des passionnés à votre service.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <!-- Membre 1 -->
            <div class="text-center">
                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-lg">Joseph KOFFI</h4>
                <p class="text-blue-600 text-sm font-bold uppercase">Directeur Général</p>
            </div>
            <!-- Membre 2 -->
            <div class="text-center">
                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-lg">Sarah TOURE</h4>
                <p class="text-blue-600 text-sm font-bold uppercase">Resp. Flotte</p>
            </div>
            <!-- Membre 3 -->
            <div class="text-center">
                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-lg">David AKAKPO</h4>
                <p class="text-blue-600 text-sm font-bold uppercase">Service Client</p>
            </div>
        </div>
    </div>

</div>
@endsection
