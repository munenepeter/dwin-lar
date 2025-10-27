<x-layouts.app>

    <main class="flex-1 shadow-xs rounded-md">
        <div class="mx-auto">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Dashboard Overview</h1>

            <!-- Quick Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Clients</dt>
                                <dd class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($totalClients ?? 0); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Policies</dt>
                                <dd class="text-lg font-medium text-gray-900"><?php echo htmlspecialchars($activePolicies ?? 0); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">YTD Commission</dt>
                                <dd class="text-lg font-medium text-gray-900">KES <?php echo htmlspecialchars(number_format($yearToDateCommission ?? 0, 2)); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">YTD Premium</dt>
                                <dd class="text-lg font-medium text-gray-900">KES <?php echo htmlspecialchars(number_format($yearToDatePremium ?? 0, 2)); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6" style="height: 420px !important;">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Policies by Type</h2>
                    <canvas style="height: 380px !important;" id="policyTypeChart"></canvas>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Policies by Company</h2>
                    <canvas id="policyCompanyChart"></canvas>
                </div>
            </div>

            <!-- Expiring Policies Table -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Policies Expiring in Next 30 Days</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Number</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days to Expiry</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($expiringPolicies)): ?>
                                <?php foreach ($expiringPolicies as $policy): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($policy->policy_number); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($policy->client_name); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($policy->policy_type); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($policy->company_name); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($policy->expiry_date); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($policy->days_to_expiry); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($policy->agent_name); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No policies expiring in the next 30 days.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>


    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data from the controller (JSON encoded strings)
        const policyTypeLabels = <?php echo $policyTypeLabels ?? '[]'; ?>;
        const policyTypeData = <?php echo $policyTypeData ?? '[]'; ?>;
        const policyCompanyLabels = <?php echo $policyCompanyLabels ?? '[]'; ?>;
        const policyCompanyData = <?php echo $policyCompanyData ?? '[]'; ?>;

        // Policy Type Chart
        const ctxPolicyType = document.getElementById('policyTypeChart').getContext('2d');
        new Chart(ctxPolicyType, {
            type: 'pie',
            data: {
                labels: policyTypeLabels,
                datasets: [{
                    label: 'Number of Policies',
                    data: policyTypeData,
                    backgroundColor: [
                        '#EF4444',
                        '#F59E0B',
                        '#10B981',
                        '#3B82F6',
                        '#6366F1',
                        '#8B5CF6',
                        '#E879F9',
                        '#EC4899',
                        '#F43F5E',
                    ],
                    borderColor: [
                        '#991B1B',
                        '#B45309',
                        '#047857',
                        '#2563EB',
                        '#4F46E5',
                        '#7C3AED',
                        '#D946EF',
                        '#BE185D',
                        '#E11D48',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false,
                        text: 'Policies by Type'
                    }
                }
            },
        });

        // Policy Company Chart
        const ctxPolicyCompany = document.getElementById('policyCompanyChart').getContext('2d');
        new Chart(ctxPolicyCompany, {
            type: 'bar',
            data: {
                labels: policyCompanyLabels,
                datasets: [{
                    label: 'Number of Policies',
                    data: policyCompanyData,
                    backgroundColor: [
                        '#EF4444',
                        '#F59E0B',
                        '#10B981',
                        '#3B82F6',
                        '#6366F1',
                        '#8B5CF6',
                        '#E879F9',
                        '#EC4899',
                        '#F43F5E',
                    ],
                    borderColor: [
                        '#991B1B',
                        '#B45309',
                        '#047857',
                        '#2563EB',
                        '#4F46E5',
                        '#7C3AED',
                        '#D946EF',
                        '#BE185D',
                        '#E11D48',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: false,
                        text: 'Policies by Company'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    </script>

</x-layouts.app>