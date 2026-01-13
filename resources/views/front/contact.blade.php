<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact - AutoDrive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="bg-gray-100 font-sans antialiased">

    @include('partials.navbar')
    

    <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
        <!-- CONTENEUR UNIQUE (Pas de creux) -->
        <div class="bg-white w-full max-w-6xl rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

            <!-- GAUCHE : LE FORMULAIRE LIVEWIRE -->
            <div class="w-full md:w-1/2 p-8 md:p-12">
                <div class="mb-6">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Contactez-nous</h1>
                    <p class="text-gray-500">Une question ? Un projet ? Remplissez ce formulaire et nous vous répondrons sous 24h.</p>
                </div>

                <!-- Appel du composant Livewire -->
                <livewire:front.contact-form />
            </div>

            <!-- DROITE : LA CARTE (Prend toute la hauteur) -->
            <!-- Carte avec Marqueur Précis -->
            <div class="w-full md:w-1/2 bg-gray-200 relative min-h-[400px]">
                <iframe
                    width="100%"
                    height="100%"
                    style="border:0;"
                    loading="lazy"
                    allowfullscreen
                    class="absolute inset-0 w-full h-full object-cover grayscale hover:grayscale-0 transition duration-700"
                    src="https://maps.google.com/maps?q=6.133652,1.223129&hl=fr&z=15&output=embed">
                </iframe>

                <!-- La petite bulle d'info reste la même -->
                <div class="absolute bottom-6 left-6 bg-white p-4 rounded-xl shadow-lg max-w-xs z-10 border border-gray-100">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="bg-blue-600 p-2 rounded-full text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 leading-none">AutoDrive Agency</p>
                            <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider mt-1">Siège Social</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 pl-11">123 Avenue de la Libération,<br>Lomé, Togo</p>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
