{{-- Notification pour les sessions vidéo actives --}}
@if(isset($showVideoSessionNotification) && $showVideoSessionNotification)
<script src="{{ asset('js/video-session-notification.js') }}"></script>
@endif

