@extends('layouts.admin')

@include('components.delete-modal-handler')

@section('title', 'Paiements')
@section('breadcrumb', 'Paiements')
@section('page-title', 'Gestion des Paiements')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('tableSearchInput');
  const tableBody = document.getElementById('paiementsTableBody');
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
        // C'est la ligne "Aucun paiement"
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
    
    // Afficher/masquer la ligne "Aucun paiement trouvé"
    const emptyRow = tableBody.querySelector('tr td[colspan]');
    if (emptyRow) {
      const emptyRowParent = emptyRow.closest('tr');
      if (term === '') {
        if (visibleCount === 0 && allRows.length === 1) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun paiement enregistré';
        } else {
          emptyRowParent.style.display = 'none';
        }
      } else {
        if (visibleCount === 0) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun paiement trouvé pour "' + searchTerm + '"';
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

@push('styles')
<style>
  /* Styles pour les icônes d'action */
  .table td .btn-link.action-btn .ni-single-02,
  .table td button.btn-link.action-btn .ni-single-02 {
    color: #17a2b8 !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #17a2b8 !important;
  }
  
  .table td .btn-link.action-btn .bi-pencil,
  .table td button.btn-link.action-btn .bi-pencil {
    color: #5e72e4 !important;
    opacity: 1 !important;
  }
  
  .table td button.btn-link.action-btn .bi-trash {
    color: #f5365c !important;
    opacity: 1 !important;
  }
  
  .table td .btn-link.action-btn,
  .table td button.btn-link.action-btn {
    opacity: 1 !important;
  }
  
  .table td .btn-link.action-btn .ni,
  .table td button.btn-link.action-btn .ni,
  .table td .btn-link.action-btn .bi,
  .table td button.btn-link.action-btn .bi {
    visibility: visible !important;
    display: inline-block !important;
    color: inherit !important;
  }
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Liste des Paiements</h5>
          <a href="{{ route('admin.paiements.create') }}" class="btn btn-primary btn-sm mb-0">
            <i class="ni ni-fat-add"></i> Nouveau Paiement
          </a>
        </div>
      </div>
      <div class="card-body px-0 pt-6 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size: .85rem;">PAIEMENT</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2" style="font-size: .85rem;">NOM</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder ps-2" style="font-size: .85rem;">PRÉNOM</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder" style="font-size: .85rem;">MONTANT</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder" style="font-size: .85rem;">DATE</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder" style="font-size: .85rem;">HEURE</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder" style="font-size: .85rem;">MÉTHODE</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder" style="font-size: .85rem;">STATUT</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody id="paiementsTableBody">
              @forelse($paiements as $paiement)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="icon icon-shape icon-sm bg-gradient-warning text-center border-radius-md">
                        <i class="ni ni-money-coins text-white opacity-10"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-3">
                      <h6 class="mb-0 text-xs">Paiement #{{ $paiement->id }}</h6>
                      <p class="text-xs text-secondary mb-0">Utilisateur ID: {{ $paiement->id }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $paiement->nom ?? 'N/A' }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $paiement->prenom ?? 'N/A' }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-xs font-weight-bold">{{ number_format($paiement->montant_paye ?? 0, 0, ',', ' ') }} FCFA</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ isset($paiement->date_paiement) ? \Illuminate\Support\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : 'N/A' }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ isset($paiement->date_paiement) ? \Illuminate\Support\Carbon::parse($paiement->date_paiement)->format('H:i') : 'N/A' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $paiement->paiement_method ?? 'N/A' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm {{ ($paiement->paiement_statut ?? '') === 'effectué' ? 'badge-success' : 'badge-secondary' }}">{{ ucfirst($paiement->paiement_statut ?? 'en attente') }}</span>
                </td>
                <td class="align-middle">
                  <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.paiements.show', $paiement->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Voir les détails" style="color: #17a2b8 !important; opacity: 1 !important;">
                      <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                    </a>
                    <a href="{{ route('admin.paiements.edit', $paiement->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Modifier" style="color: #5e72e4 !important; opacity: 1 !important;">
                      <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important; -webkit-text-fill-color: #5e72e4 !important;"></i>
                    </a>
                    <button type="button" 
                            class="btn btn-link action-btn p-2 mb-0" 
                            data-toggle="modal" 
                            data-target="#deleteConfirmModal{{ $paiement->id }}" 
                            data-original-title="Supprimer" 
                            style="color: #f5365c !important; opacity: 1 !important;">
                      <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                    </button>
                    @include('components.delete-confirm-modal', [
                      'id' => $paiement->id,
                      'action' => route('admin.paiements.destroy', $paiement->id),
                      'message' => 'Êtes-vous sûr de vouloir supprimer ce paiement ?'
                    ])
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" class="text-center py-4">
                  <p class="text-xs text-secondary mb-0">Aucun paiement trouvé</p>
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
