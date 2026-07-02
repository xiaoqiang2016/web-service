@extends('admin.layouts.master')

@section('title', __('admin.articles.create.title'))

@push('styles')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/41.4.1/classic/theme/moono-lisa.css">
<style>
.ck-editor__editable { min-height: 300px; }
</style>
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.articles.create.title') }}</h3>
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.category') }}</label>
                <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">-</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ get_translated($category, 'name') }}</option>
                        @if($category->children && $category->children->count() > 0)
                            @foreach($category->children as $child)
                                <option value="{{ $child->id }}">  ├─ {{ get_translated($child, 'name') }}</option>
                            @endforeach
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.author') }}</label>
                <input type="text" name="author" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.source') }}</label>
                <input type="text" name="source" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.status') }}</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="0">{{ __('admin.dashboard.draft') }}</option>
                    <option value="1">{{ __('admin.dashboard.published') }}</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.is_top') }}</label>
                <input type="checkbox" name="is_top" value="1">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.is_recommend') }}</label>
                <input type="checkbox" name="is_recommend" value="1">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.published_at') }}</label>
                <input type="date" name="published_at" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ date('Y-m-d') }}">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.translations') }}</label>
                @foreach($languages as $language)
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <input type="text" name="translations[{{ $language->locale }}][title]" placeholder="{{ __('admin.common.title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" required>
                        <input type="text" name="translations[{{ $language->locale }}][summary]" placeholder="{{ __('admin.common.summary') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2">
                        <input type="file" name="translations[{{ $language->locale }}][cover_image]" class="w-full mb-2">
                        <textarea name="translations[{{ $language->locale }}][content]" id="content-{{ $language->locale }}" class="ckeditor w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" rows="5"></textarea>
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

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初始化所有CKEditor实例
    document.querySelectorAll('.ckeditor').forEach(function(element) {
        ClassicEditor.create(element, {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo', 'blockQuote', 'insertTable']
        }).catch(error => {
            console.error('CKEditor error:', error);
        });
    });
});
</script>
@endpush
