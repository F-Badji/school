@php
    $user = auth()->user();
@endphp

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Informations personnelles</h2>
        
        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Photo de profil -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                        @if($user->photo)
                            <img id="profile-preview" src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <span id="profile-initials" class="text-gray-600 font-semibold text-2xl">{{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                        <label for="photo" class="inline-block px-4 py-2 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors cursor-pointer text-sm font-medium">
                            Choisir une photo
                        </label>
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG ou GIF. Max 2MB</p>
                    </div>
                </div>
            </div>
            
            <!-- Nom et Prénom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent transition-all">
                    @error('nom')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="prenom" class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent transition-all">
                    @error('prenom')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent transition-all">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Date de naissance -->
            <div>
                <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-2">Date de naissance</label>
                <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance', $user->date_naissance ? $user->date_naissance->format('Y-m-d') : '') }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent transition-all">
                @error('date_naissance')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Mot de passe -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Changer le mot de passe</h3>
                <div class="space-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password" minlength="8"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent transition-all placeholder:text-gray-400"
                            placeholder="Laissez vide pour ne pas changer"
                            oninput="updatePasswordRequired(this)">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" minlength="8"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#065b32] focus:border-transparent transition-all placeholder:text-gray-400"
                            placeholder="Répétez le nouveau mot de passe"
                            oninput="updatePasswordRequired(this)">
                    </div>
                </div>
            </div>
            
            <!-- Statut d'inscription -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statut d'inscription</h3>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-green-900">Inscription active</p>
                            @php
                                // Utiliser la date de confirmation du paiement si disponible, sinon la date de paiement, sinon la date d'inscription
                                $inscriptionDate = $user->date_confirmation_paiement ?? $user->date_paiement ?? $user->created_at;
                                $dateFormatee = $inscriptionDate instanceof \Carbon\Carbon 
                                    ? $inscriptionDate->format('d/m/Y') 
                                    : \Carbon\Carbon::parse($inscriptionDate)->format('d/m/Y');
                            @endphp
                            <p class="text-xs text-green-700">Vous êtes inscrit le {{ $dateFormatee }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Boutons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-3 bg-[#065b32] text-white rounded-lg hover:bg-[#077a43] transition-colors font-medium">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profile-preview');
                const initials = document.getElementById('profile-initials');
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                if (initials) {
                    initials.style.display = 'none';
                }
                // Si pas de preview, créer l'image
                if (!preview) {
                    const img = document.createElement('img');
                    img.id = 'profile-preview';
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    const container = input.closest('.flex').querySelector('.w-24');
                    container.innerHTML = '';
                    container.appendChild(img);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function updatePasswordRequired(input) {
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        if (password.value.trim() !== '') {
            passwordConfirmation.setAttribute('required', 'required');
        } else {
            passwordConfirmation.removeAttribute('required');
        }
        
        if (passwordConfirmation.value.trim() !== '' && password.value.trim() !== '') {
            password.setAttribute('required', 'required');
        }
    }
</script>

