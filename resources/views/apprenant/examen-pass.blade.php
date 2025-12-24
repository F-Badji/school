<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Examen - {{ $examen->titre ?? 'Examen' }} - BJ Academie</title>
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
        .quiz-sidebar {
            width: 380px;
            background-color: #ffffff;
            border-right: 1px solid #e5e7eb;
            transition: width 0.3s ease, opacity 0.3s ease;
        }
        .quiz-sidebar.closed {
            width: 0;
            opacity: 0;
            overflow: hidden;
        }
        .quiz-question-item {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .quiz-question-item:hover {
            background-color: #f9fafb;
        }
        .quiz-question-item.active {
            background-color: #f3e8ff;
            border-left: 4px solid #9333ea;
        }
        .timer-box {
            background-color: #374151;
            color: #ffffff;
            padding: 16px;
            text-align: center;
            font-family: 'Courier New', monospace;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .timer-box.warning {
            background-color: #dc2626;
        }
        .answer-button {
            padding: 16px 32px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .answer-button:hover {
            border-color: #9333ea;
            background-color: #faf5ff;
        }
        .answer-button.selected {
            background-color: #f3e8ff;
            border-color: #9333ea;
            color: #9333ea;
        }
        .locked-interface {
            pointer-events: none;
            user-select: none;
            filter: blur(20px);
            -webkit-filter: blur(20px);
            opacity: 0.1;
        }
        .locked-interface * {
            pointer-events: none;
        }
        .unlock-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .unlock-modal.hidden {
            display: none;
        }
        /* Flouter complètement le contenu derrière le modal */
        .unlock-modal-active #mainContainer {
            filter: blur(30px) !important;
            -webkit-filter: blur(30px) !important;
            opacity: 0.05 !important;
            pointer-events: none !important;
            user-select: none !important;
        }
        /* Empêcher la sélection de texte */
        body {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        /* Permettre la sélection dans les champs de texte */
        textarea, input[type="text"], input[type="number"] {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
    </style>
</head>
<body oncontextmenu="return false;">
    <!-- Overlay de sécurité pour forcer le plein écran -->
    <div id="securityOverlay" class="fixed inset-0 bg-black z-[10000] flex items-center justify-center" style="display: none;">
        <div class="bg-white rounded-xl p-8 max-w-md mx-4 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Sécurité requise</h3>
            <p class="text-gray-600 mb-6">Le mode plein écran est obligatoire pour passer cet examen. Veuillez autoriser le mode plein écran pour continuer.</p>
            <button onclick="forceFullscreen()" class="px-6 py-3 text-white rounded-lg font-medium transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                Autoriser le mode plein écran
            </button>
        </div>
    </div>

    <!-- Modal de déverrouillage -->
    <div id="unlockModal" class="unlock-modal {{ $codeUnlocked ? 'hidden' : '' }}">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Interface verrouillée</h3>
            <p class="text-gray-600 mb-6" id="unlockMessageReason">Pour déverrouiller l'interface, veuillez entrer le code de sécurité fourni par votre professeur.</p>
            <div id="fullscreenPrompt" class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800" style="display: none;">
                <p class="font-semibold mb-1">⚠️ Mode plein écran requis</p>
                <p class="mb-2">Vous risquez d'être suspendu une fois quitté le mode plein écran.</p>
                <button type="button" onclick="enterFullscreen()" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                    Réactiver le mode plein écran
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Code de sécurité</label>
                <input type="text" id="unlockCode" maxlength="6" autocomplete="off" autofill="off" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center text-2xl font-mono tracking-widest" placeholder="000000">
            </div>
            <div id="unlockMessage" class="mb-4 text-sm"></div>
            <div class="flex gap-3">
                <button onclick="unlockInterface()" class="flex-1 px-6 py-3 text-white rounded-lg font-medium hover:opacity-90 transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                    Déverrouiller
                </button>
            </div>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden {{ $codeUnlocked ? '' : 'locked-interface' }}" id="mainContainer">
        <!-- Left Quiz Sidebar -->
        <aside id="quizSidebar" class="quiz-sidebar flex flex-col h-full" style="{{ $codeUnlocked ? '' : 'display: none;' }}">
            <!-- Header -->
            <div class="bg-gray-800 text-white p-4">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Examen</h2>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-purple-200 flex items-center justify-center flex-shrink-0">
                            @if($user->photo ?? null)
                                <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full rounded-full object-cover">
                            @else
                                <span class="text-xs font-semibold text-purple-700">
                                    {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}</p>
                            <p class="text-xs text-gray-300 break-words">{{ $user->email ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="flex-1 overflow-y-auto">
                @if($questions && $questions->count() > 0)
                    @foreach($questions as $index => $question)
                        <div class="quiz-question-item block {{ $index == ($currentQuestionIndex ?? 0) ? 'active' : '' }}" 
                             data-question-index="{{ $index }}"
                             style="text-decoration: none; color: inherit; cursor: default; pointer-events: none;">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-900">Question {{ $index + 1 }}</div>
                                @if($index < $currentQuestionIndex)
                                    <div class="flex items-center gap-1 text-xs font-semibold text-green-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>Terminé</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="p-4 text-center text-gray-500 text-sm">
                        Aucune question disponible
                    </div>
                @endif
            </div>

            <!-- Timer -->
            <div class="timer-box" id="timerBox">
                <div id="timerDisplay">00 : 00 : 00</div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white px-6 py-3 flex items-center justify-between border-b border-gray-200" id="topBar" style="{{ $codeUnlocked ? '' : 'display: none;' }}">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-bold text-gray-700">
                        {{ $examen->titre }}
                    </h2>
                </div>
            </div>

            <!-- Examen Content -->
            <div class="flex-1 overflow-y-auto bg-white p-8">
                <div class="max-w-4xl mx-auto">
                    @if($questions && $questions->count() > 0)
                        @php
                            $currentQuestion = $questions->get($currentQuestionIndex ?? 0);
                            $totalQuestions = $questions->count();
                        @endphp
                        
                        @if($currentQuestion)
                            <!-- Question Section with Border -->
                            <div class="border-2 border-gray-300 rounded-lg p-6">
                                <form id="examenForm" action="{{ route('apprenant.examen.submit', $examen->id) }}" method="POST">
                                    @csrf
                                    
                                    <!-- Inclure toutes les questions dans le formulaire (masquées sauf la question actuelle) -->
                                    @foreach($questions as $qIndex => $question)
                                        <div class="question-container" data-question-index="{{ $qIndex }}" style="{{ $qIndex == $currentQuestionIndex ? '' : 'display: none;' }}">
                                            <!-- Question Header -->
                                            <div class="mb-6">
                                                <span class="text-sm text-gray-600">Question {{ $qIndex + 1 }} sur {{ $totalQuestions }}</span>
                                            </div>

                                            <!-- Question -->
                                            <div class="mb-6">
                                                <h2 class="text-xl font-semibold text-gray-900 mb-4">
                                                    {{ $question->question }}
                                                </h2>
                                            </div>

                                            <!-- Image (if question has image) -->
                                            @if($question->image)
                                                <div class="mb-8 flex justify-center">
                                                    <img src="{{ asset('storage/' . $question->image) }}" alt="Question image" class="max-w-md w-full rounded-lg shadow-md">
                                                </div>
                                            @endif
                                            
                                            <!-- Answer Section -->
                                            <div class="mb-8">
                                            @if($question->type === 'vrai_faux')
                                                <div class="flex gap-4">
                                                    <button type="button" class="answer-button flex-1" onclick="selectAnswer(this, 'VRAI', {{ $question->id }})">
                                                        VRAI
                                                    </button>
                                                    <button type="button" class="answer-button flex-1" onclick="selectAnswer(this, 'FAUX', {{ $question->id }})">
                                                        FAUX
                                                    </button>
                                                </div>
                                                <input type="hidden" name="question_{{ $question->id }}_reponse" id="answer_{{ $question->id }}">
                                            @elseif($question->type === 'choix_multiple')
                                                <div class="space-y-3">
                                                    @if($question->options && is_array($question->options))
                                                        @foreach($question->options as $optIndex => $option)
                                                            <label class="flex items-center gap-3 p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors answer-option" onclick="selectMultipleAnswer(this, {{ $question->id }}, {{ $optIndex }})">
                                                                <input type="checkbox" name="question_{{ $question->id }}_option_{{ $optIndex }}" class="w-5 h-5 text-blue-600">
                                                                <span class="flex-1 text-gray-900 font-medium">{{ $option['texte'] ?? '' }}</span>
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @elseif($question->type === 'texte_libre')
                                                <textarea name="question_{{ $question->id }}_reponse" rows="5" placeholder="Tapez votre réponse ici..." class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                                            @elseif($question->type === 'numerique')
                                                <input type="number" step="any" name="question_{{ $question->id }}_reponse" placeholder="Entrez votre réponse numérique" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg text-center">
                                            @endif
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Bottom Actions -->
                                    <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                                        @if($currentQuestionIndex > 0)
                                            <a href="{{ route('apprenant.examen.passer', ['id' => $examen->id, 'q' => $currentQuestionIndex - 1]) }}" class="px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 inline-block text-center">
                                                ← Question précédente
                                            </a>
                                        @else
                                            <div></div>
                                        @endif
                                        
                                        @if($currentQuestionIndex < $totalQuestions - 1)
                                            <a href="{{ route('apprenant.examen.passer', ['id' => $examen->id, 'q' => $currentQuestionIndex + 1]) }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 inline-block text-center">
                                                Question suivante →
                                            </a>
                                        @else
                                            <button type="button" onclick="submitExamen(event)" class="px-6 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 inline-block text-center">
                                                Soumettre l'examen
                                            </button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-600">Aucune question disponible pour cet examen.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sécurité : Empêcher l'accès aux outils de développement
        document.addEventListener('keydown', function(e) {
            // Empêcher F12
            if (e.key === 'F12') {
                e.preventDefault();
                return false;
            }
            // Empêcher Ctrl+Shift+I (DevTools)
            if (e.ctrlKey && e.shiftKey && e.key === 'I') {
                e.preventDefault();
                return false;
            }
            // Empêcher Ctrl+Shift+J (Console)
            if (e.ctrlKey && e.shiftKey && e.key === 'J') {
                e.preventDefault();
                return false;
            }
            // Empêcher Ctrl+Shift+C (Inspect Element)
            if (e.ctrlKey && e.shiftKey && e.key === 'C') {
                e.preventDefault();
                return false;
            }
            // Empêcher Ctrl+U (View Source)
            if (e.ctrlKey && e.key === 'U') {
                e.preventDefault();
                return false;
            }
            // Empêcher Ctrl+S (Save Page)
            if (e.ctrlKey && e.key === 'S') {
                e.preventDefault();
                return false;
            }
            // Empêcher Ctrl+P (Print)
            if (e.ctrlKey && e.key === 'P') {
                e.preventDefault();
                return false;
            }
        });

        // Empêcher le clic droit
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // Empêcher le copier-coller (sauf dans les champs de texte)
        document.addEventListener('copy', function(e) {
            const target = e.target;
            if (target.tagName !== 'TEXTAREA' && target.tagName !== 'INPUT' && target.getAttribute('contenteditable') !== 'true') {
                e.preventDefault();
                return false;
            }
        });

        document.addEventListener('cut', function(e) {
            const target = e.target;
            if (target.tagName !== 'TEXTAREA' && target.tagName !== 'INPUT' && target.getAttribute('contenteditable') !== 'true') {
                e.preventDefault();
                return false;
            }
        });

        document.addEventListener('paste', function(e) {
            const target = e.target;
            if (target.tagName !== 'TEXTAREA' && target.tagName !== 'INPUT' && target.getAttribute('contenteditable') !== 'true') {
                e.preventDefault();
                return false;
            }
        });

        // Empêcher le drag and drop
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });

        // Mode plein écran automatique - FORCÉ
        let fullscreenActivated = false;
        let fullscreenPromptShown = false;
        let securityOverlayShown = false;
        
        function enterFullscreen() {
            const elem = document.documentElement;
            const promptDiv = document.getElementById('fullscreenPrompt');
            const securityOverlay = document.getElementById('securityOverlay');
            
            try {
                // Utiliser l'API Fullscreen avec navigationUI: "hide" pour masquer tous les éléments de l'interface
                // Cela masque les boutons de la fenêtre (Windows/Mac) et la barre d'adresse
                if (elem.requestFullscreen) {
                    // Essayer avec navigationUI: "hide" pour masquer complètement l'interface
                    const options = { navigationUI: "hide" };
                    elem.requestFullscreen(options).then(() => {
                        fullscreenActivated = true;
                        if (promptDiv) promptDiv.style.display = 'none';
                        if (securityOverlay) securityOverlay.style.display = 'none';
                        // Forcer le masquage des boutons de la fenêtre
                        document.body.style.overflow = 'hidden';
                    }).catch(() => {
                        // Si navigationUI n'est pas supporté, essayer sans option
                        elem.requestFullscreen().then(() => {
                            fullscreenActivated = true;
                            if (promptDiv) promptDiv.style.display = 'none';
                            if (securityOverlay) securityOverlay.style.display = 'none';
                            document.body.style.overflow = 'hidden';
                        }).catch(err => {
                            if (!fullscreenPromptShown && promptDiv) {
                                promptDiv.style.display = 'block';
                                fullscreenPromptShown = true;
                            }
                            if (!securityOverlayShown && securityOverlay) {
                                securityOverlay.style.display = 'flex';
                                securityOverlayShown = true;
                            }
                        });
                    });
                } else if (elem.webkitRequestFullscreen) {
                    // Safari/WebKit
                    elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                    fullscreenActivated = true;
                    if (promptDiv) promptDiv.style.display = 'none';
                    if (securityOverlay) securityOverlay.style.display = 'none';
                    document.body.style.overflow = 'hidden';
                } else if (elem.webkitRequestFullScreen) {
                    // Ancienne version WebKit
                    elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                    fullscreenActivated = true;
                    if (promptDiv) promptDiv.style.display = 'none';
                    if (securityOverlay) securityOverlay.style.display = 'none';
                    document.body.style.overflow = 'hidden';
                } else if (elem.mozRequestFullScreen) {
                    // Firefox
                    elem.mozRequestFullScreen();
                    fullscreenActivated = true;
                    if (promptDiv) promptDiv.style.display = 'none';
                    if (securityOverlay) securityOverlay.style.display = 'none';
                    document.body.style.overflow = 'hidden';
                } else if (elem.msRequestFullscreen) {
                    // IE/Edge
                    elem.msRequestFullscreen();
                    fullscreenActivated = true;
                    if (promptDiv) promptDiv.style.display = 'none';
                    if (securityOverlay) securityOverlay.style.display = 'none';
                    document.body.style.overflow = 'hidden';
                }
            } catch (err) {
                if (!fullscreenPromptShown && promptDiv) {
                    promptDiv.style.display = 'block';
                    fullscreenPromptShown = true;
                }
                if (!securityOverlayShown && securityOverlay) {
                    securityOverlay.style.display = 'flex';
                    securityOverlayShown = true;
                }
            }
        }

        // Fonction pour forcer le plein écran (appelée depuis le bouton)
        function forceFullscreen() {
            enterFullscreen();
            // Réessayer après un court délai
            setTimeout(function() {
                if (!fullscreenActivated) {
                    enterFullscreen();
                }
            }, 200);
        }

        // Vérifier si on est déjà en plein écran
        function checkIfFullscreen() {
            const isFullscreen = document.fullscreenElement || 
                                document.webkitFullscreenElement || 
                                document.mozFullScreenElement || 
                                document.msFullscreenElement;
            
            if (isFullscreen) {
                fullscreenActivated = true;
                const promptDiv = document.getElementById('fullscreenPrompt');
                if (promptDiv) promptDiv.style.display = 'none';
            }
        }

        // FORCER l'activation du plein écran - SÉCURITÉ MAXIMALE
        // Vérifier immédiatement et afficher l'overlay si nécessaire
        (function() {
            checkIfFullscreen();
            if (!fullscreenActivated) {
                enterFullscreen();
                // Si après 1 seconde on n'est toujours pas en plein écran, afficher l'overlay
                setTimeout(function() {
                    const isFullscreen = document.fullscreenElement || 
                                        document.webkitFullscreenElement || 
                                        document.mozFullScreenElement || 
                                        document.msFullscreenElement;
                    
                    if (!isFullscreen) {
                        const securityOverlay = document.getElementById('securityOverlay');
                        const mainContainer = document.getElementById('mainContainer');
                        if (securityOverlay) {
                            securityOverlay.style.display = 'flex';
                            securityOverlayShown = true;
                        }
                        if (mainContainer) {
                            mainContainer.style.pointerEvents = 'none';
                            mainContainer.style.opacity = '0.3';
                        }
                    }
                }, 1000);
            }
        })();

        // Activer le plein écran automatiquement dès le chargement du DOM
        // Gérer le floutage du contenu quand le modal est affiché
        function updateModalBlur() {
            const unlockModal = document.getElementById('unlockModal');
            const mainContainer = document.getElementById('mainContainer');
            
            if (unlockModal && mainContainer) {
                if (unlockModal.classList.contains('hidden')) {
                    // Modal masqué - retirer le floutage
                    document.body.classList.remove('unlock-modal-active');
                } else {
                    // Modal affiché - appliquer le floutage
                    document.body.classList.add('unlock-modal-active');
                }
            }
        }
        
        // Observer les changements du modal
        const unlockModalObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    updateModalBlur();
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser le floutage du modal
            const unlockModal = document.getElementById('unlockModal');
            if (unlockModal) {
                updateModalBlur();
                // Observer les changements de classe du modal
                unlockModalObserver.observe(unlockModal, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            }
            
            checkIfFullscreen();
            // Essayer immédiatement
            if (!fullscreenActivated) {
                enterFullscreen();
            }
            // Réessayer plusieurs fois avec des délais courts
            setTimeout(function() {
                if (!fullscreenActivated) {
                    enterFullscreen();
                }
            }, 100);
            setTimeout(function() {
                if (!fullscreenActivated) {
                    enterFullscreen();
                }
            }, 300);
            setTimeout(function() {
                if (!fullscreenActivated) {
                    enterFullscreen();
                }
            }, 500);
        });

        // Essayer aussi au chargement complet de la page
        window.addEventListener('load', function() {
            checkIfFullscreen();
            setTimeout(function() {
                if (!fullscreenActivated) {
                    enterFullscreen();
                }
            }, 100);
            setTimeout(function() {
                if (!fullscreenActivated) {
                    enterFullscreen();
                }
            }, 300);
        });

        // Activer le plein écran après le premier clic n'importe où sur la page (fallback)
        document.addEventListener('click', function(e) {
            // Ne pas empêcher les clics normaux, juste activer le plein écran si pas encore fait
            if (!fullscreenActivated) {
                enterFullscreen();
            }
        }, { once: true });
        
        // Activer aussi au focus de la fenêtre
        window.addEventListener('focus', function() {
            if (fullscreenActivated) {
                setTimeout(checkFullscreen, 100);
            } else {
                checkIfFullscreen();
                if (!fullscreenActivated) {
                    enterFullscreen();
                }
            }
        });
        
        // Activer au premier mouvement de souris (fallback supplémentaire)
        document.addEventListener('mousemove', function() {
            if (!fullscreenActivated) {
                enterFullscreen();
            }
        }, { once: true });

        // Activer au premier touch (pour mobile)
        document.addEventListener('touchstart', function() {
            if (!fullscreenActivated) {
                enterFullscreen();
            }
        }, { once: true });

        // Activer au premier scroll
        document.addEventListener('scroll', function() {
            if (!fullscreenActivated) {
                enterFullscreen();
            }
        }, { once: true });

        // Activer au premier keypress
        document.addEventListener('keydown', function() {
            if (!fullscreenActivated) {
                enterFullscreen();
            }
        }, { once: true });

        // Vérifier et forcer le mode plein écran
        let isCheckingFullscreen = false;
        function checkFullscreen() {
            if (isCheckingFullscreen) return;
            
            const isFullscreen = document.fullscreenElement || 
                                document.webkitFullscreenElement || 
                                document.mozFullScreenElement || 
                                document.msFullscreenElement;
            
            if (!isFullscreen) {
                // Si on n'est pas en plein écran, essayer de l'activer
                if (!fullscreenActivated) {
                    enterFullscreen();
                } else {
                    // Si on était en plein écran mais qu'on en est sorti, réactiver
                    isCheckingFullscreen = true;
                    setTimeout(() => {
                        enterFullscreen();
                        isCheckingFullscreen = false;
                    }, 300);
                }
            } else {
                // On est en plein écran, mettre à jour le flag
                fullscreenActivated = true;
            }
        }

        // Empêcher la sortie du mode plein écran
        document.addEventListener('fullscreenchange', function() {
            const isFullscreen = !!document.fullscreenElement;
            if (isFullscreen) {
                // Forcer le masquage des boutons de la fenêtre en mode plein écran
                document.body.style.overflow = 'hidden';
                fullscreenActivated = true;
            } else {
                // L'utilisateur a quitté le mode plein écran - verrouiller l'interface
                if (fullscreenActivated) {
                    lockInterface('Sortie du mode plein écran détectée. Vous risquez d\'être suspendu. L\'interface a été verrouillée pour des raisons de sécurité.');
                }
            }
            setTimeout(checkFullscreen, 100);
        });

        document.addEventListener('webkitfullscreenchange', function() {
            const isFullscreen = !!document.webkitFullscreenElement;
            if (isFullscreen) {
                document.body.style.overflow = 'hidden';
                fullscreenActivated = true;
            } else {
                // L'utilisateur a quitté le mode plein écran - verrouiller l'interface
                if (fullscreenActivated) {
                    lockInterface('Sortie du mode plein écran détectée. Vous risquez d\'être suspendu. L\'interface a été verrouillée pour des raisons de sécurité.');
                }
            }
            setTimeout(checkFullscreen, 100);
        });

        document.addEventListener('mozfullscreenchange', function() {
            const isFullscreen = !!document.mozFullScreenElement;
            if (isFullscreen) {
                document.body.style.overflow = 'hidden';
                fullscreenActivated = true;
            } else {
                // L'utilisateur a quitté le mode plein écran - verrouiller l'interface
                if (fullscreenActivated) {
                    lockInterface('Sortie du mode plein écran détectée. Vous risquez d\'être suspendu. L\'interface a été verrouillée pour des raisons de sécurité.');
                }
            }
            setTimeout(checkFullscreen, 100);
        });

        document.addEventListener('msfullscreenchange', function() {
            const isFullscreen = !!document.msFullscreenElement;
            if (isFullscreen) {
                document.body.style.overflow = 'hidden';
                fullscreenActivated = true;
            } else {
                // L'utilisateur a quitté le mode plein écran - verrouiller l'interface
                if (fullscreenActivated) {
                    lockInterface('Sortie du mode plein écran détectée. Vous risquez d\'être suspendu. L\'interface a été verrouillée pour des raisons de sécurité.');
                }
            }
            setTimeout(checkFullscreen, 100);
        });

        // Vérifier toutes les secondes si on est toujours en plein écran - SÉCURITÉ CONTINUE
        setInterval(function() {
            checkFullscreen();
            // Si on n'est pas en plein écran, afficher l'overlay de sécurité qui bloque tout
            const isFullscreen = document.fullscreenElement || 
                                document.webkitFullscreenElement || 
                                document.mozFullScreenElement || 
                                document.msFullscreenElement;
            
            if (!isFullscreen) {
                const securityOverlay = document.getElementById('securityOverlay');
                if (securityOverlay) {
                    securityOverlay.style.display = 'flex';
                    securityOverlayShown = true;
                    // Bloquer l'interface principale
                    const mainContainer = document.getElementById('mainContainer');
                    if (mainContainer) {
                        mainContainer.style.pointerEvents = 'none';
                        mainContainer.style.opacity = '0.3';
                    }
                }
            } else {
                // Si on est en plein écran, masquer l'overlay et réactiver l'interface
                const securityOverlay = document.getElementById('securityOverlay');
                if (securityOverlay) {
                    securityOverlay.style.display = 'none';
                    securityOverlayShown = false;
                }
                const mainContainer = document.getElementById('mainContainer');
                if (mainContainer) {
                    mainContainer.style.pointerEvents = 'auto';
                    mainContainer.style.opacity = '1';
                }
            }
        }, 500); // Vérifier toutes les 500ms pour une sécurité maximale

        // Empêcher l'inspection d'éléments
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' || 
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
                (e.ctrlKey && e.key === 'U')) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        });

        // Désactiver les raccourcis de navigation
        window.addEventListener('beforeunload', function(e) {
            // Ne pas empêcher la navigation normale, mais on peut ajouter un message si nécessaire
        });

        // Empêcher l'accès à la console
        (function() {
            function disableDevTools() {
                if (typeof window.console !== 'undefined') {
                    if (typeof window.console.clear !== 'undefined') {
                        window.console.clear();
                    }
                }
            }
            setInterval(disableDevTools, 1000);
        })();

        // Sidebar toggle
        // Sidebar toujours visible (bouton Masquer supprimé)
        const quizSidebar = document.getElementById('quizSidebar');

        // Answer selection functions
        function selectAnswer(button, answer, questionId) {
            // Remove selected class from all buttons in the same question
            const questionContainer = button.closest('.mb-8');
            questionContainer.querySelectorAll('.answer-button').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Add selected class to clicked button
            button.classList.add('selected');
            
            // Set hidden input value
            const hiddenInput = document.getElementById('answer_' + questionId);
            if (hiddenInput) {
                hiddenInput.value = answer;
            }
        }

        function selectMultipleAnswer(label, questionId, optionIndex) {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                label.classList.add('border-blue-500', 'bg-blue-50');
            } else {
                label.classList.remove('border-blue-500', 'bg-blue-50');
            }
        }

        // Submit examen
        function submitExamen(event) {
            event.preventDefault();
            
            if (confirm('Êtes-vous sûr de vouloir soumettre votre examen ? Vous ne pourrez plus modifier vos réponses.')) {
                document.getElementById('examenForm').submit();
            }
        }

        // Timer countdown - Basé sur heure_debut et heure_fin
        @php
            $timerSeconds = $tempsRestant ?? 0;
            // S'assurer que c'est un entier sans décimales
            $timerSeconds = (int)round($timerSeconds);
        @endphp
        let timerSeconds = {{ $timerSeconds }};
        const timerElement = document.getElementById('timerDisplay');
        const timerBox = document.getElementById('timerBox');
        
        // Fonction pour formater le temps
        function formatTime(seconds) {
            // S'assurer que seconds est un entier
            seconds = Math.floor(seconds);
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = Math.floor(seconds % 60);
            return String(hours).padStart(2, '0') + ' : ' + 
                   String(minutes).padStart(2, '0') + ' : ' + 
                   String(secs).padStart(2, '0');
        }
        
        // Afficher le temps initial
        if (timerElement) {
            timerElement.textContent = formatTime(timerSeconds);
        }
        
        // Déclarer les intervalles
        let timerInterval;
        let serverCheckInterval;
        
        // Vérifier périodiquement le temps côté serveur (toutes les 5 secondes)
        serverCheckInterval = setInterval(() => {
            fetch('{{ route("apprenant.examen.check-time", $examen->id) }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.temps_ecoule) {
                    // Le temps est écoulé côté serveur
                    clearInterval(serverCheckInterval);
                    clearInterval(timerInterval);
                    
                    // Afficher le temps final
                    if (timerElement) {
                        timerElement.textContent = formatTime(0);
                    }
                    
                    // Changer la couleur en rouge
                    if (timerBox) {
                        timerBox.classList.add('warning');
                    }
                    
                    // Soumettre automatiquement l'examen
                    alert('Le temps est écoulé ! L\'examen sera soumis automatiquement.');
                    document.getElementById('examenForm').submit();
                } else if (data.temps_restant !== undefined) {
                    // Mettre à jour le temps restant depuis le serveur
                    timerSeconds = data.temps_restant;
                    if (timerElement) {
                        timerElement.textContent = formatTime(timerSeconds);
                    }
                    
                    // Avertissement quand il reste moins de 5 minutes
                    if (timerSeconds <= 300 && timerSeconds > 0) {
                        if (timerBox && !timerBox.classList.contains('warning')) {
                            timerBox.classList.add('warning');
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Erreur lors de la vérification du temps:', error);
            });
        }, 5000); // Vérifier toutes les 5 secondes
        
        // Timer local pour l'affichage (se met à jour toutes les secondes)
        timerInterval = setInterval(() => {
            timerSeconds--;
            if (timerSeconds <= 0) {
                timerSeconds = 0;
                clearInterval(timerInterval);
                clearInterval(serverCheckInterval);
                
                // Afficher le temps final
                if (timerElement) {
                    timerElement.textContent = formatTime(0);
                }
                
                // Changer la couleur en rouge
                if (timerBox) {
                    timerBox.classList.add('warning');
                }
                
                // Vérifier une dernière fois côté serveur avant de soumettre
                fetch('{{ route("apprenant.examen.check-time", $examen->id) }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.temps_ecoule) {
                        alert('Le temps est écoulé ! L\'examen sera soumis automatiquement.');
                        document.getElementById('examenForm').submit();
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la vérification finale:', error);
                    // Soumettre quand même si erreur
                    alert('Le temps est écoulé ! L\'examen sera soumis automatiquement.');
                    document.getElementById('examenForm').submit();
                });
            } else {
                if (timerElement) {
                    timerElement.textContent = formatTime(timerSeconds);
                }
                
                // Avertissement quand il reste moins de 5 minutes
                if (timerSeconds <= 300 && timerSeconds > 0) {
                    if (timerBox && !timerBox.classList.contains('warning')) {
                        timerBox.classList.add('warning');
                    }
                }
            }
        }, 1000);

        // Fonction pour verrouiller l'interface (redemander le code)
        function lockInterface(reason = '') {
            const unlockModal = document.getElementById('unlockModal');
            const mainContainer = document.getElementById('mainContainer');
            const topBar = document.getElementById('topBar');
            const quizSidebar = document.getElementById('quizSidebar');
            const unlockCode = document.getElementById('unlockCode');
            const unlockMessageReason = document.getElementById('unlockMessageReason');
            
            if (unlockModal) {
                unlockModal.classList.remove('hidden');
            }
            if (mainContainer) {
                mainContainer.classList.add('locked-interface');
            }
            if (topBar) {
                topBar.style.display = 'none';
            }
            if (quizSidebar) {
                quizSidebar.style.display = 'none';
            }
            if (unlockCode) {
                // Vider complètement le champ et forcer la réinitialisation
                unlockCode.value = '';
                unlockCode.type = 'text'; // Forcer la réinitialisation
                unlockCode.type = 'text'; // Double pour s'assurer
                // Attendre un peu et revider au cas où le navigateur aurait restauré la valeur
                setTimeout(function() {
                    if (unlockCode) {
                        unlockCode.value = '';
                    }
                }, 50);
            }
            if (unlockMessageReason) {
                if (reason) {
                    unlockMessageReason.innerHTML = '<span class="text-red-600 font-semibold">⚠️ ' + reason + '</span><br><br>Pour déverrouiller l\'interface, veuillez entrer le code de sécurité fourni par votre professeur.';
                } else {
                    unlockMessageReason.textContent = 'Pour déverrouiller l\'interface, veuillez entrer le code de sécurité fourni par votre professeur.';
                }
            }
            updateModalBlur();
        }

        // Fonction de déverrouillage
        function unlockInterface() {
            const code = document.getElementById('unlockCode').value.trim();
            const messageDiv = document.getElementById('unlockMessage');
            
            if (!code || code.length !== 6) {
                messageDiv.innerHTML = '<p class="text-red-600">Veuillez entrer un code à 6 chiffres.</p>';
                return;
            }
            
            fetch('{{ route("apprenant.examen.unlock", $examen->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Masquer le modal
                    const unlockModal = document.getElementById('unlockModal');
                    if (unlockModal) {
                        unlockModal.classList.add('hidden');
                    }
                    // Retirer le floutage
                    updateModalBlur();
                    // Déverrouiller l'interface
                    document.getElementById('mainContainer').classList.remove('locked-interface');
                    // Afficher la barre supérieure
                    document.getElementById('topBar').style.display = 'flex';
                    // Afficher le sidebar
                    document.getElementById('quizSidebar').style.display = 'flex';
                    messageDiv.innerHTML = '';
                } else {
                    messageDiv.innerHTML = '<p class="text-red-600">' + data.message + '</p>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<p class="text-red-600">Erreur lors de la vérification du code.</p>';
            });
        }

        // SÉCURITÉ : Détecter le changement d'onglet ou la perte de focus
        let isPageVisible = true;
        let lastFocusTime = Date.now();

        // Détecter le changement d'onglet (visibilitychange)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // L'utilisateur a changé d'onglet ou minimisé la fenêtre
                isPageVisible = false;
                lockInterface('Changement d\'onglet détecté. L\'interface a été verrouillée pour des raisons de sécurité.');
            } else {
                // L'utilisateur est revenu sur l'onglet
                isPageVisible = true;
                // Vérifier si l'interface était déverrouillée avant
                const unlockModal = document.getElementById('unlockModal');
                if (unlockModal && !unlockModal.classList.contains('hidden')) {
                    // L'interface était déjà verrouillée, ne rien faire
                } else {
                    // L'interface était déverrouillée, la verrouiller maintenant
                    lockInterface('Retour sur l\'onglet détecté. L\'interface a été verrouillée pour des raisons de sécurité.');
                }
            }
        });

        // Détecter la perte de focus de la fenêtre
        window.addEventListener('blur', function() {
            isPageVisible = false;
            lastFocusTime = Date.now();
            // Verrouiller après un court délai pour éviter les faux positifs
            setTimeout(function() {
                if (!isPageVisible) {
                    lockInterface('Perte de focus détectée. L\'interface a été verrouillée pour des raisons de sécurité.');
                }
            }, 100);
        });

        // Détecter le retour du focus
        window.addEventListener('focus', function() {
            const timeSinceBlur = Date.now() - lastFocusTime;
            // Si plus de 500ms se sont écoulées, verrouiller
            if (timeSinceBlur > 500) {
                lockInterface('Retour de focus détecté après une absence. L\'interface a été verrouillée pour des raisons de sécurité.');
            }
            isPageVisible = true;
        });

        // Empêcher les raccourcis clavier pour changer d'onglet (Mac et Windows)
        document.addEventListener('keydown', function(e) {
            // Cmd+Tab (Mac) ou Alt+Tab (Windows) pour changer d'application
            if ((e.metaKey || e.ctrlKey) && e.key === 'Tab') {
                e.preventDefault();
                e.stopPropagation();
                lockInterface('Tentative de changement d\'application détectée. L\'interface a été verrouillée pour des raisons de sécurité.');
                return false;
            }
            // Cmd+` (Mac) pour changer d'onglet dans la même application
            if ((e.metaKey || e.ctrlKey) && e.key === '`') {
                e.preventDefault();
                e.stopPropagation();
                lockInterface('Tentative de changement d\'onglet détectée. L\'interface a été verrouillée pour des raisons de sécurité.');
                return false;
            }
            // Cmd+1, Cmd+2, etc. pour changer d'onglet (Chrome/Firefox)
            if ((e.metaKey || e.ctrlKey) && e.key >= '1' && e.key <= '9') {
                e.preventDefault();
                e.stopPropagation();
                lockInterface('Tentative de changement d\'onglet détectée. L\'interface a été verrouillée pour des raisons de sécurité.');
                return false;
            }
            // Ctrl+Tab pour changer d'onglet
            if (e.ctrlKey && e.key === 'Tab') {
                e.preventDefault();
                e.stopPropagation();
                lockInterface('Tentative de changement d\'onglet détectée. L\'interface a été verrouillée pour des raisons de sécurité.');
                return false;
            }
            // Ctrl+PageUp/PageDown pour changer d'onglet
            if (e.ctrlKey && (e.key === 'PageUp' || e.key === 'PageDown')) {
                e.preventDefault();
                e.stopPropagation();
                lockInterface('Tentative de changement d\'onglet détectée. L\'interface a été verrouillée pour des raisons de sécurité.');
                return false;
            }
        }, true);

        // Empêcher les gestes trackpad macOS (3 doigts pour changer d'onglet)
        // Note: Les gestes trackpad ne peuvent pas être complètement désactivés via JavaScript,
        // mais on peut détecter les changements d'onglet et verrouiller
        let touchStartTime = 0;
        let touchCount = 0;

        document.addEventListener('touchstart', function(e) {
            if (e.touches.length >= 3) {
                touchStartTime = Date.now();
                touchCount = e.touches.length;
            }
        }, { passive: false });

        document.addEventListener('touchend', function(e) {
            if (touchCount >= 3) {
                const touchDuration = Date.now() - touchStartTime;
                // Si un geste à 3 doigts dure plus de 100ms, c'est probablement un changement d'onglet
                if (touchDuration > 100) {
                    setTimeout(function() {
                        lockInterface('Geste trackpad détecté. L\'interface a été verrouillée pour des raisons de sécurité.');
                    }, 200);
                }
                touchCount = 0;
            }
        }, { passive: false });

        // Vérifier périodiquement si la page est toujours visible
        setInterval(function() {
            if (document.hidden) {
                lockInterface('Page masquée détectée. L\'interface a été verrouillée pour des raisons de sécurité.');
            }
        }, 1000);

        // Permettre la soumission avec Enter
        document.getElementById('unlockCode')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                unlockInterface();
            }
        });
    </script>
</body>
</html>

