<div class="question-item bg-white border border-gray-200 rounded-lg p-4" data-question-id="{{ $question->id ?? 'new' }}" data-section-index="{{ $sectionIndex }}" data-question-index="{{ $questionIndex }}">
    <div class="flex items-start gap-3">
        <!-- Drag Handle -->
        <div class="cursor-move mt-2" title="Glisser pour réorganiser">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
            </svg>
        </div>
        
        <div class="flex-1 space-y-3">
            <!-- Question Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-1 rounded">Question {{ $questionIndex + 1 }}</span>
                    <select name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][type]" class="text-sm border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="updateQuestionType(this, {{ $sectionIndex }}, {{ $questionIndex }})">
                        <option value="vrai_faux" {{ ($question->type ?? 'vrai_faux') === 'vrai_faux' ? 'selected' : '' }}>Vrai/Faux</option>
                        <option value="choix_multiple" {{ ($question->type ?? '') === 'choix_multiple' ? 'selected' : '' }}>Choix multiple</option>
                        <option value="texte_libre" {{ ($question->type ?? '') === 'texte_libre' ? 'selected' : '' }}>Texte libre</option>
                        <option value="image" {{ ($question->type ?? '') === 'image' ? 'selected' : '' }}>Image</option>
                        <option value="numerique" {{ ($question->type ?? '') === 'numerique' ? 'selected' : '' }}>Numérique</option>
                    </select>
                </div>
                <button type="button" onclick="removeQuestion(this)" class="text-red-600 hover:text-red-800 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Question Text -->
            <div>
                <textarea name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][question]" rows="2" placeholder="Entrez votre question..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>{{ $question->question ?? '' }}</textarea>
                @if(isset($question->id))
                    <input type="hidden" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][id]" value="{{ $question->id }}">
                @endif
            </div>
            
            <!-- Question Type Specific Fields -->
            <div class="question-type-fields" data-question-type="{{ $question->type ?? 'vrai_faux' }}">
                <!-- Vrai/Faux -->
                <div class="vrai_faux-fields" style="display: {{ ($question->type ?? 'vrai_faux') === 'vrai_faux' ? 'block' : 'none' }};">
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][reponse_vrai_faux]" value="true" {{ ($question->reponse_correcte ?? '') === 'true' ? 'checked' : '' }} class="text-blue-600">
                            <span class="text-sm">Vrai</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][reponse_vrai_faux]" value="false" {{ ($question->reponse_correcte ?? '') === 'false' ? 'checked' : '' }} class="text-blue-600">
                            <span class="text-sm">Faux</span>
                        </label>
                    </div>
                </div>
                
                <!-- Choix Multiple -->
                <div class="choix_multiple-fields" style="display: {{ ($question->type ?? '') === 'choix_multiple' ? 'block' : 'none' }};">
                    <div id="options-container-{{ $sectionIndex }}-{{ $questionIndex }}" class="space-y-2">
                        @if(isset($question->options) && is_array($question->options))
                            @foreach($question->options as $optIndex => $option)
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][options][{{ $optIndex }}][correcte]" value="1" {{ ($option['correcte'] ?? false) ? 'checked' : '' }} class="text-blue-600">
                                    <input type="text" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][options][{{ $optIndex }}][texte]" value="{{ $option['texte'] ?? '' }}" placeholder="Option {{ $optIndex + 1 }}" class="flex-1 px-3 py-1.5 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                    <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" onclick="addOption({{ $sectionIndex }}, {{ $questionIndex }})" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                        + Ajouter une option
                    </button>
                </div>
                
                <!-- Texte Libre -->
                <div class="texte_libre-fields" style="display: {{ ($question->type ?? '') === 'texte_libre' ? 'block' : 'none' }};">
                    <textarea name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][reponse_texte_libre]" rows="3" placeholder="Réponse attendue (optionnel, pour correction manuelle)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ $question->reponse_correcte ?? '' }}</textarea>
                </div>
                
                <!-- Image -->
                <div class="image-fields" style="display: {{ ($question->type ?? '') === 'image' ? 'block' : 'none' }};">
                    <div class="mb-2">
                        <input type="file" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][image_file]" accept="image/*" class="text-sm" onchange="previewQuestionImage(this, {{ $sectionIndex }}, {{ $questionIndex }})">
                        @if(isset($question->image) && $question->image)
                            <input type="hidden" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][image]" value="{{ $question->image }}">
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $question->image) }}" alt="Question image" class="max-w-xs rounded-lg border border-gray-300" id="question-image-preview-{{ $sectionIndex }}-{{ $questionIndex }}">
                            </div>
                        @endif
                        <div id="question-image-preview-new-{{ $sectionIndex }}-{{ $questionIndex }}" class="mt-2 hidden">
                            <img src="" alt="Preview" class="max-w-xs rounded-lg border border-gray-300">
                        </div>
                    </div>
                    <textarea name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][reponse_image]" rows="2" placeholder="Réponse attendue pour cette image" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">{{ $question->reponse_correcte ?? '' }}</textarea>
                </div>
                
                <!-- Numérique -->
                <div class="numerique-fields" style="display: {{ ($question->type ?? '') === 'numerique' ? 'block' : 'none' }};">
                    <input type="number" step="any" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][reponse_numerique]" value="{{ $question->reponse_correcte ?? '' }}" placeholder="Réponse numérique attendue" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>
            
            <!-- Points and Explanation -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Points</label>
                    <input type="number" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][points]" value="{{ $question->points ?? 1 }}" min="1" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Explication (optionnel)</label>
                    <input type="text" name="questions[{{ $sectionIndex }}][{{ $questionIndex }}][explication]" value="{{ $question->explication ?? '' }}" placeholder="Explication de la réponse" class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>
        </div>
    </div>
</div>













