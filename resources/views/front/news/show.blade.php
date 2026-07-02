@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$articleTranslation = $article->translations->firstWhere('locale', $currentLocale) ?? $article->translations->first();
@endphp
@section('title', $articleTranslation?->seo_title ?: get_translated($article, 'title'))
@section('meta_description', $articleTranslation?->seo_description ?: get_translated($article, 'summary') ?: 'News article')
@section('meta_keywords', $articleTranslation?->seo_keywords ?: 'news')

@section('content')

@include('front.partials.header', ['translatable' => $article])

<div class="sidebanner" style="background-image:url({{ $banner ? asset('storage/' . ($banner->translation?->image ?? $banner->image)) : asset('index_files/cate02.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; <a href="{{ route('front.news', app()->getLocale()) }}">{{ __('front.news') }}</a> &gt; {{ get_translated($article, 'title') }}</p>
    </div>
</div>

<div class="main wp cl">

    <div class="newsnr">

        <h1>{{ get_translated($article, 'title') }}</h1>

        <div class="artInfo">
            <span class="time">{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('M d,Y') : date('M d,Y') }}</span>
            <span class="hit">{{ $article->view_count ?? 0 }}</span>
        </div>
        <div class="myart">
            {!! get_translated($article, 'content') !!}
        </div>

        <div class="pnbar">
            <p>
                @if($prevArticle)
                    @php
                        $prevTitle = $prevArticle->translation?->title ?? '';
                        $prevDisplay = mb_strlen($prevTitle) > 30 ? mb_substr($prevTitle, 0, 30) . '...' : $prevTitle;
                        $prevSlug = $prevArticle->translations->firstWhere('locale', app()->getLocale())?->slug ?? $prevArticle->translations->first()?->slug;
                    @endphp
                    @if($prevSlug)
                    <a href="{{ route('front.news.show', ['locale' => app()->getLocale(), 'slug' => $prevSlug]) }}" title="{{ $prevTitle }}">{{ __('front.prev') }}</a>
                    @else
                    <span class="disabled">{{ __('front.prev') }}</span>
                    @endif
                @else
                    <span class="disabled">{{ __('front.prev') }}</span>
                @endif
                <a href="{{ route('front.news', app()->getLocale()) }}"><img src="{{ asset('index_files/re.png') }}">{{ __('front.return') }}</a>
                @if($nextArticle)
                    @php
                        $nextTitle = $nextArticle->translation?->title ?? '';
                        $nextDisplay = mb_strlen($nextTitle) > 30 ? mb_substr($nextTitle, 0, 30) . '...' : $nextTitle;
                        $nextSlug = $nextArticle->translations->firstWhere('locale', app()->getLocale())?->slug ?? $nextArticle->translations->first()?->slug;
                    @endphp
                    @if($nextSlug)
                    <a href="{{ route('front.news.show', ['locale' => app()->getLocale(), 'slug' => $nextSlug]) }}" title="{{ $nextTitle }}">{{ __('front.next') }}</a>
                    @else
                    <span class="disabled">{{ __('front.next') }}</span>
                    @endif
                @else
                    <span class="disabled">{{ __('front.next') }}</span>
                @endif
            </p>
        </div>

    </div>

</div>

@include('front.partials.footer')

@endsection
