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

    // On accepte 'admin' OU 'super_admin' dans le panneau d'administration
    if ($user === null || !in_array($user->role, ['admin', 'super_admin'])) {
        abort(403, 'Accès réservé au personnel autorisé.');
    }

    return $next($request);
}
}
