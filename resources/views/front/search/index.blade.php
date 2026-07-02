@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$categoryTranslation = isset($category) ? ($category->translations->firstWhere('locale', $currentLocale) ?? $category->translations->first()) : null;
@endphp
@section('title', $categoryTranslation?->seo_title ?: 'Search Results')
@section('meta_description', $categoryTranslation?->seo_description ?: 'Search results')
@section('meta_keywords', $categoryTranslation?->seo_keywords ?: 'search')

@section('content')
@include('front.partials.header')

<div class="sidebanner" style="background-image:url({{ $banner ? asset('storage/' . ($banner->translation?->image ?? $banner->image)) : asset('index_files/about.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; {{ __('front.search') }}</p>
    </div>
</div>

<div class="search-page">
    <div class="wp">
        <div class="search-header">
            <h1>{{ __('front.search_results') }}</h1>
            <div class="search-box">
                <form method="get" action="{{ route('front.search', app()->getLocale()) }}">
                    <input type="text" name="keyword" placeholder="{{ __('front.search') }}..." value="{{ $keyword }}">
                    <button type="submit"><i class="qico qico-search"></i></button>
                </form>
            </div>
        </div>

        @if(!$keyword)
            <div class="no-results">
                <p>{{ __('front.enter_keyword') }}</p>
            </div>
        @else
            <!-- Tabs -->
            <div class="search-tabs">
                <a href="{{ route('front.search', ['locale' => app()->getLocale(), 'keyword' => $keyword, 'tab' => 'all']) }}"
                   class="tab {{ $tab === 'all' ? 'active' : '' }}">
                    {{ __('front.all') }} ({{ $productsTotal + $articlesTotal }})
                </a>
                <a href="{{ route('front.search', ['locale' => app()->getLocale(), 'keyword' => $keyword, 'tab' => 'products']) }}"
                   class="tab {{ $tab === 'products' ? 'active' : '' }}">
                    {{ __('front.products') }} ({{ $productsTotal }})
                </a>
                <a href="{{ route('front.search', ['locale' => app()->getLocale(), 'keyword' => $keyword, 'tab' => 'articles']) }}"
                   class="tab {{ $tab === 'articles' ? 'active' : '' }}">
                    {{ __('front.news') }} ({{ $articlesTotal }})
                </a>
            </div>

            <!-- Products Results -->
            @if(($tab === 'all' || $tab === 'products') && $products->count() > 0)
                <div class="search-section">
                    <h2 class="section-title">{{ __('front.products') }}</h2>
                    <div class="product-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <a href="{{ route('front.product', ['locale' => app()->getLocale(), 'id' => $product->id]) }}">
                                    <div class="product-img">
                                        <img src="{{ $product->cover_image ? asset('storage/' . $product->cover_image) : asset('index_files/p1.jpg') }}" alt="{{ $product->translation?->name }}">
                                    </div>
                                    <div class="product-info">
                                        <h3>{{ $product->translation?->name }}</h3>
                                        <p>{{ Str::limit(strip_tags($product->translation?->summary ?: $product->translation?->description), 80) }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @if($tab === 'products' && $products->hasPages())
                        <div class="pagination-wrap">
                            {{ $products->appends(['keyword' => $keyword, 'tab' => 'products'])->links() }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Articles Results -->
            @if(($tab === 'all' || $tab === 'articles') && $articles->count() > 0)
                <div class="search-section">
                    <h2 class="section-title">{{ __('front.news') }}</h2>
                    <div class="article-list">
                        @foreach($articles as $article)
                            @php $articleSlug = $article->translations->firstWhere('locale', app()->getLocale())?->slug ?? $article->translations->first()?->slug; @endphp
                            @if($articleSlug)
                            <div class="article-card">
                                <a href="{{ route('front.news.show', ['locale' => app()->getLocale(), 'slug' => $articleSlug]) }}">
                                    <div class="article-info">
                                        <h3>{{ $article->translation?->title }}</h3>
                                        <p>{{ Str::limit(strip_tags($article->translation?->content), 120) }}</p>
                                        <span class="article-date">{{ $article->published_at ? date('Y-m-d', strtotime($article->published_at)) : '' }}</span>
                                    </div>
                                </a>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @if($tab === 'articles' && $articles->hasPages())
                        <div class="pagination-wrap">
                            {{ $articles->appends(['keyword' => $keyword, 'tab' => 'articles'])->links() }}
                        </div>
                    @endif
                </div>
            @endif

            @if($products->count() === 0 && $articles->count() === 0)
                <div class="no-results">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <p>{{ __('front.no_results') }} "{{ $keyword }}"</p>
                    <p class="sub">{{ __('front.try_different') }}</p>
                </div>
            @endif
        @endif
    </div>
</div>

@include('front.partials.footer')
@endsection

@push('styles')
<style>
.search-page { padding: 40px 0 60px; }

.search-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.search-header h1 {
    font-size: 24px;
    color: #333;
    margin: 0;
}

.search-box form {
    display: flex;
    border: 2px solid #e5e5e5;
    border-radius: 4px;
    overflow: hidden;
    transition: border-color 0.3s;
}

.search-box form:focus-within {
    border-color: #0DA0E4;
}

.search-box input {
    width: 300px;
    padding: 10px 15px;
    border: none;
    outline: none;
    font-size: 14px;
}

.search-box button {
    background: #0DA0E4;
    border: none;
    padding: 10px 18px;
    cursor: pointer;
    color: #fff;
    font-size: 16px;
    transition: background 0.3s;
}

.search-box button:hover { background: #0b8ec7; }

/* Tabs */
.search-tabs {
    display: flex;
    gap: 0;
    margin-bottom: 30px;
    border-bottom: 2px solid #e5e5e5;
}

.search-tabs .tab {
    padding: 12px 24px;
    text-decoration: none;
    color: #666;
    font-size: 15px;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    transition: all 0.3s;
}

.search-tabs .tab:hover,
.search-tabs .tab.active {
    color: #0DA0E4;
    border-bottom-color: #0DA0E4;
}

/* Sections */
.search-section { margin-bottom: 50px; }

.section-title {
    font-size: 20px;
    color: #333;
    padding-bottom: 12px;
    border-bottom: 2px solid #0DA0E4;
    margin-bottom: 25px;
    display: inline-block;
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

.product-card {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.3s;
}

.product-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.product-card a { text-decoration: none; color: inherit; }

.product-img {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f5f5f5;
}

.product-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.product-card:hover .product-img img { transform: scale(1.05); }

.product-info { padding: 15px; }

.product-info h3 {
    font-size: 15px;
    color: #333;
    margin: 0 0 8px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-info p {
    font-size: 13px;
    color: #999;
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Article List */
.article-list { display: flex; flex-direction: column; gap: 15px; }

.article-card {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 6px;
    padding: 20px;
    transition: all 0.3s;
}

.article-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border-color: #0DA0E4;
}

.article-card a { text-decoration: none; color: inherit; }

.article-info h3 {
    font-size: 17px;
    color: #333;
    margin: 0 0 10px;
    transition: color 0.3s;
}

.article-card:hover .article-info h3 { color: #0DA0E4; }

.article-info p {
    font-size: 14px;
    color: #888;
    margin: 0 0 10px;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.article-date {
    font-size: 13px;
    color: #bbb;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 80px 20px;
    color: #999;
}

.no-results svg { margin-bottom: 20px; }

.no-results p { font-size: 18px; margin: 0 0 10px; }

.no-results .sub { font-size: 14px; color: #bbb; }

/* Pagination */
.pagination-wrap {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

.pagination-wrap nav { display: flex; gap: 5px; }

.pagination-wrap nav a,
.pagination-wrap nav span {
    padding: 8px 14px;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
    text-decoration: none;
    color: #666;
    font-size: 14px;
    transition: all 0.3s;
}

.pagination-wrap nav a:hover {
    background: #0DA0E4;
    color: #fff;
    border-color: #0DA0E4;
}

.pagination-wrap nav span[aria-current="page"] {
    background: #0DA0E4;
    color: #fff;
    border-color: #0DA0E4;
}

@media (max-width: 768px) {
    .search-header { flex-direction: column; align-items: flex-start; }
    .search-box input { width: 200px; }
    .product-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; }
    .product-img { height: 150px; }
    .search-tabs .tab { padding: 10px 14px; font-size: 13px; }
}
</style>
@endpush
