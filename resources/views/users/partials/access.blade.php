<div id="access-control-content" class="rounded-lg border border-gray-300 bg-white shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-semibold leading-none tracking-tight">Access Control</h3>
            <p class="text-sm text-gray-500">Manage system access permissions</p>
        </div>
    </div>

    <div class="space-y-6">
        <div>
            <h4 class="text-lg font-medium mb-3">Role Permissions</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-300">
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Role</th>
                            @foreach ($permissions as $key => $desc)
                                <th class="h-12 px-4 text-center align-middle font-medium text-gray-500"
                                    title="{{ $desc }}">{{ $key }}</th>
                            @endforeach
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rolePermissions as $role)
                            @php $rolePerms = $role->permissions ?? []; @endphp
                            <tr class="border-b border-gray-300 hover:bg-gray-50">
                                <td class="p-4 align-middle font-medium">{{ $role->role_name }}</td>
                                @foreach ($permissions as $key => $desc)
                                    <td class="p-4 align-middle text-center">
                                        @if (in_array($key, $rolePerms))
                                            <x-lucide-check class="h-5 w-5 text-green-500 mx-auto" />
                                        @else
                                            <x-lucide-x class="h-5 w-5 text-red-400 mx-auto" />
                                        @endif
                                    </td>
                                @endforeach
                                <td class="p-4 align-middle">
                                    <button class="edit-role-perms inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium text-blue-600 hover:text-blue-800"
                                            data-role-id="{{ $role->id }}">
                                        Edit Permissions
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <h4 class="text-lg font-medium mb-3">Permission Descriptions</h4>
            <div class="bg-gray-50 p-4 rounded-lg">
                <ul class="space-y-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($permissions as $key => $desc)
                        <li class="flex items-center space-x-2">
                            <span class="font-mono bg-gray-200 px-2 py-1 rounded text-sm mr-3">{{ $key }}</span>
                            <span class="text-xs">{{ $desc }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- ==================== PERMISSIONS DIALOG ==================== --}}
<dialog id="permsDialog"
        class="fixed inset-0 z-50 w-full max-w-md mx-auto my-8 p-6 bg-white rounded-lg shadow-lg">
    <div class="relative">
        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 close-dialog">
            <x-lucide-x class="h-6 w-6" />
        </button>

        <h3 id="permsDialogTitle" class="text-lg font-semibold mb-4">Edit Permissions</h3>

        <form id="permsForm">
            @csrf
            <input type="hidden" id="permsRoleId" name="role_id">

            <div class="space-y-4">
                <div>
                    <label id="permsRoleName" class="block text-sm font-medium text-gray-700">Role: </label>
                    <p id="permsRoleDesc" class="text-sm text-gray-500 mt-1"></p>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                    <div class="space-y-3">
                        @foreach ($permissions as $key => $desc)
                            <div class="flex items-center">
                                <input id="perm-edit-{{ $key }}" name="permissions[]" type="checkbox" value="{{ $key }}"
                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="perm-edit-{{ $key }}" class="ml-3 text-sm text-gray-700">
                                    <span class="font-medium">{{ $key }}</span>
                                    <span class="block text-xs text-gray-500">{{ $desc }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" class="close-dialog inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                    Save Permissions
                </button>
            </div>
        </form>
    </div>
</dialog>
@php
    $rolePermissions = json_decode($rolePermissions);
@endphp
<script>
    const permsDialog = document.getElementById('permsDialog');
    const permsForm   = document.getElementById('permsForm');

    document.querySelectorAll('.edit-role-perms').forEach(btn => {
        btn.addEventListener('click', () => {
            const roleId = btn.dataset.roleId;
            // eslint-disable-next-line
            const role = @json($rolePermissions).find(r => r.id == roleId);

            document.getElementById('permsRoleId').value = role.id;
            document.getElementById('permsRoleName').textContent = 'Role: ' + role.role_name;
            document.getElementById('permsRoleDesc').textContent = role.description || 'No description';

            document.querySelectorAll('#permsForm [name="permissions[]"]').forEach(cb => cb.checked = false);
            (JSON.parse(role.permissions || '[]')).forEach(p => {
                const cb = document.querySelector(`#permsForm [value="${p}"]`);
                if (cb) cb.checked = true;
            });

            permsDialog.showModal();
        });
    });

    permsForm.addEventListener('submit', async e => {
        e.preventDefault();
        const fd = new FormData(permsForm);
        const payload = {
            role_id: fd.get('role_id'),
            permissions: fd.getAll('permissions[]')
        };

        try {
            const res = await fetch('/admin/users/update-role-permissions', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.message || 'Error');
        } catch (e) { alert('Save failed'); }
    });

    document.querySelectorAll('.close-dialog').forEach(b => b.addEventListener('click', () => permsDialog.close()));
    permsDialog.addEventListener('click', e => { if (e.target === permsDialog) permsDialog.close(); });
</script>