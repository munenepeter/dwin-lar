@php
    $isEdit = isset($policy) && $policy !== null;
    $formAction = $isEdit ? route('policies.update', $policy->id) : route('policies.store');
    $formMethod = $isEdit ? 'PATCH' : 'POST';
    $dialogTitle = $isEdit ? 'Edit Policy' : 'Add New Policy';

    // Default values for a brand-new policy
    $policy = $policy ?? (object)[
        'id'               => '',
        'client_id'        => '',
        'company_id'       => '',
        'policy_type_id'   => '',
        'agent_id'         => '',
        'premium_amount'   => '',
        'sum_insured'      => '',
        'issue_date'       => now()->format('Y-m-d'),
        'effective_date'   => now()->format('Y-m-d'),
        'expiry_date'      => now()->addYear()->format('Y-m-d'),
        'payment_frequency'=> 'ANNUAL',
        'payment_method'   => 'CASH',
        'policy_status'    => 'PENDING',
        'coverage_details' => '',
        'notes'            => ''
    ];

    // Decode existing JSON (edit mode)
    $coverageDetails = $isEdit && $policy->coverage_details
        ? json_decode($policy->coverage_details, true)
        : [];
@endphp

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">{{ $dialogTitle }}</h3>

    <form id="policy-form"
          action="{{ $formAction }}"
          method="POST"
          class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        @csrf
        @if ($isEdit) @method('PATCH') @endif

        {{-- ------------------------------------------------- CLIENT ------------------------------------------------- --}}
        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
            <select id="client_id" name="client_id"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
                <option value="">Select Client</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $policy->client_id == $client->id ? 'selected' : '' }}>
                        {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ------------------------------------------------- COMPANY ------------------------------------------------- --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="company_id" class="block text-sm font-medium text-gray-700">Insurance Company</label>
                <select id="company_id" name="company_id"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                        required>
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ $policy->company_id == $company->id ? 'selected' : '' }}>
                            {{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ------------------------------------------------- POLICY TYPE (AJAX) ------------------------------------------------- --}}
            <div>
                <label for="policy_type_id" class="block text-sm font-medium text-gray-700">Policy Type</label>
                <select id="policy_type_id" name="policy_type_id"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                        required>
                    <option value="">Select Policy Type</option>

                    @if ($isEdit)
                        {{-- In edit mode we already loaded the allowed types --}}
                        @foreach ($policyTypes as $type)
                            <option value="{{ $type->id }}" {{ $policy->policy_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->type_name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <p id="policy-type-msg" class="text-xs text-red-600 mt-1 hidden">
                    No commission structure exists for the selected company.
                </p>
            </div>
        </div>

        {{-- ------------------------------------------------- AGENT ------------------------------------------------- --}}
        <div>
            <label for="agent_id" class="block text-sm font-medium text-gray-700">Assigned Agent</label>
            <select id="agent_id" name="agent_id"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
                <option value="">Select Agent</option>
                @foreach ($agents as $agent)
                    <option value="{{ $agent->id }}" {{ $policy->agent_id == $agent->id ? 'selected' : '' }}>
                        {{ $agent->full_name ?? $agent->first_name . ' ' . $agent->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ------------------------------------------------- DATES ------------------------------------------------- --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                <input type="date" id="issue_date" name="issue_date"
                       value="{{ $policy->issue_date }}"
                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                       required>
            </div>
            <div>
                <label for="effective_date" class="block text-sm font-medium text-gray-700">Effective Date</label>
                <input type="date" id="effective_date" name="effective_date"
                       value="{{ $policy->effective_date }}"
                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                       required>
            </div>
            <div>
                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date"
                       value="{{ $policy->expiry_date }}"
                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                       required>
            </div>
        </div>

        {{-- ------------------------------------------------- AMOUNTS ------------------------------------------------- --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="premium_amount" class="block text-sm font-medium text-gray-700">Premium Amount (KES)</label>
                <input type="number" step="0.01" id="premium_amount" name="premium_amount"
                       value="{{ $policy->premium_amount }}"
                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                       required>
            </div>
            <div>
                <label for="sum_insured" class="block text-sm font-medium text-gray-700">Sum Insured (KES)</label>
                <input type="number" step="0.01" id="sum_insured" name="sum_insured"
                       value="{{ $policy->sum_insured }}"
                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                       required>
            </div>
        </div>

        {{-- ------------------------------------------------- PAYMENT ------------------------------------------------- --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="payment_frequency" class="block text-sm font-medium text-gray-700">Payment Frequency</label>
                <select id="payment_frequency" name="payment_frequency"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                        required>
                    <option value="">Select Frequency</option>
                    <option value="MONTHLY"   {{ $policy->payment_frequency == 'MONTHLY'   ? 'selected' : '' }}>Monthly</option>
                    <option value="QUARTERLY" {{ $policy->payment_frequency == 'QUARTERLY' ? 'selected' : '' }}>Quarterly</option>
                    <option value="SEMI_ANNUAL"{{ $policy->payment_frequency == 'SEMI_ANNUAL'? 'selected' : '' }}>Semi-Annual</option>
                    <option value="ANNUAL"    {{ $policy->payment_frequency == 'ANNUAL'    ? 'selected' : '' }}>Annual</option>
                </select>
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <select id="payment_method" name="payment_method"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                        required>
                    <option value="">Select Method</option>
                    <option value="CASH"          {{ $policy->payment_method == 'CASH'          ? 'selected' : '' }}>Cash</option>
                    <option value="CHEQUE"        {{ $policy->payment_method == 'CHEQUE'        ? 'selected' : '' }}>Cheque</option>
                    <option value="BANK_TRANSFER" {{ $policy->payment_method == 'BANK_TRANSFER' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="MOBILE_MONEY"  {{ $policy->payment_method == 'MOBILE_MONEY'  ? 'selected' : '' }}>Mobile Money</option>
                    <option value="CARD"          {{ $policy->payment_method == 'CARD'          ? 'selected' : '' }}>Card</option>
                </select>
            </div>
        </div>

        {{-- ------------------------------------------------- STATUS ------------------------------------------------- --}}
        <div>
            <label for="policy_status" class="block text-sm font-medium text-gray-700">Policy Status</label>
            <select id="policy_status" name="policy_status"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
                <option value="">Select Status</option>
                <option value="PENDING"   {{ $policy->policy_status == 'PENDING'   ? 'selected' : '' }}>Pending</option>
                <option value="ACTIVE"    {{ $policy->policy_status == 'ACTIVE'    ? 'selected' : '' }}>Active</option>
                <option value="EXPIRED"   {{ $policy->policy_status == 'EXPIRED'   ? 'selected' : '' }}>Expired</option>
                <option value="CANCELLED" {{ $policy->policy_status == 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                <option value="SUSPENDED" {{ $policy->policy_status == 'SUSPENDED' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>

        {{-- ------------------------------------------------- COVERAGE DETAILS (dynamic) ------------------------------------------------- --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Coverage Details</label>

            <div id="coverage-details-container" class="space-y-3">
                @if (!empty($coverageDetails))
                    @foreach ($coverageDetails as $idx => $item)
                        <div class="coverage-row flex gap-2 items-center">
                            <input type="text" placeholder="Key (e.g. Vehicle Make)"
                                   value="{{ $item['key'] ?? '' }}"
                                   class="coverage-key flex-1 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 p-2">

                            <input type="text" placeholder="Value"
                                   value="{{ $item['value'] ?? '' }}"
                                   class="coverage-value flex-1 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 p-2">

                            <button type="button"
                                    class="remove-coverage text-red-600 hover:text-red-800"
                                    title="Remove">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="button" id="add-coverage-detail"
                    class="mt-2 inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm">
                Add Coverage Detail
            </button>

            <input type="hidden" name="coverage_details" id="coverage_details_hidden"
                   value="{{ old('coverage_details', json_encode($coverageDetails)) }}">

            <p class="text-xs text-gray-500 mt-1">Add any extra coverage information (optional).</p>
        </div>

        {{-- ------------------------------------------------- NOTES ------------------------------------------------- --}}
        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea id="notes" name="notes" rows="3"
                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">{{ $policy->notes ?? '' }}</textarea>
        </div>

        {{-- ------------------------------------------------- SUBMIT ------------------------------------------------- --}}
        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                Cancel
            </button>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $isEdit ? 'Update Policy' : 'Create Policy' }}
            </button>
        </div>
    </form>
</section>

{{-- ===============================================  JAVASCRIPT  =============================================== --}}
<script>
    // ---------- 1. Load Policy Types when Company changes ----------
    const companySelect      = document.getElementById('company_id');
    const policyTypeSelect   = document.getElementById('policy_type_id');
    const policyTypeMsg      = document.getElementById('policy-type-msg');

    function loadPolicyTypes(companyId, selectedId = null) {
        if (!companyId) {
            policyTypeSelect.innerHTML = '<option value="">Select Policy Type</option>';
            policyTypeMsg.classList.add('hidden');
            return;
        }

        fetch(`${window.location.origin}/policy-types/by-company/${companyId}`)
            .then(r => r.json())
            .then(types => {
                policyTypeSelect.innerHTML = '<option value="">Select Policy Type</option>';

                if (types.length === 0) {
                    policyTypeMsg.classList.remove('hidden');
                    policyTypeSelect.disabled = true;
                    return;
                }

                policyTypeMsg.classList.add('hidden');
                policyTypeSelect.disabled = false;

                types.forEach(t => {
                    const opt = document.createElement('option');
                    opt.value = t.id;
                    opt.text  = t.type_name;
                    if (selectedId && selectedId == t.id) opt.selected = true;
                    policyTypeSelect.appendChild(opt);
                });
            })
            .catch(() => {
                policyTypeMsg.textContent = 'Error loading policy types.';
                policyTypeMsg.classList.remove('hidden');
            });
    }

    companySelect.addEventListener('change', function () {
        loadPolicyTypes(this.value);
    });

    // On page load (create mode) – nothing to pre-select
    // On edit mode we already rendered the correct options, but we still need the AJAX endpoint for future changes
    @if(!$isEdit)
        // nothing
    @endif

    // ---------- 2. Dynamic Coverage Details ----------
    const container          = document.getElementById('coverage-details-container');
    const addBtn             = document.getElementById('add-coverage-detail');
    const hiddenInput        = document.getElementById('coverage_details_hidden');

    function updateHidden() {
        const rows   = container.querySelectorAll('.coverage-row');
        const data   = [];

        rows.forEach(row => {
            const key   = row.querySelector('.coverage-key').value.trim();
            const value = row.querySelector('.coverage-value').value.trim();
            if (key && value) data.push({key, value});
        });

        hiddenInput.value = JSON.stringify(data);
    }

    addBtn.addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'coverage-row flex gap-2 items-center';

        div.innerHTML = `
            <input type="text" placeholder="Key (e.g. Vehicle Make)"
                   class="coverage-key flex-1 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 p-2">

            <input type="text" placeholder="Value"
                   class="coverage-value flex-1 shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 p-2">

            <button type="button" class="remove-coverage text-red-600 hover:text-red-800" title="Remove">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;

        container.appendChild(div);
        updateHidden();
    });

    container.addEventListener('click', e => {
        if (e.target.closest('.remove-coverage')) {
            e.target.closest('.coverage-row').remove();
            updateHidden();
        }
    });

    container.addEventListener('input', updateHidden);

    // initialise hidden field on load
    updateHidden();

    // ---------- 3. Form validation (optional) ----------
    document.getElementById('policy-form').addEventListener('submit', function (e) {
        if (!policyTypeSelect.value) {
            alert('Please select a valid Policy Type (must have a commission structure).');
            e.preventDefault();
        }
    });
</script>