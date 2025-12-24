@extends('layouts.admin')

@php
$errors = $errors ?? collect([]);
@endphp

@section('title', 'Settings')
@section('breadcrumb', 'Paramètres')
@section('page-title', 'Paramètres du Compte')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

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
            <a class="nav-link text-body d-flex align-items-center" data-scroll href="#basic-info">
              <i class="ni ni-books me-2 text-dark opacity-6"></i>
              <span class="text-sm">Information</span>
            </a>
          </li>
          <li class="nav-item pt-2">
            <a class="nav-link text-body d-flex align-items-center" data-scroll href="#password">
              <i class="ni ni-atom me-2 text-dark opacity-6"></i>
              <span class="text-sm">Changer le mot de passe</span>
            </a>
          </li>
          <li class="nav-item pt-2">
            <a class="nav-link text-body d-flex align-items-center" data-scroll href="#sessions">
              <i class="ni ni-watch-time me-2 text-dark opacity-6"></i>
              <span class="text-sm">Appareils connectés</span>
            </a>
          </li>
          <li class="nav-item pt-2">
            <a class="nav-link text-body d-flex align-items-center" data-scroll href="#delete">
              <i class="ni ni-settings-gear-65 me-2 text-dark opacity-6"></i>
              <span class="text-sm">Supprimer le compte</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="col-lg-9 mt-lg-0 mt-4">
      <div class="card mt-4" id="basic-info">
        <div class="card-header">
          <h5>Information</h5>
        </div>
        <div class="card-body pt-0">
          <form id="profileForm" action="{{ auth()->user()->role === 'admin' ? route('admin.settings.updateProfile') : route('account.settings.updateProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-6">
                <label class="form-label">Prénom</label>
                <div class="input-group">
                  <input id="firstName" name="prenom" class="form-control" type="text" placeholder="Prénom" value="{{ old('prenom', auth()->user()->prenom) }}">
                </div>
              </div>
              <div class="col-6">
                <label class="form-label">Nom</label>
                <div class="input-group">
                  <input id="lastName" name="nom" class="form-control" type="text" placeholder="Nom" value="{{ old('nom', auth()->user()->nom) }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label class="form-label mt-4">Email</label>
                <div class="input-group">
                  <input id="email" name="email" class="form-control" type="email" placeholder="example@email.com" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label class="form-label mt-4">Ville</label>
                <div class="input-group">
                  <input id="location" name="location" class="form-control" type="text" placeholder="Ex: Dakar" value="{{ old('location', auth()->user()->location) }}">
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label mt-4">Nationalité</label>
                <select name="nationalite" class="form-control @error('nationalite') is-invalid @enderror">
                  <option value="">-- Sélectionner une nationalité --</option>
                  <option value="AF" {{ old('nationalite', auth()->user()->nationalite) == 'AF' ? 'selected' : '' }}>🇦🇫 Afghanistan</option>
                  <option value="ZA" {{ old('nationalite', auth()->user()->nationalite) == 'ZA' ? 'selected' : '' }}>🇿🇦 Afrique du Sud</option>
                  <option value="AL" {{ old('nationalite', auth()->user()->nationalite) == 'AL' ? 'selected' : '' }}>🇦🇱 Albanie</option>
                  <option value="DZ" {{ old('nationalite', auth()->user()->nationalite) == 'DZ' ? 'selected' : '' }}>🇩🇿 Algérie</option>
                  <option value="DE" {{ old('nationalite', auth()->user()->nationalite) == 'DE' ? 'selected' : '' }}>🇩🇪 Allemagne</option>
                  <option value="AD" {{ old('nationalite', auth()->user()->nationalite) == 'AD' ? 'selected' : '' }}>🇦🇩 Andorre</option>
                  <option value="AO" {{ old('nationalite', auth()->user()->nationalite) == 'AO' ? 'selected' : '' }}>🇦🇴 Angola</option>
                  <option value="AG" {{ old('nationalite', auth()->user()->nationalite) == 'AG' ? 'selected' : '' }}>🇦🇬 Antigua-et-Barbuda</option>
                  <option value="SA" {{ old('nationalite', auth()->user()->nationalite) == 'SA' ? 'selected' : '' }}>🇸🇦 Arabie Saoudite</option>
                  <option value="AR" {{ old('nationalite', auth()->user()->nationalite) == 'AR' ? 'selected' : '' }}>🇦🇷 Argentine</option>
                  <option value="AM" {{ old('nationalite', auth()->user()->nationalite) == 'AM' ? 'selected' : '' }}>🇦🇲 Arménie</option>
                  <option value="AU" {{ old('nationalite', auth()->user()->nationalite) == 'AU' ? 'selected' : '' }}>🇦🇺 Australie</option>
                  <option value="AT" {{ old('nationalite', auth()->user()->nationalite) == 'AT' ? 'selected' : '' }}>🇦🇹 Autriche</option>
                  <option value="AZ" {{ old('nationalite', auth()->user()->nationalite) == 'AZ' ? 'selected' : '' }}>🇦🇿 Azerbaïdjan</option>
                  <option value="BS" {{ old('nationalite', auth()->user()->nationalite) == 'BS' ? 'selected' : '' }}>🇧🇸 Bahamas</option>
                  <option value="BH" {{ old('nationalite', auth()->user()->nationalite) == 'BH' ? 'selected' : '' }}>🇧🇭 Bahreïn</option>
                  <option value="BD" {{ old('nationalite', auth()->user()->nationalite) == 'BD' ? 'selected' : '' }}>🇧🇩 Bangladesh</option>
                  <option value="BB" {{ old('nationalite', auth()->user()->nationalite) == 'BB' ? 'selected' : '' }}>🇧🇧 Barbade</option>
                  <option value="BE" {{ old('nationalite', auth()->user()->nationalite) == 'BE' ? 'selected' : '' }}>🇧🇪 Belgique</option>
                  <option value="BZ" {{ old('nationalite', auth()->user()->nationalite) == 'BZ' ? 'selected' : '' }}>🇧🇿 Belize</option>
                  <option value="BJ" {{ old('nationalite', auth()->user()->nationalite) == 'BJ' ? 'selected' : '' }}>🇧🇯 Bénin</option>
                  <option value="BT" {{ old('nationalite', auth()->user()->nationalite) == 'BT' ? 'selected' : '' }}>🇧🇹 Bhoutan</option>
                  <option value="BY" {{ old('nationalite', auth()->user()->nationalite) == 'BY' ? 'selected' : '' }}>🇧🇾 Biélorussie</option>
                  <option value="MM" {{ old('nationalite', auth()->user()->nationalite) == 'MM' ? 'selected' : '' }}>🇲🇲 Birmanie</option>
                  <option value="BO" {{ old('nationalite', auth()->user()->nationalite) == 'BO' ? 'selected' : '' }}>🇧🇴 Bolivie</option>
                  <option value="BA" {{ old('nationalite', auth()->user()->nationalite) == 'BA' ? 'selected' : '' }}>🇧🇦 Bosnie-Herzégovine</option>
                  <option value="BW" {{ old('nationalite', auth()->user()->nationalite) == 'BW' ? 'selected' : '' }}>🇧🇼 Botswana</option>
                  <option value="BR" {{ old('nationalite', auth()->user()->nationalite) == 'BR' ? 'selected' : '' }}>🇧🇷 Brésil</option>
                  <option value="BN" {{ old('nationalite', auth()->user()->nationalite) == 'BN' ? 'selected' : '' }}>🇧🇳 Brunei</option>
                  <option value="BG" {{ old('nationalite', auth()->user()->nationalite) == 'BG' ? 'selected' : '' }}>🇧🇬 Bulgarie</option>
                  <option value="BF" {{ old('nationalite', auth()->user()->nationalite) == 'BF' ? 'selected' : '' }}>🇧🇫 Burkina Faso</option>
                  <option value="BI" {{ old('nationalite', auth()->user()->nationalite) == 'BI' ? 'selected' : '' }}>🇧🇮 Burundi</option>
                  <option value="KH" {{ old('nationalite', auth()->user()->nationalite) == 'KH' ? 'selected' : '' }}>🇰🇭 Cambodge</option>
                  <option value="CM" {{ old('nationalite', auth()->user()->nationalite) == 'CM' ? 'selected' : '' }}>🇨🇲 Cameroun</option>
                  <option value="CA" {{ old('nationalite', auth()->user()->nationalite) == 'CA' ? 'selected' : '' }}>🇨🇦 Canada</option>
                  <option value="CV" {{ old('nationalite', auth()->user()->nationalite) == 'CV' ? 'selected' : '' }}>🇨🇻 Cap-Vert</option>
                  <option value="CL" {{ old('nationalite', auth()->user()->nationalite) == 'CL' ? 'selected' : '' }}>🇨🇱 Chili</option>
                  <option value="CN" {{ old('nationalite', auth()->user()->nationalite) == 'CN' ? 'selected' : '' }}>🇨🇳 Chine</option>
                  <option value="CY" {{ old('nationalite', auth()->user()->nationalite) == 'CY' ? 'selected' : '' }}>🇨🇾 Chypre</option>
                  <option value="CO" {{ old('nationalite', auth()->user()->nationalite) == 'CO' ? 'selected' : '' }}>🇨🇴 Colombie</option>
                  <option value="KM" {{ old('nationalite', auth()->user()->nationalite) == 'KM' ? 'selected' : '' }}>🇰🇲 Comores</option>
                  <option value="CG" {{ old('nationalite', auth()->user()->nationalite) == 'CG' ? 'selected' : '' }}>🇨🇬 Congo</option>
                  <option value="CD" {{ old('nationalite', auth()->user()->nationalite) == 'CD' ? 'selected' : '' }}>🇨🇩 République démocratique du Congo</option>
                  <option value="KR" {{ old('nationalite', auth()->user()->nationalite) == 'KR' ? 'selected' : '' }}>🇰🇷 Corée du Sud</option>
                  <option value="KP" {{ old('nationalite', auth()->user()->nationalite) == 'KP' ? 'selected' : '' }}>🇰🇵 Corée du Nord</option>
                  <option value="CR" {{ old('nationalite', auth()->user()->nationalite) == 'CR' ? 'selected' : '' }}>🇨🇷 Costa Rica</option>
                  <option value="CI" {{ old('nationalite', auth()->user()->nationalite) == 'CI' ? 'selected' : '' }}>🇨🇮 Côte d'Ivoire</option>
                  <option value="HR" {{ old('nationalite', auth()->user()->nationalite) == 'HR' ? 'selected' : '' }}>🇭🇷 Croatie</option>
                  <option value="CU" {{ old('nationalite', auth()->user()->nationalite) == 'CU' ? 'selected' : '' }}>🇨🇺 Cuba</option>
                  <option value="DK" {{ old('nationalite', auth()->user()->nationalite) == 'DK' ? 'selected' : '' }}>🇩🇰 Danemark</option>
                  <option value="DJ" {{ old('nationalite', auth()->user()->nationalite) == 'DJ' ? 'selected' : '' }}>🇩🇯 Djibouti</option>
                  <option value="DM" {{ old('nationalite', auth()->user()->nationalite) == 'DM' ? 'selected' : '' }}>🇩🇲 Dominique</option>
                  <option value="EG" {{ old('nationalite', auth()->user()->nationalite) == 'EG' ? 'selected' : '' }}>🇪🇬 Égypte</option>
                  <option value="AE" {{ old('nationalite', auth()->user()->nationalite) == 'AE' ? 'selected' : '' }}>🇦🇪 Émirats arabes unis</option>
                  <option value="EC" {{ old('nationalite', auth()->user()->nationalite) == 'EC' ? 'selected' : '' }}>🇪🇨 Équateur</option>
                  <option value="ER" {{ old('nationalite', auth()->user()->nationalite) == 'ER' ? 'selected' : '' }}>🇪🇷 Érythrée</option>
                  <option value="ES" {{ old('nationalite', auth()->user()->nationalite) == 'ES' ? 'selected' : '' }}>🇪🇸 Espagne</option>
                  <option value="EE" {{ old('nationalite', auth()->user()->nationalite) == 'EE' ? 'selected' : '' }}>🇪🇪 Estonie</option>
                  <option value="SZ" {{ old('nationalite', auth()->user()->nationalite) == 'SZ' ? 'selected' : '' }}>🇸🇿 Eswatini</option>
                  <option value="US" {{ old('nationalite', auth()->user()->nationalite) == 'US' ? 'selected' : '' }}>🇺🇸 États-Unis</option>
                  <option value="ET" {{ old('nationalite', auth()->user()->nationalite) == 'ET' ? 'selected' : '' }}>🇪🇹 Éthiopie</option>
                  <option value="FJ" {{ old('nationalite', auth()->user()->nationalite) == 'FJ' ? 'selected' : '' }}>🇫🇯 Fidji</option>
                  <option value="FI" {{ old('nationalite', auth()->user()->nationalite) == 'FI' ? 'selected' : '' }}>🇫🇮 Finlande</option>
                  <option value="FR" {{ old('nationalite', auth()->user()->nationalite) == 'FR' ? 'selected' : '' }}>🇫🇷 France</option>
                  <option value="GA" {{ old('nationalite', auth()->user()->nationalite) == 'GA' ? 'selected' : '' }}>🇬🇦 Gabon</option>
                  <option value="GM" {{ old('nationalite', auth()->user()->nationalite) == 'GM' ? 'selected' : '' }}>🇬🇲 Gambie</option>
                  <option value="GE" {{ old('nationalite', auth()->user()->nationalite) == 'GE' ? 'selected' : '' }}>🇬🇪 Géorgie</option>
                  <option value="GH" {{ old('nationalite', auth()->user()->nationalite) == 'GH' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                  <option value="GR" {{ old('nationalite', auth()->user()->nationalite) == 'GR' ? 'selected' : '' }}>🇬🇷 Grèce</option>
                  <option value="GD" {{ old('nationalite', auth()->user()->nationalite) == 'GD' ? 'selected' : '' }}>🇬🇩 Grenade</option>
                  <option value="GT" {{ old('nationalite', auth()->user()->nationalite) == 'GT' ? 'selected' : '' }}>🇬🇹 Guatemala</option>
                  <option value="GN" {{ old('nationalite', auth()->user()->nationalite) == 'GN' ? 'selected' : '' }}>🇬🇳 Guinée</option>
                  <option value="GW" {{ old('nationalite', auth()->user()->nationalite) == 'GW' ? 'selected' : '' }}>🇬🇼 Guinée-Bissau</option>
                  <option value="GQ" {{ old('nationalite', auth()->user()->nationalite) == 'GQ' ? 'selected' : '' }}>🇬🇶 Guinée équatoriale</option>
                  <option value="GY" {{ old('nationalite', auth()->user()->nationalite) == 'GY' ? 'selected' : '' }}>🇬🇾 Guyana</option>
                  <option value="HT" {{ old('nationalite', auth()->user()->nationalite) == 'HT' ? 'selected' : '' }}>🇭🇹 Haïti</option>
                  <option value="HN" {{ old('nationalite', auth()->user()->nationalite) == 'HN' ? 'selected' : '' }}>🇭🇳 Honduras</option>
                  <option value="HU" {{ old('nationalite', auth()->user()->nationalite) == 'HU' ? 'selected' : '' }}>🇭🇺 Hongrie</option>
                  <option value="IN" {{ old('nationalite', auth()->user()->nationalite) == 'IN' ? 'selected' : '' }}>🇮🇳 Inde</option>
                  <option value="ID" {{ old('nationalite', auth()->user()->nationalite) == 'ID' ? 'selected' : '' }}>🇮🇩 Indonésie</option>
                  <option value="IQ" {{ old('nationalite', auth()->user()->nationalite) == 'IQ' ? 'selected' : '' }}>🇮🇶 Irak</option>
                  <option value="IR" {{ old('nationalite', auth()->user()->nationalite) == 'IR' ? 'selected' : '' }}>🇮🇷 Iran</option>
                  <option value="IE" {{ old('nationalite', auth()->user()->nationalite) == 'IE' ? 'selected' : '' }}>🇮🇪 Irlande</option>
                  <option value="IS" {{ old('nationalite', auth()->user()->nationalite) == 'IS' ? 'selected' : '' }}>🇮🇸 Islande</option>
                  <option value="IL" {{ old('nationalite', auth()->user()->nationalite) == 'IL' ? 'selected' : '' }}>🇮🇱 Israël</option>
                  <option value="IT" {{ old('nationalite', auth()->user()->nationalite) == 'IT' ? 'selected' : '' }}>🇮🇹 Italie</option>
                  <option value="JM" {{ old('nationalite', auth()->user()->nationalite) == 'JM' ? 'selected' : '' }}>🇯🇲 Jamaïque</option>
                  <option value="JP" {{ old('nationalite', auth()->user()->nationalite) == 'JP' ? 'selected' : '' }}>🇯🇵 Japon</option>
                  <option value="JO" {{ old('nationalite', auth()->user()->nationalite) == 'JO' ? 'selected' : '' }}>🇯🇴 Jordanie</option>
                  <option value="KZ" {{ old('nationalite', auth()->user()->nationalite) == 'KZ' ? 'selected' : '' }}>🇰🇿 Kazakhstan</option>
                  <option value="KE" {{ old('nationalite', auth()->user()->nationalite) == 'KE' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                  <option value="KG" {{ old('nationalite', auth()->user()->nationalite) == 'KG' ? 'selected' : '' }}>🇰🇬 Kirghizistan</option>
                  <option value="KI" {{ old('nationalite', auth()->user()->nationalite) == 'KI' ? 'selected' : '' }}>🇰🇮 Kiribati</option>
                  <option value="KW" {{ old('nationalite', auth()->user()->nationalite) == 'KW' ? 'selected' : '' }}>🇰🇼 Koweït</option>
                  <option value="LA" {{ old('nationalite', auth()->user()->nationalite) == 'LA' ? 'selected' : '' }}>🇱🇦 Laos</option>
                  <option value="LS" {{ old('nationalite', auth()->user()->nationalite) == 'LS' ? 'selected' : '' }}>🇱🇸 Lesotho</option>
                  <option value="LV" {{ old('nationalite', auth()->user()->nationalite) == 'LV' ? 'selected' : '' }}>🇱🇻 Lettonie</option>
                  <option value="LB" {{ old('nationalite', auth()->user()->nationalite) == 'LB' ? 'selected' : '' }}>🇱🇧 Liban</option>
                  <option value="LR" {{ old('nationalite', auth()->user()->nationalite) == 'LR' ? 'selected' : '' }}>🇱🇷 Liberia</option>
                  <option value="LY" {{ old('nationalite', auth()->user()->nationalite) == 'LY' ? 'selected' : '' }}>🇱🇾 Libye</option>
                  <option value="LI" {{ old('nationalite', auth()->user()->nationalite) == 'LI' ? 'selected' : '' }}>🇱🇮 Liechtenstein</option>
                  <option value="LT" {{ old('nationalite', auth()->user()->nationalite) == 'LT' ? 'selected' : '' }}>🇱🇹 Lituanie</option>
                  <option value="LU" {{ old('nationalite', auth()->user()->nationalite) == 'LU' ? 'selected' : '' }}>🇱🇺 Luxembourg</option>
                  <option value="MG" {{ old('nationalite', auth()->user()->nationalite) == 'MG' ? 'selected' : '' }}>🇲🇬 Madagascar</option>
                  <option value="MW" {{ old('nationalite', auth()->user()->nationalite) == 'MW' ? 'selected' : '' }}>🇲🇼 Malawi</option>
                  <option value="MY" {{ old('nationalite', auth()->user()->nationalite) == 'MY' ? 'selected' : '' }}>🇲🇾 Malaisie</option>
                  <option value="MV" {{ old('nationalite', auth()->user()->nationalite) == 'MV' ? 'selected' : '' }}>🇲🇻 Maldives</option>
                  <option value="ML" {{ old('nationalite', auth()->user()->nationalite) == 'ML' ? 'selected' : '' }}>🇲🇱 Mali</option>
                  <option value="MT" {{ old('nationalite', auth()->user()->nationalite) == 'MT' ? 'selected' : '' }}>🇲🇹 Malte</option>
                  <option value="MA" {{ old('nationalite', auth()->user()->nationalite) == 'MA' ? 'selected' : '' }}>🇲🇦 Maroc</option>
                  <option value="MU" {{ old('nationalite', auth()->user()->nationalite) == 'MU' ? 'selected' : '' }}>🇲🇺 Maurice</option>
                  <option value="MR" {{ old('nationalite', auth()->user()->nationalite) == 'MR' ? 'selected' : '' }}>🇲🇷 Mauritanie</option>
                  <option value="MX" {{ old('nationalite', auth()->user()->nationalite) == 'MX' ? 'selected' : '' }}>🇲🇽 Mexique</option>
                  <option value="MD" {{ old('nationalite', auth()->user()->nationalite) == 'MD' ? 'selected' : '' }}>🇲🇩 Moldavie</option>
                  <option value="MC" {{ old('nationalite', auth()->user()->nationalite) == 'MC' ? 'selected' : '' }}>🇲🇨 Monaco</option>
                  <option value="MN" {{ old('nationalite', auth()->user()->nationalite) == 'MN' ? 'selected' : '' }}>🇲🇳 Mongolie</option>
                  <option value="ME" {{ old('nationalite', auth()->user()->nationalite) == 'ME' ? 'selected' : '' }}>🇲🇪 Monténégro</option>
                  <option value="MZ" {{ old('nationalite', auth()->user()->nationalite) == 'MZ' ? 'selected' : '' }}>🇲🇿 Mozambique</option>
                  <option value="NA" {{ old('nationalite', auth()->user()->nationalite) == 'NA' ? 'selected' : '' }}>🇳🇦 Namibie</option>
                  <option value="NR" {{ old('nationalite', auth()->user()->nationalite) == 'NR' ? 'selected' : '' }}>🇳🇷 Nauru</option>
                  <option value="NP" {{ old('nationalite', auth()->user()->nationalite) == 'NP' ? 'selected' : '' }}>🇳🇵 Népal</option>
                  <option value="NI" {{ old('nationalite', auth()->user()->nationalite) == 'NI' ? 'selected' : '' }}>🇳🇮 Nicaragua</option>
                  <option value="NE" {{ old('nationalite', auth()->user()->nationalite) == 'NE' ? 'selected' : '' }}>🇳🇪 Niger</option>
                  <option value="NG" {{ old('nationalite', auth()->user()->nationalite) == 'NG' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                  <option value="NO" {{ old('nationalite', auth()->user()->nationalite) == 'NO' ? 'selected' : '' }}>🇳🇴 Norvège</option>
                  <option value="NZ" {{ old('nationalite', auth()->user()->nationalite) == 'NZ' ? 'selected' : '' }}>🇳🇿 Nouvelle-Zélande</option>
                  <option value="OM" {{ old('nationalite', auth()->user()->nationalite) == 'OM' ? 'selected' : '' }}>🇴🇲 Oman</option>
                  <option value="UG" {{ old('nationalite', auth()->user()->nationalite) == 'UG' ? 'selected' : '' }}>🇺🇬 Ouganda</option>
                  <option value="UZ" {{ old('nationalite', auth()->user()->nationalite) == 'UZ' ? 'selected' : '' }}>🇺🇿 Ouzbékistan</option>
                  <option value="PK" {{ old('nationalite', auth()->user()->nationalite) == 'PK' ? 'selected' : '' }}>🇵🇰 Pakistan</option>
                  <option value="PW" {{ old('nationalite', auth()->user()->nationalite) == 'PW' ? 'selected' : '' }}>🇵🇼 Palaos</option>
                  <option value="PA" {{ old('nationalite', auth()->user()->nationalite) == 'PA' ? 'selected' : '' }}>🇵🇦 Panama</option>
                  <option value="PG" {{ old('nationalite', auth()->user()->nationalite) == 'PG' ? 'selected' : '' }}>🇵🇬 Papouasie-Nouvelle-Guinée</option>
                  <option value="PY" {{ old('nationalite', auth()->user()->nationalite) == 'PY' ? 'selected' : '' }}>🇵🇾 Paraguay</option>
                  <option value="NL" {{ old('nationalite', auth()->user()->nationalite) == 'NL' ? 'selected' : '' }}>🇳🇱 Pays-Bas</option>
                  <option value="PE" {{ old('nationalite', auth()->user()->nationalite) == 'PE' ? 'selected' : '' }}>🇵🇪 Pérou</option>
                  <option value="PH" {{ old('nationalite', auth()->user()->nationalite) == 'PH' ? 'selected' : '' }}>🇵🇭 Philippines</option>
                  <option value="PL" {{ old('nationalite', auth()->user()->nationalite) == 'PL' ? 'selected' : '' }}>🇵🇱 Pologne</option>
                  <option value="PT" {{ old('nationalite', auth()->user()->nationalite) == 'PT' ? 'selected' : '' }}>🇵🇹 Portugal</option>
                  <option value="QA" {{ old('nationalite', auth()->user()->nationalite) == 'QA' ? 'selected' : '' }}>🇶🇦 Qatar</option>
                  <option value="RO" {{ old('nationalite', auth()->user()->nationalite) == 'RO' ? 'selected' : '' }}>🇷🇴 Roumanie</option>
                  <option value="GB" {{ old('nationalite', auth()->user()->nationalite) == 'GB' ? 'selected' : '' }}>🇬🇧 Royaume-Uni</option>
                  <option value="RU" {{ old('nationalite', auth()->user()->nationalite) == 'RU' ? 'selected' : '' }}>🇷🇺 Russie</option>
                  <option value="RW" {{ old('nationalite', auth()->user()->nationalite) == 'RW' ? 'selected' : '' }}>🇷🇼 Rwanda</option>
                  <option value="KN" {{ old('nationalite', auth()->user()->nationalite) == 'KN' ? 'selected' : '' }}>🇰🇳 Saint-Kitts-et-Nevis</option>
                  <option value="LC" {{ old('nationalite', auth()->user()->nationalite) == 'LC' ? 'selected' : '' }}>🇱🇨 Sainte-Lucie</option>
                  <option value="VC" {{ old('nationalite', auth()->user()->nationalite) == 'VC' ? 'selected' : '' }}>🇻🇨 Saint-Vincent-et-les-Grenadines</option>
                  <option value="SM" {{ old('nationalite', auth()->user()->nationalite) == 'SM' ? 'selected' : '' }}>🇸🇲 Saint-Marin</option>
                  <option value="ST" {{ old('nationalite', auth()->user()->nationalite) == 'ST' ? 'selected' : '' }}>🇸🇹 Sao Tomé-et-Principe</option>
                  <option value="SN" {{ old('nationalite', auth()->user()->nationalite) == 'SN' ? 'selected' : '' }}>🇸🇳 Sénégal</option>
                  <option value="RS" {{ old('nationalite', auth()->user()->nationalite) == 'RS' ? 'selected' : '' }}>🇷🇸 Serbie</option>
                  <option value="SC" {{ old('nationalite', auth()->user()->nationalite) == 'SC' ? 'selected' : '' }}>🇸🇨 Seychelles</option>
                  <option value="SL" {{ old('nationalite', auth()->user()->nationalite) == 'SL' ? 'selected' : '' }}>🇸🇱 Sierra Leone</option>
                  <option value="SG" {{ old('nationalite', auth()->user()->nationalite) == 'SG' ? 'selected' : '' }}>🇸🇬 Singapour</option>
                  <option value="SK" {{ old('nationalite', auth()->user()->nationalite) == 'SK' ? 'selected' : '' }}>🇸🇰 Slovaquie</option>
                  <option value="SI" {{ old('nationalite', auth()->user()->nationalite) == 'SI' ? 'selected' : '' }}>🇸🇮 Slovénie</option>
                  <option value="SO" {{ old('nationalite', auth()->user()->nationalite) == 'SO' ? 'selected' : '' }}>🇸🇴 Somalie</option>
                  <option value="SD" {{ old('nationalite', auth()->user()->nationalite) == 'SD' ? 'selected' : '' }}>🇸🇩 Soudan</option>
                  <option value="SS" {{ old('nationalite', auth()->user()->nationalite) == 'SS' ? 'selected' : '' }}>🇸🇸 Soudan du Sud</option>
                  <option value="LK" {{ old('nationalite', auth()->user()->nationalite) == 'LK' ? 'selected' : '' }}>🇱🇰 Sri Lanka</option>
                  <option value="SE" {{ old('nationalite', auth()->user()->nationalite) == 'SE' ? 'selected' : '' }}>🇸🇪 Suède</option>
                  <option value="CH" {{ old('nationalite', auth()->user()->nationalite) == 'CH' ? 'selected' : '' }}>🇨🇭 Suisse</option>
                  <option value="SR" {{ old('nationalite', auth()->user()->nationalite) == 'SR' ? 'selected' : '' }}>🇸🇷 Suriname</option>
                  <option value="SY" {{ old('nationalite', auth()->user()->nationalite) == 'SY' ? 'selected' : '' }}>🇸🇾 Syrie</option>
                  <option value="TJ" {{ old('nationalite', auth()->user()->nationalite) == 'TJ' ? 'selected' : '' }}>🇹🇯 Tadjikistan</option>
                  <option value="TW" {{ old('nationalite', auth()->user()->nationalite) == 'TW' ? 'selected' : '' }}>🇹🇼 Taïwan</option>
                  <option value="TZ" {{ old('nationalite', auth()->user()->nationalite) == 'TZ' ? 'selected' : '' }}>🇹🇿 Tanzanie</option>
                  <option value="TD" {{ old('nationalite', auth()->user()->nationalite) == 'TD' ? 'selected' : '' }}>🇹🇩 Tchad</option>
                  <option value="CZ" {{ old('nationalite', auth()->user()->nationalite) == 'CZ' ? 'selected' : '' }}>🇨🇿 République tchèque</option>
                  <option value="TH" {{ old('nationalite', auth()->user()->nationalite) == 'TH' ? 'selected' : '' }}>🇹🇭 Thaïlande</option>
                  <option value="TL" {{ old('nationalite', auth()->user()->nationalite) == 'TL' ? 'selected' : '' }}>🇹🇱 Timor oriental</option>
                  <option value="TG" {{ old('nationalite', auth()->user()->nationalite) == 'TG' ? 'selected' : '' }}>🇹🇬 Togo</option>
                  <option value="TO" {{ old('nationalite', auth()->user()->nationalite) == 'TO' ? 'selected' : '' }}>🇹🇴 Tonga</option>
                  <option value="TT" {{ old('nationalite', auth()->user()->nationalite) == 'TT' ? 'selected' : '' }}>🇹🇹 Trinité-et-Tobago</option>
                  <option value="TN" {{ old('nationalite', auth()->user()->nationalite) == 'TN' ? 'selected' : '' }}>🇹🇳 Tunisie</option>
                  <option value="TM" {{ old('nationalite', auth()->user()->nationalite) == 'TM' ? 'selected' : '' }}>🇹🇲 Turkménistan</option>
                  <option value="TR" {{ old('nationalite', auth()->user()->nationalite) == 'TR' ? 'selected' : '' }}>🇹🇷 Turquie</option>
                  <option value="TV" {{ old('nationalite', auth()->user()->nationalite) == 'TV' ? 'selected' : '' }}>🇹🇻 Tuvalu</option>
                  <option value="UA" {{ old('nationalite', auth()->user()->nationalite) == 'UA' ? 'selected' : '' }}>🇺🇦 Ukraine</option>
                  <option value="UY" {{ old('nationalite', auth()->user()->nationalite) == 'UY' ? 'selected' : '' }}>🇺🇾 Uruguay</option>
                  <option value="VU" {{ old('nationalite', auth()->user()->nationalite) == 'VU' ? 'selected' : '' }}>🇻🇺 Vanuatu</option>
                  <option value="VA" {{ old('nationalite', auth()->user()->nationalite) == 'VA' ? 'selected' : '' }}>🇻🇦 Vatican</option>
                  <option value="VE" {{ old('nationalite', auth()->user()->nationalite) == 'VE' ? 'selected' : '' }}>🇻🇪 Venezuela</option>
                  <option value="VN" {{ old('nationalite', auth()->user()->nationalite) == 'VN' ? 'selected' : '' }}>🇻🇳 Viêt Nam</option>
                  <option value="YE" {{ old('nationalite', auth()->user()->nationalite) == 'YE' ? 'selected' : '' }}>🇾🇪 Yémen</option>
                  <option value="ZM" {{ old('nationalite', auth()->user()->nationalite) == 'ZM' ? 'selected' : '' }}>🇿🇲 Zambie</option>
                  <option value="ZW" {{ old('nationalite', auth()->user()->nationalite) == 'ZW' ? 'selected' : '' }}>🇿🇼 Zimbabwe</option>
                </select>
                @error('nationalite')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 align-self-center">
                <label class="form-label mt-4">Langue</label>
                <select class="form-control" name="choices-language" id="choices-language">
                  <option value="French" {{ old('choices-language', 'French')==='French' ? 'selected' : '' }}>French</option>
                  <option value="English" {{ old('choices-language')==='English' ? 'selected' : '' }}>English</option>
                  <option value="Spanish" {{ old('choices-language')==='Spanish' ? 'selected' : '' }}>Spanish</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label mt-4">Photo</label>
                <div class="input-group">
                  <input id="photo" name="photo" class="form-control" type="file" accept="image/*" onchange="displayFileName(this)">
                </div>
                @if(auth()->user()->photo)
                <div class="mt-2">
                  <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Photo actuelle" class="avatar avatar-sm rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                </div>
                @endif
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-12 text-end">
                <button type="submit" class="btn bg-gradient-primary mb-0" id="submitProfileBtn">Enregistrer</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Card Changer le mot de passe -->
      <div class="card mt-4" id="password">
        <div class="card-header">
          <h5>Changer le mot de passe</h5>
        </div>
        <div class="card-body pt-0">
          <form action="{{ route('account.settings.updatePassword') }}" method="POST" id="passwordForm">
            @csrf
            <label class="form-label">Mot de passe actuel</label>
            <div class="form-group">
              <input class="form-control" type="password" name="current_password" id="current_password" placeholder="Mot de passe actuel" required>
            </div>
            <label class="form-label">Nouveau mot de passe</label>
            <div class="form-group">
              <input class="form-control" type="password" name="new_password" id="new_password" placeholder="Nouveau mot de passe" required>
            </div>
            <label class="form-label">Confirmer le nouveau mot de passe</label>
            <div class="form-group">
              <input class="form-control" type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirmer le mot de passe" required>
            </div>
            <h5 class="mt-5">Exigences du mot de passe</h5>
            <p class="text-muted mb-2">
              Veuillez suivre ce guide pour un mot de passe fort :
            </p>
            <ul class="text-muted ps-4 mb-0 float-start">
              <li>
                <span class="text-sm">Un caractère spécial</span>
              </li>
              <li>
                <span class="text-sm">Minimum 6 caractères</span>
              </li>
              <li>
                <span class="text-sm">Un chiffre (2 sont recommandés)</span>
              </li>
              <li>
                <span class="text-sm">Changez-le souvent</span>
              </li>
            </ul>
            <button type="submit" class="btn bg-gradient-dark btn-sm float-end mt-6 mb-0" id="updatePasswordBtn">Mettre à jour le mot de passe</button>
          </form>
        </div>
      </div>

      <!-- Card Sessions -->
      <div class="card mt-4" id="sessions">
        <div class="card-header pb-3">
          <h5>Appareils connectés</h5>
          <p class="text-sm">Ceci est une liste des appareils qui se sont connectés à votre compte. Supprimez ceux que vous ne reconnaissez pas.</p>
        </div>
        <div class="card-body pt-0">
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          @forelse($sessions as $index => $session)
            <div class="d-flex align-items-center {{ $index > 0 ? 'mt-3' : '' }}">
              <div class="text-center w-5">
                @if(in_array($session['device_name'], ['iPhone', 'iPad', 'Android', 'Mobile']))
                  <i class="fas fa-mobile text-lg opacity-6"></i>
                @else
                  <i class="fas fa-desktop text-lg opacity-6"></i>
                @endif
              </div>
              <div class="my-auto ms-3 flex-grow-1">
              <div class="h-100">
                  <p class="text-sm mb-1 font-weight-bold">
                    {{ $session['browser'] }} sur {{ $session['platform'] }}
                </p>
                <p class="mb-0 text-xs">
                    {{ $session['ip_address'] }}
                    @if($session['is_current'])
                      - <span class="text-success font-weight-bold">Votre session actuelle</span>
                    @endif
                  </p>
                  <p class="mb-0 text-xs text-secondary">
                    Dernière activité : {{ \Carbon\Carbon::parse($session['last_activity'])->diffForHumans() }}
                  </p>
                </div>
              </div>
              @if($session['is_current'])
                <span class="badge badge-success badge-sm my-auto me-3">ACTIVE</span>
              @else
                <span class="badge badge-secondary badge-sm my-auto me-3">INACTIVE</span>
              @endif
              <div class="d-flex align-items-center gap-2 my-auto">
                <button type="button" class="btn btn-sm btn-link text-primary p-0" data-bs-toggle="modal" data-bs-target="#sessionModal{{ $index }}">
                  Voir plus
                  <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                </button>
                <form action="{{ auth()->user()->role === 'admin' && request()->routeIs('admin.*') ? route('admin.sessions.destroy', $session['id']) : route('account.sessions.destroy', $session['id']) }}" method="POST" class="d-inline ms-2">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger text-white" onclick="return confirm('Êtes-vous sûr de vouloir déconnecter cet appareil ?{{ $session['is_current'] ? ' Vous serez déconnecté de cette session.' : '' }}')" title="Déconnecter cet appareil">
                    <i class="fas fa-sign-out-alt"></i> Déconnecter
                  </button>
                </form>
              </div>
            </div>
            @if(!$loop->last)
              <hr class="horizontal dark mt-3">
            @endif

            <!-- Modal pour les détails de la session -->
            <div class="modal fade" id="sessionModal{{ $index }}" tabindex="-1" aria-labelledby="sessionModalLabel{{ $index }}" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="sessionModalLabel{{ $index }}">Détails de l'appareil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row mb-3">
                      <div class="col-12">
                        <div class="d-flex align-items-center mb-3">
                          <div class="text-center me-3">
                            @if(in_array($session['device_name'], ['iPhone', 'iPad', 'Android', 'Mobile']))
                              <i class="fas fa-mobile text-3xl text-primary"></i>
                            @else
                              <i class="fas fa-desktop text-3xl text-primary"></i>
                            @endif
                          </div>
                          <div>
                            <h6 class="mb-0">{{ $session['browser'] }} sur {{ $session['platform'] }}</h6>
                            <p class="text-sm text-muted mb-0">{{ $session['device_name'] }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-6 mb-3">
                        <p class="text-xs text-muted mb-1">Adresse IP</p>
                        <p class="text-sm font-weight-bold mb-0">{{ $session['ip_address'] }}</p>
                      </div>
                      <div class="col-6 mb-3">
                        <p class="text-xs text-muted mb-1">Statut</p>
                        @if($session['is_current'])
                          <span class="badge badge-success badge-sm">ACTIVE</span>
                        @else
                          <span class="badge badge-secondary badge-sm">INACTIVE</span>
                        @endif
                      </div>
                      <div class="col-6 mb-3">
                        <p class="text-xs text-muted mb-1">Navigateur</p>
                        <p class="text-sm font-weight-bold mb-0">{{ $session['browser'] }}</p>
                      </div>
                      <div class="col-6 mb-3">
                        <p class="text-xs text-muted mb-1">Plateforme</p>
                        <p class="text-sm font-weight-bold mb-0">{{ $session['platform'] }}</p>
                      </div>
                      <div class="col-6 mb-3">
                        <p class="text-xs text-muted mb-1">Type d'appareil</p>
                        <p class="text-sm font-weight-bold mb-0">{{ $session['device_name'] }}</p>
                      </div>
                      <div class="col-6 mb-3">
                        <p class="text-xs text-muted mb-1">Dernière activité</p>
                        <p class="text-sm font-weight-bold mb-0">{{ \Carbon\Carbon::parse($session['last_activity'])->format('d/m/Y H:i') }}</p>
                        <p class="text-xs text-secondary mb-0">{{ \Carbon\Carbon::parse($session['last_activity'])->diffForHumans() }}</p>
                      </div>
                      @if(!empty($session['user_agent']))
                        <div class="col-12 mb-3">
                          <p class="text-xs text-muted mb-1">User Agent</p>
                          <p class="text-sm mb-0" style="word-break: break-all; font-size: 0.75rem;">{{ $session['user_agent'] }}</p>
                        </div>
                      @endif
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
                    <form action="{{ auth()->user()->role === 'admin' && request()->routeIs('admin.*') ? route('admin.sessions.destroy', $session['id']) : route('account.sessions.destroy', $session['id']) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm text-white" onclick="return confirm('Êtes-vous sûr de vouloir déconnecter cet appareil ?{{ $session['is_current'] ? ' Vous serez déconnecté de cette session.' : '' }}')">
                        <i class="fas fa-sign-out-alt me-1"></i> Déconnecter
                      </button>
                    </form>
                  </div>
                </div>
          </div>
            </div>
          @empty
            <div class="text-center py-4">
              <i class="fas fa-desktop text-4xl text-muted mb-3"></i>
              <p class="text-muted mb-0">Aucun appareil connecté</p>
            </div>
          @endforelse
        </div>
      </div>

      <!-- Card Supprimer le compte -->
      <div class="card mt-4" id="delete">
        <div class="card-header">
          <h5>Supprimer le compte</h5>
          <p class="text-sm mb-0">Une fois que vous supprimez votre compte, il n'y a pas de retour en arrière. Veuillez être certain.</p>
        </div>
        <div class="card-body d-sm-flex pt-0">
          <div class="d-flex align-items-center mb-sm-0 mb-4">
            <div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" id="confirmDeleteCheckbox">
              </div>
            </div>
            <div class="ms-2">
              <span class="text-dark font-weight-bold d-block text-sm">Confirmer</span>
              <span class="text-xs d-block">Je veux supprimer mon compte.</span>
            </div>
          </div>
          <button class="btn btn-outline-secondary mb-0 ms-auto" type="button" name="button">Désactiver</button>
          <button type="button" class="btn btn-danger mb-0 ms-2" id="deleteAccountBtn" disabled>Supprimer le compte</button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  if (document.getElementById('choices-gender')) {
    var gender = document.getElementById('choices-gender');
    const example = new Choices(gender);
  }

  if (document.getElementById('choices-language')) {
    var language = document.getElementById('choices-language');
    const example = new Choices(language);
  }

  if (document.getElementById('choices-year')) {
    var year = document.getElementById('choices-year');
    setTimeout(function() {
      const example = new Choices(year);
    }, 1);

    for (y = 1900; y <= 2020; y++) {
      var optn = document.createElement("OPTION");
      optn.text = y;
      optn.value = y;

      if (y == 2020) {
        optn.selected = true;
      }

      year.options.add(optn);
    }
  }

  if (document.getElementById('choices-day')) {
    var day = document.getElementById('choices-day');
    setTimeout(function() {
      const example = new Choices(day);
    }, 1);

    for (y = 1; y <= 31; y++) {
      var optn = document.createElement("OPTION");
      optn.text = y;
      optn.value = y;

      if (y == 1) {
        optn.selected = true;
      }

      day.options.add(optn);
    }
  }

  if (document.getElementById('choices-month')) {
    var month = document.getElementById('choices-month');
    setTimeout(function() {
      const example = new Choices(month);
    }, 1);

    var monthArray = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    for (m = 0; m <= 11; m++) {
      var optn = document.createElement("OPTION");
      optn.text = monthArray[m];
      optn.value = (m + 1);
      if (m == 1) {
        optn.selected = true;
      }
      month.options.add(optn);
    }
  }

  function visible() {
    var elem = document.getElementById('profileVisibility');
    if (elem) {
      if (elem.innerHTML == "Passer en visible") {
        elem.innerHTML = "Passer en invisible"
      } else {
        elem.innerHTML = "Passer en visible"
      }
    }
  }

  // Gestion du bouton Supprimer le compte - verrouillé par défaut
  document.addEventListener('DOMContentLoaded', function() {
    const confirmCheckbox = document.getElementById('confirmDeleteCheckbox');
    const deleteBtn = document.getElementById('deleteAccountBtn');
    
    if (confirmCheckbox && deleteBtn) {
      confirmCheckbox.addEventListener('change', function() {
        deleteBtn.disabled = !this.checked;
      });
    }

    // Validation du mot de passe avec vérification du mot de passe actuel
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
      passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        
        // Supprimer les messages d'erreur précédents
        const existingErrors = document.querySelectorAll('.password-error');
        existingErrors.forEach(err => err.remove());
        
        // Vérifier que le mot de passe actuel est rempli
        if (!currentPassword) {
          showPasswordError('current_password', 'Le mot de passe actuel est obligatoire.');
          return;
        }
        
        // Vérifier que les nouveaux mots de passe correspondent
        if (newPassword !== confirmPassword) {
          showPasswordError('new_password_confirmation', 'Les mots de passe ne correspondent pas.');
          return;
        }
        
        // Vérifier la longueur minimale
        if (newPassword.length < 6) {
          showPasswordError('new_password', 'Le mot de passe doit contenir au moins 6 caractères.');
          return;
        }
        
        // Vérifier le mot de passe actuel via AJAX
        fetch('{{ route("account.settings.updatePassword") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            current_password: currentPassword,
            new_password: newPassword,
            new_password_confirmation: confirmPassword
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.errors && data.errors.current_password) {
            showPasswordError('current_password', data.errors.current_password[0]);
          } else if (data.message || data.success) {
            // Succès - soumettre le formulaire normalement
            passwordForm.submit();
          } else {
            // Soumettre le formulaire normalement
            passwordForm.submit();
          }
        })
        .catch(error => {
          // En cas d'erreur réseau, soumettre le formulaire normalement
          passwordForm.submit();
        });
      });
    }
  });
  
  function showPasswordError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (field) {
      const errorDiv = document.createElement('div');
      errorDiv.className = 'password-error text-danger text-xs mt-1';
      errorDiv.textContent = message;
      field.parentElement.appendChild(errorDiv);
      field.classList.add('is-invalid');
    }
  }

  // Fonction pour afficher le nom du fichier sélectionné
  function displayFileName(input) {
    console.log('[PHOTO DEBUG] displayFileName appelé', {
      input_files: input.files ? input.files.length : 0,
      has_file: input.files && input.files[0] ? true : false,
      file_name: input.files && input.files[0] ? input.files[0].name : 'N/A'
    });
    
    const currentPhotoName = document.getElementById('currentPhotoName');
    const fileNameText = document.getElementById('fileNameText');
    
    console.log('[PHOTO DEBUG] Éléments trouvés:', {
      currentPhotoName: !!currentPhotoName,
      fileNameText: !!fileNameText
    });
    
    if (input.files && input.files[0]) {
      const fileName = input.files[0].name;
      
      console.log('[PHOTO DEBUG] Fichier sélectionné:', fileName);
      
      // Mettre à jour le style CSS de l'input file pour afficher le nouveau nom
      const style = document.createElement('style');
      style.id = 'photo-input-style';
      const existingStyle = document.getElementById('photo-input-style');
      if (existingStyle) {
        existingStyle.remove();
      }
      style.textContent = `
        #photo::before {
          content: "${fileName}";
          color: #344767;
          display: inline-block;
          pointer-events: none;
          position: absolute;
          left: 12px;
          top: 50%;
          transform: translateY(-50%);
        }
      `;
      document.head.appendChild(style);
      
      // Si une photo existe déjà, mettre à jour son nom
      if (currentPhotoName) {
        console.log('[PHOTO DEBUG] Mise à jour currentPhotoName avec:', fileName);
        currentPhotoName.textContent = fileName;
      } else if (fileNameText) {
        // Sinon, afficher le nom du nouveau fichier
        console.log('[PHOTO DEBUG] Mise à jour fileNameText avec:', fileName);
        fileNameText.textContent = fileName;
      }
    } else {
      console.log('[PHOTO DEBUG] Aucun fichier sélectionné, restauration du nom original');
      
      if (currentPhotoName) {
        // Si une photo existait, réafficher son nom original depuis l'attribut data
        const originalPhoto = currentPhotoName.getAttribute('data-original-photo');
        console.log('[PHOTO DEBUG] Nom original depuis data-original-photo:', originalPhoto);
        if (originalPhoto) {
          currentPhotoName.textContent = originalPhoto;
          
          // Restaurer le style CSS avec le nom original
          const style = document.createElement('style');
          style.id = 'photo-input-style';
          const existingStyle = document.getElementById('photo-input-style');
          if (existingStyle) {
            existingStyle.remove();
          }
          style.textContent = `
            #photo::before {
              content: "${originalPhoto}";
              color: #344767;
              display: inline-block;
              pointer-events: none;
              position: absolute;
              left: 12px;
              top: 50%;
              transform: translateY(-50%);
            }
          `;
          document.head.appendChild(style);
        }
      } else if (fileNameText) {
        console.log('[PHOTO DEBUG] Affichage "Aucun fichier sélectionné"');
        fileNameText.textContent = 'Aucun fichier sélectionné';
        
        // Restaurer le style CSS avec "Choisir le fichier"
        const style = document.createElement('style');
        style.id = 'photo-input-style';
        const existingStyle = document.getElementById('photo-input-style');
        if (existingStyle) {
          existingStyle.remove();
        }
        style.textContent = `
          #photo::before {
            content: "Choisir le fichier";
            color: #344767;
            display: inline-block;
            pointer-events: none;
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
          }
        `;
        document.head.appendChild(style);
      }
    }
  }

  // Logs pour le formulaire de profil
  document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.getElementById('profileForm');
    const submitBtn = document.getElementById('submitProfileBtn');
    
    // Logs pour la photo
    const currentPhotoName = document.getElementById('currentPhotoName');
    const fileNameText = document.getElementById('fileNameText');
    const photoFileNameDisplay = document.getElementById('photoFileNameDisplay');
    const photoInput = document.getElementById('photo');
    
    console.log('[PHOTO DEBUG] État initial de la photo:', {
      currentPhotoName_exists: !!currentPhotoName,
      currentPhotoName_text: currentPhotoName ? currentPhotoName.textContent : 'N/A',
      currentPhotoName_data_original: currentPhotoName ? currentPhotoName.getAttribute('data-original-photo') : 'N/A',
      currentPhotoName_data_path: currentPhotoName ? currentPhotoName.getAttribute('data-photo-path') : 'N/A',
      currentPhotoName_display: currentPhotoName ? window.getComputedStyle(currentPhotoName).display : 'N/A',
      currentPhotoName_visibility: currentPhotoName ? window.getComputedStyle(currentPhotoName).visibility : 'N/A',
      currentPhotoName_opacity: currentPhotoName ? window.getComputedStyle(currentPhotoName).opacity : 'N/A',
      fileNameText_exists: !!fileNameText,
      fileNameText_text: fileNameText ? fileNameText.textContent : 'N/A',
      photoFileNameDisplay_exists: !!photoFileNameDisplay,
      photoFileNameDisplay_innerHTML: photoFileNameDisplay ? photoFileNameDisplay.innerHTML : 'N/A',
      photo_input_exists: !!photoInput,
      photo_input_value: photoInput ? photoInput.value : 'N/A',
      photo_input_files: photoInput && photoInput.files ? photoInput.files.length : 0
    });
    
    // Vérifier visuellement si le texte est visible
    if (currentPhotoName) {
      const rect = currentPhotoName.getBoundingClientRect();
      console.log('[PHOTO DEBUG] Position et taille de currentPhotoName:', {
        width: rect.width,
        height: rect.height,
        top: rect.top,
        left: rect.left,
        visible: rect.width > 0 && rect.height > 0
      });
    }
    
    // Vérifier pourquoi l'input file affiche "aucun fichier sél."
    if (photoInput) {
      console.log('[PHOTO DEBUG] Input file détails:', {
        value: photoInput.value,
        files_length: photoInput.files ? photoInput.files.length : 0,
        accept: photoInput.accept,
        type: photoInput.type,
        // Note: Les inputs file ne peuvent pas afficher le fichier actuel pour des raisons de sécurité
        note: 'Les inputs file HTML ne peuvent pas afficher le fichier actuellement enregistré. C\'est normal qu\'il affiche "aucun fichier sél." même si une photo existe.'
      });
    }
    
    if (profileForm) {
      console.log('[PROFILE FORM] Formulaire trouvé', {
        action: profileForm.action,
        method: profileForm.method,
        enctype: profileForm.enctype
      });

      // Intercepter la soumission du formulaire
      profileForm.addEventListener('submit', function(e) {
        console.log('[PROFILE FORM] Soumission du formulaire');
        
        const formData = new FormData(profileForm);
        const data = {};
        for (let [key, value] of formData.entries()) {
          if (key !== 'photo') { // Ne pas logger le fichier
            data[key] = value;
          } else {
            data[key] = value.name || 'Fichier sélectionné';
          }
        }
        
        console.log('[PROFILE FORM] Données du formulaire:', data);
        console.log('[PROFILE FORM] Action:', profileForm.action);
        console.log('[PROFILE FORM] Méthode:', profileForm.method);
        
        // Laisser le formulaire se soumettre normalement
      });

      // Logs des changements de champs
      const inputs = profileForm.querySelectorAll('input, select');
      inputs.forEach(input => {
        input.addEventListener('change', function() {
          console.log('[PROFILE FORM] Champ modifié:', {
            name: input.name,
            value: input.type === 'file' ? input.files[0]?.name : input.value
          });
        });
      });
    } else {
      console.error('[PROFILE FORM] Formulaire non trouvé!');
    }
  });
</script>
@endpush
@endsection
