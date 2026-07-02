<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        $banner = Banner::where('position', 'faq')->where('is_show', 1)->with('translation')->first();
        $faqs = Faq::with('translation')->where('is_show', 1)->orderBy('sort_order')->paginate(5);
        
        // 获取FAQ栏目SEO信息
        $category = Category::where('url', '/faq')->with('translations')->first();
        
        return view('front.faq', compact('banner', 'faqs', 'category'));
    }
}
