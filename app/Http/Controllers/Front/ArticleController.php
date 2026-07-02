<?php

namespace App\Http\Controllers\Front;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $categories = Category::tree('news', 1);
        $articles = Article::with('translation')->where('status', 1)->orderBy('published_at', 'desc')->paginate(10);

        // 获取新闻栏目分类的SEO信息
        $category = Category::where('type', 'news')->with('translations')->first();

        // 获取新闻栏目Banner
        $banner = Banner::where('position', 'news')->where('is_show', 1)->with('translation')->first();

        return view('front.news.index', compact('categories', 'articles', 'banner', 'category'));
    }

    public function show($locale, $slug)
    {
        $article = Article::whereHas('translations', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('translation', 'translations', 'category.translation')->firstOrFail();

        $article->increment('view_count');

        // 获取新闻栏目Banner
        $banner = Banner::where('position', 'news')->where('is_show', 1)->with('translation')->first();

        // 获取上一篇文章（published_at小于当前文章的最新文章）
        $prevArticle = Article::where('status', 1)
            ->where('published_at', '<', $article->published_at)
            ->whereHas('translations', function ($query) use ($locale) {
                $query->where('locale', $locale);
            })
            ->with(['translation' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->orderBy('published_at', 'desc')
            ->first();

        // 获取下一篇文章（published_at大于当前文章的最旧文章）
        $nextArticle = Article::where('status', 1)
            ->where('published_at', '>', $article->published_at)
            ->whereHas('translations', function ($query) use ($locale) {
                $query->where('locale', $locale);
            })
            ->with(['translation' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->orderBy('published_at', 'asc')
            ->first();

        return view('front.news.show', compact('article', 'prevArticle', 'nextArticle', 'banner'));
    }
}
