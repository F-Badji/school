<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes cours - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        aside nav a span {
            transition: none !important;
            -webkit-transition: none !important;
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
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
                <a href="{{ route('apprenant.parametres') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
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
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="text-gray-500 text-sm">{{ now()->format('l d F Y') }}</div>
                    <div class="flex items-center gap-4">
                        @include('components.notification-icon-apprenant')
                        <div class="flex items-center gap-3">
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
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Page Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Mes cours</h1>

                    <!-- Search and Filter -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-1 relative">
                            <input type="text" id="searchInput" placeholder="Recherchez vos matières" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600 font-medium">Rapide</span>
                            <select id="matiereSelect" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                <option value="">Toutes les matières</option>
                                @foreach($matieres ?? [] as $matiere)
                                    @php
                                        $nom = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? 'Matière';
                                    @endphp
                                    <option value="{{ $nom }}">{{ $nom }}</option>
                                @endforeach
                            </select>
                            <button class="p-2 text-gray-400 hover:text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                            </button>
                            <button class="p-2 text-gray-400 hover:text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Courses Section -->
                    <div class="mb-8 mt-12">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <h2 class="text-xl font-bold text-gray-900">Mes cours</h2>
                                <!-- Tabs -->
                                <div class="flex items-center gap-2 border-b border-gray-200">
                                    <button id="tabTous" class="px-4 py-2 text-sm font-semibold border-b-2 border-blue-600 text-blue-600 transition-colors">
                                        Tous
                                    </button>
                                    <button id="tabFavoris" class="px-4 py-2 text-sm font-semibold border-b-2 border-transparent text-gray-600 hover:text-gray-900 transition-colors">
                                        Mes favoris ({{ $favorisCount ?? 0 }})
                                    </button>
                                </div>
                            </div>
                            <button id="viewAllBtn" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Voir plus ></button>
                        </div>
                        <div class="relative">
                            <!-- Boutons de navigation -->
                            <button id="navLeftBtn" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors" style="display: none;">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button id="navRightBtn" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white shadow-lg border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors" style="display: none;">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            
                            <!-- Conteneur scrollable horizontal (vue par défaut) -->
                            <div id="professorsContainer" class="flex gap-6 overflow-x-auto scrollbar-hide pb-4" style="scroll-behavior: smooth;">
                                <div id="professorsRow" class="flex gap-6">
                                    @forelse($matieresAvecFormateurs ?? [] as $index => $item)
                                    @php
                                        $formateur = $item['formateur'];
                                        $matiere = $item['matiere'];
                                        $nomMatiere = $item['nom_matiere'];
                                        
                                        $formateurName = !empty($formateur->name) ? $formateur->name : 
                                                        (!empty($formateur->prenom) && !empty($formateur->nom) ? $formateur->prenom . ' ' . $formateur->nom : 
                                                        'Professeur');
                                        
                                        $initials = '';
                                        if (!empty($formateur->prenom) && !empty($formateur->nom)) {
                                            $initials = strtoupper(substr($formateur->prenom, 0, 1) . substr($formateur->nom, 0, 1));
                                        } elseif (!empty($formateur->name)) {
                                            $nameParts = explode(' ', $formateur->name);
                                            $initials = strtoupper(substr($nameParts[0] ?? '', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
                                        } else {
                                            $initials = 'PR';
                                        }
                                        
                                        $isDark = ($index % 2 == 0);
                                        $bgClass = $isDark ? 'card-dark-bg' : 'bg-white';
                                        $textClass = $isDark ? 'text-white' : '';
                                        $textColor = $isDark ? 'text-white' : 'text-gray-900';
                                        $textSecondary = $isDark ? 'text-gray-300' : 'text-gray-600';
                                        $textTertiary = $isDark ? 'text-gray-200' : 'text-gray-700';
                                        $borderColor = $isDark ? 'border-gray-600' : 'border-gray-200';
                                        
                                        $colors = ['avatar-dark-blue', 'bg-gradient-to-br from-blue-400 to-blue-600', 'bg-gradient-to-br from-yellow-400 to-yellow-600', 'bg-gradient-to-br from-gray-700 to-gray-900'];
                                        $avatarColor = $colors[$index % count($colors)];
                                    @endphp
                                        @php
                                            $formateurId = is_object($formateur) ? ($formateur->id ?? null) : null;
                                            $favoriKey = $formateurId ? ($formateurId . '_' . $nomMatiere) : '';
                                            $isFavori = isset($favorisMap[$favoriKey]) && $favorisMap[$favoriKey];
                                        @endphp
                                        <div class="professor-card flex-shrink-0 w-80 {{ $bgClass }} rounded-xl border {{ $borderColor }} p-6 card-hover relative {{ $textClass }}" data-name="{{ $formateurName }}" data-matiere="{{ $nomMatiere }}" data-formateur-id="{{ $formateurId }}" data-favori="{{ $isFavori ? 'true' : 'false' }}">
                                            <button class="favori-btn absolute top-4 right-4 p-2 {{ $isFavori ? 'text-yellow-400' : 'text-gray-400' }} hover:text-yellow-400 transition-colors" data-formateur-id="{{ $formateurId }}" data-matiere-nom="{{ $nomMatiere }}">
                                                <svg class="w-5 h-5 {{ $isFavori ? 'fill-current' : '' }}" fill="{{ $isFavori ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                </svg>
                                            </button>
                                            <div class="flex items-center gap-3 mb-4">
                                                @if(!empty($formateur->photo))
                                                    <div class="w-16 h-16 rounded-full {{ $avatarColor }} overflow-hidden flex items-center justify-center text-white font-bold text-lg shadow-md flex-shrink-0">
                                                        <img src="{{ asset('storage/' . $formateur->photo) }}" alt="{{ $formateurName }}" class="w-full h-full object-cover">
                                                    </div>
                                                @else
                                                    <div class="w-16 h-16 rounded-full {{ $avatarColor }} flex items-center justify-center text-white font-bold text-lg shadow-md flex-shrink-0">
                                                        {{ $initials }}
                                                    </div>
                                                @endif
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                        <span class="inline-block px-2.5 py-1 badge-top text-white text-xs font-bold rounded">TOP Apprenant</span>
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                            <span class="text-sm font-semibold {{ $textColor }}">4.9</span>
                                                        </div>
                                                    </div>
                                                    <h3 class="text-lg font-bold {{ $textColor }} mb-1 flex items-center gap-1">
                                                        {{ $formateurName }}
                                                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </h3>
                                                    <p class="text-sm {{ $textSecondary }}">Professeur de {{ $nomMatiere }}</p>
                                                </div>
                                            </div>
                                            <p class="text-sm {{ $textTertiary }} mb-4 leading-relaxed">
                                                @if(str_contains(strtolower($nomMatiere), 'introduction à l\'informatique de gestion') || str_contains(strtolower($nomMatiere), 'informatique de gestion'))
                                                    Découvrez les bases de l'Informatique de Gestion et apprenez à utiliser les outils numériques pour optimiser la gestion des entreprises.
                                                @elseif(str_contains(strtolower($nomMatiere), 'php') || str_contains(strtolower($nomMatiere), 'programmation en php'))
                                                    Apprenez les concepts essentiels du langage PHP et développez des applications web performantes selon les bonnes pratiques de programmation.
                                                @elseif(str_contains(strtolower($nomMatiere), 'algorithmes') || str_contains(strtolower($nomMatiere), 'algorithme'))
                                                    Ce cours d'Algorithmes présente les bases de la logique et des méthodes de résolution de problèmes pour concevoir des programmes efficaces.
                                                @else
                                                    Découvrez mes cours de {{ $nomMatiere }} et progressez rapidement avec des méthodes pédagogiques adaptées à votre niveau.
                                                @endif
                                            </p>
                                            <div class="flex items-center justify-end gap-4 text-xs {{ $textSecondary }} mb-4">
                                                <span>30+ étudiants</span>
                                            </div>
                                        <div class="flex items-center justify-end pt-4 border-t {{ $isDark ? 'border-gray-600' : 'border-gray-200' }}">
                                            @php
                                                $nomMatiereLower = strtolower($nomMatiere);
                                                $routeProfesseur = null;
                                                
                                                if (str_contains($nomMatiereLower, 'informatique de gestion')) {
                                                    $routeProfesseur = route('apprenant.professeur.informatique-gestion');
                                                } elseif (str_contains($nomMatiereLower, 'php') || str_contains($nomMatiereLower, 'programmation')) {
                                                    $routeProfesseur = route('apprenant.professeur.programmation-php');
                                                } elseif (str_contains($nomMatiereLower, 'algorithme')) {
                                                    $routeProfesseur = route('apprenant.professeur.algorithmes');
                                                } else {
                                                    // Route générique pour les autres matières
                                                    $matiereSlug = strtolower($nomMatiere);
                                                    $matiereSlug = str_replace(' ', '-', $matiereSlug);
                                                    $matiereSlug = preg_replace('/[^a-z0-9\-]/', '', $matiereSlug);
                                                    $routeProfesseur = route('apprenant.professeur.matiere', ['matiereSlug' => $matiereSlug]);
                                                }
                                            @endphp
                                            <a href="{{ $routeProfesseur }}" class="px-5 py-2 bg-white text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-semibold">Accéder au cours</a>
                                        </div>
                                        </div>
                                    @empty
                                    <div class="text-center py-8">
                                        <p class="text-gray-500">Aucune matière disponible pour le moment.</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Grille complète (vue étendue) -->
                            <div id="professorsGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6" style="display: none;">
                                @forelse($matieresAvecFormateurs ?? [] as $index => $item)
                                @php
                                    $formateur = $item['formateur'];
                                    $matiere = $item['matiere'];
                                    $nomMatiere = $item['nom_matiere'];
                                    
                                    $formateurName = !empty($formateur->name) ? $formateur->name : 
                                                    (!empty($formateur->prenom) && !empty($formateur->nom) ? $formateur->prenom . ' ' . $formateur->nom : 
                                                    'Professeur');
                                    
                                    $initials = '';
                                    if (!empty($formateur->prenom) && !empty($formateur->nom)) {
                                        $initials = strtoupper(substr($formateur->prenom, 0, 1) . substr($formateur->nom, 0, 1));
                                    } elseif (!empty($formateur->name)) {
                                        $nameParts = explode(' ', $formateur->name);
                                        $initials = strtoupper(substr($nameParts[0] ?? '', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
                                    } else {
                                        $initials = 'PR';
                                    }
                                    
                                    $isDark = ($index % 2 == 0);
                                    $bgClass = $isDark ? 'card-dark-bg' : 'bg-white';
                                    $textClass = $isDark ? 'text-white' : '';
                                    $textColor = $isDark ? 'text-white' : 'text-gray-900';
                                    $textSecondary = $isDark ? 'text-gray-300' : 'text-gray-600';
                                    $textTertiary = $isDark ? 'text-gray-200' : 'text-gray-700';
                                    $borderColor = $isDark ? 'border-gray-600' : 'border-gray-200';
                                    
                                    $colors = ['avatar-dark-blue', 'bg-gradient-to-br from-blue-400 to-blue-600', 'bg-gradient-to-br from-yellow-400 to-yellow-600', 'bg-gradient-to-br from-gray-700 to-gray-900'];
                                    $avatarColor = $colors[$index % count($colors)];
                                    
                                    $formateurId = is_object($formateur) ? ($formateur->id ?? null) : null;
                                    $favoriKey = $formateurId ? ($formateurId . '_' . $nomMatiere) : '';
                                    $isFavori = isset($favorisMap[$favoriKey]) && $favorisMap[$favoriKey];
                                @endphp
                                    <div class="professor-card flex-shrink-0 w-80 {{ $bgClass }} rounded-xl border {{ $borderColor }} p-6 card-hover relative {{ $textClass }}" data-name="{{ $formateurName }}" data-matiere="{{ $nomMatiere }}" data-formateur-id="{{ $formateurId }}" data-favori="{{ $isFavori ? 'true' : 'false' }}">
                                        <button class="favori-btn absolute top-4 right-4 p-2 {{ $isFavori ? 'text-yellow-400' : 'text-gray-400' }} hover:text-yellow-400 transition-colors" data-formateur-id="{{ $formateurId }}" data-matiere-nom="{{ $nomMatiere }}">
                                            <svg class="w-5 h-5 {{ $isFavori ? 'fill-current' : '' }}" fill="{{ $isFavori ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                            </svg>
                                        </button>
                                        <div class="flex items-center gap-3 mb-4">
                                            @if(!empty($formateur->photo))
                                                <div class="w-16 h-16 rounded-full {{ $avatarColor }} overflow-hidden flex items-center justify-center text-white font-bold text-lg shadow-md flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $formateur->photo) }}" alt="{{ $formateurName }}" class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <div class="w-16 h-16 rounded-full {{ $avatarColor }} flex items-center justify-center text-white font-bold text-lg shadow-md flex-shrink-0">
                                                    {{ $initials }}
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                    <span class="inline-block px-2.5 py-1 badge-top text-white text-xs font-bold rounded">TOP Apprenant</span>
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                        <span class="text-sm font-semibold {{ $textColor }}">4.9</span>
                                                    </div>
                                                </div>
                                                <h3 class="text-lg font-bold {{ $textColor }} mb-1 flex items-center gap-1">
                                                    {{ $formateurName }}
                                                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </h3>
                                                <p class="text-sm {{ $textSecondary }}">Professeur de {{ $nomMatiere }}</p>
                                            </div>
                                        </div>
                                        <p class="text-sm {{ $textTertiary }} mb-4 leading-relaxed">
                                            @if(str_contains(strtolower($nomMatiere), 'introduction à l\'informatique de gestion') || str_contains(strtolower($nomMatiere), 'informatique de gestion'))
                                                Découvrez les bases de l'Informatique de Gestion et apprenez à utiliser les outils numériques pour optimiser la gestion des entreprises.
                                            @elseif(str_contains(strtolower($nomMatiere), 'php') || str_contains(strtolower($nomMatiere), 'programmation en php'))
                                                Apprenez les concepts essentiels du langage PHP et développez des applications web performantes selon les bonnes pratiques de programmation.
                                            @elseif(str_contains(strtolower($nomMatiere), 'algorithmes') || str_contains(strtolower($nomMatiere), 'algorithme'))
                                                Ce cours d'Algorithmes présente les bases de la logique et des méthodes de résolution de problèmes pour concevoir des programmes efficaces.
                                            @else
                                                Découvrez mes cours de {{ $nomMatiere }} et progressez rapidement avec des méthodes pédagogiques adaptées à votre niveau.
                                            @endif
                                        </p>
                                        <div class="flex items-center justify-end gap-4 text-xs {{ $textSecondary }} mb-4">
                                            <span>30+ étudiants</span>
                                        </div>
                                        <div class="flex items-center justify-end pt-4 border-t {{ $isDark ? 'border-gray-600' : 'border-gray-200' }}">
                                            @php
                                                $nomMatiereLower = strtolower($nomMatiere);
                                                $routeProfesseur = null;
                                                
                                                if (str_contains($nomMatiereLower, 'informatique de gestion')) {
                                                    $routeProfesseur = route('apprenant.professeur.informatique-gestion');
                                                } elseif (str_contains($nomMatiereLower, 'php') || str_contains($nomMatiereLower, 'programmation')) {
                                                    $routeProfesseur = route('apprenant.professeur.programmation-php');
                                                } elseif (str_contains($nomMatiereLower, 'algorithme')) {
                                                    $routeProfesseur = route('apprenant.professeur.algorithmes');
                                                } else {
                                                    // Route générique pour les autres matières
                                                    $matiereSlug = strtolower($nomMatiere);
                                                    $matiereSlug = str_replace(' ', '-', $matiereSlug);
                                                    $matiereSlug = preg_replace('/[^a-z0-9\-]/', '', $matiereSlug);
                                                    $routeProfesseur = route('apprenant.professeur.matiere', ['matiereSlug' => $matiereSlug]);
                                                }
                                            @endphp
                                            <a href="{{ $routeProfesseur }}" class="px-5 py-2 bg-white text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-semibold">Accéder au cours</a>
                                        </div>
                                    </div>
                                @empty
                                <div class="col-span-3 text-center py-8">
                                    <p class="text-gray-500">Aucune matière disponible pour le moment.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>
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
        // Script minimal pour le Support - en dehors de tout bloc
        (function() {
            'use strict';
            console.log('🚀 [SUPPORT] Script minimal chargé');
            
            function openSupport() {
                console.log('🖱️ [SUPPORT] openSupport() appelé');
                const modal = document.getElementById('supportModal');
                console.log('🔍 [SUPPORT] Modal:', modal);
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                    console.log('✅ [SUPPORT] Modal ouverte');
                } else {
                    console.error('❌ [SUPPORT] Modal introuvable');
                }
            }
            
            // Attendre que le DOM soit prêt
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('✅ [SUPPORT] DOM ready');
                    setupSupport();
                });
            } else {
                console.log('✅ [SUPPORT] DOM déjà prêt');
                setupSupport();
            }
            
            function setupSupport() {
                const btn = document.getElementById('supportBtn');
                console.log('🔍 [SUPPORT] Bouton trouvé:', btn);
                
                if (btn) {
                    // Méthode 1: onclick inline
                    btn.setAttribute('onclick', 'event.preventDefault(); event.stopPropagation(); (function(){const m=document.getElementById("supportModal");if(m){m.classList.add("active");document.body.style.overflow="hidden";console.log("✅ Modal ouverte");}})(); return false;');
                    
                    // Méthode 2: addEventListener
                    btn.addEventListener('click', function(e) {
                        console.log('🖱️ [SUPPORT] Clic détecté via addEventListener');
                        e.preventDefault();
                        e.stopPropagation();
                        openSupport();
                    }, true); // useCapture = true pour capturer avant les autres
                    
                    console.log('✅ [SUPPORT] Handlers attachés');
                } else {
                    console.error('❌ [SUPPORT] Bouton introuvable');
                }
            }
        })();
    </script>
    
    <script>
        console.log('🚀 Script loaded, waiting for DOM...');
        document.addEventListener('DOMContentLoaded', function() {
            console.log('✅ DOM Content Loaded!');
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

            document.getElementById('coursDropdownBtn')?.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById('coursDropdownMenu')?.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                const btn = document.getElementById('coursDropdownBtn');
                const menu = document.getElementById('coursDropdownMenu');
                if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });

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

            // Search and filter functionality
            const searchInput = document.getElementById('searchInput');
            const matiereSelect = document.getElementById('matiereSelect');
            let currentTab = 'tous';

            function filterCards() {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const selectedMatiere = matiereSelect.value.toLowerCase().trim();
                const allCards = document.querySelectorAll('.professor-card');

                allCards.forEach(card => {
                    const name = card.getAttribute('data-name').toLowerCase();
                    const matiere = card.getAttribute('data-matiere').toLowerCase();
                    const searchText = name + ' ' + matiere;

                    let matchesSearch = true;
                    let matchesMatiere = true;
                    let matchesTab = true;

                    // Tab filter
                    if (currentTab === 'favoris') {
                        const isFavori = card.getAttribute('data-favori') === 'true';
                        matchesTab = isFavori;
                    }

                    // Search filter
                    if (searchTerm) {
                        matchesSearch = searchText.includes(searchTerm);
                    }

                    // Matiere filter
                    if (selectedMatiere) {
                        const motsMatiere = selectedMatiere.split(/[\s\-_]+/).filter(m => m.length > 0);
                        matchesMatiere = motsMatiere.some(mot => matiere.includes(mot));
                    }

                    if (matchesSearch && matchesMatiere && matchesTab) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update navigation buttons
                if (!isExpanded && professorsContainer) {
                    setTimeout(updateNavButtons, 100);
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterCards);
            }
            if (matiereSelect) {
                matiereSelect.addEventListener('change', filterCards);
            }

            // Navigation horizontale et toggle vue
            const viewAllBtn = document.getElementById('viewAllBtn');
            const navLeftBtn = document.getElementById('navLeftBtn');
            const navRightBtn = document.getElementById('navRightBtn');
            const professorsContainer = document.getElementById('professorsContainer');
            const professorsRow = document.getElementById('professorsRow');
            const professorsGrid = document.getElementById('professorsGrid');
            
            let isExpanded = false;
            const scrollAmount = 320;

            function toggleNavIcons(show) {
                if (show) {
                    navLeftBtn.style.display = 'flex';
                    navRightBtn.style.display = 'flex';
                } else {
                    navLeftBtn.style.display = 'none';
                    navRightBtn.style.display = 'none';
                }
            }

            function updateNavButtons() {
                if (!isExpanded && professorsContainer) {
                    const scrollLeft = professorsContainer.scrollLeft;
                    const scrollWidth = professorsContainer.scrollWidth;
                    const clientWidth = professorsContainer.clientWidth;
                    
                    navLeftBtn.style.display = scrollLeft <= 0 ? 'none' : 'flex';
                    navRightBtn.style.display = scrollLeft + clientWidth >= scrollWidth - 10 ? 'none' : 'flex';
                }
            }

            if (navLeftBtn && navRightBtn && professorsContainer) {
                navLeftBtn.addEventListener('click', function() {
                    if (!isExpanded) {
                        professorsContainer.scrollBy({
                            left: -scrollAmount,
                            behavior: 'smooth'
                        });
                    }
                });

                navRightBtn.addEventListener('click', function() {
                    if (!isExpanded) {
                        professorsContainer.scrollBy({
                            left: scrollAmount,
                            behavior: 'smooth'
                        });
                    }
                });

                professorsContainer.addEventListener('scroll', updateNavButtons);
                updateNavButtons();
            }

            if (viewAllBtn && professorsContainer && professorsGrid) {
                viewAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    isExpanded = !isExpanded;
                    
                    if (isExpanded) {
                        professorsContainer.style.display = 'none';
                        professorsGrid.style.display = 'grid';
                        toggleNavIcons(false);
                        viewAllBtn.textContent = 'Voir moins <';
                    } else {
                        professorsGrid.style.display = 'none';
                        professorsContainer.style.display = 'flex';
                        toggleNavIcons(true);
                        viewAllBtn.textContent = 'Voir plus >';
                        if (professorsContainer) {
                            professorsContainer.scrollLeft = 0;
                        }
                        updateNavButtons();
                    }
                    
                    setTimeout(filterCards, 100);
                });
            }
            
            if (professorsContainer) {
                window.addEventListener('resize', function() {
                    if (!isExpanded) {
                        updateNavButtons();
                    }
                });
            }

            // Tabs functionality
            const tabTous = document.getElementById('tabTous');
            const tabFavoris = document.getElementById('tabFavoris');

            function showTab(tabName) {
                currentTab = tabName;
                
                // Update tab styles
                if (tabTous && tabFavoris) {
                    if (tabName === 'tous') {
                        tabTous.classList.add('border-blue-600', 'text-blue-600');
                        tabTous.classList.remove('border-transparent', 'text-gray-600');
                        tabFavoris.classList.add('border-transparent', 'text-gray-600');
                        tabFavoris.classList.remove('border-blue-600', 'text-blue-600');
                    } else {
                        tabFavoris.classList.add('border-blue-600', 'text-blue-600');
                        tabFavoris.classList.remove('border-transparent', 'text-gray-600');
                        tabTous.classList.add('border-transparent', 'text-gray-600');
                        tabTous.classList.remove('border-blue-600', 'text-blue-600');
                    }
                }

                // Re-apply filters
                filterCards();
            }

            if (tabTous) {
                tabTous.addEventListener('click', () => showTab('tous'));
            }
            if (tabFavoris) {
                tabFavoris.addEventListener('click', () => showTab('favoris'));
            }

            // Toggle favoris functionality
            document.querySelectorAll('.favori-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const formateurId = this.getAttribute('data-formateur-id');
                    const matiereNom = this.getAttribute('data-matiere-nom');
                    const svg = this.querySelector('svg');
                    const card = this.closest('.professor-card');
                    
                    if (!formateurId || !matiereNom) return;
                    
                    // Toggle visuel immédiat
                    const isCurrentlyFavori = this.classList.contains('text-yellow-400');
                    
                    fetch('{{ route("apprenant.favoris.toggle") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            formateur_id: formateurId,
                            matiere_nom: matiereNom
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mettre à jour l'icône
                            if (data.is_favori) {
                                this.classList.remove('text-gray-400');
                                this.classList.add('text-yellow-400');
                                svg.setAttribute('fill', 'currentColor');
                                svg.classList.add('fill-current');
                            } else {
                                this.classList.remove('text-yellow-400');
                                this.classList.add('text-gray-400');
                                svg.setAttribute('fill', 'none');
                                svg.classList.remove('fill-current');
                            }
                            
                            // Mettre à jour l'attribut data-favori de la carte
                            if (card) {
                                card.setAttribute('data-favori', data.is_favori ? 'true' : 'false');
                            }
                            
                            // Mettre à jour le compteur dans l'onglet
                            if (tabFavoris) {
                                tabFavoris.textContent = `Mes favoris (${data.favoris_count})`;
                            }
                            
                            // Si on est sur l'onglet favoris, masquer la carte si elle n'est plus en favoris
                            if (currentTab === 'favoris' && !data.is_favori && card) {
                                card.style.display = 'none';
                                setTimeout(updateNavButtons, 100);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du toggle favoris:', error);
                    });
                });
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
</body>
</html>






