@extends('layouts.admin')

@include('components.delete-modal-handler')

@section('title', 'Notifications')
@section('breadcrumb', 'Notifications')
@section('page-title', 'Centre de Notifications')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Envoyer une notification</h6>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.notifications.store') }}">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Titre</label>
              <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Audience</label>
              <select name="audience" class="form-control" id="audience-select" required>
                <option value="tous">Tous</option>
                <option value="apprenants">Apprenants</option>
                <option value="formateurs">Formateurs</option>
                <option value="utilisateur">Individuel</option>
              </select>
            </div>
          </div>
          <div class="row" id="individual-target" style="display: none;">
            <div class="col-md-6 mb-3">
              <label class="form-label">Sélectionner l'utilisateur</label>
              <select name="user_id" class="form-control">
                <optgroup label="Apprenants">
                  @foreach($apprenants as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                  @endforeach
                </optgroup>
                <optgroup label="Formateurs">
                  @foreach($formateurs as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                  @endforeach
                </optgroup>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="body" class="form-control" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Historique des notifications</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Titre</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Audience</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($messages as $m)
                <tr>
                  <td>{{ $m->title }}</td>
                  <td>{{ $m->audience }}</td>
                  <td>{{ $m->status }}</td>
                  <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                  <td class="text-center">
                    <button type="button" 
                            class="btn btn-link action-btn p-2 mb-0" 
                            data-toggle="modal" 
                            data-target="#deleteConfirmModal{{ $m->id }}" 
                            data-original-title="Supprimer" 
                            style="color: #f5365c !important; opacity: 1 !important;">
                      <i class="bi bi-trash text-lg" aria-hidden="true" style="color: #f5365c !important; opacity: 1 !important; -webkit-text-fill-color: #f5365c !important;"></i>
                    </button>
                    @include('components.delete-confirm-modal', [
                      'id' => $m->id,
                      'action' => route('admin.notifications.destroy', $m->id),
                      'message' => 'Êtes-vous sûr de vouloir supprimer cette notification ?'
                    ])
                  </td>
                </tr>
              @empty
                <tr><td colspan="5" class="text-center py-4">Aucun message</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.getElementById('audience-select').addEventListener('change', function() {
    document.getElementById('individual-target').style.display = this.value === 'utilisateur' ? 'block' : 'none';
  });
</script>
@endpush
@endsection





