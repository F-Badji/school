@extends('layouts.admin')

@section('title', 'Modifier l\'événement')
@section('breadcrumb', 'Calendrier')
@section('page-title', 'Modifier l\'événement')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Modifier l'événement</h6>
        <a href="{{ route('admin.calendrier.index') }}" class="btn btn-secondary btn-sm">
          <i class="ni ni-bold-left"></i> Retour
        </a>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.calendrier.update', $event->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Titre de l'événement</label>
              <input type="text" name="titre" class="form-control" value="{{ old('titre', $event->titre) }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Type</label>
              <select name="type" class="form-control" required>
                <option value="Examen" {{ old('type', $event->type) === 'Examen' ? 'selected' : '' }}>Examen</option>
                <option value="Devoir" {{ old('type', $event->type) === 'Devoir' ? 'selected' : '' }}>Devoir</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Date</label>
              <input type="date" name="date" class="form-control" value="{{ old('date', optional($event->scheduled_at)->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Heure</label>
              <input type="time" name="heure" class="form-control" value="{{ old('heure', optional($event->scheduled_at)->format('H:i')) }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Rappel (minutes avant)</label>
              <input type="number" name="rappel_minutes" class="form-control" value="{{ old('rappel_minutes', $event->rappel_minutes) }}" placeholder="15" min="0">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Classe</label>
              <select name="classe" id="classe-select" class="form-control">
                <option value="">Sélectionner une classe</option>
                <option value="Licence 1" {{ old('classe', $event->classe_id) === 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                <option value="Licence 2" {{ old('classe', $event->classe_id) === 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                <option value="Licence 3" {{ old('classe', $event->classe_id) === 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Cours</label>
              <select name="cours_id" id="cours-select" class="form-control">
                <option value="">Sélectionnez d'abord une classe</option>
              </select>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('admin.calendrier.index') }}" class="btn btn-secondary">Annuler</a>
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
    // Gestion du dropdown des matières
    const classeSelect = document.getElementById('classe-select');
    const coursSelect = document.getElementById('cours-select');
    const currentCoursId = {{ $event->cours_id ?? 'null' }};
    
    // Charger les matières si une classe est déjà sélectionnée
    const selectedClasse = classeSelect.value;
    if (selectedClasse) {
      loadMatieres(selectedClasse);
    }
    
    if (classeSelect && coursSelect) {
      classeSelect.addEventListener('change', function() {
        const selectedClasse = classeSelect.value;
        
        coursSelect.innerHTML = '<option value="">Chargement...</option>';
        coursSelect.disabled = true;
        
        if (!selectedClasse) {
          coursSelect.innerHTML = '<option value="">Sélectionnez d\'abord une classe</option>';
          coursSelect.disabled = false;
          return;
        }
        
        loadMatieres(selectedClasse);
      });
    }
    
    function loadMatieres(classe) {
      const licenceMap = {
        'Licence 1': 'licence_1',
        'Licence 2': 'licence_2',
        'Licence 3': 'licence_3'
      };
      
      const licenceValue = licenceMap[classe];
      
      if (!licenceValue) {
        coursSelect.innerHTML = '<option value="">Classe invalide</option>';
        coursSelect.disabled = false;
        return;
      }
      
      fetch('{{ route("admin.formateurs.matieres-by-licence") }}?licence=' + encodeURIComponent(licenceValue), {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => {
            throw new Error(err.error || err.message || 'Erreur lors de la récupération des matières');
          });
        }
        return response.json();
      })
      .then(data => {
        if (data.success && Array.isArray(data.matieres)) {
          coursSelect.innerHTML = '<option value="">Sélectionner une matière</option>';
          
          if (data.matieres.length > 0) {
            data.matieres.forEach(matiere => {
              const option = document.createElement('option');
              option.value = matiere.id;
              option.textContent = matiere.nom_matiere || matiere.nom || 'Matière #' + matiere.id;
              // Pré-sélectionner si c'est la matière actuelle
              if (currentCoursId && matiere.id == currentCoursId) {
                option.selected = true;
              }
              coursSelect.appendChild(option);
            });
          } else {
            coursSelect.innerHTML = '<option value="">Aucune matière disponible pour cette classe</option>';
          }
        } else {
          coursSelect.innerHTML = '<option value="">Erreur lors du chargement des matières</option>';
        }
        coursSelect.disabled = false;
      })
      .catch(error => {
        console.error('Erreur:', error);
        coursSelect.innerHTML = '<option value="">Erreur: ' + (error.message || 'Erreur lors du chargement') + '</option>';
        coursSelect.disabled = false;
      });
    }
  });
</script>
@endpush

