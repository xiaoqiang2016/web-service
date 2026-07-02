<?php

namespace App\Http\Controllers\Admin;

use App\Models\CaseModel;
use App\Models\CaseTranslation;
use App\Models\Language;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CaseController extends Controller
{
    public function index()
    {
        $cases = CaseModel::with('translation', 'category.translation')->orderBy('sort_order')->get();
        return view('admin.cases.index', compact('cases'));
    }

    public function create()
    {
        $languages = Language::getActive();
        $categories = Category::tree('case', 1);
        return view('admin.cases.create', compact('languages', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'client_name' => 'nullable|string',
            'industry' => 'nullable|string',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'translations.*.title' => 'required',
            'translations.*.content' => 'nullable',
        ]);

        $case = CaseModel::create([
            'category_id' => $request->category_id,
            'client_name' => $request->client_name,
            'industry' => $request->industry,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
        ]);

        foreach ($request->translations as $locale => $data) {
            $coverImage = null;
            if (isset($data['cover_image']) && $data['cover_image']) {
                $coverImage = $data['cover_image']->store('cases', 'public');
            }

            $images = [];
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    $images[] = $image->store('cases/gallery', 'public');
                }
            }

            CaseTranslation::create([
                'case_id' => $case->id,
                'locale' => $locale,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'summary' => $data['summary'] ?? null,
                'content' => $data['content'] ?? null,
                'cover_image' => $coverImage,
                'images' => $images,
            ]);
        }

        Cache::forget('cases');

        return redirect()->route('admin.cases.index')->with('success', 'Case created');
    }

    public function edit(CaseModel $case)
    {
        $languages = Language::getActive();
        $categories = Category::tree('case', 1);
        return view('admin.cases.edit', compact('case', 'languages', 'categories'));
    }

    public function update(Request $request, CaseModel $case)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'client_name' => 'nullable|string',
            'industry' => 'nullable|string',
            'sort_order' => 'integer',
            'is_show' => 'boolean',
            'translations.*.title' => 'required',
            'translations.*.content' => 'nullable',
        ]);

        $case->update([
            'category_id' => $request->category_id,
            'client_name' => $request->client_name,
            'industry' => $request->industry,
            'sort_order' => $request->sort_order ?? 0,
            'is_show' => $request->is_show ?? 1,
        ]);

        foreach ($request->translations as $locale => $data) {
            $translation = $case->translations()->where('locale', $locale)->first();
            $coverImage = $translation?->cover_image;

            if (isset($data['cover_image']) && $data['cover_image']) {
                if ($coverImage) {
                    Storage::disk('public')->delete($coverImage);
                }
                $coverImage = $data['cover_image']->store('cases', 'public');
            }

            $images = $translation?->images ?? [];
            if (isset($data['images']) && is_array($data['images'])) {
                foreach ($data['images'] as $image) {
                    $images[] = $image->store('cases/gallery', 'public');
                }
            }

            if ($translation) {
                $translation->update([
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'summary' => $data['summary'] ?? null,
                    'content' => $data['content'] ?? null,
                    'cover_image' => $coverImage,
                    'images' => $images,
                ]);
            } else {
                CaseTranslation::create([
                    'case_id' => $case->id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'cover_image' => $coverImage,
                ]);
            }
        }

        Cache::forget('cases');

        return redirect()->route('admin.cases.index')->with('success', 'Case updated');
    }

    public function destroy(CaseModel $case)
    {
        foreach ($case->translations as $translation) {
            if ($translation->cover_image) {
                Storage::disk('public')->delete($translation->cover_image);
            }
            foreach ($translation->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $case->delete();
        Cache::forget('cases');
        return redirect()->route('admin.cases.index')->with('success', 'Case deleted');
    }
}
