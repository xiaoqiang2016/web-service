<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\BannerTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with('translation')->orderBy('sort_order')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $languages = Language::getActive();
        return view('admin.banners.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link_url' => 'nullable|url',
            'link_target' => 'required|in:_self,_blank',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'position' => 'required',
        ]);

        $banner = Banner::create([
            'image' => null,
            'link_url' => $request->link_url,
            'link_target' => $request->link_target,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
            'position' => $request->position,
        ]);

        foreach ($request->translations as $locale => $data) {
            $imagePath = null;
            if (isset($data['image']) && $data['image']) {
                $imagePath = $data['image']->store('banners', 'public');
            }

            BannerTranslation::create([
                'banner_id' => $banner->id,
                'locale' => $locale,
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'image' => $imagePath,
            ]);
        }

        Cache::forget('banners');

        return redirect()->route('admin.banners.index')->with('success', 'Banner created');
    }

    public function edit(Banner $banner)
    {
        $languages = Language::getActive();
        return view('admin.banners.edit', compact('banner', 'languages'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'link_url' => 'nullable|url',
            'link_target' => 'required|in:_self,_blank',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'position' => 'required',
        ]);

        $banner->update([
            'link_url' => $request->link_url,
            'link_target' => $request->link_target,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
            'position' => $request->position,
        ]);

        foreach ($request->translations as $locale => $data) {
            $translation = $banner->translations()->where('locale', $locale)->first();

            $imagePath = $translation?->image;
            if (isset($data['image']) && $data['image']) {
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $data['image']->store('banners', 'public');
            }

            if ($translation) {
                $translation->update([
                    'title' => $data['title'] ?? null,
                    'description' => $data['description'] ?? null,
                    'image' => $imagePath,
                ]);
            } else {
                BannerTranslation::create([
                    'banner_id' => $banner->id,
                    'locale' => $locale,
                    'title' => $data['title'] ?? null,
                    'description' => $data['description'] ?? null,
                    'image' => $imagePath,
                ]);
            }
        }

        Cache::forget('banners');

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        Cache::forget('banners');
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted');
    }
}
