/**
 * Script d'injection automatique pour les notifications vidéo apprenant
 * S'injecte automatiquement dans toutes les pages apprenant
 */
(function() {
    // Vérifier si on est sur une page apprenant et pas sur la page de visioconférence
    if (window.location.pathname.includes('/apprenant/') && 
        !window.location.pathname.includes('/video-conference/')) {
        
        // Vérifier si le script principal n'est pas déjà chargé
        if (!document.querySelector('script[src*="apprenant-video-session-notification.js"]')) {
            const script = document.createElement('script');
            script.src = '/js/apprenant-video-session-notification.js';
            script.defer = true;
            document.head.appendChild(script);
        }
    }
})();





