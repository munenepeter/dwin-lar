            <aside :class="{ 'w-full md:w-64': sidebarOpen, 'w-0 md:w-16 hidden md:block': !sidebarOpen }"
                class="bg-sidebar text-sidebar-foreground border-r border-gray-200 dark:border-gray-700 sidebar-transition overflow-hidden">
                <!-- Sidebar Content -->
                <style>
                    .sidebar-item:hover {
                        background-color: rgba(239, 68, 68, 0.1);
                    }

                    .sidebar-item.active {
                        background-color: rgba(239, 68, 68, 0.15) !important;
                    }

                    .sidebar-item.active svg {
                        color: #ef4444 !important;
                    }

                    .submenu {
                        max-height: 0;
                        overflow: hidden;
                        transition: max-height 0.3s ease-in-out;
                    }

                    .submenu.open {
                        max-height: 500px;
                    }
                </style>
                <aside id="sidenav" class="w-64 bg-white border-r border-gray-100 h-fit">
                    <!-- Header -->
                    <div class="p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shield-alt text-xl"></i>
                            </div>
                            <div>
                                <h1 class="font-semibold text-gray-900 text-lg">Dwin Insurance</h1>
                                <p class="text-sm text-gray-500">Admin Panel</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                        <!-- MAIN Section -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">MAIN</h3>

                            <!-- Dashboard -->
                            <a href="/admin/dashboard" class="sidebar-item <?= url() == 'admin/dashboard' ? 'active' : ''; ?> flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Dashboard
                            </a>

                            <!-- Analytics -->
                            <!-- REMOVE FOR NOW, TO BE CONSIDERED -->
                            <!-- <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                 <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                 </svg>
                 Analytics
             </a> -->

                            <!-- Clients -->
                            <a href="/admin/clients" class="sidebar-item <?= url() == 'admin/clients' ? 'active' : ''; ?> flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Clients
                            </a>

                            <a href="/admin/policies" class="sidebar-item <?= url() == 'admin/policies' ? 'active' : ''; ?> flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Policies
                            </a>

                            <!-- Commissions
             <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                 <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                 </svg>
                 Commissions
             </a> -->
                        </div>

                        <!-- MANAGEMENT Section -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">MANAGEMENT</h3>

                            <!-- Users -->
                            <a href="/admin/users" class="sidebar-item <?= request()->is('admin/users/*') ? 'active' : ''; ?> flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                Users
                            </a>

                            <!-- Insurance Companies -->
                            <a href="/admin/insurance-companies" class="sidebar-item <?= request()->is('admin/insurance-companies') ? 'active' : ''; ?> flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Insurance Companies
                            </a>

                            <!-- Commission Structures -->
                            <!-- DISABLED FOR NOW, FIND IT UNDER INSURANCE COMPANIES ABOVE! -->
                            <!-- <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                 <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                 </svg>
                 Commission Structures
             </a> -->

                            <!-- Payments -->
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Payments
                            </a>

                            <!-- Notifications -->
                            <a href="/admin/notifications" class="sidebar-item <?= request()->is('admin/notifications') ? 'active' : ''; ?> flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Notifications
                            </a>
                        </div>

                        <!-- REPORTS Section -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">REPORTS</h3>

                            <!-- Performance Metrics -->
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Performance Metrics
                            </a>

                            <!-- Agent Reports -->
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Agent Reports
                            </a>

                            <!-- Financial Reports -->
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                Financial Reports
                            </a>
                        </div>

                        <!-- SYSTEM Section -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">SYSTEM</h3>

                            <!-- Settings -->
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </a>

                            <!-- Audit Logs -->
                            <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                                <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Audit Logs
                            </a>

                            <!-- Backup & Maintenance -->
                            <!-- TEMPORARILY DISABLED -->
                            <!-- <a href="#" class="sidebar-item flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-700 group">
                 <svg class="mr-3 w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                 </svg>
                 Backup & Maintenance
             </a> -->
                        </div>
                    </nav>

                    <!-- Bottom User Menu -->
                    <div class="border-t border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">AD</span>
                                </div>
                                <div>
                                    <p class="font-medium text-sm text-gray-900">{{ Auth::user()->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{Auth::user()->email}}</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <script>
                        // Toggle submenu function
                        function toggleSubmenu(menuId) {
                            const submenu = document.getElementById(`${menuId}-submenu`);
                            const arrow = document.getElementById(`${menuId}-arrow`);

                            submenu.classList.toggle('open');

                            // Rotate the arrow icon
                            if (submenu.classList.contains('open')) {
                                arrow.classList.add('rotate-90');
                            } else {
                                arrow.classList.remove('rotate-90');
                            }
                        }

                        // Highlight active menu item
                        document.addEventListener('DOMContentLoaded', function() {
                            const menuItems = document.querySelectorAll('.sidebar-item');

                            menuItems.forEach(item => {
                                item.addEventListener('click', function(e) {
                                    // Prevent default only for non-link items
                                    if (item.tagName === 'BUTTON' || item.getAttribute('href') === '#') {
                                        e.preventDefault();
                                    }

                                    // Remove active class from all items
                                    menuItems.forEach(i => {
                                        i.classList.remove('active');
                                        const icon = i.querySelector('svg');
                                        if (icon) {
                                            icon.classList.remove('text-red-500');
                                            icon.classList.add('text-gray-400');
                                        }
                                    });

                                    // Add active class to clicked item
                                    this.classList.add('active');
                                    const icon = this.querySelector('svg');
                                    if (icon) {
                                        icon.classList.remove('text-gray-400');
                                        icon.classList.add('text-red-500');
                                    }
                                });
                            });
                        });
                    </script>
                </aside>
            </aside>