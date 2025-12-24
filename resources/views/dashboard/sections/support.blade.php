<div class="max-w-4xl mx-auto space-y-6">
    <!-- Centre d'aide / FAQ -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Centre d'aide</h2>
        
        <div class="space-y-4">
            <details class="group border border-gray-200 rounded-lg">
                <summary class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Comment s'inscrire à un cours ?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="p-4 pt-0 text-sm text-gray-600">
                    <p>Pour suivre un cours, rendez-vous dans la section "Mes Cours", parcourez les cours disponibles et cliquez sur le bouton "Suivre le cours" du cours qui vous intéresse.</p>
                </div>
            </details>
            
            <details class="group border border-gray-200 rounded-lg">
                <summary class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Comment soumettre une évaluation ?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="p-4 pt-0 text-sm text-gray-600">
                    <p>Dans la section "Évaluations", vous trouverez toutes les évaluations disponibles. Cliquez sur "Commencer" pour un quiz ou "Soumettre" pour un devoir. Suivez les instructions à l'écran pour compléter votre évaluation.</p>
                </div>
            </details>
            
            <details class="group border border-gray-200 rounded-lg">
                <summary class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Comment contacter mon formateur ?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="p-4 pt-0 text-sm text-gray-600">
                    <p>Vous pouvez contacter votre formateur via la section "Messagerie" du tableau de bord. Sélectionnez la conversation avec votre formateur ou créez une nouvelle conversation.</p>
                </div>
            </details>
            
            <details class="group border border-gray-200 rounded-lg">
                <summary class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900">Comment voir mes notes ?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="p-4 pt-0 text-sm text-gray-600">
                    <p>Consultez la section "Évaluations" pour voir toutes vos notes et résultats. Vous pouvez également voir votre note moyenne dans le tableau de bord.</p>
                </div>
            </details>
        </div>
    </div>
    
    <!-- Assistance technique -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Assistance technique</h2>
        
        <form class="space-y-4">
            <div>
                <label for="sujet" class="block text-sm font-medium text-gray-700 mb-2">Sujet</label>
                <input type="text" id="sujet" name="sujet" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent">
            </div>
            
            <div>
                <label for="categorie" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                <select id="categorie" name="categorie" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent">
                    <option value="">Sélectionner une catégorie</option>
                    <option value="technique">Problème technique</option>
                    <option value="pedagogique">Question pédagogique</option>
                    <option value="compte">Problème de compte</option>
                    <option value="autre">Autre</option>
                </select>
            </div>
            
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea id="message" name="message" rows="6" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent"
                    placeholder="Décrivez votre problème ou votre question en détail..."></textarea>
            </div>
            
            <div>
                <label for="fichier" class="block text-sm font-medium text-gray-700 mb-2">Pièce jointe (optionnel)</label>
                <input type="file" id="fichier" name="fichier"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Formats acceptés: PDF, JPG, PNG. Max 10MB</p>
            </div>
            
            <div class="flex items-center justify-end gap-4">
                <button type="reset" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Annuler
                </button>
                <button type="submit" class="px-6 py-3 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors font-medium">
                    Envoyer la demande
                </button>
            </div>
        </form>
    </div>
    
    <!-- Tickets soumis -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Mes demandes d'assistance</h2>
        
        <div class="space-y-3">
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-semibold text-gray-900">Problème de connexion</h3>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">En cours</span>
                </div>
                <p class="text-sm text-gray-600 mb-2">Je n'arrive pas à me connecter depuis hier matin</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>Créé le 18/01/2025</span>
                    <button class="text-[#065b32] hover:underline font-medium">Voir les détails</button>
                </div>
            </div>
            
            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-semibold text-gray-900">Question sur les notes</h3>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Résolu</span>
                </div>
                <p class="text-sm text-gray-600 mb-2">Je ne comprends pas ma note pour le quiz PHP</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>Créé le 15/01/2025</span>
                    <button class="text-[#065b32] hover:underline font-medium">Voir les détails</button>
                </div>
            </div>
        </div>
    </div>
</div>


