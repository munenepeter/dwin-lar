<div class="rounded-lg border border-gray-300 bg-white shadow-sm">
    <div class="p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">Policies Expiring Soon</h3>
        <p class="text-sm text-gray-500">Policies that are expiring within the next 30 days</p>
    </div>
    <div class="p-6 pt-0">
        <div class="relative w-full overflow-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Number</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Client</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Company</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Type</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">End Date</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Days Remaining</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($expiringSoon)): ?>
                        <?php foreach ($expiringSoon as $policy): ?>
                            <tr class="border-b border-gray-300 hover:bg-gray-50">
                                <td class="p-4 align-middle font-medium"><?= htmlspecialchars($policy->policy_number) ?></td>
                                <td class="p-4 align-middle"><?= htmlspecialchars($policy->first_name . ' ' . $policy->last_name) ?></td>
                                <td class="p-4 align-middle"><?= htmlspecialchars($policy->company_name) ?></td>
                                <td class="p-4 align-middle"><?= htmlspecialchars($policy->policy_type_name) ?></td>
                                <td class="p-4 align-middle"><?= date('M d, Y', strtotime($policy->end_date)) ?></td>
                                <td class="p-4 align-middle">
                                    <?php 
                                        $now = new DateTime();
                                        $endDate = new DateTime($policy->end_date);
                                        $interval = $now->diff($endDate);
                                        echo $interval->days . ' days';
                                    ?>
                                </td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center space-x-2">
                                        <button class="open-view-policy-dialog inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3" data-policy-id="<?= $policy->id ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                        <button class="renew-policy-button inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium bg-blue-500 hover:bg-blue-600 text-white h-9 rounded-md px-3" data-policy-id="<?= $policy->id ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw h-4 w-4">
                                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.76 2.75M3 12v1H2M12 21v-1H21"></path>
                                                <path d="M7 16l-3-3 3-3"></path>
                                            </svg>
                                            Renew
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">No policies expiring soon</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>