<div class="rounded-lg border border-gray-300 bg-white shadow-sm">
    <div class="flex justify-between pr-4">

        <div class="p-6">
            <h3 class="text-2xl font-semibold leading-none tracking-tight">Policy Types</h3>
            <p class="text-sm text-gray-500">Overview of available policy types and their policy counts</p>
        </div>

        <div class="mt-4 text-right">
            <button id="openCreatePolicyTypeDialog" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle mr-2 h-4 w-4">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 8v8"></path>
                    <path d="M8 12h8"></path>
                </svg>
                Add Policy Type
            </button>
        </div>
    </div>
    <div class="p-6 pt-0">
        <div class="relative w-full overflow-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-300">
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy Type Name</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Total Policies</th>
                        <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($policyTypes)): ?>
                        <?php foreach ($policyTypes as $type): ?>
                            <tr class="border-b border-gray-300 hover:bg-gray-50">
                                <td class="p-4 align-middle font-medium"><?= htmlspecialchars($type->type_name) ?></td>
                                <td class="p-4 align-middle"><?= htmlspecialchars($type->policy_count) ?></td>
                                <td class="p-4 align-middle">
                                    <div class="flex items-center space-x-2">
                                        <button class="open-edit-policy-type-dialog inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3" data-policy-type-id="<?= $type->id ?? '' ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen h-4 w-4">
                                                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.375 2.625a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4Z"></path>
                                            </svg>
                                        </button>
                                        <button class="delete-policy-type-button inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3" data-policy-type-id="<?= $type->id ?? '' ?>">
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
                            <td colspan="3" class="p-4 text-center text-gray-500">No policy types found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>