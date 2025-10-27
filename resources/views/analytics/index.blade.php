<x-layouts.app>

    <main class="flex-1 shadow-xs rounded-md">
        <div class="mx-auto">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Analytics Dashboard</h1>

            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a href="#" class="tab-link border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" id="tab-general">General</a>
                    <a href="#" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" id="tab-clients">Clients</a>
                    <a href="#" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" id="tab-policies">Policies</a>
                    <a href="#" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" id="tab-commissions">Commissions</a>
                </nav>
            </div>

            <!-- Tab Content -->
            <div id="content-general" class="tab-content mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Clients</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo htmlspecialchars($totalClients ?? 0); ?></dd>
                        </dl>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Policies</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900"><?php echo htmlspecialchars($totalPolicies ?? 0); ?></dd>
                        </dl>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Premium</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">KES <?php echo htmlspecialchars(number_format($totalPremium ?? 0, 2)); ?></dd>
                        </dl>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Commissions</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">KES <?php echo htmlspecialchars(number_format($totalCommissions ?? 0, 2)); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div id="content-clients" class="tab-content mt-6 hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Client Acquisition</h2>
                        <canvas id="clientAcquisitionChart"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Client Status</h2>
                        <canvas id="clientStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <div id="content-policies" class="tab-content mt-6 hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Policies Sold Over Time</h2>
                        <canvas id="policiesSoldChart"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Premium Growth Over Time</h2>
                        <canvas id="premiumGrowthChart"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Policy Status Distribution</h2>
                        <canvas id="policyStatusDistributionChart"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Expiring Policies (Next 90 days)</h2>
                        <p class="text-3xl font-semibold text-gray-900"><?php echo htmlspecialchars($expiringPolicies ?? 0); ?></p>
                    </div>
                </div>
            </div>

            <div id="content-commissions" class="tab-content mt-6 hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Commissions Earned Over Time</h2>
                        <canvas id="commissionsEarnedChart"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Top 10 Agents by Policies Sold</h2>
                        <canvas id="topAgentsChart"></canvas>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 mt-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Commissions by Insurance Company</h2>
                    <canvas id="commissionsByCompanyChart"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.tab-link');
            const contents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = 'content-' + e.target.id.split('-')[1];

                    tabs.forEach(t => {
                        t.classList.remove('border-blue-500', 'text-blue-600');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    e.target.classList.add('border-blue-500', 'text-blue-600');
                    e.target.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');

                    contents.forEach(content => {
                        if (content.id === targetId) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                });
            });

            // Charts
            const clientAcquisitionData = <?php echo json_encode($clientAcquisition) ?? '[]'; ?>;
            const clientStatusData = <?php echo json_encode($clientStatus) ?? '[]'; ?>;
            const policiesSoldData = <?php echo json_encode($policiesSold) ?? '[]'; ?>;
            const premiumGrowthData = <?php echo json_encode($premiumGrowth) ?? '[]'; ?>;
            const policyStatusDistributionData = <?php echo json_encode($policyStatusDistribution) ?? '[]'; ?>;
            const commissionsEarnedData = <?php echo json_encode($commissionsEarned) ?? '[]'; ?>;
            const topAgentsData = <?php echo json_encode($topAgents) ?? '[]'; ?>;
            const commissionsByCompanyData = <?php echo json_encode($commissionsByCompany) ?? '[]'; ?>;

            new Chart(document.getElementById('clientAcquisitionChart'), {
                type: 'line',
                data: {
                    labels: clientAcquisitionData.map(d => d.month),
                    datasets: [{
                        label: 'New Clients',
                        data: clientAcquisitionData.map(d => d.total),
                        borderColor: '#3B82F6',
                        tension: 0.1
                    }]
                }
            });

            new Chart(document.getElementById('clientStatusChart'), {
                type: 'pie',
                data: {
                    labels: clientStatusData.map(d => d.client_status),
                    datasets: [{
                        data: clientStatusData.map(d => d.total),
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                    }]
                }
            });
            
            new Chart(document.getElementById('policiesSoldChart'), {
                type: 'line',
                data: {
                    labels: policiesSoldData.map(d => d.month),
                    datasets: [{
                        label: 'Policies Sold',
                        data: policiesSoldData.map(d => d.total),
                        borderColor: '#10B981',
                        tension: 0.1
                    }]
                }
            });

            new Chart(document.getElementById('premiumGrowthChart'), {
                type: 'line',
                data: {
                    labels: premiumGrowthData.map(d => d.month),
                    datasets: [{
                        label: 'Total Premium',
                        data: premiumGrowthData.map(d => d.total),
                        borderColor: '#6366F1',
                        tension: 0.1
                    }]
                }
            });

            new Chart(document.getElementById('policyStatusDistributionChart'), {
                type: 'pie',
                data: {
                    labels: policyStatusDistributionData.map(d => d.policy_status),
                    datasets: [{
                        data: policyStatusDistributionData.map(d => d.total),
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#6B7280', '#3B82F6'],
                    }]
                }
            });

            new Chart(document.getElementById('commissionsEarnedChart'), {
                type: 'line',
                data: {
                    labels: commissionsEarnedData.map(d => d.month),
                    datasets: [{
                        label: 'Commissions Earned',
                        data: commissionsEarnedData.map(d => d.total),
                        borderColor: '#8B5CF6',
                        tension: 0.1
                    }]
                }
            });
            
            new Chart(document.getElementById('topAgentsChart'), {
                type: 'bar',
                data: {
                    labels: topAgentsData.map(d => d.full_name),
                    datasets: [{
                        label: 'Policies Sold',
                        data: topAgentsData.map(d => d.total_policies),
                        backgroundColor: '#3B82F6',
                    }]
                }
            });
            
            new Chart(document.getElementById('commissionsByCompanyChart'), {
                type: 'bar',
                data: {
                    labels: commissionsByCompanyData.map(d => d.company_name),
                    datasets: [{
                        label: 'Total Commission',
                        data: commissionsByCompanyData.map(d => d.total_commission),
                        backgroundColor: '#10B981',
                    }]
                }
            });
        });
    </script>
