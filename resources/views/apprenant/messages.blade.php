<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - BJ Academie</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        input:focus {
            --tw-ring-color: #1a1f3a;
            border-color: #1a1f3a;
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
        /* Cacher définitivement les badges avec toutes les classes exactes à côté de l'icône de profil */
        #profileDropdownBtn ~ .badge.badge-md.badge-circle.badge-floating.badge-danger.border-white:not(#notificationBadge),
        #profileDropdownBtn.parentElement .badge.badge-md.badge-circle.badge-floating.badge-danger.border-white:not(#notificationBadge) {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
        /* Call Interface Styles */
        .call-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 100%);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .call-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .call-interface {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem;
        }
        .call-profile-section {
            text-align: center;
            margin-bottom: 3rem;
        }
        .call-profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            border: 6px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            font-weight: bold;
            overflow: hidden;
        }
        .call-profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .call-name {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }
        .call-status {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
        }
        .call-timer {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }
        .call-controls {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            justify-content: center;
            margin-top: 3rem;
        }
        .call-btn {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .call-btn svg {
            width: 32px;
            height: 32px;
        }
        .call-btn-answer {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .call-btn-answer:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        .call-btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .call-btn-reject:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .call-btn-end {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            width: 80px;
            height: 80px;
        }
        .call-btn-end:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .call-btn-mute,
        .call-btn-speaker,
        .call-btn-video {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
        }
        .call-btn-mute:hover,
        .call-btn-speaker:hover,
        .call-btn-video:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }
        .call-btn-mute.active,
        .call-btn-speaker.active,
        .call-btn-video.active {
            background: rgba(255, 255, 255, 0.4);
        }
        .call-ringing-animation {
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .call-audio-visualizer {
            display: flex;
            gap: 4px;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
            height: 40px;
        }
        .audio-bar {
            width: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 2px;
            animation: audio-wave 1s infinite;
        }
        .audio-bar:nth-child(1) { animation-delay: 0s; }
        .audio-bar:nth-child(2) { animation-delay: 0.1s; }
        .audio-bar:nth-child(3) { animation-delay: 0.2s; }
        .audio-bar:nth-child(4) { animation-delay: 0.3s; }
        .audio-bar:nth-child(5) { animation-delay: 0.4s; }
        @keyframes audio-wave {
            0%, 100% { height: 10px; }
            50% { height: 30px; }
        }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        @include('components.sidebar-apprenant')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden bg-white">
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
                                    <a href="{{ route('apprenant.parametres') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profil</span>
                                    </a>
                                    <a href="{{ route('apprenant.parametres') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
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
            <main class="flex-1 overflow-hidden bg-white">
                <div class="flex h-full">
                    <!-- Left Panel - Chat List -->
                    <div class="w-96 border-r border-gray-200 flex flex-col bg-white">
                        <!-- Chat Title and Messages Section -->
                        <div class="p-6 border-b border-gray-200">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4">Chat</h1>
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-bold text-gray-900">Messages</h2>
                                <div class="flex items-center gap-2">
                                    @php
                                        $totalUnread = 0;
                                        foreach($conversations ?? [] as $conv) {
                                            $totalUnread += $conv['unread_count'] ?? 0;
                                        }
                                    @endphp
                                    @if($totalUnread > 0)
                                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white unread-badge">{{ $totalUnread }}</span>
                                    @endif
                                    <span class="text-sm text-gray-500 unread-text">{{ $totalUnread }} nouveaux messages</span>
                                </div>
                            </div>
                            <!-- Search Bar -->
                            <div class="relative">
                                <input type="text" id="searchContacts" placeholder="Rechercher" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Chat List -->
                        <div class="flex-1 overflow-y-auto">
                            <div class="space-y-0" id="chatList">
                                @php
                                    $conversations = [];
                                    foreach($messages ?? [] as $message) {
                                        $otherUserId = $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
                                        if (!isset($conversations[$otherUserId])) {
                                            $otherUser = $message->sender_id == $user->id ? $message->receiver : $message->sender;
                                            $conversations[$otherUserId] = [
                                                'user' => $otherUser,
                                                'last_message' => $message,
                                                'unread_count' => 0
                                            ];
                                        }
                                        if ($message->receiver_id == $user->id && !$message->read_at) {
                                            $conversations[$otherUserId]['unread_count']++;
                                        }
                                        if ($message->created_at > $conversations[$otherUserId]['last_message']->created_at) {
                                            $conversations[$otherUserId]['last_message'] = $message;
                                        }
                                    }
                                    $activeChatId = request()->get('chat', null);
                                    $firstContact = $contactsAutorises->first();
                                    if (!$activeChatId && $firstContact) {
                                        $activeChatId = $firstContact->id;
                                    }
                                @endphp
                                @if(isset($forumGroups) && $forumGroups->count() > 0)
                                    @foreach($forumGroups as $group)
                                        @php
                                            $isActive = $activeChatId == 'group_' . $group->id;
                                            $memberCount = $group->users->count();
                                        @endphp
                                        <div class="p-4 cursor-pointer transition-colors chat-item group-item {{ $isActive ? 'active' : '' }}"
                                            data-group-id="{{ $group->id }}"
                                            data-group-name="{{ $group->name }}"
                                            data-group-description="{{ $group->description ?? '' }}"
                                            data-group-creator="{{ $group->created_by }}"
                                            data-group-restrict="{{ $group->restrict_messages ?? 0 }}"
                                            data-group-avatar="{{ $group->avatar ?? '' }}"
                                            style="{{ $isActive ? 'background-color: rgba(26, 31, 58, 0.1); border-left: 4px solid #1a1f3a;' : '' }} border-bottom: 1px solid #e5e7eb;"
                                            onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='rgba(0,0,0,0.02)'"
                                            onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor=''"
                                            onclick="window.location.href='{{ route('apprenant.messages') }}?chat=group_{{ $group->id }}'">
                                            <div class="flex items-center gap-3">
                                                <div class="relative flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm overflow-hidden" style="{{ $group->avatar ? 'background-image: url(/storage/' . $group->avatar . '); background-size: cover; background-position: center;' : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' }}">
                                                        @if(!$group->avatar)
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        @endif
                                                    </div>
                                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $memberCount }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $group->name }}</p>
                                                        <span class="text-xs text-purple-600 font-medium">GROUPE</span>
                                                    </div>
                                                    <p class="text-xs text-gray-600 truncate mb-1">{{ $group->description ?? 'Groupe de discussion' }}</p>
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-gray-500">{{ $memberCount }} membre{{ $memberCount > 1 ? 's' : '' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @forelse($contactsAutorises ?? [] as $contact)
                                    @php
                                        $conversation = $conversations[$contact->id] ?? null;
                                        $lastMessage = $conversation['last_message'] ?? null;
                                        $unreadCount = $conversation['unread_count'] ?? 0;
                                        $isActive = $activeChatId == $contact->id;
                                        $initials = strtoupper(substr($contact->prenom ?? '', 0, 1) . substr($contact->nom ?? '', 0, 1));
                                        $contactName = ($contact->prenom ?? '') . ' ' . ($contact->nom ?? '');
                                        if (empty(trim($contactName))) {
                                            $contactName = $contact->name ?? 'Contact';
                                        }
                                        $timeAgo = $lastMessage ? \Carbon\Carbon::parse($lastMessage->created_at)->diffForHumans() : '';
                                        if ($timeAgo === 'il y a 1 seconde' || $timeAgo === '1 second ago') {
                                            $timeAgo = 'À l\'instant';
                                        }
                                    @endphp
                                    <div class="p-4 cursor-pointer transition-colors chat-item" 
                                         data-user-id="{{ $contact->id }}"
                                         style="{{ $isActive ? 'background-color: rgba(26, 31, 58, 0.1); border-left: 4px solid #1a1f3a;' : '' }}"
                                         onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='rgba(0,0,0,0.02)'" 
                                         onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor=''">
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex-shrink-0">
                                                @if($contact->photo ?? null)
                                                    <img src="{{ asset('storage/' . $contact->photo) }}" alt="{{ $contactName }}" class="w-12 h-12 rounded-full object-cover">
                                                @else
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                        {{ $initials }}
                                            </div>
                                                @endif
                                            @php
                                                $contactIsOnline = false;
                                                if ($contact->last_seen ?? null) {
                                                    $contactLastSeen = \Carbon\Carbon::parse($contact->last_seen);
                                                    $contactIsOnline = $contactLastSeen->diffInMinutes(now()) < 5;
                                                }
                                            @endphp
                                            <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full {{ $contactIsOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-1">
                                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $contactName }}</p>
                                                    @if($timeAgo)
                                                        <span class="text-xs text-gray-500 whitespace-nowrap">{{ $timeAgo }}</span>
                                                    @endif
                                            </div>
                                                @if($lastMessage)
                                                    <p class="text-xs text-gray-600 truncate mb-1">{{ Str::limit($lastMessage->content, 40) }}</p>
                                                @else
                                                    <p class="text-xs text-gray-500 truncate mb-1">Aucun message</p>
                                                @endif
                                            <div class="flex items-center justify-end">
                                                    @if($lastMessage && $lastMessage->sender_id == $user->id)
                                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                    @elseif($unreadCount > 0)
                                                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white">{{ $unreadCount }}</span>
                                                    @endif
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center">
                                        <p class="text-sm text-gray-500">Aucun contact disponible</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Right Panel - Active Chat -->
                    <div class="flex-1 flex flex-col bg-white" id="chatPanel">
                        @php
                            $activeGroup = null;
                            if ($activeChatId && strpos($activeChatId, 'group_') === 0) {
                                $groupId = str_replace('group_', '', $activeChatId);
                                $activeGroup = isset($forumGroups) ? $forumGroups->firstWhere('id', $groupId) : null;
                            }
                            $activeContact = !$activeGroup ? $contactsAutorises->firstWhere('id', $activeChatId) : null;
                            $activeMessages = collect();
                            if ($activeContact) {
                                // SÉCURITÉ CRITIQUE : Récupérer UNIQUEMENT les messages entre l'utilisateur connecté et le contact actif
                                // Vérification stricte pour éviter toute fuite de données
                                $activeMessages = \App\Models\Message::with(['sender:id,name,prenom,nom,email,photo,role', 'receiver:id,name,prenom,nom,email,photo,role'])
                                    ->where(function($query) use ($user, $activeContact) {
                                        // Message envoyé par l'utilisateur connecté au contact actif
                                        $query->where(function($q) use ($user, $activeContact) {
                                            $q->where('sender_id', $user->id)
                                              ->where('receiver_id', $activeContact->id);
                                        })
                                        // OU message envoyé par le contact actif à l'utilisateur connecté
                                        ->orWhere(function($q) use ($user, $activeContact) {
                                            $q->where('sender_id', $activeContact->id)
                                              ->where('receiver_id', $user->id);
                                        });
                                    })
                                    ->orderBy('created_at', 'asc')
                                    ->get();
                                
                                // SÉCURITÉ : Vérification finale - s'assurer que tous les messages appartiennent bien à cette conversation
                                $activeMessages = $activeMessages->filter(function($message) use ($user, $activeContact) {
                                    $isFromUser = $message->sender_id == $user->id && $message->receiver_id == $activeContact->id;
                                    $isToUser = $message->sender_id == $activeContact->id && $message->receiver_id == $user->id;
                                    return $isFromUser || $isToUser;
                                })->values();
                            }
                        @endphp
                        @if($activeChatId && $activeGroup)
                            <!-- Group Chat Header -->
                            <div class="p-6 border-b border-gray-200" id="chatHeader">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm overflow-hidden" style="{{ $activeGroup->avatar ? 'background-image: url(/storage/' . $activeGroup->avatar . '); background-size: cover; background-position: center;' : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' }}">
                                                @if(!$activeGroup->avatar)
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900"><a href="#" class="hover:underline" onclick="event.preventDefault(); openGroupModal({{ $activeGroup->id }});">{{ $activeGroup->name }}</a></p>
                                            <p class="text-sm text-gray-500">{{ $activeGroup->users->count() }} membre{{ $activeGroup->users->count() > 1 ? 's' : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Group Messages Area -->
                            <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                                <div id="messagesArea" class="space-y-4">
                                    <div class="text-center py-12">
                                        <p class="text-sm text-gray-500">Les messages de groupe seront disponibles prochainement.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Message Input (hidden for groups for now) -->
                            <div class="p-6 border-t border-gray-200 bg-white relative" id="messageInputContainer" style="display: none;">
                            </div>
                        @elseif($activeChatId && $activeContact)
                            @php
                                $activeInitials = strtoupper(substr($activeContact->prenom ?? '', 0, 1) . substr($activeContact->nom ?? '', 0, 1));
                            @endphp
                            <!-- Chat Header -->
                            <div class="p-6 border-b border-gray-200" id="chatHeader">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            @if($activeContact->photo ?? null)
                                                <img src="{{ asset('storage/' . $activeContact->photo) }}" alt="{{ $activeContact->prenom ?? '' }} {{ $activeContact->nom ?? '' }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                            @else
                                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                    {{ $activeInitials }}
                                                </div>
                                            @endif
                                            @php
                                                $activeIsOnline = false;
                                                if ($activeContact->last_seen ?? null) {
                                                    $activeLastSeen = \Carbon\Carbon::parse($activeContact->last_seen);
                                                    $activeIsOnline = $activeLastSeen->diffInMinutes(now()) < 5;
                                                }
                                            @endphp
                                            <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full {{ $activeIsOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900">{{ $activeContact->prenom ?? '' }} {{ $activeContact->nom ?? '' }}</p>
                                            @php
                                                $isOnline = false;
                                                $lastSeenText = 'Jamais en ligne';
                                                if ($activeContact->last_seen ?? null) {
                                                    $lastSeen = \Carbon\Carbon::parse($activeContact->last_seen);
                                                    $isOnline = $lastSeen->diffInMinutes(now()) < 5;
                                                    if (!$isOnline) {
                                                        $diffInMinutes = intval($lastSeen->diffInMinutes(now()));
                                                        $diffInHours = intval($lastSeen->diffInHours(now()));
                                                        $diffInDays = intval($lastSeen->diffInDays(now()));
                                                        $diffInWeeks = intval($lastSeen->diffInWeeks(now()));
                                                        $diffInMonths = intval($lastSeen->diffInMonths(now()));
                                                        $diffInYears = intval($lastSeen->diffInYears(now()));
                                                        
                                                        if ($diffInMinutes < 60) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '');
                                                        } elseif ($diffInHours < 24) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInHours . ' heure' . ($diffInHours > 1 ? 's' : '');
                                                        } elseif ($diffInDays < 7) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInDays . ' jour' . ($diffInDays > 1 ? 's' : '');
                                                        } elseif ($diffInWeeks < 4) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInWeeks . ' semaine' . ($diffInWeeks > 1 ? 's' : '');
                                                        } elseif ($diffInMonths < 12) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInMonths . ' mois';
                                                        } else {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInYears . ' an' . ($diffInYears > 1 ? 's' : '');
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if($isOnline)
                                                <p class="text-sm text-green-600 font-medium">En ligne</p>
                                            @else
                                                <p class="text-sm text-gray-500 font-medium">{{ $lastSeenText }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button id="callBtn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700" data-receiver-id="{{ $activeContact->id ?? '' }}" data-receiver-name="{{ ($activeContact->prenom ?? '') . ' ' . ($activeContact->nom ?? '') }}" data-receiver-photo="{{ $activeContact->photo ?? null }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            Appeler
                                        </button>
                                        <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Appel video
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages Area -->
                            <div class="flex-1 overflow-y-auto p-6 bg-gray-50">
                                <div id="messagesArea" class="space-y-4">
                                    @foreach($activeMessages as $message)
                                        @php
                                            $isSystemMessage = $message->label === 'System' || 
                                                             strpos($message->content, '📞❌') !== false || 
                                                             strpos($message->content, '📞✅') !== false ||
                                                             strpos($message->content, 'Appel manqué') !== false ||
                                                             strpos($message->content, 'Appel terminé') !== false;
                                        @endphp
                                        @if($isSystemMessage)
                                            <!-- System Message - Aligné à droite comme WhatsApp -->
                                            <div class="flex items-start gap-3 justify-end my-2" data-message-id="{{ $message->id }}">
                                                <div class="flex-1 flex justify-end">
                                                    <div class="max-w-[70%]">
                                                        <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                                            <p class="text-xs text-gray-600">{{ $message->content }}</p>
                                                        </div>
                                                        <p class="text-xs text-gray-400 mt-1 text-right">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($message->sender_id == $user->id)
                                            <!-- Apprenant's Message -->
                                            <div class="flex items-start gap-3 justify-end" data-message-id="{{ $message->id }}">
                                                <div class="flex-1 flex justify-end">
                                                    <div class="max-w-[70%]">
                                                        <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                            <p class="text-sm">{{ $message->content }}</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-1 text-right">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Other User's Message -->
                                            <div class="flex items-start gap-3" data-message-id="{{ $message->id }}">
                                                <div class="flex-1">
                                                    <div class="inline-block max-w-[70%]">
                                                        <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                            <p class="text-sm text-gray-700">{{ $message->content }}</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-1">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Message Input -->
                            <div class="p-6 border-t border-gray-200 bg-white relative" id="messageInputContainer">
                                <!-- Emoji Picker -->
                                <div id="emojiPicker" class="hidden absolute bottom-full left-0 mb-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl p-4" style="max-height: 300px; overflow-y: auto; z-index: 9999;">
                                    <div class="grid grid-cols-8 gap-2">
                                        @php
                                            $emojis = [
                                            '😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '🤯', '🤠', '🥳', '😎', '🤓', '🧐', '😕', '😟', '🙁', '😮', '😯', '😲', '😳', '🥺', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣', '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖',
                                            '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾', '🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴', '🦄', '🐝', '🐛', '🦋', '🐌', '🐞', '🐜', '🦟', '🦗', '🕷️', '🦂', '🐢', '🐍', '🦎', '🦖', '🦕', '🐙', '🦑', '🦐', '🦞', '🦀', '🐡', '🐠', '🐟', '🐬', '🐳', '🐋', '🦈', '🐊', '🐅', '🐆', '🦓', '🦍', '🦧', '🐘', '🦛', '🦏', '🐪', '🐫', '🦒', '🦘', '🦬', '🐃', '🐂', '🐄', '🐎', '🐖', '🐏', '🐑', '🦙', '🐐', '🦌', '🐕', '🐩', '🦮', '🐕‍🦺', '🐈', '🐓', '🦃', '🦤', '🦚', '🦜', '🦢', '🦩', '🕊️', '🐇', '🦝', '🦨', '🦡', '🦦', '🦥', '🐁', '🐀', '🐿️', '🦔',
                                            '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟',
                                            '👋', '🤚', '🖐️', '✋', '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈', '👉', '👆', '🖕', '👇', '☝️', '👍', '👎', '✊', '👊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏', '✍️', '💪', '🦾', '🦿', '🦵', '🦶', '👂', '🦻', '👃', '🧠', '🫀', '🫁', '🦷', '🦴', '👀', '👁️', '👅', '👄',
                                            '💋', '💌', '💍', '💎', '🔇', '🔈', '🔉', '🔊', '📢', '📣', '📯', '🔔', '🔕', '🎵', '🎶', '💿', '📀', '📱', '☎️', '📞', '📟', '📠', '🔋', '🔌', '💻', '🖥️', '🖨️', '⌨️', '🖱️', '🖲️', '🕹️', '🗜️', '💾', '📼', '📷', '📸', '📹', '🎥', '📽️', '🎞️', '📺', '📻', '🎙️', '🎚️', '🎛️', '⏱️', '⏲️', '⏰', '🕰️', '⌚', '📡', '💡', '🔦', '🕯️', '🪔', '🧯', '🛢️', '💸', '💵', '💴', '💶', '💷', '💰', '💳', '⚖️', '🛒', '🛍️', '🎁', '🎈', '🎉', '🎊', '🎀', '🎗️', '🏆', '🥇', '🥈', '🥉', '⚽', '🏀', '🏈', '⚾', '🎾', '🏐', '🏉', '🎱', '🏓', '🏸', '🥅', '🏒', '🏑', '🏏', '🥃', '🥤', '🧃', '🧉', '🧊', '🥢', '🍽️', '🍴', '🥄', '🔪', '🏺', '🌍', '🌎', '🌏', '🌐', '🗺️', '🧭', '🏔️', '⛰️', '🌋', '🗻', '🏕️', '🏖️', '🏜️', '🏝️', '🏞️', '🏟️', '🏛️', '🏗️', '🧱', '🏘️', '🏚️', '🏠', '🏡', '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '💒', '🗼', '🗽', '⛪', '🕌', '🛕', '🕍', '⛩️', '🕋', '⛲', '⛺', '🌁', '🌃', '🏙️', '🌄', '🌅', '🌆', '🌇', '🌉', '♨️', '🎠', '🎡', '🎢', '💈', '🎪', '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝', '🚞', '🚋', '🚌', '🚍', '🚎', '🚐', '🚑', '🚒', '🚓', '🚔', '🚕', '🚖', '🚗', '🚘', '🚙', '🚚', '🚛', '🚜', '🏎️', '🏍️', '🛵', '🦽', '🦼', '🛴', '🚲', '🛺', '🚁', '🛸', '✈️', '🛩️', '🛫', '🛬', '🪂', '💺', '🚀', '🚤', '⛵', '🛥️', '🛳️', '⛴️', '🚢', '⚓', '⛽', '🚧', '🚦', '🚥', '🗿', '🛂', '🛃', '🛄', '🛅', '⚠️', '🚸', '⛔', '🚫', '🚳', '🚭', '🚯', '🚱', '🚷', '📵', '🔞', '☢️', '☣️', '⬆️', '↗️', '➡️', '↘️', '⬇️', '↙️', '⬅️', '↖️', '↕️', '↔️', '↩️', '↪️', '⤴️', '⤵️', '🔃', '🔄', '🔙', '🔚', '🔛', '🔜', '🔝'
                                            ];
                                        @endphp
                                        @foreach($emojis as $emoji)
                                            <button type="button" class="emoji-item text-2xl hover:bg-gray-100 rounded p-1 transition-colors" data-emoji="{{ $emoji }}">{{ $emoji }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <form id="messageForm" method="POST" action="{{ route('apprenant.messages.send') }}" class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="receiver_id" id="receiverId" value="{{ $activeChatId }}">
                                    <button type="button" id="emojiBtn" class="p-2 text-gray-400 hover:text-gray-600 transition-colors relative">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                    </button>
                                    <input type="text" name="content" id="messageInput" placeholder="Message" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;" required>
                                    <button type="submit" class="p-3 text-white rounded-lg transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="flex-1 flex items-center justify-center bg-gray-50">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg">Sélectionnez une conversation pour commencer</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Profile dropdown menu
        document.addEventListener('DOMContentLoaded', function() {
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
                    if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                        profileDropdownMenu.classList.add('hidden');
                    }
                });

                profileDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }


            // Gestion du chat
            console.log('🔍 [DEBUG] ===== Initialisation du chat =====');
            const chatItems = document.querySelectorAll('.chat-item');
            const messageForm = document.getElementById('messageForm');
            const messageInput = document.getElementById('messageInput');
            const messagesArea = document.getElementById('messagesArea');
            const receiverIdInput = document.getElementById('receiverId');
            const searchContacts = document.getElementById('searchContacts');
            const chatHeader = document.getElementById('chatHeader');
            const messageInputContainer = document.getElementById('messageInputContainer');
            const chatPanel = document.getElementById('chatPanel');
            
            console.log('🔍 [DEBUG] Éléments DOM au chargement:');
            console.log('  - chatItems:', chatItems.length, 'contacts trouvés');
            console.log('  - messageForm:', messageForm ? '✅ trouvé' : '❌ NON TROUVÉ');
            console.log('  - messageInput:', messageInput ? '✅ trouvé' : '❌ NON TROUVÉ');
            console.log('  - messagesArea:', messagesArea ? '✅ trouvé' : '❌ NON TROUVÉ');
            console.log('  - receiverIdInput:', receiverIdInput ? '✅ trouvé' : '❌ NON TROUVÉ');
            console.log('  - chatHeader:', chatHeader ? '✅ trouvé' : '❌ NON TROUVÉ');
            console.log('  - messageInputContainer:', messageInputContainer ? '✅ trouvé' : '❌ NON TROUVÉ');
            console.log('  - chatPanel:', chatPanel ? '✅ trouvé' : '❌ NON TROUVÉ');
            
            
            if (!chatHeader) {
                console.error('❌ [DEBUG] ERREUR CRITIQUE: chatHeader non trouvé dans le DOM!');
            }
            if (!messagesArea) {
                console.error('❌ [DEBUG] ERREUR CRITIQUE: messagesArea non trouvé dans le DOM!');
            }
            if (!messageInputContainer) {
                console.warn('⚠️ [DEBUG] ATTENTION: messageInputContainer non trouvé dans le DOM (sera créé si nécessaire)');
            }
            if (!chatPanel) {
                console.error('❌ [DEBUG] ERREUR CRITIQUE: chatPanel non trouvé dans le DOM!');
            }

            // Recherche de contacts
            if (searchContacts) {
                searchContacts.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    chatItems.forEach(item => {
                        const contactName = item.querySelector('.text-sm.font-semibold')?.textContent.toLowerCase() || '';
                        if (contactName.includes(searchTerm)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }

            // Gérer le clic sur un contact ou un groupe
            console.log('🔍 [DEBUG] Initialisation des clics sur contacts. Nombre de contacts:', chatItems.length);
            chatItems.forEach((item, index) => {
                const userId = item.getAttribute('data-user-id');
                const groupId = item.getAttribute('data-group-id');
                const isGroup = !!groupId;
                console.log(`🔍 [DEBUG] Contact ${index + 1}: userId=${userId}, groupId=${groupId}, isGroup=${isGroup}, élément:`, item);
                
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const userId = this.getAttribute('data-user-id');
                    const groupId = this.getAttribute('data-group-id');
                    const isGroup = !!groupId;
                    
                    console.log('🔍 [DEBUG] ===== CLIC SUR CONTACT/GROUPE =====');
                    console.log('🔍 [DEBUG] userId:', userId, 'groupId:', groupId, 'isGroup:', isGroup);
                    console.log('🔍 [DEBUG] Élément cliqué:', this);
                    
                    // Si c'est un groupe, gérer différemment
                    if (isGroup) {
                        console.log('🔍 [DEBUG] Clic sur un groupe, redirection vers l\'URL du groupe');
                        // La redirection est déjà gérée par onclick dans le HTML
                        return;
                    }
                    
                    if (!userId) {
                        console.error('❌ [DEBUG] ERREUR: userId est null ou undefined!');
                        alert('Erreur: Impossible de récupérer l\'ID du contact');
                        return;
                    }
                    
                    // Mettre à jour l'état actif
                    chatItems.forEach(ci => {
                        ci.classList.remove('active');
                        ci.style.backgroundColor = '';
                        ci.style.borderLeft = '';
                    });
                    this.classList.add('active');
                    this.style.backgroundColor = 'rgba(26, 31, 58, 0.1)';
                    this.style.borderLeft = '4px solid #1a1f3a';
                    console.log('✅ [DEBUG] État actif mis à jour');
                    
                    // SÉCURITÉ : Mettre à jour le receiverId dans le formulaire AVANT de charger les messages
                    if (receiverIdInput) {
                        receiverIdInput.value = userId;
                        console.log('✅ [DEBUG] receiverIdInput mis à jour:', receiverIdInput.value);
                    } else {
                        console.error('❌ [DEBUG] ERREUR: receiverIdInput est null!');
                    }
                    
                    // Afficher le panneau de chat
                    const chatHeader = document.getElementById('chatHeader');
                    const messageInputContainer = document.getElementById('messageInputContainer');
                    const chatPanel = document.getElementById('chatPanel');
                    
                    console.log('🔍 [DEBUG] Éléments DOM:');
                    console.log('  - chatHeader:', chatHeader ? '✅ trouvé' : '❌ NON TROUVÉ');
                    console.log('  - messagesArea:', messagesArea ? '✅ trouvé' : '❌ NON TROUVÉ');
                    console.log('  - messageInputContainer:', messageInputContainer ? '✅ trouvé' : '❌ NON TROUVÉ');
                    console.log('  - chatPanel:', chatPanel ? '✅ trouvé' : '❌ NON TROUVÉ');
                    
                    if (chatHeader) {
                        chatHeader.style.display = 'block';
                        console.log('✅ [DEBUG] chatHeader affiché');
                    } else {
                        console.error('❌ [DEBUG] ERREUR: chatHeader non trouvé!');
                    }
                    
                    // CRITIQUE : S'assurer que messagesArea est visible et dans le DOM
                    if (messagesArea) {
                        console.log('✅ [DEBUG] messagesArea trouvé et visible');
                    } else {
                        console.error('❌ [DEBUG] ERREUR CRITIQUE: messagesArea non trouvé dans le DOM!');
                        // Essayer de le trouver à nouveau
                        const messagesAreaRetry = document.getElementById('messagesArea');
                        if (messagesAreaRetry) {
                            console.log('✅ [DEBUG] messagesArea trouvé à la deuxième tentative');
                        } else {
                            console.error('❌ [DEBUG] ERREUR CRITIQUE: messagesArea n\'existe toujours pas!');
                        }
                    }
                    
                    // S'assurer que messageInputContainer est visible
                    if (messageInputContainer) {
                        console.log('✅ [DEBUG] messageInputContainer trouvé et visible');
                    } else {
                        console.warn('⚠️ [DEBUG] messageInputContainer non trouvé');
                    }
                    
                    // S'assurer que le formulaire est visible
                    const messageForm = document.getElementById('messageForm');
                    if (messageForm) {
                        messageForm.style.display = 'flex';
                        messageForm.style.visibility = 'visible';
                        console.log('✅ [DEBUG] messageForm affiché et forcé visible');
                    } else {
                        console.error('❌ [DEBUG] ERREUR CRITIQUE: messageForm non trouvé!');
                    }
                    
                    // NE PAS vider le conteneur ici - laisser displayMessages gérer cela
                    // Cela évite de perdre les messages quand on revient sur un contact
                    console.log('✅ [DEBUG] Contact cliqué, chargement des messages sans vider le conteneur');
                    
                    // Réinitialiser lastMessageIds pour le nouveau contact
                    if (typeof lastMessageIds !== 'undefined') {
                        lastMessageIds.clear();
                        console.log('✅ [DEBUG] lastMessageIds réinitialisé');
                    }
                    
                    // Sauvegarder l'onglet actif dans l'URL et localStorage
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('chat', userId);
                    window.history.pushState({ chat: userId }, '', currentUrl.toString());
                    localStorage.setItem('activeChatId', userId);
                    
                    // Charger les messages
                    console.log('🔍 [DEBUG] Appel de loadThread avec userId:', userId);
                    loadThread(userId);
                });
            });
            
            // Restaurer l'onglet actif au chargement de la page
            document.addEventListener('DOMContentLoaded', function() {
                // Vérifier d'abord l'URL, puis localStorage
                const urlParams = new URLSearchParams(window.location.search);
                let activeChatId = urlParams.get('chat');
                
                if (!activeChatId) {
                    activeChatId = localStorage.getItem('activeChatId');
                }
                
                if (activeChatId) {
                    // Attendre un peu pour que le DOM soit complètement chargé
                    setTimeout(function() {
                        // Vérifier si c'est un groupe
                        if (activeChatId.startsWith('group_')) {
                            const groupId = activeChatId.replace('group_', '');
                            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
                            if (chatItem) {
                                console.log('✅ [DEBUG] Restauration du groupe actif:', activeChatId);
                                chatItem.click();
                            } else {
                                console.warn('⚠️ [DEBUG] Groupe actif non trouvé:', activeChatId);
                            }
                        } else {
                            const chatItem = document.querySelector(`.chat-item[data-user-id="${activeChatId}"]`);
                            if (chatItem) {
                                console.log('✅ [DEBUG] Restauration de l\'onglet actif:', activeChatId);
                                chatItem.click();
                            } else {
                                console.warn('⚠️ [DEBUG] Onglet actif non trouvé:', activeChatId);
                            }
                        }
                    }, 100);
                }
            });

            // Charger le thread de messages
            function loadThread(receiverId) {
                console.log('🔍 [DEBUG] ===== loadThread appelé =====');
                console.log('🔍 [DEBUG] receiverId:', receiverId);
                console.log('🔍 [DEBUG] Type de receiverId:', typeof receiverId);
                
                if (!receiverId) {
                    console.error('❌ [DEBUG] ERREUR: receiverId est null ou undefined dans loadThread!');
                    alert('Erreur: ID du destinataire manquant');
                    return;
                }
                
                // LOG : État du conteneur AVANT la requête
                const messagesAreaBefore = document.getElementById('messagesArea');
                const messagesBeforeCount = messagesAreaBefore ? messagesAreaBefore.querySelectorAll('[data-message-id]').length : 0;
                console.log('🔍 [DEBUG loadThread] AVANT requête:');
                console.log('   - messagesArea existe:', !!messagesAreaBefore);
                console.log('   - Messages affichés:', messagesBeforeCount);
                if (messagesAreaBefore) {
                    console.log('   - Contenu du conteneur (premiers 200 chars):', messagesAreaBefore.textContent.substring(0, 200));
                }
                
                const baseUrl = '{{ url("/apprenant/messages/thread") }}';
                const url = `${baseUrl}/${receiverId}`;
                console.log('🔍 [DEBUG] URL de la requête:', url);
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('🔍 [DEBUG] Réponse reçue, status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('🔍 [DEBUG loadThread] Données reçues:', data);
                    if (data.success) {
                        const messagesReceived = data.messages ? data.messages.length : 0;
                        const adminMessagesReceived = data.messages ? data.messages.filter(m => 
                            (m.sender && m.sender.role === 'admin') || (m.receiver && m.receiver.role === 'admin')
                        ).length : 0;
                        console.log(`✅ [DEBUG loadThread] Succès! ${messagesReceived} messages reçus, dont ${adminMessagesReceived} avec admin`);
                        console.log('🔍 [DEBUG loadThread] Receiver:', data.receiver);
                        console.log('🔍 [DEBUG loadThread] Message IDs reçus:', data.messages ? data.messages.map(m => m.id) : []);
                        
                        // LOG : Messages actuellement affichés AVANT displayMessages
                        const messagesBeforeDisplay = messagesArea ? messagesArea.querySelectorAll('[data-message-id]').length : 0;
                        const messageIdsBeforeDisplay = messagesArea ? Array.from(messagesArea.querySelectorAll('[data-message-id]')).map(msg => 
                            parseInt(msg.getAttribute('data-message-id'))
                        ) : [];
                        console.log(`🔍 [DEBUG loadThread] Messages actuellement affichés AVANT displayMessages: ${messagesBeforeDisplay}`);
                        console.log(`🔍 [DEBUG loadThread] Message IDs actuellement affichés:`, messageIdsBeforeDisplay);
                        
                        // SÉCURITÉ : Mettre à jour le receiverId dans le formulaire
                        if (receiverIdInput) {
                            receiverIdInput.value = receiverId;
                            console.log('✅ [DEBUG loadThread] receiverIdInput mis à jour:', receiverIdInput.value);
                        } else {
                            console.error('❌ [DEBUG loadThread] ERREUR: receiverIdInput est null!');
                        }
                        
                        // S'assurer que le formulaire est visible
                        const messageForm = document.getElementById('messageForm');
                        if (messageForm) {
                            messageForm.style.display = 'flex';
                            console.log('✅ [DEBUG loadThread] messageForm affiché');
                        } else {
                            console.log('🔍 [DEBUG loadThread] messageForm non trouvé (sera créé si nécessaire)');
                        }
                        
                        displayMessages(data.messages, data.receiver);
                        
                        // Marquer les messages comme lus
                        markMessagesAsRead(receiverId);
                        
                        // LOG : Messages affichés APRÈS displayMessages
                        setTimeout(() => {
                            const messagesAfterDisplay = messagesArea ? messagesArea.querySelectorAll('[data-message-id]').length : 0;
                            const messageIdsAfterDisplay = messagesArea ? Array.from(messagesArea.querySelectorAll('[data-message-id]')).map(msg => 
                                parseInt(msg.getAttribute('data-message-id'))
                            ) : [];
                            console.log(`🔍 [DEBUG loadThread] Messages affichés APRÈS displayMessages: ${messagesAfterDisplay}`);
                            console.log(`🔍 [DEBUG loadThread] Message IDs affichés:`, messageIdsAfterDisplay);
                            
                            // Vérifier si des messages avec admin ont disparu
                            if (data.messages) {
                                const adminMessageIdsReceived = data.messages
                                    .filter(m => (m.sender && m.sender.role === 'admin') || (m.receiver && m.receiver.role === 'admin'))
                                    .map(m => m.id);
                                const adminMessageIdsDisplayed = messageIdsAfterDisplay.filter(id => 
                                    adminMessageIdsReceived.includes(id)
                                );
                                
                                if (adminMessageIdsReceived.length > adminMessageIdsDisplayed.length) {
                                    console.error(`❌ [DEBUG loadThread] ALERTE CRITIQUE: Messages avec admin PERDUS lors de l'affichage! Reçus: ${adminMessageIdsReceived.length}, Affichés: ${adminMessageIdsDisplayed.length}`);
                                    console.error(`❌ [DEBUG loadThread] Message IDs avec admin reçus:`, adminMessageIdsReceived);
                                    console.error(`❌ [DEBUG loadThread] Message IDs avec admin affichés:`, adminMessageIdsDisplayed);
                                } else {
                                    console.log(`✅ [DEBUG loadThread] Tous les messages avec admin sont présents: ${adminMessageIdsDisplayed.length}/${adminMessageIdsReceived.length}`);
                                }
                            }
                        }, 500);
                    } else {
                        console.error('❌ [DEBUG loadThread] Échec de la requête:', data.message);
                        alert(data.message || 'Erreur lors du chargement des messages');
                    }
                })
                .catch(error => {
                    console.error('❌ [DEBUG] ERREUR dans loadThread:', error);
                    console.error('❌ [DEBUG] Stack trace:', error.stack);
                    alert('Erreur lors du chargement des messages: ' + error.message);
                });
            }

            // Afficher les messages
            function displayMessages(messages, receiver) {
                console.log('🔍 [DEBUG] ===== displayMessages appelé =====');
                console.log('🔍 [DEBUG] Nombre de messages reçus:', messages ? messages.length : 0);
                console.log('🔍 [DEBUG] Receiver:', receiver);
                console.log('🔍 [DEBUG] Receiver ID:', receiver ? receiver.id : 'N/A');
                console.log('🔍 [DEBUG] Receiver role:', receiver ? receiver.role : 'N/A');
                console.log('🔍 [DEBUG] Messages complets:', messages);
                
                if (!receiver) {
                    console.error('❌ [DEBUG] ERREUR: receiver est null ou undefined!');
                    return;
                }
                
                if (!messages || !Array.isArray(messages)) {
                    console.error('❌ [DEBUG] ERREUR: messages n\'est pas un tableau!', messages);
                    console.error('   - Type de messages:', typeof messages);
                    return;
                }
                
                if (messages.length === 0) {
                    console.log('⚠️ [DEBUG] Aucun message à afficher (tableau vide)');
                }
                
                // SÉCURITÉ CRITIQUE : Vérifier que les messages appartiennent bien à ce receiver
                // Déclarer currentUserId une seule fois au début de la fonction
                const currentUserId = {{ $user->id }};
                console.log('🔍 [DEBUG] currentUserId:', currentUserId);
                console.log('🔍 [DEBUG] receiver.id:', receiver.id);
                
                const originalLength = messages.length;
                const adminMessagesBefore = messages.filter(m => 
                    (m.sender && m.sender.role === 'admin') || (m.receiver && m.receiver.role === 'admin')
                ).length;
                console.log(`🔍 [DEBUG displayMessages] AVANT FILTRAGE: ${originalLength} messages, dont ${adminMessagesBefore} avec admin`);
                console.log(`🔍 [DEBUG displayMessages] Message IDs avant filtrage:`, messages.map(m => m.id));
                
                messages = messages.filter(function(message) {
                    // SÉCURITÉ CRITIQUE : Message doit être soit envoyé par l'utilisateur connecté au receiver, soit envoyé par le receiver à l'utilisateur connecté
                    // Cette vérification s'applique AUSSI aux messages système (Appel manqué, Appel terminé)
                    const isFromUser = message.sender_id == currentUserId && message.receiver_id == receiver.id;
                    const isToUser = message.sender_id == receiver.id && message.receiver_id == currentUserId;
                    
                    // SÉCURITÉ : Les messages système doivent aussi respecter cette règle stricte
                    // Un message système ne doit apparaître que dans la conversation entre l'utilisateur connecté et le receiver
                    const isSystemMessage = message.label === 'System' || 
                                          (message.content && (
                                              message.content.includes('📞❌') || 
                                              message.content.includes('📞✅') ||
                                              message.content.includes('Appel manqué') ||
                                              message.content.includes('Appel terminé')
                                          ));
                    
                    // Si c'est un message système, vérifier qu'il appartient bien à cette conversation
                    if (isSystemMessage) {
                        // Le message système doit être entre l'utilisateur connecté et le receiver actuel
                        const systemMessageValid = isFromUser || isToUser;
                        if (!systemMessageValid) {
                            console.warn(`⚠️ [SÉCURITÉ] Message système (ID: ${message.id}) filtré - n'appartient pas à cette conversation. sender_id: ${message.sender_id}, receiver_id: ${message.receiver_id}, currentUserId: ${currentUserId}, receiver.id: ${receiver.id}`);
                        }
                        return systemMessageValid;
                    }
                    
                    // SÉCURITÉ CRITIQUE : Les messages avec l'admin sont TOUJOURS valides et ne doivent JAMAIS être supprimés
                    // MAIS seulement si le receiver actuel est l'admin OU si c'est une conversation avec l'admin
                    const isWithAdmin = (message.sender && message.sender.role === 'admin') || 
                                       (message.receiver && message.receiver.role === 'admin');
                    
                    if (isWithAdmin) {
                        // L'admin peut être soit le sender, soit le receiver
                        const adminIsSender = message.sender && message.sender.role === 'admin';
                        const adminIsReceiver = message.receiver && message.receiver.role === 'admin';
                        
                        // Vérifier que l'autre partie est bien l'utilisateur connecté
                        const otherPartyIsUser = (adminIsSender && message.receiver_id == currentUserId) || 
                                                (adminIsReceiver && message.sender_id == currentUserId);
                        
                        // Si le receiver actuel est l'admin, inclure TOUS les messages entre l'admin et l'utilisateur
                        if (receiver.role === 'admin' && otherPartyIsUser) {
                            return true;
                        }
                        
                        // Si le message implique l'admin et l'utilisateur, l'inclure même si le receiver n'est pas l'admin
                        // (cas où on affiche les messages d'une conversation avec l'admin)
                        if (otherPartyIsUser) {
                            return true;
                        }
                    }
                    
                    // Sinon, vérifier normalement (message entre l'utilisateur connecté et le receiver)
                    return isFromUser || isToUser;
                });
                
                const adminMessagesAfter = messages.filter(m => 
                    (m.sender && m.sender.role === 'admin') || (m.receiver && m.receiver.role === 'admin')
                ).length;
                console.log(`🔍 [DEBUG displayMessages] APRÈS FILTRAGE: ${messages.length} messages, dont ${adminMessagesAfter} avec admin`);
                console.log(`🔍 [DEBUG displayMessages] Message IDs après filtrage:`, messages.map(m => m.id));
                
                if (adminMessagesBefore > adminMessagesAfter) {
                    console.error(`❌ [DEBUG displayMessages] ALERTE CRITIQUE: Messages avec admin PERDUS! Avant: ${adminMessagesBefore}, Après: ${adminMessagesAfter}`);
                }
                
                console.log(`✅ [DEBUG displayMessages] Messages filtrés: ${messages.length} sur ${originalLength} (les messages avec l'admin sont toujours conservés)`);
                
                // Mettre à jour le header du chat
                const chatHeader = document.querySelector('#chatHeader');
                console.log('🔍 [DEBUG] chatHeader trouvé:', chatHeader ? '✅' : '❌');
                if (chatHeader && receiver) {
                    const receiverName = (receiver.prenom || '') + ' ' + (receiver.nom || '');
                    const receiverInitials = ((receiver.prenom || '').charAt(0) + (receiver.nom || '').charAt(0)).toUpperCase();
                    
                    // Calculer le statut en ligne
                    let isOnline = false;
                    let statusText = 'Jamais en ligne';
                    let statusColor = 'text-gray-500';
                    let statusDotColor = 'bg-gray-400';
                    
                    if (receiver.last_seen) {
                        const lastSeen = new Date(receiver.last_seen);
                        const now = new Date();
                        const diffMinutes = Math.floor((now - lastSeen) / (1000 * 60));
                        isOnline = diffMinutes < 5;
                        
                        if (isOnline) {
                            statusText = 'En ligne';
                            statusColor = 'text-green-600';
                            statusDotColor = 'bg-green-500';
                        } else {
                            // Formater le temps de manière naturelle
                            const diffHours = Math.floor(diffMinutes / 60);
                            const diffDays = Math.floor(diffHours / 24);
                            const diffWeeks = Math.floor(diffDays / 7);
                            const diffMonths = Math.floor(diffDays / 30);
                            
                            if (diffMinutes < 60) {
                                statusText = `En ligne il y a ${diffMinutes} minute${diffMinutes > 1 ? 's' : ''}`;
                            } else if (diffHours < 24) {
                                statusText = `En ligne il y a ${diffHours} heure${diffHours > 1 ? 's' : ''}`;
                            } else if (diffDays < 7) {
                                statusText = `En ligne il y a ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
                            } else if (diffWeeks < 4) {
                                statusText = `En ligne il y a ${diffWeeks} semaine${diffWeeks > 1 ? 's' : ''}`;
                            } else if (diffMonths < 12) {
                                statusText = `En ligne il y a ${diffMonths} mois`;
                            } else {
                                const diffYears = Math.floor(diffMonths / 12);
                                statusText = `En ligne il y a ${diffYears} an${diffYears > 1 ? 's' : ''}`;
                            }
                        }
                    }
                    
                    const headerContent = `
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    ${receiver.photo ? `<img src="/storage/${receiver.photo}" alt="${receiverName}" class="w-12 h-12 rounded-full object-cover">` : `<div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">${receiverInitials}</div>`}
                                    <span class="absolute bottom-0 right-0 w-3 h-3 ${statusDotColor} border-2 border-white rounded-full"></span>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-gray-900">${receiverName}</p>
                                    <p class="text-sm ${statusColor} font-medium">${statusText}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Appeler
                                </button>
                                <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Appel video
                                </button>
                            </div>
                        </div>
                    `;
                    chatHeader.innerHTML = headerContent;
                }

                // CRITIQUE : Récupérer messagesArea à chaque fois pour s'assurer qu'il existe
                const messagesArea = document.getElementById('messagesArea');
                if (!messagesArea) {
                    console.error('❌ [DEBUG displayMessages] ERREUR CRITIQUE: messagesArea non trouvé dans le DOM!');
                    // Essayer de le trouver à nouveau après un court délai
                    setTimeout(() => {
                        const messagesAreaRetry = document.getElementById('messagesArea');
                        if (messagesAreaRetry) {
                            console.log('✅ [DEBUG displayMessages] messagesArea trouvé à la deuxième tentative, réaffichage des messages...');
                            displayMessages(messages, receiver);
                        } else {
                            console.error('❌ [DEBUG displayMessages] ERREUR CRITIQUE: messagesArea n\'existe toujours pas après délai!');
                        }
                    }, 100);
                    return;
                }
                
                // messagesArea est maintenant directement le conteneur avec class="space-y-4"
                const messagesContainer = messagesArea;
                console.log('🔍 [DEBUG displayMessages] messagesContainer (messagesArea) trouvé:', messagesContainer ? '✅' : '❌');
                
                if (!messagesContainer) {
                    console.error('❌ [DEBUG displayMessages] ERREUR: messagesContainer (messagesArea) non trouvé!');
                    return;
                }

                console.log('🔍 [DEBUG displayMessages] messagesContainer trouvé:');
                console.log('   - Classe:', messagesContainer.className);
                console.log('   - Contenu avant vidage (premiers 300 chars):', messagesContainer.innerHTML.substring(0, 300));
                console.log('   - Nombre d\'enfants:', messagesContainer.children.length);
                
                // SÉCURITÉ CRITIQUE : Vérifier d'abord que le receiver correspond bien au receiverId actuel
                const currentReceiverId = receiverIdInput ? receiverIdInput.value : null;
                console.log('🔍 [DEBUG] Vérification de sécurité:');
                console.log('  - currentReceiverId:', currentReceiverId);
                console.log('  - receiver.id:', receiver.id);
                if (currentReceiverId && receiver.id != currentReceiverId) {
                    console.error('❌ [DEBUG] SÉCURITÉ : Tentative d\'afficher des messages d\'un autre contact !');
                    return;
                }
                
                // OPTIMISATION : Vérifier si les messages ont changé avant de vider le conteneur
                // Récupérer les IDs des messages actuellement affichés
                const existingMessageIds = new Set();
                if (messagesContainer) {
                    messagesContainer.querySelectorAll('[data-message-id]').forEach(msg => {
                        const msgId = parseInt(msg.getAttribute('data-message-id'));
                        if (msgId) {
                            existingMessageIds.add(msgId);
                        }
                    });
                }
                
                // Récupérer les IDs des nouveaux messages
                const newMessageIds = new Set(messages.map(m => m.id));
                
                // Vérifier si les messages sont identiques (mêmes IDs)
                // Comparer les tailles et le contenu des Sets
                const messagesChanged = existingMessageIds.size !== newMessageIds.size || 
                    !Array.from(existingMessageIds).every(id => newMessageIds.has(id)) ||
                    !Array.from(newMessageIds).every(id => existingMessageIds.has(id));
                
                console.log('🔍 [DEBUG] Comparaison des messages:');
                console.log('  - Messages existants:', Array.from(existingMessageIds).sort((a, b) => a - b));
                console.log('  - Nouveaux messages:', Array.from(newMessageIds).sort((a, b) => a - b));
                console.log('  - Taille existants:', existingMessageIds.size);
                console.log('  - Taille nouveaux:', newMessageIds.size);
                console.log('  - Messages ont changé:', messagesChanged);
                
                // SOLUTION ULTRA-SIMPLE : Toujours vider et réafficher les messages
                // Ne jamais garder les messages existants - toujours afficher les nouveaux
                // Cela garantit que les messages s'affichent toujours correctement
                console.log('🔍 [DEBUG displayMessages] AVANT vidage du conteneur:');
                console.log('   - Contenu HTML:', messagesContainer.innerHTML.substring(0, 500));
                console.log('   - Nombre d\'éléments:', messagesContainer.children.length);
                
                messagesContainer.innerHTML = '';
                console.log('✅ [DEBUG displayMessages] Conteneur vidé pour afficher les messages');
                console.log('   - Contenu HTML après vidage:', messagesContainer.innerHTML);
                console.log('   - Nombre d\'éléments après vidage:', messagesContainer.children.length);
                
                if (typeof lastMessageIds !== 'undefined') {
                    lastMessageIds.clear();
                    console.log('✅ [DEBUG displayMessages] lastMessageIds réinitialisé');
                } else {
                    console.log('⚠️ [DEBUG displayMessages] lastMessageIds n\'est pas défini');
                }
                
                if (messages.length === 0) {
                    console.log('🔍 [DEBUG displayMessages] Aucun message reçu du serveur');
                    
                    // Vérifier si les messages existants appartiennent au receiver actuel
                    const existingMessages = messagesContainer.querySelectorAll('[data-message-id]');
                    const existingMessageIds = Array.from(existingMessages).map(msg => parseInt(msg.getAttribute('data-message-id')));
                    
                    console.log('🔍 [DEBUG displayMessages] Messages existants dans le conteneur:', existingMessageIds.length);
                    console.log('🔍 [DEBUG displayMessages] Receiver actuel:', receiver.id);
                    
                    // Si le conteneur est vide ou ne contient que des messages qui ne correspondent pas au receiver actuel
                    // Alors afficher "Aucun message"
                    if (existingMessageIds.length === 0) {
                        console.log('🔍 [DEBUG displayMessages] Conteneur vide, affichage "Aucun message"');
                        messagesContainer.innerHTML = '<div class="text-center py-12"><p class="text-sm text-gray-500">Aucun message dans cette conversation</p></div>';
                    } else {
                        // Le conteneur contient des messages, mais le serveur retourne 0 messages
                        // Cela signifie qu'on a changé de contact et que ce contact n'a pas de messages
                        // Vider le conteneur et afficher "Aucun message"
                        console.log('🔍 [DEBUG displayMessages] Conteneur contient des messages mais serveur retourne 0 - vider et afficher "Aucun message"');
                        messagesContainer.innerHTML = '<div class="text-center py-12"><p class="text-sm text-gray-500">Aucun message dans cette conversation</p></div>';
                    }
                    return;
                }
                
                console.log('🔍 [DEBUG displayMessages] Affichage de', messages.length, 'messages');
                console.log('🔍 [DEBUG displayMessages] currentUserId:', currentUserId);
                console.log('🔍 [DEBUG displayMessages] receiver.id:', receiver.id);

                // currentUserId est déjà déclaré plus haut dans la fonction
                let newMessagesAdded = false;
                let messagesDisplayed = 0;
                
                console.log('🔍 [DEBUG displayMessages] Début de l\'affichage des messages');
                console.log('   - messagesContainer existe toujours:', !!messagesContainer);
                console.log('   - messagesContainer parent:', messagesContainer.parentElement ? messagesContainer.parentElement.id : 'N/A');
                
                messages.forEach((message, index) => {
                    // Vérifier si le message n'est pas déjà affiché (double vérification)
                    // Note: lastMessageIds a été réinitialisé, donc cette vérification ne devrait pas bloquer
                    if (typeof lastMessageIds !== 'undefined' && lastMessageIds.has(message.id)) {
                        console.log(`🔍 [DEBUG] Message ${index + 1} (ID: ${message.id}) déjà affiché, ignoré`);
                        return;
                    }
                    const existingMessage = messagesContainer.querySelector(`[data-message-id="${message.id}"]`);
                    if (existingMessage) {
                        console.log(`🔍 [DEBUG] Message ${index + 1} (ID: ${message.id}) existe déjà dans le DOM, ignoré`);
                        lastMessageIds.add(message.id);
                        return;
                    }
                    
                    // Ajouter l'ID à la liste des messages affichés
                    lastMessageIds.add(message.id);
                    console.log(`🔍 [DEBUG] Affichage du message ${index + 1}/${messages.length}, ID: ${message.id}`);
                    
                    newMessagesAdded = true;
                    const isSender = message.sender_id == currentUserId;
                    const otherUser = isSender ? message.receiver : message.sender;
                    const senderName = (otherUser.prenom || '') + ' ' + (otherUser.nom || '');
                    const messageDate = new Date(message.created_at);
                    // Format de date identique à l'admin : d/m/Y H:i
                    const day = String(messageDate.getDate()).padStart(2, '0');
                    const month = String(messageDate.getMonth() + 1).padStart(2, '0');
                    const year = messageDate.getFullYear();
                    const hours = String(messageDate.getHours()).padStart(2, '0');
                    const minutes = String(messageDate.getMinutes()).padStart(2, '0');
                    const timeFormat = `${day}/${month}/${year} ${hours}:${minutes}`;

                    // Créer l'élément du message
                    // Vérifier si c'est un message système
                    const isSystemMessage = message.label === 'System' || 
                                          (message.content && (
                                              message.content.includes('📞❌') || 
                                              message.content.includes('📞✅') ||
                                              message.content.includes('Appel manqué') ||
                                              message.content.includes('Appel terminé')
                                          ));

                    const messageDiv = document.createElement('div');
                    messageDiv.setAttribute('data-message-id', message.id);

                    if (isSystemMessage) {
                        // Message système aligné à droite comme les messages envoyés (style WhatsApp)
                        messageDiv.className = 'flex items-start gap-3 justify-end my-2';
                        messageDiv.innerHTML = `
                            <div class="flex-1 flex justify-end">
                                <div class="max-w-[70%]">
                                    <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                        <p class="text-xs text-gray-600">${escapeHtml(message.content)}</p>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1 text-right">${timeFormat}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        messageDiv.className = isSender ? 'flex items-start gap-3 justify-end' : 'flex items-start gap-3';
                    if (isSender) {
                        messageDiv.innerHTML = `
                            <div class="flex-1 flex justify-end">
                                <div class="max-w-[70%]">
                                    <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                        <p class="text-sm">${escapeHtml(message.content)}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 text-right">${timeFormat}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        messageDiv.innerHTML = `
                            <div class="flex-1">
                                <div class="inline-block max-w-[70%]">
                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                        <p class="text-sm text-gray-700">${escapeHtml(message.content)}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">${timeFormat}</p>
                                </div>
                            </div>
                        `;
                        }
                    }
                    
                    // Ajouter le message au conteneur
                    console.log(`🔍 [DEBUG displayMessages] Ajout du message ${index + 1}/${messages.length} (ID: ${message.id}) au conteneur`);
                    console.log('   - messagesContainer existe:', !!messagesContainer);
                    console.log('   - messageDiv créé:', !!messageDiv);
                    
                    if (!messagesContainer) {
                        console.error(`❌ [DEBUG displayMessages] ERREUR: messagesContainer n'existe plus lors de l'ajout du message ${message.id}!`);
                        return;
                    }
                    
                    messagesContainer.appendChild(messageDiv);
                    messagesDisplayed++;
                    
                    // Vérifier immédiatement si le message a été ajouté
                    const checkImmediate = messagesContainer.querySelector(`[data-message-id="${message.id}"]`);
                    console.log(`   - Message ajouté au DOM (vérification immédiate):`, checkImmediate ? '✅' : '❌');
                    
                    // LOG : Vérifier si c'est un message avec admin
                    const isWithAdmin = (message.sender && message.sender.role === 'admin') || 
                                      (message.receiver && message.receiver.role === 'admin');
                    if (isWithAdmin) {
                        console.log(`✅ [DEBUG displayMessages] Message avec admin ajouté au DOM - ID: ${message.id}`);
                        // Vérifier immédiatement après l'ajout
                        // Utiliser une référence directe à l'élément plutôt que querySelector
                        setTimeout(() => {
                            // Vérifier d'abord si le conteneur existe toujours
                            const currentContainer = messagesArea;
                            if (!currentContainer) {
                                console.error(`❌ [DEBUG displayMessages] ALERTE: messagesArea non trouvé après 100ms!`);
                                return;
                            }

                            // Vérifier si l'élément existe dans le conteneur
                            const checkElement = currentContainer.querySelector(`[data-message-id="${message.id}"]`);
                            if (!checkElement) {
                                // Vérifier si le conteneur a été vidé
                                const allMessages = currentContainer.querySelectorAll('[data-message-id]');
                                console.error(`❌ [DEBUG displayMessages] ALERTE: Message avec admin ${message.id} ajouté mais NON TROUVÉ dans le DOM après 100ms!`);
                                console.error(`   - Conteneur existe: ${currentContainer ? 'Oui' : 'Non'}`);
                                console.error(`   - Nombre de messages dans le conteneur: ${allMessages.length}`);
                                console.error(`   - IDs des messages dans le conteneur:`, Array.from(allMessages).map(m => m.getAttribute('data-message-id')));
                                
                                // Vérifier si messageDiv est toujours dans le DOM
                                if (messageDiv && messageDiv.parentNode) {
                                    console.error(`   - messageDiv est toujours dans le DOM, parent:`, messageDiv.parentNode);
                                } else {
                                    console.error(`   - messageDiv n'est plus dans le DOM!`);
                                }
                            } else {
                                console.log(`✅ [DEBUG displayMessages] Message avec admin ${message.id} vérifié et présent dans le DOM`);
                            }
                        }, 100);
                    } else {
                        console.log(`✅ [DEBUG displayMessages] Message ${index + 1} ajouté au DOM - ID: ${message.id}`);
                    }
                });
                
                console.log(`✅ [DEBUG displayMessages] Affichage terminé: ${messagesDisplayed} messages affichés sur ${messages.length}, newMessagesAdded: ${newMessagesAdded}`);
                
                // VÉRIFICATION FINALE : Compter les messages dans le DOM
                const finalMessages = messagesContainer.querySelectorAll('[data-message-id]');
                const finalMessageIds = Array.from(finalMessages).map(msg => parseInt(msg.getAttribute('data-message-id')));
                console.log('🔍 [DEBUG displayMessages] VÉRIFICATION FINALE:');
                console.log('   - Messages dans le DOM:', finalMessages.length);
                console.log('   - IDs des messages dans le DOM:', finalMessageIds);
                console.log('   - Contenu HTML du conteneur (premiers 500 chars):', messagesContainer.innerHTML.substring(0, 500));
                console.log('   - messagesContainer existe toujours:', !!messagesContainer);
                console.log('   - messagesContainer parent:', messagesContainer.parentElement ? messagesContainer.parentElement.id : 'N/A');
                console.log('   - messagesContainer parent existe:', !!messagesContainer.parentElement);
                console.log('   - messagesArea existe:', !!messagesArea);
                console.log('   - messagesArea dans le DOM:', messagesArea ? document.body.contains(messagesArea) : false);
                console.log('   - messagesContainer dans le DOM:', document.body.contains(messagesContainer));
                console.log('   - messagesContainer parent dans le DOM:', messagesContainer.parentElement ? document.body.contains(messagesContainer.parentElement) : false);
                
                // Vérifier si le conteneur est visible
                if (messagesContainer) {
                    const style = window.getComputedStyle(messagesContainer);
                    console.log('   - messagesContainer display:', style.display);
                    console.log('   - messagesContainer visibility:', style.visibility);
                    console.log('   - messagesContainer height:', style.height);
                    console.log('   - messagesContainer parent display:', messagesContainer.parentElement ? window.getComputedStyle(messagesContainer.parentElement).display : 'N/A');
                }
                
                if (finalMessages.length !== messagesDisplayed) {
                    console.error(`❌ [DEBUG displayMessages] ALERTE: Nombre de messages affichés (${messagesDisplayed}) ne correspond pas au nombre dans le DOM (${finalMessages.length})!`);
                }
                
                if (finalMessages.length === 0 && messages.length > 0) {
                    console.error(`❌ [DEBUG displayMessages] ERREUR CRITIQUE: Aucun message dans le DOM alors que ${messages.length} messages devraient être affichés!`);
                    console.error('   - Contenu complet du conteneur:', messagesContainer.innerHTML);
                    console.error('   - messagesContainer parent:', messagesContainer.parentElement);
                }
                
                // LOG FINAL : Vérifier tous les messages avec admin dans le DOM
                setTimeout(() => {
                    const allAdminMessagesInDOM = Array.from(messagesContainer.querySelectorAll('[data-message-id]')).filter(msg => {
                        const msgId = parseInt(msg.getAttribute('data-message-id'));
                        const originalMessage = messages.find(m => m.id === msgId);
                        return originalMessage && ((originalMessage.sender && originalMessage.sender.role === 'admin') || 
                                                  (originalMessage.receiver && originalMessage.receiver.role === 'admin'));
                    });
                    console.log(`🔍 [DEBUG displayMessages] VÉRIFICATION FINALE: ${allAdminMessagesInDOM.length} messages avec admin trouvés dans le DOM`);
                    if (allAdminMessagesInDOM.length < adminMessagesAfter) {
                        console.error(`❌ [DEBUG displayMessages] ALERTE CRITIQUE: Messages avec admin MANQUANTS dans le DOM! Attendu: ${adminMessagesAfter}, Trouvé: ${allAdminMessagesInDOM.length}`);
                    }
                }, 200);
                
                // Scroll vers le bas seulement si de nouveaux messages ont été ajoutés
                if (newMessagesAdded) {
                    console.log('🔍 [DEBUG] Scroll vers le bas...');
                    setTimeout(() => {
                        messagesArea.scrollTop = messagesArea.scrollHeight;
                        console.log('✅ [DEBUG] Scroll terminé');
                    }, 100);
                }
            }
            
            // Fonction pour marquer les messages comme lus
            function markMessagesAsRead(receiverId) {
                if (!receiverId) return;
                
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
                
                if (!token) {
                    console.error('Token CSRF non trouvé');
                    return;
                }
                
                fetch('{{ route("apprenant.messages.mark-as-read") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour le compteur dans la sidebar
                        updateUnreadCount(data.total_unread);
                        
                        // Mettre à jour le compteur dans la liste des contacts
                        updateContactUnreadCount(receiverId, 0);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du marquage des messages comme lus:', error);
                });
            }
            
            // Fonction pour mettre à jour le compteur de messages non lus dans la sidebar
            function updateUnreadCount(count) {
                const unreadBadge = document.querySelector('.unread-badge');
                const unreadText = document.querySelector('.unread-text');
                if (unreadBadge) {
                    unreadBadge.textContent = count;
                    if (count === 0) {
                        unreadBadge.style.display = 'none';
                    } else {
                        unreadBadge.style.display = 'flex';
                    }
                }
                if (unreadText) {
                    unreadText.textContent = count + ' nouveaux messages';
                }
            }
            
            // Fonction pour mettre à jour le compteur de messages non lus d'un contact spécifique
            function updateContactUnreadCount(userId, count) {
                const contactItem = document.querySelector(`.chat-item[data-user-id="${userId}"]`);
                if (contactItem) {
                    // Chercher le badge de messages non lus existant
                    let unreadBadge = contactItem.querySelector('.flex.items-center.justify-end span[style*="background: linear-gradient"]');
                    
                    if (count > 0) {
                        if (!unreadBadge) {
                            // Créer le badge s'il n'existe pas
                            const flexContainer = contactItem.querySelector('.flex.items-center.justify-end');
                            if (flexContainer) {
                                unreadBadge = document.createElement('span');
                                unreadBadge.className = 'w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white';
                                unreadBadge.style.background = 'linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)';
                                flexContainer.appendChild(unreadBadge);
                            }
                        }
                        if (unreadBadge) {
                            unreadBadge.textContent = count;
                            unreadBadge.style.display = 'flex';
                        }
                    } else {
                        // Supprimer le badge si count est 0
                        if (unreadBadge) {
                            unreadBadge.remove();
                        }
                        // Afficher la coche verte si le message a été lu
                        const flexContainer = contactItem.querySelector('.flex.items-center.justify-end');
                        if (flexContainer && !flexContainer.querySelector('svg')) {
                            const checkIcon = document.createElement('svg');
                            checkIcon.className = 'w-4 h-4 text-green-500';
                            checkIcon.setAttribute('fill', 'currentColor');
                            checkIcon.setAttribute('viewBox', '0 0 20 20');
                            checkIcon.innerHTML = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>';
                            flexContainer.appendChild(checkIcon);
                        }
                    }
                }
            }

            // Fonction pour échapper le HTML
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Envoyer un message - Utiliser la délégation d'événements pour que cela fonctionne même si le formulaire est créé dynamiquement
            document.addEventListener('submit', function(e) {
                // Vérifier si c'est le formulaire de message
                if (e.target && e.target.id === 'messageForm') {
                    e.preventDefault();
                    
                    const messageInput = document.getElementById('messageInput');
                    const receiverIdInput = document.getElementById('receiverId');
                    
                    if (!messageInput || !receiverIdInput) {
                        console.error('❌ [DEBUG] ERREUR: messageInput ou receiverIdInput non trouvé!');
                        return;
                    }
                    
                    const content = messageInput.value.trim();
                    if (!content) {
                        console.log('⚠️ [DEBUG] Message vide, envoi annulé');
                        return;
                    }
                    
                    if (!receiverIdInput.value) {
                        alert('Veuillez sélectionner un contact avant d\'envoyer un message');
                        return;
                    }

                    console.log('🔍 [DEBUG] Envoi du message à:', receiverIdInput.value);
                    console.log('🔍 [DEBUG] Contenu:', content);
                    
                    const formData = new FormData(e.target);
                    
                    fetch('{{ route("apprenant.messages.send") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('🔍 [DEBUG] Réponse reçue, status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('🔍 [DEBUG] Données reçues:', data);
                        if (data.success) {
                            messageInput.value = '';
                            console.log('✅ [DEBUG] Message envoyé avec succès, rechargement des messages...');
                            // Recharger les messages
                            if (receiverIdInput.value) {
                                loadThread(receiverIdInput.value);
                            }
                        } else {
                            console.error('❌ [DEBUG] Erreur lors de l\'envoi:', data.message);
                            alert(data.message || 'Erreur lors de l\'envoi du message');
                        }
                    })
                    .catch(error => {
                        console.error('❌ [DEBUG] Erreur:', error);
                        alert('Erreur lors de l\'envoi du message');
                    });
                }
            });

            // Emoji picker functionality - délégation d'événements
            // Utiliser la délégation d'événements pour gérer les clics même après chargement dynamique
            document.addEventListener('click', function(e) {
                // Gérer le clic sur le bouton emoji
                if (e.target.closest('#emojiBtn') || e.target.closest('#emojiBtn svg') || e.target.closest('#emojiBtn path')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const emojiBtn = document.getElementById('emojiBtn');
                    const emojiPicker = document.getElementById('emojiPicker');
                    if (emojiBtn && emojiPicker) {
                        const isHidden = emojiPicker.classList.contains('hidden');
                        if (isHidden) {
                            emojiPicker.classList.remove('hidden');
                        } else {
                            emojiPicker.classList.add('hidden');
                        }
                        return;
                    }
                }

                // Gérer le clic sur un emoji
                const emojiItem = e.target.closest('.emoji-item');
                if (emojiItem) {
                    e.preventDefault();
                    e.stopPropagation();
                    const emoji = emojiItem.getAttribute('data-emoji');
                    const messageInput = document.getElementById('messageInput');
                    const emojiPicker = document.getElementById('emojiPicker');
                    if (emoji && messageInput) {
                        const cursorPos = messageInput.selectionStart || messageInput.value.length;
                        const textBefore = messageInput.value.substring(0, cursorPos);
                        const textAfter = messageInput.value.substring(cursorPos);
                        messageInput.value = textBefore + emoji + textAfter;
                        messageInput.focus();
                        const newPos = cursorPos + emoji.length;
                        messageInput.setSelectionRange(newPos, newPos);
                        if (emojiPicker) {
                            emojiPicker.classList.add('hidden');
                        }
                    }
                    return;
                }

                // Fermer le sélecteur d'emojis si on clique ailleurs
                const emojiBtn = document.getElementById('emojiBtn');
                const emojiPicker = document.getElementById('emojiPicker');
                if (emojiBtn && emojiPicker && !emojiBtn.contains(e.target) && !emojiPicker.contains(e.target)) {
                    emojiPicker.classList.add('hidden');
                }
            });

            // Système de rafraîchissement automatique des messages
            let pollingInterval = null;
            let lastMessageIds = new Set(); // Stocker les IDs des messages déjà affichés

            function startMessagePolling() {
                // POLLING COMPLÈTEMENT DÉSACTIVÉ pour éviter que les messages disparaissent
                console.log('⚠️ [DEBUG] startMessagePolling appelé mais POLLING DÉSACTIVÉ');
                return; // Ne rien faire
                
                // CODE DÉSACTIVÉ - Ne pas démarrer le polling automatique
                // if (pollingInterval) {
                //     clearInterval(pollingInterval);
                // }
                // if (!receiverIdInput || !receiverIdInput.value) {
                //     return;
                // }
                // const messagesContainer = messagesArea.querySelector('.space-y-4');
                // if (messagesContainer) {
                //     lastMessageIds.clear();
                //     messagesContainer.querySelectorAll('[data-message-id]').forEach(msg => {
                //         const msgId = parseInt(msg.getAttribute('data-message-id'));
                //         if (msgId) {
                //             lastMessageIds.add(msgId);
                //         }
                //     });
                // }
                // pollingInterval = setInterval(function() {
                //     if (!receiverIdInput || !receiverIdInput.value) {
                //         clearInterval(pollingInterval);
                //         return;
                //     }
                //     const receiverId = receiverIdInput.value;
                //     loadThread(receiverId);
                // }, 5000);
            }

            function stopMessagePolling() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }
            }

            // DÉSACTIVÉ : Ne pas démarrer le polling automatiquement
            // Le polling sera déclenché uniquement lors de l'envoi d'un message
            // setTimeout(() => {
            //     if (receiverIdInput && receiverIdInput.value) {
            //         startMessagePolling();
            //     }
            // }, 500);

            // Redémarrer le polling quand on change de contact
            chatItems.forEach(item => {
                item.addEventListener('click', function() {
                    stopMessagePolling();
                    lastMessageIds.clear(); // Réinitialiser la liste des messages
                    // DÉSACTIVÉ : Ne pas démarrer le polling automatiquement lors du changement de contact
                    // setTimeout(() => {
                    //     startMessagePolling();
                    // }, 1000);
                });
            });

            // Arrêter le polling quand on quitte la page
            window.addEventListener('beforeunload', function() {
                stopMessagePolling();
            });
            
            // TEST : Vérifier que tout est bien initialisé
            console.log('🔍 [DEBUG] ===== INITIALISATION TERMINÉE =====');
            console.log('🔍 [DEBUG] Nombre de contacts avec event listeners:', chatItems.length);
            console.log('🔍 [DEBUG] Tous les éléments DOM sont prêts');
            
            // TEST : Ajouter un listener de test sur le document pour voir si les clics sont capturés
            document.addEventListener('click', function(e) {
                if (e.target.closest('.chat-item')) {
                    console.log('🔍 [DEBUG] TEST: Clic détecté sur un .chat-item via event delegation');
                }
            }, true);

        // Support Modal functionality
        const supportBtn = document.getElementById('supportBtn');
        const supportModal = document.getElementById('supportModal');
        const supportModalClose = document.getElementById('supportModalClose');

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
        
        // Group Modal functions for apprenant
        function openGroupModal(groupId) {
            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
            let name = 'Groupe';
            let description = '';
            let avatar = null;
            if (chatItem) {
                name = chatItem.getAttribute('data-group-name') || name;
                description = chatItem.getAttribute('data-group-description') || '';
                avatar = chatItem.getAttribute('data-group-avatar') || '';
            }
            
            // Create or update modal
            let modal = document.getElementById('groupDetailsModal');
            if (!modal) {
                const modalHtml = `
                <div id="groupDetailsModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-3xl relative z-10 overflow-hidden">
                        <div class="p-4 border-b flex items-center justify-between">
                            <h3 id="groupModalTitle" class="text-lg font-semibold">Groupe</h3>
                            <button id="groupCloseBtn" class="px-3 py-1 text-sm bg-gray-100 rounded hover:bg-gray-200">Fermer</button>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-4 mb-4">
                                <div id="groupAvatar" class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center relative overflow-hidden"></div>
                                <div class="flex-1">
                                    <label class="block text-xs text-gray-600">Nom du groupe</label>
                                    <input id="groupNameInput" class="w-full border rounded px-2 py-1 bg-gray-50" readonly />
                                    <label class="block text-xs text-gray-600 mt-2">Description</label>
                                    <textarea id="groupDescriptionInput" class="w-full border rounded px-2 py-1 bg-gray-50" rows="3" readonly></textarea>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-2">Membres</h4>
                                <div id="groupMembersList" class="space-y-2 max-h-64 overflow-y-auto border rounded p-2"></div>
                            </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                modal = document.getElementById('groupDetailsModal');
                document.getElementById('groupCloseBtn').addEventListener('click', () => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                });
            }
            
            document.getElementById('groupModalTitle').textContent = name;
            document.getElementById('groupNameInput').value = name;
            document.getElementById('groupDescriptionInput').value = description;
            
            // Load avatar
            const avatarEl = document.getElementById('groupAvatar');
            if (avatar && avatar.trim() !== '') {
                avatarEl.style.backgroundImage = `url(/storage/${avatar})`;
                avatarEl.style.backgroundSize = 'cover';
                avatarEl.style.backgroundPosition = 'center';
                avatarEl.innerHTML = '';
            } else {
                avatarEl.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                avatarEl.innerHTML = '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>';
            }
            
            // Load members - fetch from server
            const membersList = document.getElementById('groupMembersList');
            membersList.innerHTML = '<p class="text-center text-gray-500 py-4">Chargement des membres...</p>';
            
            fetch(`/apprenant/forum/groups/${groupId}/members`)
                .then(r => r.json())
                .then(data => {
                    if (data.success && data.members) {
                        membersList.innerHTML = '';
                        data.members.forEach(m => {
                            const div = document.createElement('div');
                            div.className = 'flex items-center gap-2';
                            div.innerHTML = `${m.photo ? `<img src="/storage/${m.photo}" class="w-8 h-8 rounded-full">` : `<div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs">${(m.prenom||'').charAt(0)}${(m.nom||'').charAt(0)}</div>`}<div><div class="font-medium">${m.prenom} ${m.nom}</div><div class="text-xs text-gray-500">${m.email}</div></div>`;
                            membersList.appendChild(div);
                        });
                    } else {
                        membersList.innerHTML = '<p class="text-center text-gray-500 py-4">Erreur lors du chargement des membres.</p>';
                    }
                })
                .catch(err => {
                    console.error('Erreur chargement membres:', err);
                    membersList.innerHTML = '<p class="text-center text-gray-500 py-4">Erreur lors du chargement des membres.</p>';
                });
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
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

    <!-- Call Interface Modal -->
    <div id="callModal" class="call-modal-overlay">
        <div class="call-interface">
            <!-- Profile Section -->
            <div class="call-profile-section">
                <div class="call-profile-image" id="callProfileImage">
                    <span id="callProfileInitials"></span>
                </div>
                <h2 class="call-name" id="callName">Nom de l'appelant</h2>
                <p class="call-status" id="callStatus">Appel en cours...</p>
                <div class="call-timer" id="callTimer" style="display: none;">00:00</div>
                <div class="call-audio-visualizer" id="audioVisualizer" style="display: none;">
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                </div>
            </div>

            <!-- Call Controls -->
            <div class="call-controls">
                <!-- Mute Button -->
                <button id="muteBtn" class="call-btn call-btn-mute" title="Microphone">
                    <svg id="muteIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                    <svg id="muteIconOff" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6" style="stroke: #ef4444;"></path>
                    </svg>
                </button>

                <!-- Speaker Button -->
                <button id="speakerBtn" class="call-btn call-btn-speaker" title="Haut-parleur">
                    <svg id="speakerIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                    <svg id="speakerIconOff" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6" style="stroke: #ef4444;"></path>
                    </svg>
                </button>

                <!-- Answer Button (only visible when receiving call) -->
                <button id="answerBtn" class="call-btn call-btn-answer" title="Décrocher" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </button>

                <!-- Reject Button (only visible when receiving call) -->
                <button id="rejectBtn" class="call-btn call-btn-reject" title="Rejeter" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- End Call Button (visible during active call) -->
                <button id="endCallBtn" class="call-btn call-btn-end" title="Raccrocher" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Audio Element -->
            <audio id="remoteAudio" autoplay style="display: none;"></audio>
        </div>
    </div>

    <!-- Socket.io and WebRTC Scripts -->
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script>
        // WebRTC Call Manager
        class CallManager {
            constructor() {
                this.socket = null;
                this.localStream = null;
                this.remoteStream = null;
                this.peerConnection = null;
                this.currentCall = null;
                this.callTimer = null;
                this.callStartTime = null;
                this.missedCallTimeout = null;
                this.isMuted = false;
                this.isSpeakerOn = false;
                this.userId = {{ auth()->id() }};
                this.userName = '{{ auth()->user()->prenom ?? "" }} {{ auth()->user()->nom ?? "" }}';
                this.userPhoto = '{{ auth()->user()->photo ?? null }}';
                
                this.init();
            }

            init() {
                // Initialize Socket.io - Using Laravel Echo or direct connection
                // Note: You'll need to configure Laravel Echo with Socket.io server
                // For now, using a placeholder connection
                try {
                    this.socket = io('http://localhost:6001', {
                        transports: ['websocket', 'polling'],
                        reconnection: true,
                        reconnectionDelay: 1000,
                        reconnectionAttempts: 5
                    });

                    this.socket.on('connect', () => {
                        console.log('Socket connected:', this.socket.id);
                        this.socket.emit('user-connected', { userId: this.userId });
                    });

                    this.socket.on('disconnect', () => {
                        console.log('Socket disconnected');
                    });

                    // Listen for incoming calls
                    this.socket.on('incoming-call', (data) => {
                        this.handleIncomingCall(data);
                    });

                    // Listen for call accepted
                    this.socket.on('call-accepted', (data) => {
                        this.handleCallAccepted(data);
                    });

                    // Listen for call rejected
                    this.socket.on('call-rejected', (data) => {
                        this.handleCallRejected(data);
                    });

                    // Listen for call ended
                    this.socket.on('call-ended', (data) => {
                        this.handleCallEnded(data);
                    });

                    // Listen for missed call
                    this.socket.on('call-missed', (data) => {
                        this.handleCallMissed(data);
                    });

                    // Listen for ICE candidates
                    this.socket.on('ice-candidate', async (data) => {
                        await this.handleIceCandidate(data);
                    });

                    // Listen for offer
                    this.socket.on('offer', async (data) => {
                        await this.handleOffer(data);
                    });

                    // Listen for answer
                    this.socket.on('answer', async (data) => {
                        await this.handleAnswer(data);
                    });
                } catch (error) {
                    console.error('Socket.io connection error:', error);
                    // Fallback: Use polling-based signaling if WebSocket fails
                }

                // Setup UI event listeners
                this.setupEventListeners();
            }

            setupEventListeners() {
                // Call button - utiliser event delegation pour gérer les boutons dynamiques
                document.addEventListener('click', (e) => {
                    const callBtn = e.target.closest('button');
                    if (callBtn && (callBtn.id === 'callBtn' || callBtn.textContent.includes('Appeler'))) {
                        // Récupérer les données depuis les attributs data ou depuis le header
                        let receiverId = callBtn.dataset.receiverId;
                        let receiverName = callBtn.dataset.receiverName || 'Contact';
                        let receiverPhoto = callBtn.dataset.receiverPhoto || null;
                        
                        // Si les données ne sont pas dans le bouton, les récupérer depuis le header
                        if (!receiverId) {
                            const chatHeader = callBtn.closest('.p-6.border-b') || 
                                             callBtn.closest('.flex.items-center.justify-between')?.closest('.p-6');
                            if (chatHeader) {
                                // Chercher l'ID dans le receiverId input
                                const receiverIdInput = document.getElementById('receiverId');
                                if (receiverIdInput) {
                                    receiverId = receiverIdInput.value;
                                }
                                
                                // Récupérer le nom depuis le header
                                const nameElement = chatHeader.querySelector('p.text-base.font-bold') || 
                                                  chatHeader.querySelector('p.font-bold');
                                if (nameElement) {
                                    receiverName = nameElement.textContent.trim();
                                }
                                
                                // Récupérer la photo depuis le header
                                const photoElement = chatHeader.querySelector('img');
                                if (photoElement && photoElement.src) {
                                    // Extraire le chemin de la photo depuis l'URL complète
                                    const photoSrc = photoElement.src;
                                    if (photoSrc.includes('/storage/')) {
                                        receiverPhoto = photoSrc.split('/storage/')[1];
                                    } else if (photoSrc.includes('storage/')) {
                                        receiverPhoto = photoSrc.split('storage/')[1];
                                    }
                                }
                            }
                        }
                        
                        if (receiverId) {
                            console.log('Initiation d\'appel pour:', receiverId, receiverName, receiverPhoto);
                            this.initiateCall(receiverId, receiverName, receiverPhoto);
                        } else {
                            alert('Aucun contact sélectionné');
                        }
                    }
                });

                // Answer button
                document.getElementById('answerBtn')?.addEventListener('click', () => {
                    this.answerCall();
                });

                // Reject button
                document.getElementById('rejectBtn')?.addEventListener('click', () => {
                    this.rejectCall();
                });

                // End call button
                document.getElementById('endCallBtn')?.addEventListener('click', () => {
                    this.endCall(true); // Show message before ending
                });

                // Mute button
                document.getElementById('muteBtn')?.addEventListener('click', () => {
                    this.toggleMute();
                });

                // Speaker button
                document.getElementById('speakerBtn')?.addEventListener('click', () => {
                    this.toggleSpeaker();
                });
            }

            async initiateCall(receiverId, receiverName, receiverPhoto) {
                try {
                    // Get user media
                    this.localStream = await navigator.mediaDevices.getUserMedia({ 
                        audio: true, 
                        video: false 
                    });

                    // Create peer connection
                    this.peerConnection = this.createPeerConnection();

                    // Add local stream tracks
                    this.localStream.getTracks().forEach(track => {
                        this.peerConnection.addTrack(track, this.localStream);
                    });

                    // Create offer
                    const offer = await this.peerConnection.createOffer();
                    await this.peerConnection.setLocalDescription(offer);

                    // Store call info
                    this.currentCall = {
                        receiverId: receiverId,
                        receiverName: receiverName,
                        receiverPhoto: receiverPhoto,
                        isIncoming: false,
                        startedAt: new Date().toISOString(), // Enregistrer la date de début
                        callStartTime: null // Sera défini quand l'appel sera accepté
                    };

                    // Show call interface
                    this.showCallInterface(receiverName, receiverPhoto, 'Appel en cours...', false);

                    // Play dial tone for outgoing call
                    this.playDialTone();

                    // Send offer via socket
                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-user', {
                            to: receiverId,
                            offer: offer,
                            callerName: this.userName,
                            callerPhoto: this.userPhoto
                        });
                    } else {
                        console.warn('Socket not connected, using fallback signaling');
                        // Fallback: You could use AJAX polling or other methods here
                    }

                } catch (error) {
                    console.error('Error initiating call:', error);
                    alert('Impossible de démarrer l\'appel. Vérifiez vos permissions de microphone.');
                    this.actuallyEndCall();
                }
            }

            handleIncomingCall(data) {
                this.currentCall = {
                    callerId: data.from,
                    callerName: data.callerName,
                    callerPhoto: data.callerPhoto,
                    offer: data.offer,
                    isIncoming: true,
                    startedAt: new Date().toISOString(), // Enregistrer la date de début
                    callStartTime: null // Will be set when answered
                };

                // Show call interface with answer/reject buttons
                this.showCallInterface(
                    data.callerName, 
                    data.callerPhoto, 
                    'Appel entrant...', 
                    true
                );

                // Play ringtone (optional)
                this.playRingtone();
                
                // Set timeout for missed call (30 seconds)
                this.missedCallTimeout = setTimeout(() => {
                    if (this.currentCall && this.currentCall.isIncoming && !this.callStartTime) {
                        // Call was not answered - show "Appel manqué"
                        this.showCallEndedMessage('Appel manqué');
                        if (this.socket && this.socket.connected) {
                            this.socket.emit('call-missed', { to: this.currentCall.callerId });
                        }
                        setTimeout(() => {
                            this.endCall();
                        }, 2000);
                    }
                }, 30000); // 30 seconds timeout
            }

            async answerCall() {
                try {
                    // Clear missed call timeout
                    if (this.missedCallTimeout) {
                        clearTimeout(this.missedCallTimeout);
                        this.missedCallTimeout = null;
                    }

                    // Get user media
                    this.localStream = await navigator.mediaDevices.getUserMedia({ 
                        audio: true, 
                        video: false 
                    });

                    // Create peer connection
                    this.peerConnection = this.createPeerConnection();

                    // Add local stream tracks
                    this.localStream.getTracks().forEach(track => {
                        this.peerConnection.addTrack(track, this.localStream);
                    });

                    // Set remote description
                    await this.peerConnection.setRemoteDescription(
                        new RTCSessionDescription(this.currentCall.offer)
                    );

                    // Create answer
                    const answer = await this.peerConnection.createAnswer();
                    await this.peerConnection.setLocalDescription(answer);

                    // Send answer via socket
                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-accepted', {
                            to: this.currentCall.callerId,
                            answer: answer
                        });
                    }

                    // Mark call as answered
                    if (this.currentCall) {
                        this.currentCall.callStartTime = Date.now();
                    }

                    // Stop ringtone when call is answered
                    this.stopRingtone();

                    // Update UI - Start timer immediately when call is answered
                    this.showCallInterface(
                        this.currentCall.callerName,
                        this.currentCall.callerPhoto,
                        'En communication...',
                        false
                    );
                    this.startCallTimer(); // Start timer as soon as call is answered

                } catch (error) {
                    console.error('Error answering call:', error);
                    alert('Impossible de répondre à l\'appel.');
                    this.actuallyEndCall();
                }
            }

            rejectCall() {
                // Arrêter immédiatement la sonnerie
                this.stopRingtone();
                
                if (this.currentCall && this.currentCall.isIncoming) {
                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-rejected', {
                            to: this.currentCall.callerId
                        });
                    }
                    // Marquer comme rejeté
                    this.currentCall.status = 'rejected';
                    // Show "Appel manqué" for the caller (they will receive it via handleCallRejected)
                }
                // When rejecting, it's always a missed call
                this.showCallEndedMessage('Appel manqué');
                setTimeout(() => {
                    this.actuallyEndCall();
                }, 2000);
            }

            async handleCallAccepted(data) {
                // Stop dial tone when call is accepted
                this.stopDialTone();

                // Set remote description
                await this.peerConnection.setRemoteDescription(
                    new RTCSessionDescription(data.answer)
                );

                // Update UI - Start timer immediately when call is accepted
                this.showCallInterface(
                    this.currentCall.receiverName,
                    this.currentCall.receiverPhoto,
                    'En communication...',
                    false
                );
                this.startCallTimer(); // Start timer as soon as call is accepted
            }

            handleCallRejected(data) {
                // Show "Appel manqué" for the caller
                this.showCallEndedMessage('Appel manqué');
                setTimeout(() => {
                    this.endCall();
                }, 2000);
            }

            handleCallEnded(data) {
                // Check if call was answered (timer started) or if data says it was answered
                const wasAnswered = this.currentCall?.callStartTime !== null || data?.wasAnswered === true;
                // If call was not answered, it's a missed call
                const message = wasAnswered ? 'Appel terminé' : 'Appel manqué';
                this.showCallEndedMessage(message);
                setTimeout(() => {
                    this.actuallyEndCall();
                }, 2000);
            }

            handleCallMissed(data) {
                // Show "Appel manqué" message for the caller
                if (this.currentCall && !this.currentCall.isIncoming) {
                    this.showCallEndedMessage('Appel manqué');
                    setTimeout(() => {
                        this.endCall();
                    }, 2000);
                }
            }

            endCall(showMessage = false) {
                // Arrêter immédiatement toutes les tonalités
                this.stopRingtone();
                this.stopDialTone();
                
                // Check if we should show a message before ending
                if (showMessage && this.currentCall) {
                    const wasAnswered = this.currentCall?.callStartTime !== null;
                    // If call was not answered (not decroché), show "Appel manqué"
                    const message = wasAnswered ? 'Appel terminé' : 'Appel manqué';
                    this.showCallEndedMessage(message);
                    
                    // Notify other user about the call end
                    if (this.socket && this.socket.connected) {
                        if (this.currentCall.isIncoming) {
                            this.socket.emit('call-ended', { 
                                to: this.currentCall.callerId,
                                wasAnswered: wasAnswered
                            });
                        } else {
                            this.socket.emit('call-ended', { 
                                to: this.currentCall.receiverId,
                                wasAnswered: wasAnswered
                            });
                        }
                    }
                    
                    // Wait before actually ending
                    setTimeout(() => {
                        this.actuallyEndCall();
                    }, 2000);
                    return;
                }

                // Notify other user
                if (this.currentCall && this.socket && this.socket.connected) {
                    const wasAnswered = this.currentCall?.callStartTime !== null;
                    if (this.currentCall.isIncoming) {
                        this.socket.emit('call-ended', { 
                            to: this.currentCall.callerId,
                            wasAnswered: wasAnswered
                        });
                    } else {
                        this.socket.emit('call-ended', { 
                            to: this.currentCall.receiverId,
                            wasAnswered: wasAnswered
                        });
                    }
                }

                this.actuallyEndCall();
            }

            actuallyEndCall() {
                // Enregistrer l'appel dans la base de données avant de nettoyer
                this.saveCallToDatabase();

                // Clear missed call timeout
                if (this.missedCallTimeout) {
                    clearTimeout(this.missedCallTimeout);
                    this.missedCallTimeout = null;
                }

                // Stop local stream
                if (this.localStream) {
                    this.localStream.getTracks().forEach(track => track.stop());
                    this.localStream = null;
                }

                // Close peer connection
                if (this.peerConnection) {
                    this.peerConnection.close();
                    this.peerConnection = null;
                }

                // Stop timer
                this.stopCallTimer();

                // Stop all audio
                this.stopRingtone();
                this.stopDialTone();

                // Reset mute and speaker states
                this.isMuted = false;
                this.isSpeakerOn = false;
                this.updateMuteIcon(false);
                this.updateSpeakerIcon(false);

                // Hide call interface
                this.hideCallInterface();
                this.currentCall = null;
            }

            saveCallToDatabase() {
                if (!this.currentCall) return;

                // Déterminer qui est l'appelant et le destinataire
                let callerId, receiverId, status, wasAnswered;
                
                if (this.currentCall.isIncoming) {
                    // Appel entrant : l'autre personne est l'appelant, nous sommes le destinataire
                    callerId = this.currentCall.callerId;
                    receiverId = this.userId;
                } else {
                    // Appel sortant : nous sommes l'appelant, l'autre personne est le destinataire
                    callerId = this.userId;
                    receiverId = this.currentCall.receiverId;
                }

                // Déterminer le statut et si l'appel a été répondu
                wasAnswered = this.currentCall.callStartTime !== null;
                
                // Déterminer le statut
                if (this.currentCall.status === 'rejected') {
                    status = 'rejected';
                } else if (!wasAnswered) {
                    // Appel non répondu
                    status = 'missed';
                } else {
                    // Appel terminé après avoir été répondu
                    status = 'ended';
                }

                // Calculer la durée si l'appel a été répondu
                let duration = null;
                let endedAt = new Date().toISOString();
                
                if (wasAnswered && this.currentCall.callStartTime) {
                    duration = Math.floor((Date.now() - this.currentCall.callStartTime) / 1000);
                }

                // Date de début d'appel
                const startedAt = this.currentCall.startedAt || new Date().toISOString();

                // Envoyer les données au serveur
                const formData = new FormData();
                formData.append('receiver_id', receiverId);
                formData.append('started_at', startedAt);
                formData.append('ended_at', endedAt);
                formData.append('duration', duration || 0);
                formData.append('status', status);
                formData.append('was_answered', wasAnswered ? 1 : 0);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                fetch('{{ route("apprenant.calls.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Appel enregistré avec succès:', data.call);
                    } else {
                        console.error('Erreur lors de l\'enregistrement de l\'appel:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de l\'enregistrement de l\'appel:', error);
                });
            }

            createPeerConnection() {
                const configuration = {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' }
                    ]
                };

                const pc = new RTCPeerConnection(configuration);

                // Handle ICE candidates
                pc.onicecandidate = (event) => {
                    if (event.candidate) {
                        const targetId = this.currentCall?.isIncoming 
                            ? this.currentCall.callerId 
                            : this.currentCall?.receiverId;
                        if (targetId && this.socket && this.socket.connected) {
                            this.socket.emit('ice-candidate', {
                                to: targetId,
                                candidate: event.candidate
                            });
                        }
                    }
                };

                // Handle remote stream
                pc.ontrack = (event) => {
                    this.remoteStream = event.streams[0];
                    const remoteAudio = document.getElementById('remoteAudio');
                    if (remoteAudio) {
                        remoteAudio.srcObject = this.remoteStream;
                        // Appliquer le volume actuel du haut-parleur
                        remoteAudio.volume = this.isSpeakerOn ? 1.0 : 0;
                    }
                };

                return pc;
            }

            async handleIceCandidate(data) {
                if (this.peerConnection && data.candidate) {
                    await this.peerConnection.addIceCandidate(
                        new RTCIceCandidate(data.candidate)
                    );
                }
            }

            async handleOffer(data) {
                // This is handled in handleIncomingCall
            }

            async handleAnswer(data) {
                // This is handled in handleCallAccepted
            }

            showCallInterface(name, photo, status, isIncoming) {
                const modal = document.getElementById('callModal');
                const callName = document.getElementById('callName');
                const callStatus = document.getElementById('callStatus');
                const callProfileImage = document.getElementById('callProfileImage');
                const callProfileInitials = document.getElementById('callProfileInitials');
                const answerBtn = document.getElementById('answerBtn');
                const rejectBtn = document.getElementById('rejectBtn');
                const endCallBtn = document.getElementById('endCallBtn');
                const audioVisualizer = document.getElementById('audioVisualizer');
                const muteBtn = document.getElementById('muteBtn');
                const speakerBtn = document.getElementById('speakerBtn');

                if (callName) callName.textContent = name;
                if (callStatus) {
                    callStatus.textContent = status;
                    callStatus.style.color = 'rgba(255, 255, 255, 0.8)';
                    callStatus.style.fontWeight = '400';
                }

                // Set profile image
                if (photo && photo.trim() !== '' && photo !== 'null') {
                    // Construire le chemin complet de l'image
                    let photoPath = photo;
                    // Si la photo ne contient pas déjà le chemin complet, l'ajouter
                    if (!photo.startsWith('http') && !photo.startsWith('/')) {
                        photoPath = `/storage/${photo}`;
                    } else if (photo.startsWith('storage/')) {
                        photoPath = `/${photo}`;
                    }
                    // Vider les initiales d'abord
                    if (callProfileInitials) callProfileInitials.textContent = '';
                    // Créer l'image avec gestion d'erreur
                    const initials = this.getInitials(name);
                    callProfileImage.innerHTML = `<img src="${photoPath}" alt="${this.escapeHtml(name)}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.style.display='none'; if(document.getElementById('callProfileInitials')) document.getElementById('callProfileInitials').textContent='${initials}';">`;
                } else {
                    // Pas de photo, afficher les initiales
                    const initials = this.getInitials(name);
                    if (callProfileInitials) callProfileInitials.textContent = initials;
                    // Vider l'image si elle existe
                    if (callProfileImage) {
                        const img = callProfileImage.querySelector('img');
                        if (img) img.remove();
                    }
                }

                // Show/hide buttons based on call state
                if (isIncoming) {
                    if (answerBtn) answerBtn.style.display = 'flex';
                    if (rejectBtn) rejectBtn.style.display = 'flex';
                    if (endCallBtn) endCallBtn.style.display = 'none';
                    if (muteBtn) muteBtn.style.display = 'none';
                    if (speakerBtn) speakerBtn.style.display = 'none';
                    if (callProfileImage) callProfileImage.classList.add('call-ringing-animation');
                } else {
                    if (answerBtn) answerBtn.style.display = 'none';
                    if (rejectBtn) rejectBtn.style.display = 'none';
                    if (endCallBtn) endCallBtn.style.display = 'flex';
                    if (muteBtn) muteBtn.style.display = 'flex';
                    if (speakerBtn) speakerBtn.style.display = 'flex';
                    if (callProfileImage) callProfileImage.classList.remove('call-ringing-animation');
                }

                if (status === 'En communication...') {
                    if (audioVisualizer) audioVisualizer.style.display = 'flex';
                } else {
                    if (audioVisualizer) audioVisualizer.style.display = 'none';
                }

                if (modal) modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            hideCallInterface() {
                const modal = document.getElementById('callModal');
                if (modal) modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            showCallEndedMessage(message) {
                const callStatus = document.getElementById('callStatus');
                const callTimer = document.getElementById('callTimer');
                const audioVisualizer = document.getElementById('audioVisualizer');
                
                if (callStatus) {
                    callStatus.textContent = message;
                    callStatus.style.color = message === 'Appel manqué' ? '#ef4444' : '#6b7280';
                    callStatus.style.fontWeight = '600';
                }
                
                if (callTimer) {
                    callTimer.style.display = 'none';
                }
                
                if (audioVisualizer) {
                    audioVisualizer.style.display = 'none';
                }

                // Envoyer un message système dans le chat
                this.sendSystemMessage(message);
                
                // Hide all control buttons except end call
                const answerBtn = document.getElementById('answerBtn');
                const rejectBtn = document.getElementById('rejectBtn');
                const endCallBtn = document.getElementById('endCallBtn');
                const muteBtn = document.getElementById('muteBtn');
                const speakerBtn = document.getElementById('speakerBtn');
                
                if (answerBtn) answerBtn.style.display = 'none';
                if (rejectBtn) rejectBtn.style.display = 'none';
                if (endCallBtn) endCallBtn.style.display = 'flex';
                if (muteBtn) muteBtn.style.display = 'none';
                if (speakerBtn) speakerBtn.style.display = 'none';
            }

            startCallTimer() {
                this.callStartTime = Date.now();
                const timerElement = document.getElementById('callTimer');
                if (timerElement) {
                    timerElement.style.display = 'block';
                    timerElement.textContent = '00:00';
                }

                // Clear any existing timer
                if (this.callTimer) {
                    clearInterval(this.callTimer);
                }

                // Start timer - update every second
                this.callTimer = setInterval(() => {
                    if (this.callStartTime && timerElement) {
                        const elapsed = Math.floor((Date.now() - this.callStartTime) / 1000);
                        const minutes = Math.floor(elapsed / 60);
                        const seconds = elapsed % 60;
                        timerElement.textContent = 
                            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }
                }, 1000);
            }

            stopCallTimer() {
                if (this.callTimer) {
                    clearInterval(this.callTimer);
                    this.callTimer = null;
                }
                const timerElement = document.getElementById('callTimer');
                if (timerElement) timerElement.style.display = 'none';
                this.callStartTime = null;
            }

            toggleMute() {
                if (this.localStream) {
                    this.isMuted = !this.isMuted;
                    // Arrêt immédiat (0 seconde) : désactiver toutes les pistes audio instantanément
                    this.localStream.getAudioTracks().forEach(track => {
                        // Désactiver immédiatement la piste (arrêt instantané - 0 seconde)
                        track.enabled = !this.isMuted;
                    });
                    
                    this.updateMuteIcon(this.isMuted);
                    
                    // Log pour debug
                    console.log('Micro ' + (this.isMuted ? 'désactivé (arrêt immédiat - 0 seconde)' : 'activé'));
                }
            }

            updateMuteIcon(isMuted) {
                const muteIcon = document.getElementById('muteIcon');
                const muteIconOff = document.getElementById('muteIconOff');
                const muteBtn = document.getElementById('muteBtn');
                
                if (muteIcon && muteIconOff) {
                    if (isMuted) {
                        muteIcon.style.display = 'none';
                        muteIconOff.style.display = 'block';
                    } else {
                        muteIcon.style.display = 'block';
                        muteIconOff.style.display = 'none';
                    }
                }
                
                if (muteBtn) {
                    muteBtn.classList.toggle('active', isMuted);
                }
            }

            toggleSpeaker() {
                this.isSpeakerOn = !this.isSpeakerOn;
                const remoteAudio = document.getElementById('remoteAudio');
                if (remoteAudio) {
                    // Arrêt immédiat (0 seconde) : couper complètement le volume
                    if (!this.isSpeakerOn) {
                        remoteAudio.volume = 0;
                        remoteAudio.pause(); // Pause immédiate pour arrêt complet
                    } else {
                        remoteAudio.volume = 1.0;
                        remoteAudio.play(); // Reprendre la lecture
                    }
                }
                
                // Si le haut-parleur est désactivé, arrêter immédiatement la tonalité d'appel (0 seconde)
                if (!this.isSpeakerOn) {
                    this.stopDialTone(); // Arrêt immédiat
                } else {
                    // Si le haut-parleur est activé et qu'on est en train d'appeler, relancer la tonalité
                    if (this.currentCall && !this.currentCall.isIncoming && !this.currentCall.callStartTime) {
                        this.playDialTone();
                    }
                }
                
                this.updateSpeakerIcon(this.isSpeakerOn);
                console.log('Haut-parleur ' + (this.isSpeakerOn ? 'activé' : 'désactivé (arrêt immédiat)'));
            }

            updateSpeakerIcon(isOn) {
                const speakerIcon = document.getElementById('speakerIcon');
                const speakerIconOff = document.getElementById('speakerIconOff');
                const speakerBtn = document.getElementById('speakerBtn');
                
                if (speakerIcon && speakerIconOff) {
                    if (isOn) {
                        speakerIcon.style.display = 'block';
                        speakerIconOff.style.display = 'none';
                    } else {
                        speakerIcon.style.display = 'none';
                        speakerIconOff.style.display = 'block';
                    }
                }
                
                if (speakerBtn) {
                    speakerBtn.classList.toggle('active', isOn);
                }
            }

            playRingtone() {
                // Play ringtone for incoming call (melody)
                if (window.playRingtoneAudio) {
                    window.playRingtoneAudio();
                } else {
                    // Fallback
                    const ringtone = document.getElementById('ringtoneAudio');
                    if (ringtone) {
                        ringtone.loop = true;
                        ringtone.volume = 0.7;
                        ringtone.play().catch(error => {
                            console.error('Error playing ringtone:', error);
                        });
                    }
                }
            }

            stopRingtone() {
                // Stop ringtone audio immédiatement
                if (window.stopRingtoneAudio) {
                    window.stopRingtoneAudio();
                } else {
                    // Fallback
                    const ringtone = document.getElementById('ringtoneAudio');
                    if (ringtone) {
                        ringtone.pause();
                        ringtone.currentTime = 0;
                        ringtone.src = ''; // Vider la source pour arrêter complètement
                    }
                }
            }

            playDialTone() {
                // Play dial tone for outgoing call (teuuun sound)
                if (window.playDialToneAudio) {
                    window.playDialToneAudio();
                } else {
                    // Fallback
                    const dialTone = document.getElementById('dialToneAudio');
                    if (dialTone) {
                        dialTone.loop = true;
                        dialTone.volume = 0.5;
                        dialTone.play().catch(error => {
                            console.error('Error playing dial tone:', error);
                        });
                    }
                }
            }

            stopDialTone() {
                // Stop dial tone audio
                if (window.stopDialToneAudio) {
                    window.stopDialToneAudio();
                } else {
                    // Fallback
                    const dialTone = document.getElementById('dialToneAudio');
                    if (dialTone) {
                        dialTone.pause();
                        dialTone.currentTime = 0;
                    }
                }
            }

            sendSystemMessage(message) {
                // Envoyer un message système dans le chat
                if (!this.currentCall) return;

                const receiverId = this.currentCall.isIncoming 
                    ? this.currentCall.callerId 
                    : this.currentCall.receiverId;

                if (!receiverId) return;

                // Créer le contenu du message système
                const icon = message === 'Appel manqué' ? '📞❌' : '📞✅';
                const content = `${icon} ${message}`;

                // Envoyer le message via AJAX
                const formData = new FormData();
                formData.append('receiver_id', receiverId);
                formData.append('content', content);
                formData.append('label', 'System'); // Marquer comme message système
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                fetch('{{ route("apprenant.messages.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.message) {
                        // Vérifier si c'est la conversation active
                        const receiverIdInput = document.getElementById('receiverId');
                        const messagesArea = document.getElementById('messagesArea');
                        
                        if (receiverIdInput && receiverIdInput.value == receiverId && messagesArea) {
                            // Ajouter directement le message dans l'interface sans recharger
                            this.addSystemMessageToUI(data.message);
                        } else {
                            // Si ce n'est pas la conversation active, recharger le thread
                            if (typeof loadThread === 'function') {
                                loadThread(receiverId);
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de l\'envoi du message système:', error);
                });
            }

            addSystemMessageToUI(message) {
                // Ajouter directement un message système dans l'interface
                const messagesArea = document.getElementById('messagesArea');
                if (!messagesArea) return;

                // Vérifier si le message n'existe pas déjà
                const existingMessage = messagesArea.querySelector(`[data-message-id="${message.id}"]`);
                if (existingMessage) {
                    console.log('Message système déjà présent dans l\'interface');
                    return;
                }

                // Créer l'élément du message système - Aligné à droite comme WhatsApp
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex items-start gap-3 justify-end my-2';
                messageDiv.setAttribute('data-message-id', message.id);

                // Formater la date
                const messageDate = new Date(message.created_at);
                const day = String(messageDate.getDate()).padStart(2, '0');
                const month = String(messageDate.getMonth() + 1).padStart(2, '0');
                const year = messageDate.getFullYear();
                const hours = String(messageDate.getHours()).padStart(2, '0');
                const minutes = String(messageDate.getMinutes()).padStart(2, '0');
                const timeFormat = `${day}/${month}/${year} ${hours}:${minutes}`;

                messageDiv.innerHTML = `
                    <div class="flex-1 flex justify-end">
                        <div class="max-w-[70%]">
                            <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                <p class="text-xs text-gray-600">${this.escapeHtml(message.content)}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-right">${timeFormat}</p>
                        </div>
                    </div>
                `;

                // Ajouter le message à la fin de la conversation
                messagesArea.appendChild(messageDiv);

                // Faire défiler vers le bas pour voir le nouveau message
                messagesArea.scrollTop = messagesArea.scrollHeight;

                console.log('Message système ajouté à l\'interface:', message.id);
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            getInitials(name) {
                if (!name) return '??';
                const parts = name.trim().split(' ').filter(p => p.length > 0);
                if (parts.length === 0) return '??';
                if (parts.length === 1) return parts[0].substring(0, 2).toUpperCase();
                return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            }
        }

        // Initialize Call Manager when page loads
        let callManager;
        document.addEventListener('DOMContentLoaded', () => {
            callManager = new CallManager();
        });

        // Generate ringtone (melody for incoming call)
        function generateRingtone() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const sampleRate = audioContext.sampleRate;
            const duration = 0.5; // 0.5 seconds per ring
            const buffer = audioContext.createBuffer(1, sampleRate * duration, sampleRate);
            const data = buffer.getChannelData(0);
            
            // Create a pleasant ringtone melody (two tones)
            for (let i = 0; i < data.length; i++) {
                const t = i / sampleRate;
                // First tone (440 Hz - A note)
                const tone1 = Math.sin(2 * Math.PI * 440 * t) * 0.3;
                // Second tone (554 Hz - C# note)
                const tone2 = Math.sin(2 * Math.PI * 554 * t) * 0.3;
                // Combine with fade in/out
                const fade = Math.sin(Math.PI * t / duration);
                data[i] = (tone1 + tone2) * fade;
            }
            
            return buffer;
        }

        // Generate dial tone (continuous tone for outgoing call)
        function generateDialTone() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const sampleRate = audioContext.sampleRate;
            const duration = 2; // 2 seconds
            const buffer = audioContext.createBuffer(1, sampleRate * duration, sampleRate);
            const data = buffer.getChannelData(0);
            
            // Create a dial tone (350 Hz + 440 Hz)
            for (let i = 0; i < data.length; i++) {
                const t = i / sampleRate;
                const tone1 = Math.sin(2 * Math.PI * 350 * t) * 0.2;
                const tone2 = Math.sin(2 * Math.PI * 440 * t) * 0.2;
                data[i] = tone1 + tone2;
            }
            
            return buffer;
        }

        // Initialize audio when page loads
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const ringtoneBuffer = generateRingtone();
                const dialToneBuffer = generateDialTone();
                
                // Create audio sources
                let ringtoneSource = null;
                let dialToneSource = null;
                
                // Function to play ringtone
                window.playRingtoneAudio = function() {
                    // Activer l'audioContext si nécessaire (sans attendre pour jouer immédiatement)
                    if (audioContext.state === 'suspended') {
                        audioContext.resume().catch(err => {
                            console.error('Erreur lors de l\'activation de l\'audioContext:', err);
                        });
                    }
                    
                    if (ringtoneSource) {
                        try {
                            ringtoneSource.stop(0);
                        } catch (e) {
                            // Ignorer l'erreur si déjà arrêté
                        }
                        ringtoneSource.disconnect();
                    }
                    ringtoneSource = audioContext.createBufferSource();
                    ringtoneSource.buffer = ringtoneBuffer;
                    ringtoneSource.connect(audioContext.destination);
                    ringtoneSource.loop = true;
                    ringtoneSource.start(0);
                };
                
                // Function to stop ringtone - Arrêt immédiat
                window.stopRingtoneAudio = function() {
                    if (ringtoneSource) {
                        try {
                            ringtoneSource.stop(0); // Arrêt immédiat (0 seconde)
                        } catch (e) {
                            // Ignorer l'erreur si déjà arrêté
                        }
                        ringtoneSource.disconnect();
                        ringtoneSource = null;
                    }
                };
                
                // Function to play dial tone
                window.playDialToneAudio = function() {
                    // Activer l'audioContext si nécessaire (sans attendre pour jouer immédiatement)
                    if (audioContext.state === 'suspended') {
                        audioContext.resume().catch(err => {
                            console.error('Erreur lors de l\'activation de l\'audioContext:', err);
                        });
                    }
                    
                    if (dialToneSource) {
                        try {
                            dialToneSource.stop(0);
                        } catch (e) {
                            // Ignorer l'erreur si déjà arrêté
                        }
                        dialToneSource.disconnect();
                    }
                    dialToneSource = audioContext.createBufferSource();
                    dialToneSource.buffer = dialToneBuffer;
                    dialToneSource.connect(audioContext.destination);
                    dialToneSource.loop = true;
                    dialToneSource.start(0);
                };
                
                // Function to stop dial tone - Arrêt immédiat
                window.stopDialToneAudio = function() {
                    if (dialToneSource) {
                        try {
                            dialToneSource.stop(0); // Arrêt immédiat (0 seconde)
                        } catch (e) {
                            // Ignorer l'erreur si déjà arrêté
                        }
                        dialToneSource.disconnect();
                        dialToneSource = null;
                    }
                };
            } catch (error) {
                console.error('Error initializing audio:', error);
            }
        });
    </script>
    @include('components.apprenant-video-session-notification')
</body>
</html>

