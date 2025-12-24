@extends('layouts.admin')

@section('title', 'Détails Paiement')
@section('breadcrumb', 'Paiements')
@section('page-title', 'Détails du Paiement')

@section('content')
<div class="row">
  <div class="col-12 col-lg-8">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Informations personnelles</h6>
        <a href="{{ route('admin.paiements.receipt', $user->id) }}" class="btn btn-outline-primary btn-sm">Télécharger le reçu</a>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-3"><strong>Nom</strong><br>{{ $user->nom ?? '-' }}</div>
          <div class="col-md-6 mb-3"><strong>Prénom</strong><br>{{ $user->prenom ?? '-' }}</div>
          <div class="col-md-6 mb-3"><strong>Email</strong><br>{{ $user->email }}</div>
          <div class="col-md-6 mb-3"><strong>Téléphone</strong><br>{{ $user->phone ?? '-' }}</div>
          <div class="col-md-6 mb-3"><strong>Filière</strong><br>{{ $user->filiere ?? '-' }}</div>
          <div class="col-md-6 mb-3"><strong>Niveau d'étude</strong><br>{{ $user->niveau_etude ?? '-' }}</div>
          <div class="col-md-6 mb-3"><strong>Adresse</strong><br>{{ $user->adresse ?? '-' }}</div>
          <div class="col-md-6 mb-3"><strong>Date d'inscription</strong><br>{{ $user->created_at?->format('d/m/Y H:i') }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4">
    <div class="card mb-4">
      <div class="card-header pb-0"><h6 class="mb-0">Paiement</h6></div>
      <div class="card-body">
        <div class="mb-2"><strong>Montant</strong><br>{{ number_format($user->montant_paye ?? 0, 0, ',', ' ') }} FCFA</div>
        <div class="mb-2"><strong>Méthode</strong><br>{{ $user->paiement_method ?? '-' }}</div>
        <div class="mb-2"><strong>Date de paiement</strong><br>{{ $user->date_paiement ? \Illuminate\Support\Carbon::parse($user->date_paiement)->format('d/m/Y H:i') : '-' }}</div>
        <div class="mb-3"><strong>Statut</strong><br>
          <span class="badge {{ ($user->paiement_statut ?? '') === 'effectué' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($user->paiement_statut ?? 'en attente') }}</span>
        </div>

        <form method="POST" action="{{ route('admin.paiements.update-status', $user->id) }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Changer le statut</label>
            <select name="paiement_statut" class="form-control">
              <option value="effectué" {{ ($user->paiement_statut === 'effectué') ? 'selected' : '' }}>Payé</option>
              <option value="en attente" {{ ($user->paiement_statut !== 'effectué') ? 'selected' : '' }}>Non payé</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection





