<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-[calc(100vh-12rem)]">
    <!-- Liste des conversations -->
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Messages</h2>
            <input type="text" placeholder="Rechercher..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent">
        </div>
        
        <div class="flex-1 overflow-y-auto">
            <div class="space-y-1 p-2">
                <!-- Conversation 1 -->
                <div class="p-3 rounded-lg hover:bg-gray-50 cursor-pointer border-l-4 border-[#065b32] bg-blue-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#065b32] text-white flex items-center justify-center font-semibold">
                            PD
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-semibold text-gray-900 truncate">Prof. Diallo</p>
                                <span class="text-xs text-gray-500">14:30</span>
                            </div>
                            <p class="text-xs text-gray-600 truncate">Avez-vous des questions sur le...</p>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">2</span>
                        </div>
                    </div>
                </div>
                
                <!-- Conversation 2 -->
                <div class="p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
                            PB
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-semibold text-gray-900 truncate">Prof. Ba</p>
                                <span class="text-xs text-gray-500">Hier</span>
                            </div>
                            <p class="text-xs text-gray-600 truncate">Votre devoir a été corrigé</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Zone de chat -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#065b32] text-white flex items-center justify-center font-semibold">
                    PD
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Prof. Diallo</p>
                    <p class="text-xs text-gray-500">Développement Web Avancé</p>
                </div>
            </div>
        </div>
        
        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-full bg-[#065b32] text-white flex items-center justify-center text-xs font-semibold">
                    PD
                </div>
                <div class="flex-1">
                    <div class="bg-gray-100 rounded-lg p-3">
                        <p class="text-sm text-gray-900">Bonjour, avez-vous des questions sur le dernier module du cours ?</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">14:25</p>
                </div>
            </div>
            
            <div class="flex items-start gap-3 justify-end">
                <div class="flex-1 flex justify-end">
                    <div class="max-w-[70%]">
                        <div class="bg-[#065b32] text-white rounded-lg p-3">
                            <p class="text-sm">Bonjour professeur, oui j'ai une question concernant...</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 text-right">14:28</p>
                    </div>
                </div>
                <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-semibold">
                    {{ substr(auth()->user()->prenom, 0, 1) }}{{ substr(auth()->user()->nom, 0, 1) }}
                </div>
            </div>
        </div>
        
        <!-- Zone de saisie -->
        <div class="p-4 border-t border-gray-200">
            <form class="flex items-center gap-3">
                <input type="text" name="message" placeholder="Tapez votre message..." required
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent">
                <button type="submit" class="p-2 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Forum de discussion -->
<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Forum de discussion</h2>
    
    <!-- Formulaire pour créer un nouveau message -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Créer un nouveau message</h3>
        <form class="space-y-3">
            <input type="text" name="forum_titre" placeholder="Titre de votre message..." required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent text-sm">
            <textarea name="forum_message" rows="3" placeholder="Votre message..." required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent text-sm"></textarea>
            <button type="submit" class="w-full px-4 py-2 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors text-sm font-medium">
                Publier
            </button>
        </form>
    </div>
    
    <div class="space-y-4">
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#065b32] text-white flex items-center justify-center text-sm font-semibold">
                        PD
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Prof. Diallo</p>
                        <p class="text-xs text-gray-500">Développement Web - Il y a 2 heures</p>
                    </div>
                </div>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Question sur les formulaires HTML</h3>
            <p class="text-sm text-gray-600 mb-3">Quelqu'un peut m'expliquer la différence entre GET et POST ?</p>
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <button class="hover:text-[#065b32] transition-colors">💬 Répondre</button>
                <span>5 réponses</span>
            </div>
        </div>
        
        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-semibold">
                        M
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Marie</p>
                        <p class="text-xs text-gray-500">Base de Données - Il y a 5 heures</p>
                    </div>
                </div>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Devoir soumis</h3>
            <p class="text-sm text-gray-600 mb-3">J'ai terminé mon devoir sur les relations SQL.</p>
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <button class="hover:text-[#065b32] transition-colors">💬 Répondre</button>
                <span>2 réponses</span>
            </div>
        </div>
    </div>
</div>

