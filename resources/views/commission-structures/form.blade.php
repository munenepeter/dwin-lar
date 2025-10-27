@php
    $isEdit = isset($commissionStructure);
    $title = $isEdit ? 'Edit Commission Structure' : 'Add Commission Structure';
@endphp

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">{{ $title }}</h3>

    <form id="commission-structure-form"
        action="{{ $isEdit ? route('commission-structures.update', $commissionStructure) : route('commission-structures.store') }}"
        method="POST" class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">

        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Company</label>
                <select name="company_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"
                    required>
                    <option value="">-- Select Company --</option>
                    @foreach ($companies as $c)
                        <option value="{{ $c->id }}"
                            {{ old('company_id', $commissionStructure->company_id ?? '') == $c->id ? 'selected' : '' }}>
                            {{ $c->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Policy Type</label>
                <select name="policy_type_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"
                    required>
                    <option value="">-- Select Type --</option>
                    @foreach ($policyTypes as $pt)
                        <option value="{{ $pt->id }}"
                            {{ old('policy_type_id', $commissionStructure->policy_type_id ?? '') == $pt->id ? 'selected' : '' }}>
                            {{ $pt->type_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Structure Name</label>
            <input type="text" name="structure_name"
                value="{{ old('structure_name', $commissionStructure->structure_name ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"
                required maxlength="100">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Commission Type</label>
            <select name="commission_type" id="commission_type"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"
                required>
                <option value="FLAT_PERCENTAGE"
                    {{ old('commission_type', $commissionStructure->commission_type ?? '') == 'FLAT_PERCENTAGE' ? 'selected' : '' }}>
                    Flat Percentage
                </option>
                <option value="FIXED_AMOUNT"
                    {{ old('commission_type', $commissionStructure->commission_type ?? '') == 'FIXED_AMOUNT' ? 'selected' : '' }}>
                    Fixed Amount
                </option>
                <option value="TIERED"
                    {{ old('commission_type', $commissionStructure->commission_type ?? '') == 'TIERED' ? 'selected' : '' }}>
                    Tiered
                </option>
            </select>
        </div>

        {{-- ==== FLAT PERCENTAGE ==== --}}
        <div id="flat-percentage-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Base Percentage (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="base_percentage"
                    value="{{ old('base_percentage', $commissionStructure->base_percentage ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600">
            </div>
        </div>

        {{-- ==== FIXED AMOUNT ==== --}}
        <div id="fixed-amount-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden">
            <div>
                <label class="block text-sm font-medium text-gray-700">Fixed Amount (KES)</label>
                <input type="number" step="0.01" min="0" name="fixed_amount"
                    value="{{ old('fixed_amount', $commissionStructure->fixed_amount ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600">
            </div>
        </div>

        {{-- ==== TIERED ==== --}}
        <div id="tiered-fields" class="space-y-4 hidden">
            <label class="block text-sm font-medium text-gray-700">Tier Structure (JSON)</label>
            <p class="text-xs text-gray-500 mb-2">
                Example: <code>[{ "from": 0, "to": 100000, "percentage": 5 }, { "from": 100001, "percentage": 7
                    }]</code>
            </p>
            <textarea name="tier_structure" rows="6"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"
                placeholder='[{"from":0,"to":100000,"percentage":5},{"from":100001,"percentage":7}]'>{{ old('tier_structure', $commissionStructure->tier_structure ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Minimum Premium (KES)</label>
                <input type="number" step="0.01" min="0" name="minimum_premium"
                    value="{{ old('minimum_premium', $commissionStructure->minimum_premium ?? '0.00') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Maximum Premium (KES) <span
                        class="text-xs text-gray-500">(optional)</span></label>
                <input type="number" step="0.01" min="0" name="maximum_premium"
                    value="{{ old('maximum_premium', $commissionStructure->maximum_premium ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Effective Date</label>
                <input type="date" name="effective_date"
                    value="{{ old('effective_date', $commissionStructure->effective_date ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"
                    required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Expiry Date <span
                        class="text-xs text-gray-500">(optional)</span></label>
                <input type="date" name="expiry_date"
                    value="{{ old('expiry_date', $commissionStructure->expiry_date ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600">
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $commissionStructure->is_active ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-600">
                <span class="ml-2 text-sm font-medium text-gray-700">Active</span>
            </label>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button"
                class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                Cancel
            </button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $isEdit ? 'Update' : 'Create' }} Structure
            </button>
        </div>
    </form>
</section>

<script>
    // -------------------------------------------------
    // Show / hide fields depending on commission type
    // -------------------------------------------------
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('commission_type');
        const flatDiv = document.getElementById('flat-percentage-fields');
        const fixedDiv = document.getElementById('fixed-amount-fields');
        const tieredDiv = document.getElementById('tiered-fields');

        function toggle() {
            const val = typeSelect.value;
            flatDiv.classList.toggle('hidden', val !== 'FLAT_PERCENTAGE');
            fixedDiv.classList.toggle('hidden', val !== 'FIXED_AMOUNT');
            tieredDiv.classList.toggle('hidden', val !== 'TIERED');
        }

        typeSelect.addEventListener('change', toggle);
        toggle(); // initial
    });
</script>
