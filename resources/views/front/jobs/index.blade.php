@extends('front.layouts.master')
@php
$currentLocale = app()->getLocale();
$categoryTranslation = isset($category) ? ($category->translations->firstWhere('locale', $currentLocale) ?? $category->translations->first()) : null;
@endphp
@section('title', $categoryTranslation?->seo_title ?: 'Jobs')
@section('meta_description', $categoryTranslation?->seo_description ?: 'Join our team - job opportunities')
@section('meta_keywords', $categoryTranslation?->seo_keywords ?: 'jobs, careers, employment')

@section('content')

<div id="top">
    <div class="wp cl">
        <span class="fl mo-header-menu"><i class="qico qico-caidan"></i></span>
        <p><a href="tel:+8618122186819">+8618122186819</a></p>
        <div class="search">
            <form class="serchbox cl" name="search" method="get" action="{{ route('front.index', app()->getLocale()) }}">
                <input class="submit_text" type="text" name="" placeholder="{{ __('front.search') }}">
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
                    @if(app()->getLocale() === 'zh')
                    <svg class="lang-flag" width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg"><rect width="600" height="400" fill="#DE2910"/><polygon points="100,50 115,95 165,95 125,125 140,170 100,140 60,170 75,125 35,95 85,95" fill="#FFDE00"/></svg>
                    @elseif(app()->getLocale() === 'vn')
                    <svg class="lang-flag" width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg"><rect width="600" height="400" fill="#DA251D"/><polygon points="300,80 340,200 470,200 365,280 405,400 300,320 195,400 235,280 130,200 260,200" fill="#FFFF00"/></svg>
                    @else
                    <svg class="lang-flag" width="20" height="15" viewBox="0 0 60 30" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="30" fill="#012169"/><path d="M0,0 60,30 M60,0 0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 60,30 M60,0 0,30" stroke="#C8102E" stroke-width="4"/><path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/><path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/></svg>
                    @endif
                    <em>{{ strtoupper(app()->getLocale()) }}</em><i class="qico qico-down"></i>
                </div>
                <ul>
                    <li><a href="{{ route('front.jobs', 'zh') }}" rel="nofollow">
                        <svg width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg"><rect width="600" height="400" fill="#DE2910"/><polygon points="100,50 115,95 165,95 125,125 140,170 100,140 60,170 75,125 35,95 85,95" fill="#FFDE00"/></svg>中文</a></li>
                    <li><a href="{{ route('front.jobs', 'en') }}" rel="nofollow">
                        <svg width="20" height="15" viewBox="0 0 60 30" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="30" fill="#012169"/><path d="M0,0 60,30 M60,0 0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 60,30 M60,0 0,30" stroke="#C8102E" stroke-width="4"/><path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/><path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/></svg>EN</a></li>
                    <li><a href="{{ route('front.jobs', 'vn') }}" rel="nofollow">
                        <svg width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg"><rect width="600" height="400" fill="#DA251D"/><polygon points="300,80 340,200 470,200 365,280 405,400 300,320 195,400 235,280 130,200 260,200" fill="#FFFF00"/></svg>VN</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>

<div class="sidebanner" style="background-image:url({{ asset('index_files/cate03.jpg') }})"></div>

<div class="path">
    <div class="wp cl">
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; {{ __('front.jobs') }}</p>
    </div>
</div>

