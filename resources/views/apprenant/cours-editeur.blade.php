<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditeur de Cours - BJ Academie</title>
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

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <div class="text-white" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                <div class="flex items-center justify-between px-6 py-7">
                    <div class="flex items-center gap-4">
                        <h1 class="text-2xl font-semibold mt-2">
                            @if($section && isset($section['titre']))
                                {{ $section['titre'] }}
                            @else
                                Semaine {{ $week ?? 1 }} - Introduction à la gestion d'entreprise
                            @endif
                        </h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2 text-sm text-gray-300">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Modifications enregistrées il y a 2 min</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex flex-1 overflow-hidden">
                <!-- Main Content -->
                <div class="flex-1 overflow-y-auto bg-white p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">
                        @if($section && isset($section['titre']))
                            {{ $section['titre'] }}
                        @else
                            Lire avant de commencer
                        @endif
                    </h1>
                    
                    <p class="text-base text-gray-700 mb-6 leading-relaxed">
                        @if($section && isset($section['description']))
                            {!! nl2br(e($section['description'])) !!}
                        @else
                            Bonjour mes étudiants ! L'économie n'est pas seulement une matière - c'est la lentille à travers laquelle nous voyons la société. De la micro à la macroéconomie, je vous aiderai à découvrir les clés pour comprendre les phénomènes économiques dans mes cours complets. Tout d'abord, laissez-moi vous parler un peu de moi et de la chose la plus importante - comment commencer ?
                        @endif
                    </p>

                    <!-- Video Player -->
                    @if($section && isset($section['lien_video']) && !empty($section['lien_video']))
                        <div class="w-full max-w-4xl mx-auto mb-6 rounded-lg overflow-hidden" style="aspect-ratio: 16/9;">
                            <div id="youtube-player" style="width: 100%; height: 100%;"></div>
                        </div>
                    @endif

                    <!-- Button to download course -->
                    @if($section && isset($section['fichier_pdf']) && !empty($section['fichier_pdf']))
                        <div class="w-full max-w-4xl mx-auto mb-6 mt-6 flex justify-center">
                            <button onclick="downloadCourse()" class="px-6 py-3 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                Télécharger ce cours
                            </button>
                        </div>
                    @endif

                </div>

                <!-- Right Sidebar - Tools -->
                <div class="w-80 bg-white border-l border-gray-200 p-6 overflow-y-auto flex flex-col">
            <!-- Reading Progress Section -->
            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Progression de lecture</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600">Progression</span>
                        <span id="progress-percentage" class="text-sm font-semibold text-gray-900">0%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div id="progress-bar" class="bg-gradient-to-r from-purple-600 to-purple-700 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <p id="progress-text" class="text-xs text-gray-500 mt-2">Commencez la vidéo pour suivre votre progression</p>
                </div>
            </div>

            <!-- Course Guide Section -->
            <div class="mt-auto">
                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-3">
                    <p class="text-base font-semibold mb-1 text-gray-900">Exercice à faire</p>
                    <p class="text-xs text-gray-600">
                        @if($section && isset($section['titre']))
                            {{ $section['titre'] }}
                        @else
                            Introduction à la gestion d'entreprise
                        @endif
                    </p>
                </div>
                <a href="{{ route('apprenant.quiz', ['cours_id' => $cours->id ?? null, 'section' => $sectionIndex ?? 0]) }}" class="block w-full px-4 py-2 text-white rounded-lg text-sm font-medium transition-colors text-center" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                    Test de connaissance
                </a>
            </div>
                </div>
            </div>
        </div>
    </div>

    <!-- YouTube IFrame API -->
    <script src="https://www.youtube.com/iframe_api"></script>
    
    <script>
        let player;
        let videoDuration = 0;
        let progressInterval = null;
        
        // Fonction appelée quand l'API YouTube est prête
        function onYouTubeIframeAPIReady() {
            @if($section && isset($section['lien_video']) && !empty($section['lien_video']))
                // Extraire l'ID de la vidéo YouTube depuis l'URL ou utiliser directement l'ID
                let videoId = '{{ $section['lien_video'] }}';
                
                // Si c'est une URL complète, extraire l'ID
                if (videoId.includes('youtube.com/watch?v=')) {
                    videoId = videoId.split('v=')[1].split('&')[0];
                } else if (videoId.includes('youtu.be/')) {
                    videoId = videoId.split('youtu.be/')[1].split('?')[0];
                }
                
                player = new YT.Player('youtube-player', {
                    height: '100%',
                    width: '100%',
                    videoId: videoId,
                    playerVars: {
                        'playsinline': 1,
                        'rel': 0
                    },
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            @else
                // Vidéo par défaut si aucune vidéo n'est fournie
                player = new YT.Player('youtube-player', {
                    height: '100%',
                    width: '100%',
                    videoId: 'DKHs2zDl2cM',
                    playerVars: {
                        'playsinline': 1,
                        'rel': 0
                    },
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            @endif
        }
        
        // Quand le lecteur est prêt
        function onPlayerReady(event) {
            videoDuration = event.target.getDuration();
            updateProgress();
        }
        
        // Suivre les changements d'état du lecteur
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING) {
                // Démarrer la mise à jour de la progression toutes les secondes
                if (progressInterval) {
                    clearInterval(progressInterval);
                }
                progressInterval = setInterval(updateProgress, 1000);
            } else {
                // Arrêter la mise à jour si la vidéo est en pause ou arrêtée
                if (progressInterval) {
                    clearInterval(progressInterval);
                    progressInterval = null;
                }
                // Mettre à jour une dernière fois
                updateProgress();
            }
        }
        
        // Mettre à jour la barre de progression
        function updateProgress() {
            if (player && player.getCurrentTime && videoDuration > 0) {
                const currentTime = player.getCurrentTime();
                const progress = (currentTime / videoDuration) * 100;
                const progressPercentage = Math.min(Math.max(progress, 0), 100).toFixed(1);
                
                // Mettre à jour l'affichage
                document.getElementById('progress-bar').style.width = progressPercentage + '%';
                document.getElementById('progress-percentage').textContent = progressPercentage + '%';
                
                // Mettre à jour le texte
                const minutes = Math.floor(currentTime / 60);
                const seconds = Math.floor(currentTime % 60);
                const totalMinutes = Math.floor(videoDuration / 60);
                const totalSeconds = Math.floor(videoDuration % 60);
                document.getElementById('progress-text').textContent = 
                    `${minutes}:${seconds.toString().padStart(2, '0')} / ${totalMinutes}:${totalSeconds.toString().padStart(2, '0')}`;
            }
        }
        
        function downloadCourse() {
            @if($section && isset($section['fichier_pdf']) && !empty($section['fichier_pdf']))
                const pdfPath = '{{ asset("storage/" . $section['fichier_pdf']) }}';
                const fileName = '{{ basename($section['fichier_pdf']) }}';
            @else
                // PDF par défaut si aucun PDF n'est fourni
                const pdfPath = '{{ asset("storage/cours/introduction_gestion_entreprise.pdf") }}';
                const fileName = 'Introduction_a_la_gestion_d_entreprise.pdf';
            @endif
            
            // Créer un lien de téléchargement pour le PDF
            const link = document.createElement('a');
            link.href = pdfPath;
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Cours dropdown menu
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>
</body>
</html>

