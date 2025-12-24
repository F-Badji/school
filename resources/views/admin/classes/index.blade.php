@extends('layouts.admin')

@include('components.delete-modal-handler')

@section('title', 'Classes')
@section('breadcrumb', 'Classes')
@section('page-title', 'Gestion des Classes et Semestres')

@push('styles')
<style>
  .table td .btn-link.action-btn,
  .table td button.btn-link.action-btn {
    opacity: 1 !important;
  }
  .table td .btn-link.action-btn .ni,
  .table td button.btn-link.action-btn .ni,
  .table td .btn-link.action-btn .bi {
    visibility: visible !important;
    display: inline-block !important;
    color: inherit !important;
  }
  .semestre-badge {
    display: inline-block;
    padding: 0.35rem 0.65rem;
    margin: 0.2rem;
    color: #344767;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
  }
  .modal-content {
    border-radius: 1rem;
  }
  .form-check-input:checked {
    background-color: #5e72e4;
    border-color: #5e72e4;
  }
  .table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
  }
  .table tbody tr:hover {
    background-color: #f8f9fa;
  }
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0 font-weight-bold">Liste des Classes</h5>
            <p class="text-xs text-muted mb-0 mt-1">
              <i class="ni ni-bullet-list-67 me-1"></i>
              Total: <strong>{{ $classesUniques->count() }}</strong> classe(s) enregistrée(s) dans la base de données
              @php
                $niveaux = $classesUniques->pluck('niveau_etude')->unique()->values();
              @endphp
              @if($niveaux->isNotEmpty())
                - Niveaux: <strong>{{ $niveaux->implode(', ') }}</strong>
              @endif
            </p>
          </div>
          <button type="button" class="btn btn-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#createClasseModal">
            <i class="ni ni-fat-add me-1"></i> Nouvelle Classe
          </button>
        </div>
      </div>
      <div class="card-body px-0 pt-4 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-xs font-weight-bold" style="color: #344767 !important;">Filière</th>
                <th class="text-uppercase text-xs font-weight-bold ps-2" style="color: #344767 !important;">Classe</th>
                <th class="text-uppercase text-xs font-weight-bold ps-2" style="color: #344767 !important;">Semestres</th>
                <th class="text-center text-uppercase text-xs font-weight-bold" style="color: #344767 !important;">Effectif</th>
                <th class="text-center text-uppercase text-xs font-weight-bold" style="color: #344767 !important;">Date de création</th>
                <th class="text-center text-uppercase text-xs font-weight-bold" style="color: #344767 !important;">Statut</th>
                <th class="text-center text-uppercase text-xs font-weight-bold" style="color: #344767 !important;">Actions</th>
              </tr>
            </thead>
            <tbody id="classesTableBody">
              @forelse($classesUniques as $classe)
              @php
                // Récupérer tous les semestres actifs de cette classe
                // La relation classeSemestres est déjà filtrée par actif=true et triée dans le contrôleur
                $semestresActifs = $classe->classeSemestres ?? collect();
              @endphp
              <tr data-classe-id="{{ $classe->id }}">
                <td>
                  <span class="text-xs font-weight-bold">{{ $classe->filiere ?? 'N/A' }}</span>
                </td>
                <td>
                  <span class="text-xs font-weight-bold">{{ $classe->niveau_etude ?? 'N/A' }}</span>
                </td>
                <td>
                  <div class="d-flex flex-wrap align-items-center">
                    @if($semestresActifs->isNotEmpty())
                      @foreach($semestresActifs as $cs)
                        <span class="semestre-badge">Semestre {{ $cs->semestre }}</span>
                      @endforeach
                    @else
                      <span class="text-xs text-muted">
                        <i class="ni ni-notification-70 me-1"></i>
                        Aucun semestre
                      </span>
                    @endif
                  </div>
                </td>
                <td class="align-middle text-center">
                  <span class="badge badge-sm bg-gradient-info">{{ $classe->apprenants_count ?? 0 }} apprenant(s)</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-xs text-secondary">{{ $classe->created_at->format('d/m/Y') }}</span>
                </td>
                <td class="align-middle text-center">
                  @if($classe->actif ?? true)
                    <span class="badge badge-sm badge-success">Active</span>
                  @else
                    <span class="badge badge-sm badge-secondary">Inactive</span>
                  @endif
                </td>
                <td class="align-middle">
                  <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-link action-btn p-2 mb-0" onclick="editClasse({{ $classe->id }})" data-toggle="tooltip" data-original-title="Modifier" style="color: #5e72e4 !important; opacity: 1 !important;">
                      <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important;"></i>
                    </button>
                    <form action="{{ route('admin.classes.toggle-block', $classe) }}" method="POST" class="d-inline" onsubmit="toggleBlockClasse(event, this)">
                      @csrf
                      @method('POST')
                      <button type="submit" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="{{ ($classe->actif ?? true) ? 'Désactiver' : 'Activer' }}" style="color: {{ ($classe->actif ?? true) ? '#fb6340' : '#28a745' }} !important; opacity: 1 !important;">
                        <i class="ni ni-lock-circle-open text-lg {{ ($classe->actif ?? true) ? 'warning' : '' }}" aria-hidden="true" style="color: {{ ($classe->actif ?? true) ? '#fb6340' : '#28a745' }} !important; opacity: 1 !important;"></i>
                      </button>
                    </form>
                    <button type="button" 
                            class="btn btn-link action-btn p-2 mb-0" 
                            data-toggle="modal" 
                            data-target="#deleteConfirmModal{{ $classe->id }}" 
                            data-original-title="Supprimer" 
                            style="color: #f5365c !important; opacity: 1 !important;">
                      <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important;"></i>
                    </button>
                    @include('components.delete-confirm-modal', [
                      'id' => $classe->id,
                      'action' => route('admin.classes.destroy', $classe),
                      'message' => 'Êtes-vous sûr de vouloir supprimer cette classe ?'
                    ])
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-5">
                  <div class="d-flex flex-column align-items-center">
                    <i class="ni ni-bullet-list-67 text-muted mb-2" style="font-size: 3rem;"></i>
                    <p class="text-xs text-muted mb-0">Aucune classe enregistrée dans la base de données</p>
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#createClasseModal">
                      <i class="ni ni-fat-add me-1"></i> Créer la première classe
                    </button>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Créer Classe -->
