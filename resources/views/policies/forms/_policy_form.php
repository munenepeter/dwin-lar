<?php
$isEdit = isset($policy) && $policy !== null;
$formAction = $isEdit ? '/admin/policies/edit/' . $policy->id : '/admin/policies/storePolicy';
$dialogTitle = $isEdit ? 'Edit Policy' : 'Add New Policy';



// Default values for new policy
$policy = $policy ?? (object)[
    'id' => '',
    'client_id' => '',
    'company_id' => '',
    'policy_type_id' => '',
    'agent_id' => '',
    'premium_amount' => '',
    'sum_insured' => '',
    'issue_date' => date('Y-m-d'),
    'effective_date' => date('Y-m-d'),
    'expiry_date' => date('Y-m-d', strtotime('+1 year')),
    'payment_frequency' => 'ANNUAL',
    'payment_method' => 'CASH',
    'policy_status' => 'PENDING',
    'coverage_details' => '',
    'notes' => ''
];

$coverageDetails = $isEdit && $policy->coverage_details ? json_decode($policy->coverage_details, true) : [];
?>

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4"><?= $dialogTitle ?></h3>
    <form id="policy-form" action="<?= $formAction ?>" method="POST" class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($policy->id) ?>">
        <?php endif; ?>
        <input type="hidden" name="signature" value="<?= md5(uniqid($policy->id ?? "NEW")) ?>">

        <div>
            <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
            <select id="client_id" name="client_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                <option value="">Select Client</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= htmlspecialchars($client->id) ?>" <?= ($policy->client_id == $client->id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($client->first_name . ' ' . $client->last_name) ?> (<?= htmlspecialchars($client->email) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="company_id" class="block text-sm font-medium text-gray-700">Insurance Company</label>
                <select id="company_id" name="company_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Company</option>
                    <?php foreach ($companies as $company): ?>
                        <option value="<?= htmlspecialchars($company->id) ?>" <?= ($policy->company_id == $company->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($company->company_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="policy_type_id" class="block text-sm font-medium text-gray-700">Policy Type</label>
                <select id="policy_type_id" name="policy_type_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Policy Type</option>
                    <?php foreach ($policyTypes as $type): ?>
                        <option value="<?= htmlspecialchars($type->id) ?>" <?= ($policy->policy_type_id == $type->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($type->type_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div>
            <label for="agent_id" class="block text-sm font-medium text-gray-700">Assigned Agent</label>
            <select id="agent_id" name="agent_id" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                <option value="">Select Agent</option>
                <?php foreach ($agents as $agent): ?>
                    <option value="<?= htmlspecialchars($agent->id) ?>" <?= ($policy->agent_id == $agent->id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($agent->full_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                <input type="date" id="issue_date" name="issue_date" value="<?= htmlspecialchars($policy->issue_date) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
            <div>
                <label for="effective_date" class="block text-sm font-medium text-gray-700">Effective Date</label>
                <input type="date" id="effective_date" name="effective_date" value="<?= htmlspecialchars($policy->effective_date) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
            <div>
                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" value="<?= htmlspecialchars($policy->expiry_date) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="premium_amount" class="block text-sm font-medium text-gray-700">Premium Amount (KES)</label>
                <input type="number" step="0.01" id="premium_amount" name="premium_amount" value="<?= htmlspecialchars($policy->premium_amount) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
            <div>
                <label for="sum_insured" class="block text-sm font-medium text-gray-700">Sum Insured (KES)</label>
                <input type="number" step="0.01" id="sum_insured" name="sum_insured" value="<?= htmlspecialchars($policy->sum_insured) ?>" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="payment_frequency" class="block text-sm font-medium text-gray-700">Payment Frequency</label>
                <select id="payment_frequency" name="payment_frequency" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Frequency</option>
                    <option value="MONTHLY" <?= ($policy->payment_frequency == 'MONTHLY') ? 'selected' : '' ?>>Monthly</option>
                    <option value="QUARTERLY" <?= ($policy->payment_frequency == 'QUARTERLY') ? 'selected' : '' ?>>Quarterly</option>
                    <option value="SEMI_ANNUAL" <?= ($policy->payment_frequency == 'SEMI_ANNUAL') ? 'selected' : '' ?>>Semi-Annual</option>
                    <option value="ANNUAL" <?= ($policy->payment_frequency == 'ANNUAL') ? 'selected' : '' ?>>Annual</option>
                </select>
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <select id="payment_method" name="payment_method" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                    <option value="">Select Method</option>
                    <option value="CASH" <?= ($policy->payment_method == 'CASH') ? 'selected' : '' ?>>Cash</option>
                    <option value="CHEQUE" <?= ($policy->payment_method == 'CHEQUE') ? 'selected' : '' ?>>Cheque</option>
                    <option value="BANK_TRANSFER" <?= ($policy->payment_method == 'BANK_TRANSFER') ? 'selected' : '' ?>>Bank Transfer</option>
                    <option value="MOBILE_MONEY" <?= ($policy->payment_method == 'MOBILE_MONEY') ? 'selected' : '' ?>>Mobile Money</option>
                    <option value="CARD" <?= ($policy->payment_method == 'CARD') ? 'selected' : '' ?>>Card</option>
                </select>
            </div>
        </div>

        <div>
            <label for="policy_status" class="block text-sm font-medium text-gray-700">Policy Status</label>
            <select id="policy_status" name="policy_status" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5" required>
                <option value="">Select Status</option>
                <option value="PENDING" <?= ($policy->policy_status == 'PENDING') ? 'selected' : '' ?>>Pending</option>
                <option value="ACTIVE" <?= ($policy->policy_status == 'ACTIVE') ? 'selected' : '' ?>>Active</option>
                <option value="EXPIRED" <?= ($policy->policy_status == 'EXPIRED') ? 'selected' : '' ?>>Expired</option>
                <option value="CANCELLED" <?= ($policy->policy_status == 'CANCELLED') ? 'selected' : '' ?>>Cancelled</option>
                <option value="SUSPENDED" <?= ($policy->policy_status == 'SUSPENDED') ? 'selected' : '' ?>>Suspended</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Coverage Details</label>
            <div id="coverage-details-container" class="space-y-4">
                <!-- Dynamic entries will be added here -->
            </div>
            <button type="button" id="add-coverage-detail" class="mt-2 inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 text-sm">
                Add Coverage Detail
            </button>
            <input type="hidden" name="coverage_details" id="coverage_details_hidden">
            <p class="text-xs text-gray-500 mt-1">Add coverage details for the policy (optional)</p>
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea id="notes" name="notes" rows="3" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"><?= htmlspecialchars($policy->notes ?? '') ?></textarea>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <?= $isEdit ? 'Update Policy' : 'Create Policy' ?>
            </button>
        </div>
    </form>
</section>