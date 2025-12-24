@extends('layouts.admin')

@section('title', 'Security')
@section('breadcrumb', 'Security')
@section('page-title', 'Sécurité')

@section('content')
<div class="container-fluid mt-6">
  <div class="row mb-5">
    <div class="col-lg-3">
      <div class="card position-sticky top-1">
        <ul class="nav flex-column bg-white border-radius-lg p-3">
          <li class="nav-item">
            <a class="nav-link text-body d-flex align-items-center" href="{{ auth()->user()->role === 'admin' ? route('admin.profile') : route('account.profile') }}">
              <i class="ni ni-spaceship me-2 text-dark opacity-6"></i>
              <span class="text-sm">Profil</span>
            </a>
          </li>
          <li class="nav-item pt-2">
            <a class="nav-link text-body d-flex align-items-center" href="{{ auth()->user()->role === 'admin' ? route('admin.settings') : route('account.settings') }}">
              <i class="ni ni-books me-2 text-dark opacity-6"></i>
              <span class="text-sm">Paramètres</span>
            </a>
          </li>
          <li class="nav-item pt-2">
            <a class="nav-link text-body d-flex align-items-center active" href="{{ auth()->user()->role === 'admin' ? route('admin.security') : route('account.security') }}">
              <i class="ni ni-lock-circle-open me-2 text-dark opacity-6"></i>
              <span class="text-sm">Sécurité</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="col-lg-9 mt-lg-0 mt-4">
      <!-- Card Sécurité -->
      <div class="card mt-4">
        <div class="card-header">
          <h5>Sécurité du compte</h5>
          <p class="text-sm mb-0">Gérez les paramètres de sécurité de votre compte</p>
        </div>
        <div class="card-body pt-0">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: transparent !important; border: none; padding: 0;">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li style="color: #dc3545;">{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Section Changer le mot de passe -->
          <div class="mb-4">
            <h6 class="mb-3">Changer le mot de passe</h6>
            <form id="passwordForm" action="{{ auth()->user()->role === 'admin' ? route('admin.settings.updatePassword') : route('account.settings.updatePassword') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Mot de passe actuel</label>
                  <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                  @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nouveau mot de passe</label>
                  <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                  @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Confirmer le nouveau mot de passe</label>
                  <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" required>
                  @error('new_password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <button type="submit" class="btn bg-gradient-dark btn-sm mt-3 mb-0">Mettre à jour le mot de passe</button>
            </form>
          </div>

          <hr>

          @if(auth()->user()->role === 'admin' || auth()->user()->is_admin)
          <!-- Section Mot de passe de suppression -->
          <div class="mb-4">
            <h6 class="mb-3">Mot de passe de suppression</h6>
            <p class="text-sm text-muted mb-3">Modifiez le mot de passe requis pour effectuer des suppressions dans l'interface d'administration. Le mot de passe doit contenir uniquement des chiffres.</p>
            <form id="deletePasswordForm" action="{{ auth()->user()->role === 'admin' ? route('admin.security.updateDeletePassword') : route('account.security.updateDeletePassword') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Ancien mot de passe de suppression <span class="text-danger">*</span></label>
                  <input type="password" name="current_delete_password" id="current_delete_password" class="form-control @error('current_delete_password') is-invalid @enderror" required pattern="[0-9]+" inputmode="numeric">
                  @error('current_delete_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="form-text text-muted">Entrez l'ancien mot de passe de suppression.</small>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nouveau mot de passe de suppression <span class="text-danger">*</span></label>
                  <input type="password" name="new_delete_password" id="new_delete_password" class="form-control @error('new_delete_password') is-invalid @enderror" required minlength="4" pattern="[0-9]+" inputmode="numeric">
                  @error('new_delete_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="form-text text-muted">Le mot de passe doit contenir uniquement des chiffres (minimum 4 chiffres).</small>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Confirmer le nouveau mot de passe <span class="text-danger">*</span></label>
                  <input type="password" name="new_delete_password_confirmation" id="new_delete_password_confirmation" class="form-control @error('new_delete_password_confirmation') is-invalid @enderror" required minlength="4" pattern="[0-9]+" inputmode="numeric">
                  @error('new_delete_password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <button type="submit" class="btn bg-gradient-dark btn-sm mt-3 mb-0">
                <i class="ni ni-check-bold"></i> Mettre à jour le mot de passe de suppression
              </button>
            </form>
          </div>

          <hr>
          @endif

          <!-- Section Appareils connectés -->
          <div class="mb-4">
            <h6 class="mb-3">Appareils connectés</h6>
            <p class="text-sm text-muted mb-3">Gérez les appareils qui ont accès à votre compte.</p>
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.settings') : route('account.settings') }}#sessions" class="btn btn-outline-primary btn-sm">
              Voir les appareils connectés
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
  /* Style pour les messages d'erreur des formulaires de mot de passe */
  #passwordForm .invalid-feedback,
  #deletePasswordForm .invalid-feedback {
    background: transparent !important;
    color: #dc3545 !important;
    padding: 0.25rem 0;
    margin-top: 0.5rem;
    display: block;
    border: none;
  }
  
  /* Style spécifique pour tous les messages d'erreur de validation */
  form .invalid-feedback {
    background: transparent !important;
    color: #dc3545 !important;
  }
</style>
@endpush

@push('scripts')
<script>
  if (document.getElementById('choices-questions')) {
    var questions = document.getElementById('choices-questions');
    const example = new Choices(questions);
  }

  function visible() {
    // Function for toggle switches
  }
</script>
@endpush
@endsection

