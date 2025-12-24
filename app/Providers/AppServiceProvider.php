<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer pour partager le nombre de messages non lus avec toutes les vues de l'apprenant
        View::composer('apprenant.*', function ($view) {
            $user = Auth::user();
            $unreadMessagesCount = 0;
            
            if ($user && ($user->role === 'student' || !$user->role)) {
                // Calculer le nombre réel de messages non lus
                $unreadMessagesCount = Message::where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
            }
            
            $view->with('sidebarUnreadMessagesCount', $unreadMessagesCount);
            
            // Ajouter la notification de session vidéo active pour les apprenants
            $view->with('showApprenantVideoSessionNotification', true);
            
            // Injecter directement le script dans toutes les vues apprenant (sauf video-conference)
            $routeName = request()->route()->getName() ?? '';
            if (strpos($routeName, 'apprenant.') === 0 && 
                strpos($routeName, 'video-conference') === false) {
                $view->with('injectApprenantVideoNotification', true);
            } else {
                $view->with('injectApprenantVideoNotification', false);
            }
        });
        
        // View Composer pour partager le nombre de messages non lus avec toutes les vues de l'admin
        View::composer(['admin.*', 'layouts.admin'], function ($view) {
            $user = Auth::user();
            $unreadMessagesCount = 0;
            
            if ($user && $user->role === 'admin') {
                // Calculer le nombre réel de messages non lus
                $unreadMessagesCount = Message::where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
            }
            
            $view->with('sidebarUnreadMessagesCount', $unreadMessagesCount);
        });
        
        // View Composer pour partager le nombre de messages non lus avec toutes les vues du formateur
        View::composer('formateur.*', function ($view) {
            $user = Auth::user();
            $unreadMessagesCount = 0;
            
            if ($user && $user->role === 'teacher') {
                // Calculer le nombre réel de messages non lus
                $unreadMessagesCount = Message::where('receiver_id', $user->id)
                    ->whereNull('read_at')
                    ->count();
            }
            
            $view->with('sidebarUnreadMessagesCount', $unreadMessagesCount);
            
            // Ajouter la notification de session vidéo active (sauf sur la page de visioconférence)
            $routeName = request()->route()->getName() ?? '';
            $view->with('showVideoSessionNotification', 
                strpos($routeName, 'formateur.') === 0 && 
                strpos($routeName, 'video-conference') === false
            );
        });
    }
}
