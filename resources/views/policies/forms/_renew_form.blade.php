<section class="p-6 bg-white rounded-lg shadow-sm">
    <h3 class="text-xl font-semibold mb-4">Renew Policy #{{ $policy->policy_number }}</h3>

    <form action="{{ route('policies.renew.store', $policy) }}" method="POST">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Renewal Date</label>
                <input type="date" name="renewal_date" required
                       value="{{ now()->addDays(1)->format('Y-m-d') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">New Premium (KES)</label>
                <input type="number" step="0.01" name="new_premium_amount" required
                       value="{{ $policy->premium_amount }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600">
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Notes (optional)</label>
            <textarea name="notes" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-600 focus:border-red-600"></textarea>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Create Renewal Request</button>
        </div>
    </form>
</section>