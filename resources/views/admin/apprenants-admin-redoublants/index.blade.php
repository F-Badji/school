@extends('layouts.admin')

@section('title', 'Apprenants')
@section('breadcrumb', 'Apprenants')
@section('page-title', 'Gestion des Apprenants - Admis & Redoublants')

@include('components.delete-modal-handler')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Liste des Apprenants</h6>
          <div class="d-flex gap-2">
            <div class="input-group" style="min-width: 300px;">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" 
                     id="tableSearchInput"
                     class="form-control" 
                     placeholder="Rechercher un apprenant..." 
                     autocomplete="off">
              <button type="button" id="clearTableSearchBtn" class="btn btn-outline-secondary" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem; display: none;">
                <i class="fas fa-times"></i>
              </button>
            </div>
            <div class="btn-group" role="group">
              <a href="{{ route('admin.apprenants-admin-redoublants.index', ['type' => 'admin']) }}" 
                 class="btn btn-sm {{ request('type') === 'admin' ? 'btn-primary' : 'btn-outline-primary' }}">
                Admis
              </a>
              <a href="{{ route('admin.apprenants-admin-redoublants.index', ['type' => 'redoublant']) }}" 
                 class="btn btn-sm {{ request('type') === 'redoublant' ? 'btn-primary' : 'btn-outline-primary' }}">
                Redoublants
              </a>
              <a href="{{ route('admin.apprenants-admin-redoublants.index') }}" 
                 class="btn btn-sm {{ !request('type') ? 'btn-primary' : 'btn-outline-primary' }}">
                Tous
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Photo</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Nom & Prénom</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Email</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Téléphone</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Classe</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Filière</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Année Académique</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Type</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Statut</th>
                <th class="text-secondary opacity-7">Actions</th>
              </tr>
            </thead>
            <tbody id="apprenantsTableBody">
              @forelse($apprenants as $apprenant)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      @if($apprenant->photo)
                        <img src="{{ asset('storage/' . $apprenant->photo) }}" class="avatar avatar-sm me-3" alt="user image">
                      @else
                        <div class="avatar avatar-sm me-3 bg-gradient-primary">
                          <span class="text-white text-xs font-weight-bold">
                            {{ strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1)) }}
                          </span>
                        </div>
                      @endif
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">{{ $apprenant->prenom ?? '' }} {{ $apprenant->nom ?? '' }}</h6>
                    <p class="text-xs text-secondary mb-0">{{ $apprenant->matricule ?? 'N/A' }}</p>
                  </div>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->email ?? 'N/A' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->phone ?? 'N/A' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">
                    {{ $apprenant->niveau_etude ?? 'N/A' }}
                  </span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->filiere ?? 'N/A' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">
                    {{ $apprenant->annee_academique ?? ($apprenant->created_at ? $apprenant->created_at->format('Y') . '-' . ($apprenant->created_at->format('Y') + 1) : 'N/A') }}
                  </span>
                </td>
                <td class="align-middle text-center">
                  @if($apprenant->est_promu)
                    <span class="badge badge-sm bg-gradient-success">Admis</span>
                  @elseif($apprenant->est_redoublant)
                    <span class="badge badge-sm bg-gradient-warning">Redoublant</span>
                  @else
                    <span class="badge badge-sm bg-gradient-secondary">Normal</span>
                  @endif
                </td>
                <td class="align-middle text-center text-sm">
                  @if($apprenant->statut === 'actif')
                    <span class="badge badge-sm bg-gradient-success">Actif</span>
                  @elseif($apprenant->statut === 'bloque')
                    <span class="badge badge-sm bg-gradient-danger">Bloqué</span>
                  @else
                    <span class="badge badge-sm bg-gradient-secondary">En attente</span>
                  @endif
                </td>
                <td class="align-middle">
                  <div class="d-flex gap-2 justify-content-center align-items-center">
                    <a href="{{ route('admin.apprenants-admin-redoublants.show', $apprenant->id) }}" 
                       class="btn btn-link action-btn p-2 mb-0" 
                       data-toggle="tooltip" 
                       data-original-title="Voir les détails" 
                       style="color: #17a2b8 !important; opacity: 1 !important;">
                      <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important;"></i>
                    </a>
                    <a href="{{ route('admin.apprenants-admin-redoublants.edit', $apprenant->id) }}" 
                       class="btn btn-link action-btn p-2 mb-0" 
                       data-toggle="tooltip" 
                       data-original-title="Modifier" 
                       style="color: #5e72e4 !important; opacity: 1 !important;">
                      <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important;"></i>
                    </a>
                    <form action="{{ route('admin.apprenants-admin-redoublants.mark-admis', $apprenant->id) }}" 
                          method="POST" 
                          class="d-inline" 
                          onsubmit="return confirm('Marquer cet apprenant comme admis (promu) ?');">
                      @csrf
                      <button type="submit" 
                              class="btn btn-link action-btn p-2 mb-0" 
                              data-toggle="tooltip" 
                              data-original-title="Marquer comme Admis" 
                              style="color: #28a745 !important; opacity: 1 !important;">
                        <i class="ni ni-check-bold text-lg" aria-hidden="true" style="color: #28a745 !important; opacity: 1 !important;"></i>
                      </button>
                    </form>
                    <form action="{{ route('admin.apprenants-admin-redoublants.mark-redoublant', $apprenant->id) }}" 
                          method="POST" 
                          class="d-inline" 
                          onsubmit="return confirm('Marquer cet apprenant comme redoublant ?');">
                      @csrf
                      <button type="submit" 
                              class="btn btn-link action-btn p-2 mb-0" 
                              data-toggle="tooltip" 
                              data-original-title="Marquer comme Redoublant" 
                              style="color: #ffc107 !important; opacity: 1 !important;">
                        <i class="ni ni-refresh text-lg" aria-hidden="true" style="color: #ffc107 !important; opacity: 1 !important;"></i>
                      </button>
                    </form>
                    <button type="button" 
                            class="btn btn-link action-btn p-2 mb-0" 
                            data-toggle="modal" 
                            data-target="#deleteConfirmModal{{ $apprenant->id }}" 
                            data-original-title="Supprimer" 
                            style="color: #f5365c !important; opacity: 1 !important;">
                      <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important;"></i>
                    </button>
                    @include('components.delete-confirm-modal', [
                      'id' => $apprenant->id,
                      'action' => route('admin.apprenants-admin-redoublants.destroy', $apprenant->id),
                      'message' => 'Êtes-vous sûr de vouloir supprimer cet apprenant ?'
                    ])
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="10" class="text-center py-4">
                  <p class="text-muted mb-0">Aucun apprenant enregistré</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="card-footer px-3 py-2">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="text-sm text-secondary mb-0">
                Affichage de {{ $apprenants->firstItem() ?? 0 }} à {{ $apprenants->lastItem() ?? 0 }} sur {{ $apprenants->total() }} apprenants
              </p>
            </div>
            <div>
              {{ $apprenants->appends(request()->query())->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

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
  
  /* Admis - Vert - Force opacité et couleur (Nucleo ni-check-bold) */
  .table td button.btn-link.action-btn .ni-check-bold {
    color: #28a745 !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #28a745 !important;
  }
  
  /* Redoublant - Jaune - Force opacité et couleur (Nucleo ni-refresh) */
  .table td button.btn-link.action-btn .ni-refresh {
    color: #ffc107 !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #ffc107 !important;
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
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    color: inherit !important;
  }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('tableSearchInput');
  const tableBody = document.getElementById('apprenantsTableBody');
  const clearBtn = document.getElementById('clearTableSearchBtn');
  
  if (!searchInput || !tableBody) return;
  
  const allRows = Array.from(tableBody.querySelectorAll('tr'));
  
  function filterTable(searchTerm) {
    const term = searchTerm.toLowerCase().trim();
    let visibleCount = 0;
    
    allRows.forEach(row => {
      if (row.querySelector('td[colspan]')) {
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
    
    const emptyRow = tableBody.querySelector('tr td[colspan]');
    if (emptyRow) {
      const emptyRowParent = emptyRow.closest('tr');
      if (term === '') {
        if (visibleCount === 0 && allRows.length === 1) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun apprenant enregistré';
        } else {
          emptyRowParent.style.display = 'none';
        }
      } else {
        if (visibleCount === 0) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun apprenant trouvé pour "' + searchTerm + '"';
        } else {
          emptyRowParent.style.display = 'none';
        }
      }
    }
  }
  
  searchInput.addEventListener('input', function() {
    filterTable(this.value);
    
    if (clearBtn) {
      if (this.value.trim() !== '') {
        clearBtn.style.display = '';
      } else {
        clearBtn.style.display = 'none';
      }
    }
  });
  
  if (clearBtn) {
    clearBtn.addEventListener('click', function() {
      searchInput.value = '';
      filterTable('');
      this.style.display = 'none';
      searchInput.focus();
    });
    
    if (searchInput.value.trim() === '') {
      clearBtn.style.display = 'none';
    }
  }
  
  if (searchInput.value.trim() !== '') {
    filterTable(searchInput.value);
  }
});
</script>
@endpush

