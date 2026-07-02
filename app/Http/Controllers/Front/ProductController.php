<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::productTree(1);
        $categorySlug = $request->segment(3);
        $subCategorySlug = $request->segment(4);

        $query = Product::with('translation');
        // 获取产品栏目分类的SEO信息（用于页面SEO）
        $category = Category::where('type', 'product')->with('translations')->first();
        
        if ($categorySlug) {
            $categorySlugCategory = Category::whereHas('translations', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })->with('translations')->first();
            if ($categorySlugCategory) {
                $category = $categorySlugCategory;
            }
            if ($category) {
                if ($subCategorySlug) {
                    $subCategory = Category::whereHas('translations', function ($q) use ($subCategorySlug) {
                        $q->where('slug', $subCategorySlug);
                    })->where('parent_id', $category->id)->first();
                    if ($subCategory) {
                        $query->where('category_id', $subCategory->id);
                    } else {
                        // Subcategory slug not found under this category, show all products in category and its children
                        $query->where(function ($q) use ($category) {
                            $q->where('category_id', $category->id)
                              ->orWhereHas('category', function ($cq) use ($category) {
                                  $cq->where('parent_id', $category->id);
                              });
                        });
                    }
                } else {
                    // Only category slug, show products in this category and its children
                    $query->where(function ($q) use ($category) {
                        $q->where('category_id', $category->id)
                          ->orWhereHas('category', function ($cq) use ($category) {
                              $cq->where('parent_id', $category->id);
                          });
                    });
                }
            }
        }

        $products = $query->where('is_show', 1)->orderBy('sort_order')->paginate(9);

        $banner = Banner::where('position', 'products')->where('is_show', 1)->with('translation')->first();

        return view('front.products.index', compact('categories', 'products', 'banner', 'category'));
    }

    public function show($locale, $id)
    {
        $product = Product::with('translation', 'category.translation')->findOrFail($id);

        $product->increment('view_count');

        $categories = Category::productTree(1);
        $banner = Banner::where('position', 'products')->where('is_show', 1)->with('translation')->first();
        
        // Get the accordion category ID for expansion
        // Walk up the category tree to find the 1st-level product category
        // (whose parent is the Products page with type=page)
        $currentCategoryId = $product->category_id;
        $currentCategory = $product->category;
        while ($currentCategory && $currentCategory->parent_id) {
            $parentCategory = Category::find($currentCategory->parent_id);
            if (!$parentCategory || $parentCategory->type === 'page') {
                // Current category is a 1st-level product category
                $currentCategoryId = $currentCategory->id;
                break;
            }
            // Parent is also a product category, move up
            $currentCategoryId = $parentCategory->id;
            $currentCategory = $parentCategory;
        }

        return view('front.products.show', compact('product', 'categories', 'banner', 'currentCategoryId'));
    }
}
