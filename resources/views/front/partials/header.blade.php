<div id="top">
    <div class="wp cl">
        <span class="fl mo-header-menu"><i class="qico qico-caidan"></i></span>
        <p><a href="tel:{{ $contactSettings->where('type', 'phone')->first()?->value }}">{{ $contactSettings->where('type', 'phone')->first()?->value }}</a></p>
        <div class="search">
            <form class="serchbox cl" name="search" method="get" action="{{ route('front.search', app()->getLocale()) }}">
                <input class="submit_text" type="text" name="keyword" placeholder="{{ __('front.search') }}" value="{{ request('keyword') }}">
                <button type="submit" class="submit_btn"><i class="qico qico-search"></i></button>
            </form>
        </div>
        <span class="fr mo-header-search"><i class="qico qico-sousuo"></i></span>
    </div>

    <div class="mo-search">
        <form role="search" id="searchform" class="cl" method="get" action="{{ route('front.search', app()->getLocale()) }}">
            <input type="text" class="form-control" name="keyword" placeholder="{{ __('front.search') }}" value="{{ request('keyword') }}">
            <input class="submit_btn" type="submit" value="GO">
        </form>
    </div>

</div>

<div class="mo-leftmenu visible-xs-block">
    <ul>
        @foreach($menuCategories as $category)
        <?php
            $url = $category->url == '/' ? '/' : app()->getLocale() . $category->url;
            $isActive = request()->is(trim($url, '/')) || request()->is(trim($url, '/') . '/*') || request()->is($url) || request()->is($url . '/*');
        ?>
        <li @if($isActive)class="active"@endif>
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
                <?php
                    $url = $category->url == '/' ? '/' : app()->getLocale() . $category->url;
                    $isActive = request()->is(trim($url, '/')) || request()->is(trim($url, '/') . '/*') || request()->is($url) || request()->is($url . '/*');
                ?>
                <li @if($isActive)class="active"@endif>
                    <a href="{{ $category->url == '/' ? route('front.index', app()->getLocale()) : url(app()->getLocale() . $category->url) }}">{{ get_translated($category, 'name') }}</a>
                    @if($category->children->count() > 0)
                    <ul>
                        @foreach($category->children as $child)
                        <li>
                            @if($child->type === 'product')
                            <a href="{{ route('front.products', app()->getLocale()) }}/{{ $child->translation?->slug }}">{{ get_translated($child, 'name') }}</a>
                            @else
                            <a href="{{ $child->url == '/' ? route('front.index', app()->getLocale()) : url(app()->getLocale() . $child->url) }}">{{ get_translated($child, 'name') }}</a>
                            @endif
                        </li>
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
                    <svg class="lang-flag" width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                        <rect width="600" height="400" fill="#DE2910"/>
                        <polygon points="100,50 115,95 165,95 125,125 140,170 100,140 60,170 75,125 35,95 85,95" fill="#FFDE00"/>
                    </svg>
                    @elseif(app()->getLocale() === 'vn')
                    <svg class="lang-flag" width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                        <rect width="600" height="400" fill="#DA251D"/>
                        <polygon points="300,80 340,200 470,200 365,280 405,400 300,320 195,400 235,280 130,200 260,200" fill="#FFFF00"/>
                    </svg>
                    @else
                    <svg class="lang-flag" width="20" height="15" viewBox="0 0 60 30" xmlns="http://www.w3.org/2000/svg">
                        <rect width="60" height="30" fill="#012169"/>
                        <path d="M0,0 60,30 M60,0 0,30" stroke="#fff" stroke-width="6"/>
                        <path d="M0,0 60,30 M60,0 0,30" stroke="#C8102E" stroke-width="4"/>
                        <path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/>
                        <path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/>
                    </svg>
                    @endif
                    <em>{{ strtoupper(app()->getLocale()) }}</em><i class="qico qico-down"></i>
                </div>
                <ul>
                    @if(isset($translatable) && $translatable)
                        {{-- 有翻译对象的页面（如文章详情页） --}}
                        <li><a href="{{ route(Route::currentRouteName(), ['zh', $translatable->translations->where('locale', 'zh')->first()?->slug ?? $translatable->translation?->slug]) }}" rel="nofollow">
                            <svg width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                                <rect width="600" height="400" fill="#DE2910"/>
                                <polygon points="100,50 115,95 165,95 125,125 140,170 100,140 60,170 75,125 35,95 85,95" fill="#FFDE00"/>
                            </svg>ZH</a></li>
                        <li><a href="{{ route(Route::currentRouteName(), ['en', $translatable->translations->where('locale', 'en')->first()?->slug ?? $translatable->translation?->slug]) }}" rel="nofollow">
                            <svg width="20" height="15" viewBox="0 0 60 30" xmlns="http://www.w3.org/2000/svg">
                                <rect width="60" height="30" fill="#012169"/>
                                <path d="M0,0 60,30 M60,0 0,30" stroke="#fff" stroke-width="6"/>
                                <path d="M0,0 60,30 M60,0 0,30" stroke="#C8102E" stroke-width="4"/>
                                <path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/>
                                <path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/>
                            </svg>EN</a></li>
                        <li><a href="{{ route(Route::currentRouteName(), ['vn', $translatable->translations->where('locale', 'vn')->first()?->slug ?? $translatable->translation?->slug]) }}" rel="nofollow">
                            <svg width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                                <rect width="600" height="400" fill="#DA251D"/>
                                <polygon points="300,80 340,200 470,200 365,280 405,400 300,320 195,400 235,280 130,200 260,200" fill="#FFFF00"/>
                            </svg>VN</a></li>
                    @else
                        {{-- 普通页面（如列表页） --}}
                        @php
                            $routeParams = request()->route()->parameters();
                            $routeName = Route::currentRouteName();
                        @endphp
                        <li><a href="{{ $routeName ? route($routeName, array_merge($routeParams, ['locale' => 'zh'])) : url('zh' . request()->getRequestUri()) }}" rel="nofollow">
                            <svg width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                                <rect width="600" height="400" fill="#DE2910"/>
                                <polygon points="100,50 115,95 165,95 125,125 140,170 100,140 60,170 75,125 35,95 85,95" fill="#FFDE00"/>
                            </svg>ZH</a></li>
                        <li><a href="{{ $routeName ? route($routeName, array_merge($routeParams, ['locale' => 'en'])) : url('en' . request()->getRequestUri()) }}" rel="nofollow">
                            <svg width="20" height="15" viewBox="0 0 60 30" xmlns="http://www.w3.org/2000/svg">
                                <rect width="60" height="30" fill="#012169"/>
                                <path d="M0,0 60,30 M60,0 0,30" stroke="#fff" stroke-width="6"/>
                                <path d="M0,0 60,30 M60,0 0,30" stroke="#C8102E" stroke-width="4"/>
                                <path d="M30,0 V30 M0,15 H60" stroke="#fff" stroke-width="10"/>
                                <path d="M30,0 V30 M0,15 H60" stroke="#C8102E" stroke-width="6"/>
                            </svg>EN</a></li>
                        <li><a href="{{ $routeName ? route($routeName, array_merge($routeParams, ['locale' => 'vn'])) : url('vn' . request()->getRequestUri()) }}" rel="nofollow">
                            <svg width="20" height="15" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                                <rect width="600" height="400" fill="#DA251D"/>
                                <polygon points="300,80 340,200 470,200 365,280 405,400 300,320 195,400 235,280 130,200 260,200" fill="#FFFF00"/>
                            </svg>VN</a></li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
</div>
