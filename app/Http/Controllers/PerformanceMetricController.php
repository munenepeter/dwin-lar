<?php

namespace App\Http\Controllers;

use App\Models\PerformanceMetric;

class PerformanceMetricController extends Controller {
    public function index() {
        $performanceMetrics = PerformanceMetric::with(['agent', 'company', 'policyType'])->paginate(15);
        return view('performance-metrics.index', compact('performanceMetrics'));
    }

    public function show(PerformanceMetric $performanceMetric) {
        $performanceMetric->load(['agent', 'company', 'policyType']);
        return view('performance-metrics.show', compact('performanceMetric'));
    }
}
