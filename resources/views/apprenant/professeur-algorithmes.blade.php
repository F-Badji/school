<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algorithmes - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        nav a[class*="bg-blue"],
        nav a[class*="border-blue"] {
            transition: none !important;
            -webkit-transition: none !important;
            transition-property: none !important;
        }
        /* Empêcher toutes les animations sur les icônes SVG */
        aside nav a svg,
        aside nav a svg * {
            transition: none !important;
            -webkit-transition: none !important;
            animation: none !important;
            -webkit-animation: none !important;
            will-change: auto !important;
        }
        /* Empêcher l'animation lors du changement de classe */
        aside nav a.bg-blue-600\/20 svg,
        aside nav a.bg-blue-600\/20 svg * {
            transition: none !important;
            -webkit-transition: none !important;
            animation: none !important;
            -webkit-animation: none !important;
        }
        /* Empêcher TOUTES les transitions sur les liens de navigation */
        aside nav a.nav-link,
        aside nav a.nav-link *,
        aside nav a.nav-link svg,
        aside nav a.nav-link svg *,
        aside nav a.nav-link span {
            transition: none !important;
            -webkit-transition: none !important;
            transition-duration: 0s !important;
            -webkit-transition-duration: 0s !important;
            animation: none !important;
            -webkit-animation: none !important;
        }
        aside nav a.nav-link:hover {
            transition: none !important;
            -webkit-transition: none !important;
        }
        .ql-toolbar {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem 0.5rem 0 0;
            background: white;
        }
        .ql-container {
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 0.5rem 0.5rem;
            min-height: 200px;
            font-size: 14px;
        }
        .ql-editor {
            min-height: 200px;
            font-size: 16px;
            line-height: 1.6;
        }
        #description-editor .ql-editor {
            font-size: 16px;
            line-height: 1.6;
        }
        /* Slider avec couleur purple */
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            cursor: pointer;
        }
        input[type="range"]::-webkit-slider-track {
            background: #e5e7eb;
            height: 8px;
            border-radius: 4px;
        }
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            background: #9333ea;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-top: -6px;
        }
        input[type="range"]::-moz-range-track {
            background: #e5e7eb;
            height: 8px;
            border-radius: 4px;
        }
        input[type="range"]::-moz-range-thumb {
            background: #9333ea;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
        input[type="range"]::-moz-range-progress {
            background: #9333ea;
            height: 8px;
            border-radius: 4px;
        }
        /* Animation de rebond pour "En cours" */
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .bounce-text {
            animation: bounce 1s ease-in-out infinite;
            display: inline-block;
            font-weight: 600;
            color: #dc2626;
            font-size: 1.125rem;
        }
</style>
    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
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
                    $isDashboard = $currentRoute === 'apprenant.dashboard';
                    $isCours = $currentRoute === 'apprenant.cours';
                    $isProfesseurs = $currentRoute === 'apprenant.professeurs';
                    $isNotes = $currentRoute === 'account.notes';
                    $isDevoirs = $currentRoute === 'apprenant.devoirs';
                    $isExamens = $currentRoute === 'apprenant.examens';
                    $isCalendrier = $currentRoute === 'apprenant.calendrier';
                @endphp
                <a href="{{ route('apprenant.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isDashboard ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Tableau de bord</span>
                </a>
                <div class="w-full">
                    <a href="{{ route('apprenant.cours') }}" id="coursDropdownBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link cursor-pointer" style="transition: none !important; -webkit-transition: none !important; {{ $isCours || $isNotes || $isDevoirs || $isExamens || $isCalendrier ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
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
                        <a href="{{ route('apprenant.cours') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important;">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mes cours</span>
                        </a>
                        <a href="{{ route('account.notes') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isNotes ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mes notes</span>
                        </a>
                        <a href="{{ route('apprenant.devoirs') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isDevoirs ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mes devoirs</span>
                        </a>
                        <a href="{{ route('apprenant.examens') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isExamens ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mes examens</span>
                        </a>
                        <a href="{{ route('apprenant.calendrier') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important;">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="sidebar-text font-medium text-sm" style="transition: none !important; -webkit-transition: none !important;">Mon calendrier</span>
                        </a>
                    </div>
                </div>
                <a href="{{ route('apprenant.professeurs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isProfesseurs ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Mes professeurs</span>
                </a>
                <a href="{{ route('apprenant.messages') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg  relative">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Messages</span>
                    @if(isset($sidebarUnreadMessagesCount) && $sidebarUnreadMessagesCount > 0)
                        <span class="absolute right-4 top-2.5 w-6 h-6 bg-white rounded-full flex items-center justify-center text-xs font-bold text-gray-900 sidebar-unread-badge" id="sidebarUnreadBadge">{{ $sidebarUnreadMessagesCount }}</span>
                    @endif
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Analyses</span>
                </a>
            </nav>

            <!-- Bottom Section -->
            <div class="w-full px-2 space-y-2 border-t border-gray-700/50 pt-4">
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Paramètres</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
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
                            <input type="text" placeholder="Rechercher" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Breadcrumb -->
                    <div class="flex-1 flex items-center justify-center">
                        <nav class="flex items-center space-x-2 text-sm text-gray-600">
                        </nav>
                    </div>

                    <!-- Notifications & Profile -->
                    <div class="flex items-center gap-4">
                        <button class="p-2 text-gray-600 hover:text-gray-900 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </button>
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
            <main class="flex-1 overflow-y-auto bg-white">
                <div class="max-w-7xl mx-auto px-6 py-6">
                    <!-- Page Title -->
                    <div class="mb-6 mt-8">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $coursPrincipal->titre ?? 'Algorithmes' }}</h1>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left Column - Main Content -->
                        <div class="lg:col-span-2">
                            <!-- Title and Actions -->
                            <div class="mb-6">
                    </div>

                            <!-- Basic info Section -->
                            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations de base</h2>
                                
                                <!-- Titre du cours Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Titre du cours *</label>
                                    <input type="text" value="{{ $coursPrincipal->titre ?? '' }}" readonly class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50 cursor-not-allowed">
                                </div>

                                <!-- Description Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <div id="description-editor" style="height: 200px; pointer-events: none;">
                                        <div class="ql-editor text-base" data-placeholder="Entrer la description..." style="pointer-events: none; font-size: 16px; line-height: 1.6;">
                                            @if($coursPrincipal && $coursPrincipal->description)
                                                {!! $coursPrincipal->description !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Matière Field -->
                                @php
                                    $matiereNom = '';
                                    if ($coursPrincipal && $coursPrincipal->formateur) {
                                        $matiere = $coursPrincipal->formateur->matieres()->first();
                                        $matiereNom = $matiere ? ($matiere->nom_matiere ?? '') : '';
                                    }
                                @endphp
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Matière *</label>
                                    <input type="text" value="{{ $matiereNom }}" readonly class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50 cursor-not-allowed">
                                </div>

                                <!-- Filière Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Filière *</label>
                                    <input type="text" value="{{ $coursPrincipal->filiere ?? '' }}" readonly class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50 cursor-not-allowed">
                                </div>

                                <!-- Niveau d'étude Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Niveau d'étude *</label>
                                    <input type="text" value="{{ $coursPrincipal->niveau_etude ?? '' }}" readonly class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50 cursor-not-allowed">
                                </div>

                                <!-- Durée Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Durée</label>
                                    <input type="text" value="{{ $coursPrincipal->duree ?? '' }}" readonly class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50 cursor-not-allowed">
                                </div>

                                <!-- Ordre d'affichage Field -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ordre d'affichage</label>
                                    <input type="text" value="{{ $coursPrincipal->ordre ?? '' }}" readonly class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-gray-50 cursor-not-allowed">
                                </div>

                                <!-- Cover Image -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                                    <div class="relative w-full h-64 bg-gray-100 rounded-lg overflow-hidden border-2 border-dashed border-gray-300">
                                        @if($coursPrincipal && $coursPrincipal->image_couverture)
                                            @php
                                                $imagePath = 'storage/' . $coursPrincipal->image_couverture;
                                                $fullPath = public_path($imagePath);
                                                $imageExists = file_exists($fullPath);
                                                \Log::info('🔍 [VUE PROFESSEUR ALGORITHMES] Affichage image couverture', [
                                                    'cours_id' => $coursPrincipal->id,
                                                    'image_couverture_db' => $coursPrincipal->image_couverture,
                                                    'image_path' => $imagePath,
                                                    'full_path' => $fullPath,
                                                    'file_exists' => $imageExists,
                                                ]);
                                            @endphp
                                            @if($imageExists)
                                                <img src="{{ asset($imagePath) }}" alt="Couverture" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <div class="text-center">
                                                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <p class="text-sm">Image non trouvée</p>
                                                        <p class="text-xs text-gray-500 mt-1">Chemin : {{ $coursPrincipal->image_couverture }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <div class="text-center">
                                                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <p class="text-sm">Aucune image</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-lg font-semibold text-gray-900">Contenue des cours</h2>
                        </div>
                        
                                <!-- Week Sections -->
                                <div class="space-y-3">
                                    @php
                                        \Log::info('🔍 [VUE PROFESSEUR ALGORITHMES] Données reçues dans la vue', [
                                            'cours_principal_exists' => isset($coursPrincipal) && $coursPrincipal !== null,
                                            'cours_principal_id' => $coursPrincipal->id ?? 'N/A',
                                            'cours_principal_titre' => $coursPrincipal->titre ?? 'N/A',
                                            'cours_contenu_exists' => isset($coursPrincipal) && $coursPrincipal && isset($coursPrincipal->contenu),
                                            'cours_contenu_is_array' => isset($coursPrincipal) && $coursPrincipal && is_array($coursPrincipal->contenu),
                                            'cours_contenu_count' => (isset($coursPrincipal) && $coursPrincipal && $coursPrincipal->contenu && is_array($coursPrincipal->contenu)) ? count($coursPrincipal->contenu) : 0,
                                        ]);
                                    @endphp
                                    @if($coursPrincipal && $coursPrincipal->contenu && is_array($coursPrincipal->contenu) && count($coursPrincipal->contenu) > 0)
                                        @foreach($coursPrincipal->contenu as $index => $section)
                                            @php
                                                \Log::info('🔍 [VUE PROFESSEUR ALGORITHMES] Section en cours de traitement', [
                                                    'section_index' => $index,
                                                    'section_titre' => $section['titre'] ?? 'N/A',
                                                    'section_sous_titres' => $section['sous_titres'] ?? [],
                                                    'section_sous_titres_count' => isset($section['sous_titres']) ? (is_array($section['sous_titres']) ? count($section['sous_titres']) : 1) : 0,
                                                    'section_description' => !empty($section['description']) ? 'PRESENT' : 'VIDE',
                                                    'section_lien_video' => $section['lien_video'] ?? 'N/A',
                                                    'section_fichier_pdf' => $section['fichier_pdf'] ?? 'N/A',
                                                ]);
                                            @endphp
                                            @php
                                                $sectionId = 'section-' . $index;
                                                $sectionTitre = $section['titre'] ?? 'Section ' . ($index + 1);
                                                
                                                // Récupérer les sous-titres avec plusieurs formats possibles
                                                $sectionSousTitres = [];
                                                
                                                // Vérifier d'abord si sous_titres existe et n'est pas null
                                                // isset() retourne true même si la valeur est null, donc on doit aussi vérifier !== null
                                                if (isset($section['sous_titres']) && $section['sous_titres'] !== null) {
                                                    if (is_array($section['sous_titres'])) {
                                                        // Filtrer les valeurs vides mais garder les valeurs null pour le debug
                                                        $sectionSousTitres = array_values(array_filter($section['sous_titres'], function($item) {
                                                            return $item !== null && $item !== '';
                                                        }));
                                                    } elseif (is_string($section['sous_titres']) && trim($section['sous_titres']) !== '') {
                                                        $sectionSousTitres = [trim($section['sous_titres'])];
                                                    }
                                                } elseif (isset($section['sous_titre']) && $section['sous_titre'] !== null && trim($section['sous_titre']) !== '') {
                                                    // Compatibilité avec l'ancien format (un seul sous-titre)
                                                    $sectionSousTitres = [trim($section['sous_titre'])];
                                                }
                                                
                                                // Log pour déboguer
                                                \Log::info('🔍 [VUE PROFESSEUR ALGORITHMES] Récupération des sous-titres', [
                                                    'section_index' => $index,
                                                    'section_titre' => $sectionTitre,
                                                    'has_sous_titres_key' => isset($section['sous_titres']),
                                                    'sous_titres_value' => $section['sous_titres'] ?? 'N/A',
                                                    'sous_titres_is_null' => isset($section['sous_titres']) && $section['sous_titres'] === null,
                                                    'sous_titres_is_array' => isset($section['sous_titres']) && is_array($section['sous_titres']),
                                                    'sectionSousTitres_final' => $sectionSousTitres,
                                                    'sectionSousTitres_count' => count($sectionSousTitres),
                                                ]);
                                                
                                                // Log pour déboguer
                                                \Log::info('🔍 [VUE PROFESSEUR ALGORITHMES] Traitement des sous-titres', [
                                                    'section_index' => $index,
                                                    'section_titre' => $sectionTitre,
                                                    'raw_section_keys' => array_keys($section),
                                                    'raw_sous_titres' => $section['sous_titres'] ?? 'N/A',
                                                    'raw_sous_titres_type' => isset($section['sous_titres']) ? gettype($section['sous_titres']) : 'N/A',
                                                    'raw_sous_titre' => $section['sous_titre'] ?? 'N/A',
                                                    'sectionSousTitres_final' => $sectionSousTitres,
                                                    'sectionSousTitres_count' => count($sectionSousTitres),
                                                    'is_empty' => empty($sectionSousTitres),
                                                    'section_full' => json_encode($section, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                                                ]);
                                                
                                                $sectionDescription = $section['description'] ?? '';
                                            @endphp
                                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                <div class="flex items-center gap-3 p-4 hover:bg-gray-50 transition-colors">
                                                    <button type="button" onclick="toggleWeekContent('{{ $sectionId }}')" class="flex-1 flex items-center gap-3 cursor-pointer text-left">
                                                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                                                        </svg>
                                                        <svg id="{{ $sectionId }}-icon" class="w-5 h-5 text-gray-400 transition-transform duration-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                        <span class="flex-1 text-sm font-semibold text-gray-900">{{ $sectionTitre }}</span>
                                                    </button>
                                                    <a href="{{ route('apprenant.cours-editeur', ['cours_id' => $coursPrincipal->id, 'section' => $index]) }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors flex-shrink-0 inline-block">
                                                        Suivre
                                                    </a>
                                                </div>
                                                <div id="{{ $sectionId }}-content" class="hidden border-t border-gray-200 bg-gray-50">
                                                    <div class="p-4 space-y-3">
                                                        <!-- Sous-titres affichés comme des cartes individuelles -->
                                                        @if(!empty($sectionSousTitres) && count($sectionSousTitres) > 0)
                                                            @foreach($sectionSousTitres as $sousTitreIndex => $sousTitre)
                                                                @php
                                                                    // Nettoyer le sous-titre
                                                                    $sousTitre = is_string($sousTitre) ? trim($sousTitre) : $sousTitre;
                                                                @endphp
                                                                @if(!empty($sousTitre) && trim($sousTitre) !== '')
                                                                @php
                                                                    // Utiliser la durée du cours si disponible, sinon 4min par défaut
                                                                    $duree = $coursPrincipal && $coursPrincipal->duree ? $coursPrincipal->duree : '4min';
                                                                @endphp
                                                                <div class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">
                                                                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="flex-1 min-w-0">
                                                                        <p class="text-sm font-medium text-gray-900">{{ $sousTitre }}</p>
                                                                    </div>
                                                                    <span class="text-xs font-medium text-gray-600 whitespace-nowrap">{{ $duree }}</span>
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @php
                                                                \Log::warning('⚠️ [VUE PROFESSEUR ALGORITHMES] Aucun sous-titre à afficher', [
                                                                    'section_index' => $index,
                                                                    'section_titre' => $sectionTitre,
                                                                    'sectionSousTitres' => $sectionSousTitres,
                                                                    'sectionSousTitres_count' => count($sectionSousTitres),
                                                                    'section_raw' => $section,
                                                                ]);
                                                            @endphp
                                                            <div class="text-sm text-gray-500 italic">Aucun sous-titre disponible pour cette section.</div>
                                                        @endif
                                                        @if(!empty($section['fichier_pdf']))
                                                            <div>
                                                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Fichier PDF du cours (à télécharger) :</h4>
                                                                <a href="{{ asset('storage/' . $section['fichier_pdf']) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                    </svg>
                                                                    Télécharger le PDF
                                                                </a>
                                                            </div>
                                                        @endif
                                                        {{-- Section Questions du quiz masquée
                                                        @if($coursPrincipal && $coursPrincipal->id)
                                                            @php
                                                                $sectionQuestions = $coursPrincipal->questions()->where('section_index', $index)->orderBy('ordre')->get();
                                                            @endphp
                                                            @if($sectionQuestions->isNotEmpty())
                                                                <div class="mt-4 pt-4 border-t border-gray-300">
                                                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Questions du quiz :</h4>
                                                                    <div class="space-y-3">
                                                                        @foreach($sectionQuestions as $question)
                                                                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                                                                <div class="flex items-start justify-between mb-2">
                                                                                    <p class="text-sm font-medium text-gray-900">{{ $question->question }}</p>
                                                                                    <span class="text-xs text-gray-500">{{ $question->points ?? 0 }} points</span>
                                                                                </div>
                                                                                @if($question->type === 'choix_multiple' && is_array($question->options))
                                                                                    <ul class="mt-2 space-y-1">
                                                                                        @foreach($question->options as $option)
                                                                                            <li class="text-xs text-gray-600 flex items-center gap-2">
                                                                                                <span class="w-2 h-2 rounded-full {{ $option === $question->reponse_correcte ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                                                                                {{ $option }}
                                                                                                @if($option === $question->reponse_correcte)
                                                                                                    <span class="text-green-600 text-xs">(Correcte)</span>
                                                                                                @endif
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                                @if($question->explication)
                                                                                    <p class="mt-2 text-xs text-gray-500 italic">{{ $question->explication }}</p>
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Message si aucun cours n'est trouvé -->
                                        <div class="text-center py-12">
                                            <p class="text-gray-500 text-lg">Aucun contenu de cours disponible pour le moment.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="space-y-6">
                                <!-- Preview Course -->
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Aperçu du cours</h3>
                                    <p class="text-sm text-gray-600 mb-4">Voir comment les autres verront votre cours.</p>
                                    @php
                                        $isSessionActive = isset($sessionStatut) && $sessionStatut === 'en_cours';
                                        $isButtonEnabled = isset($coursPrincipal) && $coursPrincipal && $coursPrincipal->id && $isSessionActive;
                                    @endphp
                                    @if($isButtonEnabled)
                                        <a href="{{ route('apprenant.video-conference.join', ['coursId' => $coursPrincipal->id]) }}" id="acceder-cours-btn" class="w-full px-4 py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors font-medium inline-block text-center">
                                            Accéder au cours
                                        </a>
                                    @else
                                        <button id="acceder-cours-btn" class="w-full px-4 py-2.5 bg-gray-400 text-white rounded-lg cursor-not-allowed transition-colors font-medium" disabled>
                                            Accéder au cours
                                        </button>
                                    @endif
                                                </div>

                                <!-- Course Status -->
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut du cours</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Algorithmes</label>
                                            <div class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 flex items-center">
                                                @php
                                                    $statutText = 'Bientôt disponible';
                                                    $statutClass = 'text-gray-600';
                                                    $bounceClass = '';
                                                    if (isset($sessionStatut)) {
                                                        if ($sessionStatut === 'en_cours') {
                                                            $statutText = 'En cours';
                                                            $statutClass = 'text-green-600 font-semibold';
                                                            $bounceClass = 'bounce-text';
                                                        } elseif ($sessionStatut === 'termine') {
                                                            $statutText = 'Terminé';
                                                            $statutClass = 'text-gray-500';
                                                        }
                                                    }
                                                @endphp
                                                <span id="session-statut-text" class="{{ $statutClass }} {{ $bounceClass }}">{{ $statutText }}</span>
                                            </div>
                                                </div>
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="hideCourse" class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                            <label for="hideCourse" class="text-sm text-gray-700">Masquer ce cours</label>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                        </div>
                                                    </div>
                                                </div>

                                <!-- Course Level -->
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Classe Licence 1</h3>
                                    <div class="space-y-2 max-h-96 overflow-y-auto">
                                        @if(isset($apprenantsLicence1) && $apprenantsLicence1->count() > 0)
                                            @foreach($apprenantsLicence1 as $apprenant)
                                                @php
                                                    // Déterminer si l'apprenant est en ligne
                                                    $isOnline = false;
                                                    if ($apprenant->last_seen) {
                                                        $lastSeen = \Carbon\Carbon::parse($apprenant->last_seen);
                                                        $isOnline = $lastSeen->isAfter(\Carbon\Carbon::now()->subMinutes(5));
                                                    }
                                                    // Vérifier si c'est l'utilisateur connecté
                                                    $isCurrentUser = ($apprenant->id ?? null) === ($user->id ?? null);
                                                @endphp
                                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                                        @if($apprenant->photo ?? null)
                                                            <img src="{{ asset('storage/' . ($apprenant->photo ?? '')) }}" alt="Photo" class="w-full h-full rounded-full object-cover">
                                                        @else
                                                            @if($isCurrentUser)
                                                                M
                                                            @else
                                                                {{ strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1)) }}
                                                            @endif
                                                        @endif
                                    </div>
                                                    <div class="flex-1 min-w-0 flex items-center justify-between gap-2">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            @if($isCurrentUser)
                                                                Moi
                                                            @else
                                                                {{ ($apprenant->prenom ?? '') . ' ' . ($apprenant->nom ?? '') }}
                                                            @endif
                                                        </p>
                                                        @if($isOnline)
                                                            <span class="text-xs font-semibold text-green-600 whitespace-nowrap flex-shrink-0">En ligne</span>
                                                        @else
                                                            <span class="text-xs font-semibold text-red-600 whitespace-nowrap flex-shrink-0">Hors ligne</span>
                                                        @endif
                                            </div>
                                        </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500 text-center py-4">Aucun apprenant trouvé pour cette classe.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Initialize Quill Editor (read-only for apprenants)
        var quill = new Quill('#description-editor', {
            theme: 'snow',
            readOnly: true,
            modules: {
                toolbar: false
                }
            });

            // Prevent flash animation on page load - execute immediately
            (function() {
                const style = document.createElement('style');
                style.textContent = `
                    aside nav a,
                    aside nav a *,
                    aside nav a svg,
                    aside nav a svg *,
                    aside nav a span {
                        transition: none !important;
                        -webkit-transition: none !important;
                        animation: none !important;
                        -webkit-animation: none !important;
                    }
                `;
                document.head.insertBefore(style, document.head.firstChild);
            })();

            // Prevent flash animation on page load
            document.addEventListener('DOMContentLoaded', function() {
                const navLinks = document.querySelectorAll('aside nav a');
                navLinks.forEach(link => {
                    link.style.setProperty('transition', 'none', 'important');
                    link.style.setProperty('-webkit-transition', 'none', 'important');
                    const svg = link.querySelector('svg');
                    const span = link.querySelector('span');
                    if (svg) {
                        svg.style.setProperty('transition', 'none', 'important');
                        svg.style.setProperty('-webkit-transition', 'none', 'important');
                    }
                    if (span) {
                        span.style.setProperty('transition', 'none', 'important');
                        span.style.setProperty('-webkit-transition', 'none', 'important');
                    }
                });
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

                profileDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Cours dropdown menu
            const coursDropdownBtn = document.getElementById('coursDropdownBtn');
            const coursDropdownMenu = document.getElementById('coursDropdownMenu');
            const sidebar = document.getElementById('sidebar');

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

                coursDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                // Fermer le menu déroulant quand le sidebar se ferme (largeur réduite)
                if (sidebar) {
                    let lastSidebarWidth = sidebar.offsetWidth;
                    
                    // Vérifier périodiquement si le sidebar est fermé
                    setInterval(function() {
                        const currentSidebarWidth = sidebar.offsetWidth;
                        
                        // Si la largeur a changé et le sidebar est maintenant fermé (≤ 85px)
                        if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                            coursDropdownMenu.classList.add('hidden');
                        }
                        
                        lastSidebarWidth = currentSidebarWidth;
                    }, 100);
                }
            }
        });

        // Toggle week content dropdown
        function toggleWeekContent(weekId) {
            const content = document.getElementById(weekId + '-content');
            const icon = document.getElementById(weekId + '-icon');
            
            if (content && icon) {
                const isHidden = content.classList.contains('hidden');
                
                if (isHidden) {
                    content.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    content.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            }
        }
    </script>
</body>
</html>


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

            // Cours dropdown menu
            const coursDropdownBtn = document.getElementById('coursDropdownBtn');
            const coursDropdownMenu = document.getElementById('coursDropdownMenu');
            const sidebar = document.getElementById('sidebar');

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

                coursDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                // Fermer le menu déroulant quand le sidebar se ferme (largeur réduite)
                if (sidebar) {
                    let lastSidebarWidth = sidebar.offsetWidth;
                    
                    // Vérifier périodiquement si le sidebar est fermé
                    setInterval(function() {
                        const currentSidebarWidth = sidebar.offsetWidth;
                        
                        // Si la largeur a changé et le sidebar est maintenant fermé (≤ 85px)
                        if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                            coursDropdownMenu.classList.add('hidden');
                        }
                        
                        lastSidebarWidth = currentSidebarWidth;
                    }, 100);
                }
            }
        });

        // Toggle week content dropdown
        function toggleWeekContent(weekId) {
            const content = document.getElementById(weekId + '-content');
            const icon = document.getElementById(weekId + '-icon');
            
            if (content && icon) {
                const isHidden = content.classList.contains('hidden');
                
                if (isHidden) {
                    content.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    content.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            }
        }

        // Vérifier le statut de la session vidéo en temps réel
        @if(isset($coursPrincipal) && $coursPrincipal && $coursPrincipal->id)
        (function() {
            const coursId = {{ $coursPrincipal->id }};
            const accederBtn = document.getElementById('acceder-cours-btn');
            const statutText = document.getElementById('session-statut-text');
            
            async function checkSessionStatus() {
                try {
                    const response = await fetch(`/apprenant/video-conference/check-session-status/${coursId}`, {
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
                    
                    if (data.success) {
                        // Mettre à jour le statut
                        if (statutText) {
                            if (data.statut === 'en_cours') {
                                statutText.textContent = 'En cours';
                                statutText.className = 'text-green-600 font-semibold bounce-text';
                            } else if (data.statut === 'termine') {
                                statutText.textContent = 'Terminé';
                                statutText.className = 'text-gray-500';
                            } else {
                                statutText.textContent = 'Bientôt disponible';
                                statutText.className = 'text-gray-600';
                            }
                        }
                        
                        // Mettre à jour le bouton
                        if (accederBtn) {
                            if (data.statut === 'en_cours') {
                                // Déverrouiller le bouton
                                if (accederBtn.tagName === 'BUTTON') {
                                    const newLink = document.createElement('a');
                                    newLink.id = 'acceder-cours-btn';
                                    newLink.href = `{{ route('apprenant.video-conference.join', ['coursId' => $coursPrincipal->id]) }}`;
                                    newLink.className = 'w-full px-4 py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors font-medium inline-block text-center';
                                    newLink.textContent = 'Accéder au cours';
                                    accederBtn.parentNode.replaceChild(newLink, accederBtn);
                                } else {
                                    accederBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                                    accederBtn.classList.add('bg-gray-900', 'hover:bg-gray-800');
                                    accederBtn.removeAttribute('disabled');
                                }
                            } else {
                                // Verrouiller le bouton
                                if (accederBtn.tagName === 'A') {
                                    const newButton = document.createElement('button');
                                    newButton.id = 'acceder-cours-btn';
                                    newButton.className = 'w-full px-4 py-2.5 bg-gray-400 text-white rounded-lg cursor-not-allowed transition-colors font-medium';
                                    newButton.textContent = 'Accéder au cours';
                                    newButton.disabled = true;
                                    accederBtn.parentNode.replaceChild(newButton, accederBtn);
                                } else {
                                    accederBtn.classList.remove('bg-gray-900', 'hover:bg-gray-800');
                                    accederBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                                    accederBtn.disabled = true;
                                }
                            }
                        }
                    }
                } catch (error) {
                    console.error('Erreur lors de la vérification du statut de la session:', error);
                }
            }
            
            // Vérifier toutes les 5 secondes
            setInterval(checkSessionStatus, 5000);
            // Vérifier immédiatement
            checkSessionStatus();
        })();
        @endif
    </script>
</body>
</html>


