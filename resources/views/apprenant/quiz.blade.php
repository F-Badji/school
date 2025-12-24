<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - BJ Academie</title>
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
    </style>
</head>
<body>
    @if(isset($remainingAttempts) && $remainingAttempts > 0)
    <!-- Alerte fixe pour les tentatives restantes -->
    <div class="fixed top-0 left-0 right-0 z-50 bg-yellow-500 text-white px-4 py-3 shadow-lg" style="background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-semibold">
                    @if($remainingAttempts == 1)
                        Il vous reste <strong>1 essai</strong> pour ce quiz.
                    @else
                        Il vous reste <strong>{{ $remainingAttempts }} essais</strong> pour ce quiz.
                    @endif
                </p>
            </div>
            <button onclick="this.parentElement.parentElement.style.display='none'" class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif
    <div class="flex h-screen overflow-hidden" style="{{ isset($remainingAttempts) && $remainingAttempts > 0 ? 'margin-top: 60px;' : '' }}">
        <!-- Left Quiz Sidebar -->
        <aside id="quizSidebar" class="quiz-sidebar flex flex-col h-full">
            <!-- Header -->
            <div class="bg-gray-800 text-white p-4">
                <div class="flex items-center justify-between mb-4">
                    <button id="toggleSidebarBtn" class="flex items-center gap-2 text-sm hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span id="toggleSidebarText">Masquer</span>
                    </button>
                </div>
                <div>
                    <h2 class="text-lg font-semibold mb-2">Exercice à faire</h2>
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
                        <a href="{{ route('apprenant.quiz', ['cours_id' => $coursId ?? null, 'section' => $sectionIndex ?? 0, 'q' => $index]) }}" 
                           class="quiz-question-item block {{ $index == ($currentQuestionIndex ?? 0) ? 'active' : '' }} quiz-nav-link" 
                           data-question-index="{{ $index }}"
                           style="text-decoration: none; color: inherit;"
                           onclick="return handleQuizNavigation(event, {{ $index }});">
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
                        </a>
                    @endforeach
                @else
                    <div class="p-4 text-center text-gray-500 text-sm">
                        Aucune question disponible
                    </div>
                @endif
            </div>

            <!-- Timer -->
            <div class="timer-box">
                <div>00 : 59 : 32</div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white px-6 py-3 flex items-center justify-between border-b border-gray-200">
                <div class="flex items-center gap-4">
                    <a href="{{ route('apprenant.cours-editeur', ['cours_id' => $coursId ?? null, 'section' => $sectionIndex ?? 0]) }}" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <h2 class="text-2xl font-bold text-gray-700">
                        @if($section && isset($section['titre']))
                            {{ $section['titre'] }}
                        @else
                            Semaine 1 - Débutant - Introduction à la gestion d'entreprise
                        @endif
                    </h2>
                </div>
                <a href="{{ route('apprenant.cours-editeur', ['cours_id' => $coursId ?? null, 'section' => $sectionIndex ?? 0]) }}" class="px-4 py-2 text-white rounded-lg text-sm font-medium hover:opacity-90" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                    Continuez mon cours
                </a>
            </div>

            <!-- Quiz Content -->
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
                                <!-- Question Header -->
                                <div class="mb-6">
                                    <span class="text-sm text-gray-600">Question {{ $currentQuestionIndex + 1 }} sur {{ $totalQuestions }}</span>
                                </div>

                                <!-- Question -->
                                <div class="mb-6">
                                    <h2 class="text-xl font-semibold text-gray-900 mb-4">
                                        {{ $currentQuestion->question }}
                                    </h2>
                                </div>

                                <!-- Image (if question type is image) -->
                                @if($currentQuestion->type === 'image' && $currentQuestion->image)
                                    <div class="mb-8 flex justify-center">
                                        <img src="{{ asset('storage/' . $currentQuestion->image) }}" alt="Question image" class="max-w-md w-full rounded-lg shadow-md">
                                    </div>
                                @endif

                                <!-- Answer Section based on question type -->
                                <div class="mb-8">
                                    @if($currentQuestion->type === 'vrai_faux')
                                        <div class="flex gap-4">
                                            <button class="answer-button flex-1" onclick="selectAnswer(this, 'true', {{ $currentQuestion->id }})">
                                                VRAI
                                            </button>
                                            <button class="answer-button flex-1" onclick="selectAnswer(this, 'false', {{ $currentQuestion->id }})">
                                                FAUX
                                            </button>
                                        </div>
                                    @elseif($currentQuestion->type === 'choix_multiple')
                                        <div class="space-y-3">
                                            @if($currentQuestion->options && is_array($currentQuestion->options))
                                                @foreach($currentQuestion->options as $optIndex => $option)
                                                    <label class="flex items-center gap-3 p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors answer-option" onclick="selectMultipleAnswer(this, {{ $currentQuestion->id }}, {{ $optIndex }})">
                                                        <input type="checkbox" name="question_{{ $currentQuestion->id }}_option_{{ $optIndex }}" class="w-5 h-5 text-blue-600">
                                                        <span class="flex-1 text-gray-900 font-medium">{{ $option['texte'] ?? '' }}</span>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>
                                    @elseif($currentQuestion->type === 'texte_libre')
                                        <textarea name="question_{{ $currentQuestion->id }}_reponse" rows="5" placeholder="Tapez votre réponse ici..." class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                                    @elseif($currentQuestion->type === 'numerique')
                                        <input type="number" step="any" name="question_{{ $currentQuestion->id }}_reponse" placeholder="Entrez votre réponse numérique" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg text-center">
                                    @endif
                                </div>

                                <!-- Bottom Actions -->
                                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                                    <a href="#" onclick="submitQuizResults(event)" class="px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 inline-block text-center">
                                        Terminer le quiz
                                    </a>
                                    @if(($currentQuestionIndex ?? 0) < $totalQuestions - 1)
                                        <a href="{{ route('apprenant.quiz', ['cours_id' => $coursId ?? null, 'section' => $sectionIndex ?? 0, 'q' => ($currentQuestionIndex ?? 0) + 1]) }}" 
                                           class="px-6 py-3 text-white rounded-lg font-medium hover:opacity-90 quiz-nav-link" 
                                           style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);"
                                           onclick="return handleQuizNavigation(event, {{ ($currentQuestionIndex ?? 0) + 1 }});">
                                            Question suivante
                                        </a>
                                    @else
                                        <a href="#" onclick="submitQuizResults(event)" class="px-6 py-3 text-white rounded-lg font-medium hover:opacity-90" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                            Terminer le quiz
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <p class="text-gray-600">Aucune question disponible.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-600">Aucune question disponible pour ce quiz.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAnswer(button, answer, questionId) {
            // Remove selected class from all buttons in this question
            const questionContainer = button.closest('.border-2');
            questionContainer.querySelectorAll('.answer-button').forEach(btn => {
                btn.classList.remove('selected');
            });
            
            // Add selected class to clicked button
            button.classList.add('selected');
            
            // Store answer (you can save to localStorage or send via AJAX)
            if (typeof(Storage) !== "undefined") {
                let answers = JSON.parse(localStorage.getItem('quiz_answers') || '{}');
                // Convert answer to VRAI/FAUX format
                const formattedAnswer = (answer === 'true' || answer === true) ? 'VRAI' : 'FAUX';
                answers[questionId] = formattedAnswer;
                localStorage.setItem('quiz_answers', JSON.stringify(answers));
            }
        }
        
        function selectMultipleAnswer(label, questionId, optionIndex) {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                label.style.borderColor = '#3b82f6';
                label.style.backgroundColor = '#eff6ff';
            } else {
                label.style.borderColor = '#e5e7eb';
                label.style.backgroundColor = 'transparent';
            }
            
            // Store answer
            if (typeof(Storage) !== "undefined") {
                let answers = JSON.parse(localStorage.getItem('quiz_answers') || '{}');
                if (!answers[questionId]) {
                    answers[questionId] = [];
                }
                if (checkbox.checked) {
                    if (!answers[questionId].includes(optionIndex)) {
                        answers[questionId].push(optionIndex);
                    }
                } else {
                    answers[questionId] = answers[questionId].filter(i => i !== optionIndex);
                }
                localStorage.setItem('quiz_answers', JSON.stringify(answers));
            }
        }
        
        function submitQuizResults(event) {
            event.preventDefault();
            
            // SÉCURITÉ : Empêcher la double soumission
            if (window.quizSubmitted) {
                return false;
            }
            
            // Confirmer la soumission
            if (!confirm('Êtes-vous sûr de vouloir terminer le quiz ? Vous ne pourrez plus y revenir.')) {
                return false;
            }
            
            // Créer un formulaire pour soumettre via POST
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("apprenant.quiz-submit") }}';
            
            // Ajouter le token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Ajouter les paramètres de base
            const coursIdInput = document.createElement('input');
            coursIdInput.type = 'hidden';
            coursIdInput.name = 'cours_id';
            coursIdInput.value = '{{ $coursId ?? "" }}';
            form.appendChild(coursIdInput);
            
            const sectionInput = document.createElement('input');
            sectionInput.type = 'hidden';
            sectionInput.name = 'section';
            sectionInput.value = '{{ $sectionIndex ?? 0 }}';
            form.appendChild(sectionInput);
            
            // Ajouter le token de sécurité et l'ID de tentative
            @if(isset($quizToken) && isset($currentAttempt))
                const quizTokenInput = document.createElement('input');
                quizTokenInput.type = 'hidden';
                quizTokenInput.name = 'quiz_token';
                quizTokenInput.value = '{{ $quizToken }}';
                form.appendChild(quizTokenInput);
                
                const attemptIdInput = document.createElement('input');
                attemptIdInput.type = 'hidden';
                attemptIdInput.name = 'attempt_id';
                attemptIdInput.value = '{{ $currentAttempt->id }}';
                form.appendChild(attemptIdInput);
            @endif
            
            // Collecter toutes les réponses
            @if($questions && $questions->count() > 0)
                @foreach($questions as $q)
                    @if($q->type === 'vrai_faux')
                        // Récupérer depuis localStorage ou les boutons sélectionnés
                        const storedAnswers{{ $q->id }} = JSON.parse(localStorage.getItem('quiz_answers') || '{}');
                        if (storedAnswers{{ $q->id }}[{{ $q->id }}]) {
                            const answerInput{{ $q->id }} = document.createElement('input');
                            answerInput{{ $q->id }}.type = 'hidden';
                            answerInput{{ $q->id }}.name = 'question_{{ $q->id }}_reponse';
                            answerInput{{ $q->id }}.value = storedAnswers{{ $q->id }}[{{ $q->id }}];
                            form.appendChild(answerInput{{ $q->id }});
                        } else {
                            // Chercher dans les boutons sélectionnés
                            const question{{ $q->id }}Buttons = document.querySelectorAll('.answer-button.selected');
                            question{{ $q->id }}Buttons.forEach(btn => {
                                const answer = btn.textContent.trim();
                                if (answer === 'VRAI' || answer === 'FAUX') {
                                    const answerInput{{ $q->id }} = document.createElement('input');
                                    answerInput{{ $q->id }}.type = 'hidden';
                                    answerInput{{ $q->id }}.name = 'question_{{ $q->id }}_reponse';
                                    answerInput{{ $q->id }}.value = answer;
                                    form.appendChild(answerInput{{ $q->id }});
                                }
                            });
                        }
                    @elseif($q->type === 'choix_multiple')
                        const question{{ $q->id }}Checkboxes = document.querySelectorAll('input[name^="question_{{ $q->id }}_option_"]:checked');
                        question{{ $q->id }}Checkboxes.forEach(cb => {
                            const optionInput = document.createElement('input');
                            optionInput.type = 'hidden';
                            optionInput.name = cb.name;
                            optionInput.value = '1';
                            form.appendChild(optionInput);
                        });
                    @elseif($q->type === 'texte_libre' || $q->type === 'numerique')
                        const question{{ $q->id }}Input = document.querySelector('input[name="question_{{ $q->id }}_reponse"], textarea[name="question_{{ $q->id }}_reponse"]');
                        if (question{{ $q->id }}Input && question{{ $q->id }}Input.value) {
                            const answerInput{{ $q->id }} = document.createElement('input');
                            answerInput{{ $q->id }}.type = 'hidden';
                            answerInput{{ $q->id }}.name = 'question_{{ $q->id }}_reponse';
                            answerInput{{ $q->id }}.value = question{{ $q->id }}Input.value;
                            form.appendChild(answerInput{{ $q->id }});
                        }
                    @endif
                @endforeach
            @endif
            
            // Marquer comme soumis, verrouillé et expiré pour empêcher la double soumission
            window.quizSubmitted = true;
            const expirationTimestamp = Date.now(); // Timestamp d'expiration
            sessionStorage.setItem('quiz_submitted', 'true');
            sessionStorage.setItem('quiz_locked', 'true');
            sessionStorage.setItem('quiz_expired', expirationTimestamp.toString());
            sessionStorage.setItem('quiz_submitted_cours_id', '{{ $coursId ?? "" }}');
            sessionStorage.setItem('quiz_submitted_section', '{{ $sectionIndex ?? 0 }}');
            
            // Marquer l'interface comme expirée immédiatement
            document.body.classList.add('quiz-expired');
            document.body.style.pointerEvents = 'none';
            document.body.style.opacity = '0.7';
            
            // Désactiver tous les boutons de soumission
            document.querySelectorAll('a[onclick*="submitQuizResults"]').forEach(btn => {
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.5';
                btn.style.cursor = 'not-allowed';
                btn.onclick = function(e) {
                    e.preventDefault();
                    alert('Le quiz est verrouillé. Vous ne pouvez plus le terminer.');
                    return false;
                };
            });
            
            // Soumettre le formulaire
            document.body.appendChild(form);
            form.submit();
        }
        
        // SÉCURITÉ : Vérifier au chargement de la page si le quiz a déjà été soumis ou expiré
        window.addEventListener('load', function() {
            const quizSubmitted = sessionStorage.getItem('quiz_submitted');
            const submittedCoursId = sessionStorage.getItem('quiz_submitted_cours_id');
            const submittedSection = sessionStorage.getItem('quiz_submitted_section');
            const quizLocked = sessionStorage.getItem('quiz_locked');
            const quizExpired = sessionStorage.getItem('quiz_expired');
            
            // Vérifier si le quiz est verrouillé ou expiré (sauf si c'est une reprise explicite)
            const urlParams = new URLSearchParams(window.location.search);
            const isRetry = urlParams.get('retry') === 'true';
            
            // Vérifier si l'interface est expirée
            if (quizExpired) {
                const expiredTimestamp = parseInt(quizExpired);
                const currentTime = Date.now();
                // L'interface est expirée si elle a été soumise (timestamp existe)
                if (expiredTimestamp && 
                    submittedCoursId === '{{ $coursId ?? "" }}' && 
                    submittedSection === '{{ $sectionIndex ?? 0 }}' &&
                    !isRetry) {
                    // L'interface est expirée, rediriger vers les résultats
                    window.location.href = '{{ route("apprenant.quiz-results", ["cours_id" => $coursId ?? null, "section" => $sectionIndex ?? 0]) }}';
                    return;
                }
            }
            
            if ((quizSubmitted === 'true' || quizLocked === 'true') && 
                submittedCoursId === '{{ $coursId ?? "" }}' && 
                submittedSection === '{{ $sectionIndex ?? 0 }}' &&
                !isRetry) {
                // Le quiz a été soumis et est verrouillé, rediriger vers les résultats
                window.location.href = '{{ route("apprenant.quiz-results", ["cours_id" => $coursId ?? null, "section" => $sectionIndex ?? 0]) }}';
            } else if (isRetry) {
                // Si c'est une reprise, déverrouiller le quiz et réinitialiser l'expiration
                sessionStorage.removeItem('quiz_submitted');
                sessionStorage.removeItem('quiz_locked');
                sessionStorage.removeItem('quiz_expired');
                window.quizSubmitted = false;
                document.body.classList.remove('quiz-expired');
                document.body.style.pointerEvents = 'auto';
                document.body.style.opacity = '1';
            }
        });
        
        // SÉCURITÉ : Vérifier si le quiz est verrouillé ou expiré et désactiver l'interface
        (function() {
            const urlParams = new URLSearchParams(window.location.search);
            const isRetry = urlParams.get('retry') === 'true';
            const quizLocked = sessionStorage.getItem('quiz_locked');
            const quizExpired = sessionStorage.getItem('quiz_expired');
            
            // Si le quiz est verrouillé ou expiré et ce n'est pas une reprise, désactiver l'interface
            if ((quizLocked === 'true' || quizExpired) && !isRetry) {
                // Désactiver toute l'interface
                document.body.classList.add('quiz-expired');
                document.body.style.pointerEvents = 'none';
                document.body.style.opacity = '0.7';
                
                // Afficher un message d'expiration
                const expiredMessage = document.createElement('div');
                expiredMessage.id = 'quiz-expired-message';
                expiredMessage.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 10000; text-align: center; max-width: 500px;';
                expiredMessage.innerHTML = `
                    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 15px; color: #1a1f3a;">Interface expirée</h2>
                    <p style="margin-bottom: 20px; color: #666;">L'interface du quiz a expiré après la soumission.</p>
                    <a href="{{ route('apprenant.quiz-results', ['cours_id' => $coursId ?? null, 'section' => $sectionIndex ?? 0]) }}" 
                       style="display: inline-block; padding: 10px 20px; background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">
                        Voir les résultats
                    </a>
                `;
                document.body.appendChild(expiredMessage);
                
                // Désactiver tous les boutons de soumission
                const submitButtons = document.querySelectorAll('a[onclick*="submitQuizResults"]');
                submitButtons.forEach(btn => {
                    btn.style.pointerEvents = 'none';
                    btn.style.opacity = '0.5';
                    btn.style.cursor = 'not-allowed';
                    btn.onclick = function(e) {
                        e.preventDefault();
                        alert('L\'interface du quiz a expiré. Cliquez sur "Reprendre le quiz" dans la page des résultats pour continuer.');
                        return false;
                    };
                });
            }
        })();

        // Toggle sidebar
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const quizSidebar = document.getElementById('quizSidebar');
        const toggleSidebarText = document.getElementById('toggleSidebarText');
        
        toggleSidebarBtn.addEventListener('click', function() {
            quizSidebar.classList.toggle('closed');
            if (quizSidebar.classList.contains('closed')) {
                toggleSidebarText.textContent = 'Afficher';
            } else {
                toggleSidebarText.textContent = 'Masquer';
            }
        });

        // Timer countdown - Utiliser la durée définie par le professeur
        @php
            // Récupérer les heures et minutes séparément
            $dureeQuizHeures = isset($section['duree_quiz_heures']) && !empty($section['duree_quiz_heures']) ? (int)$section['duree_quiz_heures'] : 0;
            $dureeQuizMinutes = isset($section['duree_quiz_minutes']) && !empty($section['duree_quiz_minutes']) ? (int)$section['duree_quiz_minutes'] : 0;
            
            // Si l'ancien format existe (duree_quiz en minutes), le convertir
            if ($dureeQuizHeures == 0 && $dureeQuizMinutes == 0 && isset($section['duree_quiz']) && !empty($section['duree_quiz'])) {
                $totalMinutes = (int)$section['duree_quiz'];
                $dureeQuizHeures = floor($totalMinutes / 60);
                $dureeQuizMinutes = $totalMinutes % 60;
            }
            
            // Si aucune durée n'est définie, utiliser 1 heure par défaut
            if ($dureeQuizHeures == 0 && $dureeQuizMinutes == 0) {
                $dureeQuizHeures = 1;
                $dureeQuizMinutes = 0;
            }
            
            $timerSeconds = ($dureeQuizHeures * 3600) + ($dureeQuizMinutes * 60);
        @endphp
        let timerSeconds = {{ $timerSeconds }}; // Durée en secondes depuis la base de données
        const timerElement = document.querySelector('.timer-box div');
        
        // Fonction pour formater le temps
        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return String(hours).padStart(2, '0') + ' : ' + 
                   String(minutes).padStart(2, '0') + ' : ' + 
                   String(secs).padStart(2, '0');
        }
        
        // Afficher le temps initial
        if (timerElement) {
            timerElement.textContent = formatTime(timerSeconds);
        }
        
        const timerInterval = setInterval(() => {
            timerSeconds--;
            if (timerSeconds <= 0) {
                timerSeconds = 0;
                clearInterval(timerInterval);
                
                // Afficher le temps final
                if (timerElement) {
                    timerElement.textContent = formatTime(0);
                }
                
                // Soumettre automatiquement le quiz quand le temps est écoulé
                alert('Le temps est écoulé ! Le quiz sera soumis automatiquement.');
                
                // Créer un événement factice pour submitQuizResults
                const fakeEvent = {
                    preventDefault: function() {}
                };
                
                // Soumettre le quiz automatiquement
                submitQuizResults(fakeEvent);
            } else {
                if (timerElement) {
                    timerElement.textContent = formatTime(timerSeconds);
                }
            }
        }, 1000);
        
        // SÉCURITÉ : Empêcher le retour en arrière pendant le quiz
        (function() {
            // Remplacer l'état de l'historique pour empêcher le retour
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
            
            // Ajouter un état à l'historique pour bloquer le retour
                window.history.pushState(null, null, window.location.href);
            
            // Empêcher aussi les gestes de navigation (Mac trackpad, iPhone, etc.)
            let touchStartX = 0;
            let touchStartY = 0;
            let touchCount = 0;
            
            document.addEventListener('touchstart', function(e) {
                touchCount = e.touches.length;
                if (e.touches.length > 0) {
                    touchStartX = e.touches[0].clientX;
                    touchStartY = e.touches[0].clientY;
                }
                
                // Détecter les gestes multi-touch (3 doigts ou plus sur Mac trackpad) et les empêcher
                if (e.touches.length >= 3) {
                    e.preventDefault();
                    e.stopPropagation();
                    alert('Les gestes de navigation sont désactivés pendant le quiz.');
                }
            }, { passive: false });
            
            document.addEventListener('touchmove', function(e) {
                // Empêcher les gestes multi-touch
                if (e.touches.length >= 3) {
                    e.preventDefault();
                    e.stopPropagation();
                } else if (e.touches.length === 1) {
                    const touchEndX = e.touches[0].clientX;
                    const touchEndY = e.touches[0].clientY;
                    const deltaX = touchEndX - touchStartX;
                    const deltaY = touchEndY - touchStartY;
                    
                    // Empêcher les gestes de balayage horizontal (swipe left/right) qui peuvent déclencher la navigation
                    if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }
            }, { passive: false });
            
            // Empêcher les gestes de trackpad Mac (wheel events avec ctrl/meta)
            document.addEventListener('wheel', function(e) {
                // Détecter les gestes de pincement (pinch) avec Ctrl/Cmd
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, { passive: false });
            
            // SÉCURITÉ : Détecter les gestes de trackpad Mac spécifiques (trois doigts)
            // Les navigateurs modernes peuvent détecter ces gestes via des événements spéciaux
            let gestureStartTime = 0;
            document.addEventListener('gesturestart', function(e) {
                e.preventDefault();
                e.stopPropagation();
                gestureStartTime = Date.now();
            }, { passive: false });
            
            document.addEventListener('gesturechange', function(e) {
                e.preventDefault();
                e.stopPropagation();
            }, { passive: false });
            
            document.addEventListener('gestureend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (Date.now() - gestureStartTime < 500) {
                    alert('Les gestes de navigation sont désactivés pendant le quiz.');
                }
            }, { passive: false });
            
            // Empêcher les raccourcis clavier de navigation
            document.addEventListener('keydown', function(e) {
                // Empêcher Alt+Left (retour), Cmd+Left (Mac), etc.
                if ((e.altKey || e.metaKey) && (e.key === 'ArrowLeft' || e.keyCode === 37)) {
                    e.preventDefault();
                    alert('Vous ne pouvez pas revenir en arrière pendant le quiz.');
                }
                // Empêcher F5 et Ctrl+R (rechargement)
                if (e.key === 'F5' || (e.ctrlKey && e.key === 'r') || (e.ctrlKey && e.key === 'R')) {
                    e.preventDefault();
                    alert('Vous ne pouvez pas recharger la page pendant le quiz.');
                }
                // Empêcher Ctrl+W (fermer l'onglet)
                if (e.ctrlKey && e.key === 'w') {
                    e.preventDefault();
                    alert('Vous ne pouvez pas fermer l\'onglet pendant le quiz.');
                }
                // Empêcher les raccourcis de développement (F12, Ctrl+Shift+I, etc.)
                if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'i'))) {
                    e.preventDefault();
                }
            });
            
            // Empêcher le rechargement via le menu contextuel
            window.addEventListener('beforeunload', function(e) {
                // Ne pas empêcher complètement (peut être gênant), mais ajouter un avertissement
                if (!window.quizSubmitted) {
                    e.preventDefault();
                    e.returnValue = 'Vous êtes en train de passer un quiz. Êtes-vous sûr de vouloir quitter ?';
                    return e.returnValue;
                }
            });
        })();
        
        // SÉCURITÉ : Empêcher l'accès via l'historique du navigateur après soumission
        window.addEventListener('pageshow', function(event) {
            // Si la page est chargée depuis le cache (retour en arrière)
            if (event.persisted) {
                // Vérifier si le quiz a été soumis
                if (window.quizSubmitted || sessionStorage.getItem('quiz_submitted')) {
                    // Rediriger vers les résultats
                    window.location.href = '{{ route("apprenant.quiz-results", ["cours_id" => $coursId ?? null, "section" => $sectionIndex ?? 0]) }}';
                }
            }
        });
        
        // SÉCURITÉ : Empêcher la copie de l'URL et l'accès direct
        // Détecter si l'utilisateur essaie de copier l'URL
        document.addEventListener('copy', function(e) {
            // Ne pas empêcher complètement, mais ajouter un avertissement
            console.warn('La copie de l\'URL du quiz est surveillée.');
        });
        
        // SÉCURITÉ : Désactiver le clic droit pour empêcher certaines actions
        document.addEventListener('contextmenu', function(e) {
            // Ne pas empêcher complètement (peut être gênant), mais logger
            console.warn('Clic droit détecté sur la page du quiz.');
        });
        
        // SÉCURITÉ : Fonction pour gérer la navigation dans le quiz
        function handleQuizNavigation(event, questionIndex) {
            // Vérifier si le quiz a été soumis
            if (window.quizSubmitted || sessionStorage.getItem('quiz_submitted')) {
                event.preventDefault();
                alert('Vous ne pouvez plus modifier vos réponses. Le quiz a été soumis.');
                return false;
            }
            return true;
        }
        
        // SÉCURITÉ : Empêcher la navigation via les liens de la sidebar après soumission
        const quizLinks = document.querySelectorAll('.quiz-nav-link');
        quizLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.quizSubmitted || sessionStorage.getItem('quiz_submitted')) {
                    e.preventDefault();
                    e.stopPropagation();
                    alert('Vous ne pouvez plus modifier vos réponses. Le quiz a été soumis.');
                    return false;
                }
            });
        });
        
        // SÉCURITÉ : Empêcher la navigation via l'historique du navigateur
        window.addEventListener('popstate', function(event) {
            const quizLocked = sessionStorage.getItem('quiz_locked');
            const quizSubmitted = sessionStorage.getItem('quiz_submitted');
            const quizExpired = sessionStorage.getItem('quiz_expired');
            
            if (window.quizSubmitted || quizSubmitted === 'true' || quizLocked === 'true' || quizExpired) {
                // Rediriger vers les résultats si le quiz a été soumis, verrouillé ou expiré
                window.location.href = '{{ route("apprenant.quiz-results", ["cours_id" => $coursId ?? null, "section" => $sectionIndex ?? 0]) }}';
            } else {
                // Empêcher le retour en arrière pendant le quiz
                window.history.pushState(null, null, window.location.href);
                alert('Vous ne pouvez pas revenir en arrière pendant le quiz.');
            }
        });
        
        // SÉCURITÉ : Vérifier périodiquement si le quiz est verrouillé ou expiré (pour empêcher le contournement)
        setInterval(function() {
            const quizLocked = sessionStorage.getItem('quiz_locked');
            const quizExpired = sessionStorage.getItem('quiz_expired');
            const urlParams = new URLSearchParams(window.location.search);
            const isRetry = urlParams.get('retry') === 'true';
            
            // Si l'interface est expirée ou verrouillée et ce n'est pas une reprise
            if ((quizLocked === 'true' || quizExpired) && !isRetry) {
                // Désactiver toute l'interface si ce n'est pas déjà fait
                if (!document.body.classList.contains('quiz-expired')) {
                    document.body.classList.add('quiz-expired');
                    document.body.style.pointerEvents = 'none';
                    document.body.style.opacity = '0.7';
                    
                    // Afficher le message d'expiration si ce n'est pas déjà affiché
                    if (!document.getElementById('quiz-expired-message')) {
                        const expiredMessage = document.createElement('div');
                        expiredMessage.id = 'quiz-expired-message';
                        expiredMessage.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 10000; text-align: center; max-width: 500px;';
                        expiredMessage.innerHTML = `
                            <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 15px; color: #1a1f3a;">Interface expirée</h2>
                            <p style="margin-bottom: 20px; color: #666;">L'interface du quiz a expiré après la soumission.</p>
                            <a href="{{ route('apprenant.quiz-results', ['cours_id' => $coursId ?? null, 'section' => $sectionIndex ?? 0]) }}" 
                               style="display: inline-block; padding: 10px 20px; background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">
                                Voir les résultats
                            </a>
                        `;
                        document.body.appendChild(expiredMessage);
                    }
                }
                
                // Vérifier et désactiver les boutons de soumission
                const submitButtons = document.querySelectorAll('a[onclick*="submitQuizResults"]');
                submitButtons.forEach(btn => {
                    if (btn.style.pointerEvents !== 'none') {
                        btn.style.pointerEvents = 'none';
                        btn.style.opacity = '0.5';
                        btn.style.cursor = 'not-allowed';
                        btn.onclick = function(e) {
                            e.preventDefault();
                            alert('L\'interface du quiz a expiré. Cliquez sur "Reprendre le quiz" dans la page des résultats pour continuer.');
                            return false;
                        };
                    }
                });
            }
        }, 1000); // Vérifier toutes les secondes
    </script>
</body>
</html>




