<!-- Icône de notification avec badge pour formateurs -->
<style>
    /* Styles pour les badges uniformes */
    .badge-md {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
        min-width: 1.5rem;
        height: 1.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        line-height: 1;
    }
    .badge-circle {
        border-radius: 50%;
        width: 1.5rem;
        height: 1.5rem;
        padding: 0;
        min-width: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .badge-circle span,
    .badge-circle {
        line-height: 1.5rem;
        vertical-align: middle;
    }
    .badge-floating {
        position: absolute;
        top: -6px;
        right: -6px;
        z-index: 10;
    }
    button.relative, a.relative {
        position: relative;
    }
    .badge-danger {
        background-color: #ea4335;
        color: white;
    }
    .badge.border-white {
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
<div class="relative">
    <button id="notificationIcon" class="p-2 text-gray-600 hover:text-gray-900 relative bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors" data-bs-toggle="dropdown" aria-expanded="false">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <span id="notificationBadge" class="badge badge-md badge-circle badge-floating badge-danger border-white" style="display: none !important; visibility: hidden !important; opacity: 0 !important;"></span>
    </button>
    <!-- Dropdown des notifications -->
    <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50 hidden" style="max-height: 400px; overflow-y: auto;">
        <div class="px-4 py-2 border-b border-gray-200">
            <h6 class="text-sm font-bold text-gray-900">Notifications</h6>
        </div>
        <div id="notificationList" class="py-2">
            <div class="px-4 py-2 text-sm text-gray-500">
                <i class="fa fa-clock mr-2"></i>
                Aucune nouvelle notification
            </div>
        </div>
    </div>
</div>

<!-- Script pour les notifications -->
<script>
    // Système de notifications pour formateurs
    (function() {
        const notificationBadge = document.getElementById('notificationBadge');
        const notificationList = document.getElementById('notificationList');
        const notificationIcon = document.getElementById('notificationIcon');
        const notificationDropdown = document.getElementById('notificationDropdown');
        
        if (!notificationIcon || !notificationDropdown) return;
        
        // Toggle dropdown
        notificationIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            loadNotificationDetails();
        });
        
        // Fermer le dropdown en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (!notificationIcon.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
        
            function loadNotifications() {
                fetch('{{ route("formateur.notifications.unread") }}')
                    .then(response => response.json())
                    .then(data => {
                        const count = data.count || 0;
                        if (notificationBadge) {
                            if (count > 0) {
                                notificationBadge.textContent = count > 99 ? '99+' : count;
                                notificationBadge.style.display = 'flex';
                                notificationBadge.style.visibility = 'visible';
                            } else {
                                // Ne jamais afficher le badge si count est 0
                                notificationBadge.textContent = '';
                                notificationBadge.style.display = 'none';
                                notificationBadge.style.visibility = 'hidden';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des notifications:', error);
                        // En cas d'erreur, cacher le badge
                        if (notificationBadge) {
                            notificationBadge.style.display = 'none';
                            notificationBadge.style.visibility = 'hidden';
                            notificationBadge.textContent = '';
                        }
                    });
            }
        
        function loadNotificationDetails() {
            fetch('{{ route("formateur.notifications.unread.details") }}')
                .then(response => response.json())
                .then(notifications => {
                    if (!notificationList) return;
                    
                    if (notifications.length === 0) {
                        notificationList.innerHTML = `
                            <div class="px-4 py-2 text-sm text-gray-500">
                                <i class="fa fa-clock mr-2"></i>
                                Aucune nouvelle notification
                            </div>
                        `;
                    } else {
                        notificationList.innerHTML = notifications.map(notif => {
                            const escapedBody = notif.body.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                            const date = new Date(notif.created_at);
                            const formattedDate = date.toLocaleString('fr-FR', { 
                                day: '2-digit', 
                                month: '2-digit', 
                                year: 'numeric', 
                                hour: '2-digit', 
                                minute: '2-digit' 
                            });
                            return `
                                <div class="px-4 py-2 hover:bg-gray-50 cursor-pointer border-b border-gray-100" onclick="showNotificationAlert(${notif.id}, '${escapedBody}')">
                                    <h6 class="text-sm font-semibold text-gray-900 mb-1">${notif.title}</h6>
                                    <p class="text-xs text-gray-600 mb-1" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        ${notif.body}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        <i class="fa fa-clock mr-1"></i>
                                        ${formattedDate}
                                    </p>
                                </div>
                            `;
                        }).join('');
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des détails:', error));
        }
        
        window.showNotificationAlert = function(notificationId, message) {
            // Marquer comme lue
            fetch(`{{ url('formateur/notifications') }}/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(() => {
                loadNotifications();
                loadNotificationDetails();
            });
            
            // Afficher l'alerte
            alert(message);
        };
        
        // Charger les notifications au démarrage
        loadNotifications();
        loadNotificationDetails();
        
        // Recharger toutes les 30 secondes
        setInterval(() => {
            loadNotifications();
            loadNotificationDetails();
        }, 30000);
    })();
</script>

