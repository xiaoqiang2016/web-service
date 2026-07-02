@extends('admin.layouts.master')

@section('title', 'Company Introduction')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">About Us Content</h3>
        
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button type="button" 
                        id="tab-company" 
                        class="tab-button active border-b-2 border-primary text-primary py-4 px-1 text-sm font-medium"
                        data-tab="company">
                    Company Introduction
                </button>
                <button type="button" 
                        id="tab-team" 
                        class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium"
                        data-tab="team">
                    Our Team
                </button>
            </nav>
        </div>
        
        <form action="{{ route('admin.about-contents.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Company Introduction Tab -->
            <div id="content-company" class="tab-content">
                @foreach($languages as $language)
                    <?php $translation = $aboutPage?->translations()->where('locale', $language->locale)->first(); ?>
                    <div class="mb-6 border p-4 rounded-lg">
                        <h4 class="font-semibold mb-3 flex items-center gap-2">
                            <span class="px-2 py-1 bg-gray-100 rounded">{{ $language->name }}</span>
                            <span class="text-sm text-gray-500">({{ strtoupper($language->locale) }})</span>
                        </h4>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Summary (简述)</label>
                            <textarea name="translations[{{ $language->locale }}][summary]" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg" 
                                      rows="3">{{ $translation?->summary }}</textarea>
                        </div>
                        <textarea name="translations[{{ $language->locale }}][content]" 
                                  id="editor-{{ $language->locale }}"
                                  class="ckeditor w-full px-4 py-2 border border-gray-300 rounded-lg" 
                                  rows="10">{{ $translation?->content }}</textarea>
                    </div>
                @endforeach
            </div>
            
            <!-- Our Team Tab -->
            <div id="content-team" class="tab-content hidden">
                @foreach($languages as $language)
                    <?php $translation = $aboutPage?->translations()->where('locale', $language->locale)->first(); ?>
                    <div class="mb-6 border p-4 rounded-lg">
                        <h4 class="font-semibold mb-3 flex items-center gap-2">
                            <span class="px-2 py-1 bg-gray-100 rounded">{{ $language->name }}</span>
                            <span class="text-sm text-gray-500">({{ strtoupper($language->locale) }})</span>
                        </h4>
                        <textarea name="translations[{{ $language->locale }}][team_content]" 
                                  id="editor-team-{{ $language->locale }}"
                                  class="ckeditor-team w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" 
                                  rows="10">{{ $translation?->team_content }}</textarea>
                    </div>
                @endforeach
            </div>
            
            <button type="submit" class="bg-secondary text-white px-6 py-2 rounded-lg hover:bg-secondary/80">Save</button>
        </form>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/41.4.1/classic/theme/moono-lisa.css">
<style>
    .ck-editor .ck-editor__main .ck-content {
        min-height: 400px;
    }
    .tab-button.active {
        border-bottom-color: #3b82f6;
        color: #3b82f6;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.1/classic/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('border-transparent', 'text-gray-500');
                btn.classList.remove('border-primary', 'text-primary');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-primary', 'text-primary');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
        });
    });
    
    // Initialize CKEditor for Company Introduction
    document.querySelectorAll('.ckeditor').forEach(function(element) {
        ClassicEditor
            .create(element, {
                uploadUrl: '{{ route('admin.upload') }}',
                simpleUpload: {
                    uploadUrl: '{{ route('admin.upload') }}'
                }
            })
            .catch(function(error) {
                console.error('CKEditor error:', error);
            });
    });
    
    // Initialize CKEditor for Our Team
    document.querySelectorAll('.ckeditor-team').forEach(function(element) {
        ClassicEditor
            .create(element, {
                uploadUrl: '{{ route('admin.upload') }}',
                simpleUpload: {
                    uploadUrl: '{{ route('admin.upload') }}'
                }
            })
            .catch(function(error) {
                console.error('CKEditor error:', error);
            });
    });
});
</script>
@endpush
