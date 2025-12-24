@extends('layouts.admin')

@section('title', 'Modifier le Message')
@section('breadcrumb', 'Modifier le Message')
@section('page-title', 'Modifier le Message')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="mb-0">Modifier le Message</h6>
          <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary mb-0">
            <i class="ni ni-bold-left"></i> Retour
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.messages.update', $message->id) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="mb-3">
            <label class="form-label">Expéditeur</label>
            <input type="text" class="form-control" value="{{ $message->sender->name ?? 'N/A' }} ({{ $message->sender->role ?? 'apprenant' }})" readonly>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Destinataire</label>
            <input type="text" class="form-control" value="{{ $message->receiver->name ?? 'N/A' }} ({{ $message->receiver->role ?? 'apprenant' }})" readonly>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="text" class="form-control" value="{{ $message->created_at->format('d/m/Y H:i') }}" readonly>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Message <span class="text-danger">*</span></label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $message->content) }}</textarea>
            @error('content')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="mb-3">
            <label class="form-label">Étiquette</label>
            <select name="label" class="form-control @error('label') is-invalid @enderror">
              <option value="Normal" {{ old('label', $message->label) === 'Normal' ? 'selected' : '' }}>Normal</option>
              <option value="Signalement" {{ old('label', $message->label) === 'Signalement' ? 'selected' : '' }}>Signalement</option>
              <option value="Urgent" {{ old('label', $message->label) === 'Urgent' ? 'selected' : '' }}>Urgent</option>
            </select>
            @error('label')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
              <i class="ni ni-check-bold"></i> Enregistrer
            </button>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">
              <i class="ni ni-bold-left"></i> Annuler
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection







