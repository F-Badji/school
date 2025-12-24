<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notes - BJ Academie</title>
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
                    $isNotes = $currentRoute === 'apprenant.notes' || $currentRoute === 'account.notes';
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
                        <a href="{{ route('apprenant.notes') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg nav-link sidebar-text" style="transition: none !important; -webkit-transition: none !important; {{ $isNotes ? 'background-color: rgba(37, 99, 235, 0.2); border-left: 4px solid rgb(59, 130, 246);' : '' }}">
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
                    @php
                        $sidebarUnreadMessagesCount = 0;
                        if (Auth::check()) {
                            $sidebarUnreadMessagesCount = \App\Models\Message::where('receiver_id', Auth::id())
                                ->whereNull('read_at')
                                ->count();
                        }
                    @endphp
                    @if($sidebarUnreadMessagesCount > 0)
                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white" id="sidebarUnreadBadge">{{ $sidebarUnreadMessagesCount }}</span>
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
                <a href="{{ route('apprenant.parametres') }}" id="parametresBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg ">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Paramètres</span>
                </a>
                <a href="#" id="supportBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg " onclick="event.preventDefault(); event.stopPropagation(); const m=document.getElementById('supportModal'); if(m){m.classList.add('active'); document.body.style.overflow='hidden';} return false;">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="sidebar-text font-medium">Support</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">Mes Notes</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Icône de notification avec badge -->
                        <div class="relative">
                            <button id="notificationIcon" class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                                </svg>
                                <span id="notificationBadge" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full" style="display: none;">
                                    0
                                </span>
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
                        <div class="relative">
                            <button id="profileDropdownBtn" class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-white shadow-md cursor-pointer hover:ring-2 hover:ring-purple-300 transition-all focus:outline-none">
                                @if(auth()->user()->photo)
                                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr(auth()->user()->prenom ?? auth()->user()->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom ?? '', 0, 1)) }}
                                    </div>
                                @endif
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50 hidden">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-purple-300 flex-shrink-0">
                                            @if(auth()->user()->photo)
                                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr(auth()->user()->prenom ?? auth()->user()->name ?? 'A', 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom ?? '', 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ auth()->user()->name ?? (auth()->user()->prenom ?? '') . ' ' . (auth()->user()->nom ?? '') }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email ?? '' }}</p>
                                            @if(auth()->user()->matricule)
                                                <p class="text-xs font-medium text-purple-600 truncate mt-1">Matricule: {{ auth()->user()->matricule }}</p>
                                            @endif
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
            <div class="flex-1 overflow-y-auto bg-gray-50 p-8">
                <div class="max-w-7xl mx-auto">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Informations utilisateur avec Matricule -->
                    <div class="mb-6 p-4 bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-2">Mes Notes</h2>
                                @if(auth()->user()->matricule)
                                    <p class="text-sm text-gray-600">
                                        <span class="font-semibold">Matricule:</span> 
                                        <span class="text-purple-600 font-medium">{{ auth()->user()->matricule }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @php
                        // SÉCURITÉ CRITIQUE : Recalculer les semestres depuis le niveau d'étude de l'utilisateur
                        // Cette vérification est ABSOLUMENT CRITIQUE pour éviter toute fraude
                        
                        // LOG DANS LA VUE
                        \Log::critical('=== DANS LA VUE - DÉBUT ===', [
                            'user_id' => $user->id ?? 'NULL',
                            'user_niveau_etude' => $user->niveau_etude ?? 'NULL',
                            'user_niveau_etude_type' => gettype($user->niveau_etude ?? null),
                            'semestre1_reçu' => $semestre1 ?? 'NON_DÉFINI',
                            'semestre2_reçu' => $semestre2 ?? 'NON_DÉFINI',
                            'semestre1_reçu_type' => gettype($semestre1 ?? null),
                            'semestre2_reçu_type' => gettype($semestre2 ?? null),
                            'niveauEtude_reçu' => $niveauEtude ?? 'NON_DÉFINI',
                        ]);
                        
                        // SÉCURITÉ : Normaliser le niveau d'étude depuis la base de données
                        $niveauEtudeViewRaw = $user->niveau_etude ?? 'Licence 1';
                        \Log::critical('=== DANS LA VUE - AVANT NORMALISATION ===', [
                            'niveauEtudeViewRaw' => $niveauEtudeViewRaw,
                            'niveauEtudeViewRaw_type' => gettype($niveauEtudeViewRaw),
                            'niveauEtudeViewRaw_length' => strlen($niveauEtudeViewRaw),
                        ]);
                        
                        $niveauEtudeView = strtolower(trim($niveauEtudeViewRaw));
                        
                        \Log::critical('=== DANS LA VUE - NIVEAU NORMALISÉ ===', [
                            'niveauEtudeViewRaw' => $niveauEtudeViewRaw,
                            'niveauEtudeView' => $niveauEtudeView,
                            'niveauEtudeView_length' => strlen($niveauEtudeView),
                            'niveauEtudeView_equals_licence1' => ($niveauEtudeView === 'licence 1'),
                            'niveauEtudeView_equals_licence2' => ($niveauEtudeView === 'licence 2'),
                        ]);
                        
                        // SÉCURITÉ : FORCER les semestres selon le niveau - IGNORER toute valeur passée
                        // Cette logique est la SEULE source de vérité pour les semestres
                        \Log::critical('=== DANS LA VUE - AVANT SWITCH ===', [
                            'niveauEtudeView' => $niveauEtudeView,
                            'semestre1_avant_switch' => $semestre1 ?? 'NON_DÉFINI',
                            'semestre2_avant_switch' => $semestre2 ?? 'NON_DÉFINI',
                        ]);
                        
                        switch ($niveauEtudeView) {
                            case 'licence 1':
                                $semestre1 = 1;
                                $semestre2 = 2;
                                \Log::critical('VUE SWITCH: Licence 1 -> Semestres 1 et 2', [
                                    'semestre1' => $semestre1,
                                    'semestre2' => $semestre2,
                                ]);
                                break;
                            case 'licence 2':
                                $semestre1 = 3;
                                $semestre2 = 4;
                                \Log::critical('VUE SWITCH: Licence 2 -> Semestres 3 et 4', [
                                    'semestre1' => $semestre1,
                                    'semestre2' => $semestre2,
                                ]);
                                break;
                            case 'licence 3':
                                $semestre1 = 5;
                                $semestre2 = 6;
                                \Log::info('VUE SWITCH: Licence 3 -> Semestres 5 et 6');
                                break;
                            case 'master 1':
                                $semestre1 = 7;
                                $semestre2 = 8;
                                \Log::info('VUE SWITCH: Master 1 -> Semestres 7 et 8');
                                break;
                            case 'master 2':
                                $semestre1 = 9;
                                $semestre2 = 10;
                                \Log::info('VUE SWITCH: Master 2 -> Semestres 9 et 10');
                                break;
                            default:
                                // Par défaut, Licence 1
                                $semestre1 = 1;
                                $semestre2 = 2;
                                \Log::warning('VUE SWITCH: DEFAULT -> Semestres 1 et 2', [
                                    'niveauEtudeView' => $niveauEtudeView,
                                ]);
                                break;
                        }
                        
                        \Log::critical('=== DANS LA VUE - APRÈS SWITCH ===', [
                            'semestre1' => $semestre1,
                            'semestre2' => $semestre2,
                            'semestre1_type' => gettype($semestre1),
                            'semestre2_type' => gettype($semestre2),
                        ]);
                        
                        // SÉCURITÉ : Vérification finale absolue - FORCER les valeurs
                        \Log::critical('=== DANS LA VUE - AVANT VÉRIFICATIONS FINALES ===', [
                            'niveauEtudeView' => $niveauEtudeView,
                            'semestre1' => $semestre1,
                            'semestre2' => $semestre2,
                        ]);
                        
                        if ($niveauEtudeView === 'licence 1') {
                            if ($semestre1 != 1 || $semestre2 != 2) {
                                \Log::critical('=== VUE ERREUR CRITIQUE : Licence 1 avec mauvais semestres ===', [
                                    'semestre1_avant' => $semestre1,
                                    'semestre2_avant' => $semestre2,
                                    'attendu_semestre1' => 1,
                                    'attendu_semestre2' => 2,
                                ]);
                            }
                            $semestre1 = 1;
                            $semestre2 = 2;
                            \Log::critical('=== VUE FORCÉ : Licence 1 -> Semestres 1 et 2 ===', [
                                'semestre1' => $semestre1,
                                'semestre2' => $semestre2,
                            ]);
                        } elseif ($niveauEtudeView === 'licence 2') {
                            if ($semestre1 != 3 || $semestre2 != 4) {
                                \Log::critical('=== VUE ERREUR CRITIQUE : Licence 2 avec mauvais semestres ===', [
                                    'semestre1_avant' => $semestre1,
                                    'semestre2_avant' => $semestre2,
                                    'attendu_semestre1' => 3,
                                    'attendu_semestre2' => 4,
                                ]);
                            }
                            $semestre1 = 3;
                            $semestre2 = 4;
                            \Log::critical('=== VUE FORCÉ : Licence 2 -> Semestres 3 et 4 ===', [
                                'semestre1' => $semestre1,
                                'semestre2' => $semestre2,
                            ]);
                        } elseif ($niveauEtudeView === 'licence 3') {
                            $semestre1 = 5;
                            $semestre2 = 6;
                        } elseif ($niveauEtudeView === 'master 1') {
                            $semestre1 = 7;
                            $semestre2 = 8;
                        } elseif ($niveauEtudeView === 'master 2') {
                            $semestre1 = 9;
                            $semestre2 = 10;
                        }
                        
                        // S'assurer que ce sont des entiers
                        $semestre1 = (int)$semestre1;
                        $semestre2 = (int)$semestre2;
                        
                        \Log::critical('=== DANS LA VUE - FINAL ===', [
                            'semestre1_FINAL' => $semestre1,
                            'semestre2_FINAL' => $semestre2,
                            'semestre1_FINAL_type' => gettype($semestre1),
                            'semestre2_FINAL_type' => gettype($semestre2),
                            'niveauEtudeView' => $niveauEtudeView,
                            'user_niveau_etude' => $user->niveau_etude ?? 'NULL',
                        ]);
                        
                        // DERNIÈRE VÉRIFICATION ABSOLUE AVANT AFFICHAGE
                        // FORCER les semestres une dernière fois selon le niveau
                        // LIRE DIRECTEMENT depuis la base de données pour éviter tout problème
                        $userNiveauRaw = $user->niveau_etude ?? 'Licence 1';
                        $niveauFinalCheck = strtolower(trim($userNiveauRaw));
                        
                        \Log::critical('=== VÉRIFICATION FINALE AVANT AFFICHAGE ===', [
                            'user_id' => $user->id ?? 'NULL',
                            'user_niveau_etude_RAW' => $userNiveauRaw,
                            'niveauFinalCheck' => $niveauFinalCheck,
                            'semestre1_AVANT_FORCE' => $semestre1 ?? 'NULL',
                            'semestre2_AVANT_FORCE' => $semestre2 ?? 'NULL',
                        ]);
                        
                        // FORCER ABSOLUMENT selon le niveau - IGNORER toutes les valeurs précédentes
                        if ($niveauFinalCheck === 'licence 1') {
                            $semestre1 = 1;
                            $semestre2 = 2;
                            \Log::critical('=== FORCÉ : Licence 1 -> Semestres 1 et 2 (AVANT AFFICHAGE) ===', [
                                'user_id' => $user->id ?? 'NULL',
                                'semestre1' => $semestre1,
                                'semestre2' => $semestre2,
                            ]);
                        } elseif ($niveauFinalCheck === 'licence 2') {
                            $semestre1 = 3;
                            $semestre2 = 4;
                            \Log::critical('=== FORCÉ : Licence 2 -> Semestres 3 et 4 (AVANT AFFICHAGE) ===', [
                                'user_id' => $user->id ?? 'NULL',
                                'semestre1' => $semestre1,
                                'semestre2' => $semestre2,
                            ]);
                        } elseif ($niveauFinalCheck === 'licence 3') {
                            $semestre1 = 5;
                            $semestre2 = 6;
                        } elseif ($niveauFinalCheck === 'master 1') {
                            $semestre1 = 7;
                            $semestre2 = 8;
                        } elseif ($niveauFinalCheck === 'master 2') {
                            $semestre1 = 9;
                            $semestre2 = 10;
                        } else {
                            // Par défaut, Licence 1
                            $semestre1 = 1;
                            $semestre2 = 2;
                            \Log::critical('=== FORCÉ : DEFAULT -> Semestres 1 et 2 (AVANT AFFICHAGE) ===', [
                                'user_id' => $user->id ?? 'NULL',
                                'niveauFinalCheck' => $niveauFinalCheck,
                                'semestre1' => $semestre1,
                                'semestre2' => $semestre2,
                            ]);
                        }
                        
                        \Log::critical('=== AVANT AFFICHAGE - DERNIÈRE VÉRIFICATION ===', [
                            'user_id' => $user->id ?? 'NULL',
                            'user_niveau_etude' => $user->niveau_etude ?? 'NULL',
                            'niveauFinalCheck' => $niveauFinalCheck,
                            'semestre1_AVANT_AFFICHAGE' => $semestre1,
                            'semestre2_AVANT_AFFICHAGE' => $semestre2,
                        ]);
                        
                        // FORCER les valeurs en tant qu'entiers
                        $semestre1 = (int)$semestre1;
                        $semestre2 = (int)$semestre2;
                    @endphp


                    <!-- Semestre {{ $semestre1 }} -->
                    <div class="mb-8">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                        <span class="text-lg font-bold">{{ $semestre1 }}</span>
                                    </div>
                                    Semestre {{ $semestre1 }}
                                </h2>
                                
                                <!-- Download Bulletin Button for Semestre {{ $semestre1 }} -->
                                @if(isset($bulletinsSem1) && $bulletinsSem1->count() > 0)
                                    <div class="relative" id="bulletinDropdownSem{{ $semestre1 }}">
                                        <button class="px-6 py-3 text-white font-medium rounded-lg transition-colors flex items-center gap-2" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onclick="console.log('[BULLETIN] Bouton cliqué pour Semestre {{ $semestre1 }}'); toggleBulletinDropdown({{ $semestre1 }}); return false;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Télécharger mon bulletin
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div id="bulletinMenuSem{{ $semestre1 }}" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                            @foreach($bulletinsSem1 as $bulletin)
                                                <a href="{{ $bulletin['url'] }}" download="{{ $bulletin['name'] }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <span class="truncate">{{ $bulletin['name'] }}</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <button class="px-6 py-3 text-gray-400 font-medium rounded-lg border border-gray-300 cursor-not-allowed flex items-center gap-2" disabled>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Aucun bulletin disponible
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Exercices -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 shadow-sm">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900">Exercices</h3>
                                                <p class="text-xs text-gray-600">Notes finales des quiz</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @if(isset($matieresSem1) && $matieresSem1->count() > 0)
                                            @foreach($matieresSem1 as $matiere)
                                                @php
                                                    $matiereId = isset($matiere->cours_id) ? 'cours_' . $matiere->cours_id : $matiere->id;
                                                    $quizData = $quizNotesSem1[$matiereId] ?? null;
                                                    $noteFinale = $quizData['note'] ?? null;
                                                    $dateQuiz = $quizData['date'] ?? null;
                                                    $tentatives = $quizData['tentatives'] ?? 0;
                                                    
                                                    // Déterminer la couleur selon la note
                                                    $noteBg = 'bg-gray-100';
                                                    $noteText = 'text-gray-600';
                                                    $noteBorder = 'border-gray-200';
                                                    $hoverBorder = 'hover:border-gray-300';
                                                    if ($noteFinale !== null) {
                                                        if ($noteFinale >= 16) {
                                                            $noteBg = 'bg-green-100';
                                                            $noteText = 'text-green-700';
                                                            $noteBorder = 'border-green-200';
                                                            $hoverBorder = 'hover:border-green-300';
                                                        } elseif ($noteFinale >= 12) {
                                                            $noteBg = 'bg-blue-100';
                                                            $noteText = 'text-blue-700';
                                                            $noteBorder = 'border-blue-200';
                                                            $hoverBorder = 'hover:border-blue-300';
                                                        } elseif ($noteFinale >= 10) {
                                                            $noteBg = 'bg-yellow-100';
                                                            $noteText = 'text-yellow-700';
                                                            $noteBorder = 'border-yellow-200';
                                                            $hoverBorder = 'hover:border-yellow-300';
                                                        } else {
                                                            $noteBg = 'bg-red-100';
                                                            $noteText = 'text-red-700';
                                                            $noteBorder = 'border-red-200';
                                                            $hoverBorder = 'hover:border-red-300';
                                                        }
                                                    }
                                                @endphp
                                                <div class="group bg-white rounded-lg border border-gray-200 {{ $hoverBorder }} hover:shadow-md transition-all duration-200 overflow-hidden">
                                                    <div class="flex items-center justify-between p-4">
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $matiere->nom_matiere }}</h4>
                                                                @if($tentatives > 0)
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                                        {{ $tentatives }} {{ $tentatives > 1 ? 'tentatives' : 'tentative' }}
                                                                    </span>
                                                        @endif
                                                    </div>
                                                            @if($dateQuiz)
                                                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                    {{ \Carbon\Carbon::parse($dateQuiz)->locale('fr')->isoFormat('D MMM YYYY') }}
                                                                </p>
                                                        @else
                                                                <p class="text-xs text-gray-400">Aucun quiz complété</p>
                                                        @endif
                                                        </div>
                                                        <div class="ml-4 flex-shrink-0">
                                                            @if($noteFinale !== null)
                                                                <div class="flex flex-col items-end">
                                                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl {{ $noteBg }} {{ $noteText }} border-2 {{ $noteBorder }} shadow-sm">
                                                                        <div class="text-center">
                                                                            <p class="text-lg font-bold leading-none">{{ round($noteFinale) }}</p>
                                                                            <p class="text-xs font-medium leading-none mt-0.5">/20</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="flex flex-col items-end">
                                                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-gray-100 text-gray-400 border-2 border-gray-200">
                                                                        <div class="text-center">
                                                                            <p class="text-lg font-bold leading-none">-</p>
                                                                            <p class="text-xs font-medium leading-none mt-0.5">/20</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center py-8">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-500">Aucune matière n'existe</p>
                                                <p class="text-xs text-gray-400 mt-1">Aucune matière n'est disponible pour ce semestre</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Devoirs -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Devoirs</h3>
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @if(isset($matieresSem1) && $matieresSem1->count() > 0)
                                            @foreach($matieresSem1 as $matiere)
                                                @php
                                                    // SÉCURITÉ : Chercher si l'apprenant connecté a une note de devoir pour cette matière
                                                    // Rechercher par champ devoir directement, pas par type
                                                    // Filtrer uniquement les notes du semestre 1
                                                    $noteDevoir = collect($notes)->first(function($note) use ($matiere, $semestre1, $user) {
                                                        // SÉCURITÉ : Vérifier que la note appartient bien à l'utilisateur connecté
                                                        $belongsToUser = (!isset($note->user_id) || $note->user_id == $user->id) ||
                                                                         ($note->nom == $user->nom && $note->prenom == $user->prenom);
                                                        
                                                        // Vérifier que la matière correspond (flexible pour correspondance partielle)
                                                        $matiereNom = trim(strtolower($matiere->nom_matiere ?? ''));
                                                        $noteMatiere = trim(strtolower($note->matiere ?? ''));
                                                        $noteClasse = trim(strtolower($note->classe ?? ''));
                                                        
                                                        $matiereMatch = ($matiereNom === $noteMatiere) || 
                                                                        ($matiereNom === $noteClasse) ||
                                                                        (stripos($noteMatiere, $matiereNom) !== false) || 
                                                                        (stripos($matiereNom, $noteMatiere) !== false) ||
                                                                        (stripos($noteClasse, $matiereNom) !== false) ||
                                                                        (stripos($matiereNom, $noteClasse) !== false);
                                                        
                                                        // Vérifier le semestre : uniquement semestre1 (ou pas de semestre défini pour compatibilité)
                                                        $semestreMatch = ($note->semestre == $semestre1) || 
                                                                        (!$note->semestre); // Si pas de semestre défini, accepter pour compatibilité avec anciennes notes
                                                        
                                                        return $belongsToUser
                                                            && $semestreMatch
                                                            && isset($note->devoir) 
                                                            && $note->devoir !== null
                                                            && $note->devoir >= 0
                                                            && $matiereMatch;
                                                    });
                                                @endphp
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $matiere->nom_matiere }}</p>
                                                        @if($noteDevoir)
                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($noteDevoir->created_at)->format('d/m/Y') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right">
                                                        @if($noteDevoir && isset($noteDevoir->devoir) && $noteDevoir->devoir !== null)
                                                            <p class="text-lg font-bold text-gray-900">{{ round($noteDevoir->devoir) }}/20</p>
                                                        @else
                                                            <p class="text-sm text-gray-400">-</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500 text-center py-4">Aucune matière n'existe</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Examens -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Examens</h3>
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @if(isset($matieresSem1) && $matieresSem1->count() > 0)
                                            @foreach($matieresSem1 as $matiere)
                                                @php
                                                    // SÉCURITÉ : Chercher si l'apprenant connecté a une note d'examen pour cette matière
                                                    // Rechercher par champ examen directement, pas par type
                                                    // Filtrer uniquement les notes du semestre 1
                                                    $noteExamen = collect($notes)->first(function($note) use ($matiere, $semestre1, $user) {
                                                        // SÉCURITÉ : Vérifier que la note appartient bien à l'utilisateur connecté
                                                        $belongsToUser = (!isset($note->user_id) || $note->user_id == $user->id) ||
                                                                         ($note->nom == $user->nom && $note->prenom == $user->prenom);
                                                        
                                                        if (!$belongsToUser) {
                                                            return false;
                                                        }
                                                        
                                                        // Vérifier que la matière correspond (flexible pour correspondance partielle)
                                                        $matiereNom = trim(strtolower($matiere->nom_matiere ?? ''));
                                                        $noteMatiere = trim(strtolower($note->matiere ?? ''));
                                                        $noteClasse = trim(strtolower($note->classe ?? ''));
                                                        
                                                        // Normaliser les noms de matières (enlever accents, espaces multiples, etc.)
                                                        $matiereNomNormalized = preg_replace('/\s+/', ' ', $matiereNom);
                                                        $noteMatiereNormalized = preg_replace('/\s+/', ' ', $noteMatiere);
                                                        $noteClasseNormalized = preg_replace('/\s+/', ' ', $noteClasse);
                                                        
                                                        $matiereMatch = ($matiereNomNormalized === $noteMatiereNormalized) || 
                                                                        ($matiereNomNormalized === $noteClasseNormalized) ||
                                                                        (stripos($noteMatiereNormalized, $matiereNomNormalized) !== false) || 
                                                                        (stripos($matiereNomNormalized, $noteMatiereNormalized) !== false) ||
                                                                        (stripos($noteClasseNormalized, $matiereNomNormalized) !== false) ||
                                                                        (stripos($matiereNomNormalized, $noteClasseNormalized) !== false);
                                                        
                                                        if (!$matiereMatch) {
                                                            return false;
                                                        }
                                                        
                                                        // Vérifier le semestre : STRICTEMENT semestre1 (pas de fallback sur !$note->semestre pour éviter les erreurs)
                                                        $semestreMatch = ($note->semestre == $semestre1);
                                                        
                                                        if (!$semestreMatch) {
                                                            return false;
                                                        }
                                                        
                                                        // Vérifier que la note d'examen existe et est valide
                                                        // IMPORTANT : On cherche spécifiquement une note d'examen, pas une note de devoir
                                                        // Dans AccountController, on crée deux objets séparés :
                                                        // 1. Un avec devoir=X, examen=0, type='devoir'
                                                        // 2. Un avec devoir=0, examen=Y, type='examen'
                                                        // On doit donc vérifier le type OU que examen > 0
                                                        $hasExamen = isset($note->examen) && $note->examen !== null && $note->examen >= 0;
                                                        
                                                        // Vérifier que c'est bien une note d'examen (pas une note de devoir avec examen=0)
                                                        // Si le type est 'examen', c'est une vraie note d'examen
                                                        // Sinon, si examen > 0, c'est aussi une vraie note d'examen
                                                        $isExamenNote = (isset($note->type) && $note->type === 'examen') || 
                                                                        ($note->examen > 0);
                                                        
                                                        if (!$hasExamen || !$isExamenNote) {
                                                            return false;
                                                        }
                                                        
                                                        // Log pour déboguer
                                                        \Log::info('Note d\'examen trouvée pour apprenant (Semestre 1)', [
                                                            'user_id' => $user->id,
                                                            'matiere' => $matiere->nom_matiere,
                                                            'note_matiere' => $note->matiere,
                                                            'note_classe' => $note->classe,
                                                            'note_semestre' => $note->semestre,
                                                            'note_examen' => $note->examen,
                                                            'note_devoir' => $note->devoir ?? 'N/A',
                                                            'note_id' => $note->id ?? 'N/A',
                                                            'note_type' => $note->type ?? 'N/A',
                                                        ]);
                                                        
                                                        return true;
                                                    });
                                                @endphp
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $matiere->nom_matiere }}</p>
                                                        @if($noteExamen)
                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($noteExamen->created_at)->format('d/m/Y') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right">
                                                        @if($noteExamen && isset($noteExamen->examen) && $noteExamen->examen !== null)
                                                            <p class="text-lg font-bold text-gray-900">{{ round($noteExamen->examen) }}/20</p>
                                                        @else
                                                            <p class="text-sm text-gray-400">-</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500 text-center py-4">Aucune matière n'existe</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Semestre {{ $semestre2 }} -->
                    <div class="mb-8">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                        <span class="text-lg font-bold">{{ $semestre2 }}</span>
                                    </div>
                                    Semestre {{ $semestre2 }}
                                </h2>
                                
                                <!-- Download Bulletin Button for Semestre {{ $semestre2 }} -->
                                @if(isset($bulletinsSem2) && $bulletinsSem2->count() > 0)
                                    <div class="relative" id="bulletinDropdownSem{{ $semestre2 }}">
                                        <button class="px-6 py-3 text-white font-medium rounded-lg transition-colors flex items-center gap-2" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onclick="console.log('[BULLETIN] Bouton cliqué pour Semestre {{ $semestre2 }}'); toggleBulletinDropdown({{ $semestre2 }}); return false;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Télécharger mon bulletin
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div id="bulletinMenuSem{{ $semestre2 }}" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                            @foreach($bulletinsSem2 as $bulletin)
                                                <a href="{{ $bulletin['url'] }}" download="{{ $bulletin['name'] }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <span class="truncate">{{ $bulletin['name'] }}</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <button class="px-6 py-3 text-gray-400 font-medium rounded-lg border border-gray-300 cursor-not-allowed flex items-center gap-2" disabled>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Aucun bulletin disponible
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Exercices -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 shadow-sm">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900">Exercices</h3>
                                                <p class="text-xs text-gray-600">Notes finales des quiz</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @if(isset($matieresSem2) && $matieresSem2->count() > 0)
                                            @foreach($matieresSem2 as $matiere)
                                                @php
                                                    $matiereId = isset($matiere->cours_id) ? 'cours_' . $matiere->cours_id : $matiere->id;
                                                    $quizData = $quizNotesSem2[$matiereId] ?? null;
                                                    $noteFinale = $quizData['note'] ?? null;
                                                    $dateQuiz = $quizData['date'] ?? null;
                                                    $tentatives = $quizData['tentatives'] ?? 0;
                                                    
                                                    // Déterminer la couleur selon la note
                                                    $noteBg = 'bg-gray-100';
                                                    $noteText = 'text-gray-600';
                                                    $noteBorder = 'border-gray-200';
                                                    $hoverBorder = 'hover:border-gray-300';
                                                    if ($noteFinale !== null) {
                                                        if ($noteFinale >= 16) {
                                                            $noteBg = 'bg-green-100';
                                                            $noteText = 'text-green-700';
                                                            $noteBorder = 'border-green-200';
                                                            $hoverBorder = 'hover:border-green-300';
                                                        } elseif ($noteFinale >= 12) {
                                                            $noteBg = 'bg-blue-100';
                                                            $noteText = 'text-blue-700';
                                                            $noteBorder = 'border-blue-200';
                                                            $hoverBorder = 'hover:border-blue-300';
                                                        } elseif ($noteFinale >= 10) {
                                                            $noteBg = 'bg-yellow-100';
                                                            $noteText = 'text-yellow-700';
                                                            $noteBorder = 'border-yellow-200';
                                                            $hoverBorder = 'hover:border-yellow-300';
                                                        } else {
                                                            $noteBg = 'bg-red-100';
                                                            $noteText = 'text-red-700';
                                                            $noteBorder = 'border-red-200';
                                                            $hoverBorder = 'hover:border-red-300';
                                                        }
                                                    }
                                                @endphp
                                                <div class="group bg-white rounded-lg border border-gray-200 {{ $hoverBorder }} hover:shadow-md transition-all duration-200 overflow-hidden">
                                                    <div class="flex items-center justify-between p-4">
                                                        <div class="flex-1 min-w-0">
                                                            <div class="flex items-center gap-2 mb-1">
                                                                <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $matiere->nom_matiere }}</h4>
                                                                @if($tentatives > 0)
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                                        {{ $tentatives }} {{ $tentatives > 1 ? 'tentatives' : 'tentative' }}
                                                                    </span>
                                                        @endif
                                                    </div>
                                                            @if($dateQuiz)
                                                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                    </svg>
                                                                    {{ \Carbon\Carbon::parse($dateQuiz)->locale('fr')->isoFormat('D MMM YYYY') }}
                                                                </p>
                                                        @else
                                                                <p class="text-xs text-gray-400">Aucun quiz complété</p>
                                                        @endif
                                                        </div>
                                                        <div class="ml-4 flex-shrink-0">
                                                            @if($noteFinale !== null)
                                                                <div class="flex flex-col items-end">
                                                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl {{ $noteBg }} {{ $noteText }} border-2 {{ $noteBorder }} shadow-sm">
                                                                        <div class="text-center">
                                                                            <p class="text-lg font-bold leading-none">{{ round($noteFinale) }}</p>
                                                                            <p class="text-xs font-medium leading-none mt-0.5">/20</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="flex flex-col items-end">
                                                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-xl bg-gray-100 text-gray-400 border-2 border-gray-200">
                                                                        <div class="text-center">
                                                                            <p class="text-lg font-bold leading-none">-</p>
                                                                            <p class="text-xs font-medium leading-none mt-0.5">/20</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-center py-8">
                                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-sm font-medium text-gray-500">Aucune matière n'existe</p>
                                                <p class="text-xs text-gray-400 mt-1">Aucune matière n'est disponible pour ce semestre</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Devoirs -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Devoirs</h3>
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @if(isset($matieresSem2) && $matieresSem2->count() > 0)
                                            @foreach($matieresSem2 as $matiere)
                                                @php
                                                    // SÉCURITÉ : Chercher si l'apprenant connecté a une note de devoir pour cette matière
                                                    // Rechercher par champ devoir directement, pas par type
                                                    // Filtrer uniquement les notes du semestre 2
                                                    $noteDevoir = collect($notes)->first(function($note) use ($matiere, $semestre2, $user) {
                                                        // SÉCURITÉ : Vérifier que la note appartient bien à l'utilisateur connecté
                                                        $belongsToUser = (!isset($note->user_id) || $note->user_id == $user->id) ||
                                                                         ($note->nom == $user->nom && $note->prenom == $user->prenom);
                                                        
                                                        // Vérifier que la matière correspond (flexible pour correspondance partielle)
                                                        $matiereNom = trim(strtolower($matiere->nom_matiere ?? ''));
                                                        $noteMatiere = trim(strtolower($note->matiere ?? ''));
                                                        $noteClasse = trim(strtolower($note->classe ?? ''));
                                                        
                                                        $matiereMatch = ($matiereNom === $noteMatiere) || 
                                                                        ($matiereNom === $noteClasse) ||
                                                                        (stripos($noteMatiere, $matiereNom) !== false) || 
                                                                        (stripos($matiereNom, $noteMatiere) !== false) ||
                                                                        (stripos($noteClasse, $matiereNom) !== false) ||
                                                                        (stripos($matiereNom, $noteClasse) !== false);
                                                        
                                                        // Vérifier le semestre : uniquement semestre2 (ou pas de semestre défini pour compatibilité)
                                                        $semestreMatch = ($note->semestre == $semestre2) || 
                                                                        (!$note->semestre); // Si pas de semestre défini, accepter pour compatibilité avec anciennes notes
                                                        
                                                        return $belongsToUser
                                                            && $semestreMatch
                                                            && isset($note->devoir) 
                                                            && $note->devoir !== null
                                                            && $note->devoir >= 0
                                                            && $matiereMatch;
                                                    });
                                                @endphp
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $matiere->nom_matiere }}</p>
                                                        @if($noteDevoir)
                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($noteDevoir->created_at)->format('d/m/Y') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right">
                                                        @if($noteDevoir && isset($noteDevoir->devoir) && $noteDevoir->devoir !== null)
                                                            <p class="text-lg font-bold text-gray-900">{{ round($noteDevoir->devoir) }}/20</p>
                                                        @else
                                                            <p class="text-sm text-gray-400">-</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500 text-center py-4">Aucune matière n'existe</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Examens -->
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">Examens</h3>
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        @if(isset($matieresSem2) && $matieresSem2->count() > 0)
                                            @foreach($matieresSem2 as $matiere)
                                                @php
                                                    // SÉCURITÉ : Chercher si l'apprenant connecté a une note d'examen pour cette matière
                                                    // Rechercher par champ examen directement, pas par type
                                                    // Filtrer uniquement les notes du semestre 2
                                                    $noteExamen = collect($notes)->first(function($note) use ($matiere, $semestre2, $user) {
                                                        // SÉCURITÉ : Vérifier que la note appartient bien à l'utilisateur connecté
                                                        $belongsToUser = (!isset($note->user_id) || $note->user_id == $user->id) ||
                                                                         ($note->nom == $user->nom && $note->prenom == $user->prenom);
                                                        
                                                        if (!$belongsToUser) {
                                                            return false;
                                                        }
                                                        
                                                        // Vérifier que la matière correspond (flexible pour correspondance partielle)
                                                        $matiereNom = trim(strtolower($matiere->nom_matiere ?? ''));
                                                        $noteMatiere = trim(strtolower($note->matiere ?? ''));
                                                        $noteClasse = trim(strtolower($note->classe ?? ''));
                                                        
                                                        // Normaliser les noms de matières (enlever accents, espaces multiples, etc.)
                                                        $matiereNomNormalized = preg_replace('/\s+/', ' ', $matiereNom);
                                                        $noteMatiereNormalized = preg_replace('/\s+/', ' ', $noteMatiere);
                                                        $noteClasseNormalized = preg_replace('/\s+/', ' ', $noteClasse);
                                                        
                                                        $matiereMatch = ($matiereNomNormalized === $noteMatiereNormalized) || 
                                                                        ($matiereNomNormalized === $noteClasseNormalized) ||
                                                                        (stripos($noteMatiereNormalized, $matiereNomNormalized) !== false) || 
                                                                        (stripos($matiereNomNormalized, $noteMatiereNormalized) !== false) ||
                                                                        (stripos($noteClasseNormalized, $matiereNomNormalized) !== false) ||
                                                                        (stripos($matiereNomNormalized, $noteClasseNormalized) !== false);
                                                        
                                                        if (!$matiereMatch) {
                                                            return false;
                                                        }
                                                        
                                                        // Vérifier le semestre : STRICTEMENT semestre2 (pas de fallback sur !$note->semestre pour éviter les erreurs)
                                                        $semestreMatch = ($note->semestre == $semestre2);
                                                        
                                                        if (!$semestreMatch) {
                                                            return false;
                                                        }
                                                        
                                                        // Vérifier que la note d'examen existe et est valide
                                                        // IMPORTANT : On cherche spécifiquement une note d'examen, pas une note de devoir
                                                        $hasExamen = isset($note->examen) && $note->examen !== null && $note->examen >= 0;
                                                        
                                                        // Vérifier que c'est bien une note d'examen (pas une note de devoir avec examen=0)
                                                        $isExamenNote = (isset($note->type) && $note->type === 'examen') || 
                                                                        ($note->examen > 0);
                                                        
                                                        if (!$hasExamen || !$isExamenNote) {
                                                            return false;
                                                        }
                                                        
                                                        // Log pour déboguer
                                                        \Log::info('Note d\'examen trouvée pour apprenant (Semestre 2)', [
                                                            'user_id' => $user->id,
                                                            'matiere' => $matiere->nom_matiere,
                                                            'note_matiere' => $note->matiere,
                                                            'note_classe' => $note->classe,
                                                            'note_semestre' => $note->semestre,
                                                            'note_examen' => $note->examen,
                                                            'note_devoir' => $note->devoir ?? 'N/A',
                                                            'note_id' => $note->id ?? 'N/A',
                                                            'note_type' => $note->type ?? 'N/A',
                                                        ]);
                                                        
                                                        return true;
                                                    });
                                                @endphp
                                                <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $matiere->nom_matiere }}</p>
                                                        @if($noteExamen)
                                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($noteExamen->created_at)->format('d/m/Y') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right">
                                                        @if($noteExamen && isset($noteExamen->examen) && $noteExamen->examen !== null)
                                                            <p class="text-lg font-bold text-gray-900">{{ round($noteExamen->examen) }}/20</p>
                                                        @else
                                                            <p class="text-sm text-gray-400">-</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-sm text-gray-500 text-center py-4">Aucune matière n'existe</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // DIAGNOSTIC: Logs pour le bouton Paramètres
        console.log('🔍 [DIAGNOSTIC NOTES] Script chargé');
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔍 [DIAGNOSTIC NOTES] DOMContentLoaded déclenché');
            
            const parametresBtn = document.getElementById('parametresBtn');
            console.log('🔍 [DIAGNOSTIC NOTES] parametresBtn trouvé:', parametresBtn);
            
            if (parametresBtn) {
                console.log('🔍 [DIAGNOSTIC NOTES] href du bouton:', parametresBtn.getAttribute('href'));
                
                parametresBtn.addEventListener('click', function(e) {
                    console.log('🔍 [DIAGNOSTIC NOTES] Clic détecté via addEventListener');
                    console.log('🔍 [DIAGNOSTIC NOTES] Event:', e);
                    console.log('🔍 [DIAGNOSTIC NOTES] DefaultPrevented:', e.defaultPrevented);
                    console.log('🔍 [DIAGNOSTIC NOTES] href:', this.getAttribute('href'));
                }, false);
            } else {
                console.error('❌ [DIAGNOSTIC NOTES] parametresBtn introuvable!');
            }
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
                // Ne pas bloquer les liens de navigation
                if (e.target.closest('a[href]') && !e.target.closest('#coursDropdownMenu')) {
                    return; // Laisser le lien fonctionner normalement
                }
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

        // Toggle bulletin dropdown
        function toggleBulletinDropdown(semestreNum) {
            console.log('[BULLETIN] toggleBulletinDropdown appelé avec:', semestreNum);
            const menuId = 'bulletinMenuSem' + semestreNum;
            console.log('[BULLETIN] Recherche du menu avec ID:', menuId);
            const menu = document.getElementById(menuId);
            
            if (menu) {
                console.log('[BULLETIN] Menu trouvé:', menu);
                console.log('[BULLETIN] Classes actuelles du menu:', menu.className);
                const isHidden = menu.classList.contains('hidden');
                console.log('[BULLETIN] Menu est caché?', isHidden);
                menu.classList.toggle('hidden');
                console.log('[BULLETIN] Classes après toggle:', menu.className);
                console.log('[BULLETIN] Menu est maintenant caché?', menu.classList.contains('hidden'));
            } else {
                console.error('[BULLETIN] Menu non trouvé avec ID:', menuId);
                console.log('[BULLETIN] Éléments disponibles:', document.querySelectorAll('[id^="bulletinMenuSem"]'));
            }
            
            // Close other dropdowns - utiliser les valeurs dynamiques
            const semestre1 = {{ $semestre1 }};
            const semestre2 = {{ $semestre2 }};
            
            if (semestreNum == semestre1) {
                const menu2 = document.getElementById('bulletinMenuSem' + semestre2);
                if (menu2) {
                    console.log('[BULLETIN] Fermeture du menu Semestre 2');
                    menu2.classList.add('hidden');
                }
            } else if (semestreNum == semestre2) {
                const menu1 = document.getElementById('bulletinMenuSem' + semestre1);
                if (menu1) {
                    console.log('[BULLETIN] Fermeture du menu Semestre 1');
                    menu1.classList.add('hidden');
                }
            }
        }

        // Logs de débogage au chargement de la page
        console.log('[BULLETIN] ===== INITIALISATION DES BULLETINS =====');
        console.log('[BULLETIN] Semestre 1:', {{ $semestre1 }});
        console.log('[BULLETIN] Semestre 2:', {{ $semestre2 }});
        console.log('[BULLETIN] Bulletins Semestre 1 count:', {{ isset($bulletinsSem1) ? $bulletinsSem1->count() : 0 }});
        console.log('[BULLETIN] Bulletins Semestre 2 count:', {{ isset($bulletinsSem2) ? $bulletinsSem2->count() : 0 }});
        
        // Vérifier que les menus existent
        setTimeout(function() {
            const menuSem1 = document.getElementById('bulletinMenuSem{{ $semestre1 }}');
            const menuSem2 = document.getElementById('bulletinMenuSem{{ $semestre2 }}');
            console.log('[BULLETIN] Menu Semestre 1 trouvé:', menuSem1 ? 'OUI' : 'NON');
            console.log('[BULLETIN] Menu Semestre 2 trouvé:', menuSem2 ? 'OUI' : 'NON');
            
            if (menuSem1) {
                console.log('[BULLETIN] Menu Semestre 1 classes:', menuSem1.className);
                console.log('[BULLETIN] Menu Semestre 1 est caché?', menuSem1.classList.contains('hidden'));
                console.log('[BULLETIN] Menu Semestre 1 contenu:', menuSem1.innerHTML.substring(0, 200));
            }
            if (menuSem2) {
                console.log('[BULLETIN] Menu Semestre 2 classes:', menuSem2.className);
                console.log('[BULLETIN] Menu Semestre 2 est caché?', menuSem2.classList.contains('hidden'));
                console.log('[BULLETIN] Menu Semestre 2 contenu:', menuSem2.innerHTML.substring(0, 200));
            }
            console.log('[BULLETIN] ===== FIN INITIALISATION =====');
        }, 500);

        // Close dropdowns when clicking outside - utiliser les valeurs dynamiques
        const semestre1 = {{ $semestre1 }};
        const semestre2 = {{ $semestre2 }};
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#bulletinDropdownSem' + semestre1) && !e.target.closest('#bulletinMenuSem' + semestre1)) {
                const menu1 = document.getElementById('bulletinMenuSem' + semestre1);
                if (menu1) menu1.classList.add('hidden');
            }
            if (!e.target.closest('#bulletinDropdownSem' + semestre2) && !e.target.closest('#bulletinMenuSem' + semestre2)) {
                const menu2 = document.getElementById('bulletinMenuSem' + semestre2);
                if (menu2) menu2.classList.add('hidden');
            }
        });
    </script>
    
    <!-- Script pour les notifications -->
    <script>
        // Système de notifications pour apprenants
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBadge = document.getElementById('notificationBadge');
            const notificationList = document.getElementById('notificationList');
            const notificationIcon = document.getElementById('notificationIcon');
            const notificationDropdown = document.getElementById('notificationDropdown');
            
            // Toggle dropdown
            if (notificationIcon && notificationDropdown) {
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
            }
            
            function loadNotifications() {
                fetch('{{ route("apprenant.notifications.unread") }}')
                    .then(response => response.json())
                    .then(data => {
                        const count = data.count || 0;
                        if (count > 0 && notificationBadge) {
                            notificationBadge.textContent = count > 99 ? '99+' : count;
                            notificationBadge.style.display = 'block';
                        } else if (notificationBadge) {
                            notificationBadge.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Erreur lors du chargement des notifications:', error));
            }
            
            function loadNotificationDetails() {
                fetch('{{ route("apprenant.notifications.unread.details") }}')
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
                fetch(`{{ url('apprenant/notifications') }}/${notificationId}/mark-as-read`, {
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
        });
    </script>
    
    <!-- DEBUG BUTTON SCRIPT -->
    <script>
        // Cours dropdown functionality
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

        // Sidebar width monitoring
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            let lastSidebarWidth = sidebar.offsetWidth;
            setInterval(function() {
                const currentSidebarWidth = sidebar.offsetWidth;
                if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                    document.getElementById('coursDropdownMenu')?.classList.add('hidden');
                }
                lastSidebarWidth = currentSidebarWidth;
            }, 100);
        }

        // Toggle bulletin dropdown
        function toggleBulletinDropdown(semestreNum) {
            const menuId = 'bulletinMenuSem' + semestreNum;
            const menu = document.getElementById(menuId);
            
            if (menu) {
                menu.classList.toggle('hidden');
            }
            
            // Close other dropdowns
            const semestre1 = {{ $semestre1 }};
            const semestre2 = {{ $semestre2 }};
            
            if (semestreNum == semestre1) {
                const menu2 = document.getElementById('bulletinMenuSem' + semestre2);
                if (menu2) menu2.classList.add('hidden');
            } else if (semestreNum == semestre2) {
                const menu1 = document.getElementById('bulletinMenuSem' + semestre1);
                if (menu1) menu1.classList.add('hidden');
            }
        }

        // Close dropdowns when clicking outside
        const semestre1 = {{ $semestre1 }};
        const semestre2 = {{ $semestre2 }};
        
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#bulletinDropdownSem' + semestre1) && !e.target.closest('#bulletinMenuSem' + semestre1)) {
                const menu1 = document.getElementById('bulletinMenuSem' + semestre1);
                if (menu1) menu1.classList.add('hidden');
            }
            if (!e.target.closest('#bulletinDropdownSem' + semestre2) && !e.target.closest('#bulletinMenuSem' + semestre2)) {
                const menu2 = document.getElementById('bulletinMenuSem' + semestre2);
                if (menu2) menu2.classList.add('hidden');
            }
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
    @include('components.apprenant-video-session-notification')
</body>



















