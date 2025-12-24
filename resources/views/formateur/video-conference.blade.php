

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Visioconférence - {{ $cours->titre ?? 'Cours' }} - BJ Academie</title>
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
        }
        .sidebar-bg {
            background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
        .video-participant.host {
            border-color: #f59e0b;
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
        .badge-host {
            background: #f59e0b;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }
        .notification-badge {
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Left Sidebar -->
        <aside class="w-20 sidebar-bg text-white flex flex-col py-6">
            <div class="mb-8 flex items-center justify-center px-4">
                <a href="{{ route('formateur.cours') }}" class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg hover:bg-gray-100 transition-colors">
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
                        <p class="text-sm text-gray-400 mt-1">Gestion de la session vidéo</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Statistiques -->
                        <div class="flex items-center gap-2 text-sm text-gray-300" id="session-stats">
                            <span id="stats-duration">00:00</span>
                            <span>•</span>
                            <span id="stats-participants">0 participants</span>
                        </div>
                        
                        <!-- Mode de vue -->
                        <div class="flex items-center gap-2 bg-gray-700 rounded-lg p-1">
                            <button id="view-mode-grille" class="view-mode-btn px-3 py-1 text-sm rounded hover:bg-gray-600 text-white" data-mode="grille" title="Vue grille">
                                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button id="view-mode-galerie" class="view-mode-btn px-3 py-1 text-sm rounded hover:bg-gray-600 text-gray-400" data-mode="galerie" title="Vue galerie">
                                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                    <path d="M2 7h16v10a2 2 0 01-2 2H4a2 2 0 01-2-2V7z"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Couper tous les micros -->
                        <button id="mute-all-btn" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors" title="Couper tous les micros">
                            🔇 Couper tous
                        </button>
                        
                        <button id="end-session" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Terminer la session
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex overflow-hidden">
                <!-- Video Container -->
                <div class="flex-1 flex flex-col">
                    <div class="flex-1 bg-gray-900 overflow-hidden">
                        <div id="video-container" class="h-full">
                            <!-- Ma vidéo (formateur) -->
                            <div class="video-participant host" id="local-video-container" data-user-id="{{ Auth::id() }}">
                                <video id="local-video" autoplay muted playsinline></video>
                                <div class="participant-info">
                                    <span>{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</span>
                                    <span class="badge-host">Hôte</span>
                                </div>
                            </div>
                            <!-- Les vidéos des participants seront ajoutées ici dynamiquement -->
                        </div>
                    </div>
                    
                    <!-- Contrôles -->
                    <div class="bg-gray-800 border-t border-gray-700 px-6 py-4">
                        <div class="flex items-center justify-center gap-4">
                            <!-- Micro -->
                            <button id="toggle-micro" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors relative">
                                <svg id="micro-icon" class="w-6 h-6 relative" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path>
                                </svg>
                                <svg id="micro-slash-icon" class="w-6 h-6 absolute hidden" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Caméra -->
                            <button id="toggle-camera" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors relative">
                                <svg id="camera-icon" class="w-6 h-6 relative" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106a1 1 0 00-1.106.553l-2 4A1 1 0 0013 13h2a1 1 0 00.894-.553l2-4a1 1 0 00-.553-1.341z"></path>
                                </svg>
                                <svg id="camera-slash-icon" class="w-6 h-6 absolute hidden" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Bascule caméra (selfie) -->
                            <button id="switch-camera" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors" title="Basculer caméra avant/arrière">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <!-- Partage d'écran -->
                            <button id="share-screen" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="w-96 bg-gray-800 border-l border-gray-700 flex flex-col">
                    <!-- Onglets -->
                    <div class="flex border-b border-gray-700">
                        <button class="tab-btn flex-1 px-4 py-3 text-white bg-gray-700" data-tab="participants">
                            Participants
                        </button>
                        <button class="tab-btn flex-1 px-4 py-3 text-gray-400 hover:text-white relative" data-tab="pending">
                            En attente
                            <span id="pending-count" class="notification-badge hidden">0</span>
                        </button>
                        <button class="tab-btn flex-1 px-4 py-3 text-gray-400 hover:text-white" data-tab="chat">
                            Chat
                        </button>
                    </div>

                    <!-- Contenu des onglets -->
                    <div class="flex-1 overflow-y-auto flex flex-col">
                        <!-- Onglet Participants -->
                        <div id="tab-participants" class="tab-content p-4 flex-1 overflow-y-auto">
                            <h3 class="text-lg font-semibold text-white mb-4">Participants actifs</h3>
                            <div id="active-participants-list" class="space-y-3">
                                <!-- Liste des participants actifs -->
                            </div>
                        </div>

                        <!-- Onglet En attente -->
                        <div id="tab-pending" class="tab-content p-4 flex-1 overflow-y-auto hidden">
                            <h3 class="text-lg font-semibold text-white mb-4">Demandes d'accès</h3>
                            <div id="pending-participants-list" class="space-y-3">
                                <!-- Liste des participants en attente -->
                            </div>
                        </div>

                        <!-- Onglet Chat -->
                        <div id="tab-chat" class="tab-content flex flex-col flex-1 overflow-hidden hidden">
                            <div class="p-4 border-b border-gray-700">
                                <h3 class="text-lg font-semibold text-white">Chat</h3>
                            </div>
                            <div class="flex-1 overflow-y-auto p-4" id="chat-messages">
                                <!-- Messages de chat -->
                            </div>
                            <div class="p-4 border-t border-gray-700">
                                <div class="flex gap-2">
                                    <input type="text" id="chat-input" placeholder="Tapez un message..." class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button id="send-chat-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Envoyer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sessionId = {{ $session->id }};
        const currentUserId = {{ Auth::id() }};
        let localStream = null;
        let screenStream = null;
        let isSharingScreen = false;
        let pendingParticipants = [];
        let activeParticipants = [];
        
        // Gestion de la caméra
        let currentFacingMode = 'user'; // 'user' = avant, 'environment' = arrière
        let availableCameras = [];
        let currentCameraIndex = 0;
        
        // WebRTC - Connexions peer-to-peer
        let peerConnections = new Map(); // Map<userId, RTCPeerConnection>
        let remoteStreams = new Map(); // Map<userId, MediaStream>
        
        // Configuration WebRTC
        const rtcConfiguration = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                { urls: 'stun:stun2.l.google.com:19302' }
            ]
        };

        // Modal de demande d'autorisation
        function showPermissionModal() {
            console.log('🔐 [MODAL] Création de la modale de permission');
            return new Promise((resolve, reject) => {
                const modal = document.createElement('div');
                modal.id = 'permission-modal';
                modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                        <h3 class="text-xl font-semibold text-white mb-4">Autorisation requise</h3>
                        <p class="text-gray-300 mb-6">
                            Pour démarrer la visioconférence, nous avons besoin d'accéder à votre caméra et microphone.
                            Veuillez autoriser l'accès lorsque votre navigateur vous le demandera.
                        </p>
                        <div class="flex gap-3">
                            <button id="request-permission-btn" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Autoriser l'accès
                            </button>
                            <button id="cancel-permission-btn" class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                Annuler
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                console.log('🔐 [MODAL] Modale ajoutée au DOM');

                // Attacher les événements après l'insertion dans le DOM
                setTimeout(() => {
                    const requestBtn = document.getElementById('request-permission-btn');
                    const cancelBtn = document.getElementById('cancel-permission-btn');
                    
                    console.log('🔐 [MODAL] Recherche des boutons:', {
                        requestBtn: !!requestBtn,
                        cancelBtn: !!cancelBtn
                    });
                    
                    if (requestBtn) {
                        console.log('🔐 [MODAL] Ajout de l\'événement click sur le bouton "Autoriser"');
                        requestBtn.addEventListener('click', async () => {
                            console.log('🔐 [MODAL] Clic sur "Autoriser l\'accès"');
                            modal.remove();
                            try {
                                console.log('🔐 [MODAL] Appel de requestMediaAccess()');
                                await requestMediaAccess();
                                console.log('🔐 [MODAL] requestMediaAccess() réussi');
                                resolve();
                            } catch (error) {
                                console.error('❌ [MODAL] Erreur dans requestMediaAccess():', error);
                                reject(error);
                            }
                        });
                    } else {
                        console.error('❌ [MODAL] Bouton "request-permission-btn" introuvable!');
                    }

                    if (cancelBtn) {
                        console.log('🔐 [MODAL] Ajout de l\'événement click sur le bouton "Annuler"');
                        cancelBtn.addEventListener('click', () => {
                            console.log('🔐 [MODAL] Clic sur "Annuler"');
                            modal.remove();
                            reject(new Error('Permissions annulées par l\'utilisateur'));
                        });
                    } else {
                        console.error('❌ [MODAL] Bouton "cancel-permission-btn" introuvable!');
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
            const isSafari = /^((?!chrome|android).)*safari/i.test(ua) || /Version\/[\d.]+.*Safari/.test(ua);
            
            return {
                isMobile,
                isIOS,
                isAndroid,
                isMac,
                isWindows,
                isLinux,
                isDesktop: !isMobile,
                isSafari
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
                if (device.isSafari) {
                    // Safari a besoin d'une approche spéciale - demander séparément
                    // Commencer par audio seul, puis ajouter vidéo
                    configs.push(
                        // Audio seul d'abord (Safari accepte mieux)
                        { video: false, audio: true },
                        // Puis essayer vidéo seul
                        { video: true, audio: false },
                        // Enfin les deux ensemble
                        { video: true, audio: true }
                    );
                } else {
                    // Autres navigateurs (Chrome, Firefox, Edge)
                    configs.push(
                        // Configuration optimale pour desktop
                        {
                            video: {
                                width: { ideal: 1280 },
                                height: { ideal: 720 },
                                frameRate: { ideal: 30 }
                            },
                            audio: {
                                echoCancellation: true,
                                noiseSuppression: true,
                                autoGainControl: true
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
                        { video: true, audio: true },
                        // Vidéo seulement
                        { video: true, audio: false },
                        // Audio seulement
                        { video: false, audio: true }
                    );
                }
            }

            return configs;
        }

        // Demander l'accès aux médias avec fallback progressif adapté à l'appareil
        async function requestMediaAccess() {
            try {
                console.log('📹 [MEDIA] Début de requestMediaAccess()');
                
                // Vérifier si l'API est disponible
                console.log('📹 [MEDIA] Vérification de l\'API mediaDevices:', {
                    mediaDevices: !!navigator.mediaDevices,
                    getUserMedia: !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia),
                    userAgent: navigator.userAgent
                });
                
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    const error = new Error('Votre navigateur ne supporte pas l\'accès aux médias. Veuillez utiliser un navigateur moderne (Chrome, Firefox, Edge, Safari).');
                    console.error('❌ [MEDIA] API non disponible:', error);
                    throw error;
                }

                // Détecter l'appareil
                const device = detectDevice();
                console.log('📹 [MEDIA] Appareil détecté:', device);

                // Obtenir les configurations adaptées
                const configurations = getDeviceConfigurations(device);
                console.log('📹 [MEDIA] Configurations à essayer:', configurations.length);

                let lastError = null;
                
                // Pour Safari, utiliser une approche spéciale
                // Safari a des problèmes connus avec getUserMedia, surtout sur macOS
                // Il faut parfois demander les permissions séparément et dans un ordre spécifique
                if (device.isSafari) {
                    try {
                        console.log('📹 [MEDIA] Approche Safari: demande séparée audio puis vidéo');
                        
                        // Safari nécessite parfois de demander l'audio d'abord pour "débloquer" les permissions
                        let audioStream = null;
                        let videoStream = null;
                        
                        // Étape 1: Demander l'audio d'abord
                        try {
                            audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            console.log('✅ [MEDIA] Audio obtenu pour Safari (étape 1)');
                        } catch (audioError) {
                            console.warn('⚠️ [MEDIA] Échec audio Safari:', audioError);
                            // Si l'audio échoue, on continue quand même pour essayer la vidéo
                        }
                        
                        // Étape 2: Demander la vidéo après l'audio (Safari peut nécessiter cet ordre)
                        // Essayer plusieurs configurations vidéo
                        const videoConfigs = [
                            { video: true },           // Configuration la plus simple
                            { video: {} },            // Objet vide
                            { video: { facingMode: 'user' } }  // Avec facingMode
                        ];
                        
                        for (let i = 0; i < videoConfigs.length; i++) {
                            try {
                                videoStream = await navigator.mediaDevices.getUserMedia(videoConfigs[i]);
                                console.log(`✅ [MEDIA] Vidéo obtenue pour Safari avec config ${i + 1}:`, videoConfigs[i]);
                                break; // Succès, sortir de la boucle
                            } catch (videoError) {
                                console.warn(`⚠️ [MEDIA] Échec config vidéo ${i + 1}:`, videoError);
                                if (i === videoConfigs.length - 1) {
                                    // Dernière tentative échouée
                                    console.warn('⚠️ [MEDIA] Toutes les configurations vidéo ont échoué');
                                }
                            }
                        }
                        
                        // Étape 3: Combiner ou utiliser les streams disponibles
                        if (audioStream && videoStream) {
                            // Créer un nouveau stream combiné
                            const combinedStream = new MediaStream();
                            audioStream.getAudioTracks().forEach(track => combinedStream.addTrack(track));
                            videoStream.getVideoTracks().forEach(track => combinedStream.addTrack(track));
                            localStream = combinedStream;
                            console.log('✅ [MEDIA] Streams combinés pour Safari');
                        } else if (videoStream) {
                            localStream = videoStream;
                            console.log('✅ [MEDIA] Utilisation vidéo seul pour Safari');
                        } else if (audioStream) {
                            localStream = audioStream;
                            console.log('✅ [MEDIA] Utilisation audio seul pour Safari (vidéo non disponible)');
                        } else {
                            throw new Error('Impossible d\'obtenir l\'audio ou la vidéo sur Safari. Veuillez vérifier les permissions système.');
                        }
                    } catch (error) {
                        console.error('❌ [MEDIA] Erreur approche Safari:', error);
                        lastError = error;
                    }
                } else {
                    // Pour les autres navigateurs, utiliser l'approche normale
                    for (let i = 0; i < configurations.length; i++) {
                        const config = configurations[i];
                        console.log(`📹 [MEDIA] Essai configuration ${i + 1}/${configurations.length}:`, config);
                        try {
                            console.log('📹 [MEDIA] Appel de getUserMedia avec la configuration:', config);
                            localStream = await navigator.mediaDevices.getUserMedia(config);
                            console.log('✅ [MEDIA] getUserMedia réussi! Stream obtenu:', {
                                id: localStream.id,
                                active: localStream.active,
                                videoTracks: localStream.getVideoTracks().length,
                                audioTracks: localStream.getAudioTracks().length,
                                videoTracksInfo: localStream.getVideoTracks().map(t => ({
                                    enabled: t.enabled,
                                    readyState: t.readyState,
                                    settings: t.getSettings()
                                })),
                                audioTracksInfo: localStream.getAudioTracks().map(t => ({
                                    enabled: t.enabled,
                                    readyState: t.readyState,
                                    settings: t.getSettings()
                                }))
                            });
                            // Si on arrive ici, la configuration a fonctionné
                            break;
                        } catch (error) {
                            console.warn(`⚠️ [MEDIA] Configuration ${i + 1} échouée:`, {
                                name: error.name,
                                message: error.message,
                                constraint: error.constraint
                            });
                            lastError = error;
                            // Continuer avec la configuration suivante
                            continue;
                        }
                    }
                }

                // Si aucune configuration n'a fonctionné, lancer l'erreur
                if (!localStream) {
                    console.error('❌ [MEDIA] Aucune configuration n\'a fonctionné. Dernière erreur:', lastError);
                    throw lastError || new Error('Impossible d\'accéder aux médias.');
                }

                console.log('📹 [MEDIA] Recherche de l\'élément video local...');
                // Afficher la vidéo locale
                const localVideo = document.getElementById('local-video');
                console.log('📹 [MEDIA] Élément video trouvé:', {
                    found: !!localVideo,
                    id: localVideo?.id,
                    tagName: localVideo?.tagName
                });
                
                if (localVideo) {
                    console.log('📹 [MEDIA] Attribution du stream à l\'élément video');
                    localVideo.srcObject = localStream;
                    
                    // Gérer l'orientation sur mobile
                    if (device.isMobile) {
                        console.log('📹 [MEDIA] Configuration mobile - ajout des attributs playsinline');
                        localVideo.setAttribute('playsinline', 'true');
                        localVideo.setAttribute('webkit-playsinline', 'true');
                    }
                    
                    console.log('📹 [MEDIA] Tentative de lecture de la vidéo...');
                    localVideo.play().then(() => {
                        console.log('✅ [MEDIA] Vidéo en lecture!');
                        console.log('📹 [MEDIA] État de la vidéo:', {
                            paused: localVideo.paused,
                            readyState: localVideo.readyState,
                            videoWidth: localVideo.videoWidth,
                            videoHeight: localVideo.videoHeight
                        });
                    }).catch(err => {
                        console.error('❌ [MEDIA] Erreur lors de la lecture de la vidéo:', err);
                        console.error('❌ [MEDIA] Détails de l\'erreur de lecture:', {
                            name: err.name,
                            message: err.message,
                            code: err.code
                        });
                    });
                } else {
                    console.error('❌ [MEDIA] Élément video #local-video introuvable dans le DOM!');
                }
                
                // Une fois la vidéo locale prête, créer les connexions avec les participants actifs
                setTimeout(() => {
                    console.log('📹 [MEDIA] Initialisation des connexions peer après 1 seconde');
                    initializePeerConnections();
                }, 1000);

                // Masquer le message d'erreur s'il existe
                const errorMsg = document.getElementById('media-error-message');
                if (errorMsg) {
                    console.log('📹 [MEDIA] Suppression du message d\'erreur existant');
                    errorMsg.remove();
                }

                console.log('✅ [MEDIA] requestMediaAccess() terminé avec succès');
                return true;
            } catch (error) {
                console.error('❌ [MEDIA] Erreur lors de l\'accès aux médias:', error);
                
                let errorMessage = 'Impossible d\'accéder à votre caméra ou microphone.';
                
                if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                    errorMessage = 'L\'accès à la caméra et au microphone a été refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur et réessayer.';
                } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                    errorMessage = 'Aucune caméra ou microphone n\'a été détecté. Veuillez vérifier que vos périphériques sont connectés.';
                } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                    errorMessage = 'La caméra ou le microphone est déjà utilisé par une autre application. Veuillez fermer les autres applications et réessayer.';
                } else if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
                    errorMessage = 'Les paramètres de la caméra ou du microphone ne sont pas supportés. Veuillez utiliser un autre périphérique.';
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

        // Initialiser la vidéo du formateur
        async function initVideo() {
            console.log('🎥 [INIT] Début de l\'initialisation de la vidéo');
            try {
                console.log('🎥 [INIT] Affichage de la modale de permission');
                await showPermissionModal();
                console.log('🎥 [INIT] Modale de permission fermée avec succès');
            } catch (error) {
                console.error('❌ [INIT] Erreur lors de l\'initialisation de la vidéo:', error);
                console.error('❌ [INIT] Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                // L'erreur est déjà gérée par showMediaError
            }
        }

        // Gestion des onglets
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                
                // Mettre à jour les boutons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('bg-gray-700', 'text-white');
                    b.classList.add('text-gray-400');
                });
                btn.classList.add('bg-gray-700', 'text-white');
                btn.classList.remove('text-gray-400');

                // Afficher le contenu correspondant
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(`tab-${tab}`).classList.remove('hidden');

                // Charger les données si nécessaire
                if (tab === 'pending') {
                    loadPendingParticipants();
                } else if (tab === 'participants') {
                    loadActiveParticipants();
                } else if (tab === 'chat') {
                    loadChatMessages();
                }
            });
        });

        // Charger les participants en attente
            async function loadPendingParticipants() {
            try {
                const url = `/formateur/video-conference/${sessionId}/pending-participants`;
                console.log('📋 [PENDING] Chargement participants en attente, URL:', url);
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                
                if (data.success) {
                    pendingParticipants = data.participants;
                    updatePendingList();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des participants en attente:', error);
                console.error('Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                // Ne pas bloquer l'application, juste logger l'erreur
            }
        }

            // Mettre à jour la liste des participants en attente
            function updatePendingList() {
            const container = document.getElementById('pending-participants-list');
            const countBadge = document.getElementById('pending-count');
            
            if (countBadge) {
                countBadge.textContent = pendingParticipants.length;
                countBadge.classList.toggle('hidden', pendingParticipants.length === 0);
            }

            if (!container) return;

            container.innerHTML = '';

            if (pendingParticipants.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-center py-4">Aucune demande en attente</p>';
                return;
            }

            pendingParticipants.forEach(participant => {
                const div = document.createElement('div');
                div.className = 'bg-gray-700 rounded-lg p-4';
                div.innerHTML = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white">
                            ${participant.nom.charAt(0)}
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">${participant.nom}</p>
                            <p class="text-gray-400 text-sm">${participant.email}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="acceptParticipant(${participant.id})" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Accepter
                        </button>
                        <button onclick="rejectParticipantWithReason(${participant.id})" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Refuser
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

            // Charger les participants actifs
            async function loadActiveParticipants() {
            try {
                const url = `/formateur/video-conference/${sessionId}/active-participants`;
                console.log('👥 [ACTIVE] Chargement participants actifs, URL:', url);
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                
                if (data.success) {
                    const oldParticipants = new Set(activeParticipants.map(p => p.user_id));
                    activeParticipants = data.participants;
                    const newParticipants = new Set(activeParticipants.map(p => p.user_id));
                    
                    // Nettoyer les participants qui ont quitté
                    oldParticipants.forEach(userId => {
                        if (!newParticipants.has(userId) && userId !== currentUserId) {
                            cleanupParticipantConnection(userId);
                        }
                    });
                    
                    updateActiveList();
                    
                    // Créer des connexions avec les nouveaux participants
                    if (localStream) {
                        activeParticipants.forEach(participant => {
                            if (participant.user_id !== currentUserId && !peerConnections.has(participant.user_id)) {
                                createPeerConnection(participant.user_id);
                            }
                        });
                    }
                }
            } catch (error) {
                console.error('Erreur lors du chargement des participants actifs:', error);
                console.error('Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                // Ne pas bloquer l'application, juste logger l'erreur
            }
        }

            // Mettre à jour la liste des participants actifs
            function updateActiveList() {
            const container = document.getElementById('active-participants-list');
            const countElement = document.getElementById('participants-count');
            
            if (countElement) {
                countElement.textContent = `${activeParticipants.length + 1} participant(s)`;
            }

            if (!container) return;

            container.innerHTML = '';

            if (activeParticipants.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-center py-4">Aucun participant actif</p>';
                return;
            }

            activeParticipants.forEach(participant => {
                // Créer ou mettre à jour la vidéo du participant
                createOrUpdateParticipantVideo(participant);
                
                const div = document.createElement('div');
                div.className = 'bg-gray-700 rounded-lg p-4';
                div.innerHTML = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white">
                            ${participant.nom.charAt(0)}
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium flex items-center gap-2">
                                ${participant.nom}
                                ${participant.main_levée ? '<span class="text-yellow-500 text-lg" title="Main levée">✋</span>' : ''}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs flex items-center relative ${participant.micro_actif ? 'text-green-400' : 'text-red-400'}">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path>
                                    </svg>
                                    ${!participant.micro_actif ? '<svg class="w-4 h-4 absolute left-0 top-0" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>' : ''}
                                </span>
                                <span class="text-xs ${participant.camera_active ? 'text-green-400' : 'text-red-400'}">
                                    ${participant.camera_active ? '📹' : '📷'}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <button onclick="muteParticipant(${participant.id})" class="px-3 py-1.5 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition-colors">
                            Couper micro
                        </button>
                        <button onclick="disableCamera(${participant.id})" class="px-3 py-1.5 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition-colors">
                            Désactiver caméra
                        </button>
                        <button onclick="expelParticipant(${participant.id})" class="px-3 py-1.5 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition-colors">
                            Expulser
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

            // Accepter un participant
            window.acceptParticipant = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/accept`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadPendingParticipants();
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de l\'acceptation:', error);
            }
        }

            // Refuser un participant
            async function rejectParticipant(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadPendingParticipants();
                }
            } catch (error) {
                console.error('Erreur lors du refus:', error);
            }
        }

            // Couper le micro d'un participant
            window.muteParticipant = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/mute`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de la coupure du micro:', error);
            }
        }

            // Désactiver la caméra d'un participant
            window.disableCamera = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/disable-camera`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de la désactivation de la caméra:', error);
            }
        }

            // Expulser un participant
            window.expelParticipant = async function(participantId) {
            if (!confirm('Êtes-vous sûr de vouloir expulser ce participant ?')) {
                return;
            }

            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/expel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    // Nettoyer la connexion WebRTC
                    const participant = activeParticipants.find(p => p.id === participantId);
                    if (participant) {
                        cleanupParticipantConnection(participant.user_id);
                    }
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de l\'expulsion:', error);
            }
        }

            // Terminer la session
            document.getElementById('end-session')?.addEventListener('click', async () => {
            if (!confirm('Êtes-vous sûr de vouloir terminer la session ? Tous les participants seront déconnectés.')) {
                return;
            }

            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/end`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                }

                window.location.href = '{{ route('formateur.cours') }}';
            } catch (error) {
                console.error('Erreur lors de la fin de session:', error);
                window.location.href = '{{ route('formateur.cours') }}';
            }
        });

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
            console.log('📺 [SCREEN] Arrêt du partage d\'écran');
            if (screenStream) {
                screenStream.getTracks().forEach(track => {
                    track.stop();
                    // Retirer les tracks du partage d'écran des peer connections
                    peerConnections.forEach((pc) => {
                        const sender = pc.getSenders().find(s => s.track === track);
                        if (sender) {
                            pc.removeTrack(sender);
                        }
                    });
                });
                screenStream = null;
            }

            isSharingScreen = false;
            document.getElementById('share-screen').classList.remove('bg-green-600');
            document.getElementById('share-screen').classList.add('bg-gray-700');

            // Revenir au stream local
            if (localStream) {
                const localVideo = document.getElementById('local-video');
                if (localVideo) {
                    localVideo.srcObject = localStream;
                    localVideo.play().catch(err => console.error('Erreur lecture vidéo locale:', err));
                }

                // Remettre les tracks locaux dans les peer connections
                peerConnections.forEach((pc) => {
                    localStream.getTracks().forEach(track => {
                        const sender = pc.getSenders().find(s => s.track && s.track.kind === track.kind);
                        if (sender) {
                            sender.replaceTrack(track);
                        } else {
                            pc.addTrack(track, localStream);
                        }
                    });
                });
            }
        }

        // Basculer entre caméra avant/arrière (selfie)
        document.getElementById('switch-camera')?.addEventListener('click', async () => {
            try {
                console.log('📷 [CAMERA] Bascule caméra, mode actuel:', currentFacingMode);
                
                // Lister les caméras disponibles
                if (availableCameras.length === 0) {
                    // Pour Safari, il faut d'abord avoir un stream actif pour lister les caméras
                    if (!localStream) {
                        alert('Veuillez d\'abord activer votre caméra');
                        return;
                    }
                    
                    try {
                        const devices = await navigator.mediaDevices.enumerateDevices();
                        availableCameras = devices.filter(device => device.kind === 'videoinput' && device.deviceId);
                        console.log('📷 [CAMERA] Caméras disponibles:', availableCameras.length);
                        
                        // Si aucune caméra n'est trouvée, essayer de demander l'accès
                        if (availableCameras.length === 0 || availableCameras.every(cam => !cam.deviceId || cam.deviceId === 'default')) {
                            console.log('📷 [CAMERA] Aucune caméra avec deviceId, demande d\'accès...');
                            try {
                                // Pour Safari, utiliser une contrainte très simple
                                const device = detectDevice();
                                let tempStream = null;
                                
                                if (device.isSafari) {
                                    // Safari : essayer différentes approches
                                    try {
                                        // Utiliser true au lieu de {} qui est invalide et cause OverconstrainedError
                                        tempStream = await navigator.mediaDevices.getUserMedia({ video: true });
                                        console.log('✅ [CAMERA] Accès obtenu avec true pour Safari');
                                    } catch (e1) {
                                        console.warn('⚠️ [CAMERA] Échec avec true, essai suivant:', e1);
                                        try {
                                            // Essayer avec des contraintes minimales
                                            tempStream = await navigator.mediaDevices.getUserMedia({ 
                                                video: { facingMode: 'user' } 
                                            });
                                            console.log('✅ [CAMERA] Accès obtenu avec facingMode pour Safari');
                                        } catch (e2) {
                                            console.warn('⚠️ [CAMERA] Échec avec facingMode:', e2);
                                            // Si on a déjà un stream local, utiliser son deviceId
                                            if (localStream && localStream.getVideoTracks().length > 0) {
                                                const currentTrack = localStream.getVideoTracks()[0];
                                                const settings = currentTrack.getSettings();
                                                if (settings.deviceId) {
                                                    availableCameras = [{ deviceId: settings.deviceId, kind: 'videoinput', label: 'Caméra actuelle' }];
                                                    console.log('📷 [CAMERA] Utilisation de la caméra actuelle:', availableCameras.length);
                                                    return;
                                                }
                                            }
                                            throw e2;
                                        }
                                    }
                                } else {
                                    tempStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
                                }
                                
                                if (tempStream) {
                                    tempStream.getTracks().forEach(track => track.stop());
                                }
                                
                                // Réessayer d'énumérer
                                const devices2 = await navigator.mediaDevices.enumerateDevices();
                                availableCameras = devices2.filter(device => device.kind === 'videoinput' && device.deviceId);
                                console.log('📷 [CAMERA] Caméras disponibles après accès:', availableCameras.length);
                            } catch (err) {
                                console.error('Erreur lors de la demande d\'accès:', err);
                            }
                        }
                    } catch (err) {
                        console.error('Erreur lors de l\'énumération des caméras:', err);
                    }
                }

                if (availableCameras.length < 2) {
                    alert('Aucune autre caméra disponible');
                    return;
                }

                // Basculer vers la caméra suivante
                currentCameraIndex = (currentCameraIndex + 1) % availableCameras.length;
                const selectedCamera = availableCameras[currentCameraIndex];
                
                console.log('📷 [CAMERA] Sélection caméra:', selectedCamera.label || selectedCamera.deviceId);

                // Arrêter le stream actuel
                if (localStream) {
                    localStream.getVideoTracks().forEach(track => track.stop());
                }

                // Obtenir le nouveau stream avec la caméra sélectionnée
                const constraints = {
                    video: {
                        deviceId: { exact: selectedCamera.deviceId },
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    },
                    audio: localStream ? {
                        deviceId: localStream.getAudioTracks()[0]?.getSettings().deviceId
                    } : true
                };

                localStream = await navigator.mediaDevices.getUserMedia(constraints);
                
                // Mettre à jour la vidéo locale
                const localVideo = document.getElementById('local-video');
                if (localVideo) {
                    localVideo.srcObject = localStream;
                    localVideo.play().catch(err => console.error('Erreur lecture vidéo:', err));
                }

                // Mettre à jour tous les peer connections
                peerConnections.forEach((pc) => {
                    localStream.getVideoTracks().forEach(track => {
                        const sender = pc.getSenders().find(s => s.track && s.track.kind === 'video');
                        if (sender) {
                            sender.replaceTrack(track);
                        } else {
                            pc.addTrack(track, localStream);
                        }
                    });
                });

                // Mettre à jour le mode
                currentFacingMode = selectedCamera.label?.toLowerCase().includes('front') || 
                                  selectedCamera.label?.toLowerCase().includes('avant') ? 'user' : 'environment';
                
                console.log('✅ [CAMERA] Caméra basculée vers:', currentFacingMode);
            } catch (error) {
                console.error('❌ [CAMERA] Erreur lors du basculement:', error);
                alert('Impossible de basculer la caméra. Veuillez réessayer.');
            }
        });

            // Chat
            async function loadChatMessages() {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/chat/messages`);
                const data = await response.json();
                
                if (data.success) {
                    const container = document.getElementById('chat-messages');
                    container.innerHTML = '';
                    
                    data.messages.forEach(msg => {
                        addChatMessage(msg, msg.user_id === {{ Auth::id() }});
                    });
                    
                    container.scrollTop = container.scrollHeight;
                }
            } catch (error) {
                console.error('Erreur lors du chargement des messages:', error);
            }
        }

            function addChatMessage(msg, isOwn = false) {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = `mb-4 ${isOwn ? 'text-right' : 'text-left'}`;
            div.innerHTML = `
                <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwn ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white'}">
                    <p class="text-xs ${isOwn ? 'text-blue-200' : 'text-gray-300'} mb-1">${msg.nom}</p>
                    <p class="text-sm">${msg.message}</p>
                    <p class="text-xs ${isOwn ? 'text-blue-200' : 'text-gray-400'} mt-1">${new Date(msg.created_at).toLocaleTimeString()}</p>
                </div>
            `;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

            document.getElementById('send-chat-btn')?.addEventListener('click', async () => {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            
            if (!message) return;

            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/chat/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                if (data.success) {
                    input.value = '';
                }
            } catch (error) {
                console.error('Erreur lors de l\'envoi du message:', error);
            }
        });

            document.getElementById('chat-input')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('send-chat-btn').click();
            }
        });

            // Socket.IO (Pusher) - Notifications en temps réel
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
                loadPendingParticipants();
                loadActiveParticipants();
            });

            channel.bind('participant.left', (data) => {
                loadActiveParticipants();
            });

            channel.bind('participant.status.changed', (data) => {
                loadActiveParticipants();
            });

            channel.bind('chat.message', (data) => {
                addChatMessage(data, data.user_id === {{ Auth::id() }});
            });
            } else {
                // Fallback: polling pour les mises à jour
                setInterval(() => {
                    loadPendingParticipants();
                    loadActiveParticipants();
                }, 3000);
            }

            // Épingler un participant
            window.pinParticipant = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/pin`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    alert('Participant épinglé en mode présentation');
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de l\'épinglage:', error);
            }
        };

            // Refuser avec raison
            window.rejectParticipantWithReason = async function(participantId) {
            const raison = prompt('Raison du refus (optionnel):');
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ raison: raison || null })
                });

                const data = await response.json();
                if (data.success) {
                    loadPendingParticipants();
                }
            } catch (error) {
                console.error('Erreur lors du refus:', error);
            }
        };

            // Changer le mode de vue
            document.querySelectorAll('.view-mode-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const mode = btn.dataset.mode;
                try {
                    const url = `/formateur/video-conference/${sessionId}/view-mode`;
                    console.log('📊 [VIEW] Changement de vue, URL:', url);
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ vue_mode: mode })
                    });

                    const data = await response.json();
                    if (data.success) {
                        document.querySelectorAll('.view-mode-btn').forEach(b => {
                            b.classList.remove('bg-blue-600', 'text-white');
                            b.classList.add('text-gray-400');
                        });
                        btn.classList.add('bg-blue-600', 'text-white');
                        btn.classList.remove('text-gray-400');
                        
                        // Appliquer le mode de vue
                        const container = document.getElementById('video-container');
                        if (mode === 'galerie') {
                            container.style.gridTemplateColumns = 'repeat(auto-fill, minmax(200px, 1fr))';
                        } else {
                            container.style.gridTemplateColumns = 'repeat(auto-fit, minmax(300px, 1fr))';
                        }
                    }
                } catch (error) {
                    console.error('Erreur lors du changement de vue:', error);
                }
            });
        });

            // Couper tous les micros
            document.getElementById('mute-all-btn')?.addEventListener('click', async () => {
            if (!confirm('Couper tous les micros des participants ?')) {
                return;
            }

            try {
                const url = `/formateur/video-conference/${sessionId}/mute-all`;
                console.log('🔇 [MUTE-ALL] Coupure globale, URL:', url);
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                console.log('🔇 [MUTE-ALL] CSRF Token:', csrfToken ? 'Présent' : 'Manquant');
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin'
                });

                console.log('🔇 [MUTE-ALL] Réponse reçue:', {
                    status: response.status,
                    statusText: response.statusText,
                    ok: response.ok,
                    contentType: response.headers.get('content-type')
                });

                if (!response.ok) {
                    let errorText = '';
                    try {
                        errorText = await response.text();
                        console.error('❌ [MUTE-ALL] Erreur HTTP:', response.status, errorText);
                    } catch (e) {
                        console.error('❌ [MUTE-ALL] Impossible de lire le texte d\'erreur:', e);
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    console.error('❌ [MUTE-ALL] Réponse non-JSON reçue:', text);
                    throw new Error('Réponse non-JSON du serveur');
                }
                
                const data = await response.json();
                console.log('🔇 [MUTE-ALL] Données reçues:', data);
                
                if (data.success) {
                    alert('Tous les micros ont été coupés');
                    loadActiveParticipants();
                } else {
                    console.error('❌ [MUTE-ALL] Erreur dans la réponse:', data);
                    alert('Erreur: ' + (data.message || 'Impossible de couper tous les micros'));
                }
            } catch (error) {
                console.error('Erreur lors de la coupure globale:', error);
                console.error('Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                alert('Erreur lors de la coupure globale: ' + error.message);
            }
        });

            // Charger les statistiques
            async function loadStatistics() {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/statistics`);
                const data = await response.json();
                
                if (data.success) {
                    const stats = data.statistics;
                    const durationMinutes = stats.duration_minutes || 0;
                    const hours = Math.floor(durationMinutes / 60);
                    const minutes = durationMinutes % 60;
                    const duration = hours + ':' + String(minutes).padStart(2, '0');
                    
                    const durationEl = document.getElementById('stats-duration');
                    const participantsEl = document.getElementById('stats-participants');
                    
                    if (durationEl) durationEl.textContent = duration;
                    if (participantsEl) participantsEl.textContent = `${stats.participants_count || 0} participants`;
                }
            } catch (error) {
                console.error('Erreur lors du chargement des statistiques:', error);
            }
        }

            // Raccourcis clavier
            document.addEventListener('keydown', (e) => {
            // Ctrl+M : Couper tous les micros
            if (e.ctrlKey && e.key === 'm') {
                e.preventDefault();
                document.getElementById('mute-all-btn')?.click();
            }
            // Ctrl+E : Terminer la session
            if (e.ctrlKey && e.key === 'e') {
                e.preventDefault();
                document.getElementById('end-session')?.click();
            }
            // Ctrl+1 : Vue grille
            if (e.ctrlKey && e.key === '1') {
                e.preventDefault();
                document.getElementById('view-mode-grille')?.click();
            }
            // Ctrl+2 : Vue galerie
            if (e.ctrlKey && e.key === '2') {
                e.preventDefault();
                document.getElementById('view-mode-galerie')?.click();
            }
        });

            // Notifications sonores
            function playNotificationSound(type = 'message') {
            const audio = new Audio();
            if (type === 'message') {
                audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBjGH0fPTgjMGHm7A7+OZURAJR6Hh8sJtJgUwgM3y2Ik3CBlo';
            } else if (type === 'join') {
                audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBjGH0fPTgjMGHm7A7+OZURAJR6Hh8sJtJgUwgM3y2Ik3CBlo';
            }
            audio.volume = 0.3;
            audio.play().catch(() => {}); // Ignorer les erreurs d'autoplay
        }


        // Fonction d'initialisation globale
        function initializeVideoConference() {
            console.log('🚀 [GLOBAL] initializeVideoConference() appelée');
            console.log('🚀 [GLOBAL] État:', {
                sessionId: sessionId,
                currentUserId: currentUserId,
                localStream: !!localStream
            });
            
            // Vérifier que tous les éléments nécessaires existent
            const elements = {
                localVideo: document.getElementById('local-video'),
                videoContainer: document.getElementById('video-container'),
                toggleMicro: document.getElementById('toggle-micro'),
                toggleCamera: document.getElementById('toggle-camera'),
                shareScreen: document.getElementById('share-screen'),
                endSession: document.getElementById('end-session')
            };
            
            console.log('🚀 [GLOBAL] Éléments DOM trouvés:', Object.entries(elements).map(([key, el]) => ({
                name: key,
                found: !!el,
                id: el?.id
            })));
            
            // Initialiser
            console.log('🚀 [INIT] Début de l\'initialisation complète');
            console.log('🚀 [INIT] État du DOM:', {
                readyState: document.readyState,
                localVideoExists: !!document.getElementById('local-video'),
                videoContainerExists: !!document.getElementById('video-container')
            });
            
            // Appeler initVideo() immédiatement
            console.log('🚀 [INIT] Appel de initVideo()');
            initVideo().catch(error => {
                console.error('❌ [INIT] Erreur dans initVideo():', error);
            });
            
            loadPendingParticipants();
            loadActiveParticipants();
            loadStatistics();
            
            // Mettre à jour les statistiques toutes les minutes
            setInterval(loadStatistics, 60000);
            
            // Rafraîchir les participants toutes les 3 secondes
            setInterval(() => {
                loadActiveParticipants();
            }, 3000);
            
            console.log('✅ [INIT] Initialisation complète terminée');
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
            
            // Mettre à jour les indicateurs
            const info = videoContainer.querySelector('.participant-info');
            if (info) {
                info.innerHTML = `
                    <span>${participant.nom}</span>
                    ${!participant.micro_actif ? '<span class="ml-2">🔇</span>' : ''}
                    ${!participant.camera_active ? '<span class="ml-2">📷</span>' : ''}
                `;
            }
        }

        // Initialiser les connexions peer-to-peer avec tous les participants actifs
        async function initializePeerConnections() {
            if (!localStream) {
                console.log('Local stream pas encore prêt');
                return;
            }

            activeParticipants.forEach(async (participant) => {
                if (participant.user_id !== currentUserId && !peerConnections.has(participant.user_id)) {
                    await createPeerConnection(participant.user_id);
                }
            });
        }

        // Créer une connexion peer-to-peer avec un participant
        async function createPeerConnection(userId) {
            try {
                console.log('Création connexion peer avec', userId);
                const pc = new RTCPeerConnection(rtcConfiguration);
                
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
                const response = await fetch(`/formateur/video-conference/${sessionId}/webrtc/offer`, {
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

        // Envoyer un candidat ICE
        async function sendIceCandidate(userId, candidate) {
            try {
                await fetch(`/formateur/video-conference/${sessionId}/webrtc/ice-candidate`, {
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

        // Nettoyer les connexions d'un participant
        function cleanupParticipantConnection(userId) {
            const pc = peerConnections.get(userId);
            if (pc) {
                pc.close();
                peerConnections.delete(userId);
            }
            remoteStreams.delete(userId);
            
            const videoContainer = document.getElementById(`video-participant-${userId}`);
            if (videoContainer) {
                videoContainer.remove();
            }
        }

        // Initialiser immédiatement si le DOM est déjà chargé
        console.log('🚀 [SCRIPT] Script chargé, état du document:', document.readyState);
        console.log('🚀 [SCRIPT] Variables globales:', {
            sessionId: typeof sessionId !== 'undefined' ? sessionId : 'UNDEFINED',
            currentUserId: typeof currentUserId !== 'undefined' ? currentUserId : 'UNDEFINED',
            localStream: typeof localStream !== 'undefined' ? (localStream ? 'EXISTS' : 'NULL') : 'UNDEFINED'
        });
        
        if (document.readyState === 'loading') {
            console.log('🚀 [SCRIPT] DOM en cours de chargement, attente de DOMContentLoaded');
            document.addEventListener('DOMContentLoaded', () => {
                console.log('🚀 [SCRIPT] DOMContentLoaded déclenché');
                initializeVideoConference();
            });
        } else {
            console.log('🚀 [SCRIPT] DOM déjà chargé, initialisation immédiate');
            // Attendre un peu pour être sûr que tout est prêt
            setTimeout(() => {
                initializeVideoConference();
            }, 100);
        }
    </script>
</body>
</html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Visioconférence - {{ $cours->titre ?? 'Cours' }} - BJ Academie</title>
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
        }
        .sidebar-bg {
            background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);
        }
        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
        .video-participant.host {
            border-color: #f59e0b;
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
        .badge-host {
            background: #f59e0b;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }
        .notification-badge {
            position: absolute;
            top: -0.5rem;
            right: -0.5rem;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Left Sidebar -->
        <aside class="w-20 sidebar-bg text-white flex flex-col py-6">
            <div class="mb-8 flex items-center justify-center px-4">
                <a href="{{ route('formateur.cours') }}" class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg hover:bg-gray-100 transition-colors">
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
                        <p class="text-sm text-gray-400 mt-1">Gestion de la session vidéo</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Statistiques -->
                        <div class="flex items-center gap-2 text-sm text-gray-300" id="session-stats">
                            <span id="stats-duration">00:00</span>
                            <span>•</span>
                            <span id="stats-participants">0 participants</span>
                        </div>
                        
                        <!-- Mode de vue -->
                        <div class="flex items-center gap-2 bg-gray-700 rounded-lg p-1">
                            <button id="view-mode-grille" class="view-mode-btn px-3 py-1 text-sm rounded hover:bg-gray-600 text-white" data-mode="grille" title="Vue grille">
                                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                            <button id="view-mode-galerie" class="view-mode-btn px-3 py-1 text-sm rounded hover:bg-gray-600 text-gray-400" data-mode="galerie" title="Vue galerie">
                                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                    <path d="M2 7h16v10a2 2 0 01-2 2H4a2 2 0 01-2-2V7z"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Couper tous les micros -->
                        <button id="mute-all-btn" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors" title="Couper tous les micros">
                            🔇 Couper tous
                        </button>
                        
                        <button id="end-session" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Terminer la session
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex overflow-hidden">
                <!-- Video Container -->
                <div class="flex-1 flex flex-col">
                    <div class="flex-1 bg-gray-900 overflow-hidden">
                        <div id="video-container" class="h-full">
                            <!-- Ma vidéo (formateur) -->
                            <div class="video-participant host" id="local-video-container" data-user-id="{{ Auth::id() }}">
                                <video id="local-video" autoplay muted playsinline></video>
                                <div class="participant-info">
                                    <span>{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</span>
                                    <span class="badge-host">Hôte</span>
                                </div>
                            </div>
                            <!-- Les vidéos des participants seront ajoutées ici dynamiquement -->
                        </div>
                    </div>
                    
                    <!-- Contrôles -->
                    <div class="bg-gray-800 border-t border-gray-700 px-6 py-4">
                        <div class="flex items-center justify-center gap-4">
                            <!-- Micro -->
                            <button id="toggle-micro" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors relative">
                                <svg id="micro-icon" class="w-6 h-6 relative" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path>
                                </svg>
                                <svg id="micro-slash-icon" class="w-6 h-6 absolute hidden" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Caméra -->
                            <button id="toggle-camera" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors relative">
                                <svg id="camera-icon" class="w-6 h-6 relative" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106a1 1 0 00-1.106.553l-2 4A1 1 0 0013 13h2a1 1 0 00.894-.553l2-4a1 1 0 00-.553-1.341z"></path>
                                </svg>
                                <svg id="camera-slash-icon" class="w-6 h-6 absolute hidden" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Bascule caméra (selfie) -->
                            <button id="switch-camera" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors" title="Basculer caméra avant/arrière">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path>
                                    <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <!-- Partage d'écran -->
                            <button id="share-screen" class="flex items-center justify-center w-14 h-14 rounded-full bg-gray-700 hover:bg-gray-600 text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="w-96 bg-gray-800 border-l border-gray-700 flex flex-col">
                    <!-- Onglets -->
                    <div class="flex border-b border-gray-700">
                        <button class="tab-btn flex-1 px-4 py-3 text-white bg-gray-700" data-tab="participants">
                            Participants
                        </button>
                        <button class="tab-btn flex-1 px-4 py-3 text-gray-400 hover:text-white relative" data-tab="pending">
                            En attente
                            <span id="pending-count" class="notification-badge hidden">0</span>
                        </button>
                        <button class="tab-btn flex-1 px-4 py-3 text-gray-400 hover:text-white" data-tab="chat">
                            Chat
                        </button>
                    </div>

                    <!-- Contenu des onglets -->
                    <div class="flex-1 overflow-y-auto flex flex-col">
                        <!-- Onglet Participants -->
                        <div id="tab-participants" class="tab-content p-4 flex-1 overflow-y-auto">
                            <h3 class="text-lg font-semibold text-white mb-4">Participants actifs</h3>
                            <div id="active-participants-list" class="space-y-3">
                                <!-- Liste des participants actifs -->
                            </div>
                        </div>

                        <!-- Onglet En attente -->
                        <div id="tab-pending" class="tab-content p-4 flex-1 overflow-y-auto hidden">
                            <h3 class="text-lg font-semibold text-white mb-4">Demandes d'accès</h3>
                            <div id="pending-participants-list" class="space-y-3">
                                <!-- Liste des participants en attente -->
                            </div>
                        </div>

                        <!-- Onglet Chat -->
                        <div id="tab-chat" class="tab-content flex flex-col flex-1 overflow-hidden hidden">
                            <div class="p-4 border-b border-gray-700">
                                <h3 class="text-lg font-semibold text-white">Chat</h3>
                            </div>
                            <div class="flex-1 overflow-y-auto p-4" id="chat-messages">
                                <!-- Messages de chat -->
                            </div>
                            <div class="p-4 border-t border-gray-700">
                                <div class="flex gap-2">
                                    <input type="text" id="chat-input" placeholder="Tapez un message..." class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button id="send-chat-btn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Envoyer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sessionId = {{ $session->id }};
        const currentUserId = {{ Auth::id() }};
        let localStream = null;
        let screenStream = null;
        let isSharingScreen = false;
        let pendingParticipants = [];
        let activeParticipants = [];
        
        // Gestion de la caméra
        let currentFacingMode = 'user'; // 'user' = avant, 'environment' = arrière
        let availableCameras = [];
        let currentCameraIndex = 0;
        
        // WebRTC - Connexions peer-to-peer
        let peerConnections = new Map(); // Map<userId, RTCPeerConnection>
        let remoteStreams = new Map(); // Map<userId, MediaStream>
        
        // Configuration WebRTC
        const rtcConfiguration = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                { urls: 'stun:stun2.l.google.com:19302' }
            ]
        };

        // Modal de demande d'autorisation
        function showPermissionModal() {
            console.log('🔐 [MODAL] Création de la modale de permission');
            return new Promise((resolve, reject) => {
                const modal = document.createElement('div');
                modal.id = 'permission-modal';
                modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                        <h3 class="text-xl font-semibold text-white mb-4">Autorisation requise</h3>
                        <p class="text-gray-300 mb-6">
                            Pour démarrer la visioconférence, nous avons besoin d'accéder à votre caméra et microphone.
                            Veuillez autoriser l'accès lorsque votre navigateur vous le demandera.
                        </p>
                        <div class="flex gap-3">
                            <button id="request-permission-btn" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Autoriser l'accès
                            </button>
                            <button id="cancel-permission-btn" class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                Annuler
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                console.log('🔐 [MODAL] Modale ajoutée au DOM');

                // Attacher les événements après l'insertion dans le DOM
                setTimeout(() => {
                    const requestBtn = document.getElementById('request-permission-btn');
                    const cancelBtn = document.getElementById('cancel-permission-btn');
                    
                    console.log('🔐 [MODAL] Recherche des boutons:', {
                        requestBtn: !!requestBtn,
                        cancelBtn: !!cancelBtn
                    });
                    
                    if (requestBtn) {
                        console.log('🔐 [MODAL] Ajout de l\'événement click sur le bouton "Autoriser"');
                        requestBtn.addEventListener('click', async () => {
                            console.log('🔐 [MODAL] Clic sur "Autoriser l\'accès"');
                            modal.remove();
                            try {
                                console.log('🔐 [MODAL] Appel de requestMediaAccess()');
                                await requestMediaAccess();
                                console.log('🔐 [MODAL] requestMediaAccess() réussi');
                                resolve();
                            } catch (error) {
                                console.error('❌ [MODAL] Erreur dans requestMediaAccess():', error);
                                reject(error);
                            }
                        });
                    } else {
                        console.error('❌ [MODAL] Bouton "request-permission-btn" introuvable!');
                    }

                    if (cancelBtn) {
                        console.log('🔐 [MODAL] Ajout de l\'événement click sur le bouton "Annuler"');
                        cancelBtn.addEventListener('click', () => {
                            console.log('🔐 [MODAL] Clic sur "Annuler"');
                            modal.remove();
                            reject(new Error('Permissions annulées par l\'utilisateur'));
                        });
                    } else {
                        console.error('❌ [MODAL] Bouton "cancel-permission-btn" introuvable!');
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
            const isSafari = /^((?!chrome|android).)*safari/i.test(ua) || /Version\/[\d.]+.*Safari/.test(ua);
            
            return {
                isMobile,
                isIOS,
                isAndroid,
                isMac,
                isWindows,
                isLinux,
                isDesktop: !isMobile,
                isSafari
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
                if (device.isSafari) {
                    // Safari a besoin d'une approche spéciale - demander séparément
                    // Commencer par audio seul, puis ajouter vidéo
                    configs.push(
                        // Audio seul d'abord (Safari accepte mieux)
                        { video: false, audio: true },
                        // Puis essayer vidéo seul
                        { video: true, audio: false },
                        // Enfin les deux ensemble
                        { video: true, audio: true }
                    );
                } else {
                    // Autres navigateurs (Chrome, Firefox, Edge)
                    configs.push(
                        // Configuration optimale pour desktop
                        {
                            video: {
                                width: { ideal: 1280 },
                                height: { ideal: 720 },
                                frameRate: { ideal: 30 }
                            },
                            audio: {
                                echoCancellation: true,
                                noiseSuppression: true,
                                autoGainControl: true
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
                        { video: true, audio: true },
                        // Vidéo seulement
                        { video: true, audio: false },
                        // Audio seulement
                        { video: false, audio: true }
                    );
                }
            }

            return configs;
        }

        // Demander l'accès aux médias avec fallback progressif adapté à l'appareil
        async function requestMediaAccess() {
            try {
                console.log('📹 [MEDIA] Début de requestMediaAccess()');
                
                // Vérifier si l'API est disponible
                console.log('📹 [MEDIA] Vérification de l\'API mediaDevices:', {
                    mediaDevices: !!navigator.mediaDevices,
                    getUserMedia: !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia),
                    userAgent: navigator.userAgent
                });
                
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    const error = new Error('Votre navigateur ne supporte pas l\'accès aux médias. Veuillez utiliser un navigateur moderne (Chrome, Firefox, Edge, Safari).');
                    console.error('❌ [MEDIA] API non disponible:', error);
                    throw error;
                }

                // Détecter l'appareil
                const device = detectDevice();
                console.log('📹 [MEDIA] Appareil détecté:', device);

                // Obtenir les configurations adaptées
                const configurations = getDeviceConfigurations(device);
                console.log('📹 [MEDIA] Configurations à essayer:', configurations.length);

                let lastError = null;
                
                // Pour Safari, utiliser une approche spéciale
                // Safari a des problèmes connus avec getUserMedia, surtout sur macOS
                // Il faut parfois demander les permissions séparément et dans un ordre spécifique
                if (device.isSafari) {
                    try {
                        console.log('📹 [MEDIA] Approche Safari: demande séparée audio puis vidéo');
                        
                        // Safari nécessite parfois de demander l'audio d'abord pour "débloquer" les permissions
                        let audioStream = null;
                        let videoStream = null;
                        
                        // Étape 1: Demander l'audio d'abord
                        try {
                            audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            console.log('✅ [MEDIA] Audio obtenu pour Safari (étape 1)');
                        } catch (audioError) {
                            console.warn('⚠️ [MEDIA] Échec audio Safari:', audioError);
                            // Si l'audio échoue, on continue quand même pour essayer la vidéo
                        }
                        
                        // Étape 2: Demander la vidéo après l'audio (Safari peut nécessiter cet ordre)
                        // Essayer plusieurs configurations vidéo
                        const videoConfigs = [
                            { video: true },           // Configuration la plus simple
                            { video: {} },            // Objet vide
                            { video: { facingMode: 'user' } }  // Avec facingMode
                        ];
                        
                        for (let i = 0; i < videoConfigs.length; i++) {
                            try {
                                videoStream = await navigator.mediaDevices.getUserMedia(videoConfigs[i]);
                                console.log(`✅ [MEDIA] Vidéo obtenue pour Safari avec config ${i + 1}:`, videoConfigs[i]);
                                break; // Succès, sortir de la boucle
                            } catch (videoError) {
                                console.warn(`⚠️ [MEDIA] Échec config vidéo ${i + 1}:`, videoError);
                                if (i === videoConfigs.length - 1) {
                                    // Dernière tentative échouée
                                    console.warn('⚠️ [MEDIA] Toutes les configurations vidéo ont échoué');
                                }
                            }
                        }
                        
                        // Étape 3: Combiner ou utiliser les streams disponibles
                        if (audioStream && videoStream) {
                            // Créer un nouveau stream combiné
                            const combinedStream = new MediaStream();
                            audioStream.getAudioTracks().forEach(track => combinedStream.addTrack(track));
                            videoStream.getVideoTracks().forEach(track => combinedStream.addTrack(track));
                            localStream = combinedStream;
                            console.log('✅ [MEDIA] Streams combinés pour Safari');
                        } else if (videoStream) {
                            localStream = videoStream;
                            console.log('✅ [MEDIA] Utilisation vidéo seul pour Safari');
                        } else if (audioStream) {
                            localStream = audioStream;
                            console.log('✅ [MEDIA] Utilisation audio seul pour Safari (vidéo non disponible)');
                        } else {
                            throw new Error('Impossible d\'obtenir l\'audio ou la vidéo sur Safari. Veuillez vérifier les permissions système.');
                        }
                    } catch (error) {
                        console.error('❌ [MEDIA] Erreur approche Safari:', error);
                        lastError = error;
                    }
                } else {
                    // Pour les autres navigateurs, utiliser l'approche normale
                    for (let i = 0; i < configurations.length; i++) {
                        const config = configurations[i];
                        console.log(`📹 [MEDIA] Essai configuration ${i + 1}/${configurations.length}:`, config);
                        try {
                            console.log('📹 [MEDIA] Appel de getUserMedia avec la configuration:', config);
                            localStream = await navigator.mediaDevices.getUserMedia(config);
                            console.log('✅ [MEDIA] getUserMedia réussi! Stream obtenu:', {
                                id: localStream.id,
                                active: localStream.active,
                                videoTracks: localStream.getVideoTracks().length,
                                audioTracks: localStream.getAudioTracks().length,
                                videoTracksInfo: localStream.getVideoTracks().map(t => ({
                                    enabled: t.enabled,
                                    readyState: t.readyState,
                                    settings: t.getSettings()
                                })),
                                audioTracksInfo: localStream.getAudioTracks().map(t => ({
                                    enabled: t.enabled,
                                    readyState: t.readyState,
                                    settings: t.getSettings()
                                }))
                            });
                            // Si on arrive ici, la configuration a fonctionné
                            break;
                        } catch (error) {
                            console.warn(`⚠️ [MEDIA] Configuration ${i + 1} échouée:`, {
                                name: error.name,
                                message: error.message,
                                constraint: error.constraint
                            });
                            lastError = error;
                            // Continuer avec la configuration suivante
                            continue;
                        }
                    }
                }

                // Si aucune configuration n'a fonctionné, lancer l'erreur
                if (!localStream) {
                    console.error('❌ [MEDIA] Aucune configuration n\'a fonctionné. Dernière erreur:', lastError);
                    throw lastError || new Error('Impossible d\'accéder aux médias.');
                }

                console.log('📹 [MEDIA] Recherche de l\'élément video local...');
                // Afficher la vidéo locale
                const localVideo = document.getElementById('local-video');
                console.log('📹 [MEDIA] Élément video trouvé:', {
                    found: !!localVideo,
                    id: localVideo?.id,
                    tagName: localVideo?.tagName
                });
                
                if (localVideo) {
                    console.log('📹 [MEDIA] Attribution du stream à l\'élément video');
                    localVideo.srcObject = localStream;
                    
                    // Gérer l'orientation sur mobile
                    if (device.isMobile) {
                        console.log('📹 [MEDIA] Configuration mobile - ajout des attributs playsinline');
                        localVideo.setAttribute('playsinline', 'true');
                        localVideo.setAttribute('webkit-playsinline', 'true');
                    }
                    
                    console.log('📹 [MEDIA] Tentative de lecture de la vidéo...');
                    localVideo.play().then(() => {
                        console.log('✅ [MEDIA] Vidéo en lecture!');
                        console.log('📹 [MEDIA] État de la vidéo:', {
                            paused: localVideo.paused,
                            readyState: localVideo.readyState,
                            videoWidth: localVideo.videoWidth,
                            videoHeight: localVideo.videoHeight
                        });
                    }).catch(err => {
                        console.error('❌ [MEDIA] Erreur lors de la lecture de la vidéo:', err);
                        console.error('❌ [MEDIA] Détails de l\'erreur de lecture:', {
                            name: err.name,
                            message: err.message,
                            code: err.code
                        });
                    });
                } else {
                    console.error('❌ [MEDIA] Élément video #local-video introuvable dans le DOM!');
                }
                
                // Une fois la vidéo locale prête, créer les connexions avec les participants actifs
                setTimeout(() => {
                    console.log('📹 [MEDIA] Initialisation des connexions peer après 1 seconde');
                    initializePeerConnections();
                }, 1000);

                // Masquer le message d'erreur s'il existe
                const errorMsg = document.getElementById('media-error-message');
                if (errorMsg) {
                    console.log('📹 [MEDIA] Suppression du message d\'erreur existant');
                    errorMsg.remove();
                }

                console.log('✅ [MEDIA] requestMediaAccess() terminé avec succès');
                return true;
            } catch (error) {
                console.error('❌ [MEDIA] Erreur lors de l\'accès aux médias:', error);
                
                let errorMessage = 'Impossible d\'accéder à votre caméra ou microphone.';
                
                if (error.name === 'NotAllowedError' || error.name === 'PermissionDeniedError') {
                    errorMessage = 'L\'accès à la caméra et au microphone a été refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur et réessayer.';
                } else if (error.name === 'NotFoundError' || error.name === 'DevicesNotFoundError') {
                    errorMessage = 'Aucune caméra ou microphone n\'a été détecté. Veuillez vérifier que vos périphériques sont connectés.';
                } else if (error.name === 'NotReadableError' || error.name === 'TrackStartError') {
                    errorMessage = 'La caméra ou le microphone est déjà utilisé par une autre application. Veuillez fermer les autres applications et réessayer.';
                } else if (error.name === 'OverconstrainedError' || error.name === 'ConstraintNotSatisfiedError') {
                    errorMessage = 'Les paramètres de la caméra ou du microphone ne sont pas supportés. Veuillez utiliser un autre périphérique.';
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

        // Initialiser la vidéo du formateur
        async function initVideo() {
            console.log('🎥 [INIT] Début de l\'initialisation de la vidéo');
            try {
                console.log('🎥 [INIT] Affichage de la modale de permission');
                await showPermissionModal();
                console.log('🎥 [INIT] Modale de permission fermée avec succès');
            } catch (error) {
                console.error('❌ [INIT] Erreur lors de l\'initialisation de la vidéo:', error);
                console.error('❌ [INIT] Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                // L'erreur est déjà gérée par showMediaError
            }
        }

        // Gestion des onglets
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const tab = btn.dataset.tab;
                
                // Mettre à jour les boutons
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('bg-gray-700', 'text-white');
                    b.classList.add('text-gray-400');
                });
                btn.classList.add('bg-gray-700', 'text-white');
                btn.classList.remove('text-gray-400');

                // Afficher le contenu correspondant
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(`tab-${tab}`).classList.remove('hidden');

                // Charger les données si nécessaire
                if (tab === 'pending') {
                    loadPendingParticipants();
                } else if (tab === 'participants') {
                    loadActiveParticipants();
                } else if (tab === 'chat') {
                    loadChatMessages();
                }
            });
        });

        // Charger les participants en attente
            async function loadPendingParticipants() {
            try {
                const url = `/formateur/video-conference/${sessionId}/pending-participants`;
                console.log('📋 [PENDING] Chargement participants en attente, URL:', url);
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                
                if (data.success) {
                    pendingParticipants = data.participants;
                    updatePendingList();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des participants en attente:', error);
                console.error('Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                // Ne pas bloquer l'application, juste logger l'erreur
            }
        }

            // Mettre à jour la liste des participants en attente
            function updatePendingList() {
            const container = document.getElementById('pending-participants-list');
            const countBadge = document.getElementById('pending-count');
            
            if (countBadge) {
                countBadge.textContent = pendingParticipants.length;
                countBadge.classList.toggle('hidden', pendingParticipants.length === 0);
            }

            if (!container) return;

            container.innerHTML = '';

            if (pendingParticipants.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-center py-4">Aucune demande en attente</p>';
                return;
            }

            pendingParticipants.forEach(participant => {
                const div = document.createElement('div');
                div.className = 'bg-gray-700 rounded-lg p-4';
                div.innerHTML = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white">
                            ${participant.nom.charAt(0)}
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">${participant.nom}</p>
                            <p class="text-gray-400 text-sm">${participant.email}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="acceptParticipant(${participant.id})" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Accepter
                        </button>
                        <button onclick="rejectParticipantWithReason(${participant.id})" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Refuser
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

            // Charger les participants actifs
            async function loadActiveParticipants() {
            try {
                const url = `/formateur/video-conference/${sessionId}/active-participants`;
                console.log('👥 [ACTIVE] Chargement participants actifs, URL:', url);
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                
                if (data.success) {
                    const oldParticipants = new Set(activeParticipants.map(p => p.user_id));
                    activeParticipants = data.participants;
                    const newParticipants = new Set(activeParticipants.map(p => p.user_id));
                    
                    // Nettoyer les participants qui ont quitté
                    oldParticipants.forEach(userId => {
                        if (!newParticipants.has(userId) && userId !== currentUserId) {
                            cleanupParticipantConnection(userId);
                        }
                    });
                    
                    updateActiveList();
                    
                    // Créer des connexions avec les nouveaux participants
                    if (localStream) {
                        activeParticipants.forEach(participant => {
                            if (participant.user_id !== currentUserId && !peerConnections.has(participant.user_id)) {
                                createPeerConnection(participant.user_id);
                            }
                        });
                    }
                }
            } catch (error) {
                console.error('Erreur lors du chargement des participants actifs:', error);
                console.error('Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
                // Ne pas bloquer l'application, juste logger l'erreur
            }
        }

            // Mettre à jour la liste des participants actifs
            function updateActiveList() {
            const container = document.getElementById('active-participants-list');
            const countElement = document.getElementById('participants-count');
            
            if (countElement) {
                countElement.textContent = `${activeParticipants.length + 1} participant(s)`;
            }

            if (!container) return;

            container.innerHTML = '';

            if (activeParticipants.length === 0) {
                container.innerHTML = '<p class="text-gray-400 text-center py-4">Aucun participant actif</p>';
                return;
            }

            activeParticipants.forEach(participant => {
                // Créer ou mettre à jour la vidéo du participant
                createOrUpdateParticipantVideo(participant);
                
                const div = document.createElement('div');
                div.className = 'bg-gray-700 rounded-lg p-4';
                div.innerHTML = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white">
                            ${participant.nom.charAt(0)}
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium flex items-center gap-2">
                                ${participant.nom}
                                ${participant.main_levée ? '<span class="text-yellow-500 text-lg" title="Main levée">✋</span>' : ''}
                            </p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-xs flex items-center relative ${participant.micro_actif ? 'text-green-400' : 'text-red-400'}">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path>
                                    </svg>
                                    ${!participant.micro_actif ? '<svg class="w-4 h-4 absolute left-0 top-0" fill="none" stroke="currentColor" viewBox="0 0 20 20" style="stroke-width: 3;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>' : ''}
                                </span>
                                <span class="text-xs ${participant.camera_active ? 'text-green-400' : 'text-red-400'}">
                                    ${participant.camera_active ? '📹' : '📷'}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <button onclick="muteParticipant(${participant.id})" class="px-3 py-1.5 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition-colors">
                            Couper micro
                        </button>
                        <button onclick="disableCamera(${participant.id})" class="px-3 py-1.5 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition-colors">
                            Désactiver caméra
                        </button>
                        <button onclick="expelParticipant(${participant.id})" class="px-3 py-1.5 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition-colors">
                            Expulser
                        </button>
                    </div>
                `;
                container.appendChild(div);
            });
        }

            // Accepter un participant
            window.acceptParticipant = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/accept`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadPendingParticipants();
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de l\'acceptation:', error);
            }
        }

            // Refuser un participant
            async function rejectParticipant(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadPendingParticipants();
                }
            } catch (error) {
                console.error('Erreur lors du refus:', error);
            }
        }

            // Couper le micro d'un participant
            window.muteParticipant = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/mute`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de la coupure du micro:', error);
            }
        }

            // Désactiver la caméra d'un participant
            window.disableCamera = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/disable-camera`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de la désactivation de la caméra:', error);
            }
        }

            // Expulser un participant
            window.expelParticipant = async function(participantId) {
            if (!confirm('Êtes-vous sûr de vouloir expulser ce participant ?')) {
                return;
            }

            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/expel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    // Nettoyer la connexion WebRTC
                    const participant = activeParticipants.find(p => p.id === participantId);
                    if (participant) {
                        cleanupParticipantConnection(participant.user_id);
                    }
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de l\'expulsion:', error);
            }
        }

            // Terminer la session
            document.getElementById('end-session')?.addEventListener('click', async () => {
            if (!confirm('Êtes-vous sûr de vouloir terminer la session ? Tous les participants seront déconnectés.')) {
                return;
            }

            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/end`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                if (localStream) {
                    localStream.getTracks().forEach(track => track.stop());
                }

                window.location.href = '{{ route('formateur.cours') }}';
            } catch (error) {
                console.error('Erreur lors de la fin de session:', error);
                window.location.href = '{{ route('formateur.cours') }}';
            }
        });

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
            console.log('📺 [SCREEN] Arrêt du partage d\'écran');
            if (screenStream) {
                screenStream.getTracks().forEach(track => {
                    track.stop();
                    // Retirer les tracks du partage d'écran des peer connections
                    peerConnections.forEach((pc) => {
                        const sender = pc.getSenders().find(s => s.track === track);
                        if (sender) {
                            pc.removeTrack(sender);
                        }
                    });
                });
                screenStream = null;
            }

            isSharingScreen = false;
            document.getElementById('share-screen').classList.remove('bg-green-600');
            document.getElementById('share-screen').classList.add('bg-gray-700');

            // Revenir au stream local
            if (localStream) {
                const localVideo = document.getElementById('local-video');
                if (localVideo) {
                    localVideo.srcObject = localStream;
                    localVideo.play().catch(err => console.error('Erreur lecture vidéo locale:', err));
                }

                // Remettre les tracks locaux dans les peer connections
                peerConnections.forEach((pc) => {
                    localStream.getTracks().forEach(track => {
                        const sender = pc.getSenders().find(s => s.track && s.track.kind === track.kind);
                        if (sender) {
                            sender.replaceTrack(track);
                        } else {
                            pc.addTrack(track, localStream);
                        }
                    });
                });
            }
        }

        // Basculer entre caméra avant/arrière (selfie)
        document.getElementById('switch-camera')?.addEventListener('click', async () => {
            try {
                console.log('📷 [CAMERA] Bascule caméra, mode actuel:', currentFacingMode);
                
                // Lister les caméras disponibles
                if (availableCameras.length === 0) {
                    // Pour Safari, il faut d'abord avoir un stream actif pour lister les caméras
                    if (!localStream) {
                        alert('Veuillez d\'abord activer votre caméra');
                        return;
                    }
                    
                    try {
                        const devices = await navigator.mediaDevices.enumerateDevices();
                        availableCameras = devices.filter(device => device.kind === 'videoinput' && device.deviceId);
                        console.log('📷 [CAMERA] Caméras disponibles:', availableCameras.length);
                        
                        // Si aucune caméra n'est trouvée, essayer de demander l'accès
                        if (availableCameras.length === 0 || availableCameras.every(cam => !cam.deviceId || cam.deviceId === 'default')) {
                            console.log('📷 [CAMERA] Aucune caméra avec deviceId, demande d\'accès...');
                            try {
                                // Pour Safari, utiliser une contrainte très simple
                                const device = detectDevice();
                                let tempStream = null;
                                
                                if (device.isSafari) {
                                    // Safari : essayer différentes approches
                                    try {
                                        // Utiliser true au lieu de {} qui est invalide et cause OverconstrainedError
                                        tempStream = await navigator.mediaDevices.getUserMedia({ video: true });
                                        console.log('✅ [CAMERA] Accès obtenu avec true pour Safari');
                                    } catch (e1) {
                                        console.warn('⚠️ [CAMERA] Échec avec true, essai suivant:', e1);
                                        try {
                                            // Essayer avec des contraintes minimales
                                            tempStream = await navigator.mediaDevices.getUserMedia({ 
                                                video: { facingMode: 'user' } 
                                            });
                                            console.log('✅ [CAMERA] Accès obtenu avec facingMode pour Safari');
                                        } catch (e2) {
                                            console.warn('⚠️ [CAMERA] Échec avec facingMode:', e2);
                                            // Si on a déjà un stream local, utiliser son deviceId
                                            if (localStream && localStream.getVideoTracks().length > 0) {
                                                const currentTrack = localStream.getVideoTracks()[0];
                                                const settings = currentTrack.getSettings();
                                                if (settings.deviceId) {
                                                    availableCameras = [{ deviceId: settings.deviceId, kind: 'videoinput', label: 'Caméra actuelle' }];
                                                    console.log('📷 [CAMERA] Utilisation de la caméra actuelle:', availableCameras.length);
                                                    return;
                                                }
                                            }
                                            throw e2;
                                        }
                                    }
                                } else {
                                    tempStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
                                }
                                
                                if (tempStream) {
                                    tempStream.getTracks().forEach(track => track.stop());
                                }
                                
                                // Réessayer d'énumérer
                                const devices2 = await navigator.mediaDevices.enumerateDevices();
                                availableCameras = devices2.filter(device => device.kind === 'videoinput' && device.deviceId);
                                console.log('📷 [CAMERA] Caméras disponibles après accès:', availableCameras.length);
                            } catch (err) {
                                console.error('Erreur lors de la demande d\'accès:', err);
                            }
                        }
                    } catch (err) {
                        console.error('Erreur lors de l\'énumération des caméras:', err);
                    }
                }

                if (availableCameras.length < 2) {
                    alert('Aucune autre caméra disponible');
                    return;
                }

                // Basculer vers la caméra suivante
                currentCameraIndex = (currentCameraIndex + 1) % availableCameras.length;
                const selectedCamera = availableCameras[currentCameraIndex];
                
                console.log('📷 [CAMERA] Sélection caméra:', selectedCamera.label || selectedCamera.deviceId);

                // Arrêter le stream actuel
                if (localStream) {
                    localStream.getVideoTracks().forEach(track => track.stop());
                }

                // Obtenir le nouveau stream avec la caméra sélectionnée
                const constraints = {
                    video: {
                        deviceId: { exact: selectedCamera.deviceId },
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    },
                    audio: localStream ? {
                        deviceId: localStream.getAudioTracks()[0]?.getSettings().deviceId
                    } : true
                };

                localStream = await navigator.mediaDevices.getUserMedia(constraints);
                
                // Mettre à jour la vidéo locale
                const localVideo = document.getElementById('local-video');
                if (localVideo) {
                    localVideo.srcObject = localStream;
                    localVideo.play().catch(err => console.error('Erreur lecture vidéo:', err));
                }

                // Mettre à jour tous les peer connections
                peerConnections.forEach((pc) => {
                    localStream.getVideoTracks().forEach(track => {
                        const sender = pc.getSenders().find(s => s.track && s.track.kind === 'video');
                        if (sender) {
                            sender.replaceTrack(track);
                        } else {
                            pc.addTrack(track, localStream);
                        }
                    });
                });

                // Mettre à jour le mode
                currentFacingMode = selectedCamera.label?.toLowerCase().includes('front') || 
                                  selectedCamera.label?.toLowerCase().includes('avant') ? 'user' : 'environment';
                
                console.log('✅ [CAMERA] Caméra basculée vers:', currentFacingMode);
            } catch (error) {
                console.error('❌ [CAMERA] Erreur lors du basculement:', error);
                alert('Impossible de basculer la caméra. Veuillez réessayer.');
            }
        });

            // Chat
            async function loadChatMessages() {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/chat/messages`);
                const data = await response.json();
                
                if (data.success) {
                    const container = document.getElementById('chat-messages');
                    container.innerHTML = '';
                    
                    data.messages.forEach(msg => {
                        addChatMessage(msg, msg.user_id === {{ Auth::id() }});
                    });
                    
                    container.scrollTop = container.scrollHeight;
                }
            } catch (error) {
                console.error('Erreur lors du chargement des messages:', error);
            }
        }

            function addChatMessage(msg, isOwn = false) {
            const container = document.getElementById('chat-messages');
            const div = document.createElement('div');
            div.className = `mb-4 ${isOwn ? 'text-right' : 'text-left'}`;
            div.innerHTML = `
                <div class="inline-block max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${isOwn ? 'bg-blue-600 text-white' : 'bg-gray-700 text-white'}">
                    <p class="text-xs ${isOwn ? 'text-blue-200' : 'text-gray-300'} mb-1">${msg.nom}</p>
                    <p class="text-sm">${msg.message}</p>
                    <p class="text-xs ${isOwn ? 'text-blue-200' : 'text-gray-400'} mt-1">${new Date(msg.created_at).toLocaleTimeString()}</p>
                </div>
            `;
            container.appendChild(div);
            container.scrollTop = container.scrollHeight;
        }

            document.getElementById('send-chat-btn')?.addEventListener('click', async () => {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            
            if (!message) return;

            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/chat/send`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                if (data.success) {
                    input.value = '';
                }
            } catch (error) {
                console.error('Erreur lors de l\'envoi du message:', error);
            }
        });

            document.getElementById('chat-input')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('send-chat-btn').click();
            }
        });

            // Socket.IO (Pusher) - Notifications en temps réel
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
                loadPendingParticipants();
                loadActiveParticipants();
            });

            channel.bind('participant.left', (data) => {
                loadActiveParticipants();
            });

            channel.bind('participant.status.changed', (data) => {
                loadActiveParticipants();
            });

            channel.bind('chat.message', (data) => {
                addChatMessage(data, data.user_id === {{ Auth::id() }});
            });
            } else {
                // Fallback: polling pour les mises à jour
                setInterval(() => {
                    loadPendingParticipants();
                    loadActiveParticipants();
                }, 3000);
            }

            // Épingler un participant
            window.pinParticipant = async function(participantId) {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/pin`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    alert('Participant épinglé en mode présentation');
                    loadActiveParticipants();
                }
            } catch (error) {
                console.error('Erreur lors de l\'épinglage:', error);
            }
        };

            // Refuser avec raison
            window.rejectParticipantWithReason = async function(participantId) {
            const raison = prompt('Raison du refus (optionnel):');
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/participant/${participantId}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ raison: raison || null })
                });

                const data = await response.json();
                if (data.success) {
                    loadPendingParticipants();
                }
            } catch (error) {
                console.error('Erreur lors du refus:', error);
            }
        };

            // Changer le mode de vue
            document.querySelectorAll('.view-mode-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const mode = btn.dataset.mode;
                try {
                    const url = `/formateur/video-conference/${sessionId}/view-mode`;
                    console.log('📊 [VIEW] Changement de vue, URL:', url);
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ vue_mode: mode })
                    });

                    const data = await response.json();
                    if (data.success) {
                        document.querySelectorAll('.view-mode-btn').forEach(b => {
                            b.classList.remove('bg-blue-600', 'text-white');
                            b.classList.add('text-gray-400');
                        });
                        btn.classList.add('bg-blue-600', 'text-white');
                        btn.classList.remove('text-gray-400');
                        
                        // Appliquer le mode de vue
                        const container = document.getElementById('video-container');
                        if (mode === 'galerie') {
                            container.style.gridTemplateColumns = 'repeat(auto-fill, minmax(200px, 1fr))';
                        } else {
                            container.style.gridTemplateColumns = 'repeat(auto-fit, minmax(300px, 1fr))';
                        }
                    }
                } catch (error) {
                    console.error('Erreur lors du changement de vue:', error);
                }
            });
        });

            // Couper tous les micros
            document.getElementById('mute-all-btn')?.addEventListener('click', async () => {
            if (!confirm('Couper tous les micros des participants ?')) {
                return;
            }

            try {
                const url = `/formateur/video-conference/${sessionId}/mute-all`;
                console.log('🔇 [MUTE-ALL] Coupure globale, URL:', url);
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                console.log('🔇 [MUTE-ALL] CSRF Token:', csrfToken ? 'Présent' : 'Manquant');
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('❌ [MUTE-ALL] Erreur HTTP:', response.status, errorText);
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                if (data.success) {
                    alert('Tous les micros ont été coupés');
                    loadActiveParticipants();
                } else {
                    console.error('❌ [MUTE-ALL] Erreur dans la réponse:', data);
                }
            } catch (error) {
                console.error('Erreur lors de la coupure globale:', error);
                console.error('Détails de l\'erreur:', {
                    name: error.name,
                    message: error.message,
                    stack: error.stack
                });
            }
        });

            // Charger les statistiques
            async function loadStatistics() {
            try {
                const response = await fetch(`/formateur/video-conference/${sessionId}/statistics`);
                const data = await response.json();
                
                if (data.success) {
                    const stats = data.statistics;
                    const durationMinutes = stats.duration_minutes || 0;
                    const hours = Math.floor(durationMinutes / 60);
                    const minutes = durationMinutes % 60;
                    const duration = hours + ':' + String(minutes).padStart(2, '0');
                    
                    const durationEl = document.getElementById('stats-duration');
                    const participantsEl = document.getElementById('stats-participants');
                    
                    if (durationEl) durationEl.textContent = duration;
                    if (participantsEl) participantsEl.textContent = `${stats.participants_count || 0} participants`;
                }
            } catch (error) {
                console.error('Erreur lors du chargement des statistiques:', error);
            }
        }

            // Raccourcis clavier
            document.addEventListener('keydown', (e) => {
            // Ctrl+M : Couper tous les micros
            if (e.ctrlKey && e.key === 'm') {
                e.preventDefault();
                document.getElementById('mute-all-btn')?.click();
            }
            // Ctrl+E : Terminer la session
            if (e.ctrlKey && e.key === 'e') {
                e.preventDefault();
                document.getElementById('end-session')?.click();
            }
            // Ctrl+1 : Vue grille
            if (e.ctrlKey && e.key === '1') {
                e.preventDefault();
                document.getElementById('view-mode-grille')?.click();
            }
            // Ctrl+2 : Vue galerie
            if (e.ctrlKey && e.key === '2') {
                e.preventDefault();
                document.getElementById('view-mode-galerie')?.click();
            }
        });

            // Notifications sonores
            function playNotificationSound(type = 'message') {
            const audio = new Audio();
            if (type === 'message') {
                audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBjGH0fPTgjMGHm7A7+OZURAJR6Hh8sJtJgUwgM3y2Ik3CBlo';
            } else if (type === 'join') {
                audio.src = 'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBjGH0fPTgjMGHm7A7+OZURAJR6Hh8sJtJgUwgM3y2Ik3CBlo';
            }
            audio.volume = 0.3;
            audio.play().catch(() => {}); // Ignorer les erreurs d'autoplay
        }


        // Fonction d'initialisation globale
        function initializeVideoConference() {
            console.log('🚀 [GLOBAL] initializeVideoConference() appelée');
            console.log('🚀 [GLOBAL] État:', {
                sessionId: sessionId,
                currentUserId: currentUserId,
                localStream: !!localStream
            });
            
            // Vérifier que tous les éléments nécessaires existent
            const elements = {
                localVideo: document.getElementById('local-video'),
                videoContainer: document.getElementById('video-container'),
                toggleMicro: document.getElementById('toggle-micro'),
                toggleCamera: document.getElementById('toggle-camera'),
                shareScreen: document.getElementById('share-screen'),
                endSession: document.getElementById('end-session')
            };
            
            console.log('🚀 [GLOBAL] Éléments DOM trouvés:', Object.entries(elements).map(([key, el]) => ({
                name: key,
                found: !!el,
                id: el?.id
            })));
            
            // Initialiser
            console.log('🚀 [INIT] Début de l\'initialisation complète');
            console.log('🚀 [INIT] État du DOM:', {
                readyState: document.readyState,
                localVideoExists: !!document.getElementById('local-video'),
                videoContainerExists: !!document.getElementById('video-container')
            });
            
            // Appeler initVideo() immédiatement
            console.log('🚀 [INIT] Appel de initVideo()');
            initVideo().catch(error => {
                console.error('❌ [INIT] Erreur dans initVideo():', error);
            });
            
            loadPendingParticipants();
            loadActiveParticipants();
            loadStatistics();
            
            // Mettre à jour les statistiques toutes les minutes
            setInterval(loadStatistics, 60000);
            
            // Rafraîchir les participants toutes les 3 secondes
            setInterval(() => {
                loadActiveParticipants();
            }, 3000);
            
            console.log('✅ [INIT] Initialisation complète terminée');
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
            
            // Mettre à jour les indicateurs
            const info = videoContainer.querySelector('.participant-info');
            if (info) {
                info.innerHTML = `
                    <span>${participant.nom}</span>
                    ${!participant.micro_actif ? '<span class="ml-2">🔇</span>' : ''}
                    ${!participant.camera_active ? '<span class="ml-2">📷</span>' : ''}
                `;
            }
        }

        // Initialiser les connexions peer-to-peer avec tous les participants actifs
        async function initializePeerConnections() {
            if (!localStream) {
                console.log('Local stream pas encore prêt');
                return;
            }

            activeParticipants.forEach(async (participant) => {
                if (participant.user_id !== currentUserId && !peerConnections.has(participant.user_id)) {
                    await createPeerConnection(participant.user_id);
                }
            });
        }

        // Créer une connexion peer-to-peer avec un participant
        async function createPeerConnection(userId) {
            try {
                console.log('Création connexion peer avec', userId);
                const pc = new RTCPeerConnection(rtcConfiguration);
                
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
                const response = await fetch(`/formateur/video-conference/${sessionId}/webrtc/offer`, {
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

        // Envoyer un candidat ICE
        async function sendIceCandidate(userId, candidate) {
            try {
                await fetch(`/formateur/video-conference/${sessionId}/webrtc/ice-candidate`, {
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

        // Nettoyer les connexions d'un participant
        function cleanupParticipantConnection(userId) {
            const pc = peerConnections.get(userId);
            if (pc) {
                pc.close();
                peerConnections.delete(userId);
            }
            remoteStreams.delete(userId);
            
            const videoContainer = document.getElementById(`video-participant-${userId}`);
            if (videoContainer) {
                videoContainer.remove();
            }
        }

        // Initialiser immédiatement si le DOM est déjà chargé
        console.log('🚀 [SCRIPT] Script chargé, état du document:', document.readyState);
        console.log('🚀 [SCRIPT] Variables globales:', {
            sessionId: typeof sessionId !== 'undefined' ? sessionId : 'UNDEFINED',
            currentUserId: typeof currentUserId !== 'undefined' ? currentUserId : 'UNDEFINED',
            localStream: typeof localStream !== 'undefined' ? (localStream ? 'EXISTS' : 'NULL') : 'UNDEFINED'
        });
        
        if (document.readyState === 'loading') {
            console.log('🚀 [SCRIPT] DOM en cours de chargement, attente de DOMContentLoaded');
            document.addEventListener('DOMContentLoaded', () => {
                console.log('🚀 [SCRIPT] DOMContentLoaded déclenché');
                initializeVideoConference();
            });
        } else {
            console.log('🚀 [SCRIPT] DOM déjà chargé, initialisation immédiate');
            // Attendre un peu pour être sûr que tout est prêt
            setTimeout(() => {
                initializeVideoConference();
            }, 100);
        }
    </script>
</body>
</html>



