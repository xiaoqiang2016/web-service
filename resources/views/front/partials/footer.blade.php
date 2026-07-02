<div id="footer">
    <div class="wp cl">

        <div class="foot-about">
            <img src="{{ asset('index_files/logo.png') }}">
            <p>
                {{ __('front.scan_qr_contact') }}</p>
            <br>
            <div class="qr-codes" style="display:flex;gap:15px;align-items:flex-start;flex-wrap:wrap;">
                <div class="qr-item" style="text-align:center;">
                    <img src="{{ asset('images/wechat.jpg') }}" alt="WeChat QR" style="width:110px;height:110px;object-fit:cover;border-radius:6px;border:2px solid #eee;">
                    <p style="font-size:12px;color:#999;margin-top:6px;">{{ __('front.wechat') }}</p>
                </div>
                <div class="qr-item" style="text-align:center;margin-left: 50px;">
                    <img src="{{ asset('images/zola.jpg') }}" alt="Zalo QR" style="width:110px;height:110px;object-fit:cover;border-radius:6px;border:2px solid #eee;">
                    <p style="font-size:12px;color:#999;margin-top:6px;">{{ __('front.zalo') }}</p>
                </div>
            </div>
        </div>

        <div class="foot-list">
            <h5>{{ __('front.quick_link') }}</h5>
            <hr>
            <ul class="cl">
                @foreach($menuCategories as $menuCat)
                    @if($menuCat->type === 'page' && $menuCat->url)
                        @php
                            $routeMap = [
                                '/' => 'front.index',
                                '/products' => 'front.products',
                                '/about' => 'front.about',
                                '/faq' => 'front.faq',
                                '/news' => 'front.news',
                                '/contact' => 'front.contact',
                            ];
                            $routeName = $routeMap[$menuCat->url] ?? null;
                        @endphp
                        @if($routeName)
                            <li><a href="{{ route($routeName, app()->getLocale()) }}">{{ get_translated($menuCat, 'name') }}</a></li>
                        @else
                            <li><a href="{{ url(app()->getLocale() . $menuCat->url) }}">{{ get_translated($menuCat, 'name') }}</a></li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>

        <div class="foot-list2">
            <h5>{{ __('front.products_title') }}</h5>
            <hr>
            <ul class="cl">
                @php $productCats = \App\Models\Category::productTree(1); @endphp
                @foreach($productCats as $cat)
                    <li><a href="{{ route('front.products', app()->getLocale()) }}/{{ $cat->translation?->slug }}">{{ get_translated($cat, 'name') }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="foot-contact">
            <h5>{{ __('front.contact_title') }}</h5>
            <hr>
            @php
                $phones = $contactSettings->where('type', 'phone');
                $emails = $contactSettings->where('type', 'email');
                $address = $contactSettings->where('type', 'address')->first();
                $socials = $contactSettings->where('type', 'social');
            @endphp
            @foreach($phones as $phone)
                <p class="p1"><a href="tel:{{ $phone->value }}">{{ $phone->value }}</a></p>
            @endforeach
            @foreach($emails as $email)
                <p class="p4"><a href="mailto:{{ $email->value }}">{{ $email->value }}</a></p>
            @endforeach
            @if($address)
                <p class="p5">{{ $address->value }}</p>
            @endif
        </div>

    </div>
</div>

<div class="copyright">
    <div class="wp">
        <p>{{ __('front.copyright') }}</p>
    </div>
</div>

<div id="gotop"><i class="qico qico-up"></i></div>
