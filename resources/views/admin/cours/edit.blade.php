@extends('layouts.admin')

@section('title', 'Modifier Cours')
@section('breadcrumb', 'Modifier Cours')
@section('page-title', 'Modifier le Cours')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Modifier les Informations</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.cours.update', $cour) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Titre du cours <span class="text-danger">*</span></label>
              <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" value="{{ old('titre', $cour->titre) }}" required>
              @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Formateur</label>
              <select name="formateur_id" class="form-control @error('formateur_id') is-invalid @enderror">
                <option value="">Sélectionner un formateur</option>
                @foreach($formateurs as $formateur)
                  <option value="{{ $formateur->id }}" {{ old('formateur_id', $cour->formateur_id) == $formateur->id ? 'selected' : '' }}>
                    {{ trim(($formateur->nom ?? '') . ' ' . ($formateur->prenom ?? '')) ?: $formateur->name }} ({{ $formateur->email }})
                  </option>
                @endforeach
              </select>
              @error('formateur_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Filière</label>
              <input type="text" name="filiere" class="form-control @error('filiere') is-invalid @enderror" value="{{ old('filiere', $cour->filiere) }}">
              @error('filiere')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Niveau d'étude</label>
              <select name="niveau_etude" class="form-control @error('niveau_etude') is-invalid @enderror">
                <option value="">Sélectionner un niveau</option>
                <option value="Licence 1" {{ old('niveau_etude', $cour->niveau_etude) === 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                <option value="Licence 2" {{ old('niveau_etude', $cour->niveau_etude) === 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                <option value="Licence 3" {{ old('niveau_etude', $cour->niveau_etude) === 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                <option value="Master 1" {{ old('niveau_etude', $cour->niveau_etude) === 'Master 1' ? 'selected' : '' }}>Master 1</option>
                <option value="Master 2" {{ old('niveau_etude', $cour->niveau_etude) === 'Master 2' ? 'selected' : '' }}>Master 2</option>
              </select>
              @error('niveau_etude')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Durée</label>
              <input type="text" name="duree" class="form-control @error('duree') is-invalid @enderror" value="{{ old('duree', $cour->duree) }}" placeholder="Ex: 40 heures, 3 mois">
              @error('duree')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Ordre</label>
              <input type="number" name="ordre" class="form-control @error('ordre') is-invalid @enderror" value="{{ old('ordre', $cour->ordre ?? 0) }}" min="0">
              @error('ordre')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $cour->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="actif" id="actif" value="1" {{ old('actif', $cour->actif ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="actif">
                  Cours actif
                </label>
              </div>
            </div>
          </div>
          
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.cours.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

