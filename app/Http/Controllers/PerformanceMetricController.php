<?php

namespace App\Http\Controllers;

use App\Models\PerformanceMetric;

class PerformanceMetricController extends Controller {
    public function index() {
        $performanceMetrics = PerformanceMetric::with(['agent', 'company', 'policyType'])->paginate(15);
        return view('performance-metrics.index', compact('performanceMetrics'));
    }

    public function create() {
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        $companies = \App\Models\InsuranceCompany::all();
        $policyTypes = \App\Models\PolicyType::all();
        return view('performance-metrics.create', compact('agents', 'companies', 'policyTypes'));
    }

    public function show(PerformanceMetric $performanceMetric) {
        $performanceMetric->load(['agent', 'company', 'policyType']);
        return view('performance-metrics.show', compact('performanceMetric'));
    }
}
