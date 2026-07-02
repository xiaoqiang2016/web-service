@extends('admin.layouts.master')

@section('title', __('admin.banners.edit.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.banners.edit.title') }}</h3>
        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.url') }}</label>
                <input type="url" name="link_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $banner->link_url }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.link_target') }}</label>
                <select name="link_target" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="_blank" {{ $banner->link_target == '_blank' ? 'selected' : '' }}>_blank (新窗口打开)</option>
                    <option value="_self" {{ $banner->link_target == '_self' ? 'selected' : '' }}>_self (当前窗口打开)</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.position') }}</label>
                <select name="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="home" {{ $banner->position == 'home' ? 'selected' : '' }}>首页 (Home)</option>
                    <option value="product" {{ $banner->position == 'product' ? 'selected' : '' }}>产品页 (Product)</option>
                    <option value="news" {{ $banner->position == 'news' ? 'selected' : '' }}>新闻页 (News)</option>
                    <option value="contact" {{ $banner->position == 'contact' ? 'selected' : '' }}>联系我们页 (Contact)</option>
                    <option value="article" {{ $banner->position == 'article' ? 'selected' : '' }}>文章页 (Article)</option>
                    <option value="faq" {{ $banner->position == 'faq' ? 'selected' : '' }}>FAQ页 (FAQ)</option>
                    <option value="about" {{ $banner->position == 'about' ? 'selected' : '' }}>关于我们页 (About Us)</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.show') }}</label>
                <input type="checkbox" name="is_show" value="1" {{ $banner->is_show ? 'checked' : '' }}>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.sort_order') }}</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="{{ $banner->sort_order }}">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.translations') }}</label>
                @foreach($languages as $language)
                    <?php $translation = $banner->translations()->where('locale', $language->locale)->first(); ?>
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <div class="mb-2">
                            <label class="block text-gray-600 text-sm mb-1">{{ __('admin.common.image') }}</label>
                            @if($translation?->image)
                                <img src="{{ asset('storage/' . $translation->image) }}" class="w-32 h-32 object-cover mb-2">
                            @endif
                            <input type="file" name="translations[{{ $language->locale }}][image]" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <input type="text" name="translations[{{ $language->locale }}][title]" placeholder="{{ __('admin.common.title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2" value="{{ $translation?->title }}">
                        <textarea name="translations[{{ $language->locale }}][description]" placeholder="{{ __('admin.common.description') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ $translation?->description }}</textarea>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.update') }}</button>
        </form>
    </div>
@endsection