<div class="modal fade" id="createClasseModal" tabindex="-1" aria-labelledby="createClasseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="createClasseModalLabel">
          <i class="ni ni-fat-add me-2 text-primary"></i>Créer une nouvelle classe
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="createClasseForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="create_code" class="form-label font-weight-bold">Code de la classe</label>
            <input type="text" class="form-control" id="create_code" name="code" placeholder="Ex: GEN-INFO-L1-001">
            <small class="text-muted">Laissez vide pour génération automatique</small>
          </div>
          <div class="mb-3">
            <label for="create_filiere" class="form-label font-weight-bold">Filière <span class="text-danger">*</span></label>
            <select class="form-control" id="create_filiere" name="filiere" required>
              <option value="">-- Sélectionner une filière --</option>
              @foreach($filieres as $filiere)
                <option value="{{ $filiere }}">{{ $filiere }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="create_niveau_etude" class="form-label font-weight-bold">Classe <span class="text-danger">*</span></label>
            <select class="form-control" id="create_niveau_etude" name="niveau_etude" required>
              <option value="">-- Sélectionner un niveau --</option>
              @foreach($niveauxEtude as $niveau)
                <option value="{{ $niveau }}">{{ $niveau }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-weight-bold">Semestres <span class="text-danger">*</span></label>
            <div class="row">
              @for($i = 1; $i <= 10; $i++)
                <div class="col-md-3 col-sm-4 col-6 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="semestres[]" value="{{ $i }}" id="create_semestre_{{ $i }}">
                    <label class="form-check-label" for="create_semestre_{{ $i }}">
                      Semestre {{ $i }}
                    </label>
                  </div>
                </div>
              @endfor
            </div>
            <small class="text-muted">Sélectionnez au moins un semestre</small>
          </div>
          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="create_actif" name="actif" checked>
              <label class="form-check-label" for="create_actif">
                Classe active
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">
            <i class="ni ni-check-bold me-1"></i>Créer la classe
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modifier Classe -->
<div class="modal fade" id="editClasseModal" tabindex="-1" aria-labelledby="editClasseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="editClasseModalLabel">
          <i class="bi bi-pencil me-2 text-primary"></i>Modifier la classe
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editClasseForm">
        <input type="hidden" id="edit_classe_id" name="classe_id">
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_code" class="form-label font-weight-bold">Code de la classe</label>
            <input type="text" class="form-control" id="edit_code" name="code">
          </div>
          <div class="mb-3">
            <label for="edit_filiere" class="form-label font-weight-bold">Filière <span class="text-danger">*</span></label>
            <select class="form-control" id="edit_filiere" name="filiere" required>
              <option value="">-- Sélectionner une filière --</option>
              @foreach($filieres as $filiere)
                <option value="{{ $filiere }}">{{ $filiere }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_niveau_etude" class="form-label font-weight-bold">Classe <span class="text-danger">*</span></label>
            <select class="form-control" id="edit_niveau_etude" name="niveau_etude" required>
              <option value="">-- Sélectionner un niveau --</option>
              @foreach($niveauxEtude as $niveau)
                <option value="{{ $niveau }}">{{ $niveau }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-weight-bold">Semestres <span class="text-danger">*</span></label>
            <div class="row">
              @for($i = 1; $i <= 10; $i++)
                <div class="col-md-3 col-sm-4 col-6 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="semestres[]" value="{{ $i }}" id="edit_semestre_{{ $i }}">
                    <label class="form-check-label" for="edit_semestre_{{ $i }}">
                      Semestre {{ $i }}
                    </label>
                  </div>
                </div>
              @endfor
            </div>
            <small class="text-muted">Sélectionnez au moins un semestre</small>
          </div>
          <div class="mb-3">
            <label for="edit_description" class="form-label font-weight-bold">Description</label>
            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="edit_actif" name="actif">
              <label class="form-check-label" for="edit_actif">
                Classe active
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">
            <i class="ni ni-check-bold me-1"></i>Enregistrer les modifications
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Gestion de la création
  const createForm = document.getElementById('createClasseForm');
  if (createForm) {
    createForm.addEventListener('submit', function(e) {
      e.preventDefault();
      createClasse();
    });
  }
  
  // Gestion de la modification
  const editForm = document.getElementById('editClasseForm');
  if (editForm) {
    editForm.addEventListener('submit', function(e) {
      e.preventDefault();
      updateClasse();
    });
  }
  
  // Réinitialiser le formulaire de création à la fermeture
  const createModal = document.getElementById('createClasseModal');
  if (createModal) {
    createModal.addEventListener('hidden.bs.modal', function() {
      createForm.reset();
      document.querySelectorAll('#createClasseForm input[type="checkbox"]').forEach(cb => cb.checked = false);
      document.getElementById('create_actif').checked = true;
    });
  }
});

function createClasse() {
  const form = document.getElementById('createClasseForm');
  const formData = new FormData(form);
  
  const semestres = formData.getAll('semestres[]');
  if (semestres.length === 0) {
    alert('Veuillez sélectionner au moins un semestre.');
    return;
  }
  
  const data = {
    code: formData.get('code') || null,
    filiere: formData.get('filiere'),
    niveau_etude: formData.get('niveau_etude'),
    semestres: semestres.map(s => parseInt(s)),
    actif: formData.get('actif') === 'on'
  };
  
  fetch('{{ route("admin.classes.store") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Erreur: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Erreur lors de la création de la classe.');
  });
}

