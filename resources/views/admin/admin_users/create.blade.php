@extends('admin.layouts.master')

@section('title', 'Add User')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">Add Admin User</h3>
        
        <form action="{{ route('admin.admin-users.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Username *</label>
                <input type="text" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ old('username') }}" required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Password *</label>
                <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Real Name</label>
                <input type="text" name="real_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ old('real_name') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Role *</label>
                <select name="role_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Status</label>
                <input type="checkbox" name="status" value="1" {{ old('status', 1) ? 'checked' : '' }}>
            </div>

            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Create</button>
        </form>
    </div>
@endsection
