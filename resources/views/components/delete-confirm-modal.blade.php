{{-- Modal de confirmation de suppression avec mot de passe --}}
<div class="modal fade" id="deleteConfirmModal{{ $id ?? 'default' }}" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel{{ $id ?? 'default' }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmModalLabel{{ $id ?? 'default' }}">Confirmation de suppression</h5>
        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="deleteForm{{ $id ?? 'default' }}" method="POST" action="{{ $action }}">
        @csrf
        @method('DELETE')
        <div class="modal-body">
          <div class="alert alert-warning" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); color: #ffffff; border: none;">
            <i class="ni ni-notification-70" style="color: #ffffff;"></i>
            <strong style="color: #ffffff;">Attention !</strong> <span style="color: #ffffff;">Cette action est irréversible.</span>
          </div>
          <p>{{ $message ?? 'Êtes-vous sûr de vouloir supprimer cet élément ?' }}</p>
          <div class="form-group">
            <label for="deletePassword{{ $id ?? 'default' }}">Mot de passe de confirmation <span class="text-danger">*</span></label>
            <input type="password" 
                   class="form-control @error('delete_password') is-invalid @enderror" 
                   id="deletePassword{{ $id ?? 'default' }}" 
                   name="delete_password" 
                   placeholder="Entrez le mot de passe" 
                   required 
                   autocomplete="off"
                   autocomplete="new-password">
            <small class="form-text text-muted">Mot de passe requis</small>
            <div class="invalid-feedback" id="passwordError{{ $id ?? 'default' }}"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-danger text-white" id="confirmDeleteBtn{{ $id ?? 'default' }}" style="color: #ffffff !important;">
            <i class="bi bi-trash text-white" style="color: #ffffff !important;"></i> <span style="color: #ffffff !important;">Supprimer</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function() {
  const modalId = 'deleteConfirmModal{{ $id ?? 'default' }}';
  const formId = 'deleteForm{{ $id ?? 'default' }}';
  const passwordInputId = 'deletePassword{{ $id ?? 'default' }}';
  const errorDivId = 'passwordError{{ $id ?? 'default' }}';
  const confirmBtnId = 'confirmDeleteBtn{{ $id ?? 'default' }}';
  
  function initDeleteModal() {
    const modal = document.getElementById(modalId);
    const form = document.getElementById(formId);
    const passwordInput = document.getElementById(passwordInputId);
    const errorDiv = document.getElementById(errorDivId);
    const confirmBtn = document.getElementById(confirmBtnId);
    
    if (!form || !modal) return;
    
    // Réinitialiser le formulaire quand la modal est fermée
    function resetForm() {
      if (form) form.reset();
      if (passwordInput) passwordInput.classList.remove('is-invalid');
      if (errorDiv) errorDiv.textContent = '';
      if (confirmBtn) {
        confirmBtn.disabled = false;
        confirmBtn.innerHTML = '<i class="bi bi-trash text-white" style="color: #ffffff !important;"></i> <span style="color: #ffffff !important;">Supprimer</span>';
      }
    }
    
    // Gérer la fermeture de la modal (Bootstrap 4 et 5)
    if (typeof $ !== 'undefined' && $.fn.modal) {
      // Bootstrap 4 avec jQuery
      $(modal).on('hidden.bs.modal', resetForm);
    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      // Bootstrap 5
      const bsModal = new bootstrap.Modal(modal);
      modal.addEventListener('hidden.bs.modal', resetForm);
    } else {
      // Fallback vanilla JS
      modal.addEventListener('hidden', resetForm);
    }
    
    // Gérer la soumission du formulaire
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const password = passwordInput ? passwordInput.value.trim() : '';
      const requiredPassword = '{{ config('delete_password.password', '022001') }}';
      
      if (password !== requiredPassword) {
        if (passwordInput) passwordInput.classList.add('is-invalid');
        if (errorDiv) errorDiv.textContent = 'Mot de passe incorrect. Veuillez réessayer.';
        return;
      }
      
      // Désactiver le bouton pour éviter les doubles soumissions
      if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="bi bi-hourglass-split text-white" style="color: #ffffff !important;"></i> <span style="color: #ffffff !important;">Suppression...</span>';
      }
      
      // Soumettre le formulaire
      form.submit();
    });
    
    // Réinitialiser l'erreur quand l'utilisateur tape
    if (passwordInput) {
      passwordInput.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
          this.classList.remove('is-invalid');
          if (errorDiv) errorDiv.textContent = '';
        }
      });
    }
  }
  
  // Initialiser quand le DOM est prêt
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDeleteModal);
  } else {
    initDeleteModal();
  }
})();
</script>
@endpush

