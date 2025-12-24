@extends('layouts.admin')

@section('title', 'Modifier Apprenant')
@section('breadcrumb', 'Modifier Apprenant')
@section('page-title', 'Modifier l\'Apprenant')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Modifier les Informations</h6>
          <a href="{{ route('admin.apprenants-admin-redoublants.index') }}" class="btn btn-sm btn-secondary mb-0">
            <i class="ni ni-bold-left"></i> Retour
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.apprenants-admin-redoublants.update', $apprenant) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nom <span class="text-danger">*</span></label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $apprenant->nom) }}" required>
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Prénom <span class="text-danger">*</span></label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $apprenant->prenom) }}" required>
              @error('prenom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $apprenant->email) }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Téléphone</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $apprenant->phone) }}" placeholder="Ex: +221 77 123 45 67">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Filière</label>
              <input type="text" name="filiere" class="form-control @error('filiere') is-invalid @enderror" value="{{ old('filiere', $apprenant->filiere) }}">
              @error('filiere')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Classe</label>
              <input type="text" name="niveau_etude" class="form-control @error('niveau_etude') is-invalid @enderror" value="{{ old('niveau_etude', $apprenant->niveau_etude) }}">
              @error('niveau_etude')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Année Académique</label>
              <input type="text" name="annee_academique" class="form-control @error('annee_academique') is-invalid @enderror" value="{{ old('annee_academique', $apprenant->annee_academique) }}" placeholder="Ex: 2024-2025">
              @error('annee_academique')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="est_promu" id="est_promu" value="1" {{ old('est_promu', $apprenant->est_promu) ? 'checked' : '' }}>
                <label class="form-check-label" for="est_promu">
                  Passé en classe supérieure (Promu)
                </label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="est_redoublant" id="est_redoublant" value="1" {{ old('est_redoublant', $apprenant->est_redoublant) ? 'checked' : '' }}>
                <label class="form-check-label" for="est_redoublant">
                  Redoublant
                </label>
              </div>
            </div>
          </div>
          
          <div class="row mt-4">
            <div class="col-12">
              <button type="submit" class="btn btn-primary">
                <i class="ni ni-check-bold"></i> Enregistrer les modifications
              </button>
              <a href="{{ route('admin.apprenants-admin-redoublants.index') }}" class="btn btn-secondary">
                <i class="ni ni-bold-left"></i> Annuler
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

