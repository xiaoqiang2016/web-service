<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\ContactSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        View::composer('front.*', function ($view) {
            $menuCategories = Category::with(['translation', 'children.translation'])
                ->where('parent_id', 0)
                ->where('is_show', 1)
                ->orderBy('sort_order')
                ->get();

            $contactSettings = ContactSetting::getSettings();

            $view->with('menuCategories', $menuCategories);
            $view->with('contactSettings', $contactSettings);
        });
    }
}
