@extends('layouts.front')

@section('title', 'Notre Expertise - AutoDrive Togo')

@section('content')
<div class="bg-white">

    <!-- 1. HERO : Vision -->
    <div class="relative bg-slate-50 py-24 overflow-hidden">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-100 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-black text-slate-900 mb-6 leading-tight">
                L'Excellence <span class="text-blue-600">Technologique</span> <br>au service de votre Mobilité.
            </h1>
            <p class="text-xl text-gray-500 max-w-3xl mx-auto">
                AutoDrive redéfinit la location de voiture au Togo. Nous ne sommes pas seulement une agence, nous sommes une plateforme sécurisée, pilotée par la donnée.
            </p>
        </div>
    </div>

    <!-- 2. HISTOIRE & MISSION -->
    <div class="py-20 container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-16">
            <div class="md:w-1/2 relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-600/10 rounded-full z-0"></div>
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=1000&auto=format&fit=crop" class="relative z-10 rounded-[2rem] shadow-2xl w-full object-cover h-[500px] hover:scale-[1.02] transition duration-500">
                <!-- Stats flottantes -->
                <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-2xl shadow-xl z-20 border border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 p-3 rounded-full text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-slate-900">100%</p>
                            <p class="text-xs text-gray-500 font-bold uppercase">Fiabilité</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold text-slate-900 mb-6">Pourquoi nous sommes différents ?</h2>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Rapidité & Efficacité</h4>
                            <p class="text-gray-500 leading-relaxed">Grâce à notre gestion optimisée par l'analyse de données, nos véhicules sont toujours prêts, là où vous en avez besoin.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg text-slate-800">Sécurité des Données</h4>
                            <p class="text-gray-500 leading-relaxed">Vos informations (Passeport, Permis) sont chiffrées et protégées selon les standards internationaux de cybersécurité.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SECTION CERTIFICATIONS (LE COEUR DU SUJET) -->
    <div class="bg-slate-900 py-24 text-white relative overflow-hidden">
        <!-- Grille de fond tech -->
        <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(#3b82f6 1px, transparent 1px), linear-gradient(to right, #3b82f6 1px, transparent 1px); background-size: 40px 40px;"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <span class="bg-blue-900/50 text-blue-300 border border-blue-500/30 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest">Certifications Google</span>
                <h2 class="text-4xl font-black mt-6 mb-4">Une expertise reconnue mondialement</h2>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg">
                    Votre sécurité n'est pas une option. Notre plateforme est administrée par un expert certifié Google Professional.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 max-w-5xl mx-auto">

                <!-- Badge CYBERSECURITY -->
                <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-8 flex flex-col items-center text-center hover:bg-white/10 transition duration-500 group">
                    <div class="mb-6 transform group-hover:scale-105 transition">
                        <!-- CODE EMBED CREDLY -->
                        <div data-iframe-width="150" data-iframe-height="270" data-share-badge-id="57c2278b-5c5d-46d3-a4a0-64d9ebc57d23" data-share-badge-host="https://www.credly.com"></div>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Google Cybersecurity</h3>
                    <p class="text-slate-400 text-sm mb-6">Garantit que notre infrastructure protège vos données personnelles contre les menaces modernes.</p>
                    <a href="https://www.credly.com/badges/57c2278b-5c5d-46d3-a4a0-64d9ebc57d23/public_url" target="_blank" class="inline-flex items-center gap-2 text-blue-400 font-bold hover:text-blue-300 transition">
                        Vérifier l'accréditation <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>

                <!-- Badge DATA ANALYTICS -->
                <div class="bg-white/5 backdrop-blur-lg border border-white/10 rounded-3xl p-8 flex flex-col items-center text-center hover:bg-white/10 transition duration-500 group">
                    <div class="mb-6 transform group-hover:scale-105 transition">
                        <!-- CODE EMBED CREDLY -->
                        <div data-iframe-width="150" data-iframe-height="270" data-share-badge-id="55580535-7a9c-4f27-bc3d-71465e53f1b5" data-share-badge-host="https://www.credly.com"></div>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Google Data Analytics</h3>
                    <p class="text-slate-400 text-sm mb-6">Nous analysons les tendances pour vous offrir les meilleurs prix et une disponibilité optimale des véhicules.</p>
                    <a href="https://www.credly.com/badges/55580535-7a9c-4f27-bc3d-71465e53f1b5/public_url" target="_blank" class="inline-flex items-center gap-2 text-green-400 font-bold hover:text-green-300 transition">
                        Vérifier l'accréditation <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>

            </div>

            <!-- Script JS Credly (Nécessaire pour afficher les badges) -->
            <script type="text/javascript" async src="//cdn.credly.com/assets/utilities/embed.js"></script>
        </div>
    </div>

    <!-- 4. ÉQUIPE -->
    <div class="py-24 container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-slate-900 mb-12">L'équipe dirigeante</h2>
        <div class="flex flex-wrap justify-center gap-10">
             <!-- Membre Principal -->
             <div class="group">
                <div class="w-40 h-40 mx-auto rounded-full overflow-hidden border-4 border-white shadow-xl mb-4 group-hover:scale-110 transition duration-300 relative">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <h4 class="font-black text-xl text-slate-800">David ATTIOGBE</h4>
                <p class="text-blue-600 text-xs font-bold uppercase tracking-widest mt-1">Fondateur & Expert Sécurité</p>
            </div>
            <!-- Tu peux ajouter d'autres membres ici -->
        </div>
    </div>

</div>
@endsection
