<div class="space-y-6">
    <!-- Vue d'ensemble -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-600">Progression globale</span>
                <span class="text-2xl font-bold text-gray-900">{{ $stats['progression_globale'] ?? 67 }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div class="progress-bar bg-gradient-to-r from-[#065b32] to-[#087a45] h-3 rounded-full" style="width: {{ $stats['progression_globale'] ?? 67 }}%"></div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-600">Note moyenne</span>
                <span class="text-2xl font-bold text-gray-900">{{ number_format($stats['note_moyenne'] ?? 85.5, 1) }}/100</span>
            </div>
            <div class="flex items-center gap-2 text-sm text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <span>En progression</span>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm text-gray-600">Modules terminés</span>
                <span class="text-2xl font-bold text-gray-900">{{ $stats['cours_termines'] ?? 5 }}</span>
            </div>
            <p class="text-sm text-gray-600">Sur {{ ($stats['cours_en_cours'] ?? 3) + ($stats['cours_termines'] ?? 5) }} cours au total</p>
        </div>
    </div>
    
    <!-- Progression par cours -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Progression par cours</h2>
        
        <div class="space-y-6">
            @if(isset($cours_recents) && count($cours_recents) > 0)
                @foreach($cours_recents as $cours)
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $cours['titre'] }}</h3>
                                <p class="text-sm text-gray-600 mt-1">Formateur: {{ $cours['formateur'] }}</p>
                            </div>
                            <span class="px-4 py-2 bg-[#065b32] text-white rounded-lg font-semibold">{{ $cours['progression'] }}%</span>
                        </div>
                        
                        <div class="mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="progress-bar bg-gradient-to-r from-[#065b32] to-[#087a45] h-4 rounded-full" style="width: {{ $cours['progression'] }}%"></div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Modules complétés</p>
                                <p class="font-semibold text-gray-900">{{ floor($cours['progression'] / 20) }}/5</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Temps passé</p>
                                <p class="font-semibold text-gray-900">12h 30min</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Quiz complétés</p>
                                <p class="font-semibold text-gray-900">3/5</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Note moyenne</p>
                                <p class="font-semibold text-gray-900">17/20</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">Aucune progression à afficher</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Statistiques détaillées -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Statistiques détaillées</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Indicateurs de performance</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Temps total d'apprentissage</span>
                        <span class="text-sm font-semibold text-gray-900">45h 20min</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Quiz réussis</span>
                        <span class="text-sm font-semibold text-gray-900">12/15</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Devoirs soumis</span>
                        <span class="text-sm font-semibold text-gray-900">8/10</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Certificats obtenus</span>
                        <span class="text-sm font-semibold text-gray-900">2</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="font-semibold text-gray-900 mb-4">Comparaison avec la moyenne</h3>
                <div class="space-y-3">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Votre moyenne</span>
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($stats['note_moyenne'] ?? 85.5, 1) }}/100</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#065b32] h-2 rounded-full" style="width: {{ $stats['note_moyenne'] ?? 85.5 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Moyenne de classe</span>
                            <span class="text-sm font-semibold text-gray-900">78.5/100</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-400 h-2 rounded-full" style="width: 78.5%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



