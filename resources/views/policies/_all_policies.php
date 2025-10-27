<div class="rounded-lg border border-gray-300 bg-white shadow-sm">
    <div class="p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">All Policies</h3>
        <p class="text-sm text-gray-500">Comprehensive list of all insurance policies</p>
    </div>
    <div class="p-6 pt-0">
        <div class="relative w-full overflow-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Number</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Client</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Company</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Start Date</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">End Date</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Premium</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($allPolicies)): ?>
                        <?php foreach ($allPolicies as $policy): ?>
                            <tr class="border-b border-gray-300 hover:bg-gray-50">
                                <td class="p-4 align-middle font-medium"><?= htmlspecialchars($policy->policy_number) ?>
                                    <br>
                                    <span class="text-xs text-gray-400"><?= htmlspecialchars($policy->type_name) ?></span>
                                </td>
                                <td class="p-4 align-middle"><?= htmlspecialchars($policy->first_name . ' ' . $policy->last_name) ?></td>
                                <td class="p-4 align-middle"><?= htmlspecialchars($policy->company_name) ?></td>
                                <td class="p-4 align-middle"><?= date('M d, Y', strtotime($policy->effective_date)) ?></td>
                                <td class="p-4 align-middle"><?= date('M d, Y', strtotime($policy->expiry_date)) ?></td>
                                <td class="p-4 align-middle">KES <?= number_format($policy->premium_amount, 2) ?></td>
                                <td class="p-4 align-middle">
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold 
                                        <?php
                                        switch ($policy->policy_status) {
                                            case 'ACTIVE':
                                                echo 'bg-green-100 text-green-800';
                                                break;
                                            case 'EXPIRED':
                                                echo 'bg-red-100 text-red-800';
                                                break;
                                            case 'PENDING':
                                                echo 'bg-yellow-100 text-yellow-800';
                                                break;
                                            default:
                                                echo 'bg-gray-100 text-gray-800';
                                                break;
                                        }
                                        ?>">
                                        <?= htmlspecialchars($policy->policy_status) ?>
                                    </span>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center space-x-2">
                                        <button class="open-view-policy-dialog inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3" data-policy-id="<?= $policy->id ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                        <button class="open-edit-policy-dialog inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3" data-policy-id="<?= $policy->id ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen h-4 w-4">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"></path>
                                            </svg>
                                        </button>
                                        <button class="delete-policy-button inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3" data-policy-id="<?= $policy->id ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2 h-4 w-4 text-red-500">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                                <line x1="14" x2="14" y1="11" y2="17"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">No policies found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>