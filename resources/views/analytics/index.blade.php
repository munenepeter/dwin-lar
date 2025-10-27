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
