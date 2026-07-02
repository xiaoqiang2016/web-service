@extends('admin.layouts.master')

@section('title', __('admin.products.create.title'))

@push('styles')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/41.4.1/classic/theme/moono-lisa.css">
<style>
.ck-editor__editable { min-height: 300px; }
.lang-tabs { display: flex; border-bottom: 2px solid #e5e7eb; margin-bottom: 0; }
.lang-tab { padding: 10px 20px; cursor: pointer; border: 1px solid transparent; border-bottom: none; border-radius: 8px 8px 0 0; margin-right: 4px; background: #f3f4f6; color: #6b7280; font-weight: 500; }
.lang-tab:hover { background: #e5e7eb; }
.lang-tab.active { background: #fff; border-color: #e5e7eb; border-bottom: 2px solid #fff; color: #111827; margin-bottom: -2px; }
.lang-content { display: none; padding: 24px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px; }
.lang-content.active { display: block; }
</style>
@endpush

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">{{ __('admin.products.create.title') }}</h1>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.common.category') }}</label>
                <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    <option value="">{{ __('admin.common.select_category') }}</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ str_repeat('→ ', $category->parent ? 1 : 0) }}{{ $category->translation?->name ?? $category->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.common.sort_order') }}</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.common.status') }}</label>
                <select name="is_show" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    <option value="1" {{ old('is_show', 1) == 1 ? 'selected' : '' }}>{{ __('admin.common.show') }}</option>
                    <option value="0" {{ old('is_show', 1) == 0 ? 'selected' : '' }}>{{ __('admin.common.hide') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.common.is_recommend') }}</label>
                <select name="is_recommend" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    <option value="0" {{ old('is_recommend', 0) == 0 ? 'selected' : '' }}>{{ __('admin.common.no') }}</option>
                    <option value="1" {{ old('is_recommend', 0) == 1 ? 'selected' : '' }}>{{ __('admin.common.yes') }}</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.common.cover_image') }}</label>
                <input type="file" name="cover_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Shared across all languages</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Detail Images</label>
                <input type="file" name="detail_images[]" accept="image/*" multiple class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                <p class="text-xs text-gray-500 mt-1">Select multiple images, shared across all languages</p>
            </div>
        </div>

        <div class="border-t pt-6">
            <h2 class="text-lg font-semibold mb-4">{{ __('admin.common.translations') }}</h2>

            {{-- Language Tabs --}}
            <div class="lang-tabs">
                @foreach($languages as $i => $language)
                    <div class="lang-tab {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $language->locale }}">{{ $language->name }} ({{ $language->locale }})</div>
                @endforeach
            </div>

            @foreach($languages as $i => $language)
            <div class="lang-content {{ $i === 0 ? 'active' : '' }}" data-lang="{{ $language->locale }}">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.common.name') }}</label>
                        <input type="text" name="translations[{{ $language->locale }}][name]" value="{{ old("translations.$language->locale.name") }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('admin.common.description') }}</label>
                        <textarea name="translations[{{ $language->locale }}][description]" id="desc-{{ $language->locale }}" class="ckeditor w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old("translations.$language->locale.description") }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Specifications</label>
                        <textarea name="translations[{{ $language->locale }}][specifications]" id="spec-{{ $language->locale }}" class="ckeditor w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old("translations.$language->locale.specifications") }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Competitive Advantage</label>
                        <textarea name="translations[{{ $language->locale }}][competitive_advantage]" id="comp-{{ $language->locale }}" class="ckeditor w-full px-3 py-2 border border-gray-300 rounded-lg">{{ old("translations.$language->locale.competitive_advantage") }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Certification</label>
                        <input type="text" name="translations[{{ $language->locale }}][certification]" value="{{ old("translations.$language->locale.certification") }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Quantity</label>
                        <input type="text" name="translations[{{ $language->locale }}][min_order_quantity]" value="{{ old("translations.$language->locale.min_order_quantity") }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Packaging Details</label>
                        <textarea name="translations[{{ $language->locale }}][packaging_details]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">{{ old("translations.$language->locale.packaging_details") }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Time</label>
                        <input type="text" name="translations[{{ $language->locale }}][delivery_time]" value="{{ old("translations.$language->locale.delivery_time") }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Terms</label>
                        <input type="text" name="translations[{{ $language->locale }}][payment_terms]" value="{{ old("translations.$language->locale.payment_terms") }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Supply Ability</label>
                        <input type="text" name="translations[{{ $language->locale }}][supply_ability]" value="{{ old("translations.$language->locale.supply_ability") }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                    </div>
                    <div class="border-t pt-4 mt-4">
                        <h3 class="text-md font-semibold mb-3">SEO Settings</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                                <input type="text" name="translations[{{ $language->locale }}][seo_title]" value="{{ old("translations.$language->locale.seo_title") }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                                <input type="text" name="translations[{{ $language->locale }}][seo_keywords]" value="{{ old("translations.$language->locale.seo_keywords") }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea name="translations[{{ $language->locale }}][seo_description]" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-secondary focus:border-transparent">{{ old("translations.$language->locale.seo_description") }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-secondary text-white px-6 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.save') }}</button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">{{ __('admin.actions.cancel') }}</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.1/classic/ckeditor.js"></script>
<script>
// Language tab switching
document.querySelectorAll('.lang-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        var lang = this.dataset.lang;
        document.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.lang-content').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        document.querySelector('.lang-content[data-lang="' + lang + '"]').classList.add('active');
    });
});

// Initialize CKEditor for all textarea.ckeditor elements
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ckeditor').forEach(function(element) {
        ClassicEditor.create(element, {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo', 'blockQuote', 'insertTable'],
            height: 300
        }).catch(error => {
            console.error('CKEditor error:', error);
        });
    });
});
</script>
@endpush
