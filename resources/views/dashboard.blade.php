<x-app-layout>
    <!-- On supprime le header par défaut et on fait le nôtre -->

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- EN-TÊTE PERSONNALISÉ AVEC BOUTON RETOUR SITE -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord Admin</h1>

                <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2 bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Voir le site
                </a>
            </div>

            <!-- STATISTIQUES (Cartes) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Carte Véhicules -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 font-medium">Véhicules Total</div>
                    <div class="text-3xl font-bold text-gray-800">{{ \App\Models\Vehicle::count() }}</div>
                </div>
                <!-- Carte Clients -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 font-medium">Clients Inscrits</div>
                    <div class="text-3xl font-bold text-gray-800">{{ \App\Models\User::where('role', '!=', 'admin')->count() }}</div>
                </div>
                <!-- Carte Réservations -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 font-medium">Réservations</div>
                    <div class="text-3xl font-bold text-gray-800">{{ \App\Models\Booking::count() }}</div>
                </div>
            </div>

            <!-- LES COMPOSANTS DE GESTION -->
            <div class="space-y-8">
                 <!-- Bloc 1 : Gestion des réservations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-blue-500">
                <livewire:admin.booking-manager />
            </div>

            <!-- Bloc 2 : Gestion des véhicules -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-gray-800">
                <livewire:admin.vehicle-manager />
            </div>

            <!-- Bloc 3 : Gestion des clients -->
           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-red-800">
                <livewire:admin.client-manager />
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
