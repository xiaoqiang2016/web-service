@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$categoryTranslation = isset($category) ? ($category->translations->firstWhere('locale', $currentLocale) ?? $category->translations->first()) : null;
@endphp
@section('title', $categoryTranslation?->seo_title ?: 'News')
@section('meta_description', $categoryTranslation?->seo_description ?: 'Latest news and updates')
@section('meta_keywords', $categoryTranslation?->seo_keywords ?: 'news, updates')

@section('content')

@include('front.partials.header')

<div class="sidebanner" style="background-image:url({{ $banner ? asset('storage/' . ($banner->translation?->image ?? $banner->image)) : asset('index_files/cate02.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; {{ __('front.news') }}</p>
    </div>
</div>

<div class="newslist">

    <div class="wp">
        <ul>
            @foreach($articles as $article)
            <li class="cl">
                <div class="date">
                    <span class="date-month">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('m') : '08' }}</span>
                    <span class="date-day">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d') : '01' }}</span>
                </div>
                @php $articleSlug = $article->translations->firstWhere('locale', app()->getLocale())?->slug ?? $article->translations->first()?->slug; @endphp
                @if($articleSlug)
                <a class="pic" href="{{ route('front.news.show', ['locale' => app()->getLocale(), 'slug' => $articleSlug]) }}"><img src="{{ $article->translation?->cover_image ? asset('storage/' . $article->translation->cover_image) : asset('index_files/n1.jpg') }}"></a>
                <div class="news-content">
                    <h5><a href="{{ route('front.news.show', ['locale' => app()->getLocale(), 'slug' => $articleSlug]) }}">{{ get_translated($article, 'title') }}</a></h5>
                    <p>{{ get_translated($article, 'summary') }}</p>
                    <a class="more" href="{{ route('front.news.show', ['locale' => app()->getLocale(), 'slug' => $articleSlug]) }}">{{ __('front.view_more') }}</a>
                </div>
                @endif
            </li>
            @endforeach
            @if($articles->isEmpty())
            <li class="cl text-center py-8">
                <p>{{ __('front.no_news_available') }}</p>
            </li>
            @endif
        </ul>

        @if($articles->hasPages())
        <div class="digg">
            @if($articles->onFirstPage())
            <span class="l disabled"><i class="qico qico-left8"></i> {{ __('front.prev') }}</span>
            @else
            <a class="l" href="{{ $articles->previousPageUrl() }}"><i class="qico qico-left8"></i> {{ __('front.prev') }}</a>
            @endif
            
            @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                @if($page == $articles->currentPage())
                <span class="disabled">{{ $page }}</span>
                @else
                <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
            
            @if($articles->hasMorePages())
            <a class="l" href="{{ $articles->nextPageUrl() }}">{{ __('front.next') }} <i class="qico qico-right8"></i></a>
            @else
            <span class="l disabled">{{ __('front.next') }} <i class="qico qico-right8"></i></span>
            @endif
        </div>
        @endif
    </div>

</div>

@include('front.partials.footer')

@endsection
