<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Front\VehicleDetails;

Route::view('/', 'welcome');
Route::get('/vehicle/{id}', VehicleDetails::class)->name('vehicle.show');
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
// Pages statiques du Front-Office
Route::view('/about', 'front.about')->name('about');
Route::view('/contact', 'front.contact')->name('contact');
Route::view('/promotions', 'front.promotions')->name('promotions'); // Demandé dans le PDF
require __DIR__.'/auth.php';
