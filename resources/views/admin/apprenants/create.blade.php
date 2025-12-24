@extends('layouts.admin')

@section('title', 'Nouvel Apprenant')
@section('breadcrumb', 'Nouvel Apprenant')
@section('page-title', 'Créer un Nouvel Apprenant')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Informations de l'Apprenant</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.apprenants.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nom <span class="text-danger">*</span></label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" required>
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Prénom <span class="text-danger">*</span></label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" required>
              @error('prenom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="8">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date de naissance</label>
              <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}">
              @error('date_naissance')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Filière</label>
              <select name="filiere" id="filiere-select" class="form-control @error('filiere') is-invalid @enderror">
                <option value="">-- Sélectionner une filière --</option>
                @foreach($filieres as $filiere)
                  <option value="{{ $filiere }}" {{ old('filiere') == $filiere ? 'selected' : '' }}>
                    {{ $filiere }}
                  </option>
                @endforeach
              </select>
              @error('filiere')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Niveau d'étude</label>
              <select name="classe_id" id="classe-select" class="form-control @error('classe_id') is-invalid @enderror">
                <option value="">-- Sélectionner un niveau d'étude --</option>
                <option value="licence_1" {{ old('classe_id') == 'licence_1' ? 'selected' : '' }}>Licence 1</option>
                <option value="licence_2" {{ old('classe_id') == 'licence_2' ? 'selected' : '' }}>Licence 2</option>
                <option value="licence_3" {{ old('classe_id') == 'licence_3' ? 'selected' : '' }}>Licence 3</option>
                <option value="master_1" {{ old('classe_id') == 'master_1' ? 'selected' : '' }}>Master 1</option>
                <option value="master_2" {{ old('classe_id') == 'master_2' ? 'selected' : '' }}>Master 2</option>
              </select>
              @error('classe_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Téléphone</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Ex: +221 77 123 45 67">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Ville</label>
              <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="Ex: Dakar">
              @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Nationalité</label>
              <select name="nationalite" class="form-control @error('nationalite') is-invalid @enderror">
                <option value="">-- Sélectionner une nationalité --</option>
                <option value="AF" {{ old('nationalite') == 'AF' ? 'selected' : '' }}>🇦🇫 Afghanistan</option>
                <option value="ZA" {{ old('nationalite') == 'ZA' ? 'selected' : '' }}>🇿🇦 Afrique du Sud</option>
                <option value="AL" {{ old('nationalite') == 'AL' ? 'selected' : '' }}>🇦🇱 Albanie</option>
                <option value="DZ" {{ old('nationalite') == 'DZ' ? 'selected' : '' }}>🇩🇿 Algérie</option>
                <option value="DE" {{ old('nationalite') == 'DE' ? 'selected' : '' }}>🇩🇪 Allemagne</option>
                <option value="AD" {{ old('nationalite') == 'AD' ? 'selected' : '' }}>🇦🇩 Andorre</option>
                <option value="AO" {{ old('nationalite') == 'AO' ? 'selected' : '' }}>🇦🇴 Angola</option>
                <option value="AG" {{ old('nationalite') == 'AG' ? 'selected' : '' }}>🇦🇬 Antigua-et-Barbuda</option>
                <option value="SA" {{ old('nationalite') == 'SA' ? 'selected' : '' }}>🇸🇦 Arabie Saoudite</option>
                <option value="AR" {{ old('nationalite') == 'AR' ? 'selected' : '' }}>🇦🇷 Argentine</option>
                <option value="AM" {{ old('nationalite') == 'AM' ? 'selected' : '' }}>🇦🇲 Arménie</option>
                <option value="AU" {{ old('nationalite') == 'AU' ? 'selected' : '' }}>🇦🇺 Australie</option>
                <option value="AT" {{ old('nationalite') == 'AT' ? 'selected' : '' }}>🇦🇹 Autriche</option>
                <option value="AZ" {{ old('nationalite') == 'AZ' ? 'selected' : '' }}>🇦🇿 Azerbaïdjan</option>
                <option value="BS" {{ old('nationalite') == 'BS' ? 'selected' : '' }}>🇧🇸 Bahamas</option>
                <option value="BH" {{ old('nationalite') == 'BH' ? 'selected' : '' }}>🇧🇭 Bahreïn</option>
                <option value="BD" {{ old('nationalite') == 'BD' ? 'selected' : '' }}>🇧🇩 Bangladesh</option>
                <option value="BB" {{ old('nationalite') == 'BB' ? 'selected' : '' }}>🇧🇧 Barbade</option>
                <option value="BE" {{ old('nationalite') == 'BE' ? 'selected' : '' }}>🇧🇪 Belgique</option>
                <option value="BZ" {{ old('nationalite') == 'BZ' ? 'selected' : '' }}>🇧🇿 Belize</option>
                <option value="BJ" {{ old('nationalite') == 'BJ' ? 'selected' : '' }}>🇧🇯 Bénin</option>
                <option value="BT" {{ old('nationalite') == 'BT' ? 'selected' : '' }}>🇧🇹 Bhoutan</option>
                <option value="BY" {{ old('nationalite') == 'BY' ? 'selected' : '' }}>🇧🇾 Biélorussie</option>
                <option value="MM" {{ old('nationalite') == 'MM' ? 'selected' : '' }}>🇲🇲 Birmanie</option>
                <option value="BO" {{ old('nationalite') == 'BO' ? 'selected' : '' }}>🇧🇴 Bolivie</option>
                <option value="BA" {{ old('nationalite') == 'BA' ? 'selected' : '' }}>🇧🇦 Bosnie-Herzégovine</option>
                <option value="BW" {{ old('nationalite') == 'BW' ? 'selected' : '' }}>🇧🇼 Botswana</option>
                <option value="BR" {{ old('nationalite') == 'BR' ? 'selected' : '' }}>🇧🇷 Brésil</option>
                <option value="BN" {{ old('nationalite') == 'BN' ? 'selected' : '' }}>🇧🇳 Brunei</option>
                <option value="BG" {{ old('nationalite') == 'BG' ? 'selected' : '' }}>🇧🇬 Bulgarie</option>
                <option value="BF" {{ old('nationalite') == 'BF' ? 'selected' : '' }}>🇧🇫 Burkina Faso</option>
                <option value="BI" {{ old('nationalite') == 'BI' ? 'selected' : '' }}>🇧🇮 Burundi</option>
                <option value="KH" {{ old('nationalite') == 'KH' ? 'selected' : '' }}>🇰🇭 Cambodge</option>
                <option value="CM" {{ old('nationalite') == 'CM' ? 'selected' : '' }}>🇨🇲 Cameroun</option>
                <option value="CA" {{ old('nationalite') == 'CA' ? 'selected' : '' }}>🇨🇦 Canada</option>
                <option value="CV" {{ old('nationalite') == 'CV' ? 'selected' : '' }}>🇨🇻 Cap-Vert</option>
                <option value="CL" {{ old('nationalite') == 'CL' ? 'selected' : '' }}>🇨🇱 Chili</option>
                <option value="CN" {{ old('nationalite') == 'CN' ? 'selected' : '' }}>🇨🇳 Chine</option>
                <option value="CY" {{ old('nationalite') == 'CY' ? 'selected' : '' }}>🇨🇾 Chypre</option>
                <option value="CO" {{ old('nationalite') == 'CO' ? 'selected' : '' }}>🇨🇴 Colombie</option>
                <option value="KM" {{ old('nationalite') == 'KM' ? 'selected' : '' }}>🇰🇲 Comores</option>
                <option value="CG" {{ old('nationalite') == 'CG' ? 'selected' : '' }}>🇨🇬 Congo</option>
                <option value="CD" {{ old('nationalite') == 'CD' ? 'selected' : '' }}>🇨🇩 République démocratique du Congo</option>
                <option value="KR" {{ old('nationalite') == 'KR' ? 'selected' : '' }}>🇰🇷 Corée du Sud</option>
                <option value="KP" {{ old('nationalite') == 'KP' ? 'selected' : '' }}>🇰🇵 Corée du Nord</option>
                <option value="CR" {{ old('nationalite') == 'CR' ? 'selected' : '' }}>🇨🇷 Costa Rica</option>
                <option value="CI" {{ old('nationalite') == 'CI' ? 'selected' : '' }}>🇨🇮 Côte d'Ivoire</option>
                <option value="HR" {{ old('nationalite') == 'HR' ? 'selected' : '' }}>🇭🇷 Croatie</option>
                <option value="CU" {{ old('nationalite') == 'CU' ? 'selected' : '' }}>🇨🇺 Cuba</option>
                <option value="DK" {{ old('nationalite') == 'DK' ? 'selected' : '' }}>🇩🇰 Danemark</option>
                <option value="DJ" {{ old('nationalite') == 'DJ' ? 'selected' : '' }}>🇩🇯 Djibouti</option>
                <option value="DM" {{ old('nationalite') == 'DM' ? 'selected' : '' }}>🇩🇲 Dominique</option>
                <option value="EG" {{ old('nationalite') == 'EG' ? 'selected' : '' }}>🇪🇬 Égypte</option>
                <option value="AE" {{ old('nationalite') == 'AE' ? 'selected' : '' }}>🇦🇪 Émirats arabes unis</option>
                <option value="EC" {{ old('nationalite') == 'EC' ? 'selected' : '' }}>🇪🇨 Équateur</option>
                <option value="ER" {{ old('nationalite') == 'ER' ? 'selected' : '' }}>🇪🇷 Érythrée</option>
                <option value="ES" {{ old('nationalite') == 'ES' ? 'selected' : '' }}>🇪🇸 Espagne</option>
                <option value="EE" {{ old('nationalite') == 'EE' ? 'selected' : '' }}>🇪🇪 Estonie</option>
                <option value="SZ" {{ old('nationalite') == 'SZ' ? 'selected' : '' }}>🇸🇿 Eswatini</option>
                <option value="US" {{ old('nationalite') == 'US' ? 'selected' : '' }}>🇺🇸 États-Unis</option>
                <option value="ET" {{ old('nationalite') == 'ET' ? 'selected' : '' }}>🇪🇹 Éthiopie</option>
                <option value="FJ" {{ old('nationalite') == 'FJ' ? 'selected' : '' }}>🇫🇯 Fidji</option>
                <option value="FI" {{ old('nationalite') == 'FI' ? 'selected' : '' }}>🇫🇮 Finlande</option>
                <option value="FR" {{ old('nationalite') == 'FR' ? 'selected' : '' }}>🇫🇷 France</option>
                <option value="GA" {{ old('nationalite') == 'GA' ? 'selected' : '' }}>🇬🇦 Gabon</option>
                <option value="GM" {{ old('nationalite') == 'GM' ? 'selected' : '' }}>🇬🇲 Gambie</option>
                <option value="GE" {{ old('nationalite') == 'GE' ? 'selected' : '' }}>🇬🇪 Géorgie</option>
                <option value="GH" {{ old('nationalite') == 'GH' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                <option value="GR" {{ old('nationalite') == 'GR' ? 'selected' : '' }}>🇬🇷 Grèce</option>
                <option value="GD" {{ old('nationalite') == 'GD' ? 'selected' : '' }}>🇬🇩 Grenade</option>
                <option value="GT" {{ old('nationalite') == 'GT' ? 'selected' : '' }}>🇬🇹 Guatemala</option>
                <option value="GN" {{ old('nationalite') == 'GN' ? 'selected' : '' }}>🇬🇳 Guinée</option>
                <option value="GW" {{ old('nationalite') == 'GW' ? 'selected' : '' }}>🇬🇼 Guinée-Bissau</option>
                <option value="GQ" {{ old('nationalite') == 'GQ' ? 'selected' : '' }}>🇬🇶 Guinée équatoriale</option>
                <option value="GY" {{ old('nationalite') == 'GY' ? 'selected' : '' }}>🇬🇾 Guyana</option>
                <option value="HT" {{ old('nationalite') == 'HT' ? 'selected' : '' }}>🇭🇹 Haïti</option>
                <option value="HN" {{ old('nationalite') == 'HN' ? 'selected' : '' }}>🇭🇳 Honduras</option>
                <option value="HU" {{ old('nationalite') == 'HU' ? 'selected' : '' }}>🇭🇺 Hongrie</option>
                <option value="IN" {{ old('nationalite') == 'IN' ? 'selected' : '' }}>🇮🇳 Inde</option>
                <option value="ID" {{ old('nationalite') == 'ID' ? 'selected' : '' }}>🇮🇩 Indonésie</option>
                <option value="IQ" {{ old('nationalite') == 'IQ' ? 'selected' : '' }}>🇮🇶 Irak</option>
                <option value="IR" {{ old('nationalite') == 'IR' ? 'selected' : '' }}>🇮🇷 Iran</option>
                <option value="IE" {{ old('nationalite') == 'IE' ? 'selected' : '' }}>🇮🇪 Irlande</option>
                <option value="IS" {{ old('nationalite') == 'IS' ? 'selected' : '' }}>🇮🇸 Islande</option>
                <option value="IL" {{ old('nationalite') == 'IL' ? 'selected' : '' }}>🇮🇱 Israël</option>
                <option value="IT" {{ old('nationalite') == 'IT' ? 'selected' : '' }}>🇮🇹 Italie</option>
                <option value="JM" {{ old('nationalite') == 'JM' ? 'selected' : '' }}>🇯🇲 Jamaïque</option>
                <option value="JP" {{ old('nationalite') == 'JP' ? 'selected' : '' }}>🇯🇵 Japon</option>
                <option value="JO" {{ old('nationalite') == 'JO' ? 'selected' : '' }}>🇯🇴 Jordanie</option>
                <option value="KZ" {{ old('nationalite') == 'KZ' ? 'selected' : '' }}>🇰🇿 Kazakhstan</option>
                <option value="KE" {{ old('nationalite') == 'KE' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                <option value="KG" {{ old('nationalite') == 'KG' ? 'selected' : '' }}>🇰🇬 Kirghizistan</option>
                <option value="KI" {{ old('nationalite') == 'KI' ? 'selected' : '' }}>🇰🇮 Kiribati</option>
                <option value="KW" {{ old('nationalite') == 'KW' ? 'selected' : '' }}>🇰🇼 Koweït</option>
                <option value="LA" {{ old('nationalite') == 'LA' ? 'selected' : '' }}>🇱🇦 Laos</option>
                <option value="LS" {{ old('nationalite') == 'LS' ? 'selected' : '' }}>🇱🇸 Lesotho</option>
                <option value="LV" {{ old('nationalite') == 'LV' ? 'selected' : '' }}>🇱🇻 Lettonie</option>
                <option value="LB" {{ old('nationalite') == 'LB' ? 'selected' : '' }}>🇱🇧 Liban</option>
                <option value="LR" {{ old('nationalite') == 'LR' ? 'selected' : '' }}>🇱🇷 Liberia</option>
                <option value="LY" {{ old('nationalite') == 'LY' ? 'selected' : '' }}>🇱🇾 Libye</option>
                <option value="LI" {{ old('nationalite') == 'LI' ? 'selected' : '' }}>🇱🇮 Liechtenstein</option>
                <option value="LT" {{ old('nationalite') == 'LT' ? 'selected' : '' }}>🇱🇹 Lituanie</option>
                <option value="LU" {{ old('nationalite') == 'LU' ? 'selected' : '' }}>🇱🇺 Luxembourg</option>
                <option value="MG" {{ old('nationalite') == 'MG' ? 'selected' : '' }}>🇲🇬 Madagascar</option>
                <option value="MW" {{ old('nationalite') == 'MW' ? 'selected' : '' }}>🇲🇼 Malawi</option>
                <option value="MY" {{ old('nationalite') == 'MY' ? 'selected' : '' }}>🇲🇾 Malaisie</option>
                <option value="MV" {{ old('nationalite') == 'MV' ? 'selected' : '' }}>🇲🇻 Maldives</option>
                <option value="ML" {{ old('nationalite') == 'ML' ? 'selected' : '' }}>🇲🇱 Mali</option>
                <option value="MT" {{ old('nationalite') == 'MT' ? 'selected' : '' }}>🇲🇹 Malte</option>
                <option value="MA" {{ old('nationalite') == 'MA' ? 'selected' : '' }}>🇲🇦 Maroc</option>
                <option value="MU" {{ old('nationalite') == 'MU' ? 'selected' : '' }}>🇲🇺 Maurice</option>
                <option value="MR" {{ old('nationalite') == 'MR' ? 'selected' : '' }}>🇲🇷 Mauritanie</option>
                <option value="MX" {{ old('nationalite') == 'MX' ? 'selected' : '' }}>🇲🇽 Mexique</option>
                <option value="MD" {{ old('nationalite') == 'MD' ? 'selected' : '' }}>🇲🇩 Moldavie</option>
                <option value="MC" {{ old('nationalite') == 'MC' ? 'selected' : '' }}>🇲🇨 Monaco</option>
                <option value="MN" {{ old('nationalite') == 'MN' ? 'selected' : '' }}>🇲🇳 Mongolie</option>
                <option value="ME" {{ old('nationalite') == 'ME' ? 'selected' : '' }}>🇲🇪 Monténégro</option>
                <option value="MZ" {{ old('nationalite') == 'MZ' ? 'selected' : '' }}>🇲🇿 Mozambique</option>
                <option value="NA" {{ old('nationalite') == 'NA' ? 'selected' : '' }}>🇳🇦 Namibie</option>
                <option value="NR" {{ old('nationalite') == 'NR' ? 'selected' : '' }}>🇳🇷 Nauru</option>
                <option value="NP" {{ old('nationalite') == 'NP' ? 'selected' : '' }}>🇳🇵 Népal</option>
                <option value="NI" {{ old('nationalite') == 'NI' ? 'selected' : '' }}>🇳🇮 Nicaragua</option>
                <option value="NE" {{ old('nationalite') == 'NE' ? 'selected' : '' }}>🇳🇪 Niger</option>
                <option value="NG" {{ old('nationalite') == 'NG' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                <option value="NO" {{ old('nationalite') == 'NO' ? 'selected' : '' }}>🇳🇴 Norvège</option>
                <option value="NZ" {{ old('nationalite') == 'NZ' ? 'selected' : '' }}>🇳🇿 Nouvelle-Zélande</option>
                <option value="OM" {{ old('nationalite') == 'OM' ? 'selected' : '' }}>🇴🇲 Oman</option>
                <option value="UG" {{ old('nationalite') == 'UG' ? 'selected' : '' }}>🇺🇬 Ouganda</option>
                <option value="UZ" {{ old('nationalite') == 'UZ' ? 'selected' : '' }}>🇺🇿 Ouzbékistan</option>
                <option value="PK" {{ old('nationalite') == 'PK' ? 'selected' : '' }}>🇵🇰 Pakistan</option>
                <option value="PW" {{ old('nationalite') == 'PW' ? 'selected' : '' }}>🇵🇼 Palaos</option>
                <option value="PA" {{ old('nationalite') == 'PA' ? 'selected' : '' }}>🇵🇦 Panama</option>
                <option value="PG" {{ old('nationalite') == 'PG' ? 'selected' : '' }}>🇵🇬 Papouasie-Nouvelle-Guinée</option>
                <option value="PY" {{ old('nationalite') == 'PY' ? 'selected' : '' }}>🇵🇾 Paraguay</option>
                <option value="NL" {{ old('nationalite') == 'NL' ? 'selected' : '' }}>🇳🇱 Pays-Bas</option>
                <option value="PE" {{ old('nationalite') == 'PE' ? 'selected' : '' }}>🇵🇪 Pérou</option>
                <option value="PH" {{ old('nationalite') == 'PH' ? 'selected' : '' }}>🇵🇭 Philippines</option>
                <option value="PL" {{ old('nationalite') == 'PL' ? 'selected' : '' }}>🇵🇱 Pologne</option>
                <option value="PT" {{ old('nationalite') == 'PT' ? 'selected' : '' }}>🇵🇹 Portugal</option>
                <option value="QA" {{ old('nationalite') == 'QA' ? 'selected' : '' }}>🇶🇦 Qatar</option>
                <option value="RO" {{ old('nationalite') == 'RO' ? 'selected' : '' }}>🇷🇴 Roumanie</option>
                <option value="GB" {{ old('nationalite') == 'GB' ? 'selected' : '' }}>🇬🇧 Royaume-Uni</option>
                <option value="RU" {{ old('nationalite') == 'RU' ? 'selected' : '' }}>🇷🇺 Russie</option>
                <option value="RW" {{ old('nationalite') == 'RW' ? 'selected' : '' }}>🇷🇼 Rwanda</option>
                <option value="KN" {{ old('nationalite') == 'KN' ? 'selected' : '' }}>🇰🇳 Saint-Kitts-et-Nevis</option>
                <option value="LC" {{ old('nationalite') == 'LC' ? 'selected' : '' }}>🇱🇨 Sainte-Lucie</option>
                <option value="VC" {{ old('nationalite') == 'VC' ? 'selected' : '' }}>🇻🇨 Saint-Vincent-et-les-Grenadines</option>
                <option value="SM" {{ old('nationalite') == 'SM' ? 'selected' : '' }}>🇸🇲 Saint-Marin</option>
                <option value="ST" {{ old('nationalite') == 'ST' ? 'selected' : '' }}>🇸🇹 Sao Tomé-et-Principe</option>
                <option value="SN" {{ old('nationalite') == 'SN' ? 'selected' : '' }}>🇸🇳 Sénégal</option>
                <option value="RS" {{ old('nationalite') == 'RS' ? 'selected' : '' }}>🇷🇸 Serbie</option>
                <option value="SC" {{ old('nationalite') == 'SC' ? 'selected' : '' }}>🇸🇨 Seychelles</option>
                <option value="SL" {{ old('nationalite') == 'SL' ? 'selected' : '' }}>🇸🇱 Sierra Leone</option>
                <option value="SG" {{ old('nationalite') == 'SG' ? 'selected' : '' }}>🇸🇬 Singapour</option>
                <option value="SK" {{ old('nationalite') == 'SK' ? 'selected' : '' }}>🇸🇰 Slovaquie</option>
                <option value="SI" {{ old('nationalite') == 'SI' ? 'selected' : '' }}>🇸🇮 Slovénie</option>
                <option value="SO" {{ old('nationalite') == 'SO' ? 'selected' : '' }}>🇸🇴 Somalie</option>
                <option value="SD" {{ old('nationalite') == 'SD' ? 'selected' : '' }}>🇸🇩 Soudan</option>
                <option value="SS" {{ old('nationalite') == 'SS' ? 'selected' : '' }}>🇸🇸 Soudan du Sud</option>
                <option value="LK" {{ old('nationalite') == 'LK' ? 'selected' : '' }}>🇱🇰 Sri Lanka</option>
                <option value="SE" {{ old('nationalite') == 'SE' ? 'selected' : '' }}>🇸🇪 Suède</option>
                <option value="CH" {{ old('nationalite') == 'CH' ? 'selected' : '' }}>🇨🇭 Suisse</option>
                <option value="SR" {{ old('nationalite') == 'SR' ? 'selected' : '' }}>🇸🇷 Suriname</option>
                <option value="SY" {{ old('nationalite') == 'SY' ? 'selected' : '' }}>🇸🇾 Syrie</option>
                <option value="TJ" {{ old('nationalite') == 'TJ' ? 'selected' : '' }}>🇹🇯 Tadjikistan</option>
                <option value="TW" {{ old('nationalite') == 'TW' ? 'selected' : '' }}>🇹🇼 Taïwan</option>
                <option value="TZ" {{ old('nationalite') == 'TZ' ? 'selected' : '' }}>🇹🇿 Tanzanie</option>
                <option value="TD" {{ old('nationalite') == 'TD' ? 'selected' : '' }}>🇹🇩 Tchad</option>
                <option value="CZ" {{ old('nationalite') == 'CZ' ? 'selected' : '' }}>🇨🇿 République tchèque</option>
                <option value="TH" {{ old('nationalite') == 'TH' ? 'selected' : '' }}>🇹🇭 Thaïlande</option>
                <option value="TL" {{ old('nationalite') == 'TL' ? 'selected' : '' }}>🇹🇱 Timor oriental</option>
                <option value="TG" {{ old('nationalite') == 'TG' ? 'selected' : '' }}>🇹🇬 Togo</option>
                <option value="TO" {{ old('nationalite') == 'TO' ? 'selected' : '' }}>🇹🇴 Tonga</option>
                <option value="TT" {{ old('nationalite') == 'TT' ? 'selected' : '' }}>🇹🇹 Trinité-et-Tobago</option>
                <option value="TN" {{ old('nationalite') == 'TN' ? 'selected' : '' }}>🇹🇳 Tunisie</option>
                <option value="TM" {{ old('nationalite') == 'TM' ? 'selected' : '' }}>🇹🇲 Turkménistan</option>
                <option value="TR" {{ old('nationalite') == 'TR' ? 'selected' : '' }}>🇹🇷 Turquie</option>
                <option value="TV" {{ old('nationalite') == 'TV' ? 'selected' : '' }}>🇹🇻 Tuvalu</option>
                <option value="UA" {{ old('nationalite') == 'UA' ? 'selected' : '' }}>🇺🇦 Ukraine</option>
                <option value="UY" {{ old('nationalite') == 'UY' ? 'selected' : '' }}>🇺🇾 Uruguay</option>
                <option value="VU" {{ old('nationalite') == 'VU' ? 'selected' : '' }}>🇻🇺 Vanuatu</option>
                <option value="VA" {{ old('nationalite') == 'VA' ? 'selected' : '' }}>🇻🇦 Vatican</option>
                <option value="VE" {{ old('nationalite') == 'VE' ? 'selected' : '' }}>🇻🇪 Venezuela</option>
                <option value="VN" {{ old('nationalite') == 'VN' ? 'selected' : '' }}>🇻🇳 Viêt Nam</option>
                <option value="YE" {{ old('nationalite') == 'YE' ? 'selected' : '' }}>🇾🇪 Yémen</option>
                <option value="ZM" {{ old('nationalite') == 'ZM' ? 'selected' : '' }}>🇿🇲 Zambie</option>
                <option value="ZW" {{ old('nationalite') == 'ZW' ? 'selected' : '' }}>🇿🇼 Zimbabwe</option>
              </select>
              @error('nationalite')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Photo</label>
              <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
              @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Diplôme</label>
              <input type="file" name="diplome" class="form-control @error('diplome') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
              <small class="text-muted">Formats acceptés : PDF, JPG, PNG (max 5MB)</small>
              @error('diplome')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Carte d'identité</label>
              <input type="file" name="carte_identite" class="form-control @error('carte_identite') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
              <small class="text-muted">Formats acceptés : PDF, JPG, PNG (max 5MB)</small>
              @error('carte_identite')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.apprenants.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Créer l'Apprenant</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const classeSelect = document.getElementById('classe-select');
    const filiereSelect = document.getElementById('filiere-select');
    
    // Fonction pour filtrer les classes disponibles selon la filière
    function filterClassesByFiliere() {
      const selectedFiliere = filiereSelect ? filiereSelect.value : '';
      
      if (!selectedFiliere) {
        // Si aucune filière n'est sélectionnée, afficher toutes les classes
        if (classeSelect) {
          const currentValue = classeSelect.value;
          classeSelect.innerHTML = `
            <option value="">-- Sélectionner une classe --</option>
            <option value="licence_1">Licence 1</option>
            <option value="licence_2">Licence 2</option>
            <option value="licence_3">Licence 3</option>
          `;
          if (currentValue) {
            classeSelect.value = currentValue;
          }
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
            
            // Si la classe actuelle n'est plus disponible, vider
            if (currentValue && !data.licences.some(l => l.value === currentValue)) {
              classeSelect.value = '';
            }
          }
        }
      })
      .catch(error => {
        console.error('Erreur lors du filtrage des classes:', error);
      });
    }
    
    // Fonction pour filtrer les filières disponibles selon la classe
    function filterFilieresByLicence() {
      const selectedLicence = classeSelect ? classeSelect.value : '';
      
      if (!selectedLicence) {
        // Si aucune classe n'est sélectionnée, afficher toutes les filières
        if (filiereSelect) {
          const currentValue = filiereSelect.value;
          filiereSelect.innerHTML = '<option value="">-- Sélectionner une filière --</option>';
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
            filiereSelect.innerHTML = '<option value="">-- Sélectionner une filière --</option>';
            
            data.filieres.forEach(filiere => {
              const option = document.createElement('option');
              option.value = filiere;
              option.textContent = filiere;
              if (currentValue === filiere) {
                option.selected = true;
              }
              filiereSelect.appendChild(option);
            });
            
            // Si la filière actuelle n'est plus disponible, vider
            if (currentValue && !data.filieres.includes(currentValue)) {
              filiereSelect.value = '';
            }
          }
        }
      })
      .catch(error => {
        console.error('Erreur lors du filtrage des filières:', error);
      });
    }
    
    // Écouter les changements sur le champ "Niveau d'étude"
    if (classeSelect) {
      classeSelect.addEventListener('change', function() {
        filterFilieresByLicence();
      });
    }
    
    // Écouter les changements sur le champ "Filière"
    if (filiereSelect) {
      filiereSelect.addEventListener('change', function() {
        filterClassesByFiliere();
      });
    }
    
    // Déclencher le chargement initial si des valeurs sont déjà sélectionnées (old input)
    if (classeSelect && classeSelect.value) {
      filterFilieresByLicence();
    }
    if (filiereSelect && filiereSelect.value) {
      filterClassesByFiliere();
    }
  });
</script>
@endpush
