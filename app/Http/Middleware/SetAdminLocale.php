<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Language;

class SetAdminLocale
{
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->query('lang');
        
        if ($lang && Language::where('locale', $lang)->where('is_active', 1)->exists()) {
            app()->setLocale($lang);
            session(['admin_locale' => $lang]);
        } else if (session('admin_locale')) {
            app()->setLocale(session('admin_locale'));
        } else {
            $defaultLocale = Language::getDefault()?->locale ?? 'en';
            app()->setLocale($defaultLocale);
        }
        
        return $next($request);
    }
}
