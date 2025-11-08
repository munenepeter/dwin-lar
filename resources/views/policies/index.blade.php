<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Policy Management</h1>
                    <p class="text-muted-foreground">Manage insurance policies, renewals, and policy types</p>
                </div>
                <button data-modal-url="{{ route('policies.create') }}" class="open-policy-modal inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-plus-2 mr-2 h-4 w-4">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2Z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <path d="M12 18v-6"></path>
                        <path d="M9 15h6"></path>
                    </svg>
                    Add Policy
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total Policies Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Policies</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-files h-4 w-4 text-blue-600">
                            <path d="M15.5 2H8.6c-.4 0-.8.2-1.1.5-.3.3-.5.7-.5 1.1v12.8c0 .4.2.8.5 1.1.3.3.7.5 1.1.5H20.4c.4 0 .8-.2 1.1-.5.3-.3.5-.7.5-1.1V6.5L15.5 2Z"></path>
                            <path d="M3 7.6v12.8c0 .4.2.8.5 1.1.3.3.7.5 1.1.5h9.8"></path>
                            <path d="M18 2v4h4"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $policies->total() }}</div>
                        <p class="text-xs text-gray-500">All policies managed</p>
                    </div>
                </div>

                <!-- Active Policies Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Active Policies</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle h-4 w-4 text-green-600">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <path d="m9.2 11.6 3 3 8-8"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $policies->where('policy_status', 'ACTIVE')->count() }}</div>
                        <p class="text-xs text-gray-500">Currently active policies</p>
                    </div>
                </div>

                <!-- Expiring Soon Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Expiring Soon</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucude-calendar-x h-4 w-4 text-orange-600">
                            <path d="M8 2v4"></path>
                            <path d="M16 2v4"></path>
                            <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path>
                            <path d="M3 10h18"></path>
                            <path d="m17 21-5-5"></path>
                            <path d="m12 21 5-5"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">{{ $policies->where('expiry_date', '<=', \Carbon\Carbon::now()->addDays(30))->count() }}</div>
                        <p class="text-xs text-gray-500">Policies expiring in 30 days</p>
                    </div>
                </div>

                <!-- Total Premium Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Premium Value</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-currency h-4 w-4 text-purple-600">
                            <circle cx="12" cy="12" r="8"></circle>
                            <path d="M3 3 6 6"></path>
                            <path d="M21 3 18 6"></path>
                            <path d="M3 21 6 18"></path>
                            <path d="M21 21 18 18"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold">KES {{ number_format($policies->sum('premium_amount'), 2) }}</div>
                        <p class="text-xs text-gray-500">Total value of all premiums</p>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Search and Filter -->
            <div class="flex items-center space-x-2">
                <div class="relative flex-1 max-w-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-2 top-2.5 h-4 w-4 text-gray-400">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input id="policySearch" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm pl-8" placeholder="Search policies..." value="">
                </div>
                <select id="policyStatusFilter" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[180px]">
                    <option value="">All Statuses</option>
                    <option value="ACTIVE">Active</option>
                    <option value="EXPIRED">Expired</option>
                    <option value="PENDING">Pending</option>
                    <option value="CANCELLED">Cancelled</option>
                    <option value="RENEWED">Renewed</option>
                </select>
                <button id="resetFiltersBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter mr-2 h-4 w-4">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Reset Filters
                </button>
            </div>

            <!-- Policies Table -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provider</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Premium & Expiry</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($policies as $policy)
                            <tr>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-medium text-gray-900">{{ $policy->policy_number }}</div>
                                    <div class="text-gray-500 text-xs">{{ $policy->policyType->type_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $policy->client->first_name }} {{ $policy->client->last_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $policy->company->company_name }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-medium text-gray-900">KES {{ number_format($policy->premium_amount, 2) }}</div>
                                    <div class="text-xs {{ $policy->expiry_date < now() ? 'text-red-600 font-semibold' : 'text-gray-500' }}">
                                        Exp: {{ $policy->expiry_date->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                    {{ $policy->policy_status === 'ACTIVE' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $policy->policy_status === 'EXPIRED' ? 'bg-red-100 text-red-800' : '' }}
                    {{ $policy->policy_status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $policy->policy_status === 'CANCELLED' ? 'bg-gray-100 text-gray-800' : '' }}">
                                        {{ $policy->policy_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('policies.show', $policy->id) }}" class="open-policy-modal text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('policies.edit', $policy->id) }}" class="open-policy-modal text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('policies.destroy', $policy->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $policies->links() }}
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Structure -->
    <div id="policyModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center hidden">
        <div id="policyModalContent" class="bg-white rounded-lg shadow-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
            <button id="closePolicyModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
            <!-- Content loaded here -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Client-side search and filter (remains as is; client-side on current page)
            const policySearchInput = document.getElementById('policySearch');
            const policyStatusFilter = document.getElementById('policyStatusFilter');
            const resetFiltersBtn = document.getElementById('resetFiltersBtn');

            function filterPolicies() {
                const searchTerm = policySearchInput.value.toLowerCase();
                const statusFilter = policyStatusFilter.value.toLowerCase();
                const policyRows = document.querySelectorAll('table tbody tr');

                policyRows.forEach(row => {
                    const policyNumber = row.cells[0].textContent.toLowerCase();
                    const clientName = row.cells[1].textContent.toLowerCase();
                    const companyName = row.cells[2].textContent.toLowerCase();
                    const policyType = row.cells[3].textContent.toLowerCase();
                    const status = row.cells[6].textContent.toLowerCase();

                    const matchesSearch = policyNumber.includes(searchTerm) ||
                        clientName.includes(searchTerm) ||
                        companyName.includes(searchTerm) ||
                        policyType.includes(searchTerm);

                    const matchesStatus = statusFilter === '' || status.includes(statusFilter);

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            if (policySearchInput) {
                policySearchInput.addEventListener('keyup', filterPolicies);
            }
            if (policyStatusFilter) {
                policyStatusFilter.addEventListener('change', filterPolicies);
            }

            if (resetFiltersBtn) {
                resetFiltersBtn.addEventListener('click', function() {
                    policySearchInput.value = '';
                    policyStatusFilter.value = '';
                    filterPolicies();
                });
            }

            // Modal JS
            const modal = document.getElementById('policyModal');
            const modalContent = document.getElementById('policyModalContent');
            const closeModal = document.getElementById('closePolicyModal');

            document.querySelectorAll('.open-policy-modal').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    let url = this.getAttribute('href') || this.getAttribute('data-modal-url');
                    if (!url) {
                        console.error('No URL found for modal link:', this);
                        return;
                    }

                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            modalContent.innerHTML = html;
                            modal.classList.remove('hidden');
                            // Re-attach close listeners if needed (e.g., for close-dialog in partials)
                            attachCloseListeners();
                        })
                        .catch(error => console.error('Error loading modal:', error));
                });
            });

            closeModal.addEventListener('click', closePolicyModal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closePolicyModal();
                }
            });

            function closePolicyModal() {
                modal.classList.add('hidden');
                modalContent.innerHTML = '';
            }

            function attachCloseListeners() {
                document.querySelectorAll('.close-dialog').forEach(btn => {
                    btn.addEventListener('click', closePolicyModal);
                });
            }
        });
    </script>
</x-layouts.app>