<!-- resources/views/policies/forms/_policy_details.blade.php (converted to Blade) -->
@if (!isset($policy) || empty($policy))
<p class="p-6 text-red-700 bg-red-50 rounded-lg border border-red-200">Policy details not found.</p>
@else
<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <div class="flex items-center justify-start mb-6 space-x-4">
        <h3 class="text-xl font-bold text-gray-900 tracking-tight">Policy Details</h3>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center rounded-full border px-2 py-1.5 text-xs font-semibold 
                    @switch($policy->policy_status)
                        @case('ACTIVE') bg-green-100 text-green-800 border-green-200 @break
                        @case('EXPIRED') bg-red-100 text-red-800 border-red-200 @break
                        @case('PENDING') bg-yellow-100 text-yellow-800 border-yellow-200 @break
                        @case('CANCELLED') bg-gray-100 text-gray-800 border-gray-200 @break
                        @case('RENEWED') bg-blue-100 text-blue-800 border-blue-200 @break
                        @default bg-gray-100 text-gray-800 border-gray-200
                    @endswitch">
                {{ $policy->policy_status }}
            </span>
            <span class="text-lg font-mono text-gray-600">{{ $policy->policy_number }}</span>
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
                                <span class="text-sm font-mono text-gray-900 bg-white px-2 py-1 rounded">{{ $policy->policy_number }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Policy Type</span>
                                <span class="text-sm text-gray-900">{{ $policy->policyType->type_name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Issue Date</span>
                                <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($policy->issue_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Effective Date</span>
                                <span class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($policy->effective_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Expiry Date</span>
                                <span class="text-sm text-gray-900 {{ \Carbon\Carbon::parse($policy->expiry_date) < now() ? 'text-red-600 font-semibold' : '' }}">
                                    {{ \Carbon\Carbon::parse($policy->expiry_date)->format('M d, Y') }}
                                    @php
                                    $daysToExpiry = \Carbon\Carbon::parse($policy->expiry_date)->diffInDays(now(), false);
                                    @endphp
                                    @if ($daysToExpiry > 0 && $daysToExpiry <= 30)
                                        <span class="ml-2 text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                                        {{ $daysToExpiry }} days left
                                </span>
                                @elseif ($daysToExpiry <= 0)
                                    <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                    Expired
                                    </span>
                                    @endif
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
                                <div class="text-2xl font-bold text-green-600">KES {{ number_format($policy->premium_amount, 2) }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ ucfirst(strtolower(str_replace('_', ' ', $policy->payment_frequency))) }} Payment</div>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-green-100">
                                <div class="text-sm font-medium text-gray-600 mb-1">Sum Insured</div>
                                <div class="text-xl font-bold text-gray-900">KES {{ number_format($policy->sum_insured, 2) }}</div>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-green-100">
                                <span class="text-sm font-medium text-gray-600">Payment Method</span>
                                <span class="text-sm text-gray-900 capitalize">{{ ucfirst(strtolower(str_replace('_', ' ', $policy->payment_method))) }}</span>
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
                                @if (!empty($policy->agent->full_name))
                                {{ $policy->agent->full_name }}
                                @else
                                <span class="text-gray-400">Not assigned</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Agent Email</span>
                            <p class="mt-1 text-sm text-gray-900">
                                @if (!empty($policy->agent->email))
                                <a href="mailto:{{ $policy->agent->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $policy->agent->email }}
                                </a>
                                @else
                                <span class="text-gray-400">Not assigned</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Info Tab (add content as needed; stubbed for completeness) -->
            <div id="client-detail-tab" class="detail-tab-content hidden">
                <!-- Client details here -->
            </div>

            <!-- Company Tab (stubbed) -->
            <div id="company-detail-tab" class="detail-tab-content hidden">
                <!-- Company details here -->
            </div>

            <!-- Coverage Details Tab -->
            <div id="coverage-detail-tab" class="detail-tab-content hidden">
                @php
                $coverageDetails = json_decode($policy->coverage_details, true) ?? [];
                @endphp
                @if (!empty($coverageDetails))
                <div class="space-y-4">
                    @foreach($coverageDetails as $detail)
                    <!-- Render coverage details -->
                    @endforeach
                </div>
                @else
                <p>No coverage details available.</p>
                @endif
            </div>

            <!-- Audit Log Tab -->
            <div id="audit-log-detail-tab" class="detail-tab-content hidden">
                @if (!empty($auditLog))
                <div class="space-y-4">
                    @foreach($auditLog as $index => $logEntry)
                    <div class="bg-white rounded-lg border border-slate-200 p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-semibold text-slate-800">{{ $logEntry->action_type }}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $logEntry->created_at->format('M j, Y \a\t g:i A') }}
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if (!empty($logEntry->user_id))
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    User ID: {{ $logEntry->user_id }}
                                </span>
                                @endif
                                <button class="audit-toggle-btn text-slate-400 hover:text-slate-600 p-1 rounded transition-colors duration-200" data-target="audit-details-{{ $index }}">
                                    <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Log Entry Details (Collapsible) -->
                        <div id="audit-details-{{ $index }}" class="hidden px-4 py-3 border-t border-slate-100">
                            @if ($logEntry->action_type === 'UPDATE' && !empty($logEntry->old_values) && !empty($logEntry->new_values))
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
                                        @php $oldValues = json_decode($logEntry->old_values, true); @endphp
                                        @if (is_array($oldValues))
                                        @foreach ($oldValues as $key => $value)
                                        <div class="mb-1">
                                            <span class="text-red-600 font-semibold">{{ $key }}:</span>
                                            <span class="text-red-800">{{ is_null($value) ? 'null' : $value }}</span>
                                        </div>
                                        @endforeach
                                        @else
                                        <pre class="whitespace-pre-wrap">{{ $logEntry->old_values }}</pre>
                                        @endif
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
                                        @php $newValues = json_decode($logEntry->new_values, true); @endphp
                                        @if (is_array($newValues))
                                        @foreach ($newValues as $key => $value)
                                        <div class="mb-1">
                                            <span class="text-green-600 font-semibold">{{ $key }}:</span>
                                            <span class="text-green-800">{{ is_null($value) ? 'null' : $value }}</span>
                                        </div>
                                        @endforeach
                                        @else
                                        <pre class="whitespace-pre-wrap">{{ $logEntry->new_values }}</pre>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @else
                            <!-- Single Value Display for INSERT/DELETE -->
                            <div class="bg-slate-50 rounded-lg p-3 border border-slate-200">
                                <h6 class="text-xs font-semibold text-slate-800 mb-2">
                                    {{ $logEntry->action_type === 'INSERT' ? 'Created Values' : 'Action Details' }}
                                </h6>
                                <div class="text-xs text-slate-700 font-mono bg-white p-2 rounded border border-slate-300 overflow-x-auto">
                                    @php $values = !empty($logEntry->new_values) ? $logEntry->new_values : $logEntry->old_values; @endphp
                                    @php $decodedValues = json_decode($values, true); @endphp
                                    @if (is_array($decodedValues))
                                    @foreach ($decodedValues as $key => $value)
                                    <div class="mb-1">
                                        <span class="text-slate-600 font-semibold">{{ $key }}:</span>
                                        <span class="text-slate-800">{{ is_null($value) ? 'null' : $value }}</span>
                                    </div>
                                    @endforeach
                                    @else
                                    <pre class="whitespace-pre-wrap">{{ $values }}</pre>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-slate-900">No activity recorded</h3>
                    <p class="mt-2 text-sm text-slate-500">There are no audit log entries for this policy yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Add JS for tabs if needed (assuming it's in a global script or add here) -->
<script>
    // Tab switching JS (add if not global)
    document.querySelectorAll('.detail-tab-button').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.detail-tab-button').forEach(btn => btn.classList.remove('active', 'border-blue-500', 'text-blue-600'));
            button.classList.add('active', 'border-blue-500', 'text-blue-600');
            document.querySelectorAll('.detail-tab-content').forEach(content => content.classList.add('hidden'));
            document.getElementById(button.dataset.detailTab + '-detail-tab').classList.remove('hidden');
        });
    });

    // Audit toggle JS
    document.querySelectorAll('.audit-toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.target);
            target.classList.toggle('hidden');
            btn.querySelector('svg').classList.toggle('rotate-180');
        });
    });
</script>
@endif