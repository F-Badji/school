@if(Auth::check() && Auth::user()->role === 'student' && (isset($showApprenantVideoSessionNotification) ? $showApprenantVideoSessionNotification : true))
    <script src="{{ asset('js/apprenant-video-session-notification.js') }}" defer></script>
@endif

{{-- Script d'injection automatique pour toutes les pages apprenant --}}
@if(Auth::check() && Auth::user()->role === 'student')
    <script>
        // Injection automatique du script de notification si on est sur une page apprenant
        (function() {
            if (window.location.pathname.includes('/apprenant/') && 
                !window.location.pathname.includes('/video-conference/') &&
                !document.querySelector('script[src*="apprenant-video-session-notification.js"]')) {
                const script = document.createElement('script');
                script.src = '{{ asset('js/apprenant-video-session-notification.js') }}';
                script.defer = true;
                document.head.appendChild(script);
            }
        })();
    </script>
@endif

