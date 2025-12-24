@extends('layouts.admin')

@section('title', 'Cours')
@section('breadcrumb', 'Cours')
@section('page-title', 'Gestion des Cours')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Liste des Cours</h6>
          <a href="{{ route('admin.cours.create') }}" class="btn btn-primary btn-sm mb-0">
            <i class="ni ni-fat-add"></i> Nouveau Cours
          </a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cours</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Durée</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Formateur</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date de création</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @forelse($cours as $c)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="icon icon-shape icon-sm bg-gradient-success text-center border-radius-md">
                        <i class="ni ni-book-bookmark text-white opacity-10"></i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-3">
                      <h6 class="mb-0 text-xs">{{ $c->titre ?? 'Cours #' . $c->id }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $c->code ?? 'N/A' }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ Str::limit($c->description ?? 'Aucune description', 50) }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="text-secondary text-xs font-weight-bold">{{ $c->duree ?? 'N/A' }}</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">
                    @if($c->formateur)
                      {{ $c->formateur->nom ?? '' }} {{ $c->formateur->prenom ?? '' }}
                    @else
                      Non assigné
                    @endif
                  </span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">{{ $c->created_at->format('d/m/Y') }}</span>
                </td>
                <td class="align-middle text-center text-sm">
                  @if($c->actif ?? true)
                    <span class="badge badge-sm badge-success">Actif</span>
                  @else
                    <span class="badge badge-sm badge-secondary">Inactif</span>
                  @endif
                </td>
                <td class="align-middle">
                  <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('admin.cours.edit', $c) }}" class="btn btn-link text-primary p-2 mb-0" data-toggle="tooltip" data-original-title="Modifier">
                      <i class="bi bi-pencil text-lg" aria-hidden="true"></i>
                    </a>
                    <form action="{{ route('admin.cours.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-link text-danger p-2 mb-0" data-toggle="tooltip" data-original-title="Supprimer">
                        <i class="bi bi-trash text-lg" aria-hidden="true"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center py-4">
                  <div class="d-flex flex-column align-items-center">
                    <i class="ni ni-book-bookmark text-secondary mb-2" style="font-size: 3rem;"></i>
                    <p class="text-xs text-secondary mb-2">Aucun cours trouvé dans la base de données</p>
                    <a href="{{ route('admin.cours.create') }}" class="btn btn-primary btn-sm">
                      <i class="ni ni-fat-add"></i> Créer le premier cours
                    </a>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        @if($cours->hasPages())
        <div class="card-footer px-3 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <p class="text-xs text-secondary mb-0">Affichage de {{ $cours->firstItem() }} à {{ $cours->lastItem() }} sur {{ $cours->total() }} cours</p>
            <div>
              {{ $cours->links() }}
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

