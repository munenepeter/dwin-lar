<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller {
    public function index(Request $request) {
        $perPage = 15;
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $kyc_status = $request->get('kyc_status', '');
        
        // Build query with filters
        $query = Client::with('assignedAgent');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_primary', 'like', "%{$search}%")
                  ->orWhere('client_code', 'like', "%{$search}%");
            });
        }
        
        if ($status) {
            $query->where('client_status', $status);
        }
        
        if ($kyc_status) {
            $query->where('kyc_status', $kyc_status);
        }
        
        $clients = $query->paginate($perPage);
        
        // Get counts for dashboard cards
        $totalClientsCount = Client::count();
        $activeClients = Client::where('client_status', 'ACTIVE')->count();
        $kycVerifiedClients = Client::where('kyc_status', 'VERIFIED')->count();
        $kycPendingClients = Client::where('kyc_status', 'PENDING')->count();
        
        return view('clients.index', compact(
            'clients', 
            'totalClientsCount', 
            'activeClients', 
            'kycVerifiedClients', 
            'kycPendingClients',
            'search',
            'status',
            'kyc_status'
        ));
    }

    public function create() {
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        return view('clients.form', compact('agents'));
    }

    public function store(StoreClientRequest $request) {
        try {
            $clientCode = 'CL' . now()->year . str_pad(Client::count() + 1, 4, '0', STR_PAD_LEFT);
            
            $client = Client::create($request->validated() + ['client_code' => $clientCode]);
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Client created successfully.']);
            }
            
            return redirect()->route('clients.index')->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error creating client: ' . $e->getMessage()]);
            }
            
            return back()->with('error', 'Error creating client: ' . $e->getMessage());
        }
    }

    public function show(Client $client) {
        // Load related data for the show view
        $client->load('assignedAgent');
        
        // Get policies
        $policies = DB::select('
            SELECT 
                p.policy_number,
                pt.type_name as policy_type,
                ic.company_name,
                p.premium_amount,
                p.policy_status,
                p.expiry_date,
                DATEDIFF(p.expiry_date, CURDATE()) as days_to_expiry
            FROM policies p
            LEFT JOIN policy_types pt ON p.policy_type_id = pt.id
            LEFT JOIN insurance_companies ic ON p.company_id = ic.id
            WHERE p.client_id = ?
            ORDER BY p.expiry_date DESC
        ', [$client->id]);
        
        // Get documents
        $documents = DB::select('
            SELECT 
                d.document_type,
                d.document_name,
                d.is_verified,
                d.created_at as document_uploaded_at,
                CONCAT(u.first_name, " ", u.last_name) as uploaded_by_name
            FROM client_documents d
            LEFT JOIN users u ON d.uploaded_by = u.id
            WHERE d.client_id = ?
            ORDER BY d.created_at DESC
        ', [$client->id]);
        
        // Get notifications
        $notifications = DB::select('
            SELECT 
                title,
                message,
                priority,
                created_at,
                CASE 
                    WHEN priority = "HIGH" THEN "border-red-500 bg-red-50"
                    WHEN priority = "MEDIUM" THEN "border-yellow-500 bg-yellow-50" 
                    ELSE "border-blue-500 bg-blue-50"
                END as priority_class
            FROM notifications 
            WHERE related_record_id = ?
            ORDER BY created_at DESC 
            LIMIT 10
        ', [$client->id]);
        
        // Get audit logs
        $auditLogs = \App\Models\AuditLog::where('table_name', 'clients')
        ->where('record_id', $client->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
            
        return view('clients.show', compact(
            'client',
            'policies',
            'documents', 
            'notifications',
            'auditLogs'
        ));
    }

    public function edit(Client $client) {
        $agents = \App\Models\User::whereHas('role', fn($q) => $q->where('role_name', 'Agent'))->get();
        
        return view('clients.form', compact('client', 'agents'));
    }


    public function update(UpdateClientRequest $request, Client $client) {
        try {
            $client->update($request->validated());
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Client updated successfully.']);
            }
            
            return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error updating client: ' . $e->getMessage()]);
            }
            
            return back()->with('error', 'Error updating client: ' . $e->getMessage());
        }
    }

    public function destroy(Client $client) {
        try {
            $client->delete();
            return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting client: ' . $e->getMessage());
        }
    }

    // AJAX endpoint for modal view
    public function view(Client $client) {
        $client->load('assignedAgent');
        return view('clients.show-partial', compact('client')); // You might want a partial view for modal
    }

    // Custom: Policy summary (calls stored proc)
    public function policySummary(Client $client) {
        $summary = DB::select('CALL GetClientPolicySummary(?)', [$client->id]);
        return view('clients.policy-summary', compact('client', 'summary'));
    }
}
