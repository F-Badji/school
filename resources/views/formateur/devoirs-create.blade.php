<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($devoir) ? 'Modifier le devoir' : 'Nouveau devoir' }} - BJ Academie</title>
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
                    $isDevoirs = $currentRoute === 'formateur.devoirs' || $currentRoute === 'formateur.devoirs.create' || $currentRoute === 'formateur.devoirs.edit';
                    $isExamens = $currentRoute === 'formateur.examens' || $currentRoute === 'formateur.examens.create' || $currentRoute === 'formateur.examens.edit';
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
                        
                    </div>
                </div>
                <a href="{{ route('formateur.devoirs') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isDevoirs ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="transition: none !important; -webkit-transition: none !important;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="sidebar-text font-medium" style="transition: none !important; -webkit-transition: none !important;">Devoirs</span>
                </a>
                <a href="{{ route('formateur.examens') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link" style="transition: none !important; -webkit-transition: none !important; {{ $isExamens ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
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
                        <span class="absolute right-4 top-2.5 w-6 h-6 bg-white rounded-full flex items-center justify-center text-xs font-bold text-gray-900 sidebar-unread-badge" id="sidebarUnreadBadge">{{ $sidebarUnreadMessagesCount }}</span>
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
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link">
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
                    <!-- Breadcrumb -->
                    <div class="flex-1 flex items-center">
                        <nav class="flex items-center space-x-2 text-sm text-gray-600">
                            <a href="{{ route('formateur.dashboard') }}" class="hover:text-gray-900">Tableau de bord</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <a href="{{ route('formateur.devoirs') }}" class="hover:text-gray-900">Mes devoirs</a>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                            <span class="text-gray-900 font-medium">{{ isset($devoir) ? 'Modifier' : 'Nouveau devoir' }}</span>
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
            <main class="flex-1 overflow-y-auto bg-white">
                <div class="max-w-7xl mx-auto px-6 py-6">
                    <!-- Page Title -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900">{{ isset($devoir) ? 'Modifier le devoir' : 'Nouveau devoir' }}</h1>
                    </div>
                    
                    <form action="{{ isset($devoir) ? route('formateur.devoirs.update', $devoir->id) : route('formateur.devoirs.store') }}" method="POST" id="devoirForm" enctype="multipart/form-data">
                        @csrf
                        @if(isset($devoir))
                            @method('PUT')
                        @endif
                        
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Column - Main Content -->
                            <div class="lg:col-span-2">
                                <!-- Title and Actions -->
                                <div class="flex items-center justify-end mb-6">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('formateur.devoirs') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                                            Annuler
                                        </a>
                                        <button type="submit" class="px-4 py-2 text-white rounded-lg transition-colors font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>

                                <!-- Basic info Section -->
                                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations de base</h2>
                                    
                                    <!-- Title Field -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre du devoir *</label>
                                        <input type="text" name="titre" value="{{ old('titre', isset($devoir) ? ($devoir->titre ?? '') : '') }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: Devoir sur les algorithmes">
                                        @error('titre')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Description Field -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                        <textarea name="description" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Description du devoir...">{{ old('description', isset($devoir) ? ($devoir->description ?? '') : '') }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Matière Field -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Matière</label>
                                        <select name="matiere_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Sélectionner une matière</option>
                                            @foreach($matieres as $matiere)
                                                <option value="{{ $matiere->id }}" {{ old('matiere_id', isset($devoir) ? ($devoir->matiere_id ?? '') : '') == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom_matiere }}</option>
                                            @endforeach
                                        </select>
                                        @error('matiere_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Date devoir Field -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Date du devoir</label>
                                        <input type="date" name="date_devoir" value="{{ old('date_devoir', isset($devoir) && $devoir->date_devoir ? $devoir->date_devoir->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        @error('date_devoir')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Heure début et fin Fields -->
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Heure de début</label>
                                            <input type="time" name="heure_debut" value="{{ old('heure_debut', isset($devoir) ? ($devoir->heure_debut ?? '') : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('heure_debut')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Heure de fin</label>
                                            <input type="time" name="heure_fin" value="{{ old('heure_fin', isset($devoir) ? ($devoir->heure_fin ?? '') : '') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('heure_fin')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Points total Field -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Points total</label>
                                        <input type="number" name="points_total" value="{{ old('points_total', isset($devoir) ? ($devoir->points_total ?? 20) : 20) }}" min="1" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="20">
                                        @error('points_total')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Questions Section -->
                                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h2 class="text-lg font-semibold text-gray-900">Questions du devoir</h2>
                                        <button type="button" onclick="addQuestion()" class="px-4 py-2 text-white rounded-lg transition-colors text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                            + Ajouter une question
                                        </button>
                                    </div>
                                    
                                    <!-- Questions Container -->
                                    <div id="questions-container" class="space-y-3">
                                        @if(isset($devoir) && isset($devoir->questions) && $devoir->questions->count() > 0)
                                            @foreach($devoir->questions as $question)
                                                @include('formateur.partials.devoir-question-item', ['question' => $question, 'questionIndex' => $loop->index])
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- Code de sécurité Section -->
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Code de sécurité</h2>
                                    <p class="text-sm text-gray-600 mb-4">Définissez un code à 6 chiffres pour sécuriser l'interface du devoir. Les apprenants devront entrer ce code pour déverrouiller l'interface pendant le devoir.</p>
                                    
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Code de sécurité (6 chiffres) *</label>
                                        <div class="flex items-center gap-3">
                                            <input type="text" name="code_securite" id="codeSecurite" value="{{ old('code_securite', isset($devoir) ? ($devoir->code_securite ?? '') : '') }}" maxlength="6" pattern="[0-9]{6}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl font-mono tracking-widest" placeholder="000000">
                                            <button type="button" onclick="generateCode()" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-medium whitespace-nowrap">
                                                Générer
                                            </button>
                                        </div>
                                        @error('code_securite')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-2 text-xs text-gray-500">Le code doit contenir exactement 6 chiffres.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Sidebar -->
                            <div class="lg:col-span-1">
                                <div class="space-y-6">
                                    <!-- Devoir Info -->
                                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations</h3>
                                        <div class="space-y-3 text-sm">
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-600">Créé le:</span>
                                                <span class="text-gray-900 font-medium">{{ isset($devoir) ? $devoir->created_at->format('d/m/Y') : 'Nouveau' }}</span>
                                            </div>
                                            @if(isset($devoir))
                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-600">Modifié le:</span>
                                                    <span class="text-gray-900 font-medium">{{ $devoir->updated_at->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <span class="text-gray-600">Questions:</span>
                                                    <span class="text-gray-900 font-medium">{{ isset($devoir->questions) ? $devoir->questions->count() : 0 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
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

        // Question Management
        let questionCounter = {{ isset($devoir) && isset($devoir->questions) ? $devoir->questions->count() : 0 }};

        function addQuestion() {
            const container = document.getElementById('questions-container');
            const questionIndex = questionCounter++;
            
            const questionHtml = `
                <div class="question-item bg-white border border-gray-200 rounded-lg p-4 mb-3" data-question-index="${questionIndex}">
                    <div class="flex items-start gap-3">
                        <div class="cursor-move mt-2" title="Glisser pour réorganiser">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                            </svg>
                        </div>
                        <div class="flex-1 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded">Question ${questionIndex + 1}</span>
                                    <select name="questions[${questionIndex}][type]" class="text-sm border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="updateQuestionType(this, ${questionIndex})">
                                        <option value="vrai_faux">Vrai/Faux</option>
                                        <option value="choix_multiple">Choix multiple</option>
                                        <option value="texte_libre">Texte libre</option>
                                        <option value="image">Image</option>
                                        <option value="numerique">Numérique</option>
                                    </select>
                                </div>
                                <button type="button" onclick="removeQuestion(this)" class="text-red-600 hover:text-red-800 text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <textarea name="questions[${questionIndex}][question]" rows="2" placeholder="Entrez votre question..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required></textarea>
                            </div>
                            <div class="question-type-fields" data-question-type="vrai_faux">
                                <div class="vrai_faux-fields">
                                    <div class="flex gap-4">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="questions[${questionIndex}][reponse_vrai_faux]" value="true" class="text-blue-600">
                                            <span class="text-sm">Vrai</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="questions[${questionIndex}][reponse_vrai_faux]" value="false" class="text-blue-600">
                                            <span class="text-sm">Faux</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="choix_multiple-fields" style="display: none;">
                                    <div id="options-container-${questionIndex}" class="space-y-2"></div>
                                    <button type="button" onclick="addOption(${questionIndex})" class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Ajouter une option</button>
                                </div>
                                <div class="texte_libre-fields" style="display: none;">
                                    <textarea name="questions[${questionIndex}][reponse_texte_libre]" rows="3" placeholder="Réponse attendue (optionnel)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                                </div>
                                <div class="image-fields" style="display: none;">
                                    <input type="file" name="questions[${questionIndex}][image_file]" accept="image/*" class="text-sm mb-2" onchange="previewQuestionImage(this, ${questionIndex})">
                                    <div id="question-image-preview-new-${questionIndex}" class="mt-2 hidden">
                                        <img src="" alt="Preview" class="max-w-xs rounded-lg border border-gray-300">
                                    </div>
                                    <textarea name="questions[${questionIndex}][reponse_image]" rows="2" placeholder="Réponse attendue pour cette image" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"></textarea>
                                </div>
                                <div class="numerique-fields" style="display: none;">
                                    <input type="number" step="any" name="questions[${questionIndex}][reponse_numerique]" placeholder="Réponse numérique attendue" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Points</label>
                                    <input type="number" name="questions[${questionIndex}][points]" value="1" min="1" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Explication (optionnel)</label>
                                    <input type="text" name="questions[${questionIndex}][explication]" placeholder="Explication de la réponse" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', questionHtml);
            initializeQuestionSortable();
        }
        
        function removeQuestion(button) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette question ?')) {
                button.closest('.question-item').remove();
                updateQuestionNumbers();
            }
        }
        
        function updateQuestionType(select, questionIndex) {
            const questionItem = select.closest('.question-item');
            const typeFields = questionItem.querySelector('.question-type-fields');
            const selectedType = select.value;
            
            // Hide all type-specific fields
            typeFields.querySelectorAll('.vrai_faux-fields, .choix_multiple-fields, .texte_libre-fields, .image-fields, .numerique-fields').forEach(field => {
                field.style.display = 'none';
            });
            
            // Show selected type field
            const selectedField = typeFields.querySelector(`.${selectedType}-fields`);
            if (selectedField) {
                selectedField.style.display = 'block';
            }
            
            // If choix_multiple and no options exist, add two
            if (selectedType === 'choix_multiple') {
                const optionsContainer = typeFields.querySelector(`#options-container-${questionIndex}`);
                if (optionsContainer && optionsContainer.children.length === 0) {
                    addOption(questionIndex);
                    addOption(questionIndex);
                }
            }
        }
        
        function addOption(questionIndex) {
            const container = document.getElementById(`options-container-${questionIndex}`);
            if (!container) return;
            
            const optionIndex = container.children.length;
            
            const optionHtml = `
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="questions[${questionIndex}][options][${optionIndex}][correcte]" value="1" class="text-blue-600">
                    <input type="text" name="questions[${questionIndex}][options][${optionIndex}][texte]" placeholder="Option ${optionIndex + 1}" class="flex-1 px-3 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', optionHtml);
        }
        
        function removeOption(button) {
            button.closest('div').remove();
        }
        
        function previewQuestionImage(input, questionIndex) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(`question-image-preview-new-${questionIndex}`);
                    if (preview) {
                        preview.querySelector('img').src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function updateQuestionNumbers() {
            document.querySelectorAll('#questions-container .question-item').forEach((item, index) => {
                const numberSpan = item.querySelector('span.text-xs.font-semibold');
                if (numberSpan) {
                    numberSpan.textContent = `Question ${index + 1}`;
                }
            });
        }
        
        // Initialize Sortable for drag & drop
        function initializeQuestionSortable() {
            const container = document.getElementById('questions-container');
            if (!container) return;
            
            let draggedElement = null;
            
            container.querySelectorAll('.question-item').forEach(item => {
                item.draggable = true;
                const dragHandle = item.querySelector('.cursor-move');
                
                if (dragHandle) {
                    dragHandle.addEventListener('mousedown', function(e) {
                        item.draggable = true;
                    });
                }
                
                item.addEventListener('dragstart', function(e) {
                    draggedElement = this;
                    this.style.opacity = '0.5';
                    e.dataTransfer.effectAllowed = 'move';
                });
                
                item.addEventListener('dragend', function(e) {
                    this.style.opacity = '1';
                    draggedElement = null;
                });
                
                item.addEventListener('dragover', function(e) {
                    if (e.preventDefault) {
                        e.preventDefault();
                    }
                    e.dataTransfer.dropEffect = 'move';
                    return false;
                });
                
                item.addEventListener('dragenter', function(e) {
                    if (this !== draggedElement) {
                        this.style.borderTop = '3px solid #3b82f6';
                    }
                });
                
                item.addEventListener('dragleave', function(e) {
                    this.style.borderTop = '';
                });
                
                item.addEventListener('drop', function(e) {
                    if (e.stopPropagation) {
                        e.stopPropagation();
                    }
                    
                    if (draggedElement !== this) {
                        const allItems = Array.from(container.querySelectorAll('.question-item'));
                        const draggedIndex = allItems.indexOf(draggedElement);
                        const targetIndex = allItems.indexOf(this);
                        
                        if (draggedIndex < targetIndex) {
                            container.insertBefore(draggedElement, this.nextSibling);
                        } else {
                            container.insertBefore(draggedElement, this);
                        }
                        
                        updateQuestionNumbers();
                    }
                    
                    this.style.borderTop = '';
                    return false;
                });
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeQuestionSortable();
        });

        // Générer un code aléatoire
        function generateCode() {
            const code = Math.floor(100000 + Math.random() * 900000).toString();
            document.getElementById('codeSecurite').value = code;
        }

        // Validation du code (uniquement des chiffres)
        document.getElementById('codeSecurite')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length > 6) {
                this.value = this.value.substring(0, 6);
            }
        });
    </script>
@include('components.video-session-notification')</body>
</html>
