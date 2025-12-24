@extends('layouts.admin')

@include('components.delete-modal-handler')

@section('title', 'Matières')
@section('breadcrumb', 'Matières')
@section('page-title', 'Gestion des Matières')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('tableSearchInput');
  const tableBody = document.getElementById('matieresTableBody');
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
        // C'est la ligne "Aucune matière"
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
    
    // Afficher/masquer la ligne "Aucune matière trouvée"
    const emptyRow = tableBody.querySelector('tr td[colspan]');
    if (emptyRow) {
      const emptyRowParent = emptyRow.closest('tr');
      if (term === '') {
        if (visibleCount === 0 && allRows.length === 1) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucune matière enregistrée';
        } else {
          emptyRowParent.style.display = 'none';
        }
      } else {
        if (visibleCount === 0) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucune matière trouvée pour "' + searchTerm + '"';
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
  /* Voir - Cyan - Force opacité et couleur (Nucleo ni-single-02) */
  .table td .btn-link.action-btn .ni-single-02,
  .table td button.btn-link.action-btn .ni-single-02 {
    color: #17a2b8 !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #17a2b8 !important;
  }
  
  /* Modifier - Bleu - Force opacité et couleur (Bootstrap Icons bi bi-pencil) */
  .table td .btn-link.action-btn .bi-pencil,
  .table td button.btn-link.action-btn .bi-pencil {
    color: #5e72e4 !important;
    opacity: 1 !important;
  }
  
  /* Supprimer - Rouge - Force opacité et couleur (Bootstrap Icons bi bi-trash) */
  .table td button.btn-link.action-btn .bi-trash {
    color: #f5365c !important;
    opacity: 1 !important;
  }
  
  /* Force tous les boutons action à avoir une opacité de 1 */
  .table td .btn-link.action-btn,
  .table td button.btn-link.action-btn {
    opacity: 1 !important;
  }
  
  /* Force toutes les icônes Nucleo, Font Awesome et Bootstrap Icons à être visibles avec opacité 1 */
  .table td .btn-link.action-btn .ni,
  .table td button.btn-link.action-btn .ni,
  .table td .btn-link.action-btn .fas,
  .table td button.btn-link.action-btn .fas,
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
          <h5 class="mb-0">Liste des Matières</h5>
          <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary btn-sm mb-0">
            <i class="ni ni-fat-add"></i> Nouvelle Matière
          </a>
        </div>
      </div>
      <div class="card-body px-0 pt-6 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Matière</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2" style="font-size: 0.75rem; color: #344767 !important;">Filière</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Classe</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Date de création</th>
                <th class="text-secondary font-weight-bold opacity-7"></th>
              </tr>
            </thead>
            <tbody id="matieresTableBody">
              @forelse($matieres as $matiere)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="icon icon-shape icon-sm bg-gradient-info text-center border-radius-md">
                        <i class="ni ni-book-bookmark text-white opacity-10"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-3">
                      <h6 class="mb-0 text-xs">{{ $matiere->nom_matiere }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $matiere->filiere ?? 'Non spécifiée' }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $matiere->niveau_etude ?? 'Non spécifié' }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $matiere->created_at->format('d/m/Y') }}</span>
                </td>
                <td class="align-middle">
                  <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.matieres.show', $matiere) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Voir les détails" style="color: #17a2b8 !important; opacity: 1 !important;">
                      <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                    </a>
                    <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Modifier" style="color: #5e72e4 !important; opacity: 1 !important;">
                      <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important; -webkit-text-fill-color: #5e72e4 !important;"></i>
                    </a>
                    <button type="button" 
                            class="btn btn-link action-btn p-2 mb-0" 
                            data-toggle="modal" 
                            data-target="#deleteConfirmModal{{ $matiere->id }}" 
                            data-original-title="Supprimer" 
                            style="color: #f5365c !important; opacity: 1 !important;">
                      <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                    </button>
                    @include('components.delete-confirm-modal', [
                      'id' => $matiere->id,
                      'action' => route('admin.matieres.destroy', $matiere),
                      'message' => 'Êtes-vous sûr de vouloir supprimer cette matière ?'
                    ])
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4">
                  <div class="d-flex flex-column align-items-center">
                    <i class="ni ni-book-bookmark text-secondary mb-2" style="font-size: 3rem;"></i>
                    <p class="text-xs text-secondary mb-2">Aucune matière trouvée dans la base de données</p>
                    <a href="{{ route('admin.matieres.create') }}" class="btn btn-primary btn-sm">
                      <i class="ni ni-fat-add"></i> Créer la première matière
                    </a>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if($matieres->hasPages())
        <div class="card-footer px-3 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <p class="text-xs text-secondary mb-0">Affichage de {{ $matieres->firstItem() }} à {{ $matieres->lastItem() }} sur {{ $matieres->total() }} matières</p>
            <div>
              {{ $matieres->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
