@extends('layouts.admin')

@section('title', 'Nouveau Paiement')
@section('breadcrumb', 'Nouveau Paiement')
@section('page-title', 'Créer un Nouveau Paiement')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Créer un Nouveau Paiement</h6>
          <a href="{{ route('admin.paiements.index') }}" class="btn btn-secondary btn-sm mb-0">
            <i class="fas fa-arrow-left"></i> Retour
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.paiements.store') }}">
          @csrf
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Apprenant <span class="text-danger">*</span></label>
              <select name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">Sélectionner un apprenant</option>
                @foreach($apprenants as $apprenant)
                  <option value="{{ $apprenant->id }}" {{ old('user_id') == $apprenant->id ? 'selected' : '' }}>
                    {{ $apprenant->nom ?? 'N/A' }} {{ $apprenant->prenom ?? 'N/A' }} ({{ $apprenant->email ?? 'N/A' }})
                  </option>
                @endforeach
              </select>
              @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Montant payé (FCFA) <span class="text-danger">*</span></label>
              <input type="number" name="montant_paye" class="form-control @error('montant_paye') is-invalid @enderror" value="{{ old('montant_paye') }}" min="0" step="0.01" required>
              @error('montant_paye')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date de paiement <span class="text-danger">*</span></label>
              <input type="date" name="date_paiement" class="form-control @error('date_paiement') is-invalid @enderror" value="{{ old('date_paiement', date('Y-m-d')) }}" required>
              @error('date_paiement')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Heure de paiement <span class="text-danger">*</span></label>
              <input type="time" name="heure_paiement" class="form-control @error('heure_paiement') is-invalid @enderror" value="{{ old('heure_paiement', date('H:i')) }}" required>
              @error('heure_paiement')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Méthode de paiement <span class="text-danger">*</span></label>
              <select name="paiement_method" class="form-control @error('paiement_method') is-invalid @enderror" required>
                <option value="">Sélectionner une méthode</option>
                <option value="Carte bancaire" {{ old('paiement_method') === 'Carte bancaire' ? 'selected' : '' }}>Carte bancaire</option>
                <option value="Orange Money" {{ old('paiement_method') === 'Orange Money' ? 'selected' : '' }}>Orange Money</option>
                <option value="Wave" {{ old('paiement_method') === 'Wave' ? 'selected' : '' }}>Wave</option>
              </select>
              @error('paiement_method')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Statut <span class="text-danger">*</span></label>
              <select name="paiement_statut" class="form-control @error('paiement_statut') is-invalid @enderror" required>
                <option value="">Sélectionner un statut</option>
                <option value="effectué" {{ old('paiement_statut') === 'effectué' ? 'selected' : '' }}>Effectué</option>
                <option value="en attente" {{ old('paiement_statut', 'en attente') === 'en attente' ? 'selected' : '' }}>En attente</option>
              </select>
              @error('paiement_statut')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.paiements.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Créer le Paiement</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection












