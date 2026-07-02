@extends('admin.layouts.master')

@section('title', 'Edit Contact Setting')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">Edit Contact Setting</h3>
        
        <form action="{{ route('admin.contact-settings.update', $contactSetting) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Key</label>
                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $contactSetting->key }}" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Value (Default)</label>
                <input type="text" name="value" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $contactSetting->value }}" required>
                <p class="text-xs text-gray-500 mt-1">This is the fallback value when no language-specific value is provided.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Sort Order</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $contactSetting->sort_order }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Is Active</label>
                <input type="checkbox" name="is_active" value="1" {{ $contactSetting->is_active ? 'checked' : '' }}>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Translations</label>
                @foreach($languages as $language)
                    <?php $translation = $contactSetting->translations()->where('locale', $language->locale)->first(); ?>
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <input type="text" name="translations[{{ $language->locale }}][label]" placeholder="Label" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" value="{{ $translation?->label }}">
                        <input type="text" name="translations[{{ $language->locale }}][value]" placeholder="Value (Language-specific)" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" value="{{ $translation?->value }}">
                        <textarea name="translations[{{ $language->locale }}][description]" placeholder="Description" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ $translation?->description }}</textarea>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Update</button>
        </form>
    </div>
@endsection
