@extends('layouts.admin')

@section('title', 'Créer une matière')
@section('breadcrumb', 'Matières')
@section('page-title', 'Créer une nouvelle matière')

@section('content')
<div class="row">
  <div class="col-12 col-lg-8">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Nouvelle matière</h6>
        <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary btn-sm">
          <i class="ni ni-bold-left"></i> Retour
        </a>
      </div>
      <div class="card-body">
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

        <form method="POST" action="{{ route('admin.matieres.store') }}">
          @csrf
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">Nom de la matière <span class="text-danger">*</span></label>
              <input type="text" name="nom_matiere" class="form-control" value="{{ old('nom_matiere') }}" required>
              <small class="text-muted">Le nom doit être unique</small>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Filière</label>
              <input type="text" name="filiere" class="form-control" value="{{ old('filiere') }}" placeholder="Ex: Informatique">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Niveau d'étude</label>
              <select name="niveau_etude" class="form-control">
                <option value="">Sélectionner un niveau</option>
                <option value="Licence 1" {{ old('niveau_etude') === 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                <option value="Licence 2" {{ old('niveau_etude') === 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                <option value="Licence 3" {{ old('niveau_etude') === 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                <option value="Master 1" {{ old('niveau_etude') === 'Master 1' ? 'selected' : '' }}>Master 1</option>
                <option value="Master 2" {{ old('niveau_etude') === 'Master 2' ? 'selected' : '' }}>Master 2</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Semestre</label>
              <select name="semestre" class="form-control">
                <option value="">Sélectionner un semestre</option>
                <option value="Semestre 1" {{ old('semestre') === 'Semestre 1' ? 'selected' : '' }}>Semestre 1</option>
                <option value="Semestre 2" {{ old('semestre') === 'Semestre 2' ? 'selected' : '' }}>Semestre 2</option>
                <option value="Semestre 3" {{ old('semestre') === 'Semestre 3' ? 'selected' : '' }}>Semestre 3</option>
                <option value="Semestre 4" {{ old('semestre') === 'Semestre 4' ? 'selected' : '' }}>Semestre 4</option>
                <option value="Semestre 5" {{ old('semestre') === 'Semestre 5' ? 'selected' : '' }}>Semestre 5</option>
                <option value="Semestre 6" {{ old('semestre') === 'Semestre 6' ? 'selected' : '' }}>Semestre 6</option>
                <option value="Semestre 7" {{ old('semestre') === 'Semestre 7' ? 'selected' : '' }}>Semestre 7</option>
                <option value="Semestre 8" {{ old('semestre') === 'Semestre 8' ? 'selected' : '' }}>Semestre 8</option>
                <option value="Semestre 9" {{ old('semestre') === 'Semestre 9' ? 'selected' : '' }}>Semestre 9</option>
                <option value="Semestre 10" {{ old('semestre') === 'Semestre 10' ? 'selected' : '' }}>Semestre 10</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Ordre</label>
              <input type="number" name="ordre" class="form-control" value="{{ old('ordre') }}" min="0" placeholder="0">
              <small class="text-muted">Ordre d'affichage (optionnel)</small>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="ni ni-fat-add"></i> Créer la matière
            </button>
            <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6 class="mb-0">Informations</h6>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <h6 class="text-sm font-weight-bold mb-2">Instructions :</h6>
          <ul class="text-xs mb-0 ps-3">
            <li>Le nom de la matière est obligatoire et doit être unique</li>
            <li>La filière et le niveau d'étude sont optionnels</li>
            <li>L'ordre permet de définir l'ordre d'affichage des matières</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

