<div class="rounded-lg border border-gray-300 bg-white shadow-sm">
    <div class="p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">All Users</h3>
        <p class="text-sm text-gray-500">Manage system users and their access</p>
    </div>

    <div class="p-6 pt-0">
        <div class="relative w-full overflow-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="h-12 px-4 text-left font-medium text-gray-500">User</th>
                        <th class="h-12 px-4 text-left font-medium text-gray-500">Role</th>
                        <th class="h-12 px-4 text-left font-medium text-gray-500">Status</th>
                        <th class="h-12 px-4 text-left font-medium text-gray-500">Last Login</th>
                        <th class="h-12 px-4 text-left font-medium text-gray-500">Created</th>
                        <th class="h-12 px-4 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-gray-300 hover:bg-gray-50">
                            <td class="p-4 align-middle">
                                <div class="flex items-center space-x-3">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200">
                                        <span class="text-sm font-medium">
                                            {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $user->first_name }} {{ $user->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 align-middle">
                                @php
                                    $roleClass = match ($user->role->role_name ?? '') {
                                        'Admin'       => 'bg-red-100 text-red-800',
                                        'Agent'       => 'bg-green-100 text-green-800',
                                        'Accountant'  => 'bg-yellow-100 text-yellow-800',
                                        default       => 'bg-blue-100 text-blue-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $roleClass }}">
                                    {{ $user->role->role_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="p-4 align-middle">
                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="p-4 align-middle">
                                {{ $user->last_login?->format('Y-m-d h:i A') ?? 'Never' }}
                            </td>
                            <td class="p-4 align-middle">
                                {{ $user->created_at?->format('Y-m-d') }}
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex items-center space-x-2">
                                    <button class="open-edit-user-dialog inline-flex items-center justify-center gap-2 text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3"
                                            data-user-id="{{ $user->id }}">
                                        <x-lucide-square-pen class="h-4 w-4" />
                                    </button>
                                    <button class="delete-user-button inline-flex items-center justify-center gap-2 text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3"
                                            data-user-id="{{ $user->id }}">
                                        <x-lucide-trash-2 class="h-4 w-4 text-red-500" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>