<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyDeletePassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier le mot de passe uniquement pour les requêtes DELETE
        if ($request->isMethod('DELETE') || $request->has('_method') && $request->input('_method') === 'DELETE') {
            $password = $request->input('delete_password');
            $requiredPassword = config('delete_password.password', '022001');
            
            if ($password !== $requiredPassword) {
                return redirect()->back()
                    ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
            }
        }
        
        return $next($request);
    }
}
