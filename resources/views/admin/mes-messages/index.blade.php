<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Messages - BJ Academie</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap CSS pour les composants de recherche (identique à Mes Notes) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

    </style>

    <style>
        /* Ajustement des boutons d'action : les déplacent légèrement vers la gauche */
        #groupAddMemberBtn,
        #groupSaveBtn {
            transform: translateX(-30px);
            transition: transform 0.12s ease;
        }
        @media (max-width: 640px) {
            /* Sur mobile, ne pas décaler pour éviter débordements */
            #groupAddMemberBtn,
            #groupSaveBtn { transform: translateX(0); }
        }
    </style>
    <script>
        // --- Modal helper functions ---
        function openGroupModal(groupId) {
            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
            let members = [];
            let name = 'Groupe';
            let description = '';
            let avatar = null;
            const creatorId = chatItem ? parseInt(chatItem.getAttribute('data-group-creator')) : null;
            const currentUserId = {{ auth()->id() }};
            const isAdmin = {{ auth()->user()->role === 'admin' ? 'true' : 'false' }};
            if (chatItem) {
                name = chatItem.getAttribute('data-group-name') || name;
                description = chatItem.getAttribute('data-group-description') || '';
                avatar = chatItem.getAttribute('data-group-avatar') || '';
                try { members = JSON.parse(chatItem.getAttribute('data-group-members') || '[]'); } catch(e){ members = []; }
            }
            document.getElementById('groupModalTitle').textContent = name;
            document.getElementById('groupNameInput').value = name;
            document.getElementById('groupDescriptionInput').value = description;
            const restrictValue = chatItem ? parseInt(chatItem.getAttribute('data-group-restrict') || 0) : 0;
            document.getElementById('restrictMessagesCheckbox').checked = restrictValue === 1;
            
            // Load avatar if exists
            const avatarEl = document.getElementById('groupAvatar');
            const avatarBtn = document.getElementById('groupAvatarBtn');
            if (avatar && avatar.trim() !== '') {
                avatarEl.style.backgroundImage = `url(/storage/${avatar})`;
                avatarEl.style.backgroundSize = 'cover';
                avatarEl.style.backgroundPosition = 'center';
                // Ensure button is still visible
                if (avatarBtn && !avatarEl.contains(avatarBtn)) {
                    avatarEl.appendChild(avatarBtn);
                }
            } else {
                avatarEl.style.backgroundImage = '';
                avatarEl.style.background = '';
                // Ensure button is still visible
                if (avatarBtn && !avatarEl.contains(avatarBtn)) {
                    avatarEl.appendChild(avatarBtn);
                }
            }
            
            // Show/hide edit buttons based on admin status
            const editButtons = ['groupAddMemberBtn', 'groupSaveBtn', 'groupAvatarBtn', 'groupManageMembersBtn', 'groupDeleteBtn'];
            editButtons.forEach(btnId => {
                const btn = document.getElementById(btnId);
                if (btn) {
                    btn.style.display = isAdmin ? '' : 'none';
                }
            });
            
            // Disable inputs for non-admins
            document.getElementById('groupNameInput').disabled = !isAdmin;
            document.getElementById('groupDescriptionInput').disabled = !isAdmin;
            document.getElementById('restrictMessagesCheckbox').disabled = !isAdmin;
            const membersList = document.getElementById('groupMembersList');
            membersList.innerHTML = '';
            members.forEach(m => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between';
                const isCreator = creatorId && parseInt(m.id) === creatorId;
                const memberAction = isCreator 
                    ? '<span class="px-2 py-1 text-sm text-blue-600 font-medium">Admin du groupe</span>'
                    : (isAdmin ? `<button data-user-id="${m.id}" class="remove-member-btn px-2 py-1 text-sm text-red-600 hover:bg-red-50 rounded">Supprimer</button>` : '');
                div.innerHTML = `<div class="flex items-center gap-2">${m.photo ? `<img src="/storage/${m.photo}" class="w-8 h-8 rounded-full">` : `<div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs">${(m.prenom||'').charAt(0)}${(m.nom||'').charAt(0)}</div>`}<div><div class="font-medium">${m.prenom} ${m.nom}</div><div class="text-xs text-gray-500">${m.email}</div></div></div><div>${memberAction}</div>`;
                div.setAttribute('data-user-id', m.id);
                membersList.appendChild(div);
            });
            // attach remove handlers - only for non-creator members
            membersList.querySelectorAll('.remove-member-btn').forEach(btn => {
                btn.addEventListener('click', function(){
                    const userId = this.getAttribute('data-user-id');
                    const groupId = document.getElementById('groupDetailsModal').dataset.groupId;
                    if (!confirm('Êtes-vous sûr de vouloir supprimer ce membre du groupe ?')) return;
                    
                    // Remove from UI immediately
                    this.closest('div').remove();
                    
                    // Remove from server
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch(`/admin/forum/groups/${groupId}/remove-member`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ user_id: userId })
                    }).then(r => r.json()).then(data => {
                        if (!data.success) {
                            alert(data.message || 'Erreur lors de la suppression du membre');
                            // Reload modal to restore state
                            openGroupModal(groupId);
                        } else {
                            // Update chat item
                            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
                            if (chatItem) {
                                const currentMembers = JSON.parse(chatItem.getAttribute('data-group-members') || '[]');
                                const updatedMembers = currentMembers.filter(m => parseInt(m.id) !== parseInt(userId));
                                chatItem.setAttribute('data-group-members', JSON.stringify(updatedMembers));
                                // Update member count display
                                const memberCountEl = chatItem.querySelector('.text-xs.text-gray-500');
                                if (memberCountEl) {
                                    memberCountEl.textContent = `${updatedMembers.length} membre${updatedMembers.length > 1 ? 's' : ''}`;
                                }
                            }
                        }
                    }).catch(err => {
                        console.error(err);
                        alert('Erreur lors de la suppression du membre');
                        openGroupModal(groupId);
                    });
                });
            });

            // show modal
            const modal = document.getElementById('groupDetailsModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.dataset.groupId = groupId;
        }

        function closeGroupModal(){
            const modal = document.getElementById('groupDetailsModal');
            if (modal){ modal.classList.remove('flex'); modal.classList.add('hidden'); }
        }

        function handleAvatarSelected(e){
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev){
                const avatar = document.getElementById('groupAvatar');
                avatar.style.backgroundImage = `url(${ev.target.result})`;
                avatar.style.backgroundSize = 'cover';
                avatar.style.backgroundPosition = 'center';
                // Keep the button visible
                const btn = document.getElementById('groupAvatarBtn');
                if (btn && !avatar.contains(btn)) {
                    avatar.appendChild(btn);
                }
            };
            reader.readAsDataURL(file);
        }

        function openAddMembersPicker(){
            // Get current members to exclude them from the picker
            const membersList = document.getElementById('groupMembersList');
            const currentMemberIds = Array.from(membersList.querySelectorAll('[data-user-id]')).map(el => parseInt(el.getAttribute('data-user-id')));
            
            // reuse existing getUsersForGroup endpoint to fetch all users and show a picker
            fetch('{{ route("admin.forum.groups.users") }}')
                .then(r => r.json())
                .then(data => {
                    if (!data.success) return alert('Impossible de charger les utilisateurs');
                    const users = data.users.filter(u => !currentMemberIds.includes(parseInt(u.id)));
                    const picker = document.createElement('div');
                    picker.className = 'fixed inset-0 z-[100] flex items-center justify-center';
                    picker.style.zIndex = '100';
                    picker.innerHTML = `<div class="absolute inset-0 bg-black opacity-40"></div><div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl w-11/12 max-h-[80vh] overflow-hidden flex flex-col relative z-10"><h4 class="font-semibold text-lg mb-4">Ajouter des membres</h4><div id="usersPickerList" class="flex-1 overflow-y-auto grid grid-cols-1 gap-2 mb-4"></div><div class="flex justify-end gap-2 pt-4 border-t"><button id="pickerAddBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter sélectionnés</button> <button id="pickerCloseBtn" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Fermer</button></div></div>`;
                    document.body.appendChild(picker);
                    const list = picker.querySelector('#usersPickerList');
                    if (users.length === 0) {
                        list.innerHTML = '<p class="text-gray-500 text-center py-4">Tous les utilisateurs sont déjà membres du groupe.</p>';
                    } else {
                        users.forEach(u => {
                            const item = document.createElement('label');
                            item.className = 'flex items-center gap-3 p-3 border rounded hover:bg-gray-50 cursor-pointer';
                            const photoHtml = u.photo 
                                ? `<img src="/storage/${u.photo}" class="w-10 h-10 rounded-full object-cover">`
                                : `<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-medium">${(u.prenom||'').charAt(0)}${(u.nom||'').charAt(0)}</div>`;
                            item.innerHTML = `<input type="checkbox" value="${u.id}" class="mr-2" /> ${photoHtml} <div class="flex-1"><div class="font-medium">${u.prenom} ${u.nom}</div><div class="text-xs text-gray-500">${u.email}</div></div>`;
                            list.appendChild(item);
                        });
                    }
                    picker.querySelector('#pickerCloseBtn').addEventListener('click', ()=> picker.remove());
                    picker.querySelector('#pickerAddBtn').addEventListener('click', ()=>{
                        const checked = Array.from(picker.querySelectorAll('input[type=checkbox]:checked')).map(i=>parseInt(i.value));
                        if (checked.length === 0) {
                            alert('Veuillez sélectionner au moins un membre');
                            return;
                        }
                        const groupId = document.getElementById('groupDetailsModal').dataset.groupId;
                        const creatorId = parseInt(document.querySelector(`.chat-item[data-group-id="${groupId}"]`)?.getAttribute('data-group-creator') || '0');
                        
                        checked.forEach(id => {
                            const user = users.find(xx => parseInt(xx.id) === id);
                            if (!user) return;
                            const div = document.createElement('div');
                            div.className = 'flex items-center justify-between';
                            const isCreator = parseInt(user.id) === creatorId;
                            const memberAction = isCreator 
                                ? '<span class="px-2 py-1 text-sm text-blue-600 font-medium">Admin du groupe</span>'
                                : `<button data-user-id="${user.id}" class="remove-member-btn px-2 py-1 text-sm text-red-600 hover:bg-red-50 rounded">Supprimer</button>`;
                            div.innerHTML = `<div class="flex items-center gap-2">${user.photo ? `<img src="/storage/${user.photo}" class="w-8 h-8 rounded-full">` : `<div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-xs">${(user.prenom||'').charAt(0)}${(user.nom||'').charAt(0)}</div>`}<div><div class="font-medium">${user.prenom} ${user.nom}</div><div class="text-xs text-gray-500">${user.email}</div></div></div><div>${memberAction}</div>`;
                            div.setAttribute('data-user-id', user.id);
                            membersList.appendChild(div);
                            
                            // Attach remove handler if not creator
                            if (!isCreator) {
                                div.querySelector('.remove-member-btn').addEventListener('click', function(){
                                    const userId = this.getAttribute('data-user-id');
                                    if (!confirm('Êtes-vous sûr de vouloir supprimer ce membre du groupe ?')) return;
                                    this.closest('div').remove();
                                    // Remove from server
                                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                    fetch(`/admin/forum/groups/${groupId}/remove-member`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': token,
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ user_id: userId })
                                    }).then(r => r.json()).then(data => {
                                        if (!data.success) {
                                            alert(data.message || 'Erreur lors de la suppression du membre');
                                            openGroupModal(groupId);
                                        }
                                    }).catch(err => {
                                        console.error(err);
                                        alert('Erreur lors de la suppression du membre');
                                        openGroupModal(groupId);
                                    });
                                });
                            }
                        });
                        picker.remove();
                    });
                }).catch(err => { console.error(err); alert('Erreur chargement utilisateurs'); });
        }

        function openManageAuthorizedMembers(){
            const modal = document.getElementById('groupDetailsModal');
            const groupId = modal.dataset.groupId;
            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
            const membersList = document.getElementById('groupMembersList');
            const members = Array.from(membersList.querySelectorAll('[data-user-id]')).map(el => {
                const userId = parseInt(el.getAttribute('data-user-id'));
                const nameEl = el.querySelector('.font-medium');
                const emailEl = el.querySelector('.text-xs.text-gray-500');
                const photoEl = el.querySelector('img');
                const initialsEl = el.querySelector('.bg-gray-300');
                return {
                    id: userId,
                    prenom: nameEl ? nameEl.textContent.split(' ')[0] : '',
                    nom: nameEl ? nameEl.textContent.split(' ').slice(1).join(' ') : '',
                    email: emailEl ? emailEl.textContent : '',
                    photo: photoEl ? photoEl.src.replace(window.location.origin + '/storage/', '') : null
                };
            });
            
            // Fetch current authorized users
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/admin/forum/groups/${groupId}/authorized-members`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            }).then(r => r.json()).then(data => {
                const authorizedUserIds = data.authorized_user_ids || [];
                
                const picker = document.createElement('div');
                picker.className = 'fixed inset-0 z-[110] flex items-center justify-center';
                picker.style.zIndex = '110';
                picker.innerHTML = `<div class="absolute inset-0 bg-black opacity-40"></div><div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl w-11/12 max-h-[80vh] overflow-hidden flex flex-col relative z-10"><h4 class="font-semibold text-lg mb-4">Gérer les membres autorisés à envoyer des messages</h4><p class="text-sm text-gray-600 mb-4">Sélectionnez les membres qui peuvent envoyer des messages dans ce groupe.</p><div id="authorizedMembersList" class="flex-1 overflow-y-auto grid grid-cols-1 gap-2 mb-4"></div><div class="flex justify-end gap-2 pt-4 border-t"><button id="authorizedSaveBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Enregistrer</button> <button id="authorizedCloseBtn" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">Fermer</button></div></div>`;
                document.body.appendChild(picker);
                const list = picker.querySelector('#authorizedMembersList');
                
                if (members.length === 0) {
                    list.innerHTML = '<p class="text-gray-500 text-center py-4">Aucun membre dans le groupe.</p>';
                } else {
                    members.forEach(m => {
                        const item = document.createElement('label');
                        item.className = 'flex items-center gap-3 p-3 border rounded hover:bg-gray-50 cursor-pointer';
                        const photoHtml = m.photo 
                            ? `<img src="/storage/${m.photo}" class="w-10 h-10 rounded-full object-cover">`
                            : `<div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-sm font-medium">${(m.prenom||'').charAt(0)}${(m.nom||'').charAt(0)}</div>`;
                        const isChecked = authorizedUserIds.includes(parseInt(m.id));
                        item.innerHTML = `<input type="checkbox" value="${m.id}" ${isChecked ? 'checked' : ''} class="mr-2" /> ${photoHtml} <div class="flex-1"><div class="font-medium">${m.prenom} ${m.nom}</div><div class="text-xs text-gray-500">${m.email}</div></div>`;
                        list.appendChild(item);
                    });
                }
                
                picker.querySelector('#authorizedCloseBtn').addEventListener('click', () => picker.remove());
                picker.querySelector('#authorizedSaveBtn').addEventListener('click', () => {
                    const checked = Array.from(picker.querySelectorAll('input[type=checkbox]:checked')).map(i => parseInt(i.value));
                    
                    fetch(`/admin/forum/groups/${groupId}/manage-authorized`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ authorized_user_ids: checked })
                    }).then(r => r.json()).then(data => {
                        if (!data.success) {
                            alert(data.message || 'Erreur lors de la mise à jour des permissions');
                            return;
                        }
                        picker.remove();
                        alert('Permissions mises à jour avec succès');
                    }).catch(err => {
                        console.error(err);
                        alert('Erreur lors de la mise à jour des permissions');
                    });
                });
            }).catch(err => {
                console.error(err);
                alert('Erreur lors du chargement des permissions');
            });
        }

        function saveGroupChanges(){
            const modal = document.getElementById('groupDetailsModal');
            const groupId = modal.dataset.groupId;
            if (!groupId) {
                alert('Erreur: ID du groupe introuvable');
                return;
            }
            
            const name = document.getElementById('groupNameInput').value.trim();
            if (!name) {
                alert('Le nom du groupe est requis');
                return;
            }
            
            const description = document.getElementById('groupDescriptionInput').value.trim();
            const avatarInput = document.getElementById('groupAvatarInput');
            const membersElems = Array.from(document.getElementById('groupMembersList').querySelectorAll('[data-user-id]'));
            const memberIds = membersElems.map(e => e.getAttribute('data-user-id'));
            const restrict = document.getElementById('restrictMessagesCheckbox').checked ? 1 : 0;

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('name', name);
            formData.append('description', description);
            formData.append('user_ids', JSON.stringify(memberIds));
            formData.append('restrict_messages', restrict);
            if (avatarInput.files && avatarInput.files[0]) {
                formData.append('avatar', avatarInput.files[0]);
            }

            // Show loading state
            const saveBtn = document.getElementById('groupSaveBtn');
            const originalText = saveBtn.textContent;
            saveBtn.disabled = true;
            saveBtn.textContent = 'Enregistrement...';

            fetch('/admin/forum/groups/' + groupId + '/update', {
                method: 'POST',
                body: formData
            }).then(r => {
                if (!r.ok) {
                    throw new Error('Erreur HTTP: ' + r.status);
                }
                return r.json();
            }).then(data => {
                saveBtn.disabled = false;
                saveBtn.textContent = originalText;
                
                if (!data.success) { 
                    alert(data.message || 'Erreur lors de la sauvegarde'); 
                    return; 
                }
                
                // update chatItem metadata
                const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
                if (chatItem) {
                    chatItem.setAttribute('data-group-name', data.group.name);
                    chatItem.setAttribute('data-group-description', data.group.description || '');
                    chatItem.setAttribute('data-group-members', JSON.stringify(data.group.users || []));
                    chatItem.setAttribute('data-group-restrict', data.group.restrict_messages || 0);
                    
                    // Update avatar
                    if (data.group.avatar) {
                        chatItem.setAttribute('data-group-avatar', data.group.avatar);
                        const avatarDiv = chatItem.querySelector('.w-12.h-12.rounded-full');
                        if (avatarDiv) {
                            avatarDiv.style.backgroundImage = `url(/storage/${data.group.avatar})`;
                            avatarDiv.style.backgroundSize = 'cover';
                            avatarDiv.style.backgroundPosition = 'center';
                            // Remove SVG icon if exists
                            const svg = avatarDiv.querySelector('svg');
                            if (svg) svg.remove();
                        }
                    }
                    
                    // update visible name
                    const nameEl = chatItem.querySelector('.text-sm.font-semibold');
                    if (nameEl) nameEl.textContent = data.group.name;
                    
                    // update description
                    const descEl = chatItem.querySelector('.text-xs.text-gray-600');
                    if (descEl) descEl.textContent = data.group.description || 'Groupe de discussion';
                    
                    // update member count
                    const memberCount = data.group.users ? data.group.users.length : 0;
                    const memberCountEl = chatItem.querySelector('.text-xs.text-gray-500');
                    if (memberCountEl) {
                        memberCountEl.textContent = `${memberCount} membre${memberCount > 1 ? 's' : ''}`;
                    }
                }
                
                // Update avatar in modal if it was changed
                if (data.group.avatar) {
                    const avatarEl = document.getElementById('groupAvatar');
                    avatarEl.style.backgroundImage = `url(/storage/${data.group.avatar})`;
                    avatarEl.style.backgroundSize = 'cover';
                    avatarEl.style.backgroundPosition = 'center';
                }
                
                closeGroupModal();
                // Reload page to reflect changes for all users
                window.location.reload();
            }).catch(err => { 
                console.error(err); 
                saveBtn.disabled = false;
                saveBtn.textContent = originalText;
                alert('Erreur lors de la sauvegarde: ' + err.message); 
            });
        }

        // --- Group Details Modal HTML ---
        // Insert modal at end of file (before closing body) - simple tailwind modal
        document.addEventListener('DOMContentLoaded', function(){
            if (!document.getElementById('groupDetailsModal')) {
                const modalHtml = `
                <div id="groupDetailsModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                    <div class="absolute inset-0 bg-black opacity-40"></div>
                    <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-3xl relative z-10 overflow-hidden">
                        <div class="p-4 border-b flex items-center justify-between">
                            <h3 id="groupModalTitle" class="text-lg font-semibold">Groupe</h3>
                            <div class="flex items-center gap-2">
                                <button id="groupAddMemberBtn" class="px-3 py-1 text-sm bg-green-50 text-green-700 rounded">Ajouter membre</button>
                                <button id="groupSaveBtn" class="px-3 py-1 text-sm bg-blue-600 text-white rounded">Enregistrer</button>
                            </div>
                        </div>
                        <button id="groupCloseBtn" class="absolute top-3 right-3 p-2 bg-white rounded-full shadow hover:bg-gray-100" aria-label="Fermer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <div class="flex items-center gap-4 mb-4">
                                    <div id="groupAvatar" class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center relative overflow-hidden">
                                        <button id="groupAvatarBtn" class="absolute bottom-0 right-0 bg-white p-1 rounded-full shadow text-sm z-10 hover:bg-gray-100" title="Changer la photo">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        </button>
                                        <input id="groupAvatarInput" type="file" accept="image/*" class="hidden">
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs text-gray-600">Nom du groupe</label>
                                        <input id="groupNameInput" class="w-full border rounded px-2 py-1" />
                                        <label class="block text-xs text-gray-600 mt-2">Description</label>
                                        <textarea id="groupDescriptionInput" class="w-full border rounded px-2 py-1" rows="3"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-semibold mb-2">Membres</h4>
                                    <div id="groupMembersList" class="space-y-2 max-h-64 overflow-y-auto border rounded p-2"></div>
                                </div>
                            </div>
                            <div class="h-full flex flex-col justify-between">
                                <div>
                                    <h4 class="font-semibold mb-2">Actions</h4>
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-2"><input type="checkbox" id="restrictMessagesCheckbox"> Restreindre l'envoi de messages aux membres autorisés</label>
                                        <div>
                                            <button id="groupManageMembersBtn" class="w-full px-3 py-2 bg-red-50 text-red-700 rounded">Gérer membres</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button id="groupDeleteBtn" class="w-full px-3 py-2 bg-white text-red-600 border border-red-100 rounded">Supprimer le groupe</button>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>`;
                document.body.insertAdjacentHTML('beforeend', modalHtml);

                // Wire modal buttons
                document.getElementById('groupCloseBtn').addEventListener('click', () => { closeGroupModal(); });
                document.getElementById('groupSaveBtn').addEventListener('click', () => { saveGroupChanges(); });
                document.getElementById('groupAvatarBtn').addEventListener('click', () => { document.getElementById('groupAvatarInput').click(); });
                document.getElementById('groupAvatarInput').addEventListener('change', handleAvatarSelected);
                document.getElementById('groupAddMemberBtn').addEventListener('click', () => { openAddMembersPicker(); });
                // Manage authorized members handler
                const manageMembersBtn = document.getElementById('groupManageMembersBtn');
                if (manageMembersBtn) {
                    manageMembersBtn.addEventListener('click', () => { openManageAuthorizedMembers(); });
                }
                // Delete group handler - automatic deletion without confirmation
                const deleteBtn = document.getElementById('groupDeleteBtn');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function(){
                        const modal = document.getElementById('groupDetailsModal');
                        const groupId = modal.dataset.groupId;
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        fetch('/admin/forum/groups/' + groupId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        }).then(r => r.json()).then(data => {
                            if (!data.success) { alert(data.message || 'Erreur lors de la suppression du groupe'); return; }
                            // remove group from list
                            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
                            if (chatItem) chatItem.remove();
                            closeGroupModal();
                            // Reload page to reflect changes
                            window.location.reload();
                        }).catch(err => { console.error(err); alert('Erreur lors de la suppression du groupe'); });
                    });
                }
            }
        });
    </script>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f7fa;
        }
        /* Call Interface Styles */
        .call-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 100%);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .call-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .call-interface {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 2rem;
        }
        .call-profile-section {
            text-align: center;
            margin-bottom: 3rem;
        }
        .call-profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            border: 6px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            font-weight: bold;
            overflow: hidden;
        }
        .call-profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .call-name {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }
        .call-status {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
        }
        .call-timer {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }
        .call-controls {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            justify-content: center;
            margin-top: 3rem;
        }
        .call-btn {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .call-btn svg {
            width: 32px;
            height: 32px;
        }
        .call-btn-answer {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .call-btn-answer:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }
        .call-btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }
        .call-btn-reject:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .call-btn-end {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            width: 80px;
            height: 80px;
        }
        .call-btn-end:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
        .call-btn-mute,
        .call-btn-speaker,
        .call-btn-video {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
        }
        .call-btn-mute:hover,
        .call-btn-speaker:hover,
        .call-btn-video:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }
        .call-btn-mute.active,
        .call-btn-speaker.active,
        .call-btn-video.active {
            background: rgba(255, 255, 255, 0.4);
        }
        .call-ringing-animation {
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        .call-audio-visualizer {
            display: flex;
            gap: 4px;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
            height: 40px;
        }
        .audio-bar {
            width: 4px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 2px;
            animation: audio-wave 1s infinite;
        }
        .audio-bar:nth-child(1) { animation-delay: 0s; }
        .audio-bar:nth-child(2) { animation-delay: 0.1s; }
        .audio-bar:nth-child(3) { animation-delay: 0.2s; }
        .audio-bar:nth-child(4) { animation-delay: 0.3s; }
        .audio-bar:nth-child(5) { animation-delay: 0.4s; }
        @keyframes audio-wave {
            0%, 100% { height: 10px; }
            50% { height: 30px; }
        }
        .icon-crossed {
            position: relative;
        }
        .icon-crossed::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 2px;
            height: 100%;
            background: #ef4444;
        }
    </style>
