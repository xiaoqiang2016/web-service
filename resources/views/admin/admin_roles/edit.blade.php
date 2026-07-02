@extends('admin.layouts.master')

@section('title', 'Edit Role')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">Edit Admin Role</h3>
        
        <form action="{{ route('admin.admin-roles.update', $adminRole) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Role Name *</label>
                <input type="text" name="role_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ old('role_name', $adminRole->role_name) }}" required>
                @error('role_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Description</label>
                <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description', $adminRole->description) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Permissions</label>
                <div class="grid grid-cols-2 gap-2">
                    @php
                        $permissions = [
                            'products' => 'Products',
                            'articles' => 'Articles',
                            'categories' => 'Categories',
                            'banners' => 'Banners',
                            'messages' => 'Messages',
                            'faqs' => 'FAQs',
                            'contact-settings' => 'Contact Settings',
                            'admin-users' => 'User Management',
                            'admin-roles' => 'Role Management',
                            'about' => 'About Us',
                            'honor-images' => 'Honor Images',
                            'factory-images' => 'Factory Images',
                        ];
                        $currentPermissions = $adminRole->permissions ?? [];
                        if (is_string($currentPermissions)) {
                            $currentPermissions = json_decode($currentPermissions, true) ?: [];
                        }
                    @endphp
                    @foreach($permissions as $key => $label)
                        <label class="flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ in_array($key, $currentPermissions) ? 'checked' : '' }} class="mr-2">
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Update</button>
        </form>
    </div>
@endsection
