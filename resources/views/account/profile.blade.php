@extends('layouts.admin')

@section('title', 'Profil')
@section('breadcrumb', 'Profil')
@section('page-title', 'Mon Profil')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Informations du Profil</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4 text-center mb-4">
            <div class="avatar avatar-xl position-relative" style="margin-top: 1.5rem;">
              @if(auth()->user()->photo)
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Photo de profil" class="avatar-img rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
              @else
                <div class="avatar-img rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; margin: 0 auto;">
                  <span class="text-white text-uppercase" style="font-size: 3rem; font-weight: bold;">
                    {{ strtoupper(substr(auth()->user()->prenom ?? '', 0, 1) . substr(auth()->user()->nom ?? '', 0, 1)) }}
                  </span>
                </div>
              @endif
            </div>
            <h5 class="mt-3 mb-1">{{ auth()->user()->prenom ?? '' }} {{ auth()->user()->nom ?? '' }}</h5>
            <p class="text-sm text-secondary mb-0">{{ auth()->user()->email ?? '' }}</p>
            <span class="badge badge-sm bg-gradient-{{ auth()->user()->role === 'admin' ? 'danger' : (auth()->user()->role === 'teacher' ? 'info' : 'success') }} mt-2">
              {{ auth()->user()->role === 'admin' ? 'Administrateur' : (auth()->user()->role === 'teacher' ? 'Formateur' : 'Apprenant') }}
            </span>
          </div>
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Prénom</label>
                <p class="text-sm">{{ auth()->user()->prenom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Nom</label>
                <p class="text-sm">{{ auth()->user()->nom ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Email</label>
                <p class="text-sm">{{ auth()->user()->email ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Téléphone</label>
                <p class="text-sm">{{ auth()->user()->phone ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Ville</label>
                <p class="text-sm">{{ auth()->user()->location ?? 'N/A' }}</p>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Nationalité</label>
                <p class="text-sm">{{ auth()->user()->nationalite ?? 'N/A' }}</p>
              </div>
              @if(auth()->user()->date_naissance)
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Date de naissance</label>
                <p class="text-sm">{{ \Carbon\Carbon::parse(auth()->user()->date_naissance)->format('d/m/Y') }}</p>
              </div>
              @endif
              <div class="col-md-6 mb-3">
                <label class="form-label text-sm font-weight-bold">Membre depuis</label>
                <p class="text-sm">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
              </div>
            </div>
            <div class="mt-4">
              <a href="{{ auth()->user()->role === 'admin' ? route('admin.settings') : route('account.settings') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-edit me-2"></i>Modifier le profil
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection






