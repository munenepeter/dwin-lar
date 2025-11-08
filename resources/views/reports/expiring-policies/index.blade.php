<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Expiring Policies Report</h1>
                    <p class="text-muted-foreground">A report of policies expiring within a specified number of days.</p>
                </div>
                <div class="space-x-2">
                    <button id="downloadCsv" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-blue-500 hover:bg-blue-600 text-white h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download mr-2 h-4 w-4">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" x2="12" y1="15" y2="3"></line>
                        </svg>
                        Download CSV
                    </button>
                    <button id="downloadPdf" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-green-500 hover:bg-green-600 text-white h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download mr-2 h-4 w-4">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" x2="12" y1="15" y2="3"></line>
                        </svg>
                        Download PDF
                    </button>
                    <button id="sendEmail" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-purple-500 hover:bg-purple-600 text-white h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail mr-2 h-4 w-4">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                        Send via Email
                    </button>
                </div>
            </div>

            <div class="rounded-lg border border-gray-300 bg-white shadow-sm p-6">
                <form method="GET" action="{{ route('reports.expiring-policies') }}" class="flex items-center space-x-4">
                    <div class="flex-1">
                        <label for="days_ahead" class="block text-sm font-medium text-gray-700">Days Ahead</label>
                        <input type="number" id="days_ahead" name="days_ahead" value="{{ request('days_ahead', 30) }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
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
                            <table class="w-full text-sm" id="expiring-policies-table">
                                <thead>
                                    <tr class="border-b border-gray-300">
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Number</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Client Name</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Client Phone</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Type</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Company</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Expiry Date</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Days to Expiry</th>
                                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Agent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reportData as $data)
                                        <tr class="border-b border-gray-300 hover:bg-gray-50">
                                            <td class="p-4 align-middle">{{ $data->policy_number }}</td>
                                            <td class="p-4 align-middle">{{ $data->client_name }}</td>
                                            <td class="p-4 align-middle">{{ $data->phone_primary }}</td>
                                            <td class="p-4 align-middle">{{ $data->policy_type }}</td>
                                            <td class="p-4 align-middle">{{ $data->company_name }}</td>
                                            <td class="p-4 align-middle">{{ $data->expiry_date }}</td>
                                            <td class="p-4 align-middle">{{ $data->days_to_expiry }}</td>
                                            <td class="p-4 align-middle">{{ $data->agent_name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="p-4 text-center">No expiring policies found for the selected criteria.</td>
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
        document.getElementById('downloadCsv').addEventListener('click', function() {
            const table = document.getElementById('expiring-policies-table');
            if (!table) return;
            const rows = table.querySelectorAll('tr');
            let csvContent = 'data:text/csv;charset=utf-8,';

            rows.forEach(function(row) {
                let rowData = [];
                row.querySelectorAll('th, td').forEach(function(cell) {
                    rowData.push(cell.textContent.trim());
                });
                csvContent += rowData.join(',') + '\r\n';
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'expiring-policies-report.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        document.getElementById('downloadPdf').addEventListener('click', function() {
            let url = new URL(window.location.href);
            url.searchParams.set('format', 'pdf');
            const link = document.createElement('a');
            link.href = url.toString();
            link.download = 'expiring-policies-report.pdf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        document.getElementById('sendEmail').addEventListener('click', function() {
            const to = prompt('Enter the recipient email address:');
            if (to) {
                let url = new URL(window.location.href);
                url.searchParams.set('action', 'email');
                url.searchParams.set('to', to);
                fetch(url.toString(), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    alert('Error sending email: ' + error);
                });
            }
        });
    </script>
</x-layouts.app>