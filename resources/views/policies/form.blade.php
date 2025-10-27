<?php
$isEdit = isset($policy) && $policy !== null;
$formAction = $isEdit ? route('policies.update', $policy->id) : route('policies.store');
$formMethod = $isEdit ? 'PUT' : 'POST';
?>

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">
        {{ $isEdit ? 'Edit Policy' : 'Add New Policy' }}
    </h3>

    <form id="policy-form" action="{{ $formAction }}" method="POST" class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        @csrf
        @if($isEdit)
        @method('PUT')
        @endif

        @if ($isEdit)
        <input type="hidden" name="id" value="{{ $policy->id }}">
        @endif

        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
            <select id="client_id" name="client_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                <option value="">Select Client</option>
                @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{ ($policy->client_id ?? '') == $client->id ? 'selected' : '' }}>
                    {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                </option>
                @endforeach
            </select>
            @error('client_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="company_id" class="block text-sm font-medium text-gray-700">Insurance Company</label>
                <select id="company_id" name="company_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ ($policy->company_id ?? '') == $company->id ? 'selected' : '' }}>
                        {{ $company->company_name }}
                    </option>
                    @endforeach
                </select>
                @error('company_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="policy_type_id" class="block text-sm font-medium text-gray-700">Policy Type</label>
                <select id="policy_type_id" name="policy_type_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Policy Type</option>
                    @foreach ($policyTypes as $type)
                    <option value="{{ $type->id }}" {{ ($policy->policy_type_id ?? '') == $type->id ? 'selected' : '' }}>
                        {{ $type->type_name }}
                    </option>
                    @endforeach
                </select>
                @error('policy_type_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="agent_id" class="block text-sm font-medium text-gray-700">Assigned Agent</label>
            <select id="agent_id" name="agent_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                <option value="">Select Agent</option>
                @foreach ($agents as $agent)
                <option value="{{ $agent->id }}" {{ ($policy->agent_id ?? '') == $agent->id ? 'selected' : '' }}>
                    {{ $agent->full_name }}
                </option>
                @endforeach
            </select>
            @error('agent_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                <input type="date" id="issue_date" name="issue_date" value="{{ $policy->issue_date ?? date('Y-m-d') }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                @error('issue_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="effective_date" class="block text-sm font-medium text-gray-700">Effective Date</label>
                <input type="date" id="effective_date" name="effective_date" value="{{ $policy->effective_date ?? date('Y-m-d') }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                @error('effective_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" value="{{ $policy->expiry_date ?? date('Y-m-d', strtotime('+1 year')) }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                @error('expiry_date')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="premium_amount" class="block text-sm font-medium text-gray-700">Premium Amount (KES)</label>
                <input type="number" step="0.01" id="premium_amount" name="premium_amount" value="{{ $policy->premium_amount ?? '' }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                @error('premium_amount')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="sum_insured" class="block text-sm font-medium text-gray-700">Sum Insured (KES)</label>
                <input type="number" step="0.01" id="sum_insured" name="sum_insured" value="{{ $policy->sum_insured ?? '' }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                @error('sum_insured')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="payment_frequency" class="block text-sm font-medium text-gray-700">Payment Frequency</label>
                <select id="payment_frequency" name="payment_frequency" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Frequency</option>
                    <option value="MONTHLY" {{ ($policy->payment_frequency ?? '') == 'MONTHLY' ? 'selected' : '' }}>Monthly</option>
                    <option value="QUARTERLY" {{ ($policy->payment_frequency ?? '') == 'QUARTERLY' ? 'selected' : '' }}>Quarterly</option>
                    <option value="SEMI_ANNUAL" {{ ($policy->payment_frequency ?? '') == 'SEMI_ANNUAL' ? 'selected' : '' }}>Semi-Annual</option>
                    <option value="ANNUAL" {{ ($policy->payment_frequency ?? '') == 'ANNUAL' ? 'selected' : '' }}>Annual</option>
                </select>
                @error('payment_frequency')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <select id="payment_method" name="payment_method" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Method</option>
                    <option value="CASH" {{ ($policy->payment_method ?? '') == 'CASH' ? 'selected' : '' }}>Cash</option>
                    <option value="CHEQUE" {{ ($policy->payment_method ?? '') == 'CHEQUE' ? 'selected' : '' }}>Cheque</option>
                    <option value="BANK_TRANSFER" {{ ($policy->payment_method ?? '') == 'BANK_TRANSFER' ? 'selected' : '' }}>Bank Transfer</option>
                    <option value="MOBILE_MONEY" {{ ($policy->payment_method ?? '') == 'MOBILE_MONEY' ? 'selected' : '' }}>Mobile Money</option>
                    <option value="CARD" {{ ($policy->payment_method ?? '') == 'CARD' ? 'selected' : '' }}>Card</option>
                </select>
                @error('payment_method')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="policy_status" class="block text-sm font-medium text-gray-700">Policy Status</label>
            <select id="policy_status" name="policy_status" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                <option value="">Select Status</option>
                <option value="PENDING" {{ ($policy->policy_status ?? '') == 'PENDING' ? 'selected' : '' }}>Pending</option>
                <option value="ACTIVE" {{ ($policy->policy_status ?? '') == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                <option value="EXPIRED" {{ ($policy->policy_status ?? '') == 'EXPIRED' ? 'selected' : '' }}>Expired</option>
                <option value="CANCELLED" {{ ($policy->policy_status ?? '') == 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                <option value="SUSPENDED" {{ ($policy->policy_status ?? '') == 'SUSPENDED' ? 'selected' : '' }}>Suspended</option>
            </select>
            @error('policy_status')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea id="notes" name="notes" rows="3" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">{{ $policy->notes ?? '' }}</textarea>
            @error('notes')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('policies.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $isEdit ? 'Update Policy' : 'Create Policy' }}
            </button>
        </div>
    </form>
</section>