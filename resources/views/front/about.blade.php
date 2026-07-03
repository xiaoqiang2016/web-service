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

<div class="sidebanner" style="background-image:url({{ $banner ? asset('storage/' . ($banner->translation?->image ?? $banner->image)) : asset('index_files/about.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; {{ __('front.about_us') }}</p>
    </div>
</div>

<div class="about2">
    <div class="wp">

        <div class="index-tit2">
            <h3>{{ __('front.what_we_are') }}</h3>
            <hr>
        </div>
         <div class="content">{!! get_translated($aboutPage, 'content') !!}</div>
    </div>
</div>

<div class="honor">
    <div class="wp">
        <div class="index-tit2">
            <h3>{{ __('front.certificate') }}</h3>
            <hr>
            <p>{{ __('front.certificate_description') }}</p>
        </div>

        <div class="list">
            <div class="swiper-container swiper-container-horizontal">
                <div class="swiper-wrapper">
                        @foreach($honorImages as $image)
                            <div class="swiper-slide">
                                <a class="honor-link" data-caption="{{ $image->caption ?? 'Certificates' }}" href="{{ asset('storage/' . $image->image) }}">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->caption }}">
                                </a>
                            </div>
                        @endforeach
                </div>
            </div>
            <div class="swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="white">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
            </div>
            <div class="swiper-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="white">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                </svg>
            </div>
        </div>

    </div>
</div>

<div class="factory">
    <div class="wp">

        <div class="index-tit2">
            <h3>{{ __('front.our_factory') }}</h3>
            <hr>
        </div>

        <div class="list">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($factoryImages as $image)
                            <div class="swiper-slide">
                                <a class="factory-link" data-caption="{{ $image->caption ?? 'Factory' }}" href="{{ asset('storage/' . $image->image) }}">
                                    <img src="{{ asset('storage/' . $image->image) }}">
                                </a>
                            </div>
                        @endforeach
                </div>
            </div>
            <div class="swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="#666">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
            </div>
            <div class="swiper-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="#666">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                </svg>
            </div>
        </div>

    </div>
</div>

@include('front.partials.footer')

@endsection
