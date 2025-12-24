/**
 * Notification globale pour les sessions vidéo actives
 * Affiche une alerte sur toutes les pages quand une session est en cours
 */

class VideoSessionNotification {
    constructor() {
        this.checkInterval = null;
        this.notificationElement = null;
        this.currentSession = null;
        this.updateInterval = null;
        this.init();
    }

    init() {
        // Vérifier si on est sur la page de visioconférence (ne pas afficher la notification)
        if (window.location.pathname.includes('/video-conference/')) {
            return;
        }

        // Vérifier les sessions actives toutes les 5 secondes
        this.checkActiveSessions();
        this.checkInterval = setInterval(() => {
            this.checkActiveSessions();
        }, 5000);
    }

    async checkActiveSessions() {
        try {
            const response = await fetch('/formateur/video-conference/active-sessions', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();
            
            if (data.success && data.sessions && data.sessions.length > 0) {
                // Prendre la première session active
                const session = data.sessions[0];
                this.currentSession = session;
                this.showNotification(session);
            } else {
                this.hideNotification();
            }
        } catch (error) {
            console.error('Erreur lors de la vérification des sessions actives:', error);
        }
    }

    showNotification(session) {
        // Si la notification existe déjà, juste la mettre à jour
        if (this.notificationElement) {
            this.updateNotification(session);
            return;
        }

        // Créer l'élément de notification
        this.notificationElement = document.createElement('div');
        this.notificationElement.id = 'video-session-notification';
        this.notificationElement.className = 'fixed top-24 right-4 z-50 max-w-md';
        this.notificationElement.innerHTML = `
            <div class="bg-blue-600 text-white rounded-lg shadow-lg p-4 cursor-pointer hover:bg-blue-700 transition-colors" onclick="window.location.href='${session.url}'">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106a1 1 0 00-1.106.553l-2 4A1 1 0 0013 13h2a1 1 0 00.894-.553l2-4a1 1 0 00-.553-1.341z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-sm">Session vidéo en cours</div>
                        <div class="text-xs mt-1 opacity-90">${this.escapeHtml(session.titre)}</div>
                    </div>
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(this.notificationElement);

        // Animation d'entrée
        setTimeout(() => {
            this.notificationElement.style.transform = 'translateX(0)';
            this.notificationElement.style.opacity = '1';
        }, 10);
    }

    updateNotification(session) {
        if (!this.notificationElement) return;

        // Mettre à jour le titre
        const titreElement = this.notificationElement.querySelector('.text-xs.mt-1.opacity-90');
        if (titreElement) {
            titreElement.textContent = this.escapeHtml(session.titre);
        }

        // Mettre à jour le lien
        const linkElement = this.notificationElement.querySelector('div[onclick]');
        if (linkElement) {
            linkElement.setAttribute('onclick', `window.location.href='${session.url}'`);
        }
    }

    hideNotification() {
        if (this.notificationElement) {
            this.notificationElement.style.opacity = '0';
            this.notificationElement.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (this.notificationElement && this.notificationElement.parentNode) {
                    this.notificationElement.parentNode.removeChild(this.notificationElement);
                }
                this.notificationElement = null;
            }, 300);
        }
        this.currentSession = null;
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    destroy() {
        if (this.checkInterval) {
            clearInterval(this.checkInterval);
        }
        this.hideNotification();
    }
}

// Initialiser la notification quand le DOM est prêt
let videoSessionNotification = null;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        // Vérifier si on est sur une page formateur
        if (window.location.pathname.includes('/formateur/')) {
            videoSessionNotification = new VideoSessionNotification();
        }
    });
} else {
    // Vérifier si on est sur une page formateur
    if (window.location.pathname.includes('/formateur/')) {
        videoSessionNotification = new VideoSessionNotification();
    }
}

// Nettoyer quand on quitte la page
window.addEventListener('beforeunload', () => {
    if (videoSessionNotification) {
        videoSessionNotification.destroy();
    }
});

