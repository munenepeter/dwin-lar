@php
    $isEdit = isset($commission_payment) && $commission_payment !== null;
    $formAction = $isEdit
        ? route('commission-payments.update', $commission_payment)
        : route('commission-payments.store');
    $dialogTitle = $isEdit ? 'Edit Commission Payment' : 'Add New Commission Payment';

    // Default values for new commission payment
    $commission_payment =
        $commission_payment ??
        (object) [
            'id' => '',
            'payment_date' => '',
            'policy_id' => '',
            'amount' => '',
            'payment_method' => '',
            'reference_number' => '',
        ];
@endphp

<section class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
    <h3 class="text-2xl font-semibold leading-none tracking-tight mb-4">{{ $dialogTitle }}</h3>
    <form id="commission-payment-form" action="{{ $formAction }}" method="POST"
        class="space-y-4 p-4 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif
        <input type="hidden" name="signature" value="{{ md5(uniqid($commission_payment->id ?? 'NEW')) }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date</label>
                <input type="date" id="payment_date" name="payment_date"
                    value="{{ $commission_payment->payment_date }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
            </div>
            <div>
                <label for="policy_id" class="block text-sm font-medium text-gray-700">Policy</label>
                <select id="policy_id" name="policy_id"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
                    <option value="">Select Policy</option>
                    {{-- @foreach ($policies as $policy)
                        <option value="{{ $policy->id }}" {{ $commission_payment->policy_id == $policy->id ? 'selected' : '' }}>
                            {{ $policy->policy_number }}
                        </option>
                    @endforeach --}}
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" id="amount" name="amount"
                    value="{{ $commission_payment->amount }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5"
                    required>
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <input type="text" id="payment_method" name="payment_method"
                    value="{{ $commission_payment->payment_method }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="reference_number" class="block text-sm font-medium text-gray-700">Reference Number</label>
                <input type="text" id="reference_number" name="reference_number"
                    value="{{ $commission_payment->reference_number }}"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-600 focus:border-red-600 block w-full p-2.5">
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <button type="button"
                class="close-dialog px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                {{ $isEdit ? 'Update Commission Payment' : 'Create Commission Payment' }}
            </button>
        </div>
    </form>
</section>

<script>
    // JS validation remains as client-side enhancement.
    window.initializeCommissionPaymentForm = function() {
        const commissionPaymentForm = document.getElementById('commission-payment-form');

        commissionPaymentForm.addEventListener('submit', (event) => {
            // Form validation
            const formData = new FormData(event.target);
            const payment = {};
            for (const [key, value] of formData.entries()) {
                payment[key] = value;
            }
            const errors = validateCommissionPayment(payment);
            if (Object.keys(errors).length > 0) {
                event.preventDefault();
                const inputs = commissionPaymentForm.elements;
                for (const input of inputs) {
                    if (errors[input.name]) {
                        input.setCustomValidity(errors[input.name]);
                        input.reportValidity();
                    } else {
                        input.setCustomValidity('');
                    }
                }
            }
        });

        function validateCommissionPayment(payment) {
            const errors = {};
            if (!payment.payment_date) {
                errors.payment_date = 'Payment date is required';
            }
            if (!payment.policy_id) {
                errors.policy_id = 'Policy is required';
            }
            if (!payment.amount) {
                errors.amount = 'Amount is required';
            } else if (isNaN(payment.amount)) {
                errors.amount = 'Amount must be a number';
            }
            return errors;
        }
    };
</script>