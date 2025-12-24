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
            <a href="{{ route('admin.apprenants-admin-redoublants.edit', $apprenant) }}" class="btn btn-sm btn-primary mb-0">
              <i class="ni ni-settings-gear-65"></i> Modifier
            </a>
            <a href="{{ route('admin.apprenants-admin-redoublants.index') }}" class="btn btn-sm btn-secondary mb-0">
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
                <span class="text-white text-3xl font-weight-bold">{{ strtoupper(substr($apprenant->prenom ?? '', 0, 1) . substr($apprenant->nom ?? '', 0, 1)) }}</span>
              </div>
            @endif
            <h5 class="mt-3 mb-1">{{ $apprenant->prenom ?? '' }} {{ $apprenant->nom ?? '' }}</h5>
            <p class="text-sm text-secondary mb-0">{{ $apprenant->email }}</p>
            <div class="mt-2">
                  @if($apprenant->est_promu)
                <span class="badge badge-sm bg-gradient-success">Admis</span>
              @elseif($apprenant->est_redoublant)
                <span class="badge badge-sm bg-gradient-warning">Redoublant</span>
              @endif
              @if($apprenant->statut)
                <span class="badge badge-sm bg-gradient-{{ $apprenant->statut === 'actif' ? 'success' : ($apprenant->statut === 'bloque' ? 'danger' : 'warning') }}">
                  {{ ucfirst($apprenant->statut) }}
                </span>
              @endif
            </div>
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
                <label class="form-label text-xs font-weight-bold">Email</label>
                <p class="mb-0">{{ $apprenant->email ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Téléphone</label>
                <p class="mb-0">{{ $apprenant->phone ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Matricule</label>
                <p class="mb-0">{{ $apprenant->matricule ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Date de naissance</label>
                <p class="mb-0">{{ $apprenant->date_naissance ? \Carbon\Carbon::parse($apprenant->date_naissance)->format('d/m/Y') : 'N/A' }}</p>
              </div>
            </div>
            
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Informations académiques</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Classe</label>
                <p class="mb-0">{{ $apprenant->niveau_etude ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Filière</label>
                <p class="mb-0">{{ $apprenant->filiere ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Année Académique</label>
                <p class="mb-0">
                  {{ $apprenant->annee_academique ?? ($apprenant->created_at ? $apprenant->created_at->format('Y') . '-' . ($apprenant->created_at->format('Y') + 1) : 'N/A') }}
                </p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Statut</label>
                <p class="mb-0">
                  @if($apprenant->est_promu)
                    <span class="badge badge-sm bg-gradient-success">Admis (Passé en classe supérieure)</span>
                  @elseif($apprenant->est_redoublant)
                    <span class="badge badge-sm bg-gradient-warning">Redoublant</span>
                  @else
                    <span class="badge badge-sm bg-gradient-secondary">Normal</span>
                  @endif
                </p>
              </div>
            </div>
            
            <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-3">Autres informations</h6>
            <div class="row mb-4">
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Ville</label>
                <p class="mb-0">{{ $apprenant->location ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Nationalité</label>
                <p class="mb-0">{{ $apprenant->nationalite ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-xs font-weight-bold">Date d'inscription</label>
                <p class="mb-0">{{ $apprenant->created_at ? $apprenant->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

