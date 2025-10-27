<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">

            {{-- ====================== HEADER ====================== --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">User Management</h1>
                    <p class="text-muted-foreground">Manage system users, roles, and permissions</p>
                </div>
                <button id="openCreateUserDialog"
                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                    <x-lucide-user-plus class="h-4 w-4 mr-2" />
                    Add User
                </button>
            </div>

            {{-- ====================== STATS (STATIC) ====================== --}}
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                {{-- Total Users --}}
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Users</h3>
                        <x-lucide-users class="h-4 w-4 text-blue-600" />
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $totalUsers }}</div>
                        <p class="text-xs text-gray-500">All system users</p>
                    </div>
                </div>

                {{-- Active Users --}}
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Active Users</h3>
                        <x-lucide-user-cog class="h-4 w-4 text-green-600" />
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $activeCount }}</div>
                        <p class="text-xs text-gray-500">{{ $activePercentage }}% of total users</p>
                    </div>
                </div>

                {{-- User Roles --}}
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">User Roles</h3>
                        <x-lucide-shield class="h-4 w-4 text-purple-600" />
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $user_roles->count() }}</div>
                        <p class="text-xs text-gray-500">Different role types</p>
                    </div>
                </div>

                {{-- Active Sessions (example – same as active users) --}}
                <div class="rounded-lg border border-gray-300 bg-whitepaused p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Active Sessions</h3>
                        <x-lucide-activity class="h-4 w-4 text-orange-600" />
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $activeCount }}</div>
                        <p class="text-xs text-gray-500">Currently logged in users</p>
                    </div>
                </div>
            </div>

            {{-- ====================== FLASH MESSAGES ====================== --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- ====================== TAB NAVIGATION ====================== --}}
            <div class="space-y-4">
                <div role="tablist"
                    class="inline-flex h-10 items-center justify-center rounded-md bg-gray-100 p-1 text-gray-500">
                    @foreach ([
        'all-users' => 'All Users',
        'roles-permissions' => 'Roles & Permissions',
        'user-activity' => 'User Activity',
        'access-control' => 'Access Control',
    ] as $id => $label)
                        <button type="button" role="tab"
                            aria-selected="{{ $activeTab === $id ? 'true' : 'false' }}"
                            aria-controls="{{ $id }}-panel"
                            class="tab-button inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-colors
                                   {{ $activeTab === $id ? 'bg-white text-gray-900 shadow-sm' : 'hover:bg-gray-200' }}"
                            data-tab="{{ $id }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- ====================== FILTER BAR (kept for All Users) ====================== --}}
                <div class="flex items-center space-x-2">
                    <div class="relative flex-1 max-w-sm">
                        <x-lucide-search class="absolute left-2 top-2.5 h-4 w-4 text-gray-400" />
                        <input id="userSearch"
                            class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm pl-8"
                            placeholder="Search users..." value="{{ request('search') }}">
                    </div>

                    <select id="roleFilter"
                        class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[180px]">
                        <option value="">All Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>

                    <button
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                        <x-lucide-filter class="h-4 w-4 mr-2" />
                        More Filters
                    </button>
                </div>

                {{-- ====================== TAB PANELS (AJAX LOADED) ====================== --}}
                <div id="tab-panels">
                    @foreach ([
        'all-users' => 'users.partials.users-tab',
        'roles-permissions' => 'users.partials.roles',
        'user-activity' => 'users.partials.activity',
        'access-control' => 'users.partials.access',
    ] as $tabId => $partial)
                        <div id="{{ $tabId }}-panel" role="tabpanel" aria-labelledby="{{ $tabId }}-tab"
                            class="tab-panel {{ $activeTab === $tabId ? '' : 'hidden' }}">
                            @if ($activeTab === $tabId)
                                @include($partial, $partialData[$tabId] ?? [])
                            @else
                                <div class="text-center p-8 text-gray-500">Loading…</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <!-- Create User Dialog -->
    <dialog id="createUserDialog"
        class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-4 bg-white shadow-lg rounded-l-lg">
        <div class="relative w-full">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="createUserFormContent"></div>
        </div>
    </dialog>

    <!-- Edit User Dialog -->
    <dialog id="editUserDialog"
        class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-4 bg-white shadow-lg rounded-l-lg">
        <div class="relative w-full">
            <button type="button"
                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="editUserFormContent"></div>
        </div>
    </dialog>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.tab-button');
            const panels = document.querySelectorAll('.tab-panel');

            const setActive = (targetId) => {
                // Update buttons
                buttons.forEach(b => {
                    const isActive = b.dataset.tab === targetId;
                    b.classList.toggle('bg-white', isActive);
                    b.classList.toggle('text-gray-900', isActive);
                    b.classList.toggle('shadow-sm', isActive);
                    b.setAttribute('aria-selected', isActive);
                });

                // Update panels
                panels.forEach(p => {
                    const show = p.id === `${targetId}-panel`;
                    p.classList.toggle('hidden', !show);
                });

                // Update URL (without reload)
                const url = new URL(window.location);
                url.searchParams.set('tab', targetId);
                window.history.replaceState({}, '', url);
            };

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.dataset.tab;

                    // If already loaded → just show
                    const panel = document.getElementById(`${target}-panel`);
                    if (panel.dataset.loaded === 'true') {
                        setActive(target);
                        return;
                    }

                    // Show loading spinner
                    panel.innerHTML = `<div class="text-center p-8">Loading…</div>`;
                    panel.dataset.loaded = 'true';

                    fetch(`/admin/users?tab=${target}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(r => r.text())
                        .then(html => {
                            panel.innerHTML = html;
                            setActive(target);
                        })
                        .catch(err => {
                            console.error(err);
                            panel.innerHTML =
                                `<div class="text-center p-8 text-red-500">Error loading content</div>`;
                        });
                });
            });

            // Preserve tab on page reload
            const urlTab = new URLSearchParams(window.location.search).get('tab');
            if (urlTab && document.querySelector(`[data-tab="${urlTab}"]`)) {
                document.querySelector(`[data-tab="${urlTab}"]`).click();
            }



            function loadRolesPermissions() {
                const contentDiv = document.querySelector('#roles-permissions');
                // Check if content is already loaded, if already loaded
                // the child element will not be empty and will have the following
                //  id="roles-permissions-content" data-loaded="true" 
                // remember we are adding the content dynamically, adding to the contentDiv
                if (document.querySelector('#roles-permissions-content')) {
                    return;
                }

                if (contentDiv) {
                    fetch('/admin/users/roles')
                        .then(response => response.text())
                        .then(html => {
                            contentDiv.innerHTML += html;
                        })
                        .catch(error => {
                            console.error('Error loading roles content:', error);
                            contentDiv.innerHTML += '<p class="text-red-500">Error loading roles content</p>';
                        });
                }
            }

            function loadUserActivity() {
                const contentDiv = document.querySelector('#user-activity');

                //same as above, check if content is already loaded
                if (document.querySelector('#user-activity-content')) {
                    return; // Content already loaded
                }
                if (contentDiv) {
                    fetch('/admin/users/activity')
                        .then(response => response.text())
                        .then(html => {
                            contentDiv.innerHTML += html;
                        })
                        .catch(error => {
                            console.error('Error loading activity content:', error);
                            contentDiv.innerHTML +=
                                '<p class="text-red-500">Error loading activity content</p>';
                        });
                }
            }

            function loadAccessControl() {
                const contentDiv = document.querySelector('#access-control');

                //same as above, check if content is already loaded
                if (document.querySelector('#access-control-content')) {
                    return; // Content already loaded
                }

                if (contentDiv) {
                    fetch('/admin/users/access')
                        .then(response => response.text())
                        .then(html => {
                            contentDiv.innerHTML += html;
                        })
                        .catch(error => {
                            console.error('Error loading access content:', error);
                            contentDiv.innerHTML += '<p class="text-red-500">Error loading access content</p>';
                        });
                }
            }

            // User Search
            const userSearch = document.getElementById('userSearch');
            userSearch.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#all-users tbody tr');

                rows.forEach(row => {
                    const name = row.querySelector('.font-medium').textContent.toLowerCase();
                    const email = row.querySelector('.text-gray-500').textContent.toLowerCase();
                    const role = row.querySelector('span:not([class*="bg-"])').textContent
                        .toLowerCase();

                    if (name.includes(searchTerm) || email.includes(searchTerm) || role.includes(
                            searchTerm)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });

            // Role Filter
            const roleFilter = document.getElementById('roleFilter');
            roleFilter.addEventListener('change', (e) => {
                const roleId = e.target.value;
                const rows = document.querySelectorAll('#all-users tbody tr');

                rows.forEach(row => {
                    if (!roleId) {
                        row.classList.remove('hidden');
                        return;
                    }

                    const rowRoleId = row.querySelector('button[data-user-id]').getAttribute(
                        'data-role-id');
                    if (rowRoleId === roleId) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });

            // Dialog handling (existing code)
            const createUserDialog = document.getElementById('createUserDialog');
            const editUserDialog = document.getElementById('editUserDialog');
            const openCreateUserDialogButton = document.getElementById('openCreateUserDialog');
            const closeDialogButtons = document.querySelectorAll('.close-dialog');
            const createUserFormContent = document.getElementById('createUserFormContent');
            const editUserFormContent = document.getElementById('editUserFormContent');


            window.initializeUserForm = function() {
                const userForm = document.getElementById('user-form');

                userForm.addEventListener('submit', (event) => {
                    // Form validation
                    const formData = new FormData(event.target);
                    const user = {};
                    for (const [key, value] of formData.entries()) {
                        user[key] = value;
                    }
                    const errors = validateUser(user);
                    if (Object.keys(errors).length > 0) {
                        event.preventDefault();
                        const inputs = userForm.elements;
                        for (const input of inputs) {
                            if (errors[input.name]) {
                                input.setCustomValidity(errors[input.name]);
                                input.reportValidity();
                            } else {
                                input.setCustomValidity('');
                            }
                        }
                    }
                });

                function validateUser(user) {
                    const errors = {};
                    if (!user.username) {
                        errors.username = 'Username is required';
                    } else if (user.username.length > 50) {
                        errors.username = 'Username must be 50 characters or less';
                    }
                    if (!user.first_name) {
                        errors.first_name = 'First name is required';
                    } else if (user.first_name.length > 50) {
                        errors.first_name = 'First name must be 50 characters or less';
                    }
                    if (!user.last_name) {
                        errors.last_name = 'Last name is required';
                    } else if (user.last_name.length > 50) {
                        errors.last_name = 'Last name must be 50 characters or less';
                    }
                    if (!user.email) {
                        errors.email = 'Email is required';
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(user.email)) {
                        errors.email = 'Invalid email format';
                    } else if (user.email.length > 100) {
                        errors.email = 'Email must be 100 characters or less';
                    }
                    //kenya phone number format +2547XXXXXXXX
                    if (user.phone && !/^\+2547\d{8}$/.test(user.phone)) {
                        errors.phone = 'Invalid phone number format';
                    }
                    if (user.employee_id && user.employee_id.length > 20) {
                        errors.employee_id = 'Employee ID must be 20 characters or less';
                    }
                    if (!user.role_id) {
                        errors.role_id = 'Role is required';
                    }
                    if (!user.password && !user.id) {
                        errors.password = 'Password is required';
                    }
                    return errors;
                }
            };

            // Open create user dialog
            openCreateUserDialogButton.addEventListener('click', function() {
                fetch('/admin/users/create')
                    .then(response => response.text())
                    .then(html => {
                        createUserFormContent.innerHTML = html;
                        createUserDialog.showModal();

                        // Initialize after a short delay
                        setTimeout(() => {
                            if (window.initializeUserForm) {
                                window.initializeUserForm();
                            } else {
                                console.error('initializeUserForm function not found!');
                            }
                        }, 100);
                    })
                    .catch(error => {
                        console.error('Error loading create user form:', error);
                    });
            });

            // Open edit user dialog
            document.querySelectorAll('.open-edit-user-dialog').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    fetch(`/admin/users/${userId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            editUserFormContent.innerHTML = html;
                            editUserDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading edit user form:', error);
                        });
                });
            });

            // Close dialogs
            closeDialogButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('dialog').close();
                });
            });

            // Close dialogs when clicking outside
            createUserDialog.addEventListener('click', function(event) {
                if (event.target === createUserDialog) {
                    createUserDialog.close();
                }
            });

            editUserDialog.addEventListener('click', function(event) {
                if (event.target === editUserDialog) {
                    editUserDialog.close();
                }
            });

            // Handle delete button click
            document.querySelectorAll('.delete-user-button').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-user-id');
                    if (confirm('Are you sure you want to delete this user?')) {
                        fetch(`/admin/users/${userId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('tr').remove();
                                    alert(data.message);
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting user:', error);
                                alert('An error occurred while deleting the user.');
                            });
                    }
                });
            });
        });
    </script>
</x-layouts.app>
