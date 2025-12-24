<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApprenantMiddleware
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
        
        // Vérifier si l'utilisateur est bloqué
        if ($user->statut === 'bloque') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('error', 'Votre compte a été bloqué. Motif : ' . ($user->motif_blocage ?? 'Aucun motif spécifié.'));
        }
        
        // Vérification de sécurité basée sur le rôle uniquement
        // Vérifier que l'utilisateur est un apprenant (rôle 'student' ou null)
        if ($user->role && $user->role !== 'student') {
            // Rediriger selon le rôle de l'utilisateur
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('erreur', 'Accès refusé. Cette section est réservée aux apprenants.');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('formateur.dashboard')->with('erreur', 'Accès refusé. Cette section est réservée aux apprenants.');
            } else {
                abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
            }
        }
        
        return $next($request);
    }
}
