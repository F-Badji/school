<div class="space-y-6">
    <!-- En-tête avec filtres -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-900">Mes Évaluations</h2>
            <div class="flex gap-3">
                <button class="px-4 py-2 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors text-sm font-medium">
                    Toutes
                </button>
                <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Disponibles
                </button>
                <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Terminées
                </button>
            </div>
        </div>
    </div>
    
    <!-- Évaluations disponibles -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Évaluations disponibles</h3>
        
        <div class="space-y-4">
            <div class="border border-blue-200 bg-blue-50 rounded-lg p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="font-semibold text-gray-900">Quiz - Introduction à PHP</h4>
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">Nouveau</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Cours: Développement Web Avancé</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span>⏱️ Durée: 30 minutes</span>
                            <span>📝 20 questions</span>
                            <span>📅 Date limite: 25/01/2025</span>
                        </div>
                    </div>
                    <button class="ml-4 px-6 py-2 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors text-sm font-medium">
                        Commencer
                    </button>
                </div>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="font-semibold text-gray-900">Devoir - Création de base de données</h4>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">Cours: Base de Données</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span>📄 Format: Rédaction</span>
                            <span>📅 Date limite: 28/01/2025</span>
                        </div>
                    </div>
                    <button class="ml-4 px-6 py-2 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors text-sm font-medium">
                        Soumettre
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Résultats des évaluations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Résultats et notes</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Évaluation</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Cours</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Note</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <p class="text-sm font-medium text-gray-900">Quiz - HTML/CSS</p>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm text-gray-600">Développement Web</p>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">18/20</span>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm text-gray-600">15/01/2025</p>
                        </td>
                        <td class="px-4 py-4">
                            <button class="text-sm text-[#065b32] hover:underline font-medium">Voir correction</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4">
                            <p class="text-sm font-medium text-gray-900">Devoir - Projet final</p>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm text-gray-600">Base de Données</p>
                        </td>
                        <td class="px-4 py-4">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">15/20</span>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-sm text-gray-600">10/01/2025</p>
                        </td>
                        <td class="px-4 py-4">
                            <button class="text-sm text-[#065b32] hover:underline font-medium">Voir commentaires</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Historique -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Historique complet</h3>
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p class="mt-4 text-gray-600">Historique complet des évaluations</p>
        </div>
    </div>
</div>



