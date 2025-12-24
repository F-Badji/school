<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon calendrier - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f7fa;
        }
                .sidebar-bg {
            background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);
        }
        .sidebar-collapsed {
            width: 5rem;
            transition: width 0.3s ease;
        }
        .sidebar-collapsed:hover {
            width: 16rem;
        }
        .sidebar-text {
            opacity: 0;
            max-width: 0;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.3s ease, max-width 0.3s ease;
        }
        .sidebar-collapsed:hover .sidebar-text {
            opacity: 1;
            max-width: 200px;
        }
                nav a {
            transition: none !important;
            -webkit-transition: none !important;
        }
        nav a,
        nav a *,
        aside nav a,
        aside nav a *,
        aside nav a svg,
        aside nav a span {
            transition: none !important;
            -webkit-transition: none !important;
        }
        
        #calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #e9ecef;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .calendar-day-header {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
            color: #344767;
            border-bottom: 2px solid #e9ecef;
        }
        
        .calendar-day {
            background-color: #fff;
            padding: 12px 8px;
            min-height: 100px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .calendar-day:hover {
            background-color: #f8f9fa;
        }
        
        .calendar-day.other-month {
            background-color: #f8f9fa;
            color: #adb5bd;
        }
        
        .calendar-day.today {
            background-color: #e3f2fd;
            border: 2px solid #2196f3;
        }
        
        .day-number {
            font-weight: 600;
            font-size: 0.875rem;
            color: #344767;
            margin-bottom: 4px;
        }
        
        .calendar-day.other-month .day-number {
            color: #adb5bd;
        }
        
        .event-item {
            font-size: 0.7rem;
            padding: 4px 6px;
            margin: 2px 0;
            border-radius: 3px;
            background-color: #fff3cd;
            color: #856404;
            border-left: 3px solid #ffc107;
            line-height: 1.3;
            word-wrap: break-word;
            white-space: normal;
        }
        
        .event-item.examen {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }
        
        .event-item.devoir {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left-color: #17a2b8;
        }
        /* Cacher définitivement les badges avec toutes les classes exactes à côté de l'icône de profil */
        #profileDropdownBtn ~ .badge.badge-md.badge-circle.badge-floating.badge-danger.border-white:not(#notificationBadge),
        #profileDropdownBtn.parentElement .badge.badge-md.badge-circle.badge-floating.badge-danger.border-white:not(#notificationBadge) {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }

        /* Support Modal Styles */
        .support-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .support-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .support-modal {
            background: white;
            border-radius: 24px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.9) translateY(20px);
            transition: all 0.3s ease;
            position: relative;
        }
        .support-modal-overlay.active .support-modal {
            transform: scale(1) translateY(0);
        }
        .support-modal-header {
            position: relative;
            padding: 0;
            border-radius: 24px 24px 0 0;
            overflow: hidden;
        }
        .support-modal-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .support-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }
        .support-modal-close:hover {
            background: white;
            transform: rotate(90deg);
        }
        .support-modal-content {
            padding: 32px;
        }
        .support-modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1f3a;
            margin-bottom: 12px;
            text-align: center;
        }
        .support-modal-subtitle {
            font-size: 16px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 32px;
        }
        .support-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .support-contact-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: block;
        }
        .support-contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }
        .support-contact-card:hover::before {
            left: 100%;
        }
        .support-contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }
        .support-contact-card.whatsapp:hover {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            border-color: #25d366;
        }
        .support-contact-card.instagram:hover {
            background: linear-gradient(135deg, #e4405f 0%, #c13584 100%);
            border-color: #e4405f;
        }
        .support-contact-card.gmail:hover {
            background: linear-gradient(135deg, #ea4335 0%, #c5221f 100%);
            border-color: #ea4335;
        }
        .support-contact-card.whatsapp:hover *,
        .support-contact-card.instagram:hover *,
        .support-contact-card.gmail:hover * {
            color: white !important;
        }
        .support-contact-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .support-contact-card:hover .support-contact-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .support-contact-icon img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        .support-contact-label {
            font-size: 16px;
            font-weight: 600;
            color: #1a1f3a;
            margin-bottom: 4px;
            transition: color 0.3s ease;
        }
        .support-contact-value {
            font-size: 14px;
            color: #6b7280;
            transition: color 0.3s ease;
        }
</style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        @include('components.sidebar-apprenant')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="relative flex-1 max-w-md">
                            <input type="text" placeholder="Rechercher" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Notifications & Profile -->
                    <div class="flex items-center gap-4">
                        @include('components.notification-icon-apprenant')
                        <div class="relative">
                            <button id="profileDropdownBtn" class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-white shadow-md cursor-pointer hover:ring-2 hover:ring-purple-300 transition-all focus:outline-none">
                                @if($user->photo ?? null)
                                    <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                    </div>
                                @endif
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50 hidden">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-purple-300 flex-shrink-0">
                                            @if($user->photo ?? null)
                                                <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">{{ $user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('apprenant.parametres', ['tab' => 'profil']) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profil</span>
                                    </a>
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Paramètres</span>
                                    </a>
                                    <hr class="my-1 border-gray-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Déconnexion</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-white p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Mon calendrier</h1>
                        <p class="text-gray-600">Consultez votre calendrier et la planification des événements à venir.</p>
                    </div>

                    <!-- Calendar Container -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                        <div id="calendar-container">
                            <div class="flex justify-between items-center mb-6">
                                <button id="prev-month" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-chevron-left" style="font-size: 1.2rem; color: #344767;"></i>
                                    </button>
                                <h2 id="calendar-month-year" class="text-2xl font-bold text-gray-900"></h2>
                                <button id="next-month" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-chevron-right" style="font-size: 1.2rem; color: #344767;"></i>
                                    </button>
                            </div>
                            <div id="calendar-grid"></div>
                            </div>
                        </div>
                        
                    <!-- Emploi du temps -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h1 class="text-4xl font-bold text-gray-900 mb-6 text-center">Mon emploi du temps</h1>
                        <div id="emploi-du-temps-container" class="w-full">
                            <div id="emploi-du-temps-loading" class="text-center py-8">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                <p class="mt-3 text-gray-600">Chargement de l'emploi du temps...</p>
                            </div>
                            <div id="emploi-du-temps-content" style="display: none;">
                                <img id="emploi-du-temps-image" src="" alt="Emploi du temps" class="w-full h-auto rounded-lg" style="max-width: 100%;">
                                <iframe id="emploi-du-temps-pdf" src="" style="display: none; width: 100%; height: 800px; border: none;" class="rounded-lg"></iframe>
                            </div>
                            <div id="emploi-du-temps-error" style="display: none;" class="text-center py-8">
                                <p class="text-gray-600">Aucun emploi du temps disponible pour votre classe.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // DIAGNOSTIC: Logs pour le bouton Paramètres
        console.log('🔍 [DIAGNOSTIC CALENDRIER] Script chargé');
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔍 [DIAGNOSTIC CALENDRIER] DOMContentLoaded déclenché');
            
            const parametresBtn = document.getElementById('parametresBtn');
            console.log('🔍 [DIAGNOSTIC CALENDRIER] parametresBtn trouvé:', parametresBtn);
            
            if (parametresBtn) {
                console.log('🔍 [DIAGNOSTIC CALENDRIER] href du bouton:', parametresBtn.getAttribute('href'));
                
                parametresBtn.addEventListener('click', function(e) {
                    console.log('🔍 [DIAGNOSTIC CALENDRIER] Clic détecté via addEventListener');
                    console.log('🔍 [DIAGNOSTIC CALENDRIER] Event:', e);
                    console.log('🔍 [DIAGNOSTIC CALENDRIER] DefaultPrevented:', e.defaultPrevented);
                    console.log('🔍 [DIAGNOSTIC CALENDRIER] href:', this.getAttribute('href'));
                }, false);
                    } else {
                console.error('❌ [DIAGNOSTIC CALENDRIER] parametresBtn introuvable!');
            }
            

            // Profile dropdown menu - identique au dashboard
            // Supprimer définitivement TOUS les badges avec les classes exactes à côté de l'icône de profil
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            if (profileDropdownBtn) {
                const removeBadges = function() {
                    const parentElement = profileDropdownBtn.parentElement;
                    if (parentElement) {
                        // Chercher tous les badges avec les classes exactes: badge badge-md badge-circle badge-floating badge-danger border-white
                        const badges = parentElement.querySelectorAll('.badge.badge-md.badge-circle.badge-floating.badge-danger.border-white');
                        badges.forEach(badge => {
                            // Ne pas supprimer le badge de notification
                            if (badge.id !== 'notificationBadge') {
                                badge.remove();
                                console.log('✅ [APPRENANT] Badge supprimé à côté du profil');
                            }
                        });
                    }
                };
                
                // Supprimer immédiatement
                removeBadges();
                
                // Surveiller les ajouts futurs de badges
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1 && node.classList) {
                                // Vérifier si c'est un badge avec toutes les classes exactes
                                if (node.classList.contains('badge') && 
                                    node.classList.contains('badge-md') && 
                                    node.classList.contains('badge-circle') && 
                                    node.classList.contains('badge-floating') && 
                                    node.classList.contains('badge-danger') && 
                                    node.classList.contains('border-white') &&
                                    node.id !== 'notificationBadge') {
                                    node.remove();
                                    console.log('✅ [APPRENANT] Badge ajouté dynamiquement supprimé');
                                }
                            }
                        });
                    });
                });
                if (profileDropdownBtn.parentElement) {
                    observer.observe(profileDropdownBtn.parentElement, { childList: true, subtree: true });
                }
            }

            const profileDropdownMenu = document.getElementById('profileDropdownMenu');

            if (profileDropdownBtn && profileDropdownMenu) {
                profileDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    // Ne pas bloquer les liens de navigation
                    if (e.target.closest('a[href]') && !e.target.closest('#profileDropdownMenu')) {
                        return; // Laisser le lien fonctionner normalement
                    }
                    if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                        profileDropdownMenu.classList.add('hidden');
                    }
                });

                profileDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Gestion du calendrier mensuel (identique à l'admin)
            let currentDate = new Date();
            let events = [];
            
            const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
            const dayNames = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
            
            function loadEvents() {
                fetch('{{ route("apprenant.calendrier.events") }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    events = data || [];
                    renderCalendar();
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des événements:', error);
                    events = [];
                    renderCalendar();
                });
            }
            
            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                
                // Mettre à jour le titre
                document.getElementById('calendar-month-year').textContent = monthNames[month] + ' ' + year;
                
                // Premier jour du mois
                const firstDay = new Date(year, month, 1);
                // Dernier jour du mois
                const lastDay = new Date(year, month + 1, 0);
                // Premier jour à afficher (lundi de la semaine)
                const startDate = new Date(firstDay);
                const dayOfWeek = firstDay.getDay();
                const daysToSubtract = dayOfWeek === 0 ? 6 : dayOfWeek - 1; // Convertir dimanche (0) à 6
                startDate.setDate(firstDay.getDate() - daysToSubtract);
                
                // Dernier jour à afficher
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 41); // 6 semaines * 7 jours - 1
                
                const grid = document.getElementById('calendar-grid');
                grid.innerHTML = '';
                
                // En-têtes des jours
                dayNames.forEach(day => {
                    const header = document.createElement('div');
                    header.className = 'calendar-day-header';
                    header.textContent = day;
                    grid.appendChild(header);
                });
                
                // Jours du calendrier
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                    const day = new Date(d);
                    const dayDate = new Date(day);
                    dayDate.setHours(0, 0, 0, 0);
                    
                    const isOtherMonth = day.getMonth() !== month;
                    const isToday = dayDate.getTime() === today.getTime();
                    
                    const dayDiv = document.createElement('div');
                    dayDiv.className = 'calendar-day' + (isOtherMonth ? ' other-month' : '') + (isToday ? ' today' : '');
                    
                    const dayNumber = document.createElement('div');
                    dayNumber.className = 'day-number';
                    dayNumber.textContent = day.getDate();
                    dayDiv.appendChild(dayNumber);
                    
                    // Ajouter les événements pour ce jour
                    const dayEvents = events.filter(event => {
                        if (!event.start) return false;
                        const eventDateStr = event.start; // Format Y-m-d
                        const dayDateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day.getDate()).padStart(2, '0');
                        return eventDateStr === dayDateStr;
                    });
                    
                    if (dayEvents.length > 0) {
                        const eventsContainer = document.createElement('div');
                        dayEvents.forEach(event => {
                            const eventDiv = document.createElement('div');
                            eventDiv.className = 'event-item';
                            const eventType = (event.type || '').toLowerCase();
                            if (eventType === 'examen') {
                                eventDiv.classList.add('examen');
                            } else if (eventType === 'devoir') {
                                eventDiv.classList.add('devoir');
                            }
                            eventDiv.textContent = event.title || '';
                            eventsContainer.appendChild(eventDiv);
                        });
                        dayDiv.appendChild(eventsContainer);
                    }
                    
                    grid.appendChild(dayDiv);
                }
            }
            
            // Navigation
            document.getElementById('prev-month').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });
            
            document.getElementById('next-month').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });
            
            // Initialiser le calendrier
            loadEvents();
            
            // Charger l'emploi du temps
            loadEmploiDuTemps();
        });
        
        // Fonction pour charger l'emploi du temps
        function loadEmploiDuTemps() {
            const loadingDiv = document.getElementById('emploi-du-temps-loading');
            const contentDiv = document.getElementById('emploi-du-temps-content');
            const errorDiv = document.getElementById('emploi-du-temps-error');
            const imageElement = document.getElementById('emploi-du-temps-image');
            const pdfElement = document.getElementById('emploi-du-temps-pdf');
            
            fetch('{{ route("apprenant.emploi-du-temps") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur lors du chargement');
                }
                return response.json();
            })
            .then(data => {
                loadingDiv.style.display = 'none';
                
                if (data.fichier) {
                    const fileType = data.type_fichier ? data.type_fichier.toLowerCase() : '';
                    
                    if (fileType === 'pdf') {
                        // Afficher le PDF dans un iframe
                        pdfElement.src = data.fichier;
                        pdfElement.style.display = 'block';
                        imageElement.style.display = 'none';
                    } else {
                        // Afficher l'image
                        imageElement.src = data.fichier;
                        imageElement.style.display = 'block';
                        pdfElement.style.display = 'none';
                    }
                    
                    contentDiv.style.display = 'block';
                    errorDiv.style.display = 'none';
                } else {
                    throw new Error('Aucun fichier disponible');
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement de l\'emploi du temps:', error);
                loadingDiv.style.display = 'none';
                contentDiv.style.display = 'none';
                errorDiv.style.display = 'block';
            });
        }
    </script>

    <!-- Support Modal -->
    <div id="supportModal" class="support-modal-overlay">
        <div class="support-modal">
            <div class="support-modal-header">
                <img src="{{ asset('assets/images/assistance.jpeg') }}" alt="Assistance">
                <button type="button" class="support-modal-close" id="supportModalClose" onclick="const m=document.getElementById('supportModal');if(m){m.classList.remove('active');document.body.style.overflow='';} return false;">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="support-modal-content">
                <h2 class="support-modal-title">Besoin d'aide ?</h2>
                <p class="support-modal-subtitle">Contactez notre équipe de support via les canaux ci-dessous</p>

                <div class="support-contact-grid">
                    <a href="https://wa.me/221769719383" target="_blank" class="support-contact-card whatsapp">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/WhatsApp.png') }}" alt="WhatsApp">
                        </div>
                        <div class="support-contact-label">WhatsApp</div>
                        <div class="support-contact-value">Chat direct</div>
                    </a>

                    <a href="mailto:contact.bjacademie221@gmail.com" class="support-contact-card gmail">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/Gmail.png') }}" alt="Gmail">
                        </div>
                        <div class="support-contact-label">Gmail</div>
                        <div class="support-contact-value">Contactez-nous par email</div>
                    </a>

                    <a href="#" class="support-contact-card instagram">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/Instagram.png') }}" alt="Instagram">
                        </div>
                        <div class="support-contact-label">Instagram</div>
                        <div class="support-contact-value">Suivez-nous</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Support Modal - même style que les autres boutons
        document.getElementById('supportBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const supportModal = document.getElementById('supportModal');
            if (supportModal) {
                supportModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });

        // Support Modal - fermeture
        const supportModalClose = document.getElementById('supportModalClose');
        const supportModal = document.getElementById('supportModal');

        if (supportModalClose) {
            supportModalClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (supportModal) {
                    supportModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Aussi avec onclick pour être sûr
            supportModalClose.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (supportModal) {
                    supportModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
                return false;
            };
        }

        if (supportModal) {
            supportModal.addEventListener('click', function(e) {
                // Ne fermer que si on clique directement sur l'overlay, pas sur le contenu
                if (e.target === supportModal) {
                    supportModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && supportModal.classList.contains('active')) {
                    supportModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }
    </script>

    @include('components.apprenant-video-session-notification')
</body>
</html>
