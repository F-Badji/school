@extends('layouts.admin')

@section('title', 'Détails de la Matière')
@section('breadcrumb', 'Détails de la Matière')
@section('page-title', 'Détails de la Matière')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Informations de la Matière</h6>
          <div class="d-flex gap-2">
            <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-primary btn-sm mb-0">
              <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary btn-sm mb-0">
              <i class="fas fa-arrow-left"></i> Retour
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label text-muted">Nom de la matière</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->nom_matiere }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Filière</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->filiere ?? 'Non spécifiée' }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Classe</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->niveau_etude ?? 'Non spécifiée' }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Date de création</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->created_at->format('d/m/Y à H:i') }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Dernière modification</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->updated_at->format('d/m/Y à H:i') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('title', 'Détails de la Matière')
@section('breadcrumb', 'Détails de la Matière')
@section('page-title', 'Détails de la Matière')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Informations de la Matière</h6>
          <div class="d-flex gap-2">
            <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-primary btn-sm mb-0">
              <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary btn-sm mb-0">
              <i class="fas fa-arrow-left"></i> Retour
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label text-muted">Nom de la matière</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->nom_matiere }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Filière</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->filiere ?? 'Non spécifiée' }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Classe</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->niveau_etude ?? 'Non spécifiée' }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Date de création</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->created_at->format('d/m/Y à H:i') }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-muted">Dernière modification</label>
            <p class="text-sm font-weight-bold mb-0">{{ $matiere->updated_at->format('d/m/Y à H:i') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
