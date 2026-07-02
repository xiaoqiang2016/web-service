<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Session::get('admin_user');
        
        if (!$user) {
            return redirect()->route('admin.login');
        }
        
        // Admin/super_admin role has all permissions
        if ($user->role && in_array($user->role->role_name, ['admin', 'super_admin'])) {
            return $next($request);
        }
        
        // Check if user has wildcard permission
        if ($user->role && in_array('*', $user->role->permissions ?? [])) {
            return $next($request);
        }
        
        // Check if user has permission for current route
        $routeName = $request->route()->getName();
        $permission = $this->getPermissionFromRoute($routeName);
        
        if ($permission && $user->role && !in_array($permission, $user->role->permissions ?? [])) {
            abort(403, 'You do not have permission to access this page.');
        }
        
        return $next($request);
    }
    
    private function getPermissionFromRoute($routeName)
    {
        $permissionMap = [
            'admin.products' => 'products',
            'admin.articles' => 'articles',
            'admin.categories' => 'categories',
            'admin.banners' => 'banners',
            'admin.messages' => 'messages',
            'admin.faqs' => 'faqs',
            'admin.contact-settings' => 'contact-settings',
            'admin.admin-users' => 'admin-users',
            'admin.admin-roles' => 'admin-roles',
            'admin.about-contents' => 'about',
            'admin.honor-images' => 'honor-images',
            'admin.factory-images' => 'factory-images',
        ];
        
        foreach ($permissionMap as $prefix => $permission) {
            if (str_starts_with($routeName, $prefix)) {
                return $permission;
            }
        }
        
        return null;
    }
}
