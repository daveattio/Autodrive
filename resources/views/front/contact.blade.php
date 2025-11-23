<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact - AutoDrive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- Inclure ici ton menu de navigation plus tard -->
    @include('partials.navbar')

    <div class="container mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-10">Contactez-nous</h1>

        <div class="flex flex-col md:flex-row gap-8 bg-white rounded-xl shadow-lg overflow-hidden">

            <!-- Partie Gauche : Formulaire -->
            <div class="w-full md:w-1/2 p-8">
                <h2 class="text-2xl font-bold mb-6 text-blue-600">Envoyez-nous un message</h2>
                <form>
                    <!-- Partie Gauche : Le Composant Livewire -->
                    <div class="w-full md:w-1/2">
                        <livewire:front.contact-form />
                    </div>
                </form>
            </div>

            <!-- Partie Droite : Google Maps & Infos -->
            <div class="w-full md:w-1/2 bg-gray-50 relative">
                <!-- Google Maps Iframe -->
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63480.83912696765!2d1.2000000!3d6.1300000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023e1c113185419%3A0x3226b54fb73963f6!2sLom%C3%A9%2C%20Togo!5e0!3m2!1sfr!2sfr!4v1700000000000!5m2!1sfr!2sfr"
                    width="100%"
                    height="100%"
                    style="border:0; min-height: 400px;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

                <div class="absolute bottom-0 left-0 right-0 bg-white/90 backdrop-blur-sm p-4 m-4 rounded shadow">
                    <h3 class="font-bold text-gray-800">Agence Principale</h3>
                    <p class="text-sm text-gray-600">123 Avenue de la Libération, Lomé, Togo</p>
                    <p class="text-sm text-gray-600">Tél: +228 90 00 00 00</p>
                    <p class="text-sm text-gray-600">Email: contact@autodrive.tg</p>
                </div>
            </div>

        </div>
    </div>

</body>

</html>