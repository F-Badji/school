@extends('layouts.admin')

@section('title', 'Ajouter un emploi du temps')
@section('breadcrumb', 'Emploi du temps')
@section('page-title', 'Ajouter un emploi du temps')

@section('content')
<div class="row">
  <div class="col-12 col-lg-8">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Nouvel emploi du temps</h6>
        <a href="{{ route('admin.emploi-du-temps.index') }}" class="btn btn-secondary btn-sm">
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

        <form method="POST" action="{{ route('admin.emploi-du-temps.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Classe <span class="text-danger">*</span></label>
              <select name="classe" class="form-control" required>
                <option value="">Sélectionner une classe</option>
                <option value="licence_1" {{ old('classe') === 'licence_1' ? 'selected' : '' }}>Licence 1</option>
                <option value="licence_2" {{ old('classe') === 'licence_2' ? 'selected' : '' }}>Licence 2</option>
                <option value="licence_3" {{ old('classe') === 'licence_3' ? 'selected' : '' }}>Licence 3</option>
              </select>
              <small class="text-muted">Note : Si un emploi du temps existe déjà pour cette classe, il sera remplacé.</small>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Fichier <span class="text-danger">*</span></label>
              <input type="file" name="fichier" class="form-control" accept=".png,.jpg,.jpeg,.svg,.pdf" required>
              <small class="text-muted">Formats acceptés : PNG, JPG, JPEG, SVG, PDF (max 10 Mo)</small>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="ni ni-fat-add"></i> Enregistrer l'emploi du temps
            </button>
            <a href="{{ route('admin.emploi-du-temps.index') }}" class="btn btn-secondary">Annuler</a>
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
            <li>Sélectionnez la classe concernée</li>
            <li>Uploadez le fichier de l'emploi du temps</li>
            <li>Les formats acceptés sont : PNG, JPG, JPEG, SVG, PDF</li>
            <li>La taille maximale est de 10 Mo</li>
            <li>Si un emploi du temps existe déjà pour cette classe, il sera automatiquement remplacé</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection









