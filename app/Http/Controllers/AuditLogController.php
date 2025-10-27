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
        $query = DB::table('audit_log')
            ->orderBy('created_at', 'desc');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by table name
        if ($request->filled('table_name')) {
            $query->where('table_name', 'like', '%' . $request->action . '%');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(3);

        // Get filter options
        $users = DB::table('users')->select('id', 'full_name')->get();
        $tables = DB::table('audit_log')->select('table_name')->distinct()->get();


        return view('admin.audit-logs.index', compact('logs', 'users', 'tables'));
    }
}
