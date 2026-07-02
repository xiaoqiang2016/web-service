<?php

namespace App\Http\Controllers\Front;

use App\Models\Download;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        $categories = Category::tree('download', 1);
        $downloads = Download::with('translation')->where('is_show', 1)->orderBy('sort_order')->get();
        $banner = Banner::where('position', 'download')->where('is_show', 1)->with('translation')->first();
        
        // 获取Downloads栏目SEO信息
        $category = Category::where('url', '/downloads')->with('translations')->first();

        return view('front.downloads.index', compact('categories', 'downloads', 'banner', 'category'));
    }

    public function download($id)
    {
        $download = Download::findOrFail($id);
        
        if (!$download->is_show) {
            abort(404);
        }

        $download->increment('download_count');

        return Storage::download($download->file_path);
    }
}
