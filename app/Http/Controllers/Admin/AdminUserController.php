<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = AdminUser::with('role')->paginate(10);
        return view('admin.admin_users.index', compact('users'));
    }

    public function create()
    {
        $roles = AdminRole::all();
        return view('admin.admin_users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin_users',
            'password' => 'required|min:6',
            'real_name' => 'nullable|string',
            'role_id' => 'required|exists:admin_roles,id',
            'email' => 'nullable|email',
            'status' => 'boolean',
        ]);

        AdminUser::create([
            'username' => $request->username,
            'password' => $request->password,
            'real_name' => $request->real_name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.admin-users.index')->with('success', 'User created');
    }

    public function edit(AdminUser $adminUser)
    {
        $roles = AdminRole::all();
        return view('admin.admin_users.edit', compact('adminUser', 'roles'));
    }

    public function update(Request $request, AdminUser $adminUser)
    {
        $request->validate([
            'username' => 'required|unique:admin_users,username,' . $adminUser->id,
            'real_name' => 'nullable|string',
            'role_id' => 'required|exists:admin_roles,id',
            'email' => 'nullable|email',
            'status' => 'boolean',
        ]);

        $data = [
            'username' => $request->username,
            'real_name' => $request->real_name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'status' => $request->status ?? 1,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $adminUser->update($data);

        return redirect()->route('admin.admin-users.index')->with('success', 'User updated');
    }

    public function destroy(AdminUser $adminUser)
    {
        $adminUser->delete();
        return redirect()->route('admin.admin-users.index')->with('success', 'User deleted');
    }
}