<div class="main wp cl">

    <div class="main-left">

        <div class="sidemenu">
            <h3>{{ __('front.departments') }}</h3>
            <ul>
                <li class="active">
                    <h5><a href="{{ route('front.jobs', app()->getLocale()) }}">{{ __('front.all_jobs') }}</a><span></span></h5>
                </li>
                <li>
                    <h5><a href="{{ route('front.jobs', app()->getLocale()) }}">{{ __('front.engineering') }}</a><span></span></h5>
                </li>
                <li>
                    <h5><a href="{{ route('front.jobs', app()->getLocale()) }}">{{ __('front.manufacturing') }}</a><span></span></h5>
                </li>
                <li>
                    <h5><a href="{{ route('front.jobs', app()->getLocale()) }}">{{ __('front.sales') }}</a><span></span></h5>
                </li>
            </ul>
        </div>

        <div class="side-contact">
            <h3>{{ __('front.contact') }}</h3>
            <div class="nr">
                <p class="p1"><a href="tel:+86 0769 81372207">+86 0769 81372207</a></p>
                <p class="p3"><a href="tel:+8618122186819">+8618122186819</a></p>
                <p class="p4"><a href="mailto:haiyan@dgqtwj.cn">haiyan@dgqtwj.cn</a></p>
                <p class="p5">No. 10, Dongbei 1st Street, Taihe, Shipai, Dongguan, Guangdong, China</p>
            </div>
        </div>

    </div>

    <div class="main-right">

        <div class="job-list">
            <div class="index-tit2">
                <h3>{{ __('front.careers') }}</h3>
                <hr>
            </div>
            <ul class="cl">
                @foreach($jobs as $job)
                <li>
                    <div class="job-info">
                        <h5><a href="{{ route('front.job.show', [app()->getLocale(), $job->translation?->slug]) }}">{{ get_translated($job, 'title') }}</a></h5>
                        <div class="meta">
                            @if($job->department)
                            <span><i class="qico qico-user"></i> {{ $job->department }}</span>
                            @endif
                            @if($job->location)
                            <span><i class="qico qico-location"></i> {{ $job->location }}</span>
                            @endif
                            @if($job->salary)
                            <span class="salary"><i class="qico qico-money"></i> {{ $job->salary }}</span>
                            @endif
                        </div>
                        <p>{{ get_translated($job, 'description') }}</p>
                        <a href="{{ route('front.job.show', [app()->getLocale(), $job->translation?->slug]) }}" class="read-more">{{ __('front.view_details') }} <i class="qico qico-right7"></i></a>
                    </div>
                </li>
                @endforeach
                @for($i = count($jobs); $i < 3; $i++)
                <li>
                    <div class="job-info">
                        <h5><a href="{{ route('front.jobs', app()->getLocale()) }}">{{ __('front.job_position') }}</a></h5>
                        <div class="meta">
                            <span><i class="qico qico-user"></i> {{ __('front.department') }}</span>
                            <span><i class="qico qico-location"></i> Dongguan</span>
                            <span class="salary"><i class="qico qico-money"></i> {{ __('front.negotiable') }}</span>
                        </div>
                        <p>{{ __('front.job_description_placeholder') }}</p>
                        <a href="{{ route('front.jobs', app()->getLocale()) }}" class="read-more">{{ __('front.view_details') }} <i class="qico qico-right7"></i></a>
                    </div>
                </li>
                @endfor
            </ul>
        </div>

        <div class="digg">
            <a class="l" href="{{ route('front.jobs', app()->getLocale()) }}"><i class="qico qico-left8"></i> {{ __('front.prev') }}</a>
            <span class="disabled">1</span>
            <a href="{{ route('front.jobs', app()->getLocale()) }}">2</a>
            <a href="{{ route('front.jobs', app()->getLocale()) }}">3</a>
            <a href="{{ route('front.jobs', app()->getLocale()) }}">4</a>
            <a href="{{ route('front.jobs', app()->getLocale()) }}">5</a>
            <a href="{{ route('front.jobs', app()->getLocale()) }}"><i class="qico qico-right7"></i></a>
            <a class="l" href="{{ route('front.jobs', app()->getLocale()) }}">{{ __('front.next') }} <i class="qico qico-right8"></i></a>
        </div>

    </div>

</div>

<div id="footer">
    <div class="wp cl">

        <div class="foot-about">
            <img src="{{ asset('index_files/logo.png') }}">
            <p>{{ __('front.subscribe_description') }}</p>
            <div class="sendemail">
                <form class="cl" name="search" method="get" action="{{ route('front.index', app()->getLocale()) }}">
                    <input class="submit_text" type="text" name="" placeholder="{{ __('front.email_address') }}">
                    <input class="submit_btn" type="submit" value="{{ __('front.subscribe') }}">
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
            <h5>{{ __('front.quick_link') }}</h5>
            <hr>
            <ul class="cl">
                <li><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a></li>
                <li><a href="{{ route('front.products', app()->getLocale()) }}">{{ __('front.products') }}</a></li>
                <li><a href="{{ route('front.about', app()->getLocale()) }}">{{ __('front.about_us') }}</a></li>
                <li><a href="{{ route('front.faq', app()->getLocale()) }}">{{ __('front.faq') }}</a></li>
                <li><a href="{{ route('front.news', app()->getLocale()) }}">{{ __('front.news') }}</a></li>
                <li><a href="{{ route('front.contact', app()->getLocale()) }}">{{ __('front.contact') }}</a></li>
            </ul>
        </div>

        <div class="foot-list2">
            <h5>{{ __('front.products_title') }}</h5>
            <hr>
            <ul class="cl">
                <li><a href="{{ route('front.products', app()->getLocale()) }}">CNC Lathe Part</a></li>
                <li><a href="{{ route('front.products', app()->getLocale()) }}">Stamping Part</a></li>
                <li><a href="{{ route('front.products', app()->getLocale()) }}">Die Casting Part</a></li>
            </ul>
        </div>

        <div class="foot-contact">
            <h5>{{ __('front.contact_title') }}</h5>
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
        <p>{{ __('front.copyright') }}</p>
    </div>
</div>

<div id="gotop"><i class="qico qico-up"></i></div>

<div id="footBar">
    <ul class="cl">
        <li><a href="{{ route('front.index', app()->getLocale()) }}"><i class="qico qico-home"></i><span>{{ __('front.home') }}</span></a></li>
        <li><a href="{{ route('front.products', app()->getLocale()) }}"><i class="qico qico-sort"></i><span>{{ __('front.products') }}</span></a></li>
        <li><a href="mailto:haiyan@dgqtwj.cn"><i class="qico qico-youxiang"></i><span>{{ __('front.email') }}</span></a></li>
        <li><a href="tel:+8618122186819"><i class="qico qico-tel"></i><span>{{ __('front.phone') }}</span></a></li>
    </ul>
</div>

@endsection