<?php

namespace App\Http\Controllers\Front;

use App\Models\CaseModel;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CaseController extends Controller
{
    public function index()
    {
        $categories = Category::tree('case', 1);
        $cases = CaseModel::with('translation')->where('is_show', 1)->orderBy('sort_order')->paginate(10);
        $banner = Banner::where('position', 'case')->where('is_show', 1)->with('translation')->first();
        
        // 获取Cases栏目SEO信息
        $category = Category::where('url', '/cases')->with('translations')->first();

        return view('front.cases.index', compact('categories', 'cases', 'banner', 'category'));
    }

    public function show($slug)
    {
        $case = CaseModel::whereHas('translation', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('translations', 'category.translation')->firstOrFail();
        $banner = Banner::where('position', 'case')->where('is_show', 1)->with('translation')->first();

        $case->increment('view_count');

        return view('front.cases.show', compact('case', 'banner'));
    }
}
