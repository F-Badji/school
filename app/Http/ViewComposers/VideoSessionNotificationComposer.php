<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class VideoSessionNotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Vérifier si on est sur une route formateur
        $routeName = request()->route()->getName() ?? '';
        
        if (strpos($routeName, 'formateur.') === 0 && 
            strpos($routeName, 'video-conference') === false) {
            $view->with('showVideoSessionNotification', true);
        } else {
            $view->with('showVideoSessionNotification', false);
        }
    }
}





