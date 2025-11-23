<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
{
    $user = $request->user();

    // Si l'utilisateur n'est pas connecté OU qu'il n'est pas admin
    if ($user === null || $user->role !== 'admin') {
        // On le renvoie à l'accueil avec une erreur 403 (Interdit)
        abort(403, 'Accès réservé aux administrateurs.');
    }

    return $next($request);
}
}
