@php
    $adminUser = session('admin_user');
    $hasPermission = function($permission) use ($adminUser) {
        if (!$adminUser) return false;
        return $adminUser->hasPermission($permission);
    };
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ __('admin.company_name') }}</title>
    @stack('styles')
    @vite('resources/css/app.css')
    <style>
        .sidebar-link {
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            transform: translateX(4px);
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.3) 0%, transparent 100%);
            border-left: 3px solid #3b82f6;
        }
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        .table-row:hover {
            background-color: #f8fafc;
        }
        .input-field {
            transition: all 0.2s ease;
        }
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .admin-sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
        }
        .admin-sidebar-header {
            border-bottom: 1px solid #334155;
        }
        .admin-sidebar-link {
            color: #cbd5e1;
            transition: all 0.2s ease;
        }
        .admin-sidebar-link:hover {
            color: white;
            background-color: rgba(51, 65, 85, 0.5);
        }
        .admin-sidebar-link.active {
            color: white;
            background-color: rgba(51, 65, 85, 0.8);
            border-left: 3px solid #3b82f6;
        }
        .admin-sidebar-link svg,
        .accordion-header svg:first-child {
            width: 18px !important;
            height: 18px !important;
            flex-shrink: 0;
        }
        .accordion-header svg:last-child {
            width: 14px !important;
            height: 14px !important;
            flex-shrink: 0;
        }
        .accordion-header {
            color: #cbd5e1;
            cursor: pointer;
        }
        .accordion-header:hover {
            color: white;
            background-color: rgba(51, 65, 85, 0.5);
        }
        .accordion-header.active {
            color: white;
            background-color: rgba(51, 65, 85, 0.8);
            border-left: 3px solid #3b82f6;
        }
        .accordion-header.active svg:last-child {
            transform: rotate(180deg);
        }
        .accordion-content {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
        }
        .accordion-content.show {
            max-height: 200px;
        }
        .admin-sidebar {
            overflow-y: auto;
            max-height: 100vh;
        }
        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .admin-sidebar::-webkit-scrollbar-track {
            background: #1e293b;
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 2px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex">
        <aside class="w-64 admin-sidebar min-h-screen fixed shadow-xl">
            <div class="p-6 admin-sidebar-header">
                <h1 class="text-xl font-bold flex items-center gap-2">
                    <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ __('admin.company_name') }}
                </h1>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    {{ __('admin.sidebar.dashboard') }}
                </a>
                {{-- Languages menu temporarily hidden --}}
                {{-- <a href="{{ route('admin.languages.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.languages.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                    </svg>
                    {{ __('admin.sidebar.languages') }}
                </a> --}}
                @if($hasPermission('categories'))
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    {{ __('admin.sidebar.categories') }}
                </a>
                @endif
                @if($hasPermission('articles'))
                <a href="{{ route('admin.articles.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    {{ __('admin.sidebar.articles') }}
                </a>
                @endif
                @if($hasPermission('products'))
                <a href="{{ route('admin.products.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ __('admin.sidebar.products') }}
                </a>
                @endif
                @if($hasPermission('banners'))
                <a href="{{ route('admin.banners.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('admin.sidebar.banners') }}
                </a>
                @endif
                @if($hasPermission('messages'))
                <a href="{{ route('admin.messages.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    {{ __('admin.sidebar.messages') }}
                </a>
                @endif
                @if($hasPermission('contact-settings'))
                <a href="{{ route('admin.contact-settings.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.contact-settings.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Contact Settings
                </a>
                @endif
                @if($hasPermission('faqs'))
                <a href="{{ route('admin.faqs.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    FAQ
                </a>
                @endif
                @if($hasPermission('admin-users'))
                <a href="{{ route('admin.admin-users.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.admin-users.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    User Management
                </a>
                @endif
                @if($hasPermission('admin-roles'))
                <a href="{{ route('admin.admin-roles.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.admin-roles.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Role Management
                </a>
                @endif
                
                @if($hasPermission('about') || $hasPermission('honor-images') || $hasPermission('factory-images'))
                <div class="accordion">
                    <button class="accordion-header w-full flex items-center justify-between gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition-colors {{ request()->routeIs('admin.about-contents.*') || request()->routeIs('admin.honor-images.*') || request()->routeIs('admin.factory-images.*') ? 'active' : '' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            About Us
                        </div>
                        <svg class="w-3 h-3 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="accordion-content {{ request()->routeIs('admin.about-contents.*') || request()->routeIs('admin.honor-images.*') || request()->routeIs('admin.factory-images.*') ? 'show' : '' }}">
                        @if($hasPermission('about'))
                        <a href="{{ route('admin.about-contents.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg ml-6 {{ request()->routeIs('admin.about-contents.*') ? 'active' : '' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Company Introduction
                        </a>
                        @endif
                        @if($hasPermission('honor-images'))
                        <a href="{{ route('admin.honor-images.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg ml-6 {{ request()->routeIs('admin.honor-images.*') ? 'active' : '' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            Honor Certificates
                        </a>
                        @endif
                        @if($hasPermission('factory-images'))
                        <a href="{{ route('admin.factory-images.index') }}" class="sidebar-link admin-sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg ml-6 {{ request()->routeIs('admin.factory-images.*') ? 'active' : '' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Factory Images
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </nav>
        </aside>
        <main class="flex-1 ml-64 p-8">
            <header class="flex justify-between items-center mb-8 bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-2xl font-bold text-slate-800">@yield('title')</h2>
                <div class="flex items-center space-x-4">
                    {{-- Language switcher temporarily hidden --}}
                {{-- <div class="relative">
                    <select onchange="window.location.href=this.value" class="appearance-none bg-white border border-gray-200 rounded-lg px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent cursor-pointer hover:border-gray-300 transition-colors">
                        @foreach(\App\Models\Language::getActive() as $lang)
                            <option value="{{ route('admin.dashboard', ['lang' => $lang->locale]) }}" {{ app()->getLocale() == $lang->locale ? 'selected' : '' }}>{{ $lang->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div> --}}
                    <div class="flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-lg">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-medium text-slate-700">{{ session('admin_user')?->username }}</span>
                    </div>
                    <a href="{{ route('admin.logout') }}" class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('admin.sidebar.logout') }}
                    </a>
                </div>
            </header>
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @vite('resources/js/app.js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionHeaders = document.querySelectorAll('.accordion-header');
            accordionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const isActive = this.classList.contains('active');
                    
                    document.querySelectorAll('.accordion-header').forEach(h => h.classList.remove('active'));
                    document.querySelectorAll('.accordion-content').forEach(c => c.classList.remove('show'));
                    
                    if (!isActive) {
                        this.classList.add('active');
                        content.classList.add('show');
                    }
                });
            });
        });
    </script>
@stack('scripts')
</body>
</html>
