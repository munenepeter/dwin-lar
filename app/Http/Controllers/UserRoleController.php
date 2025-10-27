<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use App\Http\Requests\StoreUserRoleRequest;
use App\Http\Requests\UpdateUserRoleRequest;

class UserRoleController extends Controller {
    public function index() {
        $userRoles = UserRole::paginate(15);
        return view('user-roles.index', compact('userRoles'));
    }

    public function create() {
        return view('user-roles.create');
    }

    public function store(StoreUserRoleRequest $request) {
        UserRole::create($request->validated());
        return redirect()->route('user-roles.index')->with('success', 'Role created.');
    }

    public function show(UserRole $userRole) {
        return view('user-roles.show', compact('userRole'));
    }

    public function edit(UserRole $userRole) {
        return view('user-roles.edit', compact('userRole'));
    }

    public function update(UpdateUserRoleRequest $request, UserRole $userRole) {
        $userRole->update($request->validated());
        return redirect()->route('user-roles.index')->with('success', 'Role updated.');
    }

    public function destroy(UserRole $userRole) {
        $userRole->delete();
        return redirect()->route('user-roles.index')->with('success', 'Role deleted.');
    }
}
