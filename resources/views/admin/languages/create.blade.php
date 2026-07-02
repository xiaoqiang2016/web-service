@extends('admin.layouts.master')

@section('title', __('admin.languages.create.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.languages.create.title') }}</h3>
        <form action="{{ route('admin.languages.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.locale') }}</label>
                <input type="text" name="locale" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.name') }}</label>
                <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.is_default') }}</label>
                <input type="checkbox" name="is_default" value="1">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.is_active') }}</label>
                <input type="checkbox" name="is_active" value="1" checked>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.sort_order') }}</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="0">
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</button>
        </form>
    </div>
@endsection
