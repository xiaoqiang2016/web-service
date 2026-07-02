@extends('admin.layouts.master')

@section('title', 'Factory Images')

@push('styles')
<style>
    .image-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        max-width: 100%;
        overflow-x: hidden;
    }
    .image-grid > div {
        width: 150px;
        flex-shrink: 0;
    }
</style>
@endpush

@section('content')
    <div class="bg-white rounded-lg shadow p-6 overflow-x-hidden">
        <h3 class="text-lg font-semibold text-primary mb-6">Factory Images Management</h3>
        
        <!-- Add New Image Form -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <h4 class="font-semibold mb-4">Add New Image</h4>
            <form action="{{ route('admin.factory-images.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap gap-4 items-end">
                @csrf
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 mb-2">Image</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded-lg p-2" required>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-gray-700 mb-2">Caption</label>
                    <input type="text" name="caption" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="w-32">
                    <label class="block text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="0">
                </div>
                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_show" value="1" checked class="w-5 h-5">
                        <span>Show</span>
                    </label>
                </div>
                <button type="submit" class="bg-secondary text-white px-6 py-2 rounded-lg hover:bg-secondary/80">Add</button>
            </form>
        </div>

        <!-- Images List -->
        <div class="image-grid">
            @forelse($images as $image)
                <div class="border rounded-lg overflow-hidden bg-gray-100" style="height: 170px;">
                    <img src="{{ asset('storage/' . $image->image) }}" 
                         alt="{{ $image->caption }}" 
                         style="width: 150px; height: 110px; object-fit: cover;"
                         class="cursor-pointer hover:opacity-80 transition-opacity"
                         onclick="previewImage(this.src)">
                    <div class="p-1.5 bg-gray-50" style="height: 60px;">
                        <p class="text-xs text-gray-600 truncate" title="{{ $image->caption }}">{{ $image->caption ?: '-' }}</p>
                        <p class="text-xs text-gray-400">#{{ $image->sort_order }}</p>
                        <form action="{{ route('admin.factory-images.destroy', $image) }}" method="POST" class="inline mt-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 hover:underline" onclick="return confirm('Delete this image?')">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="w-full text-center py-8 text-gray-500">
                    No factory images found. Please add some.
                </div>
            @endforelse
        </div>
        
        {{ $images->links() }}
    </div>

    <!-- Image Preview Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden z-50 flex items-center justify-center p-4" onclick="closeModal(event)">
        <img id="previewImg" src="" class="max-w-full max-h-full object-contain">
        <button onclick="closeModal(event)" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300">&times;</button>
    </div>
@endsection

@push('scripts')
<script>
function previewImage(src) {
    document.getElementById('previewImg').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(event) {
    if (event.target.id === 'imageModal' || event.target.tagName === 'BUTTON' || event.target.tagName === 'DIV') {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}
</script>
@endpush