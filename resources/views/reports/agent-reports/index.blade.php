<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Agent Performance Report</h1>
                    <p class="text-muted-foreground">Generate a performance report for a specific agent.</p>
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

            <div class="rounded-lg border border-gray-300 bg-white shadow-sm p-6">
                <form method="GET" action="{{ route('reports.agent-performance') }}" class="flex items-center space-x-4">
                    <div class="flex-1">
                        <label for="agent_id" class="block text-sm font-medium text-gray-700">Agent</label>
                        <select id="agent_id" name="agent_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>{{ $agent->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                    </div>
                    <div class="flex-1">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                    </div>
                    <div class="pt-5">
                        <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-blue-500 hover:bg-blue-600 text-white h-10 px-4 py-2">Generate Report</button>
                    </div>
                </form>
            </div>

            @if (isset($reportData))
                <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                    <div class="p-6 pt-0">
                        <div class="relative w-full overflow-auto">
                            <table class="w-full text-sm" id="agent-report-table">
                                <thead>
                                    <tr class="border-b border-gray-300">
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Date</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policies Sold</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Total Premium</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Avg. Premium</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Total Commission</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Unique Clients</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reportData as $data)
                                        <tr class="border-b border-gray-300 hover:bg-gray-50">
                                            <td class="p-4 align-middle">{{ $data->sale_date }}</td>
                                            <td class="p-4 align-middle">{{ $data->policies_sold }}</td>
                                            <td class="p-4 align-middle">{{ number_format($data->total_premium, 2) }}</td>
                                            <td class="p-4 align-middle">{{ number_format($data->avg_premium, 2) }}</td>
                                            <td class="p-4 align-middle">{{ number_format($data->total_commission, 2) }}</td>
                                            <td class="p-4 align-middle">{{ $data->unique_clients }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="p-4 text-center">No data available for the selected criteria.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        document.getElementById('downloadReport').addEventListener('click', function() {
            const table = document.getElementById('agent-report-table');
            if (!table) return;
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
            link.setAttribute('download', 'agent-performance-report.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
</x-layouts.app>
