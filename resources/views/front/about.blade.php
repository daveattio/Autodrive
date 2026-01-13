@extends('layouts.front')

@section('title', 'Notre Vision & Engagements - AutoDrive')

@section('content')
<div class="bg-white">

    <!-- 1. INTRO : LA VISION -->
    <div class="relative bg-slate-900 py-24 overflow-hidden">
        <!-- Fond abstrait -->
        <div class="absolute inset-0 opacity-20">
            <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=1920&auto=format&fit=crop" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-transparent"></div>

        <div class="container mx-auto px-4 relative z-10 flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-3/5">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-900/50 border border-blue-500/30 text-blue-300 text-xs font-bold uppercase tracking-widest mb-6">
                    Qui sommes-nous ?
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight">
                    Plus qu'une location, <br> votre partenaire de <span class="text-blue-500">mobilité</span>.
                </h1>
                <p class="text-lg text-slate-400 leading-relaxed max-w-xl">
                    AutoDrive est née d'une ambition : transformer la location de voiture au Togo en une expérience fluide, numérique et totalement transparente. Fini les surprises, place à la sérénité.
                </p>
            </div>
        </div>
    </div>

    <!-- 2. L'HISTOIRE (Timeline simplifiée) -->
    <div class="py-20 container mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-16 items-center">
            <div class="md:w-1/2 relative">
                <div class="absolute -inset-4 bg-blue-100 rounded-3xl transform -rotate-2"></div>
                <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=1000&auto=format&fit=crop" class="relative rounded-3xl shadow-2xl w-full h-[400px] object-cover border-4 border-white">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-slate-900 mb-6">De l'idée à la référence locale.</h2>
                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold border border-blue-100">01</div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Le Constat</h4>
                            <p class="text-slate-600 text-sm mt-1">Louer une voiture fiable à Lomé était complexe. Tarifs flous, état incertain, paperasse lourde.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold border border-blue-100">02</div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">La Solution Digitale</h4>
                            <p class="text-slate-600 text-sm mt-1">Nous avons développé une plateforme unique intégrant la réservation temps réel, le paiement sécurisé et la gestion de contrat numérique.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold border border-blue-100">03</div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Aujourd'hui</h4>
                            <p class="text-slate-600 text-sm mt-1">AutoDrive accompagne des centaines de clients : entreprises, expatriés et touristes, avec une flotte premium et sécurisée.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. LA VOIX DES CLIENTS (Segmentée) -->
    <div class="bg-slate-50 py-20 border-y border-slate-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-900">Ils nous font confiance</h2>
                <p class="text-slate-500 mt-2">La satisfaction client est notre seule boussole.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Particulier -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative group hover:-translate-y-1 transition duration-300">
                    <span class="absolute top-4 right-4 bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-1 rounded uppercase">Particulier</span>
                    <div class="text-yellow-400 flex gap-1 mb-4 text-sm">★★★★★</div>
                    <p class="text-slate-600 text-sm mb-6 italic">"J'avais besoin d'une voiture pour un mariage à Kpalimé. Service impeccable, voiture propre et surtout, pas de frais cachés au retour."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-500">JD</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Jean David</p>
                            <p class="text-xs text-slate-400">Lomé</p>
                        </div>
                    </div>
                </div>

                <!-- Entreprise -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative group hover:-translate-y-1 transition duration-300">
                    <span class="absolute top-4 right-4 bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-1 rounded uppercase">Entreprise</span>
                    <div class="text-yellow-400 flex gap-1 mb-4 text-sm">★★★★★</div>
                    <p class="text-slate-600 text-sm mb-6 italic">"La facturation automatique et la gestion de flotte simplifient la vie de notre département logistique. Un partenaire B2B solide."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-500">ST</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Sarah Tech</p>
                            <p class="text-xs text-slate-400">Directrice Ops</p>
                        </div>
                    </div>
                </div>

                <!-- Touriste -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative group hover:-translate-y-1 transition duration-300">
                    <span class="absolute top-4 right-4 bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-1 rounded uppercase">Touriste</span>
                    <div class="text-yellow-400 flex gap-1 mb-4 text-sm">★★★★★</div>
                    <p class="text-slate-600 text-sm mb-6 italic">"Arrivé de Paris, j'avais peur des arnaques. Avec AutoDrive, tout était prêt à l'aéroport. Le paiement par carte est un vrai plus."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-500">ML</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Marc Leblanc</p>
                            <p class="text-xs text-slate-400">France</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 4. EXPERTISE & CERTIFICATIONS (Fond Blanc pour contraste avec le footer) -->
    <div class="bg-white py-20 border-t border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-16">
                
                <!-- Texte -->
                <div class="md:w-1/2">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h2 class="text-3xl font-black text-slate-900">Expertise Certifiée Google</h2>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Votre sécurité numérique est aussi importante que votre sécurité routière. AutoDrive intègre les meilleures pratiques mondiales en matière de protection des données et d'analyse.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <span class="px-4 py-2 rounded-lg bg-gray-100 text-slate-600 font-bold text-xs uppercase tracking-wider border border-gray-200">
                            Cybersecurity Professional
                        </span>
                        <span class="px-4 py-2 rounded-lg bg-gray-100 text-slate-600 font-bold text-xs uppercase tracking-wider border border-gray-200">
                            Data Analytics Professional
                        </span>
                    </div>
                </div>

                <!-- BADGES CREDLY (Codes officiels) -->
                <div class="md:w-1/2 flex flex-col sm:flex-row justify-center items-center gap-8">
                    
                    <!-- Badge 1 : Cybersecurity -->
                    <div class="bg-white p-4 rounded-2xl shadow-xl border border-gray-100 hover:scale-105 transition duration-300 flex justify-center">
                        <div data-iframe-width="150" data-iframe-height="270" data-share-badge-id="57c2278b-5c5d-46d3-a4a0-64d9ebc57d23" data-share-badge-host="https://www.credly.com"></div>
                    </div>

                    <!-- Badge 2 : Data Analysis -->
                    <div class="bg-white p-4 rounded-2xl shadow-xl border border-gray-100 hover:scale-105 transition duration-300 flex justify-center">
                        <div data-iframe-width="150" data-iframe-height="270" data-share-badge-id="55580535-7a9c-4f27-bc3d-71465e53f1b5" data-share-badge-host="https://www.credly.com"></div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    
    <!-- Script Credly (Obligatoire pour que les badges s'affichent) -->
    <script type="text/javascript" async src="//cdn.credly.com/assets/utilities/embed.js"></script>

                        </div>
@endsection
