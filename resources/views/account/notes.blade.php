@extends('layouts.admin')

@section('title', 'Mes Notes')
@section('breadcrumb', 'Mes Notes')
@section('page-title', 'Mes Notes')

@include('components.delete-modal-handler')

@push('styles')
<style>
  .table-responsive {
    overflow-x: auto;
  }
  .table td, .table th {
    white-space: nowrap;
  }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Mes Notes</h6>
          <div>
            <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.notes.upload') : route('account.notes.upload') }}" enctype="multipart/form-data" id="uploadBulletinForm" style="display: inline-block;">
              @csrf
              <input type="file" name="bulletin_pdf" id="bulletin_pdf_input" accept=".pdf" style="display: none;" required>
              <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('bulletin_pdf_input').click();">
                <i class="ni ni-fat-add"></i> Importer un bulletin
              </button>
            </form>
            @if(isset($bulletins) && count($bulletins) > 0 && isset($apprenants) && count($apprenants) > 0)
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#sendBulletinModal">
              <i class="ni ni-send"></i> Envoyer un bulletin
            </button>
            @endif
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          @if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

          @if(isset($bulletins) && count($bulletins) > 0)
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6 class="mb-2">Mes bulletins importés</h6>
              <ul class="list-group">
            @foreach($bulletins as $b)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $b['name'] }}</span>
                <div class="d-flex gap-2">
                  <a href="{{ $b['url'] }}" target="_blank" class="btn btn-sm btn-outline-secondary">Ouvrir</a>
                  <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.notes.delete') : route('account.notes.delete') }}" style="display: inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bulletin ?');">
                    @csrf
                    <input type="hidden" name="file_path" value="{{ $b['path'] }}">
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash"></i> Supprimer
                    </button>
                  </form>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
      @endif

      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Matricule</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Nom</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Prénom</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Date de naissance</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Cours</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Classe</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Semestre</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Coefficient</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Devoir</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Examen</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Quiz</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Moyenne</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Redoubler</th>
              <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">Actions</th>
            </tr>
          </thead>
            <tbody id="notesTableBody">
            @php
              $results = [];
              if(request()->has('search') && request()->search) {
                $search = trim(request()->search);
                $results = \DB::table('notes')
                  ->where(function($query) use ($search) {
                    $query->where('matricule', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                          ->orWhere('classe', 'like', "%{$search}%") // Cours (nom de la matière)
                          ->orWhere('niveau_etude', 'like', "%{$search}%") // Classe (niveau d'étude)
                          ->orWhere('semestre', 'like', "%{$search}%")
                          ->orWhere('coefficient', 'like', "%{$search}%")
                          ->orWhereRaw('CAST(devoir AS CHAR) LIKE ?', ["%{$search}%"])
                          ->orWhereRaw('CAST(examen AS CHAR) LIKE ?', ["%{$search}%"])
                          ->orWhereRaw('CAST(quiz AS CHAR) LIKE ?', ["%{$search}%"])
                          ->orWhereRaw('CAST(moyenne AS CHAR) LIKE ?', ["%{$search}%"]);
                  })
                  ->orderBy('created_at', 'desc')
                  ->get();
              } else {
                $results = \DB::table('notes')
                  ->orderBy('created_at', 'desc')
                  ->get(); // Charger toutes les notes pour le filtrage en temps réel
              }
            @endphp
              @forelse($results as $r)
                <tr>
                  <td class="text-center">{{ $r->matricule }}</td>
                  <td class="text-center">{{ $r->nom }}</td>
                  <td class="text-center">{{ $r->prenom }}</td>
                  <td class="text-center">
                    @if($r->annee_naissance)
                      @php
                        try {
                          $dateNaissance = \Carbon\Carbon::parse($r->annee_naissance);
                          echo $dateNaissance->format('d/m/Y');
                        } catch (\Exception $e) {
                          echo $r->annee_naissance;
                        }
                      @endphp
                    @else
                      -
                    @endif
                  </td>
                  <td class="text-center">{{ $r->classe ?? 'N/A' }}</td>
                  <td class="text-center">{{ $r->niveau_etude ?? 'N/A' }}</td>
                  <td class="text-center">{{ $r->semestre ?? 'N/A' }}</td>
                  <td class="text-center">{{ $r->coefficient ?? 'N/A' }}</td>
                  <td class="text-center">{{ $r->devoir ?? '-' }}</td>
                  <td class="text-center">{{ $r->examen ?? '-' }}</td>
                  <td class="text-center">{{ $r->quiz ?? '-' }}</td>
                  <td class="text-center">
                    @php
                      // Calculer la moyenne : (Devoir + Examen) / 2
                      $devoir = $r->devoir ?? 0;
                      $examen = $r->examen ?? 0;
                      $moyenne = round(($devoir + $examen) / 2, 2);
                      echo $moyenne;
                    @endphp
                  </td>
                  <td class="text-center">
                    <span class="badge {{ $r->redoubler ? 'bg-danger' : 'bg-success' }}">{{ $r->redoubler ? 'Oui' : 'Non' }}</span>
                  </td>
                  <td class="text-center align-middle">
                    <div class="d-flex gap-2 justify-content-center">
                      <a href="{{ auth()->user()->role === 'admin' ? route('admin.notes.show', $r->id) : route('account.notes.show', $r->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Voir les détails" style="color: #17a2b8 !important; opacity: 1 !important;">
                        <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                      </a>
                      <a href="{{ auth()->user()->role === 'admin' ? route('admin.notes.edit', $r->id) : route('account.notes.edit', $r->id) }}" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Modifier" style="color: #5e72e4 !important; opacity: 1 !important;">
                        <i class="bi bi-pencil text-lg" aria-hidden="true" style="color: #5e72e4 !important; opacity: 1 !important; -webkit-text-fill-color: #5e72e4 !important;"></i>
                      </a>
                      <button type="button" 
                              class="btn btn-link action-btn p-2 mb-0" 
                              data-toggle="modal" 
                              data-target="#deleteConfirmModal{{ $r->id }}" 
                              data-original-title="Supprimer" 
                              style="color: #f5365c !important; opacity: 1 !important;">
                        <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                      </button>
                      @include('components.delete-confirm-modal', [
                        'id' => $r->id,
                        'action' => auth()->user()->role === 'admin' ? route('admin.notes.destroy', $r->id) : route('account.notes.destroy', $r->id),
                        'message' => 'Êtes-vous sûr de vouloir supprimer cette note ?'
                      ])
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="14" class="text-center py-4">
                    @if(request()->has('search') && request()->search)
                      Aucune note trouvée pour "{{ request()->search }}"
                    @else
                      Aucune note enregistrée
                    @endif
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

<!-- Section des bulletins envoyés aux apprenants -->
@if(isset($bulletinsEnvoyes) && $bulletinsEnvoyes->count() > 0)
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-3 pt-4">
          <div class="mb-3">
            <h5 class="mb-2" style="font-weight: 600; color: #344767;">
              <i class="ni ni-paper-diploma me-2 text-primary"></i>
              Les bulletins de notes des apprenants
            </h5>
            <p class="text-sm text-muted mb-0" style="margin-left: 2rem; line-height: 1.6;">
              Liste détaillée de tous les bulletins envoyés aux apprenants avec les informations complètes
            </p>
          </div>
        </div>
        <div class="card-body px-0 pt-3 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-badge me-1"></i>Matricule
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-single-02 me-1"></i>Nom
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-single-02 me-1"></i>Prénom
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-email-83 me-1"></i>Email
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-books me-1"></i>Classe
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-calendar-grid-58 me-1"></i>Semestre
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-folder-17 me-1"></i>Bulletin
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-time-alarm me-1"></i>Date d'envoi
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-single-02 me-1"></i>Envoyé par
                  </th>
                  <th class="text-center text-uppercase font-weight-bold" style="font-weight: 700 !important; font-size: 0.7rem !important; color: #344767 !important;">
                    <i class="ni ni-settings me-1"></i>Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach($bulletinsEnvoyes as $bulletin)
                  <tr>
                    <td class="text-center align-middle">
                      <span class="badge badge-sm bg-gradient-primary">{{ $bulletin['apprenant_matricule'] ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center align-middle">
                      <span class="text-sm font-weight-bold">{{ $bulletin['apprenant_nom'] ?? $bulletin['apprenant_name'] ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center align-middle">
                      <span class="text-sm font-weight-bold">{{ $bulletin['apprenant_prenom'] ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center align-middle">
                      <span class="text-sm">{{ $bulletin['apprenant_email'] ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center align-middle">
                      <span class="badge badge-sm bg-gradient-info">{{ $bulletin['classe'] ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center align-middle">
                      <span class="badge badge-sm bg-gradient-success">Semestre {{ $bulletin['semestre'] ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center align-middle">
                      <div class="d-flex flex-column align-items-center">
                        <i class="ni ni-folder-17 text-primary mb-1" style="font-size: 1.2rem;"></i>
                        <span class="text-xs text-muted" style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                          {{ $bulletin['file_name'] ?? 'N/A' }}
                        </span>
                      </div>
                    </td>
                    <td class="text-center align-middle">
                      <span class="text-sm">
                        @if($bulletin['sent_at'])
                          {{ \Carbon\Carbon::parse($bulletin['sent_at'])->format('d/m/Y à H:i') }}
                        @else
                          N/A
                        @endif
                      </span>
                    </td>
                    <td class="text-center align-middle">
                      <span class="text-sm text-muted">
                        <i class="ni ni-single-02 me-1"></i>
                        {{ $bulletin['sender_name'] ?? 'Système' }}
                      </span>
                    </td>
                    <td class="text-center align-middle">
                      <div class="d-flex gap-2 justify-content-center">
                        @if($bulletin['file_url'])
                          <a href="{{ $bulletin['file_url'] }}" target="_blank" class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Ouvrir le bulletin" style="color: #17a2b8 !important; opacity: 1 !important;">
                            <i class="ni ni-single-02 text-lg" aria-hidden="true" style="color: #17a2b8 !important; opacity: 1 !important; -webkit-text-fill-color: #17a2b8 !important;"></i>
                          </a>
                          <a href="{{ $bulletin['file_url'] }}" download class="btn btn-link action-btn p-2 mb-0" data-toggle="tooltip" data-original-title="Télécharger le bulletin" style="color: #2dce89 !important; opacity: 1 !important;">
                            <i class="ni ni-cloud-download-95 text-lg" aria-hidden="true" style="color: #2dce89 !important; opacity: 1 !important; -webkit-text-fill-color: #2dce89 !important;"></i>
                          </a>
                        @else
                          <span class="badge badge-sm bg-gradient-danger">Fichier introuvable</span>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer">
          <div class="d-flex justify-content-between align-items-center">
            <p class="text-sm text-muted mb-0">
              <i class="ni ni-info-571 me-1"></i>
              Total : <strong>{{ $bulletinsEnvoyes->count() }}</strong> bulletin(s) envoyé(s)
            </p>
            <p class="text-sm text-muted mb-0">
              <i class="ni ni-calendar-grid-58 me-1"></i>
              Dernière mise à jour : {{ now()->format('d/m/Y à H:i') }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@else
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-body text-center py-5">
          <i class="ni ni-paper-diploma text-muted" style="font-size: 4rem;"></i>
          <h6 class="text-muted mt-3 mb-0">Aucun bulletin envoyé</h6>
          <p class="text-sm text-muted">Les bulletins envoyés aux apprenants apparaîtront ici.</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<!-- Modal pour envoyer le bulletin -->
@if(isset($bulletins) && count($bulletins) > 0 && isset($apprenants) && count($apprenants) > 0)
<div class="modal fade" id="sendBulletinModal" tabindex="-1" aria-labelledby="sendBulletinModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title text-white" id="sendBulletinModalLabel">Envoyer un bulletin à un apprenant</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ request()->routeIs('admin.*') ? route('admin.notes.send') : route('account.notes.send') }}" id="sendBulletinForm">
        @csrf
        <input type="hidden" id="bulletinSemestreHidden" name="semestre" value="">
        <div class="modal-body">
          <div class="alert alert-info text-white bg-dark">
            <i class="fas fa-info-circle me-2"></i>
            Sélectionnez un bulletin, une classe puis l'apprenant qui recevra le bulletin.
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">1. Sélectionner le bulletin PDF</label>
            <select class="form-control form-control-lg" name="file_path" required>
              <option value="">-- Choisir un bulletin --</option>
              @foreach($bulletins as $b)
                <option value="{{ $b['path'] }}">{{ $b['name'] }}</option>
              @endforeach
            </select>
            <small class="text-muted">{{ count($bulletins) }} bulletin(s) disponible(s)</small>
          </div>
          <hr>
          @php
            // Mapping semestre -> classes possibles (basé sur la base de données)
            // Licence 1: semestres 1-2
            // Licence 2: semestres 3-4
            // Licence 3: semestres 5-6
            // Master 1: semestres 7-8
            // Master 2: semestres 9-10
            $semestreToClasses = [
                1 => ['Licence 1'],
                2 => ['Licence 1'],
                3 => ['Licence 2'],
                4 => ['Licence 2'],
                5 => ['Licence 3'],
                6 => ['Licence 3'],
                7 => ['Master 1'],
                8 => ['Master 1'],
                9 => ['Master 2'],
                10 => ['Master 2'],
            ];
            
            // Liste fixe et ordonnée des classes pour le dropdown
            $classesApprenants = collect([
                'Licence 1',
                'Licence 2',
                'Licence 3',
                'Master 1',
                'Master 2',
            ]);
          @endphp
          <div class="mb-3">
            <label class="form-label fw-bold">2. Sélectionner la classe</label>
            <select id="bulletinClasseFilter" class="form-control form-control-lg">
              <option value="">-- Sélectionner une classe --</option>
              <option value="__all__">Toutes les classes</option>
              @foreach($classesApprenants as $classeName)
                <option value="{{ $classeName }}">{{ $classeName }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">3. Sélectionner le semestre</label>
            <select id="bulletinSemestreFilter" class="form-control form-control-lg" disabled>
              <option value="">-- Sélectionner un semestre --</option>
              @php
                // Toujours afficher les semestres 1 à 10 (le JavaScript filtrera selon la classe)
                $semestresDisponibles = isset($semestres) ? $semestres->toArray() : [];
                \Log::info('[NOTES] Génération du dropdown semestre', [
                    'semestres_en_base' => $semestresDisponibles,
                    'count_en_base' => count($semestresDisponibles),
                ]);
              @endphp
              @for($i = 1; $i <= 10; $i++)
                <option value="{{ $i }}" data-semestre="{{ $i }}">Semestre {{ $i }}</option>
              @endfor
            </select>
            <small class="text-muted">Les semestres seront filtrés selon la classe sélectionnée</small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">4. Sélectionner l'apprenant destinataire</label>
            <select id="bulletinApprenantSelect" class="form-control form-control-lg" name="user_id" required>
              <option value="">-- Choisir un apprenant --</option>
            </select>
            <small id="bulletinApprenantsCount" class="text-muted">{{ count($apprenants) }} apprenant(s) disponible(s)</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="fas fa-paper-plane me-2"></i>Envoyer le bulletin
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@elseif(isset($bulletins) && count($bulletins) == 0)
<div class="alert alert-warning">
  <i class="fas fa-exclamation-triangle me-2"></i>
  Aucun bulletin importé. Importez d'abord un bulletin PDF pour pouvoir l'envoyer.
</div>
@elseif(!isset($apprenants) || count($apprenants) == 0)
<div class="alert alert-warning">
  <i class="fas fa-exclamation-triangle me-2"></i>
  Aucun apprenant disponible dans le système.
</div>
@endif
@endsection

@php
  // Mapping classe -> semestres (pour le JS)
  $classeToSemestresJS = [
      'Licence 1' => [1, 2],
      'Licence 2' => [3, 4],
      'Licence 3' => [5, 6],
      'Master 1' => [7, 8],
      'Master 2' => [9, 10],
  ];

  // Préparer les données apprenants côté PHP pour le JS (avec leurs semestres depuis la base)
  $apprenantsData = collect($apprenantsAvecSemestres ?? $apprenants ?? [])->map(function ($u) {
      $classeLabelMap = [
          'licence_1' => 'Licence 1',
          'licence_2' => 'Licence 2',
          'licence_3' => 'Licence 3',
          'master_1'  => 'Master 1',
          'master_2'  => 'Master 2',
      ];

      $code = $u->classe_id ?? null;
      $classeLabel = $code ? ($classeLabelMap[$code] ?? ucfirst(str_replace('_', ' ', $code))) : null;

      // Récupérer les semestres de l'apprenant depuis la base (depuis ses notes)
      $semestresApprenant = isset($u->semestres) ? $u->semestres : [];

      return [
          'id' => $u->id,
          'name' => $u->name,
          'email' => $u->email,
          'classe' => $classeLabel,
          'semestres' => $semestresApprenant, // Semestres de l'apprenant depuis la base
      ];
  })->values();
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Données apprenants (toujours basées sur la base de données)
  const apprenantsData = @json($apprenantsData);
  console.log('[NOTES] apprenantsData JS:', apprenantsData);

  // Mapping classe -> semestres (pour filtrer les semestres selon la classe)
  const classeToSemestres = @json($classeToSemestresJS);

  const searchInput = document.getElementById('notesSearchInput');
  const tableBody = document.getElementById('notesTableBody');
  const clearBtn = document.getElementById('clearSearchBtn');
  
  if (!searchInput || !tableBody) return;
  
  // Récupérer toutes les lignes du tableau
  const allRows = Array.from(tableBody.querySelectorAll('tr'));
  
  // Fonction de filtrage
  function filterTable(searchTerm) {
    const term = searchTerm.toLowerCase().trim();
    let visibleCount = 0;
    
    allRows.forEach(row => {
      if (row.querySelector('td[colspan]')) {
        // C'est la ligne "Aucune note"
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
    
    // Afficher/masquer la ligne "Aucune note trouvée"
    const emptyRow = tableBody.querySelector('tr td[colspan]');
    if (emptyRow) {
      const emptyRowParent = emptyRow.closest('tr');
      if (term === '') {
        if (visibleCount === 0 && allRows.length === 1) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucune note enregistrée';
        } else {
          emptyRowParent.style.display = 'none';
        }
      } else {
        if (visibleCount === 0) {
          emptyRowParent.style.display = '';
          emptyRow.textContent = 'Aucune note trouvée pour "' + searchTerm + '"';
        } else {
          emptyRowParent.style.display = 'none';
        }
      }
    }
  }
  
  // Filtrer en temps réel pendant la saisie (filtrage instantané)
  searchInput.addEventListener('input', function() {
    filterTable(this.value);
    
    // Afficher/masquer le bouton effacer
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

  // ---- Filtre par semestre, classe et apprenant dans la modale "Envoyer un bulletin" + sécurisation du bouton d'envoi ----
  const semestreFilter = document.getElementById('bulletinSemestreFilter');
  const classeFilter = document.getElementById('bulletinClasseFilter');
  const apprenantSelect = document.getElementById('bulletinApprenantSelect');
  const apprenantsCountLabel = document.getElementById('bulletinApprenantsCount');
  const bulletinSelect = document.querySelector('#sendBulletinModal select[name=\"file_path\"]');
  const sendBulletinBtn = document.querySelector('#sendBulletinModal button[type=\"submit\"]');

  function updateSendBulletinButtonState() {
    if (!sendBulletinBtn) return;

    const hasBulletin = bulletinSelect && bulletinSelect.value !== '';
    const hasSemestre = semestreFilter && semestreFilter.value !== '';
    const hasClasse = classeFilter && classeFilter.value !== ''; // '__all__' accepté
    const hasApprenant = apprenantSelect && !apprenantSelect.disabled && apprenantSelect.value !== '';

    const shouldEnable = hasBulletin && hasSemestre && hasClasse && hasApprenant;
    sendBulletinBtn.disabled = !shouldEnable;
  }

  // Fonction pour filtrer les semestres selon la classe sélectionnée
  function filterSemestresByClasse(selectedClasse) {
    console.log('[NOTES] filterSemestresByClasse appelé avec:', selectedClasse);
    
    if (!semestreFilter) {
      console.log('[NOTES] semestreFilter non trouvé');
      return;
    }

    const allOptions = Array.from(semestreFilter.options);
    console.log('[NOTES] Nombre total d\'options semestre:', allOptions.length);
    console.log('[NOTES] Options semestre:', allOptions.map(o => ({ value: o.value, text: o.textContent })));
    
    if (!selectedClasse || selectedClasse === '') {
      console.log('[NOTES] Aucune classe sélectionnée - désactivation du dropdown semestre');
      // Aucune classe sélectionnée : désactiver le dropdown semestre
      semestreFilter.disabled = true;
      semestreFilter.value = '';
      // Masquer tous les semestres
      allOptions.forEach(opt => {
        if (opt.value !== '') {
          opt.style.display = 'none';
          opt.disabled = true;
        }
      });
      return;
    }

    // Activer le select de semestre
    semestreFilter.disabled = false;
    console.log('[NOTES] Dropdown semestre activé');

    // Si "Toutes les classes" est sélectionné, afficher tous les semestres
    if (selectedClasse === '__all__') {
      console.log('[NOTES] "Toutes les classes" sélectionné - affichage de tous les semestres');
      allOptions.forEach(opt => {
        opt.style.display = '';
        opt.disabled = false;
      });
      return;
    }

    // Récupérer les semestres autorisés pour cette classe
    const semestresAutorises = classeToSemestres[selectedClasse] || [];
    console.log('[NOTES] Classe sélectionnée:', selectedClasse);
    console.log('[NOTES] Mapping classeToSemestres:', classeToSemestres);
    console.log('[NOTES] Semestres autorisés pour cette classe:', semestresAutorises);

    // Filtrer les options : afficher uniquement les semestres autorisés pour cette classe
    let visibleCount = 0;
    allOptions.forEach(opt => {
      if (opt.value === '') {
        opt.style.display = '';
        opt.disabled = false;
      } else {
        const semestreNum = parseInt(opt.value);
        const isAuthorized = semestresAutorises.includes(semestreNum);
        opt.style.display = isAuthorized ? '' : 'none';
        opt.disabled = !isAuthorized;
        if (isAuthorized) {
          visibleCount++;
        }
        console.log(`[NOTES] Semestre ${semestreNum}: ${isAuthorized ? 'AFFICHÉ' : 'MASQUÉ'}`);
      }
    });
    console.log('[NOTES] Nombre de semestres visibles après filtrage:', visibleCount);
  }

  if (classeFilter && apprenantSelect) {
    console.log('[NOTES] classeFilter found, options:', Array.from(classeFilter.options).map(o => o.value));

    // Au chargement : tant qu'aucune classe n'est choisie, on verrouille la sélection d'apprenant
    apprenantSelect.disabled = true;

    function populateApprenantsSelect(selectedClasse, selectedSemestre) {
      console.log('[NOTES] ===== populateApprenantsSelect =====');
      console.log('[NOTES] Classe sélectionnée:', selectedClasse);
      console.log('[NOTES] Semestre sélectionné:', selectedSemestre);
      console.log('[NOTES] Total apprenantsData:', apprenantsData ? apprenantsData.length : 0);
      console.log('[NOTES] apprenantsData complet:', apprenantsData);
      
      // Réinitialiser la liste : uniquement le placeholder au début
      apprenantSelect.innerHTML = '<option value="">-- Choisir un apprenant --</option>';

      // Si aucune classe ou aucun semestre sélectionné, on ne propose aucun apprenant
      if (!selectedClasse || !selectedSemestre) {
        console.log('[NOTES] Classe ou semestre manquant - Classe:', selectedClasse, 'Semestre:', selectedSemestre);
        apprenantSelect.disabled = true;
        if (apprenantsCountLabel) {
          apprenantsCountLabel.textContent = '0 apprenant(s) disponible(s)';
        }
        updateSendBulletinButtonState();
        return;
      }

      const semestreNum = parseInt(selectedSemestre);
      console.log('[NOTES] Semestre numéro (parsed):', semestreNum);
      let filtered;

      // Si "Toutes les classes" est sélectionné, on prend tous les apprenants
      // Le semestre est informatif mais n'exclut pas les apprenants
      if (selectedClasse === '__all__') {
        console.log('[NOTES] Filtrage: Toutes les classes - tous les apprenants inclus');
        filtered = Array.isArray(apprenantsData) ? apprenantsData : [];
      } else {
        console.log('[NOTES] Filtrage: Classe spécifique =', selectedClasse);
        // Filtrer UNIQUEMENT par classe
        // Le semestre est utilisé pour information, mais on affiche TOUS les apprenants de la classe
        // (car un apprenant peut recevoir un bulletin même s'il n'a pas encore de notes pour ce semestre)
        filtered = (Array.isArray(apprenantsData) ? apprenantsData : []).filter(a => {
          const classeMatch = a.classe === selectedClasse;
          
          console.log(`[NOTES] Apprenant ${a.name} (${a.email}):`, {
            classe: a.classe,
            classeMatch: classeMatch,
            semestres: a.semestres,
            passes: classeMatch
          });
          
          return classeMatch;
        });
      }
      console.log('[NOTES] ===== RÉSULTAT DU FILTRAGE =====');
      console.log('[NOTES] Nombre d\'apprenants filtrés:', filtered.length);
      console.log('[NOTES] Apprenants filtrés:', filtered.map(a => ({
        name: a.name,
        email: a.email,
        classe: a.classe,
        semestres: a.semestres
      })));

      // Si aucun apprenant pour cette classe et ce semestre
      if (!filtered.length) {
        const opt = document.createElement('option');
        opt.value = '';
        opt.disabled = true;
        const classeText = selectedClasse === '__all__' ? 'ces classes' : 'cette classe';
        opt.textContent = `Aucun étudiant disponible pour ${classeText} au semestre ${selectedSemestre}`;
        apprenantSelect.appendChild(opt);
        apprenantSelect.disabled = true;
        if (apprenantsCountLabel) {
          apprenantsCountLabel.textContent = '0 apprenant(s) disponible(s)';
        }
        updateSendBulletinButtonState();
        return;
      }

      filtered.forEach(a => {
        const opt = document.createElement('option');
        opt.value = a.id;
        opt.textContent = `${a.name} (${a.email}) - ${a.classe}`;
        apprenantSelect.appendChild(opt);
      });

      // Au moins un apprenant, on déverrouille la sélection
      apprenantSelect.disabled = false;

      if (apprenantsCountLabel) {
        apprenantsCountLabel.textContent = `${filtered.length} apprenant(s) disponible(s)`;
      }

      updateSendBulletinButtonState();
    }

    // Au chargement, aucun apprenant tant qu'une classe et un semestre ne sont pas choisis
    // Le semestre est désactivé par défaut (attente de la sélection de la classe)
    populateApprenantsSelect('', '');
    
    // Initialiser l'état du dropdown semestre (désactivé)
    filterSemestresByClasse('');
  }

  // Gestionnaire pour le changement de classe
  if (classeFilter) {
    classeFilter.addEventListener('change', function () {
      const selectedClasse = this.value || '';
      
      // Filtrer les semestres selon la classe choisie
      filterSemestresByClasse(selectedClasse);
      
      // Réinitialiser le semestre et l'apprenant si la classe change
      if (semestreFilter) {
        semestreFilter.value = '';
      }
      populateApprenantsSelect(selectedClasse, '');
      updateSendBulletinButtonState();
    });
  }

  // Gestionnaire pour le changement de semestre
  if (semestreFilter) {
    semestreFilter.addEventListener('change', function() {
      const selectedSemestre = this.value || '';
      const selectedClasse = classeFilter ? classeFilter.value || '' : '';
      
      // Mettre à jour le champ hidden semestre pour le formulaire
      const semestreHidden = document.getElementById('bulletinSemestreHidden');
      if (semestreHidden) {
        semestreHidden.value = selectedSemestre;
      }
      
      populateApprenantsSelect(selectedClasse, selectedSemestre);
      updateSendBulletinButtonState();
    });
  }

  // Écouteurs pour mettre à jour l'état du bouton quand les champs changent
  if (bulletinSelect) {
    bulletinSelect.addEventListener('change', updateSendBulletinButtonState);
  }
  if (apprenantSelect) {
    apprenantSelect.addEventListener('change', updateSendBulletinButtonState);
  }

  // État initial sécurisé
  updateSendBulletinButtonState();

  // ===== LOGS POUR DIAGNOSTIQUER LES ICÔNES DES BOUTONS D'ACTION =====
  console.log('[NOTES] ===== DIAGNOSTIC DES ICÔNES D\'ACTION =====');
  
  // Attendre que le DOM soit complètement chargé
  setTimeout(function() {
    const actionButtons = document.querySelectorAll('td:has(a[title="Ouvrir le bulletin"]), td:has(a[title="Télécharger le bulletin"])');
    console.log('[NOTES] Nombre de boutons d\'action trouvés:', actionButtons.length);
    
    // Trouver tous les liens d'action
    const openButtons = document.querySelectorAll('a[title="Ouvrir le bulletin"]');
    const downloadButtons = document.querySelectorAll('a[title="Télécharger le bulletin"]');
    
    console.log('[NOTES] Boutons "Ouvrir" trouvés:', openButtons.length);
    console.log('[NOTES] Boutons "Télécharger" trouvés:', downloadButtons.length);
    
    openButtons.forEach((btn, index) => {
      const icon = btn.querySelector('i');
      if (icon) {
        const computedStyle = window.getComputedStyle(icon);
        const btnStyle = window.getComputedStyle(btn);
        
        console.log(`[NOTES] Bouton "Ouvrir" #${index + 1}:`, {
          icon_class: icon.className,
          icon_color: computedStyle.color,
          icon_opacity: computedStyle.opacity,
          icon_display: computedStyle.display,
          icon_visibility: computedStyle.visibility,
          icon_fontSize: computedStyle.fontSize,
          icon_fontWeight: computedStyle.fontWeight,
          icon_lineHeight: computedStyle.lineHeight,
          icon_fontFamily: computedStyle.fontFamily,
          icon_verticalAlign: computedStyle.verticalAlign,
          btn_background: btnStyle.background,
          btn_backgroundColor: btnStyle.backgroundColor,
          btn_width: btnStyle.width,
          btn_height: btnStyle.height,
          btn_display: btnStyle.display,
          icon_innerHTML: icon.innerHTML,
          icon_textContent: icon.textContent,
          icon_offsetWidth: icon.offsetWidth,
          icon_offsetHeight: icon.offsetHeight,
          icon_clientWidth: icon.clientWidth,
          icon_clientHeight: icon.clientHeight,
          icon_getBoundingClientRect: icon.getBoundingClientRect(),
        });
        
        // Vérifier si la police d'icônes est chargée
        const testIcon = document.createElement('i');
        testIcon.className = 'ni ni-zoom-split';
        testIcon.style.fontSize = '20px';
        document.body.appendChild(testIcon);
        const testStyle = window.getComputedStyle(testIcon);
        console.log(`[NOTES] Test police icône:`, {
          fontFamily: testStyle.fontFamily,
          fontSize: testStyle.fontSize,
          width: testIcon.offsetWidth,
          height: testIcon.offsetHeight,
        });
        document.body.removeChild(testIcon);
        
        // Vérifier si l'icône est masquée par un parent
        let parent = icon.parentElement;
        let level = 0;
        while (parent && level < 5) {
          const parentStyle = window.getComputedStyle(parent);
          console.log(`[NOTES] Parent niveau ${level} (${parent.tagName}):`, {
            display: parentStyle.display,
            visibility: parentStyle.visibility,
            opacity: parentStyle.opacity,
            overflow: parentStyle.overflow,
          });
          parent = parent.parentElement;
          level++;
        }
      } else {
        console.log(`[NOTES] Bouton "Ouvrir" #${index + 1}: AUCUNE ICÔNE TROUVÉE`);
      }
    });
    
    downloadButtons.forEach((btn, index) => {
      const icon = btn.querySelector('i');
      if (icon) {
        const computedStyle = window.getComputedStyle(icon);
        const btnStyle = window.getComputedStyle(btn);
        
        console.log(`[NOTES] Bouton "Télécharger" #${index + 1}:`, {
          icon_class: icon.className,
          icon_color: computedStyle.color,
          icon_opacity: computedStyle.opacity,
          icon_display: computedStyle.display,
          icon_visibility: computedStyle.visibility,
          icon_fontSize: computedStyle.fontSize,
          icon_fontWeight: computedStyle.fontWeight,
          btn_background: btnStyle.background,
          btn_backgroundColor: btnStyle.backgroundColor,
        });
      } else {
        console.log(`[NOTES] Bouton "Télécharger" #${index + 1}: AUCUNE ICÔNE TROUVÉE`);
      }
    });
    
    console.log('[NOTES] ===== FIN DU DIAGNOSTIC DES ICÔNES =====');
  }, 1000);
});
</script>
<script>
  (function(){
    console.log('=== NOTES PAGE DEBUG ===');
    try {
      const bulletins = @json($bulletins ?? []);
      const apprenants = @json($apprenants ?? []);
      
      console.log('[NOTES] Page loaded');
      console.log('[NOTES] Bulletins count:', bulletins.length);
      console.log('[NOTES] Apprenants count:', apprenants.length);
      
      if (bulletins && bulletins.length > 0) {
        console.log('[NOTES] Bulletins list:', bulletins);
        bulletins.forEach((b, i) => {
          console.log(`[NOTES] Bulletin ${i + 1}:`, {
            name: b.name,
            path: b.path,
            url: b.url,
            exists: b.exists,
          });
        });
      } else {
        console.warn('[NOTES] ⚠️ Aucun bulletin détecté côté client.');
        console.warn('[NOTES] Vérifiez les logs serveur dans storage/logs/laravel.log');
      }
      
      // Vérifier les boutons d'envoi
      const sendButton = document.querySelector('[data-bs-target="#sendBulletinModal"]');
      if (sendButton) {
        console.log('[NOTES] Bouton "Envoyer le bulletin" trouvé');
      } else {
        console.warn('[NOTES] ⚠️ Bouton "Envoyer le bulletin" non trouvé');
      }
      
      // Vérifier le modal
      const modal = document.getElementById('sendBulletinModal');
      if (modal) {
        console.log('[NOTES] Modal trouvé');
      } else {
        console.warn('[NOTES] ⚠️ Modal non trouvé');
      }
      
      // Gérer l'upload automatique quand un fichier est sélectionné
      const bulletinInput = document.getElementById('bulletin_pdf_input');
      if (bulletinInput) {
        bulletinInput.addEventListener('change', function() {
          if (this.files && this.files.length > 0) {
            // Soumettre automatiquement le formulaire
            const form = this.closest('form');
            if (form) {
              // Désactiver le bouton pendant l'upload pour éviter les doubles soumissions
              const submitBtn = form.querySelector('button[type="button"]');
              if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="ni ni-fat-add"></i> Import en cours...';
              }
              
              form.submit();
            }
          }
        });
      }
      
    } catch(e) {
      console.error('[NOTES] ❌ Erreur lors du log:', e);
      console.error('[NOTES] Stack trace:', e.stack);
    }
    console.log('=== END NOTES DEBUG ===');
  })();
  
  // DEBUG BUTTON - Ajout direct dans la vue
  document.addEventListener('DOMContentLoaded', function() {
    const debugBtn = document.getElementById('debugBtn');
    if (debugBtn) {
      debugBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('🔍 [DEBUG NOTES] Bouton cliqué depuis account/notes.blade.php');
        
        const notesLink = document.getElementById('notesLinkSidebar');
        console.log('🔍 [DEBUG NOTES] Lien notesLinkSidebar:', notesLink);
        
        if (notesLink) {
          const href = notesLink.getAttribute('href');
          console.log('🔍 [DEBUG NOTES] Href du lien:', href);
          const spans = notesLink.querySelectorAll('span');
          console.log('🔍 [DEBUG NOTES] Spans trouvés:', spans.length);
          spans.forEach((span, i) => {
            console.log(`🔍 [DEBUG NOTES] Span ${i}:`, {
              text: span.textContent.trim(),
              classes: span.className,
              pointerEvents: window.getComputedStyle(span).pointerEvents
            });
          });
          
          // Forcer la navigation
          if (href) {
            window.location.href = href;
          }
        } else {
          alert('Lien Notes non trouvé! Vérifiez la console.');
        }
      });
    }
  });
</script>
@endpush