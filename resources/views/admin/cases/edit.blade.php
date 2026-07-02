@extends('admin.layouts.master')

@section('title', __('admin.cases.edit.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.cases.edit.title') }}</h3>
        <form action="{{ route('admin.cases.update', $case) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.category') }}</label>
                <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">-</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $case->category_id == $category->id ? 'selected' : '' }}>{{ get_translated($category, 'name') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.client') }}</label>
                <input type="text" name="client_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $case->client_name }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.industry') }}</label>
                <input type="text" name="industry" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $case->industry }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.show') }}</label>
                <input type="checkbox" name="is_show" value="1" {{ $case->is_show ? 'checked' : '' }}>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.sort_order') }}</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $case->sort_order }}">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.translations') }}</label>
                @foreach($languages as $language)
                    <?php $translation = $case->translations()->where('locale', $language->locale)->first(); ?>
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <input type="text" name="translations[{{ $language->locale }}][title]" placeholder="{{ __('admin.common.title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" value="{{ $translation?->title }}" required>
                        <input type="text" name="translations[{{ $language->locale }}][summary]" placeholder="{{ __('admin.common.summary') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" value="{{ $translation?->summary }}">
                        @if($translation?->cover_image)
                            <img src="{{ asset('storage/' . $translation->cover_image) }}" class="w-32 h-32 object-cover mb-2">
                        @endif
                        <input type="file" name="translations[{{ $language->locale }}][cover_image]" class="w-full mb-2">
                        <input type="file" name="translations[{{ $language->locale }}][images][]" class="w-full mb-2" multiple>
                        <textarea name="translations[{{ $language->locale }}][content]" placeholder="{{ __('admin.common.content') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="5">{{ $translation?->content }}</textarea>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.update') }}</button>
        </form>
    </div>
@endsection
