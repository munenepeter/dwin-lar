<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">View Commission Payment</h3>
    <div class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        <div>
            <label class="block text-sm font-medium text-gray-700">Payment Date</label>
            <p class="text-gray-900">{{ $commissionPayment->payment_date }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Policy</label>
            <p class="text-gray-900">{{ $commissionPayment->policy->policy_number ?? 'N/A' }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Amount</label>
            <p class="text-gray-900">KES {{ number_format($commissionPayment->amount, 2) }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Payment Method</label>
            <p class="text-gray-900">{{ $commissionPayment->payment_method }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Reference Number</label>
            <p class="text-gray-900">{{ $commissionPayment->reference_number }}</p>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button" class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Close</button>
        </div>
    </div>
</section>