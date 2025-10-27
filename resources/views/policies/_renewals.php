<div class="rounded-lg border border-gray-300 bg-white shadow-sm">
    <div class="p-6">
        <h3 class="text-2xl font-semibold leading-none tracking-tight">Policies for Renewal</h3>
        <p class="text-sm text-gray-500">Policies that are due for renewal or have recently expired</p>
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
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Days Left / Overdue</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($renewals)): ?>
                        <?php foreach ($renewals as $policy): ?>
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
                                        $days = (int)$interval->format('%r%a'); // %r for sign, %a for total days

                                        if ($days > 0) {
                                            echo $days . ' days left';
                                        } elseif ($days < 0) {
                                            echo abs($days) . ' days overdue';
                                        } else {
                                            echo 'Ends today';
                                        }
                                    ?>
                                </td>
                                <td class="p-4 align-middle">
                                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold 
                                        <?php 
                                            switch ($policy->status) {
                                                case 'ACTIVE': echo 'bg-green-100 text-green-800'; break;
                                                case 'EXPIRED': echo 'bg-red-100 text-red-800'; break;
                                                case 'PENDING': echo 'bg-yellow-100 text-yellow-800'; break;
                                                case 'RENEWED': echo 'bg-blue-100 text-blue-800'; break; // Assuming a 'RENEWED' status
                                                default: echo 'bg-gray-100 text-gray-800'; break;
                                            }
                                        ?>">
                                        <?= htmlspecialchars($policy->status) ?>
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
                            <td colspan="8" class="p-4 text-center text-gray-500">No policies due for renewal or recently expired</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>