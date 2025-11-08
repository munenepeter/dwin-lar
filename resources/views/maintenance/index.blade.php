<x-layouts.app>

<div class="container-fluid px-4 py-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">System Maintenance</h1>
        <p class="text-gray-600 mt-1">Manage backups, optimize system performance, and monitor health</p>
    </div>

    <!-- System Health Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Database Size -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded">Database</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Database Size</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $systemInfo['database_size'] }} MB</p>
        </div>

        <!-- Storage Size -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-1 rounded">Storage</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Storage Used</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $systemInfo['storage_size'] }} MB</p>
        </div>

        <!-- Cache Size -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">Cache</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Cache Size</h3>
            <p class="text-2xl font-bold text-gray-900">{{ $systemInfo['cache_size'] }} MB</p>
        </div>

        <!-- Last Backup -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-1 rounded">Backup</span>
            </div>
            <h3 class="text-gray-600 text-sm font-medium mb-1">Last Backup</h3>
            <p class="text-lg font-bold text-gray-900">{{ $systemInfo['last_backup'] }}</p>
        </div>
    </div>

    <!-- System Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- System Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">System Information</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">PHP Version</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $systemInfo['php_version'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Laravel Version</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $systemInfo['laravel_version'] }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Environment</span>
                        <span class="text-sm font-semibold px-2 py-1 bg-green-100 text-green-800 rounded">{{ config('app.env') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-600">Debug Mode</span>
                        <span class="text-sm font-semibold text-gray-900">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-medium text-gray-600">Timezone</span>
                        <span class="text-sm font-semibold text-gray-900">{{ config('app.timezone') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6 space-y-3">
                <!-- Backup Database -->
                <button onclick="runBackup()" id="backupBtn" class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-gray-900">Backup Database</p>
                            <p class="text-sm text-gray-500">Create a full database backup</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Optimize System -->
                <button onclick="optimizeSystem()" id="optimizeBtn" class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-gray-900">Optimize System</p>
                            <p class="text-sm text-gray-500">Clear cache and optimize performance</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Clear Cache -->
                <button onclick="clearCache()" class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-gray-900">Clear Cache</p>
                            <p class="text-sm text-gray-500">Remove all cached data</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Run Migrations -->
                <button onclick="runMigrations()" class="w-full flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-gray-900">Run Migrations</p>
                            <p class="text-sm text-gray-500">Update database schema</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Maintenance Schedule -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Maintenance Schedule</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Run</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Run</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Database Backup</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Daily</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ now()->subDay()->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ now()->format('Y-m-d') }} 02:00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Cache Optimization</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Weekly</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ now()->subWeek()->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ now()->addWeek()->format('Y-m-d') }} 03:00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Log Cleanup</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Monthly</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ now()->subMonth()->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ now()->addMonth()->format('Y-m-d') }} 04:00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="hidden fixed bottom-4 right-4 bg-white border border-gray-200 rounded-lg shadow-lg p-4 max-w-sm z-50">
    <div class="flex items-start">
        <div id="toastIcon" class="flex-shrink-0"></div>
        <div class="ml-3 w-0 flex-1">
            <p id="toastTitle" class="text-sm font-medium text-gray-900"></p>
            <p id="toastMessage" class="mt-1 text-sm text-gray-500"></p>
        </div>
        <button onclick="hideToast()" class="ml-4 flex-shrink-0 text-gray-400 hover:text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        const icons = {
            success: '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            error: '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            info: '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        };

        toastIcon.innerHTML = icons[type] || icons.success;
        toastTitle.textContent = title;
        toastMessage.textContent = message;

        toast.classList.remove('hidden');

        setTimeout(() => {
            hideToast();
        }, 5000);
    }

    function hideToast() {
        document.getElementById('toast').classList.add('hidden');
    }

    async function runBackup() {
        const btn = document.getElementById('backupBtn');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');

        try {
            const response = await fetch('{{ route("admin.maintenance.backup") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                showToast('Backup Complete', data.message, 'success');
            } else {
                showToast('Backup Failed', data.message, 'error');
            }
        } catch (error) {
            showToast('Error', 'Failed to run backup. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    async function optimizeSystem() {
        const btn = document.getElementById('optimizeBtn');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');

        try {
            const response = await fetch('{{ route("admin.maintenance.optimize") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                showToast('Optimization Complete', data.message, 'success');
            } else {
                showToast('Optimization Failed', data.message, 'error');
            }
        } catch (error) {
            showToast('Error', 'Failed to optimize system. Please try again.', 'error');
        } finally {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function clearCache() {
        showToast('Cache Clearing', 'This will clear all application caches...', 'info');
        setTimeout(() => {
            optimizeSystem();
        }, 1000);
    }

    function runMigrations() {
        if (confirm('Are you sure you want to run migrations? This may affect your database.')) {
            showToast('Migrations', 'Running database migrations...', 'info');
            // Add actual migration logic here
        }
    }
</script>
@endpush
</x-layouts.app>