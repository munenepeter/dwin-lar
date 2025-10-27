<x-layouts.app>
    <main class="flex-1 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Client Management</h1>
                    <p class="text-muted-foreground">Manage client information and related policies</p>
                </div>
                <button id="openCreateClientDialog" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus mr-2 h-4 w-4">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="19" x2="19" y1="8" y2="14"></line>
                        <line x1="22" x2="16" y1="11" y2="11"></line>
                    </svg>
                    Add New Client
                </button>
            </div>

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Clients</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-4 w-4 text-blue-600">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87C17.5 14.5 20 12.25 20 10a8 8 0 1 0-8 8h.02c.38.36.76.73 1.15 1.08"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $totalClientsCount ?? 0 }}</div>
                        <p class="text-xs text-gray-500">All registered clients</p>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Active Clients</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check h-4 w-4 text-green-600">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <polyline points="16 11 18 13 22 9"></polyline>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $activeClients ?? 0 }}</div>
                        <p class="text-xs text-gray-500">{{ $totalClientsCount > 0 ? round(($activeClients / $totalClientsCount) * 100) : 0 }}% active</p>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">KYC Verified</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check h-4 w-4 text-purple-600">
                            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $kycVerifiedClients ?? 0 }}</div>
                        <p class="text-xs text-gray-500">Clients with verified KYC</p>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">KYC Pending</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-alert h-4 w-4 text-orange-600">
                            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"></path>
                            <line x1="12" x2="12" y1="8" y2="12"></line>
                            <line x1="12" x2="12.01" y1="16" y2="16"></line>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $kycPendingClients ?? 0 }}</div>
                        <p class="text-xs text-gray-500">Clients awaiting KYC verification</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="flex items-center justify-between">
                <div class="flex flex-1 items-center space-x-2">
                    <input type="text" id="client-search" placeholder="Search clients..."
                        class="flex h-10 w-[250px] rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        value="{{ $search }}">
                    <form method="GET" action="{{ route('clients.index') }}" class="flex space-x-2">
                        <input type="hidden" name="search" id="hidden-client-search-input" value="{{ $search }}">

                        <select name="status" id="client-status-filter"
                            class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[180px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <option value="">All Statuses</option>
                            <option value="ACTIVE" {{ $status === 'ACTIVE' ? 'selected' : '' }}>Active</option>
                            <option value="INACTIVE" {{ $status === 'INACTIVE' ? 'selected' : '' }}>Inactive</option>
                            <option value="SUSPENDED" {{ $status === 'SUSPENDED' ? 'selected' : '' }}>Suspended</option>
                        </select>

                        <select name="kyc_status" id="client-kyc-status-filter"
                            class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[180px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <option value="">All KYC Statuses</option>
                            <option value="PENDING" {{ $kyc_status === 'PENDING' ? 'selected' : '' }}>Pending</option>
                            <option value="VERIFIED" {{ $kyc_status === 'VERIFIED' ? 'selected' : '' }}>Verified</option>
                            <option value="REJECTED" {{ $kyc_status === 'REJECTED' ? 'selected' : '' }}>Rejected</option>
                        </select>

                        <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter mr-2 h-4 w-4">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                            </svg>
                            Apply Filters
                        </button>
                        <a href="{{ route('clients.index') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                            Reset Filters
                        </a>
                    </form>
                </div>
            </div>

            <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">All Clients</h3>
                    <p class="text-sm text-gray-500">A list of all clients in the system.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Agent</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KYC Status</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($clients as $client)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <p class="text-sm text-gray-900 font-mono">{{ $client->client_code ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $client->first_name }} {{ $client->last_name }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">{{ $client->email }}</p>
                                    <p class="text-xs text-gray-500">{{ $client->phone_primary }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($client->assignedAgent)
                                    <div class="text-sm font-medium text-gray-900">{{ $client->assignedAgent->first_name }} {{ $client->assignedAgent->last_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $client->assignedAgent->email }}</div>
                                    @else
                                    <div class="text-sm text-gray-500">Not Assigned</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($client->client_status === 'ACTIVE') bg-green-100 text-green-800
                                            @elseif($client->client_status === 'INACTIVE') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                        {{ $client->client_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($client->kyc_status === 'VERIFIED') bg-green-100 text-green-800
                                            @elseif($client->kyc_status === 'PENDING') bg-yellow-100 text-yellow-800
                                            @elseif($client->kyc_status === 'REJECTED') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                        {{ $client->kyc_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('clients.show', $client) }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4 text-blue-500">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    <button data-client-id="{{ $client->id }}" class="edit-client-button inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil h-4 w-4 text-yellow-500">
                                            <path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path>
                                            <path d="M15 5l4 4"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 h-4 w-4 text-red-500">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                                <line x1="14" x2="14" y1="11" y2="17"></line>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No clients found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </main>

    <dialog id="createUserDialog" class="modal bg-white p-6 rounded-lg shadow-xl w-11/12 md:w-2/3">
        <div id="userFormContainer">
            <!-- ajax content -->
        </div>
    </dialog>

    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Search functionality
            const searchInput = document.getElementById('client-search');
            const hiddenSearchInput = document.getElementById('hidden-client-search-input');
            const filterForm = searchInput.closest('form');

            let searchTimeout;

            searchInput.addEventListener('keyup', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    hiddenSearchInput.value = searchInput.value;
                    filterForm.submit();
                }, 500);
            });

            // Dropdown filter auto-submit
            document.getElementById('client-status-filter').addEventListener('change', () => {
                filterForm.submit();
            });
            document.getElementById('client-kyc-status-filter').addEventListener('change', () => {
                filterForm.submit();
            });

            const createUserDialog = document.getElementById('createUserDialog');
            const openCreateUserButton = document.getElementById('openCreateClientDialog');

            if (openCreateUserButton) {
                openCreateUserButton.addEventListener('click', function() {
                    fetch('{{ route("clients.create") }}')
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('userFormContainer').innerHTML = html;
                            createUserDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading form:', error);
                            alert('Failed to load the form. Please try again.');
                        });
                });
            }

            if (createUserDialog) {
                createUserDialog.addEventListener('click', function(event) {
                    if (event.target === createUserDialog) {
                        createUserDialog.close();
                    }
                });
            }

            document.querySelectorAll('.edit-client-button').forEach(button => {
                button.addEventListener('click', function() {
                    const clientId = this.getAttribute('data-client-id');
                    fetch('{{ route("clients.edit", ":id") }}'.replace(':id', clientId))
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('userFormContainer').innerHTML = html;
                            createUserDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading form:', error);
                            alert('Failed to load the form. Please try again.');
                        });
                });
            });
        });
    </script>
</x-layouts.app>