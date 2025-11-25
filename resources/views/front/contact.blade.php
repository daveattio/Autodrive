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
            <div class="w-full md:w-1/2 bg-gray-200 relative min-h-[400px]">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63480.83912696765!2d1.2000000!3d6.1300000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023e1c113185419%3A0x3226b54fb73963f6!2sLom%C3%A9%2C%20Togo!5e0!3m2!1sfr!2sfr!4v1700000000000!5m2!1sfr!2sfr"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    class="absolute inset-0 w-full h-full object-cover">
                </iframe>

                <!-- Petite bulle info sur la carte -->
                <div class="absolute bottom-6 left-6 bg-white p-4 rounded-xl shadow-lg max-w-xs">
                    <p class="font-bold text-gray-800">Agence Principale</p>
                    <p class="text-sm text-gray-600">Lomé, Togo</p>
                    <p class="text-xs text-blue-600 mt-1 font-bold">+228 90 00 00 00</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer simple -->
    <footer class="bg-gray-900 text-white text-center py-6">
        &copy; {{ date('Y') }} AutoDrive. Tous droits réservés.
    </footer>

</body>
</html>
