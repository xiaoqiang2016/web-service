@extends('admin.layouts.master')

@section('title', 'Role Management')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">Admin Roles</h3>
            <a href="{{ route('admin.admin-roles.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Add Role</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">ID</th>
                    <th class="text-left py-2">Role Name</th>
                    <th class="text-left py-2">Description</th>
                    <th class="text-left py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td class="py-2">{{ $role->id }}</td>
                        <td class="py-2">{{ $role->role_name }}</td>
                        <td class="py-2">{{ $role->description }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.admin-roles.edit', $role) }}" class="text-secondary hover:underline">Edit</a>
                            <form action="{{ route('admin.admin-roles.destroy', $role) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </div>
@endsection
