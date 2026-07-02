<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
{
    public function index()
    {
        $roles = AdminRole::paginate(10);
        return view('admin.admin_roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.admin_roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:admin_roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        AdminRole::create([
            'role_name' => $request->role_name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.admin-roles.index')->with('success', 'Role created');
    }

    public function edit(AdminRole $adminRole)
    {
        return view('admin.admin_roles.edit', compact('adminRole'));
    }

    public function update(Request $request, AdminRole $adminRole)
    {
        $request->validate([
            'role_name' => 'required|unique:admin_roles,role_name,' . $adminRole->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ]);

        $adminRole->update([
            'role_name' => $request->role_name,
            'description' => $request->description,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.admin-roles.index')->with('success', 'Role updated');
    }

    public function destroy(AdminRole $adminRole)
    {
        $adminRole->delete();
        return redirect()->route('admin.admin-roles.index')->with('success', 'Role deleted');
    }
}
