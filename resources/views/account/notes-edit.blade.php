@extends('layouts.admin')

@section('title', 'Modifier la Note')
@section('breadcrumb', 'Mes Notes')
@section('page-title', 'Modifier la Note')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Modifier la Note</h6>
          <a href="{{ auth()->user()->role === 'admin' ? route('admin.notes') : route('account.notes') }}" class="btn btn-outline-secondary btn-sm">
            <i class="ni ni-bold-left"></i> Retour
          </a>
        </div>
        <div class="card-body">
          @if($note)
            <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.notes.update', $note->id) : route('account.notes.update', $note->id) }}">
              @csrf
              @method('PUT')
              
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Matricule *</label>
                  <input type="text" name="matricule" class="form-control" value="{{ $note->matricule ?? '' }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Nom *</label>
                  <input type="text" name="nom" class="form-control" value="{{ $note->nom ?? '' }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Prénom *</label>
                  <input type="text" name="prenom" class="form-control" value="{{ $note->prenom ?? '' }}" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Date de naissance</label>
                  <input type="date" name="annee_naissance" class="form-control" value="{{ $note->annee_naissance ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Cours</label>
                  <input type="text" name="classe" class="form-control" value="{{ $note->classe ?? '' }}" placeholder="Nom de la matière">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Classe</label>
                  <input type="text" name="niveau_etude" class="form-control" value="{{ $note->niveau_etude ?? '' }}" placeholder="Ex: Licence 1, Licence 2, etc.">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Semestre</label>
                  <input type="text" name="semestre" class="form-control" value="{{ $note->semestre ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Coefficient</label>
                  <input type="text" name="coefficient" class="form-control" value="{{ $note->coefficient ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Devoir (0-20)</label>
                  <input type="number" name="devoir" class="form-control" step="0.01" min="0" max="20" value="{{ $note->devoir ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Examen (0-20)</label>
                  <input type="number" name="examen" class="form-control" step="0.01" min="0" max="20" value="{{ $note->examen ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Quiz (0-20)</label>
                  <input type="number" name="quiz" class="form-control" step="0.01" min="0" max="20" value="{{ $note->quiz ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label text-uppercase text-xs font-weight-bold">Moyenne (0-20)</label>
                  <input type="number" name="moyenne" class="form-control" step="0.01" min="0" max="20" value="{{ $note->moyenne ?? '' }}" readonly>
                  <small class="text-muted">Calculée automatiquement : (Devoir + Examen) / 2</small>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="redoubler" id="redoubler" value="1" {{ ($note->redoubler ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="redoubler">
                      Redoubler
                    </label>
                  </div>
                </div>
              </div>
              
              <div class="mt-4 pt-4 border-top">
                <div class="d-flex gap-2">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check"></i> Enregistrer les modifications
                  </button>
                  <a href="{{ auth()->user()->role === 'admin' ? route('admin.notes') : route('account.notes') }}" class="btn btn-secondary">
                    <i class="ni ni-bold-left"></i> Annuler
                  </a>
                </div>
              </div>
            </form>
          @else
            <div class="alert alert-warning">
              Note non trouvée.
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Calculer automatiquement la moyenne lors de la modification du devoir ou de l'examen
  document.addEventListener('DOMContentLoaded', function() {
    const devoirInput = document.querySelector('input[name="devoir"]');
    const examenInput = document.querySelector('input[name="examen"]');
    const moyenneInput = document.querySelector('input[name="moyenne"]');
    
    function calculateMoyenne() {
      const devoir = parseFloat(devoirInput.value) || 0;
      const examen = parseFloat(examenInput.value) || 0;
      const moyenne = (devoir + examen) / 2;
      moyenneInput.value = moyenne.toFixed(2);
    }
    
    if (devoirInput && examenInput && moyenneInput) {
      devoirInput.addEventListener('input', calculateMoyenne);
      examenInput.addEventListener('input', calculateMoyenne);
      // Calculer au chargement de la page
      calculateMoyenne();
    }
  });
</script>
@endpush
@endsection

