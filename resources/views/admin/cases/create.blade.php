@extends('admin.layouts.master')

@section('title', __('admin.cases.create.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.cases.create.title') }}</h3>
        <form action="{{ route('admin.cases.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.category') }}</label>
                <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">-</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ get_translated($category, 'name') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.client') }}</label>
                <input type="text" name="client_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.industry') }}</label>
                <input type="text" name="industry" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.show') }}</label>
                <input type="checkbox" name="is_show" value="1" checked>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.sort_order') }}</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="0">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.translations') }}</label>
                @foreach($languages as $language)
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <input type="text" name="translations[{{ $language->locale }}][title]" placeholder="{{ __('admin.common.title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" required>
                        <input type="text" name="translations[{{ $language->locale }}][summary]" placeholder="{{ __('admin.common.summary') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2">
                        <input type="file" name="translations[{{ $language->locale }}][cover_image]" class="w-full mb-2">
                        <input type="file" name="translations[{{ $language->locale }}][images][]" class="w-full mb-2" multiple>
                        <textarea name="translations[{{ $language->locale }}][content]" placeholder="{{ __('admin.common.content') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="5"></textarea>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</button>
        </form>
    </div>
@endsection
