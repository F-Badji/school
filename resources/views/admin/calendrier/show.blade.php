@extends('layouts.admin')

@section('title', 'Détails de l\'événement')
@section('breadcrumb', 'Calendrier')
@section('page-title', 'Détails de l\'événement')

@section('content')
<div class="row">
  <div class="col-12 col-lg-8">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Informations de l'événement</h6>
        <div>
          <a href="{{ route('admin.calendrier.edit', $event->id) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-pencil"></i> Modifier
          </a>
          <a href="{{ route('admin.calendrier.index') }}" class="btn btn-secondary btn-sm">
            <i class="ni ni-bold-left"></i> Retour
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 mb-3">
            <strong>Titre</strong><br>
            <span class="text-dark">{{ $event->titre }}</span>
          </div>
          <div class="col-md-6 mb-3">
            <strong>Type</strong><br>
            <span class="badge badge-sm {{ $event->type === 'Examen' ? 'bg-danger' : 'bg-info' }}">
              {{ $event->type }}
            </span>
          </div>
          <div class="col-md-6 mb-3">
            <strong>Date et heure</strong><br>
            <span class="text-dark">
              {{ optional($event->scheduled_at)->format('d/m/Y') }} à {{ optional($event->scheduled_at)->format('H:i') }}
            </span>
          </div>
          <div class="col-md-6 mb-3">
            <strong>Classe</strong><br>
            <span class="text-dark">{{ $event->classe_id ?? 'Toutes les classes' }}</span>
          </div>
          <div class="col-md-6 mb-3">
            <strong>Matière</strong><br>
            @if($event->cours_id)
              @php
                $matiere = \App\Models\Matiere::find($event->cours_id);
              @endphp
              <span class="text-dark">
                {{ $matiere ? ($matiere->nom_matiere ?? $matiere->nom ?? 'Matière #' . $event->cours_id) : 'Matière #' . $event->cours_id }}
              </span>
            @else
              <span class="text-secondary">Aucune matière spécifiée</span>
            @endif
          </div>
          @if($event->rappel_minutes)
          <div class="col-md-6 mb-3">
            <strong>Rappel</strong><br>
            <span class="text-dark">{{ $event->rappel_minutes }} minutes avant</span>
          </div>
          @endif
          <div class="col-md-6 mb-3">
            <strong>Date de création</strong><br>
            <span class="text-dark">{{ $event->created_at->format('d/m/Y H:i') }}</span>
          </div>
          <div class="col-md-6 mb-3">
            <strong>Dernière modification</strong><br>
            <span class="text-dark">{{ $event->updated_at->format('d/m/Y H:i') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6 class="mb-0">Actions</h6>
      </div>
      <div class="card-body">
        <div class="d-flex flex-column gap-2">
          <a href="{{ route('admin.calendrier.edit', $event->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Modifier l'événement
          </a>
          <form action="{{ route('admin.calendrier.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger w-100">
              <i class="bi bi-trash"></i> Supprimer l'événement
            </button>
          </form>
          <a href="{{ route('admin.calendrier.index') }}" class="btn btn-secondary">
            <i class="ni ni-bold-left"></i> Retour à la liste
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection









