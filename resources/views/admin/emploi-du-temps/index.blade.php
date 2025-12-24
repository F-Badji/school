@extends('layouts.admin')

@include('components.delete-modal-handler')

@section('title', 'Emploi du temps')
@section('breadcrumb', 'Emploi du temps')
@section('page-title', 'Gestion des Emplois du Temps')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('tableSearchInput');
  const tableBody = document.getElementById('emploisTableBody');
  const clearBtn = document.getElementById('clearTableSearchBtn');
  
  if (!searchInput || !tableBody) return;
  
  // Récupérer toutes les lignes du tableau
  const allRows = Array.from(tableBody.querySelectorAll('tr'));
  
  // Fonction de filtrage
  function filterTable(searchTerm) {
    const term = searchTerm.toLowerCase().trim();
    let visibleCount = 0;
    
    allRows.forEach(row => {
      if (row.querySelector('td[colspan]')) {
        // C'est la ligne "Aucun emploi du temps"
        return;
      }
      
      const text = row.textContent.toLowerCase();
      const isVisible = term === '' || text.includes(term);
      
      if (isVisible) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });
    
    // Afficher/masquer la ligne "Aucun emploi du temps trouvé"
    const emptyRow = tableBody.querySelector('tr td[colspan]');
    if (emptyRow) {
      const emptyRowParent = emptyRow.closest('tr');
      if (term === '') {
        if (visibleCount === 0 && allRows.length === 1) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun emploi du temps enregistré';
        } else {
          emptyRowParent.style.display = 'none';
        }
      } else {
        if (visibleCount === 0) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun emploi du temps trouvé pour "' + searchTerm + '"';
        } else {
          emptyRowParent.style.display = 'none';
        }
      }
    }
  }
  
  // Filtrer en temps réel pendant la saisie (filtrage instantané)
  searchInput.addEventListener('input', function() {
    filterTable(this.value);
    
    // Afficher/masquer le bouton effacer - identique à Mes Notes
    if (clearBtn) {
      if (this.value.trim() !== '') {
        clearBtn.style.display = '';
      } else {
        clearBtn.style.display = 'none';
      }
    }
  });
  
  // Bouton effacer
  if (clearBtn) {
    clearBtn.addEventListener('click', function() {
      searchInput.value = '';
      filterTable('');
      this.style.display = 'none';
      searchInput.focus();
    });
    
    // Masquer le bouton si le champ est vide au chargement
    if (searchInput.value.trim() === '') {
      clearBtn.style.display = 'none';
    }
  }
  
  // Filtrer au chargement si une recherche existe déjà
  if (searchInput.value.trim() !== '') {
    filterTable(searchInput.value);
  }
});
</script>
@endpush

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Liste des emplois du temps</h6>
        <a href="{{ route('admin.emploi-du-temps.create') }}" class="btn btn-primary btn-sm">
          <i class="ni ni-fat-add"></i> Ajouter un emploi du temps
        </a>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Classe</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Type de fichier</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Date d'ajout</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Actions</th>
              </tr>
            </thead>
            <tbody id="emploisTableBody">
              @forelse($emplois as $emploi)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="icon icon-shape icon-sm bg-gradient-info text-center border-radius-md">
                        <i class="ni ni-calendar-grid-58 text-white opacity-10"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-3">
                      <h6 class="mb-0 text-xs">
                        @php
                          $classeLabels = [
                            'licence_1' => 'Licence 1',
                            'licence_2' => 'Licence 2',
                            'licence_3' => 'Licence 3'
                          ];
                          $classeLabel = $classeLabels[$emploi->classe] ?? ucfirst(str_replace('_', ' ', $emploi->classe));
                        @endphp
                        {{ $classeLabel }}
                      </h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">
                    <span class="badge badge-sm bg-gradient-secondary">{{ strtoupper($emploi->type_fichier ?? 'N/A') }}</span>
                  </p>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $emploi->created_at->format('d/m/Y H:i') }}</span>
                </td>
                <td class="align-middle text-center">
                  <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ asset('storage/' . $emploi->fichier) }}" target="_blank" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Voir le fichier" style="color: #17a2b8 !important; opacity: 1 !important;">
                      <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                    </a>
                    <button type="button" 
                            class="btn btn-link action-btn p-2 mb-0" 
                            data-toggle="modal" 
                            data-target="#deleteConfirmModal{{ $emploi->id }}" 
                            data-original-title="Supprimer" 
                            style="color: #f5365c !important; opacity: 1 !important;">
                      <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                    </button>
                    @include('components.delete-confirm-modal', [
                      'id' => $emploi->id,
                      'action' => route('admin.emploi-du-temps.destroy', $emploi->id),
                      'message' => 'Êtes-vous sûr de vouloir supprimer cet emploi du temps ?'
                    ])
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center py-4">
                  <p class="text-xs text-secondary mb-0">Aucun emploi du temps enregistré</p>
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
@endsection









