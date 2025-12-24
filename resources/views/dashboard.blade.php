@extends('layouts.admin')

@section('title', 'Tableau de Bord')
@section('breadcrumb', 'Default')
@section('page-title', 'Tableau de Bord')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card mb-4">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Apprenants</p>
                  <h5 class="font-weight-bolder">
                    {{ number_format($totalApprenants ?? 0) }}
                  </h5>
                  <p class="mb-0">
                    <span class="text-success text-sm font-weight-bolder">
                      @if(isset($utilisateursEnLigne) && $utilisateursEnLigne > 0)
                        {{ $utilisateursEnLigne }} en ligne
                      @else
                        -
                      @endif
                    </span>
                  </p>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                  <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card mb-4">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Formateurs</p>
                  <h5 class="font-weight-bolder">
                    {{ number_format($totalFormateurs ?? 0) }}
                  </h5>
                  <p class="mb-0">
                    <span class="text-info text-sm font-weight-bolder">
                      Actifs
                    </span>
                  </p>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                  <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card mb-4">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Cours Disponibles</p>
                  <h5 class="font-weight-bolder">
                    {{ number_format($coursDisponibles ?? 0) }}
                  </h5>
                  <p class="mb-0">
                    <span class="text-success text-sm font-weight-bolder">
                      {{ $coursEnCours ?? 0 }} en cours
                    </span>
                  </p>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                  <i class="ni ni-book-bookmark text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card mb-4">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-uppercase font-weight-bold">Événements à venir</p>
                  <h5 class="font-weight-bolder">
                    {{ $evenementsAvenir->count() ?? 0 }}
                  </h5>
                  <p class="mb-0">
                    <span class="text-warning text-sm font-weight-bolder">
                      Prochain événement
                    </span>
                  </p>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                  <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Raccourcis rapides -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Raccourcis rapides</h6>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.apprenants.index') }}" class="btn btn-outline-primary btn-lg w-100">
              <i class="ni ni-single-02"></i><br>
              Liste des<br>Apprenants
            </a>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.formateurs.index') }}" class="btn btn-outline-info btn-lg w-100">
              <i class="ni ni-badge"></i><br>
              Liste des<br>Formateurs
            </a>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-success btn-lg w-100">
              <i class="ni ni-building"></i><br>
              Liste des<br>Niveaux d'étude
            </a>
          </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <a href="{{ route('admin.cours.index') }}" class="btn btn-outline-warning btn-lg w-100">
              <i class="ni ni-book-bookmark"></i><br>
              Liste des<br>Cours
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Événements à venir -->
<div class="row mt-4">
  <div class="col-12">
    <div class="chart-card">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="text-xl font-weight-bold text-gray-900 mb-1" style="font-size: 1.5rem; font-weight: 700; color: #1a202c; margin-bottom: 0.25rem;">Événements à venir</h2>
          <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #6b7280;">{{ $evenementsAvenir->count() ?? 0 }} événements</p>
        </div>
      </div>
      <div class="space-y-3" style="max-height: 400px; overflow-y: auto; display: flex; flex-direction: column; gap: 0.75rem;">
        @php
          $evenementsAvenirList = $evenementsAvenir ?? collect([]);
        @endphp
        @forelse($evenementsAvenirList as $evenement)
        <div class="event-card">
          <div class="d-flex align-items-start" style="gap: 1rem;">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br flex flex-column align-items-center justify-content-center text-white flex-shrink-0" style="width: 3.5rem; height: 3.5rem; border-radius: 0.75rem; background: linear-gradient(to bottom right, #065b32, #087a45); display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
              <span class="text-lg font-weight-bold" style="font-size: 1.125rem; font-weight: 700;">{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->format('d') }}</span>
              <span class="text-xs font-semibold" style="font-size: 0.75rem; font-weight: 600;">{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->locale('fr')->isoFormat('MMM') }}</span>
            </div>
            <div class="flex-1 min-w-0" style="flex: 1; min-width: 0;">
              <h3 class="font-semibold text-gray-900 mb-1 text-sm" style="font-weight: 600; color: #1a202c; margin-bottom: 0.25rem; font-size: 0.875rem;">{{ $evenement->titre ?? 'Événement' }}</h3>
              <p class="text-xs text-gray-500 mb-2" style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.5rem;">
                {{ $evenement->type ?? 'Général' }}
                @if($evenement->matiere)
                  - {{ $evenement->matiere->nom_matiere ?? '' }}
                @endif
              </p>
              <div class="d-flex align-items-center" style="gap: 0.5rem; font-size: 0.75rem; color: #6b7280;">
                <svg class="w-3 h-3" style="width: 0.75rem; height: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->locale('fr')->isoFormat('dddd HH:mm') }}</span>
              </div>
            </div>
            <div class="ml-auto">
              <a href="{{ route('admin.calendrier.index') }}" class="btn btn-sm btn-outline-primary">Voir</a>
            </div>
          </div>
        </div>
        @empty
        <div class="text-center py-5">
          <svg class="mx-auto mb-3" style="width: 3rem; height: 3rem; color: #d1d5db; margin: 0 auto 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #6b7280;">Aucun événement à venir</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-7 mb-4 mb-lg-0">
    <div class="card z-index-2 h-100">
      <div class="card-header pb-0 pt-3 bg-transparent">
        <h6 class="text-capitalize">Taux de réussite</h6>
        <p class="text-sm mb-0">
          <i class="fa fa-arrow-up text-success"></i>
          <span class="font-weight-bold">90%</span> en 2025
        </p>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card card-carousel overflow-hidden h-100 p-0">
      <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
        <div class="carousel-inner border-radius-lg h-100">
          <div class="carousel-item h-100 active" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('{{ asset('assets/images/groupe1.jpg') }}'); background-size: cover;">
            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
              <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                <i class="ni ni-camera-compact text-dark opacity-10"></i>
              </div>
              <h5 class="text-white mb-1">Bienvenue sur BJ Academie</h5>
              <p>Gérez efficacement vos formations et apprenants.</p>
            </div>
          </div>
          <div class="carousel-item h-100" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('{{ asset('assets/images/groupe2.jpeg') }}'); background-size: cover;">
            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
              <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                <i class="ni ni-bulb-61 text-dark opacity-10"></i>
              </div>
              <h5 class="text-white mb-1">Plateforme d'apprentissage</h5>
              <p>Un système complet pour gérer vos cours et formations.</p>
            </div>
          </div>
          <div class="carousel-item h-100" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('{{ asset('assets/images/groupe3.jpeg') }}'); background-size: cover;">
            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
              <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                <i class="ni ni-trophy text-dark opacity-10"></i>
              </div>
              <h5 class="text-white mb-1">Suivez vos progrès</h5>
              <p>Visualisez les statistiques et les performances en temps réel.</p>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Suivant</span>
        </button>
      </div>
    </div>
  </div>
