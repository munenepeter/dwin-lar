<?php

/**
 * 
 * @author Peter Munene <munenenjega@gmail.com>
 */

// $policy and $auditLog are passed from the controller
if (!isset($policy) || empty($policy)) {
    echo '<p class="p-6 text-red-700 bg-red-50 rounded-lg border border-red-200">Policy details not found.</p>';
    return;
}
?>

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <div class="flex items-center justify-start mb-6 space-x-4">
        <h3 class="text-xl font-bold text-gray-900 tracking-tight">Policy Details</h3>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center rounded-full border px-2 py-1.5 text-xs font-semibold 
                <?php
                switch ($policy->policy_status) {
                    case 'ACTIVE':
                        echo 'bg-green-100 text-green-800 border-green-200';
                        break;
                    case 'EXPIRED':
                        echo 'bg-red-100 text-red-800 border-red-200';
                        break;
                    case 'PENDING':
                        echo 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        break;
                    case 'CANCELLED':
                        echo 'bg-gray-100 text-gray-800 border-gray-200';
                        break;
                    case 'RENEWED':
                        echo 'bg-blue-100 text-blue-800 border-blue-200';
                        break;
                    default:
                        echo 'bg-gray-100 text-gray-800 border-gray-200';
                        break;
                }
                ?>">
                <?= htmlspecialchars($policy->policy_status) ?>
            </span>
            <span class="text-lg font-mono text-gray-600"><?= htmlspecialchars($policy->policy_number) ?></span>
        </div>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <div class="p-4">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex -mb-px space-x-6" id="policyDetailTabs">
                    <button data-detail-tab="overview" class="detail-tab-button py-3 px-1 text-center border-b-2 font-semibold text-sm active border-blue-500 text-blue-600 focus:outline-none focus:text-blue-600 transition-all duration-200">
                        Overview
                    </button>
                    <button data-detail-tab="client" class="detail-tab-button py-3 px-1 text-center border-b-2 font-semibold text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition-all duration-200">
                        Client Info
                    </button>
                    <button data-detail-tab="company" class="detail-tab-button py-3 px-1 text-center border-b-2 font-semibold text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition-all duration-200">
                        Insurance Co
                    </button>
                    <button data-detail-tab="coverage" class="detail-tab-button py-3 px-1 text-center border-b-2 font-semibold text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition-all duration-200">
                        Coverage Details
                    </button>
                    <button data-detail-tab="audit-log" class="detail-tab-button py-3 px-1 text-center border-b-2 font-semibold text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition-all duration-200">
                        Audit Log
                    </button>
                </nav>
            </div>

            <!-- Overview Tab -->
            <div id="overview-detail-tab" class="detail-tab-content active">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Policy Information Card -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-blue-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Policy Information
                        </h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Policy Number</span>
                                <span class="text-sm font-mono text-gray-900 bg-white px-2 py-1 rounded"><?= htmlspecialchars($policy->policy_number) ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Policy Type</span>
                                <span class="text-sm text-gray-900"><?= htmlspecialchars($policy->policy_type_name) ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Issue Date</span>
                                <span class="text-sm text-gray-900"><?= date('M d, Y', strtotime($policy->issue_date)) ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Effective Date</span>
                                <span class="text-sm text-gray-900"><?= date('M d, Y', strtotime($policy->effective_date)) ?></span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Expiry Date</span>
                                <span class="text-sm text-gray-900 <?= strtotime($policy->expiry_date) < time() ? 'text-red-600 font-semibold' : '' ?>">
                                    <?= date('M d, Y', strtotime($policy->expiry_date)) ?>
                                    <?php 
                                    $daysToExpiry = ceil((strtotime($policy->expiry_date) - time()) / (60 * 60 * 24));
                                    if ($daysToExpiry > 0 && $daysToExpiry <= 30): 
                                    ?>
                                        <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                                            <?= $daysToExpiry ?> days left
                                        </span>
                                    <?php elseif ($daysToExpiry <= 0): ?>
                                        <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                            Expired
                                        </span>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information Card -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-green-100">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Financial Details
                        </h4>
                        <div class="space-y-4">
                            <div class="bg-white rounded-lg p-4 border border-green-100">
                                <div class="text-sm font-medium text-gray-600 mb-1">Premium Amount</div>
                                <div class="text-2xl font-bold text-green-600">KES <?= number_format($policy->premium_amount, 2) ?></div>
                                <div class="text-xs text-gray-500 mt-1"><?= ucfirst(strtolower(str_replace('_', ' ', $policy->payment_frequency))) ?> Payment</div>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-green-100">
                                <div class="text-sm font-medium text-gray-600 mb-1">Sum Insured</div>
                                <div class="text-xl font-bold text-gray-900">KES <?= number_format($policy->sum_insured, 2) ?></div>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-green-100">
                                <span class="text-sm font-medium text-gray-600">Payment Method</span>
                                <span class="text-sm text-gray-900 capitalize"><?= ucfirst(strtolower(str_replace('_', ' ', $policy->payment_method))) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agent Information -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Assigned Agent
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Agent Name</span>
                            <p class="mt-1 text-sm text-gray-900">
                                <?php if (!empty($policy->agent_name)): ?>
                                    <?= htmlspecialchars($policy->agent_name) ?>
                                <?php else: ?>
                                    <span class="text-gray-400">Not assigned</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Agent Email</span>
                            <p class="mt-1 text-sm text-gray-900">
                                <?php if (!empty($policy->agent_email)): ?>
                                    <a href="mailto:<?= htmlspecialchars($policy->agent_email) ?>" class="text-blue-600 hover:text-blue-800">
                                        <?= htmlspecialchars($policy->agent_email) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400">N/A</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <?php if (!empty($policy->notes)): ?>
                <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-amber-200">
                    <h4 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Notes
                    </h4>
                    <p class="text-sm text-gray-700 whitespace-pre-wrap leading-relaxed"><?= htmlspecialchars($policy->notes) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Client Information Tab -->
            <div id="client-detail-tab" class="detail-tab-content space-y-6 hidden">
                <div class="bg-gray-50 rounded-lg p-6 border border-purple-100">
                    <h4 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Client Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Full Name</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($policy->first_name . ' ' . $policy->last_name) ?></p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email Address</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <?php if (!empty($policy->client_email)): ?>
                                        <a href="mailto:<?= htmlspecialchars($policy->client_email) ?>" class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <?= htmlspecialchars($policy->client_email) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">Not provided</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Phone Number</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <?php if (!empty($policy->client_phone)): ?>
                                        <a href="tel:<?= htmlspecialchars($policy->client_phone) ?>" class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <?= htmlspecialchars($policy->client_phone) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">Not provided</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Client ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 bg-white px-2 py-1 rounded border">#<?= htmlspecialchars($policy->client_id) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Information Tab -->
            <div id="company-detail-tab" class="detail-tab-content space-y-6 hidden">
                <div class="bg-gray-50 rounded-lg p-6 border border-blue-100">
                    <h4 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Insurance Company Details
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Company Name</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($policy->company_name) ?></p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Contact Person</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <?= htmlspecialchars($policy->company_contact ?? 'Not specified') ?>
                                </p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Company Phone</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <?php if (!empty($policy->company_phone)): ?>
                                        <a href="tel:<?= htmlspecialchars($policy->company_phone) ?>" class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            <?= htmlspecialchars($policy->company_phone) ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">Not provided</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Company ID</label>
                                <p class="mt-1 text-sm font-mono text-gray-900 bg-white px-2 py-1 rounded border">#<?= htmlspecialchars($policy->company_id) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coverage Details Tab -->
            <div id="coverage-detail-tab" class="detail-tab-content space-y-6 hidden">
                <div class="bg-gray-50 rounded-lg p-6 border border-indigo-100">
                    <h4 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Coverage & Policy Details
                    </h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Policy Type</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900"><?= htmlspecialchars($policy->policy_type_name) ?></p>
                                <?php if (!empty($policy->policy_type_description)): ?>
                                    <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($policy->policy_type_description) ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Policy Duration</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <?php 
                                    $duration = ceil((strtotime($policy->expiry_date) - strtotime($policy->effective_date)) / (60 * 60 * 24));
                                    echo $duration . ' days (' . round($duration / 365, 1) . ' years)';
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Payment Frequency</label>
                                <p class="mt-1 text-sm text-gray-900 capitalize">
                                    <?= ucfirst(strtolower(str_replace('_', ' ', $policy->payment_frequency))) ?>
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Payment Method</label>
                                <p class="mt-1 text-sm text-gray-900 capitalize">
                                    <?= ucfirst(strtolower(str_replace('_', ' ', $policy->payment_method))) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Coverage Details JSON -->
                    <?php if (!empty($policy->coverage_details)): ?>
                        <div class="mt-6 pt-6 border-t border-indigo-100">
                            <label class="text-sm font-medium text-gray-600 mb-3 block">Coverage Breakdown</label>
                            <div class="bg-white rounded-lg p-4 border border-indigo-100">
                                <pre class="text-xs text-gray-700 whitespace-pre-wrap overflow-x-auto"><?= htmlspecialchars(json_encode(json_decode($policy->coverage_details, true), JSON_PRETTY_PRINT)) ?></pre>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Audit Log Tab -->
            <div id="audit-log-detail-tab" class="detail-tab-content space-y-6 hidden">
                <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-lg p-6 border border-slate-200">
                    <h4 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Policy Activity Log
                        <?php if (!empty($auditLog)): ?>
                            <span class="ml-2 bg-slate-100 text-slate-700 text-xs px-2 py-1 rounded-full"><?= count($auditLog) ?> entries</span>
                        <?php endif; ?>
                    </h4>
                    
                    <?php if (!empty($auditLog)): ?>
                        <div class="space-y-4 max-h-96 overflow-y-auto">
                            <?php foreach ($auditLog as $index => $logEntry): ?>
                                <div class="bg-white rounded-lg border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <!-- Log Entry Header -->
                                    <div class="px-4 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <?php if ($logEntry->action_type === 'INSERT'): ?>
                                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                        </svg>
                                                    </div>
                                                <?php elseif ($logEntry->action_type === 'UPDATE'): ?>
                                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </div>
                                                <?php elseif ($logEntry->action_type === 'DELETE'): ?>
                                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-sm font-semibold text-gray-900 capitalize">
                                                        <?= ucfirst(strtolower($logEntry->action_type)) ?>
                                                    </span>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                        <?php
                                                        switch ($logEntry->action_type) {
                                                            case 'INSERT':
                                                                echo 'bg-green-100 text-green-800';
                                                                break;
                                                            case 'UPDATE':
                                                                echo 'bg-blue-100 text-blue-800';
                                                                break;
                                                            case 'DELETE':
                                                                echo 'bg-red-100 text-red-800';
                                                                break;
                                                            default:
                                                                echo 'bg-gray-100 text-gray-800';
                                                        }
                                                        ?>">
                                                        <?= htmlspecialchars($logEntry->action_type) ?>
                                                    </span>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <?= date('M j, Y \a\t g:i A', strtotime($logEntry->created_at)) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <?php if (!empty($logEntry->user_id)): ?>
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                    User ID: <?= htmlspecialchars($logEntry->user_id) ?>
                                                </span>
                                            <?php endif; ?>
                                            <button class="audit-toggle-btn text-slate-400 hover:text-slate-600 p-1 rounded transition-colors duration-200" data-target="audit-details-<?= $index ?>">
                                                <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Log Entry Details (Collapsible) -->
                                    <div id="audit-details-<?= $index ?>" class="hidden px-4 py-3 border-t border-slate-100">
                                        <?php if ($logEntry->action_type === 'UPDATE' && !empty($logEntry->old_values) && !empty($logEntry->new_values)): ?>
                                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                                <!-- Old Values -->
                                                <div class="bg-red-50 rounded-lg p-3 border border-red-100">
                                                    <h6 class="text-xs font-semibold text-red-800 mb-2 flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                        Previous Values
                                                    </h6>
                                                    <div class="text-xs text-red-700 font-mono bg-white p-2 rounded border border-red-200 overflow-x-auto">
                                                        <?php
                                                        $oldValues = json_decode($logEntry->old_values, true);
                                                        if (json_last_error() === JSON_ERROR_NONE && is_array($oldValues)):
                                                        ?>
                                                            <?php foreach ($oldValues as $key => $value): ?>
                                                                <div class="mb-1">
                                                                    <span class="text-red-600 font-semibold"><?= htmlspecialchars($key) ?>:</span>
                                                                    <span class="text-red-800"><?= htmlspecialchars(is_null($value) ? 'null' : (string)$value) ?></span>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <pre class="whitespace-pre-wrap"><?= htmlspecialchars($logEntry->old_values) ?></pre>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <!-- New Values -->
                                                <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                                                    <h6 class="text-xs font-semibold text-green-800 mb-2 flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                        New Values
                                                    </h6>
                                                    <div class="text-xs text-green-700 font-mono bg-white p-2 rounded border border-green-200 overflow-x-auto">
                                                        <?php
                                                        $newValues = json_decode($logEntry->new_values, true);
                                                        if (json_last_error() === JSON_ERROR_NONE && is_array($newValues)):
                                                        ?>
                                                            <?php foreach ($newValues as $key => $value): ?>
                                                                <div class="mb-1">
                                                                    <span class="text-green-600 font-semibold"><?= htmlspecialchars($key) ?>:</span>
                                                                    <span class="text-green-800"><?= htmlspecialchars(is_null($value) ? 'null' : (string)$value) ?></span>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <pre class="whitespace-pre-wrap"><?= htmlspecialchars($logEntry->new_values) ?></pre>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- Single Value Display for INSERT/DELETE -->
                                            <div class="bg-slate-50 rounded-lg p-3 border border-slate-200">
                                                <h6 class="text-xs font-semibold text-slate-800 mb-2">
                                                    <?= $logEntry->action_type === 'INSERT' ? 'Created Values' : 'Action Details' ?>
                                                </h6>
                                                <div class="text-xs text-slate-700 font-mono bg-white p-2 rounded border border-slate-300 overflow-x-auto">
                                                    <?php
                                                    $values = !empty($logEntry->new_values) ? $logEntry->new_values : $logEntry->old_values;
                                                    $decodedValues = json_decode($values, true);
                                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decodedValues)):
                                                    ?>
                                                        <?php foreach ($decodedValues as $key => $value): ?>
                                                            <div class="mb-1">
                                                                <span class="text-slate-600 font-semibold"><?= htmlspecialchars($key) ?>:</span>
                                                                <span class="text-slate-800"><?= htmlspecialchars(is_null($value) ? 'null' : (string)$value) ?></span>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <pre class="whitespace-pre-wrap"><?= htmlspecialchars($values) ?></pre>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-sm font-medium text-slate-900">No activity recorded</h3>
                            <p class="mt-2 text-sm text-slate-500">There are no audit log entries for this policy yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
             <!-- I REMOVED IT CAUSE IT BOTHERED ME TO FIGURE OUT JS FOR IT TO WORK -->

            <!-- <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <button id="edit-policy-button" type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Policy
                </button>
                <button id="close-view-modal" type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                    Close
                </button>
            </div> -->
        </div>
    </div>
</section>