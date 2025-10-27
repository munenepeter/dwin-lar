<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Outstanding Commissions Report</h1>
                    <p class="text-muted-foreground">A summary of outstanding commissions for all agents.</p>
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

            <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                <div class="p-6 pt-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full text-sm" id="financial-report-table">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Agent Name</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Employee ID</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Pending Calculations</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Total Outstanding</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Oldest Calculation</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Newest Calculation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reportData as $data)
                                    <tr class="border-b border-gray-300 hover:bg-gray-50">
                                        <td class="p-4 align-middle">{{ $data->agent_name }}</td>
                                        <td class="p-4 align-middle">{{ $data->employee_id }}</td>
                                        <td class="p-4 align-middle">{{ $data->pending_calculations }}</td>
                                        <td class="p-4 align-middle">{{ number_format($data->total_outstanding, 2) }}</td>
                                        <td class="p-4 align-middle">{{ $data->oldest_calculation }}</td>
                                        <td class="p-4 align-middle">{{ $data->newest_calculation }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-4 text-center">No outstanding commissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('downloadReport').addEventListener('click', function() {
            const table = document.getElementById('financial-report-table');
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
            link.setAttribute('download', 'outstanding-commissions-report.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
</x-layouts.app>