</div>
<div class="row mt-4">
  <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
    <div class="card h-100">
      <div class="card-header">
        <h5 class="mb-0 text-capitalize">Liste des apprenants</h5>
      </div>
      <div class="card-body pt-0">
        <ul class="list-group list-group-flush">
          @php
            $apprenantsRecentsList = $apprenantsRecents ?? collect([]);
          @endphp
          @forelse($apprenantsRecentsList as $apprenant)
          <li class="list-group-item px-0">
            <div class="row align-items-center">
              <div class="col-auto d-flex align-items-center">
                <a href="javascript:;" class="avatar">
                  @if(!empty($apprenant['photo']))
                    <img src="{{ asset('storage/' . $apprenant['photo']) }}" class="avatar rounded-circle" alt="user image" style="width: 40px; height: 40px; object-fit: cover;">
                  @else
                    <div class="avatar {{ $apprenant['avatar_color'] }} rounded-circle">
                      <span class="text-white text-xs font-weight-bold">{{ $apprenant['initials'] }}</span>
                  </div>
                  @endif
                </a>
              </div>
              <div class="col ml-2">
                <h6 class="mb-0">
                  <a href="javascript:;">{{ $apprenant['name'] }}</a>
                </h6>
                @php
                  $lastActivity = $apprenant['last_activity'] ?? null;
                  if (!$lastActivity) {
                    $status = 'Jamais connecté';
                    $badgeClass = 'badge-secondary';
                  } else {
                    $lastSeen = \Carbon\Carbon::parse($lastActivity);
                    $now = \Carbon\Carbon::now();
                    $diffInMinutes = intval($lastSeen->diffInMinutes($now));
                    $diffInHours = intval($lastSeen->diffInHours($now));
                    $diffInDays = intval($lastSeen->diffInDays($now));
                    
                    if ($diffInMinutes < 1) {
                      $status = 'À l\'instant';
                      $badgeClass = 'badge-success';
                    } elseif ($diffInMinutes < 60) {
                      $status = 'Il y a ' . $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '');
                      $badgeClass = 'badge-success';
                    } elseif ($diffInHours < 24) {
                      $status = 'Il y a ' . $diffInHours . ' heure' . ($diffInHours > 1 ? 's' : '');
                      $badgeClass = 'badge-success';
                    } elseif ($diffInDays === 1) {
                      $status = 'Il y a 1 jour';
                      $badgeClass = 'badge-success';
                    } else {
                      $status = 'Il y a ' . $diffInDays . ' jours';
                      $badgeClass = $diffInDays <= 7 ? 'badge-info' : 'badge-warning';
                    }
                  }
                @endphp
                <span class="badge {{ $badgeClass }} badge-sm">{{ $status }}</span>
              </div>
              <div class="col-auto">
                <a href="{{ route('admin.apprenants.show', $apprenant['id']) }}" class="btn btn-outline-primary btn-xs mb-0">Voir</a>
              </div>
            </div>
          </li>
          @empty
          <li class="list-group-item px-0">
            <p class="text-muted text-center py-3">Aucun apprenant récent</p>
          </li>
          @endforelse
        </ul>
        @if(isset($apprenantsRecents) && $apprenantsRecents->count() > 0)
        <div class="card-footer text-center pt-3">
          <a href="{{ route('admin.apprenants.index') }}" class="btn btn-sm btn-outline-primary">Voir plus</a>
        </div>
        @endif
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
    <div class="card h-100">
      <div class="card-header">
        <h5 class="mb-0 text-capitalize">Liste des Professeurs</h5>
      </div>
      <div class="card-body pt-0">
        <ul class="list-group list-group-flush">
          @php
            $formateursRecentsList = $formateursRecents ?? collect([]);
          @endphp
          @forelse($formateursRecentsList as $formateur)
          <li class="list-group-item px-0">
            <div class="row align-items-center">
              <div class="col-auto d-flex align-items-center">
                <a href="javascript:;" class="avatar">
                  @if(!empty($formateur['photo']))
                    <img src="{{ asset('storage/' . $formateur['photo']) }}" class="avatar rounded-circle" alt="user image" style="width: 40px; height: 40px; object-fit: cover;">
                  @else
                    <div class="avatar {{ $formateur['avatar_color'] }} rounded-circle">
                      <span class="text-white text-xs font-weight-bold">{{ $formateur['initials'] }}</span>
                  </div>
                  @endif
                </a>
              </div>
              <div class="col ml-2">
                <h6 class="mb-0">
                  <a href="javascript:;">{{ $formateur['name'] }}</a>
                </h6>
                @php
                  $lastActivity = $formateur['last_activity'] ?? null;
                  if (!$lastActivity) {
                    $status = 'Jamais connecté';
                    $badgeClass = 'badge-secondary';
                  } else {
                    $lastSeen = \Carbon\Carbon::parse($lastActivity);
                    $now = \Carbon\Carbon::now();
                    $diffInMinutes = intval($lastSeen->diffInMinutes($now));
                    $diffInHours = intval($lastSeen->diffInHours($now));
                    $diffInDays = intval($lastSeen->diffInDays($now));
                    
                    if ($diffInMinutes < 1) {
                      $status = 'À l\'instant';
                      $badgeClass = 'badge-success';
                    } elseif ($diffInMinutes < 60) {
                      $status = 'Il y a ' . $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '');
                      $badgeClass = 'badge-success';
                    } elseif ($diffInHours < 24) {
                      $status = 'Il y a ' . $diffInHours . ' heure' . ($diffInHours > 1 ? 's' : '');
                      $badgeClass = 'badge-success';
                    } elseif ($diffInDays === 1) {
                      $status = 'Il y a 1 jour';
                      $badgeClass = 'badge-success';
                    } else {
                      $status = 'Il y a ' . $diffInDays . ' jours';
                      $badgeClass = $diffInDays <= 7 ? 'badge-info' : 'badge-warning';
                    }
                  }
                @endphp
                <span class="badge {{ $badgeClass }} badge-sm">{{ $status }}</span>
              </div>
              <div class="col-auto">
                <a href="{{ route('admin.formateurs.show', $formateur['id']) }}" class="btn btn-outline-primary btn-xs mb-0">Voir</a>
              </div>
            </div>
          </li>
          @empty
          <li class="list-group-item px-0">
            <p class="text-muted text-center py-3">Aucun professeur récent</p>
          </li>
          @endforelse
        </ul>
        @if(isset($formateursRecents) && $formateursRecents->count() > 0)
        <div class="card-footer text-center pt-3">
          <a href="{{ route('admin.formateurs.index') }}" class="btn btn-sm btn-outline-primary">Voir plus</a>
        </div>
        @endif
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-header">
        <h5 class="mb-0 text-capitalize">Événements à venir</h5>
      </div>
      <div class="card-body pt-0">
        @php
          $evenementsAffiches = isset($evenementsAvenir) ? $evenementsAvenir->take(4) : collect([]);
        @endphp
        @forelse($evenementsAffiches as $evenement)
        <div class="event-card-small mb-3">
          <div class="d-flex align-items-start" style="gap: 0.75rem;">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br flex flex-column align-items-center justify-content-center text-white flex-shrink-0" style="width: 3rem; height: 3rem; border-radius: 0.75rem; background: linear-gradient(to bottom right, #065b32, #087a45); display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
              <span class="text-sm font-weight-bold" style="font-size: 0.875rem; font-weight: 700;">{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->format('d') }}</span>
              <span class="text-xs" style="font-size: 0.625rem;">{{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->locale('fr')->isoFormat('MMM') }}</span>
            </div>
            <div class="flex-1 min-w-0" style="flex: 1; min-width: 0;">
              <h6 class="mb-1 text-sm font-weight-semibold" style="font-size: 0.875rem; font-weight: 600; color: #1a202c; margin-bottom: 0.25rem;">{{ $evenement->titre ?? 'Événement' }}</h6>
              <p class="text-xs text-gray-500 mb-1" style="font-size: 0.75rem; color: #6b7280; margin-bottom: 0.25rem;">
                {{ $evenement->type ?? 'Général' }}
                @if($evenement->matiere)
                  - {{ $evenement->matiere->nom_matiere ?? '' }}
                @endif
              </p>
              <p class="text-xs text-gray-400 mb-0" style="font-size: 0.75rem; color: #9ca3af; margin-bottom: 0;">
                {{ \Carbon\Carbon::parse($evenement->scheduled_at ?? now())->locale('fr')->isoFormat('dddd HH:mm') }}
              </p>
            </div>
          </div>
        </div>
        @empty
        <div class="text-center py-4">
          <p class="text-muted mb-0" style="color: #6b7280;">Aucun événement à venir</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  var ctx1 = document.getElementById("chart-line").getContext("2d");

  var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

  gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
  gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
  gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
  new Chart(ctx1, {
    type: "line",
    data: {
      labels: ["Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
      datasets: [{
        label: "Applications mobiles",
        tension: 0.4,
        borderWidth: 0,
        pointRadius: 0,
        borderColor: "#5e72e4",
        backgroundColor: gradientStroke1,
        borderWidth: 3,
        fill: true,
        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
        maxBarThickness: 6

      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            padding: 10,
            color: '#fbfbfb',
            font: {
              size: 11,
              family: "Open Sans",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            color: '#ccc',
            padding: 20,
            font: {
              size: 11,
              family: "Open Sans",
              style: 'normal',
              lineHeight: 2
            },
          }
        },
      },
    },
  });
</script>
@endpush

@push('styles')
<style>
  .chart-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 32px;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }
  .chart-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }
  .event-card {
    padding: 20px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    background: #ffffff;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .event-card:hover {
    border-color: #065b32;
    background: #f0fdf4;
    transform: translateX(4px);
  }
  .event-card-small {
    padding: 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: #ffffff;
    transition: all 0.2s ease;
  }
  .event-card-small:hover {
    border-color: #065b32;
    background: #f0fdf4;
  }
</style>
@endpush
