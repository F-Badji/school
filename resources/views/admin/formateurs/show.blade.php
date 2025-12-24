@extends('layouts.admin')

@section('title', 'Détails Formateur')
@section('breadcrumb', 'Détails Formateur')
@section('page-title', 'Détails du Formateur')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Informations du Formateur</h6>
          <div class="d-flex gap-2">
            <a href="{{ route('admin.formateurs.edit', $formateur) }}" class="btn btn-sm btn-primary mb-0">
              <i class="ni ni-settings-gear-65"></i> Modifier
            </a>
            <a href="{{ route('admin.formateurs.index') }}" class="btn btn-sm btn-secondary mb-0">
              <i class="ni ni-bold-left"></i> Retour
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 text-center mb-4">
            @if($formateur->photo)
              <img src="{{ asset('storage/' . $formateur->photo) }}" class="avatar avatar-xxl rounded-circle shadow-lg" alt="Photo">
            @else
              <div class="avatar avatar-xxl bg-gradient-info rounded-circle shadow-lg mx-auto">
                <span class="text-white text-3xl font-weight-bold">{{ strtoupper(substr($formateur->name ?? ($formateur->nom ?? 'F'), 0, 1)) }}</span>
              </div>
            @endif
            <h5 class="mt-3 mb-1">{{ $formateur->name ?? ($formateur->nom . ' ' . $formateur->prenom) }}</h5>
            <p class="text-sm text-secondary mb-0">{{ $formateur->email }}</p>
            @if($formateur->statut)
              <span class="badge badge-sm bg-gradient-{{ $formateur->statut === 'actif' ? 'success' : ($formateur->statut === 'bloque' ? 'danger' : 'warning') }}">
                {{ ucfirst($formateur->statut) }}
              </span>
            @endif
          </div>
          <div class="col-md-8">
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Informations personnelles</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Nom</label>
                <p class="mb-0">{{ $formateur->nom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Prénom</label>
                <p class="mb-0">{{ $formateur->prenom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Date de naissance</label>
                <p class="mb-0">{{ $formateur->date_naissance ? $formateur->date_naissance->format('d/m/Y') : 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Email</label>
                <p class="mb-0">{{ $formateur->email }}</p>
              </div>
            </div>

            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Informations professionnelles</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Spécialité</label>
                <p class="mb-0">{{ $formateur->filiere ?? 'N/A' }}</p>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label text-xs font-weight-bold">Matières enseignées</label>
                @if($formateur->matieres && $formateur->matieres->count() > 0)
                  <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($formateur->matieres as $matiere)
                      <span class="badge badge-sm bg-gradient-info">
                        {{ $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? 'Matière #' . $matiere->id }}
                      </span>
                    @endforeach
                  </div>
                @else
                  <p class="mb-0 text-secondary">Aucune matière assignée</p>
                @endif
              </div>
            </div>

            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Informations du compte</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Date d'inscription</label>
                <p class="mb-0">{{ $formateur->created_at->format('d/m/Y à H:i') }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Dernière connexion</label>
                <p class="mb-0">
                  @if($formateur->last_seen)
                    {{ \Carbon\Carbon::parse($formateur->last_seen)->format('d/m/Y à H:i') }}
                    @if(\Carbon\Carbon::parse($formateur->last_seen)->isAfter(\Carbon\Carbon::now()->subMinutes(15)))
                      <span class="badge badge-sm bg-gradient-success ms-2">En ligne</span>
                    @endif
                  @else
                    Jamais connecté
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

@if(isset($formateur->cours) && $formateur->cours->count() > 0)
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Cours attribués</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cours</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date de création</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($formateur->cours as $cours)
              <tr>
                <td>
                  <h6 class="mb-0 text-sm">{{ $cours->titre ?? $cours->nom ?? 'Cours' }}</h6>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ Str::limit($cours->description ?? 'N/A', 50) }}</p>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">
                    {{ $cours->created_at->format('d/m/Y') }}
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
          <form action="{{ route('admin.formateurs.toggle-block', $formateur) }}" method="POST" class="d-inline">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-outline-{{ $formateur->statut === 'bloque' ? 'success' : 'warning' }} btn-sm">
              <i class="ni ni-{{ $formateur->statut === 'bloque' ? 'unlock' : 'lock' }}"></i>
              {{ $formateur->statut === 'bloque' ? 'Débloquer' : 'Bloquer' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

