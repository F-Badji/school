@extends('layouts.admin')

@section('title', 'Messages')
@section('breadcrumb', 'Messages')
@section('page-title', 'Messages entre Apprenants et Formateurs')

@include('components.delete-modal-handler')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('tableSearchInput');
  const tableBody = document.getElementById('messagesTableBody');
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
        // C'est la ligne "Aucun message"
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
    
    // Afficher/masquer la ligne "Aucun message trouvé"
    const emptyRow = tableBody.querySelector('tr td[colspan]');
    if (emptyRow) {
      const emptyRowParent = emptyRow.closest('tr');
      if (term === '') {
        if (visibleCount === 0 && allRows.length === 1) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun message enregistré';
        } else {
          emptyRowParent.style.display = 'none';
        }
      } else {
        if (visibleCount === 0) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun message trouvé pour "' + searchTerm + '"';
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
    <div class="card">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Liste des messages</h6>
      </div>
      <div class="card-body">
        <form method="GET" class="row g-3 mb-3">
          <div class="col-md-3">
            <label class="form-label">Du</label>
            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">Au</label>
            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">Étiquette</label>
            <select name="label" class="form-control">
              <option value="">Toutes</option>
              @foreach(['Normal','Signalement','Urgent'] as $lab)
                <option value="{{ $lab }}" {{ request('label')===$lab ? 'selected' : '' }}>{{ $lab }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Rôle expéditeur</label>
            <select name="sender_role" class="form-control">
              <option value="">Tous</option>
              @foreach(['apprenant','formateur','admin'] as $r)
                <option value="{{ $r }}" {{ request('sender_role')===$r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-outline-secondary me-2" type="submit">Filtrer</button>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-light">Réinitialiser</a>
          </div>
        </form>

        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">DATE</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">EXPÉDITEUR</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">DESTINATAIRE</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">MESSAGE</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">ÉTIQUETTE</th>
                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">ACTIONS</th>
              </tr>
            </thead>
            <tbody id="messagesTableBody">
              @forelse($messages as $m)
                <tr>
                  <td class="text-xs">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                  <td class="text-xs"><a href="{{ route('admin.messages.thread', [$m->sender_id, $m->receiver_id]) }}">{{ $m->sender->name ?? 'N/A' }} ({{ $m->sender->role ?? 'apprenant' }})</a></td>
                  <td class="text-xs"><a href="{{ route('admin.messages.thread', [$m->sender_id, $m->receiver_id]) }}">{{ $m->receiver->name ?? 'N/A' }} ({{ $m->receiver->role ?? 'apprenant' }})</a></td>
                  <td class="text-xs" style="max-width:480px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $m->content }}</td>
                  <td>
                    @php $label = $m->label; @endphp
                    <span class="badge {{ $label==='Urgent' ? 'bg-danger' : ($label==='Signalement' ? 'bg-warning' : 'bg-secondary') }}">{{ $label }}</span>
                  </td>
                  <td class="align-middle">
                    <div class="d-flex gap-2 justify-content-center">
                      <a href="{{ route('admin.messages.show', $m->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Voir les détails" style="color: #17a2b8 !important; opacity: 1 !important;">
                        <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                      </a>
                      <a href="{{ route('admin.messages.edit', $m->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Modifier" style="color: #5e72e4 !important; opacity: 1 !important;">
                        <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important; -webkit-text-fill-color: #5e72e4 !important;"></i>
                      </a>
                      <button type="button" class="btn btn-link action-btn p-2 mb-0" data-toggle="modal" data-target="#deleteConfirmModal{{ $m->id }}" data-original-title="Supprimer" style="color: #f5365c !important; opacity: 1 !important;">
                        <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                      </button>
                      @include('components.delete-confirm-modal', [
                        'id' => $m->id,
                        'action' => route('admin.messages.destroy', $m->id),
                        'message' => 'Êtes-vous sûr de vouloir supprimer ce message ?'
                      ])
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="6" class="text-center py-4">Aucun message</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


