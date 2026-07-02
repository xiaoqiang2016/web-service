@extends('admin.layouts.master')

@section('title', 'Edit FAQ')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">Edit FAQ</h3>
        <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Show</label>
                <input type="checkbox" name="is_show" value="1" {{ $faq->is_show ? 'checked' : '' }}>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Sort Order</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $faq->sort_order }}">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Translations</label>
                @foreach($languages as $language)
                    <?php $translation = $faq->translations()->where('locale', $language->locale)->first(); ?>
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <input type="text" name="translations[{{ $language->locale }}][question]" placeholder="Question" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" value="{{ $translation?->question }}" required>
                        <textarea name="translations[{{ $language->locale }}][answer]" placeholder="Answer" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="5" required>{{ $translation?->answer }}</textarea>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Update</button>
        </form>
    </div>
@endsection
