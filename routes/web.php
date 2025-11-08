<?php

use App\Models\AuditLog;
use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PolicyTypeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PolicyRenewalController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\ClientDocumentController;
use App\Http\Controllers\InsuranceCompanyController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\CommissionPaymentController;
use App\Http\Controllers\PerformanceMetricController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\CommissionStructureController;
use App\Http\Controllers\Settings\AppearanceController;
use App\Http\Controllers\CommissionCalculationController;

Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/products', fn() => view('products'))->name('products');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/blog', fn() => view('blog'))->name('blog');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('settings/profile', [Settings\ProfileController::class, 'edit'])->name('settings.profile.edit');
    Route::put('settings/profile', [Settings\ProfileController::class, 'update'])->name('settings.profile.update');
    Route::delete('settings/profile', [Settings\ProfileController::class, 'destroy'])->name('settings.profile.destroy');
    Route::get('settings/password', [Settings\PasswordController::class, 'edit'])->name('settings.password.edit');
    Route::put('settings/password', [Settings\PasswordController::class, 'update'])->name('settings.password.update');
    Route::get('settings/appearance', [Settings\AppearanceController::class, 'edit'])->name('settings.appearance.edit');
});


// Protected routes (require auth)
// Add these routes to your existing admin routes group in web.php

Route::prefix('admin')->middleware('auth')->group(function () {
    
    // Dashboard 
    Route::get('dashboard', DashboardController::class)->name('admin.dashboard');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');

    // User Roles 
    Route::resource('user-roles', UserRoleController::class);

    // Users 
    Route::resource('users', UserController::class);
    
    // User Roles & Permissions routes 
    Route::get('users/roles/{id}', [UserController::class, 'getRole'])->name('users.roles.get');
    Route::post('users/roles', [UserController::class, 'storeRole'])->name('users.roles.store');
    Route::put('users/roles/{id}', [UserController::class, 'updateRole'])->name('users.roles.update');
    Route::delete('users/roles/{id}', [UserController::class, 'deleteRole'])->name('users.roles.delete');

    // Access Control routes 
    Route::post('users/update-role-permissions', [UserController::class, 'updateRolePermissions'])->name('users.roles.update-permissions');

    // Tab-specific routes for direct access 
    Route::get('users/tab/roles', [UserController::class, 'rolesTab'])->name('users.tab.roles');
    Route::get('users/tab/activity', [UserController::class, 'activityTab'])->name('users.tab.activity');
    Route::get('users/tab/access', [UserController::class, 'accessTab'])->name('users.tab.access');

    // Insurance Companies 
    Route::resource('insurance-companies', InsuranceCompanyController::class);
    Route::get('insurance-companies/stats', [InsuranceCompanyController::class, 'stats'])->name('insurance-companies.stats');

    // Policy Types 
    Route::resource('policy-types', PolicyTypeController::class);

    // Commission Structures 
    Route::resource('commission-structures', CommissionStructureController::class);

    // Clients 
    Route::resource('clients', ClientController::class);

    // Client Documents (nested under clients) 
    Route::resource('clients.documents', ClientDocumentController::class)->shallow();

    // Policies 
    Route::resource('policies', PolicyController::class);
    Route::get('policy-types/by-company/{company_id}', [PolicyController::class, 'policyTypesByCompany'])
     ->name('policy-types.by-company');

    // Policy Renewals (nested under policies) 
    Route::resource('policies.renewals', PolicyRenewalController::class)->shallow();

    // Commission Calculations 
    Route::resource('commission-calculations', CommissionCalculationController::class);

    // Commission Payments 
    Route::resource('commission-payments', CommissionPaymentController::class);

    // Notifications 
    Route::resource('notifications', NotificationController::class);
    Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
         ->name('notifications.markAsRead');

    // Performance Metrics 
    Route::resource('performance-metrics', PerformanceMetricController::class);

    // System Settings 
    Route::resource('system-settings', SystemSettingController::class);

    // Audit Logs 
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');

    // Maintenance 
    Route::get('maintenance', [MaintenanceController::class, 'index'])->name('admin.maintenance');
    Route::post('maintenance/backup', [MaintenanceController::class, 'backup'])->name('admin.maintenance.backup');
    Route::post('maintenance/optimize', [MaintenanceController::class, 'optimize'])->name('admin.maintenance.optimize');

    // Reports
    Route::get('reports/agent-performance', [\App\Http\Controllers\Reports\AgentReportController::class, 'index'])->name('reports.agent-performance');
    Route::get('reports/financial-reports', [\App\Http\Controllers\Reports\FinancialReportController::class, 'index'])->name('reports.financial-reports');
    Route::get('reports/expiring-policies', [\App\Http\Controllers\Reports\ExpiringPoliciesReportController::class, 'index'])->name('reports.expiring-policies');
    
    // Custom routes for stored procedures (e.g., reports) 
    Route::get('reports/client-policy-summary/{client}', [ClientController::class, 'policySummary'])
         ->name('clients.policySummary');
    Route::post('policies/update-expired', [PolicyController::class, 'updateExpired'])
         ->name('policies.updateExpired');
});

require __DIR__ . '/auth.php';
