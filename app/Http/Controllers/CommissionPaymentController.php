<?php

namespace App\Http\Controllers;

use App\Models\CommissionPayment;
use App\Http\Requests\StoreCommissionPaymentRequest;
use App\Http\Requests\UpdateCommissionPaymentRequest;
use App\Models\Policy;

class CommissionPaymentController extends Controller {
    public function index() {
        $commissionPayments = CommissionPayment::with('policy')->paginate(15);
        $total_payments = CommissionPayment::count();
        $total_paid = CommissionPayment::sum('total_commission_amount');

        return view('commission-payments.index', compact(
            'commissionPayments',
            'total_payments',
            'total_paid'
        ));
    }

    public function create() {
        return view('commission-payments.create');
    }

    public function store(StoreCommissionPaymentRequest $request) {
        CommissionPayment::create($request->validated());
        return redirect()->route('commission-payments.index')->with('success', 'Commission payment created.');
    }

    public function show(CommissionPayment $commissionPayment) {
        return view('commission-payments.show', compact('commissionPayment'));
    }

    public function edit(CommissionPayment $commissionPayment) {
        return view('commission-payments.edit', compact('commissionPayment'));
    }

    public function update(UpdateCommissionPaymentRequest $request, CommissionPayment $commissionPayment) {
        $commissionPayment->update($request->validated());
        return redirect()->route('commission-payments.index')->with('success', 'Commission payment updated.');
    }

    public function destroy(CommissionPayment $commissionPayment) {
        $commissionPayment->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Commission payment deleted successfully.']);
        }
        return redirect()->route('commission-payments.index')->with('success', 'Commission payment deleted.');
    }
}
