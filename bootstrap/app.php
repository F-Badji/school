<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'apprenant' => \App\Http\Middleware\ApprenantMiddleware::class,
            'formateur' => \App\Http\Middleware\FormateurMiddleware::class,
        ]);
        
        // Ajouter le middleware pour mettre à jour last_seen
        $middleware->web(append: [
            \App\Http\Middleware\UpdateLastSeen::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gestion personnalisée des erreurs CSRF (419) - SÉCURITÉ CRITIQUE
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->is('auth/register') || $request->routeIs('register.post')) {
                \Illuminate\Support\Facades\Log::warning('Token CSRF expiré lors de l\'inscription', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'email' => $request->input('email'),
                    'url' => $request->fullUrl(),
                ]);
                
                return redirect()->route('login.get')
                    ->with('error', '⚠️ Votre session a expiré. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                    ->withInput($request->except(['password', 'password_confirmation', '_token']));
            }
        });
        
        // Gestion des erreurs 404 pour les routes d'inscription
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, \Illuminate\Http\Request $request) {
            if ($request->is('auth/register') || $request->routeIs('register.post')) {
                \Illuminate\Support\Facades\Log::warning('Erreur 404 lors de l\'inscription', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'email' => $request->input('email'),
                    'url' => $request->fullUrl(),
                ]);
                
                return redirect()->route('login.get')
                    ->with('error', '⚠️ Erreur de session. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                    ->withInput($request->except(['password', 'password_confirmation', '_token']));
            }
        });
    })->create();
