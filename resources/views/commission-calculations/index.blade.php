<x-layouts.app>
    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Commission Calculations</h1>
                    <p class="text-muted-foreground">Manage and review commission calculations.</p>
                </div>
                <a href="{{ route('commission-calculations.create') }}" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-blue-500 hover:bg-blue-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calculator mr-2 h-4 w-4">
                        <rect width="16" height="20" x="4" y="2" rx="2"></rect>
                        <line x1="8" x2="16" y1="6" y2="6"></line>
                        <line x1="16" x2="16" y1="14" y2="18"></line>
                        <path d="M16 10h.01"></path>
                        <path d="M12 10h.01"></path>
                        <path d="M8 10h.01"></path>
                        <path d="M12 14h.01"></path>
                        <path d="M8 14h.01"></path>
                        <path d="M12 18h.01"></path>
                        <path d="M8 18h.01"></path>
                    </svg>
                    New Calculation
                </a>
            </div>

            <!-- Success/Error Messages -->
            <section id="alert-section">
                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif
                @if (session('errors'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    @foreach (session('errors') as $error)
                    <span class="block sm:inline">{{ $error }}</span>
                    @endforeach
                </div>
                @endif
            </section>

            <!-- Commission Calculations Table -->
            <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">All Calculations</h3>
                    <p class="text-sm text-gray-500">Browse all commission calculations.</p>
                </div>
                <div class="p-6 pt-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Agent</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Amount</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Date</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($commissionCalculations as $calculation)
                                <tr class="border-b border-gray-300 hover:bg-gray-50">
                                    <td class="p-4 align-middle font-medium">{{ $calculation->policy->policy_number }}</td>
                                    <td class="p-4 align-middle">{{ $calculation->agent->name }}</td>
                                    <td class="p-4 align-middle">KES {{ number_format($calculation->commission_amount, 2) }}</td>
                                    <td class="p-4 align-middle">{{ $calculation->calculation_date->format('Y-m-d') }}</td>
                                    <td class="p-4 align-middle">
                                        <a href="{{ route('commission-calculations.show', $calculation) }}" class="text-blue-600 hover:underline">View</a>
                                        <a href="{{ route('commission-calculations.edit', $calculation) }}" class="text-yellow-600 hover:underline ml-4">Edit</a>
                                         <form action="{{ route('commission-calculations.destroy', $calculation) }}" method="POST" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center">No commission calculations found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $commissionCalculations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
