<x-layouts.app>

    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Performance Metric Details</h1>
                </div>
                <a href="{{ route('performance-metrics.index') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-gray-200 hover:bg-gray-300 text-gray-800 h-10 px-4 py-2">
                    Back to Performance Metrics
                </a>
            </div>

            <!-- Details -->
            <div class="rounded-lg border border-gray-300 bg-white shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Metric Date</label>
                        <p class="text-gray-900">{{ $performanceMetric->metric_date }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agent</label>
                        <p class="text-gray-900">{{ $performanceMetric->agent->full_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Company</label>
                        <p class="text-gray-900">{{ $performanceMetric->company->company_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Policy Type</label>
                        <p class="text-gray-900">{{ $performanceMetric->policyType->type_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Policies Sold</label>
                        <p class="text-gray-900">{{ $performanceMetric->total_policies_sold }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Premium Amount</label>
                        <p class="text-gray-900">{{ number_format($performanceMetric->total_premium_amount, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Commission Earned</label>
                        <p class="text-gray-900">{{ number_format($performanceMetric->total_commission_earned, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Average Policy Value</label>
                        <p class="text-gray-900">{{ number_format($performanceMetric->average_policy_value, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Renewal Rate</label>
                        <p class="text-gray-900">{{ $performanceMetric->renewal_rate }}%</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Client Acquisition Count</label>
                        <p class="text-gray-900">{{ $performanceMetric->client_acquisition_count }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
