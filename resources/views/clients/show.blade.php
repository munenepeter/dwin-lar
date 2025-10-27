<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Client Details - {{ $client->first_name }} {{ $client->last_name }}</h1>
                    <p class="text-muted-foreground">Complete client information and related data</p>
                </div>
                <a href="{{ route('clients.index') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                        <path d="m12 19-7-7 7-7"></path>
                        <path d="M19 12H5"></path>
                    </svg>
                    Back to Clients
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Client Basic Information -->
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Client Code</p>
                        <p class="text-sm font-medium">{{ $client->client_code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Full Name</p>
                        <p class="text-sm font-medium">{{ $client->first_name }} {{ $client->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-sm font-medium">{{ $client->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Primary Phone</p>
                        <p class="text-sm font-medium">{{ $client->phone_primary }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Secondary Phone</p>
                        <p class="text-sm font-medium">{{ $client->phone_secondary ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">ID Number</p>
                        <p class="text-sm font-medium">{{ $client->id_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="text-sm font-medium">{{ $client->date_of_birth ? $client->date_of_birth->format('M j, Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="text-sm font-medium">{{ $client->gender ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($client->client_status === 'ACTIVE') bg-green-100 text-green-800
                            @elseif($client->client_status === 'INACTIVE') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $client->client_status }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">KYC Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($client->kyc_status === 'VERIFIED') bg-green-100 text-green-800
                            @elseif($client->kyc_status === 'PENDING') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $client->kyc_status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Assigned Agent Information -->
            @if($client->assignedAgent)
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold mb-4">Assigned Agent</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Agent Name</p>
                        <p class="text-sm font-medium">{{ $client->assignedAgent->first_name }} {{ $client->assignedAgent->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Agent Email</p>
                        <p class="text-sm font-medium">{{ $client->assignedAgent->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Agent Phone</p>
                        <p class="text-sm font-medium">{{ $client->assignedAgent->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Additional Information -->
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold mb-4">Additional Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-sm font-medium">{{ $client->address ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">City/County</p>
                        <p class="text-sm font-medium">{{ ($client->city ?? 'N/A') . ' / ' . ($client->county ?? 'N/A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Occupation</p>
                        <p class="text-sm font-medium">{{ $client->occupation ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Employer</p>
                        <p class="text-sm font-medium">{{ $client->employer ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Annual Income</p>
                        <p class="text-sm font-medium">{{ $client->annual_income ? number_format($client->annual_income, 2) . ' KES' : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Marital Status</p>
                        <p class="text-sm font-medium">{{ $client->marital_status ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Next of Kin</p>
                        <p class="text-sm font-medium">{{ $client->next_of_kin ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Next of Kin Contact</p>
                        <p class="text-sm font-medium">{{ ($client->next_of_kin_phone ?? 'N/A') . ' (' . ($client->next_of_kin_relationship ?? 'N/A') . ')' }}</p>
                    </div>
                </div>
                @if($client->notes)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Notes</p>
                        <p class="text-sm font-medium">{{ $client->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Policies -->
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold mb-4">Policies</h3>
                @if(empty($policies))
                    <p class="text-sm text-gray-500">No policies found for this client.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Policy Number</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Premium</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($policies as $policy)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $policy->policy_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $policy->policy_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $policy->company_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($policy->premium_amount, 2) }} KES</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($policy->policy_status === 'ACTIVE') bg-green-100 text-green-800
                                                @elseif($policy->policy_status === 'EXPIRED') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $policy->policy_status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($policy->expiry_date)->format('M j, Y') }}
                                            @if($policy->days_to_expiry <= 30 && $policy->policy_status === 'ACTIVE')
                                                <span class="text-xs text-red-600">({{ $policy->days_to_expiry }} days)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Documents -->
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold mb-4">Documents</h3>
                @if(empty($documents))
                    <p class="text-sm text-gray-500">No documents uploaded for this client.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded By</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($documents as $document)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $document->document_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $document->document_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $document->uploaded_by_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $document->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $document->is_verified ? 'Verified' : 'Pending' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($document->document_uploaded_at)->format('M j, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Notifications -->
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold mb-4">Recent Notifications</h3>
                @if(empty($notifications))
                    <p class="text-sm text-gray-500">No recent notifications for this client.</p>
                @else
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="border-l-4 {{ $notification->priority_class }} p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium">{{ $notification->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $notification->message }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($notification->created_at)->format('M j, Y H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Audit Logs -->
            <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-semibold mb-4">Audit History</h3>
                @if($auditLogs->isEmpty())
                    <p class="text-sm text-gray-500">No audit history available for this client.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($auditLogs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->action_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->user ? $log->user->first_name . ' ' . $log->user->last_name : 'System' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at->format('M j, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-layouts.app>