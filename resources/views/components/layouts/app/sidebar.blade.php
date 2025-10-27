<aside x-data="{ minimized: false }"
    :class="minimized ? 'w-16' : 'w-64'"
    class="bg-white border-r border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out overflow-hidden flex flex-col h-screen sticky top-0">

    <style>
        .sidebar-item:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }

        .sidebar-item.active {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #ef4444 !important;
        }

        .sidebar-item.active svg {
            color: #ef4444 !important;
        }
    </style>

    <!-- Header -->
    <div class="p-4 border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3" x-show="!minimized">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="font-semibold text-gray-900 text-lg">Dwin Insurance</h1>
                    <p class="text-sm text-gray-500">Admin Panel</p>
                </div>
            </div>
            <button @click="minimized = !minimized"
                class="text-gray-400 hover:text-gray-600 transition-colors"
                :class="minimized ? 'mx-auto' : ''">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        :d="minimized ? 'M13 5l7 7-7 7M5 5l7 7-7 7' : 'M11 19l-7-7 7-7m8 14l-7-7 7-7'"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <!-- MAIN Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3" x-show="!minimized">MAIN</h3>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Dashboard' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span x-show="!minimized">Dashboard</span>
            </a>

            <!-- Analytics -->
            <a href="{{ route('admin.analytics') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('admin.analytics') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Analytics' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span x-show="!minimized">Analytics</span>
            </a>

            <!-- Clients -->
            <a href="{{ route('clients.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('clients.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Clients' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <span x-show="!minimized">Clients</span>
            </a>

            <!-- Policies -->
            <a href="{{ route('policies.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('policies.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Policies' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span x-show="!minimized">Policies</span>
            </a>

            <!-- Commissions -->
            <a href="{{ route('commission-calculations.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('commission-calculations.*', 'commission-payments.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Commissions' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                <span x-show="!minimized">Commissions</span>
            </a>
        </div>

        <!-- MANAGEMENT Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3" x-show="!minimized">MANAGEMENT</h3>

            <!-- Users -->
            <a href="{{ route('users.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('users.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Users' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span x-show="!minimized">Users</span>
            </a>

            <!-- Insurance Companies -->
            <a href="{{ route('insurance-companies.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('insurance-companies.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Insurance Companies' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span x-show="!minimized">Insurance Companies</span>
            </a>

            <!-- Policy Types -->
            <a href="{{ route('policy-types.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('policy-types.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Policy Types' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span x-show="!minimized">Policy Types</span>
            </a>

            <!-- Commission Structures -->
            <a href="{{ route('commission-structures.create') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('commission-structures.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Commission Structures' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <span x-show="!minimized">Commission Structures</span>
            </a>

            <!-- Payments -->
            <a href="{{ route('commission-payments.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('commission-payments.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Payments' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <span x-show="!minimized">Payments</span>
            </a>

            <!-- Notifications -->
            <a href="{{ route('notifications.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('notifications.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Notifications' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span x-show="!minimized">Notifications</span>
            </a>
        </div>

        <!-- REPORTS Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3" x-show="!minimized">REPORTS</h3>

            <!-- Performance Metrics -->
            <a href="{{ route('performance-metrics.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('performance-metrics.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Performance Metrics' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span x-show="!minimized">Performance Metrics</span>
            </a>

            <!-- Agent Reports -->
            <a href="{{ route('users.performanceReport', ['user' => 'all']) }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('users.performanceReport') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Agent Reports' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span x-show="!minimized">Agent Reports</span>
            </a>

            <!-- Financial Reports -->
            <a href="{{ route('commission-calculations.outstandingReport') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('commission-calculations.outstandingReport') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Financial Reports' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
                <span x-show="!minimized">Financial Reports</span>
            </a>

            <!-- Expiring Policies -->
            <a href="{{ route('policies.expiringReport') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('policies.expiringReport') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Expiring Policies' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span x-show="!minimized">Expiring Policies</span>
            </a>
        </div>

        <!-- SYSTEM Section -->
        <div class="mb-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3" x-show="!minimized">SYSTEM</h3>

            <!-- Settings -->
            <a href="{{ route('system-settings.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('system-settings.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Settings' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span x-show="!minimized">Settings</span>
            </a>

            <!-- User Roles -->
            <a href="{{ route('user-roles.index') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('user-roles.*') ? 'active' : '' }}"
                x-tooltip="minimized ? 'User Roles' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span x-show="!minimized">User Roles</span>
            </a>

            <!-- Audit Logs -->
            <a href="{{ route('admin.audit-logs') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('admin.audit-logs') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Audit Logs' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span x-show="!minimized">Audit Logs</span>
            </a>

            <!-- Backup & Maintenance -->
            <a href="{{ route('admin.maintenance') }}"
                class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group {{ request()->routeIs('admin.maintenance') ? 'active' : '' }}"
                x-tooltip="minimized ? 'Backup & Maintenance' : ''">
                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 flex-shrink-0" :class="minimized ? 'mx-auto' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
                <span x-show="!minimized">Backup & Maintenance</span>
            </a>
        </div>
    </nav>

    <!-- Bottom User Menu -->
    <div class="border-t border-gray-200 p-4 flex-shrink-0">
        <div class="flex items-center" :class="minimized ? 'justify-center' : 'justify-between'">
            <div class="flex items-center space-x-3" x-show="!minimized">
                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-medium text-sm">{{ strtoupper(substr(Auth::user()->full_name, 0, 2)) }}</span>
                </div>
                <div class="min-w-0">
                    <p class="font-medium text-sm text-gray-900 truncate">{{ Auth::user()->full_name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <div x-show="minimized" class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                <span class="text-white font-medium text-sm">{{ strtoupper(substr(Auth::user()->full_name, 0, 2)) }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" x-show="!minimized">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>