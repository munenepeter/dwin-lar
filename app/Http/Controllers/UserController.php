<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller {

    public function create() {
        $roles = \App\Models\UserRole::all();
        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request) {
        $user = User::create($request->validated() + ['password_hash' => bcrypt($request->password)]); // Hash password
        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function show(User $user) {
        $user->load('role');
        return view('users.show', compact('user'));
    }

    public function edit(User $user) {
        $roles = \App\Models\UserRole::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user) {
        $data = $request->validated();
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    // Custom: Agent performance report (calls stored proc)
    public function performanceReport(User $user, Request $request) {
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->endOfMonth()->toDateString();
        $report = DB::select('CALL GetAgentPerformanceReport(?, ?, ?)', [$user->id, $startDate, $endDate]);
        return view('users.performance-report', compact('user', 'report', 'startDate', 'endDate'));
    }
    /**
     * Display the users index page with dynamic tabs
     */
    public function index(Request $request) {
        $activeTab = $request->get('tab', 'all-users');

        // ---- COMMON DATA (stats, roles, etc.) ----
        $totalUsers      = User::count();
        $activeCount     = User::where('is_active', 1)->count();
        $activePercentage = $totalUsers > 0 ? round(($activeCount / $totalUsers) * 100) : 0;
        $user_roles      = UserRole::all();
        $roles           = UserRole::select('id', 'role_name')->get();

        // ---- PARTIAL DATA PER TAB ----
        $partialData = [
            'all-users'          => $this->usersTabData($request),
            'roles-permissions' => $this->rolesTabData($request),
            'user-activity'      => $this->activityTabData($request),
            'access-control'     => $this->accessTabData($request),
        ];

        // ---- AJAX REQUESTS ----
        if ($request->ajax() || $request->wantsJson()) {
            $partial = match ($activeTab) {
                'all-users'          => 'users.partials.users-tab',
                'roles-permissions' => 'users.partials.roles',
                'user-activity'      => 'users.partials.activity',
                'access-control'     => 'users.partials.access',
                default              => 'users.partials.users-tab',
            };

            return view($partial, $partialData[$activeTab] ?? [])->render();
        }

        // ---- FULL PAGE ----
        return view('users.index', compact(
            'activeTab',
            'totalUsers',
            'activeCount',
            'activePercentage',
            'user_roles',
            'roles',
            'partialData'
        ));
    }
    private function usersTabData(Request $request): array {
        $query = User::with('role')
            ->when($request->filled('search'), fn($q) => $q->where(function ($sq) use ($request) {
                $term = $request->search;
                $sq->where('first_name', 'like', "%{$term}%")
                    ->orWhere('last_name',  'like', "%{$term}%")
                    ->orWhere('email',      'like', "%{$term}%")
                    ->orWhere('username',   'like', "%{$term}%");
            }))
            ->when($request->filled('role'), fn($q) => $q->where('role_id', $request->role))
            ->when($request->filled('status'), fn($q) => $q->where('is_active', $request->status === 'active'))
            ->orderByDesc('created_at');

        return ['users' => $query->paginate(5)];
    }

    private function rolesTabData(Request $request): array {
        $roles = UserRole::withCount('users')
            ->where('is_active', true)
            ->orderBy('role_name')
            ->get();

        $permissions = $this->getAvailablePermissions();

        return compact('roles', 'permissions');
    }

    private function activityTabData(Request $request): array {
        $perPage = 5;
        $page = max(1, (int) $request->get('page', 1));
        $activity_type = $request->get('activity_type', 'all');
        $user_id = $request->filled('user_id') && $request->user_id !== 'all' ? $request->user_id : null;

        $activities = collect();

        // === 1. Fetch Audit Logs (INSERT, UPDATE, DELETE) ===
        if (in_array($activity_type, ['all', 'changes'])) {
            $auditQuery = DB::table('audit_log')
                ->leftJoin('users', 'audit_log.user_id', '=', 'users.id')
                ->select(
                    'audit_log.id as activity_id',
                    'audit_log.created_at',
                    'audit_log.user_id',
                    'audit_log.action_type',
                    'audit_log.table_name',
                    DB::raw('NULL as notification_type'),
                    DB::raw('NULL as is_read'),
                    'users.first_name',
                    'users.last_name',
                    DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_name")
                )
                ->when($activity_type === 'changes', fn($q) => $q->whereIn('audit_log.action_type', ['INSERT', 'UPDATE', 'DELETE']))
                ->when($user_id, fn($q) => $q->where('audit_log.user_id', $user_id))
                ->orderByDesc('audit_log.created_at');

            $auditResults = $auditQuery->get();
            $activities = $activities->merge($auditResults);
        }

        // === 2. Fetch Notifications (including login if applicable) ===
        if (in_array($activity_type, ['all', 'notifications', 'login'])) {
            $notifQuery = DB::table('notifications')
                ->leftJoin('users', 'notifications.target_user_id', '=', 'users.id')
                ->select(
                    'notifications.id as activity_id',
                    'notifications.created_at',
                    'notifications.target_user_id as user_id',
                    DB::raw('"Notification" as action_type'),
                    'notifications.related_table as table_name',
                    'notifications.notification_type',
                    'notifications.is_read',
                    'users.first_name',
                    'users.last_name',
                    DB::raw("CONCAT(users.first_name, ' ', users.last_name) as user_name")
                )
                ->when($activity_type === 'login', fn($q) => $q->where('notifications.notification_type', 'USER_LOGIN'))
                ->when($user_id, fn($q) => $q->where('notifications.target_user_id', $user_id))
                ->orderByDesc('notifications.created_at');

            $notifResults = $notifQuery->get();
            $activities = $activities->merge($notifResults);
        }

        // === 3. Sort all combined activities by created_at ===
        $sortedActivities = $activities->sortByDesc('created_at');

        // === 4. Manual Pagination using LengthAwarePaginator ===
        $total = $sortedActivities->count();
        $items = $sortedActivities->forPage($page, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // === 5. Get Users for Filter Dropdown ===
        $users = User::where('is_active', true)->orderBy('first_name')->get();

        return compact('paginated', 'users');
    }

    private function accessTabData(Request $request): array {
        $rolePermissions = UserRole::where('is_active', true)
            ->orderBy('role_name')
            ->get();

        $permissions = $this->getAvailablePermissionsWithDescriptions();

        return compact('rolePermissions', 'permissions');
    }

    /**
     * Store methods for the different tabs
     */

    /**
     * Store/Update role permissions
     */
    public function updateRolePermissions(Request $request) {
        $request->validate([
            'role_id' => 'required|exists:user_roles,id',
            'permissions' => 'array',
            'permissions.*' => 'string'
        ]);

        try {
            $role = UserRole::findOrFail($request->role_id);
            $role->permissions = json_encode($request->permissions ?? []);
            $role->save();

            return response()->json([
                'success' => true,
                'message' => 'Permissions updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store new role
     */
    public function storeRole(Request $request) {
        $request->validate([
            'role_name' => 'required|string|max:50|unique:user_roles,role_name',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'is_active' => 'boolean'
        ]);

        try {
            $role = UserRole::create([
                'role_name' => $request->role_name,
                'description' => $request->description,
                'permissions' => json_encode($request->permissions ?? []),
                'is_active' => $request->boolean('is_active', true)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'role' => $role
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update existing role
     */
    public function updateRole(Request $request, $id) {
        $request->validate([
            'role_name' => 'required|string|max:50|unique:user_roles,role_name,' . $id,
            'description' => 'nullable|string',
            'permissions' => 'array',
            'is_active' => 'boolean'
        ]);

        try {
            $role = UserRole::findOrFail($id);
            $role->update([
                'role_name' => $request->role_name,
                'description' => $request->description,
                'permissions' => json_encode($request->permissions ?? []),
                'is_active' => $request->boolean('is_active', true)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'role' => $role
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get role for editing
     */
    public function getRole($id) {
        try {
            $role = UserRole::findOrFail($id);
            return response()->json($role);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Role not found'
            ], 404);
        }
    }

    /**
     * Delete role
     */
    public function deleteRole($id) {
        try {
            $role = UserRole::findOrFail($id);

            // Check if role has users assigned
            if ($role->users()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete role that has users assigned. Please reassign users first.'
                ], 422);
            }

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to get available permissions
     */
    private function getAvailablePermissions() {
        return [
            'users.view' => 'View users',
            'users.create' => 'Create users',
            'users.edit' => 'Edit users',
            'users.delete' => 'Delete users',
            'roles.view' => 'View roles',
            'roles.create' => 'Create roles',
            'roles.edit' => 'Edit roles',
            'roles.delete' => 'Delete roles',
            'clients.view' => 'View clients',
            'clients.create' => 'Create clients',
            'clients.edit' => 'Edit clients',
            'clients.delete' => 'Delete clients',
            'policies.view' => 'View policies',
            'policies.create' => 'Create policies',
            'policies.edit' => 'Edit policies',
            'policies.delete' => 'Delete policies',
            'commissions.view' => 'View commissions',
            'commissions.manage' => 'Manage commissions',
            'reports.view' => 'View reports',
            'settings.manage' => 'Manage system settings',
        ];
    }

    /**
     * Helper method to get permissions with descriptions for access control
     */
    private function getAvailablePermissionsWithDescriptions() {
        return [
            'users.view' => 'Can view user lists and details',
            'users.create' => 'Can create new users',
            'users.edit' => 'Can edit existing users',
            'users.delete' => 'Can delete users',
            'roles.view' => 'Can view role lists and permissions',
            'roles.create' => 'Can create new roles',
            'roles.edit' => 'Can edit role permissions and details',
            'roles.delete' => 'Can delete roles',
            'clients.view' => 'Can view client information',
            'clients.create' => 'Can register new clients',
            'clients.edit' => 'Can update client information',
            'clients.delete' => 'Can deactivate or delete clients',
            'policies.view' => 'Can view policy details',
            'policies.create' => 'Can create new insurance policies',
            'policies.edit' => 'Can update policy information',
            'policies.delete' => 'Can cancel or delete policies',
            'commissions.view' => 'Can view commission calculations',
            'commissions.manage' => 'Can process commission payments',
            'reports.view' => 'Can access and view system reports',
            'settings.manage' => 'Can modify system settings and configurations',
        ];
    }
}
