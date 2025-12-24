@extends('layouts.admin')

@include('components.delete-modal-handler')

@section('title', 'Calendrier')
@section('breadcrumb', 'Calendrier')
@section('page-title', 'Calendrier des Événements')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Programmer un événement</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.calendrier.store') }}">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Titre de l'événement</label>
              <input type="text" name="titre" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Type</label>
              <select name="type" class="form-control" required>
                <option value="Examen">Examen</option>
                <option value="Devoir">Devoir</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Date</label>
              <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Heure</label>
              <input type="time" name="heure" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Rappel (minutes avant)</label>
              <input type="number" name="rappel_minutes" class="form-control" placeholder="15">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Classe</label>
              <select name="classe" id="classe-select" class="form-control">
                <option value="">Sélectionner une classe</option>
                <option value="Licence 1">Licence 1</option>
                <option value="Licence 2">Licence 2</option>
                <option value="Licence 3">Licence 3</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Cours</label>
              <select name="cours_id" id="cours-select" class="form-control">
                <option value="">Sélectionnez d'abord une classe</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Calendrier</h6>
      </div>
      <div class="card-body">
        <div id="calendar-container">
          <div class="calendar-header d-flex justify-content-between align-items-center mb-4">
            <button id="prev-month" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
              <i class="bi bi-chevron-left" style="font-size: 1.2rem; color: #344767;"></i>
            </button>
            <h5 id="calendar-month-year" class="mb-0 text-dark fw-bold"></h5>
            <button id="next-month" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
              <i class="bi bi-chevron-right" style="font-size: 1.2rem; color: #344767;"></i>
            </button>
          </div>
          <div id="calendar-grid"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Liste des événements (conservée) -->
  <div class="col-12 mt-4">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0 text-dark fw-bold" style="font-size: 1.05rem;">Événements programmés</h6>
      </div>
      <div class="card-body px-0 pt-6 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">TITRE</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">TYPE</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">DATE & HEURE</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">CLASSE</th>
                <th class="text-uppercase text-dark text-xs font-weight-bolder" style="font-size:.85rem;">COURS</th>
                <th class="text-secondary font-weight-bold opacity-7"></th>
              </tr>
            </thead>
            <tbody id="evenementsTableBody">
              @forelse($events as $event)
                <tr>
                  <td>{{ $event->titre }}</td>
                  <td>{{ $event->type }}</td>
                  <td>{{ optional($event->scheduled_at)->format('d/m/Y H:i') }}</td>
                  <td>{{ $event->classe_id ?? '-' }}</td>
                  <td>
                    @if($event->cours_id)
                      @php
                        $matiere = \App\Models\Matiere::find($event->cours_id);
                      @endphp
                      {{ $matiere ? ($matiere->nom_matiere ?? $matiere->nom ?? 'Matière #' . $event->cours_id) : 'Matière #' . $event->cours_id }}
                    @else
                      -
                    @endif
                  </td>
                  <td class="align-middle">
                    <div class="d-flex gap-2 justify-content-end">
                      <a href="{{ route('admin.calendrier.show', $event->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Voir les détails" style="color: #17a2b8 !important; opacity: 1 !important;">
                        <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                      </a>
                      <a href="{{ route('admin.calendrier.edit', $event->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Modifier" style="color: #5e72e4 !important; opacity: 1 !important;">
                        <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important; -webkit-text-fill-color: #5e72e4 !important;"></i>
                      </a>
                      <button type="button" 
                              class="btn btn-link action-btn p-2 mb-0" 
                              data-toggle="modal" 
                              data-target="#deleteConfirmModal{{ $event->id }}" 
                              data-original-title="Supprimer" 
                              style="color: #f5365c !important; opacity: 1 !important;">
                        <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                      </button>
                      @include('components.delete-confirm-modal', [
                        'id' => $event->id,
                        'action' => route('admin.calendrier.destroy', $event->id),
                        'message' => 'Êtes-vous sûr de vouloir supprimer cet événement ?'
                      ])
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center py-4">Aucun événement programmé</td>
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
  
  #calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background-color: #e9ecef;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    overflow: hidden;
  }
  
  .calendar-day-header {
    background-color: #f8f9fa;
    padding: 12px;
    text-align: center;
    font-weight: 600;
    font-size: 0.875rem;
    color: #344767;
    border-bottom: 2px solid #e9ecef;
  }
  
  .calendar-day {
    background-color: #fff;
    padding: 12px 8px;
    min-height: 100px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.2s;
  }
  
  .calendar-day:hover {
    background-color: #f8f9fa;
  }
  
  .calendar-day.other-month {
    background-color: #f8f9fa;
    color: #adb5bd;
  }
  
  .calendar-day.today {
    background-color: #e3f2fd;
    border: 2px solid #2196f3;
  }
  
  .day-number {
    font-weight: 600;
    font-size: 0.875rem;
    color: #344767;
    margin-bottom: 4px;
  }
  
  .calendar-day.other-month .day-number {
    color: #adb5bd;
  }
  
  .event-dot {
    width: 8px;
    height: 8px;
    background-color: #f5365c;
    border-radius: 50%;
    display: inline-block;
    margin: 2px;
  }
  
  .event-item {
    font-size: 0.7rem;
    padding: 4px 6px;
    margin: 2px 0;
    border-radius: 3px;
    background-color: #fff3cd;
    color: #856404;
    border-left: 3px solid #ffc107;
    line-height: 1.3;
    word-wrap: break-word;
    white-space: normal;
  }
  
  .event-item.examen {
    background-color: #f8d7da;
    color: #721c24;
    border-left-color: #dc3545;
  }
  
  .event-item.devoir {
    background-color: #d1ecf1;
    color: #0c5460;
    border-left-color: #17a2b8;
  }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('tableSearchInput');
  const tableBody = document.getElementById('evenementsTableBody');
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
        // C'est la ligne "Aucun événement"
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
    
    // Afficher/masquer la ligne "Aucun événement trouvé"
    const emptyRow = tableBody.querySelector('tr td[colspan]');
    if (emptyRow) {
      const emptyRowParent = emptyRow.closest('tr');
      if (term === '') {
        if (visibleCount === 0 && allRows.length === 1) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun événement enregistré';
        } else {
          emptyRowParent.style.display = 'none';
        }
      } else {
        if (visibleCount === 0) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucun événement trouvé pour "' + searchTerm + '"';
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
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Gestion du dropdown des matières
    const classeSelect = document.getElementById('classe-select');
    const coursSelect = document.getElementById('cours-select');
    
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
        
        const licenceMap = {
          'Licence 1': 'licence_1',
          'Licence 2': 'licence_2',
          'Licence 3': 'licence_3'
        };
        
        const licenceValue = licenceMap[selectedClasse];
        
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
      });
    }
    
    // Gestion du calendrier
    let currentDate = new Date();
    let events = [];
    
    const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    const dayNames = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
    
    function loadEvents() {
      fetch('{{ route("admin.calendrier.events") }}', {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        events = data || [];
        renderCalendar();
      })
      .catch(error => {
        console.error('Erreur lors du chargement des événements:', error);
        events = [];
        renderCalendar();
      });
    }
    
    function renderCalendar() {
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth();
      
      // Mettre à jour le titre
      document.getElementById('calendar-month-year').textContent = monthNames[month] + ' ' + year;
      
      // Premier jour du mois
      const firstDay = new Date(year, month, 1);
      // Dernier jour du mois
      const lastDay = new Date(year, month + 1, 0);
      // Premier jour à afficher (lundi de la semaine)
      const startDate = new Date(firstDay);
      const dayOfWeek = firstDay.getDay();
      const daysToSubtract = dayOfWeek === 0 ? 6 : dayOfWeek - 1; // Convertir dimanche (0) à 6
      startDate.setDate(firstDay.getDate() - daysToSubtract);
      
      // Dernier jour à afficher
      const endDate = new Date(startDate);
      endDate.setDate(startDate.getDate() + 41); // 6 semaines * 7 jours - 1
      
      const grid = document.getElementById('calendar-grid');
      grid.innerHTML = '';
      
      // En-têtes des jours
      dayNames.forEach(day => {
        const header = document.createElement('div');
        header.className = 'calendar-day-header';
        header.textContent = day;
        grid.appendChild(header);
      });
      
      // Jours du calendrier
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      
      for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
        const day = new Date(d);
        const dayDate = new Date(day);
        dayDate.setHours(0, 0, 0, 0);
        
        const isOtherMonth = day.getMonth() !== month;
        const isToday = dayDate.getTime() === today.getTime();
        
        const dayDiv = document.createElement('div');
        dayDiv.className = 'calendar-day' + (isOtherMonth ? ' other-month' : '') + (isToday ? ' today' : '');
        
        const dayNumber = document.createElement('div');
        dayNumber.className = 'day-number';
        dayNumber.textContent = day.getDate();
        dayDiv.appendChild(dayNumber);
        
        // Ajouter les événements pour ce jour
        const dayEvents = events.filter(event => {
          if (!event.start) return false;
          const eventDateStr = event.start; // Format Y-m-d
          const dayDateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day.getDate()).padStart(2, '0');
          return eventDateStr === dayDateStr;
        });
        
        if (dayEvents.length > 0) {
          const eventsContainer = document.createElement('div');
          dayEvents.forEach(event => {
            const eventDiv = document.createElement('div');
            eventDiv.className = 'event-item';
            const eventType = (event.type || '').toLowerCase();
            if (eventType === 'examen') {
              eventDiv.classList.add('examen');
            } else if (eventType === 'devoir') {
              eventDiv.classList.add('devoir');
            }
            eventDiv.textContent = event.title || '';
            eventsContainer.appendChild(eventDiv);
          });
          dayDiv.appendChild(eventsContainer);
        }
        
        grid.appendChild(dayDiv);
      }
    }
    
    // Navigation
    document.getElementById('prev-month').addEventListener('click', function() {
      currentDate.setMonth(currentDate.getMonth() - 1);
      renderCalendar();
    });
    
    document.getElementById('next-month').addEventListener('click', function() {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    });
    
    // Initialiser le calendrier
    loadEvents();
  });
</script>
@endpush
