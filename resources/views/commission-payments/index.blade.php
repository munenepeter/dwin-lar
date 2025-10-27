<x-layouts.app>

    <main class="flex-1 bg-gray-50 p-4 shadow-xs rounded-md overflow-hidden">
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Commission Payments</h1>
                    <p class="text-muted-foreground">Manage commission payments</p>
                </div>
                <button id="openCreatePaymentDialog" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-colors bg-red-500 hover:bg-red-600 text-white h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle mr-2 h-4 w-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="16"></line>
                        <line x1="8" y1="12" x2="16" y2="12"></line>
                    </svg>
                    Add Payment
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <!-- Total Payments Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Payments</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign h-4 w-4 text-blue-600">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold" id="totalPayments">{{ $total_payments }}</div>
                        <p class="text-xs text-gray-500">All commission payments</p>
                    </div>
                </div>

                <!-- Total Paid Card -->
                <div class="rounded-lg border border-gray-300 bg-white p-6 shadow-sm">
                    <div class="flex flex-row items-center justify-between">
                        <h3 class="tracking-tight text-sm font-medium">Total Paid</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-coins h-4 w-4 text-green-600">
                            <circle cx="8" cy="8" r="6"></circle>
                            <path d="M18.09 10.37A6 6 0 1 1 10.34 18"></path>
                            <path d="M7 6h1v4"></path>
                            <path d="m16.71 13.88.7.71-2.82 2.82"></path>
                        </svg>
                    </div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold" id="totalPaid">KES {{ number_format($total_paid, 2) }}</div>
                        <p class="text-xs text-gray-500">Total amount paid</p>
                    </div>
                </div>
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

            <!-- Table -->
            <div class="rounded-lg border border-gray-300 bg-white shadow-sm">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Commission Payments</h3>
                    <p class="text-sm text-gray-500">Manage commission payments and their details</p>
                </div>
                <div class="p-6 pt-0">
                    <div class="relative w-full overflow-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-300">
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Payment Date</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Policy</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Amount</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Payment Method</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Reference Number</th>
                                    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($commissionPayments->isNotEmpty())
                                @foreach ($commissionPayments as $payment)
                                <tr class="border-b border-gray-300 hover:bg-gray-50">
                                    <td class="p-4 align-middle">{{ $payment->payment_date }}</td>
                                    <td class="p-4 align-middle">{{ $payment->policy->policy_number ?? 'N/A' }}</td>
                                    <td class="p-4 align-middle">KES {{ number_format($payment->amount, 2) }}</td>
                                    <td class="p-4 align-middle">{{ $payment->payment_method }}</td>
                                    <td class="p-4 align-middle">{{ $payment->reference_number }}</td>
                                    <td class="p-4 align-middle">
                                        <button class="open-edit-payment-dialog" data-payment-id="{{ $payment->id }}">Edit</button>
                                        <button class="delete-payment-button" data-payment-id="{{ $payment->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="p-4 text-center">No payments found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $commissionPayments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Payment Dialog -->
    <dialog id="createPaymentDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="createPaymentFormContent"></div>
        </div>
    </dialog>

    <!-- Edit Payment Dialog -->
    <dialog id="editPaymentDialog" class="fixed top-0 right-0 z-50 w-full max-w-md h-full p-2 bg-white shadow-lg rounded-l-sm">
        <div class="relative w-full">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center close-dialog">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div id="editPaymentFormContent"></div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            //hide id="alert-section" after some few seconds
            setTimeout(() => {
                const alertSection = document.getElementById('alert-section');
                if (alertSection) {
                    alertSection.style.display = 'none';
                }
            }, 4000); // 4 seconds

            const createPaymentDialog = document.getElementById('createPaymentDialog');
            const editPaymentDialog = document.getElementById('editPaymentDialog');
            const closeDialogButtons = document.querySelectorAll('.close-dialog');

            document.getElementById('openCreatePaymentDialog').addEventListener('click', function() {
                fetch('/admin/commission-payments/create')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('createPaymentFormContent').innerHTML = html;
                        createPaymentDialog.showModal();
                        window.initializeCommissionPaymentForm();
                    })
                    .catch(error => {
                        console.error('Error loading create payment form:', error);
                    });
            });

            document.querySelectorAll('.open-edit-payment-dialog').forEach(button => {
                button.addEventListener('click', function() {
                    const paymentId = this.getAttribute('data-payment-id');
                    fetch(`/admin/commission-payments/${paymentId}/edit`)
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('editPaymentFormContent').innerHTML = html;
                            editPaymentDialog.showModal();
                            window.initializeCommissionPaymentForm();
                        })
                        .catch(error => {
                            console.error('Error loading edit payment form:', error);
                        });
                });
            });

            closeDialogButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('dialog').close();
                });
            });

            [createPaymentDialog, editPaymentDialog].forEach(dialog => {
                if (dialog) {
                    dialog.addEventListener('click', function(event) {
                        if (event.target === dialog) {
                            dialog.close();
                        }
                    });
                }
            });

            document.querySelectorAll('.delete-payment-button').forEach(button => {
                button.addEventListener('click', function() {
                    const paymentId = this.getAttribute('data-payment-id');
                    if (confirm('Are you sure you want to delete this payment? This action cannot be undone.')) {
                        fetch(`/admin/commission-payments/${paymentId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('tr').remove();
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting payment:', error);
                                alert('An error occurred while deleting the payment.');
                            });
                    }
                });
            });
        });
    </script>
</x-layouts.app>
