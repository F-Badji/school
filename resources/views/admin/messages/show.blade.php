@extends('layouts.admin')

@section('title', 'Détails du Message')
@section('breadcrumb', 'Détails du Message')
@section('page-title', 'Détails du Message')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Détails du Message</h6>
          <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary mb-0">
            <i class="ni ni-bold-left"></i> Retour
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row mb-4">
          <div class="col-md-6 mb-3">
            <label class="form-label text-xs font-weight-bold">Date</label>
            <p class="mb-0">{{ $message->created_at->format('d/m/Y H:i') }}</p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-xs font-weight-bold">Étiquette</label>
            <p class="mb-0">
              @php $label = $message->label; @endphp
              <span class="badge {{ $label==='Urgent' ? 'bg-danger' : ($label==='Signalement' ? 'bg-warning' : 'bg-secondary') }}">{{ $label }}</span>
            </p>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-xs font-weight-bold">Expéditeur</label>
            <p class="mb-0">{{ $message->sender->name ?? 'N/A' }} ({{ $message->sender->role ?? 'apprenant' }})</p>
            <small class="text-muted">{{ $message->sender->email ?? '' }}</small>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-xs font-weight-bold">Destinataire</label>
            <p class="mb-0">{{ $message->receiver->name ?? 'N/A' }} ({{ $message->receiver->role ?? 'apprenant' }})</p>
            <small class="text-muted">{{ $message->receiver->email ?? '' }}</small>
          </div>
          <div class="col-12 mb-3">
            <label class="form-label text-xs font-weight-bold">Message</label>
            <div class="p-3 bg-light rounded">
              <p class="mb-0">{{ $message->content }}</p>
            </div>
          </div>
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.messages.edit', $message->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil"></i> Modifier
          </a>
          <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">
            <i class="ni ni-bold-left"></i> Retour
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection







