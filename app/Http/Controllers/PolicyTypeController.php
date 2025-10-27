<?php

namespace App\Http\Controllers;

use App\Models\PolicyType;
use App\Http\Requests\StorePolicyTypeRequest;
use App\Http\Requests\UpdatePolicyTypeRequest;

class PolicyTypeController extends Controller {
    public function index() {
        $policyTypes = PolicyType::paginate(15);
        return view('policy-types.index', compact('policyTypes'));
    }

    public function create() {
        return view('policy-types.create');
    }

    public function store(StorePolicyTypeRequest $request) {
        PolicyType::create($request->validated());
        return redirect()->route('policy-types.index')->with('success', 'Policy type created.');
    }

    public function show(PolicyType $policyType) {
        $policyType->load(['commissionStructures', 'policies']);
        return view('policy-types.show', compact('policyType'));
    }

    public function edit(PolicyType $policyType) {
        return view('policy-types.edit', compact('policyType'));
    }

    public function update(UpdatePolicyTypeRequest $request, PolicyType $policyType) {
        $policyType->update($request->validated());
        return redirect()->route('policy-types.index')->with('success', 'Policy type updated.');
    }

    public function destroy(PolicyType $policyType) {
        $policyType->delete();
        return redirect()->route('policy-types.index')->with('success', 'Policy type deleted.');
    }
}
