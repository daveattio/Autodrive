<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Front\VehicleDetails;
use App\Livewire\Front\UserBookings;
use App\Http\Middleware\IsAdmin; // Important pour la sécurité

// --- ZONE PUBLIQUE (Tout le monde peut voir) ---
Route::view('/', 'welcome');
Route::get('/vehicle/{id}', VehicleDetails::class)->name('vehicle.show');

// Pages statiques
Route::view('/vehicules', 'front.vehicles')->name('vehicles.index');
Route::view('/promotions', 'front.promotions')->name('promotions');
Route::view('/about', 'front.about')->name('about');
Route::view('/contact', 'front.contact')->name('contact');


// --- ZONE CLIENT (Il faut être connecté) ---
Route::middleware(['auth'])->group(function () {

    // Mes réservations
    Route::get('/mes-reservations', UserBookings::class)->name('user.bookings');

    // Profil utilisateur
    Route::view('profile', 'profile')->name('profile');
});


// --- ZONE ADMIN (Il faut être Admin) ---
Route::middleware(['auth', IsAdmin::class])->group(function () {

    // C'est ICI que l'on définit la fameuse route "admin.dashboard"
    // On change l'URL pour /admin/dashboard pour bien séparer
    Route::view('/admin/dashboard', 'dashboard')->name('admin.dashboard');
});
// --- ROUTE DE REDIRECTION INTELLIGENTE ---
// Cette route s'appelle "dashboard" pour calmer Laravel Breeze.
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user !== null && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.bookings');
})->middleware(['auth', 'verified'])->name('dashboard');
require __DIR__ . '/auth.php';
