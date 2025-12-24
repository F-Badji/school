@extends('layouts.admin')

@section('title', 'Apprenants')
@section('breadcrumb', 'Apprenants')
@section('page-title', 'Gestion des Apprenants')

@include('components.delete-modal-handler')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('tableSearchInput');
  const tableBody = document.getElementById('apprenantsTableBody');
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
        // C'est la ligne "Aucun apprenant"
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
    
    // Afficher/masquer la ligne "Aucun apprenant trouvé"
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
  
  /* Bloquer - Vert/Orange - Force opacité et couleur (Nucleo ni-lock-circle-open) */
  .table td button.btn-link.action-btn .ni-lock-circle-open:not(.warning) {
    color: #28a745 !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #28a745 !important;
  }
  .table td button.btn-link.action-btn .ni-lock-circle-open.warning {
    color: #fb6340 !important;
    opacity: 1 !important;
    -webkit-text-fill-color: #fb6340 !important;
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

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Liste des Apprenants</h5>
          <a href="{{ route('admin.apprenants.create') }}" class="btn btn-primary btn-sm mb-0">
            <i class="ni ni-fat-add"></i> Nouvel Apprenant
          </a>
        </div>
      </div>
      <div class="card-body px-0 pt-6 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Matricule</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Prénom</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2" style="font-size: 0.75rem; color: #344767 !important;">Nom</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2" style="font-size: 0.75rem; color: #344767 !important;">Email</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2" style="font-size: 0.75rem; color: #344767 !important;">Téléphone</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2" style="font-size: 0.75rem; color: #344767 !important;">Ville</th>
                <th class="text-uppercase text-secondary text-xs font-weight-bold ps-2" style="font-size: 0.75rem; color: #344767 !important;">Nationalité</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Classe</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Filière</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Catégorie de formation</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Date de naissance</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Date d'inscription</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Diplôme</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Carte d'identité</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Pourquoi souhaitez-vous suivre ces cours ?</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Comment avez-vous entendu parler de cette formation ?</th>
                <th class="text-center text-uppercase text-secondary text-xs font-weight-bold" style="font-size: 0.75rem; color: #344767 !important;">Statut</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody id="apprenantsTableBody">
              @forelse($apprenants as $apprenant)
              <tr>
                <td class="text-center">
                  <p class="text-xs font-weight-bold mb-0">{{ $apprenant->matricule ?? 'N/A' }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $apprenant->prenom ?? 'N/A' }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $apprenant->nom ?? 'N/A' }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $apprenant->email }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $apprenant->phone ?? 'N/A' }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $apprenant->location ?? 'N/A' }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">
                    @if($apprenant->nationalite)
                      @php
                        $countryFlags = [
                          'AF' => '🇦🇫', 'ZA' => '🇿🇦', 'AL' => '🇦🇱', 'DZ' => '🇩🇿', 'DE' => '🇩🇪', 'AD' => '🇦🇩', 'AO' => '🇦🇴', 'AG' => '🇦🇬', 'SA' => '🇸🇦', 'AR' => '🇦🇷',
                          'AM' => '🇦🇲', 'AU' => '🇦🇺', 'AT' => '🇦🇹', 'AZ' => '🇦🇿', 'BS' => '🇧🇸', 'BH' => '🇧🇭', 'BD' => '🇧🇩', 'BB' => '🇧🇧', 'BE' => '🇧🇪', 'BZ' => '🇧🇿',
                          'BJ' => '🇧🇯', 'BT' => '🇧🇹', 'BY' => '🇧🇾', 'MM' => '🇲🇲', 'BO' => '🇧🇴', 'BA' => '🇧🇦', 'BW' => '🇧🇼', 'BR' => '🇧🇷', 'BN' => '🇧🇳', 'BG' => '🇧🇬',
                          'BF' => '🇧🇫', 'BI' => '🇧🇮', 'KH' => '🇰🇭', 'CM' => '🇨🇲', 'CA' => '🇨🇦', 'CV' => '🇨🇻', 'CL' => '🇨🇱', 'CN' => '🇨🇳', 'CY' => '🇨🇾', 'CO' => '🇨🇴',
                          'KM' => '🇰🇲', 'CG' => '🇨🇬', 'CD' => '🇨🇩', 'KR' => '🇰🇷', 'KP' => '🇰🇵', 'CR' => '🇨🇷', 'CI' => '🇨🇮', 'HR' => '🇭🇷', 'CU' => '🇨🇺', 'DK' => '🇩🇰',
                          'DJ' => '🇩🇯', 'DM' => '🇩🇲', 'EG' => '🇪🇬', 'AE' => '🇦🇪', 'EC' => '🇪🇨', 'ER' => '🇪🇷', 'ES' => '🇪🇸', 'EE' => '🇪🇪', 'SZ' => '🇸🇿', 'US' => '🇺🇸',
                          'ET' => '🇪🇹', 'FJ' => '🇫🇯', 'FI' => '🇫🇮', 'FR' => '🇫🇷', 'GA' => '🇬🇦', 'GM' => '🇬🇲', 'GE' => '🇬🇪', 'GH' => '🇬🇭', 'GR' => '🇬🇷', 'GD' => '🇬🇩',
                          'GT' => '🇬🇹', 'GN' => '🇬🇳', 'GW' => '🇬🇼', 'GQ' => '🇬🇶', 'GY' => '🇬🇾', 'HT' => '🇭🇹', 'HN' => '🇭🇳', 'HU' => '🇭🇺', 'IN' => '🇮🇳', 'ID' => '🇮🇩',
                          'IQ' => '🇮🇶', 'IR' => '🇮🇷', 'IE' => '🇮🇪', 'IS' => '🇮🇸', 'IL' => '🇮🇱', 'IT' => '🇮🇹', 'JM' => '🇯🇲', 'JP' => '🇯🇵', 'JO' => '🇯🇴', 'KZ' => '🇰🇿',
                          'KE' => '🇰🇪', 'KG' => '🇰🇬', 'KI' => '🇰🇮', 'KW' => '🇰🇼', 'LA' => '🇱🇦', 'LS' => '🇱🇸', 'LV' => '🇱🇻', 'LB' => '🇱🇧', 'LR' => '🇱🇷', 'LY' => '🇱🇾',
                          'LI' => '🇱🇮', 'LT' => '🇱🇹', 'LU' => '🇱🇺', 'MG' => '🇲🇬', 'MW' => '🇲🇼', 'MY' => '🇲🇾', 'MV' => '🇲🇻', 'ML' => '🇲🇱', 'MT' => '🇲🇹', 'MA' => '🇲🇦',
                          'MU' => '🇲🇺', 'MR' => '🇲🇷', 'MX' => '🇲🇽', 'MD' => '🇲🇩', 'MC' => '🇲🇨', 'MN' => '🇲🇳', 'ME' => '🇲🇪', 'MZ' => '🇲🇿', 'NA' => '🇳🇦', 'NR' => '🇳🇷',
                          'NP' => '🇳🇵', 'NI' => '🇳🇮', 'NE' => '🇳🇪', 'NG' => '🇳🇬', 'NO' => '🇳🇴', 'NZ' => '🇳🇿', 'OM' => '🇴🇲', 'UG' => '🇺🇬', 'UZ' => '🇺🇿', 'PK' => '🇵🇰',
                          'PW' => '🇵🇼', 'PA' => '🇵🇦', 'PG' => '🇵🇬', 'PY' => '🇵🇾', 'NL' => '🇳🇱', 'PE' => '🇵🇪', 'PH' => '🇵🇭', 'PL' => '🇵🇱', 'PT' => '🇵🇹', 'QA' => '🇶🇦',
                          'RO' => '🇷🇴', 'GB' => '🇬🇧', 'RU' => '🇷🇺', 'RW' => '🇷🇼', 'KN' => '🇰🇳', 'LC' => '🇱🇨', 'VC' => '🇻🇨', 'SM' => '🇸🇲', 'ST' => '🇸🇹', 'SN' => '🇸🇳',
                          'RS' => '🇷🇸', 'SC' => '🇸🇨', 'SL' => '🇸🇱', 'SG' => '🇸🇬', 'SK' => '🇸🇰', 'SI' => '🇸🇮', 'SO' => '🇸🇴', 'SD' => '🇸🇩', 'SS' => '🇸🇸', 'LK' => '🇱🇰',
                          'SE' => '🇸🇪', 'CH' => '🇨🇭', 'SR' => '🇸🇷', 'SY' => '🇸🇾', 'TJ' => '🇹🇯', 'TW' => '🇹🇼', 'TZ' => '🇹🇿', 'TD' => '🇹🇩', 'CZ' => '🇨🇿', 'TH' => '🇹🇭',
                          'TL' => '🇹🇱', 'TG' => '🇹🇬', 'TO' => '🇹🇴', 'TT' => '🇹🇹', 'TN' => '🇹🇳', 'TM' => '🇹🇲', 'TR' => '🇹🇷', 'TV' => '🇹🇻', 'UA' => '🇺🇦', 'UY' => '🇺🇾',
                          'VU' => '🇻🇺', 'VA' => '🇻🇦', 'VE' => '🇻🇪', 'VN' => '🇻🇳', 'YE' => '🇾🇪', 'ZM' => '🇿🇲', 'ZW' => '🇿🇼'
                        ];
                        $flag = $countryFlags[$apprenant->nationalite] ?? '';
                      @endphp
                      {{ $flag }} {{ $apprenant->nationalite }}
                    @else
                      N/A
                    @endif
                  </p>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($apprenant->niveau_etude)
                    <span class="badge badge-sm bg-gradient-primary">{{ $apprenant->niveau_etude }}</span>
                  @elseif($apprenant->classe_id)
                    @php
                      $classeLabels = [
                        'licence_1' => 'Licence 1',
                        'licence_2' => 'Licence 2',
                        'licence_3' => 'Licence 3'
                      ];
                      $classeLabel = $classeLabels[$apprenant->classe_id] ?? ucfirst(str_replace('_', ' ', $apprenant->classe_id));
                    @endphp
                    <span class="badge badge-sm bg-gradient-primary">{{ $classeLabel }}</span>
                  @else
                    <span class="badge badge-sm bg-gradient-primary">N/A</span>
                  @endif
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->filiere ?? '-' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->categorie_formation ?? '-' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->date_naissance ? $apprenant->date_naissance->format('d/m/Y') : 'N/A' }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->created_at->format('d/m/Y') }}</span>
                </td>
                <td class="align-middle text-center">
                  @if($apprenant->diplome)
                    <a href="{{ asset('storage/' . $apprenant->diplome) }}" target="_blank" class="btn btn-sm btn-outline-info mb-0" data-toggle="tooltip" data-original-title="Voir le diplôme">
                      <i class="ni ni-paper-diploma"></i>
                    </a>
                  @else
                    <span class="text-secondary text-xs">-</span>
                  @endif
                </td>
                <td class="align-middle text-center">
                  @if($apprenant->carte_identite)
                    <a href="{{ asset('storage/' . $apprenant->carte_identite) }}" target="_blank" class="btn btn-sm btn-outline-info mb-0" data-toggle="tooltip" data-original-title="Voir la carte d'identité">
                      <i class="ni ni-badge"></i>
                    </a>
                  @else
                    <span class="text-secondary text-xs">-</span>
                  @endif
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold" style="max-width: 200px; display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $apprenant->motivation ?? '' }}">
                    {{ $apprenant->motivation ? (strlen($apprenant->motivation) > 50 ? substr($apprenant->motivation, 0, 50) . '...' : $apprenant->motivation) : '-' }}
                  </span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $apprenant->canal_decouverte ?? '-' }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-{{ $apprenant->statut === 'actif' ? 'success' : ($apprenant->statut === 'bloque' ? 'danger' : 'warning') }}">
                    {{ ucfirst($apprenant->statut ?? 'actif') }}
                  </span>
                </td>
                <td class="align-middle">
                  <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.apprenants.show', $apprenant) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Voir les détails" style="color: #17a2b8 !important; opacity: 1 !important;">
                      <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                    </a>
                    <a href="{{ route('admin.apprenants.edit', $apprenant) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Modifier" style="color: #5e72e4 !important; opacity: 1 !important;">
                      <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important; -webkit-text-fill-color: #5e72e4 !important;"></i>
                    </a>
                    @if($apprenant->statut === 'bloque')
                      <form action="{{ route('admin.apprenants.toggle-block', $apprenant) }}" method="POST" class="d-inline">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="action" value="unblock">
                        <button type="submit" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Débloquer" style="color: #28a745 !important; opacity: 1 !important;">
                          <i class="ni ni-lock-circle-open text-lg" aria-hidden="true" style="color: #28a745 !important; opacity: 1 !important; -webkit-text-fill-color: #28a745 !important;"></i>
                        </button>
                      </form>
                    @else
                      <button type="button" class="btn btn-link action-btn p-2 mb-0 block-btn" data-apprenant-id="{{ $apprenant->id }}" data-original-title="Bloquer" style="color: #fb6340 !important; opacity: 1 !important;">
                        <i class="ni ni-lock-circle-open text-lg warning" aria-hidden="true" style="color: #fb6340 !important; opacity: 1 !important; -webkit-text-fill-color: #fb6340 !important;"></i>
                      </button>
                      
                      <!-- Modal pour bloquer -->
                      <div class="modal fade" id="blockModal{{ $apprenant->id }}" tabindex="-1" role="dialog" aria-labelledby="blockModalLabel{{ $apprenant->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="blockModalLabel{{ $apprenant->id }}">Bloquer l'apprenant</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{ route('admin.apprenants.toggle-block', $apprenant) }}" method="POST">
                              @csrf
                              @method('POST')
                              <input type="hidden" name="action" value="block">
                              <div class="modal-body">
                                <div class="form-group">
                                  <label for="motif_blocage{{ $apprenant->id }}">Motif du blocage <span class="text-danger">*</span></label>
                                  <textarea class="form-control" id="motif_blocage{{ $apprenant->id }}" name="motif_blocage" rows="4" placeholder="Veuillez saisir le motif du blocage..." required></textarea>
                                  <small class="form-text text-muted">Ce motif sera affiché à l'apprenant lors de sa tentative de connexion.</small>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Bloquer l'apprenant</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    @endif
                    <button type="button" 
                            class="btn btn-link action-btn p-2 mb-0" 
                            data-toggle="modal" 
                            data-target="#deleteConfirmModal{{ $apprenant->id }}" 
                            data-original-title="Supprimer" 
                            style="color: #f5365c !important; opacity: 1 !important;">
                      <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                    </button>
                    @include('components.delete-confirm-modal', [
                      'id' => $apprenant->id,
                      'action' => route('admin.apprenants.destroy', $apprenant),
                      'message' => 'Êtes-vous sûr de vouloir supprimer cet apprenant ?'
                    ])
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="17" class="text-center py-4">
                  <p class="text-xs text-secondary mb-0">Aucun apprenant trouvé</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if($apprenants->hasPages())
        <div class="card-footer px-3 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <p class="text-xs text-secondary mb-0">Affichage de {{ $apprenants->firstItem() }} à {{ $apprenants->lastItem() }} sur {{ $apprenants->total() }} apprenants</p>
            <div>
              {{ $apprenants->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    console.log('[ICONS DEBUG] Script de force des couleurs démarré');
    
    // Forcer les couleurs des icônes après le chargement
    function forceIconColors() {
      console.log('[ICONS DEBUG] Force des couleurs en cours...');
      
      // Icône Voir (Cyan) - Nucleo ni-single-02
      const viewIcons = document.querySelectorAll('.ni-single-02');
      console.log('[ICONS DEBUG] Icônes Voir trouvées:', viewIcons.length);
      viewIcons.forEach((icon, index) => {
        const computedStyle = window.getComputedStyle(icon);
        console.log(`[ICONS DEBUG] Icône Voir ${index + 1}:`, {
          color: computedStyle.color,
          opacity: computedStyle.opacity,
          classes: icon.className,
          parentColor: icon.parentElement ? window.getComputedStyle(icon.parentElement).color : 'N/A'
        });
        icon.style.color = '#17a2b8';
        icon.style.opacity = '1';
        icon.style.webkitTextFillColor = '#17a2b8';
        if (icon.parentElement) {
          icon.parentElement.style.color = '#17a2b8';
          icon.parentElement.style.opacity = '1';
        }
      });
      
      // Icône Modifier (Bleu) - Bootstrap Icons bi bi-pencil
      const editIcons = document.querySelectorAll('.bi-pencil');
      editIcons.forEach(icon => {
        icon.style.color = '#5e72e4';
        icon.style.opacity = '1';
        if (icon.parentElement) {
          icon.parentElement.style.color = '#5e72e4';
          icon.parentElement.style.opacity = '1';
        }
      });
      
      // Icône Supprimer (Rouge) - Bootstrap Icons bi bi-trash
      const deleteIcons = document.querySelectorAll('.bi-trash');
      deleteIcons.forEach(icon => {
        icon.style.color = '#f5365c';
        icon.style.opacity = '1';
        if (icon.parentElement) {
          icon.parentElement.style.color = '#f5365c';
          icon.parentElement.style.opacity = '1';
        }
      });
      
      // Icône Bloquer (Vert/Orange) - Nucleo ni-lock-circle-open
      const blockIcons = document.querySelectorAll('.ni-lock-circle-open');
      console.log('[ICONS DEBUG] Icônes Bloquer trouvées:', blockIcons.length);
      blockIcons.forEach((icon, index) => {
        const isWarning = icon.classList.contains('warning');
        const color = isWarning ? '#fb6340' : '#28a745';
        const computedStyle = window.getComputedStyle(icon);
        console.log(`[ICONS DEBUG] Icône Bloquer ${index + 1}:`, {
          color: computedStyle.color,
          opacity: computedStyle.opacity,
          classes: icon.className,
          isWarning: isWarning,
          parentColor: icon.parentElement ? window.getComputedStyle(icon.parentElement).color : 'N/A'
        });
        icon.style.color = color;
        icon.style.opacity = '1';
        icon.style.webkitTextFillColor = color;
        if (icon.parentElement) {
          icon.parentElement.style.color = color;
          icon.parentElement.style.opacity = '1';
        }
      });
      
      console.log('[ICONS DEBUG] Force des couleurs terminée');
    }
    
    // Exécuter immédiatement
    forceIconColors();
    
    // Réexécuter après un court délai (au cas où d'autres scripts modifient)
    setTimeout(() => {
      console.log('[ICONS DEBUG] Réexécution après 100ms');
      forceIconColors();
    }, 100);
    setTimeout(() => {
      console.log('[ICONS DEBUG] Réexécution après 500ms');
      forceIconColors();
    }, 500);
    
    // Gestion des modals de blocage
    const blockButtons = document.querySelectorAll('.block-btn');
    blockButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const apprenantId = this.getAttribute('data-apprenant-id');
        const modal = document.getElementById('blockModal' + apprenantId);
        if (modal) {
          // Utiliser Bootstrap modal si disponible (Bootstrap 5)
          if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
          } else if (typeof $ !== 'undefined' && $.fn.modal) {
            // Fallback : utiliser jQuery si disponible (Bootstrap 4)
            $(modal).modal('show');
          } else {
            // Fallback : JavaScript vanilla
            openModalVanilla(modal, apprenantId);
          }
        }
      });
    });
    
    function openModalVanilla(modal, apprenantId) {
      // Afficher le modal
      modal.style.display = 'block';
      modal.classList.add('show');
      document.body.classList.add('modal-open');
      
      // Créer le backdrop
      let backdrop = document.getElementById('modalBackdrop' + apprenantId);
      if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.id = 'modalBackdrop' + apprenantId;
        document.body.appendChild(backdrop);
      }
      
      // Fermer le modal en cliquant sur le backdrop
      backdrop.addEventListener('click', function() {
        closeModalVanilla(modal, backdrop);
      });
      
      // Fermer le modal avec le bouton close
      const closeBtn = modal.querySelector('.close');
      if (closeBtn) {
        closeBtn.onclick = function() {
          closeModalVanilla(modal, backdrop);
        };
      }
      
      // Fermer le modal avec le bouton Annuler
      const cancelBtn = modal.querySelector('.btn-secondary');
      if (cancelBtn && cancelBtn.textContent.trim().includes('Annuler')) {
        cancelBtn.onclick = function(e) {
          e.preventDefault();
          closeModalVanilla(modal, backdrop);
        };
      }
    }
    
    function closeModalVanilla(modal, backdrop) {
      modal.style.display = 'none';
      modal.classList.remove('show');
      document.body.classList.remove('modal-open');
      if (backdrop && backdrop.parentNode) {
        backdrop.parentNode.removeChild(backdrop);
      }
    }
    
    // Gérer aussi les boutons avec data-dismiss="modal"
    document.addEventListener('click', function(e) {
      if (e.target.hasAttribute('data-dismiss') && e.target.getAttribute('data-dismiss') === 'modal') {
        const modal = e.target.closest('.modal');
        if (modal) {
          const backdrop = document.querySelector('.modal-backdrop.show');
          if (backdrop) {
            closeModalVanilla(modal, backdrop);
          }
        }
      }
    });
  });
</script>
@endpush
@endsection

