<x-layouts.app>

    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Insurance Companies</h1>
                    <p class="text-muted-foreground">Manage insurance companies and their commission structures</p>
                </div>
                <button id="openCreateCompanyDialog" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2 mr-2 h-4 w-4">
                        <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                        <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                        <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                        <path d="M10 6h4"></path>
                        <path d="M10 10h4"></path>
                        <path d="M10 14h4"></path>
                        <path d="M10 18h4"></path>
                    </svg>
                    Add Company
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total Companies Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Companies</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2 h-4 w-4 text-blue-600">
                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                            <path d="M10 6h4"></path>
                            <path d="M10 10h4"></path>
                            <path d="M10 14h4"></path>
                            <path d="M10 18h4"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold" id="totalCompanies">{{ $total_companies }}</div>
                        <p class="text-xs text-gray-500">All insurance providers</p>
                    </div>
                </div>

                <!-- Active Companies Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Active Companies</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check h-4 w-4 text-green-600">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        @php
                        $active_percentage = $total_companies > 0 ? round(($active_companies / $total_companies) * 100) : 0;
                        @endphp
                        <div class="text-2xl font-bold" id="activeCompanies">{{ $active_companies }}</div>
                        <p class="text-xs text-gray-500">{{ $active_percentage }}% of total companies</p>
                    </div>
                </div>

                <!-- Policies Issued Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Policies Issued</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4 text-purple-600">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            <path d="M10 9H8"></path>
                            <path d="M16 13H8"></path>
                            <path d="M16 17H8"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold" id="totalPolicies">{{ $total_policies }}</div>
                        <p class="text-xs text-gray-500">Total policies across all companies</p>
                    </div>
                </div>

                <!-- Total Premium Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Premium</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-coins h-4 w-4 text-orange-600">
                            <circle cx="8" cy="8" r="6"></circle>
                            <path d="M18.09 10.37A6 6 0 1 1 10.34 18"></path>
                            <path d="M7 6h1v4"></path>
                            <path d="m16.71 13.88.7.71-2.82 2.82"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold" id="totalPremium">KES {{ number_format($total_premium, 2) }}</div>
                        <p class="text-xs text-gray-500">Total premium value</p>
                    </div>
                </div>
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

            <!-- Tab Navigation -->
            <div class="space-y-4">
                <div role="tablist" class="inline-flex h-10 items-center justify-center rounded-md bg-gray-100 p-1 text-gray-500">
                    <button type="button" role="tab" aria-selected="true" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium bg-white text-gray-900 shadow-sm tab-button active" data-tab="all-companies">
                        All Companies
                    </button>
                    <button type="button" role="tab" aria-selected="false" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium tab-button" data-tab="commission-structures">
                        Commission Structures
                    </button>
                    <button type="button" role="tab" aria-selected="false" class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium tab-button" data-tab="company-performance">
                        Performance
                    </button>
                </div>

                <!-- Search and Filter -->
                <div class="flex items-center space-x-2">
                    <div class="relative flex-1 max-w-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-2 top-2.5 h-4 w-4 text-gray-400">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input id="companySearch" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm pl-8" placeholder="Search companies..." value="">
                    </div>
                    <select id="statusFilter" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[180px]">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter mr-2 h-4 w-4">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        More Filters
                    </button>
                </div>

                <!-- Tab Content - All Companies -->
                <div id="all-companies" class="tab-content active">
                    <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Insurance Companies</h3>
                            <p class="text-sm text-gray-500">Manage insurance providers and their details</p>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-300">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Company Code</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Company Name</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Contact</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policies</th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($insuranceCompanies->isNotEmpty())
                                        @foreach ($insuranceCompanies as $company)
                                        <tr class="border-b border-gray-300 hover:bg-gray-50">
                                            <td class="p-4 align-middle font-medium">{{ $company->company_code }}</td>
                                            <td class="p-4 align-middle">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200">
                                                        <span class="text-sm font-medium">
                                                            {{ strtoupper(substr($company->company_name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium">{{ $company->company_name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $company->city }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <div class="text-sm">{{ $company->contact_person }}</div>
                                                <div class="text-sm text-gray-500">{{ $company->phone }}</div>
                                            </td>
                                            <td class="p-4 align-middle">
                                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $company->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="p-4 align-middle">{{ $company->policies->count() }}</td>
                                            <td class="p-4 align-middle">
                                                <button class="open-view-company-dialog" data-company-id="{{ $company->id }}">View</button>
                                                <button class="open-edit-company-dialog" data-company-id="{{ $company->id }}">Edit</button>
                                                <button class="delete-company-button" data-company-id="{{ $company->id }}">Delete</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" class="p-4 text-center">No companies found.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{ $insuranceCompanies->links() }}
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Tab Content - Commission Structures -->
                <div id="commission-structures" class="tab-content hidden">
                    <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Commission Structures</h3>
                                    <p class="text-sm text-gray-500">Manage commission rates by company and policy type</p>
                                </div>
                                <button id="openCreateCommissionDialog"
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-blue-500 hover:bg-blue-600 text-white h-10 px-4 py-2">
                                    <x-lucide-plus-circle class="mr-2 h-4 w-4" />
                                    Add Structure
                                </button>
                            </div>
                        </div>

                        <div class="p-6 pt-0">
                            <div class="space-y-4">
                                @forelse ($insuranceCompanies as $company)
                                <div class="rounded-lg border border-gray-200 overflow-hidden">
                                    <div class="flex items-center justify-between bg-gray-50 p-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200">
                                                <span class="text-sm font-medium">
                                                    {{ strtoupper(substr($company->company_name, 0, 2)) }}
                                                </span>
                                            </div>
                                            <h4 class="font-medium">{{ $company->company_name }}</h4>
                                        </div>

                                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                                {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $company->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>

                                    <div class="p-4">
                                        <div class="relative w-full overflow-auto">
                                            <table class="w-full text-sm">
                                                <thead>
                                                    <tr class="border-b border-gray-200">
                                                        <th class="h-10 px-4 text-left font-medium text-gray-500">Policy Type</th>
                                                        <th class="h-10 px-4 text-left font-medium text-gray-500">Structure Name</th>
                                                        <th class="h-10 px-4 text-left font-medium text-gray-500">Commission Type</th>
                                                        <th class="h-10 px-4 text-left font-medium text-gray-500">Rate/Amount</th>
                                                        <th class="h-10 px-4 text-left font-medium text-gray-500">Effective Date</th>
                                                        <th class="h-10 px-4 text-left font-medium text-gray-500">Status</th>
                                                        <th class="h-10 px-4 text-left font-medium text-gray-500">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($company->commissionStructures as $structure)
                                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                        <td class="p-3 align-middle">{{ $structure->policyType->type_name ?? 'N/A' }}</td>
                                                        <td class="p-3 align-middle">{{ $structure->structure_name }}</td>
                                                        <td class="p-3 align-middle">
                                                            @php
                                                            $typeLabels = [
                                                            'FLAT_PERCENTAGE' => 'Flat %',
                                                            'TIERED' => 'Tiered',
                                                            'FIXED_AMOUNT' => 'Fixed Amount',
                                                            ];
                                                            @endphp
                                                            {{ $typeLabels[$structure->commission_type] ?? $structure->commission_type }}
                                                        </td>
                                                        <td class="p-3 align-middle">
                                                            @switch($structure->commission_type)
                                                            @case('FLAT_PERCENTAGE')
                                                            {{ number_format($structure->base_percentage ?? 0, 2) }}%
                                                            @break
                                                            @case('FIXED_AMOUNT')
                                                            KES {{ number_format($structure->fixed_amount ?? 0, 2) }}
                                                            @break
                                                            @case('TIERED')
                                                            Tiered Rates
                                                            @break
                                                            @endswitch
                                                        </td>
                                                        <td class="p-3 align-middle">{{ \Carbon\Carbon::parse($structure->effective_date)->format('Y-m-d') }}</td>
                                                        <td class="p-3 align-middle">
                                                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                                                        {{ $structure->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                                {{ $structure->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td class="p-3 align-middle">
                                                            <div class="flex items-center space-x-2">
                                                                <button class="open-edit-commission-dialog inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3"
                                                                    data-structure-id="{{ $structure->id }}">
                                                                    <x-lucide-square-pen class="h-4 w-4" />
                                                                </button>
                                                                <button class="delete-commission-button inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3"
                                                                    data-structure-id="{{ $structure->id }}">
                                                                    <x-lucide-trash-2 class="h-4 w-4 text-red-500" />
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="p-3 text-center text-gray-500">
                                                            No commission structures found
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="p-4 text-center text-gray-500">No companies found.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Tab Content - Company Performance -->
                <div id="company-performance" class="tab-content hidden">
                    <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                        <div class="p-6">
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Company Performance</h3>
                            <p class="text-sm text-gray-500">View metrics and analytics by insurance company</p>
                        </div>
                        <div class="p-6 pt-0">
                            <div class="grid gap-6 md:grid-cols-2">
                                <!-- Policies Chart -->
                                <div class="rounded-lg border border-gray-200 p-4">
                                    <h4 class="font-medium mb-4">Policies by Company (Last 12 Months)</h4>
                                    <div class="h-64">
                                        <canvas id="policiesChart"></canvas>
                                    </div>
                                </div>
                                <!-- Premium Chart -->
                                <div class="rounded-lg border border-gray-200 p-4">
                                    <h4 class="font-medium mb-4">Premium Distribution</h4>
                                    <div class="h-64">
                                        <canvas id="premiumChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="border-b border-gray-300">
                                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Company</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policies</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Total Premium</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Avg. Policy</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Renewal Rate</th>
                                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Trend</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($insuranceCompanies as $company): ?>
                                                <tr class="border-b border-gray-300 hover:bg-gray-50">
                                                    <td class="p-4 align-middle">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200">
                                                                <span class="text-sm font-medium">
                                                                    <?= strtoupper(substr($company->company_name, 0, 2)) ?>
                                                                </span>
                                                            </div>
                                                            <div class="font-medium"><?= htmlspecialchars($company->company_name) ?></div>
                                                        </div>
                                                    </td>
                                                    <td class="p-4 align-middle"><?= $company->policy_count ?></td>
                                                    <td class="p-4 align-middle">KES <?= $company->total_premium > 0 ? number_format($company->total_premium, 2) : '0.00' ?></td>
                                                    <td class="p-4 align-middle">KES <?= $company->policy_count > 0 ? number_format($company->total_premium / $company->policy_count, 2) : '0.00' ?></td>
                                                    <td class="p-4 align-middle"><?= $company->policy_count > 0 ? number_format($company->renewal_rate, 1) : '0.00' ?>%</td>
                                                    <td class="p-4 align-middle">
                                                        <?php if ($company->trend > 0): ?>
                                                            <span class="text-green-600 flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up h-4 w-4 mr-1">
                                                                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                                                    <polyline points="16 7 22 7 22 13"></polyline>
                                                                </svg>
                                                                <?= $company->trend > 0 ? number_format($company->trend, 1) : '0.00' ?>%
                                                            </span>
                                                        <?php elseif ($company->trend < 0): ?>
                                                            <span class="text-red-600 flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-down h-4 w-4 mr-1">
                                                                    <polyline points="22 17 13.5 8.5 8.5 13.5 2 7"></polyline>
                                                                    <polyline points="16 17 22 17 22 11"></polyline>
                                                                </svg>
                                                                <?= $company->trend < 0 ? number_format(abs($company->trend), 1) : '0.00' ?>%
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-gray-500">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Company Dialog -->
    <dialog id="createCompanyDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http:
                <path fill-rule=" evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="createCompanyFormContent"></div>
        </div>
    </dialog>

    <!-- Edit Company Dialog -->
    <dialog id="editCompanyDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http:
                <path fill-rule=" evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="editCompanyFormContent"></div>
        </div>
    </dialog>

    <!-- Create Commission Dialog -->
    <dialog id="createCommissionDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http:
                <path fill-rule=" evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="createCommissionFormContent"></div>
        </div>
    </dialog>

    <!-- Edit Commission Dialog -->
    <dialog id="editCommissionDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http:
                <path fill-rule=" evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="editCommissionFormContent"></div>
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
            }, 4000); // 5 seconds

            const urlParams = new URLSearchParams(window.location.search);
            const initialTab = urlParams.get('tab') || 'all-companies';

            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.getAttribute('data-tab');


                    history.pushState(null, '', `?tab=${tabId}`);


                    tabButtons.forEach(btn => btn.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm'));
                    button.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');


                    tabContents.forEach(content => content.classList.add('hidden'));
                    document.getElementById(tabId).classList.remove('hidden');


                    if (tabId === 'commission-structures') {
                        loadCommissionStructures();
                    } else if (tabId === 'company-performance') {
                        loadCompanyPerformance();
                    }
                });
            });


            const initialTabButton = document.querySelector(`.tab-button[data-tab="${initialTab}"]`);
            if (initialTabButton) {
                initialTabButton.click();
            } else {
                document.querySelector('.tab-button').click();
            }


            const companySearch = document.getElementById('companySearch');
            companySearch.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#all-companies tbody tr');

                rows.forEach(row => {
                    const companyName = row.querySelector('.font-medium').textContent.toLowerCase();
                    const companyCode = row.querySelector('td:first-child').textContent.toLowerCase();
                    const contactPerson = row.querySelector('td:nth-child(3) div:first-child').textContent.toLowerCase();

                    if (companyName.includes(searchTerm) || companyCode.includes(searchTerm) || contactPerson.includes(searchTerm)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });


            const statusFilter = document.getElementById('statusFilter');
            statusFilter.addEventListener('change', (e) => {
                const status = e.target.value;
                const rows = document.querySelectorAll('#all-companies tbody tr');

                rows.forEach(row => {
                    if (!status) {
                        row.classList.remove('hidden');
                        return;
                    }

                    const rowStatus = row.querySelector('td:nth-child(4) span').textContent.toLowerCase();
                    if (rowStatus === status) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });


            const createCompanyDialog = document.getElementById('createCompanyDialog');
            const editCompanyDialog = document.getElementById('editCompanyDialog');
            const viewCompanyDialog = document.getElementById('viewCompanyDialog');
            const createCommissionDialog = document.getElementById('createCommissionDialog');
            const editCommissionDialog = document.getElementById('editCommissionDialog');
            const closeDialogButtons = document.querySelectorAll('.close-dialog');


            document.getElementById('openCreateCompanyDialog').addEventListener('click', function() {
                fetch('/admin/insurance-companies/create')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('createCompanyFormContent').innerHTML = html;
                        createCompanyDialog.showModal();
                    })
                    .catch(error => {
                        console.error('Error loading create company form:', error);
                    });
            });


            document.querySelectorAll('.open-edit-company-dialog').forEach(button => {
                button.addEventListener('click', function() {
                    const companyId = this.getAttribute('data-company-id');
                    fetch(`/admin/insurance-companies/${companyId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('editCompanyFormContent').innerHTML = html;
                            editCompanyDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading edit company form:', error);
                        });
                });
            });


            document.querySelectorAll('.open-view-company-dialog').forEach(button => {
                button.addEventListener('click', function() {
                    const companyId = this.getAttribute('data-company-id');
                    fetch(`/admin/insurance-companies/${companyId}`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('viewCompanyFormContent').innerHTML = html;
                            viewCompanyDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading view company form:', error);
                        });
                });
            });


            document.getElementById('openCreateCommissionDialog').addEventListener('click', function() {
                fetch('/admin/commission-structures/create')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('createCommissionFormContent').innerHTML = html;
                        createCommissionDialog.showModal();
                    })
                    .catch(error => {
                        console.error('Error loading create commission form:', error);
                    });
            });


            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('open-edit-commission-dialog')) {
                    const structureId = e.target.getAttribute('data-structure-id');
                    fetch(`/admin/commission-structures/${structureId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('editCommissionFormContent').innerHTML = html;
                            editCommissionDialog.showModal();
                        })
                        .catch(error => {
                            console.error('Error loading edit commission form:', error);
                        });
                }
            });


            closeDialogButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('dialog').close();
                });
            });

            [createCompanyDialog, editCompanyDialog, viewCompanyDialog, createCommissionDialog, editCommissionDialog].forEach(dialog => {
                if (dialog) {
                    dialog.addEventListener('click', function(event) {
                        if (event.target === dialog) {
                            dialog.close();
                        }
                    });
                }
            });

            // [createCompanyDialog, editCompanyDialog, viewCompanyDialog, createCommissionDialog, editCommissionDialog].forEach(dialog => {
            //     dialog.addEventListener('click', function(event) {
            //         if (event.target === dialog) {
            //             dialog.close();
            //         }
            //     });
            // });


            document.querySelectorAll('.delete-company-button').forEach(button => {
                button.addEventListener('click', function() {
                    const companyId = this.getAttribute('data-company-id');
                    if (confirm('Are you sure you want to delete this company? This action cannot be undone.')) {
                        fetch(`/admin/insurance-companies/${companyId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('tr').remove();

                                    loadCompanyStats();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting company:', error);
                                alert('An error occurred while deleting the company.');
                            });
                    }
                });
            });


            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-commission-button')) {
                    const structureId = e.target.getAttribute('data-structure-id');
                    if (confirm('Are you sure you want to delete this commission structure?')) {
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
                                    e.target.closest('tr').remove();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting commission structure:', error);
                                alert('An error occurred while deleting the commission structure.');
                            });
                    }
                }
            });


            function loadCompanyPerformance() {

                const policiesCtx = document.getElementById('policiesChart').getContext('2d');
                new Chart(policiesCtx, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode(array_column($monthly_policies->toArray(), 'month')) ?>,
                        datasets: [{
                            label: 'Policies Issued',
                            data: <?= json_encode(array_column($monthly_policies->toArray(), 'count')) ?>,
                            backgroundColor: '#3b82f6',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });


                const premiumCtx = document.getElementById('premiumChart').getContext('2d');
                new Chart(premiumCtx, {
                    type: 'doughnut',
                    data: {
                        labels: <?= json_encode(array_column($company_stats->toArray(), 'company_name')) ?>,
                        datasets: [{
                            data: <?= json_encode(array_column($company_stats->toArray(), 'total_premium')) ?>,
                            backgroundColor: [
                                '#3b82f6', '#10b981', '#f59e0b', '#6366f1', '#ec4899'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });
            }


            function loadCompanyStats() {
                fetch('/admin/insurance-companies/stats')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('totalCompanies').textContent = data.total_companies;
                        document.getElementById('activeCompanies').textContent = data.active_companies;
                        document.getElementById('totalPolicies').textContent = data.total_policies;
                        document.getElementById('totalPremium').textContent = 'KES ' + data.total_premium.toLocaleString();
                    })
                    .catch(error => {
                        console.error('Error loading company stats:', error);
                    });
            }


            function loadCommissionStructures() {


            }


            if (initialTab === 'company-performance') {
                loadCompanyPerformance();
            }
        });
    </script>
</x-layouts.app>