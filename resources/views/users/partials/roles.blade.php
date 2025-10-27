<div id="roles-permissions-content" data-loaded="true" class="rounded-lg border border-gray-300 bg-white shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-semibold leading-none tracking-tight">Roles & Permissions</h3>
            <p class="text-sm text-gray-500">Manage user roles and their permissions</p>
        </div>
        <button id="addRoleButton"
                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 h-10 px-4 py-2">
            <x-lucide-plus class="h-4 w-4" />
            Add Role
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Role Name</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Description</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Permissions</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
                    <th class="h-12 px-4 text-left align-only-middle font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr class="border-b border-gray-300 hover:bg-gray-50">
                        <td class="p-4 align-middle font-medium">{{ $role->role_name }}</td>
                        <td class="p-4 align-middle text-gray-500">{{ $role->description ?? '-' }}</td>
                        <td class="p-4 align-middle">
                            @php
                                $rolePermissions = $role->permissions ?? [];
                                $count = count($rolePermissions);
                            @endphp
                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium">
                                {{ $count }} permission{{ $count !== 1 ? 's' : '' }}
                            </span>
                        </td>
                        <td class="p-4 align-middle">
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                                {{ $role->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $role->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="p-4 align-middle">
                            <div class="flex items-center space-x-2">
                                <button class="edit-role-button inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3"
                                        data-role-id="{{ $role->id }}">
                                    <x-lucide-square-pen class="h-4 w-4" />
                                </button>
                                <button class="delete-role-button inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3"
                                        data-role-id="{{ $role->id }}">
                                    <x-lucide-trash-2 class="h-4 w-4 text-red-500" />
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ==================== ROLE DIALOG ==================== --}}
<dialog id="roleDialog"
        class="fixed inset-0 z-50 w-full max-w-md mx-auto my-8 p-6 bg-white rounded-lg shadow-lg">
    <div class="relative">
        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 close-dialog">
            <x-lucide-x class="h-6 w-6" />
        </button>

        <h3 id="roleDialogTitle" class="text-lg font-semibold mb-4">Add New Role</h3>

        <form id="roleForm">
            @csrf
            <input type="hidden" id="roleId" name="id">

            <div class="space-y-4">
                <div>
                    <label for="roleName" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <input type="text" id="roleName" name="role_name" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div>
                    <label for="roleDescription" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="roleDescription" name="description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Permissions</label>
                    <div class="mt-2 space-y-2">
                        @foreach ($permissions as $key => $description)
                            <div class="flex items-center">
                                <input id="perm-{{ $key }}" name="permissions[]" type="checkbox" value="{{ $key }}"
                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="perm-{{ $key }}" class="ml-3 text-sm text-gray-700">
                                    {{ $description }} <span class="text-gray-500">({{ $key }})</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" checked
                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Active</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" class="close-dialog inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                    Save Role
                </button>
            </div>
        </form>
    </div>
</dialog>

<script>
    // ==== Role Dialog Logic (unchanged, just uses the same DOM) ====
    const roleDialog = document.getElementById('roleDialog');
    const roleForm = document.getElementById('roleForm');
    const addRoleButton = document.getElementById('addRoleButton');
    const roleDialogTitle = document.getElementById('roleDialogTitle');

    addRoleButton.addEventListener('click', () => {
        roleDialogTitle.textContent = 'Add New Role';
        roleForm.reset();
        roleForm.querySelector('[name="id"]').value = '';
        roleDialog.showModal();
    });

    document.querySelectorAll('.edit-role-button').forEach(btn => {
        btn.addEventListener('click', async () => {
            const roleId = btn.dataset.roleId;
            try {
                const res = await fetch(`/admin/users/roles/${roleId}`);
                const role = await res.json();

                roleDialogTitle.textContent = 'Edit Role';
                document.getElementById('roleId').value = role.id;
                document.getElementById('roleName').value = role.role_name;
                document.getElementById('roleDescription').value = role.description || '';
                document.querySelector('[name="is_active"]').checked = role.is_active;

                document.querySelectorAll('[name="permissions[]"]').forEach(cb => cb.checked = false);
                (JSON.parse(role.permissions || '[]')).forEach(p => {
                    const cb = document.querySelector(`[value="${p}"]`);
                    if (cb) cb.checked = true;
                });

                roleDialog.showModal();
            } catch (e) {
                alert('Failed to load role');
            }
        });
    });

    roleForm.addEventListener('submit', async e => {
        e.preventDefault();
        const fd = new FormData(roleForm);
        const id = fd.get('id');
        const url = id ? `/admin/users/roles/${id}` : '/admin/users/roles';
        const method = id ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: fd
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.message || 'Error');
        } catch (e) { alert('Save failed'); }
    });

    document.querySelectorAll('.delete-role-button').forEach(btn => {
        btn.addEventListener('click', async () => {
            if (!confirm('Delete this role? Users will need reassignment.')) return;
            const id = btn.dataset.roleId;
            try {
                const res = await fetch(`/admin/users/roles/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                if (data.success) location.reload();
                else alert(data.message);
            } catch (e) { alert('Delete failed'); }
        });
    });

    document.querySelectorAll('.close-dialog').forEach(b => b.addEventListener('click', () => roleDialog.close()));
    roleDialog.addEventListener('click', e => { if (e.target === roleDialog) roleDialog.close(); });
</script>