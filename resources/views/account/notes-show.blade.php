@extends('layouts.admin')

@section('title', 'Détails de la Note')
@section('breadcrumb', 'Mes Notes')
@section('page-title', 'Détails de la Note')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Détails de la Note</h6>
          <a href="{{ auth()->user()->role === 'admin' ? route('admin.notes') : route('account.notes') }}" class="btn btn-outline-secondary btn-sm">
            <i class="ni ni-bold-left"></i> Retour
          </a>
        </div>
        <div class="card-body">
          @if($note)
            <div class="row">
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Matricule</strong>
                <p class="text-sm">{{ $note->matricule ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Nom</strong>
                <p class="text-sm">{{ $note->nom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Prénom</strong>
                <p class="text-sm">{{ $note->prenom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Date de naissance</strong>
                <p class="text-sm">
                  @if($note->annee_naissance)
                    @php
                      try {
                        $dateNaissance = \Carbon\Carbon::parse($note->annee_naissance);
                        echo $dateNaissance->format('d/m/Y');
                      } catch (\Exception $e) {
                        echo $note->annee_naissance;
                      }
                    @endphp
                  @else
                    N/A
                  @endif
                </p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Cours</strong>
                <p class="text-sm">{{ $note->classe ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Classe</strong>
                <p class="text-sm">{{ $note->niveau_etude ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Semestre</strong>
                <p class="text-sm">{{ $note->semestre ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Coefficient</strong>
                <p class="text-sm">{{ $note->coefficient ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Devoir</strong>
                <p class="text-sm font-weight-bold">{{ $note->devoir ?? '-' }}/20</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Examen</strong>
                <p class="text-sm font-weight-bold">{{ $note->examen ?? '-' }}/20</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Quiz</strong>
                <p class="text-sm font-weight-bold">{{ $note->quiz ?? '-' }}/20</p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Moyenne</strong>
                <p class="text-sm font-weight-bold text-primary">
                  @php
                    // Calculer la moyenne : (Devoir + Examen) / 2
                    $devoir = $note->devoir ?? 0;
                    $examen = $note->examen ?? 0;
                    $moyenne = round(($devoir + $examen) / 2, 2);
                    echo $moyenne . '/20';
                  @endphp
                </p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Redoubler</strong>
                <p class="text-sm">
                  <span class="badge {{ $note->redoubler ? 'bg-danger' : 'bg-success' }}">
                    {{ $note->redoubler ? 'Oui' : 'Non' }}
                  </span>
                </p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Date de création</strong>
                <p class="text-sm">
                  @if($note->created_at)
                    {{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y à H:i') }}
                  @else
                    N/A
                  @endif
                </p>
              </div>
              <div class="col-md-6 mb-3">
                <strong class="text-uppercase text-xs font-weight-bold">Dernière modification</strong>
                <p class="text-sm">
                  @if($note->updated_at)
                    {{ \Carbon\Carbon::parse($note->updated_at)->format('d/m/Y à H:i') }}
                  @else
                    N/A
                  @endif
                </p>
              </div>
            </div>
            
            <div class="mt-4 pt-4 border-top">
              <div class="d-flex gap-2">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.notes.edit', $note->id) : route('account.notes.edit', $note->id) }}" class="btn btn-primary btn-sm">
                  <i class="bi bi-pencil"></i> Modifier
                </a>
                <form action="{{ auth()->user()->role === 'admin' ? route('admin.notes.destroy', $note->id) : route('account.notes.destroy', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i> Supprimer
                  </button>
                </form>
              </div>
            </div>
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
@endsection

