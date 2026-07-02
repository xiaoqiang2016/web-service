@extends('admin.layouts.master')

@section('title', 'User Management')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">Admin Users</h3>
            <a href="{{ route('admin.admin-users.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Add User</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">ID</th>
                    <th class="text-left py-2">Username</th>
                    <th class="text-left py-2">Real Name</th>
                    <th class="text-left py-2">Role</th>
                    <th class="text-left py-2">Email</th>
                    <th class="text-left py-2">Status</th>
                    <th class="text-left py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="py-2">{{ $user->id }}</td>
                        <td class="py-2">{{ $user->username }}</td>
                        <td class="py-2">{{ $user->real_name }}</td>
                        <td class="py-2">{{ $user->role?->role_name ?? '-' }}</td>
                        <td class="py-2">{{ $user->email }}</td>
                        <td class="py-2">
                            @if($user->status == 1)
                                <span class="text-green-500">Active</span>
                            @else
                                <span class="text-red-500">Inactive</span>
                            @endif
                        </td>
                        <td class="py-2">
                            <a href="{{ route('admin.admin-users.edit', $user) }}" class="text-secondary hover:underline">Edit</a>
                            <form action="{{ route('admin.admin-users.destroy', $user) }}" method="POST" class="inline">
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
            {{ $users->links() }}
        </div>
    </div>
@endsection
