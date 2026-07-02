@extends('admin.layouts.master')

@section('title', __('admin.categories.create.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.categories.create.title') }}</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.parent') }}</label>
                <select name="parent_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="0">-</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}">{{ get_translated($parent, 'name') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.type') }}</label>
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="product">Product</option>
                    <option value="news">News</option>
                    <option value="case">Case</option>
                    <option value="page">Page</option>
                    <option value="job">Job</option>
                    <option value="download">Download</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.show') }}</label>
                <input type="checkbox" name="is_show" value="1" checked>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.sort_order') }}</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="0">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.url') }}</label>
                <input type="text" name="url" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Enter URL (e.g., /products, /about)" value="">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.translations') }}</label>
                @foreach($languages as $language)
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <input type="text" name="translations[{{ $language->locale }}][name]" placeholder="{{ __('admin.common.name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" required>
                        <input type="text" name="translations[{{ $language->locale }}][seo_title]" placeholder="{{ __('admin.common.meta_title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2">
                        <input type="text" name="translations[{{ $language->locale }}][seo_keywords]" placeholder="{{ __('admin.common.meta_keywords') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2">
                        <textarea name="translations[{{ $language->locale }}][seo_description]" placeholder="{{ __('admin.common.meta_description') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</button>
        </form>
    </div>
@endsection
