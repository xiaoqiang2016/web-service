<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['translation', 'children.translation'])->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $languages = Language::getActive();
        $parents = Category::where('parent_id', 0)->with('translation')->get();
        return view('admin.categories.create', compact('languages', 'parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable|integer',
            'type' => 'required|in:product,news,case,page,job,download',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'url' => 'nullable|string',
            'translations.*.name' => 'required',
        ]);

        $category = Category::create([
            'parent_id' => $request->parent_id ?? 0,
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
            'url' => $request->url ?? null,
        ]);

        foreach ($request->translations as $locale => $data) {
            CategoryTranslation::create([
                'category_id' => $category->id,
                'locale' => $locale,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'seo_title' => $data['seo_title'] ?? null,
                'seo_keywords' => $data['seo_keywords'] ?? null,
                'seo_description' => $data['seo_description'] ?? null,
            ]);
        }

        Cache::forget('categories');

        return redirect()->route('admin.categories.index')->with('success', 'Category created');
    }

    public function edit(Category $category)
    {
        $languages = Language::getActive();
        $parents = Category::where('parent_id', 0)->where('id', '!=', $category->id)->with('translation')->get();
        return view('admin.categories.edit', compact('category', 'languages', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'parent_id' => 'nullable|integer',
            'type' => 'required|in:product,news,case,page,job,download',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'url' => 'nullable|string',
            'translations.*.name' => 'required',
        ]);

        $category->update([
            'parent_id' => $request->parent_id ?? 0,
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
            'url' => $request->url ?? null,
        ]);

        foreach ($request->translations as $locale => $data) {
            $translation = $category->translations()->where('locale', $locale)->first();
            if ($translation) {
                $translation->update([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'seo_title' => $data['seo_title'] ?? null,
                    'seo_keywords' => $data['seo_keywords'] ?? null,
                    'seo_description' => $data['seo_description'] ?? null,
                ]);
            } else {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'locale' => $locale,
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                ]);
            }
        }

        Cache::forget('categories');

        return redirect()->route('admin.categories.index')->with('success', 'Category updated');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        Cache::forget('categories');
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted');
    }
}
