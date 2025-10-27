<x-layouts.app>

    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Commission Structures</h1>
                    <p class="text-muted-foreground">Manage commission structures</p>
                </div>
                <button id="openCreateStructureDialog" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle mr-2 h-4 w-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    Add Structure
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

            <!-- Table -->
            <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Commission Structures</h3>
                    <p class="text-sm text-gray-500">Manage commission structures and their details</p>
                </div>
                <div class="p-6 pt-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Structure Name</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Insurance Company</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Type</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Commission Type</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Rate/Amount</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Effective Date</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($commissionStructures->isNotEmpty())
                                @foreach ($commissionStructures as $structure)
                                <tr class="border-b border-gray-300 hover:bg-gray-50">
                                    <td class="p-4 align-middle font-medium">{{ $structure->structure_name }}</td>
                                    <td class="p-4 align-middle">{{ $structure->insuranceCompany->company_name ?? \'\'N/A\'\' }}</td>
                                    <td class="p-4 align-middle">{{ $structure->policyType->type_name ?? \'\'N/A\'\' }}</td>
                                    <td class="p-4 align-middle">
                                        @php
                                        $typeLabels = [
                                        \'FLAT_PERCENTAGE\' => \'Flat %\',
                                        \'TIERED\' => \'Tiered\',
                                        \'FIXED_AMOUNT\' => \'Fixed Amount\',
                                        ];
                                        @endphp
                                        {{ $typeLabels[$structure->commission_type] ?? $structure->commission_type }}
                                    </td>
                                    <td class="p-4 align-middle">
                                        @switch($structure->commission_type)
                                        @case(\'FLAT_PERCENTAGE\')
                                        {{ number_format($structure->base_percentage ?? 0, 2) }}%
                                        @break
                                        @case(\'FIXED_AMOUNT\')
                                        KES {{ number_format($structure->fixed_amount ?? 0, 2) }}
                                        @break
                                        @case(\'TIERED\')
                                        Tiered Rates
                                        @break
                                        @endswitch
                                    </td>
                                    <td class="p-4 align-middle">{{ \Carbon\Carbon::parse($structure->effective_date)->format(\'Y-m-d\') }}</td>
                                    <td class="p-4 align-middle">
                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $structure->is_active ? \'bg-green-100 text-green-800\' : \'bg-gray-100 text-gray-800\' }}">
                                            {{ $structure->is_active ? \'Active\' : \'Inactive\' }}
                                        </span>
                                    </td>
                                    <td class="p-4 align-middle">
                                        <button class="open-view-structure-dialog" data-structure-id="{{ $structure->id }}">View</button>
                                        <button class="open-edit-structure-dialog" data-structure-id="{{ $structure->id }}">Edit</button>
                                        <button class="delete-structure-button" data-structure-id="{{ $structure->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="p-4 text-center">No commission structures found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $commissionStructures->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Structure Dialog -->
    <dialog id="createStructureDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="createStructureFormContent"></div>
        </div>
    </dialog>

    <!-- Edit Structure Dialog -->
    <dialog id="editStructureDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="editStructureFormContent"></div>
        </div>
    </dialog>
    
    <!-- View Structure Dialog -->
    <dialog id="viewStructureDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="viewStructureFormContent"></div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            //hide id="alert-section" after some few seconds
            setTimeout(() => {
                const alertSection = document.getElementById('alert-section');
                if (alertSection) {
                    alertSection.style.display = 'none';
                }
            }, 4000); // 4 seconds

            const createStructureDialog = document.getElementById('createStructureDialog');
            const editStructureDialog = document.getElementById('editStructureDialog');
            const viewStructureDialog = document.getElementById('viewStructureDialog');
            const closeDialogButtons = document.querySelectorAll('.close-dialog');

            document.getElementById('openCreateStructureDialog').addEventListener('click', function() {
                fetch('/admin/commission-structures/create')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('createStructureFormContent').innerHTML = html;
                        createStructureDialog.showModal();
                    })
                    .catch(error => {
                        console.error('Error loading create structure form:', error);
                    });
            });

            document.querySelectorAll('.open-edit-structure-dialog').forEach(button => {
                button.addEventListener('click', function() {
                    const structureId = this.getAttribute('data-structure-id');
                    fetch(`/admin/commission-structures/${structureId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('editStructureFormContent').innerHTML = html;
                            editStructureDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading edit structure form:', error);
                        });
                });
            });

            document.querySelectorAll('.open-view-structure-dialog').forEach(button => {
                button.addEventListener('click', function() {
                    const structureId = this.getAttribute('data-structure-id');
                    fetch(`/admin/commission-structures/${structureId}`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('viewStructureFormContent').innerHTML = html;
                            viewStructureDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading view structure form:', error);
                        });
                });
            });

            closeDialogButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('dialog').close();
                });
            });

            [createStructureDialog, editStructureDialog, viewStructureDialog].forEach(dialog => {
                if (dialog) {
                    dialog.addEventListener('click', function(event) {
                        if (event.target === dialog) {
                            dialog.close();
                        }
                    });
                }
            });

            document.querySelectorAll('.delete-structure-button').forEach(button => {
                button.addEventListener('click', function() {
                    const structureId = this.getAttribute('data-structure-id');
                    if (confirm('Are you sure you want to delete this commission structure? This action cannot be undone.')) {
                        fetch(`/admin/commission-structures/${structureId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('tr').remove();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting commission structure:', error);
                                alert('An error occurred while deleting the commission structure.');
                            });
                    }
                });
            });
        });
    </script>
</x-layouts.app>
