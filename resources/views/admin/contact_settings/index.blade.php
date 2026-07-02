@extends('admin.layouts.master')

@section('title', 'Contact Settings')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">Contact Settings</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($settings as $setting)
                <div class="border p-4 rounded-lg">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-semibold">{{ $setting->translation?->label ?? $setting->key }}</h4>
                        <span class="text-xs px-2 py-1 rounded {{ $setting->is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600' }}">
                            {{ $setting->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-gray-600 mb-2">{{ $setting->value }}</p>
                    <p class="text-xs text-gray-400 mb-3">{{ $setting->translation?->description }}</p>
                    <a href="{{ route('admin.contact-settings.edit', $setting) }}" class="text-blue-500 hover:text-blue-700 text-sm">Edit</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
