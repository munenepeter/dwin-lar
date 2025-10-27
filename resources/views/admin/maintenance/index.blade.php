<x-layouts.app>

    <main class="flex-1 shadow-xs rounded-md">
        <div class="mx-auto">
            <h1 class="text-2xl font-semibold text-gray-900 mb-6">Maintenance</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Maintenance Mode Settings -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Maintenance Mode</h2>
                <form action="{{ route('admin.maintenance.update') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="maintenance_mode" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="maintenance_mode" name="maintenance_mode" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="1" {{ $settings['maintenance_mode'] ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ !$settings['maintenance_mode'] ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>
                        <div>
                            <label for="allowed_ips" class="block text-sm font-medium text-gray-700">Allowed IP Addresses (comma-separated)</label>
                            <input type="text" id="allowed_ips" name="allowed_ips" value="{{ $settings['allowed_ips'] ?? '' }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Settings
                        </button>
                    </div>
                </form>
            </div>

            <!-- System Information -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">System Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($systemInfo as $key => $value)
                        <div>
                            <p class="text-sm font-medium text-gray-500">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Actions</h2>
                <div class="flex space-x-4">
                    <form action="{{ route('admin.maintenance.backup') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Run Backup
                        </button>
                    </form>
                    <form action="{{ route('admin.maintenance.optimize') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Run Optimization
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>
</x-layouts.app>
