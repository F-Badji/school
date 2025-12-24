@extends('layouts.admin')

@section('title', 'Modifier le Paiement')
@section('breadcrumb', 'Modifier le Paiement')
@section('page-title', 'Modifier le Paiement')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Modifier le Paiement</h6>
          <a href="{{ route('admin.paiements.index') }}" class="btn btn-secondary btn-sm mb-0">
            <i class="fas fa-arrow-left"></i> Retour
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.paiements.update', $user->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nom</label>
              <input type="text" class="form-control" value="{{ $user->nom ?? 'N/A' }}" disabled>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Prénom</label>
              <input type="text" class="form-control" value="{{ $user->prenom ?? 'N/A' }}" disabled>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Montant payé (FCFA)</label>
              <input type="number" name="montant_paye" class="form-control" value="{{ old('montant_paye', $user->montant_paye) }}" min="0" step="0.01">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date de paiement</label>
              <input type="date" name="date_paiement" class="form-control" value="{{ old('date_paiement', $user->date_paiement ? \Carbon\Carbon::parse($user->date_paiement)->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Heure de paiement</label>
              <input type="time" name="heure_paiement" class="form-control" value="{{ old('heure_paiement', $user->date_paiement ? \Carbon\Carbon::parse($user->date_paiement)->format('H:i') : '') }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Méthode de paiement</label>
              <select name="paiement_method" class="form-control">
                <option value="">Sélectionner une méthode</option>
                <option value="Orange Money" {{ old('paiement_method', $user->paiement_method) === 'Orange Money' ? 'selected' : '' }}>Orange Money</option>
                <option value="Wave" {{ old('paiement_method', $user->paiement_method) === 'Wave' ? 'selected' : '' }}>Wave</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Statut</label>
              <select name="paiement_statut" class="form-control">
                <option value="">Sélectionner un statut</option>
                <option value="effectué" {{ old('paiement_statut', $user->paiement_statut) === 'effectué' ? 'selected' : '' }}>Effectué</option>
                <option value="en attente" {{ old('paiement_statut', $user->paiement_statut) === 'en attente' ? 'selected' : '' }}>En attente</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection


@section('title', 'Modifier le Paiement')
@section('breadcrumb', 'Modifier le Paiement')
@section('page-title', 'Modifier le Paiement')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Modifier le Paiement</h6>
          <a href="{{ route('admin.paiements.index') }}" class="btn btn-secondary btn-sm mb-0">
            <i class="fas fa-arrow-left"></i> Retour
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.paiements.update', $user->id) }}">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nom</label>
              <input type="text" class="form-control" value="{{ $user->nom ?? 'N/A' }}" disabled>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Prénom</label>
              <input type="text" class="form-control" value="{{ $user->prenom ?? 'N/A' }}" disabled>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Montant payé (FCFA)</label>
              <input type="number" name="montant_paye" class="form-control" value="{{ old('montant_paye', $user->montant_paye) }}" min="0" step="0.01">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date de paiement</label>
              <input type="date" name="date_paiement" class="form-control" value="{{ old('date_paiement', $user->date_paiement ? \Carbon\Carbon::parse($user->date_paiement)->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Heure de paiement</label>
              <input type="time" name="heure_paiement" class="form-control" value="{{ old('heure_paiement', $user->date_paiement ? \Carbon\Carbon::parse($user->date_paiement)->format('H:i') : '') }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Méthode de paiement</label>
              <select name="paiement_method" class="form-control">
                <option value="">Sélectionner une méthode</option>
                <option value="Orange Money" {{ old('paiement_method', $user->paiement_method) === 'Orange Money' ? 'selected' : '' }}>Orange Money</option>
                <option value="Wave" {{ old('paiement_method', $user->paiement_method) === 'Wave' ? 'selected' : '' }}>Wave</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Statut</label>
              <select name="paiement_statut" class="form-control">
                <option value="">Sélectionner un statut</option>
                <option value="effectué" {{ old('paiement_statut', $user->paiement_statut) === 'effectué' ? 'selected' : '' }}>Effectué</option>
                <option value="en attente" {{ old('paiement_statut', $user->paiement_statut) === 'en attente' ? 'selected' : '' }}>En attente</option>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
