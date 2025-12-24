<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - BJ Academie</title>
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
        .card-gradient-1 {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        }
        .card-gradient-2 {
            background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
        }
        input:focus {
            outline: none;
            border-color: #1a1f3a;
            box-shadow: 0 0 0 3px rgba(26, 31, 58, 0.1);
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
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .support-contact-card {
            animation: fadeInUp 0.5s ease backwards;
        }
        .support-contact-card:nth-child(1) {
            animation-delay: 0.1s;
        }
        .support-contact-card:nth-child(2) {
            animation-delay: 0.2s;
        }
        .support-contact-card:nth-child(3) {
            animation-delay: 0.3s;
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
                    <!-- Dropdown Menu -->
                    <div id="coursDropdownMenu" class="w-full mt-2 px-2 hidden">
                        <a href="{{ route('formateur.cours') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isCours ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
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
                <a href="{{ route('formateur.parametres') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg " style="transition: none !important; -webkit-transition: none !important; {{ ($currentRoute ?? '') === 'formateur.parametres' ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Paramètres</span>
                </a>
                <a href="#" id="supportBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Support</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-white">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="relative flex-1 max-w-md">
                            <input type="text" placeholder="Rechercher" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none text-sm">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        @include('components.notification-icon-formateur')
                        <div class="relative">
                            <button id="profileDropdownBtn" class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-md cursor-pointer hover:ring-2 transition-all focus:outline-none" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
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
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">{{ $user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-1">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
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

            <!-- Settings Navigation -->
            <div class="border-b border-gray-200 px-6">
                <nav class="flex space-x-8">
                    <button onclick="showTab('profil')" id="tab-profil" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium">
                        Profil
                    </button>
                    <button onclick="showTab('password')" id="tab-password" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-medium">
                        Mot de passe
                    </button>
                </nav>
            </div>

            <!-- Settings Content -->
            <div class="flex-1 overflow-y-auto bg-gray-50 p-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Profil Tab -->
                    <div id="content-profil" class="tab-content hidden">
                        <div class="mb-8">
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">Informations du profil</h2>
                                <p class="text-gray-600">Consultez vos informations personnelles et académiques.</p>
                            </div>

                            <!-- Profile Header Card -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                                <div class="flex items-start gap-6">
                                    <!-- Profile Photo -->
                                    <div class="flex-shrink-0">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="w-24 h-24 rounded-full object-cover border-4 border-gray-100 shadow-md">
                                        @else
                                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-md" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                {{ strtoupper(substr($user->prenom ?? $user->name ?? 'A', 0, 1)) }}{{ strtoupper(substr($user->nom ?? '', 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Profile Info -->
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                            {{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}
                                            @if(!$user->prenom && !$user->nom)
                                                {{ $user->name ?? 'Utilisateur' }}
                                            @endif
                                        </h3>
                                        <p class="text-gray-600 mb-4">{{ $user->email ?? 'N/A' }}</p>
                                        
                                        <!-- Status Badge -->
                                        <div class="flex items-center gap-4 flex-wrap">
                                            @php
                                                // Déterminer le statut en ligne/hors ligne basé sur last_seen
                                                $isOnline = false;
                                                if($user->last_seen) {
                                                    $lastSeen = \Carbon\Carbon::parse($user->last_seen);
                                                    $isOnline = $lastSeen->diffInMinutes(now()) < 5; // En ligne si dernière activité il y a moins de 5 minutes
                                                }
                                            @endphp
                                            
                                            @if($user->last_seen)
                                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium {{ $isOnline ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    <span class="w-2 h-2 rounded-full {{ $isOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                                    {{ $isOnline ? 'En ligne' : 'Hors ligne' }}
                                                </span>
                                            @endif
                                            
                                            @if($user->role)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Information Cards Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Informations Personnelles -->
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900">Informations Personnelles</h4>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Nom complet</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                {{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}
                                                @if(!$user->prenom && !$user->nom)
                                                    {{ $user->name ?? 'N/A' }}
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Prénom</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $user->prenom ?? 'N/A' }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Nom</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $user->nom ?? 'N/A' }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Date de naissance</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                @if($user->date_naissance)
                                                    {{ \Carbon\Carbon::parse($user->date_naissance)->locale('fr')->isoFormat('D MMMM YYYY') }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Téléphone</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $user->phone ?? 'N/A' }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2">
                                            <span class="text-sm font-medium text-gray-500">Ville</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $user->location ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations Professionnelles -->
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900">Informations Professionnelles</h4>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Filière</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $user->filiere ?? 'N/A' }}</span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Niveau d'étude assigné</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                {{ $user->niveau_etude ?? 'N/A' }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Date d'inscription</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                @if($user->created_at)
                                                    {{ \Carbon\Carbon::parse($user->created_at)->locale('fr')->isoFormat('D MMMM YYYY') }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2">
                                            <span class="text-sm font-medium text-gray-500">Email</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right break-all">{{ $user->email ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dernière activité -->
                                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900">Activité</h4>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-start py-2 border-b border-gray-100">
                                            <span class="text-sm font-medium text-gray-500">Dernière connexion</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                @if($user->last_seen)
                                                    {{ \Carbon\Carbon::parse($user->last_seen)->locale('fr')->diffForHumans() }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <div class="flex justify-between items-start py-2">
                                            <span class="text-sm font-medium text-gray-500">Compte créé le</span>
                                            <span class="text-sm font-semibold text-gray-900 text-right">
                                                @if($user->created_at)
                                                    {{ \Carbon\Carbon::parse($user->created_at)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Tab -->
                    <div id="content-password" class="tab-content hidden">
                        <div class="mb-8">
                            <div class="mb-4">
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">Changer le mot de passe</h2>
                                <p class="text-gray-600">Mettez à jour votre mot de passe pour sécuriser votre compte.</p>
                            </div>

                            <!-- Password Form -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 max-w-2xl">
                                @if(session('success'))
                                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                        <ul class="list-disc list-inside text-red-800">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('formateur.update-password') }}">
                                    @csrf
                                    
                                    <div class="mb-6">
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Ancien mot de passe <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="password" 
                                            id="current_password" 
                                            name="current_password" 
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('current_password') border-red-500 @enderror"
                                            placeholder="Entrez votre mot de passe actuel"
                                        >
                                        @error('current_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-6">
                                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Nouveau mot de passe <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="password" 
                                            id="new_password" 
                                            name="new_password" 
                                            required
                                            minlength="8"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('new_password') border-red-500 @enderror"
                                            placeholder="Entrez votre nouveau mot de passe"
                                        >
                                        @error('new_password')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        @if(!$errors->has('new_password'))
                                            <p class="mt-1 text-xs text-gray-500">Votre mot de passe doit comporter au moins 8 caractères, des lettres miniscules et majuscules et au moins un chiffre.</p>
                                        @endif
                                    </div>

                                    <div class="mb-6">
                                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                            Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="password" 
                                            id="new_password_confirmation" 
                                            name="new_password_confirmation" 
                                            required
                                            minlength="8"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('new_password_confirmation') border-red-500 @enderror"
                                            placeholder="Confirmez votre nouveau mot de passe"
                                        >
                                        @error('new_password_confirmation')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        @if($errors->has('new_password') && str_contains($errors->first('new_password'), 'différent'))
                                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('new_password') }}</p>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <button 
                                            type="submit" 
                                            class="px-6 py-2 text-white font-medium rounded-lg transition-colors"
                                            style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);"
                                            onmouseover="this.style.background='linear-gradient(180deg, #161b33 0%, #1a1f3a 100%)'"
                                            onmouseout="this.style.background='linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)'"
                                        >
                                            Enregistrer les modifications
                                        </button>
                                        <button 
                                            type="button" 
                                            onclick="resetPasswordForm()"
                                            class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors"
                                        >
                                            Annuler
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active state from all tabs
            document.querySelectorAll('[id^="tab-"]').forEach(tab => {
                tab.style.borderColor = 'transparent';
                tab.style.color = '#6b7280';
                tab.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            const content = document.getElementById('content-' + tabName);
            if (content) {
                content.classList.remove('hidden');
            }

            // Add active state to selected tab
            const tab = document.getElementById('tab-' + tabName);
            if (tab) {
                tab.style.borderColor = '#1a1f3a';
                tab.style.color = '#1a1f3a';
                tab.classList.remove('border-transparent', 'text-gray-500');
            }

            // Update URL hash without triggering scroll
            if (history.pushState) {
                history.pushState(null, null, '#' + tabName);
            } else {
                window.location.hash = '#' + tabName;
            }
        }

        // Reset password form
        function resetPasswordForm() {
            document.getElementById('current_password').value = '';
            document.getElementById('new_password').value = '';
            document.getElementById('new_password_confirmation').value = '';
        }

        // Initialize: check URL hash or parameter for tab, or show payment tab by default, or password tab if there are errors
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL hash first (e.g., #password)
            const hash = window.location.hash.replace('#', '');
            // Check URL parameter as fallback (e.g., ?tab=password)
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            
            // Determine which tab to show
            let tabToShow = null;
            
            if (hash && ['profil', 'password'].includes(hash)) {
                tabToShow = hash;
            } else if (tabParam && ['profil', 'password'].includes(tabParam)) {
                tabToShow = tabParam;
            }
            
            @if($errors->any() || session('success'))
                if (tabToShow) {
                    showTab(tabToShow);
                } else {
                    showTab('password');
                }
            @else
                if (tabToShow) {
                    showTab(tabToShow);
                } else {
                    showTab('profil');
                }
            @endif
        });

        // Cours dropdown functionality
        const coursDropdownBtn = document.getElementById('coursDropdownBtn');
        const coursDropdownMenu = document.getElementById('coursDropdownMenu');
        const sidebar = document.getElementById('sidebar');
        let isHovering = false;
        let lastSidebarWidth = sidebar.offsetWidth;

        if (coursDropdownBtn && coursDropdownMenu) {
            coursDropdownBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                coursDropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!coursDropdownBtn.contains(e.target) && !coursDropdownMenu.contains(e.target)) {
                    coursDropdownMenu.classList.add('hidden');
                }
            });

            // Monitor sidebar width changes
            setInterval(function() {
                var currentSidebarWidth = sidebar.offsetWidth;
                if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                    coursDropdownMenu.classList.add('hidden');
                }
                lastSidebarWidth = currentSidebarWidth;
            }, 100);
        }

        // Profile dropdown menu
        document.addEventListener('DOMContentLoaded', function() {
            // Gérer le dropdown du profil
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

                profileDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Support Modal
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
            
            // Event delegation pour capturer le clic sur le bouton X même si les autres listeners ne fonctionnent pas
            document.addEventListener('click', function(e) {
                if (e.target.closest('#supportModalClose')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const modal = document.getElementById('supportModal');
                    if (modal) {
                        modal.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            }, true); // useCapture = true pour capturer avant les autres
        });
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






