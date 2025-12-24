<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        
        // Vérification de sécurité basée sur le rôle uniquement
        if ($user->role !== 'admin') {
            // Rediriger selon le rôle de l'utilisateur
            if ($user->role === 'teacher') {
                return redirect()->route('formateur.dashboard')->with('error', 'Accès refusé. Cette section est réservée à l\'administrateur.');
            } elseif ($user->role === 'student' || !$user->role) {
                return redirect()->route('apprenant.dashboard')->with('error', 'Accès refusé. Cette section est réservée à l\'administrateur.');
            } else {
                abort(403, 'Accès refusé. Cette section est réservée à l\'administrateur.');
            }
        }
        
        return $next($request);
    }
}