function editClasse(classeId) {
  fetch(`{{ route('admin.classes.get', ':id') }}`.replace(':id', classeId), {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const classe = data.classe;
      document.getElementById('edit_classe_id').value = classe.id;
      document.getElementById('edit_code').value = classe.code || '';
      document.getElementById('edit_filiere').value = classe.filiere || '';
      document.getElementById('edit_niveau_etude').value = classe.niveau_etude || '';
      document.getElementById('edit_description').value = classe.description || '';
      document.getElementById('edit_actif').checked = classe.actif;
      
      document.querySelectorAll('#editClasseForm input[type="checkbox"][name="semestres[]"]').forEach(cb => {
        cb.checked = classe.semestres.includes(parseInt(cb.value));
      });
      
      const modal = new bootstrap.Modal(document.getElementById('editClasseModal'));
      modal.show();
    } else {
      alert('Erreur lors du chargement de la classe.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Erreur lors du chargement de la classe.');
  });
}

function updateClasse() {
  const form = document.getElementById('editClasseForm');
  const formData = new FormData(form);
  const classeId = formData.get('classe_id');
  
  const semestres = formData.getAll('semestres[]');
  if (semestres.length === 0) {
    alert('Veuillez sélectionner au moins un semestre.');
    return;
  }
  
  const data = {
    code: formData.get('code') || null,
    filiere: formData.get('filiere'),
    niveau_etude: formData.get('niveau_etude'),
    description: formData.get('description') || null,
    semestres: semestres.map(s => parseInt(s)),
    actif: formData.get('actif') === 'on'
  };
  
  fetch(`{{ route('admin.classes.update', ':id') }}`.replace(':id', classeId), {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json'
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Erreur: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Erreur lors de la modification de la classe.');
  });
}

function deleteClasse(event, form) {
  event.preventDefault();
  if (confirm('Êtes-vous sûr de vouloir supprimer cette classe ? Cette action est irréversible.')) {
    const formData = new FormData(form);
    fetch(form.action, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': formData.get('_token'),
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        location.reload();
      } else {
        alert('Erreur: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Erreur lors de la suppression de la classe.');
    });
  }
}

function toggleBlockClasse(event, form) {
  event.preventDefault();
  const formData = new FormData(form);
  fetch(form.action, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': formData.get('_token'),
      'Accept': 'application/json'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Erreur: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Erreur lors de la modification du statut de la classe.');
  });
}
</script>
@endpush

@endsection
