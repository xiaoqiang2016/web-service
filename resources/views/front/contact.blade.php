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
        <p>{{ __('front.you_are_here') }} <i class="qico qico-home"></i><a href="{{ route('front.index', app()->getLocale()) }}">{{ __('front.home') }}</a> &gt; {{ __('front.contact') }}</p>
    </div>
</div>

<div class="wp main">

    <div class="contact-info">
        <ul class="cl">
            <li>
                <i class="fas fa-phone-alt contact-icon"></i>
                <h6>{{ __('front.contact_phone') }}</h6>
                <p>
                    @foreach($contactSettings->where('type', 'phone') as $phone)
                        <a href="tel:{{ $phone->value }}">{{ $phone->value }}</a><br>
                    @endforeach
                </p>
            </li>
            <li>
                <i class="fas fa-envelope contact-icon"></i>
                <h6>{{ __('front.contact_email') }}</h6>
                <p>
                    @foreach($contactSettings->where('type', 'email') as $email)
                        <a href="mailto:{{ $email->value }}">{{ $email->value }}</a><br>
                    @endforeach
                </p>
            </li>

            <li>
                <i class="fab fa-whatsapp contact-icon"></i>
                <h6>{{ __('front.contact_whatsapp') }}</h6>
                <p>
                    @foreach($contactSettings->where('type', 'social') as $social)
                        <span>{{ $social->translation?->label }}: {{ $social->value }}</span><br>
                    @endforeach
                </p>
            </li>
            <li>
                <i class="fas fa-map-marker-alt contact-icon"></i>
                <h6>{{ __('front.contact_address') }}</h6>
                <p>{{ $contactSettings->where('type', 'address')->first()?->value }}</p>
            </li>
        </ul>
    </div>

    <div class="contact cl">

        <div class="inquirbox">
            <h4>{{ __('front.inquiry') }}</h4>
            @if(session('success'))
                <div style="color:green;margin-bottom:15px;">{{ session('success') }}</div>
            @endif
            <form method="post" action="{{ route('front.contact.submit', app()->getLocale()) }}" id="contact" name="contact" class="inquirbox" onsubmit="return check()">
                @csrf
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
                    <input type="Submit" class="btn submit c_sub" id="submit" value="{{ __('front.submit') }}">
                </div>
            </form>
        </div>

        <div class="map">
            <div id="map" style="width:100%;height:400px;"></div>
        </div>

    </div>

</div>

@include('front.partials.footer')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
.contact-icon {
    font-size: 24px;
    color: #2C2C2C;
    width: 56px;
    height: 56px;
    line-height: 56px;
    text-align: center;
    border: 1px solid #2C2C2C;
    border-radius: 50%;
    display: inline-block;
}
</style>

<script type="text/javascript">
@php
    $address = $contactSettings->where('type', 'address')->first()?->value ?? '';
    $lat = $contactSettings->where('key', 'map_latitude')->first()?->value ?? '23.0225';
    $lng = $contactSettings->where('key', 'map_longitude')->first()?->value ?? '113.7516';
    $zoom = $contactSettings->where('key', 'map_zoom')->first()?->value ?? '15';
@endphp

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('map')) {
        var map = L.map('map').setView([{{ $lat }}, {{ $lng }}], {{ $zoom }});
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ $lat }}, {{ $lng }}]).addTo(map);
        marker.bindPopup("<b>{{ config('app.name') }}</b><br>{{ $address }}").openPopup();
    }
});

// 表单验证
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
</script>

@endsection
