<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tableau de Bord Administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Bloc 1 : Gestion des réservations (Le nouveau) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:admin.booking-manager />
            </div>

            <!-- Bloc 2 : Gestion des véhicules (L'ancien) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <livewire:admin.vehicle-manager />
            </div>

        </div>
    </div>
</x-app-layout>