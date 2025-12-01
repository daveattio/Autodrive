<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-screen" x-data="{ activeTab: 'analytics' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- EN-TÊTE -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <h1 class="text-3xl font-black text-gray-800 tracking-tight">
                    Administration <span class="text-blue-600">AutoDrive</span>
                </h1>

                <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 hover:text-blue-600 text-sm font-bold rounded-lg shadow-sm border border-gray-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Voir le site public
                </a>
            </div>

            <!-- BARRE DE NAVIGATION (TABS PLEINE LARGEUR) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-1.5 mb-8 sticky top-4 z-30">

                <!-- On utilise GRID pour diviser l'espace en 5 parts égales -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-1">

                    <!-- 1. VUE D'ENSEMBLE -->
                    <button @click="activeTab = 'analytics'"
                        :class="activeTab === 'analytics' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Vue d'ensemble
                    </button>

                    <!-- 2. RÉSERVATIONS -->
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

                    <!-- 3. VÉHICULES -->
                    <button @click="activeTab = 'vehicles'"
                        :class="activeTab === 'vehicles' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Véhicules
                    </button>

                    <!-- 4. PROMOTIONS -->
                    <button @click="activeTab = 'promos'"
                        :class="activeTab === 'promos' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                        Promotions
                    </button>

                    <!-- 5. CLIENTS -->
                    <button @click="activeTab = 'clients'"
                        :class="activeTab === 'clients' ? 'bg-gray-900 text-white shadow' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'"
                        class="px-4 py-3 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 w-full">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Clients
                    </button>
                </div>
            </div>

            <!-- CONTENU DYNAMIQUE (Un seul affiché à la fois) -->
            <div>
                <div x-show="activeTab === 'analytics'" x-transition.opacity.duration.300ms>
                    <livewire:admin.analytics-dashboard />
                </div>

                <div x-show="activeTab === 'bookings'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <livewire:admin.booking-manager />
                    </div>
                </div>

                <div x-show="activeTab === 'vehicles'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <livewire:admin.vehicle-manager />
                    </div>
                </div>

                <div x-show="activeTab === 'promos'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <livewire:admin.promotion-manager />
                    </div>
                </div>

                <div x-show="activeTab === 'clients'" x-cloak x-transition.opacity.duration.300ms>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <livewire:admin.client-manager />
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
