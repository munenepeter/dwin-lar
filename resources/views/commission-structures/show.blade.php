<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">View Commission Structure</h3>
    <div class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <div>
            <label class="block text-sm font-medium text-gray-700">Structure Name</label>
            <p class="text-gray-900">{{ $commissionStructure->structure_name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Insurance Company</label>
            <p class="text-gray-900">{{ $commissionStructure->insuranceCompany->company_name ?? 'N/A' }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Policy Type</label>
            <p class="text-gray-900">{{ $commissionStructure->policyType->type_name ?? 'N/A' }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Commission Type</label>
            @php
                $typeLabels = [
                    'FLAT_PERCENTAGE' => 'Flat %',
                    'TIERED' => 'Tiered',
                    'FIXED_AMOUNT' => 'Fixed Amount',
                ];
            @endphp
            <p class="text-gray-900">{{ $typeLabels[$commissionStructure->commission_type] ?? $commissionStructure->commission_type }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Rate/Amount</label>
            <p class="text-gray-900">
                @switch($commissionStructure->commission_type)
                    @case('FLAT_PERCENTAGE')
                        {{ number_format($commissionStructure->base_percentage ?? 0, 2) }}%
                        @break
                    @case('FIXED_AMOUNT')
                        KES {{ number_format($commissionStructure->fixed_amount ?? 0, 2) }}
                        @break
                    @case('TIERED')
                        Tiered Rates
                        @break
                @endswitch
            </p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Effective Date</label>
            <p class="text-gray-900">{{ \Carbon\Carbon::parse($commissionStructure->effective_date)->format('Y-m-d') }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <p class="text-gray-900">{{ $commissionStructure->is_active ? 'Active' : 'Inactive' }}</p>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Close</button>
        </div>
    </div>
</section>