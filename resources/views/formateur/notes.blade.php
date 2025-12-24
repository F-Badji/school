<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Notes - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
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
        #coursDropdownMenu:not(.hidden) .sidebar-text {
            opacity: 1 !important;
            max-width: 200px !important;
        }
        #coursDropdownMenu:not(.hidden) {
            display: block !important;
        }
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
        aside         nav a span {
            transition: none !important;
            -webkit-transition: none !important;
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
        <!-- Left Sidebar -->
        <aside id="sidebar" class="sidebar-collapsed sidebar-bg text-white flex flex-col py-6">
            <!-- Logo -->
            <div class="mb-8 flex items-center justify-center px-4">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 flex flex-col gap-6 w-full px-2">
                @php
                    $currentRoute = request()->route()->getName();
                    $isDashboard = $currentRoute === 'formateur.dashboard';
                    $isCours = $currentRoute === 'formateur.cours' || $currentRoute === 'formateur.cours.create' || $currentRoute === 'formateur.cours.edit';
                    $isNotes = $currentRoute === 'formateur.notes';
                    $isCalendrier = $currentRoute === 'formateur.calendrier';
                    $isMessages = $currentRoute === 'formateur.messages';
                    $isApprenants = $currentRoute === 'formateur.apprenants';
                @endphp
                <a href="{{ route('formateur.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isDashboard ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Tableau de bord</span>
                </a>
                <div class="w-full">
                    <a href="{{ route('formateur.cours') }}" id="coursDropdownBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link cursor-pointer" style="transition: none !important; -webkit-transition: none !important; {{ $isCours || $isNotes || $isCalendrier ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                        <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="sidebar-text font-medium flex-1" style="transition: none !important; -webkit-transition: none !important;">Cours</span>
                        <svg class="w-4 h-4 sidebar-text flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    <div id="coursDropdownMenu" class="w-full mt-2 px-2 hidden">
                        <a href="{{ route('formateur.cours') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important;">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mes cours</span>
                        </a>
                        <a href="{{ route('formateur.notes') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isNotes ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Notes</span>
                        </a>
                        <a href="{{ route('formateur.calendrier') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isCalendrier ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mon calendrier</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('formateur.devoirs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ ($currentRoute ?? '') === 'formateur.devoirs' || ($currentRoute ?? '') === 'formateur.devoirs.create' ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Devoirs</span>
                </a>
                <a href="{{ route('formateur.examens') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ ($currentRoute ?? '') === 'formateur.examens' || ($currentRoute ?? '') === 'formateur.examens.create' ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Examens</span>
                </a>
                <a href="{{ route('formateur.apprenants') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isApprenants ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Mes apprenants</span>
                </a>
                <a href="{{ route('formateur.messages') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link relative" style="transition: none !important; -webkit-transition: none !important; {{ $isMessages ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Messages</span>
                    @if(isset($sidebarUnreadMessagesCount) && $sidebarUnreadMessagesCount > 0)
                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white" id="sidebarUnreadBadge">{{ $sidebarUnreadMessagesCount }}</span>
                    @endif
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="w-full px-2 space-y-2 border-t border-gray-700/50 pt-4">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Paramètres</span>
                </a>
                <a href="#" id="supportBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Support</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex items-center">
                        <nav class="flex items-center space-x-2 text-sm text-gray-600">
                            <a href="{{ route('formateur.dashboard') }}" class="hover:text-gray-900">Tableau de bord</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">Gestion des Notes</span>
                        </nav>
                    </div>

                    <div class="flex items-center gap-4">
                        @include('components.notification-icon-formateur')
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
                                    <a href="{{ route('formateur.profil') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profil</span>
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" class="border-t border-gray-200 mt-1 pt-1">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
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

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Success/Error Messages -->
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

                    <!-- Page Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestion des Notes</h1>
                            <p class="text-gray-600">Gérez les notes de vos apprenants (Test de connaissance, Devoirs, Examens)</p>
                        </div>
                    </div>

                    <!-- Barre de recherche -->
                    @if($apprenants && $apprenants->count() > 0)
                        <div class="mb-6">
                            <div class="relative max-w-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    id="searchInput" 
                                    placeholder="Rechercher un apprenant (nom, prénom, email)..." 
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                >
                            </div>
                            <p class="mt-2 text-xs text-gray-500" id="searchResultsCount"></p>
                        </div>
                    @endif

                    <!-- Section Semestre {{ $semestre1 }} -->
                    <div id="semestre1Section" class="mb-12">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Semestre {{ $semestre1 }}</h2>
                        </div>
                        
                        <!-- Notes Table Semestre 1 -->
                    @if($apprenants && $apprenants->count() > 0)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mt-16">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider">Matricule</th>
                                            <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider">Nom et Prénom</th>
                                            @foreach($matieres as $matiere)
                                                <th class="px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider" colspan="5">
                                                    {{ $matiere->nom_matiere }}
                                                </th>
                                            @endforeach
                                            <th class="px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                        </tr>
                                        <tr>
                                            <th class="px-6 py-3 pt-6"></th>
                                            <th class="px-6 py-3 pt-6"></th>
                                            @foreach($matieres as $matiere)
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Matière</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Test de connaissance</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Devoirs</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Examens</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Semestres</th>
                                            @endforeach
                                            <th class="px-6 py-3 pt-6"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="apprenantsTableBody">
                                        @foreach($apprenants as $apprenant)
                                            <tr class="hover:bg-gray-50 apprenant-row" data-nom="{{ strtolower($apprenant->nom ?? '') }}" data-prenom="{{ strtolower($apprenant->prenom ?? '') }}" data-email="{{ strtolower($apprenant->email ?? '') }}" data-fullname="{{ strtolower(($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '')) }}">
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <p class="text-sm font-semibold text-gray-900">{{ $apprenant->matricule ?? 'N/A' }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 flex-shrink-0 mr-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); border-color: rgba(255, 255, 255, 0.3);">
                                                @if($apprenant->photo ?? null)
                                                    <img src="{{ asset('storage/' . ($apprenant->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                                @else
                                                                <div class="w-full h-full flex items-center justify-center text-white font-bold text-xs">
                                                        {{ strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                            <div class="text-sm font-semibold text-gray-900">{{ $apprenant->prenom ?? '' }} {{ $apprenant->nom ?? '' }}</div>
                                                            <div class="text-xs text-gray-500">{{ $apprenant->email ?? '' }}</div>
                                            </div>
                                        </div>
                                                </td>
                                                @php
                                                    // Initialiser $resultatId pour le semestre 1 avant la boucle
                                                    $resultatIdSem1 = null;
                                                @endphp
                                                @foreach($matieres as $matiere)
                                                    @php
                                                        $matiereData = $notesParApprenant[$apprenant->id]['matieres'][$matiere->id] ?? null;
                                                        // Pour Semestre {{ $semestre1 }}, récupérer les notes du semestre {{ $semestre1 }}
                                                        $notesParSemestre = $matiereData['notes_par_semestre'] ?? [];
                                                        $noteSem1 = $notesParSemestre[$semestre1] ?? null;
                                                        if (!$noteSem1) {
                                                            // Si pas de note pour semestre {{ $semestre1 }}, vérifier si la note globale est pour semestre {{ $semestre1 }}
                                                            $semestreGlobal = $matiereData['semestre'] ?? null;
                                                            if ($semestreGlobal == $semestre1) {
                                                                $noteSem1 = $matiereData;
                                                            } else {
                                                                $noteSem1 = null;
                                                            }
                                                        }
                                                        $quiz = $noteSem1['quiz'] ?? null;
                                                        $devoir = $noteSem1['devoir'] ?? null;
                                                        $examen = $noteSem1['examen'] ?? null;
                                                        $semestre = $noteSem1['semestre'] ?? $semestre1;
                                                        $resultatId = $noteSem1['resultat_id'] ?? null;
                                                        // Garder le premier resultatId trouvé pour le semestre 1
                                                        if ($resultatId && !$resultatIdSem1) {
                                                            $resultatIdSem1 = $resultatId;
                                                        }
                                                        $coursTitreQuiz = $matiereData['quiz_cours_titre'] ?? null;
                                                    @endphp
                                                    <!-- Matière (titre du cours) -->
                                                    <td class="px-4 py-4 text-center">
                                                        @if($coursTitreQuiz)
                                                            <span class="text-xs text-gray-700 text-center break-words" style="word-wrap: break-word; max-width: 150px; display: inline-block;">{{ $coursTitreQuiz }}</span>
                                                        @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                        @endif
                                                    </td>
                                                    <!-- Test de connaissance -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($quiz !== null)
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                                {{ round($quiz) }}/20
                                                                    </span>
                                                                @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                                @endif
                                                            </td>
                                                    <!-- Devoirs -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($devoir !== null)
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                                {{ round($devoir) }}/20
                                                                    </span>
                                                                @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                                @endif
                                                            </td>
                                                    <!-- Examens -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($examen !== null)
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                                {{ round($examen) }}/20
                                                                    </span>
                                                                @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                                @endif
                                                    </td>
                                                    <!-- Semestres -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($semestre !== null)
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                                Semestre {{ $semestre }}
                                                                    </span>
                                                                @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                                @endif
                                                    </td>
                                                @endforeach
                                                <!-- Actions -->
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <!-- Add/Edit Button -->
                                                        <button onclick="openNoteModal({{ $apprenant->id }}, '{{ $apprenant->prenom }} {{ $apprenant->nom }}', {{ $semestre1 }})" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Ajouter/Modifier les notes">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </button>
                                                        <!-- Delete Button -->
                                                        @if($resultatIdSem1)
                                                            <form action="{{ route('formateur.notes.destroy', $resultatIdSem1) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ces notes ?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer les notes">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <!-- Send to Admin Button -->
                                                        <form action="{{ route('formateur.notes.send-to-admin') }}" method="POST" class="inline send-notes-form" data-apprenant-name="{{ $apprenant->prenom }} {{ $apprenant->nom }}">
                                                            @csrf
                                                            <input type="hidden" name="apprenant_id" value="{{ $apprenant->id }}">
                                                            <button type="submit" class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors" title="Envoyer à l'administrateur">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                        </div>
                    </div>
                    
                    <!-- Section Semestre {{ $semestre2 }} -->
                    <div id="semestre2Section" class="mb-12 mt-24">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Semestre {{ $semestre2 }}</h2>
                        </div>
                        
                        <!-- Notes Table Semestre 2 -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider">Matricule</th>
                                            <th class="px-6 py-4 text-left text-lg font-bold text-gray-700 uppercase tracking-wider">Nom et Prénom</th>
                                            @foreach($matieres as $matiere)
                                                <th class="px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider" colspan="5">
                                                    {{ $matiere->nom_matiere }}
                                                </th>
                                            @endforeach
                                            <th class="px-6 py-4 text-center text-lg font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                        </tr>
                                        <tr>
                                            <th class="px-6 py-3 pt-6"></th>
                                            <th class="px-6 py-3 pt-6"></th>
                                            @foreach($matieres as $matiere)
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Matière</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Test de connaissance</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Devoirs</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Examens</th>
                                                <th class="px-4 py-3 pt-6 text-center text-sm font-medium text-gray-600">Semestres</th>
                                            @endforeach
                                            <th class="px-6 py-3 pt-6"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="apprenantsTableBodySem2">
                                        @foreach($apprenants as $apprenant)
                                            <tr class="hover:bg-gray-50 apprenant-row-sem2" data-nom="{{ strtolower($apprenant->nom ?? '') }}" data-prenom="{{ strtolower($apprenant->prenom ?? '') }}" data-email="{{ strtolower($apprenant->email ?? '') }}" data-fullname="{{ strtolower(($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '')) }}">
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <p class="text-sm font-semibold text-gray-900">{{ $apprenant->matricule ?? 'N/A' }}</p>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 flex-shrink-0 mr-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); border-color: rgba(255, 255, 255, 0.3);">
                                                @if($apprenant->photo ?? null)
                                                    <img src="{{ asset('storage/' . ($apprenant->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                                @else
                                                                <div class="w-full h-full flex items-center justify-center text-white font-bold text-xs">
                                                        {{ strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                            <div class="text-sm font-semibold text-gray-900">{{ $apprenant->prenom ?? '' }} {{ $apprenant->nom ?? '' }}</div>
                                                            <div class="text-xs text-gray-500">{{ $apprenant->email ?? '' }}</div>
                                            </div>
                                        </div>
                                                </td>
                                                @php
                                                    // Initialiser $resultatId pour le semestre 2 avant la boucle
                                                    $resultatIdSem2 = null;
                                                @endphp
                                                @foreach($matieres as $matiere)
                                                    @php
                                                        $matiereData = $notesParApprenant[$apprenant->id]['matieres'][$matiere->id] ?? null;
                                                        // Pour Semestre {{ $semestre2 }}, récupérer les notes du semestre {{ $semestre2 }}
                                                        $notesParSemestre = $matiereData['notes_par_semestre'] ?? [];
                                                        $noteSem2 = $notesParSemestre[$semestre2] ?? null;
                                                        if (!$noteSem2) {
                                                            // Si pas de note pour semestre {{ $semestre2 }}, vérifier si la note globale est pour semestre {{ $semestre2 }}
                                                            $semestreGlobal = $matiereData['semestre'] ?? null;
                                                            if ($semestreGlobal == $semestre2) {
                                                                $noteSem2 = $matiereData;
                                                            } else {
                                                                $noteSem2 = null;
                                                            }
                                                        }
                                                        $quiz = $noteSem2['quiz'] ?? null;
                                                        $devoir = $noteSem2['devoir'] ?? null;
                                                        $examen = $noteSem2['examen'] ?? null;
                                                        $semestre = $noteSem2['semestre'] ?? $semestre2;
                                                        $resultatId = $noteSem2['resultat_id'] ?? null;
                                                        // Garder le premier resultatId trouvé pour le semestre 2
                                                        if ($resultatId && !$resultatIdSem2) {
                                                            $resultatIdSem2 = $resultatId;
                                                        }
                                                        $coursTitreQuiz = $matiereData['quiz_cours_titre'] ?? null;
                                                    @endphp
                                                    <!-- Matière (titre du cours) -->
                                                    <td class="px-4 py-4 text-center">
                                                        @if($coursTitreQuiz)
                                                            <span class="text-xs text-gray-700 text-center break-words" style="word-wrap: break-word; max-width: 150px; display: inline-block;">{{ $coursTitreQuiz }}</span>
                                                        @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                        @endif
                                                    </td>
                                                    <!-- Test de connaissance -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($quiz !== null)
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                                {{ round($quiz) }}/20
                                                                    </span>
                                                                @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                                @endif
                                                            </td>
                                                    <!-- Devoirs -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($devoir !== null)
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                                {{ round($devoir) }}/20
                                                                    </span>
                                                                @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                                @endif
                                                            </td>
                                                    <!-- Examens -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($examen !== null)
                                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                                {{ round($examen) }}/20
                                                                    </span>
                                                                @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                                @endif
                                                    </td>
                                                    <!-- Semestres -->
                                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                                        @if($semestre !== null)
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                                Semestre {{ $semestre }}
                                                            </span>
                                                        @else
                                                            <span class="text-gray-400 text-sm">-</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                                <!-- Actions -->
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <!-- Add/Edit Button -->
                                                        <button onclick="openNoteModal({{ $apprenant->id }}, '{{ $apprenant->prenom }} {{ $apprenant->nom }}', {{ $semestre2 }})" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Ajouter/Modifier les notes">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </button>
                                                        <!-- Delete Button -->
                                                        @if($resultatIdSem2)
                                                            <form action="{{ route('formateur.notes.destroy', $resultatIdSem2) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ces notes ?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer les notes">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <!-- Send to Admin Button -->
                                                        <form action="{{ route('formateur.notes.send-to-admin') }}" method="POST" class="inline send-notes-form" data-apprenant-name="{{ $apprenant->prenom }} {{ $apprenant->nom }}">
                                                            @csrf
                                                            <input type="hidden" name="apprenant_id" value="{{ $apprenant->id }}">
                                                            <button type="submit" class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition-colors" title="Envoyer à l'administrateur">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                                        </div>
                                    </div>
                    @else
                        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun apprenant trouvé</h3>
                            <p class="text-gray-600">Aucun apprenant n'est assigné à votre classe et filière.</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Modal pour ajouter/modifier les notes -->
    <div id="noteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">Gérer les notes</h3>
                    <button onclick="closeNoteModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mt-2" id="modalStudentName"></p>
            </div>
            <form id="noteForm" action="{{ route('formateur.notes.store') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="user_id" id="modalUserId">
                
                <!-- Champ Semestre (caché, fixé automatiquement) -->
                <input type="hidden" name="semestre" id="modalSemestre" value="" required>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Semestre <span class="text-red-500">*</span></label>
                    <div class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700" id="semestreDisplay">
                        <!-- Le semestre sera affiché ici -->
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Le semestre est automatiquement déterminé selon la section</p>
                </div>
                
                <div class="space-y-6">
                    @foreach($matieres ?? [] as $matiere)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">{{ $matiere->nom_matiere }}</h4>
                            
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Test de connaissance</label>
                                    <input type="number" name="notes[{{ $matiere->id }}][quiz]" step="0.01" min="0" max="20" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0-20" id="quiz_{{ $matiere->id }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Devoirs</label>
                                    <input type="number" name="notes[{{ $matiere->id }}][devoir]" step="0.01" min="0" max="20" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0-20" id="devoir_{{ $matiere->id }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Examens</label>
                                    <input type="number" name="notes[{{ $matiere->id }}][examen]" step="0.01" min="0" max="20" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0-20" id="examen_{{ $matiere->id }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                    <button type="button" onclick="closeNoteModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" class="px-6 py-2 text-white rounded-lg transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Cours dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const coursDropdownBtn = document.getElementById('coursDropdownBtn');
            const coursDropdownMenu = document.getElementById('coursDropdownMenu');
            const sidebar = document.getElementById('sidebar');
            let lastSidebarWidth = sidebar ? sidebar.offsetWidth : 0;

            // S'assurer que le dropdown est fermé au chargement
            if (coursDropdownMenu) {
                coursDropdownMenu.classList.add('hidden');
            }

            if (coursDropdownBtn && coursDropdownMenu) {
                coursDropdownBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    coursDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!coursDropdownBtn.contains(e.target) && !coursDropdownMenu.contains(e.target)) {
                        coursDropdownMenu.classList.add('hidden');
                    }
                });

                if (sidebar) {
                    setInterval(function() {
                        var currentSidebarWidth = sidebar.offsetWidth;
                        if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                            coursDropdownMenu.classList.add('hidden');
                        }
                        lastSidebarWidth = currentSidebarWidth;
                    }, 100);
                }
            }
        });

        // Profile dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');

            if (profileDropdownBtn && profileDropdownMenu) {
                profileDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                        profileDropdownMenu.classList.add('hidden');
                    }
                });
            }
        });

        // Note Modal functions
        const notesData = @json($notesParApprenant ?? []);
        const apprenantsData = @json($apprenantsData ?? []);
        
        function openNoteModal(userId, studentName, semestre) {
            document.getElementById('modalUserId').value = userId;
            document.getElementById('modalStudentName').textContent = 'Apprenant: ' + studentName;
            
            // Fixer le semestre automatiquement selon la section
            document.getElementById('modalSemestre').value = semestre;
            document.getElementById('semestreDisplay').textContent = `Semestre ${semestre}`;
            
            // Reset all inputs
            document.querySelectorAll('#noteForm input[type="number"]').forEach(input => {
                input.value = '';
            });
            
            // Load existing notes if any
            if (notesData[userId] && notesData[userId].matieres) {
                @foreach($matieres ?? [] as $matiere)
                    const matiereData = notesData[userId]?.matieres?.[{{ $matiere->id }}];
                    if (matiereData) {
                        const quizInput = document.getElementById('quiz_{{ $matiere->id }}');
                        const devoirInput = document.getElementById('devoir_{{ $matiere->id }}');
                        const examenInput = document.getElementById('examen_{{ $matiere->id }}');
                        
                        if (quizInput && matiereData.quiz !== null) quizInput.value = matiereData.quiz;
                        if (devoirInput && matiereData.devoir !== null) devoirInput.value = matiereData.devoir;
                        if (examenInput && matiereData.examen !== null) examenInput.value = matiereData.examen;
                    }
                @endforeach
            }
            
            document.getElementById('noteModal').classList.remove('hidden');
        }

        function closeNoteModal() {
            document.getElementById('noteModal').classList.add('hidden');
            document.getElementById('noteForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('noteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeNoteModal();
            }
        });

        // Fonctionnalité de recherche
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchResultsCount = document.getElementById('searchResultsCount');
            const apprenantsRowsSem1 = document.querySelectorAll('.apprenant-row');
            const apprenantsRowsSem2 = document.querySelectorAll('.apprenant-row-sem2');
            const totalApprenants = apprenantsRowsSem1.length;

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase().trim();
                    let visibleCountSem1 = 0;
                    let visibleCountSem2 = 0;

                    // Filtrer Semestre {{ $semestre1 }}
                    apprenantsRowsSem1.forEach(function(row) {
                        const nom = row.getAttribute('data-nom') || '';
                        const prenom = row.getAttribute('data-prenom') || '';
                        const email = row.getAttribute('data-email') || '';
                        const fullname = row.getAttribute('data-fullname') || '';

                        const matches = searchTerm === '' || 
                                      nom.includes(searchTerm) || 
                                      prenom.includes(searchTerm) || 
                                      email.includes(searchTerm) || 
                                      fullname.includes(searchTerm);

                        if (matches) {
                            row.style.display = '';
                            visibleCountSem1++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Filtrer Semestre {{ $semestre2 }}
                    apprenantsRowsSem2.forEach(function(row) {
                        const nom = row.getAttribute('data-nom') || '';
                        const prenom = row.getAttribute('data-prenom') || '';
                        const email = row.getAttribute('data-email') || '';
                        const fullname = row.getAttribute('data-fullname') || '';

                        const matches = searchTerm === '' || 
                                      nom.includes(searchTerm) || 
                                      prenom.includes(searchTerm) || 
                                      email.includes(searchTerm) || 
                                      fullname.includes(searchTerm);

                        if (matches) {
                            row.style.display = '';
                            visibleCountSem2++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Mettre à jour le compteur
                    if (searchResultsCount) {
                        if (searchTerm === '') {
                            searchResultsCount.textContent = '';
                        } else {
                            const totalVisible = visibleCountSem1 + visibleCountSem2;
                            searchResultsCount.textContent = `${totalVisible} apprenant(s) trouvé(s) sur ${totalApprenants}`;
                        }
                    }
                });
            }
            
            // Double confirmation pour l'envoi des notes à l'administrateur
            const sendNotesForms = document.querySelectorAll('.send-notes-form');
            sendNotesForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const apprenantName = form.getAttribute('data-apprenant-name') || 'cet apprenant';
                    
                    // Première confirmation
                    const firstConfirm = confirm('⚠️ ATTENTION : Vous êtes sur le point d\'envoyer toutes les notes de ' + apprenantName + ' à l\'administrateur.\n\nCette action est irréversible. Voulez-vous vraiment continuer ?');
                    
                    if (!firstConfirm) {
                        return false;
                    }
                    
                    // Deuxième confirmation
                    const secondConfirm = confirm('🔒 DERNIÈRE CONFIRMATION :\n\nVous confirmez l\'envoi de toutes les notes de ' + apprenantName + ' à l\'administrateur ?');
                    
                    if (!secondConfirm) {
                        return false;
                    }
                    
                    // Si les deux confirmations sont validées, soumettre le formulaire
                    form.submit();
                });
            });
        });

        // Support Modal - Initialisation après chargement du DOM
        document.addEventListener('DOMContentLoaded', function() {
            const supportBtn = document.getElementById('supportBtn');
            const supportModalClose = document.getElementById('supportModalClose');
            const supportModal = document.getElementById('supportModal');

            // Ouvrir le modal
            if (supportBtn) {
                supportBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (supportModal) {
                        supportModal.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }
                });
            }

            // Fermer le modal avec le bouton X
            if (supportModalClose) {
                supportModalClose.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (supportModal) {
                        supportModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                    return false;
                });

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

            // Fermer en cliquant sur l'overlay
            if (supportModal) {
                supportModal.addEventListener('click', function(e) {
                    if (e.target === supportModal) {
                        supportModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });

                // Fermer avec Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && supportModal.classList.contains('active')) {
                        supportModal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });

                // Event delegation pour capturer tous les clics sur le bouton de fermeture
                document.addEventListener('click', function(e) {
                    if (e.target.closest('#supportModalClose') || e.target.closest('.support-modal-close')) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (supportModal) {
                            supportModal.classList.remove('active');
                            document.body.style.overflow = '';
                        }
                    }
                }, true);
            }
        });
    </script>

    <!-- Support Modal -->
    <div id="supportModal" class="support-modal-overlay">
        <div class="support-modal">
            <div class="support-modal-header">
                <img src="{{ asset('assets/images/assistance.jpeg') }}" alt="Assistance">
                <button type="button" class="support-modal-close" id="supportModalClose">
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
                    
                    <a href="mailto:filybadji2020@gmail.com" class="support-contact-card gmail">
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
@include('components.video-session-notification')</body>
</html>
