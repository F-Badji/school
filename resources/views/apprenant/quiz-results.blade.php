<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats du Quiz - BJ Academie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    @if($cours)
        <!-- Header -->
        <div class="px-6 py-4" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="flex items-center gap-4">
                    <div>
                        <p class="text-sm text-white">Question 1 sur {{ $totalQuestions > 0 ? $totalQuestions : 1 }}</p>
                        <h1 class="text-lg font-semibold text-white">
                            @if($section && isset($section['titre']))
                                {{ $section['titre'] }}
                            @else
                                {{ $cours->titre ?? 'Quiz' }}
                            @endif
                        </h1>
                    </div>
                </div>
                @php
                    $nextSectionIndex = $sectionIndex + 1;
                    $totalSections = $cours->contenu && is_array($cours->contenu) ? count($cours->contenu) : 0;
                    $hasNextSection = $nextSectionIndex < $totalSections;
                @endphp
                @if($hasNextSection)
                    <a href="{{ route('apprenant.cours', ['cours_id' => $coursId, 'section' => $nextSectionIndex]) }}" class="px-6 py-2 text-white rounded-lg font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); border: 1px solid rgba(255,255,255,0.2);">
                        Leçon suivante
                    </a>
                @else
                    <a href="{{ route('apprenant.cours-editeur', ['cours_id' => $coursId, 'section' => $sectionIndex]) }}" class="px-6 py-2 text-white rounded-lg font-medium hover:opacity-90 transition-opacity" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); border: 1px solid rgba(255,255,255,0.2);">
                        Retour aux cours
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Main Content: Two Cards Side by Side -->
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6 items-start">
                <!-- Left Card: Notes -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-lg p-5 self-start">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 bg-gray-700 rounded flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900">Notes</h2>
                    </div>
                    
                    <div class="text-center mb-4">
                        @php
                            $scoreSur20 = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 20) : 0;
                        @endphp
                        <div class="flex items-center justify-center mb-1 relative inline-block">
                            <p class="text-3xl font-bold text-gray-900 relative">
                                {{ $scoreSur20 }}/20
                                @if($scoreSur20 >= 10)
                                    <svg class="w-5 h-5 text-green-600 absolute -top-1 -right-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-red-600 absolute -top-1 -right-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </p>
                        </div>
                        <p class="text-xs text-gray-600 bg-gray-100 px-2 py-1 inline-block">Note totale de l'exercice</p>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        @php
                            $percentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
                            $scoreSur20 = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 20) : 0;
                        @endphp
                        <div class="w-full bg-gray-200 rounded-full h-5 relative">
                            <div class="bg-green-500 h-5 rounded-full relative flex items-center justify-center" style="width: {{ max($percentage, 1) }}%; min-width: {{ $percentage > 0 ? '15px' : '12px' }};">
                                <span class="text-white text-xs font-medium whitespace-nowrap">{{ $percentage }}%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Correct and Incorrect Count -->
                    <div class="grid grid-cols-2 mb-4">
                        <div class="text-left pr-3 border-r border-gray-300">
                            <p class="text-2xl font-bold text-green-600 mb-0.5">{{ $correctCount }}</p>
                            <p class="text-xs text-gray-700">Correctes</p>
                        </div>
                        <div class="text-right pl-3">
                            <p class="text-2xl font-bold text-red-600 mb-0.5">{{ $totalQuestions - $correctCount }}</p>
                            <p class="text-xs text-gray-700">Incorrectes</p>
                        </div>
                    </div>
                    
                    <!-- Performance -->
                    <div class="pt-3 border-t border-gray-200 text-center">
                        <p class="text-xs uppercase text-gray-500 mb-0.5">PERFORMANCE</p>
                        <p class="text-base font-bold text-gray-900">
                            {{ $performance }}
                        </p>
                    </div>
                </div>
                
                <!-- Right Card: Results -->
                <div class="bg-gray-100 rounded-lg border border-gray-200 shadow-xl p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Résultats</h2>
                    
                    <p class="text-green-600 font-medium mb-6">
                        Vous avez répondu correctement à {{ $correctCount }} question{{ $correctCount > 1 ? 's' : '' }} sur {{ $totalQuestions }}.
                    </p>
                    
                    @if($questions && $questions->count() > 0)
                        <div class="space-y-6">
                            @foreach($questions as $index => $question)
                                @php
                                    $studentAnswer = $studentAnswers[$question->id] ?? null;
                                    $isCorrect = false;
                                    
                                    if ($question->type === 'vrai_faux') {
                                        $normalizedStudent = strtolower(trim($studentAnswer ?? ''));
                                        $normalizedCorrect = strtolower(trim($question->reponse_correcte ?? ''));
                                        $isCorrect = ($normalizedStudent === $normalizedCorrect && $normalizedStudent !== '');
                                    } elseif ($question->type === 'choix_multiple') {
                                        $correctOptions = [];
                                        if ($question->options && is_array($question->options)) {
                                            foreach ($question->options as $option) {
                                                if (isset($option['correcte']) && $option['correcte']) {
                                                    $correctOptions[] = trim($option['texte'] ?? '');
                                                }
                                            }
                                        }
                                        $studentAnswerArray = is_array($studentAnswer) ? $studentAnswer : [];
                                        $normalizedStudentAnswers = array_map(function($answer) {
                                            return trim($answer);
                                        }, $studentAnswerArray);
                                        sort($correctOptions);
                                        sort($normalizedStudentAnswers);
                                        $isCorrect = ($correctOptions === $normalizedStudentAnswers);
                                    } elseif ($question->type === 'texte_libre' || $question->type === 'numerique') {
                                        $normalizedStudent = strtolower(trim($studentAnswer ?? ''));
                                        $normalizedCorrect = strtolower(trim($question->reponse_correcte ?? ''));
                                        $isCorrect = ($normalizedStudent === $normalizedCorrect && $normalizedStudent !== '');
                                    }
                                @endphp
                                
                                @php
                                    $scoreSur20 = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 20) : 0;
                                    $bgColor = 'bg-white';
                                    if ($scoreSur20 >= 10 && $isCorrect) {
                                        $bgColor = 'bg-green-50';
                                    } elseif ($scoreSur20 < 10 && !$isCorrect) {
                                        $bgColor = 'bg-red-50';
                                    }
                                @endphp
                                
                                <div class="border border-gray-300 rounded-lg p-4 {{ $bgColor }}">
                                    <div class="flex items-start gap-3 mb-3">
                                        @if($isCorrect)
                                            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 mb-2">Question {{ $index + 1 }}</h3>
                                            <p class="text-gray-700 mb-4">{{ $question->question }}</p>
                                            
                                            <!-- Options (for vrai_faux and choix_multiple) -->
                                            @if($question->type === 'vrai_faux')
                                                <div class="space-y-2 mb-4">
                                                    @php
                                                        $correctAnswer = $question->reponse_correcte === 'true' || strtolower($question->reponse_correcte) === 'vrai';
                                                        $studentSelectedVrai = ($studentAnswer === 'true' || strtolower($studentAnswer) === 'vrai');
                                                        $studentSelectedFaux = ($studentAnswer === 'false' || strtolower($studentAnswer) === 'faux');
                                                        $vraiIsCorrect = $studentSelectedVrai && $correctAnswer;
                                                        $fauxIsCorrect = $studentSelectedFaux && !$correctAnswer;
                                                    @endphp
                                                    <label class="flex items-center gap-2 p-2 border rounded {{ $vraiIsCorrect ? 'border-green-500 bg-green-50' : 'border-gray-300' }}">
                                                        <div class="relative">
                                                            <input type="radio" {{ $studentSelectedVrai ? 'checked' : '' }} disabled class="w-4 h-4">
                                                            @if($vraiIsCorrect)
                                                                <svg class="w-4 h-4 text-green-600 absolute top-0 left-0 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" style="margin-top: 2px; margin-left: 2px;">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                        <span class="text-gray-900">VRAI</span>
                                                    </label>
                                                    <label class="flex items-center gap-2 p-2 border rounded {{ $fauxIsCorrect ? 'border-green-500 bg-green-50' : 'border-gray-300' }}">
                                                        <div class="relative">
                                                            <input type="radio" {{ $studentSelectedFaux ? 'checked' : '' }} disabled class="w-4 h-4">
                                                            @if($fauxIsCorrect)
                                                                <svg class="w-4 h-4 text-green-600 absolute top-0 left-0 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" style="margin-top: 2px; margin-left: 2px;">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                        <span class="text-gray-900">FAUX</span>
                                                    </label>
                                                </div>
                                            @elseif($question->type === 'choix_multiple' && $question->options && is_array($question->options))
                                                <div class="space-y-2 mb-4">
                                                    @foreach($question->options as $optIndex => $option)
                                                        @php
                                                            $isCorrect = isset($option['correcte']) && $option['correcte'];
                                                            $optionText = trim($option['texte'] ?? '');
                                                            // Pour les choix multiples, la réponse peut être un tableau ou une chaîne
                                                            if (is_array($studentAnswer)) {
                                                                $isSelected = in_array($optionText, array_map('trim', $studentAnswer));
                                                            } else {
                                                                $isSelected = (trim($studentAnswer ?? '') === $optionText);
                                                            }
                                                            $showGreen = $isSelected && $isCorrect;
                                                        @endphp
                                                        <label class="flex items-center gap-2 p-2 border rounded {{ $showGreen ? 'border-green-500 bg-green-50' : 'border-gray-300' }}">
                                                            <div class="relative">
                                                                <input type="radio" {{ $isSelected ? 'checked' : '' }} disabled class="w-4 h-4">
                                                                @if($showGreen)
                                                                    <svg class="w-4 h-4 text-green-600 absolute top-0 left-0 pointer-events-none" fill="currentColor" viewBox="0 0 20 20" style="margin-top: 2px; margin-left: 2px;">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <span class="text-gray-900">{{ $optionText }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            <!-- Student Answer -->
                                            <div class="mb-3">
                                                <p class="text-green-600 font-medium">
                                                    Votre réponse : 
                                                    @if($question->type === 'vrai_faux')
                                                        {{ $studentAnswer ? ($studentAnswer === 'true' || strtolower($studentAnswer) === 'vrai' ? 'VRAI' : 'FAUX') : 'Aucune réponse' }}
                                                    @elseif($question->type === 'choix_multiple')
                                                        @if(is_array($studentAnswer) && count($studentAnswer) > 0)
                                                            {{ implode(', ', $studentAnswer) }}
                                                        @else
                                                            Aucune réponse
                                                        @endif
                                                    @else
                                                        {{ $studentAnswer ?? 'Aucune réponse' }}
                                                    @endif
                                                </p>
                                            </div>
                                            
                                            <!-- Explanation -->
                                            @if(isset($question->explication) && $question->explication)
                                                <div class="mt-3 pt-3 border-t border-gray-200">
                                                    <p class="font-semibold text-gray-900 mb-1">Explication:</p>
                                                    <p class="text-gray-700">{{ $question->explication }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Footer Buttons -->
                    <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between gap-4">
                        <div>
                        @if($remainingAttempts > 0)
                                <a href="{{ route('apprenant.quiz', ['cours_id' => $coursId, 'section' => $sectionIndex, 'retry' => 'true']) }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors text-center inline-block">
                                Reprendre le quiz
                            </a>
                            @else
                                <button disabled class="px-6 py-3 bg-gray-200 text-gray-500 rounded-lg font-medium cursor-not-allowed text-center">
                                    Tentatives terminées
                                </button>
                        @endif
                        </div>
                        <div>
                        @if($hasNextSection)
                                <a href="{{ route('apprenant.cours', ['cours_id' => $coursId, 'section' => $nextSectionIndex]) }}" class="px-6 py-3 text-white rounded-lg font-medium hover:opacity-90 transition-opacity text-center inline-block" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                Leçon suivante
                            </a>
                        @else
                                <a href="{{ route('apprenant.cours-editeur', ['cours_id' => $coursId, 'section' => $sectionIndex]) }}" class="px-6 py-3 text-white rounded-lg font-medium hover:opacity-90 transition-opacity text-center inline-block" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                Retour aux cours
                            </a>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-8 text-center">
                <p class="text-gray-600">Cours introuvable.</p>
            </div>
        </div>
    @endif
</body>
</html>
