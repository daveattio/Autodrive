@extends('layouts.front')

@section('title', 'Notre Histoire & Nos Engagements - AutoDrive Togo')

@section('content')
<div class="bg-white">
    
    <!-- 1. HERO : BUSINESS & VISION -->
    <div class="relative py-24 bg-slate-50">
        <div class="container mx-auto px-4 text-center relative z-10">
            <span class="text-blue-600 font-bold tracking-widest uppercase text-xs mb-3 block">Depuis 2025</span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6 leading-tight">
                Redéfinir la mobilité <br> au <span class="text-blue-600">Togo</span>.
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto leading-relaxed">
                AutoDrive n'est pas une simple agence. C'est la réponse à un besoin de fiabilité, de transparence et de confort pour les professionnels et les voyageurs.
            </p>
        </div>
    </div>

    <!-- 2. L'HISTOIRE (STORYTELLING) -->
    <div class="py-20 container mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-16 items-start">
            
            <!-- Image d'illustration (Flotte/Agence) -->
            <div class="md:w-1/2 relative group">
                <div class="absolute inset-0 bg-blue-600 rounded-3xl transform translate-x-3 translate-y-3 group-hover:translate-x-2 group-hover:translate-y-2 transition"></div>
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1000&auto=format&fit=crop" 
                     class="relative rounded-3xl shadow-lg border-2 border-white w-full h-[500px] object-cover" 
                     alt="Flotte AutoDrive">
            </div>

            <!-- Texte -->
            <div class="md:w-1/2 pt-4">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Tout a commencé par un constat.</h2>
                
                <div class="prose text-gray-600 leading-relaxed mb-8 space-y-4">
                    <p>
                        Louer un véhicule à Lomé a longtemps été un parcours du combattant : disponibilité incertaine, état des véhicules variable, et surtout, une opacité sur les tarifs et les assurances.
                    </p>
                    <p>
                        <strong>AutoDrive a été fondée avec une mission claire :</strong> apporter les standards internationaux de la location au marché local. Nous avons commencé avec 5 véhicules et une obsession pour le service client. Aujourd'hui, nous gérons une flotte diversifiée, allant de la citadine économique au 4x4 de luxe.
                    </p>
                    <p>
                        Notre force ? Une transparence totale. Le prix affiché est le prix payé. Les contrats sont clairs, et l'assistance est disponible 24h/24.
                    </p>
                </div>

                <div class="flex items-center gap-6">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-600 transition shadow-lg">
                        <span>Discuter de votre projet</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('vehicles.index') }}" class="text-gray-600 font-bold hover:text-blue-600 underline">Voir notre flotte</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TEMOIGNAGES CLIENTS (PREUVE SOCIALE) -->
    <div class="py-20 bg-slate-50 border-y border-gray-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Ils nous font confiance</h2>
                <p class="text-gray-500 mt-2">Découvrez les retours de nos clients particuliers et entreprises.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Avis 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative">
                    <div class="text-yellow-400 flex gap-1 mb-4">
                        @for($i=0; $i<5; $i++) <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <p class="text-gray-600 mb-6 italic">"Un service impeccable pour mes déplacements professionnels. La facture est claire, les voitures sont propres. Je recommande pour les entreprises."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">JD</div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Jean Dupont</p>
                            <p class="text-xs text-gray-500">Directeur Commercial</p>
                        </div>
                    </div>
                </div>

                <!-- Avis 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative">
                    <div class="text-yellow-400 flex gap-1 mb-4">
                        @for($i=0; $i<5; $i++) <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <p class="text-gray-600 mb-6 italic">"Nous avons loué un 4x4 pour visiter Kpalimé. La voiture était en parfait état et le personnel nous a donné de super conseils sur la route."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold">AK</div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Afi Koumé</p>
                            <p class="text-xs text-gray-500">Touriste</p>
                        </div>
                    </div>
                </div>

                <!-- Avis 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative">
                    <div class="text-yellow-400 flex gap-1 mb-4">
                        @for($i=0; $i<5; $i++) <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                    </div>
                    <p class="text-gray-600 mb-6 italic">"Enfin une agence sérieuse à Lomé. La réservation en ligne fonctionne vraiment et le prix n'a pas changé une fois sur place. Bravo."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold">MK</div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Michel Koffi</p>
                            <p class="text-xs text-gray-500">Résident</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. L'EXPERTISE TECHNIQUE (Badges discrets en bas) -->
    <div class="bg-slate-900 py-16 text-white overflow-hidden">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center gap-12">
            
            <div class="md:w-2/3">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-blue-600/20 rounded-lg text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold">Une sécurité aux normes mondiales</h3>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xl">
                    Chez AutoDrive, votre sécurité ne s'arrête pas au véhicule. Nous sommes la seule agence locale intégrant une expertise certifiée en <strong>Cybersécurité</strong> et <strong>Analyse de Données</strong>.
                </p>
                <p class="text-slate-400 text-sm leading-relaxed mt-4 max-w-xl">
                    Vos données personnelles (Passeport, Permis, Paiement) sont protégées par des protocoles stricts validés par les standards de l'industrie (Google Cybersecurity Certificate). De plus, notre gestion de flotte pilotée par la donnée nous permet de vous garantir une disponibilité optimale.
                </p>
            </div>

            <!-- Badges Credly (Intégration compacte) -->
            <div class="md:w-1/3 flex justify-center md:justify-end gap-6">
                <!-- Badge Cybersécurité -->
                <div class="transform scale-90 hover:scale-100 transition duration-300 opacity-90 hover:opacity-100">
                    <div data-iframe-width="150" data-iframe-height="270" data-share-badge-id="57c2278b-5c5d-46d3-a4a0-64d9ebc57d23" data-share-badge-host="https://www.credly.com"></div>
                </div>
                <!-- Badge Data Analysis -->
                <div class="transform scale-90 hover:scale-100 transition duration-300 opacity-90 hover:opacity-100">
                    <div data-iframe-width="150" data-iframe-height="270" data-share-badge-id="55580535-7a9c-4f27-bc3d-71465e53f1b5" data-share-badge-host="https://www.credly.com"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT BADGES (À charger une seule fois) -->
    <script type="text/javascript" async src="//cdn.credly.com/assets/utilities/embed.js"></script>

</div>
@endsection