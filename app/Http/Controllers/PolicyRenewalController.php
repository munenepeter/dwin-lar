<?php

namespace App\Http\Controllers;

use App\Models\PolicyRenewal;
use App\Http\Requests\StorePolicyRenewalRequest;
use App\Http\Requests\UpdatePolicyRenewalRequest;

class PolicyRenewalController extends Controller {
    public function index() {
        $policyRenewals = PolicyRenewal::with(['originalPolicy', 'newPolicy', 'agent'])->paginate(15);
        return view('policy-renewals.index', compact('policyRenewals'));
    }

    public function create() {
        $policies = \App\Models\Policy::all();
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('policy-renewals.create', compact('policies', 'agents'));
    }

    public function store(StorePolicyRenewalRequest $request) {
        PolicyRenewal::create($request->validated());
        return redirect()->route('policy-renewals.index')->with('success', 'Policy renewal created.');
    }

    public function show(PolicyRenewal $policyRenewal) {
        $policyRenewal->load(['originalPolicy', 'newPolicy', 'agent']);
        return view('policy-renewals.show', compact('policyRenewal'));
    }

    public function edit(PolicyRenewal $policyRenewal) {
        $policies = \App\Models\Policy::all();
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('policy-renewals.edit', compact('policyRenewal', 'policies', 'agents'));
    }

    public function update(UpdatePolicyRenewalRequest $request, PolicyRenewal $policyRenewal) {
        $policyRenewal->update($request->validated());
        return redirect()->route('policy-renewals.index')->with('success', 'Policy renewal updated.');
    }

    public function destroy(PolicyRenewal $policyRenewal) {
        $policyRenewal->delete();
        return redirect()->route('policy-renewals.index')->with('success', 'Policy renewal deleted.');
    }
}
