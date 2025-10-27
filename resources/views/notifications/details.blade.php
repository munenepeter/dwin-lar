<?php

if (!isset($notification) || empty($notification)) {
    echo '<div class="container mx-auto px-4 py-6 text-red-700">Notification not found.</div>';
    include_once 'views/admin/partials/footer.php';
    exit;
}
?>

<main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <div class="pb-6">
        <h1 class="text-2xl font-bold tracking-tight">Notification Details</h1>
        <p class="text-muted-foreground">Detailed view of notification ID: <?= htmlspecialchars($notification['id']) ?></p>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($_SESSION['success_message']);
                                            unset($_SESSION['success_message']); ?></span>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($_SESSION['error_message']);
                                            unset($_SESSION['error_message']); ?></span>
        </div>
    <?php endif; ?>

    <div class="rounded-lg border border-gray-300 bg-white shadow-sm overflow-hidden min-w-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($notification['title']) ?></h2>
                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                        <?php
                        switch ($notification['notification_type']) {
                            case 'POLICY_EXPIRY':
                                echo 'bg-red-100 text-red-800';
                                break;
                            case 'RENEWAL_DUE':
                                echo 'bg-yellow-100 text-yellow-800';
                                break;
                            case 'SYSTEM_ALERT':
                                echo 'bg-purple-100 text-purple-800';
                                break;
                            default:
                                echo 'bg-green-100 text-green-800';
                                break;
                        }
                        ?>">
                    <?= htmlspecialchars($notification['notification_type']) ?>
                </span>
            </div>
            <p class="text-gray-700 mb-4"><?= nl2br(htmlspecialchars($notification['message'])) ?></p>

            <div class="text-sm text-gray-500 mb-6">
                Created on <?= date('M j, Y H:i', strtotime($notification['created_at'])) ?>
                <?php if ($notification['updated_at'] && $notification['created_at'] != $notification['updated_at']): ?>
                    (Last updated: <?= date('M j, Y H:i', strtotime($notification['updated_at'])) ?>)
                <?php endif; ?>
            </div>

            <div class="border-b border-gray-200">
                <nav class="flex -mb-px" id="notificationTabs">
                    <button onclick="showTab('details-tab')" data-tab="details" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm active border-blue-500 text-blue-600 focus:outline-none">Notification Details</button>
                    <button onclick="showTab('related-tab')" data-tab="related" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none">Related Information</button>
                    <button onclick="showTab('audit-tab')" data-tab="audit" class="tab-button py-4 px-6 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none">Audit Log</button>
                </nav>
            </div>

            <div id="details-tab" class="tab-content p-6 border-t border-gray-200 active">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Recipient</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            <?php if ($notification['target_user_id']): ?>
                                <?= htmlspecialchars($notification['target_user_name']) ?> (<?= htmlspecialchars($notification['target_user_email']) ?>)
                            <?php elseif ($notification['target_role_id']): ?>
                                All <?= htmlspecialchars($notification['target_role_name']) ?> users
                            <?php else: ?>
                                System notification
                            <?php endif; ?>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Priority</h3>
                        <p class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    <?php
                                    switch ($notification['priority']) {
                                        case 'HIGH':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        case 'URGENT':
                                            echo 'bg-red-200 text-red-900';
                                            break;
                                        case 'MEDIUM':
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                            break;
                                    }
                                    ?>">
                                <?= htmlspecialchars($notification['priority']) ?>
                            </span>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Status</h3>
                        <div class="mt-1 space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-medium">Read:</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $notification['is_read'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $notification['is_read'] ? 'Yes' : 'No' ?>
                                </span>
                                <?php if ($notification['is_read'] && $notification['read_at']): ?>
                                    <span class="text-xs text-gray-500">(<?= date('M j, Y H:i', strtotime($notification['read_at'])) ?>)</span>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-xs font-medium">Sent:</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $notification['is_sent'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $notification['is_sent'] ? 'Yes' : 'No' ?>
                                </span>
                                <?php if ($notification['is_sent'] && $notification['email_sent_at']): ?>
                                    <span class="text-xs text-gray-500">(Email: <?= date('M j, Y H:i', strtotime($notification['email_sent_at'])) ?>)</span>
                                <?php endif; ?>
                                <?php if ($notification['is_sent'] && $notification['sms_sent_at']): ?>
                                    <span class="text-xs text-gray-500">(SMS: <?= date('M j, Y H:i', strtotime($notification['sms_sent_at'])) ?>)</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Sending Options</h3>
                        <div class="mt-1 space-y-1">
                            <p class="text-sm text-gray-900">Send Email: <?= $notification['send_email'] ? 'Yes' : 'No' ?></p>
                            <p class="text-sm text-gray-900">Send SMS: <?= $notification['send_sms'] ? 'Yes' : 'No' ?></p>
                        </div>
                    </div>
                    <?php if ($notification['expires_at']): ?>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Expires At</h3>
                            <p class="mt-1 text-sm text-gray-900"><?= date('M j, Y H:i', strtotime($notification['expires_at'])) ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="md:col-span-2 flex justify-end space-x-3 mt-4">
                        <?php if ($notification['send_email'] && !$notification['is_sent']): ?>
                            <a href="index.php?controller=notifications&action=resendEmail&id=<?= $notification['id'] ?>"
                                onclick="return confirm('Are you sure you want to resend this notification via email?');"
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-green-500 hover:bg-green-600 text-white h-9 px-4 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4">
                                    <path d="m22 2-7 20-4-9-9-4 20-7Z"></path>
                                    <path d="M15 7l-6 6"></path>
                                </svg>
                                Resend Email
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div id="related-tab" class="tab-content p-6 border-t border-gray-200 hidden">
                <?php if (!empty($notification['related_table']) && !empty($notification['related_record_id']) && !empty($relatedRecords)): ?>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Related <?= htmlspecialchars(ucfirst($notification['related_table'])) ?> Details</h3>
                    <div class="overflow-x-auto">
                        <?php if ($notification['related_table'] === 'policies'): ?>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($relatedRecords['policy_number'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($notification['related_record_name'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['company_id'] ?? 'N/A') // Would need join in controller for company name 
                                                                                                        ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['policy_type_id'] ?? 'N/A') // Would need join in controller for policy type name 
                                                                                                        ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    <?php
                                                    $policyStatus = $relatedRecords['policy_status'] ?? '';
                                                    if ($policyStatus === 'ACTIVE') echo 'bg-green-100 text-green-800';
                                                    elseif ($policyStatus === 'EXPIRED') echo 'bg-red-100 text-red-800';
                                                    else echo 'bg-gray-100 text-gray-800';
                                                    ?>">
                                                <?= htmlspecialchars($policyStatus) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['expiry_date'] ? date('M j, Y', strtotime($relatedRecords['expiry_date'])) : 'N/A') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php elseif ($notification['related_table'] === 'clients'): ?>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client Code</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KYC Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($relatedRecords['client_code'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['full_name'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['email'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['phone_primary'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    <?php
                                                    $clientStatus = $relatedRecords['client_status'] ?? '';
                                                    if ($clientStatus === 'ACTIVE') echo 'bg-green-100 text-green-800';
                                                    elseif ($clientStatus === 'INACTIVE') echo 'bg-red-100 text-red-800';
                                                    else echo 'bg-gray-100 text-gray-800';
                                                    ?>">
                                                <?= htmlspecialchars($clientStatus) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    <?php
                                                    $kycStatus = $relatedRecords['kyc_status'] ?? '';
                                                    if ($kycStatus === 'VERIFIED') echo 'bg-green-100 text-green-800';
                                                    elseif ($kycStatus === 'PENDING') echo 'bg-yellow-100 text-yellow-800';
                                                    else echo 'bg-red-100 text-red-800';
                                                    ?>">
                                                <?= htmlspecialchars($kycStatus) ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php elseif ($notification['related_table'] === 'users'): ?>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($relatedRecords['username'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['full_name'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($relatedRecords['email'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($notification['target_role_name'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    <?= ($relatedRecords['is_active'] ?? false) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                                <?= ($relatedRecords['is_active'] ?? false) ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-gray-500">No specific details available for this related table type (<?= htmlspecialchars($notification['related_table']) ?>).</p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No related record information available for this notification.</p>
                <?php endif; ?>
            </div>

            <div id="audit-tab" class="tab-content p-6 border-t border-gray-200 hidden">
                <?php if (!empty($auditLog)): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($auditLog as $logEntry): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($logEntry['created_at']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($logEntry['action_type']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($logEntry['user_id'] ?? 'N/A') ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <pre class="whitespace-pre-wrap text-xs bg-gray-50 p-2 rounded"><?= htmlspecialchars(json_encode(json_decode($logEntry['new_values'], true), JSON_PRETTY_PRINT)) ?></pre>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No audit log entries for this notification.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
</main>