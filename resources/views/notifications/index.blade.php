<?php
// notifications.php - Main notifications listing page

// Assumes header.php includes necessary HTML structure, title, and Tailwind CSS setup
include_once 'views/admin/partials/header.php';
?>

<main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Notification Management</h1>
                <p class="text-muted-foreground">View and manage system notifications</p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <div class="flex flex-row items-center justify-between">
                    <h3 class="tracking-tight text-sm font-medium">Total Notifications</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell h-4 w-4 text-blue-600">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                    </svg>
                </div>
                <div class="mt-2">
                    <div class="text-2xl font-bold"><?= $totalNotifications ?? 0 ?></div>
                    <p class="text-xs text-gray-500">All system notifications</p>
                </div>
            </div>

            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <div class="flex flex-row items-center justify-between">
                    <h3 class="tracking-tight text-sm font-medium">Unread Notifications</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-ring h-4 w-4 text-orange-600">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                        <path d="M18.02 10.02C18.47 7.42 20.98 6 22 6"></path>
                    </svg>
                </div>
                <div class="mt-2">
                    <div class="text-2xl font-bold"><?= $unreadNotifications ?? 0 ?></div>
                    <p class="text-xs text-gray-500"><?= $totalNotifications > 0 ? round(($unreadNotifications / $totalNotifications) * 100) : 0 ?>% unread</p>
                </div>
            </div>

            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <div class="flex flex-row items-center justify-between">
                    <h3 class="tracking-tight text-sm font-medium">Sent Notifications</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4 text-green-600">
                        <path d="m22 2-7 20-4-9-9-4 20-7Z"></path>
                        <path d="M15 7l-6 6"></path>
                    </svg>
                </div>
                <div class="mt-2">
                    <div class="text-2xl font-bold"><?= $sentNotifications ?? 0 ?></div>
                    <p class="text-xs text-gray-500">Total sent (email/SMS)</p>
                </div>
            </div>

            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <div class="flex flex-row items-center justify-between">
                    <h3 class="tracking-tight text-sm font-medium">Emails Sent</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail h-4 w-4 text-purple-600">
                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                    </svg>
                </div>
                <div class="mt-2">
                    <div class="text-2xl font-bold"><?= $emailSentNotifications ?? 0 ?></div>
                    <p class="text-xs text-gray-500">Notifications sent via email</p>
                </div>
            </div>
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

        <div class="flex items-center justify-between">
            <div class="flex flex-1 items-center space-x-2">
                <input type="text" id="notification-search" placeholder="Search notifications..."
                    class="flex h-10 w-[250px] rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    value="<?= htmlspecialchars($search) ?>">
                <form method="get" action="/admin/notifications" class="flex space-x-2">
                    <input type="hidden" name="search" id="hidden-search-input" value="<?= htmlspecialchars($search) ?>">

                    <select name="type" id="notification-type-filter"
                        class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[140px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <option value="">All Types</option>
                        <?php foreach ($notificationTypes as $nt): ?>
                            <option value="<?= htmlspecialchars($nt) ?>" <?= $type === $nt ? 'selected' : '' ?>>
                                <?= htmlspecialchars($nt) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="status" id="notification-status-filter"
                        class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[140px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <option value="">All Statuses</option>
                        <option value="read" <?= $status === 'read' ? 'selected' : '' ?>>Read</option>
                        <option value="unread" <?= $status === 'unread' ? 'selected' : '' ?>>Unread</option>
                        <option value="sent" <?= $status === 'sent' ? 'selected' : '' ?>>Sent</option>
                        <option value="unsent" <?= $status === 'unsent' ? 'selected' : '' ?>>Unsent</option>
                    </select>

                    <select name="priority" id="notification-priority-filter"
                        class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[140px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <option value="">All Priorities</option>
                        <option value="LOW" <?= $priority === 'LOW' ? 'selected' : '' ?>>Low</option>
                        <option value="MEDIUM" <?= $priority === 'MEDIUM' ? 'selected' : '' ?>>Medium</option>
                        <option value="HIGH" <?= $priority === 'HIGH' ? 'selected' : '' ?>>High</option>
                        <option value="URGENT" <?= $priority === 'URGENT' ? 'selected' : '' ?>>Urgent</option>
                    </select>

                    <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter mr-2 h-4 w-4">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="/admin/notifications" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                        Reset Filters
                    </a>
                </form>
            </div>
        </div>

        <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
            <div class="p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">All Notifications</h3>
                <p class="text-sm text-gray-500">A list of all notifications in the system.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title / Message</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Related Record</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($notifications)): ?>
                            <tr>
                                <td colspan="7" class="px-4 py-2.5 text-center text-gray-500">No notifications found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($notifications as $notification): ?>
                                <tr class="<?= $notification['is_read'] ? 'bg-white' : 'bg-blue-50 hover:bg-blue-100' ?>">
                                    <td class="px-4 py-2.5 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
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
                                    </td>
                                    <td class="px-4 py-2.5">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($notification['title']) ?></div>
                                        <div class="text-sm text-gray-500 truncate max-w-xs"><?= htmlspecialchars(substr($notification['message'], 0, 70)) ?><?= strlen($notification['message']) > 70 ? '...' : '' ?></div>
                                    </td>
                                    <td class="px-4 py-2.5 whitespace-nowrap">
                                        <?php if ($notification['target_user_id']): ?>
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($notification['target_user_name']) ?></div>
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($notification['target_user_email']) ?></div>
                                        <?php elseif ($notification['target_role_id']): ?>
                                            <div class="text-sm text-gray-900"><?= htmlspecialchars($notification['target_role_name']) ?> Role</div>
                                        <?php else: ?>
                                            <div class="text-sm text-gray-500">System Notification</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2.5 whitespace-nowrap">
                                        <?php if (!empty($notification['related_table'])): ?>
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars(ucfirst($notification['related_table'])) ?></div>
                                            <div class="text-sm text-gray-500">
                                                ID: <?= htmlspecialchars($notification['related_record_id']) ?>
                                                <?php if (!empty($notification['related_record_identifier'])): ?>
                                                    (<?= htmlspecialchars($notification['related_record_identifier']) ?>)
                                                <?php endif; ?>
                                                <?php if (!empty($notification['related_record_name'])): ?>
                                                    - <?= htmlspecialchars($notification['related_record_name']) ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-sm text-gray-500">N/A</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-2.5 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs font-medium">Read:</span>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $notification['is_read'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                                <?= $notification['is_read'] ? 'Yes' : 'No' ?>
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-xs font-medium">Sent:</span>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $notification['is_sent'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                                <?= $notification['is_sent'] ? 'Yes' : 'No' ?>
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-xs font-medium">Priority:</span>
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
                                        </div>
                                    </td>

                                    <td class="px-4 py-2.5 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" data-notification-id="<?= $notification['id'] ?>" id="view-notification-<?= $notification['id'] ?>"
                                            class="view-notification inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4 text-blue-500">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                        <?php if ($notification['send_email'] && $notification['is_sent']): // Only show resend if email sending is enabled and not yet sent 
                                        ?>
                                            <button title="Resend Notification via Email" type="button" data-notification-id="<?= $notification['id'] ?>" id="resend-email-<?= $notification['id'] ?>"
                                                onclick="return confirm('Are you sure you want to resend this notification via email?');"
                                                class="resend-email-btn inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium hover:bg-gray-100 h-9 rounded-md px-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4 text-green-500">
                                                    <path d="m22 2-7 20-4-9-9-4 20-7Z"></path>
                                                    <path d="M15 7l-6 6"></path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between px-6 py-3 border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="?controller=notifications&action=index&page=<?= max(1, $page - 1) ?>&type=<?= htmlspecialchars($type) ?>&status=<?= htmlspecialchars($status) ?>&search=<?= htmlspecialchars($search) ?>&priority=<?= htmlspecialchars($priority) ?>"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                    <a href="?controller=notifications&action=index&page=<?= min($totalPages, $page + 1) ?>&type=<?= htmlspecialchars($type) ?>&status=<?= htmlspecialchars($status) ?>&search=<?= htmlspecialchars($search) ?>&priority=<?= htmlspecialchars($priority) ?>"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span class="font-medium"><?= $offset + 1 ?></span> to <span class="font-medium"><?= min($offset + $perPage, $total) ?></span> of <span class="font-medium"><?= $total ?></span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <?php if ($page > 1): ?>
                                <a href="?controller=notifications&action=index&page=<?= $page - 1 ?>&type=<?= htmlspecialchars($type) ?>&status=<?= htmlspecialchars($status) ?>&search=<?= htmlspecialchars($search) ?>&priority=<?= htmlspecialchars($priority) ?>"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php
                            // Determine the range of pages to display
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);

                            if ($startPage > 1) {
                                echo '<a href="?controller=notifications&action=index&page=1&type=' . htmlspecialchars($type) . '&status=' . htmlspecialchars($status) . '&search=' . htmlspecialchars($search) . '&priority=' . htmlspecialchars($priority) . '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>';
                                if ($startPage > 2) {
                                    echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
                                }
                            }

                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <a href="?controller=notifications&action=index&page=<?= $i ?>&type=<?= htmlspecialchars($type) ?>&status=<?= htmlspecialchars($status) ?>&search=<?= htmlspecialchars($search) ?>&priority=<?= htmlspecialchars($priority) ?>"
                                    class="<?= $i === $page ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-700' ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium hover:bg-gray-50">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($endPage < $totalPages): ?>
                                <?php if ($endPage < $totalPages - 1): ?>
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                                <?php endif; ?>
                                <a href="?controller=notifications&action=index&page=<?= $totalPages ?>&type=<?= htmlspecialchars($type) ?>&status=<?= htmlspecialchars($status) ?>&search=<?= htmlspecialchars($search) ?>&priority=<?= htmlspecialchars($priority) ?>"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"><?= $totalPages ?></a>
                            <?php endif; ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="?controller=notifications&action=index&page=<?= $page + 1 ?>&type=<?= htmlspecialchars($type) ?>&status=<?= htmlspecialchars($status) ?>&search=<?= htmlspecialchars($search) ?>&priority=<?= htmlspecialchars($priority) ?>"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View notification Dialog -->
    <dialog id="viewNotificationDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="view-notification-content"></div>
        </div>
    </dialog>
</main>

<?php include_once 'views/admin/partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('notification-search');
        const hiddenSearchInput = document.getElementById('hidden-search-input');
        const filterForm = searchInput.closest('form'); // Get the parent form for submitting filters

        let searchTimeout;

        // Debounce search input
        searchInput.addEventListener('keyup', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                hiddenSearchInput.value = searchInput.value;
                filterForm.submit();
            }, 500); // Wait 500ms after user stops typing
        });

        // Add change listeners for dropdowns to auto-submit form
        document.getElementById('notification-type-filter').addEventListener('change', () => {
            filterForm.submit();
        });
        document.getElementById('notification-status-filter').addEventListener('change', () => {
            filterForm.submit();
        });
        document.getElementById('notification-priority-filter').addEventListener('change', () => {
            filterForm.submit();
        });
        // Open modal for viewing a notification
        const viewNotificationDialog = document.getElementById('viewNotificationDialog');
        const viewNotificationContent = document.getElementById('view-notification-content');
        const closeDialogButton = document.querySelector('.close-dialog');

        // Function to initialize tabs after content is loaded
        function initializeTabs() {
            // Global function to show tabs
            window.showTab = function(tabId) {
                const tabButtons = document.querySelectorAll('#viewNotificationDialog .tab-button');
                const tabContents = document.querySelectorAll('#viewNotificationDialog .tab-content');

                // Hide all tab contents within the dialog
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show the target tab
                const targetTab = document.getElementById(tabId);
                if (targetTab) {
                    targetTab.classList.remove('hidden');
                }

                // Find and activate the target button
                const targetButton = document.querySelector(`#viewNotificationDialog [onclick="showTab('${tabId}')"]`);
                if (targetButton) {
                    targetButton.classList.add('active', 'border-blue-500', 'text-blue-600');
                    targetButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                }

                // Highlight only the clicked button
                tabButtons.forEach(button => {
                    const buttonTabId = button.getAttribute('onclick')?.match(/'([^']+)'/)?.[1];
                    if (buttonTabId === tabId) {
                        button.classList.add('active', 'border-blue-500', 'text-blue-600');
                        button.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    } else {
                        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                        button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    }
                });
            };

            // Use event delegation for tab clicks
            const notificationTabs = document.querySelector('#viewNotificationDialog #notificationTabs');
            if (notificationTabs) {
                // Remove any existing listeners to avoid duplicates
                notificationTabs.replaceWith(notificationTabs.cloneNode(true));
                const newNotificationTabs = document.querySelector('#viewNotificationDialog #notificationTabs');

                newNotificationTabs.addEventListener('click', (e) => {
                    if (e.target.classList.contains('tab-button')) {
                        const tabId = e.target.getAttribute('onclick')?.match(/'([^']+)'/)?.[1];
                        if (tabId) {
                            window.showTab(tabId);
                        }
                    }
                });
            }

            // Initialize the first tab as active
            const firstTab = document.querySelector('#viewNotificationDialog .tab-button.active');
            if (firstTab) {
                const initialTabId = firstTab.getAttribute('onclick')?.match(/'([^']+)'/)?.[1];
                if (initialTabId) {
                    window.showTab(initialTabId);
                }
            } else if (tabButtons.length > 0) {
                // If no tab is marked as active, activate the first one
                const firstTabId = tabButtons[0].getAttribute('onclick')?.match(/'([^']+)'/)?.[1];
                if (firstTabId) {
                    window.showTab(firstTabId);
                }
            }
        }

        document.querySelectorAll('.view-notification').forEach(button => {
            button.addEventListener('click', () => {
                const notificationId = button.getAttribute('data-notification-id');
                fetch(`/admin/notifications/${notificationId}`)
                    .then(response => response.text())
                    .then(data => {
                        viewNotificationContent.innerHTML = data;
                        viewNotificationDialog.showModal();

                        // Initialize tabs AFTER content is loaded
                        setTimeout(() => {
                            initializeTabs();
                        }, 50); // Small delay to ensure DOM is updated
                    })
                    .catch(error => {
                        console.error('Error loading notification:', error);
                    });
            });
        });

        closeDialogButton.addEventListener('click', () => {
            viewNotificationDialog.close();
        });
    });
</script>