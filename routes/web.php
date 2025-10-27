<?php

use App\Http\Controllers\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PolicyTypeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PolicyRenewalController;
use App\Http\Controllers\ClientDocumentController;
use App\Http\Controllers\InsuranceCompanyController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\CommissionPaymentController;
use App\Http\Controllers\PerformanceMetricController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\CommissionStructureController;
use App\Http\Controllers\Settings\AppearanceController;
use App\Http\Controllers\CommissionCalculationController;
use App\Http\Controllers\DashboardController;

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
Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('dashboard', DashboardController::class);

    // User Roles
    Route::resource('user-roles', UserRoleController::class);

    // Users
    Route::resource('users', UserController::class);

    Route::get('users', [UserController::class, 'index'])->name('users.index');

    // Roles & Permissions routes
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

    // Policy Renewals (nested under policies)
    Route::resource('policies.renewals', PolicyRenewalController::class)->shallow();

    // Commission Calculations
    Route::resource('commission-calculations', CommissionCalculationController::class);

    // Commission Payments
    Route::resource('commission-payments', CommissionPaymentController::class);

    // Notifications
    Route::resource('notifications', NotificationController::class);
    Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Performance Metrics
    Route::resource('performance-metrics', PerformanceMetricController::class);

    // System Settings
    // Route::resource('system-settings', SystemSettingController::class);

    // Custom routes for stored procedures (e.g., reports)
    Route::get('reports/client-policy-summary/{client}', [ClientController::class, 'policySummary'])->name('clients.policySummary');
    Route::get('reports/agent-performance/{user}', [UserController::class, 'performanceReport'])->name('users.performanceReport');
    Route::get('reports/expiring-policies', [PolicyController::class, 'expiringReport'])->name('policies.expiringReport');
    Route::get('reports/outstanding-commissions', [CommissionCalculationController::class, 'outstandingReport'])->name('commission-calculations.outstandingReport');
    Route::post('policies/update-expired', [PolicyController::class, 'updateExpired'])->name('policies.updateExpired');
});

require __DIR__ . '/auth.php';
