@extends('layouts.admin')

@section('title', 'Conversation')
@section('breadcrumb', 'Messages')
@section('page-title', 'Conversation')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Fil de discussion</h6>
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-light">Retour</a>
      </div>
      <div class="card-body" style="max-height: 70vh; overflow:auto;">
        @forelse($messages as $m)
          <div class="d-flex {{ $loop->iteration % 2 === 0 ? 'justify-content-end' : '' }} mb-3">
            <div class="p-3 rounded {{ $loop->iteration % 2 === 0 ? 'bg-primary text-white' : 'bg-light' }}" style="max-width:70%;">
              <div class="mb-1"><strong>{{ $m->sender->name }}</strong> → {{ $m->receiver->name }} • <small>{{ $m->created_at->format('d/m/Y H:i') }}</small></div>
              <div>{{ $m->content }}</div>
              <div class="mt-1">
                @php $label = $m->label; @endphp
                <span class="badge {{ $label==='Urgent' ? 'bg-danger' : ($label==='Signalement' ? 'bg-warning' : 'bg-secondary') }}">{{ $label }}</span>
              </div>
            </div>
          </div>
        @empty
          <p class="text-center">Aucun message</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection





