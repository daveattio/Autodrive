<?php

use App\Models\User;

// Test 1 : Vérifie que la page d'accueil s'affiche bien (Code 200 OK)
test('la page d accueil s affiche correctement', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

// Test 2 : Vérifie qu'on peut voir la page des véhicules
test('la page vehicules est accessible', function () {
    $response = $this->get('/vehicules');
    $response->assertStatus(200);
});

// Test 3 : Vérifie qu'un invité est redirigé s'il essaie d'aller au dashboard
test('les invites ne peuvent pas acceder au dashboard', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});