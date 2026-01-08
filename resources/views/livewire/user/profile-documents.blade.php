<div class="bg-gray-50 min-h-screen py-10">

    <!-- 1. THÈME DYNAMIQUE -->
    @php
        $theme = match($client_type) {
            'entreprise' => 'indigo',
            'touriste'   => 'teal',
            default      => 'blue',
        };

        // Icônes Principales du Profil
        $profileIcon = match($client_type) {
            'entreprise' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
            'touriste'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
            default      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />',
        };

        // Vérification si le dossier est complet (Pour cacher le bouton Flash)
        $isComplete = $user->license_path;
        if($client_type == 'touriste' && !$user->passport_path) $isComplete = false;
        if($client_type == 'entreprise' && !$user->company_doc_path) $isComplete = false;
    @endphp

    <div class="container mx-auto px-4 max-w-7xl">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white border border-gray-200 rounded-xl shadow-sm text-{{ $theme }}-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $profileIcon !!}</svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Espace {{ ucfirst($client_type) }}</h1>
                    <p class="text-slate-500 text-sm">Gestion de vos informations et justificatifs.</p>
                </div>
            </div>

            <a href="{{ route('user.bookings') }}" class="group flex items-center gap-2 bg-white px-5 py-2.5 rounded-xl border border-gray-200 text-slate-600 font-bold hover:border-{{ $theme }}-500 hover:text-{{ $theme }}-600 transition shadow-sm">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour Réservations
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- COLONNE GAUCHE : INFOS TEXTES (2/3) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-{{ $theme }}-500"></div>

                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                Données Personnelles
                            </h3>
                            @if (session()->has('info_success'))
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 animate-pulse">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Enregistré
                                </span>
                            @endif
                        </div>

                        <form wire:submit.prevent="updateInfo" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nom Complet</label>
                                    <input type="text" wire:model="name" class="w-full border-gray-200 rounded-lg focus:ring-{{ $theme }}-500 font-bold text-slate-700 bg-gray-50 focus:bg-white transition">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                    <input type="email" wire:model="email" class="w-full border-gray-200 rounded-lg focus:ring-{{ $theme }}-500 font-bold text-slate-700 bg-gray-50 focus:bg-white transition">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Téléphone</label>
                                    <input type="text" wire:model="phone" class="w-full border-gray-200 rounded-lg focus:ring-{{ $theme }}-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ville</label>
                                    <input type="text" wire:model="city" class="w-full border-gray-200 rounded-lg focus:ring-{{ $theme }}-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Adresse</label>
                                <input type="text" wire:model="address" class="w-full border-gray-200 rounded-lg focus:ring-{{ $theme }}-500">
                            </div>

                            <!-- Champs Spécifiques (Numéros) -->
                            <div class="bg-{{ $theme }}-50/50 p-5 rounded-xl border border-{{ $theme }}-100 mt-2">
                                @if($client_type == 'particulier' || $client_type == 'touriste')
                                    <div>
                                        <label class="block text-[10px] font-bold text-{{ $theme }}-600 uppercase mb-1">N° Permis</label>
                                        <input type="text" wire:model="license_number" class="w-full border-{{ $theme }}-200 rounded-lg focus:ring-{{ $theme }}-500">
                                    </div>
                                @endif

                                @if($client_type == 'entreprise')
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-{{ $theme }}-600 uppercase mb-1">Société</label>
                                            <input type="text" wire:model="company_name" class="w-full border-{{ $theme }}-200 rounded-lg">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-{{ $theme }}-600 uppercase mb-1">NIF / RCCM</label>
                                            <input type="text" wire:model="company_id" class="w-full border-{{ $theme }}-200 rounded-lg">
                                        </div>
                                    </div>
                                @endif

                                @if($client_type == 'touriste')
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-{{ $theme }}-600 uppercase mb-1">Passeport</label>
                                            <input type="text" wire:model="passport_number" class="w-full border-{{ $theme }}-200 rounded-lg">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-{{ $theme }}-600 uppercase mb-1">Pays</label>
                                            <input type="text" wire:model="origin_country" class="w-full border-{{ $theme }}-200 rounded-lg">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="text-right">
                                <button type="submit" class="text-{{ $theme }}-600 font-bold text-sm hover:underline">Sauvegarder les infos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE : DOCUMENTS (Le Hub) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden sticky top-24">

                    <div class="bg-slate-900 p-5 text-white text-center">
                        <h3 class="font-bold uppercase tracking-widest text-xs">Justificatifs</h3>
                        <p class="text-slate-400 text-[10px] mt-1">Formats : PDF, JPG, PNG</p>
                    </div>

                    <div class="p-6">
                        <form wire:submit.prevent="saveDocuments" class="space-y-5">

                            <!-- 1. PERMIS DE CONDUIRE (Carte d'identité visuelle) -->
                            <div class="flex items-center gap-3 p-3 border {{ $user->license_path ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white' }} rounded-xl transition hover:shadow-md">
                                <!-- Icône -->
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $user->license_path ? 'bg-green-200 text-green-700' : 'bg-slate-100 text-slate-400' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <!-- Input & Lien -->
                                <div class="flex-grow overflow-hidden">
                                    <p class="text-xs font-bold text-slate-700 mb-1">Permis de Conduire</p>
                                    <label class="cursor-pointer">
                                        <span class="text-[10px] text-blue-600 font-bold hover:underline truncate block">
                                            {{ $license_file ? $license_file->getClientOriginalName() : ($user->license_path ? 'Modifier le fichier' : 'Choisir un fichier') }}
                                        </span>
                                        <input type="file" wire:model="license_file" class="hidden">
                                    </label>
                                </div>
                                <!-- Bouton Voir -->
                                @if($user->license_path)
                                    <a href="{{ asset('storage/'.$user->license_path) }}" target="_blank" class="text-slate-400 hover:text-blue-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                @endif
                            </div>

                            <!-- 2. PASSEPORT (Touriste) -->
                            @if($client_type == 'touriste')
                                <div class="flex items-center gap-3 p-3 border {{ $user->passport_path ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white' }} rounded-xl transition hover:shadow-md">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $user->passport_path ? 'bg-green-200 text-green-700' : 'bg-slate-100 text-slate-400' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex-grow overflow-hidden">
                                        <p class="text-xs font-bold text-slate-700 mb-1">Passeport</p>
                                        <label class="cursor-pointer">
                                            <span class="text-[10px] text-blue-600 font-bold hover:underline truncate block">
                                                {{ $passport_file ? $passport_file->getClientOriginalName() : ($user->passport_path ? 'Modifier le fichier' : 'Choisir un fichier') }}
                                            </span>
                                            <input type="file" wire:model="passport_file" class="hidden">
                                        </label>
                                    </div>
                                    @if($user->passport_path)
                                        <a href="{{ asset('storage/'.$user->passport_path) }}" target="_blank" class="text-slate-400 hover:text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                    @endif
                                </div>
                            @endif

                            <!-- 3. DOC ENTREPRISE -->
                            @if($client_type == 'entreprise')
                                <div class="flex items-center gap-3 p-3 border {{ $user->company_doc_path ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white' }} rounded-xl transition hover:shadow-md">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $user->company_doc_path ? 'bg-green-200 text-green-700' : 'bg-slate-100 text-slate-400' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div class="flex-grow overflow-hidden">
                                        <p class="text-xs font-bold text-slate-700 mb-1">Document RCCM/NIF</p>
                                        <label class="cursor-pointer">
                                            <span class="text-[10px] text-blue-600 font-bold hover:underline truncate block">
                                                {{ $company_doc_file ? $company_doc_file->getClientOriginalName() : ($user->company_doc_path ? 'Modifier le fichier' : 'Choisir un fichier') }}
                                            </span>
                                            <input type="file" wire:model="company_doc_file" class="hidden">
                                        </label>
                                    </div>
                                    @if($user->company_doc_path)
                                        <a href="{{ asset('storage/'.$user->company_doc_path) }}" target="_blank" class="text-slate-400 hover:text-blue-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></a>
                                    @endif
                                </div>
                            @endif

                            <!-- LOGIQUE DU BOUTON FLASH -->
                            <div class="pt-4 border-t border-gray-100">
                                @if($isComplete)
                                    <!-- DOSSIER COMPLET = BOUTON DISCRET (Mise à jour) -->
                                    <button type="submit" class="w-full bg-white border border-slate-300 text-slate-600 font-bold py-3 rounded-xl hover:bg-slate-50 transition text-sm">
                                        Mettre à jour les fichiers
                                    </button>
                                    <p class="text-center text-[10px] text-green-600 font-bold mt-2 flex items-center justify-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Dossier valide
                                    </p>
                                @else
                                    <!-- DOSSIER INCOMPLET = LOGO FLASH (Appel à l'action) -->
                                    <button type="submit" class="w-full bg-[#DC2626] text-white px-5 py-4 rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] flex items-center justify-center gap-2 transform -skew-x-3 hover:skew-x-0 hover:scale-[1.02] transition-all duration-300">
                                        <!-- Icône Éclair -->
                                        <svg class="w-5 h-5 text-yellow-300 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                                        <span class="text-lg font-black italic tracking-tighter">ENVOYER & VALIDER</span>
                                    </button>

                                    <div wire:loading class="text-center text-xs text-slate-400 mt-2">
                                        Chargement du fichier en cours...
                                    </div>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
