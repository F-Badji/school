@extends('layouts.admin')

@section('title', 'Bulletin')
@section('breadcrumb', 'Bulletin')
@section('page-title', 'Bulletin de l\'Apprenant')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Bulletin de {{ $apprenant->name ?? ($apprenant->nom . ' ' . $apprenant->prenom) }}</h6>
          <button onclick="window.print()" class="btn btn-sm btn-primary mb-0">
            <i class="ni ni-printer"></i> Imprimer
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>BULLETIN SCOLAIRE</h4>
          <p class="text-sm text-secondary">Année académique {{ date('Y') }}</p>
        </div>
        
        <div class="row mb-4">
          <div class="col-md-6">
            <p><strong>Nom :</strong> {{ $apprenant->nom }}</p>
            <p><strong>Prénom :</strong> {{ $apprenant->prenom }}</p>
            <p><strong>Classe :</strong> {{ $apprenant->classe->nom ?? $apprenant->classe->libelle ?? 'N/A' }}</p>
          </div>
          <div class="col-md-6">
            <p><strong>Email :</strong> {{ $apprenant->email }}</p>
            <p><strong>Filière :</strong> {{ $apprenant->filiere ?? 'N/A' }}</p>
          </div>
        </div>

        @if(isset($apprenant->evaluations) && $apprenant->evaluations->count() > 0)
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Matière / Évaluation</th>
                <th>Note</th>
                <th>Coefficient</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($apprenant->evaluations as $evaluation)
              <tr>
                <td>{{ $evaluation->evaluation->titre ?? 'Évaluation' }}</td>
                <td class="text-center">{{ $evaluation->note ?? 'N/A' }}/20</td>
                <td class="text-center">{{ $evaluation->coefficient ?? 1 }}</td>
                <td>{{ $evaluation->created_at->format('d/m/Y') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="alert alert-info">
          <p class="mb-0">Aucune évaluation enregistrée pour cet apprenant.</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

