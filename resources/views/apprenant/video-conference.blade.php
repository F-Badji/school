<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visioconférence - {{ $cours->titre ?? 'Cours' }} - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #111827;
            overflow: hidden;
        }
        .sidebar-bg {
            background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        /* Styles pour appareils mobiles */
        @media (max-width: 768px) {
            #video-container {
                grid-template-columns: 1fr !important;
                gap: 0.5rem;
                padding: 0.5rem;
            }
            .video-participant {
                aspect-ratio: 4/3;
            }
            .sidebar-bg {
                width: 60px !important;
            }
            .w-96 {
                width: 100% !important;
                max-width: 100vw;
            }
            .flex-col {
                flex-direction: column;
            }
        }
        /* Support de l'orientation sur mobile */
        @media (orientation: landscape) and (max-width: 768px) {
            #video-container {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        #video-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            padding: 1rem;
            height: 100%;
            overflow-y: auto;
        }
        .video-participant {
            position: relative;
            background: #1f2937;
            border-radius: 0.5rem;
            overflow: hidden;
            aspect-ratio: 16/9;
            border: 2px solid #374151;
        }
        .video-participant.active {
            border-color: #3b82f6;
        }
        .participant-info {
            position: absolute;
            bottom: 0.5rem;
            left: 0.5rem;
            background: rgba(0, 0, 0, 0.7);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            color: white;
            font-size: 0.875rem;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translate(-50%, -20px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
        .pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Left Sidebar (minimal pour la visioconférence) -->
        <aside class="w-20 sidebar-bg text-white flex flex-col py-6">
            <div class="mb-8 flex items-center justify-center px-4">
                <a href="{{ route('apprenant.professeur.matiere', ['matiereSlug' => 'algorithmique']) }}" class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col bg-gray-900">
            <!-- Header -->
            <div class="bg-gray-800 border-b border-gray-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold text-white">{{ $cours->titre ?? 'Visioconférence' }}</h1>
                    </div>
                </div>
            </div>

            <!-- Main Video Area -->
            <div class="flex-1 flex overflow-hidden">
                <!-- Video Container -->
                <div class="flex-1 flex flex-col">
                    @if($participant->statut === 'en_attente')
                    <!-- Salle d'attente -->
                    <div class="flex-1 flex items-center justify-center bg-gray-900">
                        <div class="text-center">
                            <div class="mb-6">
                                <svg class="w-24 h-24 mx-auto text-blue-500 pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-semibold text-white mb-2">En attente d'autorisation</h2>
                            <p class="text-gray-400 mb-6">Votre demande d'accès a été envoyée au formateur.</p>
                            <div class="flex items-center justify-center gap-2 text-gray-500">
                                <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>
                    @elseif($participant->statut === 'refuse')
                    <!-- Accès refusé -->
                    <div class="flex-1 flex items-center justify-center bg-gray-900">
                        <div class="text-center">
                            <div class="mb-6">
                                <svg class="w-24 h-24 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-semibold text-white mb-2">Accès refusé</h2>
                            <p class="text-gray-400 mb-6">Votre demande d'accès a été refusée par le formateur.</p>
                            <a href="{{ route('apprenant.professeur.matiere', ['matiereSlug' => 'algorithmique']) }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Retour aux cours
                            </a>
                        </div>
                    </div>
                    @elseif($participant->statut === 'expulse')
                    <!-- Expulsé -->
                    <div class="flex-1 flex items-center justify-center bg-gray-900">
                        <div class="text-center">
                            <div class="mb-6">
                                <svg class="w-24 h-24 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-semibold text-white mb-2">Vous avez été expulsé</h2>
                            <p class="text-gray-400 mb-6">Vous avez été expulsé de la session par le formateur.</p>
                            <a href="{{ route('apprenant.professeur.matiere', ['matiereSlug' => 'algorithmique']) }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Retour aux cours
                            </a>
                        </div>
                    </div>
                    @else
                    <!-- Zone vidéo active -->
                    <div class="flex-1 bg-gray-900 overflow-hidden">
                        <div id="video-container" class="h-full">
                            <!-- Ma vidéo -->
                            <div class="video-participant active" id="local-video-container" data-user-id="{{ Auth::id() }}">
                                <video id="local-video" autoplay muted playsinline></video>
                            <!-- Les vidéos des autres participants seront ajoutées ici dynamiquement -->
                                <div class="participant-info">
                                    <span id="local-name">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</span>
                                    <span class="ml-2 text-xs text-gray-300">(Vous)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Contrôles en bas -->
                    <div class="bg-gray-800 border-t border-gray-700 px-6 py-4">
                        <div class="flex items-center justify-center gap-4">
                            @if($participant->statut !== 'en_attente')
                            <!-- Micro -->
                            <button id="toggle-micro" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors">
                                <span id="micro-icon-wrapper" class="flex items-center relative">
                                <svg id="micro-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path>
                                </svg>
                                    <svg id="micro-slash-icon" class="w-6 h-6 absolute left-0 top-0 hidden pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6"></path>
                                    </svg>
                                </span>
                            </button>

                            <!-- Caméra -->
                            <button id="toggle-camera" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors">
                                <span id="camera-icon-wrapper" class="flex items-center relative">
                                <svg id="camera-icon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106a1 1 0 00-1.106.553l-2 4A1 1 0 0013 13h2a1 1 0 00.894-.553l2-4a1 1 0 00-.553-1.341z"></path>
                                </svg>
                                    <svg id="camera-slash-icon" class="w-6 h-6 absolute left-0 top-0 hidden pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6"></path>
                                    </svg>
                                </span>
                            </button>

                            <!-- Bascule caméra (selfie) -->
                            <button id="switch-camera" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors" title="Basculer caméra avant/arrière">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <!-- Main levée -->
                            <button id="raise-hand" class="flex flex-col items-center justify-center gap-1 px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition-colors relative min-w-[120px]" title="Lever la main">
                                <!-- Icône main (emoji) -->
                                <span id="hand-icon" class="text-2xl">✋</span>
                                <!-- Texte du bouton -->
                                <span id="hand-button-text" class="text-xs font-medium">Lever la main</span>
                                <span id="hand-indicator" class="hidden absolute -top-1 -right-1 w-4 h-4 bg-yellow-500 rounded-full border-2 border-gray-800"></span>
                            </button>

                            <!-- Partage d'écran -->
                            <button id="share-screen" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                            </button>
                            @endif

                            <!-- Quitter -->
                            <button id="leave-call" class="flex items-center justify-center w-14 h-14 rounded-full bg-red-600 hover:bg-red-700 text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Participants & Chat -->
                @if($participant->statut !== 'en_attente')
                <div class="w-80 bg-gray-800 border-l border-gray-700 flex flex-col">
                    <!-- Onglets -->
                    <div class="flex border-b border-gray-700">
                        <button class="tab-btn flex-1 px-4 py-3 text-white bg-gray-700" data-tab="participants">
                            Participants
                        </button>
                        <button class="tab-btn flex-1 px-4 py-3 text-gray-400 hover:text-white" data-tab="chat">
                            Chat
                        </button>
                    </div>

                    <!-- Contenu Participants -->
                    <div id="tab-participants" class="tab-content flex flex-col flex-1 overflow-hidden">
                        <div class="p-4 border-b border-gray-700">
                            <h3 class="text-lg font-semibold text-white">Participants</h3>
                            <p class="text-sm text-gray-400" id="participants-count">0 participant(s)</p>
                        </div>
                        <div class="flex-1 overflow-y-auto p-4">
                            <div id="participants-list" class="space-y-3">
                                <!-- Liste des participants (sera rempli dynamiquement) -->
                            </div>
                        </div>
                    </div>

                    <!-- Contenu Chat -->
                    <div id="tab-chat" class="tab-content flex flex-col flex-1 overflow-hidden hidden">
                        <div class="p-4 border-b border-gray-700">
                            <h3 class="text-lg font-semibold text-white">Chat</h3>
                            <p class="text-sm text-gray-400" id="chat-count" style="display: none;">0 message(s)</p>
                        </div>
                        <div class="flex-1 overflow-y-auto p-4" id="chat-messages">
                            <!-- Messages de chat -->
                        </div>
                        <div class="p-2 border-t border-gray-700">
                            <div class="flex gap-2">
                                <input type="text" id="chat-input" placeholder="Tapez un message..." class="flex-1 px-3 py-1.5 text-sm bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button id="send-chat-btn" class="px-3 py-1.5 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                                    Envoyer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Laravel Echo & Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        console.log('🚀 [SCRIPT] Script chargé - Début de l\'exécution');
        
        // Configuration Pusher
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key', 'your-pusher-key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster', 'mt1') }}',
            encrypted: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }
        });

        const sessionId = {{ $session->id }};
        const participantId = {{ $participant->id }};
        const currentUserId = {{ Auth::id() }};
        const participantStatus = '{{ $participant->statut }}';
        const statusCheckUrl = '{{ route('apprenant.video-conference.status', ['sessionId' => $session->id]) }}';
        let isMicroActive = {{ $participant->micro_actif ? 'true' : 'false' }};
        let isCameraActive = {{ $participant->camera_active ? 'true' : 'false' }};
        let microControlled = {{ $participant->micro_controle_par_formateur ? 'true' : 'false' }};
        let cameraControlled = {{ $participant->camera_controlee_par_formateur ? 'true' : 'false' }};
        
        console.log('🎯 [GLOBAL] Variables initialisées:', {
            participantId,
            currentUserId,
            participantStatus,
            isMicroActive,
            isCameraActive,
            microControlled,
            cameraControlled
        });

        let localStream = null;
        let screenStream = null;
        let isSharingScreen = false;
        let peerConnections = new Map(); // Pour WebRTC peer-to-peer
        let remoteStreams = new Map();
        
        // Configuration WebRTC (doit être défini avant toute utilisation)
        var rtcConfiguration = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' }
            ]
        };
        
        console.log('✅ [RTC] rtcConfiguration défini:', rtcConfiguration);

        // Vérifier le statut périodiquement si en attente
        if (participantStatus === 'en_attente') {
            setInterval(async () => {
                try {
                    const response = await fetch(`{{ route('apprenant.video-conference.status', ['sessionId' => $session->id]) }}`);
                    const data = await response.json();
                    
                    if (data.statut !== 'en_attente') {
                        location.reload();
                    }
                } catch (error) {
                    console.error('Erreur lors de la vérification du statut:', error);
                }
            }, 3000);
        }

        // Gestion de la déconnexion/reconnexion
        let isMarkedAbsent = false;
        let heartbeatInterval = null;
        let lastHeartbeat = Date.now();

        // Fonction pour marquer comme absent
        async function markAsAbsent() {
            if (isMarkedAbsent || participantStatus === 'en_attente') return;
            
            try {
                await fetch(`{{ route('apprenant.video-conference.mark-absent', ['sessionId' => $session->id]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                isMarkedAbsent = true;
                console.log('Marqué comme absent');
            } catch (error) {
                console.error('Erreur lors du marquage comme absent:', error);
            }
        }

        // Fonction pour marquer comme présent
        async function markAsPresent() {
            if (!isMarkedAbsent) return;
            
            try {
                const response = await fetch(`{{ route('apprenant.video-conference.mark-present', ['sessionId' => $session->id]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (data.success) {
                    isMarkedAbsent = false;
                    console.log('Marqué comme présent');
                }
            } catch (error) {
                console.error('Erreur lors du marquage comme présent:', error);
            }
        }

        // Heartbeat pour détecter les déconnexions silencieuses
        function startHeartbeat() {
            heartbeatInterval = setInterval(async () => {
                const now = Date.now();
                // Si le dernier heartbeat est trop ancien (plus de 10 secondes), on est probablement déconnecté
                if (now - lastHeartbeat > 10000 && !isMarkedAbsent && participantStatus !== 'en_attente') {
                    await markAsAbsent();
                }
                lastHeartbeat = now;
            }, 5000); // Vérifier toutes les 5 secondes
        }

        // Détecter la fermeture de l'onglet/navigateur
        window.addEventListener('beforeunload', async (e) => {
            if (participantStatus !== 'en_attente') {
                // Utiliser sendBeacon pour garantir l'envoi même si la page se ferme
                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                navigator.sendBeacon(
                    `{{ route('apprenant.video-conference.mark-absent', ['sessionId' => $session->id]) }}`,
                    formData
                );
            }
        });

        // Détecter le changement d'onglet (perte de focus)
        document.addEventListener('visibilitychange', async () => {
            if (participantStatus === 'en_attente') return;
            
            if (document.hidden) {
                // L'onglet est caché, marquer comme absent après un délai
                setTimeout(async () => {
                    if (document.hidden && !isMarkedAbsent) {
                        await markAsAbsent();
                    }
                }, 5000); // Attendre 5 secondes avant de marquer comme absent
            } else {
                // L'onglet est visible, remettre comme présent
                if (isMarkedAbsent) {
                    await markAsPresent();
                }
                lastHeartbeat = Date.now();
            }
        });

        // Détecter la perte de connexion réseau
        window.addEventListener('online', async () => {
            if (isMarkedAbsent && participantStatus !== 'en_attente') {
                await markAsPresent();
            }
            lastHeartbeat = Date.now();
        });

        window.addEventListener('offline', async () => {
            if (!isMarkedAbsent && participantStatus !== 'en_attente') {
                await markAsAbsent();
            }
        });

        // Démarrer le heartbeat si l'apprenant est accepté/présent
        if (participantStatus === 'accepte' || participantStatus === 'present') {
            startHeartbeat();
            lastHeartbeat = Date.now();
        }

        // Initialiser la vidéo si accepté
        if (participantStatus === 'accepte' || participantStatus === 'present') {
            initVideo();
        }

        // Modal de demande d'autorisation
        function showPermissionModal() {
            return new Promise((resolve, reject) => {
                const modal = document.createElement('div');
                modal.id = 'permission-modal';
                modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                        <h3 class="text-xl font-semibold text-white mb-4">Autorisation requise</h3>
                        <p class="text-gray-300 mb-6">
                            Pour participer à la visioconférence, nous avons besoin d'accéder à votre caméra et microphone.
                            Veuillez autoriser l'accès lorsque votre navigateur vous le demandera.
                        </p>
                        <div class="flex gap-3">
                            <button id="request-permission-btn" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Autoriser l'accès
                            </button>
                            <button id="cancel-permission-btn" class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                Continuer sans caméra
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);

                // Attacher les événements après l'insertion dans le DOM
                setTimeout(() => {
                    const requestBtn = document.getElementById('request-permission-btn');
                    const cancelBtn = document.getElementById('cancel-permission-btn');
                    
                    if (requestBtn) {
                        requestBtn.addEventListener('click', async () => {
                            modal.remove();
                            try {
                                await requestMediaAccess();
                                resolve();
                            } catch (error) {
                                reject(error);
                            }
                        });
                    }

                    if (cancelBtn) {
                        cancelBtn.addEventListener('click', () => {
                            modal.remove();
                            // Continuer sans caméra/micro
                            resolve();
                        });
                    }
                }, 100);
            });
        }

        // Détecter le type d'appareil
        function detectDevice() {
            const ua = navigator.userAgent || navigator.vendor || window.opera;
            const isMobile = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(ua.toLowerCase());
            const isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
            const isAndroid = /android/i.test(ua);
            const isMac = /Macintosh|MacIntel|MacPPC|Mac68K/.test(ua);
            const isWindows = /Windows/.test(ua);
            const isLinux = /Linux/.test(ua) && !isAndroid;
            
            return {
                isMobile,
                isIOS,
                isAndroid,
                isMac,
                isWindows,
                isLinux,
                isDesktop: !isMobile
            };
        }

        // Obtenir les configurations adaptées à l'appareil
        function getDeviceConfigurations(device) {
            const configs = [];

            if (device.isMobile) {
                // Configurations pour appareils mobiles (Android, iOS)
                if (device.isIOS) {
                    // iPhone/iPad - configurations spécifiques iOS
                    configs.push(
                        {
                            video: {
                                facingMode: 'user',
                                width: { ideal: 640 },
                                height: { ideal: 480 }
                            },
                            audio: {
                                echoCancellation: true,
                                noiseSuppression: true
                            }
                        },
                        {
                            video: {
                                facingMode: 'user'
                            },
                            audio: true
                        },
                        {
                            video: true,
                            audio: true
                        },
                        {
                            video: true,
                            audio: false
                        },
                        {
                            video: false,
                            audio: true
                        }
                    );
                } else if (device.isAndroid) {
                    // Android - configurations spécifiques
                    configs.push(
                        {
                            video: {
                                facingMode: 'user',
                                width: { ideal: 640 },
                                height: { ideal: 480 }
                            },
                            audio: {
                                echoCancellation: true,
                                noiseSuppression: true,
                                autoGainControl: true
                            }
                        },
                        {
                            video: {
                                facingMode: 'user'
                            },
                            audio: {
                                echoCancellation: true
                            }
                        },
                        {
                            video: true,
                            audio: true
                        },
                        {
                            video: true,
                            audio: false
                        },
                        {
                            video: false,
                            audio: true
                        }
                    );
                } else {
                    // Autres mobiles
                    configs.push(
                        { video: true, audio: true },
                        { video: true, audio: false },
                        { video: false, audio: true }
                    );
                }
            } else {
                // Configurations pour ordinateurs (Mac, Windows, Linux)
                configs.push(
                    // Configuration optimale pour desktop
                    {
                        video: {
                            width: { ideal: 1280, max: 1920 },
                            height: { ideal: 720, max: 1080 },
                            frameRate: { ideal: 30, max: 60 }
                        },
                        audio: {
                            echoCancellation: true,
                            noiseSuppression: true,
                            autoGainControl: true,
                            sampleRate: { ideal: 48000 }
                        }
                    },
                    // Configuration moyenne
                    {
                        video: {
                            width: { ideal: 1280 },
                            height: { ideal: 720 }
                        },
                        audio: {
                            echoCancellation: true,
                            noiseSuppression: true,
                            autoGainControl: true
                        }
                    },
                    // Configuration standard
                    {
                        video: {
                            width: { ideal: 640 },
                            height: { ideal: 480 }
                        },
                        audio: {
                            echoCancellation: true,
                            noiseSuppression: true
                        }
                    },
                    // Configuration minimale
                    {
                        video: true,
                        audio: true
                    },
                    // Vidéo seulement
                    {
                        video: true,
                        audio: false
                    },
                    // Audio seulement
                    {
                        video: false,
                        audio: true
                    }
                );
            }

            return configs;
        }

        // Demander l'accès aux médias avec fallback progressif adapté à l'appareil
        async function requestMediaAccess() {
            try {
            // Vérifier si l'API est disponible
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                throw new Error('Votre navigateur ne supporte pas l\'accès aux médias. Veuillez utiliser un navigateur moderne (Chrome, Firefox, Edge, Safari).');
            }

            // Détecter l'appareil
            const device = detectDevice();
            console.log('Appareil détecté:', device);

            // Obtenir les configurations adaptées
            const configurations = getDeviceConfigurations(device);

            let lastError = null;
            
            for (const config of configurations) {
                try {
                    localStream = await navigator.mediaDevices.getUserMedia(config);
                    // Si on arrive ici, la configuration a fonctionné
                    break;
                } catch (error) {
                    lastError = error;
                    // Continuer avec la configuration suivante
                    continue;
                }
            }

            // Si aucune configuration n'a fonctionné, lancer l'erreur
            if (!localStream) {
                throw lastError || new Error('Impossible d\'accéder aux médias.');
            }

                const localVideo = document.getElementById('local-video');
                if (localVideo) {
                    localVideo.srcObject = localStream;
                    localVideo.play().catch(err => {
                        console.error('Erreur lors de la lecture de la vidéo:', err);
                    });
                }

                // Appliquer les contrôles du formateur
                if (localStream) {
                    localStream.getVideoTracks().forEach(track => {
                        track.enabled = isCameraActive && !cameraControlled;
                    });
                    localStream.getAudioTracks().forEach(track => {
                        track.enabled = isMicroActive && !microControlled;
                    });
                }

                updateControls();

                // Masquer le message d'erreur s'il existe
                const errorMsg = document.getElementById('media-error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }

                return true;
            } catch (error) {
                console.error('Erreur lors de l\'accès aux médias:', error);
                
                let errorMessage = 'Impossible d\'accéder à votre caméra ou microphone.';
                
                if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                    errorMessage = 'L\'accès à la caméra et au microphone a été refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur et réessayer.';
                } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                    errorMessage = 'Aucune caméra ou microphone n\'a été détecté. Veuillez vérifier que vos périphériques sont connectés.';
                } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                    errorMessage = 'La caméra ou le microphone est déjà utilisé par une autre application. Veuillez fermer les autres applications et réessayer.';
                } else if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
                    errorMessage = 'Les paramètres demandés ne sont pas supportés par votre périphérique. Le système va essayer une configuration plus simple.';
                }

                // Afficher le message d'erreur avec un bouton pour réessayer
                showMediaError(errorMessage);
                throw error;
            }
        }

        // Afficher le message d'erreur
        function showMediaError(message) {
            // Supprimer l'ancien message s'il existe
            const existingError = document.getElementById('media-error-message');
            if (existingError) {
                existingError.remove();
            }

            const errorDiv = document.createElement('div');
            errorDiv.id = 'media-error-message';
            errorDiv.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-md';
            errorDiv.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold">Erreur d'accès aux médias</p>
                        <p class="text-sm mt-1">${message}</p>
                    </div>
                    <button id="retry-media-btn" class="ml-4 px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded transition-colors">
                        Réessayer
                    </button>
                </div>
            `;
            document.body.appendChild(errorDiv);

            // Bouton pour réessayer
            document.getElementById('retry-media-btn').addEventListener('click', async () => {
                errorDiv.remove();
                try {
                    await showPermissionModal();
                } catch (err) {
                    console.error('Erreur lors de la nouvelle tentative:', err);
                }
            });

            // Masquer automatiquement après 10 secondes
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.remove();
                }
            }, 10000);
        }

        async function initVideo() {
            try {
                await showPermissionModal();
            } catch (error) {
                console.error('Erreur lors de l\'initialisation de la vidéo:', error);
                // L'erreur est déjà gérée par showMediaError
            }
        }

        function updateControls() {
            console.log('🔧 [UPDATE CONTROLS] ========== DÉBUT ==========');
            console.log('🔧 [UPDATE CONTROLS] État:', {
                isMicroActive,
                microControlled,
                isCameraActive,
                cameraControlled,
                participantStatus
            });
            
            // Ne pas mettre à jour les contrôles si l'apprenant est en attente
            if (participantStatus === 'en_attente') {
                console.log('⏸️ [UPDATE CONTROLS] Statut en attente, retour');
                return;
            }
            
            const microBtn = document.getElementById('toggle-micro');
            const cameraBtn = document.getElementById('toggle-camera');
            const microIcon = document.getElementById('micro-icon');
            const cameraIcon = document.getElementById('camera-icon');
            const microSlashIcon = document.getElementById('micro-slash-icon');
            const cameraSlashIcon = document.getElementById('camera-slash-icon');

            console.log('🔧 [UPDATE CONTROLS] Éléments trouvés:', {
                microBtn: !!microBtn,
                cameraBtn: !!cameraBtn,
                microIcon: !!microIcon,
                cameraIcon: !!cameraIcon,
                microSlashIcon: !!microSlashIcon,
                cameraSlashIcon: !!cameraSlashIcon
            });

            if (!microBtn || !cameraBtn) {
                console.error('❌ [UPDATE CONTROLS] microBtn ou cameraBtn introuvable!');
                return;
            }

            // Toujours garder le style de base (fond gris) pour les boutons
            console.log('🔧 [UPDATE CONTROLS] Classes bouton micro AVANT:', microBtn.className);
            microBtn.classList.remove('bg-red-600', 'bg-green-600');
                microBtn.classList.add('bg-gray-700');
            console.log('🔧 [UPDATE CONTROLS] Classes bouton micro APRÈS:', microBtn.className);
            
            cameraBtn.classList.remove('bg-red-600', 'bg-green-600');
            cameraBtn.classList.add('bg-gray-700');

            // Micro - EXACTEMENT comme dans l'onglet Participants
            // Dans l'onglet: ${participant.micro_actif ? 'text-green-400' : 'text-red-400'}
            const shouldShowMicroSlash = !(isMicroActive && !microControlled);
            console.log('🔧 [UPDATE CONTROLS] Micro - shouldShowMicroSlash:', shouldShowMicroSlash, 'isMicroActive:', isMicroActive, 'microControlled:', microControlled);
            
            if (shouldShowMicroSlash) {
                // Micro coupé ou contrôlé : afficher la barre (comme dans l'onglet: text-red-400)
                console.log('🔴 [UPDATE CONTROLS] Micro coupé - Afficher barre rouge');
                if (microIcon) {
                    microIcon.classList.remove('text-green-400');
                    microIcon.classList.add('text-red-400');
                    console.log('✅ [UPDATE CONTROLS] microIcon classes:', microIcon.className);
                }
                if (microSlashIcon) {
                    console.log('🔧 [UPDATE CONTROLS] microSlashIcon AVANT:', {
                        classes: microSlashIcon.className,
                        display: window.getComputedStyle(microSlashIcon).display,
                        visibility: window.getComputedStyle(microSlashIcon).visibility,
                        opacity: window.getComputedStyle(microSlashIcon).opacity
                    });
                    microSlashIcon.classList.remove('hidden');
                    console.log('🔧 [UPDATE CONTROLS] microSlashIcon APRÈS:', {
                        classes: microSlashIcon.className,
                        display: window.getComputedStyle(microSlashIcon).display,
                        visibility: window.getComputedStyle(microSlashIcon).visibility,
                        opacity: window.getComputedStyle(microSlashIcon).opacity
                    });
                } else {
                    console.error('❌ [UPDATE CONTROLS] microSlashIcon introuvable!');
                }
            } else {
                // Micro actif : pas de barre (comme dans l'onglet: text-green-400)
                console.log('✅ [UPDATE CONTROLS] Micro actif - Cacher barre, couleur verte');
                if (microIcon) {
                    microIcon.classList.remove('text-red-400');
                    microIcon.classList.add('text-green-400');
                    console.log('✅ [UPDATE CONTROLS] microIcon classes:', microIcon.className);
                }
                if (microSlashIcon) {
                    microSlashIcon.classList.add('hidden');
                    console.log('✅ [UPDATE CONTROLS] microSlashIcon caché');
                }
            }

            // Caméra - EXACTEMENT comme dans l'onglet Participants
            const shouldShowCameraSlash = !(isCameraActive && !cameraControlled);
            console.log('🔧 [UPDATE CONTROLS] Caméra - shouldShowCameraSlash:', shouldShowCameraSlash, 'isCameraActive:', isCameraActive, 'cameraControlled:', cameraControlled);
            
            if (shouldShowCameraSlash) {
                // Caméra coupée ou contrôlée : afficher la barre (comme dans l'onglet: text-red-400)
                console.log('🔴 [UPDATE CONTROLS] Caméra coupée - Afficher barre rouge');
                if (cameraIcon) {
                    cameraIcon.classList.remove('text-green-400');
                    cameraIcon.classList.add('text-red-400');
                    console.log('✅ [UPDATE CONTROLS] cameraIcon classes:', cameraIcon.className);
                }
                if (cameraSlashIcon) {
                    console.log('🔧 [UPDATE CONTROLS] cameraSlashIcon AVANT:', {
                        classes: cameraSlashIcon.className,
                        display: window.getComputedStyle(cameraSlashIcon).display,
                        visibility: window.getComputedStyle(cameraSlashIcon).visibility,
                        opacity: window.getComputedStyle(cameraSlashIcon).opacity
                    });
                    cameraSlashIcon.classList.remove('hidden');
                    console.log('🔧 [UPDATE CONTROLS] cameraSlashIcon APRÈS:', {
                        classes: cameraSlashIcon.className,
                        display: window.getComputedStyle(cameraSlashIcon).display,
                        visibility: window.getComputedStyle(cameraSlashIcon).visibility,
                        opacity: window.getComputedStyle(cameraSlashIcon).opacity
                    });
            } else {
                    console.error('❌ [UPDATE CONTROLS] cameraSlashIcon introuvable!');
                }
            } else {
                // Caméra active : pas de barre (comme dans l'onglet: text-green-400)
                console.log('✅ [UPDATE CONTROLS] Caméra active - Cacher barre, couleur verte');
                if (cameraIcon) {
                    cameraIcon.classList.remove('text-red-400');
                    cameraIcon.classList.add('text-green-400');
                    console.log('✅ [UPDATE CONTROLS] cameraIcon classes:', cameraIcon.className);
                }
                if (cameraSlashIcon) {
                    cameraSlashIcon.classList.add('hidden');
                    console.log('✅ [UPDATE CONTROLS] cameraSlashIcon caché');
                }
            }
            
            console.log('🔧 [UPDATE CONTROLS] ========== FIN ==========');
        }

        // Toggle micro
        document.getElementById('toggle-micro')?.addEventListener('click', async () => {
            if (microControlled) {
                alert('Votre microphone est contrôlé par le formateur.');
                // S'assurer que le bouton est bien barré en rouge même si l'alerte est affichée
                updateControls();
                return;
            }

            try {
                const response = await fetch(`{{ route('apprenant.video-conference.toggle-micro', ['sessionId' => $session->id]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    isMicroActive = data.micro_actif;
                    if (localStream) {
                        localStream.getAudioTracks().forEach(track => {
                            track.enabled = isMicroActive;
                        });
                    }
                    updateControls();
                }
            } catch (error) {
                console.error('Erreur lors du toggle micro:', error);
            }
        });

        // Toggle caméra
        document.getElementById('toggle-camera')?.addEventListener('click', async () => {
            if (cameraControlled) {
                alert('Votre caméra est contrôlée par le formateur.');
                return;
            }

            try {
                const response = await fetch(`{{ route('apprenant.video-conference.toggle-camera', ['sessionId' => $session->id]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    isCameraActive = data.camera_active;
                    if (localStream) {
                        localStream.getVideoTracks().forEach(track => {
                            track.enabled = isCameraActive;
                        });
                    }
                    updateControls();
                }
            } catch (error) {
                console.error('Erreur lors du toggle caméra:', error);
            }
        });

        // Quitter l'appel
        document.getElementById('leave-call')?.addEventListener('click', async () => {
            const message = participantStatus === 'en_attente' 
                ? 'Êtes-vous sûr de vouloir annuler votre demande ?' 
                : 'Êtes-vous sûr de vouloir quitter la session ?';
            
            if (confirm(message)) {
                try {
                    await fetch(`{{ route('apprenant.video-conference.leave', ['sessionId' => $session->id]) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (localStream) {
                        localStream.getTracks().forEach(track => track.stop());
                    }

                    window.location.href = '{{ route('apprenant.professeur.matiere', ['matiereSlug' => 'algorithmique']) }}';
                } catch (error) {
                    console.error('Erreur lors de la sortie:', error);
                    window.location.href = '{{ route('apprenant.professeur.matiere', ['matiereSlug' => 'algorithmique']) }}';
                }
            }
        });

        // Gestion des onglets
        if (participantStatus !== 'en_attente') {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('bg-gray-700', 'text-white');
                    b.classList.add('text-gray-400');
                });
                btn.classList.add('bg-gray-700', 'text-white');
                btn.classList.remove('text-gray-400');

                    // SÉCURITÉ : Masquer TOUS les onglets d'abord pour éviter les fuites de données
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                        // SÉCURITÉ : Vider le contenu des onglets non actifs pour éviter les fuites
                        if (content.id !== `tab-${tab}`) {
                            // Ne pas vider les conteneurs de données, juste s'assurer qu'ils sont masqués
                        }
                    });
                    
                    // SÉCURITÉ : Afficher uniquement l'onglet sélectionné
                    const tabContent = document.getElementById(`tab-${tab}`);
                    if (tabContent) {
                        tabContent.classList.remove('hidden');
                        
                        // SÉCURITÉ : S'assurer que seul l'onglet actif est visible
                        document.querySelectorAll('.tab-content').forEach(otherContent => {
                            if (otherContent.id !== tabContent.id) {
                                otherContent.classList.add('hidden');
                            }
                        });
                    }

                    // SÉCURITÉ : Charger les données uniquement pour l'onglet actif
                if (tab === 'chat') {
                        // S'assurer que l'onglet participants est bien masqué
                        const participantsTab = document.getElementById('tab-participants');
                        if (participantsTab) {
                            participantsTab.classList.add('hidden');
                        }
                    loadChatMessages();
                    } else if (tab === 'participants') {
                        // S'assurer que l'onglet chat est bien masqué
                        const chatTab = document.getElementById('tab-chat');
                        if (chatTab) {
                            chatTab.classList.add('hidden');
                        }
                        // Recharger les participants si nécessaire
                        if (participantStatus === 'accepte' || participantStatus === 'present') {
                            loadParticipants();
                        }
                }
            });
        });
        }

        // Partage d'écran
        document.getElementById('share-screen')?.addEventListener('click', async () => {
            try {
                if (!isSharingScreen) {
                    screenStream = await navigator.mediaDevices.getDisplayMedia({
                        video: true,
                        audio: true
                    });

                    const localVideo = document.getElementById('local-video');
                    if (localVideo) {
                        localVideo.srcObject = screenStream;
                    }

                    isSharingScreen = true;
                    document.getElementById('share-screen').classList.add('bg-green-600');
                    document.getElementById('share-screen').classList.remove('bg-gray-700');

                    screenStream.getVideoTracks()[0].addEventListener('ended', () => {
                        stopScreenShare();
                    });
                } else {
                    stopScreenShare();
                }
            } catch (error) {
                console.error('Erreur lors du partage d\'écran:', error);
            }
        });

        function stopScreenShare() {
            if (screenStream) {
                screenStream.getTracks().forEach(track => track.stop());
                screenStream = null;
            }

            isSharingScreen = false;
            document.getElementById('share-screen').classList.remove('bg-green-600');
            document.getElementById('share-screen').classList.add('bg-gray-700');

            if (localStream && isCameraActive) {
                const localVideo = document.getElementById('local-video');
                if (localVideo) {
                    localVideo.srcObject = localStream;
                }
            }
        }

        // Charger la liste des participants
        async function loadParticipants() {
            if (participantStatus === 'en_attente') {
                console.log('⏸️ [PARTICIPANTS] Statut en attente, chargement annulé');
                return;
            }
            
            try {
                console.log('📋 [PARTICIPANTS] Chargement des participants...');
                const response = await fetch(`{{ route('apprenant.video-conference.active-participants', ['sessionId' => $session->id]) }}`);
                
                if (!response.ok) {
                    console.error('❌ [PARTICIPANTS] Erreur HTTP:', response.status);
                    return;
                }
                
                const data = await response.json();
                console.log('📋 [PARTICIPANTS] Données reçues:', data);
                
                if (data.success && data.participants) {
                    const container = document.getElementById('participants-list');
                    const countElement = document.getElementById('participants-count');
                    
                    console.log('📋 [PARTICIPANTS] Conteneur trouvé:', !!container, 'Compteur trouvé:', !!countElement);
                    
                    if (!container) {
                        console.error('❌ [PARTICIPANTS] Conteneur participants-list introuvable');
                        return;
                    }
                    
                    if (countElement) {
                        countElement.textContent = `${data.participants.length} participant(s)`;
                    }
                    
                    // SÉCURITÉ : Vérifier que l'onglet participants est actif avant d'afficher les données
                    const tabParticipants = document.getElementById('tab-participants');
                    const tabChat = document.getElementById('tab-chat');
                    
                    // S'assurer que seul l'onglet participants est visible
                    if (tabParticipants && !tabParticipants.classList.contains('hidden')) {
                        // L'onglet participants est actif, on peut afficher les données
                        if (tabChat) {
                            tabChat.classList.add('hidden');
                        }
                    } else {
                        // L'onglet participants n'est pas actif, ne pas afficher les données
                        console.log('⚠️ [PARTICIPANTS] L\'onglet participants n\'est pas actif, données non affichées');
                        return;
                    }
                    
                    if (data.participants.length === 0) {
                        container.innerHTML = '<p class="text-gray-400 text-center py-4">Aucun participant</p>';
                        console.log('📋 [PARTICIPANTS] Aucun participant trouvé');
                        return;
                    }
                    
                    console.log('📋 [PARTICIPANTS] Affichage de', data.participants.length, 'participants');
                    
                    // Fonction helper pour échapper le HTML (définie une seule fois)
                    function escapeHtml(text) {
                        if (!text) return '';
                        const div = document.createElement('div');
                        div.textContent = text;
                        return div.innerHTML;
                    }
                    
                    // Créer le HTML pour tous les participants
                    let participantsHTML = '';
                    data.participants.forEach((participant, index) => {
                        console.log(`📋 [PARTICIPANTS] Participant ${index + 1}:`, participant.nom);
                        
                        // Créer l'élément d'avatar avec photo ou initiales
                        const initiales = escapeHtml(participant.nom ? participant.nom.charAt(0).toUpperCase() : '?');
                        let avatarHtml = '';
                        if (participant.photo) {
                            const safePhotoPath = participant.photo.replace(/[^a-zA-Z0-9_\-\.\/]/g, '');
                            if (safePhotoPath.match(/^(photos|avatars)\//)) {
                                const photoPath = `/storage/${safePhotoPath}`;
                                avatarHtml = `
                                    <div class="relative w-10 h-10">
                                        <img src="${photoPath}" alt="${escapeHtml(participant.nom || '')}" class="w-10 h-10 rounded-full object-cover" 
                                             onerror="this.onerror=null; this.style.display='none'; const fallback = this.nextElementSibling; if(fallback) fallback.style.display='flex';">
                                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white font-semibold" style="display:none;">
                                            ${initiales}
                                        </div>
                                    </div>
                                `;
                            } else {
                                avatarHtml = `<div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    ${initiales}
                                </div>`;
                            }
                        } else {
                                avatarHtml = `<div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    ${initiales}
                                </div>`;
                        }
                        
                        participantsHTML += `
                            <div class="bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center gap-3">
                                    ${avatarHtml}
                                    <div class="flex-1">
                                        <p class="text-white font-medium flex items-center gap-2">
                                            ${escapeHtml(participant.nom || 'Inconnu')}
                                            ${participant.is_formateur ? '<span class="text-xs bg-yellow-600 px-2 py-0.5 rounded ml-2">Formateur</span>' : ''}
                                            ${participant.main_levée ? '<span class="text-yellow-500 text-lg" title="Main levée">✋</span>' : ''}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs flex items-center relative ${participant.micro_actif ? 'text-green-400' : 'text-red-400'}">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path>
                                                </svg>
                                                ${!participant.micro_actif ? '<svg class="w-4 h-4 absolute left-0 top-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6"></path></svg>' : ''}
                                            </span>
                                            <span class="text-xs flex items-center relative ${participant.camera_active ? 'text-green-400' : 'text-red-400'}">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106a1 1 0 00-1.106.553l-2 4A1 1 0 0013 13h2a1 1 0 00.894-.553l2-4a1 1 0 00-.553-1.341z"></path>
                                                </svg>
                                                ${!participant.camera_active ? '<svg class="w-4 h-4 absolute left-0 top-0 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6"></path></svg>' : ''}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    // Insérer tout le HTML d'un coup
                    container.innerHTML = participantsHTML;
                    console.log('✅ [PARTICIPANTS] Liste des participants affichée avec succès. HTML inséré:', container.innerHTML.length, 'caractères');
                } else {
                    console.error('❌ [PARTICIPANTS] Réponse API invalide:', data);
                }
            } catch (error) {
                console.error('❌ [PARTICIPANTS] Erreur lors du chargement des participants:', error);
            }
        }

        // Chat
        async function loadChatMessages() {
            // SÉCURITÉ : Vérifier que l'utilisateur est bien dans la session
            if (participantStatus === 'en_attente') {
                console.log('⏸️ [CHAT] Statut en attente, chargement annulé');
                return;
            }
            
            // SÉCURITÉ : Vérifier que l'onglet chat est actif avant de charger les messages
            const tabChat = document.getElementById('tab-chat');
            const tabParticipants = document.getElementById('tab-participants');
            
            if (!tabChat || tabChat.classList.contains('hidden')) {
                console.log('⚠️ [CHAT] L\'onglet chat n\'est pas actif, chargement annulé');
                return;
            }
            
            // S'assurer que l'onglet participants est bien masqué
            if (tabParticipants) {
                tabParticipants.classList.add('hidden');
            }
            
            try {
                // SÉCURITÉ : Utiliser uniquement la session ID de la page actuelle
                const currentSessionId = {{ $session->id }};
                const response = await fetch(`{{ route('apprenant.video-conference.chat.messages', ['sessionId' => $session->id]) }}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    if (response.status === 403) {
                        console.error('❌ [CHAT] Accès refusé - Vous n\'êtes pas autorisé à voir ces messages');
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success && data.messages) {
                    const container = document.getElementById('chat-messages');
                    if (!container) {
                        console.error('❌ [CHAT] Conteneur chat-messages introuvable');
                        return;
                    }
                    
                    container.innerHTML = '';
                    
                    // SÉCURITÉ : Vérifier que tous les messages appartiennent à cette session
                    // currentUserId est déjà défini en haut du script
                    data.messages.forEach(msg => {
                        // SÉCURITÉ : Vérifier que le message a un user_id valide
                        if (msg.user_id && msg.message) {
                            addChatMessage(msg, msg.user_id === currentUserId);
                        }
                    });
                    
                    container.scrollTop = container.scrollHeight;
                } else {
                    console.error('❌ [CHAT] Réponse API invalide:', data);
                }
            } catch (error) {
                console.error('❌ [CHAT] Erreur lors du chargement des messages:', error);
            }
        }

        function addChatMessage(msg, isOwn = false) {
            // SÉCURITÉ : Vérifier que le message est valide
            if (!msg || !msg.message || !msg.nom) {
                console.error('❌ [CHAT] Message invalide:', msg);
                return;
            }
            
            const container = document.getElementById('chat-messages');
            if (!container) {
                console.error('❌ [CHAT] Conteneur chat-messages introuvable');
                return;
            }
            
            // SÉCURITÉ : Échapper le HTML pour éviter les injections XSS
            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            const div = document.createElement('div');
            div.className = `mb-4 ${isOwn ? 'text-right' : 'text-left'}`;
            div.innerHTML = `
                <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwn ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white'}">
                    <p class="text-xs ${isOwn ? 'text-blue-200' : 'text-gray-300'} mb-1">${escapeHtml(msg.nom)}</p>
                    <p class="text-sm">${escapeHtml(msg.message)}</p>
                    <p class="text-xs ${isOwn ? 'text-blue-200' : 'text-gray-400'} mt-1">${new Date(msg.created_at).toLocaleTimeString()}</p>
                </div>
            `;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

        document.getElementById('send-chat-btn')?.addEventListener('click', async () => {
            // SÉCURITÉ : Vérifier que l'utilisateur est bien dans la session
            if (participantStatus === 'en_attente') {
                console.log('⏸️ [CHAT] Statut en attente, envoi annulé');
                return;
            }
            
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            
            if (!message) return;
            
            // SÉCURITÉ : Limiter la longueur du message côté client
            if (message.length > 1000) {
                alert('Le message est trop long (maximum 1000 caractères)');
                return;
            }

            try {
                // SÉCURITÉ : Utiliser uniquement la session ID de la page actuelle
                const currentSessionId = {{ $session->id }};
                const response = await fetch(`{{ route('apprenant.video-conference.chat.send', ['sessionId' => $session->id]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ message: message })
                });

                if (!response.ok) {
                    if (response.status === 403) {
                        alert('Accès refusé. Vous n\'êtes pas autorisé à envoyer des messages dans cette session.');
                        return;
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                if (data.success && data.message) {
                    input.value = '';
                    // SÉCURITÉ : Vérifier que le message retourné appartient à cette session
                    if (data.message.video_session_id === currentSessionId) {
                        addChatMessage(data.message, true);
                    }
                } else {
                    console.error('❌ [CHAT] Erreur lors de l\'envoi:', data);
                }
            } catch (error) {
                console.error('❌ [CHAT] Erreur lors de l\'envoi du message:', error);
                alert('Erreur lors de l\'envoi du message. Veuillez réessayer.');
            }
        });

        document.getElementById('chat-input')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('send-chat-btn').click();
            }
        });

        // Lever/Baisser la main
        let isHandRaised = false; // État local de la main
        document.getElementById('raise-hand')?.addEventListener('click', async () => {
            if (participantStatus === 'en_attente') return;
            
            try {
                const response = await fetch(`{{ route('apprenant.video-conference.raise-hand', ['sessionId' => $session->id]) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    const raiseHandBtn = document.getElementById('raise-hand');
                    const handIcon = document.getElementById('hand-icon');
                    const handButtonText = document.getElementById('hand-button-text');
                    const handIndicator = document.getElementById('hand-indicator');
                    
                    isHandRaised = data.main_levée;
                    
                    if (data.main_levée) {
                        // Main levée : fond jaune, emoji ✋, texte "Baisser la main"
                        raiseHandBtn.classList.add('bg-yellow-600');
                        raiseHandBtn.classList.remove('bg-gray-700');
                        if (handIndicator) handIndicator.classList.remove('hidden');
                        
                        // L'emoji reste ✋
                        if (handIcon) {
                            handIcon.textContent = '✋';
                        }
                        
                        // Changer le texte
                        if (handButtonText) {
                            handButtonText.textContent = 'Baisser la main';
                        }
                    } else {
                        // Main baissée : fond gris, emoji ✋, texte "Lever la main"
                        raiseHandBtn.classList.remove('bg-yellow-600');
                        raiseHandBtn.classList.add('bg-gray-700');
                        if (handIndicator) handIndicator.classList.add('hidden');
                        
                        // L'emoji reste ✋
                        if (handIcon) {
                            handIcon.textContent = '✋';
                        }
                        
                        // Changer le texte
                        if (handButtonText) {
                            handButtonText.textContent = 'Lever la main';
                        }
                    }
                }
            } catch (error) {
                console.error('Erreur lors du lever de main:', error);
            }
        });

        // Fonction pour afficher la notification de main levée
        function showHandRaisedNotification(nom) {
            // Fonction helper pour échapper le HTML
            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Supprimer toute notification existante
            const existingNotification = document.getElementById('hand-raised-notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            // Créer la notification
            const notification = document.createElement('div');
            notification.id = 'hand-raised-notification';
            notification.className = 'fixed top-20 left-1/2 transform -translate-x-1/2 z-50';
            notification.innerHTML = `
                <div class="bg-blue-600 text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 animate-fade-in">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.36 13.8c.19.58.3 1.2.3 1.85 0 3.31-2.69 6-6 6h-1.5c-.28 0-.5.22-.5.5s.22.5.5.5H18c3.87 0 7-3.13 7-7 0-1.13-.27-2.19-.74-3.12l-1.9 1.12zm-3.86-2.28c.19.58.3 1.2.3 1.85 0 3.31-2.69 6-6 6H8.5c-.28 0-.5.22-.5.5s.22.5.5.5H10c3.87 0 7-3.13 7-7 0-1.13-.27-2.19-.74-3.12l-1.9 1.12zM6.5 2C2.91 2 0 4.91 0 8.5S2.91 15 6.5 15H8c.28 0 .5-.22.5-.5s-.22-.5-.5-.5H6.5C3.46 14 1 11.54 1 8.5S3.46 3 6.5 3H8c.28 0 .5-.22.5-.5S8.28 2 8 2H6.5z"/>
                    </svg>
                    <span class="font-semibold">${escapeHtml(nom)} a levé la main</span>
                </div>
            `;
            document.body.appendChild(notification);

            // Faire disparaître après 8 secondes
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.style.transition = 'opacity 0.5s ease-out';
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        if (notification && notification.parentNode) {
                            notification.remove();
                        }
                    }, 500);
                }
            }, 8000);
        }

        // Socket.IO (Pusher) - Notifications en temps réel
        if (participantStatus === 'accepte' || participantStatus === 'present') {
            // Utiliser une approche simple avec polling si Pusher n'est pas configuré
            // Pour une vraie implémentation, configurer Pusher dans .env
            const usePusher = false; // Mettre à true quand Pusher est configuré
            
            if (usePusher && typeof Pusher !== 'undefined') {
                const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key', '') }}', {
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster', 'mt1') }}',
                    encrypted: true,
                    authEndpoint: '/broadcasting/auth',
                    auth: {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }
                });

                const channel = pusher.subscribe('private-video-session.' + sessionId);
                
                channel.bind('participant.joined', (data) => {
                    console.log('Participant rejoint:', data);
                });

                channel.bind('participant.joined', (data) => {
                    console.log('Participant rejoint:', data);
                    loadParticipants();
                });

                channel.bind('participant.left', (data) => {
                    console.log('Participant quitte:', data);
                    loadParticipants();
                });

                channel.bind('participant.status.changed', (data) => {
                    // Recharger la liste des participants quand le statut change
                    loadParticipants();
                    
                    // Afficher la notification si quelqu'un lève la main
                    if (data.changes && data.changes.main_levée !== undefined && data.changes.main_levée === true) {
                        const nom = data.nom || 'Un participant';
                        showHandRaisedNotification(nom);
                    }
                    
                    // Mettre à jour l'état du bouton si c'est l'utilisateur actuel
                    if (data.user_id === currentUserId && data.changes && data.changes.main_levée !== undefined) {
                        const raiseHandBtn = document.getElementById('raise-hand');
                        const handIcon = document.getElementById('hand-icon');
                        const handButtonText = document.getElementById('hand-button-text');
                        const handIndicator = document.getElementById('hand-indicator');
                        
                        isHandRaised = data.changes.main_levée;
                        
                        if (data.changes.main_levée) {
                            // Main levée : fond jaune, emoji ✋, texte "Baisser la main"
                            raiseHandBtn.classList.add('bg-yellow-600');
                            raiseHandBtn.classList.remove('bg-gray-700');
                            if (handIndicator) handIndicator.classList.remove('hidden');
                            
                            // L'emoji reste ✋
                            if (handIcon) {
                                handIcon.textContent = '✋';
                            }
                            
                            // Changer le texte
                            if (handButtonText) {
                                handButtonText.textContent = 'Baisser la main';
                            }
                        } else {
                            // Main baissée : fond gris, emoji ✋, texte "Lever la main"
                            raiseHandBtn.classList.remove('bg-yellow-600');
                            raiseHandBtn.classList.add('bg-gray-700');
                            if (handIndicator) handIndicator.classList.add('hidden');
                            
                            // L'emoji reste ✋
                            if (handIcon) {
                                handIcon.textContent = '✋';
                            }
                            
                            // Changer le texte
                            if (handButtonText) {
                                handButtonText.textContent = 'Lever la main';
                            }
                        }
                    }
                    
                    if (data.user_id === currentUserId) {
                        // Mettre à jour micro_actif si présent dans les changements
                        if (data.changes.micro_actif !== undefined) {
                            isMicroActive = data.micro_actif;
                            if (localStream) {
                                localStream.getAudioTracks().forEach(track => {
                                    track.enabled = isMicroActive;
                                });
                            }
                        }
                        
                        // Mettre à jour camera_active si présent dans les changements
                        if (data.changes.camera_active !== undefined) {
                            isCameraActive = data.camera_active;
                            if (localStream) {
                                localStream.getVideoTracks().forEach(track => {
                                    track.enabled = isCameraActive;
                                });
                            }
                        }
                        
                        // Si le formateur prend le contrôle du micro, couper automatiquement
                        if (data.changes.micro_controle_par_formateur !== undefined) {
                            console.log('🎯 [EVENT] micro_controle_par_formateur changé:', {
                                ancien: microControlled,
                                nouveau: data.changes.micro_controle_par_formateur,
                                data: data
                            });
                            microControlled = data.changes.micro_controle_par_formateur;
                            if (microControlled) {
                                console.log('🔴 [EVENT] Formateur prend le contrôle du micro');
                                // Le formateur a pris le contrôle, appliquer micro_actif = false
                                isMicroActive = false;
                                if (localStream) {
                                    localStream.getAudioTracks().forEach(track => {
                                        track.enabled = false;
                                    });
                                }
                                console.log('🔴 [EVENT] État après contrôle:', {
                                    isMicroActive,
                                    microControlled
                                });
                                // Mettre à jour l'interface pour afficher la barre rouge
                                console.log('🔴 [EVENT] Appel updateControls()...');
                                updateControls();
                            } else {
                                console.log('🟢 [EVENT] Formateur relâche le contrôle du micro');
                                // Le formateur a relâché le contrôle, mettre à jour l'interface
                                updateControls();
                            }
                        }
                        
                        // Si le formateur prend le contrôle de la caméra, désactiver automatiquement
                        if (data.changes.camera_controlee_par_formateur !== undefined) {
                            cameraControlled = data.camera_controlee_par_formateur;
                            if (cameraControlled) {
                                // Le formateur a pris le contrôle, appliquer camera_active = false
                                isCameraActive = false;
                                if (localStream) {
                                    localStream.getVideoTracks().forEach(track => {
                                        track.enabled = false;
                                    });
                                }
                                // Mettre à jour l'interface pour afficher la barre rouge
                                updateControls();
                            } else {
                                // Le formateur a relâché le contrôle, mettre à jour l'interface
                        updateControls();
                    }
                        }
                        
                        // Appliquer les valeurs directement depuis les données si disponibles
                        if (data.micro_actif !== undefined) {
                            isMicroActive = data.micro_actif;
                            if (localStream) {
                                localStream.getAudioTracks().forEach(track => {
                                    track.enabled = isMicroActive;
                                });
                            }
                            // Mettre à jour l'interface immédiatement
                            updateControls();
                        }
                        
                        if (data.camera_active !== undefined) {
                            isCameraActive = data.camera_active;
                            if (localStream) {
                                localStream.getVideoTracks().forEach(track => {
                                    track.enabled = isCameraActive;
                                });
                            }
                            // Mettre à jour l'interface immédiatement
                            updateControls();
                        }
                        
                        // Mettre à jour les contrôles à la fin pour s'assurer que tout est synchronisé
                        updateControls();
                    }
                });

                channel.bind('chat.message', (data) => {
                    addChatMessage(data, data.user_id === currentUserId);
                });
            } else {
                // Fallback: polling pour les mises à jour
                setInterval(async () => {
                    try {
                        const response = await fetch(statusCheckUrl);
                        const data = await response.json();
                        
                        if (data.statut !== participantStatus) {
                            location.reload();
                        }
                        
                        // Vérifier les changements de micro et caméra
                        if (data.micro_actif !== undefined && data.micro_actif !== isMicroActive) {
                            isMicroActive = data.micro_actif;
                            if (localStream) {
                                localStream.getAudioTracks().forEach(track => {
                                    track.enabled = isMicroActive;
                                });
                            }
                            updateControls();
                        }
                        
                        if (data.camera_active !== undefined && data.camera_active !== isCameraActive) {
                            isCameraActive = data.camera_active;
                            if (localStream) {
                                localStream.getVideoTracks().forEach(track => {
                                    track.enabled = isCameraActive;
                                });
                            }
                            updateControls();
                        }
                        
                        // Vérifier si le formateur a pris le contrôle
                        if (data.micro_controle_par_formateur !== undefined && data.micro_controle_par_formateur !== microControlled) {
                            console.log('🎯 [POLLING] micro_controle_par_formateur changé:', {
                                ancien: microControlled,
                                nouveau: data.micro_controle_par_formateur
                            });
                            microControlled = data.micro_controle_par_formateur;
                            if (microControlled) {
                                // Le formateur a pris le contrôle, couper le micro
                                isMicroActive = false;
                                if (localStream) {
                                    localStream.getAudioTracks().forEach(track => {
                                        track.enabled = false;
                                    });
                                }
                            }
                            // TOUJOURS appeler updateControls() quand microControlled change
                            console.log('🎯 [POLLING] Appel updateControls() après changement microControlled');
                            updateControls();
                        }
                        
                        if (data.camera_controlee_par_formateur !== undefined && data.camera_controlee_par_formateur !== cameraControlled) {
                            console.log('🎯 [POLLING] camera_controlee_par_formateur changé:', {
                                ancien: cameraControlled,
                                nouveau: data.camera_controlee_par_formateur
                            });
                            cameraControlled = data.camera_controlee_par_formateur;
                            if (cameraControlled) {
                                // Le formateur a pris le contrôle, couper la caméra
                                isCameraActive = false;
                                if (localStream) {
                                    localStream.getVideoTracks().forEach(track => {
                                        track.enabled = false;
                                    });
                                }
                            }
                            // TOUJOURS appeler updateControls() quand cameraControlled change
                            console.log('🎯 [POLLING] Appel updateControls() après changement cameraControlled');
                            updateControls();
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                    }
                }, 3000); // Vérifier plus fréquemment (3 secondes au lieu de 5)
            }
        }

        // Initialiser les contrôles
        console.log('🎯 [INIT CHECK] Vérification statut:', {
            participantStatus,
            isAccepte: participantStatus === 'accepte',
            isPresent: participantStatus === 'present',
            shouldInit: participantStatus === 'accepte' || participantStatus === 'present'
        });
        
        // TOUJOURS appeler updateControls() au chargement pour initialiser l'état visuel
        console.log('🚀 [INIT] Appel updateControls() au chargement initial');
        updateControls();
        
        if (participantStatus === 'accepte' || participantStatus === 'present') {
            console.log('🚀 [INIT] Initialisation des contrôles');
            console.log('🚀 [INIT] État initial:', {
                isMicroActive,
                microControlled,
                isCameraActive,
                cameraControlled
            });
            
            // S'assurer que les contrôles sont mis à jour avec l'état initial
            // (notamment si le micro est contrôlé par le formateur)
            setTimeout(() => {
                console.log('🚀 [INIT] Appel updateControls() après 100ms');
            updateControls();
            }, 100);
            
            console.log('🚀 [INIT] Appel updateControls() immédiat');
            updateControls(); // Appel immédiat aussi
            loadChatMessages();
            
            // Attendre que le DOM soit prêt avant de charger les participants
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(() => {
                        loadParticipants();
                    }, 500);
                });
            } else {
                setTimeout(() => {
                    loadParticipants();
                }, 500);
            }
            
            // Rafraîchir la liste des participants toutes les 3 secondes
            setInterval(() => {
                loadParticipants();
            }, 3000);
            
            // Initialiser les connexions WebRTC après 2 secondes
            setTimeout(() => {
                if (localStream) {
                    initializePeerConnections();
                }
            }, 2000);
        } else {
            console.log('⏸️ [INIT] Statut non accepté/présent, initialisation annulée:', participantStatus);
        }

        // ========== WebRTC - Fonctions de connexion peer-to-peer ==========
        
        // Créer ou mettre à jour la vidéo d'un participant
        function createOrUpdateParticipantVideo(participant) {
            const container = document.getElementById('video-container');
            let videoContainer = document.getElementById(`video-participant-${participant.user_id}`);
            
            if (!videoContainer) {
                videoContainer = document.createElement('div');
                videoContainer.id = `video-participant-${participant.user_id}`;
                videoContainer.className = 'video-participant';
                videoContainer.setAttribute('data-user-id', participant.user_id);
                
                const video = document.createElement('video');
                video.id = `remote-video-${participant.user_id}`;
                video.autoplay = true;
                video.playsinline = true;
                video.className = 'w-full h-full object-cover';
                
                const info = document.createElement('div');
                info.className = 'participant-info';
                info.innerHTML = `
                    <span>${participant.nom}</span>
                    ${!participant.micro_actif ? '<span class="ml-2">🔇</span>' : ''}
                    ${!participant.camera_active ? '<span class="ml-2">📷</span>' : ''}
                `;
                
                videoContainer.appendChild(video);
                videoContainer.appendChild(info);
                container.appendChild(videoContainer);
            }
        }

        // Initialiser les connexions peer-to-peer
        async function initializePeerConnections() {
            if (!localStream) {
                console.log('Local stream pas encore prêt');
                return;
            }

            // Obtenir la liste des participants actifs
            try {
                const response = await fetch(statusCheckUrl);
                const data = await response.json();
                
                // Pour l'apprenant, on se connecte au formateur et aux autres apprenants
                // On récupère la liste via l'API
                const formateurId = {{ $session->formateur_id }};
                if (formateurId !== currentUserId && !peerConnections.has(formateurId)) {
                    await createPeerConnection(formateurId);
                }
            } catch (error) {
                console.error('Erreur lors de l\'initialisation des connexions:', error);
            }
        }

        // Créer une connexion peer-to-peer
        async function createPeerConnection(userId) {
            try {
                console.log('Création connexion peer avec', userId);
                
                // Définir rtcConfiguration directement dans la fonction pour éviter les problèmes de cache
                const rtcConfig = {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' }
                    ]
                };
                
                console.log('✅ [RTC] Configuration WebRTC créée:', rtcConfig);
                const pc = new RTCPeerConnection(rtcConfig);
                
                // Ajouter les tracks locaux
                if (localStream) {
                    localStream.getTracks().forEach(track => {
                        pc.addTrack(track, localStream);
                    });
                }

                // Gérer les ICE candidates
                pc.onicecandidate = (event) => {
                    if (event.candidate) {
                        sendIceCandidate(userId, event.candidate);
                    }
                };

                // Gérer le stream distant
                pc.ontrack = (event) => {
                    console.log('Stream reçu de', userId);
                    const remoteStream = event.streams[0];
                    remoteStreams.set(userId, remoteStream);
                    
                    const remoteVideo = document.getElementById(`remote-video-${userId}`);
                    if (remoteVideo) {
                        remoteVideo.srcObject = remoteStream;
                        remoteVideo.play().catch(err => console.error('Erreur lecture vidéo distante:', err));
                    } else {
                        // Créer l'élément vidéo s'il n'existe pas
                        createOrUpdateParticipantVideo({ user_id: userId, nom: 'Participant', micro_actif: true, camera_active: true });
                        const newVideo = document.getElementById(`remote-video-${userId}`);
                        if (newVideo) {
                            newVideo.srcObject = remoteStream;
                            newVideo.play().catch(err => console.error('Erreur lecture vidéo distante:', err));
                        }
                    }
                };

                pc.onconnectionstatechange = () => {
                    console.log(`État connexion ${userId}:`, pc.connectionState);
                };

                peerConnections.set(userId, pc);

                // Créer et envoyer une offre
                const offer = await pc.createOffer();
                await pc.setLocalDescription(offer);
                await sendOffer(userId, offer);

            } catch (error) {
                console.error('Erreur création connexion peer:', error);
            }
        }

        // Envoyer une offre WebRTC
        async function sendOffer(userId, offer) {
            try {
                const response = await fetch(`/apprenant/video-conference/${sessionId}/webrtc/offer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        target_user_id: userId,
                        offer: offer
                    })
                });
                const data = await response.json();
                console.log('Réponse offre:', data);
            } catch (error) {
                console.error('Erreur envoi offre:', error);
            }
        }

        // Envoyer une réponse WebRTC
        async function sendAnswer(userId, answer) {
            try {
                await fetch(`/apprenant/video-conference/${sessionId}/webrtc/answer`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        target_user_id: userId,
                        answer: answer
                    })
                });
            } catch (error) {
                console.error('Erreur envoi réponse:', error);
            }
        }

        // Envoyer un candidat ICE
        async function sendIceCandidate(userId, candidate) {
            try {
                await fetch(`/apprenant/video-conference/${sessionId}/webrtc/ice-candidate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        target_user_id: userId,
                        candidate: candidate
                    })
                });
            } catch (error) {
                console.error('Erreur envoi candidat ICE:', error);
            }
        }

        // Gérer une offre WebRTC reçue
        async function handleWebRTCOffer(fromUserId, offer) {
            try {
                // Définir rtcConfiguration directement dans la fonction
                const rtcConfig = {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' }
                    ]
                };
                const pc = peerConnections.get(fromUserId) || new RTCPeerConnection(rtcConfig);
                
                if (!peerConnections.has(fromUserId)) {
                    // Ajouter les tracks locaux
                    if (localStream) {
                        localStream.getTracks().forEach(track => {
                            pc.addTrack(track, localStream);
                        });
                    }

                    // Gérer les ICE candidates
                    pc.onicecandidate = (event) => {
                        if (event.candidate) {
                            sendIceCandidate(fromUserId, event.candidate);
                        }
                    };

                    // Gérer le stream distant
                    pc.ontrack = (event) => {
                        console.log('Stream reçu de', fromUserId);
                        const remoteStream = event.streams[0];
                        remoteStreams.set(fromUserId, remoteStream);
                        
                        const remoteVideo = document.getElementById(`remote-video-${fromUserId}`);
                        if (remoteVideo) {
                            remoteVideo.srcObject = remoteStream;
                            remoteVideo.play().catch(err => console.error('Erreur lecture vidéo distante:', err));
                        }
                    };

                    peerConnections.set(fromUserId, pc);
                }

                await pc.setRemoteDescription(new RTCSessionDescription(offer));
                const answer = await pc.createAnswer();
                await pc.setLocalDescription(answer);
                
                // Envoyer la réponse
                await sendAnswer(fromUserId, answer);
            } catch (error) {
                console.error('Erreur lors du traitement de l\'offre:', error);
            }
        }

        // Gérer une réponse WebRTC reçue
        async function handleWebRTCAnswer(fromUserId, answer) {
            try {
                const pc = peerConnections.get(fromUserId);
                if (pc) {
                    await pc.setRemoteDescription(new RTCSessionDescription(answer));
                }
            } catch (error) {
                console.error('Erreur lors du traitement de la réponse:', error);
            }
        }

        // Gérer un candidat ICE reçu
        async function handleWebRTCIceCandidate(fromUserId, candidate) {
            try {
                const pc = peerConnections.get(fromUserId);
                if (pc && candidate) {
                    await pc.addIceCandidate(new RTCIceCandidate(candidate));
                }
            } catch (error) {
                console.error('Erreur lors du traitement du candidat ICE:', error);
            }
        }

        // Écouter les événements WebRTC via polling (si Pusher n'est pas configuré)
        if (participantStatus === 'accepte' || participantStatus === 'present') {
            // Pour l'instant, on utilise le polling pour simuler la réception des événements
            // Dans un vrai système avec Pusher, on utiliserait les événements en temps réel
            setInterval(async () => {
                // Vérifier les nouveaux participants et créer des connexions
                if (localStream) {
                    initializePeerConnections();
                }
            }, 5000);
        }
    </script>
</body>
</html>
