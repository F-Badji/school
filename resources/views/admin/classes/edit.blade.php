@extends('layouts.admin')

@section('title', 'Modifier Classe')
@section('breadcrumb', 'Modifier Classe')
@section('page-title', 'Modifier la Classe')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Modifier les Informations</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.classes.update', $classe) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Filière</label>
              <select name="filiere" id="filiere-select" class="form-control @error('filiere') is-invalid @enderror">
                <option value="">-- Sélectionner une filière --</option>
                @foreach($filieres as $filiere)
                  <option value="{{ $filiere }}" {{ old('filiere', $classe->filiere) == $filiere ? 'selected' : '' }}>
                    {{ $filiere }}
                  </option>
                @endforeach
              </select>
              @error('filiere')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Classe</label>
              <select name="niveau_etude" id="niveau-etude-select" class="form-control @error('niveau_etude') is-invalid @enderror">
                <option value="">Sélectionner une classe</option>
                <option value="Licence 1" {{ old('niveau_etude', $classe->niveau_etude) === 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                <option value="Licence 2" {{ old('niveau_etude', $classe->niveau_etude) === 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                <option value="Licence 3" {{ old('niveau_etude', $classe->niveau_etude) === 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
              </select>
              @error('niveau_etude')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $classe->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Apprenants <small class="text-muted">(Sélectionnez les apprenants déjà inscrits)</small></label>
              <select name="apprenants[]" id="choices-apprenants" class="form-control @error('apprenants') is-invalid @enderror" multiple>
                @foreach($apprenants as $apprenant)
                  <option value="{{ $apprenant->id }}" {{ $classe->apprenants->contains($apprenant->id) ? 'selected' : '' }}>
                    {{ trim(($apprenant->nom ?? '') . ' ' . ($apprenant->prenom ?? '')) ?: $apprenant->name }} ({{ $apprenant->email }})
                  </option>
                @endforeach
              </select>
              <small class="text-muted">Sélectionnez un ou plusieurs apprenants déjà inscrits. Utilisez la barre de recherche pour filtrer.</small>
              @error('apprenants')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="actif" id="actif" value="1" {{ old('actif', $classe->actif ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="actif">
                  Classe active
                </label>
              </div>
            </div>
          </div>
          
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const niveauEtudeSelect = document.getElementById('niveau-etude-select');
    const filiereSelect = document.getElementById('filiere-select');
    
    // Fonction pour mapper niveau_etude vers licence
    function niveauToLicence(niveau) {
      const map = {
        'Licence 1': 'licence_1',
        'Licence 2': 'licence_2',
        'Licence 3': 'licence_3'
      };
      return map[niveau] || null;
    }
    
    // Fonction pour mapper licence vers niveau_etude
    function licenceToNiveau(licence) {
      const map = {
        'licence_1': 'Licence 1',
        'licence_2': 'Licence 2',
        'licence_3': 'Licence 3'
      };
      return map[licence] || null;
    }
    
    // Fonction pour filtrer les niveaux d'étude disponibles selon la filière
    function filterNiveauxByFiliere() {
      const selectedFiliere = filiereSelect ? filiereSelect.value : '';
      
      if (!selectedFiliere) {
        // Si aucune filière n'est sélectionnée, afficher tous les niveaux
        if (niveauEtudeSelect) {
          const currentValue = niveauEtudeSelect.value;
            niveauEtudeSelect.innerHTML = `
            <option value="">Sélectionner une classe</option>
            <option value="Licence 1">Licence 1</option>
            <option value="Licence 2">Licence 2</option>
            <option value="Licence 3">Licence 3</option>
          `;
          if (currentValue) {
            niveauEtudeSelect.value = currentValue;
          }
        }
        return;
      }
      
      // Récupérer les licences disponibles pour cette filière
      fetch('{{ route("admin.formateurs.licences-by-filiere") }}?filiere=' + encodeURIComponent(selectedFiliere), {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
      })
      .then(response => response.json())
      .then(data => {
        if (data.success && Array.isArray(data.licences)) {
          if (niveauEtudeSelect) {
            const currentValue = niveauEtudeSelect.value;
            niveauEtudeSelect.innerHTML = '<option value="">Sélectionner une classe</option>';
            
            data.licences.forEach(licence => {
              const niveau = licenceToNiveau(licence.value);
              if (niveau) {
                const option = document.createElement('option');
                option.value = niveau;
                option.textContent = niveau;
                if (currentValue === niveau) {
                  option.selected = true;
                }
                niveauEtudeSelect.appendChild(option);
              }
            });
            
            // Si le niveau actuel n'est plus disponible, vider
            if (currentValue && !data.licences.some(l => licenceToNiveau(l.value) === currentValue)) {
              niveauEtudeSelect.value = '';
            }
          }
        }
      })
      .catch(error => {
        console.error('Erreur lors du filtrage des niveaux:', error);
      });
    }
    
    // Fonction pour filtrer les filières disponibles selon le niveau d'étude
    function filterFilieresByNiveau() {
      const selectedNiveau = niveauEtudeSelect ? niveauEtudeSelect.value : '';
      const licenceValue = niveauToLicence(selectedNiveau);
      
      if (!selectedNiveau || !licenceValue) {
        // Si aucun niveau n'est sélectionné, afficher toutes les filières
        if (filiereSelect) {
          const currentValue = filiereSelect.value;
          filiereSelect.innerHTML = '<option value="">-- Sélectionner une filière --</option>';
          const allFilieres = @json($filieres);
          allFilieres.forEach(filiere => {
            const option = document.createElement('option');
            option.value = filiere;
            option.textContent = filiere;
            if (currentValue === filiere) {
              option.selected = true;
            }
            filiereSelect.appendChild(option);
          });
        }
        return;
      }
      
      // Récupérer les filières disponibles pour ce niveau
      fetch('{{ route("admin.formateurs.filieres-by-licence") }}?licence=' + encodeURIComponent(licenceValue), {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
      })
      .then(response => response.json())
      .then(data => {
        if (data.success && Array.isArray(data.filieres)) {
          if (filiereSelect) {
            const currentValue = filiereSelect.value;
            filiereSelect.innerHTML = '<option value="">-- Sélectionner une filière --</option>';
            
            data.filieres.forEach(filiere => {
              const option = document.createElement('option');
              option.value = filiere;
              option.textContent = filiere;
              if (currentValue === filiere) {
                option.selected = true;
              }
              filiereSelect.appendChild(option);
            });
            
            // Si la filière actuelle n'est plus disponible, vider
            if (currentValue && !data.filieres.includes(currentValue)) {
              filiereSelect.value = '';
            }
          }
        }
      })
      .catch(error => {
        console.error('Erreur lors du filtrage des filières:', error);
      });
    }
    
    // Écouter les changements sur le champ "Niveau d'étude"
    if (niveauEtudeSelect) {
      niveauEtudeSelect.addEventListener('change', function() {
        filterFilieresByNiveau();
      });
    }
    
    // Écouter les changements sur le champ "Filière"
    if (filiereSelect) {
      filiereSelect.addEventListener('change', function() {
        filterNiveauxByFiliere();
      });
    }
    
    // Déclencher le chargement initial si des valeurs sont déjà sélectionnées
    if (niveauEtudeSelect && niveauEtudeSelect.value) {
      filterFilieresByNiveau();
    }
    if (filiereSelect && filiereSelect.value) {
      filterNiveauxByFiliere();
    }
    
    // Initialiser Choices.js pour les apprenants
    if (document.getElementById('choices-apprenants')) {
      var apprenants = document.getElementById('choices-apprenants');
      const choicesApprenants = new Choices(apprenants, {
        removeItemButton: true,
        searchEnabled: true,
        searchChoices: true,
        searchPlaceholderValue: 'Rechercher un apprenant...',
        placeholder: true,
        placeholderValue: 'Sélectionnez les apprenants déjà inscrits',
        maxItemCount: -1,
        shouldSort: true,
        searchFields: ['label', 'value']
      });
    }
  });
</script>
@endpush
