@php
    $isEdit = isset($commissionCalculation) && $commissionCalculation !== null;
    $formAction = $isEdit 
        ? route('commission-calculations.update', $commissionCalculation)
        : route('commission-calculations.store');
    $dialogTitle = $isEdit ? 'Edit Commission Calculation' : 'New Commission Calculation';

    $commissionCalculation = $commissionCalculation ?? (object) [
        'id' => '',
        'policy_id' => '',
        'commission_amount' => '',
        'calculation_date' => now()->format('Y-m-d'),
    ];
@endphp

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">{{ $dialogTitle }}</h3>
    <form id="commission-calculation-form" action="{{ $formAction }}" method="POST" class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="policy_id" class="block text-sm font-medium text-gray-700">Policy</label>
                <select id="policy_id" name="policy_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
                    @foreach($policies as $policy)
                        <option value="{{ $policy->id }}" {{ $commissionCalculation->policy_id == $policy->id ? 'selected' : '' }}>
                            {{ $policy->policy_number }}
                        </option>
                    @endforeach
                </select>
            </div>
             <div>
                <label for="commission_amount" class="block text-sm font-medium text-gray-700">Commission Amount</label>
                <input type="number" id="commission_amount" name="commission_amount" value="{{ $commissionCalculation->commission_amount }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $isEdit ? 'Update Calculation' : 'Create Calculation' }}
            </button>
        </div>
    </form>
</section>
