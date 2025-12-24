<div class="space-y-6">
    <!-- Vue mensuelle -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ now()->format('F Y') }}</h2>
            </div>
            <div class="flex gap-2">
                <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="p-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Calendrier -->
        <div class="grid grid-cols-7 gap-2">
            <!-- En-têtes des jours -->
            @foreach(['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'] as $jour)
                <div class="text-center text-sm font-semibold text-gray-700 py-2">{{ $jour }}</div>
            @endforeach
            
            <!-- Jours du mois -->
            @for($i = 1; $i <= 31; $i++)
                <div class="aspect-square border border-gray-200 rounded-lg p-2 hover:bg-gray-50 transition-colors cursor-pointer
                    @if($i == now()->day) bg-blue-50 border-blue-300 @endif">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-900">{{ $i }}</span>
                        @if(in_array($i, [5, 10, 15, 20, 25]))
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </div>
                </div>
            @endfor
        </div>
    </div>
    
    <!-- Événements à venir -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Événements à venir</h2>
            
            <div class="space-y-4">
                @if(isset($evenements_prochains) && count($evenements_prochains) > 0)
                    @foreach($evenements_prochains as $evenement)
                        <div class="flex items-start gap-4 p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0
                                @if($evenement['type'] === 'examen') bg-red-100 text-red-600
                                @elseif($evenement['type'] === 'devoir') bg-orange-100 text-orange-600
                                @else bg-blue-100 text-blue-600
                                @endif">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $evenement['titre'] }}</h3>
                                <p class="text-sm text-gray-600 mb-2">
                                    {{ \Carbon\Carbon::parse($evenement['date'])->format('d/m/Y') }} à {{ $evenement['heure'] }}
                                </p>
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                    @if($evenement['type'] === 'examen') bg-red-100 text-red-800
                                    @elseif($evenement['type'] === 'devoir') bg-orange-100 text-orange-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($evenement['type']) }}
                                </span>
                            </div>
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <p class="text-sm text-gray-600 text-center py-8">Aucun événement à venir</p>
                @endif
            </div>
        </div>
        
        <!-- Alertes et rappels -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Alertes et rappels</h2>
            
            <div class="space-y-4">
                <div class="flex items-start gap-3 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-yellow-900">Rappel: Examen dans 5 jours</p>
                        <p class="text-xs text-yellow-700 mt-1">Examen final - Développement Web le 15/02/2025</p>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-blue-900">Nouveau contenu disponible</p>
                        <p class="text-xs text-blue-700 mt-1">Un nouveau module a été ajouté au cours "Base de Données"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



