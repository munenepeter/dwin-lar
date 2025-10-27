<div id="user-activity-content" class="rounded-lg border border-gray-300 bg-white shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="text-2xl font-semibold leading-none tracking-tight">User Activity</h3>
            <p class="text-sm text-gray-500">View user login history and activities</p>
        </div>
        <div class="flex items-center space-x-2">
            <select id="activityFilter"
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="all">All Activity</option>
                <option value="login">Logins</option>
                <option value="changes">Profile Changes</option>
                <option value="notifications">Notifications</option>
            </select>

            <select id="userFilter"
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="all">All Users</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ ucwords($user->first_name . ' ' . $user->last_name) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-300">
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">User</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Activity Type</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Details</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Date/Time</th>
                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginated as $activity)
                <tr class="border-b border-gray-300 hover:bg-gray-50">
                    <td class="p-4 align-middle font-medium">{{ $activity->user_name }}</td>
                    <td class="p-4 align-middle">
                        @if ($activity->notification_type)
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                            Notification
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                            {{ ucfirst($activity->action_type) }}
                        </span>
                        @endif
                    </td>
                    <td class="p-4 align-middle">
                        @if ($activity->notification_type)
                        {{ ucfirst(str_replace('_', ' ', $activity->notification_type)) }}
                        @else
                        {{ ucfirst($activity->action_type) }} on {{ $activity->table_name }}
                        @endif
                    </td>
                    <td class="p-4 align-middle text-gray-500">
                        {{ \Carbon\Carbon::parse($activity->created_at)->format('M j, Y g:i A') }}
                    </td>
                    <td class="p-4 align-middle">
                        @if (!is_null($activity->is_read))
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold
                    {{ $activity->is_read ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $activity->is_read ? 'Read' : 'Unread' }}
                        </span>
                        @else
                        <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800">
                            Completed
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex items-center justify-between">
        <div class="text-sm text-gray-500">
            Showing {{ $paginated->firstItem() }} to {{ $paginated->lastItem() }} of {{ $paginated->total() }} activities
        </div>
        <div>
            {{ $paginated->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    const activityFilter = document.getElementById('activityFilter');
    const userFilter = document.getElementById('userFilter');

    function applyFilters() {
        const type = activityFilter.value;
        const uid = userFilter.value;

        // In a real app you would send these to the server via GET/POST
        // and reload the tab content. Example:
        const url = new URL(window.location);
        url.searchParams.set('tab', 'user-activity');
        url.searchParams.set('activity_type', type);
        url.searchParams.set('user_id', uid);
        window.history.replaceState({}, '', url);

        // Trigger tab reload (your main JS already handles ?tab=…)
        document.querySelector('[data-tab="user-activity"]').click();
    }

    activityFilter.addEventListener('change', applyFilters);
    userFilter.addEventListener('change', applyFilters);
</script>