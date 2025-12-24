<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>
    @yield('title', 'Tableau de Bord') - {{ config('app.name', 'BJ Academie') }}
  </title>
  <!--     Fonts and icons     -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.min.css') }}?v=2.0.4" rel="stylesheet" />
  @stack('styles')
  <style>
    /* Styles pour les badges uniformes */
    .badge-md {
      font-size: 0.75rem;
      padding: 0.35rem 0.65rem;
      min-width: 1.5rem;
      height: 1.5rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      line-height: 1;
    }
    .badge-circle {
      border-radius: 50%;
      width: 1.5rem;
      height: 1.5rem;
      padding: 0;
      min-width: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .badge-circle span,
    .badge-circle {
      line-height: 1.5rem;
      vertical-align: middle;
    }
    .badge-floating {
      position: absolute;
      top: -6px;
      right: -6px;
      z-index: 10;
    }
    button.relative, a.relative, .position-relative {
      position: relative;
    }
    .badge-danger {
      background-color: #ea4335;
      color: white;
    }
    .badge.border-white {
      border: 2px solid white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    /* Styles fixes pour la barre de recherche - identique à Mes Notes */
    .input-group[style*="min-width: 300px"] {
      min-width: 300px !important;
      width: 300px !important;
      max-width: 300px !important;
      position: relative !important;
      z-index: 1 !important;
      isolation: isolate !important;
      display: flex !important;
      flex-wrap: nowrap !important;
      box-sizing: border-box !important;
      overflow: visible !important;
    }
    
    .input-group[style*="min-width: 300px"] .input-group-text {
      flex-shrink: 0 !important;
    }
    
    .input-group[style*="min-width: 300px"] .form-control {
      flex: 1 1 auto !important;
      min-width: 0 !important;
      box-sizing: border-box !important;
      border-top-right-radius: 0.375rem !important;
      border-bottom-right-radius: 0.375rem !important;
      padding-right: 40px !important;
    }
    
    .input-group[style*="min-width: 300px"] .btn {
      position: absolute !important;
      right: 0 !important;
      top: 0 !important;
      bottom: 0 !important;
      z-index: 2 !important;
      margin: 0 !important;
    }
    
    .input-group[style*="min-width: 300px"] .btn[style*="display: none"] {
      display: none !important;
    }
    
    /* Styles pour l'icône de profil identique à l'interface des apprenants */
    .profile-icon-btn {
      width: 40px;
      height: 40px;
      border-radius: 9999px;
      background: linear-gradient(to bottom right, #a78bfa, #9333ea);
      overflow: hidden;
      border: 2px solid #c084fc;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      cursor: pointer;
      transition: all 0.3s;
      padding: 0;
      margin: 0;
    }
    .profile-icon-btn:hover {
      box-shadow: 0 0 0 2px rgba(196, 181, 253, 0.5);
    }
    .profile-icon-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .profile-icon-initials {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 0.875rem;
    }
    .profile-dropdown {
      position: absolute !important;
      right: 0 !important;
      margin-top: 0.5rem !important;
      width: 18rem !important;
      background: white !important;
      border-radius: 0.5rem !important;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
      border: 1px solid #e5e7eb !important;
      padding: 0.5rem 0 !important;
      z-index: 9999 !important;
    }
    .profile-dropdown.hidden {
      display: none !important;
    }
    .profile-dropdown:not(.hidden) {
      display: block !important;
    }
    .profile-dropdown-header {
      padding: 1rem;
      border-bottom: 1px solid #e5e7eb;
    }
    .profile-dropdown-user {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    .profile-dropdown-avatar {
      width: 40px;
      height: 40px;
      border-radius: 9999px;
      background: linear-gradient(to bottom right, #a78bfa, #9333ea);
      overflow: hidden;
      border: 2px solid #c084fc;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      flex-shrink: 0;
      padding: 0;
      margin: 0;
    }
    .profile-dropdown-info {
      flex: 1;
      min-width: 0;
    }
    .profile-dropdown-name {
      font-size: 0.875rem;
      font-weight: 600;
      color: #111827;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      margin: 0;
      padding: 0;
      line-height: 1.25rem;
    }
    .profile-dropdown-email {
      font-size: 0.75rem;
      color: #6b7280;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      margin: 0;
      padding: 0;
      line-height: 1rem;
    }
    .profile-dropdown-info {
      flex: 1;
      min-width: 0;
      display: flex;
      flex-direction: column;
      gap: 0;
    }
    .profile-dropdown-item {
      display: flex;
      align-items: center;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      color: #374151;
      transition: background-color 0.2s;
      text-decoration: none;
    }
    .profile-dropdown-item:hover {
      background-color: #f9fafb;
    }
    .profile-dropdown-item svg {
      width: 1.25rem;
      height: 1.25rem;
      margin-right: 0.75rem;
      color: #9ca3af;
    }
    .profile-dropdown-logout {
      width: 100%;
      display: flex;
      align-items: center;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      color: #dc2626;
      transition: background-color 0.2s;
      border: none;
      background: none;
      cursor: pointer;
    }
    .profile-dropdown-logout:hover {
      background-color: #fef2f2;
    }
    .profile-dropdown-logout svg {
      width: 1.25rem;
      height: 1.25rem;
      margin-right: 0.75rem;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="{{ route('dashboard') }}">
        <span class="ms-1 font-weight-bold">BJ Academie</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <i class="ni ni-shop text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Tableau de Bord</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">PAGES</h6>
        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#accountExamples" class="nav-link {{ request()->routeIs('account.*') || request()->routeIs('admin.profile') || request()->routeIs('admin.settings') || request()->routeIs('admin.security') ? 'active' : '' }}" aria-controls="accountExamples" role="button" aria-expanded="{{ request()->routeIs('admin.profile') || request()->routeIs('admin.settings') || request()->routeIs('admin.security') || request()->routeIs('account.notes') ? 'true' : 'false' }}">
            <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
              <i class="ni ni-settings-gear-65 text-dark text-sm opacity-10"></i>
            </div>
              <span class="nav-link-text ms-1">Comptes</span>
            <i class="ni ni-bold-down ms-auto text-xs opacity-6 collapse-arrow"></i>
          </a>
          <div class="collapse {{ request()->routeIs('admin.profile') || request()->routeIs('admin.settings') || request()->routeIs('admin.security') || request()->routeIs('account.notes') ? 'show' : '' }}" id="accountExamples">
            <ul class="nav ms-4">
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}">
                  <span class="sidenav-mini-icon">P</span>
                  <span class="sidenav-normal">Profil</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                  <span class="sidenav-mini-icon">P</span>
                  <span class="sidenav-normal">Paramètres</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.security') ? 'active' : '' }}" href="{{ route('admin.security') }}">
                  <span class="sidenav-mini-icon">S</span>
                  <span class="sidenav-normal">Sécurité</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        @if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->is_admin))
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">GESTION</h6>
          </li>
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#gestionExamples" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" aria-controls="gestionExamples" role="button" aria-expanded="{{ request()->routeIs('admin.*') ? 'true' : 'false' }}">
              <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                <i class="ni ni-settings-gear-65 text-dark text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Administration</span>
              <i class="ni ni-bold-down ms-auto text-xs opacity-6 collapse-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.*') ? 'show' : '' }}" id="gestionExamples">
              <ul class="nav ms-4">
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.apprenants.*') ? 'active' : '' }}" href="{{ route('admin.apprenants.index') }}">
                    <span class="sidenav-mini-icon">A</span>
                    <span class="sidenav-normal">Apprenants</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.formateurs.*') ? 'active' : '' }}" href="{{ route('admin.formateurs.index') }}">
                    <span class="sidenav-mini-icon">F</span>
                    <span class="sidenav-normal">Formateurs</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}" href="{{ route('admin.classes.index') }}">
                    <span class="sidenav-mini-icon">C</span>
                    <span class="sidenav-normal">Classes</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.matieres.*') ? 'active' : '' }}" href="{{ route('admin.matieres.index') }}">
                    <span class="sidenav-mini-icon">M</span>
                    <span class="sidenav-normal">Matières</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.notes') || request()->routeIs('account.notes') ? 'active' : '' }}" href="{{ auth()->user()->role === 'admin' || auth()->user()->is_admin ? route('admin.notes') : route('account.notes') }}" id="notesLinkSidebar" onclick="window.location.href='{{ auth()->user()->role === 'admin' || auth()->user()->is_admin ? route('admin.notes') : route('account.notes') }}'; return false;">
                    <span class="sidenav-mini-icon">N</span>
                    <span class="sidenav-normal" style="pointer-events: none;">Notes</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.calendrier.*') ? 'active' : '' }}" href="{{ route('admin.calendrier.index') }}">
                    <span class="sidenav-mini-icon">C</span>
                    <span class="sidenav-normal">Calendrier</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.emploi-du-temps.*') ? 'active' : '' }}" href="{{ route('admin.emploi-du-temps.index') }}">
                    <span class="sidenav-mini-icon">E</span>
                    <span class="sidenav-normal">Emploi du temps</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.paiements.*') ? 'active' : '' }}" href="{{ route('admin.paiements.index') }}">
                    <span class="sidenav-mini-icon">P</span>
                    <span class="sidenav-normal">Paiements</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}">
                    <span class="sidenav-mini-icon">M</span>
                    <span class="sidenav-normal">Messages App / Form</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link position-relative {{ request()->routeIs('admin.mes-messages.*') ? 'active' : '' }}" href="{{ route('admin.mes-messages.index') }}">
                    <span class="sidenav-mini-icon">M</span>
                    <span class="sidenav-normal">Mes Messages</span>
                    @php
                        $unreadCount = 0;
                        if (Auth::check() && Auth::user()->role === 'admin') {
                            $unreadCount = \App\Models\Message::where('receiver_id', Auth::id())
                                ->whereNull('read_at')
                                ->count();
                        }
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge badge-md badge-circle badge-floating badge-danger border-white" id="sidebarUnreadBadge">{{ $unreadCount }}</span>
                    @endif
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }} position-relative" href="{{ route('admin.notifications.index') }}">
                    <span class="sidenav-mini-icon">N</span>
                    <span class="sidenav-normal">Notifications</span>
                    <span id="sidebarNotificationBadge" class="badge badge-md badge-circle badge-floating badge-danger border-white" style="display: none !important;"></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ request()->routeIs('admin.apprenants-admin-redoublants.*') ? 'active' : '' }}" href="{{ route('admin.apprenants-admin-redoublants.index') }}">
                    <span class="sidenav-mini-icon">R</span>
                    <span class="sidenav-normal">Apprenants Admin & Redoublants</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif
      </ul>
    </div>
    <div class="sidenav-footer mx-3 my-3">
      <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-60 mx-auto" src="{{ asset('assets/img/illustrations/icon-documentation.svg') }}" alt="sidebar_illustration" onerror="this.style.display='none'">
        <div class="card-body text-center p-3 w-100 pt-0">
          <div class="docs-info">
            <h6 class="mb-0">Bj Academie</h6>
            <p class="text-xs font-weight-bold mb-0">1ère école informatique de formation à distance</p>
          </div>
        </div>
      </div>
      <span class="btn btn-dark btn-sm w-100 mb-3" style="cursor: default; pointer-events: none; opacity: 0.6;">Administrateur</span>
    </div>
  </aside>
  <main class="main-content position-relative border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl z-index-sticky" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm">
              <a class="text-white" href="{{ route('dashboard') }}">
                <i class="ni ni-box-2"></i>
              </a>
            </li>
            <li class="breadcrumb-item text-sm text-white"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">@yield('breadcrumb', 'Dashboard')</li>
          </ol>
          <h6 class="font-weight-bolder mb-0 text-white">@yield('page-title', 'Tableau de Bord')</h6>
        </nav>
        <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none">
          <a href="javascript:;" class="nav-link p-0">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </div>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center gap-3">
            @if(request()->routeIs('admin.notes') || request()->routeIs('account.notes'))
            <div class="input-group" style="min-width: 300px;">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" 
                     id="notesSearchInput"
                     class="form-control" 
                     placeholder="Rechercher par matricule, nom, prénom, cours, classe, semestre..." 
                     value="{{ request()->get('search', '') }}"
                     autocomplete="off">
              @if(request()->has('search') && request()->search)
              <button type="button" id="clearSearchBtn" class="btn btn-outline-secondary" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem;">
                <i class="fas fa-times"></i>
              </button>
              @endif
            </div>
            @elseif(request()->routeIs('admin.apprenants.*') || request()->routeIs('admin.formateurs.*') || request()->routeIs('admin.classes.*') || request()->routeIs('admin.matieres.*') || request()->routeIs('admin.calendrier.*') || request()->routeIs('admin.emploi-du-temps.*') || request()->routeIs('admin.paiements.*') || request()->routeIs('admin.messages.*'))
            <div class="input-group" style="min-width: 300px;">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" 
                     id="tableSearchInput"
                     class="form-control" 
                     placeholder="Rechercher..." 
                     autocomplete="off">
              <button type="button" id="clearTableSearchBtn" class="btn btn-outline-secondary" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem; display: none;">
                <i class="fas fa-times"></i>
              </button>
            </div>
            @else
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Rechercher...">
            </div>
            @endif
            @if(auth()->check())
            <!-- Icône de notification avec badge - identique à l'interface Messages -->
            @include('components.notification-icon-admin')
            @endif
          </div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">{{ auth()->user()->name ?? 'Utilisateur' }}</span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item pe-2 d-flex align-items-center">
              <div class="position-relative" style="z-index: 1000;">
                @php $user = auth()->user(); @endphp
                <button id="profileDropdownBtn" class="profile-icon-btn" type="button" style="position: relative; z-index: 1000; pointer-events: auto;">
                  @if($user->photo ?? null)
                    <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="profile-icon-img">
                  @else
                    <div class="profile-icon-initials">
                      {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                    </div>
                  @endif
                </button>
                
                <!-- Dropdown Menu -->
                <div id="profileDropdownMenu" class="profile-dropdown hidden" style="z-index: 9999 !important; position: absolute !important; right: 0 !important; margin-top: 0.5rem !important;">
                  <div class="profile-dropdown-header">
                    <div class="profile-dropdown-user">
                      <div class="profile-dropdown-avatar">
                        @if($user->photo ?? null)
                          <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="profile-icon-img">
                        @else
                          <div class="profile-icon-initials">
                            {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                          </div>
                        @endif
                      </div>
                      <div class="profile-dropdown-info">
                        <p class="profile-dropdown-name">
                          {{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}
                        </p>
                        <p class="profile-dropdown-email">{{ $user->email ?? '' }}</p>
                      </div>
                    </div>
                  </div>
                  <div style="padding: 0.25rem 0;">
                    <a href="{{ route('dashboard') }}" class="profile-dropdown-item">
                      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                      </svg>
                      <span>Tableau de bord</span>
                    </a>
                    @if(auth()->user()->role === 'admin')
                      <a href="{{ route('admin.profile') }}" class="profile-dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil</span>
                      </a>
                      <a href="{{ route('admin.settings') }}" class="profile-dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Paramètres</span>
                      </a>
                    @else
                      <a href="{{ route('account.profile') }}" class="profile-dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profil</span>
                      </a>
                      <a href="{{ route('account.settings') }}" class="profile-dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Paramètres</span>
                      </a>
                    @endif
                    <hr style="margin: 0.25rem 0; border-color: #e5e7eb;">
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="profile-dropdown-logout">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Déconnexion</span>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      @yield('content')
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="fa fa-cog py-2"> </i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3 bg-transparent ">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Configuration</h5>
          <p>Voir nos options de tableau de bord.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="fa fa-close"></i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0 overflow-auto">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Couleurs de la barre latérale</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Type de navigation latérale</h6>
          <p class="text-sm">Choisissez entre 2 types différents de navigation latérale.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-primary w-100 px-3 mb-2 active me-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
          <button class="btn bg-gradient-primary w-100 px-3 mb-2" data-class="bg-default" onclick="sidebarType(this)">Dark</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">Vous pouvez changer le type de navigation latérale uniquement en vue bureau.</p>
        <!-- Navbar Fixed -->
        <div class="d-flex my-3">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark mb-1">
        <div class="d-flex my-4">
          <h6 class="mb-0">Sidenav Mini</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarMinimize" onclick="navbarMinimize(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <div class="mt-2 mb-5 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/dragula/dragula.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/jkanban/jkanban.js') }}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/argon-dashboard.min.js') }}?v=2.0.4"></script>
  <script>
    // Gérer la rotation des flèches des menus déroulants
    document.addEventListener('DOMContentLoaded', function() {
      const collapseTriggers = document.querySelectorAll('[data-bs-toggle="collapse"]');
      collapseTriggers.forEach(function(trigger) {
        const targetId = trigger.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        const arrow = trigger.querySelector('.collapse-arrow');
        
        if (targetElement && arrow) {
          // Fonction pour mettre à jour l'icône
          function updateArrow(isOpen) {
            if (isOpen) {
              arrow.classList.remove('ni-bold-down');
              arrow.classList.add('ni-bold-up');
            } else {
              arrow.classList.remove('ni-bold-up');
              arrow.classList.add('ni-bold-down');
            }
          }
          
          // État initial
          if (targetElement.classList.contains('show')) {
            updateArrow(true);
          }
          
          // Écouter les événements sur l'élément cible
          targetElement.addEventListener('shown.bs.collapse', function() {
            updateArrow(true);
          });
          
          targetElement.addEventListener('hidden.bs.collapse', function() {
            updateArrow(false);
          });
        }
      });
    });

    // Profile dropdown menu - identique à l'interface Messages de l'admin
    document.addEventListener('DOMContentLoaded', function() {
      var profileDropdownBtn = document.getElementById('profileDropdownBtn');
      var profileDropdownMenu = document.getElementById('profileDropdownMenu');

      if (profileDropdownBtn && profileDropdownMenu) {
        profileDropdownBtn.addEventListener('mousedown', function(e) {
          e.preventDefault();
          e.stopPropagation();
        });
        
        profileDropdownBtn.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          profileDropdownMenu.classList.toggle('hidden');
        });

        setTimeout(function() {
          document.addEventListener('click', function(e) {
            if (profileDropdownBtn && profileDropdownMenu) {
              if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                profileDropdownMenu.classList.add('hidden');
              }
            }
          });
        }, 100);

        profileDropdownMenu.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
    });

    // Système de notifications - Le composant notification-icon-admin gère déjà tout
    // On garde juste la synchronisation du badge de la sidebar
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarNotificationBadge = document.getElementById('sidebarNotificationBadge');
      
      // Synchroniser le badge de la sidebar avec celui du composant
      function syncSidebarBadge() {
        const notificationBadge = document.getElementById('notificationBadge');
        if (notificationBadge && sidebarNotificationBadge) {
          const count = notificationBadge.textContent;
          if (count && count !== '') {
            sidebarNotificationBadge.textContent = count;
            sidebarNotificationBadge.style.display = 'block';
          } else {
            sidebarNotificationBadge.textContent = '';
            sidebarNotificationBadge.style.display = 'none';
          }
        }
      }
      
      // Observer les changements du badge de notification
      const notificationBadge = document.getElementById('notificationBadge');
      if (notificationBadge) {
        const observer = new MutationObserver(function(mutations) {
          mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' || mutation.type === 'characterData') {
              syncSidebarBadge();
            }
          });
        });
        
        observer.observe(notificationBadge, {
          childList: true,
          characterData: true,
          subtree: true
        });
        
        // Synchroniser immédiatement
        syncSidebarBadge();
      }
      
      // Synchroniser périodiquement aussi
      setInterval(syncSidebarBadge, 1000);
    });

    // Solution pour le lien Notes - forcer la navigation
    document.addEventListener('DOMContentLoaded', function() {
      const notesLink = document.getElementById('notesLinkSidebar');
      if (notesLink) {
        // Désactiver pointer-events sur tous les spans enfants
        const spans = notesLink.querySelectorAll('span');
        spans.forEach(function(span) {
          span.style.pointerEvents = 'none';
        });
        
        // Forcer la navigation au clic sur le lien
        notesLink.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          const href = this.getAttribute('href');
          if (href) {
            window.location.href = href;
          }
          return false;
        }, true);
        
        notesLink.onclick = function(e) {
          e.preventDefault();
          e.stopPropagation();
          const href = this.getAttribute('href');
          if (href) {
            window.location.href = href;
          }
          return false;
        };
      }
    });
  </script>
  @stack('scripts')
</body>

</html>
