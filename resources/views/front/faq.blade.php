@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$categoryTranslation = isset($category) ? ($category->translations->firstWhere('locale', $currentLocale) ?? $category->translations->first()) : null;
@endphp
@section('title', $categoryTranslation?->seo_title ?: 'Qianzhu Hardware Manufacturer')
@section('meta_description', $categoryTranslation?->seo_description ?: 'Qianzhu Hardware Manufacturer')
@section('meta_keywords', $categoryTranslation?->seo_keywords ?: 'Qianzhu Hardware Manufacturer')

@section('content')

@include('front.partials.header')

<div class="sidebanner" style="background-image:url({{ $banner ? asset('storage/' . ($banner->translation?->image ?? $banner->image)) : asset('index_files/cate01.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; {{ __('front.faq') }}</p>
    </div>
</div>

<div class="wp main">
    <div class="faq-list">
        @if($faqs->count() > 0)
            @foreach($faqs as $faq)
                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-icon">Q</span>
                        <h4>{{ get_translated($faq, 'question') }}</h4>
                    </div>
                    <div class="faq-answer">
                        <span class="faq-icon">A</span>
                        <p>{!! nl2br(e(get_translated($faq, 'answer'))) !!}</p>
                    </div>
                </div>
            @endforeach
            
            @if($faqs->hasPages())
            <div class="digg">
                @if($faqs->onFirstPage())
                <span class="l disabled"><i class="qico qico-left8"></i> {{ __('front.prev') }}</span>
                @else
                <a class="l" href="{{ $faqs->previousPageUrl() }}"><i class="qico qico-left8"></i> {{ __('front.prev') }}</a>
                @endif
                
                @foreach($faqs->getUrlRange(1, $faqs->lastPage()) as $page => $url)
                    @if($page == $faqs->currentPage())
                    <span class="disabled">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
                
                @if($faqs->hasMorePages())
                <a class="l" href="{{ $faqs->nextPageUrl() }}">{{ __('front.next') }} <i class="qico qico-right8"></i></a>
                @else
                <span class="l disabled">{{ __('front.next') }} <i class="qico qico-right8"></i></span>
                @endif
            </div>
            @endif
        @else
            <div class="no-data">
                <p>{{ __('front.no_faq_available') }}</p>
            </div>
        @endif
    </div>
</div>

@include('front.partials.footer')

<style>
.faq-list {
}
.faq-item {
    margin-bottom: 30px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    overflow: hidden;
}
.faq-question {
    background: #f8f9fa;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
}
.faq-question h4 {
    margin: 0;
    font-size: 16px;
    color: #333;
    flex: 1;
}
.faq-answer {
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    background: #fff;
}
.faq-answer p {
    margin: 0;
    color: #666;
    line-height: 1.8;
    flex: 1;
}
.faq-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-weight: bold;
    font-size: 14px;
    flex-shrink: 0;
}
.faq-question .faq-icon {
    background: #027BCF;
    color: #fff;
}
.faq-answer .faq-icon {
    background: #28a745;
    color: #fff;
}
.no-data {
    text-align: center;
    padding: 60px 0;
    color: #999;
}
</style>

@endsection
