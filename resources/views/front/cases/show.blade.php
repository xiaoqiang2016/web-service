@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$caseTranslation = $case->translations->firstWhere('locale', $currentLocale) ?? $case->translations->first();
@endphp
@section('title', $caseTranslation?->seo_title ?: get_translated($case, 'title'))
@section('meta_description', $caseTranslation?->seo_description ?: get_translated($case, 'summary') ?: 'Case details')
@section('meta_keywords', $caseTranslation?->seo_keywords ?: 'case, project')

@section('content')

<div id="top">
    <div class="wp cl">
        <span class="fl mo-header-menu"><i class="qico qico-caidan"></i></span>
        <p><a href="tel:+8618122186819">+8618122186819</a></p>
        <div class="search">
            <form class="serchbox cl" name="search" method="get" action="{{ route('front.index', app()->getLocale()) }}">
                <input class="submit_text" type="text" name="" placeholder="Search...">
                <button type="submit" class="submit_btn"><i class="qico qico-search"></i></button>
            </form>
        </div>
        <div class="share">
            <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-facebook"></i></a>
            <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-twitter"></i></a>
            <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-linkedin"></i></a>
            <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-pinterest"></i></a>
            <a href="mailto:haiyan@dgqtwj.cn"><i class="qico qico-skype"></i></a>
            <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-instagram"></i></a>
        </div>
        <span class="fr mo-header-search"><i class="qico qico-sousuo"></i></span>
    </div>

    <div class="mo-search">
        <form role="search" id="searchform" class="cl" method="post" action="{{ route('front.index', app()->getLocale()) }}">
            <input type="text" class="form-control" placeholder="">
            <input class="submit_btn" type="submit" value="GO">
        </form>
    </div>

</div>

<div class="mo-leftmenu visible-xs-block">
    <ul>
        @foreach($menuCategories as $category)
        <li @if(request()->is($category->url . '*'))class="active"@endif>
            <a href="{{ $category->url == '/' ? route('front.index', app()->getLocale()) : url(app()->getLocale() . $category->url) }}">{{ get_translated($category, 'name') }}</a>
            @if($category->children->count() > 0)<i class="qico qico-down down-btn"></i>
            <ul>
                @foreach($category->children as $child)
                <li><a href="{{ $child->url == '/' ? route('front.index', app()->getLocale()) : url(app()->getLocale() . $child->url) }}">{{ get_translated($child, 'name') }}</a></li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>
</div>

