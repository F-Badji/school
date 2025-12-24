<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Matiere;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormateurCoursController extends Controller
{
    /**
     * Afficher la liste des cours du formateur
     */
    public function index()
    {
        $user = Auth::user();
        
        // Vérification de sécurité
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé. Cette section est réservée aux formateurs.');
        }
        
        // Récupérer tous les cours du formateur
        $cours = Cours::where('formateur_id', $user->id)
            ->orderBy('ordre', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Récupérer les matières enseignées par le formateur
        $matieres = $user->matieres()->get();
        
        return view('formateur.cours', compact('user', 'cours', 'matieres'));
    }
    
    /**
     * Afficher le formulaire de création d'un nouveau cours
     */
    public function create()
    {
        Log::info('🔍 [CREATE COURS] Début de la méthode create');
        
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'teacher') {
                abort(403, 'Accès refusé.');
            }
            
            // SÉCURITÉ : Vérifier que le formateur a une classe et une filière assignées
            if (!$user->classe_id || !$user->filiere) {
                abort(403, 'Accès refusé. Vous n\'avez pas de classe ou filière assignée.');
            }
            
            // Récupérer les matières enseignées par le formateur
            $matieres = $user->matieres()->get();
            
            // SÉCURITÉ : Récupérer UNIQUEMENT la filière et le niveau du formateur
            $formateurFiliere = $user->filiere;
            
            // Mapper classe_id du formateur vers niveau_etude
            $classeToNiveauMap = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3'
            ];
            $formateurNiveauEtude = null;
            if ($user->classe_id && isset($classeToNiveauMap[$user->classe_id])) {
                $formateurNiveauEtude = $classeToNiveauMap[$user->classe_id];
            }
            
            // Récupérer la première matière du formateur (pour affichage)
            $matierePrincipale = $matieres->first();
            $matiereNom = $matierePrincipale ? ($matierePrincipale->nom_matiere ?? $matierePrincipale->nom ?? 'N/A') : 'N/A';
            
            $cours = null;
            
            Log::info('✅ [CREATE COURS] Données préparées, rendu de la vue', [
                'user_email' => $user->email,
                'has_success' => session()->has('success'),
            ]);
            
            return view('formateur.cours-create', compact('user', 'matieres', 'cours', 'formateurFiliere', 'formateurNiveauEtude', 'matiereNom'));
        } catch (\Exception $e) {
            Log::error('❌ [CREATE COURS] Erreur dans la méthode create', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
    
    /**
     * Enregistrer un nouveau cours
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        Log::info('🔍 [STORE COURS] Début de la méthode store', [
            'user_id' => $user->id ?? 'N/A',
            'user_email' => $user->email ?? 'N/A',
            'user_role' => $user->role ?? 'N/A',
            'has_image' => $request->hasFile('image_couverture'),
            'all_files' => array_keys($request->allFiles()),
        ]);
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        // SÉCURITÉ : Vérifier que le formateur a une classe et une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            abort(403, 'Accès refusé. Vous n\'avez pas de classe ou filière assignée.');
        }
        
        // Mapper classe_id du formateur vers niveau_etude
        $classeToNiveauMap = [
            'licence_1' => 'Licence 1',
            'licence_2' => 'Licence 2',
            'licence_3' => 'Licence 3'
        ];
        $formateurNiveauEtude = null;
        if ($user->classe_id && isset($classeToNiveauMap[$user->classe_id])) {
            $formateurNiveauEtude = $classeToNiveauMap[$user->classe_id];
        }
        
        // Vérifier l'état du fichier même si hasFile() retourne false
        $fileInAllFiles = isset($request->allFiles()['image_couverture']);
        $fileInfo = null;
        if ($fileInAllFiles) {
            try {
                $file = $request->allFiles()['image_couverture'];
                // Vérifier que c'est bien un UploadedFile avant d'accéder à ses propriétés
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    // Vérifier que le fichier est valide avant d'accéder à ses propriétés
                    if ($file->isValid()) {
                        $fileInfo = [
                            'name' => $file->getClientOriginalName(),
                            'size' => $file->getSize(),
                            'mime' => $file->getMimeType(),
                            'is_valid' => true,
                        ];
                    } else {
                        $fileInfo = [
                            'is_valid' => false,
                            'error' => $file->getError(),
                            'error_message' => $file->getErrorMessage(),
                        ];
                    }
                } else {
                    $fileInfo = ['error' => 'Le fichier n\'est pas une instance d\'UploadedFile'];
                }
            } catch (\Exception $e) {
                $fileInfo = ['error' => $e->getMessage()];
            }
        }
        
        Log::info('🔍 [STORE COURS] Avant validation', [
            'user_email' => $user->email,
            'has_image_file' => $request->hasFile('image_couverture'),
            'file_in_all_files' => $fileInAllFiles,
            'all_files_keys' => array_keys($request->allFiles()),
            'file_info' => $fileInfo,
            'php_upload_errors' => [
                'UPLOAD_ERR_OK' => UPLOAD_ERR_OK,
                'UPLOAD_ERR_INI_SIZE' => UPLOAD_ERR_INI_SIZE,
                'UPLOAD_ERR_FORM_SIZE' => UPLOAD_ERR_FORM_SIZE,
                'UPLOAD_ERR_PARTIAL' => UPLOAD_ERR_PARTIAL,
                'UPLOAD_ERR_NO_FILE' => UPLOAD_ERR_NO_FILE,
                'UPLOAD_ERR_NO_TMP_DIR' => UPLOAD_ERR_NO_TMP_DIR,
                'UPLOAD_ERR_CANT_WRITE' => UPLOAD_ERR_CANT_WRITE,
                'UPLOAD_ERR_EXTENSION' => UPLOAD_ERR_EXTENSION,
            ],
        ]);
        
        try {
            // Si le fichier est présent mais hasFile() retourne false, c'est probablement une erreur d'upload PHP
            if ($fileInAllFiles && !$request->hasFile('image_couverture')) {
                $file = $request->allFiles()['image_couverture'];
                $errorCode = $file->getError();
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'Le fichier dépasse la taille maximale autorisée par PHP (upload_max_filesize).',
                    UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la taille maximale autorisée par le formulaire (MAX_FILE_SIZE).',
                    UPLOAD_ERR_PARTIAL => 'Le fichier n\'a été que partiellement téléchargé.',
                    UPLOAD_ERR_NO_FILE => 'Aucun fichier n\'a été téléchargé.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant.',
                    UPLOAD_ERR_CANT_WRITE => 'Échec de l\'écriture du fichier sur le disque.',
                    UPLOAD_ERR_EXTENSION => 'Une extension PHP a arrêté le téléchargement du fichier.',
                ];
                $errorMessage = $errorMessages[$errorCode] ?? 'Erreur inconnue lors du téléchargement (code: ' . $errorCode . ')';
                
                Log::error('❌ [STORE COURS] Erreur PHP d\'upload détectée', [
                    'error_code' => $errorCode,
                    'error_message' => $errorMessage,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                ]);
                
                return back()->withErrors(['image_couverture' => $errorMessage])->withInput();
            }
            
            // Validation sans la règle 'uploaded' pour image_couverture pour éviter les erreurs prématurées
            $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Ne pas valider image_couverture ici si hasFile() retourne false, on le fera manuellement
            // 'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 Mo = 10240 KB
            'contenu' => 'nullable|array',
            'contenu.*.titre' => 'nullable|string|max:255',
            'contenu.*.description' => 'nullable|string',
            'contenu.*.lien_video' => 'nullable|string|max:500',
            'contenu.*.fichier_pdf' => 'nullable|string',
            'contenu.*.fichier_pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'contenu.*.sous_titres' => 'nullable|array', // Ajouter la validation pour sous_titres
            'contenu.*.sous_titres.*' => 'nullable|string', // Validation pour chaque sous-titre
            'contenu.*.duree_quiz_heures' => 'nullable|integer|min:0|max:23', // Heures du quiz
            'contenu.*.duree_quiz_minutes' => 'nullable|integer|min:0|max:59', // Minutes du quiz
            'questions' => 'nullable|array',
            'questions.*.*.type' => 'nullable|in:vrai_faux,choix_multiple,texte_libre,image,numerique',
            'questions.*.*.question' => 'nullable|string',
            'questions.*.*.points' => 'nullable|integer|min:1',
            'questions.*.*.image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duree' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'nullable|boolean',
        ]);
        
        // Valider manuellement l'image si elle est présente
        if ($request->hasFile('image_couverture')) {
            try {
                $imageValidation = $request->validate([
                    'image_couverture' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // 10 Mo = 10240 KB
                ], [
                    'image_couverture.image' => 'Le fichier doit être une image.',
                    'image_couverture.mimes' => 'L\'image doit être au format : JPEG, PNG, JPG ou GIF.',
                    'image_couverture.max' => 'L\'image ne doit pas dépasser 10 Mo.',
                ]);
                $validated['image_couverture'] = $imageValidation['image_couverture'];
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('❌ [STORE COURS] Erreur de validation de l\'image', [
                    'errors' => $e->errors(),
                ]);
                throw $e;
            }
        }
        
        // Log des données brutes avant validation
        Log::info('🔍 [STORE COURS] Données brutes reçues avant validation', [
            'request_all_keys' => array_keys($request->all()),
            'contenu_present' => $request->has('contenu'),
            'contenu_raw' => $request->input('contenu'),
            'contenu_type' => gettype($request->input('contenu')),
            'contenu_count' => is_array($request->input('contenu')) ? count($request->input('contenu')) : 0,
        ]);
        
        Log::info('✅ [STORE COURS] Validation réussie', [
            'user_email' => $user->email,
            'validated_keys' => array_keys($validated),
            'has_image_in_validated' => isset($validated['image_couverture']),
            'contenu_validated' => $validated['contenu'] ?? 'N/A',
            'contenu_type' => isset($validated['contenu']) ? gettype($validated['contenu']) : 'N/A',
            'contenu_count' => isset($validated['contenu']) && is_array($validated['contenu']) ? count($validated['contenu']) : 0,
        ]);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ [STORE COURS] Erreur de validation', [
                'user_email' => $user->email ?? 'N/A',
                'errors' => $e->errors(),
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
        
        // SÉCURITÉ : Forcer les valeurs de filière et niveau_etude basées sur le formateur
        $validated['filiere'] = $user->filiere;
        $validated['niveau_etude'] = $formateurNiveauEtude;
        
        // Gérer l'upload de l'image de couverture
        $imagePath = null;
        if ($request->hasFile('image_couverture')) {
            try {
                Log::info('🔍 [UPLOAD IMAGE] Début du processus d\'upload', [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'has_file' => $request->hasFile('image_couverture'),
                ]);
                
                $image = $request->file('image_couverture');
                
                if (!$image) {
                    Log::error('❌ [UPLOAD IMAGE] Impossible de récupérer le fichier');
                    return back()->withErrors(['image_couverture' => 'Impossible de récupérer le fichier image.'])->withInput();
                }
                
                // Vérifier que le fichier est valide avant d'accéder à ses propriétés
                if (!$image->isValid()) {
                    $errorCode = $image->getError();
                    $errorMessage = $image->getErrorMessage();
                    Log::error('❌ [UPLOAD IMAGE] Fichier invalide', [
                        'error_code' => $errorCode,
                        'error_message' => $errorMessage,
                        'php_upload_max_filesize' => ini_get('upload_max_filesize'),
                        'php_post_max_size' => ini_get('post_max_size'),
                    ]);
                    
                    // Messages d'erreur spécifiques selon le code d'erreur PHP
                    $userMessage = 'Le fichier image est invalide : ' . $errorMessage;
                    if ($errorCode == UPLOAD_ERR_INI_SIZE || $errorCode == UPLOAD_ERR_FORM_SIZE) {
                        $maxSize = ini_get('upload_max_filesize');
                        // Convertir en Mo si nécessaire (remplacer M par Mo)
                        $maxSizeDisplay = str_replace('M', 'Mo', $maxSize);
                        $userMessage = 'L\'image est trop volumineuse. Taille maximale : ' . $maxSizeDisplay . '. Veuillez réduire la taille de l\'image ou contacter l\'administrateur pour augmenter les limites.';
                    } elseif ($errorCode == UPLOAD_ERR_PARTIAL) {
                        $userMessage = 'L\'image n\'a été que partiellement téléchargée. Veuillez réessayer.';
                    } elseif ($errorCode == UPLOAD_ERR_NO_FILE) {
                        $userMessage = 'Aucun fichier n\'a été téléchargé. Veuillez sélectionner une image.';
                    }
                    
                    return back()->withErrors(['image_couverture' => $userMessage])->withInput();
                }
                
                // Maintenant que le fichier est valide, on peut accéder à ses propriétés
                Log::info('🔍 [UPLOAD IMAGE] Fichier récupéré et valide', [
                    'original_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'is_valid' => $image->isValid(),
                ]);
                
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                Log::info('🔍 [UPLOAD IMAGE] Nom du fichier généré', [
                    'image_name' => $imageName,
                ]);
                
                // S'assurer que le dossier existe
                $directory = 'cours/couvertures';
                $directoryExists = Storage::disk('public')->exists($directory);
                
                Log::info('🔍 [UPLOAD IMAGE] Vérification du dossier', [
                    'directory' => $directory,
                    'exists' => $directoryExists,
                    'full_path' => storage_path('app/public/' . $directory),
                ]);
                
                if (!$directoryExists) {
                    Log::info('🔍 [UPLOAD IMAGE] Création du dossier', [
                        'directory' => $directory,
                    ]);
                    Storage::disk('public')->makeDirectory($directory);
                    
                    // Vérifier que le dossier a bien été créé
                    $directoryExistsAfter = Storage::disk('public')->exists($directory);
                    Log::info('🔍 [UPLOAD IMAGE] Dossier créé', [
                        'directory' => $directory,
                        'exists_after' => $directoryExistsAfter,
                    ]);
                }
                
                Log::info('🔍 [UPLOAD IMAGE] Tentative de stockage', [
                    'directory' => $directory,
                    'image_name' => $imageName,
                    'disk' => 'public',
                ]);
                
                $imagePath = $image->storeAs($directory, $imageName, 'public');
                
                Log::info('🔍 [UPLOAD IMAGE] Résultat du stockage', [
                    'image_path' => $imagePath,
                    'path_is_null' => is_null($imagePath),
                    'path_is_empty' => empty($imagePath),
                ]);
                
                if (!$imagePath) {
                    Log::error('❌ [UPLOAD IMAGE] Échec du stockage - imagePath est null ou vide', [
                        'image_path' => $imagePath,
                        'directory' => $directory,
                        'image_name' => $imageName,
                    ]);
                    return back()->withErrors(['image_couverture' => 'L\'image de couverture n\'a pas pu être téléchargée.'])->withInput();
                }
                
                // Vérifier que le fichier existe réellement
                $fileExists = Storage::disk('public')->exists($imagePath);
                Log::info('🔍 [UPLOAD IMAGE] Vérification de l\'existence du fichier', [
                    'image_path' => $imagePath,
                    'file_exists' => $fileExists,
                    'full_path' => storage_path('app/public/' . $imagePath),
                ]);
                
                if (!$fileExists) {
                    Log::error('❌ [UPLOAD IMAGE] Le fichier n\'existe pas après le stockage', [
                        'image_path' => $imagePath,
                        'full_path' => storage_path('app/public/' . $imagePath),
                    ]);
                    return back()->withErrors(['image_couverture' => 'L\'image a été téléchargée mais le fichier n\'a pas été trouvé.'])->withInput();
                }
                
                Log::info('✅ [UPLOAD IMAGE] Upload réussi', [
                    'image_path' => $imagePath,
                    'file_exists' => $fileExists,
                ]);
                
            } catch (\Exception $e) {
                Log::error('❌ [UPLOAD IMAGE] Exception lors de l\'upload', [
                    'error' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['image_couverture' => 'Erreur lors du téléchargement de l\'image : ' . $e->getMessage()])->withInput();
            }
        } else {
            Log::info('ℹ️ [UPLOAD IMAGE] Aucun fichier image fourni', [
                'has_file' => $request->hasFile('image_couverture'),
            ]);
        }
        
        // Traiter le contenu avec les fichiers PDF
        $contenu = [];
        if (isset($validated['contenu']) && is_array($validated['contenu'])) {
            foreach ($validated['contenu'] as $index => $section) {
                // Gérer les sous-titres multiples
                $sousTitres = [];
                // Vérifier si sous_titres existe et n'est pas null (isset retourne true même si null)
                if (isset($section['sous_titres']) && $section['sous_titres'] !== null) {
                    if (is_array($section['sous_titres'])) {
                        // Filtrer les valeurs vides et réindexer
                        $sousTitres = array_values(array_filter($section['sous_titres'], function($item) {
                            return $item !== null && $item !== '' && trim($item) !== '';
                        }));
                    } elseif (is_string($section['sous_titres']) && trim($section['sous_titres']) !== '') {
                        $sousTitres = [trim($section['sous_titres'])];
                    }
                } elseif (isset($section['sous_titre']) && $section['sous_titre'] !== null && !empty(trim($section['sous_titre']))) {
                    // Compatibilité avec l'ancien format (un seul sous-titre)
                    $sousTitres = [trim($section['sous_titre'])];
                }
                
                // Log pour déboguer
                Log::info('🔍 [STORE COURS] Traitement des sous-titres pour section', [
                    'section_index' => $index,
                    'section_titre' => $section['titre'] ?? 'N/A',
                    'has_sous_titres_key' => isset($section['sous_titres']),
                    'sous_titres_value' => $section['sous_titres'] ?? 'N/A',
                    'sous_titres_is_null' => isset($section['sous_titres']) && $section['sous_titres'] === null,
                    'sous_titres_type' => isset($section['sous_titres']) ? gettype($section['sous_titres']) : 'N/A',
                    'raw_sous_titre' => $section['sous_titre'] ?? 'N/A',
                    'sous_titres_final' => $sousTitres,
                    'sous_titres_count' => count($sousTitres),
                    'sous_titres_not_empty' => !empty($sousTitres),
                    'section_all_keys' => array_keys($section),
                ]);
                
                $sectionData = [
                    'titre' => $section['titre'] ?? null,
                    'sous_titres' => !empty($sousTitres) ? $sousTitres : null, // Garder null si vide pour éviter de stocker un tableau vide
                    'description' => $section['description'] ?? null,
                    'lien_video' => $section['lien_video'] ?? null,
                    'duree_quiz_heures' => isset($section['duree_quiz_heures']) && $section['duree_quiz_heures'] !== '' ? (int)$section['duree_quiz_heures'] : null,
                    'duree_quiz_minutes' => isset($section['duree_quiz_minutes']) && $section['duree_quiz_minutes'] !== '' ? (int)$section['duree_quiz_minutes'] : null,
                ];
                
                // Gérer l'upload du fichier PDF pour cette section
                $pdfKey = 'contenu.' . $index . '.fichier_pdf_file';
                if ($request->hasFile($pdfKey)) {
                    $pdf = $request->file($pdfKey);
                    $pdfName = time() . '_' . $index . '_' . $pdf->getClientOriginalName();
                    $pdfPath = $pdf->storeAs('cours/pdf', $pdfName, 'public');
                    $sectionData['fichier_pdf'] = $pdfPath;
                } elseif (isset($section['fichier_pdf'])) {
                    // Garder l'ancien fichier si pas de nouveau upload
                    $sectionData['fichier_pdf'] = $section['fichier_pdf'];
                }
                
                // Ne garder que les sections avec au moins un titre
                if (!empty($sectionData['titre'])) {
                    $contenu[] = $sectionData;
                    Log::info('🔍 [STORE COURS] Section ajoutée au contenu', [
                        'section_index' => $index,
                        'sectionData' => $sectionData,
                    ]);
                }
            }
        }
        
        // Créer le cours
        Log::info('🔍 [STORE COURS] Avant création du cours', [
            'user_email' => $user->email,
            'titre' => $validated['titre'],
            'has_image' => !is_null($imagePath),
            'contenu_count' => count($contenu),
            'contenu_full' => json_encode($contenu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        ]);
        
        try {
            $cours = Cours::create([
                'titre' => $validated['titre'],
                'description' => $validated['description'] ?? null,
                'image_couverture' => $imagePath,
                'contenu' => !empty($contenu) ? $contenu : null,
                'filiere' => $validated['filiere'],
                'niveau_etude' => $validated['niveau_etude'],
                'duree' => $validated['duree'] ?? null,
                'ordre' => $validated['ordre'] ?? 0,
                'actif' => $validated['actif'] ?? true,
                'formateur_id' => $user->id,
            ]);
            
            Log::info('✅ [STORE COURS] Cours créé en base de données', [
                'cours_id' => $cours->id,
                'user_email' => $user->email,
            ]);
        } catch (\Exception $e) {
            Log::error('❌ [STORE COURS] Erreur lors de la création du cours', [
                'user_email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Erreur lors de la création du cours : ' . $e->getMessage()])->withInput();
        }
        
        // Traiter les questions
        try {
            $this->processQuestions($request, $cours);
        } catch (\Exception $e) {
            Log::error('❌ [STORE COURS] Erreur lors du traitement des questions', [
                'cours_id' => $cours->id,
                'user_email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Ne pas bloquer la création du cours si les questions échouent
        }
        
        Log::info('✅ [STORE COURS] Cours créé avec succès, redirection...', [
            'cours_id' => $cours->id,
            'user_email' => $user->email,
        ]);
        
        // Utiliser redirect()->back() avec un fallback vers la route pour éviter les problèmes de cache
        return redirect()->route('formateur.cours.create')
            ->with('success', 'Cours envoyé avec succès !')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
    
    /**
     * Afficher le formulaire d'édition d'un cours
     */
    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $cours = Cours::where('id', $id)
            ->where('formateur_id', $user->id)
            ->with(['questions' => function($query) {
                $query->orderBy('ordre');
            }])
            ->firstOrFail();
        
        // SÉCURITÉ : Vérifier que le formateur a une classe et une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            abort(403, 'Accès refusé. Vous n\'avez pas de classe ou filière assignée.');
        }
        
        // Récupérer les matières enseignées par le formateur
        $matieres = $user->matieres()->get();
        
        // SÉCURITÉ : Récupérer UNIQUEMENT la filière et le niveau du formateur
        $formateurFiliere = $user->filiere;
        
        // Mapper classe_id du formateur vers niveau_etude
        $classeToNiveauMap = [
            'licence_1' => 'Licence 1',
            'licence_2' => 'Licence 2',
            'licence_3' => 'Licence 3'
        ];
        $formateurNiveauEtude = null;
        if ($user->classe_id && isset($classeToNiveauMap[$user->classe_id])) {
            $formateurNiveauEtude = $classeToNiveauMap[$user->classe_id];
        }
        
        // Récupérer la première matière du formateur (pour affichage)
        $matierePrincipale = $matieres->first();
        $matiereNom = $matierePrincipale ? ($matierePrincipale->nom_matiere ?? $matierePrincipale->nom ?? 'N/A') : 'N/A';
        
        return view('formateur.cours-create', compact('user', 'cours', 'matieres', 'formateurFiliere', 'formateurNiveauEtude', 'matiereNom'));
    }
    
    /**
     * Mettre à jour un cours
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $cours = Cours::where('id', $id)
            ->where('formateur_id', $user->id)
            ->firstOrFail();
        
        // SÉCURITÉ : Vérifier que le formateur a une classe et une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            abort(403, 'Accès refusé. Vous n\'avez pas de classe ou filière assignée.');
        }
        
        // Mapper classe_id du formateur vers niveau_etude
        $classeToNiveauMap = [
            'licence_1' => 'Licence 1',
            'licence_2' => 'Licence 2',
            'licence_3' => 'Licence 3'
        ];
        $formateurNiveauEtude = null;
        if ($user->classe_id && isset($classeToNiveauMap[$user->classe_id])) {
            $formateurNiveauEtude = $classeToNiveauMap[$user->classe_id];
        }
        
        // Log des données brutes avant validation
        Log::info('🔍 [UPDATE COURS] Données brutes reçues avant validation', [
            'request_all_keys' => array_keys($request->all()),
            'contenu_present' => $request->has('contenu'),
            'contenu_raw' => $request->input('contenu'),
            'contenu_type' => gettype($request->input('contenu')),
            'contenu_count' => is_array($request->input('contenu')) ? count($request->input('contenu')) : 0,
            'has_image_file' => $request->hasFile('image_couverture'),
            'image_present_in_all' => in_array('image_couverture', array_keys($request->all())),
        ]);
        
        // Validation sans la règle 'uploaded' pour image_couverture pour éviter les erreurs prématurées
        // On validera manuellement l'image si elle est présente
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Ne pas valider image_couverture ici si hasFile() retourne false, on le fera manuellement
            // 'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10 Mo = 10240 KB
            'contenu' => 'nullable|array',
            'contenu.*.titre' => 'nullable|string|max:255',
            'contenu.*.description' => 'nullable|string',
            'contenu.*.lien_video' => 'nullable|string|max:500',
            'contenu.*.fichier_pdf' => 'nullable|string',
            'contenu.*.fichier_pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'contenu.*.sous_titres' => 'nullable|array', // Ajouter la validation pour sous_titres
            'contenu.*.sous_titres.*' => 'nullable|string', // Validation pour chaque sous-titre
            'contenu.*.duree_quiz_heures' => 'nullable|integer|min:0|max:23', // Heures du quiz
            'contenu.*.duree_quiz_minutes' => 'nullable|integer|min:0|max:59', // Minutes du quiz
            'questions' => 'nullable|array',
            'questions.*.*.type' => 'nullable|in:vrai_faux,choix_multiple,texte_libre,image,numerique',
            'questions.*.*.question' => 'nullable|string',
            'questions.*.*.points' => 'nullable|integer|min:1',
            'questions.*.*.image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duree' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'nullable|boolean',
        ]);
        
        // Valider manuellement l'image si elle est présente
        if ($request->hasFile('image_couverture')) {
            try {
                $imageValidation = $request->validate([
                    'image_couverture' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // 10 Mo = 10240 KB
                ], [
                    'image_couverture.image' => 'Le fichier doit être une image.',
                    'image_couverture.mimes' => 'L\'image doit être au format : JPEG, PNG, JPG ou GIF.',
                    'image_couverture.max' => 'L\'image ne doit pas dépasser 10 Mo.',
                ]);
                // L'image est validée, elle sera traitée dans la section upload ci-dessous
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('❌ [UPDATE COURS] Erreur de validation de l\'image', [
                    'errors' => $e->errors(),
                ]);
                throw $e;
            }
        }
        
        // Log des données validées
        Log::info('🔍 [UPDATE COURS] Données validées', [
            'contenu_validated' => $validated['contenu'] ?? 'N/A',
            'contenu_type' => isset($validated['contenu']) ? gettype($validated['contenu']) : 'N/A',
            'contenu_count' => isset($validated['contenu']) && is_array($validated['contenu']) ? count($validated['contenu']) : 0,
        ]);
        
        // SÉCURITÉ : Forcer les valeurs de filière et niveau_etude basées sur le formateur
        $validated['filiere'] = $user->filiere;
        $validated['niveau_etude'] = $formateurNiveauEtude;
        
        // Gérer l'upload de l'image de couverture
        // Vérifier si un fichier est présent (hasFile() peut retourner false même si le fichier existe dans allFiles())
        $hasImageFile = $request->hasFile('image_couverture');
        $imageFile = $request->file('image_couverture');
        $allFiles = $request->allFiles();
        
        // Log détaillé pour comprendre pourquoi hasFile() retourne false
        \Log::info('🔍 [UPLOAD IMAGE UPDATE] Vérification du fichier', [
            'has_file' => $hasImageFile,
            'has_input' => $request->has('image_couverture'),
            'all_files_keys' => array_keys($allFiles),
            'image_couverture_in_all_files' => isset($allFiles['image_couverture']),
            'file_image_couverture' => $imageFile ? 'PRESENT' : 'NULL',
            'file_is_valid' => $imageFile && $imageFile->isValid(),
            'file_error' => $imageFile ? $imageFile->getError() : 'N/A',
            'file_error_message' => $imageFile ? $imageFile->getErrorMessage() : 'N/A',
            'php_upload_max_filesize' => ini_get('upload_max_filesize'),
            'php_post_max_size' => ini_get('post_max_size'),
        ]);
        
        // Vérifier si un fichier est présent et valide
        // Ne traiter que si hasFile() retourne true OU si le fichier existe et est valide
        $fileExistsInAllFiles = isset($allFiles['image_couverture']);
        $fileInAllFilesIsValid = false;
        
        if ($fileExistsInAllFiles && isset($allFiles['image_couverture'])) {
            $potentialFile = $allFiles['image_couverture'];
            if ($potentialFile instanceof \Illuminate\Http\UploadedFile) {
                $fileInAllFilesIsValid = $potentialFile->isValid();
            }
        }
        
        // Ne traiter l'upload que si le fichier est valide
        if ($hasImageFile || ($imageFile && $imageFile->isValid()) || $fileInAllFilesIsValid) {
            try {
                \Log::info('🔍 [UPLOAD IMAGE UPDATE] Début du processus d\'upload', [
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'cours_id' => $cours->id,
                    'has_file' => $request->hasFile('image_couverture'),
                ]);
                
                // Supprimer l'ancienne image si elle existe
                if ($cours->image_couverture && Storage::disk('public')->exists($cours->image_couverture)) {
                    \Log::info('🔍 [UPLOAD IMAGE UPDATE] Suppression de l\'ancienne image', [
                        'old_image_path' => $cours->image_couverture,
                    ]);
                    Storage::disk('public')->delete($cours->image_couverture);
                }
                
                // Utiliser le fichier déjà récupéré ou le récupérer à nouveau
                $image = $imageFile ?: $request->file('image_couverture');
                
                if (!$image) {
                    // Essayer de récupérer depuis allFiles() seulement si le fichier est valide
                    if (isset($allFiles['image_couverture'])) {
                        $potentialImage = $allFiles['image_couverture'];
                        // Vérifier que c'est bien un UploadedFile et qu'il est valide
                        if ($potentialImage instanceof \Illuminate\Http\UploadedFile && $potentialImage->isValid()) {
                            $image = $potentialImage;
                        }
                    }
                }
                
                if (!$image) {
                    \Log::error('❌ [UPLOAD IMAGE UPDATE] Impossible de récupérer le fichier', [
                        'has_file' => $hasImageFile,
                        'image_file_exists' => $imageFile !== null,
                        'file_in_all_files' => $fileExistsInAllFiles,
                    ]);
                    return back()->withErrors(['image_couverture' => 'Impossible de récupérer le fichier image.'])->withInput();
                }
                
                // Vérifier que le fichier est valide avant d'accéder à ses propriétés
                if (!$image->isValid()) {
                    $errorCode = $image->getError();
                    $errorMessage = $image->getErrorMessage();
                    \Log::error('❌ [UPLOAD IMAGE UPDATE] Fichier invalide', [
                        'error_code' => $errorCode,
                        'error_message' => $errorMessage,
                        'php_upload_max_filesize' => ini_get('upload_max_filesize'),
                        'php_post_max_size' => ini_get('post_max_size'),
                    ]);
                    
                    // Messages d'erreur spécifiques selon le code d'erreur PHP
                    $userMessage = 'Le fichier image est invalide : ' . $errorMessage;
                    if ($errorCode == UPLOAD_ERR_INI_SIZE || $errorCode == UPLOAD_ERR_FORM_SIZE) {
                        $maxSize = ini_get('upload_max_filesize');
                        // Convertir en Mo si nécessaire (remplacer M par Mo)
                        $maxSizeDisplay = str_replace('M', 'Mo', $maxSize);
                        $userMessage = 'L\'image est trop volumineuse. Taille maximale : ' . $maxSizeDisplay . '. Veuillez réduire la taille de l\'image ou contacter l\'administrateur pour augmenter les limites.';
                    } elseif ($errorCode == UPLOAD_ERR_PARTIAL) {
                        $userMessage = 'L\'image n\'a été que partiellement téléchargée. Veuillez réessayer.';
                    } elseif ($errorCode == UPLOAD_ERR_NO_FILE) {
                        $userMessage = 'Aucun fichier n\'a été téléchargé. Veuillez sélectionner une image.';
                    }
                    
                    return back()->withErrors(['image_couverture' => $userMessage])->withInput();
                }
                
                // Maintenant que le fichier est valide, on peut accéder à ses propriétés
                \Log::info('🔍 [UPLOAD IMAGE UPDATE] Fichier récupéré et valide', [
                    'original_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                    'is_valid' => $image->isValid(),
                ]);
                
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                \Log::info('🔍 [UPLOAD IMAGE UPDATE] Nom du fichier généré', [
                    'image_name' => $imageName,
                ]);
                
                // S'assurer que le dossier existe
                $directory = 'cours/couvertures';
                $directoryExists = Storage::disk('public')->exists($directory);
                
                \Log::info('🔍 [UPLOAD IMAGE UPDATE] Vérification du dossier', [
                    'directory' => $directory,
                    'exists' => $directoryExists,
                    'full_path' => storage_path('app/public/' . $directory),
                ]);
                
                if (!$directoryExists) {
                    \Log::info('🔍 [UPLOAD IMAGE UPDATE] Création du dossier', [
                        'directory' => $directory,
                    ]);
                    Storage::disk('public')->makeDirectory($directory);
                    
                    $directoryExistsAfter = Storage::disk('public')->exists($directory);
                    \Log::info('🔍 [UPLOAD IMAGE UPDATE] Dossier créé', [
                        'directory' => $directory,
                        'exists_after' => $directoryExistsAfter,
                    ]);
                }
                
                \Log::info('🔍 [UPLOAD IMAGE UPDATE] Tentative de stockage', [
                    'directory' => $directory,
                    'image_name' => $imageName,
                    'disk' => 'public',
                ]);
                
                $imagePath = $image->storeAs($directory, $imageName, 'public');
                
                \Log::info('🔍 [UPLOAD IMAGE UPDATE] Résultat du stockage', [
                    'image_path' => $imagePath,
                    'path_is_null' => is_null($imagePath),
                    'path_is_empty' => empty($imagePath),
                ]);
                
                if (!$imagePath) {
                    \Log::error('❌ [UPLOAD IMAGE UPDATE] Échec du stockage - imagePath est null ou vide', [
                        'image_path' => $imagePath,
                        'directory' => $directory,
                        'image_name' => $imageName,
                    ]);
                    return back()->withErrors(['image_couverture' => 'L\'image de couverture n\'a pas pu être téléchargée.'])->withInput();
                }
                
                // Vérifier que le fichier existe réellement
                $fileExists = Storage::disk('public')->exists($imagePath);
                \Log::info('🔍 [UPLOAD IMAGE UPDATE] Vérification de l\'existence du fichier', [
                    'image_path' => $imagePath,
                    'file_exists' => $fileExists,
                    'full_path' => storage_path('app/public/' . $imagePath),
                ]);
                
                if (!$fileExists) {
                    \Log::error('❌ [UPLOAD IMAGE UPDATE] Le fichier n\'existe pas après le stockage', [
                        'image_path' => $imagePath,
                        'full_path' => storage_path('app/public/' . $imagePath),
                    ]);
                    return back()->withErrors(['image_couverture' => 'L\'image a été téléchargée mais le fichier n\'a pas été trouvé.'])->withInput();
                }
                
                \Log::info('✅ [UPLOAD IMAGE UPDATE] Upload réussi', [
                    'image_path' => $imagePath,
                    'file_exists' => $fileExists,
                ]);
                
            } catch (\Exception $e) {
                \Log::error('❌ [UPLOAD IMAGE UPDATE] Exception lors de l\'upload', [
                    'error' => $e->getMessage(),
                    'error_code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors(['image_couverture' => 'Erreur lors du téléchargement de l\'image : ' . $e->getMessage()])->withInput();
            }
        } else {
            // Vérifier si le fichier existe mais n'a pas été détecté par hasFile()
            // Cela peut arriver si les limites PHP sont dépassées
            if ($imageFile && !$imageFile->isValid()) {
                $errorCode = $imageFile->getError();
                $errorMessage = $imageFile->getErrorMessage();
                \Log::error('❌ [UPLOAD IMAGE UPDATE] Fichier présent mais invalide', [
                    'error_code' => $errorCode,
                    'error_message' => $errorMessage,
                    'php_upload_max_filesize' => ini_get('upload_max_filesize'),
                    'php_post_max_size' => ini_get('post_max_size'),
                ]);
                
                // Messages d'erreur spécifiques selon le code d'erreur PHP
                $userMessage = 'L\'image de couverture n\'a pas pu être téléchargée.';
                if ($errorCode == UPLOAD_ERR_INI_SIZE || $errorCode == UPLOAD_ERR_FORM_SIZE) {
                    $maxSize = ini_get('upload_max_filesize');
                    // Convertir en Mo si nécessaire (remplacer M par Mo)
                    $maxSizeDisplay = str_replace('M', 'Mo', $maxSize);
                    $userMessage = 'L\'image est trop volumineuse. Taille maximale : ' . $maxSizeDisplay . '. Veuillez réduire la taille de l\'image ou contacter l\'administrateur pour augmenter les limites.';
                } elseif ($errorCode == UPLOAD_ERR_PARTIAL) {
                    $userMessage = 'L\'image n\'a été que partiellement téléchargée. Veuillez réessayer.';
                } elseif ($errorCode == UPLOAD_ERR_NO_FILE) {
                    // Pas de fichier, on garde l'ancienne image
                } else {
                    $userMessage = 'Erreur lors du téléchargement : ' . $errorMessage;
                }
                
                if ($errorCode != UPLOAD_ERR_NO_FILE) {
                    return back()->withErrors(['image_couverture' => $userMessage])->withInput();
                }
            }
            
            $imagePath = $cours->image_couverture; // Garder l'ancienne image
            \Log::info('ℹ️ [UPLOAD IMAGE UPDATE] Aucun nouveau fichier - conservation de l\'ancienne image', [
                'old_image_path' => $imagePath,
                'has_file_check' => $hasImageFile,
                'file_exists_but_invalid' => ($imageFile && !$imageFile->isValid()),
                'all_files' => array_keys($allFiles),
                'php_upload_max_filesize' => ini_get('upload_max_filesize'),
                'php_post_max_size' => ini_get('post_max_size'),
            ]);
        }
        
        // Log final de l'imagePath
        \Log::info('🔍 [UPLOAD IMAGE UPDATE] ImagePath final', [
            'image_path' => $imagePath,
            'image_path_is_null' => is_null($imagePath),
            'image_path_is_empty' => empty($imagePath),
        ]);
        
        // Traiter le contenu avec les fichiers PDF
        $contenu = [];
        // Récupérer le contenu existant pour préserver les valeurs non modifiées
        $existingContenu = $cours->contenu ?? [];
        if (isset($validated['contenu']) && is_array($validated['contenu'])) {
            foreach ($validated['contenu'] as $index => $section) {
                // Récupérer les valeurs existantes pour cette section si elles existent
                $existingSection = isset($existingContenu[$index]) ? $existingContenu[$index] : [];
                
                // Gérer les sous-titres multiples
                $sousTitres = [];
                // Vérifier si sous_titres existe et n'est pas null (isset retourne true même si null)
                if (isset($section['sous_titres']) && $section['sous_titres'] !== null) {
                    if (is_array($section['sous_titres'])) {
                        // Filtrer les valeurs vides et réindexer
                        $sousTitres = array_values(array_filter($section['sous_titres'], function($item) {
                            return $item !== null && $item !== '' && trim($item) !== '';
                        }));
                    } elseif (is_string($section['sous_titres']) && trim($section['sous_titres']) !== '') {
                        $sousTitres = [trim($section['sous_titres'])];
                    }
                } elseif (isset($section['sous_titre']) && $section['sous_titre'] !== null && !empty(trim($section['sous_titre']))) {
                    // Compatibilité avec l'ancien format (un seul sous-titre)
                    $sousTitres = [trim($section['sous_titre'])];
                }
                
                // Log pour déboguer
                Log::info('🔍 [UPDATE COURS] Traitement des sous-titres pour section', [
                    'section_index' => $index,
                    'section_titre' => $section['titre'] ?? 'N/A',
                    'has_sous_titres_key' => isset($section['sous_titres']),
                    'sous_titres_value' => $section['sous_titres'] ?? 'N/A',
                    'sous_titres_is_null' => isset($section['sous_titres']) && $section['sous_titres'] === null,
                    'sous_titres_type' => isset($section['sous_titres']) ? gettype($section['sous_titres']) : 'N/A',
                    'raw_sous_titre' => $section['sous_titre'] ?? 'N/A',
                    'sous_titres_final' => $sousTitres,
                    'sous_titres_count' => count($sousTitres),
                    'sous_titres_not_empty' => !empty($sousTitres),
                ]);
                
                $sectionData = [
                    'titre' => $section['titre'] ?? null,
                    'sous_titres' => !empty($sousTitres) ? $sousTitres : null, // Garder null si vide pour éviter de stocker un tableau vide
                    'description' => $section['description'] ?? null,
                    'lien_video' => $section['lien_video'] ?? null,
                    'duree_quiz_heures' => isset($section['duree_quiz_heures']) && $section['duree_quiz_heures'] !== '' ? (int)$section['duree_quiz_heures'] : (isset($existingSection['duree_quiz_heures']) ? (int)$existingSection['duree_quiz_heures'] : null),
                    'duree_quiz_minutes' => isset($section['duree_quiz_minutes']) && $section['duree_quiz_minutes'] !== '' ? (int)$section['duree_quiz_minutes'] : (isset($existingSection['duree_quiz_minutes']) ? (int)$existingSection['duree_quiz_minutes'] : null),
                ];
                
                // Gérer l'upload du fichier PDF pour cette section
                $pdfKey = 'contenu.' . $index . '.fichier_pdf_file';
                if ($request->hasFile($pdfKey)) {
                    // Supprimer l'ancien PDF si il existe
                    if (isset($section['fichier_pdf']) && $section['fichier_pdf'] && Storage::disk('public')->exists($section['fichier_pdf'])) {
                        Storage::disk('public')->delete($section['fichier_pdf']);
                    }
                    
                    $pdf = $request->file($pdfKey);
                    $pdfName = time() . '_' . $index . '_' . $pdf->getClientOriginalName();
                    $pdfPath = $pdf->storeAs('cours/pdf', $pdfName, 'public');
                    $sectionData['fichier_pdf'] = $pdfPath;
                } elseif (isset($section['fichier_pdf'])) {
                    // Garder l'ancien fichier si pas de nouveau upload
                    $sectionData['fichier_pdf'] = $section['fichier_pdf'];
                } elseif (isset($existingSection['fichier_pdf'])) {
                    // Préserver l'ancien fichier PDF si présent
                    $sectionData['fichier_pdf'] = $existingSection['fichier_pdf'];
                }
                
                // Ne garder que les sections avec au moins un titre
                if (!empty($sectionData['titre'])) {
                    $contenu[] = $sectionData;
                }
            }
        }
        
        // Log avant la mise à jour
        Log::info('🔍 [UPDATE COURS] Avant mise à jour du cours', [
            'cours_id' => $cours->id,
            'image_path' => $imagePath,
            'image_path_is_null' => is_null($imagePath),
            'old_image_couverture' => $cours->image_couverture,
            'will_update_image' => !is_null($imagePath),
        ]);
        
        // Préparer les données de mise à jour
        $updateData = [
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'contenu' => !empty($contenu) ? $contenu : null,
            'filiere' => $validated['filiere'],
            'niveau_etude' => $validated['niveau_etude'],
            'duree' => $validated['duree'] ?? null,
            'ordre' => $validated['ordre'] ?? $cours->ordre,
            'actif' => $validated['actif'] ?? $cours->actif,
        ];
        
        // Ne mettre à jour l'image que si un nouveau fichier a été uploadé avec succès
        // Si $imagePath est null, cela signifie qu'aucun nouveau fichier n'a été uploadé
        // Dans ce cas, on garde l'ancienne image (même si elle est null)
        // On ne met à jour que si $imagePath a une valeur (nouveau fichier uploadé)
        if ($imagePath !== null) {
            $updateData['image_couverture'] = $imagePath;
            Log::info('🔍 [UPDATE COURS] Image sera mise à jour', [
                'new_image_path' => $imagePath,
                'old_image_path' => $cours->image_couverture,
            ]);
        } else {
            // Ne pas inclure image_couverture dans updateData pour conserver l'ancienne valeur
            Log::info('🔍 [UPDATE COURS] Image ne sera pas mise à jour (conservation de l\'ancienne)', [
                'old_image_path' => $cours->image_couverture,
                'image_path_is_null' => true,
            ]);
        }
        
        $cours->update($updateData);
        
        // Log après la mise à jour
        $cours->refresh(); // Recharger depuis la base de données
        Log::info('🔍 [UPDATE COURS] Après mise à jour du cours', [
            'cours_id' => $cours->id,
            'image_couverture_after_update' => $cours->image_couverture,
            'image_updated' => $cours->image_couverture === $imagePath,
        ]);
        
        // Traiter les questions
        $this->processQuestions($request, $cours);
        
        return redirect()->route('formateur.cours')->with('success', 'Cours mis à jour avec succès !');
    }
    
    /**
     * Supprimer un cours
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $cours = Cours::where('id', $id)
            ->where('formateur_id', $user->id)
            ->firstOrFail();
        
        $cours->delete();
        
        return redirect()->route('formateur.cours')->with('success', 'Cours supprimé avec succès !');
    }
    
    /**
     * Traiter les questions du cours
     */
    private function processQuestions(Request $request, Cours $cours)
    {
        // Supprimer toutes les questions existantes pour ce cours
        Question::where('cours_id', $cours->id)->delete();
        
        // Récupérer les questions depuis la requête
        $questions = $request->input('questions', []);
        
        if (empty($questions) || !is_array($questions)) {
            return;
        }
        
        $ordre = 0;
        
        foreach ($questions as $sectionIndex => $sectionQuestions) {
            if (!is_array($sectionQuestions)) {
                continue;
            }
            
            foreach ($sectionQuestions as $questionIndex => $questionData) {
                if (empty($questionData['question'])) {
                    continue;
                }
                
                $question = new Question();
                $question->cours_id = $cours->id;
                $question->section_index = $sectionIndex;
                $question->type = $questionData['type'] ?? 'vrai_faux';
                $question->question = $questionData['question'];
                $question->ordre = $ordre++;
                $question->points = $questionData['points'] ?? 1;
                $question->explication = $questionData['explication'] ?? null;
                
                // Traiter selon le type
                switch ($question->type) {
                    case 'vrai_faux':
                        $question->reponse_correcte = $questionData['reponse_vrai_faux'] ?? null;
                        break;
                    
                    case 'choix_multiple':
                        if (isset($questionData['options']) && is_array($questionData['options'])) {
                            $options = [];
                            foreach ($questionData['options'] as $option) {
                                if (!empty($option['texte'])) {
                                    $options[] = [
                                        'texte' => $option['texte'],
                                        'correcte' => isset($option['correcte']) && $option['correcte'] == '1'
                                    ];
                                }
                            }
                            $question->options = $options;
                        }
                        break;
                    
                    case 'texte_libre':
                        $question->reponse_correcte = $questionData['reponse_texte_libre'] ?? null;
                        break;
                    
                    case 'image':
                        // Gérer l'upload de l'image
                        $imageKey = 'questions.' . $sectionIndex . '.' . $questionIndex . '.image_file';
                        if ($request->hasFile($imageKey)) {
                            $image = $request->file($imageKey);
                            $imageName = time() . '_' . $image->getClientOriginalName();
                            $imagePath = $image->storeAs('questions/images', $imageName, 'public');
                            $question->image = $imagePath;
                        } elseif (isset($questionData['image'])) {
                            $question->image = $questionData['image'];
                        }
                        $question->reponse_correcte = $questionData['reponse_image'] ?? null;
                        break;
                    
                    case 'numerique':
                        $question->reponse_correcte = $questionData['reponse_numerique'] ?? null;
                        break;
                }
                
                $question->save();
            }
        }
    }
}
