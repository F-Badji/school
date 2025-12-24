@extends('layouts.admin')

@section('title', 'Modifier Formateur')
@section('breadcrumb', 'Modifier Formateur')
@section('page-title', 'Modifier le Formateur')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Modifier les Informations</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.formateurs.update', $formateur) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nom <span class="text-danger">*</span></label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $formateur->nom) }}" required>
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Prénom <span class="text-danger">*</span></label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $formateur->prenom) }}" required>
              @error('prenom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $formateur->email) }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Nouveau mot de passe</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8">
              <small class="text-muted">Laisser vide pour ne pas modifier</small>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date de naissance</label>
              <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance', $formateur->date_naissance ? $formateur->date_naissance->format('Y-m-d') : '') }}">
              @error('date_naissance')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Téléphone</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $formateur->phone) }}" placeholder="Ex: +221 77 123 45 67">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Ville</label>
              <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $formateur->location) }}" placeholder="Ex: Dakar">
              @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Nationalité</label>
              <select name="nationalite" class="form-control @error('nationalite') is-invalid @enderror">
                <option value="">-- Sélectionner une nationalité --</option>
                <option value="AF" {{ old('nationalite', $formateur->nationalite) == 'AF' ? 'selected' : '' }}>🇦🇫 Afghanistan</option>
                <option value="ZA" {{ old('nationalite', $formateur->nationalite) == 'ZA' ? 'selected' : '' }}>🇿🇦 Afrique du Sud</option>
                <option value="AL" {{ old('nationalite', $formateur->nationalite) == 'AL' ? 'selected' : '' }}>🇦🇱 Albanie</option>
                <option value="DZ" {{ old('nationalite', $formateur->nationalite) == 'DZ' ? 'selected' : '' }}>🇩🇿 Algérie</option>
                <option value="DE" {{ old('nationalite', $formateur->nationalite) == 'DE' ? 'selected' : '' }}>🇩🇪 Allemagne</option>
                <option value="AD" {{ old('nationalite', $formateur->nationalite) == 'AD' ? 'selected' : '' }}>🇦🇩 Andorre</option>
                <option value="AO" {{ old('nationalite', $formateur->nationalite) == 'AO' ? 'selected' : '' }}>🇦🇴 Angola</option>
                <option value="AG" {{ old('nationalite', $formateur->nationalite) == 'AG' ? 'selected' : '' }}>🇦🇬 Antigua-et-Barbuda</option>
                <option value="SA" {{ old('nationalite', $formateur->nationalite) == 'SA' ? 'selected' : '' }}>🇸🇦 Arabie Saoudite</option>
                <option value="AR" {{ old('nationalite', $formateur->nationalite) == 'AR' ? 'selected' : '' }}>🇦🇷 Argentine</option>
                <option value="AM" {{ old('nationalite', $formateur->nationalite) == 'AM' ? 'selected' : '' }}>🇦🇲 Arménie</option>
                <option value="AU" {{ old('nationalite', $formateur->nationalite) == 'AU' ? 'selected' : '' }}>🇦🇺 Australie</option>
                <option value="AT" {{ old('nationalite', $formateur->nationalite) == 'AT' ? 'selected' : '' }}>🇦🇹 Autriche</option>
                <option value="AZ" {{ old('nationalite', $formateur->nationalite) == 'AZ' ? 'selected' : '' }}>🇦🇿 Azerbaïdjan</option>
                <option value="BS" {{ old('nationalite', $formateur->nationalite) == 'BS' ? 'selected' : '' }}>🇧🇸 Bahamas</option>
                <option value="BH" {{ old('nationalite', $formateur->nationalite) == 'BH' ? 'selected' : '' }}>🇧🇭 Bahreïn</option>
                <option value="BD" {{ old('nationalite', $formateur->nationalite) == 'BD' ? 'selected' : '' }}>🇧🇩 Bangladesh</option>
                <option value="BB" {{ old('nationalite', $formateur->nationalite) == 'BB' ? 'selected' : '' }}>🇧🇧 Barbade</option>
                <option value="BE" {{ old('nationalite', $formateur->nationalite) == 'BE' ? 'selected' : '' }}>🇧🇪 Belgique</option>
                <option value="BZ" {{ old('nationalite', $formateur->nationalite) == 'BZ' ? 'selected' : '' }}>🇧🇿 Belize</option>
                <option value="BJ" {{ old('nationalite', $formateur->nationalite) == 'BJ' ? 'selected' : '' }}>🇧🇯 Bénin</option>
                <option value="BT" {{ old('nationalite', $formateur->nationalite) == 'BT' ? 'selected' : '' }}>🇧🇹 Bhoutan</option>
                <option value="BY" {{ old('nationalite', $formateur->nationalite) == 'BY' ? 'selected' : '' }}>🇧🇾 Biélorussie</option>
                <option value="MM" {{ old('nationalite', $formateur->nationalite) == 'MM' ? 'selected' : '' }}>🇲🇲 Birmanie</option>
                <option value="BO" {{ old('nationalite', $formateur->nationalite) == 'BO' ? 'selected' : '' }}>🇧🇴 Bolivie</option>
                <option value="BA" {{ old('nationalite', $formateur->nationalite) == 'BA' ? 'selected' : '' }}>🇧🇦 Bosnie-Herzégovine</option>
                <option value="BW" {{ old('nationalite', $formateur->nationalite) == 'BW' ? 'selected' : '' }}>🇧🇼 Botswana</option>
                <option value="BR" {{ old('nationalite', $formateur->nationalite) == 'BR' ? 'selected' : '' }}>🇧🇷 Brésil</option>
                <option value="BN" {{ old('nationalite', $formateur->nationalite) == 'BN' ? 'selected' : '' }}>🇧🇳 Brunei</option>
                <option value="BG" {{ old('nationalite', $formateur->nationalite) == 'BG' ? 'selected' : '' }}>🇧🇬 Bulgarie</option>
                <option value="BF" {{ old('nationalite', $formateur->nationalite) == 'BF' ? 'selected' : '' }}>🇧🇫 Burkina Faso</option>
                <option value="BI" {{ old('nationalite', $formateur->nationalite) == 'BI' ? 'selected' : '' }}>🇧🇮 Burundi</option>
                <option value="KH" {{ old('nationalite', $formateur->nationalite) == 'KH' ? 'selected' : '' }}>🇰🇭 Cambodge</option>
                <option value="CM" {{ old('nationalite', $formateur->nationalite) == 'CM' ? 'selected' : '' }}>🇨🇲 Cameroun</option>
                <option value="CA" {{ old('nationalite', $formateur->nationalite) == 'CA' ? 'selected' : '' }}>🇨🇦 Canada</option>
                <option value="CV" {{ old('nationalite', $formateur->nationalite) == 'CV' ? 'selected' : '' }}>🇨🇻 Cap-Vert</option>
                <option value="CL" {{ old('nationalite', $formateur->nationalite) == 'CL' ? 'selected' : '' }}>🇨🇱 Chili</option>
                <option value="CN" {{ old('nationalite', $formateur->nationalite) == 'CN' ? 'selected' : '' }}>🇨🇳 Chine</option>
                <option value="CY" {{ old('nationalite', $formateur->nationalite) == 'CY' ? 'selected' : '' }}>🇨🇾 Chypre</option>
                <option value="CO" {{ old('nationalite', $formateur->nationalite) == 'CO' ? 'selected' : '' }}>🇨🇴 Colombie</option>
                <option value="KM" {{ old('nationalite', $formateur->nationalite) == 'KM' ? 'selected' : '' }}>🇰🇲 Comores</option>
                <option value="CG" {{ old('nationalite', $formateur->nationalite) == 'CG' ? 'selected' : '' }}>🇨🇬 Congo</option>
                <option value="CD" {{ old('nationalite', $formateur->nationalite) == 'CD' ? 'selected' : '' }}>🇨🇩 République démocratique du Congo</option>
                <option value="KR" {{ old('nationalite', $formateur->nationalite) == 'KR' ? 'selected' : '' }}>🇰🇷 Corée du Sud</option>
                <option value="KP" {{ old('nationalite', $formateur->nationalite) == 'KP' ? 'selected' : '' }}>🇰🇵 Corée du Nord</option>
                <option value="CR" {{ old('nationalite', $formateur->nationalite) == 'CR' ? 'selected' : '' }}>🇨🇷 Costa Rica</option>
                <option value="CI" {{ old('nationalite', $formateur->nationalite) == 'CI' ? 'selected' : '' }}>🇨🇮 Côte d'Ivoire</option>
                <option value="HR" {{ old('nationalite', $formateur->nationalite) == 'HR' ? 'selected' : '' }}>🇭🇷 Croatie</option>
                <option value="CU" {{ old('nationalite', $formateur->nationalite) == 'CU' ? 'selected' : '' }}>🇨🇺 Cuba</option>
                <option value="DK" {{ old('nationalite', $formateur->nationalite) == 'DK' ? 'selected' : '' }}>🇩🇰 Danemark</option>
                <option value="DJ" {{ old('nationalite', $formateur->nationalite) == 'DJ' ? 'selected' : '' }}>🇩🇯 Djibouti</option>
                <option value="DM" {{ old('nationalite', $formateur->nationalite) == 'DM' ? 'selected' : '' }}>🇩🇲 Dominique</option>
                <option value="EG" {{ old('nationalite', $formateur->nationalite) == 'EG' ? 'selected' : '' }}>🇪🇬 Égypte</option>
                <option value="AE" {{ old('nationalite', $formateur->nationalite) == 'AE' ? 'selected' : '' }}>🇦🇪 Émirats arabes unis</option>
                <option value="EC" {{ old('nationalite', $formateur->nationalite) == 'EC' ? 'selected' : '' }}>🇪🇨 Équateur</option>
                <option value="ER" {{ old('nationalite', $formateur->nationalite) == 'ER' ? 'selected' : '' }}>🇪🇷 Érythrée</option>
                <option value="ES" {{ old('nationalite', $formateur->nationalite) == 'ES' ? 'selected' : '' }}>🇪🇸 Espagne</option>
                <option value="EE" {{ old('nationalite', $formateur->nationalite) == 'EE' ? 'selected' : '' }}>🇪🇪 Estonie</option>
                <option value="SZ" {{ old('nationalite', $formateur->nationalite) == 'SZ' ? 'selected' : '' }}>🇸🇿 Eswatini</option>
                <option value="US" {{ old('nationalite', $formateur->nationalite) == 'US' ? 'selected' : '' }}>🇺🇸 États-Unis</option>
                <option value="ET" {{ old('nationalite', $formateur->nationalite) == 'ET' ? 'selected' : '' }}>🇪🇹 Éthiopie</option>
                <option value="FJ" {{ old('nationalite', $formateur->nationalite) == 'FJ' ? 'selected' : '' }}>🇫🇯 Fidji</option>
                <option value="FI" {{ old('nationalite', $formateur->nationalite) == 'FI' ? 'selected' : '' }}>🇫🇮 Finlande</option>
                <option value="FR" {{ old('nationalite', $formateur->nationalite) == 'FR' ? 'selected' : '' }}>🇫🇷 France</option>
                <option value="GA" {{ old('nationalite', $formateur->nationalite) == 'GA' ? 'selected' : '' }}>🇬🇦 Gabon</option>
                <option value="GM" {{ old('nationalite', $formateur->nationalite) == 'GM' ? 'selected' : '' }}>🇬🇲 Gambie</option>
                <option value="GE" {{ old('nationalite', $formateur->nationalite) == 'GE' ? 'selected' : '' }}>🇬🇪 Géorgie</option>
                <option value="GH" {{ old('nationalite', $formateur->nationalite) == 'GH' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                <option value="GR" {{ old('nationalite', $formateur->nationalite) == 'GR' ? 'selected' : '' }}>🇬🇷 Grèce</option>
                <option value="GD" {{ old('nationalite', $formateur->nationalite) == 'GD' ? 'selected' : '' }}>🇬🇩 Grenade</option>
                <option value="GT" {{ old('nationalite', $formateur->nationalite) == 'GT' ? 'selected' : '' }}>🇬🇹 Guatemala</option>
                <option value="GN" {{ old('nationalite', $formateur->nationalite) == 'GN' ? 'selected' : '' }}>🇬🇳 Guinée</option>
                <option value="GW" {{ old('nationalite', $formateur->nationalite) == 'GW' ? 'selected' : '' }}>🇬🇼 Guinée-Bissau</option>
                <option value="GQ" {{ old('nationalite', $formateur->nationalite) == 'GQ' ? 'selected' : '' }}>🇬🇶 Guinée équatoriale</option>
                <option value="GY" {{ old('nationalite', $formateur->nationalite) == 'GY' ? 'selected' : '' }}>🇬🇾 Guyana</option>
                <option value="HT" {{ old('nationalite', $formateur->nationalite) == 'HT' ? 'selected' : '' }}>🇭🇹 Haïti</option>
                <option value="HN" {{ old('nationalite', $formateur->nationalite) == 'HN' ? 'selected' : '' }}>🇭🇳 Honduras</option>
                <option value="HU" {{ old('nationalite', $formateur->nationalite) == 'HU' ? 'selected' : '' }}>🇭🇺 Hongrie</option>
                <option value="IN" {{ old('nationalite', $formateur->nationalite) == 'IN' ? 'selected' : '' }}>🇮🇳 Inde</option>
                <option value="ID" {{ old('nationalite', $formateur->nationalite) == 'ID' ? 'selected' : '' }}>🇮🇩 Indonésie</option>
                <option value="IQ" {{ old('nationalite', $formateur->nationalite) == 'IQ' ? 'selected' : '' }}>🇮🇶 Irak</option>
                <option value="IR" {{ old('nationalite', $formateur->nationalite) == 'IR' ? 'selected' : '' }}>🇮🇷 Iran</option>
                <option value="IE" {{ old('nationalite', $formateur->nationalite) == 'IE' ? 'selected' : '' }}>🇮🇪 Irlande</option>
                <option value="IS" {{ old('nationalite', $formateur->nationalite) == 'IS' ? 'selected' : '' }}>🇮🇸 Islande</option>
                <option value="IL" {{ old('nationalite', $formateur->nationalite) == 'IL' ? 'selected' : '' }}>🇮🇱 Israël</option>
                <option value="IT" {{ old('nationalite', $formateur->nationalite) == 'IT' ? 'selected' : '' }}>🇮🇹 Italie</option>
                <option value="JM" {{ old('nationalite', $formateur->nationalite) == 'JM' ? 'selected' : '' }}>🇯🇲 Jamaïque</option>
                <option value="JP" {{ old('nationalite', $formateur->nationalite) == 'JP' ? 'selected' : '' }}>🇯🇵 Japon</option>
                <option value="JO" {{ old('nationalite', $formateur->nationalite) == 'JO' ? 'selected' : '' }}>🇯🇴 Jordanie</option>
                <option value="KZ" {{ old('nationalite', $formateur->nationalite) == 'KZ' ? 'selected' : '' }}>🇰🇿 Kazakhstan</option>
                <option value="KE" {{ old('nationalite', $formateur->nationalite) == 'KE' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                <option value="KG" {{ old('nationalite', $formateur->nationalite) == 'KG' ? 'selected' : '' }}>🇰🇬 Kirghizistan</option>
                <option value="KI" {{ old('nationalite', $formateur->nationalite) == 'KI' ? 'selected' : '' }}>🇰🇮 Kiribati</option>
                <option value="KW" {{ old('nationalite', $formateur->nationalite) == 'KW' ? 'selected' : '' }}>🇰🇼 Koweït</option>
                <option value="LA" {{ old('nationalite', $formateur->nationalite) == 'LA' ? 'selected' : '' }}>🇱🇦 Laos</option>
                <option value="LS" {{ old('nationalite', $formateur->nationalite) == 'LS' ? 'selected' : '' }}>🇱🇸 Lesotho</option>
                <option value="LV" {{ old('nationalite', $formateur->nationalite) == 'LV' ? 'selected' : '' }}>🇱🇻 Lettonie</option>
                <option value="LB" {{ old('nationalite', $formateur->nationalite) == 'LB' ? 'selected' : '' }}>🇱🇧 Liban</option>
                <option value="LR" {{ old('nationalite', $formateur->nationalite) == 'LR' ? 'selected' : '' }}>🇱🇷 Liberia</option>
                <option value="LY" {{ old('nationalite', $formateur->nationalite) == 'LY' ? 'selected' : '' }}>🇱🇾 Libye</option>
                <option value="LI" {{ old('nationalite', $formateur->nationalite) == 'LI' ? 'selected' : '' }}>🇱🇮 Liechtenstein</option>
                <option value="LT" {{ old('nationalite', $formateur->nationalite) == 'LT' ? 'selected' : '' }}>🇱🇹 Lituanie</option>
                <option value="LU" {{ old('nationalite', $formateur->nationalite) == 'LU' ? 'selected' : '' }}>🇱🇺 Luxembourg</option>
                <option value="MG" {{ old('nationalite', $formateur->nationalite) == 'MG' ? 'selected' : '' }}>🇲🇬 Madagascar</option>
                <option value="MW" {{ old('nationalite', $formateur->nationalite) == 'MW' ? 'selected' : '' }}>🇲🇼 Malawi</option>
                <option value="MY" {{ old('nationalite', $formateur->nationalite) == 'MY' ? 'selected' : '' }}>🇲🇾 Malaisie</option>
                <option value="MV" {{ old('nationalite', $formateur->nationalite) == 'MV' ? 'selected' : '' }}>🇲🇻 Maldives</option>
                <option value="ML" {{ old('nationalite', $formateur->nationalite) == 'ML' ? 'selected' : '' }}>🇲🇱 Mali</option>
                <option value="MT" {{ old('nationalite', $formateur->nationalite) == 'MT' ? 'selected' : '' }}>🇲🇹 Malte</option>
                <option value="MA" {{ old('nationalite', $formateur->nationalite) == 'MA' ? 'selected' : '' }}>🇲🇦 Maroc</option>
                <option value="MU" {{ old('nationalite', $formateur->nationalite) == 'MU' ? 'selected' : '' }}>🇲🇺 Maurice</option>
                <option value="MR" {{ old('nationalite', $formateur->nationalite) == 'MR' ? 'selected' : '' }}>🇲🇷 Mauritanie</option>
                <option value="MX" {{ old('nationalite', $formateur->nationalite) == 'MX' ? 'selected' : '' }}>🇲🇽 Mexique</option>
                <option value="MD" {{ old('nationalite', $formateur->nationalite) == 'MD' ? 'selected' : '' }}>🇲🇩 Moldavie</option>
                <option value="MC" {{ old('nationalite', $formateur->nationalite) == 'MC' ? 'selected' : '' }}>🇲🇨 Monaco</option>
                <option value="MN" {{ old('nationalite', $formateur->nationalite) == 'MN' ? 'selected' : '' }}>🇲🇳 Mongolie</option>
                <option value="ME" {{ old('nationalite', $formateur->nationalite) == 'ME' ? 'selected' : '' }}>🇲🇪 Monténégro</option>
                <option value="MZ" {{ old('nationalite', $formateur->nationalite) == 'MZ' ? 'selected' : '' }}>🇲🇿 Mozambique</option>
                <option value="NA" {{ old('nationalite', $formateur->nationalite) == 'NA' ? 'selected' : '' }}>🇳🇦 Namibie</option>
                <option value="NR" {{ old('nationalite', $formateur->nationalite) == 'NR' ? 'selected' : '' }}>🇳🇷 Nauru</option>
                <option value="NP" {{ old('nationalite', $formateur->nationalite) == 'NP' ? 'selected' : '' }}>🇳🇵 Népal</option>
                <option value="NI" {{ old('nationalite', $formateur->nationalite) == 'NI' ? 'selected' : '' }}>🇳🇮 Nicaragua</option>
                <option value="NE" {{ old('nationalite', $formateur->nationalite) == 'NE' ? 'selected' : '' }}>🇳🇪 Niger</option>
                <option value="NG" {{ old('nationalite', $formateur->nationalite) == 'NG' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                <option value="NO" {{ old('nationalite', $formateur->nationalite) == 'NO' ? 'selected' : '' }}>🇳🇴 Norvège</option>
                <option value="NZ" {{ old('nationalite', $formateur->nationalite) == 'NZ' ? 'selected' : '' }}>🇳🇿 Nouvelle-Zélande</option>
                <option value="OM" {{ old('nationalite', $formateur->nationalite) == 'OM' ? 'selected' : '' }}>🇴🇲 Oman</option>
                <option value="UG" {{ old('nationalite', $formateur->nationalite) == 'UG' ? 'selected' : '' }}>🇺🇬 Ouganda</option>
                <option value="UZ" {{ old('nationalite', $formateur->nationalite) == 'UZ' ? 'selected' : '' }}>🇺🇿 Ouzbékistan</option>
                <option value="PK" {{ old('nationalite', $formateur->nationalite) == 'PK' ? 'selected' : '' }}>🇵🇰 Pakistan</option>
                <option value="PW" {{ old('nationalite', $formateur->nationalite) == 'PW' ? 'selected' : '' }}>🇵🇼 Palaos</option>
                <option value="PA" {{ old('nationalite', $formateur->nationalite) == 'PA' ? 'selected' : '' }}>🇵🇦 Panama</option>
                <option value="PG" {{ old('nationalite', $formateur->nationalite) == 'PG' ? 'selected' : '' }}>🇵🇬 Papouasie-Nouvelle-Guinée</option>
                <option value="PY" {{ old('nationalite', $formateur->nationalite) == 'PY' ? 'selected' : '' }}>🇵🇾 Paraguay</option>
                <option value="NL" {{ old('nationalite', $formateur->nationalite) == 'NL' ? 'selected' : '' }}>🇳🇱 Pays-Bas</option>
                <option value="PE" {{ old('nationalite', $formateur->nationalite) == 'PE' ? 'selected' : '' }}>🇵🇪 Pérou</option>
                <option value="PH" {{ old('nationalite', $formateur->nationalite) == 'PH' ? 'selected' : '' }}>🇵🇭 Philippines</option>
                <option value="PL" {{ old('nationalite', $formateur->nationalite) == 'PL' ? 'selected' : '' }}>🇵🇱 Pologne</option>
                <option value="PT" {{ old('nationalite', $formateur->nationalite) == 'PT' ? 'selected' : '' }}>🇵🇹 Portugal</option>
                <option value="QA" {{ old('nationalite', $formateur->nationalite) == 'QA' ? 'selected' : '' }}>🇶🇦 Qatar</option>
                <option value="RO" {{ old('nationalite', $formateur->nationalite) == 'RO' ? 'selected' : '' }}>🇷🇴 Roumanie</option>
                <option value="GB" {{ old('nationalite', $formateur->nationalite) == 'GB' ? 'selected' : '' }}>🇬🇧 Royaume-Uni</option>
                <option value="RU" {{ old('nationalite', $formateur->nationalite) == 'RU' ? 'selected' : '' }}>🇷🇺 Russie</option>
                <option value="RW" {{ old('nationalite', $formateur->nationalite) == 'RW' ? 'selected' : '' }}>🇷🇼 Rwanda</option>
                <option value="KN" {{ old('nationalite', $formateur->nationalite) == 'KN' ? 'selected' : '' }}>🇰🇳 Saint-Kitts-et-Nevis</option>
                <option value="LC" {{ old('nationalite', $formateur->nationalite) == 'LC' ? 'selected' : '' }}>🇱🇨 Sainte-Lucie</option>
                <option value="VC" {{ old('nationalite', $formateur->nationalite) == 'VC' ? 'selected' : '' }}>🇻🇨 Saint-Vincent-et-les-Grenadines</option>
                <option value="SM" {{ old('nationalite', $formateur->nationalite) == 'SM' ? 'selected' : '' }}>🇸🇲 Saint-Marin</option>
                <option value="ST" {{ old('nationalite', $formateur->nationalite) == 'ST' ? 'selected' : '' }}>🇸🇹 Sao Tomé-et-Principe</option>
                <option value="SN" {{ old('nationalite', $formateur->nationalite) == 'SN' ? 'selected' : '' }}>🇸🇳 Sénégal</option>
                <option value="RS" {{ old('nationalite', $formateur->nationalite) == 'RS' ? 'selected' : '' }}>🇷🇸 Serbie</option>
                <option value="SC" {{ old('nationalite', $formateur->nationalite) == 'SC' ? 'selected' : '' }}>🇸🇨 Seychelles</option>
                <option value="SL" {{ old('nationalite', $formateur->nationalite) == 'SL' ? 'selected' : '' }}>🇸🇱 Sierra Leone</option>
                <option value="SG" {{ old('nationalite', $formateur->nationalite) == 'SG' ? 'selected' : '' }}>🇸🇬 Singapour</option>
                <option value="SK" {{ old('nationalite', $formateur->nationalite) == 'SK' ? 'selected' : '' }}>🇸🇰 Slovaquie</option>
                <option value="SI" {{ old('nationalite', $formateur->nationalite) == 'SI' ? 'selected' : '' }}>🇸🇮 Slovénie</option>
                <option value="SO" {{ old('nationalite', $formateur->nationalite) == 'SO' ? 'selected' : '' }}>🇸🇴 Somalie</option>
                <option value="SD" {{ old('nationalite', $formateur->nationalite) == 'SD' ? 'selected' : '' }}>🇸🇩 Soudan</option>
                <option value="SS" {{ old('nationalite', $formateur->nationalite) == 'SS' ? 'selected' : '' }}>🇸🇸 Soudan du Sud</option>
                <option value="LK" {{ old('nationalite', $formateur->nationalite) == 'LK' ? 'selected' : '' }}>🇱🇰 Sri Lanka</option>
                <option value="SE" {{ old('nationalite', $formateur->nationalite) == 'SE' ? 'selected' : '' }}>🇸🇪 Suède</option>
                <option value="CH" {{ old('nationalite', $formateur->nationalite) == 'CH' ? 'selected' : '' }}>🇨🇭 Suisse</option>
                <option value="SR" {{ old('nationalite', $formateur->nationalite) == 'SR' ? 'selected' : '' }}>🇸🇷 Suriname</option>
                <option value="SY" {{ old('nationalite', $formateur->nationalite) == 'SY' ? 'selected' : '' }}>🇸🇾 Syrie</option>
                <option value="TJ" {{ old('nationalite', $formateur->nationalite) == 'TJ' ? 'selected' : '' }}>🇹🇯 Tadjikistan</option>
                <option value="TW" {{ old('nationalite', $formateur->nationalite) == 'TW' ? 'selected' : '' }}>🇹🇼 Taïwan</option>
                <option value="TZ" {{ old('nationalite', $formateur->nationalite) == 'TZ' ? 'selected' : '' }}>🇹🇿 Tanzanie</option>
                <option value="TD" {{ old('nationalite', $formateur->nationalite) == 'TD' ? 'selected' : '' }}>🇹🇩 Tchad</option>
                <option value="CZ" {{ old('nationalite', $formateur->nationalite) == 'CZ' ? 'selected' : '' }}>🇨🇿 République tchèque</option>
                <option value="TH" {{ old('nationalite', $formateur->nationalite) == 'TH' ? 'selected' : '' }}>🇹🇭 Thaïlande</option>
                <option value="TL" {{ old('nationalite', $formateur->nationalite) == 'TL' ? 'selected' : '' }}>🇹🇱 Timor oriental</option>
                <option value="TG" {{ old('nationalite', $formateur->nationalite) == 'TG' ? 'selected' : '' }}>🇹🇬 Togo</option>
                <option value="TO" {{ old('nationalite', $formateur->nationalite) == 'TO' ? 'selected' : '' }}>🇹🇴 Tonga</option>
                <option value="TT" {{ old('nationalite', $formateur->nationalite) == 'TT' ? 'selected' : '' }}>🇹🇹 Trinité-et-Tobago</option>
                <option value="TN" {{ old('nationalite', $formateur->nationalite) == 'TN' ? 'selected' : '' }}>🇹🇳 Tunisie</option>
                <option value="TM" {{ old('nationalite', $formateur->nationalite) == 'TM' ? 'selected' : '' }}>🇹🇲 Turkménistan</option>
                <option value="TR" {{ old('nationalite', $formateur->nationalite) == 'TR' ? 'selected' : '' }}>🇹🇷 Turquie</option>
                <option value="TV" {{ old('nationalite', $formateur->nationalite) == 'TV' ? 'selected' : '' }}>🇹🇻 Tuvalu</option>
                <option value="UA" {{ old('nationalite', $formateur->nationalite) == 'UA' ? 'selected' : '' }}>🇺🇦 Ukraine</option>
                <option value="UY" {{ old('nationalite', $formateur->nationalite) == 'UY' ? 'selected' : '' }}>🇺🇾 Uruguay</option>
                <option value="VU" {{ old('nationalite', $formateur->nationalite) == 'VU' ? 'selected' : '' }}>🇻🇺 Vanuatu</option>
                <option value="VA" {{ old('nationalite', $formateur->nationalite) == 'VA' ? 'selected' : '' }}>🇻🇦 Vatican</option>
                <option value="VE" {{ old('nationalite', $formateur->nationalite) == 'VE' ? 'selected' : '' }}>🇻🇪 Venezuela</option>
                <option value="VN" {{ old('nationalite', $formateur->nationalite) == 'VN' ? 'selected' : '' }}>🇻🇳 Viêt Nam</option>
                <option value="YE" {{ old('nationalite', $formateur->nationalite) == 'YE' ? 'selected' : '' }}>🇾🇪 Yémen</option>
                <option value="ZM" {{ old('nationalite', $formateur->nationalite) == 'ZM' ? 'selected' : '' }}>🇿🇲 Zambie</option>
                <option value="ZW" {{ old('nationalite', $formateur->nationalite) == 'ZW' ? 'selected' : '' }}>🇿🇼 Zimbabwe</option>
              </select>
              @error('nationalite')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Spécialité</label>
              <select name="filiere" class="form-control @error('filiere') is-invalid @enderror">
                <option value="">-- Sélectionner une spécialité --</option>
                @foreach($filieres as $filiere)
                  <option value="{{ $filiere }}" {{ old('filiere', $formateur->filiere) == $filiere ? 'selected' : '' }}>
                    {{ $filiere }}
                  </option>
                @endforeach
              </select>
              @error('filiere')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Niveau d'étude assigné</label>
              <select name="classe_id" class="form-control @error('classe_id') is-invalid @enderror">
                <option value="">-- Sélectionner un niveau d'étude --</option>
                <option value="licence_1" {{ old('classe_id', $formateur->classe_id) == 'licence_1' ? 'selected' : '' }}>Licence 1</option>
                <option value="licence_2" {{ old('classe_id', $formateur->classe_id) == 'licence_2' ? 'selected' : '' }}>Licence 2</option>
                <option value="licence_3" {{ old('classe_id', $formateur->classe_id) == 'licence_3' ? 'selected' : '' }}>Licence 3</option>
                <option value="master_1" {{ old('classe_id', $formateur->classe_id) == 'master_1' ? 'selected' : '' }}>Master 1</option>
                <option value="master_2" {{ old('classe_id', $formateur->classe_id) == 'master_2' ? 'selected' : '' }}>Master 2</option>
              </select>
              @error('classe_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Matières enseignées</label>
              <select name="matieres[]" id="choices-matieres" class="form-control @error('matieres') is-invalid @enderror" multiple>
                @php
                  // Récupérer les IDs des matières déjà assignées au formateur
                  $matieresFormateurIds = $formateur->matieres->pluck('id')->toArray();
                  
                  // Si le formateur a une classe, charger les matières filtrées
                  if ($formateur->classe_id) {
                    $niveauMap = [
                      'licence_1' => 'Licence 1',
                      'licence_2' => 'Licence 2',
                      'licence_3' => 'Licence 3',
                      'master_1' => 'Master 1',
                      'master_2' => 'Master 2',
                    ];
                    $niveauEtude = $niveauMap[$formateur->classe_id] ?? null;
                    
                    // Charger les matières filtrées par classe et filière
                    $query = \App\Models\Matiere::query();
                    if ($niveauEtude) {
                      $query->where('niveau_etude', $niveauEtude);
                    }
                    if ($formateur->filiere) {
                      $query->where('filiere', $formateur->filiere);
                    }
                    $matieresFiltered = $query->orderBy('nom_matiere')->get();
                  } else {
                    $matieresFiltered = collect();
                  }
                @endphp
                @if($formateur->classe_id && $matieresFiltered->isNotEmpty())
                  @foreach($matieresFiltered as $matiere)
                    <option value="{{ $matiere->id }}" {{ in_array($matiere->id, $matieresFormateurIds) ? 'selected' : '' }}>
                      {{ $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? 'Matière #' . $matiere->id }}
                    </option>
                  @endforeach
                  {{-- Ajouter aussi TOUTES les matières du formateur (même si elles ne sont pas dans la liste filtrée) --}}
                  @foreach($formateur->matieres as $matiereFormateur)
                    @if(!$matieresFiltered->contains('id', $matiereFormateur->id))
                      <option value="{{ $matiereFormateur->id }}" selected>
                        {{ $matiereFormateur->nom_matiere ?? $matiereFormateur->nom ?? $matiereFormateur->libelle ?? 'Matière #' . $matiereFormateur->id }}
                      </option>
                    @endif
                  @endforeach
                @else
                  {{-- Si pas de classe, afficher quand même TOUTES les matières du formateur --}}
                  @foreach($formateur->matieres as $matiere)
                    <option value="{{ $matiere->id }}" selected>
                    {{ $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? 'Matière #' . $matiere->id }}
                  </option>
                @endforeach
                  @if($formateur->matieres->isEmpty())
                    <option value="">Sélectionnez d'abord une classe</option>
                  @endif
                @endif
              </select>
              <small class="text-muted">Sélectionnez d'abord une classe pour voir les matières disponibles. Utilisez la barre de recherche pour filtrer.</small>
              @error('matieres')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Statut</label>
              <select name="statut" class="form-control @error('statut') is-invalid @enderror">
                <option value="actif" {{ old('statut', $formateur->statut) === 'actif' ? 'selected' : '' }}>Actif</option>
                <option value="bloque" {{ old('statut', $formateur->statut) === 'bloque' ? 'selected' : '' }}>Bloqué</option>
                <option value="inactif" {{ old('statut', $formateur->statut) === 'inactif' ? 'selected' : '' }}>Inactif</option>
              </select>
              @error('statut')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Photo</label>
              @if($formateur->photo)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $formateur->photo) }}" class="avatar avatar-lg rounded-circle" alt="Photo actuelle">
                </div>
              @endif
              <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
              @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.formateurs.show', $formateur) }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  let choicesMatieresInstance = null;
  let selectedMatieresIds = [];
  // Flag pour empêcher loadMatieres() d'être appelée automatiquement au chargement initial
  let isInitialLoad = true;
  
  document.addEventListener('DOMContentLoaded', function() {
    
    const classeSelect = document.querySelector('select[name="classe_id"]');
    const matieresSelect = document.getElementById('choices-matieres');
    
    // Sauvegarder les matières déjà sélectionnées AVANT l'initialisation de Choices.js
    if (matieresSelect) {
      const selectedOptions = Array.from(matieresSelect.selectedOptions);
      selectedMatieresIds = selectedOptions.map(option => option.value).filter(v => v);
      console.log('🔍 [DEBUG] Matières sélectionnées détectées dans le HTML:', selectedMatieresIds);
      console.log('🔍 [DEBUG] Nombre d\'options sélectionnées:', selectedOptions.length);
      console.log('🔍 [DEBUG] Toutes les options dans le select:', Array.from(matieresSelect.options).map(opt => ({value: opt.value, text: opt.text, selected: opt.selected})));
    }
    
    // Initialiser Choices.js pour les matières
    // Choices.js préserve automatiquement les options avec l'attribut 'selected'
    if (matieresSelect) {
      // S'assurer que les matières sélectionnées sont bien présentes dans le select avant l'initialisation
      // Choices.js préserve automatiquement les valeurs sélectionnées lors de l'initialisation
      // Vérifier s'il y a des options sélectionnées avant d'initialiser Choices.js
      const hasSelectedOptions = matieresSelect.querySelectorAll('option[selected]').length > 0;
      console.log('🔍 [DEBUG] Options avec attribut selected:', hasSelectedOptions);
      console.log('🔍 [DEBUG] Initialisation de Choices.js...');
      
      choicesMatieresInstance = new Choices(matieresSelect, {
        removeItemButton: true,
        searchEnabled: true,
        searchChoices: true,
        searchPlaceholderValue: 'Rechercher une matière...',
        placeholder: !hasSelectedOptions,
        placeholderValue: hasSelectedOptions ? '' : 'Sélectionnez d\'abord une classe',
        noChoicesText: 'Veuillez choisir la classe d\'abord',
        noResultsText: 'Aucun résultat trouvé',
        maxItemCount: -1,
        shouldSort: true,
        searchFields: ['label', 'value']
      });
      
      console.log('🔍 [DEBUG] Choices.js initialisé');
      console.log('🔍 [DEBUG] Valeurs immédiatement après initialisation:', choicesMatieresInstance.getValue(true));
      
      // Vérifier immédiatement après l'initialisation et restaurer les valeurs
      // Choices.js devrait préserver les valeurs avec 'selected', mais on force la restauration
      if (selectedMatieresIds.length > 0) {
        console.log('🔍 [DEBUG] Tentative de restauration des matières:', selectedMatieresIds);
        // Utiliser plusieurs tentatives avec des délais différents pour s'assurer que ça fonctionne
        [100, 300, 500].forEach(delay => {
          setTimeout(() => {
            const currentValues = choicesMatieresInstance.getValue(true) || [];
            const currentValuesStr = currentValues.map(v => String(v));
            console.log(`🔍 [DEBUG] Après ${delay}ms - Valeurs actuelles:`, currentValues);
            
            selectedMatieresIds.forEach(id => {
              if (id) {
                const idStr = String(id);
                const idNum = parseInt(id);
                const isPresent = currentValuesStr.includes(idStr) || 
                                 currentValues.includes(idNum) || 
                                 currentValues.includes(id);
                
                console.log(`🔍 [DEBUG] Matière ${id} présente?`, isPresent);
                
                if (!isPresent) {
                  console.log(`🔍 [DEBUG] Tentative de restauration de la matière ${id}...`);
                  try {
                    choicesMatieresInstance.setChoiceByValue(idStr);
                    console.log(`✅ [DEBUG] Matière ${id} restaurée avec succès (string)`);
                  } catch (e) {
                    console.log(`❌ [DEBUG] Erreur avec string pour ${id}:`, e.message);
                    try {
                      choicesMatieresInstance.setChoiceByValue(idNum);
                      console.log(`✅ [DEBUG] Matière ${id} restaurée avec succès (number)`);
                    } catch (e2) {
                      console.log(`❌ [DEBUG] Erreur avec number pour ${id}:`, e2.message);
                      try {
                        choicesMatieresInstance.setChoiceByValue(id);
                        console.log(`✅ [DEBUG] Matière ${id} restaurée avec succès (direct)`);
                      } catch (e3) {
                        console.error(`❌ [DEBUG] Impossible de restaurer la matière ${id}:`, e3);
                      }
                    }
                  }
                }
              }
            });
            
            // Vérifier les valeurs finales
            const finalValues = choicesMatieresInstance.getValue(true) || [];
            console.log(`🔍 [DEBUG] Valeurs finales après ${delay}ms:`, finalValues);
          }, delay);
        });
      } else {
        console.log('⚠️ [DEBUG] Aucune matière sélectionnée à restaurer');
      }
    }
    
    // Fonction pour charger les matières basée sur la classe et la filière
    function loadMatieres() {
      console.log('🔄 [DEBUG] loadMatieres() appelée');
      const classeSelect = document.querySelector('select[name="classe_id"]');
      const filiereSelect = document.querySelector('select[name="filiere"]');
      const selectedLicence = classeSelect ? classeSelect.value : '';
      const selectedFiliere = filiereSelect ? filiereSelect.value : '';
      
      console.log('🔄 [DEBUG] Licence sélectionnée:', selectedLicence);
      console.log('🔄 [DEBUG] Filière sélectionnée:', selectedFiliere);
      console.log('🔄 [DEBUG] Valeurs actuelles dans Choices.js avant loadMatieres:', choicesMatieresInstance ? choicesMatieresInstance.getValue(true) : 'Choices.js non initialisé');
      
      // Si une filière est sélectionnée mais pas de classe, on peut quand même charger les matières
      // mais on préfère avoir les deux pour un filtrage précis
      if (!selectedFiliere) {
        console.log('⚠️ [DEBUG] Aucune filière sélectionnée - vidage des matières');
        // Si aucune filière n'est sélectionnée, vider les matières
        if (choicesMatieresInstance) {
          choicesMatieresInstance.clearStore();
          choicesMatieresInstance.setChoices([{ value: '', label: 'Sélectionnez d\'abord une spécialité', disabled: true }], 'value', 'label', false);
          console.log('⚠️ [DEBUG] Matières vidées car pas de filière');
        }
        return;
      }
      
      // Si une filière est sélectionnée mais pas de classe, afficher un message
      if (!selectedLicence) {
        console.log('⚠️ [DEBUG] Aucune classe sélectionnée - vidage des matières');
        if (choicesMatieresInstance) {
          choicesMatieresInstance.clearStore();
          choicesMatieresInstance.setChoices([{ value: '', label: 'Sélectionnez aussi une classe pour voir les matières', disabled: true }], 'value', 'label', false);
          console.log('⚠️ [DEBUG] Matières vidées car pas de classe');
        }
        return;
      }
      
      // Afficher un indicateur de chargement
      if (choicesMatieresInstance) {
        const currentValues = choicesMatieresInstance.getValue(true);
        console.log('🔄 [DEBUG] Valeurs actuelles avant clearStore:', currentValues);
        console.log('🔄 [DEBUG] Sauvegarde des valeurs dans selectedMatieresIds:', currentValues);
        choicesMatieresInstance.clearStore();
        choicesMatieresInstance.setChoices([{ value: '', label: 'Chargement...', disabled: true }], 'value', 'label', false);
        selectedMatieresIds = currentValues || [];
        console.log('🔄 [DEBUG] selectedMatieresIds sauvegardé:', selectedMatieresIds);
      }
      
      // Construire l'URL avec les paramètres
      let url = '{{ route("admin.formateurs.matieres-by-licence") }}?licence=' + encodeURIComponent(selectedLicence);
      if (selectedFiliere) {
        url += '&filiere=' + encodeURIComponent(selectedFiliere);
      }
      
      console.log('🔄 [DEBUG] Appel API:', url);
      
      // Récupérer les matières via l'API sécurisée
      fetch(url, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
      })
      .then(response => {
        console.log('🔄 [DEBUG] Réponse API reçue:', response.status, response.statusText);
        if (!response.ok) {
          return response.json().then(err => {
            throw new Error(err.error || err.message || 'Erreur lors de la récupération des matières');
          });
        }
        return response.json();
      })
      .then(data => {
        console.log('🔄 [DEBUG] Données reçues de l\'API:', data);
        if (data.success && Array.isArray(data.matieres)) {
          // Préparer les options pour Choices.js
          const choices = data.matieres.map(matiere => ({
            value: matiere.id.toString(),
            label: matiere.nom_matiere || matiere.nom || 'Matière #' + matiere.id
          }));
          
          console.log('🔄 [DEBUG] Choices préparés:', choices);
          console.log('🔄 [DEBUG] selectedMatieresIds à restaurer:', selectedMatieresIds);
          
          // Mettre à jour les options dans Choices.js
          if (choicesMatieresInstance) {
            choicesMatieresInstance.clearStore();
            if (choices.length > 0) {
              choicesMatieresInstance.setChoices(choices, 'value', 'label', false);
              console.log('🔄 [DEBUG] Choices.js mis à jour avec', choices.length, 'matières');
              
              // Restaurer les matières sélectionnées qui sont toujours valides
              setTimeout(() => {
                console.log('🔄 [DEBUG] Tentative de restauration des matières sauvegardées...');
                let restoredCount = 0;
                selectedMatieresIds.forEach(id => {
                  if (id && choices.some(c => c.value === id.toString())) {
                    try {
                      choicesMatieresInstance.setChoiceByValue(id);
                      restoredCount++;
                      console.log(`✅ [DEBUG] Matière ${id} restaurée`);
                    } catch (e) {
                      console.error(`❌ [DEBUG] Erreur lors de la restauration de ${id}:`, e);
                    }
                  } else {
                    console.log(`⚠️ [DEBUG] Matière ${id} non trouvée dans les choices disponibles`);
                  }
                });
                console.log(`🔄 [DEBUG] ${restoredCount} matières restaurées sur ${selectedMatieresIds.length}`);
                console.log('🔄 [DEBUG] Valeurs finales après restauration:', choicesMatieresInstance.getValue(true));
              }, 100);
            } else {
              console.log('⚠️ [DEBUG] Aucune matière disponible');
              choicesMatieresInstance.setChoices([{ value: '', label: 'Aucune matière disponible pour cette licence et spécialité', disabled: true }], 'value', 'label', false);
            }
          }
        } else {
          console.error('❌ [DEBUG] Format de réponse invalide:', data);
          throw new Error(data.error || 'Réponse invalide du serveur');
        }
      })
      .catch(error => {
        console.error('❌ [DEBUG] Erreur détaillée:', error);
        console.error('❌ [DEBUG] Message:', error.message);
        if (choicesMatieresInstance) {
          choicesMatieresInstance.clearStore();
          choicesMatieresInstance.setChoices([{ value: '', label: 'Erreur: ' + (error.message || 'Erreur lors du chargement des matières'), disabled: true }], 'value', 'label', false);
        }
      });
    }
    
    // Fonction pour filtrer les classes disponibles selon la spécialité
    function filterClassesByFiliere() {
      const filiereSelect = document.querySelector('select[name="filiere"]');
      const classeSelect = document.querySelector('select[name="classe_id"]');
      const selectedFiliere = filiereSelect ? filiereSelect.value : '';
      
      if (!selectedFiliere) {
        // Si aucune spécialité n'est sélectionnée, afficher toutes les classes
        if (classeSelect) {
          const currentValue = classeSelect.value;
          classeSelect.innerHTML = '<option value="">-- Sélectionner une classe --</option>';
          const allLicences = [
            { value: 'licence_1', label: 'Licence 1' },
            { value: 'licence_2', label: 'Licence 2' },
            { value: 'licence_3', label: 'Licence 3' }
          ];
          allLicences.forEach(licence => {
            const option = document.createElement('option');
            option.value = licence.value;
            option.textContent = licence.label;
            if (currentValue === licence.value) {
              option.selected = true;
            }
            classeSelect.appendChild(option);
          });
        }
        return;
      }
      
      // Récupérer les licences disponibles pour cette filière
      fetch('{{ route("admin.formateurs.licences-by-filiere") }}?filiere=' + encodeURIComponent(selectedFiliere), {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
      })
      .then(response => response.json())
      .then(data => {
        if (data.success && Array.isArray(data.licences)) {
          if (classeSelect) {
            const currentValue = classeSelect.value;
            classeSelect.innerHTML = '<option value="">-- Sélectionner une classe --</option>';
            
            data.licences.forEach(licence => {
              const option = document.createElement('option');
              option.value = licence.value;
              option.textContent = licence.label;
              if (currentValue === licence.value) {
                option.selected = true;
              }
              classeSelect.appendChild(option);
            });
            
            // Si la classe actuelle n'est plus disponible, vider et recharger les matières
            // MAIS seulement si ce n'est pas le chargement initial (pour préserver les matières existantes)
            if (!isInitialLoad) {
              if (currentValue && !data.licences.some(l => l.value === currentValue)) {
                classeSelect.value = '';
                loadMatieres();
              } else if (currentValue) {
                loadMatieres();
              }
            } else {
              console.log('🔍 [DEBUG] filterClassesByFiliere() - Appel de loadMatieres() ignoré (chargement initial)');
            }
          }
        }
      })
      .catch(error => {
        console.error('Erreur lors du filtrage des classes:', error);
      });
    }
    
    // Fonction pour filtrer les spécialités disponibles selon la classe
    function filterFilieresByLicence() {
      const classeSelect = document.querySelector('select[name="classe_id"]');
      const filiereSelect = document.querySelector('select[name="filiere"]');
      const selectedLicence = classeSelect ? classeSelect.value : '';
      
      if (!selectedLicence) {
        // Si aucune classe n'est sélectionnée, afficher toutes les filières
        if (filiereSelect) {
          const currentValue = filiereSelect.value;
          filiereSelect.innerHTML = '<option value="">-- Sélectionner une spécialité --</option>';
          const allFilieres = @json($filieres);
          allFilieres.forEach(filiere => {
            const option = document.createElement('option');
            option.value = filiere;
            option.textContent = filiere;
            if (currentValue === filiere) {
              option.selected = true;
            }
            filiereSelect.appendChild(option);
          });
        }
        return;
      }
      
      // Récupérer les filières disponibles pour cette licence
      fetch('{{ route("admin.formateurs.filieres-by-licence") }}?licence=' + encodeURIComponent(selectedLicence), {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
      })
      .then(response => response.json())
      .then(data => {
        if (data.success && Array.isArray(data.filieres)) {
          if (filiereSelect) {
            const currentValue = filiereSelect.value;
            filiereSelect.innerHTML = '<option value="">-- Sélectionner une spécialité --</option>';
            
            data.filieres.forEach(filiere => {
              const option = document.createElement('option');
              option.value = filiere;
              option.textContent = filiere;
              if (currentValue === filiere) {
                option.selected = true;
              }
              filiereSelect.appendChild(option);
            });
            
            // Si la spécialité actuelle n'est plus disponible, vider et recharger les matières
            // MAIS seulement si ce n'est pas le chargement initial (pour préserver les matières existantes)
            if (!isInitialLoad) {
              if (currentValue && !data.filieres.includes(currentValue)) {
                filiereSelect.value = '';
                loadMatieres();
              } else if (currentValue) {
                loadMatieres();
              }
            } else {
              console.log('🔍 [DEBUG] filterFilieresByLicence() - Appel de loadMatieres() ignoré (chargement initial)');
            }
          }
        }
      })
      .catch(error => {
        console.error('Erreur lors du filtrage des spécialités:', error);
      });
    }
    
    // Écouter les changements sur le champ "Niveau d'étude assigné"
    if (classeSelect) {
      classeSelect.addEventListener('change', function() {
        filterFilieresByLicence();
        // Charger les matières seulement si une filière est aussi sélectionnée
        const filiereSelect = document.querySelector('select[name="filiere"]');
        if (filiereSelect && filiereSelect.value) {
          loadMatieres();
        }
      });
    }
    
    // Écouter les changements sur le champ "Spécialité"
    const filiereSelect = document.querySelector('select[name="filiere"]');
    if (filiereSelect) {
      filiereSelect.addEventListener('change', function() {
        filterClassesByFiliere();
        // Charger les matières si une classe est aussi sélectionnée
        if (classeSelect && classeSelect.value) {
          loadMatieres();
        }
      });
    }
    
    // Déclencher le chargement initial si des valeurs sont déjà sélectionnées
    // MAIS ne pas appeler loadMatieres() pendant le chargement initial
    console.log('🔍 [DEBUG] DOMContentLoaded - Chargement initial des filtres...');
    if (classeSelect && classeSelect.value) {
      console.log('🔍 [DEBUG] Appel de filterFilieresByLicence() (chargement initial)');
      filterFilieresByLicence();
    }
    if (filiereSelect && filiereSelect.value) {
      console.log('🔍 [DEBUG] Appel de filterClassesByFiliere() (chargement initial)');
      filterClassesByFiliere();
    }
    
    console.log('🔍 [DEBUG] DOMContentLoaded terminé');
    console.log('🔍 [DEBUG] Classe sélectionnée:', classeSelect ? classeSelect.value : 'N/A');
    console.log('🔍 [DEBUG] Filière sélectionnée:', filiereSelect ? filiereSelect.value : 'N/A');
    console.log('🔍 [DEBUG] Matières dans le HTML:', matieresSelect ? Array.from(matieresSelect.options).filter(opt => opt.selected).map(opt => ({value: opt.value, text: opt.text})) : 'N/A');
    
    // Marquer la fin du chargement initial après un court délai
    // pour permettre aux filtres de se charger sans déclencher loadMatieres()
    setTimeout(() => {
      isInitialLoad = false;
      console.log('🔍 [DEBUG] Chargement initial terminé - Les changements utilisateur déclencheront maintenant loadMatieres()');
    }, 1000);
  });
</script>
@endpush
