@extends('admin.layouts.master')

@section('title', 'Add FAQ')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">Add FAQ</h3>
        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Show</label>
                <input type="checkbox" name="is_show" value="1" checked>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Sort Order</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="0">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Translations</label>
                @foreach($languages as $language)
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <input type="text" name="translations[{{ $language->locale }}][question]" placeholder="Question" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" required>
                        <textarea name="translations[{{ $language->locale }}][answer]" placeholder="Answer" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="5" required></textarea>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Create</button>
        </form>
    </div>
@endsection
