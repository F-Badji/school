@extends('layouts.admin')

@section('title', 'Détails Apprenant')
@section('breadcrumb', 'Détails Apprenant')
@section('page-title', 'Détails de l\'Apprenant')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Informations de l'Apprenant</h6>
          <div class="d-flex gap-2">
            <a href="{{ route('admin.apprenants.edit', $apprenant) }}" class="btn btn-sm btn-primary mb-0">
              <i class="ni ni-settings-gear-65"></i> Modifier
            </a>
            <a href="{{ route('admin.apprenants.index') }}" class="btn btn-sm btn-secondary mb-0">
              <i class="ni ni-bold-left"></i> Retour
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 text-center mb-4">
            @if($apprenant->photo)
              <img src="{{ asset('storage/' . $apprenant->photo) }}" class="avatar avatar-xxl rounded-circle shadow-lg" alt="Photo">
            @else
              <div class="avatar avatar-xxl bg-gradient-primary rounded-circle shadow-lg mx-auto">
                <span class="text-white text-3xl font-weight-bold">{{ strtoupper(substr($apprenant->name ?? ($apprenant->nom ?? 'A'), 0, 1)) }}</span>
              </div>
            @endif
            <h5 class="mt-3 mb-1">{{ $apprenant->name ?? ($apprenant->nom . ' ' . $apprenant->prenom) }}</h5>
            <p class="text-sm text-secondary mb-0">{{ $apprenant->email }}</p>
            @if($apprenant->statut)
              <span class="badge badge-sm bg-gradient-{{ $apprenant->statut === 'actif' ? 'success' : ($apprenant->statut === 'bloque' ? 'danger' : 'warning') }}">
                {{ ucfirst($apprenant->statut) }}
              </span>
            @endif
          </div>
          <div class="col-md-8">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Informations personnelles</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Nom</label>
                <p class="mb-0">{{ $apprenant->nom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Prénom</label>
                <p class="mb-0">{{ $apprenant->prenom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Date de naissance</label>
                <p class="mb-0">{{ $apprenant->date_naissance ? $apprenant->date_naissance->format('d/m/Y') : 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Email</label>
                <p class="mb-0">{{ $apprenant->email }}</p>
              </div>
            </div>

            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Documents</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Diplôme</label>
                <div class="d-flex align-items-center gap-2">
                  @if($apprenant->diplome)
                    <a href="{{ asset('storage/' . $apprenant->diplome) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-0">
                      <i class="ni ni-paper-diploma"></i> Voir le diplôme
                    </a>
                    <a href="{{ asset('storage/' . $apprenant->diplome) }}" download class="btn btn-sm btn-outline-info mb-0" data-toggle="tooltip" data-original-title="Télécharger">
                      <i class="ni ni-cloud-download-95"></i>
                    </a>
                  @else
                    <span class="text-muted text-xs">Non fourni</span>
                  @endif
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Carte d'identité</label>
                <div class="d-flex align-items-center gap-2">
                  @if($apprenant->carte_identite)
                    <a href="{{ asset('storage/' . $apprenant->carte_identite) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-0">
                      <i class="ni ni-badge"></i> Voir la carte d'identité
                    </a>
                    <a href="{{ asset('storage/' . $apprenant->carte_identite) }}" download class="btn btn-sm btn-outline-info mb-0" data-toggle="tooltip" data-original-title="Télécharger">
                      <i class="ni ni-cloud-download-95"></i>
                    </a>
                  @else
                    <span class="text-muted text-xs">Non fournie</span>
                  @endif
                </div>
              </div>
            </div>

            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Informations académiques</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Filière</label>
                <p class="mb-0">{{ $apprenant->filiere ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Niveau d'étude</label>
                <p class="mb-0">
                  @if($apprenant->niveau_etude)
                    {{ $apprenant->niveau_etude }}
                  @elseif($apprenant->classe_id)
                    @if(in_array($apprenant->classe_id, ['licence_1', 'licence_2', 'licence_3']))
                      {{ ucfirst(str_replace('_', ' ', $apprenant->classe_id)) }}
                    @elseif($apprenant->classe)
                      {{ $apprenant->classe->nom ?? $apprenant->classe->libelle ?? 'N/A' }}
                    @else
                      Non assignée
                    @endif
                  @else
                    Non assignée
                  @endif
                </p>
              </div>
            </div>

            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Informations du compte</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Date d'inscription</label>
                <p class="mb-0">{{ $apprenant->created_at->format('d/m/Y à H:i') }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Dernière connexion</label>
                <p class="mb-0">
                  @php
                    // Utiliser last_seen, sinon updated_at, sinon created_at
                    $lastActivity = $apprenant->last_seen ?? $apprenant->updated_at ?? $apprenant->created_at;
                    
                    if ($lastActivity) {
                      $lastSeen = \Carbon\Carbon::parse($lastActivity);
                      $now = \Carbon\Carbon::now();
                      $diffInMinutes = intval($lastSeen->diffInMinutes($now));
                      $diffInHours = intval($lastSeen->diffInHours($now));
                      $diffInDays = intval($lastSeen->diffInDays($now));
                      
                      if ($diffInMinutes < 1) {
                        $statusText = 'À l\'instant';
                      } elseif ($diffInMinutes < 60) {
                        $statusText = 'Il y a ' . $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '');
                      } elseif ($diffInHours < 24) {
                        $statusText = 'Il y a ' . $diffInHours . ' heure' . ($diffInHours > 1 ? 's' : '');
                      } else {
                        $statusText = 'Il y a ' . $diffInDays . ' jour' . ($diffInDays > 1 ? 's' : '');
                      }
                    } else {
                      $statusText = 'Jamais connecté';
                    }
                  @endphp
                  @if($lastActivity)
                    {{ $statusText }}
                    @if(isset($diffInMinutes) && $diffInMinutes < 15)
                      <span class="badge badge-sm bg-gradient-success ms-2">En ligne</span>
                    @endif
                  @else
                    {{ $statusText }}
                  @endif
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@if(isset($apprenant->evaluations) && $apprenant->evaluations->count() > 0)
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Évaluations</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Évaluation</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Note</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($apprenant->evaluations as $evaluation)
              <tr>
                <td>
                  <h6 class="mb-0 text-sm">{{ $evaluation->evaluation->titre ?? 'Évaluation' }}</h6>
                </td>
                <td>
                  <span class="text-xs font-weight-bold">{{ $evaluation->note ?? 'N/A' }}/20</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">
                    {{ $evaluation->created_at->format('d/m/Y') }}
                  </span>
                </td>
                <td class="align-middle">
                  <a href="javascript:;" class="text-secondary font-weight-bold text-xs">Voir</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Actions rapides</h6>
      </div>
      <div class="card-body">
        <div class="d-flex gap-2 flex-wrap">
          <a href="{{ route('admin.apprenants.bulletin', $apprenant) }}" class="btn btn-outline-info btn-sm">
            <i class="ni ni-paper-diploma"></i> Générer le bulletin
          </a>
          <form action="{{ route('admin.apprenants.toggle-block', $apprenant) }}" method="POST" class="d-inline">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-outline-{{ $apprenant->statut === 'bloque' ? 'success' : 'warning' }} btn-sm">
              <i class="ni ni-{{ $apprenant->statut === 'bloque' ? 'unlock' : 'lock' }}"></i>
              {{ $apprenant->statut === 'bloque' ? 'Débloquer' : 'Bloquer' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

