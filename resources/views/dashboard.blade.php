<x-app-layout>

    <!-- GESTION DE LA MÉMOIRE DES ONGLETS -->
    <div class="bg-gray-50 min-h-screen"
        x-data="{ activeTab: localStorage.getItem('currentTab') || 'analytics' }"
        x-init="$watch('activeTab', val => localStorage.setItem('currentTab', val))"
        x-cloak>

        <!-- 1. NAVBAR ADMIN (Remplacement de la nav par défaut) -->
        <div class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">

                    <!-- Logo & Titre -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            <div class="bg-blue-600 text-white p-1.5 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span class="text-xl font-black text-gray-900 tracking-tight">Auto<span class="text-blue-600">Drive</span> <span class="text-gray-400 font-medium text-sm ml-1">Admin</span></span>
                        </a>
                    </div>

                    <!-- Actions Droite -->
                    <div class="flex items-center gap-4">
                        <a href="{{ url('/') }}" target="_blank" class="text-sm font-bold text-gray-500 hover:text-blue-600 flex items-center gap-1 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            Site Public
                        </a>

                        <div class="h-6 w-px bg-gray-200"></div>

                        <!-- Profil Admin -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden md:block">
                                <div class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-[10px] uppercase font-bold text-blue-600">{{ Auth::user()->role === 'super_admin' ? 'Super Admin' : 'Administrateur' }}</div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 p-2 rounded-full transition" title="Déconnexion">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. CONTENU PRINCIPAL -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- LOGIQUE DES COLONNES (Grille Dynamique) -->
            @php
                // Si Super Admin : 7 onglets. Si Admin : 5 onglets.
                $gridCols = Auth::user()->role === 'super_admin' ? 'md:grid-cols-7' : 'md:grid-cols-5';
            @endphp

            <!-- 3. LES ONGLETS (TABS) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-1.5 mb-8">
                <div class="grid grid-cols-2 {{ $gridCols }} gap-1">

                    <!-- VUE D'ENSEMBLE (Super Admin Only) -->
                    @if(Auth::user()->role === 'super_admin')
                    <button @click="activeTab = 'analytics'"
                        :class="activeTab === 'analytics' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Vue d'ensemble
                    </button>
                    @endif

                    <!-- RÉSERVATIONS -->
                    <button @click="activeTab = 'bookings'"
                        :class="activeTab === 'bookings' ? 'bg-blue-600 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Réservations
                        <!-- Le badge est intégré proprement -->
                        <div class="absolute top-2 right-2 md:relative md:top-0 md:right-0">
                            <livewire:admin.notification-badge />
                        </div>
                    </button>

                    <!-- VÉHICULES -->
                    <button @click="activeTab = 'vehicles'"
                        :class="activeTab === 'vehicles' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Véhicules
                    </button>

                    <!-- MAINTENANCE -->
                    <button @click="activeTab = 'maintenance'"
                        :class="activeTab === 'maintenance' ? 'bg-gray-900 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                        <!-- Icône Clé à molette -->
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Maintenance
                    </button>

                    <!-- PROMOTIONS -->
                    <button @click="activeTab = 'promos'"
                        :class="activeTab === 'promos' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                        Promotions
                    </button>

                    <!-- CLIENTS -->
                    <button @click="activeTab = 'clients'"
                        :class="activeTab === 'clients' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Clients
                        <!-- Le badge est intégré proprement -->
                        <div class="absolute top-2 right-2 md:relative md:top-0 md:right-0">
                            <livewire:admin.kyc-badge />
                        </div>
                    </button>

                    <!-- SÉCURITÉ (Super Admin) -->
                    @if(Auth::user()->role === 'super_admin')
                    <button @click="activeTab = 'security'"
                        :class="activeTab === 'security' ? 'bg-red-600 text-white shadow-md' : 'text-gray-600 hover:bg-gray-50'"
                        class="px-4 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Sécurité & Logs
                    </button>
                    @endif
                </div>
            </div>

            <!-- 4. CONTENU DYNAMIQUE -->
            <div>
                @if(Auth::user()->role === 'super_admin')
                    <div x-show="activeTab === 'analytics'" x-transition.opacity.duration.300ms>
                        <livewire:admin.analytics-dashboard />
                    </div>
                @endif

                <div x-show="activeTab === 'bookings'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-t-4 border-green-500">
                        <livewire:admin.booking-manager />
                    </div>
                </div>

                <div x-show="activeTab === 'vehicles'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-t-4 border-gray-500">
                        <livewire:admin.vehicle-manager />
                    </div>
                </div>

                <div x-show="activeTab === 'maintenance'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-orange-500">
                        <livewire:admin.maintenance-manager />
                    </div>
                </div>

                <div x-show="activeTab === 'promos'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-t-4 border-red-500">
                        <livewire:admin.promotion-manager />
                    </div>
                </div>

                <div x-show="activeTab === 'clients'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  border-t-4 border-blue-500">
                        <livewire:admin.client-manager />
                    </div>
                </div>

                @if(Auth::user()->role === 'super_admin')
                    <div x-show="activeTab === 'security'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <livewire:admin.security-dashboard />
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
