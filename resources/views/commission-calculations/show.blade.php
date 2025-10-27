<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Commission Calculation Details</h1>
                </div>
            </div>

            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Policy Information</h3>
                        <dl class="mt-2 space-y-2 text-sm text-gray-500">
                            <dt class="font-semibold">Policy Number</dt>
                            <dd>{{ $commissionCalculation->policy->policy_number }}</dd>
                            <dt class="font-semibold">Client</dt>
                            <dd>{{ $commissionCalculation->policy->client->name }}</dd>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Agent Information</h3>
                        <dl class="mt-2 space-y-2 text-sm text-gray-500">
                            <dt class="font-semibold">Agent Name</dt>
                            <dd>{{ $commissionCalculation->agent->name }}</dd>
                        </dl>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Commission Details</h3>
                        <dl class="mt-2 space-y-2 text-sm text-gray-500">
                            <dt class="font-semibold">Commission Amount</dt>
                            <dd>KES {{ number_format($commissionCalculation->commission_amount, 2) }}</dd>
                            <dt class="font-semibold">Calculation Date</dt>
                            <dd>{{ $commissionCalculation->calculation_date->format('Y-m-d') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
             <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('commission-calculations.edit', $commissionCalculation) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">Edit</a>
                <form action="{{ route('commission-calculations.destroy', $commissionCalculation) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete</button>
                </form>
                <a href="{{ route('commission-calculations.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Back to List</a>
            </div>
        </div>
    </main>
</x-layouts.app>
