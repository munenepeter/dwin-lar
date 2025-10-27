<x-layouts.app>

    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Performance Metrics</h1>
                    <p class="text-muted-foreground">Track and analyze performance metrics</p>
                </div>
                <button id="downloadReport" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-blue-500 hover:bg-blue-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download mr-2 h-4 w-4">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" x2="12" y1="15" y2="3"></line>
                    </svg>
                    Download Report
                </button>
            </div>

            <!-- Table Content -->
            <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                <div class="p-6 pt-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full text-sm" id="performance-metrics-table">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Date</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Agent</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Company</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Type</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policies Sold</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Premium Amount</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Commission Earned</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($performanceMetrics as $metric)
                                <tr class="border-b border-gray-300 hover:bg-gray-50">
                                    <td class="p-4 align-middle">{{ $metric->metric_date }}</td>
                                    <td class="p-4 align-middle">{{ $metric->agent->full_name ?? 'N/A' }}</td>
                                    <td class="p-4 align-middle">{{ $metric->company->company_name ?? 'N/A' }}</td>
                                    <td class="p-4 align-middle">{{ $metric->policyType->type_name ?? 'N/A' }}</td>
                                    <td class="p-4 align-middle">{{ $metric->total_policies_sold }}</td>
                                    <td class="p-4 align-middle">{{ number_format($metric->total_premium_amount, 2) }}</td>
                                    <td class="p-4 align-middle">{{ number_format($metric->total_commission_earned, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center">No performance metrics found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $performanceMetrics->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('downloadReport').addEventListener('click', function() {
            const table = document.getElementById('performance-metrics-table');
            const rows = table.querySelectorAll('tr');
            let csvContent = 'data:text/csv;charset=utf-8,';

            rows.forEach(function(row) {
                let rowData = [];
                row.querySelectorAll('th, td').forEach(function(cell) {
                    rowData.push(cell.textContent);
                });
                csvContent += rowData.join(',') + '\r\n';
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'performance-metrics.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
</x-layouts.app>
