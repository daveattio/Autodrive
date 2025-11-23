<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Nos Véhicules - AutoDrive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    @include('partials.navbar')
    
    <!-- On appelle le catalogue filtrable qu'on vient de faire -->
    <livewire:front.vehicle-catalog />
</body>
</html>