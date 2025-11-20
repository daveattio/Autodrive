<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AutoDrive - Location de voitures</title>
        
        <!-- On charge Tailwind via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 antialiased">
        
        @include('partials.navbar')

        <!-- NOTRE CATALOGUE LIVEWIRE EST ICI -->
        <livewire:front.vehicle-catalog />

    </body>
</html>