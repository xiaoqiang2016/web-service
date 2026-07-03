@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$aboutPageTranslation = isset($aboutPage) ? ($aboutPage->translations->firstWhere('locale', $currentLocale) ?? $aboutPage->translations->first()) : null;
$currentLocale = app()->getLocale();
$categoryTranslation = isset($category) ? ($category->translations->firstWhere('locale', $currentLocale) ?? $category->translations->first()) : null;
@endphp
@section('title', $categoryTranslation?->seo_title ?: 'Qianzhu Hardware Manufacturer')
@section('meta_description', $categoryTranslation?->seo_description ?: 'Qianzhu Hardware Manufacturer')
@section('meta_keywords', $categoryTranslation?->seo_keywords ?: 'Qianzhu Hardware Manufacturer')
@section('content')
@include('front.partials.header')
<div id="banner">
    <div class="swiper-container swiper-container-horizontal">
        <div class="swiper-wrapper">
            @foreach($banners as $banner)
            <div class="swiper-slide">
                @php $bannerImage = $banner->translation?->image ?? $banner->image; @endphp
                @if($banner->link_url)
                <a href="{{ $banner->link_url }}" target="{{ $banner->link_target ?? '_blank' }}">
                    <img src="{{ $bannerImage ? asset('storage/' . $bannerImage) : asset('index_files/banner.jpg') }}">
                </a>
                @else
                <img src="{{ $bannerImage ? asset('storage/' . $bannerImage) : asset('index_files/banner.jpg') }}">
                @endif
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets"></div>
    </div>
</div>
<div class="indexB">
    <div class="wp cl">
        <div class="index-tit">
            <h3>{{ __('front.about_title') }}</h3>
            <hr>
        </div>

        <div class="txt">
            <div class="t">
                @if($aboutPageTranslation?->summary)
                <p class="summary">{{ strip_tags($aboutPageTranslation?->summary) }}</p>
                @endif
                <a class="more" href="{{ route('front.about', app()->getLocale()) }}">{{ __('front.read_more') }}</a>
            </div>
        </div>

        <div class="team">
            <img src="{{ asset('index_files/team.jpg') }}">
            <div class="t">
                <h4>{{ __('front.our_team') }}</h4>
                <p>{!! $aboutPageTranslation?->team_content ?: __('front.team_description') !!}</p>
            </div>
        </div>

    </div>
</div>
<div class="indexD">
    <div class="wp cl">
        <div class="index-tit">
            <h3>{{ __('front.products') }}</h3>
            <hr>
        </div>

        <ul class="cl">
            @foreach($products as $product)
                <li>
                    <a class="pic" href="{{ route('front.product', ['locale' => app()->getLocale(), 'id' => $product->id]) }}">
                        <img src="{{ $product->cover_image ? asset('storage/' . $product->cover_image) : asset('index_files/p1.jpg') }}">
                    </a>
                    <h6><a href="{{ route('front.product', ['locale' => app()->getLocale(), 'id' => $product->id]) }}">{{ Str::limit(get_translated($product, 'name'),25)}}</a></h6>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<div class="indexA">
    <div class="wp">
        <div class="index-tit">
            <h3>{{ __('front.our_factory') }}</h3>
            <hr>
        </div>
        <div class="list" style="margin-top: 30px;">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($factoryImages as $image)
                    <div class="swiper-slide">
                        <a data-fancybox="factory" data-caption="{{ $image->caption }}" href="{{ asset('storage/' . $image->image) }}">
                            <img src="{{ asset('storage/' . $image->image) }}">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-button-prev"><i class="qico qico-left"></i></div>
            <div class="swiper-button-next"><i class="qico qico-right"></i></div>
        </div>

    </div>
</div>
<div class="indexE">
    <div class="wp cl">
        <div class="index-tit">
            <h3>{{ __('front.certificate') }}</h3>
            <hr>
        </div>

        <div class="list">
            <div class="swiper-container swiper-container-horizontal">
                <div class="swiper-wrapper">
                    @foreach($honorImages as $image)
                    <div class="swiper-slide">
                        <a data-fancybox="certificates" data-caption="{{ $image->caption }}" href="{{ asset('storage/' . $image->image) }}">
                            <img src="{{ asset('storage/' . $image->image) }}">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="swiper-button-prev"><i class="qico qico-left"></i></div>
            <div class="swiper-button-next"><i class="qico qico-right"></i></div>
        </div>
    </div>
</div>

@include('front.partials.footer')

@endsection