</head>
<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden bg-white">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4" style="position: relative; z-index: 1000;">
                <div class="flex items-center justify-between">
                    <!-- Back Button and Search -->
                    <div class="flex items-center gap-3 flex-1 max-w-md">
                        <a href="{{ route('dashboard') }}" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="Retour">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <div class="relative flex-1" style="min-width: 300px;">
                            <div class="input-group" style="min-width: 300px;">
                              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                              <input type="text"
                                     id="mesMessagesSearchInput"
                                     class="form-control"
                                     placeholder="Rechercher une conversation..."
                                     autocomplete="off">
                              <button type="button" id="clearMesMessagesSearchBtn" class="btn btn-outline-secondary" style="border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem; display: none;">
                                <i class="fas fa-times"></i>
                              </button>
                            </div>
                        </div>
                        <button type="button" class="p-2 text-gray-600 hover:text-gray-900 relative bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors" id="addButton" title="Ajouter" style="cursor: pointer; padding: 0.5rem; width: 2.5rem; height: 2.5rem; background-color: #f3f4f6 !important; color: #4b5563 !important; border: none !important; border-radius: 0.5rem !important; transition: background-color 0.2s, color 0.2s !important; display: inline-flex !important; align-items: center !important; justify-content: center !important;" onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#111827';" onmouseout="this.style.backgroundColor='#f3f4f6'; this.style.color='#4b5563';">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <!-- Notifications & Profile -->
                    <div class="flex items-center gap-4" style="position: relative; z-index: 1000;">
                        @include('components.notification-icon-admin')
                        <div class="relative" style="z-index: 1000;">
                            @php
                                $user = auth()->user();
                            @endphp
                            <button id="profileDropdownBtn" class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-white shadow-md cursor-pointer hover:ring-2 hover:ring-purple-300 transition-all focus:outline-none" style="position: relative; z-index: 1000; pointer-events: auto;">
                                @if($user->photo ?? null)
                                    <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                    </div>
                                @endif
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-xl border border-gray-200 z-[9999] hidden" style="z-index: 9999 !important; overflow: visible !important; max-height: none !important;">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 overflow-hidden border-2 border-purple-300 flex-shrink-0">
                                            @if($user->photo ?? null)
                                                <img src="{{ asset('storage/' . ($user->photo ?? '')) }}" alt="Profile" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm">
                                                    {{ strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $user->name ?? ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">{{ $user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-1" style="overflow: visible !important;">
                                    <a href="{{ url('/admin/profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>Profil</span>
                                    </a>
                                    <a href="{{ url('/admin/settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors" style="display: flex !important; visibility: visible !important; opacity: 1 !important;">
                                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span>Paramètres</span>
                                    </a>
                                    <hr class="my-1 border-gray-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            <span>Déconnexion</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main Content Area -->
            <main class="flex-1 overflow-hidden bg-white">
                <div class="flex h-full">
                    <!-- Left Panel - Chat List -->
                    <div class="w-96 border-r border-gray-200 flex flex-col bg-white">
                        <!-- Chat Title and Messages Section -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h1 class="text-3xl font-bold text-gray-900">Chat</h1>
                                <button type="button" class="p-2 text-gray-600 hover:text-gray-900 relative bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors" id="addButton" title="Ajouter" style="cursor: pointer; padding: 0.5rem; width: 2.5rem; height: 2.5rem; background-color: #f3f4f6 !important; color: #4b5563 !important; border: none !important; border-radius: 0.5rem !important; transition: background-color 0.2s, color 0.2s !important; display: inline-flex !important; align-items: center !important; justify-content: center !important;" onmouseover="this.style.backgroundColor='#e5e7eb'; this.style.color='#111827';" onmouseout="this.style.backgroundColor='#f3f4f6'; this.style.color='#4b5563';">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-bold text-gray-900">Messages</h2>
                                <div class="flex items-center gap-2">
                                    @php
                                        $totalUnread = $messages->where('receiver_id', auth()->id())->whereNull('read_at')->count();
                                    @endphp
                                    <span class="badge badge-md badge-circle badge-floating badge-danger border-white unread-badge">{{ $totalUnread }}</span>
                                    <span class="text-sm text-gray-500 unread-text">{{ $totalUnread }} nouveaux messages</span>
                                </div>
                            </div>
                            <!-- Search Bar -->
                            <div class="relative">
                                <input type="text" id="searchInput" placeholder="Rechercher" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Chat List -->
                        <div class="flex-1 overflow-y-auto">
                            <div class="space-y-0" id="chatList">
                                @forelse($allItems as $itemId => $item)
                                    @if($item['type'] === 'group')
                                        @php
                                            $group = $item['group'];
                                            $isActive = $activeChatId == 'group_' . $group->id;
                                            $memberCount = $group->users->count();
                                            $groupMembersJson = $group->users->map(function($u){ return [
                                                'id' => $u->id,
                                                'prenom' => $u->prenom,
                                                'nom' => $u->nom,
                                                'email' => $u->email,
                                                'photo' => $u->photo
                                            ]; })->toJson();
                                        @endphp
                                        <div class="p-4 cursor-pointer transition-colors chat-item group-item {{ $isActive ? 'active' : '' }}"
                                            data-group-id="{{ $group->id }}"
                                            data-group-name="{{ $group->name }}"
                                            data-group-description="{{ $group->description ?? '' }}"
                                            data-group-members='{{ $groupMembersJson }}'
                                            data-group-creator="{{ $group->created_by }}"
                                            data-group-restrict="{{ $group->restrict_messages ?? 0 }}"
                                            data-group-avatar="{{ $group->avatar ?? '' }}"
                                             style="{{ $isActive ? 'background-color: rgba(26, 31, 58, 0.1); border-left: 4px solid #1a1f3a;' : '' }} border-bottom: 1px solid #e5e7eb;"
                                             onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='rgba(0,0,0,0.02)'"
                                             onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor=''">
                                            <div class="flex items-center gap-3">
                                                <div class="relative flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm overflow-hidden" style="{{ $group->avatar ? 'background-image: url(/storage/' . $group->avatar . '); background-size: cover; background-position: center;' : 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);' }}">
                                                        @if(!$group->avatar)
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        @endif
                                                    </div>
                                                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $memberCount }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $group->name }}</p>
                                                        <span class="text-xs text-purple-600 font-medium">GROUPE</span>
                                                    </div>
                                                    <p class="text-xs text-gray-600 truncate mb-1">{{ $group->description ?? 'Groupe de discussion' }}</p>
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-xs text-gray-500">{{ $memberCount }} membre{{ $memberCount > 1 ? 's' : '' }}</span>
                                                        @if(!empty($item['unread_count']) && $item['unread_count'] > 0)
                                                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">{{ $item['unread_count'] }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @php
                                            $otherUser = $item['user'];
                                            $lastMessage = $item['last_message'] ?? null;
                                            $isActive = $activeChatId == $itemId;
                                            $initials = strtoupper(substr($otherUser->prenom ?? '', 0, 1) . substr($otherUser->nom ?? '', 0, 1));
                                        @endphp
                                        <div class="p-4 cursor-pointer transition-colors chat-item {{ $isActive ? 'active' : '' }}"
                                             data-user-id="{{ $itemId }}"
                                             data-user-name="{{ strtolower(($otherUser->prenom ?? '') . ' ' . ($otherUser->nom ?? '')) }}"
                                             style="{{ $isActive ? 'background-color: rgba(26, 31, 58, 0.1); border-left: 4px solid #1a1f3a;' : '' }}"
                                             onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='rgba(0,0,0,0.02)'"
                                             onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor=''">
                                            <div class="flex items-center gap-3">
                                                <div class="relative flex-shrink-0">
                                                    @if(!empty($otherUser->photo))
                                                        <img src="{{ asset('storage/' . $otherUser->photo) }}" alt="{{ $otherUser->prenom ?? '' }} {{ $otherUser->nom ?? '' }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                                    @else
                                                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                            {{ $initials }}
                                                        </div>
                                                    @endif
                                                    @php
                                                        $contactIsOnline = false;
                                                        if (!empty($otherUser->last_seen)) {
                                                            $contactLastSeen = \Carbon\Carbon::parse($otherUser->last_seen);
                                                            $contactIsOnline = $contactLastSeen->diffInMinutes(now()) < 5;
                                                        }
                                                    @endphp
                                                    <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full {{ $contactIsOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $otherUser->prenom ?? '' }} {{ $otherUser->nom ?? '' }}</p>
                                                        @if(!empty($lastMessage))
                                                            @php
                                                                $diffInMinutes = intval($lastMessage->created_at->diffInMinutes(now()));
                                                                $diffInHours = intval($lastMessage->created_at->diffInHours(now()));
                                                                $diffInDays = intval($lastMessage->created_at->diffInDays(now()));
                                                                $diffInWeeks = intval($lastMessage->created_at->diffInWeeks(now()));
                                                                $diffInMonths = intval($lastMessage->created_at->diffInMonths(now()));
                                                                $diffInYears = intval($lastMessage->created_at->diffInYears(now()));

                                                                if ($diffInMinutes < 1) {
                                                                    $timeText = 'À l\'instant';
                                                                } elseif ($diffInMinutes < 60) {
                                                                    $timeText = 'Il y a ' . $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '');
                                                                } elseif ($diffInHours < 24) {
                                                                    $timeText = 'Il y a ' . $diffInHours . ' heure' . ($diffInHours > 1 ? 's' : '');
                                                                } elseif ($diffInDays < 7) {
                                                                    $timeText = 'Il y a ' . $diffInDays . ' jour' . ($diffInDays > 1 ? 's' : '');
                                                                } elseif ($diffInWeeks < 4) {
                                                                    $timeText = 'Il y a ' . $diffInWeeks . ' semaine' . ($diffInWeeks > 1 ? 's' : '');
                                                                } elseif ($diffInMonths < 12) {
                                                                    $timeText = 'Il y a ' . $diffInMonths . ' mois';
                                                                } else {
                                                                    $timeText = 'Il y a ' . $diffInYears . ' an' . ($diffInYears > 1 ? 's' : '');
                                                                }
                                                            @endphp
                                                            <div class="last-message-time text-xs text-gray-500">
                                                                {{ $timeText }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    {{-- Aperçu du dernier message sous le nom (comme WhatsApp) --}}
                                                    @if(!empty($lastMessage) && !empty($lastMessage->content))
                                                        <p class="text-xs text-gray-600 truncate mb-1">{{ \Illuminate\Support\Str::limit(strip_tags($lastMessage->content), 60) }}</p>
                                                    @else
                                                        <p class="text-xs text-gray-400 mb-1">Aucun message</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="p-4 text-center text-gray-500">
                                        <p class="text-sm">Aucun contact disponible</p>
                                    </div>
                                @endforelse
                    </div>
                        </div>
                    </div>

                    <!-- Right Panel - Active Chat -->
                    <div class="flex-1 flex flex-col bg-white" id="chatPanel" style="display: none;">
                        @php
                            $activeUser = null;
                            if ($activeChatId) {
                                // Chercher dans les conversations existantes
                                if (isset($conversations[$activeChatId])) {
                                    $activeUser = $conversations[$activeChatId]['user'];
                                }
                            }
                        @endphp
                        @if($activeUser)
                            <div class="flex items-center gap-3">
                                        <div class="relative">
                                            @if($activeUser->photo ?? null)
                                                <img src="{{ asset('storage/' . $activeUser->photo) }}" alt="{{ $activeUser->prenom ?? '' }} {{ $activeUser->nom ?? '' }}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                            @else
                                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                    {{ $activeInitials }}
                                                </div>
                                            @endif
                                            @php
                                                $activeIsOnline = false;
                                                if ($activeUser->last_seen ?? null) {
                                                    $activeLastSeen = \Carbon\Carbon::parse($activeUser->last_seen);
                                                    $activeIsOnline = $activeLastSeen->diffInMinutes(now()) < 5;
                                                }
                                            @endphp
                                            <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full {{ $activeIsOnline ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900">{{ $activeUser->prenom ?? '' }} {{ $activeUser->nom ?? '' }}</p>
                                            @php
                                                $isOnline = false;
                                                $lastSeenText = 'Jamais en ligne';
                                                if ($activeUser->last_seen ?? null) {
                                                    $lastSeen = \Carbon\Carbon::parse($activeUser->last_seen);
                                                    $isOnline = $lastSeen->diffInMinutes(now()) < 5;
                                                    if (!$isOnline) {
                                                        $diffInMinutes = intval($lastSeen->diffInMinutes(now()));
                                                        $diffInHours = intval($lastSeen->diffInHours(now()));
                                                        $diffInDays = intval($lastSeen->diffInDays(now()));
                                                        $diffInWeeks = intval($lastSeen->diffInWeeks(now()));
                                                        $diffInMonths = intval($lastSeen->diffInMonths(now()));
                                                        $diffInYears = intval($lastSeen->diffInYears(now()));
                                                        
                                                        if ($diffInMinutes < 60) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInMinutes . ' minute' . ($diffInMinutes > 1 ? 's' : '');
                                                        } elseif ($diffInHours < 24) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInHours . ' heure' . ($diffInHours > 1 ? 's' : '');
                                                        } elseif ($diffInDays < 7) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInDays . ' jour' . ($diffInDays > 1 ? 's' : '');
                                                        } elseif ($diffInWeeks < 4) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInWeeks . ' semaine' . ($diffInWeeks > 1 ? 's' : '');
                                                        } elseif ($diffInMonths < 12) {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInMonths . ' mois';
                                                        } else {
                                                            $lastSeenText = 'En ligne il y a ' . $diffInYears . ' an' . ($diffInYears > 1 ? 's' : '');
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if($isOnline)
                                                <p class="text-sm text-green-600 font-medium">En ligne</p>
                                            @else
                                                <p class="text-sm text-gray-500 font-medium">{{ $lastSeenText }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            Appeler
                                        </button>
                                        <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Appel video
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages Area -->
                            <div class="flex-1 overflow-y-auto p-6 bg-gray-50" style="min-height: 0;">
                                <div id="messagesArea" class="space-y-4">
                                    @if(count($activeMessages) > 0)
                                        @foreach($activeMessages as $msg)
                                            @php
                                                $isSystemMessage = $msg->label === 'System' || 
                                                                 strpos($msg->content, '📞❌') !== false || 
                                                                 strpos($msg->content, '📞✅') !== false ||
                                                                 strpos($msg->content, 'Appel manqué') !== false ||
                                                                 strpos($msg->content, 'Appel terminé') !== false;
                                            @endphp
                                            @if($isSystemMessage)
                                                <!-- System Message - Aligné à droite comme WhatsApp -->
                                                <div class="flex items-start gap-3 justify-end my-2" data-message-id="{{ $msg->id }}">
                                                    <div class="flex-1 flex justify-end">
                                                        <div class="max-w-[70%]">
                                                            <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                                                <p class="text-xs text-gray-600">{{ $msg->content }}</p>
                                                            </div>
                                                            <p class="text-xs text-gray-400 mt-1 text-right">{{ $msg->created_at->format('d/m/Y H:i') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif($msg->sender_id == $user->id)
                                            <!-- Admin's Message -->
                                            <div class="flex items-start gap-3 justify-end" data-message-id="{{ $msg->id }}">
                                                <div class="flex-1 flex justify-end">
                                                    <div class="max-w-[70%]">
                                                        <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                            <p class="text-sm">{{ $msg->content }}</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-1 text-right">{{ $msg->created_at->format('d/m/Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Other User's Message -->
                                            <div class="flex items-start gap-3" data-message-id="{{ $msg->id }}">
                                                <div class="flex-1">
                                                        <div class="inline-block max-w-[70%]">
                                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                        <p class="text-sm text-gray-700">{{ $msg->content }}</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $msg->created_at->format('d/m/Y H:i') }}</p>
                                                        </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Message Input -->
                            <div class="p-6 border-t border-gray-200 bg-white relative flex-shrink-0 mt-auto" id="messageInputContainer">
                                <!-- Emoji Picker -->
                                <div id="emojiPicker" class="hidden absolute bottom-full left-0 mb-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl p-4" style="max-height: 300px; overflow-y: auto; z-index: 9999;">
                                    <div class="grid grid-cols-8 gap-2">
                                        @php
                                            $emojis = [
                                                // Visages souriants
                                                '😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '🤯', '🤠', '🥳', '😎', '🤓', '🧐', '😕', '😟', '🙁', '😮', '😯', '😲', '😳', '🥺', '😦', '😧', '😨', '😰', '😥', '😢', '😭', '😱', '😖', '😣', '😞', '😓', '😩', '😫', '🥱', '😤', '😡', '😠', '🤬', '😈', '👿', '💀', '☠️', '💩', '🤡', '👹', '👺', '👻', '👽', '👾', '🤖',
                                                // Animaux
                                                '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾', '🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗', '🐴', '🦄', '🐝', '🐛', '🦋', '🐌', '🐞', '🐜', '🦟', '🦗', '🕷️', '🦂', '🐢', '🐍', '🦎', '🦖', '🦕', '🐙', '🦑', '🦐', '🦞', '🦀', '🐡', '🐠', '🐟', '🐬', '🐳', '🐋', '🦈', '🐊', '🐅', '🐆', '🦓', '🦍', '🦧', '🐘', '🦛', '🦏', '🐪', '🐫', '🦒', '🦘', '🦬', '🐃', '🐂', '🐄', '🐎', '🐖', '🐏', '🐑', '🦙', '🐐', '🦌', '🐕', '🐩', '🦮', '🐕‍🦺', '🐈', '🐓', '🦃', '🦤', '🦚', '🦜', '🦢', '🦩', '🕊️', '🐇', '🦝', '🦨', '🦡', '🦦', '🦥', '🐁', '🐀', '🐿️', '🦔',
                                                // Cœurs et émotions
                                                '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟', '☮️', '✝️', '☪️', '🕉️', '☸️', '✡️', '🔯', '🕎', '☯️', '☦️', '🛐', '⛎', '♈', '♉', '♊', '♋', '♌', '♍', '♎', '♏', '♐', '♑', '♒', '♓', '🆔', '⚛️', '🉑', '☢️', '☣️',
                                                // Gestes
                                                '👋', '🤚', '🖐️', '✋', '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈', '👉', '👆', '🖕', '👇', '☝️', '👍', '👎', '✊', '👊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏', '✍️', '💪', '🦾', '🦿', '🦵', '🦶', '👂', '🦻', '👃', '🧠', '🫀', '🫁', '🦷', '🦴', '👀', '👁️', '👅', '👄',
                                                // Objets et symboles
                                                '💋', '💌', '💍', '💎', '🔇', '🔈', '🔉', '🔊', '📢', '📣', '📯', '🔔', '🔕', '🎵', '🎶', '💿', '📀', '📱', '☎️', '📞', '📟', '📠', '🔋', '🔌', '💻', '🖥️', '🖨️', '⌨️', '🖱️', '🖲️', '🕹️', '🗜️', '💾', '💿', '📼', '📷', '📸', '📹', '🎥', '📽️', '🎞️', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙️', '🎚️', '🎛️', '⏱️', '⏲️', '⏰', '🕰️', '⌚', '📻', '📡', '🔋', '🔌', '💡', '🔦', '🕯️', '🪔', '🧯', '🛢️', '💸', '💵', '💴', '💶', '💷', '💰', '💳', '💎', '⚖️', '🛒', '🛍️', '🛍️', '🎁', '🎈', '🎉', '🎊', '🎀', '🎗️', '🏆', '🥇', '🥈', '🥉', '⚽', '🏀', '🏈', '⚾', '🎾', '🏐', '🏉', '🎱', '🏓', '🏸', '🥅', '🏒', '🏑', '🏏', '🥃', '🥤', '🧃', '🧉', '🧊', '🥢', '🍽️', '🍴', '🥄', '🔪', '🏺', '🌍', '🌎', '🌏', '🌐', '🗺️', '🧭', '🏔️', '⛰️', '🌋', '🗻', '🏕️', '🏖️', '🏜️', '🏝️', '🏞️', '🏟️', '🏛️', '🏗️', '🧱', '🏘️', '🏚️', '🏠', '🏡', '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '💒', '🗼', '🗽', '⛪', '🕌', '🛕', '🕍', '⛩️', '🕋', '⛲', '⛺', '🌁', '🌃', '🏙️', '🌄', '🌅', '🌆', '🌇', '🌉', '♨️', '🎠', '🎡', '🎢', '💈', '🎪', '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝', '🚞', '🚋', '🚌', '🚍', '🚎', '🚐', '🚑', '🚒', '🚓', '🚔', '🚕', '🚖', '🚗', '🚘', '🚙', '🚚', '🚛', '🚜', '🏎️', '🏍️', '🛵', '🦽', '🦼', '🛴', '🚲', '🛺', '🚁', '🛸', '✈️', '🛩️', '🛫', '🛬', '🪂', '💺', '🚀', '🚤', '⛵', '🛥️', '🛳️', '⛴️', '🚢', '⚓', '⛽', '🚧', '🚦', '🚥', '🗿', '🛂', '🛃', '🛄', '🛅', '⚠️', '🚸', '⛔', '🚫', '🚳', '🚭', '🚯', '🚱', '🚷', '📵', '🔞', '☢️', '☣️', '⬆️', '↗️', '➡️', '↘️', '⬇️', '↙️', '⬅️', '↖️', '↕️', '↔️', '↩️', '↪️', '⤴️', '⤵️', '🔃', '🔄', '🔙', '🔚', '🔛', '🔜', '🔝', '🛐', '⚛️', '🕉️', '☸️', '☮️', '☯️', '✡️', '🔯', '🕎', '☦️', '☪️', '🛣️', '🛤️', '🛢️', '⛽', '🚨', '🚥', '🚦', '🚧', '🛑', '⚡', '💡', '🔦', '🕯️', '🪔', '🧯', '🛢️', '💸', '💵', '💴', '💶', '💷', '💰', '💳', '💎', '⚖️', '🛒', '🛍️', '🎁', '🎈', '🎉', '🎊', '🎀', '🎗️', '🏆', '🥇', '🥈', '🥉', '⚽', '🏀', '🏈', '⚾', '🎾', '🏐', '🏉', '🎱', '🏓', '🏸', '🥅', '🏒', '🏑', '🏏', '🥃', '🥤', '🧃', '🧉', '🧊', '🥢', '🍽️', '🍴', '🥄', '🔪', '🏺'
                                            ];
                                        @endphp
                                        @foreach($emojis as $emoji)
                                            <button type="button" class="emoji-item text-2xl hover:bg-gray-100 rounded p-1 transition-colors" data-emoji="{{ $emoji }}">{{ $emoji }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <form id="messageForm" method="POST" action="{{ route('admin.mes-messages.send') }}" class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="receiver_id" id="receiverId" value="{{ $activeChatId }}">
                                    <button type="button" id="emojiBtn" class="p-2 text-gray-400 hover:text-gray-600 transition-colors relative">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                    </button>
                                    <input type="text" name="content" id="messageInput" placeholder="Message" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;" required>
                                    <button type="submit" class="p-3 text-white rounded-lg transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @elseif(isset($activeGroup) && $activeGroup)
                            @php
                                $memberCount = $activeGroup->users->count();
                            @endphp
                            <!-- Chat Header -->
                            <div class="p-6 border-b border-gray-200 flex-shrink-0" id="chatHeader">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-purple-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $memberCount }}</span>
                                        </div>
                                            <div>
                                            <p class="text-base font-bold text-gray-900"><a href="#" class="hover:underline" onclick="event.preventDefault(); (function(){ const el = document.querySelector('.chat-item[data-group-id=\'{{ $activeGroup->id }}\']'); if(el){ el.click(); } else { console.warn('group item not found for id', '{{ $activeGroup->id }}'); } })();">{{ $activeGroup->name }}</a></p>
                                            <p class="text-sm text-gray-500">{{ $memberCount }} membre{{ $memberCount > 1 ? 's' : '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages Area -->
                            <div class="flex-1 overflow-y-auto p-6 bg-gray-50" style="min-height: 0;">
                                <div id="messagesArea" class="space-y-4">
                                    <div class="flex items-center justify-center h-full">
                                        <div class="text-center">
                                            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Bienvenue dans {{ $activeGroup->name }}</h3>
                                            <p class="text-gray-500">Cette fonctionnalité de chat de groupe sera bientôt disponible.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Message Input -->
                            <div class="p-6 border-t border-gray-200 bg-white relative flex-shrink-0 mt-auto" id="messageInputContainer">
                                <!-- Emoji Picker -->
                                <div id="emojiPicker" class="hidden absolute bottom-full left-0 mb-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl p-4" style="max-height: 300px; overflow-y: auto; z-index: 9999;">
                                    <div class="grid grid-cols-8 gap-2">
                                        @php
                                            $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '🤯', '🤠', '🥳', '😎', '🤓', '🧐'];
                                        @endphp
                                        @foreach($emojis as $emoji)
                                            <button type="button" class="emoji-item text-2xl hover:bg-gray-100 rounded p-1 transition-colors" data-emoji="{{ $emoji }}">{{ $emoji }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <form id="messageForm" method="POST" action="{{ route('admin.mes-messages.send') }}" class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="receiver_id" id="receiverId" value="{{ $activeChatId }}">
                                    <button type="button" id="emojiBtn" class="p-2 text-gray-400 hover:text-gray-600 transition-colors relative">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                    </button>
                                    <input type="text" name="content" id="messageInput" placeholder="Message de groupe" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;" required>
                                    <button type="submit" class="p-3 text-white rounded-lg transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Empty State - Créer les éléments nécessaires pour le JavaScript même s'ils sont cachés -->
                            <!-- Chat Header -->
                            <div id="chatHeader" class="p-6 border-b border-gray-200 flex-shrink-0" style="display: none;"></div>
                            <!-- Messages Area -->
                            <div class="flex-1 overflow-y-auto p-6 bg-gray-50" style="display: none; min-height: 0;">
                                <div id="messagesArea" class="space-y-4"></div>
                            </div>
                            <!-- Message Input -->
                            <div id="messageInputContainer" class="p-6 border-t border-gray-200 bg-white relative flex-shrink-0 mt-auto" style="display: none;">
                                <!-- Emoji Picker -->
                                <div id="emojiPicker" class="hidden absolute bottom-full left-0 mb-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl p-4" style="max-height: 300px; overflow-y: auto; z-index: 9999;">
                                    <div class="grid grid-cols-8 gap-2">
                                        @php
                                            $emojis = ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '😚', '😙', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔', '🤐', '🤨', '😐', '😑', '😶', '😏', '😒', '🙄', '😬', '🤥', '😌', '😔', '😪', '🤤', '😴', '😷', '🤒', '🤕', '🤢', '🤮', '🤧', '🥵', '🥶', '😵', '🤯', '🤠', '🥳', '😎', '🤓', '🧐'];
                                        @endphp
                                        @foreach($emojis as $emoji)
                                            <button type="button" class="emoji-item text-2xl hover:bg-gray-100 rounded p-1 transition-colors" data-emoji="{{ $emoji }}">{{ $emoji }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                <form id="messageForm" method="POST" action="{{ route('admin.mes-messages.send') }}" class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="receiver_id" id="receiverId" value="">
                                    <button type="button" id="emojiBtn" class="p-2 text-gray-400 hover:text-gray-600 transition-colors relative">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    <button type="button" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                    </button>
                                    <input type="text" name="content" id="messageInput" placeholder="Message" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 text-sm" style="--tw-ring-color: #1a1f3a;" required>
                                    <button type="submit" class="p-3 text-white rounded-lg transition-colors" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        console.log('🔍 [DEBUG admin] ===== SCRIPT CHARGÉ =====');
        console.log('🔍 [DEBUG admin] Document readyState:', document.readyState);
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🔍 [DEBUG admin] ===== DOMContentLoaded DÉCLENCHÉ =====');
            
            // Profile dropdown menu
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');

            if (profileDropdownBtn && profileDropdownMenu) {
                profileDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                        profileDropdownMenu.classList.add('hidden');
                    }
                });

                profileDropdownMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            console.log('🔍 [DEBUG admin] Vérification des éléments DOM...');
            const chatListCheck = document.getElementById('chatList');
            const chatItemsCheck = document.querySelectorAll('.chat-item');
            console.log('🔍 [DEBUG admin] chatList trouvé:', chatListCheck ? '✅' : '❌');
            console.log('🔍 [DEBUG admin] Nombre de chat-items trouvés:', chatItemsCheck.length);
            if (chatItemsCheck.length > 0) {
                console.log('🔍 [DEBUG admin] Premier chat-item:', chatItemsCheck[0]);
                console.log('🔍 [DEBUG admin] data-user-id du premier:', chatItemsCheck[0].getAttribute('data-user-id'));
            }


            // Fonction pour charger les messages d'un thread
            function loadThread(receiverId) {
                console.log('🔍 [DEBUG admin] loadThread appelé pour receiverId:', receiverId);
                
                if (!receiverId) {
                    console.error('❌ [DEBUG admin] Erreur: ID du destinataire manquant');
                    return;
                }
                
                const url = '{{ route("admin.mes-messages.thread", ":id") }}'.replace(':id', receiverId);
                console.log('🔍 [DEBUG admin] URL de la requête:', url);
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('🔍 [DEBUG admin] Données reçues:', data);
                    if (data.success) {
                        // Récupérer les éléments à chaque fois pour s'assurer qu'ils existent
                        const receiverIdInput = document.getElementById('receiverId');
                        const chatHeader = document.getElementById('chatHeader');
                        const messagesArea = document.getElementById('messagesArea');
                        const messageInputContainer = document.getElementById('messageInputContainer');
                        const chatPanel = document.getElementById('chatPanel');
                        
                        console.log('🔍 [DEBUG admin] Éléments DOM:');
                        console.log('  - chatPanel:', chatPanel ? '✅ trouvé' : '❌ NON TROUVÉ');
                        console.log('  - chatHeader:', chatHeader ? '✅ trouvé' : '❌ NON TROUVÉ');
                        console.log('  - messagesArea:', messagesArea ? '✅ trouvé' : '❌ NON TROUVÉ');
                        console.log('  - messageInputContainer:', messageInputContainer ? '✅ trouvé' : '❌ NON TROUVÉ');
                        console.log('  - receiverIdInput:', receiverIdInput ? '✅ trouvé' : '❌ NON TROUVÉ');
                        
                        // Vérification de sécurité : s'assurer que tous les éléments existent
                        if (!chatPanel) {
                            console.error('❌ [DEBUG admin] ERREUR CRITIQUE: chatPanel non trouvé dans le DOM!');
                            alert('Erreur: Panneau de chat non trouvé. Veuillez actualiser la page.');
                            return;
                        }
                        
                        if (!chatHeader) {
                            console.error('❌ [DEBUG admin] ERREUR CRITIQUE: chatHeader non trouvé dans le DOM!');
                            alert('Erreur: En-tête de chat non trouvé. Veuillez actualiser la page.');
                            return;
                        }
                        
                        if (!messagesArea) {
                            console.error('❌ [DEBUG admin] ERREUR CRITIQUE: messagesArea non trouvé dans le DOM!');
                            alert('Erreur: Zone de messages non trouvée. Veuillez actualiser la page.');
                            return;
                        }
                        
                        if (!messageInputContainer) {
                            console.error('❌ [DEBUG admin] ERREUR CRITIQUE: messageInputContainer non trouvé dans le DOM!');
                            alert('Erreur: Formulaire de message non trouvé. Veuillez actualiser la page.');
                            return;
                        }
                        
                        // Afficher le panneau de chat complet
                        chatPanel.style.display = 'flex';
                        console.log('✅ [DEBUG admin] chatPanel affiché');
                        
                        // Mettre à jour le receiverId dans le formulaire
                        if (receiverIdInput) {
                            receiverIdInput.value = receiverId;
                        }
                        
                        // Mettre à jour dynamiquement le header du chat avec les informations du receiver
                        if (chatHeader && data.receiver) {
                            const receiver = data.receiver;
                            const receiverName = (receiver.prenom || '') + ' ' + (receiver.nom || '');
                            const receiverInitials = ((receiver.prenom || '').charAt(0) + (receiver.nom || '').charAt(0)).toUpperCase();
                            
                            // Calculer le statut en ligne
                            let isOnline = false;
                            let statusText = 'Jamais en ligne';
                            let statusColor = 'text-gray-500';
                            let statusDotColor = 'bg-gray-400';
                            
                            if (receiver.last_seen) {
                                const lastSeen = new Date(receiver.last_seen);
                                const now = new Date();
                                const diffMinutes = Math.floor((now - lastSeen) / 60000);
                                
                                if (diffMinutes < 5) {
                                    isOnline = true;
                                    statusText = 'En ligne';
                                    statusColor = 'text-green-600';
                                    statusDotColor = 'bg-green-500';
                                } else if (diffMinutes < 60) {
                                    statusText = `En ligne il y a ${diffMinutes} minute${diffMinutes > 1 ? 's' : ''}`;
                                } else {
                                    const diffHours = Math.floor(diffMinutes / 60);
                                    if (diffHours < 24) {
                                        statusText = `En ligne il y a ${diffHours} heure${diffHours > 1 ? 's' : ''}`;
                                    } else {
                                        const diffDays = Math.floor(diffHours / 24);
                                        if (diffDays < 7) {
                                            statusText = `En ligne il y a ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
                                        } else {
                                            const diffWeeks = Math.floor(diffDays / 7);
                                            if (diffWeeks < 4) {
                                                statusText = `En ligne il y a ${diffWeeks} semaine${diffWeeks > 1 ? 's' : ''}`;
                                            } else {
                                                const diffMonths = Math.floor(diffDays / 30);
                                                if (diffMonths < 12) {
                                                    statusText = `En ligne il y a ${diffMonths} mois`;
                                                } else {
                                                    const diffYears = Math.floor(diffMonths / 12);
                                                    statusText = `En ligne il y a ${diffYears} an${diffYears > 1 ? 's' : ''}`;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            
                            const photoPath = receiver.photo ? `/storage/${receiver.photo}` : '';
                            chatHeader.innerHTML = `
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            ${photoPath ? `<img src="${photoPath}" alt="${receiverName}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">` : `<div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">${receiverInitials}</div>`}
                                            <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full ${statusDotColor}"></span>
                                        </div>
                                        <div>
                                            <p class="text-base font-bold text-gray-900">${receiverName}</p>
                                            <p class="text-sm ${statusColor} font-medium">${statusText}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button id="callBtn" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            Appeler
                                        </button>
                                        <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Appel video
                                        </button>
                                    </div>
                                </div>
                            `;
                            chatHeader.style.display = 'block';
                            
                            // Réinitialiser les event listeners pour le bouton Appeler
                            const callBtn = document.getElementById('callBtn');
                            if (callBtn && window.callManager) {
                                callBtn.onclick = function() {
                                    const receiverName = (receiver.prenom || '') + ' ' + (receiver.nom || '');
                                    const receiverPhoto = receiver.photo ? `/storage/${receiver.photo}` : null;
                                    window.callManager.initiateCall(receiverId, receiverName, receiverPhoto);
                                };
                            }
                        }
                        
                        // Afficher les panneaux de chat
                        console.log('🔍 [DEBUG admin] Affichage des panneaux de chat...');
                        
                            const messagesAreaParent = messagesArea.parentElement;
                        console.log('🔍 [DEBUG admin] messagesAreaParent:', messagesAreaParent ? '✅ trouvé' : '❌ NON TROUVÉ');
                        
                            if (messagesAreaParent) {
                            const beforeDisplay = window.getComputedStyle(messagesAreaParent).display;
                                messagesAreaParent.style.display = 'block';
                            const afterDisplay = window.getComputedStyle(messagesAreaParent).display;
                            console.log('✅ [DEBUG admin] messagesAreaParent affiché - Avant:', beforeDisplay, 'Après:', afterDisplay);
                        } else {
                            console.error('❌ [DEBUG admin] messagesAreaParent est null!');
                        }
                        
                        const messagesAreaBeforeDisplay = window.getComputedStyle(messagesArea).display;
                        messagesArea.style.display = 'block';
                        const messagesAreaAfterDisplay = window.getComputedStyle(messagesArea).display;
                        console.log('✅ [DEBUG admin] messagesArea affiché - Avant:', messagesAreaBeforeDisplay, 'Après:', messagesAreaAfterDisplay);
                        
                        const messageInputBeforeDisplay = window.getComputedStyle(messageInputContainer).display;
                        messageInputContainer.style.display = 'block';
                        const messageInputAfterDisplay = window.getComputedStyle(messageInputContainer).display;
                        console.log('✅ [DEBUG admin] messageInputContainer affiché - Avant:', messageInputBeforeDisplay, 'Après:', messageInputAfterDisplay);
                        
                        // Vérifier l'état final du chatPanel
                        const chatPanelAfter = window.getComputedStyle(chatPanel).display;
                        console.log('🔍 [DEBUG admin] État final du chatPanel:', chatPanelAfter);
                        console.log('🔍 [DEBUG admin] chatPanel.offsetWidth:', chatPanel.offsetWidth);
                        console.log('🔍 [DEBUG admin] chatPanel.offsetHeight:', chatPanel.offsetHeight);
                        
                        // Afficher les messages
                        console.log('🔍 [DEBUG admin] Appel de displayMessages avec', data.messages ? data.messages.length : 0, 'messages');
                        displayMessages(data.messages, data.receiver);
                        console.log('✅ [DEBUG admin] Messages affichés');
                        
                        // Marquer les messages comme lus
                        console.log('🔍 [DEBUG admin] Marquage des messages comme lus pour receiverId:', receiverId);
                        markMessagesAsRead(receiverId);
                        console.log('✅ [DEBUG admin] Messages marqués comme lus');
                        
                        // Vérification finale
                        setTimeout(() => {
                            console.log('🔍 [DEBUG admin] ===== VÉRIFICATION FINALE =====');
                            console.log('  - chatPanel.display:', window.getComputedStyle(chatPanel).display);
                            console.log('  - chatPanel.visible:', chatPanel.offsetWidth > 0 && chatPanel.offsetHeight > 0);
                            console.log('  - chatHeader.display:', chatHeader ? window.getComputedStyle(chatHeader).display : 'N/A');
                            console.log('  - messagesArea.display:', messagesArea ? window.getComputedStyle(messagesArea).display : 'N/A');
                            console.log('  - messageInputContainer.display:', messageInputContainer ? window.getComputedStyle(messageInputContainer).display : 'N/A');
                            console.log('  - Nombre de messages dans messagesArea:', messagesArea ? messagesArea.querySelectorAll('[data-message-id]').length : 0);
                        }, 500);
                    } else {
                        console.error('❌ [DEBUG admin] Erreur: data.success est false');
                        console.error('❌ [DEBUG admin] Message d\'erreur:', data.message);
                        alert(data.message || 'Erreur lors du chargement des messages');
                    }
                })
                .catch(error => {
                    console.error('❌ [DEBUG admin] Erreur lors du chargement des messages:', error);
                    alert('Erreur lors du chargement des messages. Veuillez réessayer.');
                });
            }
            
            // Fonction pour afficher les messages
            function displayMessages(messages, receiver) {
                // Récupérer messagesArea à chaque fois pour s'assurer qu'il existe
                const messagesArea = document.getElementById('messagesArea');
                if (!messagesArea) {
                    console.error('messagesArea non trouvé - tentative de récupération...');
                    // Essayer de le trouver à nouveau après un court délai
                    setTimeout(() => {
                        const messagesAreaRetry = document.getElementById('messagesArea');
                        if (messagesAreaRetry) {
                            console.log('messagesArea trouvé à la deuxième tentative');
                            displayMessages(messages, receiver);
                        } else {
                            console.error('messagesArea toujours non trouvé après délai');
                        }
                    }, 100);
                    return;
                }
                
                // SÉCURITÉ CRITIQUE : Vérifier que receiver existe
                if (!receiver || !receiver.id) {
                    console.error('❌ [DEBUG admin] ERREUR: receiver est null ou n\'a pas d\'ID!');
                    return;
                }
                
                // SÉCURITÉ CRITIQUE : Filtrer les messages pour ne garder que ceux de cette conversation
                const currentUserId = {{ auth()->id() }};
                const filteredMessages = messages.filter(function(message) {
                    const isFromUser = message.sender_id == currentUserId && message.receiver_id == receiver.id;
                    const isToUser = message.sender_id == receiver.id && message.receiver_id == currentUserId;
                    
                    // SÉCURITÉ : Les messages système doivent aussi respecter cette règle stricte
                    const isSystemMessage = message.label === 'System' || 
                                          (message.content && (
                                              message.content.includes('📞❌') || 
                                              message.content.includes('📞✅') ||
                                              message.content.includes('Appel manqué') ||
                                              message.content.includes('Appel terminé')
                                          ));
                    
                    // Si c'est un message système, vérifier qu'il appartient bien à cette conversation
                    if (isSystemMessage) {
                        const systemMessageValid = isFromUser || isToUser;
                        if (!systemMessageValid) {
                            console.warn(`⚠️ [SÉCURITÉ admin] Message système (ID: ${message.id}) filtré - n'appartient pas à cette conversation. sender_id: ${message.sender_id}, receiver_id: ${message.receiver_id}, currentUserId: ${currentUserId}, receiver.id: ${receiver.id}`);
                        }
                        return systemMessageValid;
                    }
                    
                    return isFromUser || isToUser;
                });
                
                console.log('🔍 [DEBUG admin] Messages reçus:', messages.length);
                console.log('🔍 [DEBUG admin] Messages filtrés pour receiver.id=' + receiver.id + ':', filteredMessages.length);
                console.log('🔍 [DEBUG admin] currentUserId:', currentUserId);
                
                // Récupérer chatHeader à chaque fois
                const chatHeader = document.getElementById('chatHeader');
                
                // Mettre à jour le header du chat
                if (chatHeader && receiver) {
                    const receiverName = (receiver.prenom || '') + ' ' + (receiver.nom || '');
                    const receiverInitials = ((receiver.prenom || '').charAt(0) + (receiver.nom || '').charAt(0)).toUpperCase();
                    
                    // Calculer le statut en ligne
                    let isOnline = false;
                    let statusText = 'Jamais en ligne';
                    let statusColor = 'text-gray-500';
                    let statusDotColor = 'bg-gray-400';
                    
                    if (receiver.last_seen) {
                        const lastSeen = new Date(receiver.last_seen);
                        const now = new Date();
                        const diffMinutes = Math.floor((now - lastSeen) / (1000 * 60));
                        isOnline = diffMinutes < 5;
                        
                        if (isOnline) {
                            statusText = 'En ligne';
                            statusColor = 'text-green-600';
                            statusDotColor = 'bg-green-500';
                        } else {
                            const diffHours = Math.floor(diffMinutes / 60);
                            const diffDays = Math.floor(diffHours / 24);
                            const diffWeeks = Math.floor(diffDays / 7);
                            const diffMonths = Math.floor(diffDays / 30);
                            
                            if (diffMinutes < 60) {
                                statusText = `En ligne il y a ${diffMinutes} minute${diffMinutes > 1 ? 's' : ''}`;
                            } else if (diffHours < 24) {
                                statusText = `En ligne il y a ${diffHours} heure${diffHours > 1 ? 's' : ''}`;
                            } else if (diffDays < 7) {
                                statusText = `En ligne il y a ${diffDays} jour${diffDays > 1 ? 's' : ''}`;
                            } else if (diffWeeks < 4) {
                                statusText = `En ligne il y a ${diffWeeks} semaine${diffWeeks > 1 ? 's' : ''}`;
                            } else if (diffMonths < 12) {
                                statusText = `En ligne il y a ${diffMonths} mois`;
                            } else {
                                const diffYears = Math.floor(diffMonths / 12);
                                statusText = `En ligne il y a ${diffYears} an${diffYears > 1 ? 's' : ''}`;
                            }
                        }
                    }
                    
                    // S'assurer que le header a les bonnes classes pour l'espacement
                    chatHeader.className = 'p-6 border-b border-gray-200 flex-shrink-0';
                    
                    const headerContent = `
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    ${receiver.photo ? `<img src="/storage/${receiver.photo}" alt="${window.escapeHtml(receiverName)}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">` : `<div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">${receiverInitials}</div>`}
                                    <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full ${statusDotColor}"></span>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-gray-900">${window.escapeHtml(receiverName)}</p>
                                    <p class="text-sm ${statusColor} font-medium">${statusText}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Appeler
                                </button>
                                <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Appel video
                                </button>
                            </div>
                        </div>
                    `;
                    chatHeader.innerHTML = headerContent;
                }
                
                // Vider et afficher les messages
                messagesArea.innerHTML = '';
                
                if (filteredMessages.length === 0) {
                    messagesArea.innerHTML = '<div class="text-center py-12"><p class="text-sm text-gray-500">Aucun message dans cette conversation</p></div>';
                    return;
                }
                
                // currentUserId est déjà déclaré plus haut dans la fonction
                
                filteredMessages.forEach(message => {
                    const isSender = message.sender_id == currentUserId;
                    const messageDate = new Date(message.created_at);
                    const day = String(messageDate.getDate()).padStart(2, '0');
                    const month = String(messageDate.getMonth() + 1).padStart(2, '0');
                    const year = messageDate.getFullYear();
                    const hours = String(messageDate.getHours()).padStart(2, '0');
                    const minutes = String(messageDate.getMinutes()).padStart(2, '0');
                    const timeFormat = `${day}/${month}/${year} ${hours}:${minutes}`;
                    
                    // Vérifier si c'est un message système
                    const isSystemMessage = message.label === 'System' || 
                                          (message.content && (
                                              message.content.includes('📞❌') || 
                                              message.content.includes('📞✅') ||
                                              message.content.includes('Appel manqué') ||
                                              message.content.includes('Appel terminé')
                                          ));
                    
                    const messageDiv = document.createElement('div');
                    messageDiv.setAttribute('data-message-id', message.id);
                    
                    if (isSystemMessage) {
                        // Message système aligné à droite comme les messages envoyés (style WhatsApp)
                        messageDiv.className = 'flex items-start gap-3 justify-end my-2';
                        messageDiv.innerHTML = `
                            <div class="flex-1 flex justify-end">
                                <div class="max-w-[70%]">
                                    <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                        <p class="text-xs text-gray-600">${window.escapeHtml(message.content)}</p>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1 text-right">${timeFormat}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        messageDiv.className = isSender ? 'flex items-start gap-3 justify-end' : 'flex items-start gap-3';
                    if (isSender) {
                        messageDiv.innerHTML = `
                            <div class="flex-1 flex justify-end">
                                <div class="max-w-[70%]">
                                    <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                        <p class="text-sm">${window.escapeHtml(message.content)}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 text-right">${timeFormat}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        messageDiv.innerHTML = `
                            <div class="flex-1">
                                <div class="inline-block max-w-[70%]">
                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                        <p class="text-sm text-gray-700">${window.escapeHtml(message.content)}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">${timeFormat}</p>
                                </div>
                            </div>
                        `;
                        }
                    }
                    
                    messagesArea.appendChild(messageDiv);
                });
                
                // Scroll vers le bas
                setTimeout(() => {
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                }, 50);
            }
            
            // Fonction pour échapper le HTML
            window.escapeHtml = function(text) {
                if (typeof text !== "string") return text;

                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/\"/g, "&quot;")
                    .replace(/'/g, "&#039;")
                    .replace(/`/g, "&#96;");
            };

            // Fonction pour marquer les messages comme lus
            function markMessagesAsRead(receiverId) {
                if (!receiverId) return;
                
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                             document.querySelector('input[name="_token"]')?.value;
                
                if (!token) {
                    console.error('Token CSRF non trouvé');
                    return;
                }
                
                fetch('{{ route("admin.mes-messages.mark-as-read") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour le compteur dans la sidebar
                        updateUnreadCount(data.total_unread);
                        
                        // Mettre à jour le compteur dans la liste des contacts
                        updateContactUnreadCount(receiverId, 0);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du marquage des messages comme lus:', error);
                });
            }
            
            // Fonction pour mettre à jour le compteur de messages non lus dans la sidebar
            function updateUnreadCount(count) {
                // Mettre à jour le badge dans l'interface des messages
                const unreadBadge = document.querySelector('.unread-badge');
                const unreadText = document.querySelector('.unread-text');
                if (unreadBadge) {
                    unreadBadge.textContent = count;
                    if (count === 0) {
                        unreadBadge.style.display = 'none';
                    } else {
                        unreadBadge.style.display = 'flex';
                    }
                }
                if (unreadText) {
                    unreadText.textContent = count + ' nouveaux messages';
                }
                
                // Mettre à jour le badge dans la sidebar principale (layout admin)
                const sidebarLink = document.querySelector('a[href*="mes-messages"]');
                if (sidebarLink) {
                    let sidebarBadge = sidebarLink.querySelector('#sidebarUnreadBadge');
                    
                    if (count === 0) {
                        // Masquer le badge s'il existe
                        if (sidebarBadge) {
                            sidebarBadge.style.display = 'none';
                        }
                    } else {
                        // Afficher ou créer le badge
                        if (!sidebarBadge) {
                            sidebarBadge = document.createElement('span');
                            sidebarBadge.id = 'sidebarUnreadBadge';
                            sidebarBadge.className = 'badge badge-md badge-circle badge-floating badge-danger border-white';
                            sidebarLink.appendChild(sidebarBadge);
                        }
                        sidebarBadge.textContent = count;
                        sidebarBadge.style.display = 'flex';
                    }
                }
            }
            
            // Fonction pour mettre à jour le compteur de messages non lus d'un contact spécifique
            function updateContactUnreadCount(userId, count) {
                const contactItem = document.querySelector(`.chat-item[data-user-id="${userId}"]`);
                if (contactItem) {
                    // Chercher le badge de messages non lus existant
                    let unreadBadge = contactItem.querySelector('.flex.items-center.justify-end span[style*="background: linear-gradient"]');
                    
                    if (count > 0) {
                        if (!unreadBadge) {
                            // Créer le badge s'il n'existe pas
                            const flexContainer = contactItem.querySelector('.flex.items-center.justify-end');
                            if (flexContainer) {
                                unreadBadge = document.createElement('span');
                                unreadBadge.className = 'w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white';
                                unreadBadge.style.background = 'linear-gradient(180deg, #1a1f3a 0%, #161b33 100%)';
                                flexContainer.appendChild(unreadBadge);
                            }
                        }
                        if (unreadBadge) {
                            unreadBadge.textContent = count;
                            unreadBadge.style.display = 'flex';
                        }
                    } else {
                        // Supprimer le badge si count est 0
                        if (unreadBadge) {
                            unreadBadge.remove();
                        }
                        // Afficher la coche verte si le message a été lu
                        const flexContainer = contactItem.querySelector('.flex.items-center.justify-end');
                        if (flexContainer && !flexContainer.querySelector('svg')) {
                            const checkIcon = document.createElement('svg');
                            checkIcon.className = 'w-4 h-4 text-green-500';
                            checkIcon.setAttribute('fill', 'currentColor');
                            checkIcon.setAttribute('viewBox', '0 0 20 20');
                            checkIcon.innerHTML = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>';
                            flexContainer.appendChild(checkIcon);
                        }
                    }
                }
            }
            
            // Chat item click handler - Délégation d'événements pour fonctionner avec les éléments dynamiques
            console.log('🔍 [DEBUG admin] ===== INITIALISATION DU GESTIONNAIRE DE CLIC =====');
            const chatList = document.getElementById('chatList');
            console.log('🔍 [DEBUG admin] Initialisation du gestionnaire de clic pour chatList:', chatList ? '✅ trouvé' : '❌ NON TROUVÉ');
            
            if (chatList) {
                console.log('🔍 [DEBUG admin] chatList trouvé, ajout du listener de clic...');
                console.log('🔍 [DEBUG admin] chatList:', chatList);
                console.log('🔍 [DEBUG admin] chatList.innerHTML (premiers 200 chars):', chatList.innerHTML.substring(0, 200));
                
                // Ajouter un listener de test pour voir si les clics sont détectés
                chatList.addEventListener('click', function(e) {
                    console.log('🔍 [DEBUG admin] ===== CLIC DÉTECTÉ SUR chatList =====');
                    console.log('🔍 [DEBUG admin] Élément cliqué:', e.target);
                    console.log('🔍 [DEBUG admin] TagName:', e.target.tagName);
                    console.log('🔍 [DEBUG admin] Classes:', e.target.className);
                    console.log('🔍 [DEBUG admin] ID:', e.target.id);
                    console.log('🔍 [DEBUG admin] Parent:', e.target.parentElement);
                    
                    // Trouver l'élément .chat-item le plus proche du clic
                    const chatItem = e.target.closest('.chat-item');
                    console.log('🔍 [DEBUG admin] chatItem trouvé:', chatItem ? '✅' : '❌');
                    
                    if (!chatItem) {
                        console.log('❌ [DEBUG admin] Aucun chat-item trouvé, arrêt du traitement');
                        console.log('🔍 [DEBUG admin] Recherche de tous les chat-items dans le DOM...');
                        const allChatItems = document.querySelectorAll('.chat-item');
                        console.log('🔍 [DEBUG admin] Nombre total de chat-items dans le DOM:', allChatItems.length);
                        if (allChatItems.length > 0) {
                            console.log('🔍 [DEBUG admin] Premier chat-item:', allChatItems[0]);
                            console.log('🔍 [DEBUG admin] Classes du premier chat-item:', allChatItems[0].className);
                        }
                        return;
                    }
                    
                    console.log('🔍 [DEBUG admin] chatItem:', chatItem);
                    console.log('🔍 [DEBUG admin] Classes du chatItem:', chatItem.className);
                    console.log('🔍 [DEBUG admin] Tous les attributs du chatItem:', Array.from(chatItem.attributes).map(attr => `${attr.name}="${attr.value}"`));
                    
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('✅ [DEBUG admin] preventDefault et stopPropagation appelés');
                    
                    const userId = chatItem.getAttribute('data-user-id');
                    console.log('🔍 [DEBUG admin] userId extrait:', userId);

                    if (!userId) {
                        // Check if it's a group
                        const groupId = chatItem.getAttribute('data-group-id');
                        console.log('🔍 [DEBUG admin] groupId extrait:', groupId);
                        if (groupId) {
                            const groupName = chatItem.getAttribute('data-group-name');
                            console.log('✅ [DEBUG admin] C\'est un groupe:', groupId, groupName);

                            // Vérifier si déjà actif
                            const currentChat = new URL(window.location).searchParams.get('chat');
                            if (currentChat === 'group_' + groupId) {
                                console.log('Groupe déjà actif, rien à faire');
                                return;
                            }

                            // Update URL to reflect selected group
                            const url = new URL(window.location);
                            url.searchParams.set('chat', 'group_' + groupId);
                            window.history.pushState({}, '', url);
                            console.log('✅ [DEBUG admin] URL mise à jour');

                            // Update active state
                            document.querySelectorAll('.chat-item').forEach(item => {
                                item.classList.remove('active');
                                item.style.backgroundColor = '';
                                item.style.borderLeft = '';
                            });

                            chatItem.classList.add('active');
                            chatItem.style.backgroundColor = 'rgba(26, 31, 58, 0.1)';
                            chatItem.style.borderLeft = '4px solid #1a1f3a';
                            console.log('✅ [DEBUG admin] État actif mis à jour');

                            // Show group chat interface
                            showGroupChat(groupId, groupName);
                            console.log('✅ [DEBUG admin] showGroupChat appelé');

                            return;
                        }

                        console.error('❌ [DEBUG admin] ERREUR: ni userId ni groupId trouvé!');
                        console.error('❌ [DEBUG admin] Attributs du chatItem:', Array.from(chatItem.attributes).map(attr => `${attr.name}="${attr.value}"`));
                        return;
                    }
                    
                    console.log('✅ [DEBUG admin] userId valide:', userId);

                    // Vérifier si déjà actif
                    const currentChat = new URL(window.location).searchParams.get('chat');
                    if (currentChat === userId) {
                        console.log('Utilisateur déjà actif, rien à faire');
                        return;
                    }

                    // Mettre à jour l'état actif
                    const allChatItems = document.querySelectorAll('.chat-item');
                    console.log('🔍 [DEBUG admin] Nombre de chat-items trouvés:', allChatItems.length);

                    allChatItems.forEach(i => {
                        i.classList.remove('bg-blue-50', 'border-blue-200', 'active');
                        i.style.borderLeft = '';
                        i.style.backgroundColor = '';
                    });

                    chatItem.classList.add('bg-blue-50', 'border-blue-200', 'active');
                    chatItem.style.borderLeft = '4px solid #1a1f3a';
                    chatItem.style.backgroundColor = 'rgba(26, 31, 58, 0.1)';
                    console.log('✅ [DEBUG admin] État actif mis à jour pour le chat-item');

                    // Sauvegarder l'onglet actif dans l'URL et localStorage
                    const currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('chat', userId);
                    window.history.pushState({ chat: userId }, '', currentUrl.toString());
                    localStorage.setItem('activeChatId', userId);
                    console.log('✅ [DEBUG admin] URL et localStorage mis à jour avec userId:', userId);

                    // Vérifier les éléments DOM avant d'appeler loadThread
                    const chatPanel = document.getElementById('chatPanel');
                    const chatHeader = document.getElementById('chatHeader');
                    const messagesArea = document.getElementById('messagesArea');
                    const messageInputContainer = document.getElementById('messageInputContainer');

                    console.log('🔍 [DEBUG admin] Vérification des éléments DOM avant loadThread:');
                    console.log('  - chatPanel:', chatPanel ? '✅ trouvé' : '❌ NON TROUVÉ');
                    console.log('  - chatHeader:', chatHeader ? '✅ trouvé' : '❌ NON TROUVÉ');
                    console.log('  - messagesArea:', messagesArea ? '✅ trouvé' : '❌ NON TROUVÉ');
                    console.log('  - messageInputContainer:', messageInputContainer ? '✅ trouvé' : '❌ NON TROUVÉ');

                    if (chatPanel) {
                        console.log('  - chatPanel.display (avant):', window.getComputedStyle(chatPanel).display);
                    }

                    // Charger les messages dynamiquement
                    console.log('🔍 [DEBUG admin] Appel de loadThread avec userId:', userId);
                    loadThread(userId);

                    // Redémarrer le polling
                    console.log('🔍 [DEBUG admin] Arrêt du polling...');
                    stopPolling();
                    setTimeout(() => {
                        console.log('🔍 [DEBUG admin] Redémarrage du polling...');
                        startPolling();
                    }, 1000);
                });
                console.log('✅ [DEBUG admin] Listener de clic ajouté avec succès sur chatList');
            } else {
                console.error('❌ [DEBUG admin] ERREUR CRITIQUE: chatList non trouvé dans le DOM!');
                console.error('❌ [DEBUG admin] Tentative de recherche alternative...');
                const alternativeChatList = document.querySelector('[id*="chat"]');
                console.error('❌ [DEBUG admin] Éléments avec "chat" dans l\'ID:', alternativeChatList);
            }
            
            console.log('🔍 [DEBUG admin] ===== FIN DE L\'INITIALISATION DU GESTIONNAIRE DE CLIC =====');
            
            // Restaurer l'onglet actif au chargement de la page (supporte utilisateurs et groupes)
            document.addEventListener('DOMContentLoaded', function() {
                const urlParams = new URLSearchParams(window.location.search);
                let activeChatId = urlParams.get('chat');

                if (!activeChatId) {
                    activeChatId = localStorage.getItem('activeChatId');
                }

                if (activeChatId) {
                    // Attendre un peu pour que le DOM soit complètement chargé
                    setTimeout(function() {
                        // Cas groupe : "group_{id}"
                        if (typeof activeChatId === 'string' && activeChatId.startsWith('group_')) {
                            const groupId = activeChatId.split('_')[1];
                            const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
                            if (chatItem) {
                                console.log('✅ [ADMIN] Restauration du groupe actif:', activeChatId);
                                chatItem.click();
                                return;
                            }

                            // Si l'élément n'existe pas dans le DOM, afficher la vue groupe via la fonction JS
                            console.log('⚠️ [ADMIN] chat-item de groupe non trouvé, affichage via showGroupChat');
                            const groupName = chatItem ? chatItem.getAttribute('data-group-name') : 'Groupe';
                            showGroupChat(groupId, groupName || 'Groupe');
                            return;
                        }

                        // Cas utilisateur
                        const chatItemUser = document.querySelector(`.chat-item[data-user-id="${activeChatId}"]`);
                        if (chatItemUser) {
                            console.log('✅ [ADMIN] Restauration de l\'onglet utilisateur actif:', activeChatId);
                            chatItemUser.click();
                        } else {
                            console.warn('⚠️ [ADMIN] Onglet actif non trouvé:', activeChatId);
                        }
                    }, 100);
                }
            });

            // Add button functionality
            const addButton = document.getElementById('addButton');
            if (addButton) {
                addButton.addEventListener('click', function() {
                    openCreateGroupModal();
                });
            }


            // Create Group Form submission
            const createGroupForm = document.getElementById('createGroupForm');
            if (createGroupForm) {
                createGroupForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const selectedUsers = formData.getAll('user_ids[]');

                    if (selectedUsers.length === 0) {
                        alert('Veuillez sélectionner au moins un membre pour le groupe.');
                        return;
                    }

                    fetch('{{ route("admin.forum.groups.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP ${response.status}: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Groupe créé avec succès!');
                            closeCreateGroupModal();
                            // Optionally refresh the page or update the UI
                            location.reload();
                        } else {
                            alert('Erreur lors de la création du groupe: ' + (data.message || 'Erreur inconnue'));
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        alert('Erreur lors de la création du groupe: ' + error.message);
                    });
                });
            }

            // Search functionality
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    document.querySelectorAll('.chat-item').forEach(item => {
                        const text = item.textContent.toLowerCase();
                        item.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            // Emoji picker functionality
            const emojiBtn = document.getElementById('emojiBtn');
            const emojiPicker = document.getElementById('emojiPicker');
            const messageInput = document.getElementById('messageInput');

            if (emojiBtn && emojiPicker && messageInput) {
                // Toggle emoji picker
                emojiBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const isHidden = emojiPicker.classList.contains('hidden');
                    if (isHidden) {
                        emojiPicker.classList.remove('hidden');
                    } else {
                        emojiPicker.classList.add('hidden');
                    }
                });

                // Close emoji picker when clicking outside
                document.addEventListener('click', function(e) {
                    if (emojiBtn && emojiPicker && !emojiBtn.contains(e.target) && !emojiPicker.contains(e.target)) {
                        emojiPicker.classList.add('hidden');
                    }
                });

                // Insert emoji into input
                document.querySelectorAll('.emoji-item').forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const emoji = this.getAttribute('data-emoji');
                        if (emoji && messageInput) {
                            const cursorPos = messageInput.selectionStart || messageInput.value.length;
                            const textBefore = messageInput.value.substring(0, cursorPos);
                            const textAfter = messageInput.value.substring(cursorPos);
                            messageInput.value = textBefore + emoji + textAfter;
                            messageInput.focus();
                            const newPos = cursorPos + emoji.length;
                            messageInput.setSelectionRange(newPos, newPos);
                            emojiPicker.classList.add('hidden');
                        }
                    });
                });
            } else {
                // Les éléments ne sont pas encore disponibles, utiliser la délégation d'événements
                console.log('Emoji picker elements not found initially, using event delegation');
            }
            
            // Délégation d'événements pour le sélecteur d'emoji (fonctionne même si les éléments sont créés dynamiquement)
            document.addEventListener('click', function(e) {
                // Toggle emoji picker
                if (e.target.closest('#emojiBtn')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const emojiPicker = document.getElementById('emojiPicker');
                    if (emojiPicker) {
                        const isHidden = emojiPicker.classList.contains('hidden');
                        if (isHidden) {
                            emojiPicker.classList.remove('hidden');
                        } else {
                            emojiPicker.classList.add('hidden');
                        }
                    }
                }
                
                // Insert emoji into input
                if (e.target.closest('.emoji-item')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const emojiItem = e.target.closest('.emoji-item');
                    const emoji = emojiItem.getAttribute('data-emoji');
                    const messageInput = document.getElementById('messageInput');
                    const emojiPicker = document.getElementById('emojiPicker');
                    if (emoji && messageInput) {
                        const cursorPos = messageInput.selectionStart || messageInput.value.length;
                        const textBefore = messageInput.value.substring(0, cursorPos);
                        const textAfter = messageInput.value.substring(cursorPos);
                        messageInput.value = textBefore + emoji + textAfter;
                        messageInput.focus();
                        const newPos = cursorPos + emoji.length;
                        messageInput.setSelectionRange(newPos, newPos);
                        if (emojiPicker) {
                            emojiPicker.classList.add('hidden');
                        }
                    }
                }
                
                // Close emoji picker when clicking outside
                if (e.target.closest('#emojiPicker') || e.target.closest('#emojiBtn')) {
                    return;
                }
                const emojiPicker = document.getElementById('emojiPicker');
                if (emojiPicker && !emojiPicker.classList.contains('hidden')) {
                    emojiPicker.classList.add('hidden');
                }
            });

            // Gestion de l'envoi de messages - délégation d'événements
            document.addEventListener('submit', function(e) {
                const messageForm = e.target.closest('#messageForm');
                if (!messageForm) return;
                
                e.preventDefault();
                e.stopPropagation();
                
                const messageInput = document.getElementById('messageInput');
                const messagesArea = document.getElementById('messagesArea');
                const receiverIdInput = document.getElementById('receiverId');

                if (!messageInput || !messagesArea || !receiverIdInput) {
                    console.error('Éléments du formulaire non trouvés');
                    return;
                }
                
                const content = messageInput.value.trim();
                const receiverId = receiverIdInput.value;

                if (!content || !receiverId) {
                    return;
                }

                // Désactiver le bouton d'envoi
                const submitBtn = messageForm.querySelector('button[type="submit"]');
                const originalContent = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                // Préparer les données
                const formData = new FormData();
                formData.append('content', content);
                formData.append('receiver_id', receiverId);
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                // Envoyer le message
                fetch('{{ route("admin.mes-messages.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.message) {
                        // Vider le champ de saisie
                        messageInput.value = '';
                        
                        // Ajouter le message à l'interface
                        const msg = data.message;
                        const now = new Date(msg.created_at);
                        const timeStr = now.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                        
                        // Créer l'élément HTML du message
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'flex items-start gap-3 justify-end';
                        
                        messageDiv.innerHTML = `
                            <div class="flex-1 flex justify-end">
                                <div class="max-w-[70%]">
                                    <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                        <p class="text-sm">${window.escapeHtml(msg.content)}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 text-right">${timeStr}</p>
                                </div>
                            </div>
                        `;
                            messageDiv.setAttribute('data-message-id', msg.id);
                            
                            // Ajouter le message à la zone des messages
                            messagesArea.appendChild(messageDiv);
                            
                            // Mettre à jour lastMessageId
                            lastMessageId = msg.id;
                        
                        // Scroll vers le bas
                        messagesArea.scrollTop = messagesArea.scrollHeight;
                    } else {
                        alert(data.message || 'Erreur lors de l\'envoi du message');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de l\'envoi du message');
                })
                .finally(() => {
                    // Réactiver le bouton d'envoi
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalContent;
                });
            });

            // Système de rafraîchissement automatique des messages
            let lastMessageId = null;
            let pollingInterval = null;

            function startPolling() {
                // Arrêter le polling précédent s'il existe
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }

                // Récupérer les éléments à chaque fois
                const receiverIdInput = document.getElementById('receiverId');
                const messagesArea = document.getElementById('messagesArea');
                
                // Ne pas démarrer le polling si aucun contact n'est sélectionné ou si messagesArea n'existe pas
                if (!receiverIdInput || !receiverIdInput.value || !messagesArea) {
                    return;
                }

                // Récupérer l'ID du dernier message affiché
                const lastMessage = messagesArea.querySelector('.flex.items-start');
                if (lastMessage) {
                    const messageId = lastMessage.getAttribute('data-message-id');
                    if (messageId) {
                        lastMessageId = parseInt(messageId);
                    }
                }

                // Démarrer le polling toutes les 3 secondes
                pollingInterval = setInterval(function() {
                    // Récupérer les éléments à chaque fois
                    const receiverIdInput = document.getElementById('receiverId');
                    const messagesArea = document.getElementById('messagesArea');
                    
                    if (!receiverIdInput || !receiverIdInput.value || !messagesArea) {
                        clearInterval(pollingInterval);
                        return;
                    }

                    const receiverId = receiverIdInput.value;
                    const url = '{{ url("admin/mes-messages/thread") }}/' + receiverId;

                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.messages) {
                            // Filtrer uniquement les nouveaux messages
                            const newMessages = data.messages.filter(msg => {
                                return !lastMessageId || msg.id > lastMessageId;
                            });

                            if (newMessages.length > 0) {
                                // Marquer les nouveaux messages comme lus automatiquement
                                const receiverId = receiverIdInput.value;
                                if (receiverId) {
                                    markMessagesAsRead(receiverId);
                                }
                                
                                // Rafraîchir la liste des contacts quand un nouveau message arrive
                                // Cela garantit que la conversation avec le nouveau message remonte en haut
                                if (!isUpdatingContacts) {
                                    const url = '{{ route("admin.mes-messages.contacts") }}';
                                    fetch(url, {
                                        method: 'GET',
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(contactsData => {
                                        if (contactsData.success && contactsData.conversations) {
                                            requestAnimationFrame(() => {
                                                updateContactsList(contactsData.conversations);
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors du rafraîchissement de la liste:', error);
                                    });
                                }
                                
                                // Afficher les nouveaux messages
                                newMessages.forEach(msg => {
                                    // Vérifier si le message n'est pas déjà affiché
                                    const existingMessage = messagesArea.querySelector(`[data-message-id="${msg.id}"]`);
                                    if (!existingMessage) {
                                        const isSender = msg.sender_id == {{ $user->id }};
                                        const now = new Date(msg.created_at);
                                        const timeStr = now.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' }) + ' ' + now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                                        
                                        const messageDiv = document.createElement('div');
                                        messageDiv.className = isSender ? 'flex items-start gap-3 justify-end' : 'flex items-start gap-3';
                                        messageDiv.setAttribute('data-message-id', msg.id);
                                        
                                        if (isSender) {
                                            // Message de l'admin
                                            messageDiv.innerHTML = `
                                                <div class="flex-1 flex justify-end">
                                                    <div class="max-w-[70%]">
                                                        <div class="text-white rounded-lg p-3" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">
                                                            <p class="text-sm">${window.escapeHtml(msg.content)}</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-1 text-right">${timeStr}</p>
                                                    </div>
                                                </div>
                                            `;
                                        } else {
                                            // Message reçu
                                            messageDiv.innerHTML = `
                                                <div class="flex-1">
                                                    <div class="inline-block max-w-[70%]">
                                                        <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                            <p class="text-sm text-gray-700">${window.escapeHtml(msg.content)}</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 mt-1">${timeStr}</p>
                                                    </div>
                                                </div>
                                            `;
                                        }
                                        
                                        messagesArea.appendChild(messageDiv);
                                        lastMessageId = msg.id;
                                        
                                        // Scroll vers le bas
                                        messagesArea.scrollTop = messagesArea.scrollHeight;
                                    }
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors du rafraîchissement:', error);
                    });
                }, 3000); // Vérifier toutes les 3 secondes
            }

            function stopPolling() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }
            }

            // Charger automatiquement les messages si un contact est déjà sélectionné
            @if($activeChatId)
                loadThread({{ $activeChatId }});
            @endif

            // Démarrer le polling quand un contact est sélectionné
            const receiverIdInputInit = document.getElementById('receiverId');
            if (receiverIdInputInit && receiverIdInputInit.value) {
                startPolling();
            }

            // Le polling est déjà géré dans le gestionnaire de clic des chat-items

            // Variable pour suivre l'état de mise à jour
            let isUpdatingContacts = false;
            
            // DÉSACTIVÉ : Le rafraîchissement automatique de la liste est désactivé
            // La liste sera rafraîchie uniquement quand un nouveau message arrive
            // Cela évite les blocages et améliore les performances
            // function startContactsPolling() {
            //     // Désactivé pour éviter les blocages
            // }
            
            function updateContactsList(conversations) {
                if (isUpdatingContacts) {
                    return; // Éviter les mises à jour simultanées
                }
                
                isUpdatingContacts = true;
                
                try {
                    const chatList = document.getElementById('chatList');
                    if (!chatList) {
                        isUpdatingContacts = false;
                        return;
                    }
                    
                    // Sauvegarder l'ID du contact actif et la position de scroll
                    const activeChatItem = chatList.querySelector('.chat-item.active');
                    const activeUserId = activeChatItem ? activeChatItem.getAttribute('data-user-id') : null;
                    const scrollPosition = chatList.scrollTop;
                    
                    // Reconstruire la liste des contacts
                    let html = '';
                    conversations.forEach(conv => {
                        const user = conv.user;
                        const lastMessage = conv.last_message;
                        const isActive = activeUserId == user.id;
                        const initials = ((user.prenom || '').charAt(0) + (user.nom || '').charAt(0)).toUpperCase();
                        
                        // Calculer le statut en ligne
                        let isOnline = false;
                        if (user.last_seen) {
                            const lastSeen = new Date(user.last_seen);
                            const now = new Date();
                            const diffMinutes = Math.floor((now - lastSeen) / (1000 * 60));
                            isOnline = diffMinutes < 5;
                        }
                        
                        // Formater le temps du dernier message
                        let timeText = '';
                        if (lastMessage) {
                            const msgDate = new Date(lastMessage.created_at);
                            const now = new Date();
                            const diffMinutes = Math.floor((now - msgDate) / (1000 * 60));
                            const diffHours = Math.floor(diffMinutes / 60);
                            const diffDays = Math.floor(diffHours / 24);
                            
                            if (diffMinutes < 1) {
                                timeText = 'À l\'instant';
                            } else if (diffMinutes < 60) {
                                timeText = 'Il y a ' + diffMinutes + ' minute' + (diffMinutes > 1 ? 's' : '');
                            } else if (diffHours < 24) {
                                timeText = 'Il y a ' + diffHours + ' heure' + (diffHours > 1 ? 's' : '');
                            } else if (diffDays < 7) {
                                timeText = 'Il y a ' + diffDays + ' jour' + (diffDays > 1 ? 's' : '');
                            } else {
                                const day = String(msgDate.getDate()).padStart(2, '0');
                                const month = String(msgDate.getMonth() + 1).padStart(2, '0');
                                const year = msgDate.getFullYear();
                                timeText = `${day}/${month}/${year}`;
                            }
                        }
                        
                        html += `
                          <div class="p-4 cursor-pointer transition-colors chat-item ${isActive ? 'active' : ''}"
                            data-user-id="${user.id}"
                            style="${isActive ? 'background-color: rgba(26, 31, 58, 0.1); border-left: 4px solid #1a1f3a;' : ''}"
                            onmouseover="if(!this.classList.contains('active')) this.style.backgroundColor='rgba(0,0,0,0.02)'"
                            onmouseout="if(!this.classList.contains('active')) this.style.backgroundColor=''">
                            <div class="flex items-center gap-3">
                              <div class="relative flex-shrink-0">
                                ${user.photo ? `<img src="/storage/${String(user.photo).replace(/"/g, "&quot;").replace(/`/g, "&#96;")}" alt="${window.escapeHtml(user.prenom || '')} ${window.escapeHtml(user.nom || '')}" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">` : `<div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">${window.escapeHtml(initials)}</div>`}
                                <span class="absolute bottom-0 right-0 w-3 h-3 border-2 border-white rounded-full ${isOnline ? 'bg-green-500' : 'bg-gray-400'}"></span>
                              </div>
                              <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                  <p class="text-sm font-semibold text-gray-900 truncate">${window.escapeHtml(user.prenom || '')} ${window.escapeHtml(user.nom || '')}</p>
                                  ${lastMessage ? `<span class="text-xs text-gray-500 ml-2 flex-shrink-0">${timeText}</span>` : ''}
                                </div>
                                ${lastMessage ? `<p class="text-xs text-gray-600 truncate">${window.escapeHtml(lastMessage.content)}</p>` : '<p class="text-xs text-gray-400">Aucun message</p>'}
                                ${conv.unread_count > 0 ? `<span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-semibold text-white rounded-full" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">${conv.unread_count}</span>` : ''}
                              </div>
                            </div>
                          </div>
                        `;
                    });
                    
                    // Mettre à jour le HTML de manière atomique
                    chatList.innerHTML = html;
                    
                    // Restaurer la position de scroll si possible
                    if (scrollPosition > 0 && activeUserId) {
                        const newActiveItem = chatList.querySelector(`.chat-item[data-user-id="${activeUserId}"]`);
                        if (newActiveItem) {
                            // Essayer de restaurer la position de scroll approximativement
                            setTimeout(() => {
                                chatList.scrollTop = scrollPosition;
                            }, 0);
                        }
                    }
                } catch (error) {
                    console.error('Erreur lors de la mise à jour de la liste des contacts:', error);
                } finally {
                    isUpdatingContacts = false;
                }
            }
            
            // Le rafraîchissement de la liste est maintenant déclenché uniquement quand un nouveau message arrive
            // Cela évite les blocages et améliore les performances

            // Arrêter le polling quand on quitte la page
            window.addEventListener('beforeunload', function() {
                stopPolling();
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('mesMessagesSearchInput');
      const chatItems = document.querySelectorAll('.chat-item');
      const clearBtn = document.getElementById('clearMesMessagesSearchBtn');
      
      if (!searchInput || chatItems.length === 0) return;
      
      function filterConversations(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        
        chatItems.forEach(item => {
          const userName = item.getAttribute('data-user-name') || '';
          const itemText = item.textContent.toLowerCase();
          const isVisible = term === '' || userName.includes(term) || itemText.includes(term);
          item.style.display = isVisible ? '' : 'none';
        });
      }
      
      // Filtrer en temps réel pendant la saisie (filtrage instantané)
      searchInput.addEventListener('input', function() {
        filterConversations(this.value);
        
        // Afficher/masquer le bouton effacer - identique à Mes Notes
        if (clearBtn) {
          if (this.value.trim() !== '') {
            clearBtn.style.display = '';
          } else {
            clearBtn.style.display = 'none';
          }
        }
      });
      
      // Bouton effacer
      if (clearBtn) {
        clearBtn.addEventListener('click', function() {
          searchInput.value = '';
          filterConversations('');
          this.style.display = 'none';
          searchInput.focus();
        });
        
        // Masquer le bouton si le champ est vide au chargement
        if (searchInput.value.trim() === '') {
          clearBtn.style.display = 'none';
        }
      }
      
      // Filtrer au chargement si une recherche existe déjà
      if (searchInput.value.trim() !== '') {
        filterConversations(searchInput.value);
      }
    });
    </script>
    <!-- Bootstrap JS pour les composants de recherche -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Call Interface Modal -->
    <div id="callModal" class="call-modal-overlay">
        <div class="call-interface">
            <!-- Profile Section -->
            <div class="call-profile-section">
                <div class="call-profile-image" id="callProfileImage">
                    <span id="callProfileInitials"></span>
                </div>
                <h2 class="call-name" id="callName">Nom de l'appelant</h2>
                <p class="call-status" id="callStatus">Appel en cours...</p>
                <div class="call-timer" id="callTimer" style="display: none;">00:00</div>
                <div class="call-audio-visualizer" id="audioVisualizer" style="display: none;">
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                    <div class="audio-bar"></div>
                </div>
            </div>

            <!-- Call Controls -->
            <div class="call-controls">
                <!-- Mute Button -->
                <button id="muteBtn" class="call-btn call-btn-mute" title="Microphone">
                    <svg id="muteIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                    <svg id="muteIconOff" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6" style="stroke: #ef4444;"></path>
                    </svg>
                </button>

                <!-- Speaker Button -->
                <button id="speakerBtn" class="call-btn call-btn-speaker" title="Haut-parleur">
                    <svg id="speakerIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: block;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                    <svg id="speakerIconOff" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6" style="stroke: #ef4444;"></path>
                    </svg>
                </button>

                <!-- Answer Button (only visible when receiving call) -->
                <button id="answerBtn" class="call-btn call-btn-answer" title="Décrocher" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </button>

                <!-- Reject Button (only visible when receiving call) -->
                <button id="rejectBtn" class="call-btn call-btn-reject" title="Rejeter" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- End Call Button (visible during active call) -->
                <button id="endCallBtn" class="call-btn call-btn-end" title="Raccrocher" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Audio Element -->
            <audio id="remoteAudio" autoplay style="display: none;"></audio>
        </div>
    </div>

    <!-- Create Group Modal -->
    <div id="createGroupModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Créer un groupe de forum</h3>
                </div>
                <form id="createGroupForm" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="groupName" class="block text-sm font-medium text-gray-700">Nom du groupe</label>
                            <input type="text" id="groupName" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="groupDescription" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="groupDescription" name="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionner les membres</label>
                            <div id="usersList" class="border border-gray-300 rounded-md max-h-60 overflow-y-auto">
                                <!-- Users will be loaded here -->
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateGroupModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Annuler</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700">Créer le groupe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Socket.io and WebRTC Scripts -->
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script>
        // Modal functions for forum groups
        function openCreateGroupModal() {
            const modal = document.getElementById('createGroupModal');
            if (modal) {
                modal.classList.remove('hidden');
                loadUsersForGroup();
            }
        }

        function closeCreateGroupModal() {
            const modal = document.getElementById('createGroupModal');
            if (modal) {
                modal.classList.add('hidden');
                // Reset form
                document.getElementById('createGroupForm').reset();
            }
        }

        function loadUsersForGroup() {
            fetch('{{ route("admin.forum.groups.users") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.users) {
                        const usersList = document.getElementById('usersList');
                        if (usersList) {
                            let html = '<div class="p-3 space-y-2">';
                            data.users.forEach(user => {
                                const userName = (user.prenom || '') + ' ' + (user.nom || '');
                                const userInitials = ((user.prenom || '').charAt(0) + (user.nom || '').charAt(0)).toUpperCase();

                                html += `
                                    <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded cursor-pointer">
                                        <input type="checkbox" name="user_ids[]" value="${user.id}" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <div class="flex items-center space-x-3">
                                            ${user.photo ?
                                                `<img src="/storage/${user.photo}" alt="${userName}" class="w-8 h-8 rounded-full object-cover">` :
                                                `<div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-semibold text-xs" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);">${userInitials}</div>`
                                            }
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">${userName}</p>
                                                <p class="text-xs text-gray-500">${user.email}</p>
                                            </div>
                                        </div>
                                    </label>
                                `;
                            });
                            html += '</div>';
                            usersList.innerHTML = html;
                        }
                    }
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des utilisateurs:', error);
                });
        }

        function showGroupChat(groupId, groupName) {
            console.log('🔍 [DEBUG admin] showGroupChat appelé pour groupId:', groupId, 'groupName:', groupName);

            // Récupérer les éléments
            const receiverIdInput = document.getElementById('receiverId');
            const chatHeader = document.getElementById('chatHeader');
            const messagesArea = document.getElementById('messagesArea');
            const messageInputContainer = document.getElementById('messageInputContainer');
            const chatPanel = document.getElementById('chatPanel');

            // Afficher le panneau de chat
            if (chatPanel) {
                chatPanel.style.display = 'flex';
                console.log('✅ [DEBUG admin] chatPanel affiché');
            }

            // Mettre à jour le receiverId
            if (receiverIdInput) {
                receiverIdInput.value = 'group_' + groupId;
            }

            // Mettre à jour le header du chat pour le groupe
                if (chatHeader) {
                chatHeader.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-semibold text-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                                <div>
                                <p class="text-base font-bold text-gray-900"><a href="#" class="hover:underline" onclick="event.preventDefault(); (function(){ const el = document.querySelector('.chat-item[data-group-id="' + ${groupId} + '"]'); if(el){ el.click(); } else { console.warn('group item not found for id', ${groupId}); } })();">${window.escapeHtml(groupName)}</a></p>
                                <p class="text-sm text-gray-500">Groupe de discussion</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 text-sm font-medium text-gray-700" onclick="/* group call placeholder */">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Appeler
                            </button>
                            <button class="px-4 py-2 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium" style="background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);" onclick="/* group video call placeholder */">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Appel video
                            </button>
                        </div>
                    </div>
                `;
                chatHeader.style.display = 'block';
            }

            // Afficher les messages (placeholder pour l'instant)
            if (messagesArea) {
                messagesArea.innerHTML = `
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Bienvenue dans ${window.escapeHtml(groupName)}</h3>
                            <p class="text-gray-500">Cette fonctionnalité de chat de groupe sera bientôt disponible.</p>
                        </div>
                    </div>
                `;
                messagesArea.style.display = 'block';
            }

            // Determine membership and restrict rules
            try {
                const chatItem = document.querySelector(`.chat-item[data-group-id="${groupId}"]`);
                let members = [];
                let restrict = 0;
                if (chatItem) {
                    try { members = JSON.parse(chatItem.getAttribute('data-group-members') || '[]'); } catch(e){ members = []; }
                    restrict = parseInt(chatItem.getAttribute('data-group-restrict') || 0);
                }
                const currentUserId = {{ auth()->id() }};
                const isMember = members.some(m => parseInt(m.id) === parseInt(currentUserId));

                // If restricted and current user is not a member, hide input and show notice
                if (restrict && !isMember) {
                    if (messageInputContainer) messageInputContainer.style.display = 'none';
                    if (messagesArea) messagesArea.innerHTML = '<div class="text-center py-12"><p class="text-sm text-gray-500">Vous n\'êtes pas autorisé à envoyer des messages dans ce groupe.</p></div>';
                } else {
                    if (messageInputContainer) messageInputContainer.style.display = 'block';
                }
            } catch (e) {
                console.warn('Erreur vérification membres groupe', e);
                if (messageInputContainer) messageInputContainer.style.display = 'block';
            }

            console.log('✅ [DEBUG admin] Interface de chat de groupe affichée');
            // Attach click on group header name to open Group Details modal
            try {
                const headerLink = chatHeader.querySelector('a');
                if (headerLink) {
                    headerLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        openGroupModal(groupId);
                    });
                }
            } catch (err) {
                console.warn('Could not attach group header click', err);
            }
        }

        // WebRTC Call Manager (identique à apprenant et formateur, mais avec route admin)
        class CallManager {
            constructor() {
                this.socket = null;
                this.localStream = null;
                this.remoteStream = null;
                this.peerConnection = null;
                this.currentCall = null;
                this.callTimer = null;
                this.callStartTime = null;
                this.missedCallTimeout = null;
                this.isMuted = false;
                this.isSpeakerOn = false;
                this.userId = {{ auth()->id() }};
                this.userName = '{{ auth()->user()->prenom ?? "" }} {{ auth()->user()->nom ?? "" }}';
                this.userPhoto = '{{ auth()->user()->photo ?? null }}';
                
                this.init();
            }

            init() {
                // Initialize Socket.io
                try {
                    this.socket = io('http://localhost:6001', {
                        transports: ['websocket', 'polling'],
                        reconnection: true,
                        reconnectionDelay: 1000,
                        reconnectionAttempts: 5
                    });

                    this.socket.on('connect', () => {
                        console.log('✅ [ADMIN] Socket.io connecté, ID:', this.socket.id);
                        console.log('✅ [ADMIN] Envoi de user-connected avec userId:', this.userId);
                        this.socket.emit('user-connected', { userId: this.userId });
                    });

                    this.socket.on('disconnect', () => {
                        console.log('Socket.io disconnected');
                    });

                    // Listen for incoming calls
                    this.socket.on('incoming-call', (data) => {
                        console.log('📞 [ADMIN] Appel entrant reçu via Socket.io:', data);
                        this.handleIncomingCall(data);
                    });

                    // Listen for call accepted
                    this.socket.on('call-accepted', (data) => {
                        this.handleCallAccepted(data);
                    });

                    // Listen for call rejected
                    this.socket.on('call-rejected', (data) => {
                        this.handleCallRejected(data);
                    });

                    // Listen for call ended
                    this.socket.on('call-ended', (data) => {
                        this.handleCallEnded(data);
                    });

                    // Listen for ICE candidates
                    this.socket.on('ice-candidate', async (data) => {
                        await this.handleIceCandidate(data);
                    });

                    // Listen for offer
                    this.socket.on('offer', async (data) => {
                        await this.handleOffer(data);
                    });

                    // Listen for answer
                    this.socket.on('answer', async (data) => {
                        await this.handleAnswer(data);
                    });
                } catch (error) {
                    console.error('Socket.io connection error:', error);
                }

                // Setup UI event listeners
                this.setupEventListeners();
            }

            setupEventListeners() {
                // Call button - Admin interface uses different structure
                document.addEventListener('click', (e) => {
                    const callBtn = e.target.closest('button');
                    if (callBtn && callBtn.textContent.includes('Appeler')) {
                        // Dans l'interface admin, récupérer l'ID depuis le champ receiverId
                        const receiverIdInput = document.getElementById('receiverId');
                        if (receiverIdInput && receiverIdInput.value) {
                            const userId = receiverIdInput.value;
                            
                            // Récupérer le nom et la photo depuis le header du chat
                            const chatHeader = document.querySelector('#chatHeader') || 
                                             callBtn.closest('.p-6.border-b') ||
                                             callBtn.closest('.flex.items-center.justify-between');
                            
                            let userName = 'Contact';
                            let userPhoto = null;
                            
                            if (chatHeader) {
                                // Chercher le nom dans le header
                                const nameElement = chatHeader.querySelector('p.text-base.font-bold') || 
                                                   chatHeader.querySelector('p.font-bold');
                                if (nameElement) {
                                    userName = nameElement.textContent.trim();
                                }
                                
                                // Chercher la photo dans le header
                                const photoElement = chatHeader.querySelector('img');
                                if (photoElement) {
                                    userPhoto = photoElement.src;
                                }
                            }
                            
                            if (userId) {
                                console.log('Initiation d\'appel pour:', userId, userName);
                                this.initiateCall(userId, userName, userPhoto);
                            } else {
                                console.error('Aucun receiverId trouvé');
                                alert('Veuillez sélectionner un contact pour passer un appel.');
                            }
                        } else {
                            // Fallback: essayer de trouver depuis un élément parent avec data-user-id
                            const contactItem = callBtn.closest('[data-user-id]') || 
                                             callBtn.closest('.contact-item');
                            if (contactItem) {
                                const userId = contactItem.getAttribute('data-user-id');
                                const userName = contactItem.querySelector('p')?.textContent || 'Contact';
                                const userPhoto = contactItem.querySelector('img')?.src || null;
                                if (userId) {
                                    this.initiateCall(userId, userName, userPhoto);
                                }
                            } else {
                                console.error('Aucun contact sélectionné');
                                alert('Veuillez sélectionner un contact pour passer un appel.');
                            }
                        }
                    }
                });

                // Answer button
                document.getElementById('answerBtn')?.addEventListener('click', () => {
                    this.answerCall();
                });

                // Reject button
                document.getElementById('rejectBtn')?.addEventListener('click', () => {
                    this.rejectCall();
                });

                // End call button
                document.getElementById('endCallBtn')?.addEventListener('click', () => {
                    this.endCall(true);
                });

                // Mute button
                document.getElementById('muteBtn')?.addEventListener('click', () => {
                    this.toggleMute();
                });

                // Speaker button
                document.getElementById('speakerBtn')?.addEventListener('click', () => {
                    this.toggleSpeaker();
                });
            }

            async initiateCall(receiverId, receiverName, receiverPhoto) {
                try {
                    this.localStream = await navigator.mediaDevices.getUserMedia({ 
                        audio: true, 
                        video: false 
                    });

                    this.peerConnection = this.createPeerConnection();

                    this.localStream.getAudioTracks().forEach(track => {
                        this.peerConnection.addTrack(track, this.localStream);
                    });

                    const offer = await this.peerConnection.createOffer();
                    await this.peerConnection.setLocalDescription(offer);

                    this.currentCall = {
                        receiverId: receiverId,
                        receiverName: receiverName,
                        receiverPhoto: receiverPhoto,
                        isIncoming: false,
                        startedAt: new Date().toISOString(),
                        callStartTime: null
                    };

                    this.showCallInterface(receiverName, receiverPhoto, 'Appel en cours...', false);
                    this.playDialTone();

                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-user', {
                            to: receiverId,
                            offer: offer,
                            callerName: this.userName,
                            callerPhoto: this.userPhoto
                        });
                    }
                } catch (error) {
                    console.error('Error initiating call:', error);
                    alert('Impossible de démarrer l\'appel. Vérifiez vos permissions de microphone.');
                    this.actuallyEndCall();
                }
            }

            handleIncomingCall(data) {
                console.log('📞 [ADMIN] handleIncomingCall appelé avec:', data);
                
                this.currentCall = {
                    callerId: data.from,
                    callerName: data.callerName,
                    callerPhoto: data.callerPhoto,
                    offer: data.offer,
                    isIncoming: true,
                    startedAt: new Date().toISOString(),
                    callStartTime: null
                };

                console.log('📞 [ADMIN] Affichage de l\'interface d\'appel pour:', data.callerName);
                this.showCallInterface(
                    data.callerName, 
                    data.callerPhoto, 
                    'Appel entrant...', 
                    true
                );

                console.log('📞 [ADMIN] Lecture de la sonnerie');
                this.playRingtone();
                
                this.missedCallTimeout = setTimeout(() => {
                    if (this.currentCall && this.currentCall.isIncoming && !this.callStartTime) {
                        this.showCallEndedMessage('Appel manqué');
                        if (this.socket && this.socket.connected) {
                            this.socket.emit('call-missed', { to: this.currentCall.callerId });
                        }
                        setTimeout(() => {
                            this.endCall();
                        }, 2000);
                    }
                }, 30000);
            }

            async answerCall() {
                try {
                    if (!this.currentCall || !this.currentCall.offer) {
                        console.error('No incoming call to answer');
                        return;
                    }

                    this.localStream = await navigator.mediaDevices.getUserMedia({ 
                        audio: true, 
                        video: false 
                    });

                    this.peerConnection = this.createPeerConnection();

                    this.localStream.getAudioTracks().forEach(track => {
                        this.peerConnection.addTrack(track, this.localStream);
                    });

                    await this.peerConnection.setRemoteDescription(
                        new RTCSessionDescription(this.currentCall.offer)
                    );

                    const answer = await this.peerConnection.createAnswer();
                    await this.peerConnection.setLocalDescription(answer);

                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-accepted', {
                            to: this.currentCall.callerId,
                            answer: answer
                        });
                    }

                    if (this.currentCall) {
                        this.currentCall.callStartTime = Date.now();
                    }

                    this.stopRingtone();

                    this.showCallInterface(
                        this.currentCall.callerName,
                        this.currentCall.callerPhoto,
                        'En communication...',
                        false
                    );
                    this.startCallTimer();

                } catch (error) {
                    console.error('Error answering call:', error);
                    alert('Impossible de répondre à l\'appel.');
                    this.actuallyEndCall();
                }
            }

            rejectCall() {
                this.stopRingtone();
                
                if (this.currentCall && this.currentCall.isIncoming) {
                    if (this.socket && this.socket.connected) {
                        this.socket.emit('call-rejected', {
                            to: this.currentCall.callerId
                        });
                    }
                    this.currentCall.status = 'rejected';
                }
                this.showCallEndedMessage('Appel manqué');
                setTimeout(() => {
                    this.actuallyEndCall();
                }, 2000);
            }

            async handleCallAccepted(data) {
                this.stopDialTone();

                await this.peerConnection.setRemoteDescription(
                    new RTCSessionDescription(data.answer)
                );

                if (this.currentCall) {
                    this.currentCall.callStartTime = Date.now();
                }

                this.showCallInterface(
                    this.currentCall.receiverName,
                    this.currentCall.receiverPhoto,
                    'En communication...',
                    false
                );
                this.startCallTimer();
            }

            handleCallRejected(data) {
                this.showCallEndedMessage('Appel manqué');
                setTimeout(() => {
                    this.endCall();
                }, 2000);
            }

            handleCallEnded(data) {
                const wasAnswered = this.currentCall?.callStartTime !== null || data?.wasAnswered === true;
                const message = wasAnswered ? 'Appel terminé' : 'Appel manqué';
                this.showCallEndedMessage(message);
                setTimeout(() => {
                    this.actuallyEndCall();
                }, 2000);
            }

            endCall(showMessage = false) {
                this.stopRingtone();
                this.stopDialTone();
                
                if (showMessage && this.currentCall) {
                    const wasAnswered = this.currentCall?.callStartTime !== null;
                    const message = wasAnswered ? 'Appel terminé' : 'Appel manqué';
                    this.showCallEndedMessage(message);
                    
                    if (this.socket && this.socket.connected) {
                        if (this.currentCall.isIncoming) {
                            this.socket.emit('call-ended', { 
                                to: this.currentCall.callerId,
                                wasAnswered: wasAnswered
                            });
                        } else {
                            this.socket.emit('call-ended', { 
                                to: this.currentCall.receiverId,
                                wasAnswered: wasAnswered
                            });
                        }
                    }
                    
                    setTimeout(() => {
                        this.actuallyEndCall();
                    }, 2000);
                    return;
                }

                if (this.currentCall && this.socket && this.socket.connected) {
                    const wasAnswered = this.currentCall?.callStartTime !== null;
                    if (this.currentCall.isIncoming) {
                        this.socket.emit('call-ended', { 
                            to: this.currentCall.callerId,
                            wasAnswered: wasAnswered
                        });
                    } else {
                        this.socket.emit('call-ended', { 
                            to: this.currentCall.receiverId,
                            wasAnswered: wasAnswered
                        });
                    }
                }

                this.actuallyEndCall();
            }

            actuallyEndCall() {
                this.saveCallToDatabase();

                if (this.missedCallTimeout) {
                    clearTimeout(this.missedCallTimeout);
                    this.missedCallTimeout = null;
                }

                if (this.localStream) {
                    this.localStream.getTracks().forEach(track => track.stop());
                    this.localStream = null;
                }

                if (this.peerConnection) {
                    this.peerConnection.close();
                    this.peerConnection = null;
                }

                this.stopCallTimer();

                this.stopRingtone();
                this.stopDialTone();

                this.isMuted = false;
                this.isSpeakerOn = false;
                this.updateMuteIcon(false);
                this.updateSpeakerIcon(false);

                this.hideCallInterface();
                this.currentCall = null;
            }

            saveCallToDatabase() {
                if (!this.currentCall) return;

                let callerId, receiverId, status, wasAnswered;
                
                if (this.currentCall.isIncoming) {
                    callerId = this.currentCall.callerId;
                    receiverId = this.userId;
                } else {
                    callerId = this.userId;
                    receiverId = this.currentCall.receiverId;
                }

                wasAnswered = this.currentCall.callStartTime !== null;
                
                if (this.currentCall.status === 'rejected') {
                    status = 'rejected';
                } else if (!wasAnswered) {
                    status = 'missed';
                } else {
                    status = 'ended';
                }

                let duration = null;
                let endedAt = new Date().toISOString();
                
                if (wasAnswered && this.currentCall.callStartTime) {
                    duration = Math.floor((Date.now() - this.currentCall.callStartTime) / 1000);
                }

                const startedAt = this.currentCall.startedAt || new Date().toISOString();

                const formData = new FormData();
                formData.append('receiver_id', receiverId);
                formData.append('started_at', startedAt);
                formData.append('ended_at', endedAt);
                formData.append('duration', duration || 0);
                formData.append('status', status);
                formData.append('was_answered', wasAnswered ? 1 : 0);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                fetch('{{ route("admin.mes-messages.calls.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Appel enregistré avec succès:', data.call);
                    } else {
                        console.error('Erreur lors de l\'enregistrement de l\'appel:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de l\'enregistrement de l\'appel:', error);
                });
            }

            createPeerConnection() {
                const configuration = {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' }
                    ]
                };
                const pc = new RTCPeerConnection(configuration);

                pc.onicecandidate = (event) => {
                    if (event.candidate) {
                        const targetId = this.currentCall?.isIncoming 
                            ? this.currentCall.callerId 
                            : this.currentCall?.receiverId;
                        if (targetId && this.socket && this.socket.connected) {
                            this.socket.emit('ice-candidate', {
                                to: targetId,
                                candidate: event.candidate
                            });
                        }
                    }
                };

                pc.ontrack = (event) => {
                    this.remoteStream = event.streams[0];
                    const remoteAudio = document.getElementById('remoteAudio');
                    if (remoteAudio) {
                        remoteAudio.srcObject = this.remoteStream;
                        remoteAudio.volume = this.isSpeakerOn ? 1.0 : 0;
                    }
                };

                return pc;
            }

            async handleIceCandidate(data) {
                if (this.peerConnection && data.candidate) {
                    await this.peerConnection.addIceCandidate(
                        new RTCIceCandidate(data.candidate)
                    );
                }
            }

            async handleOffer(data) {
                // Handled in handleIncomingCall
            }

            async handleAnswer(data) {
                // Handled in handleCallAccepted
            }

            showCallInterface(name, photo, status, isIncoming) {
                console.log('📞 [ADMIN] showCallInterface appelé:', { name, photo, status, isIncoming });
                
                const modal = document.getElementById('callModal');
                const callName = document.getElementById('callName');
                const callStatus = document.getElementById('callStatus');
                const callProfileImage = document.getElementById('callProfileImage');
                const callProfileInitials = document.getElementById('callProfileInitials');
                const callTimer = document.getElementById('callTimer');
                const audioVisualizer = document.getElementById('audioVisualizer');
                const answerBtn = document.getElementById('answerBtn');
                const rejectBtn = document.getElementById('rejectBtn');
                const endCallBtn = document.getElementById('endCallBtn');
                const muteBtn = document.getElementById('muteBtn');
                const speakerBtn = document.getElementById('speakerBtn');

                if (!modal) {
                    console.error('❌ [ADMIN] callModal non trouvé!');
                    return;
                }

                if (callName) callName.textContent = name;
                if (callStatus) {
                    callStatus.textContent = status;
                    callStatus.style.color = 'rgba(255, 255, 255, 0.8)';
                    callStatus.style.fontWeight = '400';
                }

                // Set profile image
                if (photo && photo.trim() !== '' && photo !== 'null') {
                    let photoPath = photo;
                    if (!photo.startsWith('http') && !photo.startsWith('/')) {
                        photoPath = `/storage/${photo}`;
                    } else if (photo.startsWith('storage/')) {
                        photoPath = `/${photo}`;
                    }
                    if (callProfileInitials) callProfileInitials.textContent = '';
                    const initials = this.getInitials(name);
                    callProfileImage.innerHTML = `<img src="${photoPath}" alt="${this.escapeHtml(name)}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.style.display='none'; if(document.getElementById('callProfileInitials')) document.getElementById('callProfileInitials').textContent='${initials}';">`;
                } else {
                    const initials = this.getInitials(name);
                    if (callProfileInitials) callProfileInitials.textContent = initials;
                    if (callProfileImage) {
                        const img = callProfileImage.querySelector('img');
                        if (img) img.remove();
                    }
                }

                if (modal) {
                    modal.classList.add('active');
                    console.log('✅ [ADMIN] Modal d\'appel affiché');
                }
                document.body.style.overflow = 'hidden';

                if (isIncoming) {
                    if (answerBtn) answerBtn.style.display = 'flex';
                    if (rejectBtn) rejectBtn.style.display = 'flex';
                    if (endCallBtn) endCallBtn.style.display = 'none';
                    if (muteBtn) muteBtn.style.display = 'none';
                    if (speakerBtn) speakerBtn.style.display = 'none';
                    if (callProfileImage) callProfileImage.classList.add('call-ringing-animation');
                    if (callTimer) callTimer.style.display = 'none';
                    if (audioVisualizer) audioVisualizer.style.display = 'none';
                } else {
                    if (answerBtn) answerBtn.style.display = 'none';
                    if (rejectBtn) rejectBtn.style.display = 'none';
                    if (endCallBtn) endCallBtn.style.display = 'flex';
                    if (muteBtn) muteBtn.style.display = 'flex';
                    if (speakerBtn) speakerBtn.style.display = 'flex';
                    if (callProfileImage) callProfileImage.classList.remove('call-ringing-animation');
                    if (callTimer) callTimer.style.display = 'none';
                    if (audioVisualizer) audioVisualizer.style.display = 'none';
                }
            }

            hideCallInterface() {
                const modal = document.getElementById('callModal');
                if (modal) modal.classList.remove('active');
                document.body.style.overflow = '';
            }

            showCallEndedMessage(message) {
                const callStatus = document.getElementById('callStatus');
                const callTimer = document.getElementById('callTimer');
                const audioVisualizer = document.getElementById('audioVisualizer');
                
                if (callStatus) {
                    callStatus.textContent = message;
                    callStatus.style.color = message === 'Appel manqué' ? '#ef4444' : '#6b7280';
                    callStatus.style.fontWeight = '600';
                }
                
                if (callTimer) {
                    callTimer.style.display = 'none';
                }
                
                if (audioVisualizer) {
                    audioVisualizer.style.display = 'none';
                }

                this.sendSystemMessage(message);
                
                const answerBtn = document.getElementById('answerBtn');
                const rejectBtn = document.getElementById('rejectBtn');
                const endCallBtn = document.getElementById('endCallBtn');
                const muteBtn = document.getElementById('muteBtn');
                const speakerBtn = document.getElementById('speakerBtn');
                
                if (answerBtn) answerBtn.style.display = 'none';
                if (rejectBtn) rejectBtn.style.display = 'none';
                if (endCallBtn) endCallBtn.style.display = 'flex';
                if (muteBtn) muteBtn.style.display = 'none';
                if (speakerBtn) speakerBtn.style.display = 'none';
            }

            startCallTimer() {
                this.callStartTime = Date.now();
                const timerElement = document.getElementById('callTimer');
                if (timerElement) {
                    timerElement.style.display = 'block';
                    timerElement.textContent = '00:00';
                }

                this.callTimer = setInterval(() => {
                    if (this.callStartTime && timerElement) {
                        const elapsed = Math.floor((Date.now() - this.callStartTime) / 1000);
                        const minutes = Math.floor(elapsed / 60);
                        const seconds = elapsed % 60;
                        timerElement.textContent = 
                            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    }
                }, 1000);
            }

            stopCallTimer() {
                if (this.callTimer) {
                    clearInterval(this.callTimer);
                    this.callTimer = null;
                }
                const timerElement = document.getElementById('callTimer');
                if (timerElement) timerElement.style.display = 'none';
                this.callStartTime = null;
            }

            toggleMute() {
                if (this.localStream) {
                    this.isMuted = !this.isMuted;
                    this.localStream.getAudioTracks().forEach(track => {
                        track.enabled = !this.isMuted;
                    });
                    
                    this.updateMuteIcon(this.isMuted);
                    console.log('Micro ' + (this.isMuted ? 'désactivé (arrêt immédiat - 0 seconde)' : 'activé'));
                }
            }

            updateMuteIcon(isMuted) {
                const muteIcon = document.getElementById('muteIcon');
                const muteIconOff = document.getElementById('muteIconOff');
                const muteBtn = document.getElementById('muteBtn');
                
                if (muteIcon && muteIconOff) {
                    if (isMuted) {
                        muteIcon.style.display = 'none';
                        muteIconOff.style.display = 'block';
                    } else {
                        muteIcon.style.display = 'block';
                        muteIconOff.style.display = 'none';
                    }
                }
                
                if (muteBtn) {
                    muteBtn.classList.toggle('active', isMuted);
                }
            }

            toggleSpeaker() {
                this.isSpeakerOn = !this.isSpeakerOn;
                const remoteAudio = document.getElementById('remoteAudio');
                if (remoteAudio) {
                    if (!this.isSpeakerOn) {
                        remoteAudio.volume = 0;
                        remoteAudio.pause();
                    } else {
                        remoteAudio.volume = 1.0;
                        remoteAudio.play();
                    }
                }
                
                if (!this.isSpeakerOn) {
                    this.stopDialTone();
                } else {
                    if (this.currentCall && !this.currentCall.isIncoming && !this.currentCall.callStartTime) {
                        this.playDialTone();
                    }
                }
                
                this.updateSpeakerIcon(this.isSpeakerOn);
                console.log('Haut-parleur ' + (this.isSpeakerOn ? 'activé' : 'désactivé (arrêt immédiat)'));
            }

            updateSpeakerIcon(isOn) {
                const speakerIcon = document.getElementById('speakerIcon');
                const speakerIconOff = document.getElementById('speakerIconOff');
                const speakerBtn = document.getElementById('speakerBtn');
                
                if (speakerIcon && speakerIconOff) {
                    if (isOn) {
                        speakerIcon.style.display = 'block';
                        speakerIconOff.style.display = 'none';
                    } else {
                        speakerIcon.style.display = 'none';
                        speakerIconOff.style.display = 'block';
                    }
                }
                
                if (speakerBtn) {
                    speakerBtn.classList.toggle('active', isOn);
                }
            }

            playRingtone() {
                if (window.playRingtoneAudio) {
                    window.playRingtoneAudio();
                } else {
                    const ringtone = document.getElementById('ringtoneAudio');
                    if (ringtone) {
                        ringtone.loop = true;
                        ringtone.volume = 0.7;
                        ringtone.play().catch(error => {
                            console.error('Error playing ringtone:', error);
                        });
                    }
                }
            }

            stopRingtone() {
                if (window.stopRingtoneAudio) {
                    window.stopRingtoneAudio();
                } else {
                    const ringtone = document.getElementById('ringtoneAudio');
                    if (ringtone) {
                        ringtone.pause();
                        ringtone.currentTime = 0;
                        ringtone.src = '';
                    }
                }
            }

            playDialTone() {
                if (window.playDialToneAudio) {
                    window.playDialToneAudio();
                } else {
                    const dialTone = document.getElementById('dialToneAudio');
                    if (dialTone) {
                        dialTone.loop = true;
                        dialTone.volume = 0.5;
                        dialTone.play().catch(error => {
                            console.error('Error playing dial tone:', error);
                        });
                    }
                }
            }

            stopDialTone() {
                if (window.stopDialToneAudio) {
                    window.stopDialToneAudio();
                } else {
                    const dialTone = document.getElementById('dialToneAudio');
                    if (dialTone) {
                        dialTone.pause();
                        dialTone.currentTime = 0;
                        dialTone.src = '';
                    }
                }
            }

            sendSystemMessage(message) {
                if (!this.currentCall) return;

                const receiverId = this.currentCall.isIncoming 
                    ? this.currentCall.callerId 
                    : this.currentCall.receiverId;

                if (!receiverId) return;

                const icon = message === 'Appel manqué' ? '📞❌' : '📞✅';
                const content = `${icon} ${message}`;

                const formData = new FormData();
                formData.append('receiver_id', receiverId);
                formData.append('content', content);
                formData.append('label', 'System');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

                fetch('{{ route("admin.mes-messages.send") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.message) {
                        const receiverIdInput = document.getElementById('receiverId');
                        const messagesArea = document.getElementById('messagesArea');
                        
                        if (receiverIdInput && receiverIdInput.value == receiverId && messagesArea) {
                            this.addSystemMessageToUI(data.message);
                        } else {
                            if (typeof loadThread === 'function') {
                                loadThread(receiverId);
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de l\'envoi du message système:', error);
                });
            }

            addSystemMessageToUI(message) {
                // Ajouter directement un message système dans l'interface
                const messagesArea = document.getElementById('messagesArea');
                if (!messagesArea) {
                    console.error('❌ [ADMIN] messagesArea non trouvé');
                    return;
                }

                // Vérifier si le message n'existe pas déjà
                const existingMessage = messagesArea.querySelector(`[data-message-id="${message.id}"]`);
                if (existingMessage) {
                    console.log('Message système déjà présent dans l\'interface');
                    return;
                }

                // Créer l'élément du message système - Aligné à droite comme WhatsApp
                const messageDiv = document.createElement('div');
                messageDiv.className = 'flex items-start gap-3 justify-end my-2';
                messageDiv.setAttribute('data-message-id', message.id);

                // Formater la date
                const messageDate = new Date(message.created_at);
                const day = String(messageDate.getDate()).padStart(2, '0');
                const month = String(messageDate.getMonth() + 1).padStart(2, '0');
                const year = messageDate.getFullYear();
                const hours = String(messageDate.getHours()).padStart(2, '0');
                const minutes = String(messageDate.getMinutes()).padStart(2, '0');
                const timeFormat = `${day}/${month}/${year} ${hours}:${minutes}`;

                messageDiv.innerHTML = `
                    <div class="flex-1 flex justify-end">
                        <div class="max-w-[70%]">
                            <div class="bg-gray-200 rounded-lg px-3 py-2 inline-block">
                                <p class="text-xs text-gray-600">${this.escapeHtml(message.content)}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 text-right">${timeFormat}</p>
                        </div>
                    </div>
                `;

                // Ajouter le message à la fin de la conversation
                messagesArea.appendChild(messageDiv);

                // Faire défiler vers le bas pour voir le nouveau message
                messagesArea.scrollTop = messagesArea.scrollHeight;

                console.log('✅ [ADMIN] Message système ajouté à l\'interface:', message.id);
            }

            escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            getInitials(name) {
                if (!name) return '??';
                const parts = name.trim().split(' ').filter(p => p.length > 0);
                if (parts.length === 0) return '??';
                if (parts.length === 1) return parts[0].substring(0, 2).toUpperCase();
                return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            }
        }

        // Initialize Call Manager when page loads
        let callManager;
        document.addEventListener('DOMContentLoaded', () => {
            callManager = new CallManager();
        });

        // Generate ringtone (melody for incoming call)
        function generateRingtone() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const sampleRate = audioContext.sampleRate;
            const duration = 0.5;
            const buffer = audioContext.createBuffer(1, sampleRate * duration, sampleRate);
            const data = buffer.getChannelData(0);
            
            for (let i = 0; i < data.length; i++) {
                const t = i / sampleRate;
                const tone1 = Math.sin(2 * Math.PI * 440 * t) * 0.3;
                const tone2 = Math.sin(2 * Math.PI * 554 * t) * 0.3;
                const fade = Math.sin(Math.PI * t / duration);
                data[i] = (tone1 + tone2) * fade;
            }
            
            return buffer;
        }

        // Generate dial tone (continuous tone for outgoing call)
        function generateDialTone() {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const sampleRate = audioContext.sampleRate;
            const duration = 2;
            const buffer = audioContext.createBuffer(1, sampleRate * duration, sampleRate);
            const data = buffer.getChannelData(0);
            
            for (let i = 0; i < data.length; i++) {
                const t = i / sampleRate;
                const tone1 = Math.sin(2 * Math.PI * 350 * t) * 0.2;
                const tone2 = Math.sin(2 * Math.PI * 440 * t) * 0.2;
                data[i] = tone1 + tone2;
            }
            
            return buffer;
        }

        // Initialize audio when page loads
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const ringtoneBuffer = generateRingtone();
                const dialToneBuffer = generateDialTone();
                
                let ringtoneSource = null;
                let dialToneSource = null;
                
                window.playRingtoneAudio = function() {
                    // Activer l'audioContext si nécessaire (sans attendre pour jouer immédiatement)
                    if (audioContext.state === 'suspended') {
                        audioContext.resume().catch(err => {
                            console.error('Erreur lors de l\'activation de l\'audioContext:', err);
                        });
                    }
                    
                    if (ringtoneSource) {
                        try {
                            ringtoneSource.stop(0);
                        } catch (e) {}
                        ringtoneSource.disconnect();
                    }
                    ringtoneSource = audioContext.createBufferSource();
                    ringtoneSource.buffer = ringtoneBuffer;
                    ringtoneSource.connect(audioContext.destination);
                    ringtoneSource.loop = true;
                    ringtoneSource.start(0);
                };
                
                window.stopRingtoneAudio = function() {
                    if (ringtoneSource) {
                        try {
                            ringtoneSource.stop(0);
                        } catch (e) {}
                        ringtoneSource.disconnect();
                        ringtoneSource = null;
                    }
                };
                
                window.playDialToneAudio = function() {
                    // Activer l'audioContext si nécessaire (sans attendre pour jouer immédiatement)
                    if (audioContext.state === 'suspended') {
                        audioContext.resume().catch(err => {
                            console.error('Erreur lors de l\'activation de l\'audioContext:', err);
                        });
                    }
                    
                    if (dialToneSource) {
                        try {
                            dialToneSource.stop(0);
                        } catch (e) {}
                        dialToneSource.disconnect();
                    }
                    dialToneSource = audioContext.createBufferSource();
                    dialToneSource.buffer = dialToneBuffer;
                    dialToneSource.connect(audioContext.destination);
                    dialToneSource.loop = true;
                    dialToneSource.start(0);
                };
                
                window.stopDialToneAudio = function() {
                    if (dialToneSource) {
                        try {
                            dialToneSource.stop(0);
                        } catch (e) {}
                        dialToneSource.disconnect();
                        dialToneSource = null;
                    }
                };
            } catch (error) {
                console.error('Error initializing audio:', error);
            }
        });
    </script>
</body>
</html>

















