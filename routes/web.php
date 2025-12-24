<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ApprenantController;
use App\Http\Controllers\Admin\FormateurController;
use App\Http\Controllers\Admin\ClasseController;
use App\Http\Controllers\Admin\CoursController;
use App\Http\Controllers\Admin\MatiereController;
use App\Http\Controllers\Admin\PaiementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CalendrierController;
use App\Http\Controllers\Admin\EmploiDuTempsController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\MesMessagesController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Apprenant\ApprenantDashboardController;
use App\Http\Controllers\Apprenant\CoursController as ApprenantCoursController;
use App\Http\Controllers\Apprenant\VideoConferenceController as ApprenantVideoConferenceController;
use App\Http\Controllers\Formateur\VideoConferenceController as FormateurVideoConferenceController;
use App\Http\Controllers\Formateur\FormateurDashboardController;

use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;

Route::get('/', function() {
    return app(PageController::class)->show('home');
})->name('home');

// Route pour le formulaire de contact
Route::post('/contact/send', [ContactController::class, 'sendContactForm'])->name('contact.send');

// Route pour l'abonnement newsletter
Route::post('/newsletter/subscribe', [ContactController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

// Routes pour les pages du template WordPress
Route::get('/a-propos', function() {
    return app(PageController::class)->show('about');
})->name('about');
Route::get('/academics', function() {
    return app(PageController::class)->show('academics');
})->name('academics');
Route::get('/academic-details', function() {
    return app(PageController::class)->show('academic-details');
})->name('academic-details');
Route::get('/faculties', function() {
    return app(PageController::class)->show('faculties');
})->name('faculties');
Route::get('/faculty-details', function() {
    return app(PageController::class)->show('faculty-details');
})->name('faculty-details');
Route::get('/campus-life', function() {
    return app(PageController::class)->show('campus-life');
})->name('campus-life');
Route::get('/blog', function() {
    return app(PageController::class)->show('blog');
})->name('blog');
Route::get('/single-post', function() {
    return app(PageController::class)->show('single-post');
})->name('single-post');
Route::get('/staff', function() {
    return app(PageController::class)->show('staff');
})->name('staff');
Route::get('/faq', function() {
    return app(PageController::class)->show('faq');
})->name('faq');
Route::get('/event', function() {
    return app(PageController::class)->show('event');
})->name('event');
Route::get('/how-to-apply', function() {
    return app(PageController::class)->show('how-to-apply');
})->name('how-to-apply');
Route::get('/contact', function() {
    return app(PageController::class)->show('contact');
})->name('contact');

Route::view('/mentions-legales', 'legal')->name('legal');
Route::view('/politique-de-confidentialite', 'privacy')->name('privacy');
Route::view('/conditions-utilisation', 'terms')->name('terms');

Route::get('/auth', function () {
    return redirect('/');
})->name('login');

// Route GET pour afficher le formulaire de connexion
Route::get('/auth/login', function () {
    return redirect('/')->with('show_login', true);
})->name('login.get');

Route::post('/auth/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes d'orientation (protégées par auth)
Route::middleware('auth')->group(function () {
    Route::get('/orientation', [\App\Http\Controllers\OrientationController::class, 'show'])->name('orientation.show');
    Route::post('/orientation', [\App\Http\Controllers\OrientationController::class, 'store'])->name('orientation.store');
    Route::get('/orientation/success', [\App\Http\Controllers\OrientationController::class, 'success'])->name('orientation.success');
    Route::get('/orientation/paiement/wave', [\App\Http\Controllers\OrientationController::class, 'wavePayment'])->name('orientation.wave.payment');
    Route::get('/orientation/paiement/wave/callback', [\App\Http\Controllers\OrientationController::class, 'waveCallback'])->name('orientation.wave.callback');
});

Route::middleware('auth')->group(function () {
    // Dashboard Admin - accessible uniquement par l'admin autorisé
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('admin')->name('dashboard');
    
    // Dashboard Apprenant - accessible uniquement par les apprenants
    Route::get('/apprenant/dashboard', [ApprenantDashboardController::class, 'index'])->middleware('apprenant')->name('apprenant.dashboard');
    
    // Dashboard Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/dashboard', [FormateurDashboardController::class, 'index'])->middleware('formateur')->name('formateur.dashboard');
    
    // Cours Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/cours', [\App\Http\Controllers\Formateur\FormateurCoursController::class, 'index'])->middleware('formateur')->name('formateur.cours');
    Route::get('/formateur/cours/create', [\App\Http\Controllers\Formateur\FormateurCoursController::class, 'create'])->middleware('formateur')->name('formateur.cours.create');
    Route::post('/formateur/cours', [\App\Http\Controllers\Formateur\FormateurCoursController::class, 'store'])->middleware('formateur')->name('formateur.cours.store');
    Route::get('/formateur/cours/{id}/edit', [\App\Http\Controllers\Formateur\FormateurCoursController::class, 'edit'])->middleware('formateur')->name('formateur.cours.edit');
    Route::put('/formateur/cours/{id}', [\App\Http\Controllers\Formateur\FormateurCoursController::class, 'update'])->middleware('formateur')->name('formateur.cours.update');
    Route::delete('/formateur/cours/{id}', [\App\Http\Controllers\Formateur\FormateurCoursController::class, 'destroy'])->middleware('formateur')->name('formateur.cours.destroy');
    
    // Notes Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/notes', [\App\Http\Controllers\Formateur\FormateurNoteController::class, 'index'])->middleware('formateur')->name('formateur.notes');
    Route::post('/formateur/notes', [\App\Http\Controllers\Formateur\FormateurNoteController::class, 'store'])->middleware('formateur')->name('formateur.notes.store');
    Route::delete('/formateur/notes/{id}', [\App\Http\Controllers\Formateur\FormateurNoteController::class, 'destroy'])->middleware('formateur')->name('formateur.notes.destroy');
    Route::post('/formateur/notes/send-to-admin', [\App\Http\Controllers\Formateur\FormateurNoteController::class, 'sendToAdmin'])->middleware('formateur')->name('formateur.notes.send-to-admin');
    
    // Calendrier Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/calendrier', [FormateurDashboardController::class, 'calendrier'])->middleware('formateur')->name('formateur.calendrier');
    Route::get('/formateur/calendrier/events', [\App\Http\Controllers\Admin\CalendrierController::class, 'events'])->middleware('formateur')->name('formateur.calendrier.events');
    Route::get('/formateur/emploi-du-temps', [FormateurDashboardController::class, 'getEmploiDuTemps'])->middleware('formateur')->name('formateur.emploi-du-temps');
    
    // Messages Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/messages', [FormateurDashboardController::class, 'messages'])->middleware('formateur')->name('formateur.messages');
    Route::post('/formateur/messages/send', [FormateurDashboardController::class, 'sendMessage'])->middleware('formateur')->name('formateur.messages.send');
    Route::get('/formateur/messages/thread/{receiverId}', [FormateurDashboardController::class, 'getThread'])->middleware('formateur')->name('formateur.messages.thread');
    Route::post('/formateur/messages/mark-as-read', [FormateurDashboardController::class, 'markAsRead'])->middleware('formateur')->name('formateur.messages.mark-as-read');
    Route::post('/formateur/calls/store', [FormateurDashboardController::class, 'storeCall'])->middleware('formateur')->name('formateur.calls.store');
    
    // Mes apprenants Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/apprenants', [FormateurDashboardController::class, 'apprenants'])->middleware('formateur')->name('formateur.apprenants');
    
    // Profil Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/profil', [FormateurDashboardController::class, 'profil'])->middleware('formateur')->name('formateur.profil');
    Route::post('/formateur/profil/update-password', [FormateurDashboardController::class, 'updatePassword'])->middleware('formateur')->name('formateur.profil.update-password');
    
    // Paramètres Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/parametres', [FormateurDashboardController::class, 'parametres'])->middleware('formateur')->name('formateur.parametres');
    Route::post('/formateur/parametres/update-password', [FormateurDashboardController::class, 'updatePassword'])->middleware('formateur')->name('formateur.update-password');
    Route::get('/formateur/apprenant/{id}/profil', [FormateurDashboardController::class, 'voirProfilApprenant'])->middleware('formateur')->name('formateur.apprenant.profil');
    
    // Devoirs Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/devoirs', [\App\Http\Controllers\Formateur\FormateurDevoirController::class, 'index'])->middleware('formateur')->name('formateur.devoirs');
    Route::get('/formateur/devoirs/create', [\App\Http\Controllers\Formateur\FormateurDevoirController::class, 'create'])->middleware('formateur')->name('formateur.devoirs.create');
    Route::post('/formateur/devoirs', [\App\Http\Controllers\Formateur\FormateurDevoirController::class, 'store'])->middleware('formateur')->name('formateur.devoirs.store');
    Route::get('/formateur/devoirs/{id}/edit', [\App\Http\Controllers\Formateur\FormateurDevoirController::class, 'edit'])->middleware('formateur')->name('formateur.devoirs.edit');
    Route::put('/formateur/devoirs/{id}', [\App\Http\Controllers\Formateur\FormateurDevoirController::class, 'update'])->middleware('formateur')->name('formateur.devoirs.update');
    Route::delete('/formateur/devoirs/{id}', [\App\Http\Controllers\Formateur\FormateurDevoirController::class, 'destroy'])->middleware('formateur')->name('formateur.devoirs.destroy');
    
    // Examens Formateur - accessible uniquement par les formateurs
    Route::get('/formateur/examens', [\App\Http\Controllers\Formateur\FormateurExamenController::class, 'index'])->middleware('formateur')->name('formateur.examens');
    Route::get('/formateur/examens/create', [\App\Http\Controllers\Formateur\FormateurExamenController::class, 'create'])->middleware('formateur')->name('formateur.examens.create');
    Route::post('/formateur/examens', [\App\Http\Controllers\Formateur\FormateurExamenController::class, 'store'])->middleware('formateur')->name('formateur.examens.store');
    Route::get('/formateur/examens/{id}/edit', [\App\Http\Controllers\Formateur\FormateurExamenController::class, 'edit'])->middleware('formateur')->name('formateur.examens.edit');
    Route::put('/formateur/examens/{id}', [\App\Http\Controllers\Formateur\FormateurExamenController::class, 'update'])->middleware('formateur')->name('formateur.examens.update');
    Route::delete('/formateur/examens/{id}', [\App\Http\Controllers\Formateur\FormateurExamenController::class, 'destroy'])->middleware('formateur')->name('formateur.examens.destroy');
    
    // Visioconférence Formateur
    Route::get('/formateur/video-conference/{coursId}/manage', [FormateurVideoConferenceController::class, 'manage'])->middleware('formateur')->name('formateur.video-conference.manage');
    Route::post('/formateur/video-conference/{sessionId}/participant/{participantId}/accept', [FormateurVideoConferenceController::class, 'acceptParticipant'])->middleware('formateur')->name('formateur.video-conference.accept');
    Route::post('/formateur/video-conference/{sessionId}/participant/{participantId}/reject', [FormateurVideoConferenceController::class, 'rejectParticipant'])->middleware('formateur')->name('formateur.video-conference.reject');
    Route::post('/formateur/video-conference/{sessionId}/participant/{participantId}/mute', [FormateurVideoConferenceController::class, 'muteParticipant'])->middleware('formateur')->name('formateur.video-conference.mute');
    Route::post('/formateur/video-conference/{sessionId}/participant/{participantId}/disable-camera', [FormateurVideoConferenceController::class, 'disableCamera'])->middleware('formateur')->name('formateur.video-conference.disable-camera');
    Route::post('/formateur/video-conference/{sessionId}/participant/{participantId}/expel', [FormateurVideoConferenceController::class, 'expelParticipant'])->middleware('formateur')->name('formateur.video-conference.expel');
    Route::get('/formateur/video-conference/{sessionId}/pending-participants', [FormateurVideoConferenceController::class, 'getPendingParticipants'])->middleware('formateur')->name('formateur.video-conference.pending');
    Route::get('/formateur/video-conference/{sessionId}/active-participants', [FormateurVideoConferenceController::class, 'getActiveParticipants'])->middleware('formateur')->name('formateur.video-conference.active');
    Route::post('/formateur/video-conference/{sessionId}/end', [FormateurVideoConferenceController::class, 'endSession'])->middleware('formateur')->name('formateur.video-conference.end');
    Route::post('/formateur/video-conference/{sessionId}/chat/send', [FormateurVideoConferenceController::class, 'sendChatMessage'])->middleware('formateur')->name('formateur.video-conference.chat.send');
    Route::get('/formateur/video-conference/{sessionId}/chat/messages', [FormateurVideoConferenceController::class, 'getChatMessages'])->middleware('formateur')->name('formateur.video-conference.chat.messages');
    Route::post('/formateur/video-conference/{sessionId}/participant/{participantId}/pin', [FormateurVideoConferenceController::class, 'pinParticipant'])->middleware('formateur')->name('formateur.video-conference.pin');
    Route::post('/formateur/video-conference/{sessionId}/unpin', [FormateurVideoConferenceController::class, 'unpinParticipant'])->middleware('formateur')->name('formateur.video-conference.unpin');
    Route::post('/formateur/video-conference/{sessionId}/view-mode', [FormateurVideoConferenceController::class, 'changeViewMode'])->middleware('formateur')->name('formateur.video-conference.view-mode');
    Route::post('/formateur/video-conference/{sessionId}/mute-all', [FormateurVideoConferenceController::class, 'muteAll'])->middleware('formateur')->name('formateur.video-conference.mute-all');
    Route::get('/formateur/video-conference/{sessionId}/statistics', [FormateurVideoConferenceController::class, 'getStatistics'])->middleware('formateur')->name('formateur.video-conference.statistics');
    Route::get('/formateur/video-conference/active-sessions', [FormateurVideoConferenceController::class, 'getActiveSessions'])->middleware('formateur')->name('formateur.video-conference.active-sessions');
    Route::post('/formateur/video-conference/{sessionId}/webrtc/offer', [FormateurVideoConferenceController::class, 'handleWebRTCOffer'])->middleware('formateur')->name('formateur.video-conference.webrtc.offer');
    Route::post('/formateur/video-conference/{sessionId}/webrtc/answer', [FormateurVideoConferenceController::class, 'handleWebRTCAnswer'])->middleware('formateur')->name('formateur.video-conference.webrtc.answer');
    Route::post('/formateur/video-conference/{sessionId}/webrtc/ice-candidate', [FormateurVideoConferenceController::class, 'handleWebRTCIceCandidate'])->middleware('formateur')->name('formateur.video-conference.webrtc.ice-candidate');
    Route::post('/apprenant/video-conference/{sessionId}/webrtc/offer', [ApprenantVideoConferenceController::class, 'handleWebRTCOffer'])->middleware('apprenant')->name('apprenant.video-conference.webrtc.offer');
    Route::post('/apprenant/video-conference/{sessionId}/webrtc/answer', [ApprenantVideoConferenceController::class, 'handleWebRTCAnswer'])->middleware('apprenant')->name('apprenant.video-conference.webrtc.answer');
    Route::post('/apprenant/video-conference/{sessionId}/webrtc/ice-candidate', [ApprenantVideoConferenceController::class, 'handleWebRTCIceCandidate'])->middleware('apprenant')->name('apprenant.video-conference.webrtc.ice-candidate');
    Route::post('/apprenant/video-conference/{sessionId}/raise-hand', [ApprenantVideoConferenceController::class, 'toggleRaiseHand'])->middleware('apprenant')->name('apprenant.video-conference.raise-hand');
    
    // Cours Apprenant - accessible uniquement par les apprenants (même interface que Dashboard)
    Route::get('/apprenant/cours', [ApprenantDashboardController::class, 'index'])->middleware('apprenant')->name('apprenant.cours');
    Route::post('/apprenant/favoris/toggle', [ApprenantDashboardController::class, 'toggleFavori'])->middleware('apprenant')->name('apprenant.favoris.toggle');
    Route::get('/apprenant/favoris/count', [ApprenantDashboardController::class, 'getFavorisCount'])->middleware('apprenant')->name('apprenant.favoris.count');
    
    // Professeurs Apprenant - accessible uniquement par les apprenants (même interface que Cours)
    Route::get('/apprenant/professeurs', [ApprenantCoursController::class, 'index'])->middleware('apprenant')->name('apprenant.professeurs');
    
    // Profil Professeur vu par Apprenant - accessible uniquement par les apprenants
    Route::get('/apprenant/professeur/{id}/profil', [ApprenantCoursController::class, 'voirProfilProfesseur'])->middleware('apprenant')->name('apprenant.professeur.profil');
    
    // Visioconférence Apprenant
    Route::get('/apprenant/video-conference/{coursId}/join', [ApprenantVideoConferenceController::class, 'join'])->middleware('apprenant')->name('apprenant.video-conference.join');
    Route::get('/apprenant/video-conference/{sessionId}/status', [ApprenantVideoConferenceController::class, 'checkStatus'])->middleware('apprenant')->name('apprenant.video-conference.status');
    Route::post('/apprenant/video-conference/{sessionId}/toggle-micro', [ApprenantVideoConferenceController::class, 'toggleMicro'])->middleware('apprenant')->name('apprenant.video-conference.toggle-micro');
    Route::post('/apprenant/video-conference/{sessionId}/toggle-camera', [ApprenantVideoConferenceController::class, 'toggleCamera'])->middleware('apprenant')->name('apprenant.video-conference.toggle-camera');
    Route::post('/apprenant/video-conference/{sessionId}/leave', [ApprenantVideoConferenceController::class, 'leave'])->middleware('apprenant')->name('apprenant.video-conference.leave');
    Route::post('/apprenant/video-conference/{sessionId}/mark-absent', [ApprenantVideoConferenceController::class, 'markAsAbsent'])->middleware('apprenant')->name('apprenant.video-conference.mark-absent');
    Route::post('/apprenant/video-conference/{sessionId}/mark-present', [ApprenantVideoConferenceController::class, 'markAsPresent'])->middleware('apprenant')->name('apprenant.video-conference.mark-present');
    Route::get('/apprenant/video-conference/active-sessions', [ApprenantVideoConferenceController::class, 'getActiveSessions'])->middleware('apprenant')->name('apprenant.video-conference.active-sessions');
    Route::get('/apprenant/video-conference/check-accepted', [ApprenantVideoConferenceController::class, 'checkAcceptedRequests'])->middleware('apprenant')->name('apprenant.video-conference.check-accepted');
    Route::get('/apprenant/video-conference/check-session-status/{coursId}', [ApprenantVideoConferenceController::class, 'checkSessionStatus'])->middleware('apprenant')->name('apprenant.video-conference.check-session-status');
    Route::post('/apprenant/video-conference/{sessionId}/chat/send', [ApprenantVideoConferenceController::class, 'sendChatMessage'])->middleware('apprenant')->name('apprenant.video-conference.chat.send');
    Route::get('/apprenant/video-conference/{sessionId}/chat/messages', [ApprenantVideoConferenceController::class, 'getChatMessages'])->middleware('apprenant')->name('apprenant.video-conference.chat.messages');
    Route::get('/apprenant/video-conference/{sessionId}/active-participants', [ApprenantVideoConferenceController::class, 'getActiveParticipants'])->middleware('apprenant')->name('apprenant.video-conference.active-participants');
    Route::get('/apprenant/video-conference/{sessionId}/info', [ApprenantVideoConferenceController::class, 'getSessionInfo'])->middleware('apprenant')->name('apprenant.video-conference.info');

    // Page du professeur de Introduction à l'Informatique de Gestion
    Route::get('/apprenant/professeur/informatique-gestion', [ApprenantDashboardController::class, 'professeurInformatiqueGestion'])->middleware('apprenant')->name('apprenant.professeur.informatique-gestion');
    
    // Page du professeur de Programmation en PHP
    Route::get('/apprenant/professeur/programmation-php', [ApprenantDashboardController::class, 'professeurProgrammationPhp'])->middleware('apprenant')->name('apprenant.professeur.programmation-php');
    
    // Page du professeur d'Algorithmes
    Route::get('/apprenant/professeur/algorithmes', [ApprenantDashboardController::class, 'professeurAlgorithmes'])->middleware('apprenant')->name('apprenant.professeur.algorithmes');
    
    // Route générique pour toutes les autres matières
    Route::get('/apprenant/professeur/matiere/{matiereSlug?}', [ApprenantDashboardController::class, 'professeurMatiere'])->middleware('apprenant')->name('apprenant.professeur.matiere');
    
    // Éditeur de cours
    Route::get('/apprenant/cours-editeur', [ApprenantDashboardController::class, 'coursEditeur'])->middleware('apprenant')->name('apprenant.cours-editeur');
    
    // Messages Apprenant
    Route::get('/apprenant/messages', [ApprenantDashboardController::class, 'messages'])->middleware('apprenant')->name('apprenant.messages');
    Route::post('/apprenant/messages/send', [ApprenantDashboardController::class, 'sendMessage'])->middleware('apprenant')->name('apprenant.messages.send');
    Route::get('/apprenant/messages/thread/{receiverId}', [ApprenantDashboardController::class, 'getThread'])->middleware('apprenant')->name('apprenant.messages.thread');
    Route::post('/apprenant/messages/mark-as-read', [ApprenantDashboardController::class, 'markAsRead'])->middleware('apprenant')->name('apprenant.messages.mark-as-read');
    Route::post('/apprenant/calls/store', [ApprenantDashboardController::class, 'storeCall'])->middleware('apprenant')->name('apprenant.calls.store');
    Route::get('/apprenant/forum/groups/{group}/members', [ApprenantDashboardController::class, 'getGroupMembers'])->middleware('apprenant')->name('apprenant.forum.groups.members');
    
    // Calendrier Apprenant
    Route::get('/apprenant/calendrier', [ApprenantDashboardController::class, 'calendrier'])->middleware('apprenant')->name('apprenant.calendrier');
    Route::get('/apprenant/calendrier/events', [\App\Http\Controllers\Admin\CalendrierController::class, 'events'])->middleware('apprenant')->name('apprenant.calendrier.events');
    Route::get('/apprenant/emploi-du-temps', [ApprenantDashboardController::class, 'getEmploiDuTemps'])->middleware('apprenant')->name('apprenant.emploi-du-temps');
    
    // Devoirs Apprenant
    Route::get('/apprenant/devoirs', [ApprenantDashboardController::class, 'devoirs'])->middleware('apprenant')->name('apprenant.devoirs');
    Route::get('/apprenant/devoirs/{id}/passer', [ApprenantDashboardController::class, 'passerDevoir'])->middleware('apprenant')->name('apprenant.devoir.passer');
    Route::post('/apprenant/devoirs/{id}/submit', [ApprenantDashboardController::class, 'submitDevoir'])->middleware('apprenant')->name('apprenant.devoir.submit');
    Route::post('/apprenant/devoirs/{id}/unlock', [ApprenantDashboardController::class, 'unlockDevoir'])->middleware('apprenant')->name('apprenant.devoir.unlock');
    Route::get('/apprenant/devoirs/{id}/check-time', [ApprenantDashboardController::class, 'checkDevoirTime'])->middleware('apprenant')->name('apprenant.devoir.check-time');
    
    // Notifications Apprenant
    Route::get('/apprenant/notifications/unread/count', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->middleware('apprenant')->name('apprenant.notifications.unread');
    Route::get('/apprenant/notifications/unread/details', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnread'])->middleware('apprenant')->name('apprenant.notifications.unread.details');
    Route::post('/apprenant/notifications/{id}/mark-as-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->middleware('apprenant')->name('apprenant.notifications.mark-as-read');
    
    // Notifications Formateur
    Route::get('/formateur/notifications/unread/count', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->middleware('formateur')->name('formateur.notifications.unread');
    Route::get('/formateur/notifications/unread/details', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnread'])->middleware('formateur')->name('formateur.notifications.unread.details');
    Route::post('/formateur/notifications/{id}/mark-as-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->middleware('formateur')->name('formateur.notifications.mark-as-read');
    
    // Examens Apprenant
    Route::get('/apprenant/examens', [ApprenantDashboardController::class, 'examens'])->middleware('apprenant')->name('apprenant.examens');
    Route::get('/apprenant/examens/{id}/passer', [ApprenantDashboardController::class, 'passerExamen'])->middleware('apprenant')->name('apprenant.examen.passer');
    Route::post('/apprenant/examens/{id}/submit', [ApprenantDashboardController::class, 'submitExamen'])->middleware('apprenant')->name('apprenant.examen.submit');
    Route::post('/apprenant/examens/{id}/unlock', [ApprenantDashboardController::class, 'unlockExamen'])->middleware('apprenant')->name('apprenant.examen.unlock');
    Route::get('/apprenant/examens/{id}/check-time', [ApprenantDashboardController::class, 'checkExamenTime'])->middleware('apprenant')->name('apprenant.examen.check-time');
    
    // Quiz Apprenant
    Route::get('/apprenant/quiz', [ApprenantDashboardController::class, 'quiz'])->middleware('apprenant')->name('apprenant.quiz');
    Route::post('/apprenant/quiz/submit', [ApprenantDashboardController::class, 'submitQuiz'])->middleware('apprenant')->name('apprenant.quiz-submit');
    Route::get('/apprenant/quiz/results', [ApprenantDashboardController::class, 'quizResults'])->middleware('apprenant')->name('apprenant.quiz-results');
    
    // Notes Apprenant
    Route::get('/apprenant/notes', [\App\Http\Controllers\AccountController::class, 'notes'])->middleware('apprenant')->name('apprenant.notes');
    
    // Paramètres Apprenant
    Route::get('/apprenant/parametres', [ApprenantDashboardController::class, 'parametres'])->middleware('apprenant')->name('apprenant.parametres');
    Route::post('/apprenant/update-password', [ApprenantDashboardController::class, 'updatePassword'])->middleware('apprenant')->name('apprenant.update-password');
    Route::get('/apprenant/telecharger-recu/{invoice}', [ApprenantDashboardController::class, 'telechargerRecu'])->middleware('apprenant')->name('apprenant.telecharger-recu');
    Route::get('/apprenant/telecharger-bulletin', [ApprenantDashboardController::class, 'telechargerBulletin'])->middleware('apprenant')->name('apprenant.telecharger-bulletin');

    // Account routes - accessibles uniquement par les apprenants
    Route::prefix('account')->name('account.')->middleware('apprenant')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
        Route::post('/settings/profile', [AccountController::class, 'updateProfile'])->name('settings.updateProfile');
        Route::post('/settings/password', [AccountController::class, 'updatePassword'])->name('settings.updatePassword');
        Route::get('/notes', [AccountController::class, 'notes'])->name('notes');
        Route::get('/notes/pdf', [AccountController::class, 'notesPdf'])->name('notes.pdf');
        Route::post('/notes/upload', [AccountController::class, 'uploadBulletin'])->name('notes.upload');
        Route::post('/notes/delete', [AccountController::class, 'deleteBulletin'])->name('notes.delete');
        Route::post('/notes/send', [AccountController::class, 'sendBulletin'])->name('notes.send');
        Route::post('/notes/store', [AccountController::class, 'storeNote'])->name('notes.store');
        Route::get('/notes/{id}', [AccountController::class, 'showNote'])->name('notes.show');
        Route::get('/notes/{id}/edit', [AccountController::class, 'editNote'])->name('notes.edit');
        Route::put('/notes/{id}', [AccountController::class, 'updateNote'])->name('notes.update');
        Route::delete('/notes/{id}', [AccountController::class, 'destroyNote'])->name('notes.destroy');
        Route::get('/security', [AccountController::class, 'security'])->name('security');
        Route::post('/security/delete-password', [AccountController::class, 'updateDeletePassword'])->name('security.updateDeletePassword');
        Route::get('/invoice', [AccountController::class, 'invoice'])->name('invoice');
        Route::delete('/sessions/{sessionId}', [AccountController::class, 'destroySession'])->name('sessions.destroy');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Account routes for admin
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
        Route::get('/security', [AccountController::class, 'security'])->name('security');
        Route::post('/security/delete-password', [AccountController::class, 'updateDeletePassword'])->name('security.updateDeletePassword');
        Route::post('/settings/profile', [AccountController::class, 'updateProfile'])->name('settings.updateProfile');
        Route::post('/settings/password', [AccountController::class, 'updatePassword'])->name('settings.updatePassword');
        Route::delete('/sessions/{sessionId}', [AccountController::class, 'destroySession'])->name('sessions.destroy');
        
        // Notes
        Route::get('/notes', [AccountController::class, 'notes'])->name('notes');
        Route::get('/notes/pdf', [AccountController::class, 'notesPdf'])->name('notes.pdf');
        Route::post('/notes/upload', [AccountController::class, 'uploadBulletin'])->name('notes.upload');
        Route::post('/notes/delete', [AccountController::class, 'deleteBulletin'])->name('notes.delete');
        Route::post('/notes/send', [AccountController::class, 'sendBulletin'])->name('notes.send');
        Route::post('/notes/store', [AccountController::class, 'storeNote'])->name('notes.store');
        Route::get('/notes/{id}', [AccountController::class, 'showNote'])->name('notes.show');
        Route::get('/notes/{id}/edit', [AccountController::class, 'editNote'])->name('notes.edit');
        Route::put('/notes/{id}', [AccountController::class, 'updateNote'])->name('notes.update');
        Route::delete('/notes/{id}', [AccountController::class, 'destroyNote'])->name('notes.destroy');
        
        // Apprenants
        Route::resource('apprenants', ApprenantController::class);
        Route::post('apprenants/{apprenant}/toggle-block', [ApprenantController::class, 'toggleBlock'])->name('apprenants.toggle-block');
        Route::get('apprenants/{apprenant}/bulletin', [ApprenantController::class, 'generateBulletin'])->name('apprenants.bulletin');
        
        // Apprenants Admin & Redoublants
        Route::get('apprenants-admin-redoublants', [ApprenantController::class, 'adminRedoublants'])->name('apprenants-admin-redoublants.index');
        Route::get('apprenants-admin-redoublants/{apprenant}', [ApprenantController::class, 'showAdminRedoublant'])->name('apprenants-admin-redoublants.show');
        Route::get('apprenants-admin-redoublants/{apprenant}/edit', [ApprenantController::class, 'editAdminRedoublant'])->name('apprenants-admin-redoublants.edit');
        Route::put('apprenants-admin-redoublants/{apprenant}', [ApprenantController::class, 'updateAdminRedoublant'])->name('apprenants-admin-redoublants.update');
        Route::delete('apprenants-admin-redoublants/{apprenant}', [ApprenantController::class, 'destroyAdminRedoublant'])->name('apprenants-admin-redoublants.destroy');
        Route::post('apprenants-admin-redoublants/{apprenant}/mark-admis', [ApprenantController::class, 'markAsAdmis'])->name('apprenants-admin-redoublants.mark-admis');
        Route::post('apprenants-admin-redoublants/{apprenant}/mark-redoublant', [ApprenantController::class, 'markAsRedoublant'])->name('apprenants-admin-redoublants.mark-redoublant');
        
        // Formateurs
        // Routes statiques AVANT la route resource pour éviter les conflits
        Route::get('formateurs/matieres-by-licence', [FormateurController::class, 'getMatieresByLicence'])->name('formateurs.matieres-by-licence');
        Route::get('formateurs/licences-by-filiere', [FormateurController::class, 'getLicencesByFiliere'])->name('formateurs.licences-by-filiere');
        Route::get('formateurs/filieres-by-licence', [FormateurController::class, 'getFilieresByLicence'])->name('formateurs.filieres-by-licence');
        Route::resource('formateurs', FormateurController::class);
        Route::post('formateurs/{formateur}/toggle-block', [FormateurController::class, 'toggleBlock'])->name('formateurs.toggle-block');
        
        // Classes
        Route::post('classes/{classe}/toggle-block', [ClasseController::class, 'toggleBlock'])->name('classes.toggle-block');
        Route::get('classes/{classe}/get', [ClasseController::class, 'get'])->name('classes.get');
        Route::resource('classes', ClasseController::class)->parameters(['classes' => 'classe']);
        
        // Cours
        Route::resource('cours', CoursController::class);
        
        // Matières
        Route::resource('matieres', MatiereController::class);
        
        // Calendrier
        Route::get('/calendrier/events', [CalendrierController::class, 'events'])->name('calendrier.events');
        Route::resource('calendrier', CalendrierController::class);

        // Emploi du temps
        Route::resource('emploi-du-temps', EmploiDuTempsController::class);

        // Paiements
        Route::get('/paiements/{user}/receipt', [PaiementController::class, 'receipt'])->name('paiements.receipt');
        Route::post('/paiements/{user}/update-status', [PaiementController::class, 'updateStatus'])->name('paiements.update-status');
        Route::resource('paiements', PaiementController::class)->parameters(['paiements' => 'user']);
        
        // Messages (tous les messages entre apprenants et formateurs)
        Route::get('/messages/thread/{senderId}/{receiverId}', [MessagesController::class, 'thread'])->name('messages.thread');
        Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
        Route::get('/messages/{id}', [MessagesController::class, 'show'])->name('messages.show');
        Route::get('/messages/{id}/edit', [MessagesController::class, 'edit'])->name('messages.edit');
        Route::put('/messages/{id}', [MessagesController::class, 'update'])->name('messages.update');
        Route::delete('/messages/{id}', [MessagesController::class, 'destroy'])->name('messages.destroy');
        Route::post('/messages/delete-students', [MessagesController::class, 'deleteStudentsMessages'])->name('messages.delete-students');
        Route::post('/messages/delete-teachers', [MessagesController::class, 'deleteTeachersMessages'])->name('messages.delete-teachers');
        
        // Mes Messages (messages personnels de l'admin)
        Route::post('/mes-messages/send', [MesMessagesController::class, 'send'])->name('mes-messages.send');
        Route::get('/mes-messages', [MesMessagesController::class, 'index'])->name('mes-messages.index');
        Route::get('/mes-messages/thread/{receiverId}', [MesMessagesController::class, 'getThread'])->name('mes-messages.thread');
        Route::get('/mes-messages/contacts', [MesMessagesController::class, 'getContacts'])->name('mes-messages.contacts');
        Route::post('/mes-messages/mark-as-read', [MesMessagesController::class, 'markAsRead'])->name('mes-messages.mark-as-read');
        Route::post('/mes-messages/calls/store', [MesMessagesController::class, 'storeCall'])->name('mes-messages.calls.store');

        // Forum Groups
        Route::post('/forum/groups/store', [MesMessagesController::class, 'storeForumGroup'])->name('forum.groups.store');
        Route::get('/forum/groups/users', [MesMessagesController::class, 'getUsersForGroup'])->name('forum.groups.users');
        Route::post('/forum/groups/{group}/update', [MesMessagesController::class, 'updateForumGroup'])->name('forum.groups.update');
        Route::post('/forum/groups/{group}/remove-member', [MesMessagesController::class, 'removeMemberFromGroup'])->name('forum.groups.remove-member');
        Route::get('/forum/groups/{group}/authorized-members', [MesMessagesController::class, 'getAuthorizedMembers'])->name('forum.groups.authorized-members');
        Route::post('/forum/groups/{group}/manage-authorized', [MesMessagesController::class, 'manageAuthorizedMembers'])->name('forum.groups.manage-authorized');
        Route::delete('/forum/groups/{group}', [MesMessagesController::class, 'destroyForumGroup'])->name('forum.groups.destroy');
        
        // Notifications
        Route::resource('notifications', NotificationController::class)->only(['index', 'store', 'destroy']);
        Route::get('/notifications/unread/count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread');
        Route::get('/notifications/unread/details', [NotificationController::class, 'getUnread'])->name('notifications.unread.details');
        Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    });
});