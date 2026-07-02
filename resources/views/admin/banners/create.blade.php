@extends('admin.layouts.master')

@section('title', __('admin.banners.create.title'))

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-primary mb-6">{{ __('admin.banners.create.title') }}</h3>
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.url') }}</label>
                <input type="url" name="link_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.link_target') }}</label>
                <select name="link_target" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="_blank">_blank (新窗口打开)</option>
                    <option value="_self">_self (当前窗口打开)</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.position') }}</label>
                <select name="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    <option value="home">首页 (Home)</option>
                    <option value="product">产品页 (Product)</option>
                    <option value="news">新闻页 (News)</option>
                    <option value="contact">联系我们页 (Contact)</option>
                    <option value="article">文章页 (Article)</option>
                    <option value="faq">FAQ页 (FAQ)</option>
                    <option value="about">关于我们页 (About Us)</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.show') }}</label>
                <input type="checkbox" name="is_show" value="1" checked>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.sort_order') }}</label>
                <input type="number" name="sort_order" class="w-full px-4 py-2 border border-gray-300 rounded-lg" value="0">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2">{{ __('admin.common.translations') }}</label>
                @foreach($languages as $language)
                    <div class="border p-4 mb-4">
                        <h4 class="font-semibold mb-2">{{ $language->name }}</h4>
                        <div class="mb-2">
                            <label class="block text-gray-600 text-sm mb-1">{{ __('admin.common.image') }}</label>
                            <input type="file" name="translations[{{ $language->locale }}][image]" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <input type="text" name="translations[{{ $language->locale }}][title]" placeholder="{{ __('admin.common.title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2">
                        <textarea name="translations[{{ $language->locale }}][description]" placeholder="{{ __('admin.common.description') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-secondary text-white px-4 py-2 rounded-lg hover:bg-secondary/80">{{ __('admin.actions.create') }}</button>
        </form>
    </div>
@endsection
