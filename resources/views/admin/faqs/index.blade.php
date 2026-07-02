@extends('admin.layouts.master')

@section('title', 'FAQ Management')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-primary">FAQ List</h3>
            <a href="{{ route('admin.faqs.create') }}" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">Add FAQ</a>
        </div>
        <table class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-2">ID</th>
                    <th class="text-left py-2">Question</th>
                    <th class="text-left py-2">Sort Order</th>
                    <th class="text-left py-2">Show</th>
                    <th class="text-left py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faqs as $faq)
                    <tr>
                        <td class="py-2">{{ $faq->id }}</td>
                        <td class="py-2">{{ Str::limit(get_translated($faq, 'question'), 50) }}</td>
                        <td class="py-2">{{ $faq->sort_order }}</td>
                        <td class="py-2">{{ $faq->is_show ? 'Yes' : 'No' }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-secondary hover:underline">Edit</a>
                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this FAQ?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $faqs->links() }}
    </div>
@endsection
