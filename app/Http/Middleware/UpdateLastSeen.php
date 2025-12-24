<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Mettre à jour last_seen seulement si la dernière mise à jour date de plus de 5 minutes
            // pour éviter trop de requêtes à la base de données
            if (!$user->last_seen || $user->last_seen->diffInMinutes(now()) >= 5) {
                $user->update(['last_seen' => now()]);
            }
        }
        
        return $next($request);
    }
}
