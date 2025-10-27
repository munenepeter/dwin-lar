### 8. CommissionPaymentController
```php
<?php

namespace App\Http\Controllers;

use App\Models\CommissionPayment;
use App\Http\Requests\StoreCommissionPaymentRequest;
use App\Http\Requests\UpdateCommissionPaymentRequest;
use Illuminate\Support\Facades\Auth;

class CommissionPaymentController extends Controller {
    public function index() {
        $commissionPayments = CommissionPayment::with(['agent', 'processedBy'])->paginate(15);
        return view('commission-payments.index', compact('commissionPayments'));
    }

    public function create() {
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('commission-payments.create', compact('agents'));
    }

    public function store(StoreCommissionPaymentRequest $request) {
        $data = $request->validated();
        $data['processed_by'] = Auth::id();
        CommissionPayment::create($data);
        return redirect()->route('commission-payments.index')->with('success', 'Commission payment created.');
    }

    public function show(CommissionPayment $commissionPayment) {
        $commissionPayment->load(['agent', 'processedBy', 'paymentItems']);
        return view('commission-payments.show', compact('commissionPayment'));
    }

    public function edit(CommissionPayment $commissionPayment) {
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('commission-payments.edit', compact('commissionPayment', 'agents'));
    }

    public function update(UpdateCommissionPaymentRequest $request, CommissionPayment $commissionPayment) {
        $data = $request->validated();
        $data['processed_by'] = Auth::id();
        $commissionPayment->update($data);
        return redirect()->route('commission-payments.index')->with('success', 'Commission payment updated.');
    }

    public function destroy(CommissionPayment $commissionPayment) {
        $commissionPayment->delete();
        return redirect()->route('commission-payments.index')->with('success', 'Commission payment deleted.');
    }
}
