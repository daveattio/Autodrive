<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>À Propos - AutoDrive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    @include('partials.navbar')

    <div class="bg-blue-600 py-20 text-center text-white">
        <h1 class="text-5xl font-bold mb-4">Qui sommes-nous ?</h1>
        <p class="text-xl">Leader de la location de véhicules depuis 2025.</p>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold mb-4 text-gray-800">Notre Mission</h2>
                <p class="text-gray-600 leading-relaxed mb-6">
                    AutoDrive est née d'une volonté simple : rendre la location de voiture accessible, transparente et rapide. Que vous ayez besoin d'une citadine économique pour vos déplacements urbains ou d'un 4x4 robuste pour explorer la région, nous avons le véhicule qu'il vous faut.
                </p>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    <li>Flotte de véhicules récents et entretenus.</li>
                    <li>Assistance 24h/24 et 7j/7.</li>
                    <li>Tarifs transparents sans frais cachés.</li>
                </ul>
            </div>
            <div class="bg-gray-300 h-64 rounded-lg flex items-center justify-center text-gray-500">
                <!-- Tu pourras mettre une photo de l'équipe ou des bureaux ici -->
                [Photo Agence / Équipe]
            </div>
        </div>
    </div>

</body>
</html>