<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur a déjà saisi le mot de passe admin
        if (!session()->has('admin_access_granted')) {
            // Rediriger vers la page de vérification du mot de passe admin
            return redirect()->route('admin.access.check');
        }
        return $next($request);
    }
}
