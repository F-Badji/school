{{-- Script pour gérer l'ouverture des modals de suppression --}}
@push('scripts')
<script>
(function() {
  function initDeleteModals() {
    // Gérer tous les boutons de suppression avec data-target
    const deleteButtons = document.querySelectorAll('[data-target^="#deleteConfirmModal"], [data-bs-target^="#deleteConfirmModal"]');
    
    deleteButtons.forEach(function(button) {
      // Retirer les anciens event listeners pour éviter les doublons
      const newButton = button.cloneNode(true);
      button.parentNode.replaceChild(newButton, button);
      
      newButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const targetId = this.getAttribute('data-target') || this.getAttribute('data-bs-target');
        if (!targetId) {
          console.error('No target found for button');
          return;
        }
        
        const modal = document.querySelector(targetId);
        if (!modal) {
          console.error('Modal not found:', targetId);
          return;
        }
        
        // Essayer d'ouvrir avec Bootstrap 4 (jQuery) - si disponible
        if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
          try {
            $(modal).modal('show');
            return;
          } catch(err) {
            console.warn('jQuery modal failed, trying fallback');
          }
        } 
        
        // Essayer avec Bootstrap 5
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
          try {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            return;
          } catch(err) {
            console.warn('Bootstrap 5 modal failed, trying fallback');
          }
        } 
        
        // Fallback vanilla JS pour Bootstrap 4
        modal.style.display = 'block';
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        modal.setAttribute('aria-modal', 'true');
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = '17px';
        
        // Créer backdrop si nécessaire
        let backdrop = document.querySelector('.modal-backdrop');
        if (!backdrop) {
          backdrop = document.createElement('div');
          backdrop.className = 'modal-backdrop fade show';
          backdrop.style.position = 'fixed';
          backdrop.style.top = '0';
          backdrop.style.left = '0';
          backdrop.style.zIndex = '1040';
          backdrop.style.width = '100vw';
          backdrop.style.height = '100vh';
          backdrop.style.backgroundColor = '#000';
          backdrop.style.opacity = '0.5';
          document.body.appendChild(backdrop);
          
          // Fermer la modal en cliquant sur le backdrop
          backdrop.addEventListener('click', function() {
            closeModalVanilla(modal, backdrop);
          });
        }
        
        // Gérer la fermeture avec le bouton close
        const closeBtn = modal.querySelector('[data-dismiss="modal"], [data-bs-dismiss="modal"], .close');
        if (closeBtn) {
          closeBtn.addEventListener('click', function() {
            closeModalVanilla(modal, backdrop);
          });
        }
        
        // Gérer la fermeture avec le bouton Annuler
        const cancelBtn = modal.querySelector('.btn-secondary');
        if (cancelBtn) {
          cancelBtn.addEventListener('click', function() {
            closeModalVanilla(modal, backdrop);
          });
        }
      });
    });
  }
  
  function closeModalVanilla(modal, backdrop) {
    if (modal) {
      modal.style.display = 'none';
      modal.classList.remove('show');
      modal.setAttribute('aria-hidden', 'true');
      modal.removeAttribute('aria-modal');
    }
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    if (backdrop && backdrop.parentNode) {
      backdrop.parentNode.removeChild(backdrop);
    }
  }
  
  // Initialiser quand le DOM est prêt
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDeleteModals);
  } else {
    initDeleteModals();
  }
  
  // Réinitialiser après les mises à jour AJAX si nécessaire
  if (typeof window !== 'undefined') {
    window.initDeleteModals = initDeleteModals;
  }
})();
</script>
@endpush

