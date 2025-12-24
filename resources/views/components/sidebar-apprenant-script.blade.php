<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Paramètres Button
        const parametresBtn = document.getElementById('parametresBtn');
        
        if (parametresBtn) {
            parametresBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                window.location.href = '{{ route('apprenant.parametres') }}';
            });
        }

        // Cours Dropdown
        const coursDropdownBtn = document.getElementById('coursDropdownBtn');
        const coursDropdownMenu = document.getElementById('coursDropdownMenu');
        
        if (coursDropdownBtn && coursDropdownMenu) {
            // Fermer le dropdown au chargement
            coursDropdownMenu.classList.add('hidden');
            
            coursDropdownBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                coursDropdownMenu.classList.toggle('hidden');
            });
            
            // Fermer le dropdown en cliquant ailleurs
            document.addEventListener('click', function(e) {
                if (!coursDropdownBtn.contains(e.target) && !coursDropdownMenu.contains(e.target)) {
                    coursDropdownMenu.classList.add('hidden');
                }
            });
            
            // Monitoring de la largeur du sidebar
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                let lastSidebarWidth = sidebar.offsetWidth;
                setInterval(function() {
                    const currentSidebarWidth = sidebar.offsetWidth;
                    if (lastSidebarWidth > 85 && currentSidebarWidth <= 85) {
                        coursDropdownMenu.classList.add('hidden');
                    }
                    lastSidebarWidth = currentSidebarWidth;
                }, 100);
            }
        }

    });
</script>

