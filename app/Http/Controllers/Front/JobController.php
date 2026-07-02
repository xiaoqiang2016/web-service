<?php

namespace App\Http\Controllers\Front;

use App\Models\Job;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('translation')->where('is_show', 1)->orderBy('sort_order')->get();
        $banner = Banner::where('position', 'job')->where('is_show', 1)->with('translation')->first();
        
        // 获取Jobs栏目SEO信息
        $category = Category::where('url', '/jobs')->with('translations')->first();

        return view('front.jobs.index', compact('jobs', 'banner', 'category'));
    }

    public function show($slug)
    {
        $job = Job::whereHas('translation', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->with('translations')->firstOrFail();
        $banner = Banner::where('position', 'job')->where('is_show', 1)->with('translation')->first();

        return view('front.jobs.show', compact('job', 'banner'));
    }
}
