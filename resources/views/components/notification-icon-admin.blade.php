<!-- Icône de notification avec badge pour admin -->
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
<div class="relative" style="z-index: 1000; position: relative; display: inline-block;">
    <button id="notificationIcon" class="p-2 text-gray-600 hover:text-gray-900 relative bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors" style="cursor: pointer; z-index: 1000; padding: 0.5rem; background-color: #f3f4f6 !important; color: #4b5563 !important; border: none !important; border-radius: 0.5rem !important; transition: background-color 0.2s, color 0.2s !important; display: inline-flex !important; align-items: center !important; justify-content: center !important;" data-bs-toggle="dropdown" aria-expanded="false" onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#111827';" onmouseout="this.style.backgroundColor='#f3f4f6'; this.style.color='#4b5563';">
        <svg class="w-6 h-6" style="width: 1.5rem !important; height: 1.5rem !important; display: block !important;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
        </svg>
        <span id="notificationBadge" class="badge badge-md badge-circle badge-floating badge-danger border-white" style="display: none !important;"></span>
    </button>
    <!-- Dropdown des notifications -->
    <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50 hidden" style="position: absolute !important; right: 0 !important; margin-top: 0.5rem !important; width: 20rem !important; background-color: #ffffff !important; border-radius: 0.5rem !important; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important; border: 1px solid #e5e7eb !important; padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; z-index: 10000 !important; max-height: 400px !important; overflow-y: auto !important; display: none !important;">
        <div class="px-4 py-2 border-b border-gray-200" style="padding-left: 1rem !important; padding-right: 1rem !important; padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; border-bottom: 1px solid #e5e7eb !important;">
            <h6 class="text-sm font-bold text-gray-900" style="font-size: 0.875rem !important; font-weight: 700 !important; color: #111827 !important; margin: 0 !important;">Notifications</h6>
        </div>
        <div id="notificationList" class="py-2" style="padding-top: 0.5rem !important; padding-bottom: 0.5rem !important;">
            <div class="px-4 py-2 text-sm text-gray-500" style="padding-left: 1rem !important; padding-right: 1rem !important; padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; font-size: 0.875rem !important; color: #6b7280 !important;">
                <i class="fa fa-clock mr-2"></i>
                Aucune nouvelle notification
            </div>
        </div>
    </div>
</div>

<!-- Script pour les notifications -->
<script>
    // Système de notifications pour admin
    (function() {
        const notificationBadge = document.getElementById('notificationBadge');
        const notificationList = document.getElementById('notificationList');
        const notificationIcon = document.getElementById('notificationIcon');
        const notificationDropdown = document.getElementById('notificationDropdown');
        
        if (!notificationIcon || !notificationDropdown) return;
        
        // S'assurer que le dropdown est fermé au démarrage
        notificationDropdown.style.display = 'none';
        notificationDropdown.classList.add('hidden');
        
        // Toggle dropdown
        notificationIcon.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isHidden = notificationDropdown.classList.contains('hidden') || notificationDropdown.style.display === 'none';
            
            if (isHidden) {
                notificationDropdown.classList.remove('hidden');
                notificationDropdown.style.display = 'block';
                loadNotificationDetails();
            } else {
                notificationDropdown.classList.add('hidden');
                notificationDropdown.style.display = 'none';
            }
        });
        
        // Fermer le dropdown en cliquant ailleurs
        document.addEventListener('click', function(e) {
            if (!notificationIcon.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
                notificationDropdown.style.display = 'none';
            }
        });
        
        function loadNotifications() {
            fetch('{{ route("admin.notifications.unread") }}')
                .then(response => response.json())
                .then(data => {
                    const count = data.count || 0;
                    if (count > 0 && notificationBadge) {
                        notificationBadge.textContent = count > 99 ? '99+' : count;
                        notificationBadge.style.display = 'block';
                    } else if (notificationBadge) {
                        notificationBadge.textContent = '';
                        notificationBadge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Erreur lors du chargement des notifications:', error));
        }
        
        function loadNotificationDetails() {
            fetch('{{ route("admin.notifications.unread.details") }}')
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
            fetch(`{{ url('admin/notifications') }}/${notificationId}/mark-as-read`, {
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

