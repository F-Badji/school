<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Examens - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
        /* Make dropdown menu items always visible when dropdown is open */
        #coursDropdownMenu:not(.hidden) .sidebar-text {
            opacity: 1 !important;
            max-width: 200px !important;
        }
        /* Ensure dropdown menu is visible and properly positioned */
        #coursDropdownMenu:not(.hidden) {
            display: block !important;
        }
        /* Make sure icons in dropdown are visible */
        #coursDropdownMenu:not(.hidden) svg {
            opacity: 1 !important;
            visibility: visible !important;
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
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        .badge-top {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        .avatar-dark-blue {
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 100%);
        }
        .card-dark-bg {
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 100%);
            border-color: #2d3550;
        }
        .course-card .h-48 img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(1);
        }
        .course-card:hover .h-48 img {
            transform: scale(1.2);
        }
        .course-card .h-48 svg {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(1);
        }
        .course-card:hover .h-48 svg {
            transform: scale(1.1);
        }
        .fixed-alert-container {
            position: fixed;
            top: 88px;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 10px 0;
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
            @php
                $examensSoumis = [];
                if($tentativesSoumises && $tentativesSoumises->count() > 0 && $examens) {
                    foreach($examens as $examen) {
                        if(isset($tentativesSoumises[$examen->id]) && $tentativesSoumises[$examen->id]->soumis_le) {
                            $examensSoumis[] = [
                                'examen' => $examen,
                                'tentative' => $tentativesSoumises[$examen->id]
                            ];
                        }
                    }
                }
            @endphp
            
            <!-- Alertes fixes pour examens soumis - En haut de la page -->
            @if(count($examensSoumis) > 0)
                <div class="fixed-alert-container">
                    <div class="max-w-7xl mx-auto px-8">
                        <div class="space-y-1.5">
                            @foreach($examensSoumis as $item)
                                <div class="flex items-center justify-center gap-2.5 text-sm">
                                    <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-700 text-center">
                                        Vous avez terminé l'examen <span class="font-semibold text-gray-900">"{{ $item['examen']->titre }}"</span> à <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($item['tentative']->soumis_le)->format('H:i') }}</span>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4" style="position: relative; z-index: 999;">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Mes Examens</h1>
                        <p class="text-gray-600 text-sm mt-1">Gérez et consultez tous vos examens</p>
                    </div>
                    <div class="flex items-center gap-4">
                        @include('components.notification-icon-apprenant')
                        <div class="relative">
                            <button id="profileDropdownBtn" class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-md cursor-pointer hover:ring-2 hover:ring-gray-300 transition-all focus:outline-none" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                @if($user->photo ?? null)
                                    <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                    </div>
                                @endif
                            </button>
                            <div id="profileDropdownMenu" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 flex-shrink-0" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); border-color: rgba(26, 31, 58, 0.3);">
                                            @if($user->photo ?? null)
                                                <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 break-words">
                                                {{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}
                                            </p>
                                            <p class="text-xs text-gray-500 break-words">{{ $user->email ?? '' }}</p>
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
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="flex-1 overflow-y-auto bg-gray-50 p-8" style="padding-top: {{ count($examensSoumis) > 0 ? '140px' : '32px' }};">
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if($examens && $examens->count() > 0)
                        <!-- Examens Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($examens as $examen)
                                @php
                                    $matiereNom = $examen->matiere->nom_matiere ?? 'Examen';
                                    $formateurNom = ($examen->formateur->prenom ?? '') . ' ' . ($examen->formateur->nom ?? '');
                                    $tentativeSoumise = $tentativesSoumises[$examen->id] ?? null;
                                    $examenSoumis = $tentativeSoumise !== null;
                                @endphp
                                <div class="examen-card bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm course-card">
                                    <!-- Image de couverture -->
                                    <div class="h-48 relative overflow-hidden">
                                        @if($examen->image_couverture)
                                            <img src="{{ asset('storage/' . $examen->image_couverture) }}" alt="{{ $examen->titre }}" class="w-full h-full object-cover absolute inset-0">
                                            <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(26, 31, 58, 0.7) 0%, rgba(22, 27, 51, 0.8) 100%);"></div>
                                        @else
                                            <!-- Fond bleu -->
                                            <div class="absolute inset-0" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);"></div>
                                            <!-- Image de fond géométrique (racks de serveurs) générée automatiquement -->
                                            <svg class="absolute inset-0 w-full h-full" style="opacity: 0.6; z-index: 1;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 200" preserveAspectRatio="none">
                                            <!-- Rack de serveurs gauche -->
                                            <g transform="translate(20, 20)">
                                                <!-- Serveur 1 -->
                                                <rect x="0" y="0" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.3s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.8s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.5s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="20" x2="60" y2="20" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="25" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>

                                                <!-- Serveur 2 -->
                                                <rect x="0" y="45" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.2s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.9s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.4s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.1s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="65" x2="60" y2="65" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="70" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>

                                                <!-- Serveur 3 -->
                                                <rect x="0" y="90" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.6s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.0s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.7s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.7s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="110" x2="60" y2="110" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="115" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>
                                            </g>

                                            <!-- Rack de serveurs centre -->
                                            <g transform="translate(100, 30)">
                                                <!-- Serveur 1 -->
                                                <rect x="0" y="0" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.1s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.8s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.6s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.3s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="20" x2="60" y2="20" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="25" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>

                                                <!-- Serveur 2 -->
                                                <rect x="0" y="45" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.9s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.5s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.2s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.8s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="65" x2="60" y2="65" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="70" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>

                                                <!-- Serveur 3 -->
                                                <rect x="0" y="90" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.4s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.0s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.6s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.7s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="110" x2="60" y2="110" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="115" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>
                                            </g>

                                            <!-- Rack de serveurs droite -->
                                            <g transform="translate(180, 10)">
                                                <!-- Serveur 1 -->
                                                <rect x="0" y="0" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.3s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.9s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.7s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="5" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.1s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="20" x2="60" y2="20" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="25" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>

                                                <!-- Serveur 2 -->
                                                <rect x="0" y="45" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.0s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.5s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.2s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.8s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="65" x2="60" y2="65" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="70" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>

                                                <!-- Serveur 3 -->
                                                <rect x="0" y="90" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.4s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.0s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.6s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.7s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="110" x2="60" y2="110" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="115" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>
                                            </g>
                                        </svg>
                                        @endif
                                        <!-- Badge Actif -->
                                        <div class="absolute top-4 right-4 z-10">
                                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-medium rounded-full">Actif</span>
                                        </div>
                                        <!-- Titre et matière -->
                                        <div class="absolute bottom-4 left-4 right-4 z-10">
                                            <h3 class="text-white font-bold text-lg mb-1 line-clamp-2">{{ $examen->titre }}</h3>
                                            <p class="text-gray-200 text-sm">{{ $matiereNom }}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Contenu -->
                                    <div class="p-6">
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {{ Str::limit($examen->description ?? 'Aucune description', 100) }}
                                        </p>
                                        
                                        <!-- Informations -->
                                        <div class="space-y-3 mb-4">
                                            @if($examen->date_examen)
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>{{ \Carbon\Carbon::parse($examen->date_examen)->format('d/m/Y') }}</span>
                                                </div>
                                            @endif
                                            
                                            @if($examen->heure_debut && $examen->heure_fin)
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>{{ $examen->heure_debut }} - {{ $examen->heure_fin }}</span>
                                                </div>
                                            @endif
                                            
                                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <span>{{ $examen->questions->count() }} question(s)</span>
                                            </div>
                                            
                                            @if($formateurNom)
                                                <div class="flex items-center gap-2 text-sm text-gray-500">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    <span>{{ $formateurNom }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Bouton d'action -->
                                        @if($examenSoumis)
                                            <button disabled class="block w-full px-4 py-2.5 text-gray-500 bg-gray-200 rounded-lg text-sm font-medium text-center cursor-not-allowed" style="background: #e5e7eb;">
                                                Examen terminé
                                            </button>
                                        @else
                                            <button onclick="requestCodeBeforeStartExamen({{ $examen->id }})" class="block w-full px-4 py-2.5 text-white rounded-lg text-sm font-medium transition-colors text-center hover:opacity-90" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                Commencer l'examen
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                            <div class="text-center py-12">
                                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Aucun examen disponible</h2>
                                <p class="text-gray-600">Vous n'avez pas encore d'examens assignés par vos professeurs.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // DIAGNOSTIC: Logs pour le bouton Paramètres
        console.log('🔍 [DIAGNOSTIC EXAMENS] Script chargé');
        
        // Profile dropdown menu
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔍 [DIAGNOSTIC EXAMENS] DOMContentLoaded déclenché');
            
            const parametresBtn = document.getElementById('parametresBtn');
            console.log('🔍 [DIAGNOSTIC EXAMENS] parametresBtn trouvé:', parametresBtn);
            
            if (parametresBtn) {
                console.log('🔍 [DIAGNOSTIC EXAMENS] href du bouton:', parametresBtn.getAttribute('href'));
                
                parametresBtn.addEventListener('click', function(e) {
                    console.log('🔍 [DIAGNOSTIC EXAMENS] Clic détecté via addEventListener');
                    console.log('🔍 [DIAGNOSTIC EXAMENS] Event:', e);
                    console.log('🔍 [DIAGNOSTIC EXAMENS] DefaultPrevented:', e.defaultPrevented);
                    console.log('🔍 [DIAGNOSTIC EXAMENS] href:', this.getAttribute('href'));
                }, false);
            } else {
                console.error('❌ [DIAGNOSTIC EXAMENS] parametresBtn introuvable!');
            }
            
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
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
        });


        // Modal pour demander le code avant de commencer l'examen
        let currentExamenId = null;

        function requestCodeBeforeStartExamen(examenId) {
            currentExamenId = examenId;
            const codeInput = document.getElementById('codeInputExamen');
            const codeModal = document.getElementById('codeModalExamen');
            
            // Vider le champ et forcer la réinitialisation
            if (codeInput) {
                codeInput.value = '';
                codeInput.type = 'text'; // Forcer la réinitialisation
                codeInput.type = 'text'; // Double pour s'assurer
            }
            
            codeModal.classList.remove('hidden');
            document.getElementById('codeMessageExamen').innerHTML = '';
            
            // Attendre un peu avant de focus pour s'assurer que le champ est bien vidé
            setTimeout(function() {
                if (codeInput) {
                    codeInput.value = '';
                    codeInput.focus();
                }
            }, 100);
        }

        function verifyCodeAndStartExamen() {
            const code = document.getElementById('codeInputExamen').value.trim();
            const messageDiv = document.getElementById('codeMessageExamen');
            
            if (!code || code.length !== 6) {
                messageDiv.innerHTML = '<p class="text-red-600">Veuillez entrer un code à 6 chiffres.</p>';
                return;
            }
            
            // Vérifier le code via AJAX
            fetch('{{ route("apprenant.examen.unlock", ":id") }}'.replace(':id', currentExamenId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Code correct, rediriger vers l'examen
                    window.location.href = '{{ route("apprenant.examen.passer", ":id") }}'.replace(':id', currentExamenId);
                } else {
                    messageDiv.innerHTML = '<p class="text-red-600">' + data.message + '</p>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<p class="text-red-600">Erreur lors de la vérification du code.</p>';
            });
        }

        function closeCodeModalExamen() {
            document.getElementById('codeModalExamen').classList.add('hidden');
            currentExamenId = null;
        }

        // Permettre la soumission avec Enter
        document.getElementById('codeInputExamen')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                verifyCodeAndStartExamen();
            }
        });
    </script>

    <!-- Modal pour demander le code avant de commencer -->
    <div id="codeModalExamen" class="fixed inset-0 bg-black bg-opacity-80 backdrop-blur-sm z-[10000] flex items-center justify-center hidden">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Code de sécurité requis</h3>
            <p class="text-gray-600 mb-6">Pour commencer cet examen, veuillez entrer le code de sécurité fourni par votre professeur.</p>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Code de sécurité (6 chiffres)</label>
                <input type="text" id="codeInputExamen" maxlength="6" autocomplete="off" autofill="off" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl font-mono tracking-widest" placeholder="000000">
            </div>
            <div id="codeMessageExamen" class="mb-4 text-sm"></div>
            <div class="flex gap-3 mt-8">
                <button onclick="closeCodeModalExamen()" class="flex-1 px-4 py-2 text-sm border-2 border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                    Annuler
                </button>
                <button onclick="verifyCodeAndStartExamen()" class="flex-1 px-4 py-2 text-sm text-white rounded-lg font-medium hover:opacity-90 transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                    Démarrer
                </button>
            </div>
        </div>
    </div>

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
        }

        if (supportModal) {
            supportModal.addEventListener('click', function(e) {
                if (e.target === supportModal) {
                    supportModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

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