<div class="header">
    <div class="wp">
        <div class="logo"><a href="{{ route('front.index', app()->getLocale()) }}"><img src="{{ asset('index_files/logo.png') }}"></a></div>

        <div class="nav">
            <ul>
                @foreach($menuCategories as $category)
                <li @if(request()->is($category->url . '*'))class="active"@endif>
                    <a href="{{ $category->url == '/' ? route('front.index', app()->getLocale()) : url(app()->getLocale() . $category->url) }}">{{ get_translated($category, 'name') }}</a>
                    @if($category->children->count() > 0)
                    <ul>
                        @foreach($category->children as $child)
                        <li><a href="{{ $child->url == '/' ? route('front.index', app()->getLocale()) : url(app()->getLocale() . $child->url) }}">{{ get_translated($child, 'name') }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        <div class="header-right">
            <div class="header-lang">
                <div class="box">
                    <img src="{{ asset('index_files/en.png') }}"><em>{{ strtoupper(app()->getLocale()) }}</em><i class="qico qico-down"></i>
                </div>
                <ul>
                    <li><a href="{{ route('front.case.show', ['zh', $case->translation?->slug]) }}" rel="nofollow"><img src="{{ asset('index_files/en.png') }}">中文</a></li>
                    <li><a href="{{ route('front.case.show', ['en', $case->translation?->slug]) }}" rel="nofollow"><img src="{{ asset('index_files/en.png') }}">EN</a></li>
                    <li><a href="{{ route('front.case.show', ['vn', $case->translation?->slug]) }}" rel="nofollow"><img src="{{ asset('index_files/en.png') }}">VN</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<div class="sidebanner" style="background-image:url({{ asset('index_files/about.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>You are here : <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">Home</a> &gt; <a href="{{ route('front.cases', app()->getLocale()) }}">Cases</a> &gt; {{ get_translated($case, 'title') }}</p>
    </div>
</div>

<div class="main wp">

    <div class="case-detail">
        <h3>{{ get_translated($case, 'title') }}</h3>
        <div class="info">
            @if($case->client_name)
            <span>Client: {{ $case->client_name }}</span>
            @endif
            @if($case->industry)
            <span>Industry: {{ $case->industry }}</span>
            @endif
        </div>
        @if($case->translation?->cover_image)
        <div class="case-pic">
            <img src="{{ asset('storage/' . $case->translation->cover_image) }}">
        </div>
        @endif
        <div class="case-content">
            {!! get_translated($case, 'content') !!}
        </div>
        @if($case->translation?->images && count($case->translation->images) > 0)
        <div class="case-gallery">
            <h4>Gallery</h4>
            <ul class="cl">
                @foreach($case->translation->images as $image)
                <li><img src="{{ asset('storage/' . $image) }}"></li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

</div>

<div id="footer">
    <div class="wp cl">

        <div class="foot-about">
            <img src="{{ asset('index_files/logo.png') }}">
            <p>Enter your mailbox, the first time to check our new developments.</p>
            <div class="sendemail">
                <form class="cl" name="search" method="get" action="{{ route('front.index', app()->getLocale()) }}">
                    <input class="submit_text" type="text" name="" placeholder="email address">
                    <input class="submit_btn" type="submit" value="Subscribe">
                </form>
            </div>
            <div class="share">
                <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-facebook"></i></a>
                <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-twitter"></i></a>
                <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-linkedin"></i></a>
                <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-pinterest"></i></a>
                <a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-instagram"></i></a>
            </div>
        </div>

        <div class="foot-list">
            <h5>QUICK LINK</h5>
            <hr>
            <ul class="cl">
                <li><a href="{{ route('front.index', app()->getLocale()) }}">Home</a></li>
                <li><a href="{{ route('front.products', app()->getLocale()) }}">Products</a></li>
                <li><a href="{{ route('front.about', app()->getLocale()) }}">About Us</a></li>
                <li><a href="{{ route('front.faq', app()->getLocale()) }}">FAQ</a></li>
                <li><a href="{{ route('front.news', app()->getLocale()) }}">News</a></li>
                <li><a href="{{ route('front.contact', app()->getLocale()) }}">Contact</a></li>
            </ul>
        </div>

        <div class="foot-list2">
            <h5>PRODUCTS</h5>
            <hr>
            <ul class="cl">
                <li><a href="{{ route('front.products', app()->getLocale()) }}">CNC Lathe Part</a></li>
                <li><a href="{{ route('front.products', app()->getLocale()) }}">Stamping Part</a></li>
                <li><a href="{{ route('front.products', app()->getLocale()) }}">Die Casting Part</a></li>
            </ul>
        </div>

        <div class="foot-contact">
            <h5>CONTACT</h5>
            <hr>
            <p class="p1"><a href="tel:+86-0769-81372207">+86 0769 81372207</a></p>
            <p class="p3"><a href="tel:+8618122186819">+8618122186819</a></p>
            <p class="p4"><a href="mailto:haiyan@dgqtwj.cn">haiyan@dgqtwj.cn</a></p>
            <p class="p5">No.10, Dongbei 1st Street, Taihe, Shipai, Dongguan, Guangdong, China</p>
        </div>

    </div>
</div>

<div class="copyright">
    <div class="wp">
        <p>Copyright © Dongguan Qianzhu Hardware Co.,Ltd. All rights reserved</p>
    </div>
</div>

<div id="gotop"><i class="qico qico-up"></i></div>

<div id="footBar">
    <ul class="cl">
        <li><a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-home"></i><span>HOME</span></a></li>
        <li><a href="{{ route('front.products', app()->getLocale()) }}"><i class="qico qico-sort"></i><span>Products</span></a></li>
        <li><a href="mailto:haiyan@dgqtwj.cn"><i class="qico qico-youxiang"></i><span>E-mail</span></a></li>
        <li><a href="tel:+8618122186819"><i class="qico qico-tel"></i><span>Tel</span></a></li>
    </ul>
</div>

@endsection
