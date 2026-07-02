<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="X-UA-Compatible" content="IE=10">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <link rel="stylesheet" type="text/css" href="{{ asset('index_files/public.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('index_files/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('index_files/swiper3.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('index_files/jquery.fancybox.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('index_files/media-queries.css') }}">
    @stack('styles')
    <script type="text/javascript" src="{{ asset('index_files/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('index_files/jquery.fancybox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('index_files/swiper3.js') }}"></script>
</head>
<body>
    @yield('content')
    <script type="text/javascript" src="{{ asset('index_files/index.js') }}"></script>
    @stack('scripts')
</body>
</html>