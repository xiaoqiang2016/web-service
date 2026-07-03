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
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; {{ __('front.products') }}</p>
    </div>
</div>

<div class="main wp cl">

    <div class="main-left">

        <div class="sidemenu">
            <h3>{{ __('front.products') }}</h3>
            <ul class="accordion">
                @foreach($categories as $category)
                <li>
                    <div class="accordion-header" data-id="category-{{ $category->id }}">
                        <span class="accordion-title">{{ get_translated($category, 'name') }}</span>
                        <span class="accordion-icon">+</span>
                    </div>
                    @if($category->children->count() > 0)
                    <div class="accordion-content">
                        <ul>
                            @foreach($category->children as $child)
                            <li>
                                <a href="{{ route('front.products', app()->getLocale()) }}/{{ $category->translation?->slug }}/{{ $child->translation?->slug }}">{{ get_translated($child, 'name') }}</a>
                                @if($child->children->count() > 0)
                                <ul>
                                    @foreach($child->children as $grandchild)
                                    <li><span class="dot">•</span><a href="{{ route('front.products', app()->getLocale()) }}/{{ $category->translation?->slug }}/{{ $child->translation?->slug }}/{{ $grandchild->translation?->slug }}">{{ get_translated($grandchild, 'name') }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        <div class="side-contact">
            <h3>{{ __('front.contact') }}</h3>
            <div class="nr">
                <p class="p1"><a href="tel:{{ $contactSettings->where('type', 'phone')->first()?->value }}">{{ $contactSettings->where('type', 'phone')->first()?->value }}</a></p>
                <p class="p3"><a href="tel:{{ $contactSettings->where('type', 'phone')->skip(1)->first()?->value }}">{{ $contactSettings->where('type', 'phone')->skip(1)->first()?->value }}</a></p>
                <p class="p4"><a href="mailto:{{ $contactSettings->where('type', 'email')->first()?->value }}">{{ $contactSettings->where('type', 'email')->first()?->value }}</a></p>
                <p class="p5">{{ $contactSettings->where('type', 'address')->first()?->value }}</p>
            </div>
        </div>

    </div>

    <div class="main-right">

        <div class="pro-list">
            <ul class="cl">
              @foreach($products as $product)
              <li>
                  <a class="pic" href="{{ route('front.product', ['locale' => app()->getLocale(), 'id' => $product->id]) }}">
                      <img src="{{ $product->cover_image ? asset('storage/' . $product->cover_image) : asset('index_files/p1.jpg') }}" alt="{{ get_translated($product, 'name') }}" title="{{ get_translated($product, 'name') }}">
                  </a>
                  <h6><a href="{{ route('front.product', ['locale' => app()->getLocale(), 'id' => $product->id]) }}" title="{{ get_translated($product, 'name') }}">{{ Str::limit(get_translated($product, 'name'), 50, '...') }}</a></h6>
              </li>
              @endforeach
          </ul>
          @if(count($products) == 0)
              <li class="no-products" width="100%">
                  <div class="no-products-content">
                      <div class="no-products-icon">
                          <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                              <rect x="30" y="50" width="140" height="110" rx="8" fill="none" stroke="#ccc" stroke-width="4"/>
                              <rect x="50" y="30" width="100" height="20" rx="4" fill="none" stroke="#ccc" stroke-width="4"/>
                              <line x1="60" y1="90" x2="140" y2="90" stroke="#ccc" stroke-width="4" stroke-linecap="round"/>
                              <line x1="60" y1="110" x2="120" y2="110" stroke="#ccc" stroke-width="4" stroke-linecap="round"/>
                              <line x1="60" y1="130" x2="100" y2="130" stroke="#ccc" stroke-width="4" stroke-linecap="round"/>
                              <circle cx="140" cy="140" r="25" fill="none" stroke="#ccc" stroke-width="4"/>
                              <line x1="158" y1="158" x2="175" y2="175" stroke="#ccc" stroke-width="4" stroke-linecap="round"/>
                          </svg>
                      </div>
                      <h4>{{ __('front.no_products_found') }}</h4>
                      <p>{{ __('front.no_products_message') }}</p>
                  </div>
              </li>
              @endif
        </div>

        @if($products->hasPages())
        <div class="digg">
            @if($products->onFirstPage())
            <span class="l disabled"><i class="qico qico-left8"></i> {{ __('front.prev') }}</span>
            @else
            <a class="l" href="{{ $products->previousPageUrl() }}"><i class="qico qico-left8"></i> {{ __('front.prev') }}</a>
            @endif
            
            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if($page == $products->currentPage())
                <span class="disabled">{{ $page }}</span>
                @else
                <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
            
            @if($products->hasMorePages())
            <a class="l" href="{{ $products->nextPageUrl() }}">{{ __('front.next') }} <i class="qico qico-right8"></i></a>
            @else
            <span class="l disabled">{{ __('front.next') }} <i class="qico qico-right8"></i></span>
            @endif
        </div>
        @endif

    </div>

</div>

@include('front.partials.footer')

<script type="text/javascript">
$(document).ready(function() {
    var currentUrl = window.location.pathname;
    var foundMatch = false;
    
    // Check if current URL matches a subcategory link
    $('.sidemenu .accordion-content > ul > li > a').each(function() {
        var linkHref = $(this).attr('href');
        // Extract path from full URL
        var linkPath = linkHref.replace(/^https?:\/\/[^\/]+/, '');
        if (currentUrl === linkPath || currentUrl.indexOf(linkPath + '/') === 0) {
            var $parentContent = $(this).closest('.accordion-content');
            var $parentHeader = $parentContent.prev('.accordion-header');
            $parentHeader.addClass('active');
            $parentContent.addClass('active');
            $(this).addClass('active');
            foundMatch = true;
            return false; // break each loop
        }
    });
    
    // If no match found, default expand the first category
    if (!foundMatch) {
        var $firstHeader = $('.sidemenu .accordion-header').first();
        var $firstContent = $firstHeader.next('.accordion-content');
        $firstHeader.addClass('active');
        $firstContent.addClass('active');
    }

    // Accordion click handler with smooth animation
    $('.sidemenu .accordion-header').click(function() {
        var $this = $(this);
        var $content = $this.next('.accordion-content');
        var isActive = $this.hasClass('active');
        
        // Close all other accordions
        $('.sidemenu .accordion-header').not($this).removeClass('active');
        $('.sidemenu .accordion-content').not($content).removeClass('active');
        
        // Toggle current accordion
        if (!isActive) {
            $this.addClass('active');
            $content.addClass('active');
        } else {
            $this.removeClass('active');
            $content.removeClass('active');
        }
    });
});
</script>

@endsection
