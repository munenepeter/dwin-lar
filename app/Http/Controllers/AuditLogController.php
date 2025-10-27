<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * AuditLogController
 * Handles system audit logs and activity tracking
 */
class AuditLogController extends Controller {
    public function index(Request $request) {
        $query = DB::table('activity_log') // Adjust table name based on your setup
            ->orderBy('created_at', 'desc');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id);
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('description', 'like', '%' . $request->action . '%');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);

        // Get filter options
        $users = DB::table('users')->select('id', 'full_name')->get();

        return view('admin.audit-logs.index', compact('logs', 'users'));
    }
}