</x-layouts.app>

<x-layouts.app>
    <div class="container-fluid px-4 py-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Analytics Dashboard</h1>
            <p class="text-gray-600 mt-1">Comprehensive insights and performance metrics</p>
        </div>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Revenue -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">+12.5%</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Total Revenue</h3>
                <p class="text-2xl font-bold text-gray-900">KSh {{ number_format($analytics['total_revenue'], 2) }}</p>
            </div>

            <!-- Total Commissions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">+8.2%</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Total Commissions</h3>
                <p class="text-2xl font-bold text-gray-900">KSh {{ number_format($analytics['total_commissions'], 2) }}</p>
            </div>

            <!-- Active Policies -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-1 rounded">+15.3%</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">Active Policies</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($analytics['active_policies']) }}</p>
            </div>

            <!-- New Clients -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-1 rounded">This month</span>
                </div>
                <h3 class="text-gray-600 text-sm font-medium mb-1">New Clients</h3>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($analytics['new_clients_this_month']) }}</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Revenue Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
                    <select class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                        <option>Last year</option>
                    </select>
                </div>
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Policy Distribution -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Policy Distribution</h3>
                    <select class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option>By Type</option>
                        <option>By Status</option>
                        <option>By Agent</option>
                    </select>
                </div>
                <div class="h-64 flex items-center justify-center text-gray-400">
                    <canvas id="policyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Performance Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Top Performing Agents</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policies Sold</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue Generated</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commission Earned</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white font-medium text-sm mr-3">JD</div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">John Doe</div>
                                        <div class="text-sm text-gray-500">john@dwin.com</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">145</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">KSh 2,450,000</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">KSh 245,000</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2" style="width: 100px;">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: 95%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">95%</span>
                                </div>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Policy Chart
        const policyCtx = document.getElementById('policyChart');
        new Chart(policyCtx, {
            type: 'doughnut',
            data: {
                labels: ['Motor', 'Health', 'Life', 'Property', 'Other'],
                datasets: [{
                    data: [300, 150, 100, 80, 70],
                    backgroundColor: [
                        'rgb(239, 68, 68)',
                        'rgb(59, 130, 246)',
                        'rgb(168, 85, 247)',
                        'rgb(251, 146, 60)',
                        'rgb(34, 197, 94)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    @endpush
</x-layouts.app>