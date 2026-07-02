<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Language;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');
        
        if ($locale && Language::where('locale', $locale)->where('is_active', 1)->exists()) {
            app()->setLocale($locale);
        } else {
            $defaultLocale = Language::getDefault()?->locale ?? 'en';
            app()->setLocale($defaultLocale);
            
            if ($locale) {
                return redirect()->route('front.index', ['locale' => $defaultLocale]);
            }
        }
        
        return $next($request);
    }
}
