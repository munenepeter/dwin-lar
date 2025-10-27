<x-layouts.app>

    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Policy Types</h1>
                    <p class="text-muted-foreground">Manage policy types for insurance products</p>
                </div>
                <button id="openCreatePolicyTypeDialog" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text mr-2 h-4 w-4">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                        <path d="M10 9H8"></path>
                        <path d="M16 13H8"></path>
                        <path d="M16 17H8"></path>
                    </svg>
                    Add Policy Type
                </button>
            </div>

            <!-- Success/Error Messages -->
            <section id="alert-section">
                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif
                @if (session('errors'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    @foreach (session('errors') as $error)
                    <span class="block sm:inline">{{ $error }}</span>
                    @endforeach
                </div>
                @endif
            </section>

            <!-- Table Content -->
            <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">All Policy Types</h3>
                </div>
                <div class="p-6 pt-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Type Name</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Description</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($policyTypes as $policyType)
                                <tr class="border-b border-gray-300 hover:bg-gray-50">
                                    <td class="p-4 align-middle font-medium">{{ $policyType->type_name }}</td>
                                    <td class="p-4 align-middle">{{ Str::limit($policyType->description, 50) }}</td>
                                    <td class="p-4 align-middle">
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $policyType->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $policyType->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <button class="open-view-policy-type-dialog" data-policy-type-id="{{ $policyType->id }}">View</button>
                                        <button class="open-edit-policy-type-dialog" data-policy-type-id="{{ $policyType->id }}">Edit</button>
                                        <button class="delete-policy-type-button" data-policy-type-id="{{ $policyType->id }}">Delete</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center">No policy types found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $policyTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Policy Type Dialog -->
    <dialog id="createPolicyTypeDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="createPolicyTypeFormContent"></div>
        </div>
    </dialog>

    <!-- Edit Policy Type Dialog -->
    <dialog id="editPolicyTypeDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="editPolicyTypeFormContent"></div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const createPolicyTypeDialog = document.getElementById('createPolicyTypeDialog');
            const editPolicyTypeDialog = document.getElementById('editPolicyTypeDialog');
            const closeDialogButtons = document.querySelectorAll('.close-dialog');

            document.getElementById('openCreatePolicyTypeDialog').addEventListener('click', function() {
                fetch('/admin/policy-types/create')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('createPolicyTypeFormContent').innerHTML = html;
                        createPolicyTypeDialog.showModal();
                    });
            });

            document.querySelectorAll('.open-edit-policy-type-dialog').forEach(button => {
                button.addEventListener('click', function() {
                    const policyTypeId = this.getAttribute('data-policy-type-id');
                    fetch(`/admin/policy-types/${policyTypeId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('editPolicyTypeFormContent').innerHTML = html;
                            editPolicyTypeDialog.showModal();
                        });
                });
            });

            closeDialogButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('dialog').close();
                });
            });
        });
    </script>
</x-layouts.app>
