<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">View Insurance Company</h3>
    <div class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <div>
            <label class="block text-sm font-medium text-gray-700">Company Name</label>
            <p class="text-gray-900">{{ $insuranceCompany->company_name }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Company Code</label>
            <p class="text-gray-900">{{ $insuranceCompany->company_code }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Contact Person</label>
            <p class="text-gray-900">{{ $insuranceCompany->contact_person }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <p class="text-gray-900">{{ $insuranceCompany->email }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
            <p class="text-gray-900">{{ $insuranceCompany->phone }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Website</label>
            <p class="text-gray-900">{{ $insuranceCompany->website }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">City</label>
            <p class="text-gray-900">{{ $insuranceCompany->city }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Postal Code</label>
            <p class="text-gray-900">{{ $insuranceCompany->postal_code }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Country</label>
            <p class="text-gray-900">{{ $insuranceCompany->country }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Active Status</label>
            <p class="text-gray-900">{{ $insuranceCompany->is_active ? 'Active' : 'Inactive' }}</p>
        </div>

        <!-- Optional: Display related data -->
        @if ($insuranceCompany->commissionStructures->isNotEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700">Commission Structures</label>
                <ul class="list-disc pl-5">
                    @foreach ($insuranceCompany->commissionStructures as $structure)
                        <li>{{ $structure->name }} ({{ $structure->percentage }}%)</li> <!-- Adjust fields as per model -->
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($insuranceCompany->policies->isNotEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700">Policies</label>
                <ul class="list-disc pl-5">
                    @foreach ($insuranceCompany->policies as $policy)
                        <li>{{ $policy->policy_number }} (Premium: KES {{ number_format($policy->premium, 2) }})</li> <!-- Adjust fields as per model -->
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Close</button>
        </div>
    </div>
</section>