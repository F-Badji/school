@extends('layouts.admin')

@section('title', 'Modifier Apprenant')
@section('breadcrumb', 'Modifier Apprenant')
@section('page-title', 'Modifier l\'Apprenant')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pb-0">
        <h6 class="mb-0">Modifier les Informations</h6>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.apprenants.update', $apprenant) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nom <span class="text-danger">*</span></label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $apprenant->nom) }}" required>
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Prénom <span class="text-danger">*</span></label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $apprenant->prenom) }}" required>
              @error('prenom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $apprenant->email) }}" required>
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
              <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance', $apprenant->date_naissance ? $apprenant->date_naissance->format('Y-m-d') : '') }}">
              @error('date_naissance')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Filière</label>
              <select name="filiere" id="filiere-select" class="form-control @error('filiere') is-invalid @enderror">
                <option value="">-- Sélectionner une filière --</option>
                @foreach($filieres as $filiere)
                  <option value="{{ $filiere }}" {{ old('filiere', $apprenant->filiere) == $filiere ? 'selected' : '' }}>
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
                <option value="licence_1" {{ old('classe_id', $apprenant->classe_id) == 'licence_1' ? 'selected' : '' }}>Licence 1</option>
                <option value="licence_2" {{ old('classe_id', $apprenant->classe_id) == 'licence_2' ? 'selected' : '' }}>Licence 2</option>
                <option value="licence_3" {{ old('classe_id', $apprenant->classe_id) == 'licence_3' ? 'selected' : '' }}>Licence 3</option>
                <option value="master_1" {{ old('classe_id', $apprenant->classe_id) == 'master_1' ? 'selected' : '' }}>Master 1</option>
                <option value="master_2" {{ old('classe_id', $apprenant->classe_id) == 'master_2' ? 'selected' : '' }}>Master 2</option>
              </select>
              @error('classe_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Statut</label>
              <select name="statut" class="form-control @error('statut') is-invalid @enderror">
                <option value="actif" {{ old('statut', $apprenant->statut) === 'actif' ? 'selected' : '' }}>Actif</option>
                <option value="bloque" {{ old('statut', $apprenant->statut) === 'bloque' ? 'selected' : '' }}>Bloqué</option>
                <option value="inactif" {{ old('statut', $apprenant->statut) === 'inactif' ? 'selected' : '' }}>Inactif</option>
              </select>
              @error('statut')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Téléphone</label>
              <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $apprenant->phone) }}" placeholder="Ex: +221 77 123 45 67">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Ville</label>
              <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $apprenant->location) }}" placeholder="Ex: Dakar">
              @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Nationalité</label>
              <select name="nationalite" class="form-control @error('nationalite') is-invalid @enderror">
                <option value="">-- Sélectionner une nationalité --</option>
                <option value="AF" {{ old('nationalite', $apprenant->nationalite) == 'AF' ? 'selected' : '' }}>🇦🇫 Afghanistan</option>
                <option value="ZA" {{ old('nationalite', $apprenant->nationalite) == 'ZA' ? 'selected' : '' }}>🇿🇦 Afrique du Sud</option>
                <option value="AL" {{ old('nationalite', $apprenant->nationalite) == 'AL' ? 'selected' : '' }}>🇦🇱 Albanie</option>
                <option value="DZ" {{ old('nationalite', $apprenant->nationalite) == 'DZ' ? 'selected' : '' }}>🇩🇿 Algérie</option>
                <option value="DE" {{ old('nationalite', $apprenant->nationalite) == 'DE' ? 'selected' : '' }}>🇩🇪 Allemagne</option>
                <option value="AD" {{ old('nationalite', $apprenant->nationalite) == 'AD' ? 'selected' : '' }}>🇦🇩 Andorre</option>
                <option value="AO" {{ old('nationalite', $apprenant->nationalite) == 'AO' ? 'selected' : '' }}>🇦🇴 Angola</option>
                <option value="AG" {{ old('nationalite', $apprenant->nationalite) == 'AG' ? 'selected' : '' }}>🇦🇬 Antigua-et-Barbuda</option>
                <option value="SA" {{ old('nationalite', $apprenant->nationalite) == 'SA' ? 'selected' : '' }}>🇸🇦 Arabie Saoudite</option>
                <option value="AR" {{ old('nationalite', $apprenant->nationalite) == 'AR' ? 'selected' : '' }}>🇦🇷 Argentine</option>
                <option value="AM" {{ old('nationalite', $apprenant->nationalite) == 'AM' ? 'selected' : '' }}>🇦🇲 Arménie</option>
                <option value="AU" {{ old('nationalite', $apprenant->nationalite) == 'AU' ? 'selected' : '' }}>🇦🇺 Australie</option>
                <option value="AT" {{ old('nationalite', $apprenant->nationalite) == 'AT' ? 'selected' : '' }}>🇦🇹 Autriche</option>
                <option value="AZ" {{ old('nationalite', $apprenant->nationalite) == 'AZ' ? 'selected' : '' }}>🇦🇿 Azerbaïdjan</option>
                <option value="BS" {{ old('nationalite', $apprenant->nationalite) == 'BS' ? 'selected' : '' }}>🇧🇸 Bahamas</option>
                <option value="BH" {{ old('nationalite', $apprenant->nationalite) == 'BH' ? 'selected' : '' }}>🇧🇭 Bahreïn</option>
                <option value="BD" {{ old('nationalite', $apprenant->nationalite) == 'BD' ? 'selected' : '' }}>🇧🇩 Bangladesh</option>
                <option value="BB" {{ old('nationalite', $apprenant->nationalite) == 'BB' ? 'selected' : '' }}>🇧🇧 Barbade</option>
                <option value="BE" {{ old('nationalite', $apprenant->nationalite) == 'BE' ? 'selected' : '' }}>🇧🇪 Belgique</option>
                <option value="BZ" {{ old('nationalite', $apprenant->nationalite) == 'BZ' ? 'selected' : '' }}>🇧🇿 Belize</option>
                <option value="BJ" {{ old('nationalite', $apprenant->nationalite) == 'BJ' ? 'selected' : '' }}>🇧🇯 Bénin</option>
                <option value="BT" {{ old('nationalite', $apprenant->nationalite) == 'BT' ? 'selected' : '' }}>🇧🇹 Bhoutan</option>
                <option value="BY" {{ old('nationalite', $apprenant->nationalite) == 'BY' ? 'selected' : '' }}>🇧🇾 Biélorussie</option>
                <option value="MM" {{ old('nationalite', $apprenant->nationalite) == 'MM' ? 'selected' : '' }}>🇲🇲 Birmanie</option>
                <option value="BO" {{ old('nationalite', $apprenant->nationalite) == 'BO' ? 'selected' : '' }}>🇧🇴 Bolivie</option>
                <option value="BA" {{ old('nationalite', $apprenant->nationalite) == 'BA' ? 'selected' : '' }}>🇧🇦 Bosnie-Herzégovine</option>
                <option value="BW" {{ old('nationalite', $apprenant->nationalite) == 'BW' ? 'selected' : '' }}>🇧🇼 Botswana</option>
                <option value="BR" {{ old('nationalite', $apprenant->nationalite) == 'BR' ? 'selected' : '' }}>🇧🇷 Brésil</option>
                <option value="BN" {{ old('nationalite', $apprenant->nationalite) == 'BN' ? 'selected' : '' }}>🇧🇳 Brunei</option>
                <option value="BG" {{ old('nationalite', $apprenant->nationalite) == 'BG' ? 'selected' : '' }}>🇧🇬 Bulgarie</option>
                <option value="BF" {{ old('nationalite', $apprenant->nationalite) == 'BF' ? 'selected' : '' }}>🇧🇫 Burkina Faso</option>
                <option value="BI" {{ old('nationalite', $apprenant->nationalite) == 'BI' ? 'selected' : '' }}>🇧🇮 Burundi</option>
                <option value="KH" {{ old('nationalite', $apprenant->nationalite) == 'KH' ? 'selected' : '' }}>🇰🇭 Cambodge</option>
                <option value="CM" {{ old('nationalite', $apprenant->nationalite) == 'CM' ? 'selected' : '' }}>🇨🇲 Cameroun</option>
                <option value="CA" {{ old('nationalite', $apprenant->nationalite) == 'CA' ? 'selected' : '' }}>🇨🇦 Canada</option>
                <option value="CV" {{ old('nationalite', $apprenant->nationalite) == 'CV' ? 'selected' : '' }}>🇨🇻 Cap-Vert</option>
                <option value="CL" {{ old('nationalite', $apprenant->nationalite) == 'CL' ? 'selected' : '' }}>🇨🇱 Chili</option>
                <option value="CN" {{ old('nationalite', $apprenant->nationalite) == 'CN' ? 'selected' : '' }}>🇨🇳 Chine</option>
                <option value="CY" {{ old('nationalite', $apprenant->nationalite) == 'CY' ? 'selected' : '' }}>🇨🇾 Chypre</option>
                <option value="CO" {{ old('nationalite', $apprenant->nationalite) == 'CO' ? 'selected' : '' }}>🇨🇴 Colombie</option>
                <option value="KM" {{ old('nationalite', $apprenant->nationalite) == 'KM' ? 'selected' : '' }}>🇰🇲 Comores</option>
                <option value="CG" {{ old('nationalite', $apprenant->nationalite) == 'CG' ? 'selected' : '' }}>🇨🇬 Congo</option>
                <option value="CD" {{ old('nationalite', $apprenant->nationalite) == 'CD' ? 'selected' : '' }}>🇨🇩 République démocratique du Congo</option>
                <option value="KR" {{ old('nationalite', $apprenant->nationalite) == 'KR' ? 'selected' : '' }}>🇰🇷 Corée du Sud</option>
                <option value="KP" {{ old('nationalite', $apprenant->nationalite) == 'KP' ? 'selected' : '' }}>🇰🇵 Corée du Nord</option>
                <option value="CR" {{ old('nationalite', $apprenant->nationalite) == 'CR' ? 'selected' : '' }}>🇨🇷 Costa Rica</option>
                <option value="CI" {{ old('nationalite', $apprenant->nationalite) == 'CI' ? 'selected' : '' }}>🇨🇮 Côte d'Ivoire</option>
                <option value="HR" {{ old('nationalite', $apprenant->nationalite) == 'HR' ? 'selected' : '' }}>🇭🇷 Croatie</option>
                <option value="CU" {{ old('nationalite', $apprenant->nationalite) == 'CU' ? 'selected' : '' }}>🇨🇺 Cuba</option>
                <option value="DK" {{ old('nationalite', $apprenant->nationalite) == 'DK' ? 'selected' : '' }}>🇩🇰 Danemark</option>
                <option value="DJ" {{ old('nationalite', $apprenant->nationalite) == 'DJ' ? 'selected' : '' }}>🇩🇯 Djibouti</option>
                <option value="DM" {{ old('nationalite', $apprenant->nationalite) == 'DM' ? 'selected' : '' }}>🇩🇲 Dominique</option>
                <option value="EG" {{ old('nationalite', $apprenant->nationalite) == 'EG' ? 'selected' : '' }}>🇪🇬 Égypte</option>
                <option value="AE" {{ old('nationalite', $apprenant->nationalite) == 'AE' ? 'selected' : '' }}>🇦🇪 Émirats arabes unis</option>
                <option value="EC" {{ old('nationalite', $apprenant->nationalite) == 'EC' ? 'selected' : '' }}>🇪🇨 Équateur</option>
                <option value="ER" {{ old('nationalite', $apprenant->nationalite) == 'ER' ? 'selected' : '' }}>🇪🇷 Érythrée</option>
                <option value="ES" {{ old('nationalite', $apprenant->nationalite) == 'ES' ? 'selected' : '' }}>🇪🇸 Espagne</option>
                <option value="EE" {{ old('nationalite', $apprenant->nationalite) == 'EE' ? 'selected' : '' }}>🇪🇪 Estonie</option>
                <option value="SZ" {{ old('nationalite', $apprenant->nationalite) == 'SZ' ? 'selected' : '' }}>🇸🇿 Eswatini</option>
                <option value="US" {{ old('nationalite', $apprenant->nationalite) == 'US' ? 'selected' : '' }}>🇺🇸 États-Unis</option>
                <option value="ET" {{ old('nationalite', $apprenant->nationalite) == 'ET' ? 'selected' : '' }}>🇪🇹 Éthiopie</option>
                <option value="FJ" {{ old('nationalite', $apprenant->nationalite) == 'FJ' ? 'selected' : '' }}>🇫🇯 Fidji</option>
                <option value="FI" {{ old('nationalite', $apprenant->nationalite) == 'FI' ? 'selected' : '' }}>🇫🇮 Finlande</option>
                <option value="FR" {{ old('nationalite', $apprenant->nationalite) == 'FR' ? 'selected' : '' }}>🇫🇷 France</option>
                <option value="GA" {{ old('nationalite', $apprenant->nationalite) == 'GA' ? 'selected' : '' }}>🇬🇦 Gabon</option>
                <option value="GM" {{ old('nationalite', $apprenant->nationalite) == 'GM' ? 'selected' : '' }}>🇬🇲 Gambie</option>
                <option value="GE" {{ old('nationalite', $apprenant->nationalite) == 'GE' ? 'selected' : '' }}>🇬🇪 Géorgie</option>
                <option value="GH" {{ old('nationalite', $apprenant->nationalite) == 'GH' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                <option value="GR" {{ old('nationalite', $apprenant->nationalite) == 'GR' ? 'selected' : '' }}>🇬🇷 Grèce</option>
                <option value="GD" {{ old('nationalite', $apprenant->nationalite) == 'GD' ? 'selected' : '' }}>🇬🇩 Grenade</option>
                <option value="GT" {{ old('nationalite', $apprenant->nationalite) == 'GT' ? 'selected' : '' }}>🇬🇹 Guatemala</option>
                <option value="GN" {{ old('nationalite', $apprenant->nationalite) == 'GN' ? 'selected' : '' }}>🇬🇳 Guinée</option>
                <option value="GW" {{ old('nationalite', $apprenant->nationalite) == 'GW' ? 'selected' : '' }}>🇬🇼 Guinée-Bissau</option>
                <option value="GQ" {{ old('nationalite', $apprenant->nationalite) == 'GQ' ? 'selected' : '' }}>🇬🇶 Guinée équatoriale</option>
                <option value="GY" {{ old('nationalite', $apprenant->nationalite) == 'GY' ? 'selected' : '' }}>🇬🇾 Guyana</option>
                <option value="HT" {{ old('nationalite', $apprenant->nationalite) == 'HT' ? 'selected' : '' }}>🇭🇹 Haïti</option>
                <option value="HN" {{ old('nationalite', $apprenant->nationalite) == 'HN' ? 'selected' : '' }}>🇭🇳 Honduras</option>
                <option value="HU" {{ old('nationalite', $apprenant->nationalite) == 'HU' ? 'selected' : '' }}>🇭🇺 Hongrie</option>
                <option value="IN" {{ old('nationalite', $apprenant->nationalite) == 'IN' ? 'selected' : '' }}>🇮🇳 Inde</option>
                <option value="ID" {{ old('nationalite', $apprenant->nationalite) == 'ID' ? 'selected' : '' }}>🇮🇩 Indonésie</option>
                <option value="IQ" {{ old('nationalite', $apprenant->nationalite) == 'IQ' ? 'selected' : '' }}>🇮🇶 Irak</option>
                <option value="IR" {{ old('nationalite', $apprenant->nationalite) == 'IR' ? 'selected' : '' }}>🇮🇷 Iran</option>
                <option value="IE" {{ old('nationalite', $apprenant->nationalite) == 'IE' ? 'selected' : '' }}>🇮🇪 Irlande</option>
                <option value="IS" {{ old('nationalite', $apprenant->nationalite) == 'IS' ? 'selected' : '' }}>🇮🇸 Islande</option>
                <option value="IL" {{ old('nationalite', $apprenant->nationalite) == 'IL' ? 'selected' : '' }}>🇮🇱 Israël</option>
                <option value="IT" {{ old('nationalite', $apprenant->nationalite) == 'IT' ? 'selected' : '' }}>🇮🇹 Italie</option>
                <option value="JM" {{ old('nationalite', $apprenant->nationalite) == 'JM' ? 'selected' : '' }}>🇯🇲 Jamaïque</option>
                <option value="JP" {{ old('nationalite', $apprenant->nationalite) == 'JP' ? 'selected' : '' }}>🇯🇵 Japon</option>
                <option value="JO" {{ old('nationalite', $apprenant->nationalite) == 'JO' ? 'selected' : '' }}>🇯🇴 Jordanie</option>
                <option value="KZ" {{ old('nationalite', $apprenant->nationalite) == 'KZ' ? 'selected' : '' }}>🇰🇿 Kazakhstan</option>
                <option value="KE" {{ old('nationalite', $apprenant->nationalite) == 'KE' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                <option value="KG" {{ old('nationalite', $apprenant->nationalite) == 'KG' ? 'selected' : '' }}>🇰🇬 Kirghizistan</option>
                <option value="KI" {{ old('nationalite', $apprenant->nationalite) == 'KI' ? 'selected' : '' }}>🇰🇮 Kiribati</option>
                <option value="KW" {{ old('nationalite', $apprenant->nationalite) == 'KW' ? 'selected' : '' }}>🇰🇼 Koweït</option>
                <option value="LA" {{ old('nationalite', $apprenant->nationalite) == 'LA' ? 'selected' : '' }}>🇱🇦 Laos</option>
                <option value="LS" {{ old('nationalite', $apprenant->nationalite) == 'LS' ? 'selected' : '' }}>🇱🇸 Lesotho</option>
                <option value="LV" {{ old('nationalite', $apprenant->nationalite) == 'LV' ? 'selected' : '' }}>🇱🇻 Lettonie</option>
                <option value="LB" {{ old('nationalite', $apprenant->nationalite) == 'LB' ? 'selected' : '' }}>🇱🇧 Liban</option>
                <option value="LR" {{ old('nationalite', $apprenant->nationalite) == 'LR' ? 'selected' : '' }}>🇱🇷 Liberia</option>
                <option value="LY" {{ old('nationalite', $apprenant->nationalite) == 'LY' ? 'selected' : '' }}>🇱🇾 Libye</option>
                <option value="LI" {{ old('nationalite', $apprenant->nationalite) == 'LI' ? 'selected' : '' }}>🇱🇮 Liechtenstein</option>
                <option value="LT" {{ old('nationalite', $apprenant->nationalite) == 'LT' ? 'selected' : '' }}>🇱🇹 Lituanie</option>
                <option value="LU" {{ old('nationalite', $apprenant->nationalite) == 'LU' ? 'selected' : '' }}>🇱🇺 Luxembourg</option>
                <option value="MG" {{ old('nationalite', $apprenant->nationalite) == 'MG' ? 'selected' : '' }}>🇲🇬 Madagascar</option>
                <option value="MW" {{ old('nationalite', $apprenant->nationalite) == 'MW' ? 'selected' : '' }}>🇲🇼 Malawi</option>
                <option value="MY" {{ old('nationalite', $apprenant->nationalite) == 'MY' ? 'selected' : '' }}>🇲🇾 Malaisie</option>
                <option value="MV" {{ old('nationalite', $apprenant->nationalite) == 'MV' ? 'selected' : '' }}>🇲🇻 Maldives</option>
                <option value="ML" {{ old('nationalite', $apprenant->nationalite) == 'ML' ? 'selected' : '' }}>🇲🇱 Mali</option>
                <option value="MT" {{ old('nationalite', $apprenant->nationalite) == 'MT' ? 'selected' : '' }}>🇲🇹 Malte</option>
                <option value="MA" {{ old('nationalite', $apprenant->nationalite) == 'MA' ? 'selected' : '' }}>🇲🇦 Maroc</option>
                <option value="MU" {{ old('nationalite', $apprenant->nationalite) == 'MU' ? 'selected' : '' }}>🇲🇺 Maurice</option>
                <option value="MR" {{ old('nationalite', $apprenant->nationalite) == 'MR' ? 'selected' : '' }}>🇲🇷 Mauritanie</option>
                <option value="MX" {{ old('nationalite', $apprenant->nationalite) == 'MX' ? 'selected' : '' }}>🇲🇽 Mexique</option>
                <option value="MD" {{ old('nationalite', $apprenant->nationalite) == 'MD' ? 'selected' : '' }}>🇲🇩 Moldavie</option>
                <option value="MC" {{ old('nationalite', $apprenant->nationalite) == 'MC' ? 'selected' : '' }}>🇲🇨 Monaco</option>
                <option value="MN" {{ old('nationalite', $apprenant->nationalite) == 'MN' ? 'selected' : '' }}>🇲🇳 Mongolie</option>
                <option value="ME" {{ old('nationalite', $apprenant->nationalite) == 'ME' ? 'selected' : '' }}>🇲🇪 Monténégro</option>
                <option value="MZ" {{ old('nationalite', $apprenant->nationalite) == 'MZ' ? 'selected' : '' }}>🇲🇿 Mozambique</option>
                <option value="NA" {{ old('nationalite', $apprenant->nationalite) == 'NA' ? 'selected' : '' }}>🇳🇦 Namibie</option>
                <option value="NR" {{ old('nationalite', $apprenant->nationalite) == 'NR' ? 'selected' : '' }}>🇳🇷 Nauru</option>
                <option value="NP" {{ old('nationalite', $apprenant->nationalite) == 'NP' ? 'selected' : '' }}>🇳🇵 Népal</option>
                <option value="NI" {{ old('nationalite', $apprenant->nationalite) == 'NI' ? 'selected' : '' }}>🇳🇮 Nicaragua</option>
                <option value="NE" {{ old('nationalite', $apprenant->nationalite) == 'NE' ? 'selected' : '' }}>🇳🇪 Niger</option>
                <option value="NG" {{ old('nationalite', $apprenant->nationalite) == 'NG' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                <option value="NO" {{ old('nationalite', $apprenant->nationalite) == 'NO' ? 'selected' : '' }}>🇳🇴 Norvège</option>
                <option value="NZ" {{ old('nationalite', $apprenant->nationalite) == 'NZ' ? 'selected' : '' }}>🇳🇿 Nouvelle-Zélande</option>
                <option value="OM" {{ old('nationalite', $apprenant->nationalite) == 'OM' ? 'selected' : '' }}>🇴🇲 Oman</option>
                <option value="UG" {{ old('nationalite', $apprenant->nationalite) == 'UG' ? 'selected' : '' }}>🇺🇬 Ouganda</option>
                <option value="UZ" {{ old('nationalite', $apprenant->nationalite) == 'UZ' ? 'selected' : '' }}>🇺🇿 Ouzbékistan</option>
                <option value="PK" {{ old('nationalite', $apprenant->nationalite) == 'PK' ? 'selected' : '' }}>🇵🇰 Pakistan</option>
                <option value="PW" {{ old('nationalite', $apprenant->nationalite) == 'PW' ? 'selected' : '' }}>🇵🇼 Palaos</option>
                <option value="PA" {{ old('nationalite', $apprenant->nationalite) == 'PA' ? 'selected' : '' }}>🇵🇦 Panama</option>
                <option value="PG" {{ old('nationalite', $apprenant->nationalite) == 'PG' ? 'selected' : '' }}>🇵🇬 Papouasie-Nouvelle-Guinée</option>
                <option value="PY" {{ old('nationalite', $apprenant->nationalite) == 'PY' ? 'selected' : '' }}>🇵🇾 Paraguay</option>
                <option value="NL" {{ old('nationalite', $apprenant->nationalite) == 'NL' ? 'selected' : '' }}>🇳🇱 Pays-Bas</option>
                <option value="PE" {{ old('nationalite', $apprenant->nationalite) == 'PE' ? 'selected' : '' }}>🇵🇪 Pérou</option>
                <option value="PH" {{ old('nationalite', $apprenant->nationalite) == 'PH' ? 'selected' : '' }}>🇵🇭 Philippines</option>
                <option value="PL" {{ old('nationalite', $apprenant->nationalite) == 'PL' ? 'selected' : '' }}>🇵🇱 Pologne</option>
                <option value="PT" {{ old('nationalite', $apprenant->nationalite) == 'PT' ? 'selected' : '' }}>🇵🇹 Portugal</option>
                <option value="QA" {{ old('nationalite', $apprenant->nationalite) == 'QA' ? 'selected' : '' }}>🇶🇦 Qatar</option>
                <option value="RO" {{ old('nationalite', $apprenant->nationalite) == 'RO' ? 'selected' : '' }}>🇷🇴 Roumanie</option>
                <option value="GB" {{ old('nationalite', $apprenant->nationalite) == 'GB' ? 'selected' : '' }}>🇬🇧 Royaume-Uni</option>
                <option value="RU" {{ old('nationalite', $apprenant->nationalite) == 'RU' ? 'selected' : '' }}>🇷🇺 Russie</option>
                <option value="RW" {{ old('nationalite', $apprenant->nationalite) == 'RW' ? 'selected' : '' }}>🇷🇼 Rwanda</option>
                <option value="KN" {{ old('nationalite', $apprenant->nationalite) == 'KN' ? 'selected' : '' }}>🇰🇳 Saint-Kitts-et-Nevis</option>
                <option value="LC" {{ old('nationalite', $apprenant->nationalite) == 'LC' ? 'selected' : '' }}>🇱🇨 Sainte-Lucie</option>
                <option value="VC" {{ old('nationalite', $apprenant->nationalite) == 'VC' ? 'selected' : '' }}>🇻🇨 Saint-Vincent-et-les-Grenadines</option>
                <option value="SM" {{ old('nationalite', $apprenant->nationalite) == 'SM' ? 'selected' : '' }}>🇸🇲 Saint-Marin</option>
                <option value="ST" {{ old('nationalite', $apprenant->nationalite) == 'ST' ? 'selected' : '' }}>🇸🇹 Sao Tomé-et-Principe</option>
                <option value="SN" {{ old('nationalite', $apprenant->nationalite) == 'SN' ? 'selected' : '' }}>🇸🇳 Sénégal</option>
                <option value="RS" {{ old('nationalite', $apprenant->nationalite) == 'RS' ? 'selected' : '' }}>🇷🇸 Serbie</option>
                <option value="SC" {{ old('nationalite', $apprenant->nationalite) == 'SC' ? 'selected' : '' }}>🇸🇨 Seychelles</option>
                <option value="SL" {{ old('nationalite', $apprenant->nationalite) == 'SL' ? 'selected' : '' }}>🇸🇱 Sierra Leone</option>
                <option value="SG" {{ old('nationalite', $apprenant->nationalite) == 'SG' ? 'selected' : '' }}>🇸🇬 Singapour</option>
                <option value="SK" {{ old('nationalite', $apprenant->nationalite) == 'SK' ? 'selected' : '' }}>🇸🇰 Slovaquie</option>
                <option value="SI" {{ old('nationalite', $apprenant->nationalite) == 'SI' ? 'selected' : '' }}>🇸🇮 Slovénie</option>
                <option value="SO" {{ old('nationalite', $apprenant->nationalite) == 'SO' ? 'selected' : '' }}>🇸🇴 Somalie</option>
                <option value="SD" {{ old('nationalite', $apprenant->nationalite) == 'SD' ? 'selected' : '' }}>🇸🇩 Soudan</option>
                <option value="SS" {{ old('nationalite', $apprenant->nationalite) == 'SS' ? 'selected' : '' }}>🇸🇸 Soudan du Sud</option>
                <option value="LK" {{ old('nationalite', $apprenant->nationalite) == 'LK' ? 'selected' : '' }}>🇱🇰 Sri Lanka</option>
                <option value="SE" {{ old('nationalite', $apprenant->nationalite) == 'SE' ? 'selected' : '' }}>🇸🇪 Suède</option>
                <option value="CH" {{ old('nationalite', $apprenant->nationalite) == 'CH' ? 'selected' : '' }}>🇨🇭 Suisse</option>
                <option value="SR" {{ old('nationalite', $apprenant->nationalite) == 'SR' ? 'selected' : '' }}>🇸🇷 Suriname</option>
                <option value="SY" {{ old('nationalite', $apprenant->nationalite) == 'SY' ? 'selected' : '' }}>🇸🇾 Syrie</option>
                <option value="TJ" {{ old('nationalite', $apprenant->nationalite) == 'TJ' ? 'selected' : '' }}>🇹🇯 Tadjikistan</option>
                <option value="TW" {{ old('nationalite', $apprenant->nationalite) == 'TW' ? 'selected' : '' }}>🇹🇼 Taïwan</option>
                <option value="TZ" {{ old('nationalite', $apprenant->nationalite) == 'TZ' ? 'selected' : '' }}>🇹🇿 Tanzanie</option>
                <option value="TD" {{ old('nationalite', $apprenant->nationalite) == 'TD' ? 'selected' : '' }}>🇹🇩 Tchad</option>
                <option value="CZ" {{ old('nationalite', $apprenant->nationalite) == 'CZ' ? 'selected' : '' }}>🇨🇿 République tchèque</option>
                <option value="TH" {{ old('nationalite', $apprenant->nationalite) == 'TH' ? 'selected' : '' }}>🇹🇭 Thaïlande</option>
                <option value="TL" {{ old('nationalite', $apprenant->nationalite) == 'TL' ? 'selected' : '' }}>🇹🇱 Timor oriental</option>
                <option value="TG" {{ old('nationalite', $apprenant->nationalite) == 'TG' ? 'selected' : '' }}>🇹🇬 Togo</option>
                <option value="TO" {{ old('nationalite', $apprenant->nationalite) == 'TO' ? 'selected' : '' }}>🇹🇴 Tonga</option>
                <option value="TT" {{ old('nationalite', $apprenant->nationalite) == 'TT' ? 'selected' : '' }}>🇹🇹 Trinité-et-Tobago</option>
                <option value="TN" {{ old('nationalite', $apprenant->nationalite) == 'TN' ? 'selected' : '' }}>🇹🇳 Tunisie</option>
                <option value="TM" {{ old('nationalite', $apprenant->nationalite) == 'TM' ? 'selected' : '' }}>🇹🇲 Turkménistan</option>
                <option value="TR" {{ old('nationalite', $apprenant->nationalite) == 'TR' ? 'selected' : '' }}>🇹🇷 Turquie</option>
                <option value="TV" {{ old('nationalite', $apprenant->nationalite) == 'TV' ? 'selected' : '' }}>🇹🇻 Tuvalu</option>
                <option value="UA" {{ old('nationalite', $apprenant->nationalite) == 'UA' ? 'selected' : '' }}>🇺🇦 Ukraine</option>
                <option value="UY" {{ old('nationalite', $apprenant->nationalite) == 'UY' ? 'selected' : '' }}>🇺🇾 Uruguay</option>
                <option value="VU" {{ old('nationalite', $apprenant->nationalite) == 'VU' ? 'selected' : '' }}>🇻🇺 Vanuatu</option>
                <option value="VA" {{ old('nationalite', $apprenant->nationalite) == 'VA' ? 'selected' : '' }}>🇻🇦 Vatican</option>
                <option value="VE" {{ old('nationalite', $apprenant->nationalite) == 'VE' ? 'selected' : '' }}>🇻🇪 Venezuela</option>
                <option value="VN" {{ old('nationalite', $apprenant->nationalite) == 'VN' ? 'selected' : '' }}>🇻🇳 Viêt Nam</option>
                <option value="YE" {{ old('nationalite', $apprenant->nationalite) == 'YE' ? 'selected' : '' }}>🇾🇪 Yémen</option>
                <option value="ZM" {{ old('nationalite', $apprenant->nationalite) == 'ZM' ? 'selected' : '' }}>🇿🇲 Zambie</option>
                <option value="ZW" {{ old('nationalite', $apprenant->nationalite) == 'ZW' ? 'selected' : '' }}>🇿🇼 Zimbabwe</option>
              </select>
              @error('nationalite')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Photo</label>
              @if($apprenant->photo)
                <div class="mb-2">
                  <img src="{{ asset('storage/' . $apprenant->photo) }}" class="avatar avatar-lg rounded-circle" alt="Photo actuelle">
                </div>
              @endif
              <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
              @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Diplôme</label>
              @if($apprenant->diplome)
                <div class="mb-2">
                  <a href="{{ asset('storage/' . $apprenant->diplome) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                    <i class="ni ni-paper-diploma"></i> Voir le diplôme actuel
                  </a>
                </div>
              @endif
              <input type="file" name="diplome" class="form-control @error('diplome') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
              <small class="text-muted">Laisser vide pour conserver le fichier actuel. Formats acceptés : PDF, JPG, PNG (max 5MB)</small>
              @error('diplome')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Carte d'identité</label>
              @if($apprenant->carte_identite)
                <div class="mb-2">
                  <a href="{{ asset('storage/' . $apprenant->carte_identite) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2">
                    <i class="ni ni-badge"></i> Voir la carte d'identité actuelle
                  </a>
                </div>
              @endif
              <input type="file" name="carte_identite" class="form-control @error('carte_identite') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
              <small class="text-muted">Laisser vide pour conserver le fichier actuel. Formats acceptés : PDF, JPG, PNG (max 5MB)</small>
              @error('carte_identite')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          
          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.apprenants.show', $apprenant) }}" class="btn btn-secondary">Annuler</a>
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
    
    // Déclencher le chargement initial si des valeurs sont déjà sélectionnées
    if (classeSelect && classeSelect.value) {
      filterFilieresByLicence();
    }
    if (filiereSelect && filiereSelect.value) {
      filterClassesByFiliere();
    }
  });
</script>
@endpush
