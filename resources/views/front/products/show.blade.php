@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$productTranslation = $product->translations->firstWhere('locale', $currentLocale) ?? $product->translations->first();
@endphp
@section('title', $productTranslation?->seo_title ?: get_translated($product, 'name'))
@section('meta_description', $productTranslation?->seo_description ?: get_translated($product, 'summary') ?: 'Product details')
@section('meta_keywords', $productTranslation?->seo_keywords ?: 'product')

@section('content')

@include('front.partials.header')

<div class="sidebanner" style="background-image:url({{ $banner ? asset('storage/' . ($banner->translation?->image ?? $banner->image)) : asset('index_files/cate01.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; <a href="{{ route('front.products', app()->getLocale()) }}">{{ __('front.products') }}</a> &gt; {{ get_translated($product, 'name') }}</p>
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

        <div class="pro_view_top cl">

            <div class="pro_img">
                <div class="view">
                    <div class="swiper-container swiper-container-horizontal">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <a class="product-gallery-link" href="{{ $product->cover_image ? asset('storage/' . $product->cover_image) : asset('index_files/p1.jpg') }}">
                                    <img src="{{ $product->cover_image ? asset('storage/' . $product->cover_image) : asset('index_files/p1.jpg') }}" alt="{{ get_translated($product, 'name') }}">
                                </a>
                            </div>
                            @php
                                $images = is_array($product->images) ? $product->images : (is_string($product->images) && $product->images ? explode(',', $product->images) : []);
                            @endphp
                            @foreach($images as $image)
                            <div class="swiper-slide">
                                <a class="product-gallery-link" href="{{ asset('storage/' . $image) }}">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ get_translated($product, 'name') }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <a class="arrow-left" href="#"><i class="qico qico-left"></i></a>
                        <a class="arrow-right" href="#"><i class="qico qico-right"></i></a>
                    </div>
                </div>
                <div class="preview">
                    <div class="swiper-container swiper-container-horizontal">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="{{ $product->cover_image ? asset('storage/' . $product->cover_image) : asset('index_files/p1.jpg') }}" alt=""></div>
                            @foreach($images as $image)
                            <div class="swiper-slide"><img src="{{ asset('storage/' . $image) }}" alt=""></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="pro_view_inner">
                <h1>{{ get_translated($product, 'name') }}</h1>
                <hr>
                <div class="para">
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td>{{ __('front.brand_name') }}:</td>
                                <td>{{ $product->model ? 'Qianzhu' : '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('front.model_number') }}:</td>
                                <td>{{ $product->model ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('front.certification') }}:</td>
                                <td>{{ $product->translation?->certification ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('front.min_order_quantity') }}:</td>
                                <td>{{ $product->translation?->min_order_quantity ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('front.packaging_details') }}:</td>
                                <td>{{ $product->translation?->packaging_details ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('front.delivery_time') }}:</td>
                                <td>{{ $product->translation?->delivery_time ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('front.payment_terms') }}:</td>
                                <td>{{ $product->translation?->payment_terms ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('front.supply_ability') }}:</td>
                                <td>{{ $product->translation?->supply_ability ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        <div class="pro_tab_box">
            <div class="pro_tab" id="proTabNav">
                <ul class="cl">
                    <li class="pro_gd1 pro_menu_over active"><a href="#gd1">{{ __('front.description') }}</a></li>
                    <li class="pro_gd2"><a href="#gd2">{{ __('front.specifications') }}</a></li>
                    <li class="pro_gd3"><a href="#gd3">{{ __('front.competitive_advantage') }}</a></li>
                    <li class="pro_gd4"><a href="#gd4">{{ __('front.inquiry') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="pro_text">

            <div id="gd1" class="pro-scroll">

                <div class="tit"><h5>{{ __('front.description') }}</h5></div>

                <div class="pro-content pro-cont-1">
                    {!! get_translated($product, 'description') !!}
                </div>
            </div>

            <div id="gd2" class="pro-scroll">

                <div class="tit"><h5>{{ __('front.specifications') }}</h5></div>

                <div class="pro-content">
                    {!! get_translated($product, 'specifications') !!}
                </div>
            </div>

            <div id="gd3" class="pro-scroll">

                <div class="tit"><h5>{{ __('front.competitive_advantage') }}</h5></div>

                <div class="pro-content">
                    {!! get_translated($product, 'competitive_advantage') !!}
                </div>

            </div>

            <div id="gd4" class="pro-scroll pro-inquiry">
                <h4>{{ __('front.inquiry') }}</h4>
                <form method="post" action="{{ route('front.contact.submit', app()->getLocale()) }}" id="contact" name="contact" class="inquirbox" onsubmit="return check()">
                    @csrf
                    <input type="hidden" name="product_name" value="{{ get_translated($product, 'name') }}">
                    <div class="row">
                        <input type="text" id="name" name="name" maxlength="20" class="c_name" placeholder="{{ __('front.your_name') }}" value="{{ old('name') }}">
                        <input type="text" id="company" name="company" maxlength="20" placeholder="{{ __('front.company_name') }}" value="{{ old('company') }}">
                    </div>
                    <div class="row">
                        <input type="text" id="phone" name="phone" maxlength="20" placeholder="{{ __('front.phone') }}" value="{{ old('phone') }}">
                        <input type="text" id="email" name="email" maxlength="50" class="c_email" placeholder="{{ __('front.email') }}" value="{{ old('email') }}">
                    </div>
                    <div class="row">
                        <textarea id="content" name="content" maxlength="300" rows="4" class="c_cnt" placeholder="{{ __('front.your_inquiry') }}">{{ old('content') }}</textarea>
                    </div>
                    <div class="row">
                        <input type="text" name="captcha" class="yzm" maxlength="4" placeholder="{{ __('front.verification_code') }}">
                        <img src="{{ route('front.contact.captcha', app()->getLocale()) }}" onclick="this.src='{{ route('front.contact.captcha', app()->getLocale()) }}?t='+Math.random()" style="cursor:pointer;vertical-align:middle;">
                    </div>
                    <div class="row">
                        <input type="Submit" class="btn submit c_sub" id="submit" value="{{ __('front.send') }}">
                    </div>
                </form>
            </div>

        </div>

    </div>

</div>

@include('front.partials.footer')

<script type="text/javascript">
$("#proTabNav ul li").click(function() {
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
});

$(document).on('click', '.product-gallery-link', function(e) {
    e.preventDefault();
    var $this = $(this);
    var galleryItems = $('.product-gallery-link').map(function() {
        return {
            src: $(this).attr('href'),
            caption: '{{ get_translated($product, "name") }}'
        };
    }).get();
    var index = galleryItems.findIndex(function(item) {
        return item.src === $this.attr('href');
    });
    if (index < 0) index = 0;
    $.fancybox.open(galleryItems, {
        type: 'image',
        index: index,
        toolbar: true,
        arrows: true,
        infobar: true,
        smallBtn: true,
        transitionEffect: 'fade',
        background: 'rgba(0, 0, 0, 0.85)',
        margin: [40, 40, 40, 40],
        buttons: ['close'],
        thumbs: {
            autoStart: false,
            axis: 'y'
        },
        btnTpl: {
				arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="Previous">←</button>',
				arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="Next">→</button>',
			},
    });
});

function check() {
    if ($(".c_name").val() == '' || $(".c_email").val() == '' || $(".c_cnt").val() == '' || $(".yzm").val() == '') {
        alert('{{ __('front.fill_required_fields') }}');
        return false;
    }
    
    var email = $(".c_email").val();
    if (!(/^[0-9a-zA-Z|\-|\.|_]{2,50}[@]{1}[0-9a-zA-Z|\-]{2,50}[\.]{1}[0-9a-zA-Z|\-|\.]{2,50}$/.test(email))) {
        alert('{{ __('front.valid_email') }}');
        return false;
    }
    
    return true;
}

$(document).ready(function() {
    // Expand the category that contains the current product - run this first
    var currentCategoryId = {{ $currentCategoryId }};
    var $targetHeader = $('.sidemenu .accordion-header[data-id="category-' + currentCategoryId + '"]');
    var $targetContent = $targetHeader.next('.accordion-content');
    
    if ($targetHeader.length) {
        $targetHeader.addClass('active');
        $targetContent.addClass('active');
    }

    // Highlight the subcategory link if the product belongs to a subcategory
    var categorySlug = '{{ $product->category?->translation?->slug }}';
    var isSubcategory = {{ $product->category?->parent_id ? ($product->category->parent->type !== 'page' ? 'true' : 'false') : 'false' }};
    
    if (categorySlug && isSubcategory) {
        var $allLinks = $('.sidemenu .accordion-content a');
        $allLinks.each(function() {
            var linkHref = $(this).attr('href') || '';
            if (linkHref.indexOf('/' + categorySlug) !== -1) {
                $(this).addClass('active');
                return false;
            }
        });
    }

    // Initialize product gallery Swiper
    var gallerySwiper = new Swiper('.pro_img .view .swiper-container', {
        nextButton: '.pro_img .view .arrow-right',
        prevButton: '.pro_img .view .arrow-left',
        spaceBetween: 10,
        preventClicks: false,
        preventClicksPropagation: false,
    });

    var thumbnailSwiper = new Swiper('.pro_img .preview .swiper-container', {
        slidesPerView: 5,
        spaceBetween: 10,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });

    gallerySwiper.params.control = thumbnailSwiper;
    thumbnailSwiper.params.control = gallerySwiper;

    // Thumbnail click to switch main image
    $('.pro_img .preview .swiper-slide').on('click', function() {
        var index = $(this).index();
        gallerySwiper.slideTo(index);
    });

    // Set first thumbnail as active
    $('.pro_img .preview .swiper-slide').first().addClass('active-nav');

    // Update active thumbnail on slide change
    gallerySwiper.on('slideChangeStart', function() {
        $('.pro_img .preview .swiper-slide').removeClass('active-nav');
        $('.pro_img .preview .swiper-slide').eq(gallerySwiper.activeIndex).addClass('active-nav');
    });

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

    // Tab scroll-to-fixed functionality
    var $proTabNav = $('#proTabNav');
    var $proTabBox = $proTabNav.closest('.pro_tab_box');
    var tabOffsetTop = $proTabBox.offset().top;
    var tabHeight = $proTabNav.outerHeight();
    // Include #top bar + .header height
    var headerHeight = 0;
    var isFixed = false;
    var $placeholder = $('<div class="pro-tab-placeholder" style="display:none;height:' + tabHeight + 'px;"></div>');

    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        var triggerPoint = tabOffsetTop - headerHeight - 10;

        if (scrollTop >= triggerPoint && !isFixed) {
            $proTabNav.css({
                'position': 'fixed',
                'top': headerHeight + 'px',
                'z-index': 100
            });
            $proTabBox.after($placeholder.show());
            isFixed = true;
        } else if (scrollTop < triggerPoint && isFixed) {
            $proTabNav.css({
                'position': '',
                'top': '',
                'z-index': ''
            });
            $placeholder.hide().remove();
            isFixed = false;
        }
    });

    // Smooth scroll for tab links
    $('.pro_tab a[href^="#"]').click(function(e) {
        e.preventDefault();
        var targetId = $(this).attr('href');
        var $target = $(targetId);
        if ($target.length) {
            var offset = $target.offset().top - headerHeight - tabHeight - 10;
            $('html, body').animate({ scrollTop: offset }, 300);
        }
    });
});
</script>

@endsection
