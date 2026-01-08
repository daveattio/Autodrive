<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Front\VehicleDetails;
use App\Livewire\Front\UserBookings;
use App\Http\Controllers\PdfController; // Important pour le contrat
use App\Models\Promotion; // N'oublie pas cet import tout en haut pour les promotions
use App\Http\Middleware\IsAdmin;

// ==========================================
// 1. ZONE PUBLIQUE (Accessible à tous)
// ==========================================

Route::view('/', 'welcome');
Route::get('/vehicle/{id}', VehicleDetails::class)->name('vehicle.show');

// Page Véhicules (Catalogue)
Route::view('/vehicules', 'front.vehicles')->name('vehicles.index');

// Page À propos & Contact
Route::view('/about', 'front.about')->name('about');
Route::view('/contact', 'front.contact')->name('contact');

// Page Blog (Nouveau pour le SEO)
Route::view('/blog', 'front.blog')->name('blog');

// Page Promotions (Avec récupération des données depuis la BDD)

Route::get('/promotions', function () {
    // Changement ici : paginate(6) pour avoir des pages
    $promotions = Promotion::whereDate('end_date', '>=', now())
        ->latest()
        ->paginate(6);
    return view('front.promotions', compact('promotions'));
})->name('promotions');


// ==========================================
// 2. ZONE CLIENT (Connexion requise)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // Documents Profil Utilisateur
    Route::get('/user/documents', \App\Livewire\User\ProfileDocuments::class)->name('user.documents');

    // Mes réservations
    Route::get('/mes-reservations', UserBookings::class)->name('user.bookings');

    // Profil utilisateur
    Route::view('profile', 'profile')->name('profile');
});


// ==========================================
// 3. ZONE ADMIN (Rôle Admin requis)
// ==========================================
Route::middleware(['auth', IsAdmin::class])->group(function () {

    // Dashboard Admin
    Route::view('/admin/dashboard', 'dashboard')->name('admin.dashboard');

    // Génération du Contrat PDF
    Route::get('/admin/contract/{id}', [PdfController::class, 'generateContract'])->name('admin.contract');
});

// Route Facture (Accessible Client & Admin)
Route::get('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'download'])
    ->middleware(['auth'])
    ->name('invoice.download');

// ==========================================
// 4. SYSTÈME & REDIRECTION
// ==========================================

// Route "Dashboard" technique (pour rediriger après login)
Route::get('/dashboard', function () {
    $user = Auth::user();

    // VÉRIFICATION CORRIGÉE
    // On vérifie si le rôle est SOIT admin, SOIT super_admin
    if ($user && in_array($user->role, ['admin', 'super_admin'])) {
        return redirect()->route('admin.dashboard');
    }

    // Sinon, c'est un client
    return redirect()->route('vehicles.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
