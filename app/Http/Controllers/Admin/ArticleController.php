<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleTranslation;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('translation', 'category.translation')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $languages = Language::getActive();
        $categories = Category::tree('news', 1);
        return view('admin.articles.create', compact('languages', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'author' => 'nullable|string',
            'source' => 'nullable|string',
            'status' => 'required|integer',
            'is_top' => 'boolean',
            'is_recommend' => 'boolean',
            'published_at' => 'nullable|date',
            'translations.*.title' => 'required',
            'translations.*.content' => 'nullable',
        ]);

        $article = Article::create([
            'category_id' => $request->category_id,
            'author' => $request->author,
            'source' => $request->source,
            'status' => $request->status,
            'is_top' => $request->is_top ?? 0,
            'is_recommend' => $request->is_recommend ?? 0,
            'published_at' => $request->published_at ?? now(),
        ]);

        foreach ($request->translations as $locale => $data) {
            $coverImage = null;
            if (isset($data['cover_image']) && $data['cover_image']) {
                $coverImage = $data['cover_image']->store('articles', 'public');
            }

            ArticleTranslation::create([
                'article_id' => $article->id,
                'locale' => $locale,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'summary' => $data['summary'] ?? null,
                'content' => $data['content'] ?? null,
                'cover_image' => $coverImage,
                'seo_title' => $data['seo_title'] ?? null,
                'seo_keywords' => $data['seo_keywords'] ?? null,
                'seo_description' => $data['seo_description'] ?? null,
            ]);
        }

        Cache::forget('articles');

        return redirect()->route('admin.articles.index')->with('success', 'Article created');
    }

    public function edit(Article $article)
    {
        $languages = Language::getActive();
        $categories = Category::tree('news', 1);
        return view('admin.articles.edit', compact('article', 'languages', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'author' => 'nullable|string',
            'source' => 'nullable|string',
            'status' => 'required|integer',
            'is_top' => 'boolean',
            'is_recommend' => 'boolean',
            'published_at' => 'nullable|date',
            'translations.*.title' => 'required',
            'translations.*.content' => 'nullable',
        ]);

        $article->update([
            'category_id' => $request->category_id,
            'author' => $request->author,
            'source' => $request->source,
            'status' => $request->status,
            'is_top' => $request->is_top ?? 0,
            'is_recommend' => $request->is_recommend ?? 0,
            'published_at' => $request->published_at ?? now(),
        ]);

        foreach ($request->translations as $locale => $data) {
            $translation = $article->translations()->where('locale', $locale)->first();
            $coverImage = $translation?->cover_image;

            if (isset($data['cover_image']) && $data['cover_image']) {
                if ($coverImage) {
                    Storage::disk('public')->delete($coverImage);
                }
                $coverImage = $data['cover_image']->store('articles', 'public');
            }

            if ($translation) {
                $translation->update([
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'summary' => $data['summary'] ?? null,
                    'content' => $data['content'] ?? null,
                    'cover_image' => $coverImage,
                    'seo_title' => $data['seo_title'] ?? null,
                    'seo_keywords' => $data['seo_keywords'] ?? null,
                    'seo_description' => $data['seo_description'] ?? null,
                ]);
            } else {
                ArticleTranslation::create([
                    'article_id' => $article->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'cover_image' => $coverImage,
                ]);
            }
        }

        Cache::forget('articles');

        return redirect()->route('admin.articles.index')->with('success', 'Article updated');
    }

    public function destroy(Article $article)
    {
        foreach ($article->translations as $translation) {
            if ($translation->cover_image) {
                Storage::disk('public')->delete($translation->cover_image);
            }
        }
        $article->delete();
        Cache::forget('articles');
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted');
    }
}
