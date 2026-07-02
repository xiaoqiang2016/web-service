<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $tab = $request->get('tab', 'all');

        $products = collect();
        $articles = collect();
        $productsTotal = 0;
        $articlesTotal = 0;

        if ($keyword) {
            // Search products
            $productsQuery = Product::where('is_show', 1)
                ->whereHas('translation', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%")
                      ->orWhere('summary', 'like', "%{$keyword}%");
                });

            // Search articles
            $articlesQuery = Article::where('status', 1)
                ->whereHas('translation', function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                      ->orWhere('content', 'like', "%{$keyword}%")
                      ->orWhere('summary', 'like', "%{$keyword}%");
                });

            // Always get totals for tabs
            $productsTotal = $productsQuery->count();
            $articlesTotal = $articlesQuery->count();

            // Paginate only the active tab or both for 'all'
            if ($tab === 'products' || $tab === 'all') {
                $products = $productsQuery->with('translation')->paginate(10);
            }

            if ($tab === 'articles' || $tab === 'all') {
                $articles = $articlesQuery->with('translation')->paginate(10);
            }
        }

        $banner = Banner::where('position', 'search')->where('is_show', 1)->with('translation')->first();
        if (!$banner) {
            $banner = Banner::where('is_show', 1)->with('translation')->first();
        }

        // 获取Search页面SEO信息
        $category = Category::where('url', '/search')->with('translations')->first();

        return view('front.search.index', compact('keyword', 'tab', 'products', 'articles', 'banner', 'productsTotal', 'articlesTotal', 'category'));
    }
}
