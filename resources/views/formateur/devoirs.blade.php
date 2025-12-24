<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programmer des devoirs - BJ Academie</title>
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
        .course-card {
            transition: all 0.3s ease;
        }
        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        /* Image zoom animation on hover */
        .course-card .h-48 {
            overflow: hidden;
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
                <a href="#" id="parametresBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link">
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
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Rechercher un devoir..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="flex-1 flex items-center justify-center">
                        <nav class="flex items-center space-x-2 text-sm text-gray-600">
                            <a href="{{ route('formateur.dashboard') }}" class="hover:text-gray-900">Tableau de bord</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">Programmer des devoirs</span>
                        </nav>
                    </div>

                    <!-- Notifications & Profile -->
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
                                    <a href="{{ route('formateur.profil') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
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
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto px-6 py-8">
                    <!-- Page Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Programmer des devoirs</h1>
                            <p class="text-gray-600">Gérez tous les devoirs des étudiants en un seul endroit</p>
                        </div>
                        <a href="{{ route('formateur.devoirs.create') }}" class="px-6 py-3 text-white rounded-lg transition-all shadow-lg hover:shadow-xl font-medium flex items-center gap-2" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Nouveau devoir</span>
                        </a>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Devoirs Grid -->
                    @if($devoirs->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="devoirsGrid">
                            @foreach($devoirs as $index => $devoir)
                                @php
                                    $matiereNom = $devoir->matiere->nom_matiere ?? 'Devoir';
                                @endphp
                                <div class="course-card bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                    <div class="h-48 relative overflow-hidden">
                                        @if($devoir->image_couverture)
                                            <img src="{{ asset('storage/' . $devoir->image_couverture) }}" alt="{{ $devoir->titre }}" class="w-full h-full object-cover absolute inset-0">
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
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.6s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.8s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="50" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.4s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="65" x2="60" y2="65" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="70" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>
                                                
                                                <!-- Serveur 3 -->
                                                <rect x="0" y="90" width="60" height="40" fill="rgba(255, 255, 255, 0.25)" rx="2"/>
                                                <rect x="5" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.5s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="15" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.2s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="25" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="1.7s" repeatCount="indefinite"/>
                                                </rect>
                                                <rect x="35" y="95" width="8" height="8" fill="rgba(255, 255, 255, 0.5)" rx="1">
                                                    <animate attributeName="opacity" values="0.5;0.9;0.5" dur="2.8s" repeatCount="indefinite"/>
                                                </rect>
                                                <line x1="0" y1="110" x2="60" y2="110" stroke="rgba(255, 255, 255, 0.4)" stroke-width="1"/>
                                                <rect x="5" y="115" width="50" height="10" fill="rgba(255, 255, 255, 0.2)" rx="1"/>
                                            </g>
                                            </svg>
                                        @endif
                                        <!-- Badge Actif/Inactif -->
                                        <div class="absolute top-4 right-4 z-10">
                                            @if($devoir->actif)
                                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-medium rounded-full">Actif</span>
                                            @else
                                                <span class="px-3 py-1 bg-gray-400 text-white text-xs font-medium rounded-full">Inactif</span>
                                            @endif
                                        </div>
                                        <!-- Titre et matière -->
                                        <div class="absolute bottom-4 left-4 right-4 z-10">
                                            <h3 class="text-white font-bold text-lg mb-1 line-clamp-2">{{ $devoir->titre }}</h3>
                                            <p class="text-gray-200 text-sm">{{ $matiereNom }}</p>
                                        </div>
                                    </div>
                                    <div class="p-6">
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {{ Str::limit($devoir->description ?? 'Aucune description', 100) }}
                                        </p>
                                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                            @if($devoir->date_devoir)
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>{{ \Carbon\Carbon::parse($devoir->date_devoir)->format('d/m/Y') }}</span>
                                                </div>
                                            @endif
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <span>{{ $devoir->questions->count() }} question(s)</span>
                                            </div>
                                        </div>
                                        @if($devoir->heure_debut && $devoir->heure_fin)
                                            <div class="flex items-center gap-1 text-sm text-gray-500 mb-4">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span>{{ $devoir->heure_debut }} - {{ $devoir->heure_fin }}</span>
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('formateur.devoirs.edit', $devoir->id) }}" class="flex-1 px-4 py-2 text-white rounded-lg transition-colors text-center text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.background='linear-gradient(180deg, #161b33 0%, #1a1f3a 100%)'" onmouseout="this.style.background='linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)'">
                                                Modifier
                                            </a>
                                            <form action="{{ route('formateur.devoirs.destroy', $devoir->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce devoir ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun devoir pour le moment</h3>
                            <p class="text-gray-600 mb-6">Commencez par créer votre premier devoir</p>
                            <a href="{{ route('formateur.devoirs.create') }}" class="inline-flex items-center gap-2 px-6 py-3 text-white rounded-lg transition-all shadow-lg hover:shadow-xl font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Créer mon premier devoir</span>
                            </a>
                        </div>
                    @endif

                    <!-- Section Réponses des devoirs -->
                    @if($devoirs->count() > 0)
                        <div class="mt-12">
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-2">Réponses des devoirs</h2>
                                <p class="text-gray-600">Consultez et évaluez les réponses soumises par vos apprenants pour chaque devoir. Cette section vous permet de suivre en détail les questions posées et les réponses fournies, facilitant ainsi l'évaluation et le suivi pédagogique.</p>
                            </div>

                            <div class="space-y-8">
                                @foreach($devoirs as $devoir)
                                    @if($devoir->questions->count() > 0)
                                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                            <!-- En-tête du devoir -->
                                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <h3 class="text-lg font-bold text-gray-900">{{ $devoir->titre }}</h3>
                                                        <p class="text-sm text-gray-600 mt-1">
                                                            {{ $devoir->matiere->nom_matiere ?? 'Matière non spécifiée' }}
                                                            @if($devoir->date_devoir)
                                                                • {{ \Carbon\Carbon::parse($devoir->date_devoir)->format('d/m/Y') }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $devoir->actif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                            {{ $devoir->actif ? 'Actif' : 'Inactif' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Questions et réponses -->
                                            <div class="p-6">
                                                <div class="space-y-6">
                                                    @foreach($devoir->questions as $question)
                                                        <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                                                            <!-- Question -->
                                                            <div class="mb-4">
                                                                <div class="flex items-start justify-between mb-3">
                                                                    <div class="flex-1">
                                                                        <div class="flex items-center gap-2 mb-2">
                                                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-bold">
                                                                                {{ $loop->iteration }}
                                                                            </span>
                                                                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                                                {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                                                            </span>
                                                                            @if($question->points)
                                                                                <span class="text-xs text-gray-500">• {{ $question->points }} point(s)</span>
                                                                            @endif
                                                                        </div>
                                                                        <h4 class="text-base font-semibold text-gray-900 mb-2">{{ $question->question }}</h4>
                                                                        @if($question->image)
                                                                            <div class="mt-2">
                                                                                <img src="{{ asset('storage/' . $question->image) }}" alt="Image de la question" class="max-w-md rounded-lg border border-gray-200">
                                                                            </div>
                                                                        @endif
                                                                        @if($question->type === 'choix_multiple' && is_array($question->options))
                                                                            <div class="mt-3 space-y-2">
                                                                                @foreach($question->options as $option)
                                                                                    <div class="flex items-center gap-2 text-sm">
                                                                                        <div class="w-4 h-4 rounded border-2 {{ isset($option['correcte']) && $option['correcte'] ? 'border-green-500 bg-green-50' : 'border-gray-300' }} flex items-center justify-center">
                                                                                            @if(isset($option['correcte']) && $option['correcte'])
                                                                                                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                                                                </svg>
                                                                                            @endif
                                                                                        </div>
                                                                                        <span class="{{ isset($option['correcte']) && $option['correcte'] ? 'text-green-700 font-medium' : 'text-gray-700' }}">
                                                                                            {{ $option['texte'] ?? '' }}
                                                                                        </span>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Réponses des apprenants -->
                                                            <div class="mt-4 pt-4 border-t border-gray-300">
                                                                <h5 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                                    </svg>
                                                                    Réponses des apprenants
                                                                </h5>
                                                                
                                                                @php
                                                                    // Récupérer les réponses soumises pour cette question
                                                                    $reponsesQuestion = $devoir->reponses->where('devoir_question_id', $question->id)->groupBy('user_id');
                                                                    // Créer un tableau associatif userId => réponse pour faciliter la recherche
                                                                    $reponsesParApprenant = [];
                                                                    foreach($reponsesQuestion as $userId => $reponses) {
                                                                        $reponsesParApprenant[$userId] = $reponses->first();
                                                                    }
                                                                @endphp
                                                                
                                                                @if($apprenants && $apprenants->count() > 0)
                                                                    <div class="space-y-4">
                                                                        @foreach($apprenants as $apprenant)
                                                                            @php
                                                                                $reponse = $reponsesParApprenant[$apprenant->id] ?? null;
                                                                                $aRepondu = $reponse !== null;
                                                                            @endphp
                                                                                <div class="bg-white rounded-lg border border-gray-200 p-4">
                                                                                    <div class="flex items-start justify-between mb-3">
                                                                                        <div class="flex items-center gap-3">
                                                                                            <div class="w-10 h-10 rounded-full overflow-hidden border-2 flex-shrink-0" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); border-color: rgba(255, 255, 255, 0.3);">
                                                                                                @if($apprenant->photo ?? null)
                                                                                                    <img src="{{ asset('storage/' . ($apprenant->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                                                                                @else
                                                                                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-xs">
                                                                                                        {{ strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1)) }}
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                            <div>
                                                                                                <p class="text-sm font-semibold text-gray-900">{{ $apprenant->prenom ?? '' }} {{ $apprenant->nom ?? '' }}</p>
                                                                                                <p class="text-xs text-gray-500">{{ $apprenant->email ?? '' }}</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    @if($aRepondu && $reponse->soumis_le)
                                                                                        <span class="text-xs text-gray-500">
                                                                                            {{ \Carbon\Carbon::parse($reponse->soumis_le)->format('d/m/Y à H:i') }}
                                                                                        </span>
                                                                                    @endif
                                                                                    </div>
                                                                                    
                                                                                    <div class="mt-3 pl-12">
                                                                                    @if($aRepondu)
                                                                                        @if($question->type === 'choix_multiple' && $reponse->reponses_multiple)
                                                                                            <div class="space-y-2">
                                                                                                @foreach($reponse->reponses_multiple as $reponseOption)
                                                                                                    <div class="flex items-center gap-2 text-sm text-gray-700">
                                                                                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                                                        </svg>
                                                                                                        <span>{{ $reponseOption }}</span>
                                                                                                    </div>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @elseif($reponse->reponse)
                                                                                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                                                                                <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $reponse->reponse }}</p>
                                                                                            </div>
                                                                                        @else
                                                                                            <p class="text-sm text-gray-400 italic">Aucune réponse fournie</p>
                                                                                        @endif
                                                                                    @else
                                                                                        <p class="text-sm text-gray-400 italic">Aucune réponse fournie</p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @else
                                                                    <div class="bg-gray-50 rounded-lg p-4 text-center border border-gray-200">
                                                                        <p class="text-sm text-gray-500 italic">Aucun apprenant dans votre classe pour le moment</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        // Cours dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const coursDropdownBtn = document.getElementById('coursDropdownBtn');
            const coursDropdownMenu = document.getElementById('coursDropdownMenu');
            const sidebar = document.getElementById('sidebar');
            let isHovering = false;
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

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!coursDropdownBtn.contains(e.target) && !coursDropdownMenu.contains(e.target)) {
                        coursDropdownMenu.classList.add('hidden');
                    }
                });

                // Monitor sidebar width changes
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

        // Profile dropdown menu
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

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const devoirsGrid = document.getElementById('devoirsGrid');
            
            if (searchInput && devoirsGrid) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const devoirCards = devoirsGrid.querySelectorAll('.devoir-card');
                    
                    devoirCards.forEach(card => {
                        const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                        const description = card.querySelectorAll('p');
                        let descriptionText = '';
                        description.forEach(p => {
                            if (p.textContent) {
                                descriptionText += p.textContent.toLowerCase() + ' ';
                            }
                        });
                        const matiere = card.querySelector('p.text-sm')?.textContent.toLowerCase() || '';
                        
                        if (title.includes(searchTerm) || descriptionText.includes(searchTerm) || matiere.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Paramètres Button
            const parametresBtn = document.getElementById('parametresBtn');
            
            if (parametresBtn) {
                parametresBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = '{{ route('formateur.parametres') }}';
                });
            }
        });
    </script>
@include('components.video-session-notification')</body>
</html>
